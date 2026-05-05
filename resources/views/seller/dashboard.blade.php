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
            },

            startEdit(product) {
                this.editingProduct = product;
                this.specs = product.specifications.length > 0 
                    ? product.specifications.map(s => ({ name: s.key, value: s.value }))
                    : [{ name: '', value: '' }];
                this.imagePreviews = product.images.map(i => '/storage/' + i.path);
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
            }
         }">
        <!-- Seller Sidebar - Creative Clean -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A1D37] text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0"
        >
            <div class="p-6 h-16 flex items-center gap-3 border-b border-white/5">
                <div class="w-7 h-7 bg-green-600 rounded flex items-center justify-center font-black text-xs">S</div>
                <span class="font-black text-[9px] uppercase tracking-[0.2em]">Manage Products</span>
            </div>

            <nav class="p-4 space-y-1">
                <button @click="updateTab('overview')" :class="tab === 'overview' ? 'bg-white/10 text-white border-white/10' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Overview</span>
                </button>
                <button @click="updateTab('inventory')" :class="['inventory', 'edit-product', 'create-product'].includes(tab) ? 'bg-white/10 text-white border-white/10' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <span>Inventory</span>
                </button>
                <button @click="updateTab('store')" :class="tab === 'store' ? 'bg-white/10 text-white border-white/10' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Store Profile</span>
                </button>
                <button @click="updateTab('personal')" :class="tab === 'personal' ? 'bg-white/10 text-white border-white/10' : 'text-slate-400 border-transparent hover:bg-white/5 hover:text-white'" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg font-bold text-[10px] transition-all border text-left">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Personal Profile</span>
                </button>
            </nav>

        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-slate-100 h-14 flex items-center justify-between px-4 sticky top-0 z-40 shrink-0">
                <button @click="sidebarOpen = true" class="p-2 text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <span class="font-black text-[9px] text-slate-900 uppercase tracking-widest" x-text="tab.charAt(0).toUpperCase() + tab.slice(1)">Overview</span>
                <div class="w-7 h-7 bg-green-600 rounded flex items-center justify-center text-white font-bold text-xs">{{ substr($store->name, 0, 1) }}</div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-6xl mx-auto space-y-4">
                    
                    <!-- TAB: OVERVIEW -->
                    <div x-show="tab === 'overview'" class="space-y-4">
                        <!-- Bento Hero Header -->
                        <div class="relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group h-[160px] lg:h-[220px]">
                            <img src="https://img.freepik.com/free-photo/smiling-businesspeople-working-office_23-2148908914.jpg" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                            <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/80 to-transparent"></div>
                            <div class="relative z-10 h-full p-6 lg:p-10 flex flex-col justify-center">
                                <div class="inline-block bg-green-600 text-white text-[7px] lg:text-[8px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-2 w-fit shadow-md">
                                    Inventory System
                                </div>
                                <h1 class="text-xl lg:text-3xl font-black text-white tracking-tight mb-1 leading-none">
                                    {{ $store->name }}
                                </h1>
                                <p class="text-[9px] lg:text-[11px] text-slate-300 font-medium leading-relaxed max-w-sm">
                                    Manage your product listings and monitor your business performance on Izifai.
                                </p>
                            </div>
                        </div>

                        <!-- Stats Bento Row -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 lg:gap-4">
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[100px] lg:h-[120px]">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Total Products</p>
                                <p class="text-xl lg:text-2xl font-black text-slate-900">{{ $store->products->count() }}</p>
                            </div>
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[100px] lg:h-[120px]">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Inquiries</p>
                                <p class="text-xl lg:text-2xl font-black text-green-600">12</p>
                            </div>
                            <div class="bg-white p-4 lg:p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[100px] lg:h-[120px]">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Store Rating</p>
                                <p class="text-xl lg:text-2xl font-black text-slate-900">4.8</p>
                            </div>
                            <button @click="updateTab('create-product')" class="bg-green-600 p-4 lg:p-5 rounded-xl shadow-lg flex flex-col justify-between h-[100px] lg:h-[120px] group transition-all text-left">
                                <p class="text-[8px] font-black text-white/70 uppercase tracking-widest">Quick Action</p>
                                <p class="text-[10px] lg:text-xs font-bold text-white group-hover:translate-x-1 transition-transform">Post Product &rarr;</p>
                            </button>
                        </div>
                    </div>

                    <!-- TAB: INVENTORY -->
                    <div x-show="tab === 'inventory'" class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Inventory Catalog</h2>
                            <button @click="updateTab('create-product')" class="bg-green-600 text-white px-4 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest">Add New Product</button>
                        </div>
                        <div class="bg-white rounded-xl border border-slate-100 overflow-hidden shadow-sm">
                            <div class="w-full overflow-x-auto lg:overflow-visible">
                                <table class="w-full text-left min-w-[500px] lg:min-w-0">
                                    <thead class="bg-slate-50 text-[8px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                        <tr>
                                            <th class="px-5 py-4">Product Info</th>
                                            <th class="px-5 py-4 text-center">Category</th>
                                            <th class="px-5 py-4 text-center">Price</th>
                                            <th class="px-5 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @foreach($products as $product)
                                            <tr class="hover:bg-slate-50/50 transition-colors">
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-10 h-10 rounded bg-slate-50 border border-slate-100 overflow-hidden p-1 shrink-0">
                                                            <img src="{{ $product->images->first() ? asset('storage/' . $product->images->first()->path) : 'https://m.media-amazon.com/images/I/61pD7UeR4mL._AC_UF894,1000_QL80_.jpg' }}" class="w-full h-full object-contain">
                                                        </div>
                                                        <span class="font-bold text-slate-900 text-[11px]">{{ $product->name }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-4 text-center">
                                                    <span class="text-[7px] font-black bg-slate-100 text-slate-500 px-2 py-0.5 rounded uppercase tracking-tighter">{{ $product->category->name }}</span>
                                                </td>
                                                <td class="px-5 py-4 text-center font-black text-slate-900 text-[11px]">
                                                    {{ number_format($product->price) }}
                                                </td>
                                                <td class="px-5 py-4 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        <button @click="startEdit({{ $product->toJson() }})" class="text-slate-400 hover:text-green-600 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        </button>
                                                        <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors pt-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- TAB: CREATE PRODUCT -->
                    <div x-show="tab === 'create-product'" class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Post New Product</h2>
                            <button @click="updateTab('inventory')" class="text-[10px] font-bold text-slate-400 hover:text-slate-900 uppercase tracking-widest">&larr; Back to Catalog</button>
                        </div>
                        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            <div class="bg-white rounded-xl border border-slate-100 p-8 space-y-8 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Product Name</label>
                                        <input type="text" name="name" required placeholder="e.g. Caterpillar Excavator 320D" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Category</label>
                                        <select name="category_id" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600 appearance-none">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Price (XAF)</label>
                                        <input type="number" name="price" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Description</label>
                                    <textarea name="description" rows="4" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600"></textarea>
                                </div>
                                
                                <!-- Dynamic Specs -->
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Specifications</label>
                                        <button type="button" @click="specs.push({ name: '', value: '' })" class="text-[8px] font-black text-green-600 uppercase tracking-widest">+ Add</button>
                                    </div>
                                    <template x-for="(spec, index) in specs" :key="index">
                                        <div class="flex gap-3">
                                            <input type="text" name="spec_names[]" x-model="spec.name" placeholder="Key" class="flex-1 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 text-[10px] font-bold outline-none">
                                            <input type="text" name="spec_values[]" x-model="spec.value" placeholder="Value" class="flex-1 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 text-[10px] font-bold outline-none">
                                            <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </div>
                                    </template>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Images</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label class="w-16 h-16 rounded-lg border-2 border-dashed border-slate-200 flex items-center justify-center cursor-pointer hover:border-green-600 transition-all">
                                            <input type="file" name="images[]" multiple class="hidden" @change="handleImageUpload">
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </label>
                                        <template x-for="preview in imagePreviews">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-100"><img :src="preview" class="w-full h-full object-cover"></div>
                                        </template>
                                    </div>
                                </div>
                                <div class="pt-6 border-t border-slate-50">
                                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-green-700 transition-all">Publish Product</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: EDIT PRODUCT -->
                    <div x-show="tab === 'edit-product' && editingProduct" class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Edit Product: <span x-text="editingProduct?.name"></span></h2>
                            <button @click="updateTab('inventory')" class="text-[10px] font-bold text-slate-400 hover:text-slate-900 uppercase tracking-widest">&larr; Back to Catalog</button>
                        </div>
                        <form :action="'/seller/products/' + editingProduct?.id" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <div class="bg-white rounded-xl border border-slate-100 p-8 space-y-8 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Product Name</label>
                                        <input type="text" name="name" required :value="editingProduct?.name" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Category</label>
                                        <select name="category_id" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600 appearance-none">
                                            @foreach($categories as $cat)
                                                <option value="{{ $cat->id }}" :selected="editingProduct?.category_id == {{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Price (XAF)</label>
                                        <input type="number" name="price" required :value="editingProduct?.price" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600">
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Description</label>
                                    <textarea name="description" rows="4" required x-text="editingProduct?.description" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 outline-none focus:ring-1 focus:ring-green-600"></textarea>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Specifications</label>
                                        <button type="button" @click="specs.push({ name: '', value: '' })" class="text-[8px] font-black text-green-600 uppercase tracking-widest">+ Add</button>
                                    </div>
                                    <template x-for="(spec, index) in specs" :key="index">
                                        <div class="flex gap-3">
                                            <input type="text" name="spec_names[]" x-model="spec.name" placeholder="Key" class="flex-1 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 text-[10px] font-bold outline-none">
                                            <input type="text" name="spec_values[]" x-model="spec.value" placeholder="Value" class="flex-1 bg-slate-50 border border-slate-100 rounded-lg px-3 py-2 text-[10px] font-bold outline-none">
                                            <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                        </div>
                                    </template>
                                </div>

                                <div class="space-y-4">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Images (Overwrites current gallery)</label>
                                    <div class="flex flex-wrap gap-3">
                                        <label class="w-16 h-16 rounded-lg border-2 border-dashed border-slate-200 flex items-center justify-center cursor-pointer hover:border-green-600 transition-all">
                                            <input type="file" name="images[]" multiple class="hidden" @change="handleImageUpload">
                                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </label>
                                        <template x-for="preview in imagePreviews">
                                            <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-100"><img :src="preview" class="w-full h-full object-cover"></div>
                                        </template>
                                    </div>
                                </div>
                                <div class="pt-6 border-t border-slate-50">
                                    <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-green-700 transition-all">Update Product</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: STORE PROFILE -->
                    <div x-show="tab === 'store'" class="space-y-4 max-w-2xl">
                        <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Store Profile Settings</h2>
                        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl border border-slate-100 p-8 space-y-6 shadow-sm">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Business Name</label>
                                    <input type="text" name="name" value="{{ $store->name }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 focus:ring-1 focus:ring-green-600 outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Owner Name</label>
                                    <input type="text" name="user_name" value="{{ auth()->user()->name }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 focus:ring-1 focus:ring-green-600 outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">WhatsApp Number</label>
                                    <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 focus:ring-1 focus:ring-green-600 outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Location (City)</label>
                                    <input type="text" name="location" value="{{ $store->location }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 focus:ring-1 focus:ring-green-600 outline-none">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Description</label>
                                <textarea name="description" rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-2.5 text-[11px] font-bold text-slate-900 focus:ring-1 focus:ring-green-600 outline-none">{{ $store->description }}</textarea>
                            </div>
                            <div class="pt-4 border-t border-slate-50">
                                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg text-[10px] font-black uppercase tracking-widest hover:bg-green-700 transition-all">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB: PERSONAL PROFILE -->
                    <div x-show="tab === 'personal'" class="space-y-4 max-w-2xl">
                        <h2 class="text-xs font-black text-slate-900 uppercase tracking-widest">Personal Account Security</h2>
                        <div class="bg-white rounded-xl border border-slate-100 p-8 space-y-10 shadow-sm">
                            <section>
                                @include('profile.partials.update-profile-information-form')
                            </section>
                            <div class="border-t border-slate-50"></div>
                            <section>
                                @include('profile.partials.update-password-form')
                            </section>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-sm"></div>
    </div>
</x-app-layout>