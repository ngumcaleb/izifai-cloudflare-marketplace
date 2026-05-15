@extends('layouts.guest')

@section('title', 'Izifai — Buy and Sell in Cameroon')
@section('description', 'Izifai connects you with trusted sellers across Cameroon. Browse, message, and buy — all from one link.')

@push('styles')
<style>
    @keyframes cardIn { from { opacity: 0; transform: translateY(20px) scale(0.97); } to { opacity: 1; transform: translateY(0) scale(1); } }
    @keyframes shimmer { 0% { background-position: 200% 0; } 100% { background-position: -200% 0; } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    @keyframes scalePulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }
    @keyframes dotPulse { 0%, 100% { opacity: 0.3; } 50% { opacity: 0.8; } }
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
    .hero-gradient {
        background: radial-gradient(ellipse 80% 60% at 50% -20%, rgba(0,109,56,0.12) 0%, transparent 70%),
                    radial-gradient(ellipse 60% 50% at 80% 80%, rgba(0,168,89,0.08) 0%, transparent 60%),
                    radial-gradient(ellipse 50% 40% at 20% 60%, rgba(0,109,56,0.06) 0%, transparent 50%),
                    #fafcfa;
    }
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
    .store-card .view-store-arrow { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .store-card:hover .view-store-arrow { transform: translateX(4px); }
    .step-card { transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .step-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.06); }
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
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-scale-pulse { animation: scalePulse 2s ease-in-out infinite; }
    .animate-dot-pulse { animation: dotPulse 1.5s ease-in-out infinite; }
    .animate-dot-pulse-delayed { animation: dotPulse 1.5s ease-in-out 0.5s infinite; }
    .animate-dot-pulse-slower { animation: dotPulse 1.5s ease-in-out 1s infinite; }
</style>
@endpush

@section('content')

