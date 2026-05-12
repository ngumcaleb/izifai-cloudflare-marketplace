@extends('layouts.public')

@section('title', $store->name . ' - Izifai Showroom')
@section('description', $store->description ? strip_tags($store->description) : $store->name . ' on Izifai')

@php $whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>'; @endphp

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
        <a href="#showroom" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-primary font-bold border-l-4 border-primary bg-secondary-container/30 transition-all duration-200">
            <span class="material-symbols-outlined">storefront</span>
            <span>Showroom</span>
        </a>
        <a href="#catalog" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">grid_view</span>
            <span>Collections</span>
        </a>
        <a href="#reviews" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
            <span class="material-symbols-outlined">star</span>
            <span>Reviews</span>
        </a>
        <a href="#store-info" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200">
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
                    <a href="#showroom" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-primary font-bold border-l-4 border-primary bg-secondary-container/30 transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">storefront</span>
                        <span>Showroom</span>
                    </a>
                    <a href="#catalog" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">grid_view</span>
                        <span>Collections</span>
                    </a>
                    <a href="#reviews" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
                        <span class="material-symbols-outlined">star</span>
                        <span>Reviews</span>
                    </a>
                    <a href="#store-info" class="scroll-link flex items-center gap-4 p-4 rounded-lg text-on-surface-variant hover:text-primary hover:bg-surface-container transition-all duration-200" @click="mobileNav = false">
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
        <h2 class="text-lg lg:text-[24px] leading-8 font-bold text-primary tracking-tight truncate">{{ $store->name }}</h2>
        <div class="relative w-full max-w-md hidden sm:block">
            <form action="{{ route('stores.show', $store->slug) }}" method="GET">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input name="search" value="{{ request('search') }}"
                       class="w-full pl-12 pr-4 py-2 bg-surface-container-low border outline-variant/30 rounded-full text-sm focus:ring-primary focus:border-primary"
                       placeholder="Search in this store..." type="text"/>
            </form>
        </div>
    </div>
    <div class="flex items-center gap-2 lg:gap-4">
        <button @click="document.getElementById('mobile-search').classList.toggle('hidden')" class="sm:hidden p-2 text-on-surface-variant hover:text-primary transition-colors">
            <span class="material-symbols-outlined">search</span>
        </button>
        @guest
            <a href="{{ url('/') }}"
               class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-sm whitespace-nowrap">
                <span class="material-symbols-outlined text-[16px]">app_registration</span>
                Join Izifai Today
            </a>
        @endguest
        @auth
            @if(auth()->id() !== $store->user_id)
                <button class="p-2 text-on-surface-variant hover:text-primary transition-colors hidden sm:block">
                    <span class="material-symbols-outlined">favorite</span>
                </button>
            @endif
        @endauth
        <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-surface-container-highest overflow-hidden ring-2 ring-primary/20 shrink-0">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-xs lg:text-sm font-bold text-primary bg-surface-container-high">
                    {{ substr($store->name, 0, 1) }}
                </div>
            @endif
        </div>
    </div>
</header>
@endsection

{{-- ==================== MOBILE SEARCH ==================== --}}
@section('mobile-search')
<div id="mobile-search" class="hidden fixed top-[64px] left-0 right-0 bg-surface/95 backdrop-blur-md px-4 py-3 z-30 lg:hidden border-b border-outline-variant/10">
    <form action="{{ route('stores.show', $store->slug) }}" method="GET">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input name="search" value="{{ request('search') }}"
                   class="w-full pl-12 pr-4 py-3 bg-surface-container-low border outline-variant/30 rounded-full text-sm focus:ring-primary focus:border-primary"
                   placeholder="Search in this store..." type="text"/>
        </div>
    </form>
</div>
@endsection

{{-- ==================== CONTENT ==================== --}}
@section('content')

