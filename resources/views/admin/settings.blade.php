<x-admin-layout>
    <x-slot name="header">Settings</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/minimalist-workspace-with-laptop_23-2148176682.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-lg md:text-2xl font-bold text-white tracking-tight">
                System <span class="text-gold-400">Settings</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-sm mt-1">
                Manage your platform configurations and security parameters.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <div x-data="{ section: 'general' }" class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1">
            <div class="flex lg:flex-col overflow-x-auto no-scrollbar gap-2 lg:gap-1">
                <button @click="section = 'general'" 
                        :class="section === 'general' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">General</span>
                </button>
                <button @click="section = 'verification'" 
                        :class="section === 'verification' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="shield-check" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Verification</span>
                </button>
                <button @click="section = 'ads'" 
                        :class="section === 'ads' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="megaphone" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Promotion</span>
                </button>
                <button @click="section = 'store-images'" 
                        :class="section === 'store-images' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="store" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Store Images</span>
                </button>
                <button @click="section = 'financial'" 
                        :class="section === 'financial' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="banknote" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Financial</span>
                </button>
                <button @click="section = 'security'" 
                        :class="section === 'security' ? 'bg-white border-gold-400 text-navy-800' : 'bg-transparent border-transparent text-slate-400 hover:text-slate-600'"
                        class="flex-shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-lg border-l-4 transition-all duration-200">
                    <i data-lucide="lock" class="w-4 h-4"></i>
                    <span class="text-xs font-bold uppercase tracking-wider">Security</span>
                </button>
            </div>
        </div>

                <!-- Form Content -->
        <div class="lg:col-span-3">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="admin-card p-6 md:p-8 space-y-8 bg-white">
                @csrf
                
                <!-- General Section -->
                <div x-show="section === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">General Information</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Global branding and support details.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">App Name</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Izifai Marketplace' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Support Email</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'support@izifai.com' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Platform Slogan</label>
                            <input type="text" name="site_slogan" value="{{ $settings['site_slogan'] ?? 'The Easiest way to buy and sell in Cameroon' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Footer Branding Text</label>
                            <input type="text" name="site_footer_branding" value="{{ $settings['site_footer_branding'] ?? "Cameroon's Professional Marketplace." }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Hero Background Image</label>
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 w-32 h-20 rounded-lg overflow-hidden bg-slate-100 border border-slate-200">
                                    @if(!empty($settings['hero_image']))
                                        <img src="{{ r2_url($settings['hero_image']) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <i data-lucide="image" class="w-6 h-6"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="hero_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy-800 file:text-white hover:file:bg-gold-400 hover:file:text-white file:transition-all file:cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-1.5">Recommended: 1920x600px, JPEG or WebP. Uploading a new image replaces the current one.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Section -->
                <div x-show="section === 'verification'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">Merchant Verification</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Configure store authorization workflow.</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                            <div class="pr-4">
                                <p class="text-xs font-bold text-navy-800">Manual Store Approval</p>
                                <p class="text-[10px] text-slate-500 font-medium">Admins must manually approve every new store registration.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="manual_approval" value="0">
                                <input type="checkbox" name="manual_approval" value="1" {{ ($settings['manual_approval'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-navy-800"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                            <div class="pr-4">
                                <p class="text-xs font-bold text-navy-800">Business Documents Required</p>
                                <p class="text-[10px] text-slate-500 font-medium">Require merchants to upload ID or business license.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="docs_required" value="0">
                                <input type="checkbox" name="docs_required" value="1" {{ ($settings['docs_required'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-navy-800"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Promotion Section -->
                <div x-show="section === 'ads'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">Promotions & Advertising</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Control pricing and visibility rules.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Default Ad Duration (Days)</label>
                            <input type="number" name="default_ad_duration" value="{{ $settings['default_ad_duration'] ?? '7' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Max Active Ads per Store</label>
                            <input type="number" name="max_ads_per_store" value="{{ $settings['max_ads_per_store'] ?? '3' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Ad Price Per Day (XAF)</label>
                            <input type="number" name="ad_price_per_day" value="{{ $settings['ad_price_per_day'] ?? '200' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Promotion Daily Rate (XAF)</label>
                            <input type="number" name="promo_daily_rate" value="{{ $settings['promo_daily_rate'] ?? '500' }}" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Commission Rate (%)</label>
                            <input type="number" name="commission_rate" value="{{ $settings['commission_rate'] ?? '10' }}" min="0" max="100" step="0.1" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <!-- Store Images Section -->
                <div x-show="section === 'store-images'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">Default Store Images</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Upload default logo and cover images shown when a store hasn't set their own.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Default Store Logo</label>
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 w-20 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="{{ url('/r2/default-logo.jpg') }}?v={{ $settings['default_logo_version'] ?? '1' }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=&quot;w-full h-full flex items-center justify-center text-slate-300&quot;><i data-lucide=&quot;image&quot; class=&quot;w-6 h-6&quot;></i></div>'">
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="default_store_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy-800 file:text-white hover:file:bg-gold-400 hover:file:text-white file:transition-all file:cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-1.5">Square image recommended. JPEG, PNG, or WebP.</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Default Store Cover</label>
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 w-28 h-20 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                    <img src="{{ url('/r2/default-banner.jpg') }}?v={{ $settings['default_banner_version'] ?? '1' }}" class="w-full h-full object-cover" onerror="this.parentElement.innerHTML='<div class=&quot;w-full h-full flex items-center justify-center text-slate-300&quot;><i data-lucide=&quot;image&quot; class=&quot;w-6 h-6&quot;></i></div>'">
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="default_store_banner" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-navy-800 file:text-white hover:file:bg-gold-400 hover:file:text-white file:transition-all file:cursor-pointer">
                                    <p class="text-[10px] text-slate-400 mt-1.5">1200x400px recommended. JPEG, PNG, or WebP.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Section -->
                <div x-show="section === 'financial'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">Financial Settings</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Platform fees, commissions, and withdrawal rules.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Platform Fee Rate (%)</label>
                            <input type="number" name="platform_fee_percentage" value="{{ $settings['platform_fee_percentage'] ?? '5' }}" min="0" max="100" step="0.5"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                            <p class="text-[9px] text-slate-400 mt-1">Percentage deducted from each sale as platform commission.</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Min Withdrawal Amount (XAF)</label>
                            <input type="number" name="min_withdrawal" value="{{ $settings['min_withdrawal'] ?? '1000' }}" min="0" step="500"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                            <p class="text-[9px] text-slate-400 mt-1">Minimum amount a seller can request for withdrawal.</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Platform Currency</label>
                            <input type="text" name="platform_currency" value="{{ $settings['platform_currency'] ?? 'XAF' }}" maxlength="10"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                            <p class="text-[9px] text-slate-400 mt-1">Currency code used across the platform.</p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider">Platform Support Email</label>
                            <input type="email" name="platform_support_email" value="{{ $settings['platform_support_email'] ?? 'support@izifai.com' }}"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-semibold text-navy-800 focus:ring-1 focus:ring-gold-400 focus:border-gold-400 outline-none transition-all">
                            <p class="text-[9px] text-slate-400 mt-1">Displayed to users for withdrawal inquiries.</p>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div x-show="section === 'security'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                    <div class="mb-6">
                        <h3 class="text-base font-bold text-navy-800">Security & Maintenance</h3>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Manage platform access and security settings.</p>
                    </div>
                    
                    <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-rose-800">Maintenance Mode</p>
                            <p class="text-[10px] text-rose-600/70 font-medium">Disable public access during updates.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="maintenance_mode" value="0">
                            <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-rose-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-rose-600"></div>
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-gold-400 hover:text-white transition-all shadow-md">
                        Save Configurations
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
