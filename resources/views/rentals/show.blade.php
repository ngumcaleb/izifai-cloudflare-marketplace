@extends('layouts.guest')

@push('styles')
<style>
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.8; } }
    @keyframes scalePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .animate-dot-pulse { animation: dotPulse 1.5s ease-in-out infinite; }
    .animate-dot-pulse-delayed { animation: dotPulse 1.5s ease-in-out 0.5s infinite; }
    .animate-dot-pulse-slower { animation: dotPulse 1.5s ease-in-out 1s infinite; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('storeWhatsApp', $store->whatsapp_number)
@php
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
@endphp

@section('title', $rental->name . ' - ' . $store->name . ' Rentals')
@section('description', strip_tags($rental->description) ?: $rental->name . ' on Izifai')
@section('og_title', $rental->name . ' - ' . $store->name)
@section('og_description', str($rental->description ? strip_tags($rental->description) : $rental->name . ' on Izifai')->limit(160))
@section('og_image', $rental->main_image_url ?: asset('images/logo.png'))
@section('og_type', 'product')
@section('twitter_title', $rental->name . ' - ' . $store->name)
@section('twitter_description', str($rental->description ? strip_tags($rental->description) : $rental->name . ' on Izifai')->limit(160))
@section('twitter_image', $rental->main_image_url ?: asset('images/logo.png'))

{{-- STORE NAV --}}
@section('store-nav')
<div class="flex items-center gap-3 py-2.5 overflow-x-auto no-scrollbar">
    <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-1 text-xs font-semibold text-primary hover:underline shrink-0">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        <span class="hidden sm:inline">Back to Store</span>
    </a>
    <span class="w-px h-5 bg-gray-200 shrink-0"></span>
    <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-2.5 shrink-0 group">
        <div class="w-8 h-8 rounded-lg overflow-hidden ring-2 ring-primary/10 bg-white shrink-0">
            @if($store->logo)
                <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
            @else
                <x-store-default-logo :store="$store" size="sm" />
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-sm font-bold text-on-surface truncate max-w-[120px] lg:max-w-none group-hover:text-primary transition-colors">{{ $store->name }}</p>
        </div>
    </a>
    <nav class="flex items-center gap-1 shrink-0">
        <a href="{{ route('stores.show', $store->slug) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-on-primary whitespace-nowrap">Showroom</a>
        <a href="{{ route('stores.show', $store->slug) }}#catalog" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Rentals</a>
        <a href="{{ route('stores.show', $store->slug) }}#reviews" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Reviews</a>
        <a href="{{ route('stores.show', $store->slug) }}#store-info" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Store Info</a>
    </nav>
</div>
@endsection

{{-- STORE SIDEBAR (DESKTOP) --}}
@section('store-sidebar')
<div class="relative h-28 shrink-0">
    @if($store->banner)
        <img src="{{ $store->banner_url }}" class="w-full h-full object-cover">
    @else
        <x-store-default-banner :store="$store" variant="sidebar" />
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
    <div class="absolute -bottom-8 left-4 flex items-end gap-3">
        <div class="w-14 h-14 rounded-xl border-2 border-white bg-white shadow-lg overflow-hidden">
            @if($store->logo)
                <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
            @else
                <x-store-default-logo :store="$store" size="lg" />
            @endif
        </div>
    </div>
</div>
<div class="pt-10 px-4 pb-4 border-b border-gray-100">
    <div class="flex items-center gap-1.5 min-w-0">
        <h2 class="text-base font-bold text-on-surface truncate min-w-0 shrink">{{ $store->name }}</h2>
        <x-store-badge :store="$store" size="sm" />
    </div>
    <div class="flex flex-wrap items-center gap-2 mt-1">
        <span class="flex items-center gap-0.5 text-[11px] text-on-surface-variant">
            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
            {{ number_format($store->rating ?? 0, 1) }}
        </span>
        <span class="text-[11px] text-on-surface-variant">{{ $totalRentals }} rentals</span>
    </div>
</div>
<nav class="flex-1 py-4 px-3 space-y-0.5 overflow-y-auto">
    <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-primary font-semibold bg-primary/5 border-l-[3px] border-primary transition-all text-sm">
        <span class="material-symbols-outlined text-[20px]">storefront</span>
        Showroom
    </a>
    <a href="{{ route('stores.show', $store->slug) }}#catalog" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">grid_view</span>
        Rentals
    </a>
    <a href="{{ route('stores.show', $store->slug) }}#reviews" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">star</span>
        Reviews
    </a>
    <a href="{{ route('stores.show', $store->slug) }}#store-info" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">info</span>
        Store Info
    </a>
    @if($store->location)
        <div class="px-3 py-2 text-[11px] text-on-surface-variant flex items-center gap-2 border-t border-gray-100 pt-3 mt-2">
            <span class="material-symbols-outlined text-[16px]">location_on</span>
            <span class="truncate">{{ $store->location }}</span>
        </div>
    @endif
</nav>
<div class="px-4 py-4 border-t border-gray-100 space-y-2">
    @auth
        @if(auth()->id() !== $store->user_id)
        <form action="{{ route('conversations.store') }}" method="POST" class="w-full">
            @csrf
            <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
            <input type="hidden" name="target_type" value="rental">
            <input type="hidden" name="target_id" value="{{ $rental->id }}">
            <input type="hidden" name="message" value="Hi, I am interested in renting {{ $rental->name }}. Is it available?">
            <button type="submit"
                    class="w-full py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 text-xs text-primary border border-primary/20 hover:bg-primary/5 transition-all">
                <span class="material-symbols-outlined text-[16px]">chat_bubble_outline</span>
                Message
            </button>
        </form>
        @endif
    @endauth
    @if($store->whatsapp_number)
        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I am interested in renting ' . $rental->name . ' on Izifai.') }}" target="_blank"
           class="w-full bg-[#25D366] text-white py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-[#128C7E] transition-all text-xs shadow-sm">
            {!! $whatsappIcon !!}
            WhatsApp
        </a>
    @endif
    <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank"
       class="w-full py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 text-xs text-on-surface-variant border border-gray-200 hover:bg-gray-50 transition-all">
        <span class="material-symbols-outlined text-[16px]">groups</span>
        Join WhatsApp Group
    </a>
    @auth
        @if(auth()->id() === $store->user_id)
            <a href="{{ route('seller.dashboard') }}"
               class="w-full bg-primary text-on-primary py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:opacity-90 transition-all text-xs">
                <span class="material-symbols-outlined text-[16px]">dashboard</span>
                Dashboard
            </a>
        @else
            <a href="{{ route('seller.dashboard') }}"
               class="w-full py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 text-xs text-primary border border-primary/20 hover:bg-primary/5 transition-all">
                <span class="material-symbols-outlined text-[16px]">store</span>
                Start Selling
            </a>
        @endif
    @endauth
    @guest
        <a href="{{ url('/') }}"
           class="w-full bg-primary/10 text-primary py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary/20 transition-all text-xs">
            <span class="material-symbols-outlined text-[16px]">app_registration</span>
            Join Izifai
        </a>
    @endguest
</div>
@endsection

{{-- CONTENT --}}
@section('content')
<div x-data="rentalPage()" class="pb-4 sm:pb-6">

    {{-- ===== MOBILE HERO (lg:hidden) ===== --}}
    <section class="lg:hidden relative min-h-[420px] sm:min-h-[480px] overflow-hidden bg-black">
        <template x-if="selectedImage">
            <img :src="selectedImage" class="absolute inset-0 w-full h-full object-cover">
        </template>
        <template x-if="!selectedImage">
            <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-surface-container-low text-on-surface-variant/30">
                <span class="material-symbols-outlined text-7xl">image</span>
            </div>
        </template>

        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-black/10"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>

        <div class="absolute inset-0 pointer-events-none opacity-[0.04]">
            <div class="absolute top-1/4 left-[20%] w-1 h-1 rounded-full bg-white animate-dot-pulse"></div>
            <div class="absolute top-1/3 left-[60%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
            <div class="absolute top-2/3 left-[30%] w-1 h-1 rounded-full bg-white animate-dot-pulse-slower"></div>
            <div class="absolute bottom-1/4 right-[25%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
        </div>

        {{-- Top bar --}}
        <div class="absolute top-0 left-0 right-0 px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5 text-xs text-white/70">
                    <a href="{{ route('stores.show', $store->slug) }}" class="hover:text-white transition-colors font-semibold truncate">{{ $store->name }}</a>
                    <span class="material-symbols-outlined text-[14px] shrink-0">chevron_right</span>
                    <span class="text-white font-bold truncate">{{ $rental->name }}</span>
                </div>
                <button onclick="copyToClipboard(window.location.href, this)"
                        class="w-8 h-8 bg-white/15 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white/25 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[15px] text-white copy-icon">share</span>
                </button>
            </div>
        </div>

        {{-- Thumbnails --}}
        @if(count($rental->images ?? []) > 0)
        <div class="absolute top-14 left-4 right-4 pointer-events-none">
            <div class="flex gap-1.5 overflow-x-auto no-scrollbar pointer-events-auto">
                @foreach($rental->images_url as $idx => $imgUrl)
                <button @click="selectedImage = '{{ $imgUrl }}'"
                        class="shrink-0 w-9 h-9 rounded-lg overflow-hidden border-2 transition-all relative"
                        :class="selectedImage === '{{ $imgUrl }}' ? 'border-white ring-2 ring-white/40' : 'border-white/30 hover:border-white/60'">
                    <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                    @if($loop->iteration === 4 && count($rental->images) > 4)
                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center rounded-[inherit]">
                        <span class="text-white font-bold text-[8px]">+{{ count($rental->images) - 4 }}</span>
                    </div>
                    @endif
                </button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Overlay content --}}
        <div class="absolute bottom-0 left-0 right-0 px-4 pb-5">
            <div class="max-w-2xl min-w-0">
                <div class="flex flex-wrap items-center gap-1.5 mb-2">
                    @if($store->is_verified)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-white/15 backdrop-blur-sm text-white border border-white/20 uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Verified
                    </span>
                    @endif
                    @if($rental->category)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-white/15 backdrop-blur-sm text-white border border-white/20 uppercase tracking-wider">{{ $rental->category->name }}</span>
                    @endif
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold bg-white/15 backdrop-blur-sm text-white border border-white/20 uppercase tracking-wider">{{ ucfirst($rental->billing_unit) }}</span>
                    @if($rental->rating > 0)
                    <span class="inline-flex items-center gap-0.5 px-2 py-0.5 rounded-full text-[8px] font-bold bg-white/15 backdrop-blur-sm text-white border border-white/20">
                        <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">star</span>
                        {{ number_format($rental->rating, 1) }}
                    </span>
                    @endif
                </div>
                <h1 class="text-xl sm:text-2xl font-black leading-[1.08] text-white text-balance">{{ $rental->name }}</h1>
                <div class="flex flex-wrap items-center gap-2 mt-1.5">
                    @if($rental->location)
                    <span class="inline-flex items-center gap-1 text-[10px] text-white/80">
                        <span class="material-symbols-outlined text-[12px]">location_on</span>
                        <span class="font-semibold">{{ $rental->location }}</span>
                    </span>
                    @endif
                    <span class="inline-flex items-center gap-1 text-[10px] text-white/60">
                        <span class="material-symbols-outlined text-[12px]">visibility</span>
                        <span class="font-semibold">{{ number_format($rental->views ?? 0) }}</span>
                    </span>
                </div>
                <div class="flex items-center justify-between mt-3 pt-3 border-t border-white/15">
                    <div>
                        <div class="text-white">
                            <span class="text-lg font-black">{{ number_format($rental->rate) }}</span>
                            <span class="text-xs font-bold text-white/80"> FCFA</span>
                            <span class="text-[10px] text-white/60">/{{ $rental->billing_unit }}</span>
                        </div>
                        @if($rental->deposit)
                        <div class="flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[10px] text-white/50">security</span>
                            <span class="text-[9px] text-white/70">Deposit: <strong class="text-white/90">{{ number_format($rental->deposit) }} FCFA</strong></span>
                        </div>
                        @endif
                    </div>
                    <div class="flex flex-col sm:flex-row items-stretch gap-1.5 sm:gap-2">
                    @auth
                        @if(auth()->id() !== $store->user_id)
                        <form action="{{ route('conversations.store') }}" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                            <input type="hidden" name="target_type" value="rental">
                            <input type="hidden" name="target_id" value="{{ $rental->id }}">
                            <input type="hidden" name="message" value="Hi, I am interested in renting {{ $rental->name }}. Is it available?">
                            <button type="submit"
                                    class="flex items-center justify-center gap-1.5 w-full py-2.5 px-4 bg-white/20 text-white rounded-xl text-[11px] font-bold hover:bg-white/30 transition-all backdrop-blur-sm whitespace-nowrap">
                                <span class="material-symbols-outlined text-[16px]">chat_bubble_outline</span>
                                Message
                            </button>
                        </form>
                        @endif
                    @endauth
                    @if($store->whatsapp_number)
                    <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I am interested in renting ' . $rental->name . ' on Izifai.') }}"
                       target="_blank"
                       class="flex items-center justify-center gap-2 px-4 py-2.5 bg-[#25D366] text-white rounded-xl text-[11px] font-bold hover:bg-[#128C7E] transition-all shadow-lg shadow-[#25D366]/30 whitespace-nowrap">
                        {!! $whatsappIcon !!}
                        Enquire
                    </a>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== DESKTOP LAYOUT (hidden lg:block) ===== --}}
    <section class="hidden lg:block max-w-7xl mx-auto px-6 lg:px-8 pt-14 lg:pt-4">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-1.5 text-xs sm:text-sm text-on-surface-variant mb-4">
            <a href="{{ route('stores.show', $store->slug) }}" class="hover:text-primary transition-colors font-semibold truncate">{{ $store->name }}</a>
            <span class="material-symbols-outlined text-[14px] sm:text-[16px] shrink-0">chevron_right</span>
            <span class="text-on-surface font-bold truncate">{{ $rental->name }}</span>
            <button onclick="copyToClipboard(window.location.href, this)"
                    class="ml-auto w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center hover:bg-surface-container-high transition-all">
                <span class="material-symbols-outlined text-[16px] text-on-surface-variant copy-icon">share</span>
            </button>
        </div>

        {{-- Image + Info grid --}}
        <div class="grid grid-cols-12 gap-6">
            {{-- Left: Gallery --}}
            <div class="col-span-7 space-y-3">
                <div class="relative bg-surface-container-low rounded-2xl overflow-hidden shadow-sm border border-outline-variant/10 aspect-[16/10]">
                    <template x-if="selectedImage">
                        <img :src="selectedImage" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!selectedImage">
                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                            <span class="material-symbols-outlined text-6xl">image</span>
                        </div>
                    </template>
                </div>
                @if(count($rental->images ?? []) > 0)
                <div class="flex gap-2 overflow-x-auto no-scrollbar pb-0.5">
                    @foreach($rental->images_url as $idx => $imgUrl)
                    <button @click="selectedImage = '{{ $imgUrl }}'"
                            class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg sm:rounded-xl overflow-hidden border-2 transition-all relative"
                            :class="selectedImage === '{{ $imgUrl }}' ? 'border-primary ring-2 ring-primary/20' : 'border-outline-variant/20 hover:border-outline-variant/50'">
                        <img src="{{ $imgUrl }}" class="w-full h-full object-cover">
                        @if($loop->iteration === 4 && count($rental->images) > 4)
                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-[inherit]">
                            <span class="text-white font-bold text-xs sm:text-sm">+{{ count($rental->images) - 4 }}</span>
                        </div>
                        @endif
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Right: Info panel --}}
            <div class="col-span-5">
                <div class="bg-surface-container-lowest rounded-2xl p-6 lg:p-7 shadow-sm border border-outline-variant/10 space-y-5 sticky top-[100px]">
                    {{-- Badges --}}
                    <div class="flex flex-wrap gap-1.5">
                        @if($store->is_verified)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-primary/10 text-primary uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                            Verified
                        </span>
                        @endif
                        @if($rental->category)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-surface-container text-on-surface uppercase tracking-wider">{{ $rental->category->name }}</span>
                        @endif
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-surface-container text-on-surface uppercase tracking-wider">{{ ucfirst($rental->billing_unit) }}</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="text-xl sm:text-2xl lg:text-[28px] leading-tight font-bold text-on-surface">{{ $rental->name }}</h1>

                    {{-- Store --}}
                    <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-outline">store</span>
                        <span class="font-semibold hover:text-primary transition-colors">
                            <a href="{{ route('stores.show', $store->slug) }}">{{ $store->name }}</a>
                        </span>
                        @if($rental->rating > 0)
                        <span class="flex items-center gap-0.5 text-amber-600 ml-1">
                            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="font-bold text-sm">{{ number_format($rental->rating, 1) }}</span>
                        </span>
                        @endif
                    </div>

                    {{-- Location --}}
                    @if($rental->location)
                    <div class="flex items-center gap-2 text-xs sm:text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-outline">location_on</span>
                        <span class="font-semibold">{{ $rental->location }}</span>
                    </div>
                    @endif

                    {{-- Price --}}
                    <div class="pb-3 border-b border-outline-variant/10 space-y-1.5">
                        <div>
                            <span class="text-2xl sm:text-[28px] lg:text-[32px] leading-none font-black text-primary">{{ number_format($rental->rate) }} FCFA</span>
                            <span class="text-sm sm:text-base text-on-surface-variant font-semibold">/{{ $rental->billing_unit }}</span>
                        </div>
                        @if($rental->deposit)
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-on-surface-variant">security</span>
                            <span class="text-xs sm:text-sm text-on-surface-variant">Deposit: <strong>{{ number_format($rental->deposit) }} FCFA</strong></span>
                        </div>
                        @endif
                    </div>

                    {{-- Serial --}}
                    @if($rental->serial_number)
                    <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-outline">qr_code_scanner</span>
                        <span>Serial: <strong>{{ $rental->serial_number }}</strong></span>
                    </div>
                    @endif

                    {{-- Views --}}
                    <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                        <span class="material-symbols-outlined text-[16px] text-outline">visibility</span>
                        <span class="font-semibold">{{ number_format($rental->views ?? 0) }}</span>
                        <span class="text-outline">views</span>
                    </div>

                    {{-- Condition notes --}}
                    @if($rental->condition_notes)
                    <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 sm:p-4">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-[16px] text-amber-600 shrink-0 mt-0.5">info</span>
                            <p class="text-[11px] sm:text-xs text-amber-800 leading-relaxed">{{ $rental->condition_notes }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Actions --}}
                    <div class="space-y-2.5 pt-1">
                        @auth
                            @if(auth()->id() !== $store->user_id)
                            <form action="{{ route('conversations.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                <input type="hidden" name="target_type" value="rental">
                                <input type="hidden" name="target_id" value="{{ $rental->id }}">
                                <input type="hidden" name="message" value="Hi, I am interested in renting {{ $rental->name }}. Is it available?">
                                <button type="submit"
                                        class="flex items-center justify-center gap-2 sm:gap-3 w-full py-3 sm:py-3.5 bg-primary text-on-primary rounded-xl text-xs sm:text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">chat_bubble_outline</span>
                                    Message
                                </button>
                            </form>
                            @endif
                        @endauth
                        @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I am interested in renting ' . $rental->name . ' on Izifai.') }}"
                           target="_blank"
                           class="flex items-center justify-center gap-2 sm:gap-3 w-full py-3 sm:py-3.5 bg-[#25D366] text-white rounded-xl text-xs sm:text-sm font-bold hover:bg-[#128C7E] transition-all shadow-lg shadow-[#25D366]/20">
                            {!! $whatsappIcon !!}
                            Enquire on WhatsApp
                        </a>
                        @endif
                        <a href="{{ route('stores.show', $store->slug) }}"
                           class="flex items-center justify-center gap-2 w-full py-2.5 sm:py-3 bg-surface-container-high text-on-surface rounded-xl text-xs sm:text-sm font-bold hover:bg-surface-container-highest transition-all">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px]">store</span>
                            Browse Store
                        </a>
                        <button onclick="copyToClipboard(window.location.href, this)"
                                class="flex items-center justify-center gap-2 w-full py-2 sm:py-2.5 border border-outline-variant/30 text-on-surface-variant rounded-xl text-[11px] sm:text-xs font-bold hover:bg-surface-container transition-all">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px] copy-icon">share</span>
                            <span class="copy-label">Share Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONDITION NOTES BANNER (mobile only; desktop shows inside info panel) --}}
    @if($rental->condition_notes)
    <div class="lg:hidden max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-amber-50/90 backdrop-blur-sm border border-amber-200/50 rounded-xl sm:rounded-2xl p-3 sm:p-4 shadow-sm">
            <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-[16px] sm:text-[18px] text-amber-600 shrink-0 mt-0.5">info</span>
                <p class="text-[11px] sm:text-sm text-amber-800 leading-relaxed">{{ $rental->condition_notes }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- MAIN CONTENT BELOW HERO --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-8 lg:mt-12 space-y-6 sm:space-y-8 lg:space-y-12">

        {{-- DESCRIPTION --}}
        @if($rental->description)
        <section>
            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-primary/[0.06] flex items-center justify-center border border-primary/10">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">description</span>
                </span>
                <h2 class="text-sm sm:text-base font-bold text-on-surface">About This Rental</h2>
            </div>
            <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:p-8 shadow-sm border border-outline-variant/10">
                <div class="text-xs sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $rental->description }}</div>
            </div>
        </section>
        @endif

        {{-- RENTAL DETAILS --}}
        @if($rental->return_conditions || $rental->duration_rules)
        <section>
            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-primary/[0.06] flex items-center justify-center border border-primary/10">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">assignment</span>
                </span>
                <h2 class="text-sm sm:text-base font-bold text-on-surface">Rental Terms</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                @if($rental->return_conditions)
                <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-outline-variant/10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-primary text-[16px] sm:text-[18px]">assignment_return</span>
                        <h3 class="text-xs sm:text-sm font-bold text-on-surface">Return Conditions</h3>
                    </div>
                    <p class="text-[11px] sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $rental->return_conditions }}</p>
                </div>
                @endif
                @if($rental->duration_rules)
                <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-6 shadow-sm border border-outline-variant/10">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-primary text-[16px] sm:text-[18px]">schedule</span>
                        <h3 class="text-xs sm:text-sm font-bold text-on-surface">Duration Rules</h3>
                    </div>
                    <p class="text-[11px] sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $rental->duration_rules }}</p>
                </div>
                @endif
            </div>
        </section>
        @endif

        {{-- TRUST & SOCIAL ROW --}}
        <section>
            <div class="flex items-center gap-2 mb-3 sm:mb-4">
                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-primary/[0.06] flex items-center justify-center border border-primary/10">
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">verified_user</span>
                </span>
                <h2 class="text-sm sm:text-base font-bold text-on-surface">Trust & Assurance</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 sm:gap-4">
                @php $socialLinks = $store->social_links ?: []; @endphp

                <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm border border-outline-variant/10 flex flex-col items-center justify-center gap-2 sm:gap-3">
                    <p class="text-[10px] sm:text-xs font-bold text-on-surface-variant uppercase tracking-wider">Connect With Us</p>
                    <div class="flex flex-wrap justify-center gap-1.5 sm:gap-2">
                        @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hello, I found you on Izifai.') }}" target="_blank"
                           class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all" title="WhatsApp">
                            <svg viewBox="0 0 24 24" fill="currentColor" class="w-[14px] h-[14px] sm:w-[18px] sm:h-[18px]" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        @endif
                        @foreach($socialLinks as $social)
                            @php
                                $url = $social['url'] ?? '';
                                $platform = $social['platform'] ?? '';
                                if (!$url) continue;
                                $icon = match($platform) {
                                    'facebook' => ['icon' => 'facebook', 'bg' => 'bg-blue-50', 'color' => 'text-blue-600', 'hover' => 'hover:bg-blue-600 hover:text-white'],
                                    'instagram' => ['icon' => 'camera_alt', 'bg' => 'bg-pink-50', 'color' => 'text-pink-600', 'hover' => 'hover:bg-pink-600 hover:text-white'],
                                    'twitter' => ['icon' => 'alternate_email', 'bg' => 'bg-sky-50', 'color' => 'text-sky-600', 'hover' => 'hover:bg-sky-600 hover:text-white'],
                                    'linkedin' => ['icon' => 'work', 'bg' => 'bg-blue-50', 'color' => 'text-blue-700', 'hover' => 'hover:bg-blue-700 hover:text-white'],
                                    'tiktok' => ['icon' => 'music_note', 'bg' => 'bg-gray-50', 'color' => 'text-gray-800', 'hover' => 'hover:bg-gray-800 hover:text-white'],
                                    'youtube' => ['icon' => 'play_circle', 'bg' => 'bg-red-50', 'color' => 'text-red-600', 'hover' => 'hover:bg-red-600 hover:text-white'],
                                    'whatsapp_group' => ['icon' => 'groups', 'bg' => 'bg-green-50', 'color' => 'text-green-600', 'hover' => 'hover:bg-green-600 hover:text-white'],
                                    default => ['icon' => 'public', 'bg' => 'bg-surface-container', 'color' => 'text-on-surface-variant', 'hover' => 'hover:bg-primary/10 hover:text-primary'],
                                };
                            @endphp
                            <a href="{{ $url }}" target="_blank"
                               class="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center {{ $icon['bg'] }} {{ $icon['color'] }} {{ $icon['hover'] }} transition-all"
                               title="{{ ucfirst(str_replace('_', ' ', $platform)) }}">
                                <span class="material-symbols-outlined text-[14px] sm:text-[18px]">{{ $icon['icon'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-8 bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm border border-outline-variant/10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 divide-y sm:divide-y-0 sm:divide-x divide-outline-variant/10">
                        <div class="flex items-start gap-3 flex-1 pb-4 sm:pb-0 sm:pr-6">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-[18px] sm:text-[20px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-on-surface">Premium Assurance</p>
                                <p class="text-[10px] sm:text-xs text-on-surface-variant">Verified merchant with trusted quality</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 flex-1 pt-4 sm:pt-0 sm:pl-6">
                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <span class="material-symbols-outlined text-[18px] sm:text-[20px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs sm:text-sm font-bold text-on-surface">{{ $store->location ? explode(',', $store->location)[0] . ' Rentals' : 'Douala & Yaoundé Rentals' }}</p>
                                <p class="text-[10px] sm:text-xs text-on-surface-variant">Quality rental items available in {{ $store->location ? $store->location : "Cameroon's major cities" }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- OTHER RENTALS IN STORE --}}
        @if($storeRentals->count() > 0)
        <section class="space-y-3 sm:space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-primary/[0.06] flex items-center justify-center border border-primary/10">
                        <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">grid_view</span>
                    </span>
                    <h4 class="text-sm sm:text-base font-bold text-on-surface">More from {{ $store->name }}</h4>
                </div>
                <a href="{{ route('stores.show', $store->slug) }}" class="text-[10px] sm:text-xs font-semibold text-primary hover:underline">View all</a>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 lg:gap-4">
                @foreach($storeRentals as $sr)
                <a href="{{ route('rentals.show', $sr->slug) }}"
                   class="bg-surface-container-lowest rounded-lg sm:rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-outline-variant/10 group">
                    <div class="aspect-[4/3] overflow-hidden bg-surface-container-high">
                        @if($sr->main_image_url)
                        <img src="{{ $sr->main_image_url }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             alt="{{ $sr->name }}">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                            <span class="material-symbols-outlined text-2xl sm:text-3xl">image</span>
                        </div>
                        @endif
                    </div>
                    <div class="p-1.5 sm:p-2 space-y-0.5">
                        <h6 class="text-[10px] sm:text-xs font-bold text-on-surface truncate">{{ $sr->name }}</h6>
                        <p class="text-[10px] sm:text-xs font-bold text-primary truncate">{{ number_format($sr->rate) }} FCFA / {{ $sr->billing_unit }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>
@endsection

{{-- FOOTER --}}
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
    <div class="font-bold text-xs lg:text-sm text-on-surface text-center">{{ $store->name }} — IZIFAI Rentals</div>
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
    function rentalPage() {
        return {
            selectedImage: @js($rental->main_image_url ?? $rental->images_url[0] ?? ''),
        }
    }
</script>
@endsection
