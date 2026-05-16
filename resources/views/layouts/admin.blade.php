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

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                    <span class="text-[12px] font-semibold">Inventory</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">category</span>
                    <span class="text-[12px] font-semibold">Categories</span>
                </a>

                <a href="{{ route('admin.ads.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.ads.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">campaign</span>
                    <span class="text-[12px] font-semibold">Promotions</span>
                </a>

                <a href="{{ route('admin.payment-methods.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payment-methods.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">payments</span>
                    <span class="text-[12px] font-semibold">Payment Info</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">group</span>
                    <span class="text-[12px] font-semibold">User Base</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">flag</span>
                    <span class="text-[12px] font-semibold">Reports</span>
                </a>
                
                <div class="pt-5 pb-2 px-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">System</div>
                
                <a href="{{ route('admin.analytics') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.analytics') ? 'sidebar-active text-[#006d38] font-bold' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50' }}">
                    <span class="material-symbols-outlined text-[18px]">bar_chart</span>
                    <span class="text-[12px] font-semibold">Analytics</span>
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

                <div class="flex items-center gap-3 md:gap-6">
                    <button class="p-2 text-slate-400 hover:text-slate-700 relative">
                        <span class="material-symbols-outlined text-[20px]">notifications</span>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                        <span class="material-symbols-outlined text-[16px] text-slate-400">person</span>
                    </div>
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
    </script>
    @stack('scripts')
</body>
</html>