{{-- HERO BANNER --}}
<section id="showroom" class="relative h-[220px] sm:h-[280px] lg:h-[320px] rounded-2xl lg:rounded-[32px] overflow-hidden shadow-xl">
    @if($store->banner)
        <img class="w-full h-full object-cover" src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}">
    @else
        <div class="w-full h-full bg-gradient-to-br from-primary/80 to-primary"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
    <div class="absolute bottom-4 sm:bottom-6 lg:bottom-8 left-4 sm:left-6 lg:left-8 right-4 sm:right-6 lg:right-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="flex items-center gap-3 lg:gap-6 min-w-0">
            <div class="w-16 h-16 sm:w-20 sm:h-20 lg:w-24 lg:h-24 rounded-xl lg:rounded-2xl bg-white p-1.5 lg:p-2 shadow-lg ring-4 ring-primary/10 shrink-0">
                @if($store->logo)
                    <img src="{{ asset('storage/' . $store->logo) }}" alt="{{ $store->name }} Logo"
                         class="w-full h-full object-cover rounded-lg lg:rounded-xl">
                @else
                    <div class="w-full h-full rounded-lg lg:rounded-xl bg-primary/10 flex items-center justify-center text-xl lg:text-3xl font-black text-primary">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="text-white min-w-0">
                <div class="flex flex-wrap items-center gap-2 mb-0.5">
                    <h3 class="text-xl sm:text-2xl lg:text-[30px] lg:leading-[38px] font-bold tracking-tight truncate">{{ $store->name }}</h3>
                    @if($store->is_verified)
                        <span class="bg-primary-container text-on-primary-container px-2 py-0.5 rounded-full text-[9px] lg:text-[11px] font-bold flex items-center gap-0.5 shrink-0">
                            <span class="material-symbols-outlined text-[12px] lg:text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="hidden xs:inline">VERIFIED {{ $store->badge ? strtoupper($store->badge) : 'MERCHANT' }}</span>
                        </span>
                    @endif
                </div>
                @if($store->description)
                    <p class="text-xs sm:text-sm lg:text-base opacity-90 max-w-2xl line-clamp-2">{{ $store->description }}</p>
                @endif
                @if($store->location)
                    <p class="text-xs lg:text-sm opacity-75 mt-0.5 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px] lg:text-[16px]">location_on</span>
                        {{ $store->location }}
                    </p>
                @endif
            </div>
        </div>
        <div class="flex gap-2 shrink-0">
            @if($store->whatsapp_number)
