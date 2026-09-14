@extends('layouts.guest')

@section('title', $title . ' — Izifai')
@section('description', $description)

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }
    .tnum { font-variant-numeric: tabular-nums; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush

@section('content')
<div x-data="{ openMobileFilters: false }" class="pb-16 sm:pb-24">

    {{-- ================================================================
         1. HERO HEADER BANNER (Strict Izifai Theme)
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
                        <i class="fa-solid fa-screwdriver-wrench text-[14px]" style=""></i>
                        Equipment & Vehicle Rentals
                    </span>
                </span>

                <h1 class="mt-4 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-[1.15]">
                    {{ $title }}
                </h1>

                <p class="mt-2 text-xs sm:text-sm text-white/75 leading-relaxed max-w-xl">
                    {{ $description }}
                </p>

                {{-- Highlights / Quick Stats --}}
                <div class="mt-5 sm:mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-[10.5px] sm:text-xs font-semibold text-white/80">
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-boxes-stacked text-[14px] text-[#9acd32]" style=""></i>
                        <strong class="text-white">{{ number_format($rentals->total()) }}</strong> items available
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-[14px] text-[#9acd32]" style=""></i>
                        Verified owners
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved text-[14px] text-[#9acd32]" style=""></i>
                        Escrow deposit protection
                    </span>
                </div>

                {{-- Active Filters Pills --}}
                @php
                    $hasActiveFilters = request('q') || request('category') || request('billing_unit') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'latest');
                @endphp
                @if($hasActiveFilters)
                    <div class="mt-5 pt-4 border-t border-white/10 flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold text-white/50 uppercase tracking-wider">Active:</span>

                        @if(request('q'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    "{{ request('q') }}"
                                    <a href="{{ route('rentals.index', request()->except(['q', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('category'))
                            @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-[#9acd32] text-[#1c201e] text-[11px] font-extrabold shadow-sm">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ $activeCat->name ?? request('category') }}
                                    <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}" class="hover:opacity-75 transition-opacity ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('billing_unit'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    Period: {{ ucfirst(request('billing_unit')) }}
                                    <a href="{{ route('rentals.index', request()->except(['billing_unit', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('min_price') || request('max_price'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ number_format(request('min_price', 0)) }} - {{ request('max_price') ? number_format(request('max_price')) : '∞' }} F
                                    <a href="{{ route('rentals.index', request()->except(['min_price', 'max_price', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('sort') && request('sort') !== 'latest')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ request('sort') === 'price_low' ? 'Price: Low → High' : (request('sort') === 'price_high' ? 'Price: High → Low' : 'Most Viewed') }}
                                    <a href="{{ route('rentals.index', request()->except(['sort', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        <a href="{{ route('rentals.index') }}" class="text-[11px] font-bold text-[#9acd32] hover:text-[#b0ea3d] underline transition-colors ml-1">
                            Reset all
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ================================================================
         2. CATEGORIES HORIZONTAL BAR (Exact Products Aesthetic)
    ================================================================ --}}
    @if($categories->isNotEmpty())
    <section class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            {{-- All Categories chip --}}
            <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}"
               class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ !request('category') ? '-skew-x-6 bg-[#1c201e] text-[#9acd32] shadow-sm' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                <span class="{{ !request('category') ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                    <i class="fa-solid fa-table-cells text-[16px]" style=""></i>
                    All Gear
                </span>
            </a>

            @foreach($categories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('rentals.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ $isActive ? '-skew-x-6 bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/30' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                    <span class="{{ $isActive ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                        {{ $cat->name }}
                        @if(($cat->rental_items_count ?? 0) > 0)
                            <span class="text-[10px] opacity-75 font-semibold">({{ $cat->rental_items_count }})</span>
                        @endif
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         3. TOOLBAR / FILTER & SORT STRIP (Identical to Products)
    ================================================================ --}}
    <section class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-2.5 sm:p-4 flex flex-wrap items-center justify-between gap-2.5 sm:gap-3 shadow-sm">
            {{-- Left: Filter button & quick indicators --}}
            <div class="flex items-center gap-2.5 flex-wrap">
                {{-- Mobile Filter Trigger --}}
                <button @click="openMobileFilters = true"
                        class="lg:hidden inline-flex items-center gap-2 h-10 px-4 rounded-xl bg-[#f5f6f5] border border-[#e0e3e0] text-[#1c201e] text-[12px] font-bold hover:bg-[#eceeed] transition-all">
                    <i class="fa-solid fa-sliders text-[18px]" style=""></i>
                    Filters
                    @php $filterCount = collect([request('category'), request('billing_unit'), request('min_price'), request('max_price')])->filter()->count(); @endphp
                    @if($filterCount > 0)
                        <span class="w-5 h-5 rounded-full bg-[#9acd32] text-[#1c201e] text-[10px] font-extrabold flex items-center justify-center">{{ $filterCount }}</span>
                    @endif
                </button>

                {{-- Desktop Quick Price Filter Form --}}
                <form method="GET" action="{{ route('rentals.index') }}" class="hidden lg:flex items-center gap-2">
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

                {{-- Desktop Billing Period Selector --}}
                <div class="relative hidden sm:block">
                    <select onchange="window.location.href=this.value"
                            class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                        <option value="{{ route('rentals.index', request()->except(['billing_unit', 'page'])) }}" {{ !request('billing_unit') ? 'selected' : '' }}>
                            Period: All
                        </option>
                        @foreach(['hourly' => 'Per Hour', 'daily' => 'Per Day', 'weekly' => 'Per Week', 'monthly' => 'Per Month'] as $val => $label)
                            <option value="{{ route('rentals.index', array_merge(request()->except(['billing_unit', 'page']), ['billing_unit' => $val])) }}"
                                    {{ request('billing_unit') === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down text-[16px] text-[#6b716c] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                </div>

                {{-- Results Count --}}
                <span class="text-xs font-semibold text-[#6b716c] hidden sm:inline-block">
                    Showing <strong class="text-[#1c201e]">{{ $rentals->firstItem() ?? 0 }}–{{ $rentals->lastItem() ?? 0 }}</strong> of <strong class="text-[#1c201e]">{{ number_format($rentals->total()) }}</strong> items
                </span>
            </div>

            {{-- Right: Sort Selector --}}
            <div class="flex items-center gap-2 ml-auto">
                <span class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-wider hidden sm:inline">Sort:</span>
                <div class="relative">
                    <select onchange="window.location.href=this.value"
                            class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                        @foreach([
                            'latest' => 'Latest Listed',
                            'popular' => 'Most Viewed',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low'
                        ] as $val => $label)
                            <option value="{{ route('rentals.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                    {{ request('sort', 'latest') === $val ? 'selected' : '' }}>
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
         4. MAIN RENTALS GRID (Wall-to-Wall 4 Cards on PC View, 2 on Mobile)
    ================================================================ --}}
    <section id="rentals-section" class="max-w-7xl mx-auto px-1 sm:px-6 mt-3 sm:mt-6">
        @if($rentals->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 items-stretch auto-rows-fr gap-2.5 sm:gap-4 w-full">
                @foreach($rentals as $item)
                    @include('rentals.partials.rental-card', ['item' => $item])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10 sm:mt-12 flex justify-center">
                {{ $rentals->links('partials.pagination') }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-[#e8eae8] p-10 sm:p-16 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#f2f9df] text-[#659316] flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-screwdriver-wrench text-4xl sm:text-5xl" style=""></i>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No rentals found</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto leading-relaxed">
                    @if($hasActiveFilters)
                        We couldn't find any rentals matching your selected filters. Try broadening your criteria or reset filters.
                    @else
                        No rental equipment has been listed in this catalog yet. Check back soon or explore our stores.
                    @endif
                </p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('rentals.index') }}"
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
         5. FEATURED / HIGH DEMAND RENTALS (Matching Products Trending Strip)
    ================================================================ --}}
    @if(isset($featuredRentals) && $featuredRentals->count() > 0 && !request('q'))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 sm:mt-14">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#dc2626] text-white shadow-md sm:shadow-lg shadow-red-500/20 shrink-0">
                    <i class="fa-solid fa-fire text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">High-Demand Gear</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Most booked equipment and tools this week</p>
                </div>
            </div>
        </div>

        <div class="flex gap-2 sm:gap-3.5 overflow-x-auto no-scrollbar pb-2">
            @foreach($featuredRentals as $item)
                <a href="{{ route('rentals.show', $item->slug) }}" class="group shrink-0 w-[8.75rem] sm:w-48 rounded-xl sm:rounded-2xl bg-white border border-[#e8eae8] overflow-hidden hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-square bg-[#f5f6f5] overflow-hidden">
                        @if($item->main_image_url)
                            <img src="{{ $item->main_image_url }}" alt="{{ $item->name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                <i class="fa-solid fa-boxes-stacked text-4xl"></i>
                            </div>
                        @endif

                        <span class="absolute top-2 sm:top-2.5 left-2 sm:left-2.5 rounded-md sm:rounded-lg bg-[#1c201e] text-[#9acd32] text-[9px] sm:text-[10px] font-extrabold px-1.5 sm:px-2 py-0.5 shadow-sm uppercase">
                            /{{ $item->billing_unit ?? 'day' }}
                        </span>
                    </div>
                    <div class="p-3">
                        <p class="text-[12px] font-bold text-[#1c201e] line-clamp-1 group-hover:text-[#7ca81d] transition-colors">{{ $item->name }}</p>
                        <p class="text-[10px] text-[#9aa19c] truncate mt-0.5">{{ $item->store->name ?? 'Verified Fleet' }}</p>
                        <div class="flex items-baseline gap-1.5 mt-1.5">
                            <span class="text-[14px] font-black text-[#659316] tnum">{{ number_format($item->rate) }} <span class="text-[10px] font-bold">F</span></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         6. TOP VERIFIED FLEETS / STORES (Matching Products Top Stores Strip)
    ================================================================ --}}
    @if(isset($topStores) && $topStores->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 sm:mt-14">
        <div class="flex items-end justify-between gap-3 mb-5">
            <div>
                <h2 class="text-lg sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Top Verified Rental Fleets</h2>
                <p class="text-[12px] text-[#6b716c] mt-0.5">Reliable equipment rental shops across Cameroon</p>
            </div>
            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap">
                View all stores <i class="fa-solid fa-arrow-right text-[15px]" style=""></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5 sm:gap-4">
            @foreach($topStores as $store)
                <a href="{{ route('stores.show', $store->slug) }}"
                   class="group rounded-2xl bg-white border border-[#e8eae8] p-4 hover:border-[#9acd32]/50 hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.12)] transition-all duration-300 flex items-center gap-3.5">
                    <div class="w-13 h-13 rounded-2xl bg-[#eef0ee] overflow-hidden grid place-items-center border border-black/5 shrink-0">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fa-solid fa-store text-2xl text-[#9aa19c]"></i>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1">
                            <h3 class="text-sm font-bold text-[#1c201e] truncate group-hover:text-[#7ca81d] transition-colors">{{ $store->name }}</h3>
                            @if($store->is_verified)
                                <i class="fa-solid fa-circle-check text-[14px] text-[#659316] shrink-0" style=""></i>
                            @endif
                        </div>
                        <p class="text-[11px] font-bold text-[#659316] mt-0.5">{{ $store->rental_items_count ?? 0 }} rentals</p>
                        @if($store->location)
                            <p class="text-[10px] text-[#9aa19c] truncate mt-0.5">{{ $store->location }}</p>
                        @endif
                    </div>
                    <i class="fa-solid fa-chevron-right text-[18px] text-[#c9cecb] group-hover:text-[#9acd32] group-hover:translate-x-0.5 transition-all"></i>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         7. MOBILE FILTER DRAWER (Matching Products Drawer)
    ================================================================ --}}
    <div x-show="openMobileFilters"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">
        <div @click="openMobileFilters = false"
             x-show="openMobileFilters"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div x-show="openMobileFilters"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed inset-x-0 bottom-0 max-h-[85vh] bg-white rounded-t-3xl shadow-2xl flex flex-col z-50">
            
            {{-- Header --}}
            <div class="p-4 border-b border-[#e8eae8] flex items-center justify-between shrink-0">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-lg text-[#1c201e]"></i>
                    <h3 class="text-sm font-extrabold text-[#1c201e]">Filter Rentals</h3>
                </div>
                <button @click="openMobileFilters = false" class="w-8 h-8 rounded-full bg-black/5 flex items-center justify-center text-black/60">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            {{-- Form Fields --}}
            <form method="GET" action="{{ route('rentals.index') }}" class="p-5 pb-24 sm:pb-5 overflow-y-auto flex-1 space-y-5">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                {{-- Category --}}
                <div>
                    <label class="block text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2">Category</label>
                    <select name="category" class="w-full h-11 px-3 text-xs bg-[#f5f6f5] rounded-xl border border-[#e0e3e0] focus:border-[#9acd32] focus:outline-none">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Billing Period --}}
                <div>
                    <label class="block text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2">Billing Period</label>
                    <select name="billing_unit" class="w-full h-11 px-3 text-xs bg-[#f5f6f5] rounded-xl border border-[#e0e3e0] focus:border-[#9acd32] focus:outline-none">
                        <option value="">Any Period</option>
                        @foreach(['hourly' => 'Per Hour', 'daily' => 'Per Day', 'weekly' => 'Per Week', 'monthly' => 'Per Month'] as $unit => $uLabel)
                            <option value="{{ $unit }}" {{ request('billing_unit') === $unit ? 'selected' : '' }}>{{ $uLabel }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Price Range --}}
                <div>
                    <label class="block text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2">Rate (XAF)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Rate"
                               class="w-full h-11 px-3 text-xs bg-[#f5f6f5] rounded-xl border border-[#e0e3e0] focus:border-[#9acd32] focus:outline-none">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Rate"
                               class="w-full h-11 px-3 text-xs bg-[#f5f6f5] rounded-xl border border-[#e0e3e0] focus:border-[#9acd32] focus:outline-none">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="pt-3 flex items-center gap-2">
                    <a href="{{ route('rentals.index') }}"
                       class="flex-1 h-12 rounded-xl bg-black/5 hover:bg-black/10 text-center font-bold text-xs text-[#1c201e] flex items-center justify-center">
                        Reset
                    </a>
                    <button type="submit"
                            class="flex-[2] h-12 rounded-xl bg-[#1c201e] hover:bg-[#9acd32] hover:text-[#1c201e] text-white font-extrabold text-xs flex items-center justify-center gap-1.5 transition-colors shadow-md">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
