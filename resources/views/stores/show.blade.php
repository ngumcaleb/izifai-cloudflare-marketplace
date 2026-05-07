{{-- resources/views/stores/show.blade.php --}}
<x-app-layout>
    @php 
        $avgRating = $reviews->avg('rating'); 
        $totalProducts = $products->total();
        $totalReviews = $reviews->count();
        $joinedDate = $store->created_at->format('F Y');
        $yearsOnPlatform = max(1, $store->created_at->diffInYears(now()));
        $bannerUrl = $store->banner ? asset('storage/' . $store->banner) : 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?auto=format&fit=crop&q=80&w=2000';
        $storeViews = data_get($store, 'views');
        if ($storeViews === null) {
            $storeViews = (int) $store->products()->sum('views');
        }
        $positiveReviews = $totalReviews > 0 ? $reviews->where('rating', '>=', 4)->count() : 0;
        $positiveReviewRate = $totalReviews > 0 ? round(($positiveReviews / $totalReviews) * 100) : null;
        $previewProducts = $products->getCollection()->take(6);

        // other businesses logos (dynamic)
        $otherBusinessLogos = \App\Models\Store::query()
            ->whereKeyNot($store->getKey())
            ->whereNotNull('logo')
            ->inRandomOrder()
            ->take(6)
            ->get();
        
        // Calculate category counts
        $categoryCounts = [];
        foreach ($categories as $cat) {
            $categoryCounts[$cat->id] = $cat->products->where('store_id', $store->id)->count();
        }
    @endphp

    @push('styles')
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @endpush

    <main class="max-w-[1400px] mx-auto px-4 md:px-6 py-2 md:py-4 overflow-hidden space-y-4" x-data="{ 
        activeTab: 'home', 
        selectedCategory: 'all',
        sortBy: 'newest',
        viewMode: 'grid'
    }">
        
        <!-- Breadcrumb -->
        <nav class="flex flex-wrap items-center gap-1 text-[9px] font-bold text-slate-400 uppercase tracking-wider">
            <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors">Home</a>
            <span class="text-slate-300">/</span>
            <a href="{{ route('stores.index') }}" class="hover:text-emerald-600 transition-colors">Shops</a>
            <span class="text-slate-300">/</span>
            <span class="text-slate-800">{{ Str::limit($store->name, 25) }}</span>
        </nav>

        <!-- Hero Section - Mobile First -->
        <section>
            <!-- Mobile Hero (simplified, clean) -->
            <div class="lg:hidden relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg mb-3">
                <img src="{{ $bannerUrl }}" class="absolute inset-0 w-full h-full object-cover opacity-35">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0A1D37] via-[#0A1D37]/40 to-transparent"></div>
                <div class="relative z-10 p-4 flex flex-col items-center text-center">
                    <!-- Logo -->
                    <div class="w-16 h-16 bg-white rounded-xl shadow-lg p-2 flex items-center justify-center mb-3 -mt-8">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="max-h-12 w-auto object-contain" alt="{{ $store->name }}">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-slate-100 grid place-items-center text-slate-400 font-black text-lg">
                                {{ Str::upper(Str::substr($store->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    
                    @if($store->is_verified)
                        <div class="inline-flex items-center gap-1.5 bg-emerald-600/20 border border-emerald-500/30 text-emerald-200 px-2 py-0.5 rounded-full mb-2">
                            <svg class="w-2.5 h-2.5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-[8px] font-black uppercase tracking-wider">Verified Store</span>
                        </div>
                    @endif
                    
                    <h1 class="text-xl font-black text-white tracking-tight">{{ $store->name }}</h1>
                    <p class="text-white/70 text-[9px] font-semibold mt-1 max-w-xs">
                        {{ $store->tagline ?? ($store->description ? Str::limit(strip_tags($store->description), 60) : 'Trusted seller on Izifai') }}
                    </p>
                    
                    <div class="flex items-center gap-3 mt-2 text-[8px] font-bold text-white/60">
                        <span class="flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> {{ $store->location ?? 'Cameroon' }}</span>
                        <span class="flex items-center gap-1"><svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Joined {{ $joinedDate }}</span>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col w-full gap-2 mt-4">
                        @if(!empty($store->whatsapp_number))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp_number) }}" target="_blank"
                               class="bg-emerald-600 text-white rounded-lg px-4 py-2.5 flex items-center justify-center gap-2 font-black text-[10px] uppercase tracking-wider shadow-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Message Store
                            </a>
                        @endif
                        @if(!empty($store->phone_number))
                            <a href="tel:{{ $store->phone_number }}" class="bg-white/10 border border-white/20 text-white rounded-lg px-4 py-2.5 flex items-center justify-center gap-2 font-black text-[10px] uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Call Store
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Desktop Hero -->
            <div class="hidden lg:block relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-xl">
                <img src="{{ $bannerUrl }}" class="absolute inset-0 w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/20 to-transparent"></div>
                <div class="relative z-10 p-6 flex items-center gap-6">
                    <!-- Logo -->
                    <div class="w-24 h-24 bg-white rounded-xl shadow-lg p-3 flex items-center justify-center shrink-0">
                        @if($store->logo)
                            <img src="{{ asset('storage/' . $store->logo) }}" class="max-h-16 w-auto object-contain" alt="{{ $store->name }}">
                        @else
                            <div class="w-16 h-16 rounded-xl bg-slate-100 grid place-items-center text-slate-400 font-black text-2xl">
                                {{ Str::upper(Str::substr($store->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            @if($store->is_verified)
                                <span class="inline-flex items-center gap-1.5 bg-emerald-600/20 border border-emerald-500/30 text-emerald-200 px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-wider">
                                    <svg class="w-3 h-3 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Verified Store
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl font-black text-white tracking-tight">{{ $store->name }}</h1>
                        <p class="text-white/70 text-[11px] font-semibold mt-1 max-w-xl">{{ $store->tagline ?? ($store->description ? Str::limit(strip_tags($store->description), 100) : 'Trusted seller on Izifai') }}</p>
                        
                        <div class="flex items-center gap-6 mt-3 text-[9px] font-bold text-white/60">
                            <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg> {{ $store->location ?? 'Cameroon' }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Joined {{ $joinedDate }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> {{ number_format((int) $storeViews) }}+ views</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col gap-2 min-w-[180px]">
                        @if(!empty($store->whatsapp_number))
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $store->whatsapp_number) }}" target="_blank"
                               class="bg-emerald-600 text-white rounded-lg px-5 py-2.5 flex items-center justify-center gap-2 font-black text-[10px] uppercase tracking-wider shadow-lg hover:bg-emerald-700 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat on WhatsApp
                            </a>
                        @endif
                        @if(!empty($store->phone_number))
                            <a href="tel:{{ $store->phone_number }}" class="bg-white/10 border border-white/20 text-white rounded-lg px-5 py-2.5 flex items-center justify-center gap-2 font-black text-[10px] uppercase tracking-wider hover:bg-white/15 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Call Store
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Stats Row - Mobile -->
            <div class="lg:hidden grid grid-cols-4 gap-2 bg-white rounded-xl border border-slate-100 p-3 shadow-sm mt-3">
                <div class="text-center">
                    <p class="font-black text-[#0A1D37] text-base">{{ number_format($totalProducts) }}</p>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Products</p>
                </div>
                <div class="text-center">
                    <p class="font-black text-[#0A1D37] text-base">{{ number_format((int) $storeViews) }}+</p>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Views</p>
                </div>
                <div class="text-center">
                    <p class="font-black text-[#0A1D37] text-base">{{ $positiveReviewRate !== null ? $positiveReviewRate . '%' : '—' }}</p>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Positive</p>
                </div>
                <div class="text-center">
                    <p class="font-black text-[#0A1D37] text-base">{{ $store->created_at->format('Y') }}</p>
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider">Since</p>
                </div>
            </div>
            
            <!-- Stats Row - Desktop -->
            <div class="hidden lg:grid grid-cols-4 gap-6 bg-white rounded-xl border border-slate-100 p-4 shadow-sm mt-4 max-w-md">
                <div>
                    <p class="font-black text-[#0A1D37] text-xl">{{ number_format($totalProducts) }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Total Products</p>
                </div>
                <div>
                    <p class="font-black text-[#0A1D37] text-xl">{{ number_format((int) $storeViews) }}+</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Store Views</p>
                </div>
                <div>
                    <p class="font-black text-[#0A1D37] text-xl">{{ $positiveReviewRate !== null ? $positiveReviewRate . '%' : '—' }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Positive Reviews</p>
                </div>
                <div>
                    <p class="font-black text-[#0A1D37] text-xl">{{ $store->created_at->format('Y') }}</p>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Member Since</p>
                </div>
            </div>
        </section>

        <!-- Navigation Tabs - Pill Style (Mobile First) -->
        <div class="flex overflow-x-auto no-scrollbar gap-1.5 pb-2 -mx-4 px-4 border-b border-slate-100">
            <button @click="activeTab = 'home'" 
                    class="whitespace-nowrap px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider transition-all duration-200"
                    :class="activeTab === 'home' ? 'bg-[#0A1D37] text-white shadow-md' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> Store</span>
            </button>
            <button @click="activeTab = 'products'"
                    class="whitespace-nowrap px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider transition-all duration-200"
                    :class="activeTab === 'products' ? 'bg-[#0A1D37] text-white shadow-md' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg> Products ({{ number_format($totalProducts) }})</span>
            </button>
            <button @click="activeTab = 'about'"
                    class="whitespace-nowrap px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider transition-all duration-200"
                    :class="activeTab === 'about' ? 'bg-[#0A1D37] text-white shadow-md' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> About</span>
            </button>
            <button @click="activeTab = 'reviews'"
                    class="whitespace-nowrap px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider transition-all duration-200"
                    :class="activeTab === 'reviews' ? 'bg-[#0A1D37] text-white shadow-md' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg> Reviews</span>
            </button>
            <button @click="activeTab = 'policies'"
                    class="whitespace-nowrap px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider transition-all duration-200"
                    :class="activeTab === 'policies' ? 'bg-[#0A1D37] text-white shadow-md' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                <span class="flex items-center gap-1.5"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg> Policies</span>
            </button>
        </div>

        <!-- Tab Content -->
        <div class="space-y-4">
            
            <!-- Store Home Tab -->
            <div x-show="activeTab === 'home'" x-transition.duration.200ms class="space-y-4">
                
                <!-- Category Pills (if any) -->
                @if($categories->count() > 0)
                <div class="flex overflow-x-auto no-scrollbar gap-2 pb-2">
                    <button @click="selectedCategory = 'all'" 
                            class="whitespace-nowrap px-3 py-1.5 rounded-full text-[8px] font-black uppercase tracking-wider transition-all"
                            :class="selectedCategory === 'all' ? 'bg-[#0A1D37] text-white' : 'bg-white border border-slate-200 text-slate-500'">
                        All
                    </button>
                    @foreach($categories as $cat)
                        @if(($categoryCounts[$cat->id] ?? 0) > 0)
                            <button @click="selectedCategory = '{{ $cat->slug }}'" 
                                    class="whitespace-nowrap px-3 py-1.5 rounded-full text-[8px] font-black uppercase tracking-wider transition-all"
                                    :class="selectedCategory === '{{ $cat->slug }}' ? 'bg-[#0A1D37] text-white' : 'bg-white border border-slate-200 text-slate-500'">
                                {{ $cat->name }}
                            </button>
                        @endif
                    @endforeach
                </div>
                @endif
                
                <!-- Featured Products Grid (Mobile First) -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex flex-col border-l-4 border-emerald-600 pl-3">
                            <h2 class="text-[10px] font-black text-[#0A1D37] uppercase tracking-[0.2em]">Featured Items</h2>
                            <p class="text-[7px] font-bold text-slate-400 uppercase tracking-wider">Handpicked just for you</p>
                        </div>
                        <button @click="activeTab = 'products'" class="text-[8px] font-black text-slate-400 uppercase tracking-wider hover:text-emerald-600">View All →</button>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        @forelse($previewProducts as $product)
                            <div class="group relative bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                                <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-50">
                                    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://placehold.co/400x400/1e293b/ffffff?text=No+Image' }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if($product->discount_percent)
                                        <div class="absolute top-2 left-2 bg-red-500 text-white text-[7px] font-black px-1.5 py-0.5 rounded-full">
                                            -{{ $product->discount_percent }}%
                                        </div>
                                    @endif
                                </a>
                                <div class="p-2.5 flex-1 flex flex-col">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block mb-1">
                                        <h3 class="text-[9px] font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-emerald-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                    </a>
                                    <div class="mt-auto flex items-center justify-between pt-1.5 border-t border-slate-50">
                                        <span class="text-[10px] font-black text-[#0A1D37]">{{ number_format($product->price) }} <span class="text-[6px] text-slate-400 uppercase">XAF</span></span>
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-[8px] font-bold text-slate-400 uppercase tracking-wider hover:text-emerald-600">View →</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-[10px] font-semibold text-slate-400">No products yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- About the Store Section -->
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">About {{ $store->name }}</h3>
                    </div>
                    <p class="text-[10px] text-slate-600 font-medium leading-relaxed">
                        {{ $store->description ? Str::limit(strip_tags($store->description), 200) : ($store->name . ' is a trusted marketplace seller committed to quality and customer satisfaction.') }}
                    </p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-full text-[8px] font-bold text-slate-600"><svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> 100% Genuine</span>
                        <span class="inline-flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-full text-[8px] font-bold text-slate-600"><svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Warranty Included</span>
                        <span class="inline-flex items-center gap-1 bg-slate-50 px-2 py-1 rounded-full text-[8px] font-bold text-slate-600"><svg class="w-2.5 h-2.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg> Fast Shipping</span>
                    </div>
                </div>
                
                <!-- Trust Badges Row -->
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white rounded-xl border border-slate-100 p-3 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-800">Trusted Store</p>
                            <p class="text-[7px] font-medium text-slate-400">Verified by Izifai</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-100 p-3 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-800">Fast Response</p>
                            <p class="text-[7px] font-medium text-slate-400">Chat within minutes</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-100 p-3 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-800">Secure Payment</p>
                            <p class="text-[7px] font-medium text-slate-400">Safe transactions</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-100 p-3 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 14h6m-6 4h12M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-800">Best Prices</p>
                            <p class="text-[7px] font-medium text-slate-400">Competitive offers</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Tab -->
            <div x-show="activeTab === 'products'" x-transition.duration.200ms class="space-y-4">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">All Products ({{ number_format($totalProducts) }})</h3>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[8px] font-black text-slate-400">Sort:</span>
                            <select x-model="sortBy" class="bg-slate-50 border border-slate-200 rounded-lg px-2 py-1.5 text-[8px] font-black text-slate-700 focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                <option value="newest">Newest</option>
                                <option value="price_low">Price: Low → High</option>
                                <option value="price_high">Price: High → Low</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                        @forelse($products as $product)
                            <div class="group relative bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                                <a href="{{ route('products.show', $product->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-50">
                                    <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://placehold.co/400x400/1e293b/ffffff?text=No+Image' }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if($product->discount_percent)
                                        <div class="absolute top-2 left-2 bg-red-500 text-white text-[7px] font-black px-1.5 py-0.5 rounded-full">
                                            -{{ $product->discount_percent }}%
                                        </div>
                                    @endif
                                </a>
                                <div class="p-2.5 flex-1 flex flex-col">
                                    <a href="{{ route('products.show', $product->slug) }}" class="block mb-1">
                                        <h3 class="text-[9px] font-bold text-slate-800 line-clamp-2 leading-tight group-hover:text-emerald-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                    </a>
                                    <div class="mt-auto flex items-center justify-between pt-1.5 border-t border-slate-50">
                                        <span class="text-[10px] font-black text-[#0A1D37]">{{ number_format($product->price) }} <span class="text-[6px] text-slate-400 uppercase">XAF</span></span>
                                        <div class="flex items-center gap-1">
                                            <button type="button" 
                                                    onclick="event.preventDefault(); event.stopPropagation(); toggleSave({{ $product->id }})"
                                                    class="text-slate-300 hover:text-red-500 transition-colors">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                            </button>
                                            <a href="{{ route('products.show', $product->slug) }}" class="text-[8px] font-bold text-slate-400 uppercase tracking-wider hover:text-emerald-600">View →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <div class="w-12 h-12 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                </div>
                                <p class="text-[10px] font-semibold text-slate-400">No products found.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
            
            <!-- About Tab -->
            <div x-show="activeTab === 'about'" x-transition.duration.200ms class="space-y-4">
                <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <h3 class="text-[12px] font-black text-[#0A1D37] uppercase tracking-wider">About {{ $store->name }}</h3>
                    </div>
                    
                    <div class="prose prose-sm max-w-none">
                        <p class="text-[11px] text-slate-600 leading-relaxed">
                            {{ $store->description ?? ($store->name . ' is a premier marketplace seller dedicated to providing high-quality products and excellent customer service. With a focus on customer satisfaction, we ensure every purchase meets your expectations.') }}
                        </p>
                    </div>
                    
                    @if(!empty($store->business_hours) || !empty($store->location))
                        <div class="mt-5 pt-4 border-t border-slate-100 grid grid-cols-2 gap-4">
                            @if(!empty($store->business_hours))
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider mb-1">Business Hours</p>
                                    <p class="text-[10px] font-semibold text-slate-700">{{ $store->business_hours }}</p>
                                </div>
                            @endif
                            @if(!empty($store->location))
                                <div>
                                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-wider mb-1">Location</p>
                                    <p class="text-[10px] font-semibold text-slate-700">{{ $store->location }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Reviews Tab -->
            <div x-show="activeTab === 'reviews'" x-transition.duration.200ms class="space-y-4">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center justify-between flex-wrap gap-3 mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">Customer Reviews</h3>
                            </div>
                            <p class="text-[9px] font-semibold text-slate-400 mt-0.5">{{ number_format($totalReviews) }} total reviews</p>
                        </div>
                        @auth
                            @if(Auth::id() !== $store->user_id)
                                <button onclick="document.getElementById('reviewModal').classList.remove('hidden')"
                                        class="bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-wider hover:bg-emerald-700 transition shadow-sm">
                                    Write a Review
                                </button>
                            @endif
                        @endauth
                    </div>
                    
                    @if($totalReviews > 0)
                        <div class="space-y-3">
                            @foreach($reviews as $review)
                                <div class="border-b border-slate-50 pb-3 last:border-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-black text-[10px]">
                                                {{ substr($review->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-slate-800">{{ $review->user->name ?? 'Anonymous' }}</p>
                                                <p class="text-[7px] font-semibold text-slate-400">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-0.5">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-amber-500' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="mt-2 text-[10px] text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-12 h-12 mx-auto bg-slate-100 rounded-full flex items-center justify-center mb-2">
                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </div>
                            <p class="text-[10px] font-semibold text-slate-400">No reviews yet. Be the first!</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Policies Tab -->
            <div x-show="activeTab === 'policies'" x-transition.duration.200ms class="space-y-3">
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">Sales Policy</h3>
                    </div>
                    <p class="text-[10px] text-slate-600 leading-relaxed">{{ $store->shipping_policy ?? 'We offer nationwide shipping across Cameroon. Delivery times vary by location. For more details, please contact us directly.' }}</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">Return Policy</h3>
                    </div>
                    <p class="text-[10px] text-slate-600 leading-relaxed">{{ $store->return_policy ?? 'Returns are accepted within 14 days of delivery for eligible products. Items must be unused and in original packaging.' }}</p>
                </div>
                <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <h3 class="text-[11px] font-black text-[#0A1D37] uppercase tracking-wider">Warranty Policy</h3>
                    </div>
                    <p class="text-[10px] text-slate-600 leading-relaxed">{{ $store->warranty_policy ?? 'All products come with a manufacturer warranty. Warranty period varies by product. Contact us for specific product warranty details.' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Trusted Shops Section (Bottom Discovery Hub) -->
        <div class="pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <div class="flex flex-col border-l-4 border-emerald-600 pl-3">
                    <h2 class="text-[10px] font-black text-[#0A1D37] uppercase tracking-[0.2em]">Other Trusted Shops</h2>
                    <p class="text-[7px] font-bold text-slate-400 uppercase tracking-wider">Discover more sellers</p>
                </div>
                <a href="{{ route('stores.index') }}" class="text-[8px] font-black text-slate-400 uppercase tracking-wider hover:text-emerald-600">See All →</a>
            </div>
            
            <div class="flex overflow-x-auto no-scrollbar gap-4 pb-2">
                @foreach($otherBusinessLogos as $otherStore)
                    <a href="{{ route('stores.show', $otherStore->slug) }}" class="flex-shrink-0 w-20 text-center group">
                        <div class="w-20 h-20 bg-white rounded-xl border border-slate-100 shadow-sm flex items-center justify-center p-3 group-hover:shadow-md transition-all">
                            @if($otherStore->logo)
                                <img src="{{ asset('storage/' . $otherStore->logo) }}" class="max-h-12 w-auto object-contain" alt="{{ $otherStore->name }}">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-sm">
                                    {{ Str::upper(Str::substr($otherStore->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <p class="text-[8px] font-bold text-slate-600 mt-1.5 line-clamp-1 group-hover:text-emerald-600 transition-colors">{{ Str::limit($otherStore->name, 15) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Review Modal -->
    @auth
        @if(Auth::id() !== $store->user_id)
            <div id="reviewModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" x-data="{ rating: 5 }">
                <div class="bg-white rounded-xl max-w-md w-full p-5 relative shadow-2xl">
                    <button onclick="document.getElementById('reviewModal').classList.add('hidden')" class="absolute top-3 right-3 text-slate-400 hover:text-slate-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        <h3 class="text-base font-bold text-slate-800">Write a Review</h3>
                    </div>
                    <form action="{{ route('stores.review', $store) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-wider mb-2">Rating</label>
                            <div class="flex gap-1 text-2xl text-yellow-400">
                                <template x-for="star in [1,2,3,4,5]">
                                    <button type="button" @click="rating = star" class="focus:outline-none transition-transform hover:scale-110">
                                        <span x-show="star <= rating">★</span>
                                        <span x-show="star > rating" class="text-slate-300">★</span>
                                    </button>
                                </template>
                            </div>
                            <input type="hidden" name="rating" x-model="rating" value="5">
                        </div>
                        <div class="mb-4">
                            <label class="block text-[10px] font-black text-slate-600 uppercase tracking-wider mb-2">Your Review (Optional)</label>
                            <textarea name="comment" rows="4" class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent" placeholder="Share your experience with this store..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-emerald-600 text-white py-2.5 rounded-lg font-black text-[11px] uppercase tracking-wider hover:bg-emerald-700 transition shadow-md">
                            Submit Review
                        </button>
                    </form>
                </div>
            </div>
        @endif
    @endauth

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lucide icons are already loaded globally
        });
        
        function toggleSave(productId) {
            fetch(`/api/products/${productId}/save`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if (data.saved) {
                    // Optional: show toast notification
                    console.log('Product saved');
                }
            }).catch(error => console.error('Error:', error));
        }
    </script>
    @endpush
</x-app-layout>