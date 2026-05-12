<x-seller-layout>
    <x-slot name="title">My Shop Home</x-slot>

    <!-- Shareable Store Link Banner -->
    <div class="bg-surface-container-lowest rounded-2xl md:rounded-3xl p-4 md:p-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">share</span>
            </div>
            <div>
                <p class="font-label-md md:font-label-lg text-primary">Your Public Store Link</p>
                <p class="text-label-sm text-on-surface-variant mt-0.5">Share this link with customers</p>
            </div>
        </div>
        <div class="flex items-center gap-2 w-full md:w-auto">
            <input type="text" value="{{ route('stores.show', $store->slug) }}" readonly
                   class="flex-1 md:w-72 px-3 py-2 bg-surface-container-low border-none rounded-xl text-body-md text-on-surface truncate text-sm">
            <button onclick="navigator.clipboard.writeText('{{ route('stores.show', $store->slug) }}').then(() => { this.querySelector('span').textContent = 'Copied!'; setTimeout(() => this.querySelector('span').textContent = 'Copy', 2000); })"
                    class="px-4 md:px-5 py-2 bg-primary text-white rounded-xl font-label-md hover:opacity-90 transition-opacity shrink-0 text-sm">
                <span>Copy</span>
            </button>
        </div>
    </div>

    <!-- Performance Hub Hero -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-grid-gutter">
        <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl md:rounded-3xl p-4 md:p-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32"></div>
            <div class="relative z-10">
                <span class="text-primary font-label-md md:font-label-lg uppercase tracking-widest mb-2 block">Performance Hub</span>
                <h2 class="text-headline-md md:text-headline-lg mb-4 md:mb-6">Digital Catalog Overview</h2>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 md:gap-md">
                    <div class="bg-surface-container-low p-4 md:p-lg rounded-2xl">
                        <p class="text-label-sm text-on-surface-variant mb-1">Total Views</p>
                        <p class="text-headline-md">{{ number_format($stats['total_views']) }}</p>
                        @php $dailyViews = $stats['daily_views'] ?? 0; @endphp
                        <div class="flex items-center text-primary mt-2">
                            <span class="material-symbols-outlined text-[16px] mr-1">trending_up</span>
                            <span class="text-label-sm">{{ $dailyViews }} today</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-4 md:p-lg rounded-2xl border-2 border-primary/10">
                        <p class="text-label-sm text-on-surface-variant mb-1">Customer Contacts</p>
                        <p class="text-headline-md">{{ $stats['total_contacts'] }}</p>
                        @php $dailyContacts = $stats['daily_contacts'] ?? 0; @endphp
                        <div class="flex items-center text-primary mt-2">
                            <span class="material-symbols-outlined text-[16px] mr-1">trending_up</span>
                            <span class="text-label-sm">{{ $dailyContacts }} today</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-4 md:p-lg rounded-2xl">
                        <p class="text-label-sm text-on-surface-variant mb-1">Items Listed</p>
                        <p class="text-headline-md">{{ $products->count() }}</p>
                        <div class="flex items-center text-on-surface-variant mt-2">
                            <span class="material-symbols-outlined text-[16px] mr-1">inventory_2</span>
                            <span class="text-label-sm">{{ $products->count() }} total</span>
                        </div>
                    </div>
                    <div class="bg-surface-container-low p-4 md:p-lg rounded-2xl border-2 border-rose-100">
                        <p class="text-label-sm text-on-surface-variant mb-1">Product Loves</p>
                        <p class="text-headline-md">{{ number_format($stats['saved_count']) }}</p>
                        <div class="flex items-center text-rose-500 mt-2">
                            <span class="material-symbols-outlined text-[16px] mr-1" style="font-variation-settings: 'FILL' 1;">favorite</span>
                            <span class="text-label-sm">customer saves</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl md:rounded-3xl p-4 md:p-xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] flex flex-col">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <h3 class="text-headline-sm md:text-headline-md">Quick Actions</h3>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 md:gap-lg flex-1">
                <a href="{{ route('seller.products.create') }}"
                   class="flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 bg-surface-container-low rounded-2xl hover:bg-surface-container-high transition-colors group text-center sm:text-left">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform shrink-0">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                    </div>
                    <div>
                        <p class="font-label-md sm:font-label-lg">Add New Product</p>
                        <p class="text-label-sm text-on-surface-variant hidden sm:block">List a new item in your catalog</p>
                    </div>
                </a>
                <a href="{{ route('seller.store.settings') }}"
                   class="flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 bg-surface-container-low rounded-2xl hover:bg-surface-container-high transition-colors group text-center sm:text-left">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform shrink-0">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">store</span>
                    </div>
                    <div>
                        <p class="font-label-md sm:font-label-lg">Store Settings</p>
                        <p class="text-label-sm text-on-surface-variant hidden sm:block">Update your business details</p>
                    </div>
                </a>
                <a href="{{ route('seller.ads.index') }}"
                   class="flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 bg-surface-container-low rounded-2xl hover:bg-surface-container-high transition-colors group text-center sm:text-left">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform shrink-0">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">campaign</span>
                    </div>
                    <div>
                        <p class="font-label-md sm:font-label-lg">Promote Items</p>
                        <p class="text-label-sm text-on-surface-variant hidden sm:block">Boost your product visibility</p>
                    </div>
                </a>
                @if($store->whatsapp_number)
                    <a href="https://wa.me/{{ $store->whatsapp_number }}" target="_blank"
                       class="flex flex-col sm:flex-row items-center sm:items-center gap-2 sm:gap-4 p-3 sm:p-4 bg-green-50 rounded-2xl hover:bg-green-100 transition-colors group border border-green-200 text-center sm:text-left">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-green-600/10 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform shrink-0">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">chat</span>
                        </div>
                        <div>
                            <p class="font-label-md sm:font-label-lg text-green-700">WhatsApp Support</p>
                            <p class="text-label-sm text-on-surface-variant hidden sm:block">Chat with admin for help</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Active Product Links -->
    <section class="space-y-lg">
        <div class="flex items-center justify-between">
            <h3 class="text-headline-md">Active Product Links</h3>
            <a href="{{ route('seller.products.index') }}" class="text-primary font-label-md hover:underline">Manage all</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-grid-gutter">
            @forelse($products->take(8) as $product)
                <div class="bg-surface-container-lowest p-md rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] hover:-translate-y-1 transition-transform duration-300">
                    <div class="aspect-square rounded-2xl overflow-hidden mb-md relative bg-surface-container-high">
                        @if($product->images->first())
                            <img src="{{ asset('storage/' . $product->images->first()->path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                <span class="material-symbols-outlined text-5xl">image</span>
                            </div>
                        @endif
                        <span class="absolute top-2 right-2 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                            {{ $product->stock_status === 'in_stock' ? 'Active' : 'Out of Stock' }}
                        </span>
                    </div>
                    <h4 class="font-label-lg mb-1 truncate">{{ $product->name }}</h4>
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <p class="text-headline-md text-primary">{{ number_format($product->price) }} XAF</p>
                            <p class="text-label-sm text-on-surface-variant">{{ number_format($product->views) }} clicks</p>
                        </div>
                    </div>
                    <button onclick="navigator.clipboard.writeText('{{ route('products.show', $product->slug) }}').then(() => { this.querySelector('span').textContent = 'Copied!'; this.querySelector('.copy-label').textContent = 'Copied!'; setTimeout(() => { this.querySelector('span').textContent = 'content_copy'; this.querySelector('.copy-label').textContent = 'Copy Link'; }, 2000); })"
                            class="w-full bg-primary-container/10 text-primary py-2 rounded-xl font-label-md flex items-center justify-center gap-2 hover:bg-primary-container/20 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">content_copy</span>
                        <span class="copy-label">Copy Link</span>
                    </button>
                </div>
            @empty
                <div class="col-span-full text-center py-16 bg-surface-container-lowest rounded-3xl">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">inventory_2</span>
                    <p class="text-headline-md text-on-surface-variant mt-4">No products listed yet</p>
                    <p class="text-body-md text-on-surface-variant/60 mt-2">Start by adding your first product</p>
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-2 mt-6 bg-primary text-white px-6 py-2.5 rounded-full font-label-lg hover:opacity-90 transition-opacity">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        Add Product
                    </a>
                </div>
            @endforelse
        </div>
    </section>
</x-seller-layout>
