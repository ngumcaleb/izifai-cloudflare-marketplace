<x-seller-layout>
    <x-slot name="title">Post New Rental</x-slot>

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Add Rental Item</h1>
                <p class="text-sm text-gray-500 mt-0.5">Create a new rental listing</p>
            </div>
            <a href="{{ route('seller.rentals.index') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Rentals
            </a>
        </div>

        <form action="{{ route('seller.rentals.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                scActive: {{ $selectedCategory ? 'true' : 'false' }},
                scCustom: false,
                scVal: '{{ $selectedCategory?->id ?? '' }}',
                onScChange(val) {
                    this.scVal = val;
                    this.scActive = !!val && val !== '__new__' && val !== '';
                    if (val === '__new__') { this.scCustom = true; this.scVal = ''; }
                },
                imagePreviews: [],
                handleImageUpload(event) {
                    this.imagePreviews = [];
                    const files = event.target.files;
                    for(let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onload = (e) => { this.imagePreviews.push(e.target.result); };
                        reader.readAsDataURL(files[i]);
                    }
                }
              }">
            @csrf

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Essential Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <div class="md:col-span-2 space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Rental Title</label>
                        <input type="text" name="name" required placeholder="e.g. Canon 5D Mark IV Camera"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Category</label>
                        <select name="category_id" :disabled="scActive"
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Subcategory (optional)</label>
                        <select name="subcategory_id" :disabled="scActive"
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <option value="">None</option>
                            @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Collection</label>
                        @if($selectedCategory)
                            <div class="h-11 md:h-12 flex items-center gap-2 px-4 bg-primary/5 border border-primary/20 rounded-xl text-sm font-bold text-primary">
                                <span class="material-symbols-outlined text-[18px]">folder</span>
                                {{ $selectedCategory->name }}
                            </div>
                            <input type="hidden" name="store_category_id" value="{{ $selectedCategory->id }}">
                        @else
                            <template x-if="!scCustom">
                                <select name="store_category_id" x-model="scVal"
                                        @change="onScChange(scVal)"
                                        class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                    <option value="">None</option>
                                    @foreach($storeCategories as $sc)
                                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                                        @foreach($sc->children as $child)
                                            <option value="{{ $child->id }}">&nbsp;&nbsp;&nbsp;{{ $child->name }}</option>
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
                        @endif
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Rate (XAF)</label>
                        <input type="number" name="rate" required placeholder="e.g. 50000"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Billing Unit</label>
                        <select name="billing_unit" required
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <option value="">Select Period</option>
                            <option value="hourly">Per Hour</option>
                            <option value="daily">Per Day</option>
                            <option value="weekly">Per Week</option>
                            <option value="monthly">Per Month</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Deposit (XAF, optional)</label>
                        <input type="number" name="deposit" placeholder="e.g. 100000"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Location</label>
                        <input type="text" name="location" required placeholder="e.g. Douala, Cameroon"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Status</label>
                        <select name="status"
                                class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Serial Number (optional)</label>
                        <input type="text" name="serial_number" placeholder="e.g. SN-2024-001"
                               class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">photo_library</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Rental Media</h2>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-4">
                    <label class="aspect-square rounded-2xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-primary hover:bg-primary/[0.02] transition-all group overflow-hidden bg-gray-50">
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" @change="handleImageUpload">
                        <span class="material-symbols-outlined text-2xl md:text-3xl text-gray-300 group-hover:text-primary mb-1">cloud_upload</span>
                        <span class="text-xs font-semibold text-gray-400">Upload Photos</span>
                    </label>

                    <template x-for="(preview, index) in imagePreviews" :key="index">
                        <div class="aspect-square rounded-2xl border border-gray-200 overflow-hidden relative">
                            <img :src="preview" class="w-full h-full object-cover">
                        </div>
                    </template>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Full Description</h2>
                </div>
                <textarea name="description" rows="5" required placeholder="Describe your rental item, its condition, what's included..."
                          class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed"></textarea>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined">assignment_return</span>
                    </div>
                    <h2 class="text-base md:text-lg font-bold text-gray-900">Rental Policies</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Return Conditions</label>
                        <textarea name="return_conditions" rows="3" placeholder="e.g. Item must be returned in the same condition..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed"></textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Duration Rules</label>
                        <textarea name="duration_rules" rows="3" placeholder="e.g. Minimum rental period is 2 days..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed"></textarea>
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Condition Notes (optional)</label>
                        <textarea name="condition_notes" rows="3" placeholder="e.g. Minor scratches on body, fully functional..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('seller.rentals.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-3 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">publish</span>
                    Publish to Marketplace
                </button>
            </div>
        </form>
    </div>
</x-seller-layout>
