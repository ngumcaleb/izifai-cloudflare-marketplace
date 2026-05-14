@extends('layouts.guest')

@section('title', $store->name . ' - Izifai Showroom')
@section('description', $store->description ? strip_tags($store->description) : $store->name . ' on Izifai')
@section('og_title', $store->name . ' - Izifai Showroom')
@section('og_description', strip_tags($store->description) ?: $store->name . ' on Izifai')
@section('twitter_title', $store->name . ' - Izifai Showroom')
@section('twitter_description', strip_tags($store->description) ?: $store->name . ' on Izifai')
@php
    $storeOgImg = $store->logo ? asset('storage/' . $store->logo) : '';
@endphp
@if($storeOgImg)
    @section('og_image', $storeOgImg)
    @section('twitter_image', $storeOgImg)
@endif

@php
$whatsappIcon = '<svg viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
@endphp

@push('scripts')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Store",
    "name": "{{ $store->name }}",
    "description": "{{ strip_tags($store->description) ?: $store->name }}",
    "image": "{{ $storeOgImg ?: asset('favicon.ico') }}",
    "url": "{{ url()->current() }}",
    "address": {
        "@@type": "PostalAddress",
        "addressLocality": "{{ $store->location ?? 'Cameroon' }}",
        "addressCountry": "CM"
    }
}
</script>
@endpush

{{-- ==================== STORE NAV (MOBILE) ==================== --}}
@section('store-nav')
<div class="flex items-center gap-3 py-2.5 overflow-x-auto no-scrollbar">
    <div class="flex items-center gap-2.5 shrink-0">
        <div class="w-8 h-8 rounded-lg overflow-hidden ring-2 ring-primary/10 bg-white shrink-0">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-primary/5 flex items-center justify-center text-xs font-bold text-primary">
                    {{ substr($store->name, 0, 1) }}
                </div>
            @endif
        </div>
        <div class="min-w-0">
            <p class="text-sm font-bold text-on-surface truncate max-w-[120px] lg:max-w-none">{{ $store->name }}</p>
        </div>
    </div>
    <span class="w-px h-5 bg-gray-200 shrink-0"></span>
    <nav class="flex items-center gap-1 shrink-0">
        <a href="#showroom" class="scroll-link px-3 py-1.5 rounded-lg text-xs font-semibold bg-primary text-on-primary whitespace-nowrap">Showroom</a>
        <a href="#catalog" class="scroll-link px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Collections</a>
        <a href="#reviews" class="scroll-link px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Reviews</a>
        <a href="#store-info" class="scroll-link px-3 py-1.5 rounded-lg text-xs font-semibold text-on-surface-variant hover:bg-gray-100 whitespace-nowrap transition-colors">Store Info</a>
    </nav>
</div>
@endsection

{{-- ==================== STORE SIDEBAR (DESKTOP) ==================== --}}
@section('store-sidebar')
<div class="relative h-28 shrink-0">
    @if($store->banner)
        <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover">
    @else
        <div class="w-full h-full bg-gradient-to-br from-primary/60 to-primary"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
    <div class="absolute -bottom-8 left-4 flex items-end gap-3">
        <div class="w-14 h-14 rounded-xl border-2 border-white bg-white shadow-lg overflow-hidden">
            @if($store->logo)
                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-primary/10 flex items-center justify-center text-lg font-black text-primary">
                    {{ substr($store->name, 0, 1) }}
                </div>
            @endif
        </div>
    </div>
</div>
<div class="pt-10 px-4 pb-4 border-b border-gray-100">
    <h2 class="text-base font-bold text-on-surface truncate">{{ $store->name }}</h2>
    <div class="flex flex-wrap items-center gap-2 mt-1">
        @if($store->is_verified)
            <span class="inline-flex items-center gap-0.5 text-[10px] font-bold text-primary bg-primary/10 px-1.5 py-0.5 rounded-full">
                <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                {{ $store->badge ?: 'Verified' }}
            </span>
        @endif
        <span class="flex items-center gap-0.5 text-[11px] text-on-surface-variant">
            <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
            {{ number_format($avgRating, 1) }}
        </span>
        <span class="text-[11px] text-on-surface-variant">{{ $totalProducts }} products</span>
    </div>
