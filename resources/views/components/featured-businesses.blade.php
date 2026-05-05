@props(['title' => 'Trusted Shops', 'limit' => 10])

@php
    $stores = \App\Models\Store::whereHas('products')
        ->withCount('products')
        ->inRandomOrder()
        ->take($limit)
        ->get();
@endphp

@if($stores->count() > 0)
<section class="py-6">
    <div class="flex flex-col items-center text-center mb-6">
        <h2 class="text-xl md:text-2xl font-black text-[#0A1D37] tracking-tight mb-2">{{ $title }}</h2>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">The best sellers in Cameroon</p>
        <div class="w-12 h-1 bg-green-600 rounded-full mt-4"></div>
    </div>

    <!-- Discovery Hub Grid -->
    <div class="flex overflow-x-auto no-scrollbar gap-10 pb-6 -mx-4 px-4 lg:mx-0 lg:px-0 lg:justify-center">
        @foreach($stores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" class="flex-shrink-0 group flex flex-col items-center text-center w-[100px] transition-all">
                <!-- Brand Profile Image -->
                <div class="relative mb-4">
                    <div class="w-20 h-20 rounded-2xl bg-white shadow-xl border border-slate-50 flex items-center justify-center overflow-hidden group-hover:scale-110 group-hover:shadow-green-100 transition-all duration-500">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl font-black text-slate-100 uppercase group-hover:text-green-600 transition-colors">{{ substr($store->name, 0, 1) }}</span>
                        @endif
                    </div>
                    
                    @if($store->is_verified)
                        <div class="absolute -bottom-1 -right-1 bg-green-600 text-white p-1 rounded-lg shadow-lg border-2 border-white transform group-hover:rotate-12 transition-transform">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812z"></path></svg>
                        </div>
                    @endif
                </div>

                <!-- Simple Human Info -->
                <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-tight group-hover:text-green-600 transition-colors line-clamp-1 mb-1">{{ $store->name }}</h3>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $store->products_count }} Items</span>
                
                <div class="mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-[8px] font-black text-green-600 uppercase tracking-[0.2em]">Visit Shop &rarr;</span>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endif