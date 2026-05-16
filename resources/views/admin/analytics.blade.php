<x-admin-layout>
    <x-slot name="header">Marketplace Analytics</x-slot>

    <!-- 1. Hero Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[160px] md:h-[200px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/diverse-businesspeople-working-together_23-2148908922.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/60 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-10 flex flex-col justify-center">
            <div class="inline-block bg-gold-500 text-white text-[8px] md:text-[10px] font-bold px-3 py-1 rounded transform -skew-x-12 uppercase tracking-widest mb-3 w-fit">
                Deep Insights
            </div>
            <h2 class="text-xl md:text-3xl font-bold text-white leading-tight mb-2 tracking-tight">
                Platform <span class="text-gold-400">Performance</span>
            </h2>
            <p class="text-[10px] md:text-sm text-slate-300 font-medium max-w-md">
                Detailed metrics on growth, user engagement and merchant activity.
            </p>
        </div>
    </div>

    <!-- 2. Metrics Grid (Matching Dashboard Design) -->
    <div class="flex overflow-x-auto no-scrollbar gap-4 pb-2 -mx-1 sm:mx-0 lg:grid lg:grid-cols-4 lg:pb-0 mb-6">
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Users</p>
                <h3 class="text-xl font-extrabold text-navy-800 tracking-tight">{{ number_format($metrics['total_users']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+12% <span class="text-slate-400">vs last month</span></p>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Live Stores</p>
                <h3 class="text-xl font-extrabold text-navy-800 tracking-tight">{{ number_format($metrics['total_stores']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+5% <span class="text-slate-400">growth rate</span></p>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 shrink-0">
                <i data-lucide="store" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Listings</p>
                <h3 class="text-xl font-extrabold text-navy-800 tracking-tight">{{ number_format($metrics['total_products']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+8% <span class="text-slate-400">inventory boost</span></p>
            </div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 shrink-0">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
        </div>

        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Active Ads</p>
                <h3 class="text-xl font-extrabold text-navy-800 tracking-tight">{{ number_format($metrics['active_ads']) }}</h3>
                <p class="text-[9px] text-rose-500 font-bold mt-1">Live <span class="text-slate-400">promotions</span></p>
            </div>
            <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center text-rose-500 shrink-0">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 3. Growth Visualization -->
    <div class="admin-card p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
            <div>
                <h3 class="text-lg font-bold text-navy-800 uppercase tracking-tight">Growth Velocity</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Platform scaling over the last 12 months</p>
            </div>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-navy-800 rounded-sm"></span>
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">User Base</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 bg-gold-400 rounded-sm"></span>
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Merchant Growth</span>
                </div>
            </div>
        </div>

        <div class="h-[200px] md:h-[280px] flex items-end gap-1.5 md:gap-3 px-1 border-b border-slate-100 mb-4">
            @php
                $maxVal = collect($growth)->max(function($item) {
                    return max($item['users'], $item['stores']);
                });
                $maxVal = $maxVal > 0 ? $maxVal : 1;
            @endphp
            @foreach($growth as $data)
                <div class="flex-1 flex flex-col justify-end gap-1 group relative">
                    <!-- Tooltip -->
                    <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none">
                        <div class="bg-navy-900 text-white text-[8px] font-bold py-1.5 px-2.5 rounded shadow-xl whitespace-nowrap">
                            {{ $data['month'] }}: U{{ $data['users'] }} / S{{ $data['stores'] }}
                        </div>
                    </div>
                    
                    <div class="w-full bg-navy-800/10 rounded-t-md group-hover:bg-navy-800/30 transition-all duration-300" 
                         style="height: {{ ($data['users'] / $maxVal) * 100 }}%"></div>
                    <div class="w-full bg-gold-400/80 rounded-t-md group-hover:bg-gold-500 transition-all duration-300" 
                         style="height: {{ ($data['stores'] / $maxVal) * 100 }}%"></div>
                </div>
            @endforeach
        </div>
        <div class="flex justify-between px-1">
            @foreach($growth as $data)
                <span class="text-[8px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest transform -rotate-45 md:rotate-0 origin-top-left md:origin-center">{{ $data['month'] }}</span>
            @endforeach
        </div>
    </div>
</x-admin-layout>
