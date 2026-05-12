<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Izifai — Simplify Your Shopping')</title>
    <meta name="description" content="@yield('description', 'Izifai - Cameroon\'s premier B2B and B2C marketplace connecting verified sellers with buyers.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Outfit', sans-serif; background-color: #f8fafc; color: #0f172a; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
    @stack('styles')
</head>
<body class="antialiased min-h-screen flex flex-col" x-data="{ mobileMenu: false, searchOpen: false }">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-emerald-900 via-emerald-700 to-emerald-800 text-white text-center py-2 px-4">
        <p class="text-[10px] md:text-xs font-semibold tracking-wider">
            <i class="fa-solid fa-store text-emerald-300 mr-1.5"></i>
            Cameroon's Premier Marketplace — Connect with Verified Sellers
            <a href="{{ route('register') }}" class="underline underline-offset-2 font-bold ml-1 hover:text-emerald-200">Join Free</a>
        </p>
    </div>

    <!-- Header -->
    <header class="bg-white border-b border-slate-200/80 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between h-16 md:h-20 gap-4">

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden p-2 -ml-2 text-slate-600 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-all">
                    <svg x-show="!mobileMenu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileMenu" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center shrink-0">
                    <x-application-logo class="h-8 md:h-9" />
                </a>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-lg mx-4">
                    <form action="{{ route('products.search') }}" method="GET" class="w-full">
                        <div class="relative flex items-center">
                            <select name="category" class="absolute left-0 h-full w-auto pl-4 pr-8 bg-transparent border-r border-slate-200 text-xs font-semibold text-slate-500 appearance-none cursor-pointer hover:text-emerald-600 focus:outline-none rounded-l-full">
                                <option value="">All</option>
                                @php $categories = \App\Models\Category::all(); @endphp
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="q" value="{{ request('q') }}"
                                   placeholder="Search products, sellers, categories..."
                                   class="w-full h-11 pl-20 pr-12 bg-slate-50 border border-slate-200 rounded-full text-sm focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100 transition-all">
                            <button type="submit" class="absolute right-1.5 top-1/2 -translate-y-1/2 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center hover:bg-emerald-700 transition-colors">
                                <i class="fa-solid fa-magnifying-glass text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Nav -->
                <div class="flex items-center gap-1 md:gap-3">
                    <button @click="searchOpen = !searchOpen" class="md:hidden p-2 text-slate-600 hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-all">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                    <a href="{{ route('stores.index') }}" class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-full transition-all">
                        <i class="fa-solid fa-store text-xs"></i>
                        Stores
                    </a>
                    <a href="{{ route('products.search') }}" class="hidden md:inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-full transition-all">
                        <i class="fa-solid fa-box text-xs"></i>
                        Products
                    </a>
                    @auth
                        @if(auth()->user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}"
                               class="flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white rounded-full text-xs font-bold hover:bg-emerald-700 transition-all shadow-sm">
                                <i class="fa-solid fa-grip text-xs"></i>
                                <span class="hidden sm:inline">Seller Panel</span>
                            </a>
                        @else
                            <a href="{{ route('register') }}?role=seller"
                               class="flex items-center gap-1.5 px-4 py-2 bg-emerald-600 text-white rounded-full text-xs font-bold hover:bg-emerald-700 transition-all shadow-sm">
                                <i class="fa-solid fa-store text-xs"></i>
                                <span class="hidden sm:inline">Start Selling</span>
                            </a>
                        @endif
                    @else
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-full transition-all">Log In</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-emerald-600 text-white rounded-full text-xs font-bold hover:bg-emerald-700 transition-all shadow-sm">Get Started</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Search (collapsible) -->
        <div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden border-t border-slate-100 px-4 py-3 bg-white">
            <form action="{{ route('products.search') }}" method="GET">
                <div class="flex gap-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..."
                           class="flex-1 h-10 px-4 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-400">
                    <button type="submit" class="px-4 h-10 bg-emerald-600 text-white rounded-xl text-xs font-bold hover:bg-emerald-700 transition-colors">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="lg:hidden border-t border-slate-100 bg-white">
            <div class="px-4 py-4 space-y-1">
                <a href="{{ route('stores.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl transition-all">
                    <i class="fa-solid fa-store w-5 text-center text-slate-400"></i>
                    Browse Stores
                </a>
                <a href="{{ route('products.search') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700 rounded-xl transition-all">
                    <i class="fa-solid fa-box w-5 text-center text-slate-400"></i>
                    Browse Products
                </a>
                <div class="border-t border-slate-100 my-2"></div>
                @auth
                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-emerald-700 bg-emerald-50 rounded-xl">
                            <i class="fa-solid fa-grip w-5 text-center"></i>
                            Seller Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-slate-700 hover:bg-emerald-50 rounded-xl transition-all">
                        <i class="fa-solid fa-arrow-right-to-bracket w-5 text-center text-slate-400"></i>
                        Log In
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold bg-emerald-600 text-white rounded-xl">
                        <i class="fa-solid fa-user-plus w-5 text-center"></i>
                        Get Started
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-12 md:py-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
                <!-- Brand -->
                <div class="col-span-2 md:col-span-1">
                    <x-application-logo class="h-7" />
                    <p class="text-xs text-slate-500 mt-4 leading-relaxed max-w-xs">
                        Cameroon's premier B2B and B2C marketplace. Connecting verified sellers with buyers across the nation.
                    </p>
                    <div class="flex items-center gap-3 mt-5">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-700 hover:text-white transition-all"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-700 hover:text-white transition-all"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-700 hover:text-white transition-all"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:bg-emerald-700 hover:text-white transition-all"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
                    </div>
                </div>
                <!-- For Buyers -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">For Buyers</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('products.search') }}" class="text-xs hover:text-emerald-400 transition-colors">Browse Products</a></li>
                        <li><a href="{{ route('stores.index') }}" class="text-xs hover:text-emerald-400 transition-colors">Find Stores</a></li>
                        <li><a href="{{ route('register') }}" class="text-xs hover:text-emerald-400 transition-colors">Create Account</a></li>
                    </ul>
                </div>
                <!-- For Sellers -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">For Sellers</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('register') }}?role=seller" class="text-xs hover:text-emerald-400 transition-colors">Start Selling</a></li>
                        <li><a href="{{ route('login') }}" class="text-xs hover:text-emerald-400 transition-colors">Seller Login</a></li>
                        <li><a href="#" class="text-xs hover:text-emerald-400 transition-colors">Pricing</a></li>
                    </ul>
                </div>
                <!-- Company -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-widest mb-4">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-xs hover:text-emerald-400 transition-colors">About</a></li>
                        <li><a href="#" class="text-xs hover:text-emerald-400 transition-colors">Contact</a></li>
                        <li><a href="#" class="text-xs hover:text-emerald-400 transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-xs hover:text-emerald-400 transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 mt-10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-[10px] font-semibold text-slate-600 uppercase tracking-widest">
                    &copy; {{ date('Y') }} Izifai. All rights reserved.
                </p>
                <p class="text-[10px] text-slate-700">
                    <i class="fa-solid fa-location-dot mr-1"></i> Cameroon
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
    </script>
    @stack('scripts')
</body>
</html>