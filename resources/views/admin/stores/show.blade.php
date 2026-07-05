<x-admin-layout>
    <x-slot name="header">Business Profile</x-slot>

    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-gold-500 uppercase tracking-widest transition-all">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Back to Directory
        </a>

        <!-- Store Hero Header Card -->
        <div class="relative bg-navy-800 rounded-2xl p-6 md:p-10 overflow-hidden shadow-xl">
            <div class="absolute right-0 top-0 w-64 h-64 bg-gold-400/10 rounded-bl-[200px] -z-0"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl overflow-hidden shrink-0 shadow-2xl ring-2 ring-white/20">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                        @else
                            <x-store-default-logo :store="$store" size="2xl" class="rounded-2xl" />
                        @endif
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-tight">{{ $store->name }}</h1>
                            <div class="flex gap-2">
                                @if($store->is_verified)
                                    <span class="px-2.5 py-1 bg-emerald-500 text-white text-[8px] font-bold uppercase tracking-widest rounded-lg shadow-lg shadow-emerald-500/20">Verified Partner</span>
                                @else
                                    <span class="px-2.5 py-1 bg-gold-500 text-white text-[8px] font-bold uppercase tracking-widest rounded-lg">Awaiting Review</span>
                                @endif
                                @if($store->status === 'suspended')
                                    <span class="px-2.5 py-1 bg-rose-500 text-white text-[8px] font-bold uppercase tracking-widest rounded-lg shadow-lg shadow-rose-500/20">Suspended</span>
                                @endif
                            </div>
                        </div>
                        <p class="text-[10px] md:text-xs text-slate-300 font-medium uppercase tracking-[0.2em]">Merchant ID: #{{ str_pad($store->id, 6, '0', STR_PAD_LEFT) }} • Joined {{ $store->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('stores.show', $store->slug) }}" target="_blank" class="px-5 py-3 bg-white/10 hover:bg-gold-400 text-slate-300 hover:text-white rounded-xl text-[10px] font-bold uppercase tracking-widest inline-flex items-center gap-2 border border-white/10 hover:border-gold-400 transition-all">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Visit Store
                    </a>
                    @if(!$store->is_verified)
                    <form action="{{ route('admin.stores.verify', $store) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-gold-500 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-white hover:text-[#006d38] transition-all shadow-lg shadow-gold-500/20 flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4"></i>
                            Approve Store
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
        <div class="bg-emerald-500 text-white p-4 rounded-xl shadow-lg flex items-center gap-4">
            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                <i data-lucide="check" class="w-5 h-5"></i>
            </div>
            <span class="text-xs font-bold">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="admin-card p-4 md:p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="package" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[18px] md:text-2xl font-black text-navy-800 leading-none">{{ $productCount }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Products</p>
                </div>
            </div>
            <div class="admin-card p-4 md:p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 shrink-0">
                    <i data-lucide="tool" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[18px] md:text-2xl font-black text-navy-800 leading-none">{{ $serviceCount }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Services</p>
                </div>
            </div>
            <div class="admin-card p-4 md:p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 shrink-0">
                    <i data-lucide="archive" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[18px] md:text-2xl font-black text-navy-800 leading-none">{{ $rentalCount }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Rentals</p>
                </div>
            </div>
            <div class="admin-card p-4 md:p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 shrink-0">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[18px] md:text-2xl font-black text-navy-800 leading-none">{{ $reviewCount }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Store Reviews</p>
                </div>
            </div>
            <div class="admin-card p-4 md:p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-gold-50 rounded-xl flex items-center justify-center text-gold-600 shrink-0">
                    <i data-lucide="star" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[18px] md:text-2xl font-black text-navy-800 leading-none">{{ $avgRating ? number_format($avgRating, 1) : '—' }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Avg Rating</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Merchant Intelligence -->
                <div class="admin-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50">
                        <h2 class="text-xs font-bold text-navy-800 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="bar-chart-3" class="w-4 h-4 text-gold-400"></i>
                            Merchant Intelligence
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div>
                                    <dt class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2">Legal Owner</dt>
                                    <dd class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-50 text-navy-800 rounded-xl flex items-center justify-center font-bold text-xs border border-slate-100 shadow-sm">{{ substr($store->user->name, 0, 1) }}</div>
                                        <div>
                                            <span class="block text-[13px] font-bold text-navy-800">{{ $store->user->name }}</span>
                                            <span class="block text-[10px] text-slate-400 font-medium">{{ $store->user->email }}</span>
                                        </div>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2">Primary Location</dt>
                                    <dd class="text-[13px] font-bold text-navy-800 flex items-center gap-2">
                                        <i data-lucide="map-pin" class="w-4 h-4 text-gold-400"></i>
                                        {{ $store->location ?? 'Global / Online' }}
                                    </dd>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div>
                                    <dt class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-2">Communications</dt>
                                    <dd class="space-y-3">
                                        <div class="flex items-center gap-3 text-[13px] font-bold text-navy-800">
                                            <div class="w-7 h-7 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                                                <i data-lucide="phone" class="w-4 h-4"></i>
                                            </div>
                                            {{ $store->whatsapp_number }}
                                        </div>
                                        <div class="flex items-center gap-3 text-[13px] font-bold text-navy-800">
                                            <div class="w-7 h-7 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                                                <i data-lucide="message-square" class="w-4 h-4"></i>
                                            </div>
                                            {{ $store->phone_number ?? 'No alternate phone' }}
                                        </div>
                                    </dd>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 pt-8 border-t border-slate-50">
                            <dt class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-3">Merchant Bio</dt>
                            <dd class="text-sm text-slate-600 leading-relaxed font-medium italic">
                                "{{ $store->description ?? 'No business description provided.' }}"
                            </dd>
                        </div>
                    </div>
                </div>

                <!-- Financial Overview -->
                @if($wallet)
                <div class="admin-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50">
                        <h2 class="text-xs font-bold text-navy-800 uppercase tracking-widest flex items-center gap-2">
                            <i data-lucide="wallet" class="w-4 h-4 text-emerald-500"></i>
                            Financial Overview
                        </h2>
                    </div>
                    <div class="p-8">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                            <div class="p-5 bg-emerald-50 rounded-2xl border border-emerald-100">
                                <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mb-1">Balance</p>
                                <p class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($wallet->balance ?? 0) }}</p>
                            </div>
                            <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100">
                                <p class="text-[9px] font-bold text-amber-600 uppercase tracking-widest mb-1">Locked</p>
                                <p class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($wallet->locked_balance ?? 0) }}</p>
                            </div>
                            <div class="p-5 bg-blue-50 rounded-2xl border border-blue-100">
                                <p class="text-[9px] font-bold text-blue-600 uppercase tracking-widest mb-1">Withdrawable</p>
                                <p class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($wallet->balance ?? 0) }}</p>
                            </div>
                            <div class="p-5 bg-purple-50 rounded-2xl border border-purple-100">
                                <p class="text-[9px] font-bold text-purple-600 uppercase tracking-widest mb-1">Total Earned</p>
                                <p class="text-xl md:text-2xl font-black text-navy-800">XAF {{ number_format($wallet->total_earned ?? 0) }}</p>
                            </div>
                        </div>

                        @if($recentTransactions->isNotEmpty())
                        <div>
                            <h4 class="text-[10px] font-bold text-navy-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                                <i data-lucide="list" class="w-3.5 h-3.5 text-slate-400"></i>
                                Recent Transactions
                            </h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="border-b border-slate-50">
                                            <th class="px-4 py-3 text-[8px] font-bold text-slate-400 uppercase tracking-widest">Type</th>
                                            <th class="px-4 py-3 text-[8px] font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                                            <th class="px-4 py-3 text-[8px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                            <th class="px-4 py-3 text-[8px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($recentTransactions as $txn)
                                        <tr class="hover:bg-slate-50/30 transition-colors">
                                            <td class="px-4 py-3">
                                                <span class="text-[11px] font-bold text-navy-800 capitalize">{{ $txn->type }}</span>
                                                @if($txn->description)
                                                <p class="text-[8px] text-slate-400 mt-0.5">{{ Str::limit($txn->description, 40) }}</p>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="text-[11px] font-bold {{ $txn->type === 'deposit' || $txn->type === 'payment' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                    {{ $txn->type === 'deposit' || $txn->type === 'payment' ? '+' : '-' }}XAF {{ number_format($txn->amount) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-1.5 py-0.5 text-[7px] font-bold uppercase rounded {{ $txn->status === 'completed' ? 'bg-emerald-50 text-emerald-600' : ($txn->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-rose-50 text-rose-600') }}">
                                                    {{ $txn->status }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-[10px] text-slate-500 font-medium">{{ $txn->created_at->format('d M H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Tabbed Listings -->
                <div x-data="{ tab: '{{ request()->hasAny(['service_search', 'service_status', 'rental_search', 'rental_status']) ? 'services' : (request()->hasAny(['product_search', 'product_stock']) ? 'products' : 'products') }}' }">
                    <!-- Tab Navigation -->
                    <div class="flex flex-wrap items-center gap-1.5 border-b border-slate-100 pb-0.5">
                        <button @click="tab = 'products'" :class="{ 'bg-navy-800 text-white shadow-md': tab === 'products', 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100': tab !== 'products' }" class="px-4 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all inline-flex items-center gap-2">
                            <i data-lucide="package" class="w-3.5 h-3.5"></i>
                            Products ({{ $productCount }})
                        </button>
                        <button @click="tab = 'services'" :class="{ 'bg-navy-800 text-white shadow-md': tab === 'services', 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100': tab !== 'services' }" class="px-4 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all inline-flex items-center gap-2">
                            <i data-lucide="tool" class="w-3.5 h-3.5"></i>
                            Services ({{ $serviceCount }})
                        </button>
                        <button @click="tab = 'rentals'" :class="{ 'bg-navy-800 text-white shadow-md': tab === 'rentals', 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100': tab !== 'rentals' }" class="px-4 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all inline-flex items-center gap-2">
                            <i data-lucide="archive" class="w-3.5 h-3.5"></i>
                            Rentals ({{ $rentalCount }})
                        </button>
                        <button @click="tab = 'reviews'" :class="{ 'bg-navy-800 text-white shadow-md': tab === 'reviews', 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100': tab !== 'reviews' }" class="px-4 py-2.5 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all inline-flex items-center gap-2">
                            <i data-lucide="star" class="w-3.5 h-3.5"></i>
                            Reviews ({{ $reviewCount + $productReviewCount + $serviceReviewCounts->sum() }})
                        </button>
                    </div>

                    <!-- Products Tab -->
                    <div x-show="tab === 'products'" x-cloak class="admin-card overflow-hidden mt-4">
                        <div class="px-6 py-5 border-b border-slate-50">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Products ({{ $productCount }})</h3>
                                <form action="{{ route('admin.stores.show', $store) }}" method="GET" class="flex flex-wrap gap-2">
                                    <input type="text" name="product_search" value="{{ request('product_search') }}"
                                           placeholder="Search products..."
                                           class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all w-full sm:w-auto">
                                    <select name="product_stock" class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                                        <option value="">All Stock</option>
                                        <option value="in_stock" {{ request('product_stock') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                        <option value="out_of_stock" {{ request('product_stock') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-navy-800 text-white rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-navy-900 transition-all">Filter</button>
                                    @if(request()->anyFilled(['product_search', 'product_stock']))
                                    <a href="{{ route('admin.stores.show', $store) }}" class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">Clear</a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Product</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Price</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Stock</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($products as $product)
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                                    @if($product->mainImage)
                                                        <img src="{{ $product->mainImage->url }}" class="w-full h-full object-cover">
                                                    @elseif($product->images->first())
                                                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <i data-lucide="image" class="w-4 h-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[12px] font-bold text-navy-800 leading-tight">{{ $product->name }}</p>
                                                    @if($product->category)
                                                    <span class="text-[9px] text-slate-400 font-medium">{{ $product->category->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-[12px] font-bold text-navy-800">XAF {{ number_format($product->price, 2) }}</span>
                                            @if($product->old_price)
                                            <span class="text-[9px] text-slate-400 line-through ml-1">XAF {{ number_format($product->old_price, 2) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($product->stock_status === 'in_stock')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded">In Stock</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-bold uppercase rounded">Out of Stock</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.products.show', $product) }}" class="p-2 bg-navy-50 text-navy-700 hover:bg-navy-800 hover:text-white rounded-lg transition-all" title="Manage">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </a>
                                                <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all" title="View on site">
                                                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i>
                                                </a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Permanently delete &quot;{{ str_replace("'", '’', $product->name) }}&quot;?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete product">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center text-slate-400 italic text-sm">No products found matching your criteria.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden divide-y divide-slate-50">
                            @forelse($products as $product)
                            <div class="p-4 flex items-center gap-3">
                                <div class="w-14 h-14 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                    @if($product->mainImage)
                                        <img src="{{ $product->mainImage->url }}" class="w-full h-full object-cover">
                                    @elseif($product->images->first())
                                        <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12px] font-bold text-navy-800 truncate">{{ $product->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">XAF {{ number_format($product->price, 2) }}</p>
                                    <span class="px-1.5 py-0.5 {{ $product->stock_status === 'in_stock' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} text-[7px] font-bold uppercase rounded">{{ $product->stock_status === 'in_stock' ? 'In Stock' : 'Out of Stock' }}</span>
                                </div>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Permanently delete &quot;{{ str_replace("'", '’', $product->name) }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <div class="p-10 text-center text-slate-400 italic text-xs">No products found.</div>
                            @endforelse
                        </div>

                        @if($products->hasPages())
                        <div class="px-6 py-4 border-t border-slate-50">
                            {{ $products->links('partials.pagination') }}
                        </div>
                        @endif
                    </div>

                    <!-- Services Tab -->
                    <div x-show="tab === 'services'" x-cloak class="admin-card overflow-hidden mt-4">
                        <div class="px-6 py-5 border-b border-slate-50">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Services ({{ $serviceCount }})</h3>
                                <form action="{{ route('admin.stores.show', $store) }}" method="GET" class="flex flex-wrap gap-2">
                                    <input type="text" name="service_search" value="{{ request('service_search') }}"
                                           placeholder="Search services..."
                                           class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all w-full sm:w-auto">
                                    <select name="service_status" class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('service_status') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('service_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-navy-800 text-white rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-navy-900 transition-all">Filter</button>
                                    @if(request()->anyFilled(['service_search', 'service_status']))
                                    <a href="{{ route('admin.stores.show', $store) }}" class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">Clear</a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Service</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Starting At</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Reviews</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($services as $service)
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                                    @if($service->mainImage)
                                                        <img src="{{ $service->mainImage?->url ?? $service->images->first()?->url }}" class="w-full h-full object-cover">
                                                    @elseif($service->images->first())
                                                        <img src="{{ $service->images->first()->url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <i data-lucide="image" class="w-4 h-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[12px] font-bold text-navy-800 leading-tight">{{ $service->name }}</p>
                                                    @if($service->category)
                                                    <span class="text-[9px] text-slate-400 font-medium">{{ $service->category->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-[12px] font-bold text-navy-800">XAF {{ number_format($service->starting_price, 2) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col gap-1">
                                                <span class="px-2 py-0.5 {{ $service->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[8px] font-bold uppercase rounded inline-block w-fit">{{ $service->status }}</span>
                                                @if($service->approval_status === 'pending')
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-bold uppercase rounded inline-block w-fit">Pending Approval</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-[11px] text-slate-500 font-medium">
                                            {{ $serviceReviewCounts[$service->id] ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.services.show', $service) }}" class="p-2 bg-navy-50 text-navy-700 hover:bg-navy-800 hover:text-white rounded-lg transition-all" title="Manage">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </a>
                                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Permanently delete service &quot;{{ str_replace("'", '’', $service->name) }}&quot;?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete service">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-slate-400 italic text-sm">No services found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden divide-y divide-slate-50">
                            @forelse($services as $service)
                            <div class="p-4 flex items-center gap-3">
                                <div class="w-14 h-14 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                    @if($service->mainImage)
                                        <img src="{{ $service->mainImage?->url ?? $service->images->first()?->url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12px] font-bold text-navy-800 truncate">{{ $service->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">XAF {{ number_format($service->starting_price, 2) }}</p>
                                    <span class="px-1.5 py-0.5 {{ $service->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[7px] font-bold uppercase rounded">{{ $service->status }}</span>
                                </div>
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete &quot;{{ str_replace("'", '’', $service->name) }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <div class="p-10 text-center text-slate-400 italic text-xs">No services found.</div>
                            @endforelse
                        </div>

                        @if($services->hasPages())
                        <div class="px-6 py-4 border-t border-slate-50">
                            {{ $services->links('partials.pagination') }}
                        </div>
                        @endif
                    </div>

                    <!-- Rentals Tab -->
                    <div x-show="tab === 'rentals'" x-cloak class="admin-card overflow-hidden mt-4">
                        <div class="px-6 py-5 border-b border-slate-50">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Rentals ({{ $rentalCount }})</h3>
                                <form action="{{ route('admin.stores.show', $store) }}" method="GET" class="flex flex-wrap gap-2">
                                    <input type="text" name="rental_search" value="{{ request('rental_search') }}"
                                           placeholder="Search rentals..."
                                           class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all w-full sm:w-auto">
                                    <select name="rental_status" class="px-3 py-1.5 bg-slate-50 border-none rounded-lg text-[11px] font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                                        <option value="">All Status</option>
                                        <option value="active" {{ request('rental_status') === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ request('rental_status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <button type="submit" class="px-3 py-1.5 bg-navy-800 text-white rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-navy-900 transition-all">Filter</button>
                                    @if(request()->anyFilled(['rental_search', 'rental_status']))
                                    <a href="{{ route('admin.stores.show', $store) }}" class="px-3 py-1.5 bg-slate-100 text-slate-500 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">Clear</a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50">
                                    <tr>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Item</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Rate</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Deposit</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                        <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($rentals as $rental)
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                                    @if($rental->main_image_url)
                                                        <img src="{{ $rental->main_image_url }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                            <i data-lucide="image" class="w-4 h-4"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[12px] font-bold text-navy-800 leading-tight">{{ $rental->name }}</p>
                                                    @if($rental->category)
                                                    <span class="text-[9px] text-slate-400 font-medium">{{ $rental->category->name }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-[12px] font-bold text-navy-800">XAF {{ number_format($rental->rate) }}/{{ $rental->billing_unit ?? 'day' }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-[11px] font-bold text-navy-800">XAF {{ number_format($rental->deposit ?? 0) }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-0.5 {{ $rental->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[8px] font-bold uppercase rounded">{{ $rental->status }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.rentals.show', $rental) }}" class="p-2 bg-navy-50 text-navy-700 hover:bg-navy-800 hover:text-white rounded-lg transition-all" title="Manage">
                                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                                </a>
                                                <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST" onsubmit="return confirm('Permanently delete &quot;{{ str_replace("'", '’', $rental->name) }}&quot;?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete rental">
                                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-slate-400 italic text-sm">No rental items found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="md:hidden divide-y divide-slate-50">
                            @forelse($rentals as $rental)
                            <div class="p-4 flex items-center gap-3">
                                <div class="w-14 h-14 bg-slate-100 rounded-lg overflow-hidden shrink-0">
                                    @if($rental->main_image_url)
                                        <img src="{{ $rental->main_image_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i data-lucide="image" class="w-5 h-5"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[12px] font-bold text-navy-800 truncate">{{ $rental->name }}</p>
                                    <p class="text-[10px] text-slate-500 font-medium">XAF {{ number_format($rental->rate) }}/{{ $rental->billing_unit ?? 'day' }}</p>
                                    <span class="px-1.5 py-0.5 {{ $rental->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} text-[7px] font-bold uppercase rounded">{{ $rental->status }}</span>
                                </div>
                                <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST" onsubmit="return confirm('Delete &quot;{{ str_replace("'", '’', $rental->name) }}&quot;?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                            @empty
                            <div class="p-10 text-center text-slate-400 italic text-xs">No rentals found.</div>
                            @endforelse
                        </div>

                        @if($rentals->hasPages())
                        <div class="px-6 py-4 border-t border-slate-50">
                            {{ $rentals->links('partials.pagination') }}
                        </div>
                        @endif
                    </div>

                    <!-- Reviews Tab -->
                    <div x-show="tab === 'reviews'" x-cloak class="mt-4 space-y-6">
                        <!-- Store Reviews -->
                        @if($storeReviews->isNotEmpty())
                        <div class="admin-card overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-50">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Store Reviews ({{ $storeReviews->total() }})</h3>
                            </div>
                            <div class="divide-y divide-slate-50">
                                @foreach($storeReviews as $review)
                                <div class="px-6 py-5 hover:bg-slate-50/30 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-[11px] text-navy-800 shrink-0">
                                                {{ substr($review->user->name ?? 'A', 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-[12px] font-bold text-navy-800">{{ $review->user->name ?? 'Anonymous' }}</span>
                                                    <span class="flex items-center gap-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star" class="w-3 h-3 {{ $i <= ($review->rating ?? 0) ? 'text-gold-400 fill-gold-400' : 'text-slate-200' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                                @if($review->comment)
                                                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $review->comment }}</p>
                                                @endif
                                                <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.reviews.store.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this review?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @if($storeReviews->hasPages())
                            <div class="px-6 py-4 border-t border-slate-50">
                                {{ $storeReviews->links('partials.pagination') }}
                            </div>
                            @endif
                        </div>
                        @endif

                        <!-- Recent Product Reviews -->
                        @if($recentProductReviews->isNotEmpty())
                        <div class="admin-card overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-50">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Recent Product Reviews ({{ $productReviewCount }} total)</h3>
                            </div>
                            <div class="divide-y divide-slate-50">
                                @foreach($recentProductReviews as $review)
                                <div class="px-6 py-4 hover:bg-slate-50/30 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-[11px] text-navy-800 shrink-0">
                                                {{ substr($review->user->name ?? 'A', 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-[12px] font-bold text-navy-800">{{ $review->user->name ?? 'Anonymous' }}</span>
                                                    <span class="flex items-center gap-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star" class="w-3 h-3 {{ $i <= ($review->rating ?? 0) ? 'text-gold-400 fill-gold-400' : 'text-slate-200' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $review->comment ?? 'No comment' }}</p>
                                                <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.reviews.product.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this product review?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Recent Service Reviews -->
                        @if($recentServiceReviews->isNotEmpty())
                        <div class="admin-card overflow-hidden">
                            <div class="px-6 py-5 border-b border-slate-50">
                                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Recent Service Reviews ({{ $serviceReviewCounts->sum() }} total)</h3>
                            </div>
                            <div class="divide-y divide-slate-50">
                                @foreach($recentServiceReviews as $review)
                                <div class="px-6 py-4 hover:bg-slate-50/30 transition-colors">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <div class="w-8 h-8 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-[11px] text-navy-800 shrink-0">
                                                {{ substr($review->user->name ?? 'A', 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-[12px] font-bold text-navy-800">{{ $review->user->name ?? 'Anonymous' }}</span>
                                                    <span class="flex items-center gap-0.5">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i data-lucide="star" class="w-3 h-3 {{ $i <= ($review->rating ?? 0) ? 'text-gold-400 fill-gold-400' : 'text-slate-200' }}"></i>
                                                        @endfor
                                                    </span>
                                                </div>
                                                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $review->comment ?? 'No comment' }}</p>
                                                <p class="text-[9px] text-slate-400 font-medium mt-1">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.reviews.service.destroy', $review) }}" method="POST" onsubmit="return confirm('Delete this service review?')">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors">
                                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($storeReviews->isEmpty() && $recentProductReviews->isEmpty() && $recentServiceReviews->isEmpty())
                        <div class="admin-card p-10 text-center">
                            <i data-lucide="message-square" class="w-8 h-8 text-slate-200 mx-auto mb-3"></i>
                            <p class="text-sm text-slate-400 italic">No reviews yet for this store.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Management Tools (Sidebar) -->
            <div class="space-y-6">
                <!-- Authority & Badges -->
                <div class="admin-card bg-navy-900 border-none p-8 relative overflow-hidden shadow-xl">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-gold-400/5 rounded-full"></div>
                    <h3 class="text-sm font-bold text-white mb-2">Authority Status</h3>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest mb-6">Visual markers for buyers</p>

                    <form action="{{ route('admin.stores.badge', $store) }}" method="POST" class="space-y-3">
                        @csrf
                        <label class="flex items-center justify-between p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 transition-all cursor-pointer group {{ !$store->badge ? 'bg-gold-500/10 border-gold-400/30' : '' }}">
                            <span class="text-[11px] font-bold text-slate-300 group-hover:text-white transition-colors">None</span>
                            <input type="radio" name="badge" value="" class="w-4 h-4 text-gold-400 bg-navy-800 border-white/10 focus:ring-0" {{ !$store->badge ? 'checked' : '' }}>
                        </label>
                        @foreach(['Verified Seller', 'Trusted Store', 'Premium Seller', 'Legit Business', 'Top Rated'] as $badge)
                        <label class="flex items-center justify-between p-4 rounded-xl border border-white/5 bg-white/5 hover:bg-white/10 transition-all cursor-pointer group {{ $store->badge == $badge ? 'bg-gold-500/10 border-gold-400/30' : '' }}">
                            <span class="text-[11px] font-bold text-slate-300 group-hover:text-white transition-colors">{{ $badge }}</span>
                            <input type="radio" name="badge" value="{{ $badge }}" class="w-4 h-4 text-gold-400 bg-navy-800 border-white/10 focus:ring-0" {{ $store->badge == $badge ? 'checked' : '' }}>
                        </label>
                        @endforeach

                        <button type="submit" class="w-full mt-4 py-3 bg-gold-500 text-white rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-gold-500/20 hover:scale-[1.02]">
                            Apply Changes
                        </button>
                    </form>
                </div>

                <!-- Store Images -->
                <div class="admin-card p-8 border-none bg-white shadow-xl">
                    <h3 class="text-sm font-bold text-navy-800 mb-2">Store Appearance</h3>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest mb-6">Logo & banner images</p>

                    <form action="{{ route('admin.stores.images', $store) }}" method="POST" enctype="multipart/form-data" class="space-y-5"
                          x-data="{
                              logoPreview: null,
                              bannerPreview: null,
                              previewLogo(event) {
                                  const file = event.target.files[0];
                                  if (file) { const r = new FileReader(); r.onload = e => this.logoPreview = e.target.result; r.readAsDataURL(file); }
                              },
                              previewBanner(event) {
                                  const file = event.target.files[0];
                                  if (file) { const r = new FileReader(); r.onload = e => this.bannerPreview = e.target.result; r.readAsDataURL(file); }
                              }
                          }">
                        @csrf
                        <div class="space-y-3">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Store Logo</label>
                            <label class="relative group cursor-pointer aspect-square w-32 rounded-xl border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center hover:border-gold-400 transition-all bg-slate-50 mx-auto">
                                <input type="file" name="logo" class="hidden" accept="image/*" @change="previewLogo">
                                <img x-show="logoPreview" :src="logoPreview" class="w-full h-full object-cover">
                                <div x-show="!logoPreview" class="w-full h-full">
                                    @if($store->logo)
                                        <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300">
                                            <span class="material-symbols-outlined text-2xl">add_photo_alternate</span>
                                            <span class="text-[9px] font-bold mt-1">Logo</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-navy-900/80 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white rounded-xl">
                                    <span class="material-symbols-outlined text-xl">camera_alt</span>
                                </div>
                            </label>
                        </div>

                        <div class="space-y-3">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Banner Image</label>
                            <label class="relative group cursor-pointer h-20 rounded-xl border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center hover:border-gold-400 transition-all bg-slate-50">
                                <input type="file" name="banner" class="hidden" accept="image/*" @change="previewBanner">
                                <img x-show="bannerPreview" :src="bannerPreview" class="w-full h-full object-cover">
                                <div x-show="!bannerPreview" class="w-full h-full">
                                    @if($store->banner)
                                        <img src="{{ $store->banner_url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <span class="material-symbols-outlined text-lg">panorama</span>
                                            <span class="text-[9px] font-bold ml-2">Banner (1200x400)</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-navy-900/80 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white rounded-xl">
                                    <span class="material-symbols-outlined text-xl">camera_alt</span>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="w-full py-3 bg-navy-800 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-navy-900 transition-all shadow-lg">
                            Update Images
                        </button>
                    </form>
                </div>

                <!-- Account Status (Suspension) -->
                <div class="admin-card p-8 border-none bg-white shadow-xl">
                    <h3 class="text-sm font-bold text-navy-800 mb-2">Account Management</h3>
                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-widest mb-6">Account visibility & access</p>

                    <div class="space-y-4">
                        <form action="{{ route('admin.stores.status', $store) }}" method="POST">
                            @csrf
                            <button class="w-full py-4 border-2 {{ $store->status === 'active' ? 'border-rose-50 text-rose-500 hover:bg-rose-50' : 'border-emerald-50 text-emerald-500 hover:bg-emerald-50' }} rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                                <i data-lucide="{{ $store->status === 'active' ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                {{ $store->status === 'active' ? 'Suspend Merchant' : 'Reactivate Merchant' }}
                            </button>
                        </form>

                        <div class="p-4 bg-slate-50 rounded-xl">
                            <p class="text-[9px] text-slate-500 font-medium leading-relaxed italic">
                                <i data-lucide="info" class="w-3 h-3 inline mr-1 mb-0.5"></i>
                                {{ $store->status === 'active'
                                    ? 'Suspending hides this store and its products from all public listings. The owner will be blocked from dashboard access.'
                                    : 'Reactivating will restore public visibility and owner dashboard access.' }}
                            </p>
                        </div>

                        <div class="pt-6 border-t border-slate-100">
                            <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" onsubmit="return confirm('WARNING: This will permanently delete the store and all its data. This cannot be undone. Continue?')">
                                @csrf
                                @method('DELETE')
                                <button class="w-full text-center text-[10px] font-bold text-slate-300 hover:text-rose-500 transition-colors uppercase tracking-widest">
                                    Permanently Delete Store
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
