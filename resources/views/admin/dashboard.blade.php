<x-app-layout>
    <x-slot name="sidebar">
        <!-- Admin Sidebar -->
        <aside class="w-[240px] bg-[#0A1D37] text-white flex flex-col min-h-screen sticky top-0">
            <div class="p-6 h-20 flex items-center gap-3 border-b border-white/10 shrink-0">
                <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center font-black text-sm">A</div>
                <span class="font-black text-xs uppercase tracking-widest">Admin Panel</span>
            </div>
            
            <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-lg bg-red-500 text-white font-bold text-[11px] transition-all">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span>Overview</span>
                </a>
            </nav>

            <div class="p-4 border-t border-white/10">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-white/5 text-slate-400 hover:text-red-400 font-bold text-[11px] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout Admin</span>
                    </button>
                </form>
            </div>
        </aside>
    </x-slot>

    <div class="p-6 md:p-8 bg-slate-50 min-h-screen">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-black text-slate-900 mb-1 tracking-tight">System Overview</h1>
                <p class="text-[11px] text-slate-500 font-medium uppercase tracking-widest">Welcome back, {{ Auth::guard('admin')->user()->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm relative overflow-hidden group hover:border-red-500 transition-colors">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-red-100 rounded-bl-[100px] -z-0"></div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 relative z-10">Total Users</h3>
                <p class="text-3xl font-black text-slate-900 relative z-10">1,240</p>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm relative overflow-hidden group hover:border-red-500 transition-colors">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-red-100 rounded-bl-[100px] -z-0"></div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 relative z-10">Active Stores</h3>
                <p class="text-3xl font-black text-slate-900 relative z-10">86</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm relative overflow-hidden group hover:border-red-500 transition-colors">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-red-100 rounded-bl-[100px] -z-0"></div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 relative z-10">Total Products</h3>
                <p class="text-3xl font-black text-slate-900 relative z-10">4,521</p>
            </div>

            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm relative overflow-hidden group hover:border-red-500 transition-colors">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-red-50 to-red-100 rounded-bl-[100px] -z-0"></div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 relative z-10">System Status</h3>
                <p class="text-xl font-black text-green-500 relative z-10 pt-1">Operational</p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex flex-col items-center justify-center min-h-[300px] opacity-50">
            <svg class="w-16 h-16 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            <p class="font-black text-slate-400 uppercase tracking-widest text-[11px] text-center max-w-sm">Admin tools and data tables will be implemented here in subsequent updates.</p>
        </div>
    </div>
</x-app-layout>
