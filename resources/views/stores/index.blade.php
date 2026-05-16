@extends('layouts.guest')
@section('title', 'Find Stores — Izifai')
@section('description', 'Browse verified sellers and stores on Izifai. Find the best products from trusted merchants across Cameroon.')

@push('styles')
<style>
    .store-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px -12px rgba(0,0,0,0.08), 0 4px 12px -4px rgba(0,0,0,0.03); }
    .store-card .store-banner { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .store-banner { transform: scale(1.05); }
    .store-card .store-logo { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .store-logo { transform: scale(1.1) rotate(-3deg); }
    .store-card .view-store-arrow { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .view-store-arrow { transform: translateX(4px); }
    .category-chip { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .category-chip.active { background: #006d38; color: white; border-color: #006d38; box-shadow: 0 2px 8px rgba(0,109,56,0.25); }
    .filter-accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-accordion-content.open { max-height: 500px; }
    .filter-arrow { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-arrow.open { transform: rotate(180deg); }
    @keyframes cardIn { from { opacity: 0; transform: translateY(20px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    .card-enter { animation: cardIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .card-enter:nth-child(1) { animation-delay: 0s; }
    .card-enter:nth-child(2) { animation-delay: 0.04s; }
    .card-enter:nth-child(3) { animation-delay: 0.08s; }
    .card-enter:nth-child(4) { animation-delay: 0.12s; }
    .card-enter:nth-child(5) { animation-delay: 0.16s; }
    .card-enter:nth-child(6) { animation-delay: 0.2s; }
    .card-enter:nth-child(7) { animation-delay: 0.24s; }
    .card-enter:nth-child(8) { animation-delay: 0.28s; }
    .card-enter:nth-child(9) { animation-delay: 0.32s; }
    .card-enter:nth-child(10) { animation-delay: 0.36s; }
    .card-enter:nth-child(11) { animation-delay: 0.4s; }
    .card-enter:nth-child(12) { animation-delay: 0.44s; }
    .card-enter:nth-child(n+13) { animation-delay: 0.48s; }
    .h-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .h-scroll > * { scroll-snap-align: start; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .mobile-sticky-bar { box-shadow: 0 -4px 20px rgba(0,0,0,0.06); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .hero-gradient { background: linear-gradient(135deg, #00210d 0%, #003317 50%, #005228 100%); }
    .store-logo-placeholder { background: linear-gradient(135deg, #006d38, #00a859); }
    .section-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .section-scroll > * { scroll-snap-align: start; }
    .trending-grid-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .trending-grid-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px -12px rgba(0,0,0,0.1); }
    .filter-sheet { transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-sheet.open { transform: translateY(0); }
    .store-badge { background: linear-gradient(135deg, #006d38, #00a859); }
    .store-hero-bg { background-image: url('https://images.unsplash.com/photo-1601597111158-2fceff292cdc?w=1400&q=80'); background-size: cover; background-position: center; }
</style>
@endpush

{{-- ==================== STORE SIDEBAR (DESKTOP) ==================== --}}
@section('store-sidebar')
    {{-- Sidebar: Categories --}}
    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">category</span>
                Categories
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <div class="space-y-0.5">
                <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ !request('category') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                    <span class="material-symbols-outlined text-[15px] {{ !request('category') ? 'text-primary' : '' }}">grid_view</span>
                    All Stores
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('stores.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="flex items-center justify-between gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('category') === $cat->slug ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="flex items-center gap-2.5 truncate">
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="w-4 h-4 flex items-center justify-center shrink-0">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-[15px] shrink-0">circle</span>
                            @endif
                            <span class="truncate">{{ $cat->name }}</span>
                        </span>
                        <span class="text-[10px] text-on-surface-variant/40 font-medium shrink-0">{{ $cat->products_count ?? $cat->products?->count() ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar: Sort By --}}
    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">sort</span>
                Sort By
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <div class="space-y-0.5">
                @foreach(['newest' => 'Newest First', 'rating' => 'Highest Rated', 'products' => 'Most Products'] as $val => $label)
                    <a href="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('sort', 'newest') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="material-symbols-outlined text-[15px] {{ request('sort', 'newest') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'newest' ? 'schedule' : ($val === 'rating' ? 'star' : 'inventory_2') }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
<div x-data="{ openMobileFilters: false }" class="min-h-screen bg-surface pb-20 lg:pb-0">

    {{-- ===== 1. HERO ===== --}}
    <section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
        <div class="relative min-h-[180px] sm:min-h-[260px] lg:min-h-[320px] overflow-hidden rounded-2xl shadow-sm">
        <div class="absolute inset-0 store-hero-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="absolute top-[-120px] right-[-80px] w-[400px] h-[400px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-[-100px] left-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-0 left-0 right-0 px-5 sm:px-6 lg:px-8 py-3 sm:py-6 lg:py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between gap-4">
                    <div class="min-w-0 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white shrink-0 ring-2 ring-white/30">
                                <span class="material-symbols-outlined text-lg sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">communities</span>
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl lg:leading-[44px] font-bold text-white tracking-tight">
                                    Discover <span class="text-[#00a859]">Stores</span>
                                </h1>
                                <p class="text-xs sm:text-sm text-white/80 max-w-xl line-clamp-2">Browse trusted sellers and find exactly what you need from merchants across Cameroon.</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5 mt-1 sm:mt-2">
                            <span class="text-white/80 text-[10px] sm:text-xs font-bold">
                                <span class="text-sm sm:text-base font-black">{{ $totalStores }}+</span> active stores
                            </span>
                            <span class="text-white/30 hidden sm:inline">•</span>
                            <span class="text-white/60 text-[9px] sm:text-[11px] font-medium hidden sm:inline">{{ number_format($totalProducts) }}+ products listed</span>
                        </div>

                        @if(request('search') || request('category'))
                            <div class="flex flex-wrap items-center gap-1 mt-1">
                                @if(request('category'))
                                    @php $catName = $categories->firstWhere('slug', request('category'))?->name ?? request('category'); @endphp
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                        {{ $catName }}
                                        <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                    </span>
                                @endif
                                @if(request('search'))
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                        "{{ request('search') }}"
                                        <a href="{{ route('stores.index', request()->except(['search', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                    </span>
                                @endif
                                <a href="{{ route('stores.index') }}" class="text-[7px] font-semibold text-white/60 hover:text-white underline underline-offset-2 transition-colors">Clear</a>
                            </div>
                        @endif
                    </div>

                    {{-- Desktop decorative badge --}}
                    <div class="hidden sm:flex flex-col items-end shrink-0 gap-1.5">
                        <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm px-2 py-0.5 rounded-full border border-white/10">
                            <span class="material-symbols-outlined text-[8px] text-primary-fixed-dim" style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="text-[7px] font-semibold text-white/70">Trusted Marketplace</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    {{-- ===== 2. POPULAR STORES ===== --}}
    @if($stores->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-primary/10 flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">communities</span>
                    </span>
                    <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Popular Stores</h2>
                </div>
                <span class="text-[9px] sm:text-[10px] font-semibold text-on-surface-variant/50">New &amp; trending</span>
            </div>

            {{-- Mobile: horizontal scroll --}}
            <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
                @php $popularStores = $stores->take(8); @endphp
                @foreach($popularStores as $store)
                    <div class="w-[140px] sm:w-[160px] shrink-0">
                        <a href="{{ route('stores.show', $store->slug) }}" class="block store-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                            <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                                @if($store->banner)
                                    <img src="{{ $store->banner_url }}" alt="{{ $store->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary/10 via-primary/5 to-surface-container-low"></div>
                                @endif
                                <div class="absolute top-1.5 left-1.5">
                                    <x-store-badge :store="$store" size="sm" />
                                </div>
                                @if($store->created_at && $store->created_at->diffInDays(now()) <= 7)
                                    <span class="absolute top-1.5 right-1.5 bg-amber-500/90 backdrop-blur-sm text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                        <span class="material-symbols-outlined text-[8px]" style="font-variation-settings: 'FILL' 1;">new_releases</span>
                                        New
                                    </span>
                                @endif
                            </div>
                            <div class="p-2">
                                <h3 class="text-[10px] sm:text-[11px] font-bold text-on-surface leading-snug line-clamp-1">{{ $store->name }}</h3>
                                <div class="mt-0.5">
                                    <p class="text-[9px] text-on-surface-variant/50 truncate">{{ $store->products_count ?? 0 }} products</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0"></div>
            </div>

            {{-- Desktop: 2-column grid --}}
            <div class="hidden lg:grid lg:grid-cols-2 lg:gap-3">
                @php $popularStoresDesktop = $stores->take(6); @endphp
                @foreach($popularStoresDesktop as $store)
                    <div class="trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex gap-3 p-2">
                        <a href="{{ route('stores.show', $store->slug) }}" class="w-16 h-16 rounded-lg overflow-hidden shrink-0 bg-surface-container-low block">
                            @if($store->logo)
                                <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full store-logo-placeholder flex items-center justify-center text-white font-black text-lg">{{ substr($store->name, 0, 1) }}</div>
                            @endif
                        </a>
                        <div class="min-w-0 flex-1 flex flex-col justify-between py-0.5">
                            <div>
                                <a href="{{ route('stores.show', $store->slug) }}" class="text-[11px] sm:text-xs font-bold text-on-surface leading-snug line-clamp-1 hover:text-primary transition-colors">{{ $store->name }}</a>
                                @if($store->location)
                                    <p class="text-[9px] text-on-surface-variant/50 truncate mt-0.5">{{ $store->location }}</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[9px] font-semibold text-on-surface-variant/60">{{ $store->products_count ?? 0 }} products</span>
                                <x-store-badge :store="$store" size="sm" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== 3. CATEGORIES ===== --}}
    @if($categories->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8 lg:hidden">
            <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                <h2 class="text-[11px] sm:text-xs font-bold text-on-surface uppercase tracking-wider">Categories</h2>
                <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
                   class="text-[10px] font-semibold text-primary hover:underline {{ !request('category') ? 'hidden' : '' }}">All</a>
            </div>
            <div class="flex gap-2 overflow-x-auto no-scrollbar h-scroll pb-1 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:flex-wrap lg:gap-2">
                <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
                   class="category-chip shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border text-[11px] font-semibold transition-all {{ !request('category') ? 'active' : 'border-black/8 text-on-surface-variant bg-white hover:border-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined text-[14px]">grid_view</span>
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('stores.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="category-chip shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border text-[11px] font-semibold transition-all {{ request('category') === $cat->slug ? 'active' : 'border-black/8 text-on-surface-variant bg-white hover:border-primary/30 hover:text-primary' }}">
                        @if($cat->icon && str_starts_with($cat->icon, '<'))
                            <span class="w-4 h-4 flex items-center justify-center shrink-0">{!! $cat->icon !!}</span>
                        @else
                            <span class="material-symbols-outlined text-[14px]">circle</span>
                        @endif
                        {{ $cat->name }}
                    </a>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0 lg:hidden"></div>
            </div>
        </section>
    @endif

    {{-- ===== 4. FILTER BAR ===== --}}
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
        <div class="flex items-center gap-2.5">
            <button @click="openMobileFilters = true"
                    class="lg:hidden flex items-center gap-2 h-9 px-3.5 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[15px]">filter_list</span>
                Filters
                @php $activeFilterCount = collect([request('category')])->filter()->count(); @endphp
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <select onchange="window.location.href=this.value"
                    class="lg:hidden h-9 px-3 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[160px]">
                @foreach(['newest' => 'Newest', 'rating' => 'Highest Rated', 'products' => 'Most Products'] as $val => $label)
                    <option value="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'newest') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="hidden lg:flex items-center gap-3 ml-auto">
                <span class="text-xs text-on-surface-variant">
                    <span class="font-bold text-on-surface">{{ $stores->firstItem() ?? 0 }}</span>–<span class="font-bold text-on-surface">{{ $stores->lastItem() ?? 0 }}</span>
                    <span class="text-on-surface-variant/40">of</span>
                    <span class="font-bold text-on-surface">{{ number_format($stores->total()) }}</span>
                </span>
            </div>
        </div>
    </section>

    {{-- ===== 5. STORES ===== --}}
    <section id="stores-section" class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
        <div class="flex-1 min-w-0">
                @if($stores->count() > 0)

                    {{-- Stores Grid (desktop) --}}
                    <div class="hidden lg:flex items-center justify-between mb-3">
                        <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">All Stores</h2>
                        <span class="text-xs text-on-surface-variant">{{ $stores->total() }} results</span>
                    </div>
                    <div class="hidden lg:grid grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($stores as $store)
                            <div class="store-card card-enter bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] group relative">
                                <a href="{{ route('stores.show', $store->slug) }}" class="block">
                                    <div class="aspect-[4/3] relative overflow-hidden bg-surface-container-low">
                                        @if($store->banner)
                                            <img src="{{ $store->banner_url }}" alt="{{ $store->name }}" loading="lazy" class="store-banner w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary/10 via-primary/5 to-surface-container-low"></div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                        <div class="absolute bottom-2.5 left-2.5 flex items-center gap-1.5">
                                            <div class="store-logo w-8 h-8 rounded-lg overflow-hidden bg-white shadow-md ring-2 ring-white shrink-0">
                                                @if($store->logo)
                                                    <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full store-logo-placeholder flex items-center justify-center text-white font-black text-[12px]">{{ substr($store->name, 0, 1) }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="absolute top-2 right-2">
                                            <x-store-badge :store="$store" size="sm" />
                                        </div>
                                        @if($store->created_at && $store->created_at->diffInDays(now()) <= 7)
                                            <span class="absolute top-2 left-2 bg-amber-500/90 backdrop-blur-sm text-white text-[8px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-lg">
                                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">new_releases</span>
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <div class="p-3 pt-2.5">
                                        <div class="flex items-center gap-1">
                                            <h3 class="text-[12px] sm:text-sm font-bold text-on-surface truncate group-hover:text-primary transition-colors">{{ $store->name }}</h3>
                                            @if($store->products_count >= 10)
                                                <span class="material-symbols-outlined text-[12px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($store->reviews_avg_rating)
                                                <div class="flex items-center gap-0.5">
                                                    <span class="material-symbols-outlined text-[12px] text-amber-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                                    <span class="text-[10px] font-bold text-on-surface">{{ number_format($store->reviews_avg_rating, 1) }}</span>
                                                    <span class="text-[8px] text-on-surface-variant">({{ $store->reviews_count ?? 0 }})</span>
                                                </div>
                                            @else
                                                <span class="text-[9px] text-on-surface-variant/50">No reviews</span>
                                            @endif
                                        </div>
                                        @if($store->location)
                                            <p class="text-[10px] text-on-surface-variant/60 truncate mt-0.5 flex items-center gap-0.5">
                                                <span class="material-symbols-outlined text-[12px]">location_on</span>
                                                {{ $store->location }}
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/[0.04]">
                                            <span class="text-[10px] font-semibold text-on-surface-variant">{{ $store->products_count ?? 0 }} {{ Str::plural('product', $store->products_count) }}</span>
                                            <span class="view-store-arrow material-symbols-outlined text-[15px] text-on-surface-variant/30 group-hover:text-primary">arrow_forward</span>
                        </div>
                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- MOBILE: Stores Grid --}}
                    <div class="lg:hidden">
                        <div class="flex items-center justify-between mb-2.5">
                            <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">All Stores</h2>
                            <span class="text-[10px] text-on-surface-variant font-medium">{{ $stores->total() }} results</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($stores as $store)
                                <div class="store-card card-enter bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group relative">
                                    <a href="{{ route('stores.show', $store->slug) }}" class="block">
                                        <div class="aspect-[4/3] relative overflow-hidden bg-surface-container-low">
                                            @if($store->banner)
                                                <img src="{{ $store->banner_url }}" alt="{{ $store->name }}" loading="lazy" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-gradient-to-br from-primary/10 via-primary/5 to-surface-container-low"></div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                                            <div class="absolute bottom-2 left-2">
                                                <div class="store-logo w-7 h-7 rounded-md overflow-hidden bg-white shadow-md ring-2 ring-white">
                                                    @if($store->logo)
                                                        <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full store-logo-placeholder flex items-center justify-center text-white font-black text-[9px]">{{ substr($store->name, 0, 1) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="absolute top-1.5 right-1.5">
                                                <x-store-badge :store="$store" size="sm" />
                                            </div>
                                            @if($store->created_at && $store->created_at->diffInDays(now()) <= 7)
                                                <span class="absolute top-1.5 left-1.5 bg-amber-500/90 backdrop-blur-sm text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">New</span>
                                            @endif
                                        </div>
                                        <div class="p-2">
                                            <h3 class="text-[11px] font-bold text-on-surface leading-snug truncate group-hover:text-primary transition-colors">{{ $store->name }}</h3>
                                            @if($store->location)
                                                <p class="text-[8px] text-on-surface-variant/50 truncate mt-0.5">{{ $store->location }}</p>
                                            @endif
                                            <div class="flex items-center gap-1 mt-1">
                                                <span class="text-[9px] font-semibold text-on-surface-variant/60">{{ $store->products_count ?? 0 }} {{ Str::plural('product', $store->products_count) }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Pagination --}}
                    @if($stores->hasPages())
                        <div class="mt-6 sm:mt-8 lg:mt-10">
                            {{ $stores->links('partials.pagination') }}
                        </div>
                    @endif

                @else
                    {{-- Empty State --}}
                    <div class="text-center py-16 sm:py-24 bg-white rounded-2xl border border-black/[0.04] shadow-sm">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-surface-container-low flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant/30" style="font-variation-settings: 'FILL' 1;">storefront</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-on-surface">No stores found</h3>
                        @if(request('search') || request('category'))
                            <p class="text-sm text-on-surface-variant mt-1 max-w-sm mx-auto leading-relaxed">
                                @if(request('search'))
                                    Nothing matches "<span class="font-semibold text-primary">{{ request('search') }}</span>"
                                @else
                                    No stores in this category yet
                                @endif
                            </p>
                            <div class="flex items-center justify-center gap-3 mt-6">
                                <a href="{{ route('stores.index') }}"
                                   class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[14px]">close</span>
                                    Clear All Filters
                                </a>
                                <a href="{{ route('stores.index') }}"
                                   class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-white text-on-surface rounded-full text-[12px] font-bold border border-black/10 hover:border-black/20 active:scale-[0.97] transition-all">
                                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                                    Reset
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-on-surface-variant mt-1">No stores have been created yet. Check back soon!</p>
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-1.5 mt-6 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">add</span>
                                Create Your Store
                            </a>
                        @endif
                    </div>
                @endif
            </div>
    </section>

    {{-- ===== MOBILE BOTTOM STICKY BAR ===== --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 mobile-sticky-bar bg-white/90 border-t border-black/[0.04] px-3 py-2.5">
        <div class="flex items-center gap-2.5 max-w-lg mx-auto">
            <button @click="openMobileFilters = true"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">filter_list</span>
                Filters
                @php $activeFilterCount = collect([request('category')])->filter()->count(); @endphp
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <button onclick="document.getElementById('stores-section')?.scrollIntoView({ behavior: 'smooth' })"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">communities</span>
                Stores
            </button>

            <select onchange="window.location.href=this.value"
                    class="h-9 px-2.5 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[130px]">
                @foreach(['newest' => 'Newest', 'rating' => 'Top Rated', 'products' => 'Most Products'] as $val => $label)
                    <option value="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'newest') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ===== MOBILE FILTER BOTTOM SHEET ===== --}}
    <div x-cloak x-show="openMobileFilters" class="fixed inset-0 z-50 lg:hidden">
        <div x-show="openMobileFilters" x-transition:enter="transition-opacity duration-250" x-transition:leave="transition-opacity duration-200"
             class="absolute inset-0 bg-black/30 backdrop-blur-sm" @click="openMobileFilters = false"></div>
        <div x-show="openMobileFilters" x-transition:enter="transition-transform duration-350 ease-out" x-transition:leave="transition-transform duration-250 ease-in"
             class="filter-sheet open absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[88vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-black/[0.04] px-5 py-4 flex items-center justify-between rounded-t-3xl z-10">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-on-surface">Filters</h3>
                    @php $totalFilters = collect([request('category'), request('search')])->filter()->count(); @endphp
                    @if($totalFilters > 0)
                        <span class="px-2 py-0.5 rounded-full bg-primary/5 text-primary text-[9px] font-bold">{{ $totalFilters }} active</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($totalFilters > 0)
                        <a href="{{ route('stores.index') }}" class="text-[10px] font-semibold text-primary hover:underline">Reset</a>
                    @endif
                    <button @click="openMobileFilters = false" class="w-8 h-8 rounded-full bg-black/[0.04] flex items-center justify-center hover:bg-black/[0.08] transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </div>
            </div>
            <div class="p-5 space-y-5">
                <div class="bg-surface-container-lowest rounded-2xl border border-black/[0.03] p-4" x-data="{ open: true }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-[11px] font-bold text-on-surface uppercase tracking-wider">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-[16px] text-primary">category</span>
                            Category
                        </span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <div class="space-y-0.5">
                            <a href="{{ route('stores.index', request()->except(['category', 'page'])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ !request('category') ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                               @click="openMobileFilters = false">
                                <span class="material-symbols-outlined text-[18px]">grid_view</span>
                                All Stores
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('stores.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('category') === $cat->slug ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                                   @click="openMobileFilters = false">
                                    @if($cat->icon && str_starts_with($cat->icon, '<'))
                                        <span class="w-5 h-5 flex items-center justify-center shrink-0">{!! $cat->icon !!}</span>
                                    @else
                                        <span class="material-symbols-outlined text-[18px]">circle</span>
                                    @endif
                                    {{ $cat->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl border border-black/[0.03] p-4" x-data="{ open: true }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-[11px] font-bold text-on-surface uppercase tracking-wider">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">sort</span>Sort By</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <div class="space-y-0.5">
                            @foreach(['newest' => 'Newest First', 'rating' => 'Highest Rated', 'products' => 'Most Products'] as $val => $label)
                                <a href="{{ route('stores.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('sort', 'newest') === $val ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                                   @click="openMobileFilters = false">
                                    <span class="material-symbols-outlined text-[18px] {{ request('sort', 'newest') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'newest' ? 'schedule' : ($val === 'rating' ? 'star' : 'inventory_2') }}</span>
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
