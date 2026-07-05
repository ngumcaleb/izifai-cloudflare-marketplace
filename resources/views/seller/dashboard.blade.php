<x-seller-layout>
    <x-slot name="title">My Shop Home</x-slot>

    <div class="lg:flex lg:gap-6 animate-fade-in">
        {{-- ====== DESKTOP SIDEBAR (lg+) ====== --}}
        <aside class="hidden lg:flex lg:flex-col lg:w-64 xl:w-72 shrink-0 gap-4">
            <div class="sticky top-[100px] space-y-4">
                {{-- Store Identity --}}
                <div class="flex items-center gap-3 bg-gradient-to-r from-primary/5 to-primary/[0.02] rounded-2xl px-4 py-4 border border-primary/10">
                    <div class="w-11 h-11 rounded-xl overflow-hidden bg-white shadow-sm ring-2 ring-primary/10 shrink-0">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                        @else
                            <x-store-default-logo :store="$store" size="sm" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-sm font-bold text-gray-900 truncate">{{ $store->name }}</h1>
                        <p class="text-[11px] text-gray-500 truncate">{{ auth()->user()->name }}</p>
                    </div>
                </div>

                {{-- Navigation Menu --}}
                <nav class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-1.5 space-y-0.5">
                    <a href="{{ route('seller.products.create') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                        </div>
                        <span>New Item</span>
                    </a>
                    <a href="{{ route('seller.products.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                        </div>
                        <span>Products</span>
                    </a>
                    <a href="{{ route('seller.services.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">handyman</span>
                        </div>
                        <span>Services</span>
                    </a>
                    <a href="{{ route('seller.rentals.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">shelves</span>
                        </div>
                        <span>Rentals</span>
                    </a>
                    <hr class="border-gray-100 mx-2 my-1">
                    <a href="{{ route('seller.orders.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                        </div>
                        <span>Orders</span>
                    </a>
                    <a href="{{ route('seller.wallet.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                        </div>
                        <span>Wallet</span>
                    </a>
                    <a href="{{ route('seller.store-categories.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">category</span>
                        </div>
                        <span>Categories</span>
                    </a>
                    <hr class="border-gray-100 mx-2 my-1">
                    <a href="{{ route('seller.ads.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">campaign</span>
                        </div>
                        <span>Promotions</span>
                    </a>
                    <a href="{{ route('seller.reviews') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">reviews</span>
                        </div>
                        <span>Reviews</span>
                    </a>
                    <a href="{{ route('seller.store.settings') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">settings</span>
                        </div>
                        <span>Settings</span>
                    </a>
                    <hr class="border-gray-100 mx-2 my-1">
                    <a href="{{ route('orders.index') }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                        </div>
                        <span>Purchases</span>
                    </a>
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-gray-700 hover:bg-primary/5 hover:text-primary transition-all group active:scale-[0.98]">
                        <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 1;">storefront</span>
                        </div>
                        <span>My Store</span>
                    </a>
                </nav>

                {{-- Quick Actions --}}
                <div class="flex items-center gap-2">
                    <button onclick="copyToClipboard('{{ route('stores.show', $store->slug) }}', this, 'Copied!')"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-primary hover:border-primary/30 transition-all text-xs font-bold shadow-sm active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[16px] copy-icon">link</span>
                        <span class="copy-label">Copy Link</span>
                    </button>
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank"
                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl bg-primary text-white hover:bg-primary/90 transition-all text-xs font-bold shadow-sm active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                        View Store
                    </a>
                </div>
            </div>
        </aside>

        {{-- ====== MAIN CONTENT ====== --}}
        <div class="flex-1 min-w-0 space-y-3 md:space-y-5">
            {{-- MOBILE: Store Identity Strip (hidden on lg+) --}}
            <div class="lg:hidden flex items-center justify-between gap-3 bg-gradient-to-r from-primary/5 to-primary/[0.02] rounded-xl md:rounded-2xl px-4 py-3 md:px-5 md:py-4 border border-primary/10">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl overflow-hidden bg-white shadow-sm ring-2 ring-primary/10 shrink-0">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                        @else
                            <x-store-default-logo :store="$store" size="sm" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-sm md:text-lg font-bold text-gray-900 truncate">{{ $store->name }}</h1>
                        <p class="text-[11px] md:text-xs text-gray-500 truncate">Welcome back, {{ auth()->user()->name }}!</p>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 shrink-0">
                    <button onclick="copyToClipboard('{{ route('stores.show', $store->slug) }}', this, 'Copied!')"
                            class="w-9 h-9 md:w-auto md:px-3 md:h-9 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-primary hover:border-primary/30 transition-all flex items-center justify-center md:gap-1.5 shadow-sm"
                            title="Copy store link">
                        <span class="material-symbols-outlined text-[18px] md:text-[16px] copy-icon">link</span>
                        <span class="hidden md:inline text-xs font-bold copy-label">Copy Link</span>
                    </button>
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank"
                       class="w-9 h-9 md:w-auto md:px-3 md:h-9 rounded-xl bg-primary text-white hover:bg-primary/90 transition-all flex items-center justify-center md:gap-1.5 shadow-sm"
                       title="View store">
                        <span class="material-symbols-outlined text-[18px] md:text-[16px]">open_in_new</span>
                        <span class="hidden md:inline text-xs font-bold">View Store</span>
                    </a>
                </div>
            </div>

            {{-- KEY METRICS --}}
            <div class="grid grid-cols-4 gap-1.5 md:gap-3">
                <div class="bg-white rounded-lg md:rounded-2xl p-2 md:p-4 shadow-sm border border-gray-100/80 overflow-hidden min-w-0">
                    <div class="flex items-center justify-between mb-0.5 md:mb-2">
                        <span class="text-[8px] md:text-[11px] font-semibold text-gray-500 uppercase tracking-wider truncate">Views</span>
                        <div class="w-4 h-4 md:w-8 md:h-8 rounded md:rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[10px] md:text-[18px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                        </div>
                    </div>
                    <p class="text-sm md:text-2xl lg:text-3xl font-black text-gray-900 leading-tight truncate">{{ number_format($stats['total_views']) }}</p>
                    <div class="flex items-center gap-0.5 md:gap-1 mt-0.5 md:mt-1">
                        <span class="text-[8px] md:text-[11px] font-semibold text-primary truncate">{{ $stats['daily_views'] ?? 0 }} today</span>
                        <span class="material-symbols-outlined text-[9px] hidden md:inline text-primary">trending_up</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg md:rounded-2xl p-2 md:p-4 shadow-sm border border-gray-100/80 overflow-hidden min-w-0">
                    <div class="flex items-center justify-between mb-0.5 md:mb-2">
                        <span class="text-[8px] md:text-[11px] font-semibold text-gray-500 uppercase tracking-wider truncate">Contacts</span>
                        <div class="w-4 h-4 md:w-8 md:h-8 rounded md:rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[10px] md:text-[18px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                        </div>
                    </div>
                    <p class="text-sm md:text-2xl lg:text-3xl font-black text-gray-900 leading-tight truncate">{{ number_format($stats['total_contacts']) }}</p>
                    <div class="flex items-center gap-0.5 md:gap-1 mt-0.5 md:mt-1">
                        <span class="text-[8px] md:text-[11px] font-semibold text-primary truncate">{{ $stats['daily_contacts'] ?? 0 }} today</span>
                        <span class="material-symbols-outlined text-[9px] hidden md:inline text-primary">trending_up</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg md:rounded-2xl p-2 md:p-4 shadow-sm border border-gray-100/80 overflow-hidden min-w-0">
                    <div class="flex items-center justify-between mb-0.5 md:mb-2">
                        <span class="text-[8px] md:text-[11px] font-semibold text-gray-500 uppercase tracking-wider truncate">Items</span>
                        <div class="w-4 h-4 md:w-8 md:h-8 rounded md:rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                            <span class="material-symbols-outlined text-[10px] md:text-[18px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                        </div>
                    </div>
                    <p class="text-sm md:text-2xl lg:text-3xl font-black text-gray-900 leading-tight truncate">{{ $products->count() }}</p>
                    <div class="flex items-center gap-0.5 md:gap-1 mt-0.5 md:mt-1">
                        <span class="text-[8px] md:text-[11px] font-semibold text-gray-500 truncate">listed</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg md:rounded-2xl p-2 md:p-4 shadow-sm border border-gray-100/80 overflow-hidden min-w-0">
                    <div class="flex items-center justify-between mb-0.5 md:mb-2">
                        <span class="text-[8px] md:text-[11px] font-semibold text-gray-500 uppercase tracking-wider truncate">Saves</span>
                        <div class="w-4 h-4 md:w-8 md:h-8 rounded md:rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                            <span class="material-symbols-outlined text-[10px] md:text-[18px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                        </div>
                    </div>
                    <p class="text-sm md:text-2xl lg:text-3xl font-black text-gray-900 leading-tight truncate">{{ number_format($stats['saved_count']) }}</p>
                    <div class="flex items-center gap-0.5 md:gap-1 mt-0.5 md:mt-1">
                        <span class="text-[8px] md:text-[11px] font-semibold text-rose-500 truncate">loves</span>
                    </div>
                </div>
            </div>

            {{-- MOBILE: Quick Access Menu (hidden on lg+, sidebar replaces it) --}}
            <section class="lg:hidden">
                <div class="flex items-center gap-2 mb-2 md:mb-3">
                    <h2 class="text-xs md:text-sm font-bold text-gray-900">Quick Access</h2>
                    <div class="flex-1 h-px bg-gray-100"></div>
                </div>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-1.5 md:gap-2">
                    <a href="{{ route('seller.products.create') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">add_circle</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">New Item</span>
                    </a>
                    <a href="{{ route('seller.products.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Products</span>
                    </a>
                    <a href="{{ route('seller.services.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">handyman</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Services</span>
                    </a>
                    <a href="{{ route('seller.rentals.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">shelves</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Rentals</span>
                    </a>
                    <a href="{{ route('seller.orders.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Orders</span>
                    </a>
                    <a href="{{ route('seller.wallet.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">account_balance_wallet</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Wallet</span>
                    </a>
                    <a href="{{ route('seller.store-categories.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">category</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Categories</span>
                    </a>
                    <a href="{{ route('seller.ads.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">campaign</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Promotions</span>
                    </a>
                    <a href="{{ route('seller.reviews') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">reviews</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Reviews</span>
                    </a>
                    <a href="{{ route('seller.store.settings') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">settings</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Settings</span>
                    </a>
                    <a href="{{ route('orders.index') }}"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">receipt_long</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">Purchases</span>
                    </a>
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank"
                       class="flex flex-col items-center gap-1 md:gap-1.5 p-2 md:p-3 bg-white rounded-xl md:rounded-2xl border border-gray-100/80 shadow-sm hover:border-primary/30 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-[16px] md:text-[20px]" style="font-variation-settings: 'FILL' 1;">storefront</span>
                        </div>
                        <span class="text-[9px] md:text-[11px] font-bold text-gray-600 group-hover:text-primary text-center leading-tight">My Store</span>
                    </a>
                </div>
            </section>

            {{-- ====== SECONDARY CONTENT: Store Info + Insights + Product Links ====== --}}
            {{-- On mobile: collapsible via "Show more" toggle. On desktop: always visible. --}}
            <section x-data="{ showMore: window.innerWidth >= 1024 }">
                {{-- Toggle button (mobile only) --}}
                <button @click="showMore = !showMore"
                        class="w-full lg:hidden flex items-center justify-center gap-2 py-2 md:py-3 text-[11px] md:text-xs font-semibold text-gray-400 hover:text-primary transition-colors">
                    <span x-show="!showMore" class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">expand_more</span>
                        Show more
                    </span>
                    <span x-show="showMore" x-cloak class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">expand_less</span>
                        Show less
                    </span>
                </button>

                {{-- Content --}}
                <div x-show="showMore"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="space-y-3 md:space-y-5 pt-1 md:pt-2">
                    {{-- Store Info + Insights Grid --}}
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 md:gap-4">
                        {{-- Store Info Card --}}
                        <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                            <div class="flex items-center gap-2 mb-4">
                                <div class="w-7 h-7 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">store</span>
                                </div>
                                <h3 class="text-xs font-bold text-gray-900">Store Info</h3>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">location_on</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[9px] font-semibold text-gray-500 uppercase tracking-wider">Location</p>
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $store->location ?: 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">call</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[9px] font-semibold text-gray-500 uppercase tracking-wider">WhatsApp</p>
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $store->whatsapp_number ?: 'Not set' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                        <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-[9px] font-semibold text-gray-500 uppercase tracking-wider">Joined</p>
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $store->created_at ? $store->created_at->format('M Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('seller.store.settings') }}" class="mt-3 w-full flex items-center justify-center gap-1.5 py-2 bg-primary/5 text-primary rounded-xl text-[11px] font-bold hover:bg-primary/10 active:scale-[0.98] transition-all">
                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                Edit Store
                            </a>
                        </div>

                        {{-- Product Insights --}}
                        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
                            {{-- Most Viewed --}}
                            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">visibility</span>
                                    </div>
                                    <h3 class="text-[11px] font-bold text-gray-900">Most Viewed</h3>
                                </div>
                                @if($mostViewed->count() > 0)
                                    <div class="space-y-1.5">
                                        @foreach($mostViewed as $i => $p)
                                            <div class="flex items-center gap-2 {{ $i > 0 ? 'pt-1.5 border-t border-gray-50' : '' }}">
                                                <span class="w-4 text-center text-[9px] font-black {{ $i < 3 ? 'text-primary' : 'text-gray-300' }}">{{ $i + 1 }}</span>
                                                <div class="w-6 h-6 rounded bg-gray-100 overflow-hidden shrink-0">
                                                    @if($p->images->first())
                                                        <img src="{{ $p->images->first()->url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <span class="material-symbols-outlined text-[10px]">image</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-[10px] font-semibold text-gray-900 truncate leading-tight">{{ $p->name }}</p>
                                                </div>
                                                <span class="text-[9px] font-bold text-gray-500 shrink-0">{{ number_format($p->views) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <span class="material-symbols-outlined text-xl text-gray-200">visibility</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">No views yet</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Most Contacted --}}
                            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-lg bg-primary/5 flex items-center justify-center text-primary shrink-0">
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">chat</span>
                                    </div>
                                    <h3 class="text-[11px] font-bold text-gray-900">Most Contacted</h3>
                                </div>
                                @if($mostContacted->count() > 0)
                                    <div class="space-y-1.5">
                                        @foreach($mostContacted as $i => $event)
                                            @if($event->product)
                                            <div class="flex items-center gap-2 {{ $i > 0 ? 'pt-1.5 border-t border-gray-50' : '' }}">
                                                <span class="w-4 text-center text-[9px] font-black {{ $i < 3 ? 'text-primary' : 'text-gray-300' }}">{{ $i + 1 }}</span>
                                                <div class="w-6 h-6 rounded bg-gray-100 overflow-hidden shrink-0">
                                                    @if($event->product->images->first())
                                                        <img src="{{ $event->product->images->first()->url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <span class="material-symbols-outlined text-[10px]">image</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-[10px] font-semibold text-gray-900 truncate leading-tight">{{ $event->product->name }}</p>
                                                </div>
                                                <span class="text-[9px] font-bold text-gray-500 shrink-0">{{ $event->total }}</span>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <span class="material-symbols-outlined text-xl text-gray-200">chat</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">No contacts yet</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Most Saved --}}
                            <div class="bg-white rounded-2xl p-4 md:p-5 shadow-sm border border-gray-100/80">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-lg bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                                    </div>
                                    <h3 class="text-[11px] font-bold text-gray-900">Most Saved</h3>
                                </div>
                                @if($mostSaved->count() > 0)
                                    <div class="space-y-1.5">
                                        @foreach($mostSaved as $i => $saved)
                                            @if($saved->product)
                                            <div class="flex items-center gap-2 {{ $i > 0 ? 'pt-1.5 border-t border-gray-50' : '' }}">
                                                <span class="w-4 text-center text-[9px] font-black {{ $i < 3 ? 'text-primary' : 'text-gray-300' }}">{{ $i + 1 }}</span>
                                                <div class="w-6 h-6 rounded bg-gray-100 overflow-hidden shrink-0">
                                                    @if($saved->product->images->first())
                                                        <img src="{{ $saved->product->images->first()->url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <span class="material-symbols-outlined text-[10px]">image</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <p class="text-[10px] font-semibold text-gray-900 truncate leading-tight">{{ $saved->product->name }}</p>
                                                </div>
                                                <span class="text-[9px] font-bold text-gray-500 shrink-0">{{ $saved->total }}</span>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <span class="material-symbols-outlined text-xl text-gray-200">favorite</span>
                                        <p class="text-[10px] text-gray-400 mt-0.5">No saves yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ACTIVE PRODUCT LINKS --}}
                    <section>
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-xs md:text-sm font-bold text-gray-900">Active Product Links</h2>
                            <a href="{{ route('seller.products.index') }}" class="text-[11px] font-semibold text-primary hover:underline underline-offset-2">Manage all</a>
                        </div>

                        @if($products->count() > 0)
                            <div x-data="{ showAll: false }">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 md:gap-3">
                                    @foreach($products as $i => $product)
                                        <div class="group bg-white rounded-xl md:rounded-2xl overflow-hidden shadow-sm border border-gray-100/80 hover:shadow-md hover:border-gray-200 transition-all"
                                             x-show="showAll || {{ $i < 4 ? 'true' : 'false' }}"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100">
                                            <div class="aspect-[4/3] relative overflow-hidden bg-gray-100">
                                                @if($product->images->first())
                                                    <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <span class="material-symbols-outlined text-2xl">image</span>
                                                    </div>
                                                @endif
                                                <span class="absolute top-1.5 right-1.5 text-white text-[7px] md:text-[8px] font-bold px-1.5 py-0.5 rounded-full uppercase {{ $product->stock_status === 'in_stock' ? 'bg-primary' : 'bg-gray-500' }}">
                                                    {{ $product->stock_status === 'in_stock' ? 'Active' : 'Sold' }}
                                                </span>
                                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/40 to-transparent h-8"></div>
                                                <p class="absolute bottom-1.5 left-2 text-white text-[9px] md:text-[10px] font-bold truncate right-2">{{ number_format($product->views) }} views</p>
                                            </div>
                                            <div class="p-2 md:p-3">
                                                <h4 class="text-[11px] md:text-sm font-bold text-gray-900 truncate">{{ $product->name }}</h4>
                                                <p class="text-xs md:text-sm font-black text-primary mt-0.5">{{ number_format($product->price) }} XAF</p>
                                                <button onclick="event.stopPropagation(); copyToClipboard('{{ route('products.show', $product->slug) }}', this)"
                                                        class="mt-1.5 w-full flex items-center justify-center gap-1 py-1.5 bg-primary/5 text-primary rounded-lg text-[9px] md:text-xs font-bold hover:bg-primary/10 transition-all">
                                                    <span class="material-symbols-outlined text-[12px] md:text-[14px] copy-icon">content_copy</span>
                                                    <span class="copy-label">Copy Link</span>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($products->count() > 4)
                                    <button @click="showAll = !showAll"
                                            class="mt-2 w-full flex items-center justify-center gap-1.5 py-2 text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors rounded-xl hover:bg-gray-50">
                                        <span x-show="!showAll" class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">expand_more</span>
                                            Show all {{ $products->count() }} products
                                        </span>
                                        <span x-show="showAll" x-cloak class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">expand_less</span>
                                            Show less
                                        </span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8 bg-white rounded-2xl shadow-sm border border-gray-100/80">
                                <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center mx-auto mb-2">
                                    <span class="material-symbols-outlined text-xl text-primary" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                                </div>
                                <p class="text-sm font-bold text-gray-900">No products yet</p>
                                <p class="text-xs text-gray-500 mt-1">Start by adding your first product.</p>
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center gap-1.5 mt-3 px-4 py-2 bg-primary text-white rounded-xl text-xs font-bold hover:opacity-90 active:scale-[0.97] transition-all">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                    Add Product
                                </a>
                            </div>
                        @endif
                    </section>
                </div>
            </section>
        </div>
    </div>
</x-seller-layout>
