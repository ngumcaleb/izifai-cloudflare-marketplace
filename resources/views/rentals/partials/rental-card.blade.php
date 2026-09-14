@props(['item'])

<div class="group relative w-full min-w-0 bg-white overflow-hidden border border-black/[0.07] rounded-xl hover:shadow-[0_18px_44px_-14px_rgba(20,27,11,0.18)] hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
    {{-- Animated Lime Top Line on Hover --}}
    <span class="absolute top-0 left-0 right-0 h-[3px] z-20 bg-gradient-to-r from-[#9acd32] via-[#86b92c] to-transparent origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>

    <a href="{{ route('rentals.show', $item->slug) }}" class="block flex-1 flex flex-col justify-between">
        {{-- Image Aspect Square --}}
        <div class="relative aspect-square overflow-hidden bg-[#f6f6f6]">
            @if($item->main_image_url)
                <img src="{{ $item->main_image_url }}"
                     alt="{{ $item->name }}" loading="lazy"
                     class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-[1.05]"
                     onerror="this.parentElement.innerHTML = '<div class=\'w-full h-full grid place-items-center text-[#9aa19c]/30\'><span class=\'fa-solid fa-boxes-stacked text-4xl sm:text-5xl\'></i></div>'">
            @else
                <div class="w-full h-full grid place-items-center text-[#9aa19c]/30">
                    <i class="fa-solid fa-boxes-stacked text-4xl sm:text-5xl"></i>
                </div>
            @endif

            {{-- Category Badge (Top-Left) --}}
            <span class="absolute top-2 sm:top-3 left-2 sm:left-3 z-20 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-12 bg-white/95 text-[#3f453f] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-[0.08em] sm:tracking-[0.12em] shadow-sm">
                {{ $item->category->name ?? 'Equipment' }}
            </span>

            {{-- Billing Period Badge (Top-Right) --}}
            <span class="absolute top-2 sm:top-3 right-2 sm:right-3 z-20 px-1.5 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-12 bg-[#1c201e] text-[#9acd32] text-[8px] sm:text-[9px] font-extrabold uppercase tracking-[0.08em] sm:tracking-[0.12em] shadow-md">
                /{{ $item->billing_unit ?? 'day' }}
            </span>

            {{-- Location Badge (Bottom-Left) --}}
            @if($item->location)
                <span class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3 z-20 px-1.5 sm:px-2 py-0.5 rounded-md bg-[#1c201e]/80 text-white text-[8.5px] sm:text-[9px] font-bold backdrop-blur-sm flex items-center gap-0.5 shadow-sm max-w-[75%] truncate">
                    <i class="fa-solid fa-location-dot text-[10px] sm:text-[11px] text-[#9acd32]" style=""></i>
                    <span class="truncate">{{ $item->location }}</span>
                </span>
            @endif
        </div>

        {{-- Details Body --}}
        <div class="p-2.5 sm:p-3.5 flex flex-col flex-1 justify-between">
            <div>
                {{-- Store Line --}}
                <div class="flex items-center justify-between gap-1.5">
                    <p class="text-[8.5px] sm:text-[10px] font-semibold uppercase tracking-[0.08em] sm:tracking-[0.12em] text-[#9aa19c] truncate">
                        {{ $item->store->name ?? 'Verified Fleet' }}
                    </p>
                    @if($item->store?->is_verified)
                        <i class="fa-solid fa-circle-check text-[10px] sm:text-[12px] text-[#659316] shrink-0" style=""></i>
                    @endif
                </div>

                {{-- Rental Title --}}
                <h3 class="text-[11px] sm:text-[13px] font-bold text-[#1c201e] leading-snug line-clamp-2 mt-1 sm:mt-1.5 group-hover:text-[#7ca81d] transition-colors">
                    {{ $item->name }}
                </h3>

                {{-- Deposit Chip --}}
                <div class="mt-1 sm:mt-1.5 flex items-center gap-1.5">
                    @if($item->deposit > 0)
                        <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] font-bold text-[#92400e]">
                            <i class="fa-solid fa-shield-halved text-[10px] sm:text-[12px] text-amber-600"></i>
                            Dep: {{ number_format($item->deposit) }} F
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold text-[#659316]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32] inline-block"></span>
                            Zero Deposit
                        </span>
                    @endif
                </div>
            </div>

            {{-- Bottom Price & Rating Bar --}}
            <div class="flex items-end justify-between gap-2 mt-2 sm:mt-2.5 pt-2 sm:pt-2.5 border-t border-[#f0f1f0]">
                <div>
                    <span class="inline-flex items-baseline gap-1 mt-0.5 px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-md -skew-x-6 bg-[#f2f9df] text-[#659316]">
                        <span class="skew-x-6 text-[12px] sm:text-[14px] font-black leading-tight tnum">
                            {{ number_format($item->rate) }} <span class="text-[8.5px] sm:text-[10px] font-bold">F/{{ substr($item->billing_unit ?? 'day', 0, 1) }}</span>
                        </span>
                    </span>
                </div>

                @if(($item->rating ?? 0) > 0)
                    <span class="inline-flex items-center gap-0.5 text-[9.5px] sm:text-[11px] font-extrabold text-[#5c625e] shrink-0">
                        <i class="fa-solid fa-star text-[11px] sm:text-[13px] text-amber-400" style=""></i>
                        {{ number_format($item->rating, 1) }}
                    </span>
                @elseif($item->views > 0)
                    <span class="inline-flex items-center gap-0.5 text-[9px] sm:text-[10px] text-[#9aa19c] shrink-0">
                        <i class="fa-solid fa-eye text-[10px] sm:text-[12px]"></i>
                        {{ number_format($item->views) }}
                    </span>
                @endif
            </div>
        </div>
    </a>
</div>