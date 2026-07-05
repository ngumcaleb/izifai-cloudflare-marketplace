@extends('layouts.guest')

@section('title', 'Cart — Izifai')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 md:py-10">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Cart</h1>
            <p class="text-sm text-on-surface-variant mt-1">{{ $cart->items_count }} item(s) in your cart</p>
        </div>
        @if($cart->items->isNotEmpty())
            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear your entire cart?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs font-semibold text-error hover:underline">Clear All</button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-slide-down">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if($cart->items->isEmpty())
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">shopping_cart</span>
            <h2 class="text-lg font-bold text-on-surface mt-4">Your cart is empty</h2>
            <p class="text-sm text-on-surface-variant mt-1">Browse products and add items to get started.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all">
                Browse Products
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($cart->items as $item)
                <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/10">
                    <div class="flex gap-4">
                        <div class="w-20 h-20 rounded-xl bg-surface-container overflow-hidden shrink-0">
                            @if($item->item_type === 'App\Models\Product')
                                <img src="{{ $item->item->mainImage?->url ?? $item->item->images->first()?->url }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ $item->item->main_image_url }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs text-on-surface-variant font-semibold uppercase tracking-wider">{{ $item->item->store->name ?? '' }}</p>
                                    <h3 class="text-sm font-bold text-on-surface mt-0.5">{{ $item->item->name }}</h3>
                                    <p class="text-sm font-black text-primary mt-1">{{ number_format($item->price) }} XAF</p>
                                </div>
                                <form action="{{ route('cart.remove', $item) }}" method="POST" class="shrink-0">
                                    @csrf @method('DELETE')
                                    <button class="w-8 h-8 flex items-center justify-center rounded-lg text-on-surface-variant/50 hover:text-error hover:bg-error/5 transition-all">
                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                    </button>
                                </form>
                            </div>
                            <div class="flex items-center gap-3 mt-3">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                    @csrf @method('PATCH')
                                    <div class="flex items-center border border-outline-variant/30 rounded-lg overflow-hidden">
                                        <button type="button" onclick="this.parentNode.querySelector('input').stepDown(); this.form.submit()" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-all text-sm font-bold">−</button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="99"
                                               class="w-12 h-8 text-center text-sm font-bold text-on-surface bg-transparent border-x border-outline-variant/30 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button type="button" onclick="this.parentNode.querySelector('input').stepUp(); this.form.submit()" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:bg-surface-container transition-all text-sm font-bold">+</button>
                                    </div>
                                    <noscript><button type="submit" class="text-xs font-semibold text-primary">Update</button></noscript>
                                </form>
                                <span class="text-sm font-bold text-on-surface ml-auto">{{ number_format($item->price * $item->quantity) }} XAF</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10 mt-4">
            <div class="flex items-center justify-between text-base">
                <span class="font-semibold text-on-surface">Total</span>
                <span class="text-xl font-black text-primary">{{ number_format($cart->total) }} XAF</span>
            </div>
            <a href="{{ route('checkout.preview') }}"
               class="block w-full mt-4 py-3.5 bg-primary text-on-primary rounded-xl text-sm font-bold text-center hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                Proceed to Checkout
            </a>
            <a href="{{ route('products.index') }}" class="block w-full mt-2 py-3 text-center text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">
                Continue Shopping
            </a>
        </div>
    @endif
</div>
@endsection
