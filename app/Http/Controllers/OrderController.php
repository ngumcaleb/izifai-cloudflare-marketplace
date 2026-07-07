<?php

namespace App\Http\Controllers;

use App\Helpers\AuditLogger;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Transaction;
use App\Services\FapshiService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.item'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.item', 'items.store', 'transaction', 'shippingAddress'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function pay(Request $request, $id)
    {
        $order = Order::with('transaction')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'This order cannot be paid.');
        }

        $validated = $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{9}$/',
        ]);

        $phone = '237' . $validated['phone'];
        $transaction = $order->transaction;

        $fapshi = app(FapshiService::class);
        $result = $fapshi->initiateDirectPay(
            $order->total_amount,
            $phone,
            "Payment for Order #{$order->order_number}",
            ['order_id' => $order->id, 'user_id' => auth()->id()]
        );

        if (($result['success'] ?? false) || isset($result['transId'])) {
            $transId = $result['transId'] ?? null;
            if ($transaction) {
                $transaction->update(['reference' => $transId, 'phone' => $phone]);
            }

            return back()->with('success', 'A payment request has been sent to your phone. Please approve it on your MoMo app.');
        }

        return back()->with('error', 'Payment request failed. Please check the phone number and try again.');
    }

    public function confirmReceived($id)
    {
        $order = Order::with('items.store.user.wallet')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($order->status !== 'shipped' && $order->status !== 'delivered') {
            return back()->with('error', 'Order cannot be confirmed as received.');
        }

        $oldStatus = $order->status;
        $order->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        AuditLogger::log('order.confirmed_received', "Confirmed received for order #{$order->order_number}", $order, ['status' => $oldStatus], ['status' => 'delivered']);

        $commissionRate = (float) Setting::get('commission_rate', 10);

        foreach ($order->items as $item) {
            $sellerWallet = $item->store?->user?->wallet;
            if (!$sellerWallet) continue;

            $itemTotal = $item->price * $item->quantity;
            $commission = $itemTotal * ($commissionRate / 100);
            $sellerPayout = $itemTotal - $commission;

            $sellerWallet->decrement('locked_balance', $itemTotal);
            $sellerWallet->increment('balance', $sellerPayout);
            $sellerWallet->increment('total_earned', $sellerPayout);

            WalletTransaction::create([
                'wallet_id' => $sellerWallet->id,
                'type' => 'escrow_release',
                'amount' => $sellerPayout,
                'balance_before' => $sellerWallet->balance - $sellerPayout,
                'balance_after' => $sellerWallet->balance,
                'description' => "Order #{$order->order_number} confirmed received — payout after commission",
                'reference' => "ESC-{$order->id}-{$item->id}",
                'status' => 'completed',
                'order_id' => $order->id,
                'buyer_name' => auth()->user()->name,
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
                'buyer_name' => auth()->user()->name,
            ]);
        }

        $order->update(['escrow_status' => 'released']);

        if ($order->transaction) {
            $order->transaction->update([
                'status' => 'completed',
                'escrow_released_at' => now(),
            ]);
        }

        return back()->with('success', 'Delivery confirmed. Payment has been released to the seller.');
    }

    public function cancel($id)
    {
        $order = Order::with('items.store.user.wallet')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Order cannot be cancelled.');
        }

        $oldStatus = $order->status;
        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        AuditLogger::log('order.cancelled', "Cancelled order #{$order->order_number}", $order, ['status' => $oldStatus], ['status' => 'cancelled']);

        foreach ($order->items as $item) {
            if ($item->item_type === 'App\\Models\\Product') {
                $item->item?->increment('inventory', $item->quantity);
            }

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
                    'buyer_name' => auth()->user()->name ?? null,
                ]);
            }
        }

        $order->update(['escrow_status' => 'refunded']);

        if ($order->transaction) {
            $order->transaction->update(['status' => 'cancelled']);
        }

        return back()->with('success', 'Order cancelled.');
    }
}
