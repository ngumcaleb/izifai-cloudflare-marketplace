{{-- Responsive product list: card-style on mobile, compact list on desktop --}}
<div class="space-y-2 md:hidden">
    @forelse($products as $product)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100/80 p-3 space-y-2.5">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                    @if($product->images->first())
                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <span class="material-symbols-outlined text-[18px]">image</span>
                        </div>
                    @endif
                </div>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-bold text-gray-900 truncate leading-tight">{{ $product->name }}</h4>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="text-[10px] font-semibold text-gray-400 uppercase">{{ $product->category->name ?? 'General' }}</span>
                        <span class="text-[10px] text-gray-300">•</span>
                        <span class="text-[10px] font-bold text-gray-800">{{ number_format($product->price) }} XAF</span>
                    </div>
                </div>
                <span class="shrink-0 inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[8px] font-bold uppercase tracking-wider {{ $product->stock_status === 'in_stock' ? 'bg-primary/5 text-primary' : 'bg-red-50 text-red-600' }}">
                    {{ $product->stock_status === 'in_stock' ? 'Active' : ($product->stock_status === 'out_of_stock' ? 'Sold' : 'Request') }}
                </span>
            </div>
            <div class="flex items-center gap-2 pt-1.5 border-t border-gray-100">
                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                   class="flex-1 flex items-center justify-center gap-1 py-2 text-gray-500 hover:text-primary hover:bg-gray-50 rounded-lg transition-all text-[11px] font-semibold">
                    <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                    View
                </a>
                <a href="{{ route('seller.products.edit', $product->id) }}"
                   class="flex-1 flex items-center justify-center gap-1 py-2 text-gray-500 hover:text-primary hover:bg-gray-50 rounded-lg transition-all text-[11px] font-semibold">
                    <span class="material-symbols-outlined text-[14px]">edit</span>
                    Edit
                </a>
                <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="w-full flex items-center justify-center gap-1 py-2 text-red-600 hover:bg-red-50 rounded-lg transition-all text-[11px] font-semibold">
                        <span class="material-symbols-outlined text-[14px]">delete</span>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-100/80 p-6 text-center">
            <div class="w-10 h-10 rounded-lg bg-gray-50 flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-2xl text-gray-300">inventory_2</span>
            </div>
            <p class="text-sm font-bold text-gray-900">No products found</p>
            <p class="text-xs text-gray-500 mt-0.5">This collection is empty.</p>
            <a href="{{ route('seller.products.create', request('collection') ? ['collection' => request('collection')] : []) }}" class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-primary text-white rounded-lg text-xs font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Add Product
            </a>
        </div>
    @endforelse
</div>

<div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100/80 divide-y divide-gray-50">
    @forelse($products as $product)
        <div class="px-5 py-3.5 flex items-center gap-4 hover:bg-gray-50/50 transition-all relative" x-data="{ open: false }">
            <div class="flex-1 min-w-0 flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                    @if($product->images->first())
                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <span class="material-symbols-outlined text-[18px]">image</span>
                        </div>
                    @endif
                </div>
                <div class="min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 truncate leading-tight mb-0.5">{{ $product->name }}</h4>
                    <div class="flex items-center gap-2">
                        <span class="text-[11px] font-semibold text-gray-400 uppercase">{{ $product->category->name ?? 'General' }}</span>
                        <span class="text-[11px] text-gray-300">•</span>
                        <span class="text-[11px] font-bold text-gray-800">{{ number_format($product->price) }} XAF</span>
                        @if($product->old_price)
                            <span class="text-[10px] text-gray-400 line-through">{{ number_format($product->old_price) }} XAF</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="w-20 text-center shrink-0">
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider {{ $product->stock_status === 'in_stock' ? 'bg-primary/5 text-primary' : 'bg-red-50 text-red-600' }}">
                    <span class="material-symbols-outlined text-[10px]">{{ $product->stock_status === 'in_stock' ? 'check_circle' : 'cancel' }}</span>
                    {{ $product->stock_status === 'in_stock' ? 'Active' : ($product->stock_status === 'out_of_stock' ? 'Sold' : 'Request') }}
                </span>
            </div>
            <div class="w-10 text-center shrink-0 relative">
                <button @click="open = !open" @click.outside="open = false"
                        class="p-1.5 text-gray-400 hover:text-primary hover:bg-gray-50 rounded-lg transition-all">
                    <span class="material-symbols-outlined text-[18px]">more_vert</span>
                </button>
                <div x-show="open" x-cloak @click.outside="open = false"
                     class="absolute right-0 top-9 w-44 bg-white rounded-xl shadow-lg border border-gray-100 z-50 overflow-hidden"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95">
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                        View Public Page
                    </a>
                    <a href="{{ route('seller.products.edit', $product->id) }}"
                       class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-600 hover:bg-gray-50 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Listing
                    </a>
                    <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this listing?')">
                        @csrf @method('DELETE')
                        <button class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                            Delete Listing
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="px-5 py-16 text-center">
            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                <span class="material-symbols-outlined text-3xl text-gray-300">inventory_2</span>
            </div>
            <p class="text-base font-bold text-gray-900">No products found</p>
            <p class="text-sm text-gray-500 mt-1">This collection is empty.</p>
            <a href="{{ route('seller.products.create', request('collection') ? ['collection' => request('collection')] : []) }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Add Product
            </a>
        </div>
    @endforelse
</div>
