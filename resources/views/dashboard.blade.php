<x-app-layout>
    <div class="bg-slate-50 min-h-screen flex" x-data="{ sidebarOpen: false }">
        <!-- Dashboard Sidebar - Creative Clean -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-[#0A1D37] text-white transition-transform duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shrink-0"
        >
            <div class="p-6 h-16 flex items-center gap-3 border-b border-white/5">
                <div class="w-7 h-7 bg-green-600 rounded flex items-center justify-center font-black text-xs">U</div>
                <span class="font-black text-[9px] uppercase tracking-[0.2em]">User Account</span>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-white/10 text-white font-bold text-[10px] transition-all border border-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Overview</span>
                </a>
                <a href="{{ route('favorites.index') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white font-bold text-[10px] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <span>Saved Sourcing</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-slate-400 hover:bg-white/5 hover:text-white font-bold text-[10px] transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <span>Settings</span>
                </a>
            </nav>

            <div class="absolute bottom-0 left-0 right-0 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500/20 text-red-500 py-3 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-slate-100 h-14 flex items-center justify-between px-4 sticky top-0 z-40 shrink-0">
                <button @click="sidebarOpen = true" class="p-2 text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
                <span class="font-black text-[9px] text-slate-900 uppercase tracking-widest">Account</span>
                <div class="w-7 h-7 rounded-full bg-slate-100"></div>
            </header>

            <div class="flex-1 overflow-y-auto p-4 lg:p-8">
                <div class="max-w-6xl mx-auto space-y-4">
                    <!-- Bento Hero Header - Matching Welcome Page -->
                    <div class="relative bg-[#0A1D37] rounded-xl overflow-hidden shadow-lg group h-[160px] lg:h-[220px]">
                        <img src="https://img.freepik.com/free-photo/diverse-businesspeople-working-together_23-2148908922.jpg" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0A1D37] via-[#0A1D37]/80 to-transparent"></div>
                        <div class="relative z-10 h-full p-6 lg:p-10 flex flex-col justify-center">
                            <div class="inline-block bg-green-600 text-white text-[7px] lg:text-[8px] font-bold px-2 py-0.5 rounded transform -skew-x-12 uppercase tracking-widest mb-2 w-fit shadow-md">
                                Official Profile
                            </div>
                            <h1 class="text-xl lg:text-3xl font-black text-white tracking-tight mb-1 leading-none">
                                Hello, {{ auth()->user()->name }}
                            </h1>
                            <p class="text-[9px] lg:text-[11px] text-slate-300 font-medium leading-relaxed max-w-sm">
                                Manage your sourcing preferences and track your saved items across Cameroon.
                            </p>
                        </div>
                    </div>

                    <!-- Stats Bento Row -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[120px]">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Saved Items</p>
                            <p class="text-2xl font-black text-slate-900">12</p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[120px]">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Inquiries</p>
                            <p class="text-2xl font-black text-green-600">03</p>
                        </div>
                        <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex flex-col justify-between h-[120px]">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Account</p>
                            <span class="bg-green-100 text-green-700 text-[8px] font-black px-2 py-1 rounded-full uppercase tracking-widest w-fit">Verified</span>
                        </div>
                        @if(auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="bg-[#0A1D37] p-5 rounded-xl shadow-lg flex flex-col justify-between h-[120px] group transition-all">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Manage Business</p>
                            <p class="text-xs font-bold text-white group-hover:translate-x-1 transition-transform">Seller Center &rarr;</p>
                        </a>
                        @endif
                    </div>

                    <!-- Recent Activity Section -->
                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-6 pb-2 border-b border-slate-50">
                            <h3 class="text-[9px] font-black text-slate-900 uppercase tracking-widest">Activity Summary</h3>
                            <a href="{{ route('favorites.index') }}" class="text-[8px] font-bold text-slate-400 hover:text-green-600 uppercase tracking-widest">View All</a>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-center gap-6 py-4">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center shrink-0 border border-slate-100">
                                <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="text-center md:text-left">
                                <h4 class="text-[11px] font-bold text-slate-900 mb-1">Your account is fully active</h4>
                                <p class="text-[10px] text-slate-500 font-medium">You can now save products, message verified wholesalers, and manage your business profile directly from this dashboard.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Backdrop -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/60 z-40 lg:hidden backdrop-blur-sm"></div>
    </div>
</x-app-layout>
