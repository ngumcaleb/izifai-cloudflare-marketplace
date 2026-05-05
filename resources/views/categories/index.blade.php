<x-app-layout>
    <div class="bg-slate-50 min-h-screen pb-20">
        <!-- Bento Hero Header - Ultra Minimal Border Radius -->
        <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-2 md:py-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 md:gap-4 h-auto">
                
                <!-- Main Large Card -->
                <div class="lg:col-span-8 relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group h-[180px] lg:min-h-[320px]">
                    <img src="{{ $randomProductImages->count() > 0 ? asset('storage/' . $randomProductImages[0]->path) : 'https://img.freepik.com/free-photo/arrangement-black-friday-shopping-carts-with-copy-space_23-2148667047.jpg' }}" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/80 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37]/90 lg:from-transparent to-transparent"></div>
                    
                    <div class="relative z-10 h-full p-4 lg:p-8 flex flex-col justify-center">
                        <div class="inline-block bg-green-600 text-white text-[8px] lg:text-[9px] font-bold px-2.5 lg:px-3.5 py-1 lg:py-1.5 rounded transform -skew-x-12 uppercase tracking-widest mb-2 lg:mb-4 w-fit shadow-md">
                            Marketplace Directory
                        </div>
                        
                        <h1 class="text-xl lg:text-5xl font-black text-white tracking-tight mb-2 lg:mb-3 leading-tight lg:leading-none">
                            Browse <span class="text-green-500">Categories</span>
                        </h1>
                        
                        <!-- Visible on Mobile now -->
                        <p class="text-[9px] lg:text-[14px] text-slate-300 font-medium leading-relaxed max-w-[240px] lg:max-w-lg mb-4 lg:mb-6 line-clamp-2 lg:line-clamp-none">
                            Find exactly what you need by exploring our curated selection of industry-specific categories and verified local suppliers across Cameroon.
                        </p>

                        <!-- Trust Stack -->
                        <div class="flex items-center gap-2 lg:gap-3">
                            <div class="flex -space-x-1.5 lg:-space-x-2">
                                @foreach($randomProductImages->slice(1, 3) as $image)
                                    <img class="w-5 h-5 lg:w-9 lg:h-9 rounded-full border border-[#0A1D37] object-cover shadow-sm" src="{{ asset('storage/' . $image->path) }}" alt="">
                                @endforeach
                                <div class="w-5 h-5 lg:w-9 lg:h-9 rounded-full border border-[#0A1D37] bg-slate-800 flex items-center justify-center text-[5px] lg:text-[8px] font-bold text-white shadow-sm">+{{ $categories->sum('products_count') }}</div>
                            </div>
                            <div class="text-[6px] lg:text-[11px] text-slate-300 font-medium leading-tight">
                                Over <span class="text-white font-bold">{{ number_format($categories->sum('products_count')) }}+</span><br> active products
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Cards -->
                <div class="hidden lg:flex lg:col-span-4 flex-col gap-3 h-full">
                    <a href="{{ route('products.new-arrivals') }}" class="flex-1 relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group block cursor-pointer">
                        <img src="https://img.freepik.com/free-photo/front-view-young-woman-with-shopping-bags_23-2148684534.jpg" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="relative z-10 h-full p-5 flex flex-col justify-end">
                            <div class="inline-block bg-orange-500 text-white text-[7px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-1.5 w-fit">
                                Explore
                            </div>
                            <h3 class="text-white font-bold text-base leading-tight group-hover:-translate-y-1 transition-transform">
                                Newest <br> Arrivals
                            </h3>
                        </div>
                    </a>

                    <a href="{{ route('stores.index') }}" class="flex-1 relative bg-white rounded-xl overflow-hidden shadow-lg group block cursor-pointer border border-slate-100">
                        <div class="absolute inset-0 bg-gradient-to-br from-white via-slate-50 to-slate-100"></div>
                        <div class="relative z-10 h-full p-5 flex flex-col justify-end">
                            <div class="inline-block bg-green-600 text-white text-[7px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-1.5 w-fit">
                                Directory
                            </div>
                            <h3 class="text-slate-900 font-bold text-base leading-tight group-hover:-translate-y-1 transition-transform">
                                Verified <br> Wholesalers
                            </h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="max-w-[1400px] mx-auto px-4 md:px-6 mt-4 md:mt-8">
            <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-200">
                <h2 class="text-[10px] md:text-[11px] font-black text-slate-900 uppercase tracking-[0.2em]">Industries & Sectors</h2>
                <div class="text-[8px] md:text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $categories->count() }} Active Categories</div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 md:gap-4">
                @foreach($categories as $category)
                    @php
                        $categoryProduct = \App\Models\Product::where('category_id', $category->id)->has('images')->with('images')->first();
                        $bgImage = $categoryProduct ? asset('storage/' . $categoryProduct->images->first()->path) : 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=600';
                    @endphp
                    
                    <!-- rounded-lg for minimal feel -->
                    <a href="{{ route('categories.show', $category->slug) }}" class="group relative aspect-square rounded-lg lg:rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all block">
                        <!-- Background Image -->
                        <img src="{{ $bgImage }}" alt="{{ $category->name }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        
                        <!-- Content -->
                        <div class="absolute inset-0 p-4 flex flex-col justify-end">
                            <span class="text-[7px] md:text-[8px] font-bold text-green-400 uppercase tracking-widest mb-0.5">Industry</span>
                            <h3 class="text-white text-xs md:text-sm font-black tracking-tight leading-tight">
                                {{ $category->name }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($categories->isEmpty())
                <div class="bg-white rounded-xl p-20 text-center border border-slate-100 shadow-sm mt-12">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-2">No categories found</h2>
                    <p class="text-slate-500 font-medium mb-8 max-w-sm mx-auto">We're currently reorganizing our product catalog. Check back soon for new additions.</p>
                    <a href="{{ route('welcome') }}" class="inline-block bg-[#0A1D37] text-white px-10 py-4 rounded-lg font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Go Home</a>
                </div>
            @endif

            <!-- Business Discovery Section -->
            <div class="mt-20">
                <x-featured-businesses title="Recommended Suppliers" />
            </div>
        </div>
    </div>
</x-app-layout>