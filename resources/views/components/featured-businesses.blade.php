<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
    
    .font-montserrat { font-family: 'Montserrat', sans-serif; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>

@props(['title' => 'Top Wholesalers', 'limit' => 12])

@php
    $stores = \App\Models\Store::whereHas('products')
        ->withCount('products')
        ->inRandomOrder()
        ->take($limit)
        ->get();
@endphp

@if($stores->count() > 0)
<section class="py-8 bg-white font-montserrat">
    <div class="max-w-[1400px] mx-auto px-4 lg:px-8">
        
        {{-- ── MINIMALIST HEADER ── --}}
        <div class="flex items-end justify-between mb-6 pb-2 border-b border-slate-100">
            <div>
                <span class="text-[9px] font-black uppercase tracking-[0.3em] text-emerald-600 block mb-1">Curated List</span>
                <h2 class="text-sm font-black text-[#0A1D37] uppercase tracking-tighter">{{ $title }}</h2>
            </div>
            <a href="{{ route('stores.index') }}" class="text-[9px] font-bold uppercase tracking-widest text-slate-400 hover:text-emerald-600 transition-colors flex items-center gap-2">
                View All Directory
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- ── SMALL-SCALE HORIZONTAL FLOW ── --}}
        <div class="flex overflow-x-auto no-scrollbar gap-3 snap-x">
            
            @foreach($stores as $store)
            <a href="{{ route('stores.show', $store->slug) }}" 
               class="snap-start flex-shrink-0 w-[160px] group border border-transparent hover:border-slate-100 p-2 rounded-xl transition-all">
                
                {{-- Square Preview --}}
                <div class="relative aspect-square rounded-lg overflow-hidden bg-slate-50 mb-3">
                    @php $img = $store->products->first()?->images->first()?->path; @endphp
                    <img src="{{ $img ? r2_url($img) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=200&h=200&auto=format&fit=crop' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    
                    {{-- Small Badge --}}
                    <div class="absolute top-1.5 right-1.5">
                        <x-store-badge :store="$store" size="sm" :showText="false" />
                    </div>
                </div>

                {{-- Micro Info --}}
                <div class="space-y-0.5">
                    <h3 class="text-[10px] font-extrabold text-[#0A1D37] truncate uppercase tracking-tight group-hover:text-emerald-600">
                        {{ $store->name }}
                    </h3>
                    <div class="flex items-center justify-between">
                        <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">
                            {{ $store->products_count }} SKUs
                        </span>
                        <span class="text-[8px] font-medium text-slate-300 uppercase italic">
                            {{ $store->location ?? 'Cameroon' }}
                        </span>
                    </div>
                </div>
            </a>
            @endforeach

            {{-- ── SMALL CTA END ── --}}
            <a href="{{ route('stores.index') }}" 
               class="flex-shrink-0 w-[120px] flex flex-col items-center justify-center border border-dashed border-slate-200 rounded-xl hover:bg-slate-50 transition-colors">
                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center mb-2">
                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">More</span>
            </a>
        </div>
    </div>
</section>
@endif