<a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
   class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-white text-xs font-bold bg-[#25D366] hover:bg-[#128C7E] transition-all whitespace-nowrap shadow-sm">
    {!! $whatsappIcon !!}
    <span>WhatsApp</span>
</a>
            @endif
            <button onclick="navigator.clipboard.writeText(window.location.href).then(() => { this.querySelector('span').textContent = 'done'; setTimeout(() => this.querySelector('span').textContent = 'Share', 2000); })"
                    class="glass-card flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-white text-xs font-bold hover:bg-white/20 transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">share</span>
                <span>Share</span>
            </button>
        </div>
    </div>
</section>

{{-- STORE METRICS --}}
<section class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:gap-5">
    <div class="bg-surface-container-lowest p-4 lg:p-6 rounded-2xl shadow-sm flex items-center gap-3 lg:gap-4 border border-outline-variant/10">
        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[22px] lg:text-[24px]" style="font-variation-settings: 'FILL' 1;">star</span>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] lg:text-[12px] leading-4 font-semibold tracking-wider text-on-surface-variant uppercase">Rating</p>
            <p class="text-base lg:text-[20px] leading-7 font-semibold text-on-surface truncate">{{ number_format($avgRating, 1) }} / 5.0</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-4 lg:p-6 rounded-2xl shadow-sm flex items-center gap-3 lg:gap-4 border border-outline-variant/10">
        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[22px] lg:text-[24px]">reviews</span>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] lg:text-[12px] leading-4 font-semibold tracking-wider text-on-surface-variant uppercase">Reviews</p>
            <p class="text-base lg:text-[20px] leading-7 font-semibold text-on-surface truncate">{{ $totalReviews }}+</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-4 lg:p-6 rounded-2xl shadow-sm flex items-center gap-3 lg:gap-4 border border-outline-variant/10">
        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[22px] lg:text-[24px]">history</span>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] lg:text-[12px] leading-4 font-semibold tracking-wider text-on-surface-variant uppercase">Member Since</p>
            <p class="text-base lg:text-[20px] leading-7 font-semibold text-on-surface truncate">{{ $tenureLabel }}</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-4 lg:p-6 rounded-2xl shadow-sm flex items-center gap-3 lg:gap-4 border border-outline-variant/10">
        <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-[22px] lg:text-[24px]">check_circle</span>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] lg:text-[12px] leading-4 font-semibold tracking-wider text-on-surface-variant uppercase">Products Listed</p>
            <p class="text-base lg:text-[20px] leading-7 font-semibold text-on-surface truncate">{{ $totalProducts }}+</p>
        </div>
    </div>
</section>

{{-- TOP PRODUCTS BENTO --}}
@if($topProducts->count() > 0)
<section class="space-y-4 lg:space-y-6">
    <div class="flex items-center justify-between">
        <h4 class="text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2">
            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">recommend</span>
            Highest Liked Products
        </h4>
        <a href="#catalog" class="scroll-link text-primary text-sm lg:text-base font-bold flex items-center gap-1 hover:underline shrink-0">
            View All <span class="material-symbols-outlined hidden sm:inline">arrow_forward</span>
        </a>
    </div>
    @php $featured = $topProducts->shift(); @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-5">
        @if($featured)
            <div class="col-span-2 lg:col-span-2 lg:row-span-2 relative rounded-2xl lg:rounded-[24px] overflow-hidden group shadow-lg aspect-[4/3] lg:aspect-[4/3]">
                @if($featured->images->first())
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                         src="{{ asset('storage/' . $featured->images->first()->path) }}" alt="{{ $featured->name }}">
                @else
                    <div class="w-full h-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-6xl">image</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-4 lg:p-8 flex flex-col justify-end">
                    <span class="w-fit bg-primary text-on-primary px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-lg text-[9px] lg:text-[11px] font-bold mb-2 lg:mb-4 uppercase">Most Popular</span>
                    <h5 class="text-white text-lg lg:text-[30px] lg:leading-[38px] font-bold mb-0.5 lg:mb-1 line-clamp-1">{{ $featured->name }}</h5>
                    @if($featured->description)
                        <p class="text-white/80 text-xs lg:text-base mb-2 lg:mb-lg line-clamp-2 hidden sm:block">{{ strip_tags($featured->description) }}</p>
                    @endif
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                    <span class="text-white font-black text-lg lg:text-[24px] leading-8">{{ number_format($featured->price) }} FCFA</span>
                                    <div class="flex items-center gap-2 lg:gap-4">
                                        <button class="bg-white/20 hover:bg-white/30 text-white p-2 lg:p-4 rounded-full backdrop-blur-md favorite-btn"
                                                data-product="{{ $featured->id }}"
                                                data-favorited="{{ in_array($featured->id, $savedProductIds) ? 'true' : 'false' }}">
                                            <span class="material-symbols-outlined text-[18px] lg:text-[24px]"
                                                  style="font-variation-settings: 'FILL' {{ in_array($featured->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                                        </button>
                                        <a href="{{ route('products.show', $featured->slug) }}"
                                           class="bg-white text-primary px-3 lg:px-6 py-1.5 lg:py-3 rounded-full text-[11px] lg:text-base font-bold hover:bg-white/90 transition-all whitespace-nowrap">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                </div>
            </div>
        @endif

        @foreach($topProducts as $index => $product)
            @php
                $spanClass = $index < 2 ? 'col-span-1' : 'col-span-2 lg:col-span-2';
                $aspectClass = $index < 2 ? 'aspect-square lg:aspect-[4/3]' : 'aspect-[2/1] lg:aspect-[4/3]';
            @endphp
            <a href="{{ route('products.show', $product->slug) }}"
               class="{{ $spanClass }} {{ $aspectClass }} {{ $heightClass }} relative rounded-2xl lg:rounded-[24px] overflow-hidden group shadow-md border border-outline-variant/10 block">
                @if($product->images->first())
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                        <span class="material-symbols-outlined text-4xl">image</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent p-3 lg:p-6 flex flex-col justify-end">
                    <p class="text-white font-bold text-sm lg:text-[20px] leading-7 line-clamp-1">{{ $product->name }}</p>
                    <div class="flex items-center justify-between">
                        <p class="text-white/90 font-bold text-xs lg:text-base">{{ number_format($product->price) }} FCFA</p>
                        @if($product->old_price)
                            <span class="bg-primary/20 text-primary-fixed-dim px-1.5 lg:px-2.5 py-0.5 rounded text-[9px] lg:text-[11px] font-bold">SALE -{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- CUSTOMER REVIEWS --}}