</div>
<nav class="flex-1 py-4 px-3 space-y-0.5 overflow-y-auto">
    <a href="#showroom" class="scroll-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-primary font-semibold bg-primary/5 border-l-[3px] border-primary transition-all text-sm">
        <span class="material-symbols-outlined text-[20px]">storefront</span>
        Showroom
    </a>
    <a href="#catalog" class="scroll-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">grid_view</span>
        Collections
    </a>
    <a href="#reviews" class="scroll-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
        <span class="material-symbols-outlined text-[20px]">star</span>
        Reviews
        @if($totalReviews > 0)
            <span class="ml-auto text-[10px] font-bold bg-gray-100 px-1.5 py-0.5 rounded-full">{{ $totalReviews }}</span>
        @endif
    </a>
    <a href="#store-info" class="scroll-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-on-surface-variant hover:text-primary hover:bg-gray-50 transition-all text-sm font-medium">
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
    @if($store->whatsapp_number)
        <a href="https://wa.me/{{ $store->whatsapp_number }}?text={{ urlencode('Hi ' . $store->name . ', I saw your store on Izifai and would like to know more.') }}" target="_blank"
           class="w-full bg-[#25D366] text-white py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-[#128C7E] transition-all text-xs shadow-sm">
            {!! $whatsappIcon !!}
            Message Seller
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

{{-- ==================== CONTENT ==================== --}}
@section('content')
<div class="px-4 sm:px-6 lg:px-8 pt-12 lg:pt-4 pb-4 sm:pb-6 space-y-4 sm:space-y-6 lg:space-y-8">

