<x-seller-layout>
    <x-slot name="title">Create Your Store</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="text-center mb-6 md:mb-8">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-store text-3xl text-primary"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create Your Store</h1>
            <p class="text-sm text-gray-500 mt-1">Set up your storefront to start selling on Izifai</p>
        </div>

        <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                socialLinks: [{ platform: '', url: '' }],
                logoPreview: null,
                bannerPreview: null,
                addSocial() { this.socialLinks.push({ platform: '', url: '' }) },
                removeSocial(i) { this.socialLinks.splice(i, 1) },
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

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4 md:space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-5">
                    <div class="md:col-span-1 flex flex-col items-center max-w-[200px] mx-auto md:max-w-none">
                        <label class="relative group cursor-pointer aspect-square w-full rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-gray-50">
                            <input type="file" name="logo" class="hidden" accept="image/*" @change="previewLogo">
                            <img x-show="logoPreview" :src="logoPreview" class="w-full h-full object-cover">
                            <div x-show="!logoPreview" class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <i class="fa-solid fa-images text-3xl"></i>
                                <span class="text-xs font-semibold mt-1">Logo</span>
                            </div>
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <i class="fa-solid fa-camera text-2xl"></i>
                                <span class="text-xs font-bold mt-1">Upload</span>
                            </div>
                        </label>
                        <p class="text-xs font-semibold text-gray-400 mt-3">Store Logo</p>
                    </div>

                    <div class="md:col-span-3">
                        <label class="relative group cursor-pointer h-28 md:h-32 w-full rounded-2xl border-2 border-dashed border-gray-200 overflow-hidden flex items-center justify-center hover:border-primary transition-all bg-gray-50">
                            <input type="file" name="banner" class="hidden" accept="image/*" @change="previewBanner">
                            <img x-show="bannerPreview" :src="bannerPreview" class="w-full h-full object-cover">
                            <div x-show="!bannerPreview" class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                <i class="fa-solid fa-image text-3xl"></i>
                                <span class="text-xs font-semibold mt-1">Banner</span>
                            </div>
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <i class="fa-solid fa-camera text-2xl"></i>
                                <span class="text-xs font-bold mt-1">Upload</span>
                            </div>
                        </label>
                        <p class="text-xs font-semibold text-gray-400 mt-3">Header Image (1200x400)</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 pt-4 md:pt-5 border-t border-gray-100">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Business Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">WhatsApp Number *</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Business Email</label>
                        <input type="email" name="business_email" value="{{ old('business_email') }}"
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">City / Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}" required
                               class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    </div>
                    <div class="col-span-full space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">Shop Description <span class="font-normal text-gray-400">(short tagline shown under your store name)</span></label>
                        <textarea name="description" rows="3"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-span-full space-y-1.5">
                        <label class="text-xs font-semibold text-gray-500 ml-1">About Your Store</label>
                        <textarea name="about" rows="5"
                                  placeholder="Tell customers your story — who you are, what you sell, why they can trust you..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed">{{ old('about') }}</textarea>
                        <p class="text-[11px] text-gray-400 ml-1">This appears on your public store page as your full "About" story.</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="pt-4 md:pt-5 border-t border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                            <h2 class="text-base md:text-lg font-bold text-gray-900">Social Media Links</h2>
                        </div>
                        <button type="button" @click="addSocial"
                                class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                            <i class="fa-solid fa-plus text-[16px]"></i>
                            Add Link
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mb-3 -mt-2">Link your Facebook, Instagram, TikTok and more so customers can follow you.</p>
                    <div class="space-y-2.5">
                        <template x-for="(link, i) in socialLinks" :key="i">
                            <div class="flex gap-2 items-start">
                                <select name="social_links[i][platform]" x-model="link.platform"
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
                                <input type="url" name="social_links[i][url]" x-model="link.url" placeholder="https://..."
                                       class="min-w-0 flex-1 h-10 bg-gray-50 border border-gray-200 rounded-xl px-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <button type="button" @click="removeSocial(i)" x-show="socialLinks.length > 1"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-xl transition-all shrink-0">
                                    <i class="fa-solid fa-trash text-[18px]"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end pt-4 md:pt-5 border-t border-gray-100 gap-3">
                    <a href="{{ route('home') }}"
                       class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-store text-[18px]"></i>
                        Create My Store
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-seller-layout>