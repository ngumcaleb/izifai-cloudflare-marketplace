<x-admin-layout>
    <x-slot name="header">E-Commerce Dashboard</x-slot>

    <!-- 1. Header Card -->
    <div class="relative bg-white rounded-xl h-[160px] md:h-[200px] overflow-hidden shadow-sm border border-slate-100 mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-green-50 via-white to-green-50/30"></div>
        <div class="absolute -right-8 -top-8 w-40 h-40 bg-[#006d38]/5 rounded-full"></div>
        <div class="absolute -left-4 -bottom-4 w-32 h-32 bg-[#006d38]/5 rounded-full"></div>
        <div class="relative z-10 h-full p-6 md:p-10 flex flex-col justify-center">
            <div class="inline-flex items-center gap-1.5 text-[#006d38] text-[8px] md:text-[10px] font-bold mb-3 w-fit">
                <span class="material-symbols-outlined text-[14px]">dashboard</span>
                Control Center
            </div>
            <h2 class="text-xl md:text-3xl font-bold text-slate-800 leading-tight mb-2 tracking-tight">
                Welcome back, <br class="md:hidden"> <span class="text-[#006d38]">{{ Auth::guard('admin')->user()->name }}</span>
            </h2>
            <p class="text-[10px] md:text-sm text-slate-500 font-medium max-w-md">
                Monitor performance, manage sellers and keep the marketplace growing.
            </p>
        </div>
    </div>

    @if($pendingWithdrawalsCount > 0)
    <a href="{{ route('admin.withdrawals.index', ['status' => 'pending']) }}"
       class="block bg-rose-50 border-2 border-rose-200 rounded-xl p-4 mb-6 hover:bg-rose-100 transition-colors group">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-rose-100 rounded-xl flex items-center justify-center text-rose-600 shrink-0">
                <i data-lucide="banknote" class="w-5 h-5"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-bold text-rose-700">{{ $pendingWithdrawalsCount }} withdrawal{{ $pendingWithdrawalsCount > 1 ? 's' : '' }} pending approval</p>
                <p class="text-xs text-rose-600/80 font-medium">Total: XAF {{ number_format($pendingWithdrawalsAmount) }} — Click to review</p>
            </div>
            <div class="text-rose-400 group-hover:text-rose-600 transition-colors">
                <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </div>
        </div>
    </a>
    @endif

    <!-- 2. Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Users</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_users']) }}</h3>
            </div>
            <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-500 shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Stores</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_stores']) }}</h3>
                <p class="text-[9px] text-amber-500 font-bold mt-1">{{ $metrics['pending_verifications'] }} pending</p>
            </div>
            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 shrink-0">
                <i data-lucide="store" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Products</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_products']) }}</h3>
                <p class="text-[9px] text-amber-500 font-bold mt-1">{{ $metrics['pending_products'] }} pending</p>
            </div>
            <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500 shrink-0">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Services</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_services']) }}</h3>
                <p class="text-[9px] text-amber-500 font-bold mt-1">{{ $metrics['pending_services'] }} pending</p>
            </div>
            <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center text-purple-500 shrink-0">
                <i data-lucide="handyman" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rentals</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_rentals']) }}</h3>
            </div>
            <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center text-teal-500 shrink-0">
                <i data-lucide="shelves" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Orders</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_orders']) }}</h3>
                <p class="text-[9px] font-bold text-navy-800 mt-1">XAF {{ number_format($metrics['total_revenue']) }}</p>
            </div>
            <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-500 shrink-0">
                <i data-lucide="shopping-cart" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Bookings</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ number_format($metrics['total_bookings']) }}</h3>
            </div>
            <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center text-pink-500 shrink-0">
                <i data-lucide="calendar" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="admin-card p-5 flex items-center justify-between group hover:border-gold-400 transition-all">
            <div class="min-w-0">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Withdrawals</p>
                <h3 class="text-xl font-bold text-navy-800 tracking-tight">{{ $metrics['pending_withdrawals'] }}</h3>
                <p class="text-[9px] text-rose-500 font-bold mt-1">Pending Approval</p>
            </div>
            <div class="w-10 h-10 bg-rose-50 rounded-lg flex items-center justify-center text-rose-500 shrink-0">
                <i data-lucide="banknote" class="w-5 h-5"></i>
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
                        <div class="w-full bg-blue-400/40 rounded-t h-[{{ ($data['orders'] / $maxVal) * 100 }}%]" title="{{ $data['orders'] }} orders"></div>
                    </div>
                    @endforeach
                </div>
                <div class="flex mt-2 gap-3 text-[9px]">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-navy-800/20"></span> Users</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-gold-400"></span> Stores</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded bg-blue-400/40"></span> Orders</span>
                </div>
                <div class="flex justify-between mt-2 px-2 text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                    @foreach($chartData as $data)
                        <span>{{ $data['label'] }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="admin-card overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="text-base font-bold text-navy-800">Recent Orders</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-bold text-gold-500 uppercase">View All</a>
                </div>
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Order</th>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                                <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4 text-xs font-bold text-navy-800">#{{ $order->order_number }}</td>
                                <td class="px-6 py-4 text-[11px] text-slate-600">{{ $order->user->name }}</td>
                                <td class="px-6 py-4 text-xs font-bold text-navy-800">XAF {{ number_format($order->total_amount) }}</td>
                                <td class="px-6 py-4 text-right">
                                    <span class="px-2 py-0.5 text-[8px] font-bold rounded
                                        {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                        {{ $order->status === 'shipped' ? 'bg-blue-50 text-blue-600' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                                        {{ in_array($order->status, ['pending', 'confirmed']) ? 'bg-amber-50 text-amber-600' : '' }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="md:hidden divide-y divide-slate-50">
                    @foreach($recentOrders as $order)
                    <div class="p-4 flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-navy-800">#{{ $order->order_number }}</h4>
                            <p class="text-[10px] text-slate-500">{{ $order->user->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-navy-800">XAF {{ number_format($order->total_amount) }}</p>
                            <span class="px-1.5 py-0.5 text-[7px] font-bold rounded
                                {{ $order->status === 'delivered' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                {{ $order->status === 'shipped' ? 'bg-blue-50 text-blue-600' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                                {{ in_array($order->status, ['pending', 'confirmed']) ? 'bg-amber-50 text-amber-600' : '' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>
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
                                        <x-store-default-logo :store="$store" size="xs" class="rounded-lg" />
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
                            <x-store-default-logo :store="$store" size="sm" class="rounded-lg" />
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
            <div class="admin-card p-6 bg-[#006d38] border-none relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full"></div>
                <div class="relative z-10">
                    <h3 class="text-sm font-bold text-white mb-4">Ad Queue</h3>
                    <div class="space-y-3">
                        @foreach($recentAds as $ad)
                        <div class="p-3 rounded-lg bg-white/5 border border-white/5 flex items-center justify-between">
                            <div class="min-w-0">
                                <h4 class="text-[10px] font-bold text-white truncate">{{ $ad->title }}</h4>
                                <p class="text-[8px] text-slate-400">{{ $ad->store->name }}</p>
                            </div>
                            <span class="text-[8px] font-bold text-gold-400 uppercase">{{ $ad->days }}d</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('admin.ads.index') }}" class="block text-center mt-6 py-3 bg-gold-500 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm">Manage Ads</a>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
