<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['items', 'transaction'])
            ->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return response()->json([
            'orders' => collect($orders->items())->map(fn($o) => [
                'id' => $o->id,
                'order_number' => $o->order_number,
                'status' => $o->status,
                'total_amount' => (float) $o->total_amount,
                'items_count' => $o->items->sum('quantity'),
                'payment_status' => $o->transaction?->status,
                'created_at' => $o->created_at,
            ]),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    public function show(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $order->load(['items.item', 'transaction', 'shippingAddress']);

        return response()->json([
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'subtotal' => (float) $order->subtotal,
                'shipping_fee' => (float) $order->shipping_fee,
                'total_amount' => (float) $order->total_amount,
                'notes' => $order->notes,
                'confirmed_at' => $order->confirmed_at,
                'shipped_at' => $order->shipped_at,
                'delivered_at' => $order->delivered_at,
                'cancelled_at' => $order->cancelled_at,
                'created_at' => $order->created_at,
                'items' => $order->items->map(fn($item) => [
                    'id' => $item->id,
                    'item_type' => class_basename($item->item_type),
                    'name' => $item->item->name,
                    'quantity' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) ($item->price * $item->quantity),
                    'store_name' => $item->store->name,
                ]),
                'payment' => $order->transaction ? [
                    'method' => $order->transaction->payment_method,
                    'amount' => (float) $order->transaction->amount,
                    'reference' => $order->transaction->reference,
                    'status' => $order->transaction->status,
                ] : null,
                'shipping_address' => $order->shippingAddress,
            ],
        ]);
    }

    public function cancel(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json(['message' => 'Order cannot be cancelled.'], 400);
        }

        $oldStatus = $order->status;
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        AuditLogger::log('order.cancelled', "API: Cancelled order #{$order->order_number}", $order, ['status' => $oldStatus], ['status' => 'cancelled']);

        // Restore inventory
        $order->load('items.store.user.wallet');
        foreach ($order->items as $item) {
            if ($item->item_type === 'App\\Models\\Product') {
                $item->item->increment('inventory', $item->quantity);
            }
            // Release locked escrow funds back
            $sellerWallet = $item->store?->user?->wallet;
            if ($sellerWallet && $sellerWallet->locked_balance > 0) {
                $itemTotal = $item->price * $item->quantity;
                $releasedAmount = min($itemTotal, $sellerWallet->locked_balance);
                $sellerWallet->decrement('locked_balance', $releasedAmount);

                WalletTransaction::create([
                    'wallet_id' => $sellerWallet->id,
                    'type' => 'escrow_refund',
                    'amount' => $releasedAmount,
                    'balance_before' => $sellerWallet->balance,
                    'balance_after' => $sellerWallet->balance,
                    'description' => "Escrow refunded for cancelled order #{$order->order_number}",
                    'reference' => "REF-{$order->id}-{$item->id}",
                    'status' => 'completed',
                    'order_id' => $order->id,
                    'buyer_name' => $order->user->name ?? null,
                ]);
            }
        }

        $order->update(['escrow_status' => 'refunded']);

        return response()->json([
            'message' => 'Order cancelled.',
        ]);
    }

    public function confirmReceived(Order $order): JsonResponse
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($order->status !== 'shipped') {
            return response()->json(['message' => 'Order cannot be confirmed as received.'], 400);
        }

        $oldStatus = $order->status;
        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        AuditLogger::log('order.confirmed_received', "API: Confirmed received for order #{$order->order_number}", $order, ['status' => $oldStatus], ['status' => 'delivered']);

        // Release escrow to seller(s)
        $order->load('items.store.user.wallet');
        $commissionRate = (float) Setting::get('commission_rate', 10);

        foreach ($order->items as $item) {
            $sellerWallet = $item->store?->user?->wallet;
            if (!$sellerWallet) {
                continue;
            }
            $itemTotal = $item->price * $item->quantity;
            $commission = $itemTotal * ($commissionRate / 100);
            $sellerPayout = $itemTotal - $commission;

            // Deduct from locked_balance
            $sellerWallet->decrement('locked_balance', $itemTotal);
            // Add net to available balance
            $sellerWallet->increment('balance', $sellerPayout);
            // Track lifetime earnings
            $sellerWallet->increment('total_earned', $sellerPayout);

            WalletTransaction::create([
                'wallet_id' => $sellerWallet->id,
                'type' => 'escrow_release',
                'amount' => $sellerPayout,
                'balance_before' => $sellerWallet->balance - $sellerPayout,
                'balance_after' => $sellerWallet->balance,
                'description' => "Order #{$order->order_number} confirmed — payout after commission",
                'reference' => "ESC-{$order->id}-{$item->id}",
                'status' => 'completed',
                'order_id' => $order->id,
                'buyer_name' => $order->user->name ?? null,
            ]);

            WalletTransaction::create([
                'wallet_id' => $sellerWallet->id,
                'type' => 'commission',
                'amount' => -$commission,
                'balance_before' => $sellerWallet->balance,
                'balance_after' => $sellerWallet->balance,
                'description' => "Platform commission ({$commissionRate}%) on order #{$order->order_number}",
                'reference' => "COM-{$order->id}-{$item->id}",
                'status' => 'completed',
                'order_id' => $order->id,
                'buyer_name' => $order->user->name ?? null,
            ]);
        }

        if ($order->transaction) {
            $order->transaction->update([
                'status' => 'completed',
                'escrow_released_at' => now(),
            ]);
        }

        $order->update(['escrow_status' => 'released']);

        return response()->json([
            'message' => 'Delivery confirmed. Payment released to seller.',
        ]);
    }
}
