@extends('layouts.guest')

@section('storeWhatsApp', $store->whatsapp_number)
@section('title', $store->name . ' - Izifai Showroom')
@section('description', $store->description ? strip_tags($store->description) : $store->name . ' on Izifai')
@php
$ogStoreImage = $store->logo ? url('/r2/' . ltrim($store->logo, '/')) : ($store->banner ? url('/r2/' . ltrim($store->banner, '/')) : null);
if (!$ogStoreImage && $store->products->count() > 0) {
    $firstImg = $store->products->first()->images->first();
    $ogStoreImage = $firstImg?->url;
}
$ogStoreImage = $ogStoreImage ?: asset('images/logo.png');
@endphp
@section('og_title', $store->name . ' — Izifai Showroom')
@section('og_description', $store->description ? str(strip_tags($store->description))->limit(160) : 'Browse products from ' . $store->name . ' on Izifai. Shop from verified sellers in Cameroon.')
@section('og_image', $ogStoreImage)
@section('og_type', 'profile')
@section('twitter_title', $store->name . ' — Izifai Showroom')
@section('twitter_description', $store->description ? str(strip_tags($store->description))->limit(160) : 'Browse products from ' . $store->name . ' on Izifai.')
@section('twitter_image', $ogStoreImage)

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }
    .tnum { font-variant-numeric: tabular-nums; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.8; } }
    @keyframes scalePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .animate-dot-pulse { animation: dotPulse 1.5s ease-in-out infinite; }
    .animate-dot-pulse-delayed { animation: dotPulse 1.5s ease-in-out 0.5s infinite; }
    .animate-dot-pulse-slower { animation: dotPulse 1.5s ease-in-out 1s infinite; }
    .animate-scale-pulse { animation: scalePulse 2s ease-in-out infinite; }
</style>
@endpush

@php
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
@endphp

