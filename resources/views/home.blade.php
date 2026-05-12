@extends('layouts.marketplace')
@section('title', 'Izifai — Simplify Your Shopping')
@section('description', 'Cameroon\'s premier marketplace connecting verified sellers with buyers. Browse products, find stores, and shop with confidence.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDM0djItSDI0di0yaDEyek0zNiAyNnYySDI0di0yaDEyeiIvPjwvZz48L2c+PC9zdmc+')] opacity-30"></div>
    <div class="max-w-7xl mx-auto px-4 py-16 md:py-28 relative">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/20 text-emerald-300 rounded-full text-[10px] font-bold uppercase tracking-widest mb-6 border border-emerald-500/20">
                <i class="fa-solid fa-store"></i>
                Cameroon's Premier Marketplace
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-black leading-tight tracking-tight">
                Simplify Your
                <span class="text-emerald-400">Shopping</span>
            </h1>
            <p class="text-sm md:text-lg text-slate-300 mt-4 md:mt-6 max-w-xl leading-relaxed">
                Connect directly with verified sellers across Cameroon. Source products, grow your business, and shop with confidence.
            </p>
            <div class="flex flex-wrap gap-3 mt-8 md:mt-10">
                @guest
                    <a href="{{ route('register') }}?role=buyer"
                       class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-white text-slate-900 rounded-full text-sm font-bold hover:bg-emerald-50 transition-all shadow-xl whitespace-nowrap">
                        <i class="fa-solid fa-user-plus"></i>
                        Start Shopping
                    </a>
                    <a href="{{ route('register') }}?role=seller"
                       class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-emerald-600 text-white rounded-full text-sm font-bold hover:bg-emerald-500 transition-all shadow-xl whitespace-nowrap">
                        <i class="fa-solid fa-store"></i>
                        Start Selling
                    </a>
                @else
                    <a href="{{ route('products.search') }}"
                       class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-white text-slate-900 rounded-full text-sm font-bold hover:bg-emerald-50 transition-all shadow-xl whitespace-nowrap">
                        <i class="fa-solid fa-box"></i>
                        Browse Products
                    </a>
                    <a href="{{ route('stores.index') }}"
                       class="inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-emerald-600 text-white rounded-full text-sm font-bold hover:bg-emerald-500 transition-all shadow-xl whitespace-nowrap">
                        <i class="fa-solid fa-store"></i>
                        Find Stores
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Stats Bar -->
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 py-6 md:py-8">
        <div class="grid grid-cols-3 gap-4 md:gap-8">
            <div class="text-center">
                <p class="text-xl md:text-3xl font-black text-slate-900">{{ number_format($stats['stores']) }}+</p>
                <p class="text-[10px] md:text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">Active Stores</p>
            </div>
            <div class="text-center">
                <p class="text-xl md:text-3xl font-black text-slate-900">{{ number_format($stats['products']) }}+</p>
                <p class="text-[10px] md:text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">Products Listed</p>
            </div>
            <div class="text-center">
                <p class="text-xl md:text-3xl font-black text-slate-900">{{ number_format($stats['categories']) }}</p>
                <p class="text-[10px] md:text-xs font-semibold text-slate-400 uppercase tracking-widest mt-1">Categories</p>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-12 md:py-20">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-black text-slate-900 tracking-tight">Browse by <span class="text-emerald-600">Category</span></h2>
                <p class="text-sm text-slate-500 mt-1">Find exactly what you need across all categories</p>
            </div>
            <a href="{{ route('products.search') }}" class="hidden md:inline-flex items-center gap-1 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                View All
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.search', ['category' => $category->slug]) }}"
                   class="group bg-white rounded-2xl border border-slate-100 p-4 md:p-6 text-center hover:border-emerald-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-tag text-emerald-600 text-lg md:text-2xl"></i>
                    </div>
                    <p class="text-xs md:text-sm font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate">{{ $category->name }}</p>
                    <p class="text-[9px] md:text-[10px] text-slate-400 font-medium mt-1">{{ $category->products_count ?? 0 }} items</p>
                </a>
            @endforeach
        </div>
        <div class="mt-6 text-center md:hidden">
            <a href="{{ route('products.search') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-full text-xs font-bold">
                View All Categories
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Featured Stores -->
<section class="bg-white py-12 md:py-20 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl md:text-3xl font-black text-slate-900 tracking-tight">Featured <span class="text-emerald-600">Stores</span></h2>
                <p class="text-sm text-slate-500 mt-1">Trusted sellers ready to serve you</p>
            </div>
            <a href="{{ route('stores.index') }}" class="hidden md:inline-flex items-center gap-1 text-sm font-bold text-emerald-600 hover:text-emerald-700 transition-colors">
                All Stores
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>
        @if($stores->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @foreach($stores as $store)
                    <a href="{{ route('stores.show', $store->slug) }}"
                       class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:border-emerald-200 hover:-translate-y-0.5 transition-all duration-300">
                        <div class="h-16 bg-gradient-to-r from-slate-700 to-slate-600 relative">
                            @if($store->banner)
                                <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="px-4 pb-4">
                            <div class="flex items-end -mt-6 mb-2">
                                <div class="w-10 h-10 rounded-lg border-2 border-white bg-white shadow-md overflow-hidden">
                                    @if($store->logo)
                                        <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-emerald-100 flex items-center justify-center text-sm font-black text-emerald-700">{{ substr($store->name, 0, 1) }}</div>
                                    @endif
                                </div>
                            </div>
                            <h3 class="text-xs font-bold text-slate-900 truncate">{{ $store->name }}</h3>
                            <p class="text-[9px] text-slate-500 mt-0.5">{{ $store->location ?? 'Cameroon' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
        <div class="mt-6 text-center md:hidden">
            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-full text-xs font-bold">
                All Stores
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4">
        <div class="bg-gradient-to-br from-emerald-900 via-emerald-700 to-emerald-800 rounded-3xl p-8 md:p-16 text-center text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMjAgMzBhMTAgMTAgMCAxIDEgMC0yMCAxMCAxMCAwIDAgMSAwIDIweiIgZmlsbD0iI2ZmZiIgZmlsbC1vcGFjaXR5PSIwLjA1Ii8+PC9zdmc+')] opacity-50"></div>
            <div class="relative">
                <h2 class="text-2xl md:text-4xl font-black tracking-tight">Ready to Start Selling?</h2>
                <p class="text-sm md:text-base text-emerald-200 mt-4 max-w-lg mx-auto">Join hundreds of verified sellers across Cameroon. Create your store in minutes and reach thousands of buyers.</p>
                <a href="{{ route('register') }}?role=seller"
                   class="inline-flex items-center gap-2 mt-8 px-8 py-4 bg-white text-emerald-900 rounded-full text-sm font-black hover:bg-emerald-50 transition-all shadow-xl whitespace-nowrap">
                    <i class="fa-solid fa-store"></i>
                    Create Your Store Free
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
