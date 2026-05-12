@extends('layouts.public')

@php
$store = $product->store;
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
@endphp

@section('title', $product->name . ' - ' . $store->name . ' Showroom')
@section('description', strip_tags($product->description) ?: $product->name . ' on Izifai')

{{-- ==================== DESKTOP SIDEBAR ==================== --}}
@section('sidebar')
<aside class="fixed left-0 top-0 h-full w-[260px] bg-surface flex-col py-6 px-4 shadow-sm z-50 hidden lg:flex">
    <div class="mb-8 px-1">
        <h1 class="text-[20px] leading-7 font-bold text-primary">{{ $store->name }}</h1>
        @if($store->is_verified)
            <p class="text-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                <span class="material-symbols-outlined text-[16px] text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                Verified {{ $store->badge ?: 'Premium Store' }}
            </p>
        @endif
    </div>
    <nav class="flex-1 space-y-1">
        <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">storefront</span>
            <span>Showroom</span>
        </a>
        <a href="{{ route('stores.show', $store->slug) }}#catalog" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">grid_view</span>
            <span>Collections</span>
        </a>
        <a href="{{ route('stores.show', $store->slug) }}#reviews" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">star</span>
            <span>Reviews</span>
        </a>
        <a href="{{ route('stores.show', $store->slug) }}#store-info" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">info</span>
            <span>Store Info</span>
        </a>
        @if($store->whatsapp_number)
            <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
               class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
                <span class="material-symbols-outlined">contact_support</span>
                <span>Support</span>
            </a>
        @endif
        <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank"
           class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">groups</span>
            <span>Join WhatsApp Group</span>
        </a>
    </nav>
    <div class="mt-auto pt-6">
        @if($store->whatsapp_number)
<a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
   class="w-full bg-[#25D366] text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-[#128C7E] transition-all">
    {!! $whatsappIcon !!}
    Message Seller
</a>
        @endif
        @auth
            @if(auth()->id() === $store->user_id)
                <a href="{{ route('seller.dashboard') }}"
                   class="w-full mt-3 bg-primary text-on-primary py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all text-sm">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('seller.dashboard') }}"
                   class="w-full mt-3 bg-surface-container-high text-on-surface py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all text-sm">
                    <span class="material-symbols-outlined text-[18px]">store</span>
                    Start Selling on Izifai
                </a>
            @endif
        @endauth
        @guest
            <a href="{{ url('/') }}"
               class="w-full mt-3 bg-surface-container-high text-on-surface py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all text-sm">
                <span class="material-symbols-outlined text-[18px]">app_registration</span>
                Join Izifai Today — List Products. Get a Link.
            </a>
        @endguest
    </div>
</aside>
@endsection

