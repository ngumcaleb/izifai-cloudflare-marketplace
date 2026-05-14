<x-seller-layout>
    <x-slot name="title">Store Identity</x-slot>

    <div class="max-w-4xl mx-auto animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Store Settings</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage your store identity and business information</p>
            </div>
            <a href="{{ route('seller.dashboard') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Dashboard
            </a>
        </div>

        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                socialLinks: {{ Js::from($store->social_links ?? []) }}.length ? {{ Js::from($store->social_links ?? []) }} : [{ platform: '', url: '' }],
                addSocial() { this.socialLinks.push({ platform: '', url: '' }) },
                removeSocial(i) { this.socialLinks.splice(i, 1) }
              }">
            @csrf @method('PUT')

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <!-- Logo & Banner -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5">
                    <div class="md:col-span-1 flex flex-col items-center max-w-[200px] mx-auto md:max-w-none">
                        <label class="relative group cursor-pointer aspect-square w-full rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-gray-50">
                            <input type="file" name="logo" class="hidden" accept="image/*">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-gray-300">
                                    <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                                    <span class="text-xs font-semibold mt-1">Logo</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
                                <span class="text-xs font-bold mt-1">Update</span>
                            </div>
                        </label>
                        <p class="text-xs font-semibold text-gray-400 mt-3">Store Logo</p>
                    </div>

                    <div class="md:col-span-3">
                        <label class="relative group cursor-pointer h-28 md:h-32 w-full rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-gray-50">
                            <input type="file" name="banner" class="hidden" accept="image/*">
                            @if($store->banner)
                                <img src="{{ asset('storage/' . $store->banner) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center text-gray-300">
                                    <span class="material-symbols-outlined text-3xl">panorama</span>
                                    <span class="text-xs font-semibold mt-1">Banner</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
                                <span class="text-xs font-bold mt-1">Upload Header</span>
                            </div>
                        </label>
                        <p class="text-xs font-semibold text-gray-400 mt-3">Header Image (1200x400)</p>
                    </div>
                </div>

                <!-- Business Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 pt-4 md:pt-5 border-t border-gray-100">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Business Name</label>
                        <input type="text" name="name" value="{{ $store->name }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Business Email</label>
                        <input type="email" name="business_email" value="{{ $store->business_email }}"
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">City / Location</label>
                        <input type="text" name="location" value="{{ $store->location }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Display Name</label>
                        <input type="text" name="user_name" value="{{ auth()->user()->name }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="col-span-full space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Shop Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed">{{ $store->description }}</textarea>
                    </div>
                </div>

                <!-- Open Hours -->
                <div class="pt-4 md:pt-5 border-t border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">schedule</span>
                        </div>
                        <h2 class="text-base md:text-lg font-bold text-gray-900">Business Hours</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Open Hours</label>
                            <textarea name="open_hours" rows="4"
                                      class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed"
                                      placeholder="e.g.&#10;Mon - Fri: 8:00 AM - 6:00 PM&#10;Sat: 9:00 AM - 2:00 PM&#10;Sun: Closed">{{ $store->open_hours }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Default Landing Page -->
                <div class="pt-4 md:pt-5 border-t border-gray-100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">flag</span>
                        </div>
                        <h2 class="text-base md:text-lg font-bold text-gray-900">Default Landing Page</h2>
                    </div>
                    <p class="text-xs text-gray-500 mb-3">Choose where you land after login</p>
                    <select name="default_page"
                            class="w-full md:w-72 h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                        <option value="dashboard" {{ auth()->user()->default_page == 'dashboard' ? 'selected' : '' }}>My Shop Home (Dashboard)</option>
                        <option value="products.index" {{ auth()->user()->default_page == 'products.index' ? 'selected' : '' }}>All My Items</option>
                        <option value="products.create" {{ auth()->user()->default_page == 'products.create' ? 'selected' : '' }}>Add New Product</option>
                        <option value="ads.index" {{ auth()->user()->default_page == 'ads.index' ? 'selected' : '' }}>Promote Items</option>
                        <option value="store.settings" {{ auth()->user()->default_page == 'store.settings' ? 'selected' : '' }}>Store Settings</option>
                    </select>
                </div>

                <!-- Social Links -->
                <div class="pt-4 md:pt-5 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">share</span>
                            </div>
                            <h2 class="text-base md:text-lg font-bold text-gray-900">Social Media Links</h2>
                        </div>
                        <button type="button" @click="addSocial"
                                class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">add</span>
                            Add Link
                        </button>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(link, i) in socialLinks" :key="i">
                            <div class="flex gap-2 items-start">
                                <select name="social_platforms[]" x-model="link.platform"
                                        class="w-28 md:w-36 h-10 bg-gray-50 border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                    <option value="">Select</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="instagram">Instagram</option>
                                    <option value="twitter">Twitter / X</option>
                                    <option value="linkedin">LinkedIn</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="whatsapp_group">WhatsApp Group</option>
                                </select>
                                <input type="url" name="social_urls[]" x-model="link.url" placeholder="https://..."
                                       class="min-w-0 flex-1 h-10 bg-gray-50 border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <button type="button" @click="removeSocial(i)" x-show="socialLinks.length > 1"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-all shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end pt-4 md:pt-5 border-t border-gray-100 gap-3">
                    <a href="{{ route('seller.dashboard') }}"
                       class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Save Settings
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-seller-layout>