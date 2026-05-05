<x-app-layout>
    <main class="max-w-[1440px] mx-auto px-4 lg:px-8 py-8 space-y-20">

        <!-- 1. Super Clean Hero Section -->
        <section class="relative">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-auto lg:h-[480px]">
                <!-- Main Featured Card -->
                <div class="lg:col-span-8 relative bg-slate-900 rounded-[2.5rem] overflow-hidden group shadow-2xl shadow-slate-200">
                    <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?auto=format&fit=crop&q=80&w=2000"
                        class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-[2000ms]">
                    <div class="absolute inset-0 bg-gradient-to-tr from-slate-900 via-slate-900/40 to-transparent"></div>
                    
                    <div class="relative z-10 h-full p-8 lg:p-16 flex flex-col justify-center max-w-2xl">
                        <div class="inline-flex items-center gap-2 bg-green-600 text-white text-[9px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-8 w-fit shadow-xl shadow-green-600/20">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                            Cameroon's #1 Digital Marketplace
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-black text-white leading-[1.1] mb-8 tracking-tight">
                            The professional way <br/>to <span class="text-green-500 underline decoration-green-500/30 underline-offset-8">source products</span> <br/>in Cameroon.
                        </h1>
                        
                        <div class="flex flex-wrap items-center gap-6">
                            <a href="{{ route('products.new-arrivals') }}"
                                class="bg-white text-slate-900 px-10 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-white/10">
                                Browse Catalog
                            </a>
                            <a href="{{ route('register') }}"
                                class="text-white font-bold text-xs uppercase tracking-widest group flex items-center gap-2">
                                Start Selling <span class="group-hover:translate-x-2 transition-transform">&rarr;</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar Discovery -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    <div class="flex-1 relative bg-white border border-slate-100 rounded-[2.5rem] p-8 overflow-hidden group shadow-sm">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-green-600/5 rounded-full blur-3xl group-hover:bg-green-600/10 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04c-.243.39-.314.906-.314 1.414 0 6.666 4.721 12.23 11.089 13.914l.111.028.111-.028C19.279 19.584 24 14.02 24 7.354c0-.508-.071-1.024-.314-1.414z"></path></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-2">Verified Suppliers</h3>
                            <p class="text-sm text-slate-500 font-medium leading-relaxed mb-6">Discovery verified businesses and trusted wholesalers across all regions.</p>
                            <a href="{{ route('stores.index') }}" class="text-xs font-bold text-green-600 uppercase tracking-widest flex items-center gap-2 group/btn">
                                Explore Shops <span class="group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex-1 relative bg-slate-50 rounded-[2.5rem] p-8 border border-slate-100 group shadow-sm">
                        <div class="relative z-10">
                            <div class="flex items-center gap-4 mb-6">
                                <div class="flex -space-x-3">
                                    <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?u=1" alt="">
                                    <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?u=2" alt="">
                                    <img class="w-10 h-10 rounded-full border-2 border-white shadow-sm" src="https://i.pravatar.cc/100?u=3" alt="">
                                </div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Community Hub</div>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900 mb-4">Join 10,000+ Buyers</h3>
                            <p class="text-xs text-slate-500 font-semibold leading-relaxed">Experience a structured marketplace built for speed and trust.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Structured Category Navigation -->
        <section>
            <div class="flex items-end justify-between mb-10 px-2">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Browse Categories</h2>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-[0.2em]">Structured Catalog</p>
                </div>
                <a href="{{ route('categories.index') }}" class="text-xs font-bold text-green-600 hover:underline uppercase tracking-widest">See all categories &rarr;</a>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @php $cats = \App\Models\Category::has('products')->take(12)->get(); @endphp
                @foreach($cats as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                       class="group bg-white border border-slate-100 p-6 rounded-[2rem] flex flex-col items-center text-center hover:border-green-600/20 hover:shadow-2xl hover:shadow-green-600/5 transition-all duration-500">
                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-50 transition-colors">
                             <!-- Dynamic Icons could go here -->
                             <svg class="w-8 h-8 text-slate-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                        <span class="text-[11px] font-bold text-slate-900 uppercase tracking-widest group-hover:text-green-600 transition-colors">{{ $cat->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 3. Professional Product Listing Experience -->
        <section class="bg-white border border-slate-100 rounded-[3rem] p-8 lg:p-16 shadow-sm">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-12 gap-6">
                <div class="max-w-xl">
                    <div class="inline-block bg-green-50 text-green-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest mb-6">
                        Trending Now
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tighter mb-4">Discover what's hot in <span class="text-green-600">Cameroon.</span></h2>
                    <p class="text-lg text-slate-500 font-medium leading-relaxed">Browse the most viewed products across our verified sellers ecosystem.</p>
                </div>
                <a href="{{ route('products.new-arrivals') }}" class="btn-primary px-10 py-4 rounded-2xl font-bold text-xs uppercase tracking-widest">Shop All Items</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @php $featured = \App\Models\Product::with(['images', 'store'])->inRandomOrder()->take(8)->get(); @endphp
                @foreach($featured as $p)
                    <div class="group relative flex flex-col bg-slate-50/50 rounded-[2rem] border border-slate-100 p-3 hover:bg-white hover:shadow-2xl transition-all duration-500">
                        <a href="{{ route('products.show', $p->slug) }}" class="block relative aspect-[4/5] rounded-[1.5rem] overflow-hidden bg-white mb-4">
                            <img src="{{ $p->images->first() ? asset('storage/' . $p->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-[1.5s]">
                            
                            <div class="absolute top-4 left-4">
                                @if($p->store->is_verified)
                                    <div class="bg-white/95 backdrop-blur-md px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-sm">
                                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="text-[8px] font-black text-slate-900 uppercase tracking-widest">Verified Seller</span>
                                    </div>
                                @endif
                            </div>
                        </a>
                        
                        <div class="px-3 pb-3 space-y-4">
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 line-clamp-1 group-hover:text-green-600 transition-colors mb-1">{{ $p->name }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->store->name }}</p>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                <span class="text-lg font-black text-slate-900">{{ number_format($p->price) }} <span class="text-[9px] text-slate-400">XAF</span></span>
                                <div class="flex items-center gap-1 text-[9px] font-bold text-slate-400 uppercase tracking-tighter bg-white px-3 py-1 rounded-full border border-slate-100">
                                    <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $p->store->location ?? 'Cameroon' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 4. Verified Stores Section (Discover Suppliers) -->
        <section>
            <div class="flex flex-col items-center text-center mb-16 px-4">
                <div class="inline-block bg-slate-900 text-white text-[9px] font-black px-5 py-2 rounded-full uppercase tracking-[0.3em] mb-6">Verified Ecosystem</div>
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tighter mb-4">Shop directly from trusted <span class="text-green-600 underline decoration-green-600/20 underline-offset-8">local suppliers.</span></h2>
                <p class="text-lg text-slate-500 font-medium max-w-2xl">Skip the middleman. Connect directly with wholesalers, manufacturers, and top retailers across Cameroon.</p>
            </div>
            
            <div class="pt-6">
                <x-featured-businesses title="Top Verified Stores" />
            </div>
        </section>

    </main>
</x-app-layout>