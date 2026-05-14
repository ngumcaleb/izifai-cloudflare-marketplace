<x-seller-layout>
    <x-slot name="title">Customer Reviews</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Customer Reviews</h1>
                <p class="text-sm text-gray-500 mt-0.5">What customers are saying about your store</p>
            </div>
        </div>

        <!-- Rating Summary -->
        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80">
            <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-8">
                <div class="text-center">
                    <p class="text-4xl md:text-5xl font-black text-gray-900">{{ number_format($avgRating, 1) }}</p>
                    <div class="flex items-center gap-0.5 mt-1 justify-center">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa-solid fa-star {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}" style="font-size: 12px;"></i>
                        @endfor
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $totalReviews }} review{{ $totalReviews !== 1 ? 's' : '' }}</p>
                </div>
                <div class="flex-1 w-full space-y-1.5 max-w-xs">
                    @for($i = 5; $i >= 1; $i--)
                        @php $pct = ($starDistribution[$i]['percentage'] ?? 0); @endphp
                        <div class="flex items-center gap-2 text-xs">
                            <span class="w-3 font-bold text-gray-500">{{ $i }}</span>
                            <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-amber-400 rounded-full" style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="w-8 text-right text-xs text-gray-500">{{ $starDistribution[$i]['count'] ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 divide-y divide-gray-100">
            @forelse($reviews as $review)
                <div class="p-4 md:p-6">
                    <div class="flex items-start gap-3 md:gap-4">
                        <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-primary/5 flex items-center justify-center text-sm font-black text-primary shrink-0 ring-1 ring-primary/10">
                            {{ substr($review->user->name ?? '?', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $review->user->name ?? 'Anonymous' }}</p>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" style="font-size: 10px;"></i>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-400 sm:ml-auto">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 md:p-6 text-center">
                    <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                        <span class="material-symbols-outlined text-3xl text-gray-300">reviews</span>
                    </div>
                    <p class="text-base font-bold text-gray-900">No reviews yet</p>
                    <p class="text-sm text-gray-500 mt-1">Reviews from customers will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</x-seller-layout>