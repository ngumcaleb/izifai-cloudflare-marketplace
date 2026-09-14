@extends('layouts.guest')

@section('title', 'Izifai — Shop Cameroon\'s Marketplace')
@section('description', 'Buy and sell directly with verified merchants across Cameroon. Browse products, book services, rent equipment, and share your store in one link.')

@php
    $withImg = $products->filter(fn($p) => $p->images->isNotEmpty())->values();
    $heroPool = $withImg->shuffle();
    $heroProduct = $heroPool->first();
    $heroProduct2 = $heroPool->skip(1)->first();
    $heroProduct3 = $heroPool->skip(2)->first();
    $exploreImg = $heroProduct2 ?: $heroProduct;
    $dealPct = fn($p) => $p->old_price && $p->old_price > $p->price ? round((1 - $p->price / $p->old_price) * 100) : 0;

    $deals = $products->concat($trendingProducts)
        ->filter(fn($p) => $p->images->isNotEmpty() && $p->old_price && $p->old_price > $p->price)
        ->unique('id')->take(10)->values();
    $dealFeatured = $deals->first();
$featuredTab = $products->where('is_featured', true)->take(8)->values();

    if ($featuredTab->count() < 5) { $featuredTab = $products->take(8); }

    $tileColors = [
        ['#ffe7d2', '#c25400'],
        ['#eef4d8', '#659316'],
        ['#eceef1', '#454b57'],
        ['#fdf0c4', '#8a6d00'],
        ['#e2e9f8', '#2f55a1'],
    ];

    $firstName = auth()->check() ? \Illuminate\Support\Str::before(auth()->user()->name, ' ') : null;
    $savedCount = auth()->check() ? count($savedProductIds) : 0;
    $userStore = auth()->check() ? auth()->user()->store : null;
@endphp

