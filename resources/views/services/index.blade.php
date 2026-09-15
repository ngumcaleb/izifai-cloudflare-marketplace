@extends('layouts.guest')

@section('title', $title . ' — Izifai')
@section('description', $description)

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
    <section class="max-w-7xl mx-auto px-2 sm:px-6 mt-4 sm:mt-6">
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-[#1c201e] border border-black/5 shadow-[0_14px_44px_-16px_rgba(0,0,0,0.18)] p-5 sm:p-10 lg:p-12 text-white">
            {{-- Ambient glow orbs --}}
            <div class="absolute -top-24 -right-16 w-80 h-80 rounded-full bg-[#9acd32]/15 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-28 -left-16 w-72 h-72 rounded-full bg-[#7ca81d]/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                {{-- Skewed Kicker Badge --}}
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 -skew-x-6 rounded-md bg-gradient-to-r from-[#9acd32] to-[#86b92c] text-[#1c201e] text-[10px] sm:text-[11px] font-extrabold uppercase tracking-[0.16em] shadow-[0_6px_18px_-6px_rgba(154,205,50,0.55)]">
                    <span class="skew-x-6 inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-ruler text-[14px]" style=""></i>
                        Professional Services
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
                        <i class="fa-solid fa-shield-halved text-[14px] text-[#9acd32]" style=""></i>
                        <strong class="text-white">{{ number_format($services->total()) }}</strong> services available
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-screwdriver-wrench text-[14px] text-[#9acd32]" style=""></i>
                        {{ $categories->count() }} specialties
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-comment-dots text-[14px] text-[#9acd32]" style=""></i>
                        Direct service requests
                    </span>
                </div>

                {{-- Active Filters Pills --}}
                @php
                    $hasActiveFilters = request('q') || request('category') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'latest');
                @endphp
                @if($hasActiveFilters)
                    <div class="mt-5 pt-4 border-t border-white/10 flex flex-wrap items-center gap-2">
                        <span class="text-[11px] font-bold text-white/50 uppercase tracking-wider">Active:</span>

                        @if(request('q'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    "{{ request('q') }}"
                                    <a href="{{ route('services.index', request()->except(['q', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
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
                                    <a href="{{ route('services.index', request()->except(['category', 'page'])) }}" class="hover:opacity-75 transition-opacity ml-0.5">
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
                                    <a href="{{ route('services.index', request()->except(['min_price', 'max_price', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        @if(request('sort') && request('sort') !== 'latest')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg -skew-x-6 bg-white/15 backdrop-blur-sm text-white text-[11px] font-semibold">
                                <span class="skew-x-6 flex items-center gap-1">
                                    {{ request('sort') === 'price_low' ? 'Price: Low → High' : (request('sort') === 'price_high' ? 'Price: High → Low' : 'Most Popular') }}
                                    <a href="{{ route('services.index', request()->except(['sort', 'page'])) }}" class="hover:text-[#9acd32] transition-colors ml-0.5">
                                        <i class="fa-solid fa-xmark text-[13px]"></i>
                                    </a>
                                </span>
                            </span>
                        @endif

                        <a href="{{ route('services.index') }}" class="text-[11px] font-bold text-[#9acd32] hover:text-[#b0ea3d] underline transition-colors ml-1">
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
    <section class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1">
            {{-- All Services chip --}}
            <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
               class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ !request('category') ? '-skew-x-6 bg-[#1c201e] text-[#9acd32] shadow-sm' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                <span class="{{ !request('category') ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                    <i class="fa-solid fa-table-cells text-[16px]" style=""></i>
                    All Services
                </span>
            </a>

            @foreach($categories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="shrink-0 px-3.5 sm:px-4 py-2 rounded-xl text-[11.5px] sm:text-[12px] font-bold transition-all duration-200 flex items-center gap-1.5 {{ $isActive ? '-skew-x-6 bg-[#9acd32] text-[#1c201e] shadow-sm shadow-[#9acd32]/30' : 'bg-white border border-[#e8eae8] text-[#3f453f] hover:border-[#9acd32]/50 hover:text-[#7ca81d]' }}">
                    <span class="{{ $isActive ? 'skew-x-6' : '' }} flex items-center gap-1.5">
                        {{ $cat->name }}
                        @if(($cat->services_count ?? $cat->services?->count() ?? 0) > 0)
                            <span class="text-[10px] opacity-75 font-semibold">({{ $cat->services_count ?? $cat->services->count() }})</span>
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
    <section class="max-w-7xl mx-auto px-2.5 sm:px-6 mt-5 sm:mt-6">
        <div class="bg-white rounded-2xl border border-[#e8eae8] p-2.5 sm:p-4 flex flex-wrap items-center justify-between gap-2.5 sm:gap-3 shadow-sm">
            {{-- Left: Search & Quick Price inputs --}}
            <div class="flex flex-wrap items-center gap-2.5">
                {{-- Search Box --}}
                <form method="GET" action="{{ route('services.index') }}" class="flex items-center bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl px-3 h-10 gap-2 focus-within:border-[#9acd32] focus-within:bg-white transition-all w-52 sm:w-64">
                    @foreach(request()->except(['q', 'page']) as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <i class="fa-solid fa-magnifying-glass text-[18px] text-[#9aa19c]"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search service..."
                           class="w-full bg-transparent text-[12px] font-semibold text-[#1c201e] placeholder:text-[#9aa19c] outline-none">
                    @if(request('q'))
                        <a href="{{ route('services.index', request()->except(['q', 'page'])) }}" class="text-[#9aa19c] hover:text-[#1c201e]">
                            <i class="fa-solid fa-xmark text-[16px]"></i>
                        </a>
                    @endif
                </form>

                {{-- Desktop Quick Price Filter --}}
                <form method="GET" action="{{ route('services.index') }}" class="hidden lg:flex items-center gap-2">
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

                {{-- Mobile Filter Trigger --}}
                <button @click="openMobileFilters = true"
                        class="lg:hidden inline-flex items-center gap-1.5 h-10 px-3.5 rounded-xl bg-[#f5f6f5] border border-[#e0e3e0] text-[#1c201e] text-[12px] font-bold hover:bg-[#eceeed] transition-all shrink-0">
                    <i class="fa-solid fa-sliders text-[17px]" style=""></i>
                    Filters
                    @php $filterCount = collect([request('category'), request('min_price'), request('max_price')])->filter()->count(); @endphp
                    @if($filterCount > 0)
                        <span class="w-5 h-5 rounded-full bg-[#9acd32] text-[#1c201e] text-[10px] font-extrabold flex items-center justify-center">{{ $filterCount }}</span>
                    @endif
                </button>
            </div>

            {{-- Right: Results count & Sort Selector --}}
            <div class="flex items-center gap-3 ml-auto">
                <span class="text-xs font-semibold text-[#6b716c] hidden sm:inline-block">
                    Showing <strong class="text-[#1c201e]">{{ $services->firstItem() ?? 0 }}–{{ $services->lastItem() ?? 0 }}</strong> of <strong class="text-[#1c201e]">{{ number_format($services->total()) }}</strong> services
                </span>

                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-wider hidden sm:inline">Sort:</span>
                    <div class="relative">
                        <select onchange="window.location.href=this.value"
                                class="h-10 pl-3.5 pr-8 bg-[#f5f6f5] border border-[#e0e3e0] rounded-xl text-[12px] font-bold text-[#1c201e] outline-none cursor-pointer hover:border-[#9acd32] focus:border-[#9acd32] transition-all appearance-none">
                            @foreach([
                                'latest' => 'Latest',
                                'popular' => 'Most Viewed',
                                'price_low' => 'Price: Low to High',
                                'price_high' => 'Price: High to Low'
                            ] as $val => $label)
                                <option value="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                        {{ request('sort', 'latest') === $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down text-[16px] text-[#6b716c] absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         4. MAIN SERVICES GRID (Wall-to-Wall 4 Columns on PC View)
    ================================================================ --}}
    <section id="services-section" class="max-w-7xl mx-auto px-1 sm:px-6 mt-4 sm:mt-6">
        @if($services->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 items-stretch auto-rows-fr gap-2 sm:gap-5 w-full">
                @foreach($services as $service)
                    <div class="group relative w-full min-w-0 bg-white rounded-xl sm:rounded-2xl border border-black/[0.07] overflow-hidden hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        {{-- Top Animated Accent Line --}}
                        <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>

                        <div>
                            {{-- Image Container --}}
                            <a href="{{ route('services.show', $service->slug) }}" class="block relative aspect-[4/3] overflow-hidden bg-[#f6f6f6]">
                                @if($service->main_image_url)
                                    <img src="{{ $service->main_image_url }}" alt="{{ $service->name }}" loading="lazy"
                                         class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105">
                                @else
                                    <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                        <i class="fa-solid fa-pen-ruler text-4xl sm:text-5xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent"></div>

                                {{-- Category Badge --}}
                                @if($service->category)
                                    <span class="absolute top-2 left-2 sm:top-3 sm:left-3 z-10 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-12 bg-white/95 text-[#3f453f] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-[0.12em] shadow-sm">
                                        {{ $service->category->name }}
                                    </span>
                                @endif

                                {{-- Delivery or Package badge on top right --}}
                                @if($service->delivery_time)
                                    <span class="absolute top-2 right-2 sm:top-3 sm:right-3 z-10 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-12 bg-[#1c201e]/85 backdrop-blur-sm text-[#9acd32] text-[8px] sm:text-[9px] font-extrabold tracking-wide shadow-sm flex items-center gap-0.5 sm:gap-1">
                                        <i class="fa-solid fa-clock text-[9px] sm:text-[11px]"></i>
                                        {{ $service->delivery_time }}
                                    </span>
                                @endif
                            </a>

                            {{-- Service Info --}}
                            <div class="p-2.5 sm:p-3.5">
                                {{-- Store / Provider Info --}}
                                <div class="flex items-center justify-between gap-2">
                                    <p class="text-[8.5px] sm:text-[10px] font-bold uppercase tracking-[0.12em] text-[#9aa19c] truncate flex items-center gap-1">
                                        {{ $service->store->name ?? 'Izifai Provider' }}
                                        @if($service->store?->is_verified)
                                            <i class="fa-solid fa-circle-check text-[10px] sm:text-[11px] text-[#659316] shrink-0" style=""></i>
                                        @endif
                                    </p>

                                    @if(($service->rating ?? 0) > 0)
                                        <span class="inline-flex items-center gap-0.5 text-[9.5px] sm:text-[11px] font-extrabold text-[#5c625e] shrink-0">
                                            <i class="fa-solid fa-star text-[10px] sm:text-[13px] text-amber-400" style=""></i>
                                            {{ number_format($service->rating, 1) }}
                                        </span>
                                    @endif
                                </div>

                                {{-- Service Title --}}
                                <a href="{{ route('services.show', $service->slug) }}" class="block mt-1">
                                    <h3 class="text-[12px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 group-hover:text-[#7ca81d] transition-colors">
                                        {{ $service->name }}
                                    </h3>
                                </a>

                                @if($service->description)
                                    <p class="text-[10px] sm:text-[11px] text-[#6b716c] line-clamp-2 mt-1 leading-relaxed">
                                        {{ $service->description }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        {{-- Card Footer --}}
                        <div class="p-2.5 sm:p-3.5 pt-2 sm:pt-2.5 border-t border-[#f0f1f0] flex items-center justify-between gap-1.5 sm:gap-2">
                            <div class="min-w-0">
                                <span class="text-[8px] sm:text-[9px] font-bold text-[#9aa19c] uppercase tracking-wider block">Starting at</span>
                                <span class="inline-flex items-baseline gap-0.5 sm:gap-1 mt-0.5 sm:mt-0.5 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-6 bg-[#f2f9df] text-[#659316]">
                                    <span class="skew-x-6 text-[12px] sm:text-[13px] font-black leading-tight tnum">
                                        {{ number_format($service->starting_price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span>
                                    </span>
                                </span>
                            </div>

                            <a href="{{ route('services.show', $service->slug) }}"
                               class="inline-flex items-center gap-1 sm:gap-1.5 text-[10px] sm:text-[11px] font-extrabold text-[#1c201e] group-hover:text-[#7ca81d] transition-colors">
                                Book Now
                                <span class="grid place-items-center w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-[#f2f9df] text-[#7ca81d] group-hover:bg-[#9acd32] group-hover:text-[#1c201e] transition-colors">
                                    <i class="fa-solid fa-arrow-right text-[10px] sm:text-[13px]"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10 sm:mt-12 flex justify-center">
                {{ $services->links('partials.pagination') }}
            </div>

        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-[#e8eae8] p-8 sm:p-16 text-center shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#f2f9df] text-[#659316] flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-pen-ruler text-4xl sm:text-5xl" style=""></i>
                </div>
                <h3 class="text-lg sm:text-xl font-extrabold text-[#1c201e]">No services found</h3>
                <p class="text-xs sm:text-sm text-[#6b716c] mt-1.5 max-w-md mx-auto leading-relaxed">
                    @if($hasActiveFilters)
                        We couldn't find any services matching your criteria. Try adjusting your search query or reset filters.
                    @else
                        No services have been listed in this catalog yet. Be the first provider to offer your skills!
                    @endif
                </p>
                <div class="mt-6 flex items-center justify-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('services.index') }}"
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
                            Browse Providers
                        </span>
                    </a>
                </div>
            </div>
        @endif
    </section>

    {{-- ================================================================
         5. FEATURED SERVICES SPOTLIGHT (Matching Home Deals aesthetic)
    ================================================================ --}}
    @if(isset($featuredServices) && $featuredServices->count() > 0 && !request('q'))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 sm:mt-14">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <span class="grid place-items-center w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-[#9acd32] text-[#1c201e] shadow-md sm:shadow-lg shadow-[#9acd32]/30 shrink-0">
                    <i class="fa-solid fa-wand-magic-sparkles text-[16px] sm:text-[20px]" style=""></i>
                </span>
                <div>
                    <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Featured Pro Services</h2>
                    <p class="text-[10px] sm:text-[12px] text-[#6b716c] -mt-0.5">Top-rated services recommended by Izifai</p>
                </div>
            </div>
        </div>

        <div class="flex gap-2.5 sm:gap-3.5 overflow-x-auto no-scrollbar pb-2">
            @foreach($featuredServices as $s)
                <a href="{{ route('services.show', $s->slug) }}" class="group shrink-0 w-[8.75rem] sm:w-52 rounded-xl sm:rounded-2xl bg-white border border-[#e8eae8] overflow-hidden hover:shadow-[0_16px_40px_-12px_rgba(0,0,0,0.14)] hover:-translate-y-1 transition-all duration-300">
                    <div class="relative aspect-[4/3] bg-[#f5f6f5] overflow-hidden">
                        @if($s->main_image_url)
                            <img src="{{ $s->main_image_url }}" alt="{{ $s->name }}" loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                                <i class="fa-solid fa-pen-ruler text-4xl"></i>
                            </div>
                        @endif
                    </div>
                    <div class="p-2.5 sm:p-3">
                        <p class="text-[10.5px] sm:text-[12px] font-bold text-[#1c201e] line-clamp-1 group-hover:text-[#7ca81d] transition-colors">{{ $s->name }}</p>
                        <p class="text-[8.5px] sm:text-[10px] text-[#9aa19c] truncate mt-0.5">{{ $s->store->name ?? 'Verified Pro' }}</p>
                        <div class="flex items-baseline gap-1 mt-1.5 sm:mt-2">
                            <span class="text-[8.5px] text-[#9aa19c] font-bold">From</span>
                            <span class="text-[12px] sm:text-[13px] font-black text-[#659316] tnum">{{ number_format($s->starting_price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ================================================================
         6. TOP SERVICE STORES (Matching Home "Top stores" aesthetic)
    ================================================================ --}}
    @if(isset($topStores) && $topStores->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 mt-10 sm:mt-14">
        <div class="flex items-end justify-between gap-3 mb-3.5 sm:mb-5">
            <div>
                <h2 class="text-sm sm:text-xl font-extrabold tracking-tight text-[#1c201e]">Top Verified Providers</h2>
                <p class="text-[10px] sm:text-[12px] text-[#6b716c] mt-0.5">Reliable agencies and freelance pros on Izifai</p>
            </div>
            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-[#7ca81d] hover:text-[#659316] transition-colors whitespace-nowrap">
                View all providers <i class="fa-solid fa-arrow-right text-[14px] sm:text-[15px]" style=""></i>
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
                            <span class="text-[10px] sm:text-[11px] text-[#9aa19c]">{{ $store->services_count }} services</span>
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
        <div x-show="openMobileFilters"
             x-transition:enter="transition-opacity duration-300"
             x-transition:leave="transition-opacity duration-200"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"
             @click="openMobileFilters = false"></div>

        <div x-show="openMobileFilters"
             x-transition:enter="transition-transform duration-300 ease-out"
             x-transition:leave="transition-transform duration-250 ease-in"
             class="filter-sheet open absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] overflow-y-auto shadow-2xl flex flex-col">

            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-[#eff1ef] px-5 py-4 flex items-center justify-between z-10">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[20px] text-[#7ca81d]" style=""></i>
                    <h3 class="text-sm font-extrabold text-[#1c201e]">Filter Services</h3>
                </div>
                <div class="flex items-center gap-3">
                    @if($hasActiveFilters)
                        <a href="{{ route('services.index') }}" class="text-xs font-bold text-[#7ca81d] hover:underline">Reset</a>
                    @endif
                    <button @click="openMobileFilters = false" class="w-8 h-8 rounded-full bg-[#f5f6f5] flex items-center justify-center text-[#1c201e]">
                        <i class="fa-solid fa-xmark text-[18px]"></i>
                    </button>
                </div>
            </div>

            <div class="p-5 space-y-6">
                {{-- Categories --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Category</h4>
                    <div class="space-y-1 max-h-48 overflow-y-auto pr-1">
                        <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ !request('category') ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                            All Categories
                            @if(!request('category'))
                                <i class="fa-solid fa-check text-[16px]"></i>
                            @endif
                        </a>
                        @foreach($categories as $c)
                            @php $isCActive = request('category') === $c->slug; @endphp
                            <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $c->slug])) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-bold {{ $isCActive ? 'bg-[#f2f9df] text-[#659316]' : 'text-[#3f453f] hover:bg-[#f5f6f5]' }}">
                                <span>{{ $c->name }}</span>
                                @if($isCActive)
                                    <i class="fa-solid fa-check text-[16px]"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Price Range --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Price Range (FCFA)</h4>
                    <form method="GET" action="{{ route('services.index') }}">
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

                {{-- Sort Order --}}
                <div>
                    <h4 class="text-xs font-extrabold text-[#1c201e] uppercase tracking-wider mb-2.5">Sort Order</h4>
                    <div class="space-y-1">
                        @foreach([
                            'latest' => 'Latest',
                            'popular' => 'Most Viewed',
                            'price_low' => 'Price: Low to High',
                            'price_high' => 'Price: High to Low'
                        ] as $sVal => $sLabel)
                            @php $isSortActive = request('sort', 'latest') === $sVal; @endphp
                            <a href="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $sVal])) }}"
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
