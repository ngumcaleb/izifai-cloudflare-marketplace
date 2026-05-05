<x-app-layout>
    <div class="bg-slate-50 min-h-screen pb-20">
        <!-- Bento Hero Header - Ultra Minimal Border Radius -->
        <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-2 md:py-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 md:gap-4 h-auto">
                
                <!-- Main Category Card -->
                <div class="lg:col-span-8 relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group h-[180px] lg:min-h-[320px]">
                    <img src="{{ $randomProductImages->count() > 0 ? asset('storage/' . $randomProductImages[0]->path) : ($category->image_path ? asset('storage/' . $category->image_path) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=1200') }}" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/80 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37]/90 lg:from-transparent to-transparent"></div>
                    
                    <div class="relative z-10 h-full p-4 lg:p-8 flex flex-col justify-center">
                        <div class="inline-block bg-green-600 text-white text-[8px] lg:text-[9px] font-bold px-2.5 lg:px-3.5 py-1 lg:py-1.5 rounded transform -skew-x-12 uppercase tracking-widest mb-2 lg:mb-4 w-fit shadow-md">
                            Browsing Category
                        </div>
                        
                        <h1 class="text-xl lg:text-5xl font-black text-white tracking-tight mb-2 lg:mb-3 leading-tight lg:leading-none">
                            {{ $category->name }}
                        </h1>
                        
                        <!-- Visible on Mobile now -->
                        <p class="text-[9px] lg:text-[14px] text-slate-300 font-medium leading-relaxed max-w-[240px] lg:max-w-lg mb-4 lg:mb-6 line-clamp-2 lg:line-clamp-none">
                            Discover the best deals and verified suppliers in the <span class="text-white font-bold">{{ $category->name }}</span> industry across Cameroon.
                        </p>

                        <!-- Trust Stack -->
                        <div class="flex items-center gap-2 lg:gap-3">
                            <div class="flex -space-x-1.5 lg:-space-x-2">
                                @foreach($randomProductImages->slice(1, 4) as $image)
                                    <img class="w-5 h-5 lg:w-9 lg:h-9 rounded-full border border-[#0A1D37] object-cover shadow-sm" src="{{ asset('storage/' . $image->path) }}" alt="">
                                @endforeach
                                <div class="w-5 h-5 lg:w-9 lg:h-9 rounded-full border border-[#0A1D37] bg-slate-800 flex items-center justify-center text-[5px] lg:text-[8px] font-bold text-white shadow-sm">+{{ $products->total() }}</div>
                            </div>
                            <div class="text-[6px] lg:text-[11px] text-slate-300 font-medium leading-tight">
                                <span class="text-white font-bold">{{ number_format($products->total()) }}</span><br> products available
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Card -->
                <div class="hidden lg:flex lg:col-span-4 flex-col gap-3 h-full">
                    <a href="{{ route('categories.index') }}" class="flex-1 relative bg-white rounded-xl overflow-hidden shadow-lg group block cursor-pointer border border-slate-100">
                        <div class="absolute inset-0 bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
                        <div class="relative z-10 h-full p-6 flex flex-col justify-end">
                            <div class="inline-block bg-green-600 text-white text-[7px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-2 w-fit">
                                Navigation
                            </div>
                            <h3 class="text-slate-900 font-bold text-lg leading-tight group-hover:-translate-y-1 transition-transform">
                                All <br> Categories
                            </h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Mobile Categories Filter (Horizontal Scroll) -->
        <div class="lg:hidden px-4 mb-4">
            <div class="flex overflow-x-auto no-scrollbar gap-2 -mx-4 px-4 pb-2">
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                       class="whitespace-nowrap px-4 py-2 rounded-full text-[10px] font-bold transition-all {{ $cat->id === $category->id ? 'bg-green-600 text-white shadow-md shadow-green-100' : 'bg-white text-slate-600 border border-slate-100' }}">
                        {{ $cat->name }}
                        <span class="ml-1 opacity-60 text-[8px]">({{ $cat->products_count }})</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="max-w-[1400px] mx-auto px-4 md:px-6 flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters (Desktop) -->
            <aside class="hidden lg:block w-72 shrink-0">
                <div class="bg-white rounded-xl border border-slate-100 p-6 sticky top-24 shadow-sm">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Industries</h3>
                        <span class="text-[8px] font-bold text-slate-400">{{ $categories->count() }}</span>
                    </div>
                    <div class="space-y-1.5">
                        @foreach($categories as $cat)
                            <a href="{{ route('categories.show', $cat->slug) }}"
                                class="flex items-center justify-between px-4 py-3 rounded-lg text-xs font-bold transition-all group {{ $cat->id === $category->id ? 'bg-green-600 text-white shadow-lg shadow-green-100' : 'text-slate-500 hover:bg-slate-50' }}">
                                <span class="flex items-center gap-3">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $cat->id === $category->id ? 'bg-white' : 'bg-slate-200 group-hover:bg-green-400' }}"></div>
                                    {{ $cat->name }}
                                </span>
                                <span class="text-[9px] {{ $cat->id === $category->id ? 'text-white/70' : 'text-slate-300' }} tracking-tighter">{{ number_format($cat->products_count) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="flex-1">
                <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-200">
                    <h2 class="text-[10px] md:text-[11px] font-black text-slate-900 uppercase tracking-[0.2em]">Active Listings</h2>
                    <div class="text-[8px] md:text-[9px] font-bold text-slate-400 uppercase tracking-widest">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-3 lg:gap-4">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg lg:rounded-xl border border-slate-100 p-2 hover:shadow-xl hover:border-green-600/20 transition-all group relative flex flex-col h-full"
                                x-data="{ isFavorited: {{ auth()->check() && auth()->user()->savedProducts->contains($product->id) ? 'true' : 'false' }}, favCount: {{ $product->savedUsers->count() }} }">
                                <a href="{{ route('products.show', $product->slug) }}" class="block mb-2">
                                    <div class="aspect-square rounded bg-slate-50 overflow-hidden relative">
                                        <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                        @if($product->store && $product->store->is_verified)
                                            <div class="absolute top-2 left-2 bg-white/90 backdrop-blur-sm px-2 py-0.5 rounded shadow-sm border border-green-100 flex items-center gap-1">
                                                <svg class="w-2 h-2 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                                <span class="text-[7px] font-black text-green-600 uppercase tracking-widest">Verified</span>
                                            </div>
                                        @endif

                                        <!-- Favorite Button -->
                                        <button @click.prevent="
                                            @auth
                                                fetch('{{ route('products.toggle-favorite', $product->id) }}', { 
                                                    method: 'POST', 
                                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } 
                                                })
                                                .then(res => res.json())
                                                .then(data => { isFavorited = data.favorited; favCount = data.count; })
                                            @else
                                                window.location = '{{ route('login') }}'
                                            @endauth
                                        " class="absolute top-2 right-2 w-6 h-6 rounded-full bg-white/90 shadow-md flex items-center justify-center transition-all hover:scale-110 active:scale-95 z-10">
                                            <svg class="w-3 h-3" :class="isFavorited ? 'fill-red-500 text-red-500' : 'text-slate-300'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                        </button>
                                    </div>
                                </a>
                                <div class="px-1 flex-1 flex flex-col">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block">
                                        <h3 class="text-[10px] font-semibold text-slate-700 mb-1 line-clamp-2 h-6 leading-tight group-hover:text-green-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                    </a>
                                    <div class="flex flex-wrap items-baseline gap-1.5 mb-2">
                                        <span class="text-[11px] font-bold text-slate-900 truncate">{{ number_format($product->price) }} XAF</span>
                                        @if($product->old_price && $product->old_price > $product->price)
                                            <span class="text-[9px] text-red-500 font-medium line-through opacity-80">{{ number_format($product->old_price) }} XAF</span>
                                        @endif
                                    </div>
                                    <div class="mt-auto pt-2 border-t border-slate-50 flex items-center justify-between">
                                        <a href="{{ route('stores.show', $product->store->slug) }}" class="flex items-center gap-1 truncate">
                                            <div class="w-2.5 h-2.5 bg-green-500 rounded-full flex items-center justify-center shrink-0">
                                                <svg class="w-1.5 h-1.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                            </div>
                                            <span class="text-[7px] font-black text-slate-400 uppercase tracking-tighter truncate">{{ $product->store->name }}</span>
                                        </a>
                                        <div class="flex items-center gap-0.5 text-[6px] font-bold text-slate-400 uppercase shrink-0">
                                            <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span>{{ $product->store->location ?? 'CMR' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12 flex justify-center">
                        <div class="bg-white rounded-lg border border-slate-100 p-2 shadow-sm inline-block">
                            {{ $products->links() }}
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-xl p-20 text-center border border-slate-100 shadow-sm mt-8">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900 mb-2">No items here yet</h2>
                        <p class="text-slate-500 font-medium mb-8 max-w-sm mx-auto">We couldn't find any products in this category. Explore other industries for better luck.</p>
                        <a href="{{ route('categories.index') }}" class="inline-block bg-[#0A1D37] text-white px-10 py-4 rounded-lg font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Back to Categories</a>
                    </div>
                @endif

                <!-- Related Businesses Discovery -->
                <div class="mt-16">
                    <x-featured-businesses title="Top Businesses in This Industry" limit="3" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>