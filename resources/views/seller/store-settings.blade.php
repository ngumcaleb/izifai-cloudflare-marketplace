<x-seller-layout>
    <x-slot name="title">Store Identity</x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                socialLinks: {{ Js::from($store->social_links ?? []) }}.length ? {{ Js::from($store->social_links ?? []) }} : [{ platform: '', url: '' }],
                addSocial() { this.socialLinks.push({ platform: '', url: '' }) },
                removeSocial(i) { this.socialLinks.splice(i, 1) }
              }">
            @csrf @method('PUT')

            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] space-y-4 md:space-y-xl">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-xl">
                    <!-- Logo Upload -->
                    <div class="md:col-span-1 flex flex-col items-center max-w-[200px] mx-auto md:max-w-none">
                        <label class="relative group cursor-pointer aspect-square w-full rounded-2xl border-2 border-dashed border-outline-variant overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-surface-container-low">
                            <input type="file" name="logo" class="hidden" accept="image/*">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-on-surface-variant/40">
                                    <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                                    <span class="text-label-sm mt-1">Logo</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
                                <span class="font-label-md mt-1">Update</span>
                            </div>
                        </label>
                        <p class="font-label-sm text-on-surface-variant mt-3">Store Logo</p>
                    </div>

                    <!-- Banner Upload -->
                    <div class="md:col-span-3">
                        <label class="relative group cursor-pointer h-28 md:h-32 w-full rounded-2xl border-2 border-dashed border-outline-variant overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-surface-container-low">
                            <input type="file" name="banner" class="hidden" accept="image/*">
                            @if($store->banner)
                                <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-on-surface-variant/40">
                                    <span class="material-symbols-outlined text-3xl">panorama</span>
                                    <span class="font-label-sm mt-1">Profile Banner</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
                                <span class="font-label-md mt-1">Upload Header</span>
                            </div>
                        </label>
                        <p class="font-label-sm text-on-surface-variant mt-3">Header Image (1200x400)</p>
                    </div>
                </div>

                <!-- Business Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-md pt-4 md:pt-lg border-t border-outline-variant/30">
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">Business Name</label>
                        <input type="text" name="name" value="{{ $store->name }}" required
                               class="w-full px-4 py-2.5 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" required
                               class="w-full px-4 py-2.5 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">Business Email</label>
                        <input type="email" name="business_email" value="{{ $store->business_email }}"
                               class="w-full px-4 py-2.5 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">City / Location</label>
                        <input type="text" name="location" value="{{ $store->location }}" required
                               class="w-full px-4 py-2.5 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">Display Name</label>
                        <input type="text" name="user_name" value="{{ auth()->user()->name }}" required
                               class="w-full px-4 py-2.5 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>
                    <div class="col-span-full space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-0.5">Shop Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-3 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none resize-none leading-relaxed">{{ $store->description }}</textarea>
                    </div>
                </div>

                <!-- Open Hours -->
                <div class="pt-4 md:pt-lg border-t border-outline-variant/30">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <h3 class="font-headline-sm md:font-headline-md text-on-surface">Business Hours</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="font-label-sm text-on-surface-variant ml-0.5">Open Hours</label>
                            <textarea name="open_hours" rows="4"
                                      class="w-full px-4 py-3 bg-surface-container-low border-none rounded-xl text-body-md focus:ring-2 focus:ring-primary outline-none resize-none leading-relaxed"
                                      placeholder="e.g.&#10;Mon - Fri: 8:00 AM - 6:00 PM&#10;Sat: 9:00 AM - 2:00 PM&#10;Sun: Closed">{{ $store->open_hours }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Default Landing Page -->
                <div class="pt-4 md:pt-lg border-t border-outline-variant/30">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">flag</span>
                        </div>
                        <h3 class="font-headline-sm md:font-headline-md text-on-surface">Default Landing Page</h3>
                    </div>
                    <p class="text-label-sm text-on-surface-variant mb-3">Choose where you land after login</p>
                    <select name="default_page"
                            class="w-full md:w-72 h-12 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-4 text-body-md outline-none">
                        <option value="dashboard" {{ auth()->user()->default_page == 'dashboard' ? 'selected' : '' }}>My Shop Home (Dashboard)</option>
                        <option value="products.index" {{ auth()->user()->default_page == 'products.index' ? 'selected' : '' }}>All My Items</option>
                        <option value="products.create" {{ auth()->user()->default_page == 'products.create' ? 'selected' : '' }}>Add New Product</option>
                        <option value="ads.index" {{ auth()->user()->default_page == 'ads.index' ? 'selected' : '' }}>Promote Items</option>
                        <option value="store.settings" {{ auth()->user()->default_page == 'store.settings' ? 'selected' : '' }}>Store Settings</option>
                    </select>
                </div>

                <!-- Social Links -->
                <div class="pt-4 md:pt-lg border-t border-outline-variant/30">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 md:w-8 md:h-8 rounded-xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">share</span>
                            </div>
                            <h3 class="font-headline-sm md:font-headline-md text-on-surface">Social Media Links</h3>
                        </div>
                        <button type="button" @click="addSocial"
                                class="font-label-md text-primary hover:underline flex items-center gap-1 text-sm md:text-base">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            Add Link
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(link, i) in socialLinks" :key="i">
                            <div class="flex gap-2 md:gap-3 items-start">
                                <select name="social_platforms[]" x-model="link.platform"
                                        class="w-36 md:w-40 h-11 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-3 text-body-md outline-none text-sm">
                                    <option value="">Select</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="twitter">Twitter / X</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="youtube">YouTube</option>
                                </select>
                                <input type="url" name="social_urls[]" x-model="link.url" placeholder="https://..."
                                       class="flex-1 h-11 bg-surface-container-low border-none focus:ring-2 focus:ring-primary rounded-xl px-3 text-body-md outline-none text-sm">
                                <button type="button" @click="removeSocial(i)" x-show="socialLinks.length > 1"
                                        class="p-2.5 text-error hover:bg-error-container rounded-xl transition-all shrink-0">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end pt-4 md:pt-md border-t border-outline-variant/30 gap-3">
                    <a href="{{ route('seller.dashboard') }}"
                       class="w-full sm:w-auto text-center px-6 py-3 rounded-full font-label-md md:font-label-lg text-on-surface-variant hover:bg-surface-container-high transition-colors border border-outline-variant">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-3 rounded-full font-label-md md:font-label-lg hover:opacity-90 transition-opacity shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px] md:text-[20px]">save</span>
                        Save Identity
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-seller-layout>
