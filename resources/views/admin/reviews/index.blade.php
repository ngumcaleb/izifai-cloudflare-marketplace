<x-admin-layout>
    <x-slot name="header">Review Moderation</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Review <span class="text-gold-400">Moderation</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Manage and moderate all product, service, and store reviews across the platform.
            </p>
        </div>
    </div>

    <div x-data="{ tab: '{{ request('tab', 'products') }}' }" class="space-y-6">
        <div class="admin-card p-2 flex gap-1">
            <button @click="tab = 'products'" :class="tab === 'products' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:text-navy-800'" class="flex-1 py-2.5 rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all">Product Reviews</button>
            <button @click="tab = 'services'" :class="tab === 'services' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:text-navy-800'" class="flex-1 py-2.5 rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all">Service Reviews</button>
            <button @click="tab = 'stores'" :class="tab === 'stores' ? 'bg-navy-800 text-white' : 'text-slate-500 hover:text-navy-800'" class="flex-1 py-2.5 rounded-lg text-[11px] font-bold uppercase tracking-wider transition-all">Store Reviews</button>
        </div>

        <!-- Filter Bar -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search reviewer, content, or item..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="rating" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Ratings</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <input type="hidden" name="tab" x-bind:value="tab">
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">Filter</button>
                        @if(request()->anyFilled(['search', 'rating', 'date_from', 'date_to', 'per_page']))
                            <a href="{{ route('admin.reviews.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- Product Reviews --}}
        <div x-show="tab === 'products'" class="admin-card overflow-hidden">
            <div class="p-4 border-b border-slate-50">
                <h3 class="text-sm font-bold text-navy-800">Product Reviews ({{ $productReviews->total() }})</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($productReviews as $review)
                    <div class="p-4 flex items-start justify-between gap-4 hover:bg-slate-50/30 transition-colors">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-navy-800">{{ $review->user->name }}</span>
                                <span class="text-[9px] text-slate-400">on</span>
                                <span class="text-xs font-bold text-navy-800">{{ $review->product->name }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1">{{ $review->comment }}</p>
                            <p class="text-[9px] text-slate-400 mt-1">{{ $review->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <form action="{{ route('admin.reviews.product.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review permanently?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-10 text-center text-slate-400 italic text-xs">No product reviews.</div>
                @endforelse
            </div>
            @if($productReviews->hasPages())
                <div class="p-4 border-t border-slate-50">{{ $productReviews->appends(request()->query())->links('partials.pagination') }}</div>
            @endif
        </div>

        {{-- Service Reviews --}}
        <div x-show="tab === 'services'" class="admin-card overflow-hidden">
            <div class="p-4 border-b border-slate-50">
                <h3 class="text-sm font-bold text-navy-800">Service Reviews ({{ $serviceReviews->total() }})</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($serviceReviews as $review)
                    <div class="p-4 flex items-start justify-between gap-4 hover:bg-slate-50/30 transition-colors">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-navy-800">{{ $review->user->name }}</span>
                                <span class="text-[9px] text-slate-400">on</span>
                                <span class="text-xs font-bold text-navy-800">{{ $review->service->name }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1">{{ $review->comment }}</p>
                            <p class="text-[9px] text-slate-400 mt-1">{{ $review->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <form action="{{ route('admin.reviews.service.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review permanently?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-10 text-center text-slate-400 italic text-xs">No service reviews.</div>
                @endforelse
            </div>
            @if($serviceReviews->hasPages())
                <div class="p-4 border-t border-slate-50">{{ $serviceReviews->appends(request()->query())->links('partials.pagination') }}</div>
            @endif
        </div>

        {{-- Store Reviews --}}
        <div x-show="tab === 'stores'" class="admin-card overflow-hidden">
            <div class="p-4 border-b border-slate-50">
                <h3 class="text-sm font-bold text-navy-800">Store Reviews ({{ $storeReviews->total() }})</h3>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($storeReviews as $review)
                    <div class="p-4 flex items-start justify-between gap-4 hover:bg-slate-50/30 transition-colors">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-navy-800">{{ $review->user->name }}</span>
                                <span class="text-[9px] text-slate-400">on</span>
                                <span class="text-xs font-bold text-navy-800">{{ $review->store->name }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1">{{ $review->comment }}</p>
                            <p class="text-[9px] text-slate-400 mt-1">{{ $review->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <form action="{{ route('admin.reviews.store.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review permanently?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-10 text-center text-slate-400 italic text-xs">No store reviews.</div>
                @endforelse
            </div>
            @if($storeReviews->hasPages())
                <div class="p-4 border-t border-slate-50">{{ $storeReviews->appends(request()->query())->links('partials.pagination') }}</div>
            @endif
        </div>
    </div>
</x-admin-layout>
