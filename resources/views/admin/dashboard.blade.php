<x-admin-layout>
    <x-slot name="header">E-Commerce Dashboard</x-slot>

    <!-- 1. Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[160px] md:h-[220px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/diverse-businesspeople-working-together_23-2148908922.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/40 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-10 flex flex-col justify-center">
            <div class="inline-block bg-gold-500 text-navy-900 text-[8px] md:text-[10px] font-bold px-3 py-1 rounded transform -skew-x-12 uppercase tracking-widest mb-3 w-fit">
                Control Center
            </div>
            <h2 class="text-xl md:text-3xl font-bold text-white leading-tight mb-2 tracking-tight">
                Welcome back, <br class="md:hidden"> <span class="text-gold-400">{{ Auth::guard('admin')->user()->name }}</span>
            </h2>
            <p class="text-[10px] md:text-sm text-slate-300 font-medium max-w-md">
                Monitor performance, manage sellers and keep the marketplace growing.
            </p>
        </div>
    </div>

    <!-- 2. Stats Grid -->
    <div class="flex overflow-x-auto no-scrollbar gap-4 pb-2 -mx-1 sm:mx-0 lg:grid lg:grid-cols-4 lg:pb-0 mb-6">
        <!-- Total Products -->
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Products</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_products']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+15% <span class="text-slate-400">new this wk</span></p>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 shrink-0">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Active Sellers -->
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Merchants</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_stores']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+7% <span class="text-slate-400">conversion</span></p>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 shrink-0">
                <i data-lucide="store" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Customers</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_users']) }}</h3>
                <p class="text-[9px] text-emerald-500 font-bold mt-1">+5% <span class="text-slate-400">active now</span></p>
            </div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>

        <!-- Pending Ads -->
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all shrink-0 w-[240px] sm:w-auto">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ad Requests</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ $metrics['pending_ads'] }}</h3>
                <p class="text-[9px] text-rose-500 font-bold mt-1">Action Required</p>
            </div>
            <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center text-rose-500 shrink-0">
                <i data-lucide="megaphone" class="w-5 h-5"></i>
            </div>
        </div>
    </div>

    <!-- 3. Main Data Area -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart Section -->
        <div class="lg:col-span-2 space-y-6">
            <div class="admin-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-base font-bold text-navy-800">Growth Analytics</h3>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">User & Store Activity</p>
                    </div>
                    <select class="bg-slate-50 border-none rounded-lg text-[10px] font-bold px-3 py-1.5 focus:ring-0">
                        <option>Last 6 Months</option>
                    </select>
                </div>
                
                <div class="h-48 md:h-64 flex items-end gap-1.5 md:gap-3 px-2">
                    @php
                        $maxVal = collect($chartData)->max(function($item) {
                            return max($item['users'], $item['stores']);
                        });
                        $maxVal = $maxVal > 0 ? $maxVal : 1;
                    @endphp
                    @foreach($chartData as $data)
                    <div class="flex-1 flex flex-col justify-end gap-1 h-full">
                        <div class="w-full bg-navy-800/20 rounded-t h-[{{ ($data['users'] / $maxVal) * 100 }}%]" title="{{ $data['users'] }} users"></div>
                        <div class="w-full bg-gold-400 rounded-t h-[{{ ($data['stores'] / $maxVal) * 100 }}%]" title="{{ $data['stores'] }} stores"></div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-4 px-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                    @foreach($chartData as $data)
                        <span>{{ $data['label'] }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Recent Store Requests -->
            <div class="admin-card overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-navy-800">New Store Requests</h3>
                    <a href="{{ route('admin.stores.index') }}" class="text-[10px] font-bold text-gold-500 uppercase">View Hub</a>
                </div>
                
                <!-- Table for Desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Business</th>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Owner</th>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentStores as $store)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-navy-800 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                            {{ substr($store->name, 0, 1) }}
                                        </div>
                                        <span class="text-xs font-bold text-navy-800 truncate">{{ $store->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-[11px] font-medium text-slate-600">{{ $store->user->name }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-2 py-0.5 {{ $store->is_verified ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[9px] font-bold rounded">
                                        {{ $store->is_verified ? 'Active' : 'Pending' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Cards for Mobile -->
                <div class="md:hidden divide-y divide-slate-50">
                    @foreach($recentStores as $store)
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-navy-800 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                {{ substr($store->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-navy-800">{{ $store->name }}</h4>
                                <p class="text-[10px] text-slate-500">{{ $store->user->name }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 {{ $store->is_verified ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600' }} text-[8px] font-bold rounded uppercase tracking-wider">
                            {{ $store->is_verified ? 'Active' : 'Pending' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="space-y-6">
            <div class="admin-card p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold text-navy-800">Popular Listings</h3>
                    <i data-lucide="trending-up" class="w-4 h-4 text-gold-400"></i>
                </div>
                <div class="space-y-5">
                    @foreach($recentProducts->take(5) as $product)
                    <a href="{{ route('admin.products.index', ['search' => $product->name]) }}" class="flex items-center gap-3 group hover:bg-slate-50 -mx-2 px-2 py-1 rounded-xl transition-all">
                        <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-50 group-hover:border-gold-400/30 transition-colors">
                            @if($product->mainImage)
<img src="{{ $product->mainImage->url }}" class="w-full h-full object-cover">
                             @elseif($product->images->first())
                                 <img src="{{ $product->images->first()->url }}" class="w-full h-full object-cover">
                             @else
                                 <div class="w-full h-full flex items-center justify-center text-slate-300">
                                     <i data-lucide="image" class="w-5 h-5"></i>
                                 </div>
                             @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-[11px] font-bold text-navy-800 truncate group-hover:text-gold-500 transition-colors">{{ $product->name }}</h4>
                            <p class="text-[9px] text-slate-400 mt-0.5">{{ number_format($product->views) }} views</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-navy-800">XAF {{ number_format($product->price) }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
                <a href="{{ route('admin.products.index') }}" class="block text-center w-full mt-6 py-3 bg-slate-50 text-navy-800 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-navy-800 hover:text-white transition-all">Full Inventory</a>
            </div>

            <!-- Ad Requests Quick View -->
            <div class="admin-card p-6 bg-navy-900 border-none relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gold-400/10 rounded-full"></div>
                <div class="relative z-10">
                    <h3 class="text-sm font-bold text-white mb-4">Ad Queue</h3>
                    <div class="space-y-3">
                        @foreach($recentAds as $ad)
                        <div class="p-3 rounded-lg bg-white/5 border border-white/5 flex items-center justify-between">
                            <div class="min-w-0">
                                <h4 class="text-[10px] font-bold text-white truncate">{{ $ad->product->name }}</h4>
                                <p class="text-[8px] text-slate-400">{{ $ad->store->name }}</p>
                            </div>
                            <span class="text-[8px] font-bold text-gold-400 uppercase">{{ $ad->duration_days }}d</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('admin.ads.index') }}" class="block text-center mt-6 py-3 bg-gold-500 text-navy-900 rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">Manage Ads</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
