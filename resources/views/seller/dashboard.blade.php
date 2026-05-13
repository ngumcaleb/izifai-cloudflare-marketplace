<x-seller-layout>
    <x-slot name="title">My Shop Home</x-slot>

    {{-- GREETING + STORE LINK --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-on-surface">
                Hey, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="text-sm text-on-surface-variant mt-0.5">Here's what's happening with your store today.</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <input type="text" value="{{ route('stores.show', $store->slug) }}" readonly
                   class="flex-1 sm:w-56 px-3 py-2 bg-surface-container-low border border-outline-variant/20 rounded-xl text-sm text-on-surface truncate">
             <button onclick="copyToClipboard('{{ route('stores.show', $store->slug) }}', this, 'Copied!')"
                    class="px-3 py-2 bg-primary text-on-primary rounded-xl text-sm font-bold hover:opacity-90 transition-opacity shrink-0 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px] copy-icon">link</span>
                <span class="hidden sm:inline copy-label">Copy Link</span>
            </button>
        </div>
    </div>

    {{-- KEY METRICS --}}
    <div class="grid grid-cols-2 gap-3 md:gap-4">
        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Views</span>
                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-black text-on-surface">{{ number_format($stats['total_views']) }}</p>
            <div class="flex items-center gap-1 mt-1">
                <span class="text-[11px] font-semibold text-primary">{{ $stats['daily_views'] ?? 0 }} today</span>
                <span class="material-symbols-outlined text-[14px] text-primary">trending_up</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Contacts</span>
                <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-black text-on-surface">{{ number_format($stats['total_contacts']) }}</p>
            <div class="flex items-center gap-1 mt-1">
                <span class="text-[11px] font-semibold text-primary">{{ $stats['daily_contacts'] ?? 0 }} today</span>
                <span class="material-symbols-outlined text-[14px] text-primary">trending_up</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Products</span>
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-black text-on-surface">{{ $products->count() }}</p>
            <div class="flex items-center gap-1 mt-1">
                <span class="text-[11px] font-semibold text-on-surface-variant">listed items</span>
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">Saves</span>
                <div class="w-8 h-8 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500">
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                </div>
            </div>
            <p class="text-2xl md:text-3xl font-black text-on-surface">{{ number_format($stats['saved_count']) }}</p>
            <div class="flex items-center gap-1 mt-1">
                <span class="text-[11px] font-semibold text-rose-500">customer loves</span>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS + RECENT ACTIVITY --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4">
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm md:text-base font-bold text-on-surface">Quick Actions</h2>
                <a href="{{ route('seller.products.index') }}" class="text-xs font-semibold text-primary hover:underline">Manage Items</a>
            </div>
            <div class="flex gap-2 overflow-x-auto no-scrollbar pb-1">
                <a href="{{ route('seller.products.create') }}"
                   class="flex flex-col items-center gap-1.5 min-w-[80px] p-3 bg-surface-container-low rounded-xl hover:bg-primary/10 hover:text-primary transition-all group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                    </div>
                    <span class="text-[10px] font-bold text-on-surface-variant group-hover:text-primary text-center leading-tight">Add Product</span>
                </a>
                <a href="{{ route('seller.store.settings') }}"
                   class="flex flex-col items-center gap-1.5 min-w-[80px] p-3 bg-surface-container-low rounded-xl hover:bg-primary/10 hover:text-primary transition-all group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">store</span>
                    </div>
                    <span class="text-[10px] font-bold text-on-surface-variant group-hover:text-primary text-center leading-tight">Store Settings</span>
                </a>
                <a href="{{ route('seller.ads.index') }}"
                   class="flex flex-col items-center gap-1.5 min-w-[80px] p-3 bg-surface-container-low rounded-xl hover:bg-primary/10 hover:text-primary transition-all group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">campaign</span>
                    </div>
                    <span class="text-[10px] font-bold text-on-surface-variant group-hover:text-primary text-center leading-tight">Promote Items</span>
                </a>
                <a href="{{ route('seller.reviews') }}"
                   class="flex flex-col items-center gap-1.5 min-w-[80px] p-3 bg-surface-container-low rounded-xl hover:bg-primary/10 hover:text-primary transition-all group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">reviews</span>
                    </div>
                    <span class="text-[10px] font-bold text-on-surface-variant group-hover:text-primary text-center leading-tight">Reviews</span>
                </a>
                @if($store->whatsapp_number)
                    <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                       class="flex flex-col items-center gap-1.5 min-w-[80px] p-3 bg-green-50 rounded-xl hover:bg-green-100 transition-all group shrink-0">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                        </div>
                        <span class="text-[10px] font-bold text-green-700 text-center leading-tight">Support</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="bg-surface-container-lowest rounded-2xl p-4 md:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm md:text-base font-bold text-on-surface">Store Info</h2>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px]">location_on</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold text-on-surface-variant uppercase tracking-wider">Location</p>
                        <p class="text-sm font-bold text-on-surface truncate">{{ $store->location ?: 'Not set' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px]">call</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold text-on-surface-variant uppercase tracking-wider">WhatsApp</p>
                        <p class="text-sm font-bold text-on-surface truncate">{{ $store->whatsapp_number ?: 'Not set' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold text-on-surface-variant uppercase tracking-wider">Joined</p>
                        <p class="text-sm font-bold text-on-surface truncate">{{ $store->created_at ? $store->created_at->format('M Y') : 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <a href="{{ route('seller.store.settings') }}" class="mt-4 w-full flex items-center justify-center gap-1.5 py-2.5 bg-primary/5 text-primary rounded-xl text-xs font-bold hover:bg-primary/10 transition-all">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                Edit Store
            </a>
        </div>
    </div>

    {{-- ACTIVE PRODUCT LINKS --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm md:text-base font-bold text-on-surface">Active Product Links</h2>
            <a href="{{ route('seller.products.index') }}" class="text-xs font-semibold text-primary hover:underline">Manage all</a>
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                @foreach($products->take(8) as $product)
                    <div class="group bg-surface-container-lowest rounded-xl md:rounded-2xl overflow-hidden shadow-sm border border-outline-variant/10 hover:shadow-md transition-all">
                        <div class="aspect-[4/3] relative overflow-hidden bg-surface-container-high">
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                    <span class="material-symbols-outlined text-3xl">image</span>
                                </div>
                            @endif
                            <span class="absolute top-1.5 right-1.5 bg-primary text-white text-[8px] font-bold px-1.5 py-0.5 rounded-full uppercase {{ $product->stock_status === 'in_stock' ? 'bg-primary' : 'bg-on-surface-variant' }}">
                                {{ $product->stock_status === 'in_stock' ? 'Active' : 'Sold' }}
                            </span>
                            <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/40 to-transparent h-8"></div>
                            <p class="absolute bottom-1.5 left-2 text-white text-[10px] font-bold truncate right-2">{{ number_format($product->views) }} views</p>
                        </div>
                        <div class="p-2.5 md:p-3">
                            <h4 class="text-xs md:text-sm font-bold text-on-surface truncate">{{ $product->name }}</h4>
                            <p class="text-sm md:text-base font-black text-primary mt-0.5">{{ number_format($product->price) }} XAF</p>
                            <button onclick="event.stopPropagation(); copyToClipboard('{{ route('products.show', $product->slug) }}', this)"
                                    class="mt-2 w-full flex items-center justify-center gap-1 py-1.5 bg-primary-container/10 text-primary rounded-lg text-[10px] md:text-xs font-bold hover:bg-primary-container/20 transition-all">
                                <span class="material-symbols-outlined text-[14px] copy-icon">content_copy</span>
                                <span class="copy-label">Copy Link</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 bg-surface-container-lowest rounded-2xl border border-outline-variant/10">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-2xl text-primary" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                </div>
                <p class="text-sm font-bold text-on-surface">No products yet</p>
                <p class="text-xs text-on-surface-variant mt-1">Start by adding your first product.</p>
                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-1.5 mt-4 px-5 py-2.5 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[16px]">add</span>
                    Add Product
                </a>
            </div>
        @endif
    </section>
</x-seller-layout>
