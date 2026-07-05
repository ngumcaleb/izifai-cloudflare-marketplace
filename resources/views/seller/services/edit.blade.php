<x-seller-layout>
    <x-slot name="title">Edit Service</x-slot>

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Modify Service</h1>
                <p class="text-sm text-gray-500 mt-0.5">Service #{{ $service->id }}</p>
            </div>
            <a href="{{ route('seller.services.index') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Services
            </a>
        </div>

        <form action="{{ route('seller.services.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                scActive: {{ $service->store_category_id ? 'true' : 'false' }},
                scCustom: false,
                scVal: '{{ $service->store_category_id ?? '' }}',
                packages: {{ Js::from($service->packages->map(fn($p) => ['id' => $p->id, 'name' => $p->name, 'description' => $p->description, 'price' => $p->price, 'delivery_time' => $p->delivery_time])) }},
                addPackage() {
                    this.packages.push({ id: null, name: '', description: '', price: '', delivery_time: '' });
                },
                removePackage(i) {
                    if (this.packages.length > 1) this.packages.splice(i, 1);
                },
                onScChange(val) {
                    this.scVal = val;
                    this.scActive = !!val && val !== '__new__' && val !== '';
                    if (val === '__new__') { this.scCustom = true; this.scVal = ''; }
                },
                imagePreviews: {{ Js::from($service->images->map(fn($i) => $i->url)) }},
                mainImageIndex: {{ $service->images->search(fn($i) => $i->is_main) ?: 0 }},
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

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Essential Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Service Title</label>
                        <input type="text" name="name" value="{{ $service->name }}" required
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Category</label>
                        <select name="category_id" :disabled="scActive"
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Store Category <span class="text-gray-400 font-normal">(optional)</span></label>
                        <template x-if="!scCustom">
                            <select name="store_category_id" x-model="scVal"
                                    @change="onScChange(scVal)"
                                    class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <option value="">None</option>
                                @foreach($storeCategories as $sc)
                                    <option value="{{ $sc->id }}" {{ $service->store_category_id == $sc->id ? 'selected' : '' }}>{{ $sc->name }}</option>
                                    @foreach($sc->children as $child)
                                        <option value="{{ $child->id }}" {{ $service->store_category_id == $child->id ? 'selected' : '' }}>&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
                                    @endforeach
                                @endforeach
                                <option value="__new__">+ Add custom category...</option>
                            </select>
                        </template>
                        <template x-if="scCustom">
                            <div class="flex gap-2">
                                <input type="text" name="store_category_name" placeholder="Type your category name"
                                       class="flex-1 h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <button type="button" @click="scCustom = false; scVal = ''; onScChange('')"
                                        class="shrink-0 px-3 text-xs font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </template>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Starting Price (XAF)</label>
                        <input type="number" name="starting_price" value="{{ $service->starting_price }}" required
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Delivery Time</label>
                        <input type="text" name="delivery_time" value="{{ $service->delivery_time }}"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Status</label>
                        <select name="status"
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <option value="active" {{ $service->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $service->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">photo_library</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Service Media</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    <label class="aspect-square rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/[0.02] transition-all group overflow-hidden bg-gray-50">
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleImageUpload">
                        <span class="material-symbols-outlined text-2xl md:text-3xl text-gray-300 group-hover:text-primary mb-1">cloud_upload</span>
                        <span class="text-xs font-semibold text-gray-400">Replace Photos</span>
                    </label>

                    <template x-for="(preview, index) in imagePreviews" :key="index">
                        <div class="aspect-square rounded-2xl border border-gray-200 overflow-hidden relative group cursor-pointer" @click="mainImageIndex = index">
                            <img :src="preview" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-primary/40 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center" :class="mainImageIndex == index ? 'opacity-100' : ''">
                                <span class="text-[8px] font-bold text-white uppercase tracking-widest" x-text="mainImageIndex == index ? 'Main Image' : 'Set Main'"></span>
                            </div>
                        </div>
                    </template>
                </div>
                <p class="text-xs text-gray-400 italic">* Uploading new images will replace all existing images.</p>
                <input type="hidden" name="main_image_index" :value="mainImageIndex">
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">description</span>
                        </div>
                        <h2 class="text-base md:text-lg font-bold text-gray-900">Full Description</h2>
                    </div>
                    <textarea name="description" rows="5" required
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed">{{ $service->description }}</textarea>
                </div>

                <div class="pt-4 md:pt-5 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">package</span>
                            </div>
                            <h2 class="text-base md:text-lg font-bold text-gray-900">Service Packages</h2>
                        </div>
                        <button type="button" @click="addPackage"
                                class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            Add Package
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(pkg, index) in packages" :key="index">
                            <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/50 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider" x-text="'Package #' + (index + 1)"></span>
                                    <button type="button" @click="removePackage(index)" x-show="packages.length > 1"
                                            class="text-red-500 hover:bg-red-50 p-1 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <template x-if="pkg.id != null && pkg.id !== undefined && pkg.id !== ''">
                                        <input type="hidden" :name="`packages[${index}][id]`" :value="pkg.id">
                                    </template>
                                    <input type="text" :name="`packages[${index}][name]`" x-model="pkg.name" required placeholder="Package name (e.g. Basic)"
                                           class="w-full h-10 bg-white border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    <input type="number" :name="`packages[${index}][price]`" x-model="pkg.price" required placeholder="Price (XAF)"
                                           class="w-full h-10 bg-white border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    <input type="text" :name="`packages[${index}][delivery_time]`" x-model="pkg.delivery_time" placeholder="Delivery time (e.g. 2 days)"
                                           class="w-full h-10 bg-white border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30">
                                    <div class="md:col-span-2">
                                        <textarea :name="`packages[${index}][description]`" x-model="pkg.description" placeholder="What's included in this package?"
                                                  class="w-full h-16 bg-white border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('seller.services.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-3 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">update</span>
                    Update Service Listing
                </button>
            </div>
        </form>
    </div>
</x-seller-layout>
