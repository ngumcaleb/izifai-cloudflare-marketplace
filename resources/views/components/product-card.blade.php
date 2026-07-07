{{-- resources/views/components/product-card.blade.php --}}
@props(['product'])

@php
    $isFavorited = auth()->check() && $product->savedUsers->contains(auth()->id());
@endphp

<div class="group relative bg-white flex flex-col h-full border border-slate-100 hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 p-2 rounded-xl overflow-hidden product-card-hover"
     x-data="{ 
        favorited: {{ $isFavorited ? 'true' : 'false' }},
        loading: false,
        toggleFavorite() {
            if (!{{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = '{{ route('login') }}';
                return;
            }
            if (this.loading) return;
            this.loading = true;
            
            fetch('{{ route('products.toggle-favorite', $product->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                this.favorited = data.favorited;
                this.loading = false;
                window.dispatchEvent(new CustomEvent('favorites-updated', { detail: { count: data.count } }));
            })
            .catch(() => {
                this.loading = false;
            });
        }
     }">
    <!-- Badges & Actions -->
    <div class="absolute top-3 left-3 z-20 flex flex-col gap-1.5">
        @if($product->old_price && $product->old_price > $product->price)
            <span class="bg-brand text-white text-[9px] font-bold px-1.5 py-0.5 rounded shadow-sm">
                -{{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%
            </span>
        @endif
    </div>

    <!-- Favorite Button -->
    <button @click.prevent="toggleFavorite" 
            :class="favorited ? 'text-rose-500 bg-rose-50' : 'text-slate-400 bg-white/80'"
            class="absolute top-3 right-3 z-30 w-8 h-8 backdrop-blur-md rounded-full flex items-center justify-center hover:scale-110 transition-all shadow-sm">
        <i class="fa-solid fa-heart text-sm" x-show="favorited"></i>
        <i class="fa-regular fa-heart text-sm" x-show="!favorited"></i>
    </button>

    <!-- Image Area -->
    <a href="{{ route('products.show', $product->slug) }}" class="relative aspect-[4/5] overflow-hidden bg-slate-50 mb-3 rounded-lg block">
        <img src="{{ $product->images->first() ? $product->images->first()->url : 'https://placehold.co/600x750/f8fafc/94a3b8?text=No+Image' }}" 
             alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        
        <!-- Image stack -->
        @if($product->images->count() > 1)
            <div class="absolute bottom-2 left-2 flex items-center">
                @foreach($product->images->take(3)->skip(1) as $img)
                    <div class="-ml-1.5 first:ml-0 w-5 h-5 rounded-full ring-2 ring-white overflow-hidden shadow-sm bg-white">
                        <img src="{{ $img->url }}" alt="" class="w-full h-full object-cover" loading="lazy" onerror="this.style.display='none'">
                    </div>
                @endforeach
                <span class="ml-1 text-[8px] font-bold text-white drop-shadow-sm">+{{ $product->images->count() - 1 }}</span>
            </div>
        @endif

        <!-- Quick View Overlay -->
        <div class="absolute inset-0 bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
            <span class="bg-white/90 backdrop-blur text-slate-900 px-3 py-1.5 rounded-full text-[10px] font-bold shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform">Quick View</span>
        </div>
    </a>

    <!-- Content -->
    <div class="space-y-1.5 px-1 pb-1">
        <div class="flex items-center justify-between">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">{{ $product->category->name ?? 'Global' }}</p>
            <!-- Rating -->
            <div class="flex items-center gap-0.5 text-orange-500">
                <i class="fa-solid fa-star text-[8px]"></i>
                <span class="text-[9px] font-bold text-slate-400">4.8</span>
            </div>
        </div>

        <a href="{{ route('products.show', $product->slug) }}" class="block">
            <h3 class="text-[13px] font-bold text-slate-800 line-clamp-1 leading-snug group-hover:text-brand transition-colors tracking-tight">{{ $product->name }}</h3>
        </a>
        
        <div class="flex items-baseline gap-1.5 pt-0.5">
            <span class="text-[14px] font-extrabold text-slate-900"><span class="text-[9px] text-slate-400 font-medium mr-0.5">XAF</span>{{ number_format($product->price) }}</span>
            @if($product->old_price && $product->old_price > $product->price)
                <span class="text-[10px] text-slate-300 line-through font-medium">{{ number_format($product->old_price) }}</span>
            @endif
        </div>

        <!-- Trust Signal -->
        <div class="pt-2 flex items-center gap-1.5">
            <div class="w-1.5 h-1.5 rounded-full bg-brand"></div>
            <span class="text-[9px] font-bold text-slate-500">Verified Stock</span>
        </div>
    </div>
</div>