{{-- ==================== MOBILE NAV ==================== --}}
@section('mobile-nav')
<template x-teleport="body">
    <div x-show="mobileNav" x-cloak
         class="fixed inset-0 z-[60] lg:hidden"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 mobile-nav-overlay" @click="mobileNav = false"></div>
        <div class="absolute left-0 top-0 h-full w-[280px] bg-surface shadow-2xl"
             @click.away="mobileNav = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div class="flex flex-col h-full py-6 px-4">
                <div class="flex items-center justify-between mb-8 px-1">
                    <div>
                        <h1 class="text-[20px] leading-7 font-bold text-primary">{{ $store->name }}</h1>
                        @if($store->is_verified)
                            <p class="text-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                                <span class="material-symbols-outlined text-[16px] text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                                Verified {{ $store->badge ?: 'Premium Store' }}
                            </p>
                        @endif
                    </div>
                    <button @click="mobileNav = false" class="p-2 text-on-surface-variant hover:text-on-surface">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <nav class="flex-1 space-y-1">
                    <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-4 p-4 rounded-lg text-primary font-bold border-l-4 border-primary bg-secondary-container/30 transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">storefront</span>
                        <span>Showroom</span>
                    </a>
                    <a href="{{ route('stores.show', $store->slug) }}#catalog" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">grid_view</span>
                        <span>Collections</span>
                    </a>
                    <a href="{{ route('stores.show', $store->slug) }}#reviews" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">star</span>
                        <span>Reviews</span>
                    </a>
                    <a href="{{ route('stores.show', $store->slug) }}#store-info" class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">info</span>
                        <span>Store Info</span>
                    </a>
                    @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                           class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
                            <span class="material-symbols-outlined">contact_support</span>
                            <span>Support</span>
                        </a>
                    @endif
                    <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank"
                       class="flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
                        <span class="material-symbols-outlined">groups</span>
                        <span>Join WhatsApp Group</span>
                    </a>
                </nav>
                <div class="mt-auto pt-6">
                    @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                           class="w-full bg-[#25D366] text-white py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-md hover:bg-[#128C7E] transition-all">
                            {!! $whatsappIcon !!}
                            Message Seller
                        </a>
                    @endif
                    @auth
                        @if(auth()->id() === $store->user_id)
                            <a href="{{ route('seller.dashboard') }}"
                               class="w-full mt-3 bg-primary text-on-primary py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all text-sm">
                                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('seller.dashboard') }}"
                               class="w-full mt-3 bg-surface-container-high text-on-surface py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all text-sm">
                                <span class="material-symbols-outlined text-[18px]">store</span>
                                Start Selling on Izifai
                            </a>
                        @endif
                    @endauth
                    @guest
                        <a href="{{ url('/') }}"
                           class="w-full mt-3 bg-surface-container-high text-on-surface py-3 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-surface-container-highest transition-all text-sm">
                            <span class="material-symbols-outlined text-[18px]">app_registration</span>
                            Join Izifai Today — List Products. Get a Link.
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</template>
@endsection

