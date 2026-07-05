<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AuditLogger;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.store']);

        if ($request->search) {
            $query->where('order_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->store_id) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('store_id', $request->store_id);
            });
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->min_amount) {
            $query->where('total_amount', '>=', $request->min_amount);
        }

        if ($request->max_amount) {
            $query->where('total_amount', '<=', $request->max_amount);
        }

        $perPage = $request->input('per_page', 20);
        $orders = $query->latest()->paginate($perPage);

        $stores = Store::orderBy('name')->get();

        return view('admin.orders.index', compact('orders', 'stores'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.store', 'transaction', 'shippingAddress']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        AuditLogger::log('order.status_updated', "Order #{$order->order_number}: status {$oldStatus} → {$request->status}", $order, ['status' => $oldStatus], ['status' => $request->status]);

        return back()->with('success', "Order status updated to {$request->status}.");
    }
}
