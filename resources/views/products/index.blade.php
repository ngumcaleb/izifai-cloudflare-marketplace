@extends('layouts.guest')

@section('title', $title . ' — Izifai')
@section('description', $description)

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }
    .tnum { font-variant-numeric: tabular-nums; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .ecom-btn { display: inline-flex; align-items: center; justify-content: center; gap: .5rem; border-radius: 9999px; font-weight: 600; transition: background .15s ease, transform .1s ease, box-shadow .2s ease; cursor: pointer; }
    .ecom-btn:active { transform: scale(.97); }
    .favorite-btn:active { transform: scale(0.85); }
    .favorite-btn.bumping { animation: favBump 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes favBump { 0% { transform: scale(1); } 40% { transform: scale(1.3); } 100% { transform: scale(1); } }
    .filter-sheet { transform: translateY(100%); transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-sheet.open { transform: translateY(0); }
</style>
@endpush

@section('content')
<div x-data="{ openMobileFilters: false, openPriceDropdown: false }" class="pb-16 sm:pb-24">

    {{-- ================================================================
         1. HERO HEADER BANNER (Consistent with Home Theme)
    ================================================================ --}}
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-4 sm:mt-6">
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-[#1c201e] border border-black/5 shadow-[0_14px_44px_-16px_rgba(0,0,0,0.18)] p-5 sm:p-10 lg:p-12 text-white">
            {{-- Ambient glow orbs --}}
            <div class="absolute -top-24 -right-16 w-80 h-80 rounded-full bg-[#9acd32]/15 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-28 -left-16 w-72 h-72 rounded-full bg-[#7ca81d]/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                {{-- Skewed Kicker Badge --}}
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 -skew-x-6 rounded-md bg-gradient-to-r from-[#9acd32] to-[#86b92c] text-[#1c201e] text-[10px] sm:text-[11px] font-extrabold uppercase tracking-[0.16em] shadow-[0_6px_18px_-6px_rgba(154,205,50,0.55)]">
                    <span class="skew-x-6 inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-{{ request('q') ? 'magnifying-glass' : 'store' }} text-[14px]"></i>
                        {{ request('q') ? 'Search Results' : 'Verified Marketplace' }}
                    </span>
                </span>

                <h1 class="mt-4 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-[1.15]">
                    {{ $title }}
                </h1>

                <p class="mt-2 text-xs sm:text-sm text-white/75 leading-relaxed max-w-xl">
                    {{ $description }}
                </p>

                {{-- Mobile-only filter trigger (filtering on mobile happens in the sheet) --}}
                @php $filterCount = count(array_filter([request('category'), request('min_price'), request('max_price')])); @endphp
                <button @click="openMobileFilters = true"
                        class="lg:hidden mt-5 inline-flex items-center gap-2 h-10 px-4 rounded-xl bg-[#9acd32] text-[#1c201e] text-[12px] font-extrabold shadow-md hover:bg-[#86b92c] active:scale-[0.97] transition-all">
                    <i class="fa-solid fa-sliders text-[15px]" style=""></i>
                    Filters
                    @if($filterCount > 0)
                        <span class="w-5 h-5 rounded-full bg-[#1c201e] text-[#9acd32] text-[10px] font-extrabold flex items-center justify-center">{{ $filterCount }}</span>
                    @endif
                </button>

                {{-- Highlights / Quick Stats --}}
                <div class="mt-5 sm:mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-[10.5px] sm:text-xs font-semibold text-white/80">
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-boxes-stacked text-[14px] text-[#9acd32]" style=""></i>
                        <strong class="text-white">{{ number_format($products->total()) }}</strong> products found
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-[14px] text-[#9acd32]" style=""></i>
                        Verified sellers
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-lock text-[14px] text-[#9acd32]" style=""></i>
                        Escrow protection
                    </span>
                </div>

                {{-- Active Filters Pills --}}
                @php
                    $hasActiveFilters = request('q') || request('category') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'random');
                @endphp
                @if($hasActiveFilters)
                    <div class="mt-5 pt-4 border-t border-white/10 flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold text-white/50 uppercase tracking-wider">Active:</span>

                        @if(request('q'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    "{{ request('q') }}"
                                    <a href="{{ route('products.index', request()->except(['q', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('category'))
                            @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-[#9acd32] text-[#1c201e] text-[11px] font-extrabold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ $activeCat->name ?? request('category') }}
                                    <a href="{{ route('products.index', request()->except(['category', 'page'])) }}" class="hover:opacity-75 transition-opacity ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    @if(request('min_price') && request('max_price'))
                                        {{ number_format((int)request('min_price')) }} – {{ number_format((int)request('max_price')) }} F
                                    @elseif(request('min_price'))
                                        From {{ number_format((int)request('min_price')) }} F
                                    @else
                                        Up to {{ number_format((int)request('max_price')) }} F
                                    @endif
                                    <a href="{{ route('products.index', request()->except(['min_price', 'max_price', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('sort') && request('sort') !== 'random')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ request('sort') === 'price_low' ? 'Price: Low → High' : 'Price: High → Low' }}
                                    <a href="{{ route('products.index', request()->except(['sort', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        <a href="{{ route('products.index') }}" class="text-[11px] font-bold text-[#9acd32] hover:text-[#b0ea3d] underline transition-colors ml-1">
                            Reset all
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ================================================================
         2. TRENDING NOW STRIP (catches the eye right under the header)
    ================================================================ --}}
    @if(isset($trendingProducts) && $trendingProducts->count() > 0 && !request('q'))
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-5 sm:mt-6">
        <div class="flex items-center gap-2.5 sm:gap-3 mb-3.5 sm:mb-5">
            <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#dc2626] text-white shadow-md sm:shadow-lg shadow-red-500/20 shrink-0">
                <i class="fa-solid fa-fire text-[16px] sm:text-[20px]" style=""></i>
            </span>
            <div>
                <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Trending Now</h2>
                <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Most popular items buyers are looking at today</p>
            </div>
        </div>

        <div class="flex gap-2 sm:gap-2.5 overflow-x-auto no-scrollbar pb-2">
            @foreach($trendingProducts as $p)
                @php
                    $dPct = $p->old_price && $p->old_price > $p->price ? round((1 - $p->price / $p->old_price) * 100) : 0;
                @endphp
                <a href="{{ route('products.show', $p->slug) }}" class="group shrink-0 w-[8.75rem] sm:w-48 rounded-xl sm:rounded-2xl bg-white border border-[#e8eae8] overflow-hidden hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-square bg-[#f5f6f5] overflow-hidden">
                        @if($p->images->first())
                            <img src="{{ $p->images->first()->url }}" alt="{{ $p->name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                <i class="fa-solid fa-image text-4xl"></i>
                            </div>
                        @endif

                        @if($dPct > 0)
                            <span class="absolute top-2 sm:top-2.5 left-2 sm:left-2.5 rounded-md sm:rounded-lg bg-[#dc2626] text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 shadow-sm">-{{ $dPct }}%</span>
                        @endif
                    </div>
                    <div class="p-2.5 sm:p-3">
                        <p class="text-[10.5px] sm:text-[12px] font-bold text-[#1c201e] line-clamp-1 group-hover:text-[#7ca81d] transition-colors">{{ $p->name }}</p>
                        <p class="text-[8.5px] sm:text-[10px] text-[#9aa19c] truncate mt-0.5">{{ $p->store->name ?? 'Marketplace' }}</p>
                        <div class="flex items-baseline gap-1.5 mt-1 sm:mt-1.5">
                            <span class="text-[12px] sm:text-[14px] font-black text-[#659316] tnum">{{ number_format($p->price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                            @if($p->old_price && $p->old_price > $p->price)
                                <span class="text-[10px] sm:text-[11px] text-[#f97316] line-through tnum font-medium">{{ number_format($p->old_price) }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         3. CATEGORIES HORIZONTAL BAR
    ================================================================ --}}
    @if($categories->isNotEmpty())
    <section class="hidden lg:block max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            {{-- All Categories chip --}}
            <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
               class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ !request('category') ? '-skew-x-6 bg-[#1c201e] text-[#9acd32] shadow-sm' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                <span class="{{ !request('category') ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                    <i class="fa-solid fa-table-cells text-[16px]" style=""></i>
                    All Products
                </span>
            </a>

            @foreach($categories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ $isActive ? '-skew-x-6 bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/30' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                    <span class="{{ $isActive ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                        {{ $cat->name }}
                        @if(($cat->products_count ?? 0) > 0)
                            <span class="text-[10px] opacity-75 font-semibold">({{ $cat->products_count }})</span>
                        @endif
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         4. TOOLBAR / FILTER & SORT STRIP
    ================================================================ --}}
    <section class="hidden lg:block max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-2.5 sm:p-4 flex flex-wrap items-center justify-between gap-2.5 sm:gap-3 shadow-sm">
            {{-- Left: quick indicators --}}
            <div class="flex items-center gap-2.5">
                {{-- Desktop Quick Price Filter Form --}}
                <form method="GET" action="{{ route('products.index') }}" class="hidden lg:flex items-center gap-2">
                    @foreach(request()->except(['min_price', 'max_price', 'page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach

                    <div class="flex items-center bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl px-2.5 h-10 gap-1.5 focus-within:border-[#9acd32] focus-within:bg-white transition-all">
                        <span class="text-[11px] font-bold text-[#9aa19c]">Price:</span>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min F"
                               class="w-20 bg-transparent text-[12px] font-semibold text-[#1c201e] placeholder:text-[#9aa19c] outline-none">
                        <span class="text-[#9aa19c] text-xs">–</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max F"
                               class="w-20 bg-transparent text-[12px] font-semibold text-[#1c201e] placeholder:text-[#9aa19c] outline-none">
                        <button type="submit" class="w-6 h-6 rounded-lg bg-[#1c201e] text-white flex items-center justify-center hover:bg-[#9acd32] hover:text-[#1c201e] transition-colors">
                            <i class="fa-solid fa-arrow-right text-[14px]"></i>
                        </button>
                    </div>
                </form>

                {{-- Results Count --}}
                <span class="text-xs font-semibold text-[#6b716c] hidden sm:inline-block">
                    Showing <strong class="text-[#1c201e]">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</strong> of <strong class="text-[#1c201e]">{{ number_format($products->total()) }}</strong> items
                </span>
            </div>

            {{-- Right: Sort Selector --}}
            <div class="flex items-center gap-2 ml-auto">
                <span class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-wider hidden sm:inline">Sort:</span>
                <div class="relative">
                    <select onchange="window.location.href=this.value"
                            class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                        @foreach([
                            'random' => 'Recommended',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low'
                        ] as $val => $label)
                            <option value="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                    {{ request('sort', 'random') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[16px] text-[#6b716c] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         5. MAIN PRODUCT GRID (Wall-to-Wall 4 Cards on PC View)
    ================================================================ --}}
    <section id="products-section" class="max-w-7xl mx-auto px-1 sm:px-6 mt-3 sm:mt-6">
        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 items-stretch auto-rows-fr gap-2.5 sm:gap-4 w-full">
                @foreach($products as $product)
                    @include('partials.home-product-card', ['product' => $product, 'savedProductIds' => $savedProductIds])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10 sm:mt-12 flex justify-center">
                {{ $products->links('partials.pagination') }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-[#e8eae8] p-10 sm:p-16 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#f2f9df] text-[#659316] flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-boxes-stacked text-4xl sm:text-5xl" style=""></i>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No products found</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto leading-relaxed">
                    @if($hasActiveFilters)
                        We couldn't find any products matching your selected filters. Try broadening your criteria or reset filters.
                    @else
                        No products have been listed in this catalog yet. Check back soon or explore our stores.
                    @endif
                </p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('products.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg -skew-x-6 bg-[#1c201e] text-white text-xs font-bold hover:bg-[#9acd32] hover:text-[#1c201e] transition-all shadow-md">
                            <span class="skew-x-6 flex items-center gap-1.5">
                                <i class="fa-solid fa-arrows-rotate text-[15px]"></i>
                                Reset Filters
                            </span>
                        </a>
                    @endif
                    <a href="{{ route('stores.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg -skew-x-6 bg-[#f2f9df] text-[#659316] text-xs font-bold hover:bg-[#9acd32] hover:text-[#1c201e] transition-all">
                        <span class="skew-x-6 flex items-center gap-1.5">
                            <i class="fa-solid fa-store text-[15px]"></i>
                            Explore Stores
                        </span>
                    </a>
                </div>
            </div>
        @endif
    </section>

    {{-- ================================================================
         5. TOP STORES STRIP (Matching Home "Top stores" aesthetic)
    ================================================================ --}}
    @if(isset($topStores) && $topStores->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 sm:mt-14">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div>
                <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Top Verified Stores</h2>
                <p class="text-[10px] sm:text-[12px] text-[#6b716c] mt-0.5">Reliable merchants shipping across Cameroon</p>
            </div>
            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap">
                View all stores <i class="fa-solid fa-arrow-right text-[14px] sm:text-[15px]" style=""></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4">
            @foreach($topStores as $store)
                <a href="{{ route('stores.show', $store->slug) }}"
                   class="group rounded-xl sm:rounded-2xl bg-white border border-[#e8eae8] p-3 sm:p-4 hover:border-[#9acd32]/50 hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.12)] transition-all duration-300 flex items-center gap-3 sm:gap-3.5">
                    <div class="w-11 h-11 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-[#eef0ee] overflow-hidden grid place-items-center border border-black/5 shrink-0">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-[11px] sm:text-sm font-extrabold text-[#3f4f0e]">{{ strtoupper(substr($store->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-[12px] sm:text-[13px] font-bold text-[#1c201e] truncate inline-flex items-center gap-1">
                            {{ $store->name }}
                            @if($store->is_verified)
                                <i class="fa-solid fa-circle-check text-[12px] sm:text-[13px] text-[#659316]" style=""></i>
                            @endif
                        </p>
                        <div class="flex items-center gap-2 mt-0.5">
                            @if(($store->rating ?? 0) > 0)
                                <span class="inline-flex items-center gap-0.5 text-[10px] sm:text-[11px] font-bold text-[#6b716c]">
                                    <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                                    {{ number_format($store->rating, 1) }}
                                </span>
                            @endif
                            <span class="text-[10px] sm:text-[11px] text-[#9aa19c]">{{ $store->products_count }} products</span>
                        </div>
                    </div>
                    <span class="grid place-items-center w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#f2f9df] text-[#7ca81d] group-hover:bg-[#9acd32] group-hover:text-[#1c201e] transition-colors shrink-0">
                        <i class="fa-solid fa-arrow-right text-[13px] sm:text-[16px]" style=""></i>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         7. MOBILE FILTER BOTTOM SHEET
    ================================================================ --}}
    <div x-cloak x-show="openMobileFilters" class="fixed inset-0 z-50 lg:hidden" style="display: none;">
        {{-- Backdrop --}}
        <div x-show="openMobileFilters"
             x-transition:enter="transition-opacity duration-300"
             x-transition:leave="transition-opacity duration-200"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"
             @click="openMobileFilters = false"></div>

        {{-- Sheet --}}
        <div x-show="openMobileFilters"
             x-transition:enter="transition-transform duration-300 ease-out"
             x-transition:leave="transition-transform duration-250 ease-in"
             class="filter-sheet open absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] pb-16 sm:pb-4 overflow-y-auto shadow-2xl flex flex-col">

            {{-- Sheet Header --}}
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-[#eff1ef] px-5 py-4 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[20px] text-[#7ca81d]" style=""></i>
                    <h3 class="text-sm font-extrabold text-[#1c201e]">Filter Products</h3>
                </div>
                <div class="flex items-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('products.index') }}" class="text-xs font-bold text-[#7ca81d] hover:underline">Reset</a>
                    @endif
                    <button @click="openMobileFilters = false" class="w-8 h-8 rounded-full bg-[#f5f6f5] flex items-center justify-center text-[#1c201e]">
                        <i class="fa-solid fa-xmark text-[18px]"></i>
                    </button>
                </div>
            </div>

            <div class="p-5 space-y-6">
                {{-- Categories Filter --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Category</h4>
                    <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                        <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ !request('category') ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                            All Categories
                            @if(!request('category'))
                                <i class="fa-solid fa-check text-[16px]"></i>
                            @endif
                        </a>
                        @foreach($categories as $c)
                            @php $isCActive = request('category') === $c->slug; @endphp
                            <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $c->slug])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ $isCActive ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                                <span>{{ $c->name }}</span>
                                @if($isCActive)
                                    <i class="fa-solid fa-check text-[16px]"></i>
                                @else
                                    <span class="text-[10px] text-[#9aa19c] font-semibold">{{ $c->products_count }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range Filter --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Price Range (FCFA)</h4>
                    <form method="GET" action="{{ route('products.index') }}">
                        @foreach(request()->except(['min_price', 'max_price', 'page']) as $k => $v)
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                        @endforeach
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                                   class="w-full h-11 px-3 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-xs font-semibold text-[#1c201e] outline-none focus:border-[#9acd32]">
                            <span class="text-[#9aa19c] font-bold text-xs">to</span>
                            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                                   class="w-full h-11 px-3 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-xs font-semibold text-[#1c201e] outline-none focus:border-[#9acd32]">
                        </div>
                        <button type="submit" class="mt-3 w-full h-11 rounded-xl bg-[#1c201e] text-white font-bold text-xs hover:bg-[#9acd32] hover:text-[#1c201e] transition-colors">
                            Apply Price Range
                        </button>
                    </form>
                </div>

                {{-- Sort Filter --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Sort Order</h4>
                    <div class="space-y-1">
                        @foreach([
                            'random' => 'Recommended',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low'
                        ] as $sVal => $sLabel)
                            @php $isSortActive = request('sort', 'random') === $sVal; @endphp
                            <a href="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $sVal])) }}"
                               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold {{ $isSortActive ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                                {{ $sLabel }}
                                @if($isSortActive)
                                    <i class="fa-solid fa-check text-[16px]"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to products if query or filter applied
        const params = new URLSearchParams(window.location.search);
        const filterParams = ['q', 'category', 'min_price', 'max_price', 'sort'];
        const hasFilters = filterParams.some(p => {
            const v = params.get(p);
            return p === 'sort' ? (v && v !== 'random') : Boolean(v);
        });

        if (hasFilters && !window.location.hash) {
            const el = document.getElementById('products-section');
            if (el) {
                setTimeout(() => el.scrollIntoView({ behavior: 'smooth', block: 'start' }), 120);
            }
        }
    });

    // Favorite heart button AJAX toggle
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.favorite-btn');
        if (!btn) return;
        e.preventDefault();
        e.stopPropagation();

        btn.classList.add('bumping');
        setTimeout(() => btn.classList.remove('bumping'), 400);

        const productId = btn.dataset.product;

        @auth
            fetch('{{ url('/products') }}/' + productId + '/favorite', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            }).then(r => r.json()).then(data => {
                const icon = btn.querySelector('i.fa-heart') || btn.querySelector('i.fa-heart');
                if (!icon) return;

                if (data.favorited) {
                    icon.classList.add('fa-solid'); icon.classList.remove('fa-regular');
                    icon.classList.add('text-[#dc2626]');
                    icon.classList.remove('text-[#5c625e]');
                    btn.dataset.favorited = 'true';
                } else {
                    icon.classList.add('fa-regular'); icon.classList.remove('fa-solid');
                    icon.classList.remove('text-[#dc2626]');
                    icon.classList.add('text-[#5c625e]');
                    btn.dataset.favorited = 'false';
                }
            }).catch(err => console.error('Favorite error:', err));
        @endauth

        @guest
            window.location.href = '{{ route('login') }}';
        @endguest
    });
</script>
@endpush
