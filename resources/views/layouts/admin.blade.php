<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ \App\Models\Setting::get('site_name', 'Izifai') }} Admin - {{ $title ?? 'Dashboard' }}</title>
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            700: '#2D3A54',
                            800: '#1A233A',
                            900: '#0F172A',
                        },
                        gold: {
                            400: '#FBBF24',
                            500: '#F59E0B',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .admin-card { background: white; border-radius: 12px; border: 1px solid #f1f5f9; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); }
        .sidebar-active { background: #2D3A54; border-left: 4px solid #FBBF24; }
        .header-gradient { background: linear-gradient(135deg, #1A233A 0%, #2D3A54 100%); }
    </style>
</head>
<body class="bg-[#F8FAFC] antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-navy-900/60 backdrop-blur-sm lg:hidden transition-opacity duration-300"></div>

        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-navy-800 text-white transition-all duration-300 transform lg:relative lg:translate-x-0 flex flex-col"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <!-- Logo Section -->
            <div class="h-20 flex items-center px-6 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                    <x-application-logo class="w-8 h-8 fill-gold-400" />
                    <span class="font-black text-sm uppercase tracking-tighter text-white">{{ \App\Models\Setting::get('site_name', 'Izifai') }} <span class="text-gold-400">Admin</span></span>
                </a>
            </div>


            <!-- User Profile (Sidebar) -->
            <div class="p-6 flex items-center gap-3 border-b border-white/5 bg-navy-900/20">
                <div class="w-10 h-10 rounded-full border border-gold-400/30 p-0.5 shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->name ?? 'Admin') }}&background=FBBF24&color=1A233A" 
                         class="w-full h-full rounded-full object-cover">
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-[12px] text-white truncate">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</h3>
                    <p class="text-[9px] text-slate-400 font-medium uppercase tracking-widest truncate">System Manager</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto no-scrollbar">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Overview</span>
                </a>

                <a href="{{ route('admin.stores.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.stores.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="store" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Merchant Hub</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.products.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="package" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Inventory</span>
                </a>

                <a href="{{ route('admin.ads.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.ads.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="megaphone" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Promotions</span>
                </a>

                <a href="{{ route('admin.payment-methods.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.payment-methods.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="wallet" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Payment Info</span>
                </a>

                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="users" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">User Base</span>
                </a>

                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.reports.*') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="flag" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Reports</span>
                </a>
                
                <div class="pt-4 pb-2 px-4 text-[9px] font-black text-slate-500 uppercase tracking-widest">System</div>
                
                <a href="{{ route('admin.analytics') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.analytics') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Analytics</span>
                </a>

                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('admin.settings') ? 'sidebar-active text-white shadow-lg shadow-black/10' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="settings" class="w-4 h-4"></i>
                    <span class="text-[12px] font-semibold">Settings</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-white/5">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 w-full px-4 py-2.5 rounded-xl text-gold-400 hover:bg-gold-400/10 transition-all font-bold text-[12px]">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Mobile Navigation Bar -->
            <header class="h-16 bg-white border-b border-slate-100 flex items-center justify-between px-4 lg:px-8 lg:h-20 shrink-0">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-50 rounded-lg">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div class="lg:hidden flex items-center gap-2">
                        <x-application-logo class="w-6 h-6 fill-navy-800" />
                        <span class="font-black text-xs uppercase tracking-tighter text-navy-800">{{ \App\Models\Setting::get('site_name', 'Izifai') }}</span>
                    </div>
                    <h1 class="hidden lg:block text-xl font-bold text-navy-800 tracking-tight">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                <div class="flex items-center gap-3 md:gap-6">
                    <button class="p-2 text-slate-400 hover:text-navy-800 relative">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center border border-slate-200">
                        <i data-lucide="user" class="w-4 h-4 text-slate-400"></i>
                    </div>
                </div>
            </header>

            <!-- Page Content (Mobile Responsive Padding) -->
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
