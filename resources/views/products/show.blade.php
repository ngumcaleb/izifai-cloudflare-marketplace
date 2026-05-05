<x-app-layout>
    <main class="max-w-[1440px] mx-auto px-4 lg:px-8 py-12" x-data="{ reportModal: false, reportReason: '' }">
        
        <!-- 1. Breadcrumbs & Meta -->
        <nav class="flex items-center gap-3 text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-10">
            <a href="/" class="hover:text-green-600 transition-colors">Marketplace</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('categories.show', $product->category->slug) }}" class="hover:text-green-600 transition-colors">{{ $product->category->name }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-900">{{ $product->name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            
            <!-- 2. Professional Media Gallery (Col 5) -->
            <div class="lg:col-span-5 space-y-6" x-data="{ currentImage: '{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}' }">
                <div class="aspect-[4/5] rounded-[2.5rem] bg-white border border-slate-100 overflow-hidden shadow-2xl shadow-slate-200/50 group flex items-center justify-center p-8">
                    <img :src="currentImage" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-700">
                </div>
                
                @if($product->images->count() > 1)
                    <div class="flex flex-wrap gap-4 px-2">
                        @foreach($product->images as $image)
                            <button @click="currentImage = '{{ asset('storage/' . $image->path) }}'" 
                                    class="w-20 h-20 rounded-2xl border-2 overflow-hidden transition-all bg-white p-1"
                                    :class="currentImage === '{{ asset('storage/' . $image->path) }}' ? 'border-green-600 ring-4 ring-green-50' : 'border-slate-100 hover:border-slate-300'">
                                <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover rounded-xl">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- 3. Product Details & Purchase Hub (Col 7) -->
            <div class="lg:col-span-7">
                <div class="max-w-2xl">
                    <!-- Title & Identity -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="bg-green-50 text-green-600 text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest">In Stock</span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">SKU: IZF-{{ $product->id }}</span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-black text-slate-900 tracking-tighter leading-tight mb-6">{{ $product->name }}</h1>
                        
                        <div class="flex items-baseline gap-6 mb-8">
                            <span class="text-5xl font-black text-slate-900">{{ number_format($product->price) }} <span class="text-sm font-bold text-slate-400">XAF</span></span>
                            @if($product->old_price)
                                <span class="text-xl text-slate-300 font-bold line-through">{{ number_format($product->old_price) }} XAF</span>
                                <span class="text-green-600 text-sm font-black uppercase tracking-widest">Save {{ round((($product->old_price - $product->price) / $product->old_price) * 100) }}%</span>
                            @endif
                        </div>
                    </div>

                    <!-- Variants Section -->
                    <div class="space-y-10 mb-12">
                        @if($product->colors && count($product->colors) > 0)
                        <div>
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-4">Available Colorways</h4>
                            <div class="flex flex-wrap gap-4">
                                @foreach($product->colors as $color)
                                    <button class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-slate-100 hover:ring-green-600 transition-all p-1" title="{{ $color }}">
                                        <div class="w-full h-full rounded-full shadow-inner" style="background-color: {{ strtolower($color) }}"></div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($product->sizes && count($product->sizes) > 0)
                        <div>
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em] mb-4">Select Specification</h4>
                            <div class="flex flex-wrap gap-3">
                                @foreach($product->sizes as $size)
                                    <button class="px-8 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-black text-slate-900 uppercase tracking-widest hover:border-green-600 hover:bg-green-50 transition-all">
                                        {{ $size }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Primary Actions -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-12">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}?text=Hello, I am interested in: {{ urlencode($product->name) }}" 
                           target="_blank"
                           class="bg-[#16A34A] text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-green-700 transition-all shadow-xl shadow-green-600/20 active:scale-95">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                            Order via WhatsApp
                        </a>
                        <a href="tel:{{ preg_replace('/[^0-9]/', '', $product->store->whatsapp_number) }}" 
                           class="bg-slate-900 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest flex items-center justify-center gap-3 hover:bg-slate-800 transition-all active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            Call Seller
                        </a>
                    </div>

                    <!-- Seller Trust Card (High Fidelity) -->
                    <div class="bg-slate-50/50 border border-slate-100 rounded-[2.5rem] p-8 lg:p-10 mb-12">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 rounded-[1.5rem] bg-white shadow-xl flex items-center justify-center text-slate-900 font-black text-2xl border border-slate-50 overflow-hidden">
                                    @if($product->store->logo)
                                        <img src="{{ asset('storage/' . $product->store->logo) }}" class="w-full h-full object-cover">
                                    @else
                                        {{ substr($product->store->name, 0, 1) }}
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-xl font-black text-slate-900">{{ $product->store->name }}</h3>
                                        @if($product->store->is_verified)
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ $product->store->location ?? 'Cameroon' }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('stores.show', $product->store->slug) }}" class="px-6 py-3 bg-white border border-slate-200 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 hover:text-white transition-all">Visit Store</a>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-6 pt-8 border-t border-slate-100">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Trust Signal</p>
                                <p class="text-xs font-bold text-slate-900 flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                    Verified Business Entity
                                </p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Response Time</p>
                                <p class="text-xs font-bold text-slate-900">Typically < 2 hours</p>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Specifications Grid -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-green-600 rounded-full"></span>
                                Technical Specifications
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                                @forelse($product->specifications as $spec)
                                    <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $spec->key }}</span>
                                        <span class="text-sm font-bold text-slate-900">{{ $spec->value }}</span>
                                    </div>
                                @empty
                                    <p class="text-sm text-slate-400 font-medium">No detailed specifications provided.</p>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900 mb-6 flex items-center gap-3">
                                <span class="w-1.5 h-6 bg-slate-900 rounded-full"></span>
                                About this product
                            </h2>
                            <div class="prose prose-slate max-w-none">
                                <p class="text-slate-500 font-medium leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Discover More Carousel -->
        <div class="mt-32 pt-20 border-t border-slate-100">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">Similar Discoveries</h2>
                    <p class="text-sm text-slate-400 font-bold uppercase tracking-[0.2em]">Based on your interests</p>
                </div>
                <a href="{{ route('products.new-arrivals') }}" class="text-xs font-bold text-green-600 uppercase tracking-widest">See more &rarr;</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8">
                @php
                    $relatedProducts = \App\Models\Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->with(['images', 'store'])
                        ->take(5)
                        ->get();
                @endphp
                @foreach($relatedProducts as $related)
                    <div class="group relative flex flex-col">
                        <a href="{{ route('products.show', $related->slug) }}" class="block relative aspect-[4/5] rounded-[2rem] overflow-hidden bg-slate-50 border border-slate-100 mb-4">
                            <img src="{{ $related->images->first() ? asset('storage/' . $related->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        </a>
                        <h3 class="text-xs font-bold text-slate-900 line-clamp-1 mb-2">{{ $related->name }}</h3>
                        <span class="text-sm font-black text-slate-900">{{ number_format($related->price) }} XAF</span>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-app-layout>

