@extends('layouts.guest')
@section('title', $title . ' — Izifai')
@section('description', $description)

@push('styles')
<style>
    .rental-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .rental-card:hover { box-shadow: 0 8px 32px -8px rgba(0,109,56,0.12), 0 2px 8px -4px rgba(0,0,0,0.04); }
    .rental-card .img-wrap { position: relative; overflow: hidden; }
    .rental-card .img-wrap img { transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    .rental-card:hover .img-wrap img { transform: scale(1.08); }

    .category-card-rental { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .category-card-rental:hover { transform: translateY(-4px); }
    .category-card-rental.active { box-shadow: 0 0 0 2px #006d38, 0 4px 20px rgba(0,109,56,0.2); }
    .filter-sheet { transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-sheet.open { transform: translateY(0); }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .shimmer-bg { background: linear-gradient(90deg, #f0f7f0 0%, #e8f0e6 40%, #f0f7f0 80%); background-size: 200% 100%; animation: shimmer 1.8s infinite; }
    .filter-accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-accordion-content.open { max-height: 500px; }
    .filter-arrow { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-arrow.open { transform: rotate(180deg); }
    .h-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .h-scroll > * { scroll-snap-align: start; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
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
    .card-enter:nth-child(n+11) { animation-delay: 0.4s; }
    .hero-bg { background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=1400&q=80'); background-size: cover; background-position: center; }
    .hero-pattern-rental { background-image: radial-gradient(circle at 25% 40%, rgba(255,255,255,0.06) 0%, transparent 50%), radial-gradient(circle at 70% 60%, rgba(255,255,255,0.04) 0%, transparent 50%), repeating-linear-gradient(45deg, transparent, transparent 40px, rgba(255,255,255,0.02) 40px, rgba(255,255,255,0.02) 80px); }
    .mobile-sticky-bar { box-shadow: 0 -4px 20px rgba(0,0,0,0.06); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .store-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px -8px rgba(0,0,0,0.08); }
    .store-avatar { border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.8; } }
    @keyframes scalePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    .animate-dot-pulse { animation: dotPulse 1.5s ease-in-out infinite; }
    .animate-dot-pulse-delayed { animation: dotPulse 1.5s ease-in-out 0.5s infinite; }
    .animate-dot-pulse-slower { animation: dotPulse 1.5s ease-in-out 1s infinite; }
    .animate-scale-pulse { animation: scalePulse 2s ease-in-out infinite; }
    .billing-unit-tag { background: rgba(0, 0, 0, 0.04); }
    .deposit-badge { background: rgba(245,158,11,0.12); color: #b45309; }
</style>
@endpush

@section('store-sidebar')
    @if($topStores->count() > 0)
        <div class="p-4 border-b border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[15px] text-amber-600" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                    <h2 class="text-[10px] font-extrabold text-on-surface uppercase tracking-wider">Top Stores</h2>
                </div>
                <a href="{{ route('stores.index') }}" class="text-[9px] font-semibold text-primary hover:underline">View all</a>
            </div>
            <div class="space-y-2">
                @foreach($topStores as $store)
                    <a href="{{ route('stores.show', $store->slug) }}" class="store-card flex items-center gap-2.5 bg-surface-container-lowest rounded-xl p-2.5 border border-black/[0.03] transition-all hover:border-primary/20">
                        @if($store->logo)
                            <div class="store-avatar w-9 h-9 rounded-xl overflow-hidden shrink-0 bg-white">
                                <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                            </div>
                        @else
                            <x-store-default-logo :store="$store" size="sm" class="store-avatar rounded-xl" />
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1">
                                <h3 class="text-[11px] font-bold text-on-surface truncate">{{ $store->name }}</h3>
                                @if($store->is_verified)
                                    <span class="material-symbols-outlined text-[9px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-[8px] text-on-surface-variant/50">{{ $store->rental_items_count ?? 0 }} rentals</span>
                                @if($store->location)
                                    <span class="text-[8px] text-on-surface-variant/40 truncate">· {{ $store->location }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-[14px] text-on-surface-variant/20">chevron_right</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

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
                <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ !request('category') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                    <span class="material-symbols-outlined text-[15px] {{ !request('category') ? 'text-primary' : '' }}">grid_view</span>
                    All Rentals
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('rentals.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="flex items-center justify-between gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('category') === $cat->slug ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="flex items-center gap-2.5 truncate">
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="w-4 h-4 flex items-center justify-center shrink-0">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-[15px] shrink-0">circle</span>
                            @endif
                            <span class="truncate">{{ $cat->name }}</span>
                        </span>
                        <span class="text-[10px] text-on-surface-variant/40 font-medium shrink-0">{{ $cat->rentalItems->count() }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">payments</span>
                Price Range
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <form method="GET" action="{{ route('rentals.index') }}" id="sidebar-price-form">
                @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="flex items-center gap-2">
                    <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                           class="w-full h-9 px-3 bg-surface-container-low border border-black/8 rounded-lg text-xs focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                           onchange="document.getElementById('sidebar-price-form').submit()">
                    <span class="text-[10px] text-on-surface-variant/30 font-medium">to</span>
                    <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                           class="w-full h-9 px-3 bg-surface-container-low border border-black/8 rounded-lg text-xs focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                           onchange="document.getElementById('sidebar-price-form').submit()">
                </div>
                <button type="submit" class="mt-2.5 w-full h-9 bg-on-surface/5 hover:bg-on-surface/10 text-on-surface text-[11px] font-bold rounded-lg transition-all active:scale-[0.98]">Apply</button>
            </form>
        </div>
    </div>

    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">schedule</span>
                Billing Period
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <div class="space-y-0.5">
                <a href="{{ route('rentals.index', request()->except(['billing_unit', 'page'])) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ !request('billing_unit') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                    Any Period
                </a>
                @foreach(['hourly' => 'Per Hour', 'daily' => 'Per Day', 'weekly' => 'Per Week', 'monthly' => 'Per Month'] as $val => $label)
                    <a href="{{ route('rentals.index', array_merge(request()->except(['billing_unit', 'page']), ['billing_unit' => $val])) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('billing_unit') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">location_on</span>
                Location
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <form method="GET" action="{{ route('rentals.index') }}" id="sidebar-location-form">
                @foreach(request()->except(['location', 'page']) as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <input type="text" name="location" placeholder="City or area..." value="{{ request('location') }}"
                       class="w-full h-9 px-3 bg-surface-container-low border border-black/8 rounded-lg text-xs focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all"
                       onchange="document.getElementById('sidebar-location-form').submit()">
                <button type="submit" class="mt-2.5 w-full h-9 bg-on-surface/5 hover:bg-on-surface/10 text-on-surface text-[11px] font-bold rounded-lg transition-all active:scale-[0.98]">Apply</button>
            </form>
        </div>
    </div>

    <div class="p-4" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">sort</span>
                Sort By
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <div class="space-y-0.5">
                @foreach(['latest' => 'Latest', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low', 'popular' => 'Most Viewed'] as $val => $label)
                    <a href="{{ route('rentals.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('sort', 'latest') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="material-symbols-outlined text-[15px] {{ request('sort', 'latest') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'latest' ? 'schedule' : ($val === 'price_low' ? 'north' : ($val === 'price_high' ? 'south' : 'visibility')) }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('content')
<div x-data="{ openMobileFilters: false }" class="min-h-screen bg-surface pb-20 lg:pb-0">

    {{-- HERO — rental equipment image + dark overlay --}}
    <section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
        <div class="relative min-h-[220px] sm:min-h-[280px] lg:min-h-[300px] rounded-2xl overflow-hidden shadow-sm">
            <div class="absolute inset-0 bg-cover bg-center rounded-2xl hero-bg"></div>
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>
            <div class="absolute inset-0 hero-pattern-rental"></div>
            <div class="absolute inset-0 pointer-events-none opacity-[0.06]">
                <div class="absolute top-20 left-[15%] w-1 h-1 rounded-full bg-white animate-dot-pulse"></div>
                <div class="absolute top-40 left-[35%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
                <div class="absolute top-10 right-[25%] w-1 h-1 rounded-full bg-white animate-dot-pulse-slower"></div>
                <div class="absolute bottom-40 right-[20%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
                <div class="absolute bottom-20 left-[40%] w-1 h-1 rounded-full bg-white animate-dot-pulse"></div>
            </div>
            <div class="absolute bottom-0 left-0 right-0 px-5 sm:px-6 lg:px-10 py-4 sm:py-6 lg:py-8">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                        <div class="max-w-2xl min-w-0">
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 mb-2 sm:mb-3">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-300 animate-scale-pulse"></span>
                                <span class="text-[8px] sm:text-[10px] font-bold text-white/90 tracking-wide truncate max-w-[180px] sm:max-w-none">Equipment & Gear Rental</span>
                            </div>
                            <h1 class="text-xl sm:text-3xl lg:text-5xl font-black leading-[1.1] sm:leading-[1.04] tracking-[-0.03em] text-white text-balance">
                                Borrow <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-300 to-emerald-300">What You Need</span>
                            </h1>
                            <p class="text-[10px] sm:text-sm text-white/80 max-w-xl leading-snug sm:leading-relaxed mt-1 sm:mt-2 line-clamp-1 sm:line-clamp-none">
                                Rent equipment, tools, vehicles and more from trusted providers near you — pay by the hour, day, or week.
                            </p>
                            <div class="flex items-center gap-2 sm:gap-5 mt-2 sm:mt-4">
                                <span class="text-white text-[10px] sm:text-sm font-bold">
                                    <span class="text-sm sm:text-lg font-black">{{ number_format($rentals->total()) }}</span> Items
                                </span>
                                <span class="text-white/60 text-[8px] sm:text-[10px]">Flexible rental periods</span>
                            </div>

                            @if(request('q') || request('category') || request('min_price') || request('max_price') || request('billing_unit') || request('location') || (request('sort') && request('sort') !== 'latest'))
                                <div class="flex flex-wrap items-center gap-1 mt-1">
                                    @if(request('category'))
                                        @php $catName = $categories->firstWhere('slug', request('category'))?->name ?? request('category'); @endphp
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ $catName }}
                                            <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    @if(request('min_price') || request('max_price'))
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            @if(request('min_price') && request('max_price'))
                                                {{ number_format((int)request('min_price')) }}–{{ number_format((int)request('max_price')) }} FCFA
                                            @elseif(request('min_price'))
                                                From {{ number_format((int)request('min_price')) }} FCFA
                                            @else
                                                Up to {{ number_format((int)request('max_price')) }} FCFA
                                            @endif
                                            <a href="{{ route('rentals.index', request()->except(['min_price', 'max_price', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    @if(request('billing_unit'))
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ ucfirst(request('billing_unit')) }}
                                            <a href="{{ route('rentals.index', request()->except(['billing_unit', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    @if(request('location'))
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ request('location') }}
                                            <a href="{{ route('rentals.index', request()->except(['location', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    @if(request('sort') && request('sort') !== 'latest')
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ request('sort') === 'price_low' ? 'Low→High' : (request('sort') === 'price_high' ? 'High→Low' : 'Popular') }}
                                            <a href="{{ route('rentals.index', request()->except(['sort', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    <a href="{{ route('rentals.index') }}" class="text-[7px] font-semibold text-white/60 hover:text-white underline underline-offset-2 transition-colors">Clear</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED RENTALS — horizontal card style with premium badge --}}
    @if($featuredRentals->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-primary/[0.06] flex items-center justify-center shadow-sm border border-primary/10">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">recommend</span>
                    </span>
                    <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Featured Rentals</h2>
                </div>
                <span class="text-[9px] sm:text-[10px] font-semibold text-on-surface-variant/50">Top picks</span>
            </div>
            {{-- Mobile horizontal scroll --}}
            <div x-data="autoScroll()" class="flex gap-3 overflow-x-auto no-scrollbar h-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
                @foreach($featuredRentals as $item)
                    <div class="w-[280px] shrink-0 card-enter" style="animation-delay: {{ $loop->index * 0.06 }}s">
                        <a href="{{ route('rentals.show', $item->slug) }}" class="block rental-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group flex">
                            <div class="w-[120px] shrink-0 aspect-[4/3] bg-surface-container-low overflow-hidden">
                                @if($item->main_image_url)
                                    <img src="{{ $item->main_image_url }}" alt="{{ $item->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-2xl">image</span></div>
                                @endif
                            </div>
                            <div class="flex-1 p-2.5 min-w-0 flex flex-col justify-between">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-1 mb-0.5">
                                        <span class="text-[7px] font-bold text-primary uppercase tracking-wide bg-primary/[0.06] px-1 py-0.5 rounded flex items-center gap-0.5"><span class="material-symbols-outlined text-[7px]" style="font-variation-settings: 'FILL' 1;">stars</span> Featured</span>
                                        @if($item->category)
                                            <span class="text-[7px] text-on-surface-variant/50 truncate">{{ $item->category->name }}</span>
                                        @endif
                                    </div>
                                    <h3 class="text-[10px] font-bold text-on-surface leading-snug line-clamp-1">{{ $item->name }}</h3>
                                    @if($item->store)
                                        <p class="text-[7px] text-on-surface-variant/50 truncate mt-0.5">{{ $item->store->name }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center justify-between mt-1 pt-1 border-t border-black/[0.04]">
                                    <span class="text-[10px] font-black text-orange-600">{{ number_format($item->rate) }}<span class="text-[6px] text-orange-400">/<span class="lowercase">{{ substr($item->billing_unit,0,1) }}</span></span></span>
                                    @if($item->deposit)
                                        <span class="deposit-badge text-[6px] font-bold px-1 py-0.5 rounded">Dep {{ number_format($item->deposit/1000,1) }}k</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0"></div>
            </div>
            {{-- Desktop grid --}}
            <div class="hidden lg:grid lg:grid-cols-2 gap-3">
                @foreach($featuredRentals as $item)
                    <div class="rental-card bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-sm group flex card-enter" style="animation-delay: {{ $loop->index * 0.06 }}s">
                        <a href="{{ route('rentals.show', $item->slug) }}" class="flex w-full">
                            <div class="w-[40%] shrink-0 aspect-[4/3] bg-surface-container-low overflow-hidden relative">
                                @if($item->main_image_url)
                                    <img src="{{ $item->main_image_url }}" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-3xl">image</span></div>
                                @endif
                                <span class="absolute top-2 left-2 bg-primary/90 backdrop-blur-sm text-on-primary text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm">
                                    <span class="material-symbols-outlined text-[7px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                                    Featured
                                </span>
                            </div>
                            <div class="flex-1 p-3.5 min-w-0 flex flex-col justify-between">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-2 mb-0.5">
                                        @if($item->category)
                                            <p class="text-[9px] font-semibold text-primary/70 uppercase tracking-wide truncate">{{ $item->category->name }}</p>
                                        @endif
                                        @if($item->rating > 0)
                                            <span class="flex items-center gap-0.5 text-[9px] font-semibold text-amber-600">
                                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                                {{ number_format($item->rating, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    <h3 class="text-sm font-bold text-on-surface leading-snug line-clamp-1">{{ $item->name }}</h3>
                                    @if($item->store)
                                        <p class="text-[10px] text-on-surface-variant/60 truncate mt-0.5 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[10px]">store</span>
                                            {{ $item->store->name }}
                                        </p>
                                    @endif
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        @if($item->location)
                                            <span class="inline-flex items-center gap-0.5 text-[8px] text-on-surface-variant/50">
                                                <span class="material-symbols-outlined text-[9px]">location_on</span>
                                                {{ $item->location }}
                                            </span>
                                        @endif
                                        @if($item->deposit)
                                            <span class="deposit-badge text-[8px] font-bold px-1.5 py-0.5 rounded">Dep {{ number_format($item->deposit/1000,1) }}k</span>
                                        @endif
                                        <span class="billing-unit-tag text-[8px] font-semibold px-1.5 py-0.5 rounded-full capitalize">{{ $item->billing_unit }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/[0.04]">
                                    <span class="text-xs font-black text-orange-600">{{ number_format($item->rate) }} <span class="text-[7px] font-bold text-orange-400">FCFA/<span class="lowercase">{{ $item->billing_unit }}</span></span></span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary text-on-primary text-[9px] font-bold rounded-lg hover:bg-primary/90 active:scale-[0.97] transition-all shadow-sm">
                                        Rent Now
                                        <span class="material-symbols-outlined text-[10px]">arrow_forward</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CATEGORIES — green-toned icon cards --}}
    @if($categories->count() > 0)
        @php
            $rentalColors = [
                ['bg' => 'from-emerald-600 to-green-700', 'light' => 'bg-emerald-50', 'icon' => 'text-emerald-600'],
                ['bg' => 'from-green-600 to-teal-700', 'light' => 'bg-green-50', 'icon' => 'text-green-600'],
                ['bg' => 'from-teal-600 to-cyan-700', 'light' => 'bg-teal-50', 'icon' => 'text-teal-600'],
                ['bg' => 'from-lime-600 to-green-700', 'light' => 'bg-lime-50', 'icon' => 'text-lime-600'],
            ];
        @endphp
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-primary/[0.06] flex items-center justify-center shadow-sm border border-primary/10">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-primary">category</span>
                    </span>
                    <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Browse by Category</h2>
                </div>
                @if(request('category'))
                    <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}" class="text-[10px] font-semibold text-primary hover:underline">All</a>
                @endif
            </div>
            <div class="flex gap-3 overflow-x-auto no-scrollbar h-scroll pb-2 sm:pb-0 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:grid lg:grid-cols-4 lg:gap-3">
                @foreach($categories as $i => $cat)
                    @php $c = $rentalColors[$i % count($rentalColors)]; @endphp
                    <a href="{{ route('rentals.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="category-card-rental shrink-0 w-[130px] sm:w-[140px] lg:w-auto lg:shrink-0 block bg-white rounded-2xl border border-black/[0.04] shadow-sm overflow-hidden group {{ request('category') === $cat->slug ? 'active' : 'hover:shadow-md' }} transition-all">
                        <div class="h-[72px] sm:h-20 bg-gradient-to-br {{ $c['bg'] }} flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/10"></div>
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="text-white/90 text-2xl sm:text-3xl relative z-10">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-white/80 text-2xl sm:text-3xl relative z-10" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                            @endif
                            @if(request('category') === $cat->slug)
                                <span class="absolute top-1.5 right-1.5 w-4 h-4 rounded-full bg-white/90 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[10px] text-primary" style="font-variation-settings: 'FILL' 1;">check</span>
                                </span>
                            @endif
                        </div>
                        <div class="p-2.5 sm:p-3">
                            <h3 class="text-[10px] sm:text-xs font-bold text-on-surface truncate">{{ $cat->name }}</h3>
                            <p class="text-[8px] sm:text-[9px] text-on-surface-variant/50 mt-0.5">{{ $cat->rentalItems->count() }} items</p>
                        </div>
                    </a>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0 lg:hidden"></div>
            </div>
        </section>
    @endif

    {{-- FILTER BAR --}}
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
        <div class="flex items-center gap-2.5">
            <form method="GET" action="{{ route('rentals.index') }}" class="flex-1 max-w-xs hidden sm:block">
                @foreach(request()->except(['q', 'page']) as $key => $value)
                    @if(is_array($value))
                        @foreach($value as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="relative">
                    <span class="material-symbols-outlined text-[16px] text-on-surface-variant/30 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                    <input type="text" name="q" placeholder="Search rentals..." value="{{ request('q') }}"
                           class="w-full h-9 pl-9 pr-3 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all placeholder:text-on-surface-variant/30">
                </div>
            </form>

            <button @click="openMobileFilters = true"
                    class="lg:hidden flex items-center gap-2 h-9 px-3.5 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[15px]">filter_list</span>
                Filters
                @php $activeFilterCount = collect([request('category'), request('min_price'), request('max_price'), request('billing_unit'), request('location')])->filter()->count(); @endphp
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <select onchange="window.location.href=this.value"
                    class="lg:hidden h-9 px-3 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[160px]">
                @foreach(['latest' => 'Latest', 'price_low' => 'Price: Low ↑', 'price_high' => 'Price: High ↓', 'popular' => 'Most Viewed'] as $val => $label)
                    <option value="{{ route('rentals.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'latest') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="hidden lg:flex items-center gap-3 ml-auto">
                <span class="text-xs text-on-surface-variant">
                    <span class="font-bold text-on-surface">{{ $rentals->firstItem() ?? 0 }}</span>–<span class="font-bold text-on-surface">{{ $rentals->lastItem() ?? 0 }}</span>
                    <span class="text-on-surface-variant/40">of</span>
                    <span class="font-bold text-on-surface">{{ number_format($rentals->total()) }}</span>
                </span>
            </div>
        </div>
    </section>

    {{-- RENTALS GRID — "Equipment Showcase" cards --}}
    <section id="rentals-section" class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
        @if($rentals->count() > 0)
            <div class="hidden lg:flex items-center justify-between mb-3">
                <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">All Rentals</h2>
                <span class="text-xs text-on-surface-variant">{{ $rentals->total() }} results</span>
            </div>
            <div class="hidden lg:grid grid-cols-2 gap-3">
                @foreach($rentals as $item)
                    <div class="rental-card card-enter bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] group flex">
                        <a href="{{ route('rentals.show', $item->slug) }}" class="flex w-full">
                            {{-- Image --}}
                            <div class="img-wrap w-[36%] shrink-0 bg-surface-container-low relative overflow-hidden">
                                @if($item->main_image_url)
                                    <img class="w-full h-full object-cover"
                                         src="{{ $item->main_image_url }}"
                                         alt="{{ $item->name }}" loading="lazy"
                                         onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full flex items-center justify-center text-on-surface-variant/20\'><span class=\'material-symbols-outlined text-3xl\'>image</span></div>'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                        <span class="material-symbols-outlined text-3xl">image</span>
                                    </div>
                                @endif
                            </div>
                            {{-- Info panel --}}
                            <div class="flex-1 p-3.5 flex flex-col justify-between min-w-0">
                                <div class="min-w-0">
                                    {{-- Top row: Category + Rate --}}
                                    <div class="flex items-start justify-between gap-2">
                                        @if($item->category)
                                            <p class="text-[9px] font-semibold text-primary/70 uppercase tracking-wide truncate">{{ $item->category->name }}</p>
                                        @endif
                                        <span class="text-xs font-black text-orange-600 shrink-0 leading-none">{{ number_format($item->rate) }} <span class="text-[7px] font-bold text-orange-400 font-sans">/{{ $item->billing_unit }}</span></span>
                                    </div>
                                    {{-- Item name --}}
                                    <h3 class="text-[13px] font-bold text-on-surface leading-snug line-clamp-1 mt-0.5">{{ $item->name }}</h3>
                                    {{-- Store + Rating --}}
                                    <div class="flex items-center gap-2 mt-1">
                                        @if($item->store)
                                            <p class="text-[10px] text-on-surface-variant/60 truncate flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[10px]">store</span>
                                                {{ $item->store->name }}
                                            </p>
                                        @endif
                                        @if($item->rating > 0)
                                            <span class="flex items-center gap-0.5 text-[9px] font-semibold text-amber-600 shrink-0">
                                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                                {{ number_format($item->rating, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                    {{-- Specs row: Location · Deposit · Billing unit --}}
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        @if($item->location)
                                            <span class="inline-flex items-center gap-0.5 text-[8px] text-on-surface-variant/50">
                                                <span class="material-symbols-outlined text-[9px]">location_on</span>
                                                {{ $item->location }}
                                            </span>
                                        @endif
                                        @if($item->deposit)
                                            <span class="deposit-badge text-[8px] font-bold px-1.5 py-0.5 rounded">Dep {{ number_format($item->deposit/1000,1) }}k</span>
                                        @endif
                                        <span class="billing-unit-tag text-[8px] font-semibold px-1.5 py-0.5 rounded-full capitalize">{{ $item->billing_unit }}</span>
                                    </div>
                                </div>
                                {{-- Bottom row: Views + Rent Now button --}}
                                <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/[0.04]">
                                    <span class="flex items-center gap-0.5 text-[8px] text-on-surface-variant/40">
                                        <span class="material-symbols-outlined text-[9px]">visibility</span>
                                        {{ number_format($item->views) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-primary text-on-primary text-[9px] font-bold rounded-lg hover:bg-primary/90 active:scale-[0.97] transition-all shadow-sm">
                                        Rent Now
                                        <span class="material-symbols-outlined text-[10px]">arrow_forward</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="lg:hidden">
                <div class="flex items-center justify-between mb-2.5">
                    <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">More Rentals</h2>
                    <span class="text-[10px] text-on-surface-variant font-medium">{{ $rentals->total() }} results</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    @foreach($rentals as $item)
                        <div class="rental-card card-enter bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex flex-col group">
                            <a href="{{ route('rentals.show', $item->slug) }}" class="flex flex-col h-full">
                                <div class="aspect-[4/3] bg-surface-container-low relative overflow-hidden shrink-0">
                                    @if($item->main_image_url)
                                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                             src="{{ $item->main_image_url }}"
                                             alt="{{ $item->name }}" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                            <span class="material-symbols-outlined text-4xl">image</span>
                                        </div>
                                    @endif
                                    @if($item->location)
                                        <span class="absolute top-1.5 left-1.5 bg-white/90 backdrop-blur-sm text-slate-800 text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm">
                                            <span class="material-symbols-outlined text-[8px]">location_on</span>
                                            {{ $item->location }}
                                        </span>
                                    @endif
                                </div>
                                <div class="p-2 flex flex-col flex-1 justify-between gap-1">
                                    <div class="min-w-0">
                                        <div class="flex items-start justify-between gap-1">
                                            <div class="min-w-0 flex-1">
                                                @if($item->category)
                                                    <p class="text-[7px] font-semibold text-primary/70 uppercase tracking-wide truncate">{{ $item->category->name }}</p>
                                                @endif
                                                <h3 class="text-[10px] font-bold text-on-surface leading-snug line-clamp-1">{{ $item->name }}</h3>
                                            </div>
                                            <span class="text-[10px] font-black text-orange-600 shrink-0 leading-none mt-0.5">{{ number_format($item->rate) }}<span class="text-[6px] text-orange-400">/<span class="lowercase">{{ substr($item->billing_unit,0,1) }}</span></span></span>
                                        </div>
                                        @if($item->store)
                                            <p class="text-[7px] text-on-surface-variant/50 truncate mt-0.5">{{ $item->store->name }}</p>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($item->deposit)
                                            <span class="deposit-badge text-[6px] font-bold px-1 py-0.5 rounded">Dep {{ number_format($item->deposit/1000,1) }}k</span>
                                        @endif
                                        <span class="billing-unit-tag text-[6px] font-semibold px-1 py-0.5 rounded capitalize">{{ $item->billing_unit }}</span>
                                        <span class="ml-auto text-[7px] text-on-surface-variant/40 flex items-center gap-0.5">
                                            <span class="material-symbols-outlined text-[7px]">visibility</span>
                                            {{ $item->views }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($topStores->count() > 0)
                <div class="lg:hidden mt-8">
                    <div class="flex items-center justify-between mb-2.5">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px] text-amber-600" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                            <h2 class="text-[10px] font-extrabold text-on-surface uppercase tracking-wider">Top Stores</h2>
                        </div>
                        <a href="{{ route('stores.index') }}" class="text-[9px] font-semibold text-primary hover:underline">View all</a>
                    </div>
                    <div class="flex gap-2.5 overflow-x-auto no-scrollbar pb-2 -mx-3 px-3">
                        @foreach($topStores as $store)
                            <div class="w-[150px] shrink-0">
                                <a href="{{ route('stores.show', $store->slug) }}" class="store-card block bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm">
                                    @if($store->banner)
                                        <div class="h-12 overflow-hidden bg-surface-container-low">
                                            <img src="{{ $store->banner_url }}" alt="" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <x-store-default-banner :store="$store" variant="card" class="h-12" />
                                    @endif
                                    <div class="px-2.5 pb-2.5 relative">
                                        <div class="flex items-end -mt-5 mb-1.5">
                                            @if($store->logo)
                                                <div class="store-avatar w-8 h-8 rounded-lg overflow-hidden shrink-0 bg-white">
                                                    <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <x-store-default-logo :store="$store" size="sm" class="store-avatar rounded-lg" />
                                            @endif
                                            @if($store->is_verified)
                                                <span class="ml-1 mb-0.5 w-3 h-3 rounded-full bg-primary/10 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-[7px] text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="text-[10px] font-bold text-on-surface truncate">{{ $store->name }}</h3>
                                        <span class="text-[8px] text-on-surface-variant/50">{{ $store->rental_items_count ?? 0 }} rentals</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        <div class="w-3 shrink-0"></div>
                    </div>
                </div>
            @endif

            <div class="mt-6 sm:mt-8 lg:mt-10">
                {{ $rentals->links('partials.pagination') }}
            </div>
        @else
            <div class="text-center py-16 sm:py-24 bg-white rounded-2xl border border-black/[0.04] shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-surface-container-low flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant/30" style="font-variation-settings: 'FILL' 1;">shelves</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-on-surface">No rentals found</h3>
                @if(request('q') || request('category') || request('min_price') || request('max_price') || request('billing_unit') || request('location'))
                    <p class="text-sm text-on-surface-variant mt-1 max-w-sm mx-auto leading-relaxed">We couldn't find any rental items matching your criteria. Try adjusting your filters.</p>
                    <div class="flex items-center justify-center gap-3 mt-6">
                        <a href="{{ route('rentals.index') }}"
                           class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[14px]">close</span>
                            Clear All Filters
                        </a>
                    </div>
                @else
                    <p class="text-sm text-on-surface-variant mt-1">No rental items have been listed yet. Check back soon!</p>
                @endif
            </div>
        @endif
    </section>

    {{-- MOBILE BOTTOM STICKY BAR --}}
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-40 mobile-sticky-bar bg-white/90 border-t border-black/[0.04] px-3 py-2.5">
        <div class="flex items-center gap-2.5 max-w-lg mx-auto">
            <button @click="openMobileFilters = true"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">filter_list</span>
                Filters
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <button @click="document.querySelector('#rentals-section')?.scrollIntoView({ behavior: 'smooth' })"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">grid_view</span>
                Rentals
            </button>

            <select onchange="window.location.href=this.value"
                    class="h-9 px-2.5 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[130px]">
                @foreach(['latest' => 'Latest', 'price_low' => 'Low ↑', 'price_high' => 'High ↓', 'popular' => 'Popular'] as $val => $label)
                    <option value="{{ route('rentals.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'latest') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- MOBILE FILTER BOTTOM SHEET --}}
    <div x-cloak x-show="openMobileFilters" class="fixed inset-0 z-50 lg:hidden">
        <div x-show="openMobileFilters" x-transition:enter="transition-opacity duration-250" x-transition:leave="transition-opacity duration-200"
             class="absolute inset-0 bg-black/30 backdrop-blur-sm" @click="openMobileFilters = false"></div>
        <div x-show="openMobileFilters" x-transition:enter="transition-transform duration-350 ease-out" x-transition:leave="transition-transform duration-250 ease-in"
             class="filter-sheet open absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[88vh] overflow-y-auto shadow-2xl">
            <div class="sticky top-0 bg-white/95 backdrop-blur-md border-b border-black/[0.04] px-5 py-4 flex items-center justify-between rounded-t-3xl z-10">
                <div class="flex items-center gap-3">
                    <h3 class="text-sm font-bold text-on-surface">Filters</h3>
                    @php $totalFilters = collect([request('category'), request('min_price'), request('max_price'), request('q'), request('billing_unit'), request('location')])->filter()->count(); @endphp
                    @if($totalFilters > 0)
                        <span class="px-2 py-0.5 rounded-full bg-primary/5 text-primary text-[9px] font-bold">{{ $totalFilters }} active</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($totalFilters > 0)
                        <a href="{{ route('rentals.index') }}" class="text-[10px] font-semibold text-primary hover:underline">Reset</a>
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
                            <a href="{{ route('rentals.index', request()->except(['category', 'page'])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ !request('category') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                               @click="openMobileFilters = false">
                                <span class="material-symbols-outlined text-[18px]">grid_view</span>
                                All Rentals
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('rentals.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('category') === $cat->slug ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
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
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">payments</span>Price Range</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <form method="GET" action="{{ route('rentals.index') }}" id="mobile-price-form">
                            @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="flex items-center gap-3">
                                <input type="number" name="min_price" placeholder="Min (FCFA)" value="{{ request('min_price') }}"
                                       class="w-full h-10 bg-surface-container-low border border-black/8 rounded-xl px-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
                                       onchange="document.getElementById('mobile-price-form').submit()">
                                <span class="text-[11px] text-on-surface-variant/30 font-medium">to</span>
                                <input type="number" name="max_price" placeholder="Max (FCFA)" value="{{ request('max_price') }}"
                                       class="w-full h-10 bg-surface-container-low border border-black/8 rounded-xl px-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
                                       onchange="document.getElementById('mobile-price-form').submit()">
                            </div>
                            <button type="submit" class="mt-2.5 w-full h-10 bg-on-surface/5 hover:bg-on-surface/10 text-on-surface text-xs font-bold rounded-xl transition-all active:scale-[0.98]">Apply</button>
                        </form>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl border border-black/[0.03] p-4" x-data="{ open: true }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-[11px] font-bold text-on-surface uppercase tracking-wider">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">schedule</span>Billing Period</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <div class="space-y-0.5">
                            <a href="{{ route('rentals.index', request()->except(['billing_unit', 'page'])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ !request('billing_unit') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                               @click="openMobileFilters = false">
                                Any Period
                            </a>
                            @foreach(['hourly' => 'Per Hour', 'daily' => 'Per Day', 'weekly' => 'Per Week', 'monthly' => 'Per Month'] as $val => $label)
                                <a href="{{ route('rentals.index', array_merge(request()->except(['billing_unit', 'page']), ['billing_unit' => $val])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('billing_unit') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                                   @click="openMobileFilters = false">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl border border-black/[0.03] p-4" x-data="{ open: true }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-[11px] font-bold text-on-surface uppercase tracking-wider">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">location_on</span>Location</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <form method="GET" action="{{ route('rentals.index') }}" id="mobile-location-form">
                            @foreach(request()->except(['location', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <input type="text" name="location" placeholder="City or area..." value="{{ request('location') }}"
                                   class="w-full h-10 bg-surface-container-low border border-black/8 rounded-xl px-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15"
                                   onchange="document.getElementById('mobile-location-form').submit()">
                        </form>
                    </div>
                </div>

                <div class="bg-surface-container-lowest rounded-2xl border border-black/[0.03] p-4" x-data="{ open: true }">
                    <button @click="open = !open" class="flex items-center justify-between w-full text-[11px] font-bold text-on-surface uppercase tracking-wider">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">sort</span>Sort By</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <div class="space-y-0.5">
                            @foreach(['latest' => 'Latest', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low', 'popular' => 'Most Viewed'] as $val => $label)
                                <a href="{{ route('rentals.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('sort', 'latest') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                                   @click="openMobileFilters = false">
                                    <span class="material-symbols-outlined text-[18px] {{ request('sort', 'latest') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'latest' ? 'schedule' : ($val === 'price_low' ? 'north' : ($val === 'price_high' ? 'south' : 'visibility')) }}</span>
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
