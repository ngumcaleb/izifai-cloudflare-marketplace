<x-seller-layout>
    <x-slot name="title">Incoming Orders</x-slot>

    <div class="animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Incoming Orders</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">Manage incoming orders — track, ship, and fulfill customer purchases from your store.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-slide-down">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-slide-down">
                <span class="material-symbols-outlined text-red-600">error</span>
                <p class="text-sm font-semibold text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-slide-down">
                <span class="material-symbols-outlined text-red-600">warning</span>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="text-sm font-semibold text-red-800">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="space-y-2 md:grid md:grid-cols-2 md:gap-3 md:space-y-0">
            @forelse($orders as $order)
                <a href="{{ route('seller.orders.show', $order->id) }}"
                   class="block bg-white rounded-2xl p-4 shadow-sm border border-gray-100/80 hover:border-primary/20 hover:shadow-md transition-all group">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $order->order_number }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                    {{ $order->status === 'delivered' ? 'bg-green-50 text-green-600 border border-green-200' : ($order->status === 'shipped' ? 'bg-blue-50 text-blue-600 border border-blue-200' : ($order->status === 'cancelled' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-amber-50 text-amber-600 border border-amber-200')) }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <h3 class="text-sm font-bold text-gray-900 group-hover:text-primary transition-colors truncate">
                                {{ $order->items->first()->name ?? 'Order' }}
                                @if($order->items->count() > 1)
                                    <span class="text-gray-400 font-normal"> +{{ $order->items->count() - 1 }} more</span>
                                @endif
                            </h3>
                            <div class="flex items-center gap-3 mt-1.5 text-xs text-gray-500">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">person</span>
                                    {{ $order->user->name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-1 text-[11px] text-gray-400">
                                <span>{{ $order->created_at->format('M d, Y H:i') }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="font-bold text-gray-700">{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }} XAF</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="md:col-span-2 bg-white rounded-2xl p-12 shadow-sm border border-gray-100/80 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-4xl text-gray-300">shopping_cart</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">No orders yet</h3>
                    <p class="text-sm text-gray-500 mt-1">When customers purchase your items, they'll appear here.</p>
                </div>
            @endforelse
        </div>

        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-seller-layout>
