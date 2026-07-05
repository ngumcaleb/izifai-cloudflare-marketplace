<x-seller-layout>
    <x-slot name="title">Order #{{ $order->order_number }}</x-slot>

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">Placed {{ $order->created_at->format('M d, Y H:i') }} · Review order details below and manage fulfillment.</p>
            </div>
            <a href="{{ route('seller.orders.index') }}"
               class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                All Orders
            </a>
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            {{-- Left: Order Details --}}
            <div class="md:col-span-2 space-y-4">
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-xs font-semibold text-gray-400">Status</span>
                            <p class="text-sm font-bold text-gray-900 mt-0.5">
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                    {{ $order->status === 'delivered' ? 'bg-green-50 text-green-600 border border-green-200' : ($order->status === 'shipped' ? 'bg-blue-50 text-blue-600 border border-blue-200' : ($order->status === 'cancelled' ? 'bg-red-50 text-red-600 border border-red-200' : 'bg-amber-50 text-amber-600 border border-amber-200')) }}">
                                    {{ $order->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400">Buyer</span>
                            <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400">Items</span>
                            <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $order->items->count() }}</p>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-gray-400">Total</span>
                            <p class="text-sm font-bold text-primary mt-0.5">{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }} XAF</p>
                        </div>
                    </div>

                    @if($order->shippingAddress)
                        <div class="border-t border-gray-100 pt-4">
                            <span class="text-xs font-semibold text-gray-400">Shipping Address</span>
                            <p class="text-sm text-gray-700 mt-1">
                                {{ $order->shippingAddress->address_line1 }}<br>
                                @if($order->shippingAddress->address_line2){{ $order->shippingAddress->address_line2 }}<br>@endif
                                {{ $order->shippingAddress->city }}, {{ $order->shippingAddress->region }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80">
                    <h3 class="text-sm font-bold text-gray-900 mb-3">Order Items</h3>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50">
                                <div class="w-12 h-12 rounded-lg bg-gray-200 overflow-hidden shrink-0">
                                    @if($item->item && method_exists($item->item, 'mainImage') && $item->item->mainImage)
                                        <img src="{{ $item->item->mainImage->url }}" class="w-full h-full object-cover">
                                    @elseif($item->item && method_exists($item->item, 'images') && $item->item->images->first())
                                        <img src="{{ $item->item->images->first()->url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <span class="material-symbols-outlined">inventory_2</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $item->name ?? $item->item?->name }}</p>
                                    <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} × {{ number_format($item->price) }} XAF</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-bold text-gray-900">{{ number_format($item->price * $item->quantity) }} XAF</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between">
                        <span class="text-sm font-bold text-gray-900">Total</span>
                        <span class="text-sm font-bold text-primary">{{ number_format($order->items->sum(fn($i) => $i->price * $i->quantity)) }} XAF</span>
                    </div>
                </div>
            </div>

            {{-- Right: Actions & Status Info --}}
            <div class="space-y-4">
                @if($order->status === 'pending' || $order->status === 'confirmed')
                    <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80 space-y-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Ship Order</p>
                                <p class="text-[11px] text-gray-500">{{ $order->status === 'confirmed' ? 'Buyer has paid — ship the items now.' : 'Awaiting payment confirmation.' }}</p>
                            </div>
                        </div>
                        @if($order->status === 'confirmed')
                            <form action="{{ route('seller.orders.ship', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" onclick="return confirm('Mark this order as shipped?')"
                                        class="w-full bg-primary text-white py-3 rounded-xl text-xs font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[16px]">local_shipping</span>
                                    Mark as Shipped
                                </button>
                            </form>
                        @endif
                    </div>
                @elseif($order->status === 'shipped')
                    <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                <span class="material-symbols-outlined text-[18px]">local_shipping</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-blue-800">Shipped</p>
                                <p class="text-[11px] text-gray-500 mt-1">Awaiting buyer confirmation. Payment will be released to your wallet once the buyer confirms receipt.</p>
                            </div>
                        </div>
                    </div>
                @elseif($order->status === 'delivered')
                    <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 shrink-0">
                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-green-800">Delivered</p>
                                <p class="text-[11px] text-gray-500 mt-1">Payment has been released to your wallet. Thank you for fulfilling this order!</p>
                            </div>
                        </div>
                    </div>
                @elseif($order->status === 'cancelled')
                    <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500 shrink-0">
                                <span class="material-symbols-outlined text-[18px]">cancel</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-red-700">Cancelled</p>
                                <p class="text-[11px] text-gray-500 mt-1">This order has been cancelled. No payment has been processed.</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Order Timeline --}}
                <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500">
                            <span class="material-symbols-outlined text-[14px]">timeline</span>
                        </div>
                        <p class="text-xs font-bold text-gray-900">Order Timeline</p>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-start gap-2.5">
                            <div class="flex flex-col items-center mt-0.5">
                                <div class="w-2 h-2 rounded-full {{ in_array($order->status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'bg-primary' : 'bg-gray-200' }}"></div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Order Placed</p>
                                <p class="text-[10px] text-gray-400">{{ $order->created_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <div class="flex flex-col items-center mt-0.5">
                                <div class="w-2 h-2 rounded-full {{ in_array($order->status, ['confirmed', 'shipped', 'delivered']) ? 'bg-primary' : 'bg-gray-200' }}"></div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Payment Confirmed</p>
                                <p class="text-[10px] text-gray-400">Buyer payment verified</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <div class="flex flex-col items-center mt-0.5">
                                <div class="w-2 h-2 rounded-full {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary' : 'bg-gray-200' }}"></div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Shipped</p>
                                <p class="text-[10px] text-gray-400">Item dispatched</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <div class="flex flex-col items-center mt-0.5">
                                <div class="w-2 h-2 rounded-full {{ $order->status === 'delivered' ? 'bg-primary' : 'bg-gray-200' }}"></div>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-900">Delivered</p>
                                <p class="text-[10px] text-gray-400">Buyer confirmed receipt</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
