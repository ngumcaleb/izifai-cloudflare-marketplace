<x-app-layout>
    <div class="bg-slate-50 min-h-screen pb-20">
        <!-- Bento Hero Header -->
        <div class="max-w-[1400px] mx-auto px-4 md:px-6 py-4 md:py-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 md:gap-4 h-auto lg:min-h-[320px]">

                <!-- Main Large Card -->
                <div
                    class="lg:col-span-8 relative bg-[#0A1D37] rounded-xl md:rounded-2xl overflow-hidden shadow-lg group h-[180px] lg:h-full">
                    <img src="{{ $products->count() > 0 && $products[0]->images->first() ? asset('storage/' . $products[0]->images->first()->path) : 'https://img.freepik.com/free-photo/fashion-shoes-sneakers_1203-7529.jpg' }}"
                        class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-1000">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/80 to-transparent"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37]/90 lg:from-transparent to-transparent">
                    </div>
                    <div class="relative z-10 h-full p-4 lg:p-8 flex flex-col justify-center">
                        <div
                            class="inline-block bg-green-600 text-white text-[7px] md:text-[9px] font-bold px-2 md:px-3 py-0.5 md:py-1 rounded transform -skew-x-12 uppercase tracking-widest mb-2 w-fit shadow-md">
                            Personal Collection
                        </div>

                        <h1
                            class="text-3xl md:text-4xl lg:text-5xl font-black text-white tracking-tight mb-2 leading-none">
                            My <span class="text-green-500">Favorites</span>
                        </h1>

                        <p
                            class="text-[9px] md:text-[11px] lg:text-[13px] text-slate-300 font-medium leading-relaxed max-w-sm lg:max-w-md mb-3 lg:mb-5">
                            View and manage the products you've saved for later. Connect with suppliers directly to
                            start trading.
                        </p>

                        <!-- Trust Stack -->
                        <div class="flex items-center gap-2 md:gap-3 mb-3 lg:mb-5">
                            <div class="flex -space-x-1.5 md:-space-x-2">
                                <img class="w-5 h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/fashion-shoes-sneakers_1203-7529.jpg"
                                    alt="">
                                <img class="w-5 h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/modern-stationary-collection-arrangement_23-2149309649.jpg"
                                    alt="">
                                <img class="w-5 h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/shiny-black-headphones-reflect-music-technology-generated-by-ai_188544-24151.jpg"
                                    alt="">
                                <img class="w-5 h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 rounded-full border-2 border-[#0A1D37] object-cover"
                                    src="https://img.freepik.com/free-photo/black-wireless-earbud-with-charging-case_125540-3428.jpg"
                                    alt="">
                                <div
                                    class="w-5 h-5 md:w-6 md:h-6 lg:w-8 lg:h-8 rounded-full border-2 border-[#0A1D37] bg-slate-800 flex items-center justify-center text-[5px] md:text-[7px] lg:text-[9px] font-bold text-white shadow-sm">
                                    +10k</div>
                            </div>
                            <div
                                class="text-[7px] md:text-[8px] lg:text-[10px] text-slate-300 font-medium leading-tight">
                                Over <span class="text-white font-bold">10,000+</span><br> products available
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Cards (Desktop Only) -->
                <div class="hidden lg:flex lg:col-span-4 flex-col gap-3 md:gap-4 h-full min-h-[300px]">
                    <a href="{{ route('products.new-arrivals') }}"
                        class="flex-1 relative bg-[#0A1D37] rounded-xl md:rounded-2xl overflow-hidden shadow-lg group block cursor-pointer">
                        <img src="https://img.freepik.com/free-photo/headphones-desk-with-laptop-close-up_23-2148289354.jpg"
                            class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#0A1D37]/90 via-[#0A1D37]/60 to-transparent">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-transparent to-transparent">
                        </div>
                        <div class="relative z-10 h-full p-5 flex flex-col justify-end">
                            <div
                                class="flex items-center gap-1.5 mb-1.5 transform group-hover:-translate-y-1 transition-transform duration-300">
                                <svg class="w-3 h-3 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span
                                    class="text-[8px] font-bold text-green-400 uppercase tracking-widest block">Explore
                                    Shop</span>
                            </div>
                            <h3
                                class="text-white font-black text-xl leading-tight transform group-hover:-translate-y-1 transition-transform duration-300">
                                New <br> Arrivals</h3>
                        </div>
                    </a>

                    <a href="{{ route('stores.index') }}"
                        class="flex-1 relative bg-[#0A1D37] rounded-xl md:rounded-2xl overflow-hidden shadow-lg group block cursor-pointer">
                        <img src="https://img.freepik.com/free-photo/front-view-young-woman-with-shopping-bags_23-2148684534.jpg"
                            class="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:scale-105 transition-transform duration-1000">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-[#0A1D37]/90 via-[#0A1D37]/60 to-transparent">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-transparent to-transparent">
                        </div>
                        <div class="relative z-10 h-full p-5 flex flex-col justify-end">
                            <div
                                class="flex items-center gap-1.5 mb-1.5 transform group-hover:-translate-y-1 transition-transform duration-300">
                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <span
                                    class="text-[8px] font-bold text-slate-300 uppercase tracking-widest block">Trusted
                                    Source</span>
                            </div>
                            <h3
                                class="text-white font-black text-xl leading-tight transform group-hover:-translate-y-1 transition-transform duration-300">
                                Verified <br> Wholesalers</h3>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="max-w-[1400px] mx-auto px-4 md:px-6">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2 md:gap-4">
                    @foreach($products as $product)
                        <div class="bg-white border border-slate-100 rounded overflow-hidden group flex flex-col h-full shadow-sm"
                            x-data="{ isFavorited: true, favCount: {{ $product->savedUsers->count() }} }">
                            <a href="{{ route('products.show', $product->slug) }}"
                                class="block relative aspect-square bg-slate-50 overflow-hidden">
                                <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                                @if($product->store && $product->store->is_verified)
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

                                <!-- Favorite Button -->
                                <button @click.prevent="
                                                    fetch('{{ route('products.toggle-favorite', $product->id) }}', { 
                                                        method: 'POST', 
                                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' } 
                                                    })
                                                    .then(res => res.json())
                                                    .then(data => { isFavorited = data.favorited; favCount = data.count; })
                                                "
                                    class="absolute bottom-1 right-1 w-6 h-6 rounded-full bg-white/90 shadow-sm flex items-center justify-center transition-all hover:scale-110 active:scale-95 z-10 border border-slate-100/50 backdrop-blur-sm">
                                    <svg class="w-3 h-3" :class="isFavorited ? 'fill-red-500 text-red-500' : 'text-slate-300'"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button>
                            </a>
                            <div class="p-1.5 flex-1 flex flex-col">
                                <a href="{{ route('products.show', $product->slug) }}" class="block mb-1">
                                    <h3
                                        class="text-[8px] md:text-[10px] font-semibold text-slate-700 line-clamp-2 h-5.5 md:h-7 leading-tight tracking-tight group-hover:text-green-600 transition-colors">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                <div class="flex items-center justify-between mt-auto pt-0.5">
                                    <span
                                        class="text-[9px] md:text-[11px] font-bold text-slate-900">{{ number_format($product->price) }}
                                        <span class="text-[6px] md:text-[7px]">XAF</span></span>
                                    <div
                                        class="flex items-center gap-0.5 text-[6px] md:text-[7px] font-medium text-slate-400 uppercase">
                                        <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        <span class="truncate max-w-[50px]">{{ $product->store->location ?? 'CMR' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-full border border-slate-100 px-6 py-2 shadow-sm">
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white rounded-[2rem] p-20 text-center border border-slate-100">
                    <div
                        class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-2">No favorites yet</h2>
                    <p class="text-slate-500 font-medium mb-10 max-w-sm mx-auto">Start exploring our catalog and save the
                        products that interest you.</p>
                    <a href="{{ route('products.new-arrivals') }}"
                        class="inline-block bg-[#0A1D37] text-white px-10 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all">Explore
                        Catalog</a>
                </div>
            @endif

            <!-- Business Discovery Section -->
            <div class="mt-20">
                <x-featured-businesses title="Discover More Top Wholesalers" />
            </div>
        </div>
    </div>
</x-app-layout>