@section('content')
<div class="pb-16 sm:pb-24">

    {{-- ================================================================
         1. HERO — Full-Bleed Cover That Fades Into the Page (Storefront)
    ================================================================ --}}
    @php $heroProductThumbs = $topProducts->take(4); @endphp
    <header id="showroom" class="relative scroll-mt-[120px]">
        {{-- Cover : full-width image, no card, fades down into the white page --}}
        <div class="relative w-full h-44 sm:h-60 lg:h-72 overflow-hidden bg-[#1c201e]">
            @if($store->banner_url)
                <img src="{{ $store->banner_url }}" alt="{{ $store->name }}" loading="lazy"
                     class="absolute inset-0 w-full h-full object-cover" onerror="this.classList.add('hidden')">
            @else
                {{-- Default marketplace cover fallback --}}
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600&q=80&auto=format&fit=crop"
                     alt="" loading="lazy"
                     class="absolute inset-0 w-full h-full object-cover" onerror="this.classList.add('hidden')">
            @endif

            {{-- Bottom fade : merge the cover into the page background --}}
            <div class="absolute inset-x-0 bottom-0 h-[70%] sm:h-[45%] bg-gradient-to-t from-[#f5f6f5] to-[#f5f6f5]/0 pointer-events-none"></div>
        </div>

        {{-- Identity below the cover : logo first, then text --}}
        <div class="max-w-7xl mx-auto px-3 sm:px-6">
            <div class="relative z-10 -mt-10 sm:-mt-14 flex flex-col sm:flex-row items-start sm:items-end gap-3 sm:gap-5 min-w-0">
                <div class="w-20 h-20 sm:w-28 sm:h-28 rounded-full sm:rounded-3xl bg-white p-1.5 sm:p-2 ring-1 ring-black/5 shadow-[0_14px_36px_-12px_rgba(0,0,0,0.35)] shrink-0 overflow-hidden">
                    @if($store->logo)
                        <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover rounded-full sm:rounded-2xl">
                    @else
                        <x-store-default-logo :store="$store" size="md" class="w-full h-full" />
                    @endif
                </div>

                <div class="min-w-0 text-left">
                    <div class="flex items-center justify-start gap-2 flex-wrap">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-[#1c201e] leading-tight">{{ $store->name }}</h1>
                        @if($store->is_verified)
                            <i class="fa-solid fa-circle-check text-[18px] sm:text-xl text-[#7ca81d] shrink-0" style=""></i>
                        @endif
                    </div>

                    <div class="mt-1.5 flex flex-wrap items-center justify-start gap-x-3 gap-y-1 text-[11.5px] sm:text-xs font-semibold text-[#6b716c]">
                        <span class="inline-flex items-center gap-1 font-bold text-[#3f453f] tnum">
                            <i class="fa-solid fa-star text-[13px] text-amber-400" style=""></i>
                            {{ number_format($avgRating, 1) }}
                            <span class="font-semibold text-[#9aa19c] text-[10.5px] sm:text-[11.5px]">({{ $totalReviews }} reviews)</span>
                        </span>
                        @if($store->location)
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-[12px] text-[#7ca81d]" style=""></i>{{ $store->location }}
                            </span>
                        @endif
                        @if($joinedDate)
                            <span class="inline-flex items-center gap-1">
                                <i class="fa-solid fa-calendar-days text-[12px] text-[#7ca81d]" style=""></i>Since {{ date('Y', strtotime($joinedDate)) }}
                            </span>
                        @endif
                    </div>

                    @if($store->description)
                        <p class="mt-3 text-xs sm:text-sm text-[#3f453f] leading-relaxed max-w-2xl">{{ $store->description }}</p>
                    @endif

                    {{-- Highlights / Quick Stats --}}
                    <div class="mt-3.5 flex flex-wrap items-center justify-start gap-x-4 gap-y-2 text-[10.5px] sm:text-xs font-semibold text-[#6b716c]">
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-boxes-stacked text-[14px] text-[#7ca81d]" style=""></i>
                            <strong class="text-[#3f453f] tnum">{{ $totalItems }}</strong> items live
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <i class="fa-solid fa-users text-[14px] text-[#7ca81d]" style=""></i>
                            <strong class="text-[#3f453f] tnum">{{ number_format($store->follower_count ?? 0) }}</strong> followers
                        </span>
                        @if($heroProductThumbs->count() > 0)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="flex -space-x-2 sm:-space-x-2.5">
                                @foreach($heroProductThumbs as $p)
                                    <a href="{{ route('products.show', $p->slug) }}" class="w-6 h-6 sm:w-7 sm:h-7 rounded-full border-2 border-[#f5f6f5] overflow-hidden bg-white hover:z-10 relative transition-transform hover:scale-110">
                                        @if($p->images->first())
                                            <img src="{{ $p->images->first()->url }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <div class="w-full h-full bg-[#f5f6f5] flex items-center justify-center"><i class="fa-solid fa-image text-[8px] text-[#1c201e]/40"></i></div>
                                        @endif
                                    </a>
                                @endforeach
                            </span>
                            <span>Top picks</span>
                        </span>
                        @endif
                    </div>

                    {{-- CTAs + Store Search --}}
                    <div class="mt-4 sm:mt-5" x-data="{ storeSearch: {{ request('search') ? 'true' : 'false' }} }">
                        <div class="flex flex-wrap items-center justify-start gap-2">
                            <button @click="storeSearch = !storeSearch"
                                    class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 bg-[#f2f9df] text-[#659316] rounded-xl text-[12px] sm:text-[13px] font-bold border border-[#9acd32]/30 hover:border-[#7ca81d] active:scale-[0.97] transition-all duration-200">
                                <i class="fa-solid fa-magnifying-glass text-[14px] sm:text-[15px]"></i>
                                <span>Search</span>
                                @if(request('search'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#659316] animate-pulse"></span>
                                @endif
                            </button>
                            @if($store->whatsapp_number)
                                <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi ' . $store->name . ', I saw your store on Izifai!') }}" target="_blank"
                                   class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-[#25D366] text-white rounded-xl text-[12px] sm:text-[13px] font-bold hover:bg-[#128C7E] active:scale-[0.97] transition-all duration-200 shadow-md">
                                    {!! $whatsappIcon !!}
                                    WhatsApp
                                </a>
                            @endif
                            @auth
                                @if(auth()->id() !== $store->user_id)
                                <form action="{{ route('conversations.store') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                    <input type="hidden" name="target_type" value="store">
                                    <input type="hidden" name="target_id" value="{{ $store->id }}">
                                    <input type="hidden" name="message" value="Hi, I am interested in {{ $store->name }} on Izifai.">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-[#1c201e] rounded-xl text-[12px] sm:text-[13px] font-bold border border-[#1c201e] hover:bg-[#1c201e] hover:text-[#9acd32] active:scale-[0.97] transition-all duration-200">
                                        <i class="fa-regular fa-comment text-[15px] sm:text-[16px]"></i>
                                        Message
                                    </button>
                                </form>
                                @endif
                            @endauth
                            <button onclick="copyToClipboard(window.location.href, this, 'Done!')"
                                    class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-white text-[#1c201e] rounded-xl text-[12px] sm:text-[13px] font-bold border border-[#e8eae8] hover:border-[#1c201e] active:scale-[0.97] transition-all duration-200">
                                <i class="fa-solid fa-share-nodes text-[15px] sm:text-[16px] copy-icon"></i>
                                <span class="copy-label">Share</span>
                            </button>
                        </div>

                        {{-- Collapsible Store Search --}}
                        <div x-show="storeSearch" x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="mt-3 max-w-lg">
                            <form method="GET" action="{{ route('stores.show', $store->slug) }}#catalog" class="flex items-center gap-2 bg-white border border-[#e0e3e0] rounded-xl px-3 h-11 shadow-sm focus-within:border-[#9acd32] focus-within:ring-2 focus-within:ring-[#9acd32]/15 transition-all">
                                @foreach(request()->only(['category', 'sort']) as $k => $v)
                                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                                @endforeach
                                <i class="fa-solid fa-magnifying-glass text-[16px] text-[#9aa19c]"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search {{ $store->name }}..."
                                       class="w-full bg-transparent text-[12px] sm:text-xs font-semibold text-[#1c201e] placeholder:text-[#9aa19c] outline-none" x-ref="storeSearchInput" x-init="$watch('storeSearch', v => { if(v) setTimeout(() => $refs.storeSearchInput.focus(), 100) })">
                                @if(request('search'))
                                    <a href="{{ route('stores.show', $store->slug) }}?category={{ request('category') }}&sort={{ request('sort') }}#catalog" class="text-[#9aa19c] hover:text-[#1c201e] shrink-0">
                                        <i class="fa-solid fa-xmark text-[16px]"></i>
                                    </a>
                                @endif
                                <button type="submit" class="shrink-0 h-8 px-3 sm:px-4 rounded-lg bg-[#1c201e] text-[#9acd32] text-[11px] sm:text-xs font-bold hover:bg-[#2a2f2b] transition-colors">Search</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ================================================================
         1.5. CATALOG TABS (Products | Services | Rentals) — Switchable
    ================================================================ --}}
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-5 sm:mt-6" x-data="{ activeTab: 'products' }">
        {{-- Sticky segmented tab bar: hooks just below the fixed layout header --}}
        <div class="sticky top-14 sm:top-[144px] z-30 -mx-2 sm:mx-0 py-1.5 sm:py-2 bg-[#f5f6f5]/95 backdrop-blur-sm border-b border-[#eff1ef]">
            <div class="flex items-center gap-1 p-1 overflow-x-auto no-scrollbar bg-[#eceeed] border border-[#e3e6e3] rounded-full">
                <button @click="activeTab = 'products'"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 rounded-full text-[11.5px] sm:text-[12px] font-bold transition-all duration-200"
                        :class="activeTab === 'products' ? 'bg-[#9acd32] text-[#1c201e] shadow-sm' : 'text-[#6b716c] hover:bg-white/70 hover:text-[#1c201e]'">
                    <i class="fa-solid fa-boxes-stacked text-[15px]" style=""></i>
                    Products
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black"
                          :class="activeTab === 'products' ? 'bg-[#1c201e]/10 text-[#1c201e]' : 'bg-white/70 text-[#6b716c]'">{{ number_format($totalProducts) }}</span>
                </button>
                @if($totalServices > 0)
                <button @click="activeTab = 'services'"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 rounded-full text-[11.5px] sm:text-[12px] font-bold transition-all duration-200"
                        :class="activeTab === 'services' ? 'bg-[#9acd32] text-[#1c201e] shadow-sm' : 'text-[#6b716c] hover:bg-white/70 hover:text-[#1c201e]'">
                    <i class="fa-solid fa-bell-concierge text-[15px]" style=""></i>
                    Services
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black"
                          :class="activeTab === 'services' ? 'bg-[#1c201e]/10 text-[#1c201e]' : 'bg-white/70 text-[#6b716c]'">{{ number_format($totalServices) }}</span>
                </button>
                @endif
                @if($totalRentals > 0)
                <button @click="activeTab = 'rentals'"
                        class="shrink-0 inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 rounded-full text-[11.5px] sm:text-[12px] font-bold transition-all duration-200"
                        :class="activeTab === 'rentals' ? 'bg-[#9acd32] text-[#1c201e] shadow-sm' : 'text-[#6b716c] hover:bg-white/70 hover:text-[#1c201e]'">
                    <i class="fa-solid fa-handshake text-[15px]" style=""></i>
                    Rentals
                    <span class="px-1.5 py-0.5 rounded-md text-[10px] font-black"
                          :class="activeTab === 'rentals' ? 'bg-[#1c201e]/10 text-[#1c201e]' : 'bg-white/70 text-[#6b716c]'">{{ number_format($totalRentals) }}</span>
                </button>
                @endif
            </div>
        </div>

        {{-- ============ PRODUCTS PANEL ============ --}}
        <div x-show="activeTab === 'products'" x-cloak>
    {{-- ================================================================
         2. STORE CATEGORIES CHIP BAR (Exact Catalog Aesthetic)
    ================================================================ --}}
    @if($allCategories->isNotEmpty())
    <div class="max-w-7xl mx-auto px-0 mt-5 sm:mt-6">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
<a href="{{ route('stores.show', $store->slug) }}#catalog"
               class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 {{ !request('category') || request('category') === 'all' ? 'bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/25' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                <i class="fa-solid fa-store text-[15px]" style=""></i>
                All Items
            </a>
            @foreach($allCategories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('stores.show', $store->slug) }}?category={{ $cat->slug }}#catalog"
                   class="shrink-0 inline-flex items-center px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 {{ $isActive ? 'bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/25' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ================================================================
         4. FEATURED PRODUCTS STRIP (Matching Catalog Trending Strip)
    ================================================================ --}}
    @if($topProducts->count() > 0)
    <div class="max-w-7xl mx-auto px-3 sm:px-6 mt-8 sm:mt-10">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#1c201e] text-[#9acd32] shadow-sm shrink-0">
                    <i class="fa-solid fa-thumbs-up text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Featured Picks</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Handpicked bestsellers from {{ $store->name }}</p>
                </div>
            </div>
            <a href="#catalog" class="scroll-link inline-flex items-center gap-1 text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap shrink-0">
                View All <i class="fa-solid fa-arrow-right text-[15px]" style=""></i>
            </a>
        </div>

        <div class="flex gap-2 sm:gap-3.5 overflow-x-auto no-scrollbar pb-2">
            @foreach($topProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}"
                   class="group shrink-0 w-[8.75rem] sm:w-48 rounded-xl sm:rounded-2xl bg-white border border-[#e8eae8] overflow-hidden hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-1 transition-all duration-300 card-enter" style="animation-delay: {{ $loop->index * 0.06 }}s">
                    <div class="relative aspect-square bg-[#f6f6f6] overflow-hidden">
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                <i class="fa-solid fa-image text-3xl"></i>
                            </div>
                        @endif

                        @if($product->old_price && $product->old_price > $product->price)
                            <span class="absolute top-2 left-2 bg-[#dc2626] text-white text-[9px] sm:text-[10px] font-black px-1.5 py-0.5 rounded-md -skew-x-12 shadow-sm">-{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                        @endif

                        <span class="absolute top-2 right-2 max-w-[calc(100%-4rem)] px-1.5 py-0.5 rounded-md -skew-x-12 bg-[#1c201e]/80 text-[#9acd32] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wide shadow-sm">
                            <span class="skew-x-6 block truncate">{{ $product->category->name ?? 'Featured' }}</span>
                        </span>

                        <button class="favorite-btn absolute bottom-2 right-2 w-6 h-6 sm:w-8 sm:h-8 bg-white/95 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors shadow-md z-20"
                                data-product="{{ $product->id }}"
                                data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}"
                                onclick="event.stopPropagation(); event.preventDefault();">
                            <i class="{{ in_array($product->id, $savedProductIds) ? 'fa-solid text-[#dc2626]' : 'fa-regular' }} fa-heart text-[11px] sm:text-[14px]" style=""></i>
                        </button>
                    </div>
                    <div class="p-2.5 sm:p-3.5">
                        <p class="text-[10px] text-[#9aa19c] truncate">{{ number_format($product->views ?? 0) }} views</p>
                        <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] line-clamp-1 mt-0.5 group-hover:text-[#7ca81d] transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-baseline gap-1.5 mt-1">
                            <span class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum">{{ number_format($product->price) }} <span class="text-[9px] sm:text-[10px] font-bold">F</span></span>
                            @if($product->old_price)
                                <span class="text-[8.5px] sm:text-[10px] text-[#f97316] line-through truncate">{{ number_format($product->old_price) }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ================================================================
         5. TOOLBAR / SEARCH & SORT STRIP (Exact Catalog Aesthetic)
    ================================================================ --}}
    <div id="catalog" class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-6 sm:mt-8 scroll-mt-[130px]">
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-2.5 sm:p-4 flex flex-wrap items-center justify-between gap-2.5 sm:gap-3 shadow-sm">
            <div class="flex items-center gap-2.5 flex-wrap">
                {{-- Results Count --}}
                <span class="text-xs font-semibold text-[#6b716c]">
                    Showing <strong class="text-[#1c201e]">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-[#1c201e]">{{ number_format($products->total()) }}</strong> products
                </span>
                @if(request('search'))
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-[#f2f9df] border border-[#9acd32]/25 text-[11px] font-bold text-[#659316]">
                        <i class="fa-solid fa-magnifying-glass text-[11px]" style=""></i>
                        "{{ request('search') }}"
                        <a href="{{ route('stores.show', $store->slug) }}?category={{ request('category') }}&sort={{ request('sort') }}#catalog" class="text-[#9aa19c] hover:text-[#1c201e]">
                            <i class="fa-solid fa-xmark text-[13px]"></i>
                        </a>
                    </span>
                @endif
            </div>

            {{-- Right: Sort Selector --}}
            <div class="flex items-center gap-2 ml-auto">
                <span class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-wider hidden sm:inline">Sort:</span>
                <div class="relative">
                    <select onchange="this.options[this.selectedIndex].value && (window.location.href = this.options[this.selectedIndex].value)"
                            class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                        <option value="">Select…</option>
                        @foreach([
                            'latest' => 'Latest Listed',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low',
                            'popular' => 'Most Viewed'
                        ] as $val => $label)
                            <option value="{{ route('stores.show', [$store->slug, 'sort' => $val, 'category' => request('category'), 'search' => request('search')]) }}"
                                    {{ request('sort') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[16px] text-[#6b716c] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================================
         6. PRODUCTS GRID (2 Cards Mobile, 4-5 on PC)
    ================================================================ --}}
    <div class="max-w-7xl mx-auto px-1 sm:px-6 mt-4 sm:mt-6">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 items-stretch auto-rows-fr gap-2 sm:gap-4 w-full">
                @foreach($products as $product)
                    <div class="group relative w-full min-w-0 bg-white rounded-xl sm:rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
                                @if($product->images->first())
                                    <img src="{{ $product->images->first()->url }}"
                                         alt="{{ $product->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                                         onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><span class=\'fa-solid fa-image text-4xl sm:text-5xl\'></i></div>'">
                                @else
                                    <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                        <i class="fa-solid fa-image text-4xl sm:text-5xl"></i>
                                    </div>
                                @endif

                                @if($product->old_price && $product->old_price > $product->price)
                                    @php $discountPct = round((1 - $product->price / $product->old_price) * 100); @endphp
                                    @if($discountPct > 0)
                                        <span class="absolute top-2 left-2 z-20 px-1.5 py-0.5 -skew-x-12 bg-[#dc2626] text-white text-[9px] sm:text-[10px] font-black shadow-md">-{{ $discountPct }}%</span>
                                    @endif
                                @endif

                                @if($product->stock_status === 'out_of_stock')
                                    <span class="absolute inset-x-0 bottom-0 z-10 py-1 bg-[#1c201e]/80 text-white text-[9px] sm:text-[10px] font-bold text-center backdrop-blur-sm">Out of Stock</span>
                                @endif
                            </div>

                            <div class="p-2.5 sm:p-3.5">
                                <div class="flex items-center justify-between gap-1.5">
                                    <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-[#9aa19c] truncate">{{ $product->category->name ?? 'Marketplace' }}</p>
                                    @if($product->stock_status === 'in_stock')
                                        <span class="inline-flex items-center gap-1 text-[8.5px] sm:text-[10px] font-bold text-[#659316] shrink-0">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] inline-block"></span> In Stock
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 group-hover:text-[#7ca81d] transition-colors">{{ $product->name }}</h3>

                                <div class="flex items-end justify-between gap-1 mt-2 pt-2 border-t border-[#f0f1f0]">
                                    <div class="flex items-baseline gap-1 min-w-0">
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <span class="text-[9.5px] sm:text-[11px] text-[#f97316] line-through font-medium tnum truncate">{{ number_format($product->old_price) }}</span>
                                        @endif
                                        <span class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum truncate">{{ number_format($product->price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                                    </div>
                                    @if(($product->rating ?? 0) > 0)
                                        <span class="inline-flex items-center gap-0.5 text-[9.5px] sm:text-[11px] font-extrabold text-[#5c625e] shrink-0">
                                            <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                                            {{ number_format($product->rating, 1) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>

                        @auth
                            @if(auth()->id() !== $store->user_id)
                            <form action="{{ route('conversations.store') }}" method="POST"
                                  onclick="event.stopPropagation()"
                                  class="absolute top-2 left-2 z-30">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                <input type="hidden" name="target_type" value="product">
                                <input type="hidden" name="target_id" value="{{ $product->id }}">
                                <input type="hidden" name="message" value="Hi, I am interested in {{ $product->name }}. Is it still available?">
                                <button type="submit"
                                        class="w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-[#9acd32] hover:text-[#1c201e] transition-all shadow-sm"
                                        title="Message seller about this product">
                                    <i class="fa-regular fa-comment text-[13px]"></i>
                                </button>
                            </form>
                            @endif
                        @endauth
                        <button class="favorite-btn absolute top-2 right-2 w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-30"
                                data-product="{{ $product->id }}"
                                data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                            <i class="{{ in_array($product->id, $savedProductIds) ? 'fa-solid' : 'fa-regular' }} fa-heart text-[13px] {{ in_array($product->id, $savedProductIds) ? 'text-[#dc2626]' : 'text-[#5c625e]' }}" style=""></i>
                        </button>
                    </div>
                @endforeach
            </div>

            @if($products->hasPages())
                <div class="mt-10 sm:mt-12 flex justify-center">
                    {{ $products->links('partials.pagination') }}
                </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-[#e8eae8] p-10 sm:p-16 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#f2f9df] text-[#659316] flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-boxes-stacked text-4xl sm:text-5xl" style=""></i>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No products found</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto leading-relaxed">
                    @if(request('search') || request('category') !== 'all')
                        We couldn't find any products matching your search in this store. Try a different keyword or clear filters.
                    @else
                        This store has no products listed yet. Check back soon!
                    @endif
                </p>
                @if($store->whatsapp_number)
                    <div class="mt-6 flex items-center justify-center">
                        <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi ' . $store->name . ', I am interested in your products on Izifai.') }}" target="_blank"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg -skew-x-6 bg-[#25D366] text-white text-xs font-bold hover:bg-[#128C7E] transition-all shadow-md">
                            <span class="skew-x-6 flex items-center gap-1.5">
                                {!! $whatsappIcon !!}
                                Contact via WhatsApp
                            </span>
                        </a>
                    </div>
                @endif
            </div>
        @endif
    </div>
    </div>{{-- end products panel --}}

    {{-- ============ SERVICES PANEL ============ --}}
    @if($totalServices > 0)
    <div x-show="activeTab === 'services'" x-cloak>
        <div class="max-w-7xl mx-auto px-1 sm:px-6 mt-6 sm:mt-8">
            <div class="flex items-end justify-between gap-3 mb-3 sm:mb-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-purple-50 text-purple-600 shadow-sm shrink-0">
                        <i class="fa-solid fa-bell-concierge text-[16px] sm:text-[20px]" style=""></i>
                    </span>
                    <div>
                        <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Services</h2>
                        <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Professional services from {{ $store->name }}</p>
                    </div>
                </div>
                <a href="{{ route('services.index', ['store' => $store->slug]) }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap shrink-0">
                    View All <i class="fa-solid fa-arrow-right text-[15px]" style=""></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-4">
                @foreach($services as $service)
                    <div class="group relative w-full min-w-0 bg-white rounded-xl sm:rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        <a href="{{ route('services.show', $service->slug) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
                                @php $svcImg = $service->images->first()?->url; @endphp
                                @if($svcImg)
                                    <img src="{{ $svcImg }}" alt="{{ $service->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                                         onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><span class=\'fa-solid fa-image text-4xl sm:text-5xl\'></i></div>'">
                                @else
                                    <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                        <i class="fa-solid fa-image text-4xl sm:text-5xl"></i>
                                    </div>
                                @endif
                                @if($service->delivery_time)
                                    <span class="absolute top-2 left-2 z-20 px-2 py-0.5 rounded-md bg-white/95 text-[#3f453f] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wide shadow-sm flex items-center gap-1">
                                        <i class="fa-solid fa-clock text-[10px]"></i>
                                        {{ $service->delivery_time }}
                                    </span>
                                @endif
                                @auth
                                    @if(auth()->id() !== $store->user_id)
                                    <form action="{{ route('conversations.store') }}" method="POST"
                                          onclick="event.stopPropagation()"
                                          class="absolute top-2 right-2 z-30">
                                        @csrf
                                        <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                        <input type="hidden" name="target_type" value="service">
                                        <input type="hidden" name="target_id" value="{{ $service->id }}">
                                        <input type="hidden" name="message" value="Hi, I am interested in {{ $service->name }}. Is it available?">
                                        <button type="submit"
                                                class="w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-[#9acd32] hover:text-[#1c201e] transition-all shadow-sm"
                                                title="Message seller about this service">
                                            <i class="fa-regular fa-comment text-[13px]"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endauth
                            </div>
                            <div class="p-2.5 sm:p-3.5">
                                <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-purple-600 truncate">{{ $service->category->name ?? 'Services' }}</p>
                                <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 group-hover:text-[#7ca81d] transition-colors">{{ $service->name }}</h3>
                                @if($service->starting_price)
                                    <p class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum mt-1.5">From {{ number_format($service->starting_price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></p>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ============ RENTALS PANEL ============ --}}
    @if($totalRentals > 0)
    <div x-show="activeTab === 'rentals'" x-cloak>
        <div class="max-w-7xl mx-auto px-1 sm:px-6 mt-6 sm:mt-8">
            <div class="flex items-end justify-between gap-3 mb-3 sm:mb-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 shadow-sm shrink-0">
                        <i class="fa-solid fa-handshake text-[16px] sm:text-[20px]" style=""></i>
                    </span>
                    <div>
                        <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Rentals</h2>
                        <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Equipment & gear available to rent</p>
                    </div>
                </div>
                <a href="{{ route('rentals.index', ['store' => $store->slug]) }}"
                   class="inline-flex items-center gap-1 text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap shrink-0">
                    View All <i class="fa-solid fa-arrow-right text-[15px]" style=""></i>
                </a>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-4">
                @foreach($rentals as $item)
                    <div class="group relative w-full min-w-0 bg-white rounded-xl sm:rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300">
                        <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        <a href="{{ route('rentals.show', $item->slug) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
                                @php $rtlImg = $item->images_url[0] ?? null; @endphp
                                @if($rtlImg)
                                    <img src="{{ $rtlImg }}" alt="{{ $item->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                                         onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><span class=\'fa-solid fa-image text-4xl sm:text-5xl\'></i></div>'">
                                @else
                                    <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                        <i class="fa-solid fa-image text-4xl sm:text-5xl"></i>
                                    </div>
                                @endif
                                <span class="absolute top-2 left-2 z-20 px-2 py-0.5 rounded-md -skew-x-12 bg-[#1c201e] text-[#9acd32] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-wide shadow-sm">
                                    <span class="skew-x-6 inline-block">/{{ $item->billing_unit ?? 'day' }}</span>
                                </span>
                                @if($item->location)
                                    <span class="absolute bottom-2 left-2 z-20 px-2 py-0.5 rounded-md bg-[#1c201e]/80 text-white text-[8px] sm:text-[9px] font-bold backdrop-blur-sm flex items-center gap-0.5 shadow-sm">
                                        <i class="fa-solid fa-location-dot text-[10px] text-[#9acd32]" style=""></i>
                                        {{ $item->location }}
                                    </span>
                                @endif
                                @auth
                                    @if(auth()->id() !== $store->user_id)
                                    <form action="{{ route('conversations.store') }}" method="POST"
                                          onclick="event.stopPropagation()"
                                          class="absolute top-2 right-2 z-30">
                                        @csrf
                                        <input type="hidden" name="seller_id" value="{{ $store->user_id }}">
                                        <input type="hidden" name="target_type" value="rental">
                                        <input type="hidden" name="target_id" value="{{ $item->id }}">
                                        <input type="hidden" name="message" value="Hi, I am interested in renting {{ $item->name }}. Is it available?">
                                        <button type="submit"
                                                class="w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-[#9acd32] hover:text-[#1c201e] transition-all shadow-sm"
                                                title="Message seller about this rental">
                                            <i class="fa-regular fa-comment text-[13px]"></i>
                                        </button>
                                    </form>
                                    @endif
                                @endauth
                            </div>
                            <div class="p-2.5 sm:p-3.5">
                                <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-blue-600 truncate">{{ $item->category->name ?? 'Rentals' }}</p>
                                <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 group-hover:text-[#7ca81d] transition-colors">{{ $item->name }}</h3>
                                <div class="flex items-baseline gap-1.5 mt-1.5">
                                    <span class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum">{{ number_format($item->rate) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                                    <span class="text-[9.5px] sm:text-[11px] text-[#9aa19c] font-semibold">/{{ $item->billing_unit }}</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    </section>{{-- end tabs x-data wrapper --}}

    {{-- ================================================================
         7.5 SUGGESTED FOR YOU (Cross-Store Products)
    ================================================================ --}}
    @if($suggestedProducts->count() > 0)
    <section class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-8 sm:mt-12">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#f2f9df] text-[#659316] shadow-sm shrink-0">
                    <i class="fa-solid fa-wand-magic-sparkles text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Suggested for You</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">More picks from other stores on Izifai</p>
                </div>
            </div>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-1 text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap shrink-0">
                Browse Marketplace <i class="fa-solid fa-arrow-right text-[15px]" style=""></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2 sm:gap-4">
            @foreach($suggestedProducts as $sugg)
                <div class="group relative w-full min-w-0 bg-white rounded-xl sm:rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300">
                    <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                    <a href="{{ route('products.show', $sugg->slug) }}" class="block">
                        <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
                            @if($sugg->images->first())
                                <img src="{{ $sugg->images->first()->url }}"
                                     alt="{{ $sugg->name }}" loading="lazy"
                                     class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                                     onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><i class=\'fa-solid fa-image text-4xl sm:text-5xl\'></i></div>'">
                            @else
                                <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                    <i class="fa-solid fa-image text-4xl sm:text-5xl"></i>
                                </div>
                            @endif

                            @if($sugg->old_price && $sugg->old_price > $sugg->price)
                                @php $suggDisc = round((1 - $sugg->price / $sugg->old_price) * 100); @endphp
                                @if($suggDisc > 0)
                                    <span class="absolute top-2 left-2 z-20 px-1.5 py-0.5 -skew-x-12 bg-[#dc2626] text-white text-[9px] sm:text-[10px] font-black shadow-md">-{{ $suggDisc }}%</span>
                                @endif
                            @endif

                            @if($sugg->stock_status === 'out_of_stock')
                                <span class="absolute inset-x-0 bottom-0 z-10 py-1 bg-[#1c201e]/80 text-white text-[9px] sm:text-[10px] font-bold text-center backdrop-blur-sm">Out of Stock</span>
                            @endif
                        </div>

                        <div class="p-2.5 sm:p-3.5">
                            <div class="flex items-center justify-between gap-1.5">
                                <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-[#9aa19c] truncate">{{ $sugg->store->name ?? 'Marketplace' }}</p>
                                @if($sugg->stock_status === 'in_stock')
                                    <span class="inline-flex items-center gap-1 text-[8.5px] sm:text-[10px] font-bold text-[#659316] shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] inline-block"></span> In Stock
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 group-hover:text-[#7ca81d] transition-colors">{{ $sugg->name }}</h3>

                            <div class="flex items-end justify-between gap-1 mt-2 pt-2 border-t border-[#f0f1f0]">
                                <div class="flex items-baseline gap-1 min-w-0">
                                    @if($sugg->old_price && $sugg->old_price > $sugg->price)
                                        <span class="text-[9.5px] sm:text-[11px] text-[#f97316] line-through font-medium tnum truncate">{{ number_format($sugg->old_price) }}</span>
                                    @endif
                                    <span class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum truncate">{{ number_format($sugg->price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                                </div>
                                @if(($sugg->rating ?? 0) > 0)
                                    <span class="inline-flex items-center gap-0.5 text-[9.5px] sm:text-[11px] font-extrabold text-[#5c625e] shrink-0">
                                        <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                                        {{ number_format($sugg->rating, 1) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>

                    <button class="favorite-btn absolute top-2 right-2 w-7 h-7 bg-white/90 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-30"
                            data-product="{{ $sugg->id }}"
                            data-favorited="{{ in_array($sugg->id, $suggestedSavedIds) ? 'true' : 'false' }}">
                        <i class="{{ in_array($sugg->id, $suggestedSavedIds) ? 'fa-solid' : 'fa-regular' }} fa-heart text-[13px] {{ in_array($sugg->id, $suggestedSavedIds) ? 'text-[#dc2626]' : 'text-[#5c625e]' }}" style=""></i>
                    </button>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         8. REVIEWS (Rating Summary + Cards)
    ================================================================ --}}
    <section id="reviews" class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-8 sm:mt-12 scroll-mt-[130px]" x-data="{ reviewForm: false, reviewRating: 0 }">
        <div class="flex items-end justify-between gap-3 mb-4 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-500 shadow-sm shrink-0">
                    <i class="fa-solid fa-star text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Customer Reviews</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">What buyers think about this store</p>
                </div>
            </div>
            @auth
                @if(auth()->id() !== $store->user_id)
                    <button @click="reviewForm = !reviewForm"
                            class="inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-[#1c201e] text-[#9acd32] text-[11px] sm:text-xs font-bold hover:bg-[#2a2f2b] transition-all shadow-sm shrink-0">
                        <i class="fa-solid fa-pen text-[13px]" style=""></i>
                        <span class="hidden sm:inline">Write Review</span>
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-[#1c201e] text-[#9acd32] text-[11px] sm:text-xs font-bold hover:bg-[#2a2f2b] transition-all shadow-sm shrink-0">
                    <i class="fa-solid fa-right-to-bracket text-[13px]"></i>
                    <span class="hidden sm:inline">Login to Review</span>
                </a>
            @endauth
        </div>

        {{-- Rating summary & distribution --}}
        @if($totalReviews > 0 && isset($starDistribution))
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-4 sm:p-5 shadow-sm mb-5 grid grid-cols-1 sm:grid-cols-[auto_1fr] gap-4 sm:gap-8">
            <div class="flex sm:flex-col items-center sm:items-start justify-center gap-2 sm:gap-1 sm:pr-8 sm:border-r border-[#f0f1f0] shrink-0">
                <p class="text-3xl sm:text-5xl font-black text-[#1c201e] tnum leading-none">{{ number_format($avgRating, 1) }}</p>
                <div class="flex text-amber-400">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="{{ $i <= round($avgRating) ? 'fa-solid' : 'fa-regular' }} fa-star text-[14px]" style=""></i>
                    @endfor
                </div>
                <p class="text-[11px] font-bold text-[#9aa19c]">{{ $totalReviews }} review{{ $totalReviews === 1 ? '' : 's' }}</p>
            </div>
            <div class="space-y-1.5 min-w-0">
                @foreach($starDistribution as $star => $data)
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="text-[11px] sm:text-xs font-bold text-[#3f453f] w-3 text-right">{{ $star }}</span>
                    <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                    <div class="flex-1 h-2 sm:h-2.5 rounded-full bg-[#f0f1f0] overflow-hidden">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#9acd32] to-[#659316]" style="width: {{ $data['percentage'] }}%"></div>
                    </div>
                    <span class="text-[10px] sm:text-xs text-[#9aa19c] w-6 text-right tnum">{{ $data['count'] }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Write review form --}}
        @auth
            <form x-show="reviewForm" x-cloak
                  action="{{ route('stores.review', $store) }}" method="POST"
                  class="p-4 sm:p-5 bg-white rounded-2xl border border-[#e8eae8] space-y-3 mb-5 shadow-sm"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0">
                @csrf
                <div class="flex items-center gap-1">
                    <template x-for="star in 5" :key="star">
                        <button type="button" @click="reviewRating = star"
                                :class="star <= reviewRating ? 'fa-solid fa-star text-2xl text-amber-400' : 'fa-regular fa-star text-2xl text-[#c9cecb]'"
                                class="transition-all hover:scale-110"></button>
                    </template>
                    <input type="hidden" name="rating" :value="reviewRating">
                    <span class="text-xs font-bold text-[#3f453f] ml-1" x-show="reviewRating > 0" x-text="reviewRating + ' / 5'"></span>
                </div>
                <textarea name="comment" rows="2" placeholder="Share your experience..."
                          class="w-full px-3 py-2.5 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-xs focus:outline-none focus:border-[#9acd32] focus:ring-2 focus:ring-[#9acd32]/15 resize-none"></textarea>
                <div class="flex gap-2">
                    <button type="submit" class="px-5 py-2.5 bg-[#9acd32] text-[#1c201e] rounded-xl text-xs font-bold hover:bg-[#86b92c] transition-all">Submit Review</button>
                    <button type="button" @click="reviewForm = false" class="px-4 py-2 text-xs font-bold text-[#6b716c] hover:text-[#1c201e] transition-colors">Cancel</button>
                </div>
            </form>
        @endauth

        {{-- Reviews cards --}}
        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 sm:gap-3">
                @foreach($reviews as $review)
                    <div class="bg-white p-3 sm:p-4 rounded-xl sm:rounded-2xl shadow-sm border border-[#e8eae8]">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-[#f2f9df] border border-[#9acd32]/30 flex items-center justify-center font-black text-[#659316] text-[11px] sm:text-xs shrink-0">
                                    {{ substr($review->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-[#1c201e] truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                                    <p class="text-[10px] text-[#9aa19c]">{{ $review->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex text-amber-400 shrink-0">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star text-[11px]" style=""></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-xs text-[#3f453f] leading-relaxed line-clamp-3 mt-2">"{{ $review->comment }}"</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-3xl border border-[#e8eae8] p-8 sm:p-14 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-amber-50 text-amber-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-star text-3xl sm:text-4xl" style=""></i>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No reviews yet</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto">Be the first to share your experience shopping with this store.</p>
                @auth
                    @if(auth()->id() !== $store->user_id)
                        <button @click="reviewForm = true" class="text-xs font-bold text-[#7ca81d] hover:underline mt-3">Write a review</button>
                    @endif
                @endauth
            </div>
        @endif
    </section>

    {{-- ================================================================
         9. STORE INFO
    ================================================================ --}}
    <section id="store-info" class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-8 sm:mt-12 scroll-mt-[130px]" x-data="{ showInfo: true }">
        <div class="flex items-end justify-between gap-3 mb-4 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#f2f9df] text-[#659316] shadow-sm shrink-0">
                    <i class="fa-solid fa-circle-info text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Store Information</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Contact details & business profile</p>
                </div>
            </div>
            <button @click="showInfo = !showInfo" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white border border-[#e8eae8] flex items-center justify-center text-[#3f453f] hover:bg-[#f5f6f5] transition-all shrink-0">
                <i class="fa-solid fa-chevron-down text-[16px] transition-transform duration-200" :class="showInfo ? 'rotate-180' : ''"></i>
            </button>
        </div>

        <div x-show="showInfo" x-cloak class="bg-white rounded-2xl border border-[#e8eae8] p-4 sm:p-5 shadow-sm grid sm:grid-cols-2 gap-x-8 gap-y-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0">
            @if($store->description)
            <div class="sm:col-span-2 flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f2f9df] flex items-center justify-center text-[#659316] shrink-0">
                    <i class="fa-solid fa-file-lines text-[16px]" style=""></i>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider">About</p>
                    <p class="text-xs sm:text-sm text-[#3f453f] leading-relaxed">{{ $store->description }}</p>
                </div>
            </div>
            @endif
            @if($store->location)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f2f9df] flex items-center justify-center text-[#659316] shrink-0">
                    <i class="fa-solid fa-location-dot text-[16px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider">Location</p>
                    <p class="text-xs font-bold text-[#1c201e]">{{ $store->location }}</p>
                </div>
            </div>
            @endif
            @if($store->whatsapp_number)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f2f9df] flex items-center justify-center text-[#659316] shrink-0">
                    <i class="fa-solid fa-comment text-[16px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider">WhatsApp</p>
                    <a href="https://wa.me/{{ wa_url($store->whatsapp_number) }}?text={{ urlencode('Hi, I found your store on Izifai.') }}" target="_blank"
                       class="text-xs font-bold text-[#659316] hover:underline truncate block">{{ $store->whatsapp_number }}</a>
                </div>
            </div>
            @endif
            @if($store->business_email)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f2f9df] flex items-center justify-center text-[#659316] shrink-0">
                    <i class="fa-solid fa-envelope text-[16px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider">Email</p>
                    <a href="mailto:{{ $store->business_email }}" class="text-xs font-bold text-[#659316] hover:underline truncate block">{{ $store->business_email }}</a>
                </div>
            </div>
            @endif
            @if($store->open_hours)
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#f2f9df] flex items-center justify-center text-[#659316] shrink-0">
                    <i class="fa-solid fa-clock text-[16px]"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider">Hours</p>
                    <p class="text-xs font-bold text-[#1c201e] whitespace-pre-line">{{ $store->open_hours }}</p>
                </div>
            </div>
            @endif

            @php $socialLinks = $store->social_links ?: []; @endphp
            @if(count($socialLinks) > 0)
            <div class="sm:col-span-2 pt-2 border-t border-[#f0f1f0]">
                <p class="text-[9px] font-extrabold text-[#9aa19c] uppercase tracking-wider mb-2">Follow Us</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($socialLinks as $social)
                        @php $url = $social['url'] ?? ''; $platform = $social['platform'] ?? ''; if (!$url) continue; @endphp
                        <a href="{{ $url }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-2 bg-[#f5f6f5] text-[#3f453f] rounded-xl text-[10px] font-bold hover:bg-[#f2f9df] hover:text-[#659316] hover:border-[#9acd32]/40 transition-all border border-[#e8eae8]">
                            <i class="{{ match($platform) {
                                    'facebook' => 'fa-brands fa-facebook',
                                    'instagram' => 'fa-brands fa-instagram',
                                    'twitter' => 'fa-brands fa-x-twitter',
                                    'linkedin' => 'fa-brands fa-linkedin-in',
                                    'tiktok' => 'fa-brands fa-tiktok',
                                    'youtube' => 'fa-brands fa-youtube',
                                    'whatsapp_group' => 'fa-brands fa-whatsapp',
                                    default => 'fa-solid fa-globe',
                                } }} text-[14px]"></i>
                            {{ ucfirst(str_replace('_', ' ', $platform)) }}
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

</div>
@endsection

@section('footer')
<script>
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
                const icon = btn.querySelector('i.fa-heart');
                if (data.favorited) {
                    icon.classList.add('fa-solid'); icon.classList.remove('fa-regular');
                    btn.dataset.favorited = 'true';
                } else {
                    icon.classList.add('fa-regular'); icon.classList.remove('fa-solid');
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
</script>
@endsection