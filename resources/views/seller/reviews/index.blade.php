<x-seller-layout>
    <x-slot name="title">Customer Reviews</x-slot>

    <div class="space-y-4 md:space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-headline-md md:text-headline-lg text-on-surface tracking-tight">Customer Reviews</h2>
                <p class="font-label-sm text-on-surface-variant mt-1">What customers are saying about your store</p>
            </div>
        </div>

        <!-- Rating Summary -->
        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)]">
            <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-8">
                <div class="text-center">
                    <p class="text-4xl md:text-5xl font-black text-on-surface">{{ number_format($avgRating, 1) }}</p>
                    <div class="flex items-center gap-0.5 mt-1 justify-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'text-orange-500' : 'text-on-surface-variant/20' }}" style="font-size: 12px;"></i>
                        @endfor
                    </div>
                    <p class="text-label-sm text-on-surface-variant mt-1">{{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
                </div>
                <div class="flex-1 w-full space-y-1.5 max-w-xs">
                    @for($i = 5; $i >= 1; $i--)
                        @php $pct = ($starDistribution[$i]['percentage'] ?? 0); @endphp
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 font-bold text-on-surface-variant">{{ $i }}</span>
                            <div class="flex-1 h-2 bg-surface-container-high rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-8 text-right text-label-sm text-on-surface-variant">{{ $starDistribution[$i]['count'] ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] divide-y divide-outline-variant/20">
            @forelse($reviews as $review)
                <div class="p-4 md:p-xl">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-primary/10 flex items-center justify-center text-sm font-black text-primary shrink-0">
                            {{ substr($review->user->name ?? '?', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                <p class="font-label-md md:font-label-lg text-on-surface truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-orange-500' : 'text-on-surface-variant/15' }}" style="font-size: 10px;"></i>
                                    @endfor
                                </div>
                                <span class="text-label-sm text-on-surface-variant sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-body-md text-on-surface-variant mt-2 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 md:p-xl text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">reviews</span>
                    <p class="text-headline-md text-on-surface-variant mt-3">No reviews yet</p>
                    <p class="text-body-md text-on-surface-variant/60 mt-1">Reviews from customers will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>