@section('header-search')
<div class="hidden sm:flex flex-1 max-w-xl lg:max-w-2xl mx-4">
    <div class="w-full flex rounded-full overflow-hidden bg-white border border-[#e6e8e6] focus-within:border-[#9acd32] focus-within:shadow-[0_0_0_3px_rgba(154,205,50,0.10)] transition-all group h-11">
        <span class="grid place-items-center pl-4 text-[#9aa19c]">
            <span class="material-symbols-rounded text-[20px]" style="font-variation-settings:'FILL' 1;">search</span>
        </span>
        <input type="text" readonly placeholder="What are you looking for?"
               @click="$dispatch('open-search')"
               class="w-full h-full bg-transparent text-[13px] outline-none px-2 text-[#1c201e] placeholder:text-[#9aa19c] cursor-pointer">
        <button class="h-full px-5 bg-[#9acd32] text-white text-sm font-bold hover:bg-[#7ca81d] transition-colors flex items-center gap-1.5" @click="$dispatch('open-search')">
            <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">search</span>
            <span class="hidden lg:inline">Search</span>
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }

    .ecom-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; border-radius: 9999px; font-weight: 600; transition: background .15s ease, transform .1s ease, box-shadow .2s ease; cursor: pointer; }
    .ecom-btn:active { transform: scale(.97); }

    .seg { display: inline-flex; padding: 3px; background: #eceeed; border: 1px solid #e3e6e3; border-radius: 9999px; }
    .seg button { border-radius: 9999px; padding: .45rem .95rem; font-size: .78rem; font-weight: 600; color: #6b716c; transition: background .15s ease, color .15s ease; white-space: nowrap; }
    .seg button.on { background: #9acd32; color: #fff; box-shadow: 0 2px 6px rgba(154, 205, 50, .35); }
    .seg button:not(.on):hover { color: #1c201e; }

    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .tnum { font-variant-numeric: tabular-nums; }

    .bg-dots { background-image: radial-gradient(rgba(255,255,255,.14) 1px, transparent 1px); background-size: 18px 18px; }
    .bg-grid-soft { background-image: linear-gradient(rgba(255,255,255,.07) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.07) 1px, transparent 1px); background-size: 30px 30px; }

    @keyframes floaty { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    .floaty { animation: floaty 6s ease-in-out infinite; }
    .floaty-slow { animation: floaty 9s ease-in-out infinite; }

    @keyframes spin-slow { to { transform: rotate(360deg); } }
    .spin-slow { animation: spin-slow 22s linear infinite; }
</style>
@endpush

@section('content')

{{-- ================================================================
     HERO CAROUSEL  (intelligent: adapts for guests vs signed-in)
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 sm:mt-6">
    <div x-data="homeHero(3)"
         @mouseenter="pause()" @mouseleave="resume()"
         class="relative overflow-hidden rounded-3xl border border-black/5 bg-white shadow-[0_14px_44px_-16px_rgba(0,0,0,0.16)] select-none">
        <div class="flex touch-pan-y transition-transform duration-500 ease-out"
             :style="{ transform: 'translateX(-' + (index * 100) + '%)' }"
             @pointerdown="down($event)" @pointermove="move($event)" @pointerup="up()" @pointercancel="up()">

            {{-- ========== SLIDE 1 — hero pitch (auth aware) ========== --}}
            <div class="w-full shrink-0">
                @auth
                <div class="relative h-full overflow-hidden bg-gradient-to-br from-[#7ca81d] via-[#9acd32] to-[#6f9f20]">
                    <div class="absolute -top-24 -right-16 w-72 h-72 rounded-full bg-[#9acd32]/40 blur-3xl floaty"></div>
                    <div class="absolute -bottom-28 -left-10 w-80 h-80 rounded-full bg-white/[.08] blur-2xl"></div>
                    <div class="absolute inset-0 bg-grid-soft opacity-40"></div>

                    @if($heroProduct)
                    <div class="absolute inset-0">
                        <img src="{{ $heroProduct->images->first()->url }}" alt="{{ $heroProduct->name }}"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.classList.add('hidden')">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#151b0b]/95 via-[#151b0b]/75 to-[#151b0b]/35"></div>
                    </div>
                    @endif

                    <div class="relative z-10 px-5 sm:px-10 py-9 sm:py-12 lg:py-14 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-white/10 border border-white/15 backdrop-blur px-3.5 py-1.5 text-[11px] font-semibold text-white">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] animate-pulse"></span>
                            Good to see you, {{ $firstName }}
                        </span>
                        <h1 class="mt-4 text-[1.75rem] sm:text-4xl lg:text-[2.6rem] font-extrabold text-white tracking-tight leading-[1.1]">
                            Let's find your<br><span class="text-[#9acd32]">next great deal.</span>
                        </h1>
                        <p class="mt-3.5 text-sm sm:text-[15px] text-white/80 max-w-md leading-relaxed">
                            @if($savedCount > 0)
                                You saved <span class="font-bold text-white">{{ $savedCount }}</span> item{{ $savedCount === 1 ? '' : 's' }}. Pick up where you left off or explore what's new today.
                            @else
                                Fresh listings are landing every minute — explore what's new and save the ones you love.
                            @endif
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('products.index') }}" class="ecom-btn h-12 px-7 text-sm bg-white text-[#659316] shadow-lg shadow-black/10 hover:bg-[#f2f9df]">
                                Resume browsing
                                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                            </a>
                            <a href="{{ route('conversations.index') }}" class="ecom-btn h-12 px-7 text-sm text-white border-2 border-white/40 hover:bg-white/10">
                                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">chat_bubble</span>
                                My inbox
                            </a>
                        </div>

                        @if($userStore)
                        <a href="{{ route('seller.dashboard') }}" class="mt-3 inline-flex items-center gap-1.5 self-start text-[12px] font-bold text-[#9acd32] hover:text-white transition-colors">
                            <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">dashboard</span>
                            Go to seller dashboard
                        </a>
                        @endif

                        <div class="mt-7 flex flex-wrap gap-x-6 gap-y-2 text-[11px] font-semibold text-white/90">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">verified</span>
                                {{ number_format($verifiedStores) }}+ verified sellers
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                                {{ number_format($totalProducts) }}+ products live
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">link</span>
                                Share your store in one link
                            </span>
                        </div>
                    </div>
                </div>
                @endauth

                @guest
                <div class="relative h-full overflow-hidden bg-gradient-to-br from-[#7ca81d] via-[#9acd32] to-[#6f9f20]">
                    <div class="absolute -top-24 -right-16 w-72 h-72 rounded-full bg-[#9acd32]/40 blur-3xl floaty"></div>
                    <div class="absolute -bottom-28 -left-10 w-80 h-80 rounded-full bg-white/[.08] blur-2xl"></div>
                    <div class="absolute inset-0 bg-grid-soft opacity-40"></div>

                    @if($heroProduct)
                    <div class="absolute inset-0">
                        <img src="{{ $heroProduct->images->first()->url }}" alt="{{ $heroProduct->name }}"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.classList.add('hidden')">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#151b0b]/95 via-[#151b0b]/75 to-[#151b0b]/35"></div>
                    </div>
                    @endif

                    <div class="relative z-10 px-5 sm:px-10 py-9 sm:py-12 lg:py-14 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-white/10 border border-white/15 backdrop-blur px-3.5 py-1.5 text-[11px] font-semibold text-white">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] animate-pulse"></span>
                            Cameroon's fastest marketplace
                        </span>
                        <h1 class="mt-4 text-[1.75rem] sm:text-4xl lg:text-[2.6rem] font-extrabold text-white tracking-tight leading-[1.1]">
                            Buy. Sell. <span class="text-[#9acd32]">Discover.<br class="hidden sm:block"> One link.</span>
                        </h1>
                        <p class="mt-3.5 text-sm sm:text-[15px] text-white/80 max-w-md leading-relaxed">
                            Buy direct from verified sellers, book services and rent gear — no middleman, no app required.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('products.index') }}" class="ecom-btn h-12 px-7 text-sm bg-white text-[#659316] shadow-lg shadow-black/10 hover:bg-[#f2f9df]">
                                Start shopping
                                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                            </a>
                            <a href="{{ route('register') }}" class="ecom-btn h-12 px-7 text-sm text-white border-2 border-white/40 hover:bg-white/10">
                                Become a seller
                            </a>
                        </div>

                        @if($allProductCategories->isNotEmpty())
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($allProductCategories->take(4) as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                               class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/15 px-3 py-1.5 text-[11px] font-semibold text-white hover:bg-white/20 transition-colors">
                                {{ $cat->name }}
                                <span class="material-symbols-rounded text-[13px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                            </a>
                            @endforeach
                        </div>
                        @endif

                        <div class="mt-7 flex flex-wrap gap-x-6 gap-y-2 text-[11px] font-semibold text-white/90">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">verified</span>
                                {{ number_format($verifiedStores) }}+ verified sellers
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                                {{ number_format($totalProducts) }}+ products live
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">link</span>
                                Share your store in one link
                            </span>
                        </div>
                    </div>
                </div>
                @endguest
            </div>

            {{-- ========== SLIDE 2 — Deals of the day ========== --}}
            <div class="w-full shrink-0">
                <div class="relative h-full overflow-hidden bg-gradient-to-br from-[#7ca81d] via-[#9acd32] to-[#6f9f20]">
                    <div class="absolute -top-20 -left-16 w-72 h-72 rounded-full bg-white/[.12] blur-3xl"></div>
                    <div class="absolute -bottom-24 -right-10 w-80 h-80 rounded-full bg-[#1c201e]/25 blur-2xl"></div>

                    @if($dealFeatured)
                    <div class="absolute inset-0">
                        <img src="{{ $dealFeatured->images->first()->url }}" alt="{{ $dealFeatured->name }}"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.classList.add('hidden')">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#151b0b]/95 via-[#151b0b]/65 to-[#151b0b]/25"></div>
                    </div>
                    @endif

                    <div class="relative z-10 px-5 sm:px-10 py-9 sm:py-12 lg:py-14 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-white/10 border border-white/15 backdrop-blur px-3.5 py-1.5 text-[11px] font-semibold text-white">
                            <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">local_fire_department</span>
                            Limited-time prices
                        </span>
                        <h2 class="mt-4 text-[1.75rem] sm:text-4xl lg:text-[2.6rem] font-extrabold text-white tracking-tight leading-[1.1]">
                            Deals of the day.<br><span class="text-[#9acd32]">Grab them fast.</span>
                        </h2>
                        <p class="mt-3.5 text-sm sm:text-[15px] text-white/80 max-w-md leading-relaxed">
                            Deep discounts on verified products. When stock's gone, the deal is gone too.
                        </p>
                        @if($dealFeatured)
                        <p class="mt-4 inline-flex items-center gap-2.5 self-start rounded-full bg-[#151b0b]/35 border border-white/15 backdrop-blur px-4 py-2 text-[12px] font-bold text-white">
                            <span class="truncate max-w-[40vw] sm:max-w-xs">{{ $dealFeatured->name }}</span>
                            @if($dealFeatured->old_price && $dealFeatured->old_price > $dealFeatured->price)
                            <span class="text-white/50 line-through tnum font-medium">{{ number_format($dealFeatured->old_price) }}</span>
                            @endif
                            <span class="text-[#9acd32] tnum">{{ number_format($dealFeatured->price) }} F</span>
                        </p>
                        @endif
                        <div class="mt-6">
                            <a href="#deals" class="ecom-btn h-12 px-7 text-sm bg-[#9acd32] text-[#1c201e] shadow-lg shadow-black/20 hover:bg-[#86b92c]">
                                Shop all deals
                                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                            </a>
                        </div>
                        <div class="mt-7 flex flex-wrap gap-x-6 gap-y-2 text-[11px] font-bold text-white/80">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">bolt</span>
                                {{ $deals->count() }}+ live deals
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">verified</span>
                                Verified sellers only
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ========== SLIDE 3 — Explore everything ========== --}}
            <div class="w-full shrink-0">
                <div class="relative h-full overflow-hidden bg-gradient-to-br from-[#7ca81d] via-[#9acd32] to-[#6f9f20]">
                    <div class="absolute -top-20 -right-16 w-72 h-72 rounded-full bg-white/[.12] blur-3xl"></div>
                    <div class="absolute -bottom-24 -left-10 w-80 h-80 rounded-full bg-[#1c201e]/25 blur-2xl"></div>

                    @if($exploreImg)
                    <div class="absolute inset-0">
                        <img src="{{ $exploreImg->images->first()->url }}" alt="{{ $exploreImg->name }}"
                             class="w-full h-full object-cover" loading="lazy"
                             onerror="this.classList.add('hidden')">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#151b0b]/95 via-[#151b0b]/65 to-[#151b0b]/25"></div>
                    </div>
                    @endif

                    <div class="relative z-10 px-5 sm:px-10 py-9 sm:py-12 lg:py-14 flex flex-col justify-center">
                        <span class="inline-flex items-center gap-2 self-start rounded-full bg-white/10 border border-white/15 backdrop-blur px-3.5 py-1.5 text-[11px] font-semibold text-white">
                            <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">compass_calibration</span>
                            Explore everything
                        </span>
                        <h2 class="mt-4 text-[1.75rem] sm:text-4xl lg:text-[2.6rem] font-extrabold text-white tracking-tight leading-[1.1]">
                            Services & rentals.<br><span class="text-[#9acd32]">One marketplace.</span>
                        </h2>
                        <p class="mt-3.5 text-sm sm:text-[15px] text-white/80 max-w-md leading-relaxed">
                            Book local pros and rent gear by the day — no middleman, no app required.
                        </p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 rounded-full bg-[#9acd32] text-[#1c201e] px-4 py-2 text-[12px] font-bold hover:bg-[#86b92c] transition-colors">
                                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">design_services</span>
                                {{ number_format($totalServices) }} pros ready
                            </a>
                            <a href="{{ route('rentals.index') }}" class="inline-flex items-center gap-1.5 rounded-full bg-white/10 border border-white/25 text-white px-4 py-2 text-[12px] font-bold hover:bg-white/20 transition-colors">
                                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">shelves</span>
                                {{ number_format($totalRentals) }} items to rent
                            </a>
                        </div>
                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('services.index') }}" class="ecom-btn h-12 px-7 text-sm bg-white text-[#659316] shadow-lg shadow-black/10 hover:bg-[#f2f9df]">
                                Book a service
                                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                            </a>
                            <a href="{{ route('register') }}" class="ecom-btn h-12 px-7 text-sm text-white border-2 border-white/40 hover:bg-white/10">
                                Sell something
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Controls: dots + arrows --}}
        <div class="absolute bottom-4 left-5 z-30 flex items-center gap-2">
            <template x-for="i in total" :key="i">
                <button @click="go(i - 1)"
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="index === i - 1 ? 'w-7 bg-white shadow' : 'w-2.5 bg-white/45 hover:bg-white/70'"></button>
            </template>
        </div>
        <div class="absolute bottom-3 right-4 z-30 hidden sm:flex items-center gap-2">
            <button @click="go((index + total - 1) % total)"
                    class="w-9 h-9 rounded-full bg-white/15 backdrop-blur border border-white/25 text-white grid place-items-center hover:bg-white/30 transition-colors active:scale-95">
                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">chevron_left</span>
            </button>
            <button @click="go((index + 1) % total)"
                    class="w-9 h-9 rounded-full bg-white/15 backdrop-blur border border-white/25 text-white grid place-items-center hover:bg-white/30 transition-colors active:scale-95">
                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">chevron_right</span>
            </button>
        </div>
    </div>
