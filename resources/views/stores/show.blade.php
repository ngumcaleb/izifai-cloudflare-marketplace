<x-app-layout>
    @php 
        $avgRating = $reviews->avg('rating') ?: 5; 
        $totalProducts = $products->count();
    @endphp
    
    <main class="bg-white min-h-screen font-sans antialiased pb-20" x-data="{ activeTab: 'all' }">
        
        <!-- 1. Mini Website Header -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 py-3">
            <div class="max-w-[1400px] mx-auto px-4 md:px-6 flex items-center justify-between">
                <a href="{{ route('stores.show', $store->slug) }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center overflow-hidden border border-slate-100 group-hover:border-green-600 transition-colors">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-[10px] font-black text-slate-300 uppercase">{{ substr($store->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <span class="text-xs font-black text-[#0A1D37] uppercase tracking-widest group-hover:text-green-600 transition-colors">{{ $store->name }}</span>
                </a>
                
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp_number) }}" target="_blank"
                   class="bg-[#0A1D37] text-white px-4 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest hover:bg-green-600 transition-all shadow-md active:scale-95">
                    Send Message
                </a>
            </div>
        </nav>

        <!-- 2. Business Hero -->
        <section class="relative py-16 md:py-24 bg-slate-50 overflow-hidden">
            <div class="absolute inset-0 opacity-40">
                <div class="absolute inset-0 bg-gradient-to-br from-green-50/50 via-transparent to-slate-100/50"></div>
            </div>
            
            <div class="max-w-[1400px] mx-auto px-4 md:px-6 relative z-10">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 bg-white px-3 py-1.5 rounded-full border border-slate-100 shadow-sm mb-6">
                        <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Verified Business Partner</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-7xl font-black text-[#0A1D37] tracking-tight leading-[0.9] mb-8 uppercase">
                        {{ $store->name }}
                    </h1>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Catalog</div>
                            <div class="text-xl font-black text-[#0A1D37]">{{ $totalProducts }} <span class="text-[10px] opacity-40">Items</span></div>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Reviews</div>
                            <div class="text-xl font-black text-[#0A1D37]">{{ number_format($avgRating, 1) }} <span class="text-[10px] opacity-40">Score</span></div>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Location</div>
                            <div class="text-xl font-black text-[#0A1D37] truncate">{{ $store->location ?? 'Cameroon' }}</div>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
                            <div class="text-[10px] font-black text-slate-300 uppercase tracking-widest mb-1">Joined</div>
                            <div class="text-xl font-black text-[#0A1D37]">{{ $store->created_at->format('Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. About Section -->
        <section class="max-w-[1400px] mx-auto px-4 md:px-6 py-16 border-b border-slate-100">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
                <div class="md:col-span-4 flex justify-center md:justify-start">
                    <div class="w-48 h-48 md:w-64 md:h-64 rounded-[3rem] bg-slate-50 p-2 overflow-hidden border-2 border-slate-100 shadow-xl">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover rounded-[2.5rem]">
                        @else
                            <div class="w-full h-full bg-white flex items-center justify-center rounded-[2.5rem]">
                                <span class="text-7xl font-black text-slate-100 uppercase">{{ substr($store->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="md:col-span-8 space-y-6 text-center md:text-left">
                    <h2 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.4em] flex items-center justify-center md:justify-start gap-4">
                        <span class="w-10 h-[2px] bg-green-600"></span>
                        About the business
                    </h2>
                    <p class="text-slate-500 text-lg md:text-2xl font-medium leading-relaxed italic">
                        {{ $store->description ?? 'Discover our curated collection of high-quality products.' }}
                    </p>
                    <div class="pt-4 flex flex-wrap justify-center md:justify-start gap-4">
                        <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full border border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Wholesale Pricing
                        </div>
                        <div class="flex items-center gap-2 bg-slate-50 px-4 py-2 rounded-full border border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Quality Checked
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Category Tabs & Product Grid -->
        <section class="max-w-[1400px] mx-auto px-4 md:px-6 py-16">
            <div class="flex flex-col items-center mb-12">
                <h2 class="text-[12px] font-black text-slate-900 uppercase tracking-[0.4em] mb-8">Collections Catalog</h2>
                
                <!-- Horizontal Tabs -->
                <div class="flex overflow-x-auto no-scrollbar gap-2 bg-slate-50 p-1.5 rounded-2xl border border-slate-100 max-w-full">
                    <button @click="activeTab = 'all'" 
                            :class="activeTab === 'all' ? 'bg-[#0A1D37] text-white shadow-lg' : 'text-slate-500 hover:text-[#0A1D37]'"
                            class="whitespace-nowrap px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-300">
                        All Items
                    </button>
                    @foreach($categories as $category)
                        <button @click="activeTab = 'cat-{{ $category->id }}'" 
                                :class="activeTab === 'cat-{{ $category->id }}' ? 'bg-[#0A1D37] text-white shadow-lg' : 'text-slate-500 hover:text-[#0A1D37]'"
                                class="whitespace-nowrap px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-wider transition-all duration-300">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Products Showcase -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-8">
                @foreach($products as $product)
                    <div x-show="activeTab === 'all' || activeTab === 'cat-{{ $product->category_id }}'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-90"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="group flex flex-col h-full bg-white rounded-[2rem] border border-slate-100 p-2 hover:shadow-2xl hover:border-green-600/20 transition-all duration-500">
                        
                        <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-square overflow-hidden rounded-[1.8rem] bg-slate-50">
                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            
                            @if($product->old_price && $product->old_price > $product->price)
                                <div class="absolute top-4 right-4 bg-red-500 text-white text-[8px] font-black px-2 py-1 rounded shadow-lg uppercase tracking-widest">
                                    Special
                                </div>
                            @endif
                        </a>
                        
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-xs font-black text-[#0A1D37] line-clamp-1 group-hover:text-green-600 transition-colors mb-2 uppercase tracking-tight">
                                {{ $product->name }}
                            </h3>
                            <div class="mt-auto pt-3 border-t border-slate-50 flex items-center justify-between">
                                <span class="text-sm font-black text-[#0A1D37]">{{ number_format($product->price) }} <span class="text-[8px] text-slate-400">XAF</span></span>
                                <div class="w-6 h-6 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-all">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 5. Footer CTA (Mini Website Style) -->
        <section class="max-w-[1400px] mx-auto px-4 md:px-6 mt-20">
            <div class="bg-[#0A1D37] rounded-[3rem] p-12 text-center text-white overflow-hidden relative group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-green-600/10 rounded-full blur-3xl -mr-32 -mt-32"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-black mb-4 uppercase tracking-tight">Ready to order?</h2>
                    <p class="text-slate-400 mb-8 max-w-sm mx-auto text-sm">Connect with {{ $store->name }} directly on WhatsApp for orders, custom pricing, and quick inquiries.</p>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp_number) }}" target="_blank"
                       class="inline-flex items-center gap-4 bg-white text-[#0A1D37] px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-green-600 hover:text-white transition-all shadow-xl active:scale-95">
                        Chat with Merchant
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>