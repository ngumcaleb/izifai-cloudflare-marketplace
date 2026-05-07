
{{-- resources/views/seller/dashboard.blade.php --}}
<x-app-layout>
    <div class="bg-slate-50 min-h-screen flex" 
         x-data="{ 
            tab: (new URLSearchParams(window.location.search)).get('tab') || 'overview', 
            sidebarOpen: false,
            editingProduct: null,
            specs: [{ name: '', value: '' }],
            imagePreviews: [],
            
            updateTab(newTab) {
                this.tab = newTab;
                const url = new URL(window.location);
                url.searchParams.set('tab', newTab);
                window.history.pushState({}, '', url);
                if (newTab !== 'edit-product') this.editingProduct = null;
                // Close sidebar on mobile when tab changes
                this.sidebarOpen = false;
            },

            startEdit(product) {
                this.editingProduct = product;
                this.specs = product.specifications && product.specifications.length > 0 
                    ? product.specifications.map(s => ({ name: s.key, value: s.value }))
                    : [{ name: '', value: '' }];
                this.imagePreviews = product.images && product.images.length > 0 
                    ? product.images.map(i => '/storage/' + i.path)
                    : [];
                this.updateTab('edit-product');
            },

            handleImageUpload(event) {
                this.imagePreviews = [];
                const files = event.target.files;
                for(let i = 0; i < files.length; i++) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreviews.push(e.target.result);
                    };
                    reader.readAsDataURL(files[i]);
                }
            },
            
            resetSpecs() {
                this.specs = [{ name: '', value: '' }];
            }
         }">
        
        <!-- Seller Sidebar - Clean Premium Design -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A1D37] text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0 shadow-xl"
        >
            <!-- Sidebar Header -->
            <div class="p-5 h-16 flex items-center gap-3 border-b border-white/10">
                <div class="w-7 h-7 bg-emerald-600 rounded-lg flex items-center justify-center font-black text-xs shadow-lg">S</div>
                <span class="font-black text-[9px] uppercase tracking-[0.2em] text-white/80">Seller Hub</span>
            </div>

            <!-- Sidebar Navigation -->
            <nav class="p-4 space-y-1.5">
                <button @click="updateTab('overview')" 
                        :class="tab === 'overview' ? 'bg-emerald-600/20 text-white border-emerald-500/30' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" 
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Dashboard</span>
                </button>
                
                <button @click="updateTab('inventory')" 
                        :class="['inventory', 'edit-product', 'create-product'].includes(tab) ? 'bg-emerald-600/20 text-white border-emerald-500/30' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" 
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Inventory</span>
                </button>
                
                <button @click="updateTab('store')" 
                        :class="tab === 'store' ? 'bg-emerald-600/20 text-white border-emerald-500/30' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" 
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span>Store Profile</span>
                </button>
                
                <button @click="updateTab('personal')" 
                        :class="tab === 'personal' ? 'bg-emerald-600/20 text-white border-emerald-500/30' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" 
                        class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>Account</span>
                </button>
            </nav>
            
            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
                <div class="flex items-center gap-2 px-2 py-2 rounded-lg bg-white/5">
                    <div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center">
                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </div>
                    <div>
                        <p class="text-[8px] font-black text-white/50 uppercase tracking-wider">Seller since</p>
                        <p class="text-[9px] font-bold text-white">{{ $store->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-slate-100 h-14 flex items-center justify-between px-4 sticky top-0 z-40 shrink-0 shadow-sm">
                <button @click="sidebarOpen = true" class="p-2 text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-emerald-600 rounded-lg flex items-center justify-center text-white font-black text-[8px]">{{ substr($store->name, 0, 1) }}</div>
                    <span class="font-black text-[9px] text-slate-800 uppercase tracking-wider" x-text="{
                        overview: 'Dashboard',
                        inventory: 'Inventory',
                        'create-product': 'New Product',
                        'edit-product': 'Edit Product',
                        store: 'Store Profile',
                        personal: 'Account Settings'
                    }[tab] || 'Dashboard'">Dashboard</span>
                </div>
                <div class="w-7"></div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-6">
                <div class="max-w-7xl mx-auto space-y-5">
                    
                    <!-- TAB: OVERVIEW / DASHBOARD -->
                    <div x-show="tab === 'overview'" x-cloak class="space-y-5">
                        <!-- Hero Banner -->
                        <div class="relative bg-gradient-to-r from-[#0A1D37] to-[#0A1D37]/90 rounded-2xl overflow-hidden shadow-xl">
                            <div class="absolute inset-0 opacity-20">
                                <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=2000" class="w-full h-full object-cover">
                            </div>
                            <div class="relative z-10 p-6 lg:p-8">
                                <div class="inline-block bg-emerald-600 text-white text-[7px] lg:text-[8px] font-black px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-3 shadow-md">
                                    Welcome Back
                                </div>
                                <h1 class="text-xl lg:text-2xl font-black text-white tracking-tight">
                                    {{ auth()->user()->name }}
                                </h1>
                                <p class="text-[10px] lg:text-[11px] text-slate-300 mt-1 max-w-md">
                                    Manage your products, track sales, and grow your business on Izifai.
                                </p>
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <span class="text-[8px] font-black text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Total</span>
                                </div>
                                <p class="text-2xl lg:text-3xl font-black text-slate-900">{{ $store->products->count() }}</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Products</p>
                            </div>
                            
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-8 h-8 rounded-xl bg-sky-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                    <span class="text-[8px] font-black text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">Views</span>
                                </div>
                                <p class="text-2xl lg:text-3xl font-black text-slate-900">{{ number_format($store->products()->sum('views')) }}+</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Total Views</p>
                            </div>
                            
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                    </div>
                                    <span class="text-[8px] font-black text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Rating</span>
                                </div>
                                <p class="text-2xl lg:text-3xl font-black text-slate-900">4.8</p>
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mt-1">Store Rating</p>
                            </div>
                            
                            <button @click="updateTab('create-product')" 
                                    class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-4 lg:p-5 rounded-xl shadow-lg hover:shadow-xl transition-all group text-left">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <span class="text-[8px] font-black text-white/70 uppercase tracking-wider">Action</span>
                                </div>
                                <p class="text-base lg:text-lg font-black text-white group-hover:translate-x-1 transition-transform">Add Product →</p>
                                <p class="text-[8px] font-bold text-white/60 mt-1">Post new listing</p>
                            </button>
                        </div>
                        
                        <!-- Quick Tips -->
                        <div class="bg-white rounded-xl border border-slate-100 p-5 shadow-sm">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-wider">Quick Tips</h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                        <span class="text-[8px] font-black text-emerald-600">1</span>
                                    </div>
                                    <p class="text-[9px] font-medium text-slate-600">Add high-quality product images to boost sales</p>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                        <span class="text-[8px] font-black text-emerald-600">2</span>
                                    </div>
                                    <p class="text-[9px] font-medium text-slate-600">Keep your store profile updated with accurate info</p>
                                </div>
                                <div class="flex items-start gap-2">
                                    <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
                                        <span class="text-[8px] font-black text-emerald-600">3</span>
                                    </div>
                                    <p class="text-[9px] font-medium text-slate-600">Respond to customer messages promptly</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: INVENTORY -->
                    <div x-show="tab === 'inventory'" x-cloak class="space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Product Catalog</h2>
                                <p class="text-[9px] text-slate-400 mt-0.5">Manage all your product listings</p>
                            </div>
                            <button @click="updateTab('create-product')" 
                                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Product
                            </button>
                        </div>
                        
                        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                            <div class="w-full overflow-x-auto">
                                <table class="w-full text-left min-w-[600px]">
                                    <thead class="bg-slate-50 border-b border-slate-100">
                                        <tr>
                                            <th class="px-5 py-4 text-[8px] font-black text-slate-400 uppercase tracking-wider">Product</th>
                                            <th class="px-5 py-4 text-[8px] font-black text-slate-400 uppercase tracking-wider text-center">Category</th>
                                            <th class="px-5 py-4 text-[8px] font-black text-slate-400 uppercase tracking-wider text-center">Price</th>
                                            <th class="px-5 py-4 text-[8px] font-black text-slate-400 uppercase tracking-wider text-center">Views</th>
                                            <th class="px-5 py-4 text-[8px] font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($products as $product)
                                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded-lg bg-slate-50 border border-slate-100 overflow-hidden p-1 shrink-0">
                                                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://placehold.co/200x200/1e293b/ffffff?text=No+Image' }}" 
                                                                 class="w-full h-full object-contain">
                                                        </div>
                                                        <span class="font-bold text-slate-800 text-[11px] line-clamp-1">{{ $product->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    <span class="text-[7px] font-black bg-slate-100 text-slate-600 px-2 py-0.5 rounded uppercase tracking-tighter">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                                </td>
                                                <td class="px-5 py-4 text-center font-black text-slate-800 text-[11px]">
                                                    {{ number_format($product->price) }} <span class="text-[7px] text-slate-400">XAF</span>
                                                </td>
                                                <td class="px-5 py-4 text-center text-[10px] font-bold text-slate-500">
                                                    {{ number_format($product->views) }}
                                                </td>
                                                <td class="px-5 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button @click="startEdit({{ Js::from($product) }})" 
                                                                class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        </button>
                                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product permanently?')" class="inline">
                                                            @csrf 
                                                            @method('DELETE')
                                                            <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-5 py-12 text-center">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                        </div>
                                                        <p class="text-[11px] font-medium text-slate-400">No products yet</p>
                                                        <button @click="updateTab('create-product')" class="text-[9px] font-black text-emerald-600 hover:underline">Create your first product →</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        @if(method_exists($products, 'links'))
                            <div class="mt-4">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- TAB: CREATE PRODUCT -->
                    <div x-show="tab === 'create-product'" x-cloak class="space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">New Product</h2>
                                <p class="text-[9px] text-slate-400 mt-0.5">Add a new product to your store</p>
                            </div>
                            <button @click="updateTab('inventory')" 
                                    class="text-[9px] font-bold text-slate-400 hover:text-slate-900 uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Back to Catalog
                            </button>
                        </div>
                        
                        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            <div class="bg-white rounded-xl border border-slate-100 p-5 lg:p-6 space-y-6 shadow-sm">
                                <!-- Basic Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Product Name <span class="text-red-400">*</span></label>
                                        <input type="text" name="name" required 
                                               placeholder="e.g., Professional Wireless Headphones" 
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Category <span class="text-red-400">*</span></label>
                                        <select name="category_id" required 
                                                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all appearance-none">
                                            <option value="">Select category</option>
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Price (XAF) <span class="text-red-400">*</span></label>
                                        <input type="number" name="price" required 
                                               placeholder="0" 
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Description <span class="text-red-400">*</span></label>
                                    <textarea name="description" rows="4" required 
                                              placeholder="Describe your product in detail..." 
                                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all resize-none"></textarea>
                                </div>
                                
                                <!-- Specifications -->
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Specifications</label>
                                        <button type="button" @click="specs.push({ name: '', value: '' })" 
                                                class="text-[8px] font-black text-emerald-600 uppercase tracking-wider hover:text-emerald-700 transition-colors flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Add Field
                                        </button>
                                    </div>
                                    <template x-for="(spec, index) in specs" :key="index">
                                        <div class="flex gap-3 items-center">
                                            <input type="text" name="spec_names[]" x-model="spec.name" 
                                                   placeholder="e.g., Brand" 
                                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] font-medium outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                            <input type="text" name="spec_values[]" x-model="spec.value" 
                                                   placeholder="e.g., Sony" 
                                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] font-medium outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                            <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1" 
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Images -->
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Product Images</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label class="w-20 h-20 rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-emerald-500 hover:bg-emerald-50/20 transition-all group">
                                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleImageUpload">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            <span class="text-[7px] text-slate-400 group-hover:text-emerald-500 mt-1">Upload</span>
                                        </label>
                                        <template x-for="preview in imagePreviews">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm relative group">
                                                <img :src="preview" class="w-full h-full object-cover">
                                                <button type="button" @click="imagePreviews = imagePreviews.filter(p => p !== preview)" 
                                                        class="absolute top-1 right-1 w-5 h-5 rounded-full bg-red-500 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-[10px]">
                                                    ×
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    <p class="text-[7px] text-slate-400">You can select multiple images. First image will be the cover.</p>
                                </div>
                                
                                <!-- Submit -->
                                <div class="pt-4 border-t border-slate-100 flex justify-end">
                                    <button type="submit" 
                                            class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-2">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Publish Product
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: EDIT PRODUCT -->
                    <div x-show="tab === 'edit-product' && editingProduct" x-cloak class="space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Edit Product</h2>
                                <p class="text-[9px] text-slate-400 mt-0.5" x-text="'Editing: ' + editingProduct?.name"></p>
                            </div>
                            <button @click="updateTab('inventory')" 
                                    class="text-[9px] font-bold text-slate-400 hover:text-slate-900 uppercase tracking-wider flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Cancel
                            </button>
                        </div>
                        
                        <form :action="'/seller/products/' + editingProduct?.id" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')
                            <div class="bg-white rounded-xl border border-slate-100 p-5 lg:p-6 space-y-6 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Product Name</label>
                                        <input type="text" name="name" required :value="editingProduct?.name" 
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Category</label>
                                        <select name="category_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" :selected="editingProduct?.category_id == {{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Price (XAF)</label>
                                        <input type="number" name="price" required :value="editingProduct?.price" 
                                               class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Description</label>
                                    <textarea name="description" rows="4" required x-text="editingProduct?.description" 
                                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none"></textarea>
                                </div>
                                
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Specifications</label>
                                        <button type="button" @click="specs.push({ name: '', value: '' })" 
                                                class="text-[8px] font-black text-emerald-600 uppercase tracking-wider flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Add Field
                                        </button>
                                    </div>
                                    <template x-for="(spec, index) in specs" :key="index">
                                        <div class="flex gap-3 items-center">
                                            <input type="text" name="spec_names[]" x-model="spec.name" placeholder="Key" 
                                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] font-medium outline-none focus:ring-2 focus:ring-emerald-500/20">
                                            <input type="text" name="spec_values[]" x-model="spec.value" placeholder="Value" 
                                                   class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[10px] font-medium outline-none focus:ring-2 focus:ring-emerald-500/20">
                                            <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1" 
                                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">New Images (optional)</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label class="w-20 h-20 rounded-xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-emerald-500 transition-all group">
                                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleImageUpload">
                                            <svg class="w-5 h-5 text-slate-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            <span class="text-[7px] text-slate-400">Upload</span>
                                        </label>
                                        <template x-for="preview in imagePreviews">
                                            <div class="w-20 h-20 rounded-xl overflow-hidden border border-slate-100 shadow-sm relative group">
                                                <img :src="preview" class="w-full h-full object-cover">
                                            </div>
                                        </template>
                                    </div>
                                    <p class="text-[7px] text-slate-400">New images will replace existing ones</p>
                                </div>
                                
                                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                                    <button type="submit" 
                                            class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-sm">
                                        Update Product
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: STORE PROFILE -->
                    <div x-show="tab === 'store'" x-cloak class="space-y-4 max-w-3xl">
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Store Settings</h2>
                            <p class="text-[9px] text-slate-400 mt-0.5">Manage your store information and branding</p>
                        </div>
                        
                        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-100 p-5 lg:p-6 space-y-6 shadow-sm">
                            @csrf
                            @method('PUT')
                            
                            <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                                <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                    @if($store->logo)
                                        <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[11px] font-bold text-slate-800">{{ $store->name }}</p>
                                    <p class="text-[8px] text-slate-400">Store Logo</p>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Business Name</label>
                                    <input type="text" name="name" value="{{ $store->name }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Owner Name</label>
                                    <input type="text" name="user_name" value="{{ auth()->user()->name }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                    <p class="text-[7px] text-slate-400">Customers will reach you via this number</p>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ $store->phone_number }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Location (City)</label>
                                    <input type="text" name="location" value="{{ $store->location }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Email Address</label>
                                    <input type="email" name="email" value="{{ $store->email }}" 
                                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500">
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-wider">Store Description</label>
                                <textarea name="description" rows="4" 
                                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-[12px] font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 resize-none">{{ $store->description }}</textarea>
                            </div>
                            
                            <div class="pt-2 border-t border-slate-100 flex justify-end">
                                <button type="submit" 
                                        class="bg-emerald-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-wider hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: PERSONAL PROFILE -->
                    <div x-show="tab === 'personal'" x-cloak class="space-y-4 max-w-3xl">
                        <div>
                            <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Account Settings</h2>
                            <p class="text-[9px] text-slate-400 mt-0.5">Manage your personal account and security</p>
                        </div>
                        
                        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                            <div class="p-5 lg:p-6 border-b border-slate-100">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                            <div class="p-5 lg:p-6">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Backdrop for mobile sidebar -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak 
             class="fixed inset-0 bg-black/50 z-40 lg:hidden backdrop-blur-sm transition-opacity"></div>
    </div>
    
    @push('styles')
    <style>
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @endpush
</x-app-layout>