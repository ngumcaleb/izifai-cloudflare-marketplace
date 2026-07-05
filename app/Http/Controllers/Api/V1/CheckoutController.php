<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function preview(): JsonResponse
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.item.store')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 400);
        }

        // Group by store
        $storeGroups = $cart->items->groupBy(fn($item) => $item->item->store_id);
        $shippingFee = 0; // Will be calculated based on store/delivery

        $paymentMethods = PaymentMethod::where('is_active', true)->get()->map(fn($pm) => [
            'id' => $pm->id,
            'name' => $pm->name,
            'icon_url' => $pm->icon_url,
            'number' => $pm->number,
            'account_name' => $pm->account_name,
        ]);

        return response()->json([
            'summary' => [
                'items_count' => $cart->items_count,
                'subtotal' => $cart->total,
                'shipping_fee' => $shippingFee,
                'total' => $cart->total + $shippingFee,
            ],
            'stores' => $storeGroups->map(fn($items, $storeId) => [
                'store_id' => (int) $storeId,
                'store_name' => $items->first()->item->store->name,
                'items' => $items->map(fn($item) => [
                    'name' => $item->item->name,
                    'quantity' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) ($item->price * $item->quantity),
                ]),
            ])->values(),
            'payment_methods' => $paymentMethods,
            'addresses' => auth()->user()->shippingAddresses,
        ]);
    }

    public function placeOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shipping_address_id' => 'nullable|exists:shipping_addresses,id',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('items.item.store')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 400);
        }

        foreach ($cart->items as $item) {
            if ($item->item->store->user_id === auth()->id()) {
                return response()->json(['message' => 'You cannot buy your own listing. Remove it from your cart first.'], 422);
            }
        }

        $paymentMethod = PaymentMethod::findOrFail($validated['payment_method_id']);
        $subtotal = $cart->total;
        $shippingFee = 0;

        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'IZF-' . strtoupper(Str::random(10)),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total_amount' => $subtotal + $shippingFee,
            'shipping_address_id' => $validated['shipping_address_id'] ?? null,
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

            // Decrement inventory for products
            if ($cartItem->item_type === 'App\\Models\\Product') {
                $cartItem->item->decrement('inventory', $cartItem->quantity);
            }
        }

        // Create escrow transaction (pending payment confirmation)
        Transaction::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'type' => 'payment',
            'amount' => $order->total_amount,
            'currency' => 'XAF',
            'payment_method' => $paymentMethod->name,
            'status' => 'pending',
        ]);

        // Clear cart
        $cart->items()->delete();

        AuditLogger::log('order.placed', "API: Placed order #{$order->order_number}: {$order->total_amount} XAF", $order);

        return response()->json([
            'message' => 'Order placed successfully. Complete payment to confirm.',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'total_amount' => (float) $order->total_amount,
                'status' => $order->status,
                'payment_method' => $paymentMethod->name,
                'payment_number' => $paymentMethod->number,
                'account_name' => $paymentMethod->account_name,
            ],
        ], 201);
    }

    public function confirmPayment(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'sender_number' => 'required|string|max:20',
            'transaction_reference' => 'required|string|max:255',
            'proof_image' => 'nullable|image|max:5120',
        ]);

        $transaction = $order->transaction;
        $data = [
            'reference' => $validated['transaction_reference'],
        ];

        $transaction->update($data);
        $transaction->update(['status' => 'pending']);

        // Lock funds in escrow for each seller
        $order->load('items.store.user.wallet');
        foreach ($order->items as $item) {
            $sellerWallet = $item->store?->user?->wallet;
            if (!$sellerWallet) {
                continue;
            }
            $itemTotal = $item->price * $item->quantity;
            $sellerWallet->increment('locked_balance', $itemTotal);

            WalletTransaction::create([
                'wallet_id' => $sellerWallet->id,
                'type' => 'escrow_hold',
                'amount' => $itemTotal,
                'balance_before' => $sellerWallet->balance,
                'balance_after' => $sellerWallet->balance,
                'description' => "Funds locked in escrow for order #{$order->order_number}",
                'reference' => "ESC-{$order->id}-{$item->id}",
                'status' => 'completed',
                'order_id' => $order->id,
                'buyer_name' => auth()->user()->name ?? null,
            ]);
        }

        $order->update(['escrow_status' => 'held']);

        AuditLogger::log('order.payment_confirmed', "API: Payment confirmed for order #{$order->order_number}", $order, ['escrow_status' => 'pending'], ['escrow_status' => 'held']);

        return response()->json([
            'message' => 'Payment information submitted. Funds locked in escrow.',
        ]);
    }
}
