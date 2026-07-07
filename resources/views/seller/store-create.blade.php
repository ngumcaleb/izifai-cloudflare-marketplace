<x-seller-layout>
    <x-slot name="title">Create Your Store</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="text-center mb-6 md:mb-8">
            <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-primary">storefront</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Create Your Store</h1>
            <p class="text-sm text-gray-500 mt-1">Set up your storefront to start selling on Izifai</p>
        </div>

        <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6"
              x-data="{
                logoPreview: null,
                bannerPreview: null,
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
                                <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                                <span class="text-xs font-semibold mt-1">Logo</span>
                            </div>
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
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
                                <span class="material-symbols-outlined text-3xl">panorama</span>
                                <span class="text-xs font-semibold mt-1">Banner</span>
                            </div>
                            <div class="absolute inset-0 bg-primary/80 opacity-0 group-hover:opacity-100 transition-all flex flex-col items-center justify-center text-white rounded-2xl">
                                <span class="material-symbols-outlined text-2xl">camera_alt</span>
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
                        <label class="text-xs font-semibold text-gray-500 ml-1">Shop Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none leading-relaxed">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-end pt-4 md:pt-5 border-t border-gray-100 gap-3">
                    <a href="{{ route('home') }}"
                       class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-2.5 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">storefront</span>
                        Create My Store
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-seller-layout>