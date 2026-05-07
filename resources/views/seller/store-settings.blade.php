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
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span>Product Catalog</span>
                </a>
                <a href="{{ route('seller.store.settings') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-green-600 text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Store Profile</span>
                </a>
                <div class="pt-4 mt-4 border-t border-white/5">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-white font-bold text-[11px] transition-all">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Personal Settings</span>
                    </a>
                </div>
            </nav>
        </aside>
    </x-slot>

    <div class="p-6 md:p-8">
        <div class="max-w-4xl">
            <div class="mb-10">
                <h1 class="text-2xl font-black text-slate-900 mb-2">Unified Profile Settings</h1>
                <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Manage your personal identity
                    and business storefront in one place.</p>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Combined Header -->
                <div class="p-8 bg-slate-50 border-b border-slate-100 flex flex-col md:flex-row md:items-center gap-8">
                    <!-- Personal Photo -->
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-20 h-20 rounded-full bg-white border border-slate-200 overflow-hidden shadow-sm">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div
                                    class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 font-black text-xl uppercase">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Personal
                            Photo</span>
                    </div>

                    <div class="h-10 w-px bg-slate-200 hidden md:block"></div>

                    <!-- Store Logo -->
                    <div class="flex flex-col items-center gap-3">
                        <div
                            class="w-20 h-20 rounded-xl bg-[#0A1D37] overflow-hidden shadow-sm flex items-center justify-center">
                            @if($store->logo)
                                <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                            @else
                                <span
                                    class="text-white font-black text-xl uppercase">{{ substr($store->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Store Logo</span>
                    </div>

                    <div class="flex-1">
                        <h3 class="text-xl font-black text-slate-900 mb-1">{{ $store->name }}</h3>
                        <p class="text-[11px] font-bold text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data"
                    class="p-8 space-y-10">
                    @csrf
                    @method('PUT')

                    <!-- SECTION: PERSONAL IDENTITY -->
                    <div>
                        <h4
                            class="text-[11px] font-black text-green-600 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <span class="w-4 h-px bg-green-600/20"></span>
                            Personal Identity
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Personal
                                    Full Name</label>
                                <input type="text" name="user_name" value="{{ auth()->user()->name }}" required
                                    class="w-full px-4 py-3 rounded-md border border-slate-200 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/30">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Update
                                    Profile Picture</label>
                                <input type="file" name="profile_photo"
                                    class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-[10px] file:font-black file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-all cursor-pointer">
                                <p class="text-[9px] text-slate-400 italic">This photo represents you in reviews and
                                    chats.</p>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION: BUSINESS STOREFRONT -->
                    <div>
                        <h4
                            class="text-[11px] font-black text-green-600 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <span class="w-4 h-px bg-green-600/20"></span>
                            Business Storefront
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store
                                    Display Name</label>
                                <input type="text" name="name" value="{{ $store->name }}" required
                                    class="w-full px-4 py-3 rounded-md border border-slate-200 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/30">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">WhatsApp
                                    Business Number</label>
                                <input type="text" name="whatsapp_number" value="{{ $store->whatsapp_number }}" required
                                    class="w-full px-4 py-3 rounded-md border border-slate-200 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/30">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Location
                                    (City)</label>
                                <input type="text" name="location" value="{{ $store->location }}" required
                                    class="w-full px-4 py-3 rounded-md border border-slate-200 focus:border-green-600 focus:ring-0 font-bold text-sm transition-all bg-slate-50/30">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Store
                                    Logo</label>
                                <input type="file" name="logo"
                                    class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-[10px] file:font-black file:bg-green-50 file:text-green-700 hover:file:bg-green-100 transition-all cursor-pointer">
                            </div>
                        </div>

                        <div class="mt-8 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Business
                                Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 rounded-md border border-slate-200 focus:border-green-600 focus:ring-0 font-medium text-sm transition-all bg-slate-50/30"
                                placeholder="Describe what you sell...">{{ $store->description }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-8 border-t border-slate-100">
                        <button type="submit"
                            class="bg-[#16A34A] text-white px-12 py-4 rounded-md font-bold text-xs uppercase tracking-widest hover:bg-green-700 shadow-xl shadow-green-100 transition-all active:scale-[0.98]">
                            Save Unified Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>