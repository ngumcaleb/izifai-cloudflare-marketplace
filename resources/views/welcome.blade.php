<x-app-layout>
    <main class="max-w-[1400px] mx-auto px-4 md:px-6 py-2 md:py-4 overflow-hidden space-y-4">

        <!-- 1. Refined Hero Section -->
        <section>
            <div class="lg:hidden relative bg-[#0A1D37] rounded-xl h-[190px] overflow-hidden shadow-lg">
                <img src="https://img.freepik.com/free-photo/diverse-businesspeople-working-together_23-2148908922.jpg"
                    class="absolute inset-0 w-full h-full object-cover opacity-50">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-[#0A1D37]/20 to-transparent"></div>
                <div class="relative z-10 h-full p-4 flex flex-col justify-end">
                    <div
                        class="inline-block bg-green-600 text-white text-[7px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-1.5 w-fit">
                        Official Market
                    </div>
                    <h2 class="text-base font-semibold text-white leading-tight mb-2">Buy and sell easily <br> in <span
                            class="text-green-500">Cameroon.</span></h2>

                    <!-- Trust Stack Mobile -->
                    <div class="flex items-center gap-1.5 mb-2.5">
                        <div class="flex -space-x-1.5">
                            <img class="w-5 h-5 rounded-full border border-[#0A1D37] object-cover"
                                src="https://img.freepik.com/free-photo/fashion-shoes-sneakers_1203-7529.jpg" alt="">
                            <img class="w-5 h-5 rounded-full border border-[#0A1D37] object-cover"
                                src="https://img.freepik.com/free-photo/modern-stationary-collection-arrangement_23-2149309649.jpg"
                                alt="">
                            <img class="w-5 h-5 rounded-full border border-[#0A1D37] object-cover"
                                src="https://img.freepik.com/free-photo/shiny-black-headphones-reflect-music-technology-generated-by-ai_188544-24151.jpg"
                                alt="">
                            <div
                                class="w-5 h-5 rounded-full border border-[#0A1D37] bg-slate-800 flex items-center justify-center text-[5px] font-bold text-white">
                                +10k</div>
                        </div>
                        <div class="text-[6px] text-slate-300 font-medium">Join <span
                                class="text-white font-bold">10k+</span> buyers</div>
                    </div>

                    <div class="flex items-center gap-3">
                        <a href="{{ route('products.new-arrivals') }}"
                            class="bg-white text-slate-900 px-3 py-1.5 rounded font-bold text-[8px] uppercase tracking-widest shadow-lg">Buy
                            Now</a>
                        <a href="{{ route('register') }}"
                            class="text-white font-bold text-[8px] uppercase tracking-widest border-b border-green-500 pb-0.5">Start
                            Selling</a>
                    </div>
                </div>
            </div>

            <div class="hidden lg:grid grid-cols-12 gap-4 h-auto">
                <div class="col-span-8 relative bg-[#0A1D37] rounded-xl overflow-hidden group shadow-xl h-[320px]">
                    <img src="https://img.freepik.com/free-photo/smiling-businesspeople-working-office_23-2148908914.jpg"
                        class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/10 to-transparent"></div>
                    <div class="relative z-10 h-full p-8 flex flex-col justify-center">
                        <div
                            class="inline-block bg-green-600 text-white text-[9px] font-bold px-3 py-1 rounded transform -skew-x-12 uppercase tracking-widest mb-4 w-fit">
                            Premium Choice
                        </div>
                        <h2 class="text-3xl font-semibold text-white leading-tight mb-5 tracking-tight">
                            The easiest way to <br> buy and sell items <br> across <span
                                class="text-green-500">Cameroon.</span>
                        </h2>

                        <!-- Trust Stack Desktop -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex -space-x-2">
                                <img class="w-8 h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/fashion-shoes-sneakers_1203-7529.jpg"
                                    alt="">
                                <img class="w-8 h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/modern-stationary-collection-arrangement_23-2149309649.jpg"
                                    alt="">
                                <img class="w-8 h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/shiny-black-headphones-reflect-music-technology-generated-by-ai_188544-24151.jpg"
                                    alt="">
                                <img class="w-8 h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/black-wireless-earbud-with-charging-case_125540-3428.jpg"
                                    alt="">
                                <div
                                    class="w-8 h-8 rounded-full border-2 border-[#0A1D37] bg-slate-800 flex items-center justify-center text-[9px] font-bold text-white shadow-sm">
                                    +10k</div>
                            </div>
                            <div class="text-[10px] text-slate-300 font-medium leading-tight">
                                Join <span class="text-white font-bold">10,000+</span> active <br> buyers & sellers
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <a href="{{ route('products.new-arrivals') }}"
                                class="bg-white text-slate-900 px-6 py-3 rounded font-bold text-[10px] uppercase tracking-[0.2em] hover:bg-slate-100 transition-all shadow-xl">
                                Browse Items
                            </a>
                            <a href="{{ route('register') }}"
                                class="text-white font-bold text-[10px] uppercase tracking-[0.2em] border-b border-green-500 pb-2 hover:text-green-400 transition-colors">
                                Become a Seller
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-span-4 flex flex-col gap-4">
                    @php
                        $heroProducts = \App\Models\Product::with('images')->latest()->take(2)->get();
                        $heroImg1 = $heroProducts->count() > 0 && $heroProducts[0]->images->first() ? asset('storage/' . $heroProducts[0]->images->first()->path) : 'https://img.freepik.com/free-photo/construction-site-industrial-cranes_23-2148849735.jpg';
                        $heroImg2 = $heroProducts->count() > 1 && $heroProducts[1]->images->first() ? asset('storage/' . $heroProducts[1]->images->first()->path) : 'https://img.freepik.com/free-photo/front-view-young-woman-with-shopping-bags_23-2148684534.jpg';
                    @endphp
                    <a href="{{ route('stores.index') }}"
                        class="flex-1 relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group block cursor-pointer">
                        <img src="{{ $heroImg1 }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#0A1D37]/90 via-[#0A1D37]/60 to-transparent">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-transparent to-transparent">
                        </div>
                        <div class="relative z-10 h-full p-4 md:p-5 flex flex-col justify-end">
                            <div
                                class="flex items-center gap-1.5 mb-1.5 transform group-hover:-translate-y-1 transition-transform duration-300">
                                <svg class="w-3 h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span
                                    class="text-[8px] font-bold text-green-400 uppercase tracking-widest block">Verified
                                    Wholesalers</span>
                            </div>
                            <h3
                                class="text-white font-black text-base md:text-xl leading-tight transform group-hover:-translate-y-1 transition-transform duration-300">
                                View Shops <span class="text-green-500">&rarr;</span></h3>
                        </div>
                    </a>

                    <a href="{{ route('register') }}"
                        class="flex-1 relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group block cursor-pointer">
                        <img src="{{ $heroImg2 }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#0A1D37]/90 via-[#0A1D37]/60 to-transparent">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-transparent to-transparent">
                        </div>
                        <div class="relative z-10 h-full p-4 md:p-5 flex flex-col justify-end">
                            <div
                                class="flex items-center gap-1.5 mb-1.5 transform group-hover:-translate-y-1 transition-transform duration-300">
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span
                                    class="text-[8px] font-bold text-slate-300 uppercase tracking-widest block">Monetization</span>
                            </div>
                            <h3
                                class="text-white font-black text-base md:text-xl leading-tight transform group-hover:-translate-y-1 transition-transform duration-300">
                                Feature Your <br> Products Today</h3>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- 2. Shop by Category (Horizontal Pills) -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <div class="flex flex-col border-l-4 border-green-600 pl-4">
                    <h2 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-[0.2em]">Shop by Category</h2>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Find what you need</p>
                </div>
                <a href="{{ route('categories.index') }}" class="text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-green-600 transition-colors">See All &rarr;</a>
            </div>
            
            <div class="flex overflow-x-auto no-scrollbar gap-2 -mx-4 px-4 pb-2">
                @php $cats = \App\Models\Category::has('products')->take(12)->get(); @endphp
                @foreach($cats as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                       class="whitespace-nowrap px-5 py-2.5 bg-white border border-slate-100 rounded-full text-[10px] font-black text-[#0A1D37] uppercase tracking-wider hover:border-green-600/30 hover:shadow-lg transition-all duration-300">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </section>

        <!-- 3. Our Best Items (Clean Redesign) -->
        <section class="bg-slate-50 -mx-4 px-4 py-6 lg:mx-0 lg:rounded-[2rem] border border-slate-100">
            <div class="flex items-center justify-between mb-6">
                <div class="flex flex-col gap-1">
                    <h2 class="text-[12px] font-black text-[#0A1D37] uppercase tracking-[0.3em] flex items-center gap-3">
                        <span class="w-10 h-[2px] bg-green-600"></span>
                        Our Best Items
                    </h2>
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-13">Top Quality Handpicked for You</p>
                </div>
            </div>
            
            <div class="flex overflow-x-auto no-scrollbar gap-6 pb-2">
                @php $featured = \App\Models\Product::with(['images', 'store'])->inRandomOrder()->take(6)->get(); @endphp
                @foreach($featured as $p)
                    <div class="flex-shrink-0 w-[170px] md:w-[210px] bg-white border border-slate-100 rounded-2xl overflow-hidden group/item hover:shadow-2xl transition-all duration-500 flex flex-col">
                        <a href="{{ route('products.show', $p->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-50">
                            <img src="{{ $p->images->first() ? asset('storage/' . $p->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                class="w-full h-full object-cover group-hover/item:scale-110 transition-transform duration-700">
                            
                            <div class="absolute top-3 left-3 bg-green-600 text-white text-[7px] font-black px-2 py-1 transform -skew-x-12 uppercase tracking-widest shadow-lg">
                                Top Pick
                            </div>
                        </a>
                        <div class="p-4 space-y-3">
                            <h3 class="text-[10px] font-bold text-[#0A1D37] line-clamp-1 leading-tight group-hover/item:text-green-600 transition-colors">
                                {{ $p->name }}
                            </h3>
                            <div class="flex items-center justify-between pt-2 border-t border-slate-50">
                                <span class="text-[12px] font-black text-[#0A1D37]">{{ number_format($p->price) }} <span class="text-[7px] text-slate-400 uppercase">XAF</span></span>
                                <div class="flex items-center gap-1 text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                    <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $p->store->location ?? 'CMR' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>


        <!-- 5. Popular Now -->
        <section>
            <div class="flex items-center justify-between mb-4 border-b border-slate-50 pb-2">
                <div class="flex flex-col">
                    <h2 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-[0.2em]">Popular Now</h2>
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">What everyone is buying</p>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @php $trending = \App\Models\Product::with(['images', 'store'])->orderBy('views', 'desc')->take(12)->get(); @endphp
                @foreach($trending as $tp)
                    <div class="group relative bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col h-full overflow-hidden">
                        <a href="{{ route('products.show', $tp->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-50">
                            <img src="{{ $tp->images->first() ? asset('storage/' . $tp->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute top-2 left-2 bg-[#0A1D37] text-white text-[7px] font-black px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest z-10">
                                Popular
                            </div>
                        </a>
                        <div class="p-3 flex-1 flex flex-col">
                            <h3 class="text-[10px] md:text-[11px] font-bold text-[#0A1D37] line-clamp-2 leading-tight group-hover:text-green-600 transition-colors mb-2">{{ $tp->name }}</h3>
                            <div class="mt-auto flex items-center justify-between pt-2 border-t border-slate-50">
                                <span class="text-[11px] font-black text-[#0A1D37]">{{ number_format($tp->price) }}</span>
                                <div class="flex items-center gap-1 text-[8px] font-bold text-slate-400 uppercase tracking-tighter">
                                    <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $tp->store->location ?? 'CMR' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- 6. Newest Items -->
        <section class="pb-16 lg:pb-0">
            <div class="flex items-center justify-between mb-2 pb-1 border-b border-slate-100">
                <h2 class="text-[9px] font-bold text-slate-900 uppercase tracking-[0.2em]">Newest Items</h2>
                <a href="{{ route('products.new-arrivals') }}"
                    class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">See All</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
                @php $newItems = \App\Models\Product::with(['images', 'store'])->latest()->take(18)->get(); @endphp
                @foreach($newItems as $ni)
                    <div
                        class="bg-white border border-slate-100 rounded overflow-hidden group flex flex-col h-full shadow-sm">
                        <a href="{{ route('products.show', $ni->slug) }}"
                            class="block relative aspect-square bg-slate-50 overflow-hidden">
                            <img src="{{ $ni->images->first() ? asset('storage/' . $ni->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @if($ni->store->is_verified)
                                <div
                                    class="absolute top-1 left-1 bg-white/95 px-1 py-0.5 rounded flex items-center gap-0.5 shadow-sm border border-slate-50">
                                    <svg class="w-2 h-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z">
                                        </path>
                                    </svg>
                                    <span class="text-[5px] font-bold text-green-600 uppercase tracking-tighter">Verified</span>
                                </div>
                            @endif
                        </a>
                        <div class="p-1.5 flex-1 flex flex-col">
                            <a href="{{ route('products.show', $ni->slug) }}" class="block mb-1">
                                <h3
                                    class="text-[8px] font-semibold text-slate-700 line-clamp-2 h-5.5 leading-tight tracking-tight">
                                    {{ $ni->name }}
                                </h3>
                            </a>
                            <div class="flex items-center justify-between mt-auto pt-0.5">
                                <span class="text-[9px] font-bold text-slate-900">{{ number_format($ni->price) }}</span>
                                <div class="flex items-center gap-0.5 text-[6px] font-medium text-slate-400 uppercase">
                                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate max-w-[50px]">{{ $ni->store->location ?? 'CMR' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        <!-- 6. Trusted Shops (Bottom Discovery Hub) -->
        <div class="pt-6 border-t border-slate-100">
            <x-featured-businesses title="Trusted Shops" />
        </div>
    </main>
</x-app-layout>