<?php

namespace App\Http\Controllers;

use App\Helpers\AuditLogger;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\PaymentMethod;
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

        return view('checkout.preview', compact('cart'));
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
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'IZF-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'subtotal' => $cart->total,
            'shipping_fee' => 0,
            'total_amount' => $cart->total,
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

        Transaction::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'type' => 'payment',
            'amount' => $order->total_amount,
            'currency' => 'XAF',
            'payment_method' => $paymentMethod->name,
            'status' => 'pending',
        ]);

        $cart->items()->delete();

        AuditLogger::log('order.placed', "Placed order #{$order->order_number}: {$order->total_amount} XAF", $order);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order placed! Complete payment using the details below.');
    }
}