{{-- HERO BANNER --}}
@php $heroProductThumbs = $topProducts->take(4); @endphp
<section id="showroom" class="mt-3 sm:mt-4">
    <div class="relative min-h-[180px] sm:min-h-[260px] lg:min-h-[320px] overflow-hidden rounded-2xl shadow-sm">
        @if($store->banner)
            <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('storage/' . $store->banner) }}" alt="{{ $store->name }}">
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-primary/80 to-primary"></div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="absolute top-[-120px] right-[-80px] w-[400px] h-[400px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-[-100px] left-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-0 left-0 right-0 px-5 sm:px-6 lg:px-8 py-3 sm:py-6 lg:py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between gap-4">
                    <div class="min-w-0 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white shrink-0 ring-2 ring-white/30">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-6 h-6 sm:w-7 sm:h-7 object-cover rounded-lg">
                                @else
                                    <span class="material-symbols-outlined text-lg sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">store</span>
                                @endif
                            </div>
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white tracking-tight truncate">{{ $store->name }}</h1>
                                    @if($store->is_verified)
                                        <span class="bg-primary-container text-on-primary-container px-1.5 py-0.5 rounded-full text-[8px] lg:text-[10px] font-bold flex items-center gap-0.5 shrink-0">
                                            <span class="material-symbols-outlined text-[10px] lg:text-[12px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                            <span class="hidden xs:inline">VERIFIED</span>
                                        </span>
                                    @endif
                                </div>
                                @if($store->description)
                                    <p class="text-[11px] sm:text-sm text-white/80 max-w-xl line-clamp-1">{{ $store->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-1.5 mt-1 sm:mt-2">
                            @if($heroProductThumbs->count() > 0)
                            <div class="flex -space-x-1.5">
                                @foreach($heroProductThumbs as $p)
                                    <a href="{{ route('products.show', $p->slug) }}" class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-[1.5px] border-white/70 overflow-hidden bg-white shadow-sm hover:z-10 relative transition-transform hover:scale-110">
                                        @if($p->images->first())
                                            <img src="{{ asset('storage/' . $p->images->first()->path) }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <div class="w-full h-full bg-white/30 flex items-center justify-center"><span class="material-symbols-outlined text-[8px] text-white/60">photo</span></div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                            @endif
                            <span class="text-white/80 text-[10px] sm:text-xs font-bold">
                                <span class="text-sm sm:text-base font-black">{{ $totalProducts }}</span> products
                            </span>
                            <span class="text-white/30 hidden sm:inline">•</span>
                            <span class="text-white/60 text-[9px] sm:text-[11px] font-medium hidden sm:inline">Shop on Izifai</span>
                        </div>
                    </div>
                    <div class="flex gap-1.5 sm:gap-2 shrink-0">
                        @if($store->whatsapp_number)
                        <a href="https://wa.me/{{ $store->whatsapp_number }}?text={{ urlencode('Hi ' . $store->name . ', I saw your store on Izifai!') }}" target="_blank"
                           class="flex items-center justify-center gap-1 p-2 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl text-white text-[10px] sm:text-xs font-bold bg-[#25D366] hover:bg-[#128C7E] transition-all shadow-sm">
                            {!! $whatsappIcon !!}
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                        @endif
                        <button onclick="copyToClipboard(window.location.href, this, 'Done!')"
                                class="flex items-center justify-center gap-1 p-2 sm:px-3 sm:py-2 rounded-lg sm:rounded-xl text-white text-[10px] sm:text-xs font-bold bg-white/20 hover:bg-white/30 transition-all backdrop-blur-sm">
                            <span class="material-symbols-outlined text-[16px] sm:text-[18px] copy-icon">share</span>
                            <span class="hidden sm:inline copy-label">Share</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORY PILLS (horizontal scroll) --}}
@if($categories->count() > 0)
<section class="-mx-4 sm:-mx-0 px-4 sm:px-0 overflow-x-auto no-scrollbar">
    <div class="flex gap-2 pb-1">
        <a href="{{ route('stores.show', $store->slug) }}#catalog"
           class="shrink-0 px-4 py-2 rounded-full bg-primary text-on-primary text-xs font-bold shadow-sm transition-all">
            All
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('stores.show', $store->slug) }}?category={{ $cat->slug }}#catalog"
               class="shrink-0 px-4 py-2 rounded-full bg-surface-container-low text-on-surface-variant hover:bg-surface-container hover:text-on-surface text-xs font-bold transition-all border border-outline-variant/20">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- QUICK STATS --}}
