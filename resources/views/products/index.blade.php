@extends('layouts.guest')
@section('title', $title . ' — Izifai')
@section('description', $description)

@push('styles')
<style>
    .product-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px -12px rgba(0,0,0,0.08), 0 4px 12px -4px rgba(0,0,0,0.03); }
    .product-card .img-secondary { opacity: 0; transition: opacity 0.45s cubic-bezier(0.16, 1, 0.3, 1); }
    .product-card:hover .img-primary { opacity: 0; }
    .product-card:hover .img-secondary { opacity: 1; }
    .category-chip { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .category-chip.active { background: #006d38; color: white; border-color: #006d38; box-shadow: 0 2px 8px rgba(0,109,56,0.25); }
    .filter-sheet { transform: translateY(100%); transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-sheet.open { transform: translateY(0); }
    .favorite-btn { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .favorite-btn:active { transform: scale(0.85); }
    .favorite-btn.bumping { animation: favBump 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes favBump { 0% { transform: scale(1); } 40% { transform: scale(1.3); } 100% { transform: scale(1); } }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    .shimmer-bg { background: linear-gradient(90deg, #f0f7f0 0%, #e8f0e6 40%, #f0f7f0 80%); background-size: 200% 100%; animation: shimmer 1.8s infinite; }
    .stock-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .stock-dot.in-stock { background: #22c55e; box-shadow: 0 0 0 2px rgba(34,197,94,0.2); }
    .stock-dot.out-of-stock { background: #ef4444; box-shadow: 0 0 0 2px rgba(239,68,68,0.2); }
    .stock-dot.on-request { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245,158,11,0.2); }
    .discount-pill::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.15) 50%, transparent 100%); }
    .filter-accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-accordion-content.open { max-height: 500px; }
    .filter-arrow { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .filter-arrow.open { transform: rotate(180deg); }
    .active-filter-chips { animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    .color-swatch { width: 14px; height: 14px; border-radius: 9999px; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.08); }
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
    .card-enter:nth-child(11) { animation-delay: 0.4s; }
    .card-enter:nth-child(12) { animation-delay: 0.44s; }
    .card-enter:nth-child(n+13) { animation-delay: 0.48s; }
    .hero-pattern { background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%); }
    .mobile-sticky-bar { box-shadow: 0 -4px 20px rgba(0,0,0,0.06); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .h-scroll-card { width: 62vw; max-width: 280px; }
    @media (min-width: 640px) { .h-scroll-card { width: 45vw; } }
    .hero-bg { background-image: url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1400&q=80'); background-size: cover; background-position: center; }

    .store-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px -8px rgba(0,0,0,0.08); }
    .section-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .section-scroll > * { scroll-snap-align: start; }
    .trending-badge { background: linear-gradient(135deg, #f59e0b, #ef4444); }
    .store-avatar { border: 2px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
    .price-current { color: #ea580c; }
    .price-current-fcfa { color: #ea580c; opacity: 0.7; }
    .price-old { color: #dc2626; }
    .price-old-line { color: #dc2626; text-decoration: line-through; opacity: 0.6; }
    .trending-grid-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .trending-grid-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px -12px rgba(0,0,0,0.1); }
</style>
@endpush

{{-- ==================== STORE SIDEBAR (DESKTOP) ==================== --}}
@section('store-sidebar')
    {{-- Sidebar: Top Stores --}}
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
                                <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="store-avatar w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center shrink-0 text-primary font-extrabold text-sm">
                                {{ strtoupper(substr($store->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-1">
                                <h3 class="text-[11px] font-bold text-on-surface truncate">{{ $store->name }}</h3>
                                @if($store->is_verified)
                                    <span class="material-symbols-outlined text-[9px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="text-[8px] text-on-surface-variant/50">{{ $store->products_count ?? 0 }} products</span>
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
                <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ !request('category') ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                    <span class="material-symbols-outlined text-[15px] {{ !request('category') ? 'text-primary' : '' }}">grid_view</span>
                    All Products
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
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

    {{-- Sidebar: Price Range --}}
    <div class="p-4 border-b border-gray-100" x-data="{ open: true }">
        <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
            <span class="flex items-center gap-2">
                <span class="material-symbols-outlined text-[15px] text-primary">payments</span>
                Price Range
            </span>
            <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
        </button>
        <div class="filter-accordion-content mt-3" :class="open && 'open'">
            <form method="GET" action="{{ route('products.index') }}" id="sidebar-price-form">
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
                @foreach(['random' => 'Random', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low'] as $val => $label)
                    <a href="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs {{ request('sort', 'random') === $val ? 'bg-primary/[0.06] text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02] hover:text-on-surface' }} transition-all">
                        <span class="material-symbols-outlined text-[15px] {{ request('sort', 'random') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'random' ? 'shuffle' : ($val === 'price_low' ? 'north' : 'south') }}</span>
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar: Highest Selling --}}
    @if(isset($mostContactedProducts) && $mostContactedProducts->count() > 0)
        <div class="p-4" x-data="{ open: true }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-[10px] font-bold text-on-surface uppercase tracking-wider">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[15px] text-[#25D366]">chat</span>
                    Highest Selling
                </span>
                <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40 filter-arrow" :class="open && 'open'">expand_more</span>
            </button>
            <div class="filter-accordion-content mt-3" :class="open && 'open'">
                <div class="space-y-2">
                    @foreach($mostContactedProducts->take(5) as $product)
                        <a href="{{ route('products.show', $product->slug) }}"
                           class="flex items-center gap-2.5 p-2 rounded-xl hover:bg-black/[0.02] transition-all group">
                            <div class="w-10 h-10 rounded-lg overflow-hidden shrink-0 bg-surface-container-low">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-sm">image</span></div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-[11px] font-bold text-on-surface truncate group-hover:text-primary transition-colors">{{ $product->name }}</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] font-black price-current">{{ number_format($product->price) }}</span>
                                    @if($product->weekly_contacts > 0)
                                        <span class="text-[8px] text-[#25D366] font-semibold flex items-center gap-0.5">
                                            <span class="w-1 h-1 rounded-full bg-[#25D366]"></span>
                                            {{ $product->weekly_contacts }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-[14px] text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform">chevron_right</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection

@section('content')
<div x-data="productsPage()" class="min-h-screen bg-surface pb-20 lg:pb-0">

    {{-- ===== 1. HERO ===== --}}
    <section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
        <div class="relative min-h-[180px] sm:min-h-[260px] lg:min-h-[320px] overflow-hidden rounded-2xl shadow-sm">
        <div class="absolute inset-0 hero-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="absolute top-[-120px] right-[-80px] w-[400px] h-[400px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-[-100px] left-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-0 left-0 right-0 px-5 sm:px-6 lg:px-8 py-3 sm:py-6 lg:py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-end justify-between gap-4">
                    <div class="min-w-0 max-w-2xl">
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white shrink-0 ring-2 ring-white/30">
                                <span class="material-symbols-outlined text-lg sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">storefront</span>
                            </div>
                            <div>
                                <h1 class="text-2xl sm:text-3xl lg:text-4xl lg:leading-[44px] font-bold text-white tracking-tight">
                                    Buy and Sell in <span class="text-[#00a859]">Cameroon</span>
                                </h1>
                                <p class="text-xs sm:text-sm text-white/80 max-w-xl line-clamp-2">Izifai connects you with trusted sellers across Cameroon. Browse, message, and buy — all from one link.</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-1.5 mt-1 sm:mt-2">
                            @if($trendingProducts->count() > 0)
                                <div class="flex -space-x-1.5">
                                    @php $heroProducts = $trendingProducts->take(4); @endphp
                                    @foreach($heroProducts as $product)
                                        <a href="{{ route('products.show', $product->slug) }}" class="w-5 h-5 sm:w-6 sm:h-6 rounded-full border-[1.5px] border-white/70 overflow-hidden bg-white shadow-sm hover:z-10 relative transition-transform hover:scale-110">
                                            @if($product->images->first())
                                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-white/30"><span class="material-symbols-outlined text-[8px] text-white/60">photo</span></div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            <span class="text-white/80 text-[10px] sm:text-xs font-bold">
                                <span class="text-sm sm:text-base font-black">{{ number_format($products->total()) }}</span> products
                            </span>
                            <span class="text-white/30 hidden sm:inline">•</span>
                            <span class="text-white/60 text-[9px] sm:text-[11px] font-medium hidden sm:inline">Shop on Izifai</span>
                        </div>

                        @if(request('q') || request('category') || request('min_price') || request('max_price') || (request('sort') && request('sort') !== 'random'))
                            <div class="flex flex-wrap items-center gap-1 mt-1">
                                @if(request('category'))
                                    @php $catName = $categories->firstWhere('slug', request('category'))?->name ?? request('category'); @endphp
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                        {{ $catName }}
                                        <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
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
                                        <a href="{{ route('products.index', request()->except(['min_price', 'max_price', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                    </span>
                                @endif
                                @if(request('sort') && request('sort') !== 'random')
                                    <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-white/12 text-white rounded-full text-[7px] font-semibold backdrop-blur-sm border border-white/10">
                                        {{ request('sort') === 'price_low' ? 'Low→High' : 'High→Low' }}
                                        <a href="{{ route('products.index', request()->except(['sort', 'page'])) }}"><span class="material-symbols-outlined text-[8px] cursor-pointer hover:text-white/70">close</span></a>
                                    </span>
                                @endif
                                <a href="{{ route('products.index') }}" class="text-[7px] font-semibold text-white/60 hover:text-white underline underline-offset-2 transition-colors">Clear</a>
                            </div>
                        @endif
                    </div>

                    @if($trendingProducts->count() > 0)
                        <div class="hidden sm:flex flex-col items-end shrink-0 gap-1.5">
                            <div class="flex items-center -space-x-2.5">
                                @php $heroDesktopProducts = $trendingProducts->take(5); @endphp
                                @foreach($heroDesktopProducts as $product)
                                    <a href="{{ route('products.show', $product->slug) }}" class="w-9 h-9 lg:w-10 lg:h-10 rounded-full border-2 border-white/80 overflow-hidden bg-white shadow-sm hover:z-10 relative transition-transform hover:scale-110 hover:-translate-y-1">
                                        @if($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-white/30"><span class="material-symbols-outlined text-white/60 text-sm">photo</span></div>
                                        @endif
                                    </a>
                                @endforeach
                                <div class="w-9 h-9 lg:w-10 lg:h-10 rounded-full border-2 border-white/80 bg-black/25 backdrop-blur-sm flex items-center justify-center text-white text-[7px] font-extrabold relative z-[5] shadow-sm">
                                    +
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 bg-white/10 backdrop-blur-sm px-2 py-0.5 rounded-full border border-white/10">
                                <span class="material-symbols-outlined text-[8px] text-amber-300" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                                <span class="text-[7px] font-semibold text-white/70">Trending now</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
        </section>

    {{-- ===== 2. TRENDING ===== --}}
    @if($trendingProducts->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="trending-badge w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-white" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                    </span>
                    <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Trending on Izifai</h2>
                </div>
                <span class="text-[9px] sm:text-[10px] font-semibold text-on-surface-variant/50">Most views</span>
            </div>

            {{-- Mobile: horizontal scroll --}}
            <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
                @foreach($trendingProducts as $product)
                    <div class="w-[140px] sm:w-[160px] shrink-0">
                        <a href="{{ route('products.show', $product->slug) }}" class="block product-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                            <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                                @if($product->images->first())
                                    <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-3xl">image</span></div>
                                @endif
                                <span class="trending-badge absolute top-1.5 left-1.5 text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                    <span class="material-symbols-outlined text-[8px]" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                                    {{ $product->weekly_views ?? $product->views }} this week
                                </span>
                                <button class="favorite-btn absolute top-1.5 right-1.5 w-6 h-6 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                        data-product="{{ $product->id }}"
                                        data-favorited="{{ in_array($product->id, $savedProductIds ?? []) ? 'true' : 'false' }}">
                                    <span class="material-symbols-outlined text-[11px] {{ in_array($product->id, $savedProductIds ?? []) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                          style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds ?? []) ? 1 : 0 }};">favorite</span>
                                </button>
                            </div>
                            <div class="p-2">
                                <h3 class="text-[10px] sm:text-[11px] font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                                <div class="flex items-baseline gap-1 mt-1">
                                    <p class="text-xs font-black price-current">{{ number_format($product->price) }} <span class="text-[6px] font-bold price-current-fcfa">FCFA</span></p>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <p class="text-[8px] price-old-line">{{ number_format($product->old_price) }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="w-3 sm:w-6 shrink-0"></div>
            </div>

            {{-- Desktop: 2-column grid --}}
            <div class="hidden lg:grid lg:grid-cols-2 lg:gap-3">
                @foreach($trendingProducts as $product)
                    <div class="trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex gap-3 p-2">
                        <a href="{{ route('products.show', $product->slug) }}" class="w-20 h-20 rounded-lg overflow-hidden shrink-0 bg-surface-container-low block">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-xl">image</span></div>
                            @endif
                        </a>
                        <div class="min-w-0 flex-1 flex flex-col justify-between py-0.5">
                            <div>
                                <a href="{{ route('products.show', $product->slug) }}" class="text-[11px] sm:text-xs font-bold text-on-surface leading-snug line-clamp-2 hover:text-primary transition-colors">{{ $product->name }}</a>
                                @if($product->store)
                                    <p class="text-[9px] text-on-surface-variant/50 truncate mt-0.5">{{ $product->store->name }}</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs sm:text-sm font-black price-current">{{ number_format($product->price) }} <span class="text-[7px] font-bold price-current-fcfa">FCFA</span></p>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <p class="text-[8px] price-old-line">{{ number_format($product->old_price) }}</p>
                                    @endif
                                </div>
                                <span class="trending-badge text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm shrink-0">
                                    <span class="material-symbols-outlined text-[7px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                                    {{ $product->weekly_views ?? $product->views }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== 3. CATEGORIES ===== --}}
    @if($categories->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                <h2 class="text-[11px] sm:text-xs font-bold text-on-surface uppercase tracking-wider">Categories</h2>
                <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                   class="text-[10px] font-semibold text-primary hover:underline {{ !request('category') ? 'hidden' : '' }}">All</a>
            </div>
            <div class="flex gap-2 overflow-x-auto no-scrollbar h-scroll pb-1 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:flex-wrap lg:gap-2">
                <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                   class="category-chip shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border text-[11px] font-semibold transition-all {{ !request('category') ? 'active' : 'border-black/8 text-on-surface-variant bg-white hover:border-primary/30 hover:text-primary' }}">
                    <span class="material-symbols-outlined text-[14px]">grid_view</span>
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
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
                @php $activeFilterCount = collect([request('category'), request('min_price'), request('max_price')])->filter()->count(); @endphp
                @if($activeFilterCount > 0)
                    <span class="w-4 h-4 rounded-full bg-primary text-on-primary text-[7px] font-bold flex items-center justify-center">{{ $activeFilterCount }}</span>
                @endif
            </button>

            <select onchange="window.location.href=this.value"
                    class="lg:hidden h-9 px-3 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[160px]">
                @foreach(['random' => 'Random', 'price_low' => 'Price: Low ↑', 'price_high' => 'Price: High ↓'] as $val => $label)
                    <option value="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'random') === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <div class="hidden lg:flex items-center gap-3 ml-auto">
                <span class="text-xs text-on-surface-variant">
                    <span class="font-bold text-on-surface">{{ $products->firstItem() ?? 0 }}</span>–<span class="font-bold text-on-surface">{{ $products->lastItem() ?? 0 }}</span>
                    <span class="text-on-surface-variant/40">of</span>
                    <span class="font-bold text-on-surface">{{ number_format($products->total()) }}</span>
                </span>
            </div>
        </div>
    </section>

    {{-- ===== 5. PRODUCTS ===== --}}
    <section id="products-section" class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6">
                @if($products->count() > 0)

                    {{-- Products Grid (desktop) --}}
                    <div class="hidden lg:flex items-center justify-between mb-3">
                        <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">All Products</h2>
                        <span class="text-xs text-on-surface-variant">{{ $products->total() }} results</span>
                    </div>
                    <div class="hidden lg:grid grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($products as $product)
                            <div class="product-card card-enter bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] group relative">
                                <a href="{{ route('products.show', $product->slug) }}" class="block">
                                    <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                                        @if($product->images->first())
                                            <img class="img-primary w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                                                 src="{{ asset('storage/' . $product->images->first()->path) }}"
                                                 alt="{{ $product->name }}" loading="lazy"
                                                 onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full flex items-center justify-center text-on-surface-variant/20\'><span class=\'material-symbols-outlined text-4xl\'>image</span></div>'">
                                            @if($product->images->count() > 1)
                                                <img class="img-secondary absolute inset-0 w-full h-full object-cover"
                                                     src="{{ asset('storage/' . $product->images->skip(1)->first()->path) }}"
                                                     alt="{{ $product->name }}" loading="lazy"
                                                     onerror="this.style.display='none'">
                                            @endif
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                                <span class="material-symbols-outlined text-4xl">image</span>
                                            </div>
                                        @endif

                                        @if($product->old_price && $product->old_price > $product->price)
                                            @php $discountPct = round((1 - $product->price / $product->old_price) * 100); @endphp
                                            @if($discountPct > 0)
                                                <span class="discount-pill absolute top-2.5 left-2.5 bg-error text-on-error text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm">
                                                    <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                                                    -{{ $discountPct }}%
                                                </span>
                                            @endif
                                        @endif

                                        @if($product->is_featured)
                                            <span class="absolute top-2.5 left-2.5 bg-primary/90 backdrop-blur-sm text-on-primary text-[8px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                                                Featured
                                            </span>
                                        @endif

                                        @if($product->stock_status && $product->stock_status !== 'in_stock')
                                            <span class="absolute bottom-2.5 left-2.5 bg-white/90 backdrop-blur-sm text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm border border-black/5">
                                                <span class="stock-dot {{ $product->stock_status }}"></span>
                                                {{ $product->stock_status === 'out_of_stock' ? 'Out of Stock' : 'On Request' }}
                                            </span>
                                        @endif

                                        <button class="favorite-btn absolute top-2.5 right-2.5 w-8 h-8 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                                data-product="{{ $product->id }}"
                                                data-favorited="{{ in_array($product->id, $savedProductIds ?? []) ? 'true' : 'false' }}">
                                            <span class="material-symbols-outlined text-[15px] {{ in_array($product->id, $savedProductIds ?? []) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                                  style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds ?? []) ? 1 : 0 }};">favorite</span>
                                        </button>

                                        <div class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/50 via-black/10 to-transparent flex items-end justify-center pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <span class="bg-white/90 backdrop-blur-sm text-on-surface text-[10px] font-bold px-5 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-[13px]">visibility</span>
                                                Quick View
                                            </span>
                                        </div>
                                    </div>

                                    <div class="p-3">
                                        <div class="flex items-center justify-between gap-2 mb-0.5">
                                            @if($product->category)
                                                <p class="text-[9px] sm:text-[10px] font-semibold text-primary/70 uppercase tracking-wide truncate">{{ $product->category->name }}</p>
                                            @endif
                                            @if($product->stock_status === 'in_stock')
                                                <span class="flex items-center gap-1 text-[8px] font-semibold text-emerald-600/70">
                                                    <span class="stock-dot in-stock"></span>
                                                    In Stock
                                                </span>
                                            @endif
                                        </div>
                                        <h3 class="text-[12px] sm:text-sm font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                                        @if($product->store)
                                            <p class="text-[10px] sm:text-[11px] text-on-surface-variant/60 truncate mt-0.5 flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[11px]">store</span>
                                                {{ $product->store->name }}
                                            </p>
                                        @endif
                                        @if(!empty($product->colors) && is_array($product->colors))
                                            <div class="flex items-center gap-1 mt-1.5">
                                                @foreach(array_slice($product->colors, 0, 4) as $color)
                                                    <span class="color-swatch" style="background: {{ $color }};"></span>
                                                @endforeach
                                                @if(count($product->colors) > 4)
                                                    <span class="text-[8px] text-on-surface-variant/50 font-semibold ml-0.5">+{{ count($product->colors) - 4 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        @if(!empty($product->sizes) && is_array($product->sizes))
                                            <div class="flex items-center gap-1 mt-1.5 flex-wrap">
                                                @foreach(array_slice($product->sizes, 0, 3) as $size)
                                                    <span class="text-[8px] font-semibold text-on-surface-variant/50 bg-black/[0.03] px-1.5 py-0.5 rounded">{{ $size }}</span>
                                                @endforeach
                                                @if(count($product->sizes) > 3)
                                                    <span class="text-[8px] text-on-surface-variant/50 font-semibold">+{{ count($product->sizes) - 3 }}</span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="flex items-baseline gap-2 mt-1.5">
                                            <p class="text-sm sm:text-base font-black price-current tracking-tight">{{ number_format($product->price) }}
                                                <span class="text-[8px] font-bold price-current-fcfa">FCFA</span>
                                            </p>
                                            @if($product->old_price && $product->old_price > $product->price)
                                                <p class="text-[10px] sm:text-[11px] price-old-line">{{ number_format($product->old_price) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{-- MOBILE: More Products Grid --}}
                    <div class="lg:hidden">
                        <div class="flex items-center justify-between mb-2.5">
                            <h2 class="text-[11px] font-bold text-on-surface uppercase tracking-wider">More Products</h2>
                            <span class="text-[10px] text-on-surface-variant font-medium">{{ $products->total() }} results</span>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($products as $product)
                                <div class="product-card card-enter bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group relative">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                                        <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                                            @if($product->images->first())
                                                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                                     src="{{ asset('storage/' . $product->images->first()->path) }}"
                                                     alt="{{ $product->name }}" loading="lazy">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                                    <span class="material-symbols-outlined text-4xl">image</span>
                                                </div>
                                            @endif
                                            @if($product->old_price && $product->old_price > $product->price)
                                                @php $d = round((1 - $product->price / $product->old_price) * 100); @endphp
                                                @if($d > 0)
                                                    <span class="absolute top-1.5 left-1.5 bg-error text-on-error text-[7px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">-{{ $d }}%</span>
                                                @endif
                                            @endif
                                            @if($product->is_featured)
                                                <span class="absolute top-1.5 left-1.5 bg-primary/90 backdrop-blur-sm text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm">
                                                    <span class="material-symbols-outlined text-[8px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                                                    Featured
                                                </span>
                                            @endif
                                            <button class="favorite-btn absolute top-1.5 right-1.5 w-6 h-6 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                                    data-product="{{ $product->id }}"
                                                    data-favorited="{{ in_array($product->id, $savedProductIds ?? []) ? 'true' : 'false' }}">
                                                <span class="material-symbols-outlined text-[11px] {{ in_array($product->id, $savedProductIds ?? []) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                                      style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds ?? []) ? 1 : 0 }};">favorite</span>
                                            </button>
                                        </div>
                                        <div class="p-2">
                                            <h3 class="text-[11px] font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                                            @if($product->store)
                                                <p class="text-[8px] text-on-surface-variant/50 truncate">{{ $product->store->name }}</p>
                                            @endif
                                            <div class="flex items-baseline gap-1 mt-1">
                                                <p class="text-xs font-black price-current">{{ number_format($product->price) }} <span class="text-[6px] font-bold price-current-fcfa">FCFA</span></p>
                                                @if($product->old_price && $product->old_price > $product->price)
                                                    <p class="text-[8px] price-old-line">{{ number_format($product->old_price) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- MOBILE: Top Stores (at bottom) --}}
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
                                                    <img src="{{ asset('storage/' . $store->banner) }}" alt="" class="w-full h-full object-cover">
                                                </div>
                                            @else
                                                <div class="h-12 bg-gradient-to-r from-primary/5 to-primary-container/20 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-xl text-primary/20">store</span>
                                                </div>
                                            @endif
                                            <div class="px-2.5 pb-2.5 relative">
                                                <div class="flex items-end -mt-5 mb-1.5">
                                                    @if($store->logo)
                                                        <div class="store-avatar w-8 h-8 rounded-lg overflow-hidden shrink-0 bg-white">
                                                            <img src="{{ asset('storage/' . $store->logo) }}" alt="" class="w-full h-full object-cover">
                                                        </div>
                                                    @else
                                                        <div class="store-avatar w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center shrink-0 text-primary font-extrabold text-[10px]">
                                                            {{ strtoupper(substr($store->name, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                    @if($store->is_verified)
                                                        <span class="ml-1 mb-0.5 w-3 h-3 rounded-full bg-primary/10 flex items-center justify-center">
                                                            <span class="material-symbols-outlined text-[7px] text-primary" style="font-variation-settings: 'FILL' 1;">verified</span>
                                                        </span>
                                                    @endif
                                                </div>
                                                <h3 class="text-[10px] font-bold text-on-surface truncate">{{ $store->name }}</h3>
                                                <span class="text-[8px] text-on-surface-variant/50">{{ $store->products_count ?? 0 }} products</span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                                <div class="w-3 shrink-0"></div>
                            </div>
                        </div>
                    @endif

                    {{-- Pagination --}}
                    <div class="mt-6 sm:mt-8 lg:mt-10">
                        {{ $products->links('partials.pagination') }}
                    </div>

                @else
                    <div class="text-center py-16 sm:py-24 bg-white rounded-2xl border border-black/[0.04] shadow-sm">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-surface-container-low flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-4xl sm:text-5xl text-on-surface-variant/30" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-on-surface">No products found</h3>
                        @if(request('q') || request('category') || request('min_price') || request('max_price'))
                            <p class="text-sm text-on-surface-variant mt-1 max-w-sm mx-auto leading-relaxed">We couldn't find any products matching your criteria. Try adjusting your filters.</p>
                            <div class="flex items-center justify-center gap-3 mt-6">
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[14px]">close</span>
                                    Clear All Filters
                                </a>
                                <a href="{{ route('stores.index') }}"
                                   class="inline-flex items-center gap-1.5 px-6 py-2.5 bg-white text-on-surface rounded-full text-[12px] font-bold border border-black/10 hover:border-black/20 active:scale-[0.97] transition-all">
                                    <span class="material-symbols-outlined text-[14px]">store</span>
                                    Browse Stores
                                </a>
                            </div>
                        @else
                            <p class="text-sm text-on-surface-variant mt-1">No products have been listed yet. Check back soon!</p>
                            <a href="{{ route('stores.index') }}"
                               class="inline-flex items-center gap-1.5 mt-6 px-6 py-2.5 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all shadow-sm">
                                <span class="material-symbols-outlined text-[14px]">store</span>
                                Browse Stores
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===== MOBILE: HIGHEST SELLING ===== --}}
    @if(isset($mostContactedProducts) && $mostContactedProducts->count() > 0)
        <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:hidden">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-[#25D366]/10 flex items-center justify-center shadow-sm">
                        <svg class="w-3.5 h-3.5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    <h2 class="text-xs font-extrabold text-on-surface">Highest Selling</h2>
                </div>
                <span class="text-[9px] font-semibold text-on-surface-variant/50">Most contacted via WhatsApp</span>
            </div>
            <div class="grid grid-cols-2 gap-2.5">
                @foreach($mostContactedProducts as $product)
                    <div class="trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex gap-2 p-2">
                        <a href="{{ route('products.show', $product->slug) }}" class="w-[52px] h-[52px] rounded-lg overflow-hidden shrink-0 bg-surface-container-low block">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-lg">image</span></div>
                            @endif
                        </a>
                        <div class="min-w-0 flex-1 flex flex-col justify-between">
                            <a href="{{ route('products.show', $product->slug) }}" class="text-[9px] font-bold text-on-surface leading-snug line-clamp-2 hover:text-primary transition-colors">{{ $product->name }}</a>
                            <div class="flex items-center justify-between mt-0.5">
                                <p class="text-[10px] font-black price-current">{{ number_format($product->price) }}</p>
                                <span class="bg-[#25D366]/10 text-[#25D366] text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5">
                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    {{ $product->weekly_contacts ?? $product->contacts_count }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== MOBILE BOTTOM STICKY BAR ===== --}}
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

            <button @click="document.querySelector('#products-section')?.scrollIntoView({ behavior: 'smooth' })"
                    class="flex items-center justify-center gap-2 h-9 flex-1 bg-white border border-black/8 rounded-xl text-[11px] font-bold text-on-surface hover:border-black/15 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">grid_view</span>
                Products
            </button>

            <select onchange="window.location.href=this.value"
                    class="h-9 px-2.5 bg-white border border-black/8 rounded-xl text-[11px] font-medium text-on-surface focus:outline-none focus:border-primary transition-all shadow-sm flex-1 max-w-[130px]">
                @foreach(['random' => 'Random', 'price_low' => 'Low ↑', 'price_high' => 'High ↓'] as $val => $label)
                    <option value="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}" {{ request('sort', 'random') === $val ? 'selected' : '' }}>{{ $label }}</option>
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
                    @php $totalFilters = collect([request('category'), request('min_price'), request('max_price'), request('q')])->filter()->count(); @endphp
                    @if($totalFilters > 0)
                        <span class="px-2 py-0.5 rounded-full bg-primary/5 text-primary text-[9px] font-bold">{{ $totalFilters }} active</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    @if($totalFilters > 0)
                        <a href="{{ route('products.index') }}" class="text-[10px] font-semibold text-primary hover:underline">Reset</a>
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
                            <a href="{{ route('products.index', request()->except(['category', 'page'])) }}"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ !request('category') ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                               @click="openMobileFilters = false">
                                <span class="material-symbols-outlined text-[18px]">grid_view</span>
                                All Products
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
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
                        <form method="GET" action="{{ route('products.index') }}" id="mobile-price-form">
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
                            @foreach(['random' => 'Random', 'price_low' => 'Price: Low to High', 'price_high' => 'Price: High to Low'] as $val => $label)
                                <a href="{{ route('products.index', array_merge(request()->except(['sort', 'page']), ['sort' => $val])) }}"
                                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm {{ request('sort', 'random') === $val ? 'bg-primary/5 text-primary font-bold' : 'text-on-surface-variant hover:bg-black/[0.02]' }} transition-all"
                                   @click="openMobileFilters = false">
                                    <span class="material-symbols-outlined text-[18px] {{ request('sort', 'random') === $val ? 'text-primary' : 'text-on-surface-variant/30' }}">{{ $val === 'random' ? 'shuffle' : ($val === 'price_low' ? 'north' : 'south') }}</span>
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
    function productsPage() {
        return {
            openMobileFilters: false,
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const params = new URLSearchParams(window.location.search);
        const filterParams = ['q', 'category', 'min_price', 'max_price', 'sort'];
        const hasFilters = filterParams.some(function(p) {
            var v = params.get(p);
            if (p === 'sort') return v && v !== 'random';
            return v && v.length > 0;
        });
        if (hasFilters) {
            var el = document.getElementById('products-section');
            if (el) setTimeout(function() { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); }, 100);
        }
    });

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.favorite-btn');
        if (!btn) return;
        e.preventDefault();
        btn.classList.add('bumping');
        setTimeout(() => btn.classList.remove('bumping'), 400);
        const productId = btn.dataset.product;
        @auth
            fetch('{{ url('/products') }}/' + productId + '/favorite', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
            }).then(r => r.json()).then(data => {
                const icon = btn.querySelector('.material-symbols-outlined');
                if (data.favorited) {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    icon.classList.add('text-error');
                    icon.classList.remove('text-on-surface-variant/60');
                    btn.dataset.favorited = 'true';
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    icon.classList.remove('text-error');
                    icon.classList.add('text-on-surface-variant/60');
                    btn.dataset.favorited = 'false';
                }
            });
        @endauth
        @guest
            window.location.href = '{{ route('login') }}';
        @endguest
    });
</script>
@endpush
