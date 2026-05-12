@extends('layouts.marketplace')
@section('title', 'Find Stores — Izifai')
@section('description', 'Browse verified sellers and stores on Izifai. Find the best products from trusted merchants across Cameroon.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 md:py-12">

    <!-- Header -->
    <div class="mb-8 md:mb-12">
        <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight">Find <span class="text-emerald-600">Stores</span></h1>
        <p class="text-sm md:text-base text-slate-500 mt-2 max-w-xl">Browse verified sellers and discover products from trusted merchants across Cameroon.</p>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-2xl border border-slate-100 p-4 md:p-6 mb-8 shadow-sm">
        <form method="GET" action="{{ route('stores.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stores by name or location..."
                       class="w-full h-12 pl-11 pr-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all">
            </div>
            <button type="submit" class="h-12 px-8 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-all whitespace-nowrap shadow-sm">
                <i class="fa-solid fa-search mr-2"></i>
                Search
            </button>
        </form>
    </div>

    <!-- Store Listings -->
    @if($stores->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
            @foreach($stores as $store)
                <a href="{{ route('stores.show', $store->slug) }}"
                   class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:border-emerald-200 hover:-translate-y-0.5 transition-all duration-300">
                    <!-- Banner -->
                    <div class="h-20 bg-gradient-to-r from-slate-700 to-slate-600 relative overflow-hidden">
                        @if($store->banner)
                            <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover">
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    </div>
                    <!-- Content -->
                    <div class="px-4 pb-5">
                        <!-- Logo -->
                        <div class="flex items-end -mt-8 mb-3">
                            <div class="w-14 h-14 rounded-xl border-3 border-white bg-white shadow-md overflow-hidden shrink-0">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-emerald-100 flex items-center justify-center text-lg font-black text-emerald-700">
                                        {{ substr($store->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            @if($store->is_verified)
                                <div class="ml-auto bg-blue-50 text-blue-600 rounded-full px-2 py-0.5 text-[8px] font-bold tracking-wider border border-blue-100">
                                    <i class="fa-solid fa-circle-check mr-0.5"></i> Verified
                                </div>
                            @endif
                        </div>
                        <!-- Name -->
                        <h3 class="text-sm font-bold text-slate-900 group-hover:text-emerald-600 transition-colors truncate">{{ $store->name }}</h3>
                        <!-- Location -->
                        @if($store->location)
                            <p class="text-[10px] text-slate-500 font-medium mt-1 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot text-emerald-500"></i>
                                {{ $store->location }}
                            </p>
                        @endif
                        <!-- Stats -->
                        <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-50">
                            <span class="text-[10px] font-bold text-slate-400">
                                <i class="fa-solid fa-box mr-1 text-emerald-500"></i>
                                {{ $store->products_count ?? $store->products->count() }} products
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8 md:mt-12">
            {{ $stores->links('partials.pagination') }}
        </div>
    @else
        <div class="text-center py-16 md:py-24 bg-white rounded-2xl border border-slate-100">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-store text-2xl text-slate-300"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-400">No stores found</h3>
            @if(request('search'))
                <p class="text-sm text-slate-400 mt-2">No results for "{{ request('search') }}"</p>
                <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 bg-emerald-600 text-white rounded-full text-xs font-bold hover:bg-emerald-700 transition-all">
                    <i class="fa-solid fa-arrow-left"></i>
                    Clear Search
                </a>
            @else
                <p class="text-sm text-slate-400 mt-2">Check back soon for new sellers</p>
            @endif
        </div>
    @endif
</div>
@endsection