<section class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3">
    <div class="bg-surface-container-lowest rounded-xl p-3 sm:p-4 shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Rating</p>
                <p class="text-sm sm:text-base font-bold text-on-surface truncate">{{ number_format($avgRating, 1) }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-3 sm:p-4 shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">reviews</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Reviews</p>
                <p class="text-sm sm:text-base font-bold text-on-surface truncate">{{ $totalReviews }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-3 sm:p-4 shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Products</p>
                <p class="text-sm sm:text-base font-bold text-on-surface truncate">{{ $totalProducts }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-3 sm:p-4 shadow-sm border border-outline-variant/10">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">calendar_month</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Since</p>
                <p class="text-sm sm:text-base font-bold text-on-surface truncate">{{ $joinedDate ? date('Y', strtotime($joinedDate)) : 'N/A' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS (horizontal scroll on mobile) --}}
@if($topProducts->count() > 0)
<section>
    <div class="flex items-center justify-between">
        <h2 class="text-base sm:text-lg font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[18px]" style="font-variation-settings: 'FILL' 1;">recommend</span>
            Featured
        </h2>
        <a href="#catalog" class="scroll-link text-primary text-xs sm:text-sm font-semibold hover:underline shrink-0">
            View All &rarr;
        </a>
    </div>
    <div class="flex gap-3 overflow-x-auto no-scrollbar pb-1">
        @foreach($topProducts as $product)
            <a href="{{ route('products.show', $product->slug) }}"
               class="w-[150px] sm:w-[170px] lg:w-[180px] shrink-0 bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/20 hover:shadow-md transition-all group">
                <div class="h-24 sm:h-28 lg:h-28 overflow-hidden relative bg-surface-container-high">
                    @if($product->images->first())
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                            <span class="material-symbols-outlined text-2xl">image</span>
                        </div>
                    @endif
                    @if($product->old_price)
                        <span class="absolute top-1 left-1 bg-error text-on-error text-[7px] font-bold px-1.5 py-0.5 rounded-full">-{{ round((1 - $product->price / $product->old_price) * 100) }}%</span>
                    @endif
                    <button class="favorite-btn absolute top-1 right-1 w-5 h-5 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors"
                            data-product="{{ $product->id }}"
                            data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}"
                            onclick="event.stopPropagation(); event.preventDefault();">
                        <span class="material-symbols-outlined text-[10px]"
                              style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                    </button>
                    <div class="absolute bottom-1 left-1 bg-black/50 backdrop-blur rounded-full px-1.5 py-0.5 flex items-center gap-0.5">
                        <span class="material-symbols-outlined text-[9px] text-white">visibility</span>
                        <span class="text-[8px] font-bold text-white leading-none">{{ $product->views ?? 0 }}</span>
                    </div>
                </div>
                <div class="p-1.5">
                    @if($product->category)
                        <p class="text-[7px] font-semibold text-primary uppercase truncate">{{ $product->category->name }}</p>
                    @endif
                    <h3 class="text-[10px] font-bold text-on-surface truncate">{{ $product->name }}</h3>
                    <div class="flex items-baseline gap-1 mt-0.5 min-w-0">
                        <span class="text-[10px] font-black text-primary truncate">{{ number_format($product->price) }} FCFA</span>
                        @if($product->old_price)
                            <span class="text-[7px] text-on-surface-variant line-through truncate">{{ number_format($product->old_price) }} FCFA</span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- FULL CATALOG --}}