<section id="reviews" class="space-y-4 lg:space-y-6" x-data="{ reviewForm: false, reviewRating: 0 }">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h4 class="text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">reviews</span>
            Recent Customer Trust
        </h4>
        <div class="flex items-center gap-2">
            <span class="text-sm lg:text-base font-bold">Excellent {{ number_format($avgRating, 1) }}</span>
            <div class="flex text-primary">
                @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[16px] lg:text-[18px]"
                          style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                @endfor
            </div>
        </div>
    </div>

    <div class="flex flex-wrap justify-end gap-3 -mt-2">
        @auth
            @if(auth()->id() !== $store->user_id)
                <button @click="reviewForm = !reviewForm"
                        class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl text-xs lg:text-sm font-bold hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Write Review
                </button>
            @endif
        @else
            <a href="{{ route('login') }}"
               class="flex items-center gap-2 px-4 py-2 bg-primary text-on-primary rounded-xl text-xs lg:text-sm font-bold hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[18px]">login</span>
                Login to Review
            </a>
        @endauth
    </div>

    @auth
        <form x-show="reviewForm" x-cloak
              action="{{ route('stores.review', $store) }}" method="POST"
              class="p-4 lg:p-6 bg-surface-container-low rounded-2xl border border-outline-variant/10 space-y-4"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 -translate-y-2"
              x-transition:enter-end="opacity-100 translate-y-0">
            @csrf
            <p class="text-sm font-bold text-on-surface">Your Rating</p>
            <div class="flex items-center gap-1 mb-4">
                <template x-for="star in 5" :key="star">
                    <button type="button" @click="reviewRating = star"
                            class="text-3xl transition-all hover:scale-110"
                            :class="star <= reviewRating ? 'text-primary' : 'text-outline-variant'">
                        <span class="material-symbols-outlined text-[28px] lg:text-[32px]"
                              :style="'font-variation-settings: \\'FILL\\' ' + (star <= reviewRating ? 1 : 0)">
                            star
                        </span>
                    </button>
                </template>
                <input type="hidden" name="rating" :value="reviewRating">
                <span class="text-sm text-on-surface-variant ml-2" x-show="reviewRating > 0" x-text="reviewRating + ' / 5'"></span>
            </div>
            <div>
                <textarea name="comment" rows="2" placeholder="Share your experience with this store..."
                          class="w-full px-4 py-3 bg-surface-container-lowest border border-outline-variant/30 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 resize-none"></textarea>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-primary text-on-primary rounded-xl text-xs lg:text-sm font-bold hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[18px] align-middle">send</span>
                    Submit Review
                </button>
                <button type="button" @click="reviewForm = false"
                        class="px-5 py-2.5 text-xs lg:text-sm font-bold text-on-surface-variant hover:text-on-surface transition-colors">
                    Cancel
                </button>
            </div>
        </form>
    @endauth

    @if($reviews->count() > 0)
        <div class="flex gap-3 lg:gap-5 overflow-x-auto pb-2 snap-x snap-mandatory no-scrollbar -mx-4 lg:-mx-0 px-4 lg:px-0 max-w-[100vw] lg:max-w-none">
            @foreach($reviews as $review)
                <div class="min-w-[280px] sm:min-w-[320px] lg:min-w-[360px] w-[80vw] sm:w-auto bg-surface-container-lowest p-4 lg:p-6 rounded-2xl shadow-sm border border-outline-variant/10 space-y-3 lg:space-y-4 shrink-0 snap-start">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-8 h-8 lg:w-10 lg:h-10 rounded-full bg-secondary-container flex items-center justify-center font-bold text-primary text-xs lg:text-sm shrink-0">
                                {{ substr($review->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-xs lg:text-sm truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                                <p class="text-[10px] lg:text-[11px] text-on-surface-variant">Verified Purchase</p>
                            </div>
                        </div>
                        <div class="flex text-primary shrink-0">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-[14px] lg:text-[16px]"
                                      style="font-variation-settings: 'FILL' {{ $i <= $review->rating ? 1 : 0 }};">star</span>
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-xs lg:text-sm italic text-on-surface-variant line-clamp-3">"{{ $review->comment }}"</p>
                    @endif
                    <p class="text-[10px] lg:text-[11px] text-on-surface-variant/60 text-right">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 lg:py-12 bg-surface-container-low rounded-2xl border border-outline-variant/10">
            <span class="material-symbols-outlined text-3xl lg:text-4xl text-outline-variant">reviews</span>
            <p class="text-sm font-bold text-on-surface-variant mt-2">No reviews yet</p>
            @auth
                @if(auth()->id() !== $store->user_id)
                    <button @click="reviewForm = true" class="text-sm font-bold text-primary hover:underline mt-1">
                        Be the first to review
                    </button>
                @endif
            @endauth
        </div>
    @endif
</section>

{{-- STORE INFORMATION --}}
<section id="store-info" class="scroll-mt-[80px] lg:scroll-mt-[100px]">
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/10 overflow-hidden shadow-sm">
        <div class="px-4 lg:px-8 py-6 lg:py-8">
            <h4 class="text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2 mb-6 lg:mb-8">
                <span class="material-symbols-outlined text-primary">info</span>
                Store Information
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @if($store->location)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">location_on</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">Location</p>
                            <p class="text-sm font-bold text-on-surface mt-0.5">{{ $store->location }}</p>
                        </div>
                    </div>
                @endif
                @if($store->business_email)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">mail</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">Email</p>
                            <a href="mailto:{{ $store->business_email }}" class="text-sm font-bold text-primary mt-0.5 block truncate hover:underline">
                                {{ $store->business_email }}
                            </a>
                        </div>
                    </div>
                @endif
                @if($store->whatsapp_number)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">chat</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">WhatsApp</p>
                            <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                               class="text-sm font-bold text-primary mt-0.5 block truncate hover:underline">
                                {{ $store->whatsapp_number }}
                            </a>
                        </div>
                    </div>
                @endif
                @if($store->open_hours)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase">Business Hours</p>
                            <p class="text-sm font-bold text-on-surface mt-0.5 whitespace-pre-line">{{ $store->open_hours }}</p>
                        </div>
                    </div>
                @endif
            </div>

            @php
                $socialLinks = $store->social_links ?: [];
            @endphp
            @if(count($socialLinks) > 0)
                <div class="mt-6 lg:mt-8 pt-6 lg:pt-8 border-t border-outline-variant/10">
                    <p class="text-[11px] font-semibold tracking-wider text-on-surface-variant uppercase mb-4">Follow Us</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach($socialLinks as $social)
                            <a href="{{ $social['url'] ?? '#' }}" target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary/5 text-primary rounded-xl text-sm font-bold hover:bg-primary/10 transition-all border border-primary/10">
                                <span class="material-symbols-outlined text-[18px]">
                                    {{ $social['platform'] === 'facebook' ? 'facebook' : ($social['platform'] === 'instagram' ? 'instagram' : ($social['platform'] === 'twitter' ? 'x' : ($social['platform'] === 'linkedin' ? 'linkedin' : ($social['platform'] === 'tiktok' ? 'music_note' : ($social['platform'] === 'youtube' ? 'play_circle' : 'public'))))) }}
                                </span>
                                {{ ucfirst($social['platform'] ?? 'link') }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- FULL CATALOG --}}
<section id="catalog" class="scroll-mt-[80px] lg:scroll-mt-[100px] space-y-4 lg:space-y-6"
         x-data="catalogManager({
             activeCategory: '{{ request('category', 'all') }}',
             activeSort: '{{ request('sort', 'latest') }}',
             storeSlug: '{{ $store->slug }}'
         })">
    <div class="sticky top-[64px] lg:top-[72px] bg-background/95 backdrop-blur-md py-3 lg:py-4 z-30 -mx-4 lg:-mx-0 px-4 lg:px-0">
        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
            <h4 class="text-lg lg:text-[24px] leading-8 font-bold shrink-0">Full Catalog</h4>
            <div class="flex items-center gap-3 overflow-x-auto no-scrollbar flex-1 min-w-0">
                <div class="flex gap-1 bg-surface-container-high rounded-xl p-1 shrink-0">
                    <button @click="switchCategory('all')"
                            :class="activeCategory === 'all' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-primary'"
                            class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-lg text-xs lg:text-sm font-bold transition-all whitespace-nowrap">
                        All
                    </button>
                    @foreach($categories as $cat)
                        <button @click="switchCategory('{{ $cat->slug }}')"
                                :class="activeCategory === '{{ $cat->slug }}' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-primary'"
                                class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-lg text-xs lg:text-sm font-bold transition-all whitespace-nowrap">
                            {{ $cat->name }}
                        </button>
                    @endforeach
                </div>
                <button @click="showSort = !showSort"
                        class="flex items-center gap-1.5 lg:gap-2 px-3 lg:px-4 py-1.5 lg:py-2 border border-outline-variant/30 rounded-xl hover:bg-surface-container transition-colors text-xs lg:text-sm font-bold text-on-surface-variant shrink-0">
                    <span class="material-symbols-outlined text-[18px]">sort</span>
                    Sort
                </button>
            </div>
        </div>
        <div x-show="showSort" x-cloak class="mt-3">
            <div class="flex bg-surface-container-high rounded-xl p-1 gap-1 w-fit">
                <button @click="switchSort('latest')"
                        :class="activeSort === 'latest' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-primary'"
                        class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-lg text-xs lg:text-sm font-bold transition-all whitespace-nowrap">
                    Latest
                </button>
                <button @click="switchSort('price_low')"
                        :class="activeSort === 'price_low' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-primary'"
                        class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-lg text-xs lg:text-sm font-bold transition-all whitespace-nowrap">
                    Low Price
                </button>
                <button @click="switchSort('price_high')"
                        :class="activeSort === 'price_high' ? 'bg-white shadow-sm text-primary' : 'text-on-surface-variant hover:text-primary'"
                        class="px-3 lg:px-4 py-1.5 lg:py-2 rounded-lg text-xs lg:text-sm font-bold transition-all whitespace-nowrap">
                    High Price
                </button>
            </div>
        </div>
    </div>

    <div x-show="loading" x-cloak class="text-center py-12">
        <span class="material-symbols-outlined text-4xl text-primary animate-spin">refresh</span>
    </div>

    <div id="products-container" x-show="!loading">
        @if($products->count() > 0)
            <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 lg:gap-5">
                @foreach($products as $product)
                    <div class="bg-surface-container-lowest rounded-xl lg:rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all border border-outline-variant/10 group relative">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <div class="aspect-square relative overflow-hidden">
                                @if($product->images->first())
                                    <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                         src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="w-full h-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-4xl">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-2 lg:p-4 space-y-0.5 lg:space-y-1">
                                @if($product->category)
                                    <p class="text-[9px] lg:text-[11px] font-semibold text-primary uppercase truncate">{{ $product->category->name }}</p>
                                @endif
                                <h6 class="font-bold text-xs lg:text-base text-on-surface truncate">{{ $product->name }}</h6>
                                <p class="text-sm lg:text-[20px] lg:leading-7 text-primary font-black truncate">{{ number_format($product->price) }} FCFA</p>
                                @if($product->old_price)
                                    <p class="text-[10px] lg:text-xs text-on-surface-variant line-through truncate">{{ number_format($product->old_price) }} FCFA</p>
                                @endif
                            </div>
                        </a>
                        <button class="favorite-btn absolute top-2 right-2 lg:top-3 lg:right-3 w-7 h-7 lg:w-8 lg:h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-10"
                                data-product="{{ $product->id }}"
                                data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                            <span class="material-symbols-outlined text-[16px] lg:text-[20px]"
                                  style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                        </button>
                    </div>
                @endforeach
            </div>
            <div id="products-pagination" class="mt-6">
                {{ $products->links('partials.pagination') }}
            </div>
        @else
            <div id="products-empty" class="text-center py-12 lg:py-16 bg-surface-container-lowest rounded-2xl border border-outline-variant/10">
                <span class="material-symbols-outlined text-4xl lg:text-5xl text-outline-variant">inventory_2</span>
                <p class="text-sm font-bold text-on-surface-variant mt-4">No products listed yet</p>
                @if($store->whatsapp_number)
                    <p class="text-xs lg:text-sm text-on-surface-variant mt-2">Contact the seller for available items</p>
