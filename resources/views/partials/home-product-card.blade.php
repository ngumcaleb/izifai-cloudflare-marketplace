<div class="group relative w-full min-w-0 bg-white overflow-hidden border border-black/[0.07] rounded-xl hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300">
    <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
            @if($product->images->first())
                <img src="{{ $product->images->first()->url }}"
                     alt="{{ $product->name }}" loading="lazy"
                     class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                     onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><i class=\'fa-solid fa-image text-4xl sm:text-5xl\'></i></div>'">
            @else
                <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                    <i class="fa-solid fa-image text-4xl sm:text-5xl"></i>
                </div>
            @endif

            @if($product->is_featured)
                <span class="absolute top-2 sm:top-3 -left-1.5 sm:-left-2 z-20 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-r-md -skew-x-12 bg-[#1c201e] text-[#9acd32] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-[0.1em] sm:tracking-[0.14em] shadow-md">
                    Featured
                </span>
            @endif

            <span class="absolute top-2 sm:top-3 left-2 sm:left-3 z-20 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-12 bg-white/95 text-[#3f453f] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-[0.08em] sm:tracking-[0.12em] shadow-sm">
                {{ $product->category->name ?? 'Marketplace' }}
            </span>

            @if($product->old_price && $product->old_price > $product->price)
                @php $discountPct = round((1 - $product->price / $product->old_price) * 100); @endphp
                @if($discountPct > 0)
                    <span class="absolute top-2 sm:top-3 right-2 sm:right-3 z-20 px-1.5 sm:px-2.5 py-0.5 -skew-x-12 bg-[#dc2626] text-white text-[9px] sm:text-[11px] font-black shadow-md">-{{ $discountPct }}%</span>
                @endif
            @endif

            <button class="favorite-btn absolute bottom-2 sm:bottom-3 right-2 sm:right-3 z-30 w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-white/95 shadow-md grid place-items-center hover:scale-110 active:scale-90 transition-all"
                    data-product="{{ $product->id }}"
                    data-favorited="{{ in_array($product->id, $savedProductIds) ? 'true' : 'false' }}">
                <i class="{{ in_array($product->id, $savedProductIds) ? 'fa-solid' : 'fa-regular' }} fa-heart text-[15px] sm:text-[18px] {{ in_array($product->id, $savedProductIds) ? 'text-[#dc2626]' : 'text-[#5c625e]' }}" style=""></i>
            </button>

            @if($product->stock_status === 'out_of_stock')
                <span class="absolute inset-x-0 bottom-0 z-10 py-1 sm:py-2 bg-[#1c201e]/80 text-white text-[9px] sm:text-[10px] font-bold text-center backdrop-blur-sm">Out of Stock</span>
            @endif
        </div>

        <div class="p-2.5 sm:p-3.5">
            <div class="flex items-center justify-between gap-1.5">
                <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-[#9aa19c] truncate">{{ $product->store->name ?? 'Marketplace' }}</p>
                @if($product->stock_status === 'in_stock')
                    <span class="inline-flex items-center gap-1 text-[8.5px] sm:text-[10px] font-bold text-[#659316] shrink-0">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] inline-block"></span> In Stock
                    </span>
                @endif
            </div>

            <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 sm:mt-1.5 group-hover:text-[#7ca81d] transition-colors">{{ $product->name }}</h3>

            <div class="flex items-center gap-1 mt-0.5 sm:mt-1">
                <p class="text-[9.5px] sm:text-[11px] text-[#9aa19c] truncate">{{ $product->category->name ?? '' }}</p>
                @if($product->store?->is_verified)
                    <i class="fa-solid fa-circle-check text-[10px] sm:text-[11px] text-[#659316] shrink-0" style=""></i>
                @endif
            </div>

            <div class="flex items-end justify-between gap-1 mt-2 sm:mt-2.5 pt-2 sm:pt-2.5 border-t border-[#f0f1f0]">
                <div class="min-w-0">
                    @if($product->old_price && $product->old_price > $product->price)
                        <p class="text-[9.5px] sm:text-[11px] text-[#f97316] line-through font-medium tnum truncate">{{ number_format($product->old_price) }} F</p>
                    @endif
                    <span class="inline-flex items-baseline gap-0.5 mt-0.5 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-6 bg-[#f2f9df] text-[#659316]">
                        <span class="skew-x-6 text-[12px] sm:text-[14px] font-black leading-tight tnum">{{ number_format($product->price) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F</span></span>
                    </span>
                </div>
                @if(($product->rating ?? 0) > 0)
                    <span class="inline-flex items-center gap-0.5 text-[9.5px] sm:text-[11px] font-extrabold text-[#5c625e] shrink-0">
                        <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                        {{ number_format($product->rating, 1) }}
                    </span>
                @endif
            </div>
        </div>
    </a>
</div>