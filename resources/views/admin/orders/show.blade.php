<x-admin-layout>
    <x-slot name="header">Order #{{ $order->order_number }}</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Orders
        </a>

        <div class="admin-card p-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Order #</p>
                    <p class="text-sm font-bold text-navy-800">{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Date</p>
                    <p class="text-sm font-bold text-navy-800">{{ $order->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Total</p>
                    <p class="text-sm font-bold text-navy-800">XAF {{ number_format($order->total_amount) }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Status</p>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase inline-block mt-0.5
                        {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-blue-50 text-blue-600' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                        {{ in_array($order->status, ['pending', 'confirmed']) ? 'bg-amber-50 text-amber-600' : '' }}">
                        {{ $order->status }}
                    </span>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Customer</p>
                <p class="text-sm font-bold text-navy-800">{{ $order->user->name }}</p>
                <p class="text-xs text-slate-500">{{ $order->user->email }}</p>
            </div>

            @if($order->shippingAddress)
            <div class="border-t border-slate-100 pt-4 mt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-2">Shipping Address</p>
                <p class="text-sm text-slate-600">
                    {{ $order->shippingAddress->address_line1 }}<br>
                    @if($order->shippingAddress->address_line2){{ $order->shippingAddress->address_line2 }}<br>@endif
                    {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->region }}
                </p>
            </div>
            @endif
        </div>

        <div class="admin-card p-6">
            <h3 class="text-sm font-bold text-navy-800 mb-4">Items ({{ $order->items->count() }})</h3>
            <div class="space-y-3">
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-navy-800">{{ $item->name ?? $item->item?->name }}</p>
                            <p class="text-xs text-slate-500">Qty: {{ $item->quantity }} × XAF {{ number_format($item->price) }}</p>
                            @if($item->store)
                                <p class="text-[10px] text-slate-400">Sold by: {{ $item->store->name }}</p>
                            @endif
                        </div>
                        <p class="text-sm font-bold text-navy-800">XAF {{ number_format($item->price * $item->quantity) }}</p>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between">
                <span class="text-sm font-bold text-navy-800">Total</span>
                <span class="text-sm font-bold text-navy-800">XAF {{ number_format($order->total_amount) }}</span>
            </div>
        </div>

        <div class="admin-card p-6">
            <h3 class="text-sm font-bold text-navy-800 mb-4">Update Status</h3>
            <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-3">
                @csrf
                <select name="status" class="flex-1 px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold hover:bg-navy-900 transition-all">Update</button>
            </form>
        </div>

        @if($order->transaction)
        <div class="admin-card p-6">
            <h3 class="text-sm font-bold text-navy-800 mb-4">Payment</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Reference</p>
                    <p class="text-sm font-bold text-navy-800">{{ $order->transaction->reference ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Status</p>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase inline-block mt-0.5 {{ $order->transaction->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }}">
                        {{ $order->transaction->status }}
                    </span>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-admin-layout>
