@extends('layouts.guest')
@section('title', $title . ' — Izifai')
@section('description', $description)

@push('styles')
<style>
    .service-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .category-card { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .category-card:hover { transform: translateY(-4px); }
    .category-card.active { box-shadow: 0 0 0 2px #006d38, 0 4px 16px rgba(0,109,56,0.15); }
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
    .hero-pattern { background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%); }
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
    .hero-bg { background-image: url('https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1400&q=80'); background-size: cover; background-position: center; }
    .price-current { color: #ea580c; }
    .price-current-fcfa { color: #ea580c; opacity: 0.7; }
    .package-pill { background: linear-gradient(135deg, #006d38, #00a859); }
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
                                <span class="text-[8px] text-on-surface-variant/50">{{ $store->services_count ?? 0 }} services</span>
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
                <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ !request('category') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                    <span class="material-symbols-outlined text-[15px] {{ !request('category') ? 'text-primary' : '' }}">grid_view</span>
                    All Services
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="flex items-center justify-between gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('category') === $cat->slug ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="flex items-center gap-2.5 truncate">
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="w-4 h-4 flex items-center justify-center shrink-0">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-[15px] shrink-0">circle</span>
                            @endif
                            <span class="truncate">{{ $cat->name }}</span>
                        </span>
                        <span class="text-[10px] text-on-surface-variant/40 font-medium shrink-0">{{ $cat->services->count() }}</span>
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
            <form method="GET" action="{{ route('services.index') }}" id="sidebar-price-form">
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
                    <a href="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
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

    {{-- HERO --}}
    <section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
        <div class="relative min-h-[220px] sm:min-h-[280px] lg:min-h-[300px] rounded-2xl shadow-sm">
            <div class="absolute inset-0 bg-cover bg-center rounded-2xl hero-bg"></div>
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>
            <div class="absolute inset-0 rounded-2xl hero-pattern"></div>
            <div class="absolute top-[-120px] right-[-80px] w-[400px] h-[400px] rounded-full bg-white/5 blur-[80px]"></div>
            <div class="absolute bottom-[-100px] left-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[80px]"></div>
            <div class="absolute inset-0 pointer-events-none opacity-[0.04]">
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
                                <span class="w-1.5 h-1.5 rounded-full bg-[#00a859] animate-scale-pulse"></span>
                                <span class="text-[8px] sm:text-[10px] font-bold text-white/90 tracking-wide truncate max-w-[180px] sm:max-w-none">Professional Services Marketplace</span>
                            </div>
                            <h1 class="text-xl sm:text-3xl lg:text-5xl font-black leading-[1.1] sm:leading-[1.04] tracking-[-0.03em] text-white text-balance">
                                Hire Top <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00a859] to-[#4ade80]">Professionals</span>
                            </h1>
                            <p class="text-[10px] sm:text-sm text-white/80 max-w-xl leading-snug sm:leading-relaxed mt-1 sm:mt-2 line-clamp-1 sm:line-clamp-none">
                                Browse professional services from verified sellers across Cameroon.
                            </p>
                            <div class="flex items-center gap-2 sm:gap-5 mt-2 sm:mt-4">
                                <span class="text-white text-[10px] sm:text-sm font-bold">
                                    <span class="text-sm sm:text-lg font-black">{{ number_format($services->total()) }}</span> Services
                                </span>
                                <span class="text-white/60 text-[8px] sm:text-[10px]">Book with confidence</span>
                            </div>

                            @if(request('q') || request('category') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'latest'))
                                <div class="flex flex-wrap items-center gap-1 mt-1">
                                    @if(request('category'))
                                        @php $catName = $categories->firstWhere('slug', request('category'))?->name ?? request('category'); @endphp
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ $catName }}
                                            <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
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
                                            <a href="{{ route('services.index', request()->except(['min_price', 'max_price', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    @if(request('sort') && request('sort') !== 'latest')
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                            {{ request('sort') === 'price_low' ? 'Low→High' : (request('sort') === 'price_high' ? 'High→Low' : 'Popular') }}
                                            <a href="{{ route('services.index', request()->except(['sort', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                        </span>
                                    @endif
                                    <a href="{{ route('services.index') }}" class="text-[7px] font-semibold text-white/60 hover:text-white underline underline-offset-2 transition-colors">Clear</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURED SERVICES --}}
    @if($featuredServices->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center shadow-sm shadow-amber-500/20">
                        <span class="material-symbols-outlined text-[13px] sm:text-[15px] text-white" style="font-variation-settings: 'FILL' 1;">recommend</span>
                    </span>
                    <div>
                        <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Featured Services</h2>
                        <p class="text-[9px] sm:text-[10px] text-on-surface-variant/50 font-medium">Top picks for you</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 bg-amber-50 text-amber-700 text-[9px] font-bold rounded-full border border-amber-200/50">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-scale-pulse"></span>
                    Featured
                </span>
            </div>
            <div x-data="autoScroll()" class="flex gap-3 overflow-x-auto no-scrollbar h-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
                @foreach($featuredServices as $service)
                    <div class="w-[220px] shrink-0 card-enter" style="animation-delay: {{ $loop->index * 0.06 }}s">
                        <div class="service-card bg-white rounded-xl border border-black/[0.04] shadow-sm p-2.5 flex gap-2.5 items-start">
                            <a href="{{ route('services.show', $service->slug) }}" class="shrink-0">
                                <div class="w-[56px] h-[56px] rounded-lg overflow-hidden bg-surface-container-low">
                                    @if($service->main_image_url)
                                        <img src="{{ $service->main_image_url }}" alt="{{ $service->name }}" loading="lazy" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-xl">image</span></div>
                                    @endif
                                </div>
                            </a>
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('services.show', $service->slug) }}" class="text-[10px] font-bold text-on-surface leading-snug line-clamp-1">{{ $service->name }}</a>
                                @if($service->store)
                                    <p class="text-[8px] text-on-surface-variant/50 truncate">{{ $service->store->name }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-xs font-black price-current">{{ number_format($service->starting_price) }} <span class="text-[6px] font-bold price-current-fcfa">FCFA</span></p>
                                    @if($service->delivery_time)
                                        <span class="text-[8px] text-on-surface-variant/50">{{ $service->delivery_time }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0"></div>
            </div>
            <div class="hidden lg:grid lg:grid-cols-2 gap-3">
                @foreach($featuredServices as $service)
                    <div class="service-card bg-white rounded-xl border border-black/[0.04] shadow-sm hover:shadow-[0_8px_30px_-8px_rgba(0,0,0,0.08)] transition-all p-3 flex gap-3 card-enter" style="animation-delay: {{ $loop->index * 0.06 }}s">
                        <a href="{{ route('services.show', $service->slug) }}" class="shrink-0">
                            <div class="w-[72px] h-[72px] rounded-lg overflow-hidden bg-surface-container-low">
                                @if($service->main_image_url)
                                    <img src="{{ $service->main_image_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-xl">image</span></div>
                                @endif
                            </div>
                        </a>
                        <div class="min-w-0 flex-1 flex flex-col justify-between py-0.5">
                            <div>
                                <div class="flex items-center gap-1.5 mb-0.5">
                                    @if($service->category)
                                        <span class="text-[10px] font-semibold text-primary/60 uppercase tracking-wide">{{ $service->category->name }}</span>
                                    @endif
                                    @if($service->rating > 0)
                                        <span class="flex items-center gap-0.5 text-[10px] font-semibold text-amber-600">
                                            <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                            {{ number_format($service->rating, 1) }}
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('services.show', $service->slug) }}" class="text-xs font-bold text-on-surface leading-snug line-clamp-1 hover:text-primary transition-colors">{{ $service->name }}</a>
                                @if($service->store)
                                    <p class="text-[10px] text-on-surface-variant/50 truncate mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[10px]">store</span>
                                        {{ $service->store->name }}
                                        @if($service->store->is_verified)
                                            <span class="material-symbols-outlined text-[9px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-1.5">
                                <p class="text-xs font-black price-current">From {{ number_format($service->starting_price) }} <span class="text-[7px] font-bold price-current-fcfa">FCFA</span></p>
                                @if($service->delivery_time)
                                    <span class="flex items-center gap-1 text-[9px] text-on-surface-variant/50">
                                        <span class="material-symbols-outlined text-[10px]">schedule</span>
                                        {{ $service->delivery_time }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CATEGORIES --}}
    @if($categories->count() > 0)
        @php
            $catColors = [
                '#0ea5e9', '#f59e0b', '#10b981', '#8b5cf6', '#e11d48', '#06b6d4',
                '#f97316', '#14b8a6', '#6366f1', '#ec4899', '#65a30d', '#d946ef',
            ];
            $catIcons = [
                'build', 'home_repair_service', 'brush', 'computer', 'cleaning_services',
                'health_and_beauty', 'local_shipping', 'school', 'camera_alt', 'restaurant',
                'pets', 'handyman', 'design_services', 'event', 'fitness_center',
                'music_note', 'car_repair', 'water_drop', 'lightbulb', 'paint',
            ];
        @endphp
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 sm:mt-8 lg:mt-10">
            <div class="flex items-center justify-between mb-4 sm:mb-5">
                <div class="flex items-center gap-2.5">
                    <span class="w-7 h-7 rounded-lg bg-gradient-to-br from-primary to-primary/70 flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[14px] text-white" style="font-variation-settings: 'FILL' 1;">category</span>
                    </span>
                    <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Browse by Category</h2>
                </div>
                <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
                   class="text-[10px] font-semibold text-primary hover:underline {{ !request('category') ? 'hidden' : '' }}">All Categories</a>
            </div>

            <div class="flex gap-3 overflow-x-auto no-scrollbar h-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:hidden">
                @foreach($categories as $i => $cat)
                    @php $color = $catColors[$i % count($catColors)]; @endphp
                    <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="category-card shrink-0 w-[130px] rounded-xl border border-black/[0.04] p-3 {{ request('category') === $cat->slug ? 'active bg-white' : 'bg-white hover:shadow-md' }}">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-2" style="background: {{ $color }}15;">
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="w-5 h-5 flex items-center justify-center">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-[18px]" style="color: {{ $color }};">{{ $catIcons[$i % count($catIcons)] }}</span>
                            @endif
                        </div>
                        <h3 class="text-[10px] font-bold text-on-surface leading-snug line-clamp-2">{{ $cat->name }}</h3>
                        <p class="text-[8px] text-on-surface-variant/50 mt-0.5">{{ $cat->services->count() }} services</p>
                    </a>
                @endforeach
                <div class="w-3 shrink-0"></div>
            </div>

            <div class="hidden lg:grid lg:grid-cols-4 gap-3">
                <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
                   class="category-card rounded-xl border border-black/[0.04] p-4 {{ !request('category') ? 'active bg-white' : 'bg-white hover:shadow-md' }}">
                    <div class="w-11 h-11 rounded-xl bg-surface-container-low flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[22px] text-on-surface-variant/60" style="font-variation-settings: 'FILL' 1;">grid_view</span>
                    </div>
                    <h3 class="text-xs font-bold text-on-surface">All Services</h3>
                    <p class="text-[10px] text-on-surface-variant/50 mt-0.5">{{ $services->total() }} services</p>
                </a>
                @foreach($categories as $i => $cat)
                    @php $color = $catColors[$i % count($catColors)]; @endphp
                    <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                       class="category-card rounded-xl border border-black/[0.04] p-4 {{ request('category') === $cat->slug ? 'active bg-white' : 'bg-white hover:shadow-md' }}">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-3" style="background: {{ $color }}15;">
                            @if($cat->icon && str_starts_with($cat->icon, '<'))
                                <span class="w-5 h-5 flex items-center justify-center">{!! $cat->icon !!}</span>
                            @else
                                <span class="material-symbols-outlined text-[22px]" style="color: {{ $color }}; font-variation-settings: 'FILL' 1;">{{ $catIcons[$i % count($catIcons)] }}</span>
                            @endif
                        </div>
                        <h3 class="text-xs font-bold text-on-surface">{{ $cat->name }}</h3>
                        <p class="text-[10px] text-on-surface-variant/50 mt-0.5">{{ $cat->services->count() }} services</p>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- FILTER BAR --}}
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
        <div class="hidden lg:flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <h2 class="text-[15px] font-extrabold text-on-surface tracking-tight">All Services</h2>
                <span class="text-xs text-on-surface-variant/50">—</span>
                <span class="text-xs font-medium text-on-surface-variant">{{ $services->total() }} {{ Str::plural('result', $services->total()) }}</span>
            </div>
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('services.index') }}">
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
                        <span class="material-symbols-outlined text-[15px] text-on-surface-variant/30 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                        <input type="text" name="q" placeholder="Search services..." value="{{ request('q') }}"
                               class="w-56 h-9 pl-9 pr-3 bg-surface-container-low border border-black/8 rounded-lg text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all placeholder:text-on-surface-variant/30">
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:hidden flex items-center gap-2.5">
            <button @click="openMobileFilters = true"
                    class="flex items-center gap-2 h-9 px-3.5 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[15px]">filter_list</span>
                Filters
                @php $activeFilterCount = collect([request('category'), request('min_price'), request('max_price')])->filter()->count(); @endphp
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <select onchange="window.location.href=this.value"
                    class="h-9 px-3 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[160px]">
                @foreach(['latest' => 'Latest', 'price_low' => 'Price: Low ↑', 'price_high' => 'Price: High ↓', 'popular' => 'Most Viewed'] as $val => $label)
                    <option value="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'latest') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </section>

    {{-- SERVICES GRID --}}
    <section id="services-section" class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
        @if($services->count() > 0)
            <div class="hidden lg:flex flex-col gap-3">
                @foreach($services as $service)
                    <div class="service-card card-enter bg-white rounded-xl border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_-8px_rgba(0,0,0,0.08)] transition-all p-3 flex gap-4 relative overflow-hidden">
                        <a href="{{ route('services.show', $service->slug) }}" class="shrink-0">
                            <div class="w-[88px] h-[88px] rounded-xl overflow-hidden bg-surface-container-low">
                                @if($service->main_image_url)
                                    <img class="w-full h-full object-cover"
                                         src="{{ $service->main_image_url }}"
                                         alt="{{ $service->name }}" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                        <span class="material-symbols-outlined text-2xl">image</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="min-w-0 flex-1 flex flex-col justify-between py-0.5">
                            <div>
                                <div class="flex items-center gap-2 mb-0.5">
                                    @if($service->category)
                                        <span class="text-[10px] font-semibold text-primary/60 uppercase tracking-wide">{{ $service->category->name }}</span>
                                    @endif
                                    @if($service->rating > 0)
                                        <span class="flex items-center gap-0.5 text-[10px] font-semibold text-amber-600">
                                            <span class="material-symbols-outlined text-[11px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                            {{ number_format($service->rating, 1) }}
                                            <span class="text-amber-400/50 font-medium">({{ $service->review_count }})</span>
                                        </span>
                                    @endif
                                </div>
                                <a href="{{ route('services.show', $service->slug) }}" class="text-sm font-bold text-on-surface leading-snug line-clamp-1 hover:text-primary transition-colors">{{ $service->name }}</a>
                                @if($service->store)
                                    <p class="text-[11px] text-on-surface-variant/50 mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[10px]">store</span>
                                        <span class="truncate">{{ $service->store->name }}</span>
                                        @if($service->store->is_verified)
                                            <span class="material-symbols-outlined text-[10px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        @endif
                                    </p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-black price-current tracking-tight">From {{ number_format($service->starting_price) }}
                                        <span class="text-[8px] font-bold price-current-fcfa">FCFA</span>
                                    </span>
                                    @if($service->delivery_time)
                                        <span class="flex items-center gap-1 text-[10px] text-on-surface-variant/50">
                                            <span class="material-symbols-outlined text-[11px]">schedule</span>
                                            {{ $service->delivery_time }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($service->packages->count() > 0)
                                        <span class="package-pill text-white text-[9px] font-bold px-2 py-0.5 rounded-md">{{ $service->packages->count() }} pkg</span>
                                    @endif
                                    <a href="{{ route('services.show', $service->slug) }}" class="px-3 py-1.5 bg-primary/5 hover:bg-primary/10 text-primary text-[10px] font-bold rounded-lg transition-all active:scale-[0.97]">Book Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:hidden">
                <div class="flex items-center justify-between mb-2.5">
                    <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">More Services</h2>
                    <span class="text-[10px] text-on-surface-variant font-medium">{{ $services->total() }} results</span>
                </div>
                <div class="flex flex-col gap-2.5">
                    @foreach($services as $service)
                        <div class="service-card card-enter bg-white rounded-xl border border-black/[0.04] shadow-sm p-2.5 flex gap-2.5 items-start">
                            <a href="{{ route('services.show', $service->slug) }}" class="shrink-0">
                                <div class="w-[64px] h-[64px] rounded-lg overflow-hidden bg-surface-container-low">
                                    @if($service->main_image_url)
                                        <img class="w-full h-full object-cover" src="{{ $service->main_image_url }}" alt="{{ $service->name }}" loading="lazy">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                            <span class="material-symbols-outlined text-xl">image</span>
                                        </div>
                                    @endif
                                </div>
                            </a>
                            <div class="min-w-0 flex-1">
                                @if($service->category)
                                    <p class="text-[9px] font-semibold text-primary/60 uppercase tracking-wide truncate">{{ $service->category->name }}</p>
                                @endif
                                <a href="{{ route('services.show', $service->slug) }}" class="text-[11px] font-bold text-on-surface leading-snug line-clamp-1">{{ $service->name }}</a>
                                @if($service->store)
                                    <p class="text-[9px] text-on-surface-variant/50 truncate flex items-center gap-0.5">{{ $service->store->name }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-xs font-black price-current">From {{ number_format($service->starting_price) }} <span class="text-[6px] font-bold price-current-fcfa">FCFA</span></span>
                                    <div class="flex items-center gap-1">
                                        @if($service->packages->count() > 0)
                                            <span class="package-pill text-white text-[7px] font-bold px-1.5 py-0.5 rounded-md">{{ $service->packages->count() }}pkg</span>
                                        @endif
                                        @if($service->rating > 0)
                                            <span class="flex items-center gap-0.5 text-[9px] font-semibold text-amber-600">
                                                <span class="material-symbols-outlined text-[9px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                                {{ number_format($service->rating, 1) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
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
                                        <span class="text-[8px] text-on-surface-variant/50">{{ $store->services_count ?? 0 }} services</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        <div class="w-3 shrink-0"></div>
                    </div>
                </div>
            @endif

            <div class="mt-6 sm:mt-8 lg:mt-10">
                {{ $services->links('partials.pagination') }}
            </div>
        @else
            <div class="text-center py-16 sm:py-24 bg-white rounded-2xl border border-black/[0.04] shadow-sm">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-surface-container-low flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant/30" style="font-variation-settings: 'FILL' 1;">handyman</span>
                </div>
                <h3 class="text-base sm:text-lg font-bold text-on-surface">No services found</h3>
                @if(request('q') || request('category') || request('min_price') || request('max_price'))
                    <p class="text-sm text-on-surface-variant mt-1 max-w-sm mx-auto leading-relaxed">We couldn't find any services matching your criteria. Try adjusting your filters.</p>
                    <div class="flex items-center justify-center gap-3 mt-6">
                        <a href="{{ route('services.index') }}"
                           class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                            <span class="material-symbols-outlined text-[14px]">close</span>
                            Clear All Filters
                        </a>
                    </div>
                @else
                    <p class="text-sm text-on-surface-variant mt-1">No services have been listed yet. Check back soon!</p>
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

            <button @click="document.querySelector('#services-section')?.scrollIntoView({ behavior: 'smooth' })"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">grid_view</span>
                Services
            </button>

            <select onchange="window.location.href=this.value"
                    class="h-9 px-2.5 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[130px]">
                @foreach(['latest' => 'Latest', 'price_low' => 'Low ↑', 'price_high' => 'High ↓', 'popular' => 'Popular'] as $val => $label)
                    <option value="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'latest') === $val ? 'selected' : '' }}>{{ $label }}</option>
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
                    @php $totalFilters = collect([request('category'), request('min_price'), request('max_price'), request('q')])->filter()->count(); @endphp
                    @if($totalFilters > 0)
                        <span class="px-2 py-0.5 rounded-full bg-primary/5 text-primary text-[9px] font-bold">{{ $totalFilters }} active</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($totalFilters > 0)
                        <a href="{{ route('services.index') }}" class="text-[10px] font-semibold text-primary hover:underline">Reset</a>
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
                            <a href="{{ route('services.index', request()->except(['category', 'page'])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ !request('category') ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                               @click="openMobileFilters = false">
                                <span class="material-symbols-outlined text-[18px]">grid_view</span>
                                All Services
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('services.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
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
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[16px] text-primary">payments</span>Price Range</span>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
                    </button>
                    <div class="filter-accordion-content mt-3" :class="open && 'open'">
                        <form method="GET" action="{{ route('services.index') }}" id="mobile-price-form">
                            @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="flex items-center gap-3">
                                <input type="number" name="min_price" placeholder="Min (FCFA)" value="{{ request('min_price') }}"
                                       class="w-full h-10 px-3 bg-surface border border-black/8 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                                <span class="text-xs text-on-surface-variant/40 font-medium">to</span>
                                <input type="number" name="max_price" placeholder="Max (FCFA)" value="{{ request('max_price') }}"
                                       class="w-full h-10 px-3 bg-surface border border-black/8 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/15 transition-all">
                            </div>
                            <button type="submit" class="mt-3 w-full h-10 bg-on-surface text-on-primary rounded-xl text-xs font-bold hover:bg-on-surface/90 transition-all active:scale-[0.98]"
                                    @click="openMobileFilters = false">Apply Price</button>
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
                                <a href="{{ route('services.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('sort', 'latest') === $val ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const filterParams = ['q', 'category', 'min_price', 'max_price', 'sort'];
        const hasFilters = filterParams.some(function(p) {
            var v = params.get(p);
            if (p === 'sort') return v && v !== 'latest';
            return v && v.length > 0;
        });
        if (hasFilters) {
            var el = document.getElementById('services-section');
            if (el) setTimeout(function() { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
        }
    });
</script>
@endpush
