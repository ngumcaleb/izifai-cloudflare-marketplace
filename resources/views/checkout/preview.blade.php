@extends('layouts.guest')

@section('title', 'Checkout — Izifai')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 md:py-10">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Checkout</h1>
        <p class="text-sm text-on-surface-variant mt-1">Review your order and confirm payment</p>
    </div>

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
                    <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">Mobile Money Phone Number</h3>
                    <p class="text-[11px] text-on-surface-variant mb-3">Enter your MoMo phone number to receive a payment request. You'll approve the payment on your phone.</p>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-on-surface-variant">+237</span>
                        <input type="tel" name="phone" inputmode="numeric" pattern="[0-9]{9}" required
                               maxlength="9" placeholder="6XXXXXXXX"
                               class="w-full bg-surface-container border-none rounded-xl pl-14 pr-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20"
                               value="{{ old('phone') }}">
                    </div>
                    @error('phone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
                    <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-3">Shipping Address</h3>

                    @if(isset($addresses) && $addresses->count())
                    <div class="mb-3 space-y-2">
                        @foreach($addresses as $addr)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-outline-variant/20 cursor-pointer has-[:checked]:border-primary has-[:checked]:bg-primary/5 transition-all">
                            <input type="radio" name="shipping_address_id" value="{{ $addr->id }}"
                                   class="mt-0.5 accent-primary" {{ $addr->is_default ? 'checked' : '' }}>
                            <div class="text-sm">
                                <span class="font-bold text-on-surface">{{ $addr->label }}</span>
                                <p class="text-on-surface-variant text-xs">{{ $addr->address }}, {{ $addr->city }}, {{ $addr->country }}</p>
                                <p class="text-on-surface-variant text-xs">{{ $addr->phone }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="text-center">
                        <button type="button" onclick="document.getElementById('newAddressForm').classList.toggle('hidden'); this.classList.toggle('hidden')"
                                class="text-xs font-bold text-primary hover:underline">+ Add New Address</button>
                    </div>
                    @endif

                    <div id="newAddressForm" class="space-y-3 {{ isset($addresses) && $addresses->count() ? 'hidden' : '' }}">
                        <input type="hidden" name="shipping_address_id" value="new">
                        <div>
                            <label class="text-xs font-bold text-on-surface-variant mb-1 block">Label</label>
                            <input type="text" name="shipping_label" placeholder="e.g. Home, Office"
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20"
                                   value="{{ old('shipping_label', 'Home') }}">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs font-bold text-on-surface-variant mb-1 block">City</label>
                                <input type="text" name="shipping_city" required placeholder="Yaoundé"
                                       class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20"
                                       value="{{ old('shipping_city') }}">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-on-surface-variant mb-1 block">Phone</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-on-surface-variant">+237</span>
                                    <input type="tel" name="shipping_phone" inputmode="numeric" pattern="[0-9]{9}" required
                                           maxlength="9" placeholder="6XXXXXXXX"
                                           class="w-full bg-surface-container border-none rounded-xl pl-14 pr-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20"
                                           value="{{ old('shipping_phone') }}">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-on-surface-variant mb-1 block">Address</label>
                            <input type="text" name="shipping_address" required placeholder="Rue de la République, Bâtiment A"
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20"
                                   value="{{ old('shipping_address') }}">
                        </div>
                        <label class="flex items-center gap-2 text-sm text-on-surface-variant">
                            <input type="checkbox" name="save_address" value="1" class="accent-primary">
                            Save this address for next time
                        </label>
                    </div>
                    @error('shipping_city')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('shipping_address')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('shipping_phone')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
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
                            class="w-full mt-5 py-3.5 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/20">
                        Place Order
                    </button>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection
