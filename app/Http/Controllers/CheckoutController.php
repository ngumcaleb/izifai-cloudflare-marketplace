<?php

namespace App\Http\Controllers;

use App\Helpers\AuditLogger;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingAddress;
use App\Models\Transaction;
use App\Services\FapshiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function preview()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.item.store')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            if ($item->item->store->user_id === auth()->id()) {
                return redirect()->route('cart.index')->with('error', 'You cannot buy your own listing. Please remove it from your cart.');
            }
        }

        $addresses = \App\Models\ShippingAddress::where('user_id', auth()->id())->latest()->get();

        return view('checkout.preview', compact('cart', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.item.store')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        foreach ($cart->items as $item) {
            if ($item->item->store->user_id === auth()->id()) {
                return redirect()->route('cart.index')->with('error', 'You cannot buy your own listing. Please remove it from your cart.');
            }
        }

        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{9}$/',
            'notes' => 'nullable|string|max:500',
            'shipping_address_id' => 'required',
            'shipping_label' => 'nullable|string|max:100',
            'shipping_city' => 'required_if:shipping_address_id,new|string|max:255',
            'shipping_address' => 'required_if:shipping_address_id,new|string|max:255',
            'shipping_phone' => 'required_if:shipping_address_id,new|string|regex:/^[0-9]{9}$/',
            'save_address' => 'nullable|boolean',
        ]);

        if ($validated['shipping_address_id'] === 'new') {
            $shippingAddress = ShippingAddress::create([
                'user_id' => auth()->id(),
                'label' => $validated['shipping_label'] ?? 'Home',
                'address' => $validated['shipping_address'],
                'city' => $validated['shipping_city'],
                'phone' => '237' . $validated['shipping_phone'],
                'is_default' => !ShippingAddress::where('user_id', auth()->id())->exists(),
            ]);
            $shippingAddressId = $shippingAddress->id;
        } else {
            $shippingAddress = ShippingAddress::where('id', $validated['shipping_address_id'])
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $shippingAddressId = $shippingAddress->id;
        }

        $phone = '237' . $validated['phone'];

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'IZF-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'subtotal' => $cart->total,
            'shipping_fee' => 0,
            'total_amount' => $cart->total,
            'shipping_address_id' => $shippingAddressId,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($cart->items as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_type' => $cartItem->item_type,
                'item_id' => $cartItem->item_id,
                'store_id' => $cartItem->item->store_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'name' => $cartItem->item->name,
            ]);

            if ($cartItem->item_type === 'App\Models\Product') {
                $cartItem->item->decrement('inventory', $cartItem->quantity);
            }
        }

        $transaction = Transaction::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'type' => 'payment',
            'amount' => $order->total_amount,
            'currency' => 'XAF',
            'payment_method' => 'Fapshi',
            'phone' => $phone,
            'status' => 'pending',
        ]);

        $cart->items()->delete();

        if (($validated['save_address'] ?? false) && $validated['shipping_address_id'] === 'new') {
            $shippingAddress->update(['is_default' => false]);
            ShippingAddress::where('user_id', auth()->id())->update(['is_default' => false]);
            $shippingAddress->update(['is_default' => true]);
        }

        $fapshi = app(FapshiService::class);
        $result = $fapshi->initiateDirectPay(
            $order->total_amount,
            $phone,
            "Payment for Order #{$order->order_number}",
            ['order_id' => $order->id, 'user_id' => auth()->id()]
        );

        if (($result['success'] ?? false) || isset($result['transId'])) {
            $transId = $result['transId'] ?? null;
            $transaction->update(['reference' => $transId]);

            AuditLogger::log('order.placed', "Placed order #{$order->order_number}: {$order->total_amount} XAF via Fapshi", $order);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'A payment request has been sent to your phone. Please check your MoMo messages and approve the payment.');
        }

        AuditLogger::log('order.placed', "Placed order #{$order->order_number}: {$order->total_amount} XAF (payment initiation failed)", $order);

        return redirect()->route('orders.show', $order->id)
            ->with('error', 'Order created but payment request failed. Please try paying again from the order page.');
    }
}