{{-- ===== 1. HERO ===== --}}
<section class="mx-3 sm:mx-6 lg:mx-8 mt-3 sm:mt-4">
    <div class="relative flex flex-col justify-end min-h-[280px] sm:min-h-[300px] lg:min-h-[380px] overflow-hidden rounded-2xl shadow-sm">
        @php $heroImage = \App\Models\Setting::get('hero_image'); @endphp
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $heroImage ? r2_url($heroImage) : 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=2070&auto=format&fit=crop' }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-black/10"></div>
        <div class="absolute top-[-120px] right-[-80px] w-[400px] h-[400px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute bottom-[-100px] left-[-60px] w-[300px] h-[300px] rounded-full bg-white/5 blur-[80px]"></div>
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-[0.04]">
            <div class="absolute top-20 left-[15%] w-1 h-1 rounded-full bg-white animate-dot-pulse"></div>
            <div class="absolute top-40 left-[35%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
            <div class="absolute top-10 right-[25%] w-1 h-1 rounded-full bg-white animate-dot-pulse-slower"></div>
            <div class="absolute bottom-40 right-[20%] w-1.5 h-1.5 rounded-full bg-white animate-dot-pulse-delayed"></div>
            <div class="absolute bottom-20 left-[40%] w-1 h-1 rounded-full bg-white animate-dot-pulse"></div>
        </div>
        <div class="relative px-5 sm:px-8 lg:px-12 py-4 sm:py-8 lg:py-12">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 mb-3 sm:mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#00a859] animate-scale-pulse"></span>
                            <span class="text-[9px] sm:text-[10px] font-bold text-white/90 tracking-wide">Cameroon's Trusted Marketplace</span>
                        </div>
                        <h1 class="text-[32px] sm:text-[44px] lg:text-[56px] font-black leading-[1.04] tracking-[-0.03em] text-white text-balance">
                            Buy and Sell in<br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00a859] to-[#4ade80]">Cameroon</span>
                        </h1>
                        <p class="text-xs sm:text-sm lg:text-base text-white/80 max-w-xl leading-relaxed mt-2 sm:mt-3 font-[350]">
                            Izifai connects you with trusted sellers across Cameroon. Browse products, message directly, and buy — all from one link, no app needed.
                        </p>
                        <div class="flex flex-nowrap items-center gap-2 sm:gap-3 mt-3 sm:mt-5">
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center justify-center gap-1 sm:gap-2 px-4 sm:px-7 py-2.5 sm:py-3 bg-white text-[#00210d] rounded-full text-[11px] sm:text-[13px] font-bold hover:bg-white/90 active:scale-[0.97] transition-all duration-200 shadow-sm group flex-1 sm:flex-none">
                                Start Selling Free
                                <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:translate-x-0.5 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                            </a>
                            <a href="{{ route('products.index') }}"
                               class="inline-flex items-center justify-center gap-2 px-4 sm:px-7 py-2.5 sm:py-3 bg-white/10 backdrop-blur-sm text-white rounded-full text-[11px] sm:text-[13px] font-bold border border-white/20 hover:bg-white/20 active:scale-[0.97] transition-all duration-200 flex-1 sm:flex-none">
                                Browse Products
                            </a>
                        </div>
                        <div class="flex flex-wrap items-center gap-3 sm:gap-5 mt-4 sm:mt-6">
                            <div class="flex -space-x-2">
                                @php $heroStoreAvatars = $stores->take(3); @endphp
                                @foreach($heroStoreAvatars as $s)
                                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full border-2 border-white/80 overflow-hidden bg-white/20">
                                        @if($s->logo)
                                            <img src="{{ $s->logo_url }}" class="w-full h-full object-cover" alt="">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white/70 text-[9px] font-black">{{ substr($s->name, 0, 1) }}</div>
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
                        <div class="shrink-0 w-full lg:w-[320px] xl:w-[360px]">
                            <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/15 p-3 sm:p-4">
                                <div class="flex items-center gap-2.5 mb-2.5">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg bg-white/15 flex items-center justify-center text-white font-black text-xs">{{ substr($featuredStore->name, 0, 1) }}</div>
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
                                <a href="{{ route('stores.show', $featuredStore->slug) }}" class="flex items-center justify-between mt-2.5 pt-2.5 border-t border-white/10 text-[10px] sm:text-[11px] font-semibold text-white/80 hover:text-white transition-colors">
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

{{-- ===== 2. FEATURED PRODUCTS ===== --}}
@if($products->count() > 0)
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 sm:mt-10 lg:mt-12">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <div>
                <h2 class="text-sm sm:text-base lg:text-lg font-black text-on-surface tracking-tight">Featured Products</h2>
                <p class="text-[10px] sm:text-xs text-on-surface-variant/70 mt-0.5">Discover popular items from trusted sellers</p>
            </div>
            <a href="{{ route('products.index') }}" class="flex items-center gap-1 text-[11px] sm:text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                View All
                <span class="material-symbols-outlined text-[14px] sm:text-[16px]">arrow_forward</span>
            </a>
        </div>

        {{-- Mobile: Horizontal scroll --}}
        <div class="flex gap-3 overflow-x-auto no-scrollbar pb-2 -mx-3 px-3 sm:-mx-6 sm:px-6 lg:hidden">
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

        {{-- Desktop: Grid --}}
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
                                        <span class="w-3 h-3 rounded-full border-2 border-white shadow-[0_0_0_1px_rgba(0,0,0,0.08)]" style="background: {{ $color }};"></span>
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

{{-- ===== 3. CATEGORIES ===== --}}
@if($categories->count() > 0)
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-6 sm:mt-10 lg:mt-12">
        <div class="flex items-center justify-between mb-3 sm:mb-4">
            <div>
                <h2 class="text-sm sm:text-base lg:text-lg font-black text-on-surface tracking-tight">Browse by Category</h2>
                <p class="text-[10px] sm:text-xs text-on-surface-variant/70 mt-0.5">Find exactly what you're looking for</p>
            </div>
            <a href="{{ route('products.index') }}" class="flex items-center gap-1 text-[11px] sm:text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                All Categories
                <span class="material-symbols-outlined text-[14px] sm:text-[16px]">arrow_forward</span>
            </a>
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
    </section>
@endif

{{-- ===== 4. HOW IT WORKS ===== --}}
<section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-8 sm:mt-14 lg:mt-16">
    <div class="max-w-2xl mx-auto text-center mb-6 sm:mb-10">
        <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-[0.15em]">Simple Process</span>
        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-on-surface mt-2 text-balance">
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

{{-- ===== 5. FEATURED STORES ===== --}}
@if($stores->count() > 0)
    <section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-8 sm:mt-14 lg:mt-16">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
            <div>
                <h2 class="text-sm sm:text-base lg:text-lg font-black text-on-surface tracking-tight">Trusted Stores</h2>
                <p class="text-[10px] sm:text-xs text-on-surface-variant/70 mt-0.5">Shop from verified sellers across Cameroon</p>
            </div>
            <a href="{{ route('stores.index') }}" class="flex items-center gap-1 text-[11px] sm:text-xs font-bold text-primary hover:text-primary/80 transition-colors">
                All Stores
                <span class="material-symbols-outlined text-[14px] sm:text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($stores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="store-card bg-white rounded-xl overflow-hidden border border-black/[0.04] shadow-sm group">
                    <div class="aspect-[4/3] relative overflow-hidden bg-surface-container-low">
                        @if($store->banner)
                            <img src="{{ $store->banner_url }}" alt="" class="store-banner w-full h-full object-cover">
                        @else
                            <div class="store-banner w-full h-full bg-gradient-to-br from-primary/10 to-primary/5"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                        <div class="absolute -bottom-6 left-1/2 -translate-x-1/2">
                            <div class="store-logo w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-white p-1 shadow-lg ring-2 ring-white">
                                @if($store->logo)
                                    <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <div class="w-full h-full rounded-lg bg-primary/5 flex items-center justify-center text-primary font-black text-sm sm:text-base">{{ substr($store->name, 0, 1) }}</div>
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

{{-- ===== 6. STATS BANNER ===== --}}
<section class="mx-3 sm:mx-6 lg:mx-8 mt-8 sm:mt-14 lg:mt-16">
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-[#00210d] via-[#003317] to-[#005228]">
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

{{-- ===== 7. FINAL CTA ===== --}}
<section class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-8 sm:mt-14 lg:mt-16 mb-8 sm:mb-14 lg:mb-16">
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
