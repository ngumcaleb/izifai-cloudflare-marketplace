@extends('layouts.guest')

@section('title', 'Checkout — Izifai')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 md:py-10">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Checkout</h1>
        <p class="text-sm text-on-surface-variant mt-1">Review your order and confirm payment</p>
    </div>

    @php $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get(); @endphp

    @if($cart->items->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">shopping_cart</span>
            <h2 class="text-lg font-bold text-on-surface mt-4">Your cart is empty</h2>
            <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all">
                Browse Products
            </a>
        </div>
    @else
        <form action="{{ route('checkout.place-order') }}" method="POST">
            @csrf

            <div class="space-y-4">
                @foreach($cart->items->groupBy(fn($i) => $i->item->store_id) as $storeId => $items)
                    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
                        <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">{{ $items->first()->item->store->name }}</h3>
                        <div class="divide-y divide-outline-variant/10">
                            @foreach($items as $item)
                            <div class="flex items-center justify-between py-2 first:pt-0 last:pb-0">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container overflow-hidden shrink-0">
                                        @if($item->item_type === 'App\Models\Product')
                                            <img src="{{ $item->item->mainImage?->url ?? $item->item->images->first()?->url }}" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-on-surface truncate">{{ $item->item->name }}</p>
                                        <p class="text-xs text-on-surface-variant">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                <span class="text-sm font-bold text-on-surface shrink-0">{{ number_format($item->price * $item->quantity) }} XAF</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
                    <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">Payment Method</h3>
                    <div class="space-y-2">
                        @forelse($paymentMethods as $pm)
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant/20 has-[:checked]:border-primary has-[:checked]:bg-primary/5 cursor-pointer transition-all">
                                <input type="radio" name="payment_method_id" value="{{ $pm->id }}" required
                                       class="accent-primary">
                                <div>
                                    <p class="text-sm font-bold text-on-surface">{{ $pm->name }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $pm->account_name }} — {{ $pm->number }}</p>
                                </div>
                            </label>
                        @empty
                            <p class="text-sm text-on-surface-variant">No payment methods available. Please contact support.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
                    <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">Order Notes (optional)</h3>
                    <textarea name="notes" rows="3" class="w-full bg-surface-container border-none rounded-xl p-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20" placeholder="Any special instructions..."></textarea>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
                    <div class="space-y-1.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant">Subtotal</span>
                            <span class="font-semibold">{{ number_format($cart->total) }} XAF</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-on-surface-variant">Shipping</span>
                            <span class="font-semibold">Free</span>
                        </div>
                        <div class="border-t border-outline-variant/20 pt-2 mt-2 flex justify-between text-base">
                            <span class="font-bold text-on-surface">Total</span>
                            <span class="text-xl font-black text-primary">{{ number_format($cart->total) }} XAF</span>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full mt-5 py-3.5 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20"
                            @if($paymentMethods->isEmpty()) disabled @endif>
                        Place Order
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection
