@extends('layouts.guest')
@section('title', $q ? "Search: $q — Izifai" : 'Search — Izifai')

@push('styles')
<style>
    .product-card { transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1); }
    .product-card:hover { transform: translateY(-4px); box-shadow: 0 20px 60px -12px rgba(0,0,0,0.08); }
</style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6 md:py-10">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-on-surface">Search Results</h1>
        @if($q && strlen($q) >= 2)
            <p class="text-sm text-on-surface-variant mt-1">
                Showing results for "<strong class="text-on-surface">{{ $q }}</strong>"
                — {{ $products->count() + $services->count() + $rentals->count() + $stores->count() }} items found
            </p>
        @else
            <p class="text-sm text-on-surface-variant mt-1">Enter at least 2 characters to search.</p>
        @endif
    </div>

    {{-- Scope tabs --}}
    @if($q && strlen($q) >= 2)
    <div class="flex items-center gap-1 mb-6 overflow-x-auto no-scrollbar">
        @foreach(['all', 'products', 'services', 'rentals', 'stores'] as $tab)
            <a href="{{ route('search', ['q' => $q, 'scope' => $tab]) }}"
               class="px-4 py-1.5 rounded-full text-[11px] font-bold transition-all capitalize whitespace-nowrap
                      {{ ($scope === $tab || ($tab === 'all' && !in_array($scope, ['products','services','rentals','stores']))) ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface bg-surface-container-lowest hover:bg-surface-container-high' }}">
                {{ $tab === 'all' ? 'All' : $tab }}
            </a>
        @endforeach
    </div>
    @endif

    @if(!$q || strlen($q) < 2)
        <div class="text-center py-20">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">search</span>
            <h2 class="text-lg font-bold text-on-surface mt-4">Search Products, Services & More</h2>
            <p class="text-sm text-on-surface-variant mt-1">Use the search bar above to find what you're looking for.</p>
        </div>
    @else
        {{-- Products --}}
        @if($scope === 'all' || $scope === 'products')
        @if($products->count() > 0)
        <section class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">inventory_2</span>
                    Products
                    <span class="text-xs font-normal text-on-surface-variant">({{ $products->count() }})</span>
                </h2>
                @if($scope === 'all')
                <a href="{{ route('products.index', ['search' => $q]) }}" class="text-xs font-bold text-primary hover:underline">View All Products</a>
                @endif
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                @foreach($products as $product)
                <div class="product-card bg-surface-container-lowest rounded-2xl overflow-hidden border border-outline-variant/10 shadow-sm group relative">
                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                        <div class="aspect-square relative overflow-hidden bg-surface-container-high">
                            @if($product->images->first())
                            <img src="{{ $product->images->first()->url }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy"
                                 onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center text-on-surface-variant/20\'><span class=\'material-symbols-outlined text-3xl\'>image</span></div>'">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                <span class="material-symbols-outlined text-3xl">image</span>
                            </div>
                            @endif
                        </div>
                        <div class="p-2 sm:p-3 space-y-0.5">
                            @if($product->category)
                            <p class="text-[7px] sm:text-[9px] font-semibold text-outline uppercase truncate">{{ $product->category->name }}</p>
                            @endif
                            <h6 class="font-bold text-xs sm:text-sm text-on-surface truncate">{{ $product->name }}</h6>
                            <p class="text-xs sm:text-sm font-black text-primary truncate">{{ number_format($product->price) }} FCFA</p>
                            @if($product->store)
                            <p class="text-[9px] text-on-surface-variant truncate">{{ $product->store->name }}</p>
                            @endif
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        @endif

        {{-- Services --}}
        @if($scope === 'all' || $scope === 'services')
        @if($services->count() > 0)
        <section class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">handyman</span>
                    Services
                    <span class="text-xs font-normal text-on-surface-variant">({{ $services->count() }})</span>
                </h2>
                @if($scope === 'all')
                <a href="{{ route('services.index', ['search' => $q]) }}" class="text-xs font-bold text-primary hover:underline">View All Services</a>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($services as $service)
                <a href="{{ route('services.show', $service->slug) }}" class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/10 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex items-start gap-3">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-surface-container-high shrink-0">
                            @if($service->images->first())
                            <img src="{{ $service->images->first()->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                <span class="material-symbols-outlined text-xl">image</span>
                            </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h6 class="font-bold text-sm text-on-surface truncate group-hover:text-primary transition-colors">{{ $service->name }}</h6>
                            @if($service->store)
                            <p class="text-xs text-on-surface-variant truncate">{{ $service->store->name }}</p>
                            @endif
                            <p class="text-sm font-black text-primary mt-1">{{ number_format($service->starting_price) }} FCFA</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        @endif

        {{-- Rentals --}}
        @if($scope === 'all' || $scope === 'rentals')
        @if($rentals->count() > 0)
        <section class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">calendar_month</span>
                    Rentals
                    <span class="text-xs font-normal text-on-surface-variant">({{ $rentals->count() }})</span>
                </h2>
                @if($scope === 'all')
                <a href="{{ route('rentals.index', ['search' => $q]) }}" class="text-xs font-bold text-primary hover:underline">View All Rentals</a>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($rentals as $rental)
                <a href="{{ route('rentals.show', $rental->slug) }}" class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/10 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex items-start gap-3">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-surface-container-high shrink-0">
                            @if($rental->images->first())
                            <img src="{{ $rental->images->first()->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/20">
                                <span class="material-symbols-outlined text-xl">image</span>
                            </div>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h6 class="font-bold text-sm text-on-surface truncate group-hover:text-primary transition-colors">{{ $rental->name }}</h6>
                            @if($rental->store)
                            <p class="text-xs text-on-surface-variant truncate">{{ $rental->store->name }} @if($rental->location) &middot; {{ $rental->location }} @endif</p>
                            @endif
                            <p class="text-sm font-black text-primary mt-1">{{ number_format($rental->rate) }} FCFA<small class="text-xs font-normal text-on-surface-variant">/{{ $rental->billing_unit }}</small></p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        @endif

        {{-- Stores --}}
        @if($scope === 'all' || $scope === 'stores')
        @if($stores->count() > 0)
        <section class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[18px]">store</span>
                    Stores
                    <span class="text-xs font-normal text-on-surface-variant">({{ $stores->count() }})</span>
                </h2>
                @if($scope === 'all')
                <a href="{{ route('stores.index', ['search' => $q]) }}" class="text-xs font-bold text-primary hover:underline">View All Stores</a>
                @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                @foreach($stores as $store)
                <a href="{{ route('stores.show', $store->slug) }}" class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/10 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl overflow-hidden bg-surface-container-high shrink-0 flex items-center justify-center">
                            @if($store->logo)
                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                            <span class="text-lg font-black text-primary">{{ substr($store->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h6 class="font-bold text-sm text-on-surface truncate group-hover:text-primary transition-colors">
                                {{ $store->name }}
                                @if($store->is_verified)
                                <span class="material-symbols-outlined text-[14px] text-primary align-text-bottom" style="font-variation-settings:'FILL' 1">verified</span>
                                @endif
                            </h6>
                            @if($store->location)
                            <p class="text-xs text-on-surface-variant truncate">{{ $store->location }}</p>
                            @endif
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </section>
        @endif
        @endif

        {{-- No results --}}
        @if($products->isEmpty() && $services->isEmpty() && $rentals->isEmpty() && $stores->isEmpty())
        <div class="text-center py-20">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">search_off</span>
            <h2 class="text-lg font-bold text-on-surface mt-4">No Results Found</h2>
            <p class="text-sm text-on-surface-variant mt-1">We couldn't find anything matching "<strong>{{ $q }}</strong>".</p>
            <p class="text-xs text-on-surface-variant mt-1">Try different keywords or browse categories.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-3 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-all">
                Browse Products
            </a>
        </div>
        @endif
    @endif
</div>
@endsection
