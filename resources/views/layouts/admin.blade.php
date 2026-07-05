<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\Models\Setting::get('site_name', 'Izifai') }} Admin - {{ $title ?? 'Dashboard' }}</title>
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            700: '#006d38',
                            800: '#005228',
                            900: '#003317',
                        },
                        gold: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            400: '#00a859',
                            500: '#006d38',
                            600: '#005228',
                        },
                        primary: '#006d38',
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .admin-card { background: white; border-radius: 12px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
        .sidebar-active { background: #f0fdf4; border-left: 4px solid #006d38; }
        .header-gradient { background: linear-gradient(135deg, #005228 0%, #006d38 100%); }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20; }
    </style>
</head>
<body class="bg-[#f4fcf1] antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100 transition-all duration-300 transform lg:relative lg:translate-x-0 flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <!-- Logo Section -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                    <x-application-logo class="w-8 h-8" />
                    <span class="font-extrabold text-sm uppercase tracking-tighter text-slate-800">{{ \App\Models\Setting::get('site_name', 'Izifai') }} <span class="text-[#006d38]">Admin</span></span>
                </a>
            </div>

            <!-- User Profile (Sidebar) -->
            <div class="p-5 flex items-center gap-3 border-b border-slate-100 bg-[#f4fcf1]/50">
                <div class="w-10 h-10 rounded-full border-2 border-[#006d38]/20 p-0.5 shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'Admin') }}&background=006d38&color=fff" 
                         class="w-full h-full rounded-full object-cover">
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-[12px] text-slate-800 truncate">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</h3>
                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-widest truncate">System Manager</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto no-scrollbar">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span>
                    <span class="text-[12px] font-semibold">Overview</span>
                </a>

                <a href="{{ route('admin.stores.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.stores.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">store</span>
                    <span class="text-[12px] font-semibold">Merchant Hub</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Listings</div>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                    <span class="text-[12px] font-semibold">Products</span>
                </a>

                <a href="{{ route('admin.services.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.services.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">handyman</span>
                    <span class="text-[12px] font-semibold">Services</span>
                </a>

                <a href="{{ route('admin.rentals.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.rentals.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">shelves</span>
                    <span class="text-[12px] font-semibold">Rentals</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Commerce</div>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.orders.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                    <span class="text-[12px] font-semibold">Orders</span>
                </a>

                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.bookings.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                    <span class="text-[12px] font-semibold">Bookings</span>
                </a>

                <a href="{{ route('admin.rental-transactions.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.rental-transactions.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">assignment</span>
                    <span class="text-[12px] font-semibold">Rental Txns</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Financial</div>

                <a href="{{ route('admin.financials') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.financials') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">account_balance</span>
                    <span class="text-[12px] font-semibold">Financials</span>
                </a>

                <a href="{{ route('admin.withdrawals.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.withdrawals.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">money_off</span>
                    <span class="text-[12px] font-semibold">Withdrawals</span>
                </a>

                <a href="{{ route('admin.payment-methods.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payment-methods.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">payments</span>
                    <span class="text-[12px] font-semibold">Payment Info</span>
                </a>

                <div class="pt-4 pb-1 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Community</div>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">group</span>
                    <span class="text-[12px] font-semibold">User Base</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reviews.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">reviews</span>
                    <span class="text-[12px] font-semibold">Reviews</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">flag</span>
                    <span class="text-[12px] font-semibold">Reports</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">category</span>
                    <span class="text-[12px] font-semibold">Categories</span>
                </a>

                <a href="{{ route('admin.ads.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.ads.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">ads_click</span>
                    <span class="text-[12px] font-semibold">Ad Requests</span>
                </a>
                
                <div class="pt-5 pb-2 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">System</div>
                
                <a href="{{ route('admin.analytics') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.analytics') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">bar_chart</span>
                    <span class="text-[12px] font-semibold">Analytics</span>
                </a>

                <a href="{{ route('admin.notifications.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.notifications.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">notifications</span>
                    <span class="text-[12px] font-semibold">Notifications</span>
                </a>

                <a href="{{ route('admin.admin-management.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.admin-management.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">manage_accounts</span>
                    <span class="text-[12px] font-semibold">Admin Management</span>
                </a>

                <a href="{{ route('admin.audit-logs.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.audit-logs.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">history</span>
                    <span class="text-[12px] font-semibold">Audit Log</span>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">settings</span>
                    <span class="text-[12px] font-semibold">Settings</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-slate-100">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-red-500 hover:bg-red-50 transition-all font-semibold text-[12px]">
                        <span class="material-symbols-outlined text-[18px]">logout</span>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Navigation Bar -->
            <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 lg:px-8 lg:h-20 shrink-0 shadow-sm">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-lg">
                        <span class="material-symbols-outlined text-[20px]">menu</span>
                    </button>
                    <div class="lg:hidden flex items-center gap-2">
                        <x-application-logo class="w-6 h-6" />
                        <span class="font-extrabold text-xs uppercase tracking-tighter text-slate-800">{{ \App\Models\Setting::get('site_name', 'Izifai') }}</span>
                    </div>
                    <h1 class="hidden lg:block text-xl font-bold text-slate-800 tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                <div class="flex items-center gap-3 md:gap-6" x-data="{ notifOpen: false, unreadCount: 0, notifications: [] }"
                     x-init="fetch('{{ route('admin.notifications.unread-count') }}').then(r=>r.json()).then(d=>unreadCount=d.unread_count)">
                    <div class="relative">
                        <button @click="notifOpen = !notifOpen; if(notifOpen){fetch('{{ route('admin.notifications.unread-count') }}').then(r=>r.json()).then(d=>unreadCount=d.unread_count);fetch('{{ route('admin.notifications.dropdown') }}').then(r=>r.json()).then(d=>notifications=d.notifications)}" class="p-2 text-slate-400 hover:text-slate-700 relative">
                            <span class="material-symbols-outlined text-[20px]">notifications</span>
                            <span x-show="unreadCount > 0" x-text="unreadCount" class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-rose-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center px-1 border-2 border-white"></span>
                        </button>
                        <div x-show="notifOpen" @click.outside="notifOpen = false" x-cloak class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-slate-100 overflow-hidden z-50">
                            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-navy-800">Notifications</span>
                                <button @click="fetch('{{ route('admin.notifications.read-all') }}',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}}).then(r=>r.json()).then(d=>{unreadCount=0;notifications=[]})" class="text-[9px] font-bold text-gold-500 uppercase tracking-widest">Mark All Read</button>
                            </div>
                            <div class="max-h-72 overflow-y-auto">
                                <template x-for="n in notifications" :key="n.id">
                                    <form :action="n.url" method="POST" class="contents">
                                        @csrf
                                        <button type="submit" class="w-full text-left p-3 border-b border-slate-50 hover:bg-slate-50 transition-colors flex items-start gap-3">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                                                 :class="{'bg-amber-50 text-amber-500': n.type === 'withdrawal', 'bg-rose-50 text-rose-500': n.type === 'report', 'bg-blue-50 text-blue-500': n.type === 'system'}">
                                                <span class="material-symbols-outlined text-[16px]" x-text="n.type === 'withdrawal' ? 'account_balance' : (n.type === 'report' ? 'flag' : 'notifications')"></span>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[11px] font-bold text-navy-800 truncate" x-text="n.title"></p>
                                                <p class="text-[9px] text-slate-500 truncate" x-text="n.message"></p>
                                                <p class="text-[8px] text-slate-400 mt-0.5" x-text="n.time"></p>
                                            </div>
                                        </button>
                                    </form>
                                </template>
                                <div x-show="notifications.length === 0" class="p-6 text-center">
                                    <p class="text-[10px] text-slate-400 font-medium">No new notifications</p>
                                </div>
                            </div>
                            <div class="p-2 border-t border-slate-100 text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-[10px] font-bold text-navy-800 hover:text-gold-500 transition-colors">View All Notifications</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.profile') }}" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200 hover:bg-slate-200 transition-colors">
                        <span class="material-symbols-outlined text-[16px] text-slate-400">person</span>
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-3 sm:p-6 lg:p-8 no-scrollbar space-y-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('notifDropdown', () => ({
                open: false,
                unread: 0,
                init() {
                    fetch('/admin/notifications/unread-count').then(r=>r.json()).then(d=>this.unread=d.unread_count);
                }
            }));
        });
    </script>
    @stack('scripts')
</body>
</html>