<a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
   class="inline-flex items-center gap-2 mt-4 px-5 py-2.5 bg-[#25D366] text-white rounded-xl text-sm font-bold hover:bg-[#128C7E] transition-all">
    {!! $whatsappIcon !!}
    Contact via WhatsApp
</a>
                @endif
            </div>
        @endif
    </div>
</section>

@endsection

{{-- ==================== FOOTER ==================== --}}
@section('footer')
<footer class="w-full py-8 lg:py-12 bg-surface-container-low flex flex-col items-center justify-center space-y-3 lg:space-y-4 border-t border-outline-variant/30 px-4">
    @if($store->business_email || $store->open_hours)
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
    function catalogManager(config) {
        return {
            activeCategory: config.activeCategory || 'all',
            activeSort: config.activeSort || 'latest',
            storeSlug: config.storeSlug,
            loading: false,
            showSort: false,

            switchCategory(slug) {
                this.activeCategory = slug;
                this.fetchProducts();
            },

            switchSort(sort) {
                this.activeSort = sort;
                this.fetchProducts();
            },

            buildUrl() {
                const url = new URL(window.location.origin + '/store/' + this.storeSlug);
                if (this.activeCategory !== 'all') {
                    url.searchParams.set('category', this.activeCategory);
                }
                if (this.activeSort !== 'latest') {
                    url.searchParams.set('sort', this.activeSort);
                }
                const searchInput = document.querySelector('input[name="search"]');
                if (searchInput && searchInput.value) {
                    url.searchParams.set('search', searchInput.value);
                }
                return url;
            },

            fetchProducts() {
                this.loading = true;
                const url = this.buildUrl();
                fetch(url.toString())
                    .then(r => r.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const container = document.getElementById('products-container');
                        const newGrid = doc.querySelector('#products-grid');
                        const newEmpty = doc.querySelector('#products-empty');
                        if (newGrid) {
                            container.innerHTML = newGrid.outerHTML + (doc.querySelector('#products-pagination') ? doc.querySelector('#products-pagination').outerHTML : '');
                        } else if (newEmpty) {
                            container.innerHTML = newEmpty.outerHTML;
                        }
                        window.history.pushState({}, '', url.toString());
                        this.loading = false;
                    })
                    .catch(() => { this.loading = false; });
            }
        };
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

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.scroll-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const topOffset = 80;
                    const top = target.getBoundingClientRect().top + window.pageYOffset - topOffset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });
    });

    window.addEventListener('popstate', function() {
        const catalogEl = document.getElementById('catalog');
        if (!catalogEl) return;
        const url = new URL(window.location.href);
        if (!url.pathname.startsWith('/store/')) return;
        const data = Alpine.$data(catalogEl);
        data.activeCategory = url.searchParams.get('category') || 'all';
        data.activeSort = url.searchParams.get('sort') || 'latest';
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) searchInput.value = url.searchParams.get('search') || '';
        data.fetchProducts();
    });
</script>
@endsection