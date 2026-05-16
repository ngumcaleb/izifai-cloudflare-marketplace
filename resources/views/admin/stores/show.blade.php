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
                    <div class="w-20 h-20 md:w-24 md:h-24 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center font-black text-3xl md:text-4xl text-white border border-white/20 shrink-0 shadow-2xl overflow-hidden">
                        @if($store->logo)
                            <img src="{{ $store->logo_url }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($store->name, 0, 1) }}
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
                    <span class="px-5 py-3 bg-white/5 text-slate-400 rounded-xl text-[10px] font-bold uppercase tracking-widest inline-flex items-center gap-2 border border-white/5">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        Storefront (Removed)
                    </span>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <!-- Business Intelligence -->
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

                <!-- Product Catalog Context -->
                <div class="admin-card p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Active Listings ({{ $store->products->count() }})</h3>
                        <a href="{{ route('admin.products.index', ['search' => $store->name]) }}" class="text-[10px] font-bold text-gold-500 uppercase hover:underline">Manage All</a>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach($store->products->take(4) as $product)
                        <div class="group relative aspect-square bg-slate-100 rounded-xl overflow-hidden border border-slate-100 shadow-sm">
                            @if($product->mainImage)
<img src="{{ $product->mainImage->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-all">
                             @elseif($product->images->first())
                                 <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover group-hover:scale-110 transition-all">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-lucide="image" class="w-6 h-6"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-navy-900/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                <span class="text-[8px] font-bold text-white uppercase tracking-widest">View Details</span>
                            </div>
                        </div>
                        @endforeach
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
                        @foreach(['Verified Seller', 'Trusted Store', 'Premium Seller'] as $badge)
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

                        <!-- Permanent Removal -->
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
