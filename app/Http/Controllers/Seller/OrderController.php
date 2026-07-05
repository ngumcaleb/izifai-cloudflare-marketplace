<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('seller.store.create')
                ->with('error', 'Create a store first.');
        }

        $orderIds = OrderItem::where('store_id', $store->id)
            ->pluck('order_id')
            ->unique();

        $orders = Order::with(['user', 'items' => function ($q) use ($store) {
            $q->where('store_id', $store->id);
        }, 'items.item'])->whereIn('id', $orderIds)
            ->latest()
            ->paginate(20);

        return view('seller.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $store = auth()->user()->store;

        $order = Order::with(['user', 'items' => function ($q) use ($store) {
            $q->where('store_id', $store->id);
        }, 'items.item', 'shippingAddress'])
            ->whereHas('items', fn($q) => $q->where('store_id', $store->id))
            ->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    public function markShipped($id)
    {
        $store = auth()->user()->store;

        $order = Order::whereHas('items', fn($q) => $q->where('store_id', $store->id))
            ->findOrFail($id);

        if ($order->status !== 'confirmed' && $order->status !== 'pending') {
            return back()->with('error', 'Order cannot be marked as shipped.');
        }

        $order->update([
            'status' => 'shipped',
            'shipped_at' => now(),
        ]);

        return back()->with('success', 'Order marked as shipped.');
    }


}
