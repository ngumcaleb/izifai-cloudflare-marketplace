@extends('layouts.guest')

@section('storeWhatsApp', $service->store->whatsapp_number)
@php
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
@endphp

@section('title', $service->name . ' - ' . $store->name . ' Services')
@section('description', strip_tags($service->description) ?: $service->name . ' on Izifai')
@section('og_title', $service->name . ' - ' . $store->name)
@section('og_description', str($service->description ? strip_tags($service->description) : $service->name . ' on Izifai')->limit(160))
@section('og_image', $service->main_image_url ?: asset('images/logo.png'))
@section('og_type', 'service')
@section('twitter_title', $service->name . ' - ' . $store->name)
@section('twitter_description', str($service->description ? strip_tags($service->description) : $service->name . ' on Izifai')->limit(160))
@section('twitter_image', $service->main_image_url ?: asset('images/logo.png'))

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
        <a href="{{ route('stores.show', $store->slug) }}#catalog" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Services</a>
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
            {{ number_format($avgRating, 1) }}
        </span>
        <span class="text-[11px] text-on-surface-variant">{{ $store->services()->count() }} services</span>
    </div>
</div>
<nav class="flex-1 py-4 px-3 space-y-0.5 overflow-y-auto">
    <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-primary font-semibold bg-primary/5 border-l-[3px] border-primary transition-all text-sm">
        <span class="material-symbols-outlined text-[20px]">storefront</span>
        Showroom
    </a>
    <a href="{{ route('stores.show', $store->slug) }}#catalog" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">grid_view</span>
        Services
    </a>
    <a href="{{ route('stores.show', $store->slug) }}#reviews" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">star</span>
        Reviews
        @if($totalReviews > 0)
            <span class="ml-auto text-[10px] font-bold bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $totalReviews }}</span>
        @endif
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
            <input type="hidden" name="target_type" value="service">
            <input type="hidden" name="target_id" value="{{ $service->id }}">
            <input type="hidden" name="message" value="Hi, I am interested in {{ $service->name }}. Is it still available?">
            <button type="submit"
                    class="w-full py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 text-xs text-primary border border-primary/20 hover:bg-primary/5 transition-all">
                <span class="material-symbols-outlined text-[16px]">chat_bubble_outline</span>
                Message
            </button>
        </form>
        @endif
    @endauth
    @if($store->whatsapp_number)
        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I am interested in ' . $service->name . ' on Izifai.') }}" target="_blank"
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
<div class="px-4 sm:px-6 lg:px-8 pt-14 lg:pt-4 pb-4 sm:pb-6">
<div x-data="servicePage()" class="space-y-6 sm:space-y-8 lg:space-y-12">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-xs sm:text-sm text-on-surface-variant min-w-0">
        <a href="{{ route('stores.show', $store->slug) }}" class="hover:text-primary transition-colors font-semibold truncate whitespace-nowrap">{{ $store->name }}</a>
        <span class="material-symbols-outlined text-[14px] sm:text-[16px] shrink-0">chevron_right</span>
        <span class="text-on-surface font-bold truncate whitespace-nowrap">{{ $service->name }}</span>
    </div>

    {{-- SERVICE HERO --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8">

        {{-- LEFT: Gallery --}}
        <div class="lg:col-span-7 space-y-3 sm:space-y-4">
            <div class="relative bg-surface-container-lowest rounded-xl sm:rounded-2xl overflow-hidden shadow-sm border border-outline-variant/10 aspect-[16/9]">
                <template x-if="selectedImage">
                    <img :src="selectedImage" class="w-full h-full object-cover">
                </template>
                <template x-if="!selectedImage">
                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                        <span class="material-symbols-outlined text-6xl">image</span>
                    </div>
                </template>
                <button onclick="copyToClipboard(window.location.href, this)"
                        class="absolute top-3 right-3 w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10">
                    <span class="material-symbols-outlined text-[16px] copy-icon text-on-surface-variant">share</span>
                </button>
            </div>

            @if($service->images->count() > 0)
            <div class="flex gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-0.5">
                @foreach($service->images as $idx => $img)
                <button @click="selectedImage = '{{ $img->url }}'"
                        class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg sm:rounded-xl overflow-hidden border-2 transition-all relative"
                        :class="selectedImage === '{{ $img->url }}' ? 'border-primary ring-2 ring-primary/20' : 'border-outline-variant/20 hover:border-outline-variant/50'">
                    <img src="{{ $img->url }}" class="w-full h-full object-cover">
                    @if($loop->iteration === 4 && $service->images->count() > 4)
                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center rounded-[inherit]">
                        <span class="text-white font-bold text-xs sm:text-sm">+{{ $service->images->count() - 4 }}</span>
                    </div>
                    @endif
                </button>
                @endforeach
            </div>
            @endif
        </div>

        {{-- RIGHT: Service Info --}}
        <div class="lg:col-span-5">
            <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 shadow-sm border border-outline-variant/10 space-y-4 sm:space-y-5 sticky top-[80px] lg:top-[100px]">

                {{-- Badges --}}
                <div class="flex flex-wrap gap-1.5 sm:gap-2">
                    @if($store->is_verified)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-primary/10 text-primary uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Verified Authentic
                    </span>
                    @endif
                    @if($service->category)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[9px] sm:text-[10px] font-bold bg-surface-container text-on-surface uppercase tracking-wider">
                        {{ $service->category->name }}
                    </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="text-xl sm:text-2xl lg:text-[28px] leading-tight font-bold text-on-surface">{{ $service->name }}</h1>

                {{-- Star Rating --}}
                <div class="flex items-center gap-2">
                    <div class="flex text-amber-500">
                        @for($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-[16px] sm:text-[18px]"
                              style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                        @endfor
                    </div>
                    <span class="text-xs sm:text-sm font-bold text-on-surface">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-xs sm:text-sm text-on-surface-variant">({{ $totalReviews }} reviews)</span>
                </div>

                {{-- Price --}}
                <div class="pb-2 border-b border-outline-variant/10">
                    <span class="text-2xl sm:text-[28px] lg:text-[32px] leading-none font-black text-primary">From {{ number_format($service->starting_price) }} FCFA</span>
                    @if($service->delivery_time)
                    <div class="flex items-center gap-2 mt-1.5">
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant">schedule</span>
                        <span class="text-xs sm:text-sm text-on-surface-variant">{{ $service->delivery_time }}</span>
                    </div>
                    @endif
                </div>

                {{-- Packages --}}
                @if($service->packages->count() > 0)
                <div>
                    <p class="text-[10px] sm:text-xs font-bold text-on-surface-variant uppercase tracking-wider mb-2 sm:mb-3">Service Packages</p>
                    <div class="space-y-2 sm:space-y-3">
                        @foreach($service->packages as $pkg)
                        <div class="flex items-start gap-3 p-3 sm:p-4 rounded-xl bg-surface-container border border-outline-variant/10 hover:border-primary/20 transition-all cursor-pointer"
                             :class="selectedPackage === {{ $pkg->id }} ? 'border-primary/30 bg-primary/[0.03]' : ''"
                             @click="selectedPackage = {{ $pkg->id }}">
                            <div class="w-4 h-4 mt-0.5 rounded-full border-2 shrink-0 flex items-center justify-center"
                                 :class="selectedPackage === {{ $pkg->id }} ? 'border-primary' : 'border-gray-300'">
                                <div x-show="selectedPackage === {{ $pkg->id }}" class="w-2 h-2 rounded-full bg-primary"></div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-2">
                                    <h4 class="text-xs sm:text-sm font-bold text-on-surface">{{ $pkg->name }}</h4>
                                    <span class="text-sm font-black text-primary shrink-0">{{ number_format($pkg->price) }} FCFA</span>
                                </div>
                                @if($pkg->description)
                                <p class="text-[10px] sm:text-xs text-on-surface-variant mt-0.5">{{ $pkg->description }}</p>
                                @endif
                                @if($pkg->delivery_time)
                                <div class="flex items-center gap-1 mt-1 text-[9px] sm:text-[10px] text-on-surface-variant/60">
                                    <span class="material-symbols-outlined text-[12px]">schedule</span>
                                    {{ $pkg->delivery_time }}
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Views --}}
                <div class="flex items-center gap-2 text-xs text-on-surface-variant">
                    <span class="material-symbols-outlined text-[16px] text-outline">visibility</span>
                    <span class="font-semibold">{{ number_format($service->views ?? 0) }}</span>
                    <span class="text-outline">views</span>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-2.5 sm:space-y-3 pt-1 sm:pt-2">
                    @auth
                        @if(auth()->id() !== $store->user_id)
                        <form action="{{ route('conversations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                            <input type="hidden" name="target_type" value="service">
                            <input type="hidden" name="target_id" value="{{ $service->id }}">
                            <input type="hidden" name="message" value="Hi, I am interested in {{ $service->name }}. Is it still available?">
                            <button type="submit"
                                    class="flex items-center justify-center gap-2 sm:gap-3 w-full py-3 sm:py-3.5 bg-primary text-on-primary rounded-xl text-xs sm:text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/20">
                                <span class="material-symbols-outlined text-[16px] sm:text-[18px]">chat_bubble_outline</span>
                                Message
                            </button>
                        </form>
                        @endif
                    @endauth
                    @if($store->whatsapp_number)
                    <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I am interested in ' . $service->name . ' on Izifai.') }}"
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

    {{-- DESCRIPTION --}}
    @if($service->description)
    <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-5 sm:p-6 lg:p-8 shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2 mb-3 sm:mb-4">
            <span class="material-symbols-outlined text-primary text-[18px] sm:text-[20px]">description</span>
            <h2 class="text-sm sm:text-base font-bold text-on-surface">Description</h2>
        </div>
        <div class="text-xs sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-wrap">{{ $service->description }}</div>
    </div>
    @endif

    {{-- TRUST & SOCIAL ROW --}}
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
                        <span class="material-symbols-outlined text-[18px] sm:text-[20px]" style="font-variation-settings: 'FILL' 1;">handyman</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-bold text-on-surface">{{ $store->location ? explode(',', $store->location)[0] . ' Professional Services' : 'Douala & Yaoundé Services' }}</p>
                        <p class="text-[10px] sm:text-xs text-on-surface-variant">Professional services delivered in {{ $store->location ? $store->location : "Cameroon's major cities" }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CUSTOMER REVIEWS --}}
    @if($reviews->count() > 0)
    <section id="reviews" class="scroll-mt-[80px] lg:scroll-mt-[100px] space-y-4">
        <div class="flex items-center justify-between">
            <h4 class="text-base sm:text-lg lg:text-[24px] leading-8 font-bold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-[18px] sm:text-[20px]">reviews</span>
                Customer Reviews
            </h4>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="text-xs sm:text-sm font-bold">{{ number_format($avgRating, 1) }}</span>
                <div class="flex text-amber-500">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]"
                          style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Star Distribution --}}
        @if(isset($starDistribution))
        <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm border border-outline-variant/10">
            @foreach($starDistribution as $star => $data)
            <div class="flex items-center gap-2 sm:gap-3 py-1 sm:py-1.5">
                <span class="text-[11px] sm:text-xs font-bold text-on-surface w-3 sm:w-4 text-right">{{ $star }}</span>
                <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>
                <div class="flex-1 h-2 sm:h-2.5 rounded-full bg-surface-container overflow-hidden">
                    <div class="h-full rounded-full bg-amber-500" style="width: {{ $data['percentage'] }}%"></div>
                </div>
                <span class="text-[10px] sm:text-xs text-on-surface-variant w-8 text-right">{{ $data['count'] }}</span>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Review Cards --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
            @foreach($reviews as $review)
            <div class="bg-surface-container-lowest rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm border border-outline-variant/10">
                <div class="flex items-center gap-2 sm:gap-3 mb-2 sm:mb-3">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-secondary-container flex items-center justify-center font-bold text-primary text-[10px] sm:text-sm shrink-0">
                        {{ substr($review->user->name ?? 'A', 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-bold truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                        <p class="text-[9px] sm:text-[10px] text-on-surface-variant">Verified Customer</p>
                    </div>
                </div>
                <div class="flex text-amber-500 mb-1.5 sm:mb-2">
                    @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[14px] sm:text-[16px]"
                          style="font-variation-settings: 'FILL' {{ $i <= $review->rating ? 1 : 0 }};">star</span>
                    @endfor
                </div>
                @if($review->comment)
                <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">"{{ $review->comment }}"</p>
                @endif
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- OTHER SERVICES IN STORE --}}
    @if($storeServices->count() > 0)
    <section class="space-y-3 sm:space-y-4">
        <h4 class="text-base sm:text-lg lg:text-[24px] leading-8 font-bold">Other Services from {{ $store->name }}</h4>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 lg:gap-4">
            @foreach($storeServices as $sp)
            <a href="{{ route('services.show', $sp->slug) }}"
               class="bg-surface-container-lowest rounded-lg sm:rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all border border-outline-variant/10 group">
                <div class="aspect-[4/3] overflow-hidden bg-surface-container-high">
                    @if($sp->main_image_url)
                    <img src="{{ $sp->main_image_url }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         alt="{{ $sp->name }}">
                    @else
                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                        <span class="material-symbols-outlined text-2xl sm:text-3xl">image</span>
                    </div>
                    @endif
                </div>
                <div class="p-1.5 sm:p-2 space-y-0.5">
                    <h6 class="text-[10px] sm:text-xs font-bold text-on-surface truncate">{{ $sp->name }}</h6>
                    <p class="text-[10px] sm:text-xs font-bold text-primary truncate">From {{ number_format($sp->starting_price) }} FCFA</p>
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
    <div class="font-bold text-xs lg:text-sm text-on-surface text-center">{{ $store->name }} — IZIFAI Services</div>
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
    function servicePage() {
        return {
            selectedImage: @js($service->main_image_url ?? $service->images->first()?->url ?? ''),
            selectedPackage: @js($service->packages->first()?->id ?? null),
        }
    }
</script>
@endsection
