<x-seller-layout>
    <x-slot name="title">Edit Listing</x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h2 class="text-headline-md md:text-headline-lg text-on-surface tracking-tight">Modify Item</h2>
                <p class="font-label-sm text-on-surface-variant mt-1">Listing #{{ $product->id }}</p>
            </div>
            <a href="{{ route('seller.products.index') }}" class="font-label-md text-on-surface-variant hover:text-primary flex items-center gap-2 transition-colors text-sm md:text-base">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to Inventory
            </a>
        </div>

        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                specs: ({{ Js::from($product->specifications->map(fn($s) => ['name' => $s->key, 'value' => $s->value])) }}).length ? {{ Js::from($product->specifications->map(fn($s) => ['name' => $s->key, 'value' => $s->value])) }} : [{ name: '', value: '' }],
                colors: {{ Js::from($product->colors ?? []) }},
                sizes: {{ Js::from($product->sizes ?? []) }},
                newColor: '',
                newSize: '',
                addColor() {
                    const c = this.newColor.trim();
                    if (c && !this.colors.includes(c)) { this.colors.push(c); this.newColor = ''; }
                },
                removeColor(i) { this.colors.splice(i, 1); },
                addSize() {
                    const s = this.newSize.trim();
                    if (s && !this.sizes.includes(s)) { this.sizes.push(s); this.newSize = ''; }
                },
                removeSize(i) { this.sizes.splice(i, 1); },
                imagePreviews: {{ Js::from($product->images->map(fn($i) => asset('storage/' . $i->path))) }},
                mainImageIndex: {{ $product->images->search(fn($i) => $i->is_main) ?: 0 }},
                handleImageUpload(event) {
                    this.imagePreviews = [];
                    this.mainImageIndex = 0;
                    const files = event.target.files;
                    for(let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.imagePreviews.push(e.target.result); };
                        reader.readAsDataURL(files[i]);
                    }
                }
              }">
            @csrf @method('PUT')

            <!-- Basic Details -->
            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] space-y-4 md:space-y-md">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <h3 class="font-headline-sm md:font-headline-md text-on-surface">Essential Information</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-md">
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Product Title</label>
                        <input type="text" name="name" value="{{ $product->name }}" required
                               class="w-full h-12 md:h-14 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl md:rounded-2xl px-4 md:px-6 text-body-md text-on-surface outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Category</label>
                        <select name="category_id" required
                                class="w-full h-12 md:h-14 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl md:rounded-2xl px-4 md:px-6 text-body-md outline-none">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Stock Status</label>
                        <select name="stock_status"
                                class="w-full h-12 md:h-14 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl md:rounded-2xl px-4 md:px-6 text-body-md outline-none">
                            <option value="in_stock" {{ $product->stock_status == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="out_of_stock" {{ $product->stock_status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="on_request" {{ $product->stock_status == 'on_request' ? 'selected' : '' }}>On Request</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Price (XAF)</label>
                        <input type="number" name="price" value="{{ $product->price }}" required
                               class="w-full h-12 md:h-14 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl md:rounded-2xl px-4 md:px-6 text-body-md outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Old Price (Optional)</label>
                        <input type="number" name="old_price" value="{{ $product->old_price }}"
                               class="w-full h-12 md:h-14 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl md:rounded-2xl px-4 md:px-6 text-body-md outline-none">
                    </div>
                </div>
            </div>

            <!-- Colors & Sizes -->
            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] space-y-4 md:space-y-md">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">palette</span>
                    </div>
                    <h3 class="font-headline-sm md:font-headline-md text-on-surface">Colors & Sizes</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-md">
                    <div class="space-y-3">
                        <label class="font-label-sm text-on-surface-variant ml-1">Available Colors</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="newColor" @keydown.enter.prevent="addColor"
                                   placeholder="e.g. Metallic Red"
                                   class="flex-1 h-11 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-4 text-body-md outline-none">
                            <button type="button" @click="addColor"
                                    class="px-4 bg-primary text-white rounded-xl font-label-md hover:opacity-90 transition-opacity shrink-0">
                                Add
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2" x-show="colors.length > 0">
                            <template x-for="(color, i) in colors" :key="i">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-full text-label-sm">
                                    <span x-text="color"></span>
                                    <button type="button" @click="removeColor(i)" class="hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                    </button>
                                </span>
                            </template>
                        </div>
                        <template x-for="(color, i) in colors" :key="i">
                            <input type="hidden" name="colors[]" :value="color">
                        </template>
                    </div>

                    <div class="space-y-3">
                        <label class="font-label-sm text-on-surface-variant ml-1">Available Sizes</label>
                        <div class="flex gap-2">
                            <input type="text" x-model="newSize" @keydown.enter.prevent="addSize"
                                   placeholder="e.g. XL, 42, 500ml"
                                   class="flex-1 h-11 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-4 text-body-md outline-none">
                            <button type="button" @click="addSize"
                                    class="px-4 bg-primary text-white rounded-xl font-label-md hover:opacity-90 transition-opacity shrink-0">
                                Add
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2" x-show="sizes.length > 0">
                            <template x-for="(size, i) in sizes" :key="i">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-primary/10 text-primary rounded-full text-label-sm">
                                    <span x-text="size"></span>
                                    <button type="button" @click="removeSize(i)" class="hover:text-error transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">close</span>
                                    </button>
                                </span>
                            </template>
                        </div>
                        <template x-for="(size, i) in sizes" :key="i">
                            <input type="hidden" name="sizes[]" :value="size">
                        </template>
                    </div>
                </div>
            </div>

            <!-- Media Gallery -->
            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] space-y-4 md:space-y-md">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">photo_library</span>
                    </div>
                    <h3 class="font-headline-sm md:font-headline-md text-on-surface">Product Media</h3>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    <label class="aspect-square rounded-2xl md:rounded-3xl border-2 md:border-4 border-dashed border-outline-variant flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/5 transition-all group overflow-hidden bg-surface-container-low">
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleImageUpload">
                        <span class="material-symbols-outlined text-2xl md:text-3xl text-on-surface-variant/40 group-hover:text-primary mb-1 md:mb-2">cloud_upload</span>
                        <span class="font-label-sm text-on-surface-variant/60">Replace Photos</span>
                    </label>

                    <template x-for="(preview, index) in imagePreviews" :key="index">
                        <div class="aspect-square rounded-2xl md:rounded-3xl border border-outline-variant/30 overflow-hidden relative group cursor-pointer" @click="mainImageIndex = index">
                            <img :src="preview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center" :class="mainImageIndex == index ? 'opacity-100' : ''">
                                <span class="text-[8px] font-bold text-white uppercase tracking-widest" x-text="mainImageIndex == index ? 'Main Image' : 'Set Main'"></span>
                            </div>
                        </div>
                    </template>
                </div>
                <p class="font-label-sm text-on-surface-variant mt-2 italic">* Note: Uploading new images will replace all existing images.</p>
                <input type="hidden" name="main_image_index" :value="mainImageIndex">
            </div>

            <!-- Description & Specs -->
            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] space-y-4 md:space-y-lg">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <h3 class="font-headline-sm md:font-headline-md text-on-surface">Full Description</h3>
                    </div>
                    <textarea name="description" rows="5" required
                              class="w-full bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-2xl md:rounded-3xl p-4 md:p-6 text-body-md outline-none resize-none leading-relaxed">{{ $product->description }}</textarea>
                </div>

                <div class="pt-4 md:pt-lg border-t border-outline-variant/30">
                    <div class="flex items-center justify-between mb-4 md:mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">list_alt</span>
                            </div>
                            <h3 class="font-headline-sm md:font-headline-md text-on-surface">Specifications</h3>
                        </div>
                        <button type="button" @click="specs.push({ name: '', value: '' })"
                                class="font-label-md text-primary hover:underline flex items-center gap-1 text-sm md:text-base">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            Add Attribute
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                                <input type="text" name="spec_names[]" x-model="spec.name" placeholder="e.g. Color"
                                       class="w-full sm:flex-1 h-10 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-3 text-body-md outline-none text-sm">
                                <input type="text" name="spec_values[]" x-model="spec.value" placeholder="e.g. Metallic Red"
                                       class="w-full sm:flex-1 h-10 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-3 text-body-md outline-none text-sm">
                                <button type="button" @click="specs.splice(index, 1)" x-show="specs.length > 1"
                                        class="self-end sm:self-auto p-2 text-error hover:bg-error-container rounded-xl transition-all shrink-0">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('seller.products.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 md:py-4 rounded-full font-label-md md:font-label-lg text-on-surface-variant hover:bg-surface-container-high transition-colors border border-outline-variant">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 md:px-12 py-3 md:py-4 rounded-full font-label-md md:font-label-lg hover:opacity-90 transition-opacity shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px] md:text-[20px]">update</span>
                    Update Marketplace Listing
                </button>
            </div>
        </form>
    </div>
</x-seller-layout>