{{-- ==================== TOPBAR ==================== --}}
@section('topbar')
<header class="fixed top-0 right-0 left-0 lg:left-[260px] lg:w-[calc(100%-260px)] h-[64px] lg:h-[72px] bg-surface/80 backdrop-blur-md flex items-center justify-between px-4 lg:px-8 z-40 shadow-sm">
    <div class="flex items-center gap-3 lg:gap-6 flex-1 min-w-0">
        <button @click="mobileNav = true" class="lg:hidden p-2 -ml-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('stores.show', $store->slug) }}" class="hover:opacity-80 transition-opacity">
                <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-surface-container-highest overflow-hidden ring-2 ring-primary/20 shrink-0">
                    @if($store->logo)
                        <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-xs lg:text-sm font-bold text-primary bg-surface-container-high">
                            {{ substr($store->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </a>
            <h2 class="text-lg lg:text-[24px] leading-8 font-bold text-primary tracking-tight truncate">{{ $product->name }}</h2>
        </div>
    </div>
    <div class="flex items-center gap-2 lg:gap-4">
        @guest
            <a href="{{ url('/') }}"
               class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-[16px]">app_registration</span>
                Join Izifai Today
            </a>
        @endguest
        <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-surface-container-highest overflow-hidden ring-2 ring-primary/20 shrink-0 hidden sm:block">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-xs lg:text-sm font-bold text-primary bg-surface-container-high">
                    {{ substr($store->name, 0, 1) }}
                </div>
            @endif
        </div>
    </div>
</header>
@endsection

{{-- ==================== CONTENT ==================== --}}
@section('content')
<div x-data="productPage()" class="space-y-8 lg:space-y-12">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-on-surface-variant min-w-0">
        <a href="{{ route('stores.show', $store->slug) }}" class="hover:text-primary transition-colors font-semibold truncate whitespace-nowrap">{{ $store->name }}</a>
        <span class="material-symbols-outlined text-[16px] shrink-0">chevron_right</span>
        <span class="text-on-surface font-bold truncate whitespace-nowrap">{{ $product->name }}</span>
    </div>

    {{-- PRODUCT HERO --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">

        {{-- LEFT: Gallery --}}
        <div class="lg:col-span-7 space-y-4">
            <div class="relative bg-white rounded-xl overflow-hidden shadow-sm aspect-[4/3]">
                <template x-if="selectedImage">
                    <img :src="selectedImage" class="w-full h-full object-cover">
                </template>
                <template x-if="!selectedImage">
                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                        <span class="material-symbols-outlined text-6xl">image</span>
                    </div>
                </template>
            </div>

            @if($product->images->count() > 0)
            <div class="grid grid-cols-4 gap-3">
                @foreach($product->images as $idx => $img)
                <button @click="selectedImage = '{{ asset('storage/' . $img->path) }}'"
                        class="aspect-square rounded-lg overflow-hidden border-2 transition-all relative"
                        :class="selectedImage === '{{ asset('storage/' . $img->path) }}' ? 'border-primary' : 'border-outline-variant/20 hover:border-outline-variant/50'">
                    <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-full object-cover">
                    @if($loop->iteration === 4 && $product->images->count() > 4)
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">+{{ $product->images->count() - 4 }}</span>
                    </div>
                    @endif
                </button>
                @endforeach
            </div>
            @endif

            @if($product->description)
            <div class="bg-white rounded-xl p-6 shadow-sm">
                <h2 class="text-sm font-bold text-on-surface mb-4">Description</h2>
                <div class="text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $product->description }}</div>
            </div>
            @endif
        </div>

        {{-- RIGHT: Product Info --}}
        <div class="lg:col-span-5">
            <div class="bg-white rounded-xl p-6 lg:p-8 shadow-sm space-y-5 sticky top-[80px] lg:top-[100px]">

                {{-- Badges --}}
                <div class="flex flex-wrap gap-2">
                    @if($store->is_verified)
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold bg-primary/10 text-primary uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Verified Authentic
                    </span>
                    @endif
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                        {{ $product->stock_status === 'in_stock' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                        {{ str_replace('_', ' ', $product->stock_status) }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-2xl lg:text-[28px] leading-tight font-bold text-on-surface">{{ $product->name }}</h1>

                {{-- Star Rating --}}
                <div class="flex items-center gap-2">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-[18px]"
                              style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-on-surface">{{ number_format($avgRating, 1) }}</span>
                    <a href="{{ route('stores.show', $store->slug) }}#reviews" class="text-sm text-primary font-semibold hover:underline">({{ $totalReviews }} reviews)</a>
                </div>

                {{-- Price --}}
                <div>
                    <span class="text-[28px] lg:text-[32px] leading-none font-black text-primary">{{ number_format($product->price) }} FCFA</span>
                    @if($product->old_price)
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-sm text-on-surface-variant line-through">{{ number_format($product->old_price) }} FCFA</span>
                        <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">-{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                    </div>
                    @endif
                    <p class="text-xs text-on-surface-variant mt-1">Inclusive of all taxes</p>
                </div>

                {{-- Colors --}}
                @if($product->colors && count($product->colors) > 0)
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Colors</p>
                    <div class="flex flex-wrap gap-3">
                        <template x-for="color in {{ json_encode($product->colors) }}" :key="color">
                            <button @click="selectedColor = color"
                                    class="w-9 h-9 rounded-full border-2 transition-all flex items-center justify-center"
                                    :class="selectedColor === color ? 'border-primary ring-2 ring-primary/20' : 'border-outline-variant/30 hover:border-outline-variant'"
                                    :style="'background-color: ' + color.toLowerCase()"
                                    :title="color">
                                <template x-if="selectedColor === color">
                                    <span class="material-symbols-outlined text-[14px]" :style="'color: ' + (['white','#fff','#ffffff','whitesmoke'].includes(color.toLowerCase()) ? '#000' : '#fff')" style="font-variation-settings: 'FILL' 1;">check</span>
                                </template>
                            </button>
                        </template>
                    </div>
                </div>
                @endif

                {{-- Key Specifications --}}
                @if($product->specifications && $product->specifications->count() > 0)
                <div>
                    <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-3">Key Specifications</p>
                    <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                        @foreach($product->specifications->take(6) as $spec)
                        <div class="flex items-start gap-2 text-sm">
                            <span class="material-symbols-outlined text-[16px] text-primary shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <div>
                                <p class="text-[10px] text-on-surface-variant font-semibold uppercase">{{ $spec->key }}</p>
                                <p class="text-xs font-bold text-on-surface">{{ $spec->value }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Action Buttons --}}
                <div class="space-y-3 pt-2">
                    @if($store->whatsapp_number)
                    <a href="https://wa.me/{{ $store->whatsapp_number }}?text={{ urlencode('Hi, I am interested in ' . $product->name . ' on Izifai.') }}"
                       target="_blank" onclick="logContact('whatsapp')"
                       class="flex items-center justify-center gap-3 w-full py-3.5 bg-[#25D366] text-white rounded-xl text-sm font-bold hover:bg-[#128C7E] transition-all shadow-lg shadow-[#25D366]/30">
                        {!! $whatsappIcon !!}
                        Enquire on WhatsApp
                    </a>
                    @endif
                    <a href="{{ route('stores.show', $store->slug) }}"
                       class="flex items-center justify-center gap-2 w-full py-3 bg-surface-container-high text-on-surface rounded-xl text-sm font-bold hover:bg-surface-container-highest transition-all">
                        <span class="material-symbols-outlined text-[18px]">store</span>
                        Message Vendor
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { const span = this.querySelector('span:last-child'); span.textContent = 'Copied!'; setTimeout(() => span.textContent = 'Share Link', 2000); })"
                            class="flex items-center justify-center gap-2 w-full py-2.5 border border-outline-variant/30 text-on-surface-variant rounded-xl text-xs font-bold hover:bg-surface-container transition-all">
                        <span class="material-symbols-outlined text-[18px]">share</span>
                        <span>Share Link</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- DESCRIPTION (mobile fallback) --}}
    @if($product->description)
    <div class="lg:hidden bg-white rounded-xl p-6 shadow-sm">
        <h2 class="text-sm font-bold text-on-surface mb-4">Description</h2>
        <div class="text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $product->description }}</div>
    </div>
    @endif

    {{-- TRUST & SOCIAL ROW --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl p-5 shadow-sm flex flex-col items-center justify-center gap-3">
            <p class="text-xs font-bold text-on-surface-variant uppercase tracking-wider">Connect With Us</p>
            <div class="flex gap-2">
                <a href="#" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[18px]">camera_alt</span>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[18px]">thumb_up</span>
                </a>
                <a href="#" class="w-9 h-9 rounded-full bg-surface-container flex items-center justify-center text-on-surface-variant hover:bg-primary/10 hover:text-primary transition-all">
                    <span class="material-symbols-outlined text-[18px]">play_circle</span>
                </a>
            </div>
        </div>
        <div class="lg:col-span-3 bg-white rounded-xl p-5 shadow-sm flex flex-col sm:flex-row gap-4 sm:gap-6 divide-y sm:divide-y-0 sm:divide-x divide-outline-variant/20">
            <div class="flex items-start gap-3 flex-1">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-on-surface">Premium Assurance</p>
                    <p class="text-xs text-on-surface-variant">Verified merchant with platinum status for quality and trust</p>
                </div>
            </div>
            <div class="flex items-start gap-3 flex-1 pt-4 sm:pt-0 sm:pl-6">
                <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-on-surface">{{ $store->location ? explode(',', $store->location)[0] . ' Express' : 'Douala & Yaoundé Express' }}</p>
                    <p class="text-xs text-on-surface-variant">Fast delivery across {{ $store->location ? $store->location : "Cameroon's major cities" }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOMER REVIEWS --}}
    @if($reviews->count() > 0)
    <section id="reviews" class="scroll-mt-[80px] lg:scroll-mt-[100px]">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">reviews</span>
                Customer Reviews
            </h4>
            <div class="flex items-center gap-2">
                <span class="text-sm font-bold">{{ number_format($avgRating, 1) }}</span>
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[16px]"
                          style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                    @endfor
                </div>
            </div>
        </div>

        @php $firstReview = $reviews->shift(); @endphp
        @if($firstReview)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="bg-white/80 backdrop-blur rounded-xl p-5 shadow-sm border border-outline-variant/10">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center font-bold text-primary text-sm">
                        {{ substr($firstReview->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold">{{ $firstReview->user->name ?? 'Anonymous' }}</p>
                        <p class="text-[10px] text-on-surface-variant">Verified Buyer</p>
                    </div>
                </div>
                <div class="flex text-amber-400 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[16px]"
                          style="font-variation-settings: 'FILL' {{ $i <= $firstReview->rating ? 1 : 0 }};">star</span>
                    @endfor
                </div>
                @if($firstReview->comment)
                <p class="text-sm text-on-surface-variant italic">"{{ $firstReview->comment }}"</p>
                @endif
            </div>

            @php $secondReview = $reviews->shift(); @endphp
            @if($secondReview)
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-primary/20 overflow-hidden">
                <div class="flex flex-col sm:flex-row">
                    <div class="flex-1 p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center font-bold text-primary text-sm">
                                {{ substr($secondReview->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold">{{ $secondReview->user->name ?? 'Anonymous' }}</p>
                                <p class="text-[10px] text-on-surface-variant">Verified Buyer</p>
                            </div>
                        </div>
                        <div class="flex text-amber-400 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-[16px]"
                                  style="font-variation-settings: 'FILL' {{ $i <= $secondReview->rating ? 1 : 0 }};">star</span>
                            @endfor
                        </div>
                        @if($secondReview->comment)
                        <p class="text-sm text-on-surface-variant">"{{ $secondReview->comment }}"</p>
                        @endif
                    </div>
                    @if($product->images->first())
                    <div class="sm:w-48 lg:w-56 h-48 sm:h-auto">
                        <img src="{{ asset('storage/' . $product->images->first()->path) }}"
                             class="w-full h-full object-cover rounded-lg sm:rounded-none sm:rounded-r-xl"
                             alt="{{ $product->name }}">
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
        @endif
    </section>
    @endif

    {{-- HIGHLY LIKED PRODUCTS --}}
    @if($topProducts->count() > 0)
    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">recommend</span>
                Highly Liked Products
            </h4>
            <a href="{{ route('stores.show', $store->slug) }}#catalog" class="text-primary text-sm font-bold hover:underline shrink-0 flex items-center gap-1">
                View All <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5">
            @foreach($topProducts->take(4) as $p)
            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all border border-outline-variant/10 overflow-hidden group relative">
                <a href="{{ route('products.show', $p->slug) }}" class="block">
                    <div class="aspect-square relative overflow-hidden">
                        @if($p->images->first())
                        <img src="{{ asset('storage/' . $p->images->first()->path) }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             alt="{{ $p->name }}">
                        @else
                        <div class="w-full h-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                            <span class="material-symbols-outlined text-4xl">image</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-3 space-y-1">
                        @if($p->category)
                        <p class="text-[9px] font-semibold text-outline uppercase truncate">{{ $p->category->name }}</p>
                        @endif
                        <h6 class="font-bold text-sm text-on-surface truncate">{{ $p->name }}</h6>
                        <p class="text-sm font-black text-primary truncate">{{ number_format($p->price) }} FCFA</p>
                    </div>
                </a>
                <button class="favorite-btn absolute top-2 right-2 w-7 h-7 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-10"
                        data-product="{{ $p->id }}"
                        data-favorited="{{ in_array($p->id, $savedProductIds) ? 'true' : 'false' }}">
                    <span class="material-symbols-outlined text-[16px]"
                          style="font-variation-settings: 'FILL' {{ in_array($p->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                </button>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- OTHER PRODUCTS IN STORE --}}
    @if($storeProducts->count() > 0)
    <section class="space-y-4">
        <h4 class="text-lg lg:text-[24px] leading-8 font-bold">Other Products in Store</h4>
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-3 lg:gap-4">
            @foreach($storeProducts as $sp)
            <a href="{{ route('products.show', $sp->slug) }}"
               class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all border border-outline-variant/10 group">
                <div class="aspect-square overflow-hidden">
                    @if($sp->images->first())
                    <img src="{{ asset('storage/' . $sp->images->first()->path) }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="{{ $sp->name }}">
                    @else
                    <div class="w-full h-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-3xl">image</span>
                    </div>
                    @endif
                </div>
                <div class="p-2 space-y-0.5">
                    <h6 class="text-xs font-bold text-on-surface truncate">{{ $sp->name }}</h6>
                    <p class="text-xs font-bold text-primary truncate">{{ number_format($sp->price) }} FCFA</p>
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

{{-- ==================== FOOTER ==================== --}}
@section('footer')
<footer class="w-full py-8 lg:py-12 bg-surface-container-low flex flex-col items-center justify-center space-y-3 lg:space-y-4 border-t border-outline-variant/30 px-4">
    @if($store->business_email || $store->location)
        <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-6 text-xs lg:text-sm text-on-surface-variant">
            @if($store->business_email)
                <a href="mailto:{{ $store->business_email }}" class="hover:text-primary transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] lg:text-[16px] align-middle">mail</span>
                    {{ $store->business_email }}
                </a>
            @endif
            @if($store->location)
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[14px] lg:text-[16px] align-middle">location_on</span>
                    {{ $store->location }}
                </span>
            @endif
        </div>
    @endif
    <div class="font-bold text-xs lg:text-sm text-on-surface text-center">{{ $store->name }} — IZIFAI Showroom</div>
    @auth
        @if(auth()->id() === $store->user_id)
            <a href="{{ route('seller.dashboard') }}"
               class="inline-flex items-center gap-1.5 text-primary font-semibold text-xs lg:text-sm hover:underline">
                <span class="material-symbols-outlined text-[14px]">dashboard</span>
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('seller.dashboard') }}"
               class="text-primary font-semibold text-xs lg:text-sm hover:underline">
                Start Selling on Izifai &rarr;
            </a>
        @endif
    @endauth
    @guest
        <a href="{{ url('/') }}"
           class="text-primary font-semibold text-xs lg:text-sm hover:underline">
            Join Izifai Today &rarr;
        </a>
    @endguest
    <p class="text-xs lg:text-sm text-on-surface-variant">&copy; {{ date('Y') }} IZIFAI Platform. All rights reserved.</p>
</footer>

<script>
    function productPage() {
        return {
            selectedImage: @js($product->images->first() ? asset('storage/' . $product->images->first()->path) : ''),
            selectedColor: null,
            selectedSize: null
        }
    }

    function logContact(type) {
        fetch('{{ route('products.log-contact', $product) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ type: type })
        });
        if (type === 'whatsapp') {
            window.open('https://wa.me/{{ $store->whatsapp_number ?? '' }}?text={{ urlencode('Hi, I am interested in ' . $product->name . ' on Izifai.') }}', '_blank');
        }
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.favorite-btn');
        if (!btn) return;
        e.preventDefault();
        const productId = btn.dataset.product;
        const isFav = btn.dataset.favorited === 'true';
        @auth
            fetch('{{ url('/products') }}/' + productId + '/favorite', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                const icon = btn.querySelector('.material-symbols-outlined');
                if (data.favorited) {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    btn.dataset.favorited = 'true';
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    btn.dataset.favorited = 'false';
                }
            });
        @endauth
        @guest
            window.location.href = '{{ route('login') }}';
        @endguest
    });
</script>
@endsection