@extends('layouts.guest')

@section('title', 'Find Stores — Izifai')
@section('description', 'Browse verified sellers and stores on Izifai. Find the best products from trusted merchants across Cameroon.')

@push('styles')
<style>
    body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif !important; background-color: #f5f6f5; }
    .tnum { font-variant-numeric: tabular-nums; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .filter-sheet { transform: translateY(100%); transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-sheet.open { transform: translateY(0); }
</style>
@endpush

@section('content')
<div x-data="{ openMobileFilters: false }" class="pb-16 sm:pb-24">

    {{-- ================================================================
         1. HERO HEADER BANNER (Consistent with Home Theme)
    ================================================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-4 sm:mt-6">
        <div class="relative overflow-hidden rounded-3xl bg-[#1c201e] border border-black/5 shadow-[0_14px_44px_-16px_rgba(0,0,0,0.18)] p-6 sm:p-10 lg:p-12 text-white">
            {{-- Ambient glow orbs --}}
            <div class="absolute -top-24 -right-16 w-80 h-80 rounded-full bg-[#9acd32]/15 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-28 -left-16 w-72 h-72 rounded-full bg-[#7ca81d]/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                {{-- Skewed Kicker Badge --}}
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 -skew-x-6 rounded-md bg-gradient-to-r from-[#9acd32] to-[#86b92c] text-[#1c201e] text-[10px] sm:text-[11px] font-extrabold uppercase tracking-[0.16em] shadow-[0_6px_18px_-6px_rgba(154,205,50,0.55)]">
                    <span class="skew-x-6 inline-flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-[14px]" style="font-variation-settings:'FILL' 1;">storefront</span>
                        Verified Merchants
                    </span>
                </span>

                <h1 class="mt-4 text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white leading-[1.15]">
                    {{ request('search') ? 'Stores Matching "' . request('search') . '"' : 'Find Trusted Stores in Cameroon' }}
                </h1>

                <p class="mt-2 text-xs sm:text-sm text-white/75 leading-relaxed max-w-xl">
                    Discover verified local sellers and manufacturers across Cameroon. Browse real store catalogs, connect directly on WhatsApp, and buy with escrow safety.
                </p>

                {{-- Highlights / Quick Stats --}}
                <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-[11px] sm:text-xs font-semibold text-white/80">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">store</span>
                        <strong class="text-white">{{ number_format($totalStores) }}+</strong> active stores
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">inventory_2</span>
                        <strong class="text-white">{{ number_format($totalProducts) }}+</strong> products listed
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="material-symbols-rounded text-[14px] text-[#9acd32]" style="font-variation-settings:'FILL' 1;">verified</span>
                        Verified badge check
                    </span>
                </div>

                {{-- Active Filters Pills --}}
                @php
                    $hasActiveFilters = request('search') || (request('category') && request('category') !== 'all') || (request('sort') && request('sort') !== 'newest');
                @endphp
                @if($hasActiveFilters)
                    <div class="mt-5 pt-4 border-t border-white/10 flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold text-white/50 uppercase tracking-wider">Active:</span>

                        @if(request('search'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    "{{ request('search') }}"
                                    <a href="{{ route('stores.index', request()->except(['search', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <span class="material-symbols-rounded text-[13px]">close</span>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('category') && request('category') !== 'all')
                            @php $activeCat = $categories->firstWhere('slug', request('category')); @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-[#9acd32] text-[#1c201e] text-[11px] font-extrabold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ $activeCat->name ?? request('category') }}
                                    <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}" class="hover:opacity-75 transition-opacity ml-0.5">
                                        <span class="material-symbols-rounded text-[13px]">close</span>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('sort') && request('sort') !== 'newest')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ request('sort') === 'rating' ? 'Top Rated' : 'Most Products' }}
                                    <a href="{{ route('stores.index', request()->except(['sort', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <span class="material-symbols-rounded text-[13px]">close</span>
                                    </a>
                                </span>
                            </span>
                        @endif

                        <a href="{{ route('stores.index') }}" class="text-[11px] font-bold text-[#9acd32] hover:text-[#b0ea3d] underline transition-colors ml-1">
                            Reset all
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ================================================================
         2. CATEGORIES HORIZONTAL BAR
    ================================================================ --}}
    @if($categories->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-6">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            {{-- All Stores chip --}}
            <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
               class="shrink-0 px-4 py-2 rounded-xl text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ !request('category') || request('category') === 'all' ? '-skew-x-6 bg-[#1c201e] text-[#9acd32] shadow-sm' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                <span class="{{ !request('category') || request('category') === 'all' ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                    <span class="material-symbols-rounded text-[16px]" style="font-variation-settings:'FILL' 1;">storefront</span>
                    All Stores
                </span>
            </a>

            @foreach($categories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('stores.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="shrink-0 px-4 py-2 rounded-xl text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ $isActive ? '-skew-x-6 bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/30' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
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
         3. TOOLBAR / SEARCH & SORT STRIP
    ================================================================ --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-6">
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-3 sm:p-4 flex flex-wrap items-center justify-between gap-3 shadow-sm">
            {{-- Left: Search input & indicators --}}
            <div class="flex items-center gap-2.5 flex-1 max-w-md">
                {{-- Search Store Form --}}
                <form method="GET" action="{{ route('stores.index') }}" class="w-full flex items-center bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl px-3 h-10 gap-2 focus-within:border-[#9acd32] focus-within:bg-white transition-all">
                    @foreach(request()->except(['search', 'page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <span class="material-symbols-rounded text-[18px] text-[#9aa19c]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search store name, city or keyword..."
                           class="w-full bg-transparent text-[12px] font-semibold text-[#1c201e] placeholder:text-[#9aa19c] outline-none">
                    @if(request('search'))
                        <a href="{{ route('stores.index', request()->except(['search', 'page'])) }}" class="text-[#9aa19c] hover:text-[#1c201e]">
                            <span class="material-symbols-rounded text-[16px]">close</span>
                        </a>
                    @endif
                </form>

                {{-- Mobile Filter Drawer Button --}}
                <button @click="openMobileFilters = true"
                        class="lg:hidden inline-flex items-center gap-1.5 h-10 px-3.5 rounded-xl bg-[#f5f6f5] border border-[#e0e3e0] text-[#1c201e] text-[12px] font-bold hover:bg-[#eceeed] transition-all shrink-0">
                    <span class="material-symbols-rounded text-[17px]" style="font-variation-settings:'FILL' 1;">tune</span>
                    Filters
                </button>
            </div>

            {{-- Right: Results count & Sort Selector --}}
            <div class="flex items-center gap-3 ml-auto">
                <span class="text-xs font-semibold text-[#6b716c] hidden sm:inline-block">
                    Showing <strong class="text-[#1c201e]">{{ $stores->firstItem() ?? 0 }}–{{ $stores->lastItem() ?? 0 }}</strong> of <strong class="text-[#1c201e]">{{ number_format($stores->total()) }}</strong> stores
                </span>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-wider hidden sm:inline">Sort:</span>
                    <div class="relative">
                        <select onchange="window.location.href=this.value"
                                class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                            @foreach([
                                'newest' => 'Newest First',
                                'rating' => 'Highest Rated',
                                'products' => 'Most Products'
                            ] as $val => $label)
                                <option value="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                        {{ request('sort', 'newest') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <span class="material-symbols-rounded text-[16px] text-[#6b716c] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none">
                            expand_more
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         4. MAIN STORES GRID (4 Cards Per Row on PC View)
    ================================================================ --}}
    <section id="stores-section" class="max-w-7xl mx-auto px-4 sm:px-6 mt-6">
        @if($stores->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 items-stretch gap-4 sm:gap-5 w-full">
                @foreach($stores as $store)
                    <div class="group relative w-full bg-white rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        {{-- Top Animated Gradient Line --}}
                        <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>

                        <div>
                            {{-- Store Banner Header --}}
                            <a href="{{ route('stores.show', $store->slug) }}" class="block relative aspect-[16/9] overflow-hidden bg-[#eef0ee]">
                                @if($store->banner)
                                    <img src="{{ $store->banner_url }}" alt="{{ $store->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                                @else
                                    <x-store-default-banner :store="$store" variant="card" />
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>

                                {{-- Badges on top of banner --}}
                                <div class="absolute top-2.5 right-2.5 flex items-center gap-1.5 z-10">
                                    @if($store->is_verified)
                                        <span class="px-2 py-0.5 rounded-md -skew-x-6 bg-[#1c201e]/85 backdrop-blur-sm text-[#9acd32] text-[9px] font-extrabold uppercase tracking-wide shadow-sm flex items-center gap-1">
                                            <span class="material-symbols-rounded text-[11px]" style="font-variation-settings:'FILL' 1;">verified</span>
                                            Verified
                                        </span>
                                    @endif

                                    @if($store->created_at && $store->created_at->diffInDays(now()) <= 14)
                                        <span class="px-2 py-0.5 rounded-md -skew-x-6 bg-[#9acd32] text-[#1c201e] text-[9px] font-extrabold uppercase tracking-wide shadow-sm">
                                            New
                                        </span>
                                    @endif
                                </div>
                            </a>

                            {{-- Store Logo Avatar (Floating over banner) --}}
                            <div class="px-4 relative">
                                <div class="flex items-end justify-between -mt-7 mb-2 relative z-10">
                                    <a href="{{ route('stores.show', $store->slug) }}"
                                       class="w-14 h-14 rounded-2xl bg-white p-1 ring-2 ring-white shadow-md overflow-hidden shrink-0 block group-hover:ring-[#9acd32]/50 transition-all">
                                        @if($store->logo)
                                            <img src="{{ $store->logo_url }}" alt="{{ $store->name }}" class="w-full h-full object-cover rounded-xl">
                                        @else
                                            <div class="w-full h-full rounded-xl bg-[#eef4d8] text-[#659316] font-extrabold text-lg grid place-items-center">
                                                {{ strtoupper(substr($store->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </a>

                                    {{-- Rating badge --}}
                                    @if($store->reviews_avg_rating && $store->reviews_avg_rating > 0)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-[#fffbeb] border border-amber-200/60 text-amber-700 text-[11px] font-extrabold shadow-sm">
                                            <span class="material-symbols-rounded text-[13px] text-amber-400" style="font-variation-settings:'FILL' 1;">star</span>
                                            {{ number_format($store->reviews_avg_rating, 1) }}
                                            <span class="text-[9px] text-[#9aa19c] font-medium">({{ $store->reviews_count ?? 0 }})</span>
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-[#9aa19c] bg-[#f5f6f5] px-2 py-0.5 rounded-md">
                                            New Seller
                                        </span>
                                    @endif
                                </div>

                                {{-- Store Title & Location --}}
                                <a href="{{ route('stores.show', $store->slug) }}" class="block mt-1">
                                    <h3 class="text-sm font-extrabold text-[#1c201e] leading-snug truncate group-hover:text-[#7ca81d] transition-colors flex items-center gap-1">
                                        {{ $store->name }}
                                        @if($store->is_verified)
                                            <span class="material-symbols-rounded text-[14px] text-[#659316] shrink-0" style="font-variation-settings:'FILL' 1;">verified</span>
                                        @endif
                                    </h3>
                                </a>

                                @if($store->location)
                                    <p class="text-[11px] text-[#6b716c] truncate mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-rounded text-[13px] text-[#9aa19c]">location_on</span>
                                        {{ $store->location }}
                                    </p>
                                @endif

                                @if($store->description)
                                    <p class="text-[11px] text-[#9aa19c] line-clamp-2 mt-1.5 leading-relaxed">
                                        {{ $store->description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-4 pt-3 mt-3 border-t border-[#f0f1f0] flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md -skew-x-6 bg-[#f2f9df] text-[#659316] text-[11px] font-extrabold">
                                <span class="skew-x-6">
                                    {{ number_format($store->products_count ?? 0) }} {{ Str::plural('product', $store->products_count ?? 0) }}
                                </span>
                            </span>

                            <a href="{{ route('stores.show', $store->slug) }}"
                               class="inline-flex items-center gap-1 text-[11px] font-extrabold text-[#1c201e] group-hover:text-[#7ca81d] transition-colors">
                                Visit Store
                                <span class="grid place-items-center w-6 h-6 rounded-full bg-[#f2f9df] text-[#7ca81d] group-hover:bg-[#9acd32] group-hover:text-[#1c201e] transition-colors">
                                    <span class="material-symbols-rounded text-[13px]">arrow_forward</span>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($stores->hasPages())
                <div class="mt-10 sm:mt-12 flex justify-center">
                    {{ $stores->links('partials.pagination') }}
                </div>
            @endif

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-3xl border border-[#e8eae8] p-10 sm:p-16 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#f2f9df] text-[#659316] flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-rounded text-4xl sm:text-5xl" style="font-variation-settings:'FILL' 1;">storefront</span>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No stores found</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto leading-relaxed">
                    @if($hasActiveFilters)
                        We couldn't find any stores matching your criteria. Try adjusting your search query or reset filters.
                    @else
                        No stores have been registered on the marketplace yet. Be the first to open your storefront!
                    @endif
                </p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('stores.index') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg -skew-x-6 bg-[#1c201e] text-white text-xs font-bold hover:bg-[#9acd32] hover:text-[#1c201e] transition-all shadow-md">
                            <span class="skew-x-6 flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[15px]">refresh</span>
                                Reset Filters
                            </span>
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-6 py-2.5 rounded-lg -skew-x-6 bg-[#9acd32] text-[#1c201e] text-xs font-bold hover:bg-[#86b92c] transition-all shadow-md">
                            <span class="skew-x-6 flex items-center gap-1.5">
                                <span class="material-symbols-rounded text-[15px]">storefront</span>
                                Open Your Store
                            </span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </section>

    {{-- ================================================================
         5. MOBILE FILTER BOTTOM SHEET
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
             class="filter-sheet open absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] overflow-y-auto shadow-2xl flex flex-col">

            {{-- Sheet Header --}}
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-[#eff1ef] px-5 py-4 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-rounded text-[20px] text-[#7ca81d]" style="font-variation-settings:'FILL' 1;">tune</span>
                    <h3 class="text-sm font-extrabold text-[#1c201e]">Filter Stores</h3>
                </div>
                <div class="flex items-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('stores.index') }}" class="text-xs font-bold text-[#7ca81d] hover:underline">Reset</a>
                    @endif
                    <button @click="openMobileFilters = false" class="w-8 h-8 rounded-full bg-[#f5f6f5] flex items-center justify-center text-[#1c201e]">
                        <span class="material-symbols-rounded text-[18px]">close</span>
                    </button>
                </div>
            </div>

            <div class="p-5 space-y-6">
                {{-- Categories Filter --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Category</h4>
                    <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                        <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ !request('category') || request('category') === 'all' ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                            All Categories
                            @if(!request('category') || request('category') === 'all')
                                <span class="material-symbols-rounded text-[16px]">check</span>
                            @endif
                        </a>
                        @foreach($categories as $c)
                            @php $isCActive = request('category') === $c->slug; @endphp
                            <a href="{{ route('stores.index', array_merge(request()->except(['category', 'page']), ['category' => $c->slug])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ $isCActive ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                                <span>{{ $c->name }}</span>
                                @if($isCActive)
                                    <span class="material-symbols-rounded text-[16px]">check</span>
                                @else
                                    <span class="text-[10px] text-[#9aa19c] font-semibold">{{ $c->products_count }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Sort Filter --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Sort Order</h4>
                    <div class="space-y-1">
                        @foreach([
                            'newest' => 'Newest First',
                            'rating' => 'Highest Rated',
                            'products' => 'Most Products'
                        ] as $sVal => $sLabel)
                            @php $isSortActive = request('sort', 'newest') === $sVal; @endphp
                            <a href="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $sVal])) }}"
                               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold {{ $isSortActive ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                                {{ $sLabel }}
                                @if($isSortActive)
                                    <span class="material-symbols-rounded text-[16px]">check</span>
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
