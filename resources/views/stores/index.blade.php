@extends('layouts.guest')
@section('title', 'Find Stores — Izifai')
@section('description', 'Browse verified sellers and stores on Izifai. Find the best products from trusted merchants across Cameroon.')

@push('styles')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(1deg); }
    }
    @keyframes float-delayed {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(-1deg); }
    }
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-delayed { animation: float-delayed 7s ease-in-out infinite; }
    .animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }
    .grid-pattern {
        background-image: radial-gradient(circle, rgba(0, 109, 56, 0.06) 1px, transparent 1px);
        background-size: 40px 40px;
    }
    .store-card:nth-child(1) { animation-delay: 0s; }
    .store-card:nth-child(2) { animation-delay: 0.05s; }
    .store-card:nth-child(3) { animation-delay: 0.1s; }
    .store-card:nth-child(4) { animation-delay: 0.15s; }
    .store-card:nth-child(5) { animation-delay: 0.2s; }
    .store-card:nth-child(6) { animation-delay: 0.25s; }
    .store-card:nth-child(7) { animation-delay: 0.3s; }
    .store-card:nth-child(8) { animation-delay: 0.35s; }
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<section class="relative overflow-hidden bg-gradient-to-br from-primary/[0.06] via-surface to-primary/[0.03] pt-14 pb-20 lg:pt-20 lg:pb-28">
    {{-- Background --}}
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-0 grid-pattern opacity-40"></div>
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-60 -left-40 w-[500px] h-[500px] bg-primary/5 rounded-full blur-3xl"></div>
        {{-- Floating decorative cards --}}
        <div class="hidden lg:block absolute top-28 right-[12%] w-48 h-32 bg-surface-container-lowest/80 backdrop-blur-sm rounded-xl border border-outline-variant/20 shadow-lg animate-float">
            <div class="p-3 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded bg-primary/20"></div>
                    <div class="w-16 h-2 rounded-full bg-on-surface/10"></div>
                </div>
                <div class="w-full h-1.5 rounded-full bg-on-surface/5"></div>
                <div class="w-3/4 h-1.5 rounded-full bg-on-surface/5"></div>
                <div class="flex justify-between">
                    <div class="w-10 h-2 rounded-full bg-primary/20"></div>
                    <div class="w-10 h-2 rounded-full bg-on-surface/5"></div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block absolute bottom-36 left-[8%] w-40 h-28 bg-surface-container-lowest/80 backdrop-blur-sm rounded-xl border border-outline-variant/20 shadow-lg animate-float-delayed">
            <div class="p-3 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-5 h-5 rounded bg-orange-400/20"></div>
                    <div class="w-12 h-2 rounded-full bg-on-surface/10"></div>
                </div>
                <div class="w-full h-1.5 rounded-full bg-on-surface/5"></div>
                <div class="w-1/2 h-1.5 rounded-full bg-on-surface/5"></div>
            </div>
        </div>
        {{-- Floating dots --}}
        <div class="hidden lg:block absolute top-1/3 right-[5%] w-2.5 h-2.5 bg-primary/30 rounded-full animate-float" style="animation-duration: 4s;"></div>
        <div class="hidden lg:block absolute bottom-1/2 left-[4%] w-2 h-2 bg-primary/20 rounded-full animate-float-delayed" style="animation-duration: 5s;"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 relative">
        <div class="max-w-3xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 rounded-full text-xs font-bold text-primary mb-6 tracking-wide border border-primary/10">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">communities</span>
                Marketplace
            </div>
            <h1 class="text-[34px] sm:text-[44px] lg:text-[56px] font-black leading-[1.05] tracking-tight text-on-surface">
                Discover <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-fixed-dim to-primary">Stores</span>
            </h1>
            <p class="text-sm sm:text-base lg:text-lg text-on-surface-variant mt-3 max-w-lg mx-auto leading-relaxed">
                Browse trusted sellers and find exactly what you need from merchants across Cameroon.
            </p>

            {{-- Search --}}
            <form method="GET" action="{{ route('stores.index') }}" class="mt-8 max-w-xl mx-auto">
                <div class="relative flex items-center bg-surface-container-lowest rounded-2xl border border-outline-variant/20 shadow-lg shadow-primary/5 focus-within:border-primary/50 focus-within:shadow-primary/10 transition-all duration-300">
                    <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-outline z-10 text-[22px]">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search stores by name or location..."
                           class="w-full pl-12 pr-4 h-14 bg-transparent text-sm focus:outline-none">
                    @if(request('search'))
                        <a href="{{ route('stores.index', request()->except('search', 'page')) }}" class="mr-2 p-2 text-on-surface-variant hover:text-on-surface transition-colors">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </a>
                    @endif
                </div>
            </form>

            {{-- Stats --}}
            <div class="mt-8 flex items-center justify-center gap-6 sm:gap-10">
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl font-black text-on-surface">{{ $totalStores }}+</p>
                    <p class="text-[11px] sm:text-xs text-on-surface-variant font-medium mt-0.5 flex items-center gap-1 justify-center">
                        <span class="material-symbols-outlined text-[14px] text-primary">store</span>
                        Active Stores
                    </p>
                </div>
                <div class="w-px h-10 bg-outline-variant/30"></div>
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl font-black text-on-surface">{{ number_format($totalProducts) }}+</p>
                    <p class="text-[11px] sm:text-xs text-on-surface-variant font-medium mt-0.5 flex items-center gap-1 justify-center">
                        <span class="material-symbols-outlined text-[14px] text-primary">inventory_2</span>
                        Products Listed
                    </p>
                </div>
                <div class="w-px h-10 bg-outline-variant/30"></div>
                <div class="text-center">
                    <p class="text-2xl sm:text-3xl font-black text-primary">{{ \App\Models\Store::where('is_verified', true)->count() }}+</p>
                    <p class="text-[11px] sm:text-xs text-on-surface-variant font-medium mt-0.5 flex items-center gap-1 justify-center">
                        <span class="material-symbols-outlined text-[14px] text-primary">verified</span>
                        Verified Sellers
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===== CONTENT ===== --}}
<section class="max-w-7xl mx-auto px-4 pb-16 lg:pb-24 -mt-6 relative z-10">

    {{-- Category Pills --}}
    @if($categories->count() > 0)
        <div class="mb-6">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-2">
                <a href="{{ route('stores.index', request()->except('category', 'page')) }}"
                   class="shrink-0 px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 {{ !request('category') || request('category') === 'all' ? 'bg-primary text-on-primary shadow-sm shadow-primary/20' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container border border-outline-variant/20 hover:border-primary/30' }}">
                    All Stores
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('stores.index', array_merge(request()->except('category', 'page'), ['category' => $category->slug])) }}"
                       class="shrink-0 px-4 py-2 rounded-full text-xs font-bold transition-all duration-200 {{ request('category') === $category->slug ? 'bg-primary text-on-primary shadow-sm shadow-primary/20' : 'bg-surface-container-low text-on-surface-variant hover:bg-surface-container border border-outline-variant/20 hover:border-primary/30' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Toolbar: Results + Sort --}}
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-surface-container-lowest rounded-xl px-4 py-3 border border-outline-variant/10">
        <p class="text-sm text-on-surface-variant">
            @if($stores->total() > 0)
                <span class="font-bold text-on-surface">{{ $stores->total() }}</span> {{ Str::plural('store', $stores->total()) }}
                @if(request('search'))
                    found for "<span class="font-semibold text-primary">{{ request('search') }}</span>"
                @endif
                @if(request('category') && request('category') !== 'all')
                    @if(request('search')) <span class="mx-1.5 text-outline-variant">•</span> @endif
                    in <span class="font-semibold text-primary">{{ \App\Models\Category::where('slug', request('category'))->first()?->name ?? request('category') }}</span>
                @endif
            @else
                No stores found
            @endif
        </p>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            @if(request('search') || request('category'))
                <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-primary hover:underline flex items-center gap-1 shrink-0">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                    Clear
                </a>
                <span class="text-outline-variant/30">|</span>
            @endif
            <div class="relative">
                <form method="GET" action="{{ route('stores.index') }}">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    <select name="sort" onchange="this.form.submit()"
                            class="appearance-none bg-surface-container-low border border-outline-variant/20 rounded-lg pl-3 pr-8 py-1.5 text-xs font-semibold text-on-surface-variant focus:outline-none focus:border-primary/30 cursor-pointer">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Highest Rated</option>
                        <option value="products" {{ request('sort') === 'products' ? 'selected' : '' }}>Most Products</option>
                    </select>
                </form>
                <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-[14px] pointer-events-none">unfold_more</span>
            </div>
        </div>
    </div>

    {{-- Stores Grid --}}
    @if($stores->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-6">
            @foreach($stores as $store)
                <div class="store-card group bg-surface-container-lowest rounded-2xl border border-outline-variant/10 overflow-hidden hover:shadow-xl hover:border-primary/20 hover:-translate-y-1.5 transition-all duration-300 opacity-0 animate-fade-in-up">
                    {{-- Banner --}}
                    <a href="{{ route('stores.show', $store->slug) }}" class="block h-20 sm:h-24 bg-gradient-to-br from-primary/20 to-primary/5 relative overflow-hidden">
                        @if($store->banner)
                            <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary/10 via-primary/5 to-surface-container-low"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent"></div>
                        {{-- Verified badge --}}
                        @if($store->is_verified)
                            <div class="absolute top-2 right-2 bg-primary/90 backdrop-blur-sm text-on-primary text-[8px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-lg">
                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                Verified
                            </div>
                        @endif
                        {{-- New badge --}}
                        @if($store->created_at && $store->created_at->diffInDays(now()) <= 7)
                            <div class="absolute top-2 left-2 bg-orange-500/90 backdrop-blur-sm text-white text-[8px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-lg">
                                <span class="material-symbols-outlined text-[10px]" style="font-variation-settings: 'FILL' 1;">new_releases</span>
                                New
                            </div>
                        @endif
                    </a>

                    {{-- Content --}}
                    <div class="px-4 sm:px-5 pb-5">
                        {{-- Logo --}}
                        <div class="flex items-end -mt-8 sm:-mt-10 mb-3">
                            <a href="{{ route('stores.show', $store->slug) }}" class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl ring-[3px] ring-surface-container-lowest bg-surface-container-lowest shadow-lg overflow-hidden shrink-0 transition-transform group-hover:scale-110 group-hover:rotate-[-3deg] duration-300">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary to-primary-container flex items-center justify-center text-xl sm:text-2xl font-black text-on-primary">
                                        {{ substr($store->name, 0, 1) }}
                                    </div>
                                @endif
                            </a>
                        </div>

                        {{-- Store Name + WhatsApp --}}
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <a href="{{ route('stores.show', $store->slug) }}">
                                    <h3 class="text-sm sm:text-base font-bold text-on-surface group-hover:text-primary transition-colors truncate">{{ $store->name }}</h3>
                                </a>
                                {{-- Rating --}}
                                <div class="flex items-center gap-2 mt-1">
                                    @if($store->reviews_avg_rating)
                                        <div class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px] text-orange-500" style="font-variation-settings: 'FILL' 1;">star</span>
                                            <span class="text-xs font-bold text-on-surface">{{ number_format($store->reviews_avg_rating, 1) }}</span>
                                        </div>
                                        <span class="text-[10px] text-on-surface-variant">({{ $store->reviews_count ?? 0 }})</span>
                                    @else
                                        <span class="text-[11px] text-on-surface-variant font-medium">No reviews yet</span>
                                    @endif
                                </div>
                            </div>
                            @if($store->whatsapp_number)
                                <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                                   class="shrink-0 w-8 h-8 rounded-lg bg-[#25D366]/10 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all duration-200 group/wa"
                                   title="Contact on WhatsApp">
                                    <span class="material-symbols-outlined text-[16px] group-hover/wa:scale-110 transition-transform">chat</span>
                                </a>
                            @endif
                        </div>

                        {{-- Location --}}
                        @if($store->location)
                            <p class="text-[11px] sm:text-xs text-on-surface-variant mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">location_on</span>
                                {{ $store->location }}
                            </p>
                        @endif

                        {{-- Divider + Footer --}}
                        <div class="mt-3 pt-3 border-t border-outline-variant/10">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] sm:text-[11px] font-semibold text-on-surface-variant flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px] sm:text-[16px] text-primary">inventory_2</span>
                                    {{ $store->products_count }} {{ Str::plural('product', $store->products_count) }}
                                </span>
                                <a href="{{ route('stores.show', $store->slug) }}"
                                   class="text-[10px] font-bold text-primary hover:text-primary/80 transition-colors flex items-center gap-0.5 group/link">
                                    View Store
                                    <span class="material-symbols-outlined text-[14px] group-hover/link:translate-x-0.5 transition-transform">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($stores->hasPages())
            <div class="mt-10 lg:mt-12">
                {{ $stores->links('partials.pagination') }}
            </div>
        @endif
    @else
        {{-- Empty State --}}
        <div class="text-center py-20 lg:py-28 bg-surface-container-lowest rounded-2xl border border-outline-variant/10 shadow-sm">
            <div class="w-20 h-20 rounded-2xl bg-surface-container flex items-center justify-center mx-auto mb-5">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant" style="font-variation-settings: 'FILL' 1;">storefront</span>
            </div>
            <h3 class="text-xl font-bold text-on-surface">No stores found</h3>
            @if(request('search') || request('category'))
                <p class="text-sm text-on-surface-variant mt-2 max-w-xs mx-auto">
                    @if(request('search'))
                        Nothing matches "<span class="font-semibold text-primary">{{ request('search') }}</span>"
                    @else
                        No stores in this category yet
                    @endif
                </p>
                <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-md shadow-primary/20">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    Clear All Filters
                </a>
            @else
                <p class="text-sm text-on-surface-variant mt-2">Check back soon for new sellers</p>
            @endif
        </div>
    @endif
</section>

@endsection
