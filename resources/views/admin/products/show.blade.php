<x-admin-layout>
    <x-slot name="header">Product Details</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Inventory
        </a>

        <div class="admin-card overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-64 h-64 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                        @if($product->mainImage)
                            <img src="{{ $product->mainImage->url }}" class="w-full h-full object-cover">
                        @elseif($product->images->first())
                            <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="image" class="w-12 h-12"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 space-y-4">
                        <div>
                            <h1 class="text-xl font-bold text-navy-800">{{ $product->name }}</h1>
                            <p class="text-xs text-slate-400 mt-1">SKU: {{ $product->sku ?? 'N/A' }} | Slug: {{ $product->slug }}</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $product->approval_status === 'approved' ? 'bg-emerald-50 text-emerald-600' : ($product->approval_status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600') }}">
                                {{ ucfirst($product->approval_status ?? 'pending') }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $product->stock_status === 'in_stock' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                                {{ $product->stock_status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}
                            </span>
                            @if($product->is_featured)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-600">Featured</span>
                            @endif
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Price</p>
                                <p class="text-lg font-bold text-navy-800">XAF {{ number_format($product->price) }}</p>
                                @if($product->old_price)
                                    <p class="text-xs text-slate-400 line-through">XAF {{ number_format($product->old_price) }}</p>
                                @endif
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Store</p>
                                <p class="text-sm font-bold text-navy-800">{{ $product->store->name }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Category</p>
                                <p class="text-sm font-bold text-navy-800">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>
                        @if($product->description)
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Description</p>
                                <p class="text-sm text-slate-600">{{ $product->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            @if($product->approval_status !== 'approved')
                <form action="{{ route('admin.products.approve', $product) }}" method="POST">
                    @csrf
                    <button class="px-6 py-2.5 bg-emerald-500 text-white rounded-lg text-xs font-bold hover:bg-emerald-600 transition-all">Approve Listing</button>
                </form>
            @endif
            <form action="{{ route('admin.products.feature', $product) }}" method="POST">
                @csrf
                <button class="px-6 py-2.5 {{ $product->is_featured ? 'bg-purple-500' : 'bg-navy-800' }} text-white rounded-lg text-xs font-bold hover:opacity-90 transition-all">
                    {{ $product->is_featured ? 'Remove Featured' : 'Mark as Featured' }}
                </button>
            </form>
            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="px-6 py-2.5 bg-slate-100 text-navy-800 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">View on Site</a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')">
                @csrf
                @method('DELETE')
                <button class="px-6 py-2.5 bg-rose-500 text-white rounded-lg text-xs font-bold hover:bg-rose-600 transition-all">Delete</button>
            </form>
        </div>

        @if($product->reviews->count() > 0)
            <div class="admin-card p-6">
                <h3 class="text-sm font-bold text-navy-800 mb-4">Reviews ({{ $product->reviews->count() }})</h3>
                <div class="space-y-3">
                    @foreach($product->reviews as $review)
                        <div class="p-3 bg-slate-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-bold text-navy-800">{{ $review->user->name }}</p>
                                <span class="text-[10px] text-slate-400">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <p class="text-xs text-slate-600 mt-1">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