</section>

{{-- ================================================================
     TRUST STRIP
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-6">
    <div class="rounded-2xl bg-white border border-[#e8eae8] px-4 sm:px-6 py-3.5 flex items-center justify-center flex-wrap gap-x-7 gap-y-2 text-[11px] font-semibold text-[#6b716c]">
        <span class="inline-flex items-center gap-2">
            <span class="grid place-items-center w-7 h-7 rounded-lg bg-[#f2f9df] text-[#7ca81d]">
                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">smartphone</span>
            </span>
            MTN MoMo
        </span>
        <span class="inline-flex items-center gap-2">
            <span class="grid place-items-center w-7 h-7 rounded-lg bg-[#f2f9df] text-[#7ca81d]">
                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">smartphone</span>
            </span>
            Orange Money
        </span>
        <span class="inline-flex items-center gap-2">
            <span class="grid place-items-center w-7 h-7 rounded-lg bg-[#f2f9df] text-[#7ca81d]">
                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">credit_card</span>
            </span>
            Cards
        </span>
        <span class="inline-flex items-center gap-2">
            <span class="grid place-items-center w-7 h-7 rounded-lg bg-[#f2f9df] text-[#659316]">
                <span class="material-symbols-rounded text-[15px]" style="font-variation-settings:'FILL' 1;">verified_user</span>
            </span>
            Verified stores only
        </span>
    </div>
</section>

{{-- ================================================================
     SHOP BY CATEGORY
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10">
    <div class="flex items-end justify-between gap-3 mb-5">
        <div>
            <h2 class="text-lg sm:text-xl font-bold tracking-tight text-[#1c201e]">Shop by category</h2>
            <p class="text-[12px] text-[#6b716c] mt-0.5">Jump straight to what you need</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#9acd32] hover:text-[#7ca81d] transition-colors whitespace-nowrap">
            All products <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
        </a>
    </div>
    <div x-data="autoScroll()" x-init="init()" class="flex gap-3.5 overflow-x-auto no-scrollbar pb-1">
        @foreach($categories as $cat)
            @php $tc = $tileColors[$loop->index % count($tileColors)]; @endphp
            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
               class="shrink-0 w-[5.25rem] sm:w-24 text-center group">
                <div class="w-[5.25rem] sm:w-24 h-[5.25rem] sm:h-24 rounded-2xl overflow-hidden ring-1 ring-black/5 group-hover:ring-[#9acd32]/40 group-hover:shadow-lg transition-all duration-300">
                    @if($cat->image_url)
                        <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                    @else
                        <span class="grid place-items-center w-full h-full text-xl font-extrabold group-hover:scale-105 transition-transform duration-300" style="background: {{ $tc[0] }}; color: {{ $tc[1] }};">{{ strtoupper(substr($cat->name, 0, 1)) }}</span>
                    @endif
                </div>
                <p class="mt-2 text-[11px] font-bold text-[#3f453f] leading-tight line-clamp-1 group-hover:text-[#7ca81d] transition-colors">{{ $cat->name }}</p>
                <p class="text-[10px] text-[#9aa19c]">{{ number_format($cat->products_count) }} items</p>
            </a>
        @endforeach
        @if($categories->isNotEmpty())
        <a href="{{ route('products.index') }}" class="shrink-0 w-[5.25rem] sm:w-24 text-center group self-start">
            <div class="w-[5.25rem] sm:w-24 h-[5.25rem] sm:h-24 rounded-2xl border-2 border-dashed border-[#c9cecb] bg-white grid place-items-center text-[#9aa19c] group-hover:text-[#9acd32] group-hover:border-[#9acd32]/50 transition-colors">
                <span class="material-symbols-rounded text-[24px]" style="font-variation-settings:'FILL' 1;">grid_view</span>
            </div>
            <p class="mt-2 text-[11px] font-bold text-[#6b716c] group-hover:text-[#7ca81d] transition-colors">Browse all</p>
        </a>
        @endif
    </div>
</section>

{{-- ================================================================
     DEALS OF THE DAY
================================================================ --}}
@if($deals->isNotEmpty())
<section id="deals" class="max-w-7xl mx-auto px-4 sm:px-6 mt-10">
    <div class="flex items-end justify-between gap-3 mb-5">
        <div class="flex items-center gap-3">
            <span class="grid place-items-center w-11 h-11 rounded-2xl bg-[#dc2626] text-white shadow-lg shadow-red-500/20 shrink-0">
                <span class="material-symbols-rounded text-[20px]" style="font-variation-settings:'FILL' 1;">local_fire_department</span>
            </span>
            <div>
                <h2 class="text-lg sm:text-xl font-bold tracking-tight text-[#1c201e]">Deals of the day</h2>
                <p class="text-[12px] text-[#6b716c] -mt-0.5">Limited-time prices on verified items</p>
            </div>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#9acd32] hover:text-[#7ca81d] transition-colors whitespace-nowrap">
            See all <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
        </a>
    </div>
    <div x-data="autoScroll()" x-init="init()" class="flex gap-3.5 overflow-x-auto no-scrollbar pb-2">
        @foreach($deals as $p)
        <a href="{{ route('products.show', $p->slug) }}" class="group shrink-0 w-[10.5rem] sm:w-48 rounded-2xl bg-white border border-[#e8eae8] overflow-hidden hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-1 transition-all duration-300">
            <div class="relative aspect-square bg-[#f5f6f5] overflow-hidden">
                <img src="{{ $p->images->first()->url }}" alt="{{ $p->name }}" loading="lazy"
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#b8bdb9]\'><span class=\'material-symbols-rounded text-4xl\'>image</span></div>'">
                <span class="absolute top-2.5 left-2.5 rounded-lg bg-[#dc2626] text-white text-[11px] font-bold px-2 py-0.5 shadow-sm">-{{ $dealPct($p) }}%</span>
                <span class="absolute top-2.5 right-2.5 grid place-items-center w-7 h-7 rounded-lg bg-white/95 shadow-sm text-[#7ca81d] opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="material-symbols-rounded text-[14px]" style="font-variation-settings:'FILL' 1;">visibility</span>
                </span>
            </div>
            <div class="p-3">
                <p class="text-[12px] font-bold text-[#2e332f] line-clamp-1">{{ $p->name }}</p>
                <p class="text-[10px] text-[#9aa19c] truncate mt-0.5">{{ $p->store->name ?? '' }}</p>
                <div class="flex items-baseline gap-1.5 mt-1.5">
                    <span class="text-[15px] font-extrabold text-[#659316] tnum">{{ number_format($p->price) }} <span class="text-[10px]">F</span></span>
                    <span class="text-[11px] text-[#f97316] line-through tnum font-medium">{{ number_format($p->old_price) }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ================================================================
     RECOMMENDED FOR YOU
=============================================================== --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-12">
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5 mb-7">
        <div>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 -skew-x-6 rounded-md bg-gradient-to-r from-[#9acd32] to-[#86b92c] text-[#1c201e] text-[11px] font-extrabold uppercase tracking-[0.16em] shadow-[0_6px_18px_-6px_rgba(154,205,50,0.55)]">
                <span class="skew-x-6 inline-flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[14px]" style="font-variation-settings:'FILL' 1;">auto_awesome</span>
                    Hand-picked for you
                </span>
            </span>
            <h2 class="mt-3 text-xl sm:text-[1.7rem] font-extrabold tracking-tight text-[#1c201e]">Recommended for you</h2>
            <p class="text-[12px] text-[#6b716c] mt-1">Fresh picks from {{ number_format($verifiedStores) }}+ verified stores</p>
        </div>
    </div>

    @php $recommended = $trendingProducts->merge($latestProducts)->unique('id')->take(8); @endphp

    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-4 items-stretch auto-rows-fr gap-3.5 sm:gap-4 w-full">
        @forelse($recommended as $p)
            @include('partials.home-product-card', ['product' => $p, 'savedProductIds' => $savedProductIds])
        @empty
            <p class="col-span-full text-sm text-[#6b716c] text-center py-10">No products yet — be the first to list.</p>
        @endforelse
    </div>

    <div class="mt-9 text-center">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-lg -skew-x-6 bg-[#1c201e] text-white text-sm font-bold transition-all hover:bg-[#9acd32] hover:text-[#1c201e] shadow-lg shadow-black/10">
            <span class="skew-x-6 inline-flex items-center gap-2">
                View all products
                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
            </span>
        </a>
    </div>
</section>

{{-- ================================================================
     TOP STORES
================================================================ --}}
@if($topStores->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10">
    <div class="flex items-end justify-between gap-3 mb-5">
        <div>
            <h2 class="text-lg sm:text-xl font-bold tracking-tight text-[#1c201e]">Top stores</h2>
            <p class="text-[12px] text-[#6b716c] mt-0.5">The most active sellers on Izifai</p>
        </div>
        <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#9acd32] hover:text-[#7ca81d] transition-colors whitespace-nowrap">
            See all <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
        </a>
    </div>
    <div x-data="autoScroll()" x-init="init()" class="flex gap-3.5 overflow-x-auto no-scrollbar pb-2">
        @foreach($topStores as $store)
        <a href="{{ route('stores.show', $store->slug) }}"
           class="group shrink-0 w-[16rem] rounded-2xl bg-white border border-[#e8eae8] p-4 hover:border-[#9acd32]/50 hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.12)] transition-all duration-300 flex items-center gap-3.5">
            <div class="w-14 h-14 rounded-2xl bg-[#eef0ee] overflow-hidden grid place-items-center border border-black/5 shrink-0">
                @if($store->logo)
                    <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-extrabold text-[#3f4f0e]">{{ strtoupper(substr($store->name, 0, 1)) }}</span>
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-[13px] font-bold text-[#1c201e] truncate inline-flex items-center gap-1">
                    {{ $store->name }}
                    @if($store->is_verified)
                        <span class="material-symbols-rounded text-[13px] text-[#659316]" style="font-variation-settings:'FILL' 1;">verified</span>
                    @endif
                </p>
                <div class="flex items-center gap-2 mt-0.5">
                    @if(($store->rating ?? 0) > 0)
                    <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-[#6b716c]">
                        <span class="material-symbols-rounded text-[13px] text-amber-400" style="font-variation-settings:'FILL' 1;">star</span>
                        {{ number_format($store->rating, 1) }}
                    </span>
                    @endif
                    <span class="text-[11px] text-[#9aa19c]">{{ $store->products_count }} products</span>
                </div>
            </div>
            <span class="grid place-items-center w-9 h-9 rounded-full bg-[#f2f9df] text-[#7ca81d] group-hover:bg-[#9acd32] group-hover:text-white transition-colors shrink-0">
                <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
            </span>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ================================================================
     FEATURED STORE SPOTLIGHT
================================================================ --}}
@if($featuredStore)
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10">
    <div class="rounded-3xl bg-[#1c201e] overflow-hidden relative">
        <div class="absolute -top-20 -right-10 w-72 h-72 rounded-full bg-[#9acd32]/10 blur-3xl"></div>
        <div class="grid lg:grid-cols-[1fr_auto] gap-6 p-6 sm:p-10 items-center">
            <div class="relative z-10">
                <span class="inline-flex items-center gap-2 rounded-full bg-[#9acd32]/15 border border-[#9acd32]/25 px-3.5 py-1.5 text-[11px] font-bold text-[#9acd32]">
                    <span class="material-symbols-rounded text-[14px]" style="font-variation-settings:'FILL' 1;">workspace_premium</span>
                    Store spotlight
                </span>
                <div class="mt-4 flex items-center gap-4">
                    @if($featuredStore->logo)
                        <img src="{{ $featuredStore->logo_url }}" alt="" class="w-16 h-16 rounded-2xl object-cover ring-2 ring-white/15">
                    @else
                        <span class="grid place-items-center w-16 h-16 rounded-2xl bg-[#9acd32] text-[#1c201e] text-2xl font-black">{{ strtoupper(substr($featuredStore->name, 0, 1)) }}</span>
                    @endif
                    <div class="min-w-0">
                        <h2 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight flex items-center gap-1.5">
                            {{ $featuredStore->name }}
                            @if($featuredStore->is_verified)
                                <span class="material-symbols-rounded text-[18px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">verified</span>
                            @endif
                        </h2>
                        <div class="flex items-center gap-3 mt-1 text-[12px] text-white/60">
                            @if(($featuredStore->rating ?? 0) > 0)
                            <span class="inline-flex items-center gap-1 font-bold text-white/80">
                                <span class="material-symbols-rounded text-[14px] text-amber-400" style="font-variation-settings:'FILL' 1;">star</span>
                                {{ number_format($featuredStore->rating, 1) }}
                            </span>
                            @endif
                            <span>{{ $featuredStore->products_count }} products</span>
                            @if($featuredStore->location)
                                <span class="inline-flex items-center gap-1"><span class="material-symbols-rounded text-[13px]" style="font-variation-settings:'FILL' 1;">location_on</span>{{ $featuredStore->location }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-sm text-white/65 max-w-md leading-relaxed line-clamp-2">{{ $featuredStore->description }}</p>
                <a href="{{ route('stores.show', $featuredStore->slug) }}" class="ecom-btn mt-6 h-12 px-7 text-sm bg-[#9acd32] text-white shadow-lg shadow-[#9acd32]/20 hover:bg-[#7ca81d]">
                    Visit store
                    <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
                </a>
            </div>

            @if($featuredStore->products->isNotEmpty())
            <div class="relative z-10 flex gap-3 overflow-x-auto no-scrollbar lg:max-w-md">
                @foreach($featuredStore->products->take(3) as $fp)
                <a href="{{ route('products.show', $fp->slug) }}" class="shrink-0 w-36 sm:w-44 rounded-2xl overflow-hidden bg-white group/product hover:shadow-xl transition-shadow">
                    <div class="relative aspect-square bg-[#f5f6f5]">
                        <img src="{{ $fp->images->first()->url ?? '' }}" alt="{{ $fp->name }}" loading="lazy"
                             class="w-full h-full object-cover group-hover/product:scale-105 transition-transform duration-500"
                             onerror="this.classList.add('hidden')">
                    </div>
                    <div class="p-2.5">
                        <p class="text-[11px] font-bold text-[#1c201e] truncate">{{ $fp->name }}</p>
                        <p class="text-[12px] font-black text-[#659316] tnum">{{ number_format($fp->price) }} <span class="text-[9px]">F</span></p>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     POPULAR SERVICES
================================================================ --}}
@if($topRatedServices->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10">
    <div class="flex items-end justify-between gap-3 mb-5">
        <div>
            <h2 class="text-lg sm:text-xl font-bold tracking-tight text-[#1c201e]">Popular services</h2>
            <p class="text-[12px] text-[#6b716c] mt-0.5">Top-rated professionals near you</p>
        </div>
        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1 text-sm font-bold text-[#9acd32] hover:text-[#7ca81d] transition-colors whitespace-nowrap">
            All services <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
        </a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
        @foreach($topRatedServices as $svc)
        <a href="{{ route('services.show', $svc->slug) }}"
           class="group rounded-2xl bg-white border border-[#e8eae8] p-4 hover:border-[#9acd32]/50 hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.12)] hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-3">
                <span class="grid place-items-center w-11 h-11 rounded-xl bg-[#f2f9df] text-[#659316] shrink-0">
                    <span class="material-symbols-rounded text-[20px]" style="font-variation-settings:'FILL' 1;">handyman</span>
                </span>
                <div class="min-w-0">
                    <p class="text-[13px] font-bold text-[#1c201e] truncate group-hover:text-[#659316] transition-colors">{{ $svc->name }}</p>
                    <p class="text-[11px] text-[#9aa19c] truncate">{{ $svc->store->name ?? '' }}</p>
                </div>
            </div>
            <div class="flex items-center justify-between mt-4">
                <span class="text-[13px] font-black text-[#659316] tnum">
                    @if($svc->price > 0){{ number_format($svc->price) }} F @else Request quote @endif
                </span>
                @if(($svc->rating ?? 0) > 0)
                <span class="inline-flex items-center gap-0.5 text-[11px] font-bold text-[#6b716c]">
                    <span class="material-symbols-rounded text-[13px] text-amber-400" style="font-variation-settings:'FILL' 1;">star</span>
                    {{ number_format($svc->rating, 1) }}
                </span>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ================================================================
     SELLER CTA
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 mb-4">
    <div class="rounded-3xl bg-gradient-to-br from-[#1c201e] to-[#0d0f0d] px-6 sm:px-12 py-10 sm:py-12 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-7 relative overflow-hidden">
        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-[#9acd32]/10 blur-3xl"></div>
        <div class="relative z-10">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 border border-white/10 px-3.5 py-1.5 text-[11px] font-bold text-[#9acd32]">
                <span class="material-symbols-rounded text-[14px]" style="font-variation-settings:'FILL' 1;">storefront</span>
                Free to start
            </span>
            <h2 class="mt-4 text-xl sm:text-2xl font-extrabold text-white tracking-tight">Sell everything. In one link.</h2>
            <p class="mt-2 text-sm text-white/65 max-w-md">No app. No complex setup. Share your catalog on WhatsApp and start selling today.</p>
            <div class="mt-5 flex flex-wrap gap-x-6 gap-y-2 text-[11px] font-semibold text-white/65">
                <span class="inline-flex items-center gap-1.5"><span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">check_circle</span> No tech skills needed</span>
                <span class="inline-flex items-center gap-1.5"><span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">check_circle</span> Lists in minutes</span>
                <span class="inline-flex items-center gap-1.5"><span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">check_circle</span> Shareable in seconds</span>
            </div>
        </div>
        @auth
            <a href="{{ route('seller.dashboard') }}" class="relative z-10 ecom-btn h-12 px-8 text-sm bg-[#9acd32] text-white shadow-lg shadow-[#9acd32]/20 hover:bg-[#7ca81d] shrink-0">
                Open seller dashboard
                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
            </a>
        @else
            <a href="{{ route('register') }}" class="relative z-10 ecom-btn h-12 px-8 text-sm bg-[#9acd32] text-white shadow-lg shadow-[#9acd32]/20 hover:bg-[#7ca81d] shrink-0">
                Create your store
                <span class="material-symbols-rounded text-[18px]" style="font-variation-settings:'FILL' 1;">arrow_forward</span>
            </a>
        @endauth
    </div>
</section>

@endsection

@push('scripts')
<script>
    window.homeHero = (total) => ({
        total: total,
        index: 0,
        timer: null,
        startX: 0,
        dragging: false,
        movedX: 0,

        init() {
            this.$nextTick(() => { this.resume(); });
        },
        pause() { if (this.timer) { clearInterval(this.timer); this.timer = null; } },
        resume() {
            this.pause();
            this.timer = setInterval(() => { this.go((this.index + 1) % this.total); }, 6000);
        },
        go(i) { this.index = (i + this.total) % this.total; },
        down(e) { this.startX = e.clientX; this.movedX = 0; this.dragging = true; this.pause(); },
        move(e) { if (this.dragging) this.movedX = e.clientX - this.startX; },
        up() {
            if (!this.dragging) return;
            this.dragging = false;
            if (this.movedX < -48) this.go(this.index + 1);
            else if (this.movedX > 48) this.go(this.index - 1);
            this.resume();
        }
    });
</script>

<script>
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.product;
            const icon = this.querySelector('.material-symbols-rounded');
            @auth
                fetch('/products/' + productId + '/favorite', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    this.dataset.favorited = data.favorited ? 'true' : 'false';
                    if (data.favorited) {
                        icon.classList.remove('text-on-surface-variant/50');
                        icon.classList.add('text-[#dc2626]');
                        icon.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        icon.classList.remove('text-[#dc2626]');
                        icon.classList.add('text-on-surface-variant/50');
                        icon.style.fontVariationSettings = "'FILL' 0";
                    }
                })
                .catch(() => {});
            @else
                window.location.href = '{{ route('login') }}';
            @endauth
        });
    });
</script>
@endpush