<section id="catalog" class="scroll-mt-[64px] lg:scroll-mt-[72px] space-y-3 sm:space-y-4"
         x-data="catalogManager({
             activeCategory: '{{ request('category', 'all') }}',
             activeSort: '{{ request('sort', 'latest') }}',
             storeSlug: '{{ $store->slug }}'
         })">
    <div class="sticky top-[64px] lg:top-[72px] bg-background/95 backdrop-blur-md py-2 sm:py-3 z-30 -mx-4 sm:-mx-0 px-4 sm:px-0">
        <div class="flex items-center justify-between">
            <h2 class="text-base sm:text-lg font-bold text-on-surface">All Products</h2>
            <button @click="showSort = !showSort"
                    class="flex items-center gap-1 px-3 py-1.5 border border-outline-variant/30 rounded-lg hover:bg-surface-container transition-colors text-xs font-semibold text-on-surface-variant">
                <span class="material-symbols-outlined text-[16px]">sort</span>
                Sort
            </button>
        </div>
        <div class="flex gap-1.5 overflow-x-auto no-scrollbar mt-2">
            <button @click="switchCategory('all')"
                    :class="activeCategory === 'all' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container'"
                    class="shrink-0 px-3 py-1.5 rounded-full text-[11px] font-bold transition-all">
                All
            </button>
            @foreach($categories as $cat)
                <button @click="switchCategory('{{ $cat->slug }}')"
                        :class="activeCategory === '{{ $cat->slug }}' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container'"
                        class="shrink-0 px-3 py-1.5 rounded-full text-[11px] font-bold transition-all">
                    {{ $cat->name }}
                </button>
            @endforeach
        </div>
        <div x-show="showSort" x-cloak class="mt-2">
            <div class="flex gap-1">
                <button @click="switchSort('latest')"
                        :class="activeSort === 'latest' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant'"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                    Latest
                </button>
                <button @click="switchSort('price_low')"
                        :class="activeSort === 'price_low' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant'"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                    Low Price
                </button>
                <button @click="switchSort('price_high')"
                        :class="activeSort === 'price_high' ? 'bg-primary text-on-primary shadow-sm' : 'bg-surface-container-low text-on-surface-variant'"
                        class="px-3 py-1.5 rounded-lg text-[11px] font-bold transition-all">
                    High Price
                </button>
            </div>
        </div>
    </div>

    <div x-show="loading" x-cloak class="text-center py-12">
        <span class="material-symbols-outlined text-3xl text-primary animate-spin">refresh</span>
    </div>

    <div id="products-container" x-show="!loading">
        @if($products->count() > 0)
            <div id="products-grid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-3">
                @foreach($products as $product)
                    <div class="bg-surface-container-lowest rounded-lg sm:rounded-xl overflow-hidden shadow-sm border border-outline-variant/10 hover:shadow-md transition-all group relative">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                <div class="aspect-square lg:aspect-[4/3] relative overflow-hidden bg-surface-container-high">
                                @if($product->images->first())
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                        <span class="material-symbols-outlined text-3xl">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-1.5 sm:p-3">
                                @if($product->category)
                                    <p class="text-[7px] sm:text-[10px] font-semibold text-primary uppercase truncate">{{ $product->category->name }}</p>
                                @endif
                                <h3 class="text-[11px] sm:text-sm font-bold text-on-surface truncate leading-tight">{{ $product->name }}</h3>
                                <p class="text-xs sm:text-base font-black text-primary mt-0.5 truncate">{{ number_format($product->price) }} FCFA</p>
                                @if($product->old_price)
                                    <p class="text-[9px] sm:text-[11px] text-on-surface-variant line-through truncate">{{ number_format($product->old_price) }} FCFA</p>
                                @endif
                            </div>
                        </a>
                        <button class="favorite-btn absolute top-1.5 right-1.5 sm:top-2 sm:right-2 w-5 h-5 sm:w-7 sm:h-7 bg-white/80 backdrop-blur rounded-full flex items-center justify-center hover:bg-white transition-colors z-10"
                                data-product="{{ $product->id }}"
                                data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                            <span class="material-symbols-outlined text-[10px] sm:text-[14px]"
                                  style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                        </button>
                    </div>
                @endforeach
            </div>
            <div id="products-pagination" class="mt-4 sm:mt-6">
                {{ $products->links('partials.pagination') }}
            </div>
        @else
            <div id="products-empty" class="text-center py-10 sm:py-12 bg-surface-container-low rounded-xl border border-outline-variant/10">
                <span class="material-symbols-outlined text-3xl sm:text-4xl text-outline-variant">inventory_2</span>
                <p class="text-sm font-bold text-on-surface-variant mt-3">No products found</p>
                @if($store->whatsapp_number)
                    <p class="text-xs text-on-surface-variant mt-1">Contact the seller for available items</p>
                    <a href="https://wa.me/{{ $store->whatsapp_number }}?text={{ urlencode('Hi ' . $store->name . ', I am interested in your products on Izifai.') }}" target="_blank"
                       class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-[#25D366] text-white rounded-lg text-xs font-bold hover:bg-[#128C7E] transition-all">
                        {!! $whatsappIcon !!}
                        Contact via WhatsApp
                    </a>
                @endif
            </div>
        @endif
    </div>
</section>

{{-- CUSTOMER REVIEWS --}}
<section id="reviews" x-data="{ reviewForm: false, reviewRating: 0 }">
    <div class="flex items-center justify-between">
        <h2 class="text-base sm:text-lg font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary text-[18px]">reviews</span>
            Reviews
            @if($totalReviews > 0)
                <span class="text-xs font-normal text-on-surface-variant">({{ $totalReviews }})</span>
            @endif
        </h2>
        <div class="flex items-center gap-1.5">
            <div class="flex text-orange-500">
                @for($i = 1; $i <= 5; $i++)
                    <span class="material-symbols-outlined text-[14px]"
                          style="font-variation-settings: 'FILL' {{ $i <= round($avgRating) ? 1 : 0 }};">star</span>
                @endfor
            </div>
            <span class="text-xs font-bold text-on-surface">{{ number_format($avgRating, 1) }}</span>
        </div>
    </div>

    @auth
        @if(auth()->id() !== $store->user_id)
            <button @click="reviewForm = !reviewForm"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-primary text-on-primary rounded-lg text-xs font-bold hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[14px]">edit</span>
                Write Review
            </button>
        @endif
    @else
        <a href="{{ route('login') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 bg-primary text-on-primary rounded-lg text-xs font-bold hover:opacity-90 transition-all w-fit">
            <span class="material-symbols-outlined text-[14px]">login</span>
            Login to Review
        </a>
    @endauth

    @auth
        <form x-show="reviewForm" x-cloak
              action="{{ route('stores.review', $store) }}" method="POST"
              class="p-3 sm:p-4 bg-surface-container-low rounded-xl border border-outline-variant/10 space-y-3"
              x-transition:enter="transition ease-out duration-200"
              x-transition:enter-start="opacity-0 -translate-y-2"
              x-transition:enter-end="opacity-100 translate-y-0">
            @csrf
            <div class="flex items-center gap-1">
                <template x-for="star in 5" :key="star">
                    <button type="button" @click="reviewRating = star"
                            :class="star <= reviewRating ? 'text-orange-500' : 'text-outline-variant'"
                            class="transition-all hover:scale-110">
                        <span class="material-symbols-outlined text-2xl"
                              :style="'font-variation-settings: \\'FILL\\' ' + (star <= reviewRating ? 1 : 0)">star</span>
                    </button>
                </template>
                <input type="hidden" name="rating" :value="reviewRating">
                <span class="text-xs text-on-surface-variant ml-1" x-show="reviewRating > 0" x-text="reviewRating + ' / 5'"></span>
            </div>
            <textarea name="comment" rows="2" placeholder="Share your experience..."
                      class="w-full px-3 py-2 bg-surface-container-lowest border border-outline-variant/30 rounded-lg text-xs focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary/20 resize-none"></textarea>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-1.5 bg-primary text-on-primary rounded-lg text-xs font-bold hover:opacity-90 transition-all">Submit</button>
                <button type="button" @click="reviewForm = false" class="px-4 py-1.5 text-xs font-bold text-on-surface-variant hover:text-on-surface transition-colors">Cancel</button>
            </div>
        </form>
    @endauth

    @if($reviews->count() > 0)
        <div class="flex gap-2 sm:gap-3 overflow-x-auto pb-1 snap-x snap-mandatory no-scrollbar -mx-4 sm:-mx-0 px-4 sm:px-0">
            @foreach($reviews as $review)
                <div class="min-w-[260px] sm:min-w-[300px] w-[70vw] sm:w-auto bg-surface-container-lowest p-3 sm:p-4 rounded-xl shadow-sm border border-outline-variant/10 space-y-2 shrink-0 snap-start">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 min-w-0">
                            <div class="w-7 h-7 rounded-full bg-secondary-container flex items-center justify-center font-bold text-primary text-[10px] shrink-0">
                                {{ substr($review->user->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                            </div>
                        </div>
                        <div class="flex text-orange-500 shrink-0">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="material-symbols-outlined text-[12px]"
                                      style="font-variation-settings: 'FILL' {{ $i <= $review->rating ? 1 : 0 }};">star</span>
                            @endfor
                        </div>
                    </div>
                    @if($review->comment)
                        <p class="text-xs text-on-surface-variant line-clamp-2">"{{ $review->comment }}"</p>
                    @endif
                    <p class="text-[10px] text-on-surface-variant/60 text-right">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8 bg-surface-container-low rounded-xl border border-outline-variant/10">
            <span class="material-symbols-outlined text-2xl text-outline-variant">reviews</span>
            <p class="text-xs font-bold text-on-surface-variant mt-1">No reviews yet</p>
            @auth
                @if(auth()->id() !== $store->user_id)
                    <button @click="reviewForm = true" class="text-xs font-bold text-primary hover:underline mt-1">Be the first</button>
                @endif
            @endauth
        </div>
    @endif
</section>

{{-- STORE INFO --}}
<section id="store-info" class="scroll-mt-[64px] lg:scroll-mt-[72px]"
         x-data="{ showInfo: true }">
    <button @click="showInfo = !showInfo"
            class="w-full flex items-center justify-between p-3 sm:p-4 bg-surface-container-lowest rounded-xl border border-outline-variant/10 hover:shadow-sm transition-all">
        <span class="text-sm font-bold text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] text-primary">info</span>
            Store Information
        </span>
        <span class="material-symbols-outlined text-[18px] text-on-surface-variant transition-transform duration-200"
              :class="showInfo ? 'rotate-180' : ''">expand_more</span>
    </button>
    <div x-show="showInfo" x-cloak class="p-3 sm:p-4 bg-surface-container-lowest rounded-xl border border-outline-variant/10 space-y-3"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0">
        @if($store->description)
        <div class="flex items-start gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0 mt-0.5">
                <span class="material-symbols-outlined text-[16px]">description</span>
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">About</p>
                <p class="text-xs text-on-surface leading-relaxed">{{ $store->description }}</p>
            </div>
        </div>
        @endif
        @if($store->location)
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]">location_on</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Location</p>
                <p class="text-xs font-bold text-on-surface">{{ $store->location }}</p>
            </div>
        </div>
        @endif
        @if($store->whatsapp_number)
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]">chat</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">WhatsApp</p>
                <a href="https://wa.me/{{ $store->whatsapp_number }}?text={{ urlencode('Hi, I found your store on Izifai.') }}" target="_blank"
                   class="text-xs font-bold text-primary hover:underline truncate block">{{ $store->whatsapp_number }}</a>
            </div>
        </div>
        @endif
        @if($store->business_email)
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]">mail</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Email</p>
                <a href="mailto:{{ $store->business_email }}" class="text-xs font-bold text-primary hover:underline truncate block">{{ $store->business_email }}</a>
            </div>
        </div>
        @endif
        @if($store->open_hours)
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined text-[16px]">schedule</span>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider">Hours</p>
                <p class="text-xs font-bold text-on-surface whitespace-pre-line">{{ $store->open_hours }}</p>
            </div>
        </div>
        @endif

        @php $socialLinks = $store->social_links ?: []; @endphp
        @if(count($socialLinks) > 0)
        <div class="pt-2 border-t border-outline-variant/10">
            <p class="text-[9px] font-semibold text-on-surface-variant uppercase tracking-wider mb-2">Follow Us</p>
            <div class="flex flex-wrap gap-1.5">
                @foreach($socialLinks as $social)
                    @php $url = $social['url'] ?? ''; $platform = $social['platform'] ?? ''; if (!$url) continue; @endphp
                    <a href="{{ $url }}" target="_blank"
                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-primary/5 text-primary rounded-lg text-[10px] font-bold hover:bg-primary/10 transition-all">
                        <span class="material-symbols-outlined text-[14px]">
                            {{ match($platform) {
                                'facebook' => 'facebook', 'instagram' => 'instagram', 'twitter' => 'alternate_email',
                                'linkedin' => 'work', 'tiktok' => 'music_note', 'youtube' => 'play_circle',
                                'whatsapp_group' => 'groups', default => 'public',
                            } }}
                        </span>
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
    function storeSearch(slug) {
        return {
            query: '{{ request('search') }}',
            results: [],
            open: false,
            search() {
                const q = this.query.trim();
                if (q.length < 2) { this.results = []; this.open = false; return; }
                fetch('/store/' + slug + '/search?q=' + encodeURIComponent(q))
                    .then(r => r.json())
                    .then(data => { this.results = data; this.open = true; })
                    .catch(() => {});
            }
        };
    }

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