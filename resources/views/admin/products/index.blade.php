<x-admin-layout>
    <x-slot name="header">Inventory Management</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/fashion-shoes-sneakers_1203-7529.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Global <span class="text-gold-400">Inventory</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Monitor all product listings, manage featured status, and track stock levels across the platform.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Search & Filter Area -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search products, brands, or sellers..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                </div>
                <div class="flex gap-2">
                    <select name="featured" class="px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                        <option value="">Status</option>
                        <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured</option>
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm grow md:grow-0">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Products List -->
        <div class="admin-card overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Product</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Merchant</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Pricing</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                                        @if($product->mainImage)
                                            <img src="{{ asset('storage/' . $product->mainImage->path) }}" class="w-full h-full object-cover">
                                        @elseif($product->images->first())
                                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <i data-lucide="image" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $product->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium truncate">{{ $product->category->name ?? 'Inventory' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-[12px] font-medium text-slate-600">
                                <div class="flex flex-col">
                                    <span class="font-bold text-navy-800 leading-none">{{ $product->store->name }}</span>
                                    <span class="text-[9px] text-slate-400 mt-1 uppercase">{{ $product->store->location ?? 'Cameroon' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-navy-800 leading-none">XAF {{ number_format($product->price) }}</span>
                                    @if($product->old_price)
                                        <span class="text-[9px] text-slate-400 line-through mt-1">XAF {{ number_format($product->old_price) }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    @if($product->is_featured)
                                        <span class="inline-flex items-center w-fit px-2 py-0.5 bg-purple-50 text-purple-600 text-[8px] font-bold uppercase rounded">Featured</span>
                                    @endif
                                    <span class="inline-flex items-center w-fit px-2 py-0.5 {{ $product->stock_status === 'instock' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} text-[8px] font-bold uppercase rounded">
                                        {{ $product->stock_status === 'instock' ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <span class="p-2 bg-slate-50 text-slate-300 rounded-lg inline-flex">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </span>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No products found in inventory.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List (Cards) -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($products as $product)
                <div class="p-4 flex items-center gap-4 hover:bg-slate-50 transition-colors">
                    <div class="w-16 h-16 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-50 shadow-sm">
                        @if($product->mainImage)
                            <img src="{{ asset('storage/' . $product->mainImage->path) }}" class="w-full h-full object-cover">
                        @elseif($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="image" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between">
                            <h4 class="text-[13px] font-bold text-navy-800 truncate leading-tight">{{ $product->name }}</h4>
                            <span class="text-[10px] font-bold text-navy-800 whitespace-nowrap ml-2">XAF {{ number_format($product->price) }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate mt-0.5">{{ $product->store->name }}</p>
                        <div class="flex gap-1.5 mt-1.5">
                            @if($product->is_featured)
                                <span class="px-1.5 py-0.5 bg-purple-50 text-purple-600 text-[7px] font-bold uppercase rounded">Featured</span>
                            @endif
                            <span class="px-1.5 py-0.5 {{ $product->stock_status === 'instock' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} text-[7px] font-bold uppercase rounded">
                                {{ $product->stock_status === 'instock' ? 'In Stock' : 'Out' }}
                            </span>
                        </div>
                    </div>
                    <span class="p-2 bg-slate-50 text-slate-300 rounded-lg inline-flex">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </span>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">Inventory is empty.</div>
                @endforelse
            </div>
        </div>

        @if($products->hasPages())
        <div class="mt-4">
            {{ $products->links('partials.pagination') }}
        </div>
        @endif
    </div>
</x-admin-layout>
