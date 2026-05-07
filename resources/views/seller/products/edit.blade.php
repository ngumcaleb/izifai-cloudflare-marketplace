<x-app-layout>
    <x-slot name="sidebar">
        <!-- Seller Sidebar (Compact) -->
        <aside class="w-[240px] bg-[#0A1D37] text-white flex flex-col min-h-screen sticky top-0">
            <div class="p-6 h-20 flex items-center gap-3 border-b border-white/10 shrink-0">
                <div class="w-8 h-8 bg-green-600 rounded-lg flex items-center justify-center font-black text-sm">S</div>
                <span class="font-black text-xs uppercase tracking-widest">Seller Dashboard</span>
            </div>
            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <a href="{{ route('seller.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span>Overview</span>
                </a>
                <a href="{{ route('seller.products.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-green-600 text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Product Catalog</span>
                </a>
            </nav>
        </aside>
    </x-slot>

    <div class="p-6 md:p-8">
        <div class="max-w-4xl">
            <div class="mb-10">
                <h1 class="text-2xl font-black text-slate-900 mb-2">Edit Product: {{ $product->name }}</h1>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Version 1: Product Discovery &
                    Supplier Visibility</p>
            </div>

            <form action="{{ route('seller.products.update', $product->id) }}" method="POST"
                enctype="multipart/form-data" class="space-y-8" x-data="{ 
                    specs: {{ $product->specifications->count() ? collect($product->specifications->map(function ($s) {
    return ['name' => $s->key, 'value' => $s->value]; }))->toJson() : "[{ name: '', value: '' }]" }},
                    imagePreviews: {!! collect($product->images->map(function ($i) {
    return asset('storage/' . $i->path); }))->toJson() !!},
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
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                    <h3 class="text-xs font-black text-green-600 uppercase tracking-[0.3em] mb-8">01. Essential Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Product
                                Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" required
                                placeholder="e.g. Caterpillar Excavator 320D"
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                        </div>
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Category</label>
                            <select name="category_id" required
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50 appearance-none">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stock
                                Status</label>
                            <select name="stock_status"
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50 appearance-none">
                                <option value="in_stock" {{ $product->stock_status == 'in_stock' ? 'selected' : '' }}>In
                                    Stock</option>
                                <option value="out_of_stock" {{ $product->stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="on_request" {{ $product->stock_status == 'on_request' ? 'selected' : '' }}>
                                    On Request</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Selling Price
                                (XAF)</label>
                            <input type="number" name="price" value="{{ $product->price }}" required
                                placeholder="e.g. 150000"
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Old Price
                                (Optional, XAF)</label>
                            <input type="number" name="old_price" value="{{ $product->old_price }}"
                                placeholder="e.g. 180000"
                                class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                    <h3 class="text-xs font-black text-green-600 uppercase tracking-[0.3em] mb-8">02. Detailed
                        Description</h3>
                    <div class="space-y-2 mb-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Available Colors
                            (Comma separated)</label>
                        <input type="text" name="colors"
                            value="{{ is_array($product->colors) ? implode(', ', $product->colors) : '' }}"
                            placeholder="e.g. Red, Blue, #000000"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                    </div>
                    <div class="space-y-2 mb-4">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Available Sizes /
                            Storage (Comma separated)</label>
                        <input type="text" name="sizes"
                            value="{{ is_array($product->sizes) ? implode(', ', $product->sizes) : '' }}"
                            placeholder="e.g. M, L, XL or 128GB, 256GB"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Product
                            Overview</label>
                        <textarea name="description" rows="5" required
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-medium text-sm transition-all bg-slate-50/50"
                            placeholder="Describe the specifications, condition, and usage...">{{ $product->description }}</textarea>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black text-green-600 uppercase tracking-[0.3em]">03. Technical
                            Specifications</h3>
                        <button type="button" @click="specs.push({ name: '', value: '' })"
                            class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:underline">+ Add
                            Attribute</button>
                    </div>
                    <div class="space-y-4">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="flex gap-4">
                                <input type="text" name="spec_names[]" x-model="spec.name" placeholder="e.g. Weight"
                                    class="flex-1 px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                                <input type="text" name="spec_values[]" x-model="spec.value" placeholder="e.g. 20 Tons"
                                    class="flex-1 px-4 py-3 rounded-xl border-2 border-slate-50 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/50">
                                <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1"
                                    class="p-3 text-red-400 hover:bg-red-50 rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Images -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8">
                    <h3 class="text-xs font-black text-green-600 uppercase tracking-[0.3em] mb-8">04. Media Gallery</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <label
                            class="aspect-square rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center cursor-pointer hover:border-green-600 hover:bg-green-50 transition-all group">
                            <input type="file" name="images[]" multiple class="hidden" @change="handleImageUpload">
                            <svg class="w-8 h-8 text-slate-300 group-hover:text-green-600 mb-2" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span
                                class="text-[9px] font-black text-slate-400 group-hover:text-green-600 uppercase tracking-widest text-center px-2">Upload
                                Images</span>
                        </label>

                        <template x-for="(preview, index) in imagePreviews" :key="index">
                            <div
                                class="aspect-square rounded-2xl border border-slate-200 overflow-hidden relative group">
                                <img :src="preview" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span
                                        class="text-white text-[10px] font-black tracking-widest uppercase">Preview</span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6">
                    <button type="submit"
                        class="bg-[#16A34A] text-white px-10 py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-green-700 shadow-2xl shadow-green-600/20 transition-all active:scale-[0.98]">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>