@extends('layouts.guest')

@section('title', 'Izifai — Buy and Sell in Cameroon')
@section('description', 'Izifai connects you with trusted sellers across Cameroon. Browse, message, and buy — all from one link.')

@push('styles')
<style>
    @keyframes cardIn { from { opacity: 0; transform: translateY(20px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.8; } }
    @keyframes scalePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
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
    .product-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .product-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px -12px rgba(0,0,0,0.08), 0 4px 12px -4px rgba(0,0,0,0.03); }
    .product-card .img-secondary { opacity: 0; transition: opacity 0.45s cubic-bezier(0.16, 1, 0.3, 1); }
    .product-card:hover .img-primary { opacity: 0; }
    .product-card:hover .img-secondary { opacity: 1; }
    .store-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover { transform: translateY(-6px); box-shadow: 0 20px 60px -12px rgba(0,0,0,0.08), 0 4px 12px -4px rgba(0,0,0,0.03); }
    .store-card .store-banner { transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .store-banner { transform: scale(1.05); }
    .store-card .store-logo { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .store-logo { transform: scale(1.1) rotate(-3deg); }
    .category-chip { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .favorite-btn { transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1); }
    .favorite-btn:active { transform: scale(0.85); }
    .stock-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .stock-dot.in-stock { background: #22c55e; box-shadow: 0 0 0 2px rgba(34,197,94,0.2); }
    .stock-dot.out-of-stock { background: #ef4444; box-shadow: 0 0 0 2px rgba(239,68,68,0.2); }
    .stock-dot.on-request { background: #f59e0b; box-shadow: 0 0 0 2px rgba(245,158,11,0.2); }
    .discount-pill::before { content: ''; position: absolute; inset: 0; background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.15) 50%, transparent 100%); }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .h-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .h-scroll > * { scroll-snap-align: start; }
    .section-scroll { scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch; scroll-padding-left: 12px; scroll-padding-right: 12px; }
    .section-scroll > * { scroll-snap-align: start; }
    .trending-badge { background: linear-gradient(135deg, #f59e0b, #ef4444); }
    .price-current { color: #ea580c; }
    .price-current-fcfa { color: #ea580c; opacity: 0.7; }
    .price-old-line { color: #dc2626; text-decoration: line-through; opacity: 0.6; }
    .color-swatch { width: 14px; height: 14px; border-radius: 9999px; border: 2px solid white; box-shadow: 0 0 0 1px rgba(0,0,0,0.08); }
    .animate-dot-pulse { animation: dotPulse 1.5s ease-in-out infinite; }
    .animate-dot-pulse-delayed { animation: dotPulse 1.5s ease-in-out 0.5s infinite; }
    .animate-dot-pulse-slower { animation: dotPulse 1.5s ease-in-out 1s infinite; }
    .animate-scale-pulse { animation: scalePulse 2s ease-in-out infinite; }
    .hero-pattern { background-image: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.05) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(255,255,255,0.08) 0%, transparent 50%); }
    .step-card { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .step-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.06); }
    .trending-grid-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .trending-grid-card:hover { transform: translateY(-4px); box-shadow: 0 16px 48px -12px rgba(0,0,0,0.1); }
</style>
@endpush

@section('content')

{{-- ===== 1. HERO ===== --}}
<section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
    <div class="relative min-h-[300px] sm:min-h-[340px] lg:min-h-[400px] rounded-2xl shadow-sm">
        @php $heroImage = \App\Models\Setting::get('hero_image'); @endphp
        <div class="absolute inset-0 bg-cover bg-center rounded-2xl" style="background-image: url('{{ $heroImage ? r2_url($heroImage) : 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1400&q=80' }}');"></div>
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
        <div class="absolute bottom-0 left-0 right-0 px-4 sm:px-6 lg:px-10 py-4 sm:py-6 lg:py-8">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 mb-2 sm:mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#00a859] animate-scale-pulse"></span>
                            <span class="text-[8px] sm:text-[10px] font-bold text-white/90 tracking-wide">Cameroon's Trusted Marketplace</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-5xl font-black leading-[1.04] tracking-[-0.03em] text-white text-balance">
                            Buy and Sell in<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00a859] to-[#4ade80]">Cameroon</span>
                        </h1>
                        <p class="text-xs sm:text-sm text-white/80 max-w-xl leading-relaxed mt-1 sm:mt-2">
                            Izifai connects you with trusted sellers across Cameroon. Browse products, message directly, and buy — all from one link.
                        </p>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-3 sm:mt-4">
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center gap-1.5 px-5 sm:px-6 py-2.5 sm:py-3 bg-white text-[#00210d] rounded-full text-[11px] sm:text-[13px] font-bold hover:bg-white/90 active:scale-[0.97] transition-all duration-200 shadow-sm group">
                                Start Selling Free
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:translate-x-0.5 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('products.index') }}"
                               class="inline-flex items-center justify-center gap-2 px-5 sm:px-6 py-2.5 sm:py-3 bg-white/10 backdrop-blur-sm text-white rounded-full text-[11px] sm:text-[13px] font-bold border border-white/20 hover:bg-white/20 active:scale-[0.97] transition-all duration-200">
                                Browse Products
                            </a>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 sm:gap-5 mt-3 sm:mt-4">
                            <div class="flex -space-x-2">
                                @php $heroStoreAvatars = $stores->take(3); @endphp
                                @foreach($heroStoreAvatars as $s)
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 border-white/80 bg-white/20">
                                        @if($s->logo)
                                            <img src="{{ $s->logo_url }}" class="w-full h-full object-cover rounded-full" alt="">
                                        @else
                                            <x-store-default-logo :store="$s" size="xs" class="rounded-full border-0" />
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-white">
                                <p class="text-[11px] sm:text-sm font-bold">
                                    <span class="text-base sm:text-lg font-black">{{ $verifiedStores }}+</span> Verified Sellers
                                </p>
                                <p class="text-[9px] sm:text-[10px] text-white/60">Join {{ $totalStores }}+ active stores</p>
                            </div>
                        </div>
                    </div>
                    @if($featuredStore)
                        <div class="hidden lg:block shrink-0 lg:w-[300px] xl:w-[340px]">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/15 p-3 sm:p-4">
                                <div class="flex items-center gap-2.5 mb-2.5">
                                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full overflow-hidden bg-white/20 ring-2 ring-white/30 shrink-0">
                                        @if($featuredStore->logo)
                                            <img src="{{ $featuredStore->logo_url }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <x-store-default-logo :store="$featuredStore" size="sm" class="rounded-full" />
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs sm:text-sm font-bold text-white truncate">{{ $featuredStore->name }}</p>
                                        <p class="text-[9px] text-white/60 truncate">{{ $featuredStore->products->count() }} products{{ $featuredStore->is_verified ? ' • Verified' : '' }}</p>
                                    </div>
                                </div>
                                @if($featuredStore->products->count() > 0)
                                    <div class="grid grid-cols-4 gap-1.5">
                                        @foreach($featuredStore->products->take(4) as $p)
                                            <a href="{{ route('products.show', $p->slug) }}" class="aspect-square rounded-lg overflow-hidden bg-white/10 ring-1 ring-white/10 group/card">
                                                @if($p->images->first())
                                                    <img src="{{ $p->images->first()->url }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-white/20">
                                                        <span class="material-symbols-outlined text-lg">image</span>
                                                    </div>
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                <a href="{{ route('stores.show', $featuredStore->slug) }}" class="flex items-center justify-between mt-2 pt-2 border-t border-white/10 text-[10px] sm:text-[11px] font-semibold text-white/80 hover:text-white transition-colors">
                                    <span>View store</span>
                                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 2-10. SIDEBAR + MAIN CONTENT ===== --}}
<div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-4 sm:mt-6 lg:mt-8">
    <div class="lg:grid lg:grid-cols-[280px_1fr] xl:grid-cols-[300px_1fr] lg:gap-8">

        {{-- ===== SIDEBAR (desktop only) ===== --}}
        <aside class="hidden lg:block space-y-6">

            {{-- Categories --}}
            @if($categories->count() > 0)
                <div class="bg-white rounded-xl border border-black/5 shadow-sm p-4">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Categories</h3>
                    <div class="space-y-0.5">
                        <a href="{{ route('products.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] font-semibold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all">
                            <span class="material-symbols-outlined text-[16px] text-primary/40">grid_view</span>
                            All Products
                        </a>
                        @foreach($categories as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-[12px] font-medium text-gray-600 hover:bg-primary/5 hover:text-primary transition-all">
                                @if($cat->icon && str_starts_with($cat->icon, '<'))
                                    <span class="w-4 h-4 flex items-center justify-center shrink-0 text-gray-400">{!! $cat->icon !!}</span>
                                @else
                                    <span class="material-symbols-outlined text-[16px] text-gray-400">circle</span>
                                @endif
                                <span class="truncate">{{ $cat->name }}</span>
                                <span class="ml-auto text-[10px] text-gray-400 font-semibold">{{ $cat->products_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Top Stores mini --}}
            @if($topStores->count() > 0)
                <div class="bg-white rounded-xl border border-black/5 shadow-sm p-4">
                    <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Top Stores</h3>
                    <div class="space-y-2">
                        @foreach($topStores as $i => $ts)
                            <a href="{{ route('stores.show', $ts->slug) }}" class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg hover:bg-gray-50 transition-all group">
                                <span class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center text-[9px] font-bold text-gray-400 shrink-0">{{ $i + 1 }}</span>
                                <div class="w-7 h-7 rounded-full overflow-hidden bg-gray-100 ring-1 ring-gray-200 shrink-0">
                                    @if($ts->logo)
                                        <img src="{{ $ts->logo_url }}" class="w-full h-full object-cover">
                                    @else
                                        <x-store-default-logo :store="$ts" size="xs" class="rounded-full" />
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-[11px] font-semibold text-gray-700 truncate group-hover:text-primary transition-colors">{{ $ts->name }}</p>
                                    <p class="text-[9px] text-gray-400">{{ $ts->products_count }} products</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <a href="{{ route('stores.index') }}" class="flex items-center justify-center gap-1 mt-3 pt-3 border-t border-gray-100 text-[10px] font-semibold text-primary hover:text-primary/80 transition-colors">
                        All Stores
                        <span class="material-symbols-outlined text-[12px]">arrow_forward</span>
                    </a>
                </div>
            @endif

            {{-- Promo card --}}
            <div class="bg-gradient-to-br from-[#00210d] to-[#004d1f] rounded-xl p-4 text-center">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-2">
                    <span class="material-symbols-outlined text-[20px] text-white">store</span>
                </div>
                <h4 class="text-[13px] font-bold text-white">Sell on Izifai</h4>
                <p class="text-[10px] text-white/70 mt-1 leading-relaxed">Create your free catalog and reach customers across Cameroon.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-1 mt-3 px-4 py-2 bg-white text-[#00210d] rounded-full text-[10px] font-bold hover:bg-white/90 transition-all">
                    Start Free
                    <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                </a>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <main class="min-w-0">
            {{-- Categories chips (mobile only - desktop uses sidebar) --}}
            @if($categories->count() > 0)
                <div class="lg:hidden">
                    <div class="flex items-center justify-between mb-2.5 sm:mb-3">
                        <h2 class="text-[11px] sm:text-xs font-bold text-on-surface uppercase tracking-wider">Categories</h2>
                        <a href="{{ route('products.index') }}" class="text-[10px] font-semibold text-primary hover:underline">View All</a>
                    </div>
                    <div class="flex gap-2 overflow-x-auto no-scrollbar h-scroll pb-1 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:mx-0 lg:px-0 lg:flex-wrap lg:gap-2">
                        @foreach($categories as $cat)
                            <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                               class="category-chip shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-black/8 text-[11px] font-semibold text-on-surface-variant bg-white hover:border-primary/30 hover:text-primary transition-all">
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
                </div>
            @endif

{{-- ===== 3. TRENDING PRODUCTS ===== --}}
@if($trendingProducts->count() > 0)
    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="trending-badge w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-white" style="font-variation-settings: 'FILL' 1;">local_fire_department</span>
                </span>
                <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Trending on Izifai</h2>
            </div>
            <span class="text-[9px] sm:text-[10px] font-semibold text-on-surface-variant/50">Most viewed</span>
        </div>

        <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
            @foreach($trendingProducts as $product)
                <div class="w-[140px] sm:w-[160px] shrink-0">
                    <a href="{{ route('products.show', $product->slug) }}" class="block product-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-3xl">image</span></div>
                            @endif
                            <span class="trending-badge absolute top-1.5 left-1.5 text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                <span class="material-symbols-outlined text-[8px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                                {{ $product->views }}
                            </span>
                            <button class="favorite-btn absolute top-1.5 right-1.5 w-6 h-6 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                    data-product="{{ $product->id }}"
                                    data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined text-[11px] {{ in_array($product->id, $savedProductIds) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                      style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                            </button>
                        </div>
                        <div class="p-2">
                            <h3 class="text-[10px] sm:text-[11px] font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                            @if($product->store)
                                <p class="text-[8px] text-on-surface-variant/50 truncate mt-0.5">{{ $product->store->name }}</p>
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
            <div class="w-3 sm:w-6 shrink-0"></div>
        </div>

        <div class="hidden lg:grid lg:grid-cols-2 lg:gap-3">
            @foreach($trendingProducts as $product)
                <div class="trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex gap-3 p-2">
                    <a href="{{ route('products.show', $product->slug) }}" class="w-20 h-20 rounded-lg overflow-hidden shrink-0 bg-surface-container-low block">
                        @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="" class="w-full h-full object-cover">
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
                                {{ $product->views }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif

{{-- ===== 4. FEATURED PRODUCTS ===== --}}
@if($products->count() > 0)
    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-primary/10 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">stars</span>
                </span>
                <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Featured Products</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-[9px] sm:text-[10px] font-semibold text-primary hover:underline">View All</a>
        </div>

        <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
            @foreach($products as $product)
                <div class="w-[150px] sm:w-[170px] shrink-0">
                    <div class="product-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group relative">
                        <a href="{{ route('products.show', $product->slug) }}" class="block">
                            <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                                @if($product->images->first())
                                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                         src="{{ $product->images->first()->url }}"
                                         alt="{{ $product->name }}" loading="lazy">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                        <span class="material-symbols-outlined text-3xl">image</span>
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
                                        data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                                    <span class="material-symbols-outlined text-[11px] {{ in_array($product->id, $savedProductIds) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                          style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                                </button>
                                @if($product->stock_status && $product->stock_status !== 'in_stock')
                                    <span class="absolute bottom-1.5 left-1.5 bg-white/90 backdrop-blur-sm text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-1 shadow-sm">
                                        <span class="stock-dot {{ $product->stock_status }}"></span>
                                        {{ $product->stock_status === 'out_of_stock' ? 'Out of Stock' : 'On Request' }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-2.5">
                                <div class="flex items-center justify-between gap-1 mb-0.5">
                                    @if($product->category)
                                        <p class="text-[8px] font-semibold text-primary/70 uppercase tracking-wide truncate">{{ $product->category->name }}</p>
                                    @endif
                                    @if($product->stock_status === 'in_stock')
                                        <span class="flex items-center gap-0.5 text-[7px] font-semibold text-emerald-600/70">
                                            <span class="stock-dot in-stock"></span>
                                            In Stock
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-[11px] sm:text-xs font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                                @if($product->store)
                                    <p class="text-[8px] text-on-surface-variant/50 truncate mt-0.5 flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-[9px]">store</span>
                                        {{ $product->store->name }}
                                    </p>
                                @endif
                                <div class="flex items-baseline gap-1.5 mt-1">
                                    <p class="text-xs sm:text-sm font-black price-current tracking-tight">{{ number_format($product->price) }}
                                        <span class="text-[7px] font-bold price-current-fcfa">FCFA</span>
                                    </p>
                                    @if($product->old_price && $product->old_price > $product->price)
                                        <p class="text-[8px] price-old-line">{{ number_format($product->old_price) }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="w-3 sm:w-6 shrink-0"></div>
        </div>

        <div class="hidden lg:grid lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($products as $product)
                <div class="product-card card-enter bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                            @if($product->images->first())
                                <img class="img-primary w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                                     src="{{ $product->images->first()->url }}"
                                     alt="{{ $product->name }}" loading="lazy"
                                     onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full flex items-center justify-center text-on-surface-variant/20\'><span class=\'material-symbols-outlined text-4xl\'>image</span></div>'">
                                @if($product->images->count() > 1)
                                    <img class="img-secondary absolute inset-0 w-full h-full object-cover"
                                         src="{{ $product->images->skip(1)->first()->url }}"
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
                                    data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined text-[15px] {{ in_array($product->id, $savedProductIds) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                      style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
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
    </section>
@endif

{{-- ===== 5. LATEST PRODUCTS ===== --}}
@if($latestProducts->count() > 0)
    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-amber-50 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-amber-600" style="font-variation-settings: 'FILL' 1;">new_releases</span>
                </span>
                <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Just In</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-[9px] sm:text-[10px] font-semibold text-primary hover:underline">View All</a>
        </div>

        <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
            @foreach($latestProducts as $product)
                <div class="w-[140px] sm:w-[160px] shrink-0">
                    <a href="{{ route('products.show', $product->slug) }}" class="block product-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                            @if($product->images->first())
                                <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20"><span class="material-symbols-outlined text-3xl">image</span></div>
                            @endif
                            @if($product->old_price && $product->old_price > $product->price)
                                @php $d = round((1 - $product->price / $product->old_price) * 100); @endphp
                                @if($d > 0)
                                    <span class="absolute top-1.5 left-1.5 bg-error text-on-error text-[7px] font-bold px-1.5 py-0.5 rounded-full shadow-sm">-{{ $d }}%</span>
                                @endif
                            @endif
                            <button class="favorite-btn absolute top-1.5 right-1.5 w-6 h-6 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                    data-product="{{ $product->id }}"
                                    data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined text-[11px] {{ in_array($product->id, $savedProductIds) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                      style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                            </button>
                        </div>
                        <div class="p-2">
                            @if($product->category)
                                <p class="text-[7px] font-semibold text-primary/70 uppercase tracking-wide truncate mb-0.5">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="text-[10px] sm:text-[11px] font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                            @if($product->store)
                                <p class="text-[8px] text-on-surface-variant/50 truncate mt-0.5">{{ $product->store->name }}</p>
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
            <div class="w-3 sm:w-6 shrink-0"></div>
        </div>

        <div class="hidden lg:grid lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($latestProducts as $product)
                <div class="product-card card-enter bg-white rounded-2xl overflow-hidden border border-black/[0.04] shadow-[0_1px_4px_rgba(0,0,0,0.02)] group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-low">
                            @if($product->images->first())
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                                     src="{{ $product->images->first()->url }}" alt="{{ $product->name }}" loading="lazy">
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
                            @if($product->stock_status && $product->stock_status !== 'in_stock')
                                <span class="absolute bottom-2.5 left-2.5 bg-white/90 backdrop-blur-sm text-[9px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-sm border border-black/5">
                                    <span class="stock-dot {{ $product->stock_status }}"></span>
                                    {{ $product->stock_status === 'out_of_stock' ? 'Out of Stock' : 'On Request' }}
                                </span>
                            @endif
                            <button class="favorite-btn absolute top-2.5 right-2.5 w-8 h-8 bg-white/85 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-white transition-all shadow-sm z-10"
                                    data-product="{{ $product->id }}"
                                    data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined text-[15px] {{ in_array($product->id, $savedProductIds) ? 'text-error' : 'text-on-surface-variant/60' }}"
                                      style="font-variation-settings: 'FILL' {{ in_array($product->id, $savedProductIds) ? 1 : 0 }};">favorite</span>
                            </button>
                        </div>
                        <div class="p-3">
                            @if($product->category)
                                <p class="text-[9px] font-semibold text-primary/70 uppercase tracking-wide truncate mb-0.5">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="text-[12px] sm:text-sm font-bold text-on-surface leading-snug line-clamp-2">{{ $product->name }}</h3>
                            @if($product->store)
                                <p class="text-[10px] text-on-surface-variant/60 truncate mt-0.5 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[11px]">store</span>
                                    {{ $product->store->name }}
                                </p>
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
    </section>
@endif

{{-- ===== 6. TOP STORES ===== --}}
@if($topStores->count() > 0)
    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-amber-50 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-amber-600" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                </span>
                <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Top Stores</h2>
            </div>
            <a href="{{ route('stores.index') }}" class="text-[9px] sm:text-[10px] font-semibold text-primary hover:underline">View All</a>
        </div>
        <div class="hidden lg:grid lg:grid-cols-2 lg:gap-3">
            @foreach($topStores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex items-center gap-3 p-2.5">
                    <div class="w-12 h-12 rounded-xl overflow-hidden shrink-0 bg-white ring-2 ring-gray-100">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                        @else
                            <x-store-default-logo :store="$store" size="lg" />
                        @endif
                    </div>
                    <div class="min-w-0 flex-1 flex items-center justify-between">
                        <div>
                            <div class="flex items-center gap-1">
                                <h3 class="text-[11px] sm:text-xs font-bold text-on-surface truncate">{{ $store->name }}</h3>
                                @if($store->is_verified)
                                    <span class="material-symbols-outlined text-[10px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[9px] text-on-surface-variant/60">{{ $store->products_count ?? 0 }} products</span>
                                @if($store->location)
                                    <span class="text-[9px] text-on-surface-variant/40">· {{ $store->location }}</span>
                                @endif
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-on-surface-variant/20">chevron_right</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="flex gap-3 overflow-x-auto no-scrollbar section-scroll pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
            @foreach($topStores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="w-[200px] shrink-0 trending-grid-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm flex items-center gap-2.5 p-2.5">
                    <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 bg-white ring-2 ring-gray-100">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
                        @else
                            <x-store-default-logo :store="$store" size="md" />
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-1">
                            <h3 class="text-[11px] font-bold text-on-surface truncate">{{ $store->name }}</h3>
                            @if($store->is_verified)
                                <span class="material-symbols-outlined text-[9px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                            @endif
                        </div>
                        <p class="text-[9px] text-on-surface-variant/50 truncate">{{ $store->products_count ?? 0 }} products</p>
                    </div>
                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant/20 shrink-0">chevron_right</span>
                </a>
            @endforeach
            <div class="w-3 shrink-0"></div>
        </div>
    </section>
@endif

{{-- ===== 7. TRUSTED STORES ===== --}}
@if($stores->count() > 0)
    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <span class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-primary/5 flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-[12px] sm:text-[14px] text-primary" style="font-variation-settings: 'FILL' 1;">store</span>
                </span>
                <h2 class="text-xs sm:text-sm font-extrabold text-on-surface">Trusted Stores</h2>
            </div>
            <a href="{{ route('stores.index') }}" class="text-[9px] sm:text-[10px] font-semibold text-primary hover:underline">All Stores</a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($stores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="store-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                    <div class="aspect-[4/3] relative bg-surface-container-low">
                        <div class="absolute inset-0 overflow-hidden rounded-t-xl">
                            @if($store->banner)
                                <img src="{{ $store->banner_url }}" alt="" class="store-banner w-full h-full object-cover">
                            @else
                                <x-store-default-banner :store="$store" variant="card" class="store-banner" />
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        </div>
                        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2 z-10">
                            <div class="store-logo w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-white p-1 shadow-lg ring-2 ring-white">
                                @if($store->logo)
                                    <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover rounded-full">
                                @else
                                    <x-store-default-logo :store="$store" size="lg" class="rounded-full" />
                                @endif
                            </div>
                        </div>
                        @if($store->is_verified)
                            <span class="absolute top-2 right-2 bg-primary/90 backdrop-blur-sm text-white text-[7px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5 shadow-sm">
                                <span class="material-symbols-outlined text-[8px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                <span class="hidden sm:inline">Verified</span>
                            </span>
                        @endif
                    </div>
                    <div class="p-2.5 sm:p-3 pt-8 sm:pt-9 text-center">
                        <h3 class="text-[11px] sm:text-sm font-bold text-on-surface truncate">{{ $store->name }}</h3>
                        @if($store->location)
                            <p class="text-[8px] sm:text-[10px] text-on-surface-variant/60 truncate flex items-center justify-center gap-0.5 mt-0.5">
                                <span class="material-symbols-outlined text-[10px] sm:text-[11px]">location_on</span>
                                {{ $store->location }}
                            </p>
                        @endif
                        <p class="text-[8px] sm:text-[10px] text-on-surface-variant/50 mt-1">{{ $store->products->count() }} products</p>
                        <div class="view-store-arrow flex items-center justify-center gap-0.5 mt-1.5 text-[9px] sm:text-[10px] font-semibold text-primary">
                            Visit Store
                            <span class="material-symbols-outlined text-[12px] sm:text-[14px]">arrow_forward</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif

{{-- ===== 8. HOW IT WORKS ===== --}}
<section class="mt-6 sm:mt-10 lg:mt-12">
    <div class="max-w-2xl mx-auto text-center mb-6 sm:mb-8">
        <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-[0.15em]">Simple Process</span>
        <h2 class="text-lg sm:text-xl lg:text-2xl font-black tracking-tight text-on-surface mt-2 text-balance">
            Start Selling in Three Steps
        </h2>
        <p class="text-xs sm:text-sm text-on-surface-variant mt-2 leading-relaxed max-w-md mx-auto font-[350]">
            From WhatsApp chaos to a clean, professional catalog — in minutes, not hours.
        </p>
    </div>

    <div class="flex gap-3 sm:gap-5 overflow-x-auto pb-4 snap-x snap-mandatory scroll-smooth no-scrollbar lg:overflow-visible lg:justify-center max-w-4xl mx-auto">
        <div class="step-card snap-start shrink-0 w-[72vw] sm:w-[52vw] md:w-[38vw] lg:w-72 bg-white rounded-2xl p-5 sm:p-7 border border-black/5">
            <div class="flex items-center gap-3 mb-3 sm:mb-4">
                <div class="w-9 h-9 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px] sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                </div>
                <span class="text-[8px] font-bold text-primary uppercase tracking-wider">Step 1</span>
            </div>
            <h3 class="text-sm sm:text-base font-bold text-on-surface mb-1.5">Create Your Catalog</h3>
            <p class="text-[11px] sm:text-xs text-on-surface-variant leading-relaxed font-[350]">
                Sign up free, add your products with prices and photos. Your catalog is ready in minutes — no tech skills needed.
            </p>
        </div>

        <div class="hidden lg:flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-xl text-on-surface-variant/20">arrow_forward</span>
        </div>

        <div class="step-card snap-start shrink-0 w-[72vw] sm:w-[52vw] md:w-[38vw] lg:w-72 bg-white rounded-2xl p-5 sm:p-7 border border-black/5">
            <div class="flex items-center gap-3 mb-3 sm:mb-4">
                <div class="w-9 h-9 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px] sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">link</span>
                </div>
                <span class="text-[8px] font-bold text-primary uppercase tracking-wider">Step 2</span>
            </div>
            <h3 class="text-sm sm:text-base font-bold text-on-surface mb-1.5">Share One Link</h3>
            <p class="text-[11px] sm:text-xs text-on-surface-variant leading-relaxed font-[350]">
                Post your unique Izifai link on WhatsApp. One link replaces 10+ photos — your group stays clean and valuable.
            </p>
        </div>

        <div class="hidden lg:flex items-center justify-center shrink-0">
            <span class="material-symbols-outlined text-xl text-on-surface-variant/20">arrow_forward</span>
        </div>

        <div class="step-card snap-start shrink-0 w-[72vw] sm:w-[52vw] md:w-[38vw] lg:w-72 bg-white rounded-2xl p-5 sm:p-7 border border-black/5">
            <div class="flex items-center gap-3 mb-3 sm:mb-4">
                <div class="w-9 h-9 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px] sm:text-[22px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                </div>
                <span class="text-[8px] font-bold text-primary uppercase tracking-wider">Step 3</span>
            </div>
            <h3 class="text-sm sm:text-base font-bold text-on-surface mb-1.5">Sell Smarter</h3>
            <p class="text-[11px] sm:text-xs text-on-surface-variant leading-relaxed font-[350]">
                Customers browse a lightweight catalog, see prices instantly, and contact you to order. No more muted groups.
            </p>
        </div>
    </div>

    <div class="text-center mt-6 sm:mt-8">
        <a href="{{ route('register') }}"
           class="inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-2.5 sm:py-3 bg-on-surface text-on-primary rounded-full text-[12px] sm:text-[13px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all duration-200 shadow-sm group">
            Start Free Now
            <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
        </a>
    </div>
</section>

{{-- ===== 9. STATS BANNER ===== --}}
<section class="mt-6 sm:mt-10 lg:mt-12">
    <div class="relative overflow-hidden rounded-2xl">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1556761175-b413da4baf72?w=1400&q=80');"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-[#00210d]/85 via-[#003317]/80 to-[#005228]/85"></div>
        <div class="absolute top-[-80px] right-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[60px]"></div>
        <div class="absolute bottom-[-60px] left-[-40px] w-[200px] h-[200px] rounded-full bg-white/5 blur-[60px]"></div>
        <div class="px-6 sm:px-10 lg:px-14 py-8 sm:py-10 lg:py-12 relative">
            <div class="max-w-5xl mx-auto">
                <div class="text-center mb-6 sm:mb-8">
                    <h2 class="text-base sm:text-xl lg:text-2xl font-black text-white tracking-tight">Cameroon's Growing Marketplace</h2>
                    <p class="text-[10px] sm:text-xs text-white/70 mt-1">Real numbers from real sellers</p>
                </div>
                <div class="grid grid-cols-3 gap-4 sm:gap-8 lg:gap-12 max-w-2xl mx-auto">
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight">{{ $totalStores }}+</p>
                        <p class="text-[9px] sm:text-[11px] text-white/70 font-medium mt-0.5">Active Stores</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl lg:text-3xl font-black text-white tracking-tight">{{ number_format($totalProducts) }}+</p>
                        <p class="text-[9px] sm:text-[11px] text-white/70 font-medium mt-0.5">Products Listed</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xl sm:text-2xl lg:text-3xl font-black text-[#4ade80] tracking-tight">{{ $verifiedStores }}+</p>
                        <p class="text-[9px] sm:text-[11px] text-white/70 font-medium mt-0.5">Verified Sellers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== 10. FINAL CTA ===== --}}
<section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 sm:mt-10 lg:mt-12 mb-8 sm:mb-14 lg:mb-16">
    <div class="relative overflow-hidden rounded-2xl bg-white border border-black/5 shadow-sm">
        <div class="absolute top-0 right-0 w-48 h-48 bg-primary/[0.02] rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-36 h-36 bg-primary/[0.02] rounded-full translate-y-1/2 -translate-x-1/4"></div>
        <div class="px-6 sm:px-10 lg:px-14 py-8 sm:py-10 lg:py-12 relative">
            <div class="max-w-2xl mx-auto text-center">
                <div class="w-11 h-11 rounded-2xl bg-primary/5 flex items-center justify-center text-primary mx-auto mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-[22px] sm:text-[24px]" style="font-variation-settings: 'FILL' 1;">rocket_launch</span>
                </div>
                <h2 class="text-lg sm:text-xl lg:text-2xl font-black tracking-tight text-on-surface text-balance">
                    Ready to Transform Your WhatsApp Selling?
                </h2>
                <p class="text-[11px] sm:text-xs text-on-surface-variant mt-2 leading-relaxed max-w-md mx-auto font-[350]">
                    Join {{ $verifiedStores }}+ verified sellers who've replaced photo spam with one smart link. Start free, no credit card needed.
                </p>
                <div class="mt-5 sm:mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-2.5 sm:py-3 bg-on-surface text-on-primary rounded-full text-[12px] sm:text-[13px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all duration-200 shadow-sm group">
                        Create Your Free Catalog
                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 sm:px-7 py-2.5 sm:py-3 bg-white text-on-surface rounded-full text-[12px] sm:text-[13px] font-bold border border-black/10 hover:border-black/20 active:scale-[0.97] transition-all duration-200">
                        Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

        </main>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.product;
            const wasFavorited = this.dataset.favorited === 'true';
            const icon = this.querySelector('.material-symbols-outlined');

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
                        icon.classList.remove('text-on-surface-variant/60');
                        icon.classList.add('text-error');
                        icon.style.fontVariationSettings = "'FILL' 1";
                    } else {
                        icon.classList.remove('text-error');
                        icon.classList.add('text-on-surface-variant/60');
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