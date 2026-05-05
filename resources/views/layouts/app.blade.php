<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Izifai - Premium Cameroon Marketplace' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
            -webkit-font-smoothing: antialiased;
        }

        [x-cloak] {
            display: none !important;
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .search-input-focus:focus-within {
            box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.1);
            border-color: #16A34A;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Premium Buttons */
        .btn-primary {
            background-color: #16A34A;
            color: white;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary:hover {
            background-color: #15803d;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -5px rgba(22, 163, 74, 0.3);
        }
    </style>
</head>

<body class="antialiased overflow-x-hidden" x-data="{ mobileMenu: false, userDropdown: false, cartOpen: false }">

    <!-- Top Minimal Bar -->
    <div class="hidden lg:block bg-slate-900 text-white/70 py-2.5 text-[11px] font-bold tracking-widest uppercase">
        <div class="max-w-[1440px] mx-auto px-8 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 pr-6 border-r border-white/10">
                    <img src="https://flagcdn.com/w20/cm.png" class="w-4 rounded-sm">
                    <span class="text-white">Shipping to Cameroon</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-green-400 transition-colors">Become a
                        Seller</a>
                    <a href="{{ route('help') }}" class="hover:text-green-400 transition-colors">Support</a>
                </div>
            </div>
            <div class="flex items-center gap-6">
                @auth
                    <span>Welcome, <span class="text-white">{{ auth()->user()->name }}</span></span>
                @else
                    <a href="{{ route('login') }}" class="text-white hover:text-green-400">Track Order</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Modern Main Header -->
    <header class="glass-header sticky top-0 z-[100] border-b border-slate-200/60 transition-all duration-300">
        <div class="max-w-[1440px] mx-auto px-4 lg:px-8 h-20 flex items-center gap-8">

            <!-- Mobile Toggle -->
            <button @click="mobileMenu = true"
                class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <!-- Logo -->
            <a href="/" class="shrink-0 group">
                <x-application-logo class="h-9 lg:h-11 transition-transform duration-300 group-hover:scale-105" />
            </a>

            <!-- Clean Centered Search -->
            <div class="hidden lg:flex flex-1 max-w-2xl relative mx-auto" x-data="searchAutocomplete()">
                <form action="{{ route('search') }}" method="GET"
                    class="w-full flex items-center bg-slate-100/50 border border-slate-200 rounded-2xl px-2 py-1.5 search-input-focus transition-all group">
                    <div class="flex items-center px-4 gap-2 text-slate-400 border-r border-slate-200 mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="q" x-model="query" @input.debounce.300ms="fetchSuggestions"
                        @focus="showSuggestions = true" autocomplete="off"
                        placeholder="Search products, brands and more..."
                        class="flex-1 bg-transparent border-none focus:ring-0 text-sm font-semibold py-2">
                    <button type="submit"
                        class="bg-slate-900 text-white px-6 py-2 rounded-xl font-bold text-xs hover:bg-black transition-all">Search</button>
                </form>

                <!-- Suggestions UI would go here (keeping logic simple for layout) -->
            </div>

            <!-- Action Area -->
            <div class="flex items-center gap-2 lg:gap-5">
                @auth
                    <!-- Desktop User Actions -->
                    <div class="hidden lg:flex items-center gap-2">
                        <a href="{{ route('favorites.index') }}"
                            class="p-2.5 text-slate-600 hover:bg-slate-100 rounded-xl transition-all relative group">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                </path>
                            </svg>
                        </a>

                        <div class="relative" @click.away="userDropdown = false">
                            <button @click="userDropdown = !userDropdown"
                                class="flex items-center gap-3 p-1.5 pr-4 bg-slate-100/50 border border-slate-200 rounded-2xl hover:bg-white transition-all">
                                <div
                                    class="w-8 h-8 rounded-xl bg-green-600 flex items-center justify-center text-white font-bold text-xs">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span
                                    class="text-xs font-bold text-slate-700">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="userDropdown" x-cloak
                                class="absolute right-0 mt-3 w-56 bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-100 py-3 z-[200] overflow-hidden">
                                <div class="px-5 py-2 mb-2">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Account Type
                                    </p>
                                    <p class="text-xs font-bold text-green-600">{{ ucfirst(auth()->user()->role) }}</p>
                                </div>
                                <a href="{{ auth()->user()->role === 'seller' ? route('seller.dashboard') : route('dashboard') }}"
                                    class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 text-sm font-bold text-slate-700 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-3 px-5 py-3 hover:bg-slate-50 text-sm font-bold text-slate-700 transition-colors">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                        </path>
                                    </svg>
                                    Settings
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 mt-2">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-5 py-4 hover:bg-red-50 text-red-600 text-sm font-bold transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="hidden lg:flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-sm font-bold text-slate-600 hover:text-slate-900 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}"
                            class="btn-primary px-7 py-3 rounded-2xl font-bold text-xs uppercase tracking-widest shadow-lg shadow-green-600/20">Join
                            Free</a>
                    </div>
                @endauth

                <!-- Cart Trigger (Unified) -->
                <button @click="cartOpen = true"
                    class="p-3 bg-slate-900 text-white rounded-2xl hover:scale-105 transition-all relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span
                        class="absolute -top-1 -right-1 w-5 h-5 bg-green-500 rounded-full border-2 border-white text-[10px] font-black flex items-center justify-center">0</span>
                </button>
            </div>
        </div>

        <!-- Sub Navigation / Categories (Clean Style) -->
        <div class="hidden lg:block border-t border-slate-200/60 bg-white/50">
            <div class="max-w-[1440px] mx-auto px-8 py-3 flex items-center justify-between">
                <div class="flex items-center gap-10">
                    <button
                        class="flex items-center gap-3 text-sm font-bold text-slate-900 hover:text-green-600 transition-colors group">
                        <div class="flex flex-col gap-1 w-4">
                            <span
                                class="h-0.5 w-full bg-slate-900 rounded-full group-hover:bg-green-600 transition-colors"></span>
                            <span
                                class="h-0.5 w-full bg-slate-900 rounded-full group-hover:bg-green-600 transition-colors"></span>
                        </div>
                        Browse Categories
                    </button>
                    <nav class="flex items-center gap-8 text-[13px] font-semibold text-slate-500">
                        <a href="{{ route('products.index') }}" class="hover:text-green-600 transition-colors">New
                            Arrivals</a>
                        <a href="{{ route('products.index', ['sort' => 'popular']) }}"
                            class="hover:text-green-600 transition-colors">Most Popular</a>
                        <a href="{{ route('stores.index') }}" class="hover:text-green-600 transition-colors">Local
                            Shops</a>
                        <a href="#" class="hover:text-green-600 transition-colors">Deal of the Day</a>
                    </nav>
                </div>
                <div class="flex items-center gap-4 text-[13px] font-bold text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Exclusive Flash Sale
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="relative z-10">
        {{ $slot }}
    </main>

    <!-- Footer Overhaul -->
    <footer class="bg-white border-t border-slate-200 pt-20 pb-10 mt-20">
        <div class="max-w-[1440px] mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 pb-16">
                <div class="space-y-6">
                    <x-application-logo class="h-10" />
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Cameroon's premier marketplace for quality products and verified local businesses. Bridging the
                        gap between shop and home.
                    </p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-green-600 hover:text-white transition-all"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg></a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-green-600 hover:text-white transition-all"><svg
                                class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-slate-900 font-bold text-sm mb-6 uppercase tracking-widest">Shop</h4>
                    <ul class="space-y-4 text-slate-500 text-sm font-medium">
                        <li><a href="#" class="hover:text-green-600 transition-colors">Categories</a></li>
                        <li><a href="#" class="hover:text-green-600 transition-colors">Stores</a></li>
                        <li><a href="#" class="hover:text-green-600 transition-colors">Offers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 font-bold text-sm mb-6 uppercase tracking-widest">Sell</h4>
                    <ul class="space-y-4 text-slate-500 text-sm font-medium">
                        <li><a href="#" class="hover:text-green-600 transition-colors">Become a Partner</a></li>
                        <li><a href="#" class="hover:text-green-600 transition-colors">Seller Dashboard</a></li>
                        <li><a href="#" class="hover:text-green-600 transition-colors">Shipping Info</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-slate-900 font-bold text-sm mb-6 uppercase tracking-widest">Newsletter</h4>
                    <p class="text-slate-500 text-xs mb-6 leading-relaxed">Subscribe to get special offers, free
                        giveaways, and once-in-a-lifetime deals.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Your email"
                            class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-semibold focus:border-green-600 focus:ring-0 outline-none">
                        <button
                            class="bg-slate-900 text-white px-5 py-2.5 rounded-xl font-bold text-xs hover:bg-black transition-all">Go</button>
                    </form>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-400 text-xs font-medium">© {{ date('Y') }} Izifai Marketplace. All rights reserved.
                </p>
                <div class="flex gap-6 text-slate-400 text-xs font-medium">
                    <a href="#" class="hover:text-slate-600">Privacy Policy</a>
                    <a href="#" class="hover:text-slate-600">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Navigation Overlay (Clean) -->
    <div x-show="mobileMenu" x-cloak class="fixed inset-0 z-[300]">
        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="mobileMenu = false"></div>
        <div class="absolute inset-y-0 left-0 w-80 bg-white shadow-2xl flex flex-col"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0">

            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <x-application-logo class="h-8" />
                <button @click="mobileMenu = false" class="p-2 text-slate-400"><svg class="w-6 h-6" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg></button>
            </div>

            <div class="flex-1 overflow-y-auto py-6">
                <div class="px-6 space-y-6">
                    <nav class="space-y-4">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Main Menu</p>
                        <a href="/"
                            class="flex items-center gap-4 text-slate-900 font-bold hover:text-green-600 transition-colors"><svg
                                class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg> Home</a>
                        <a href="{{ route('products.index') }}"
                            class="flex items-center gap-4 text-slate-900 font-bold hover:text-green-600 transition-colors"><svg
                                class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg> Shop All</a>
                        <a href="{{ route('stores.index') }}"
                            class="flex items-center gap-4 text-slate-900 font-bold hover:text-green-600 transition-colors"><svg
                                class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg> Sellers</a>
                    </nav>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 bg-slate-50">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="btn-primary w-full py-4 rounded-2xl font-bold flex items-center justify-center gap-2">My
                        Dashboard</a>
                @else
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('login') }}"
                            class="w-full py-4 text-center text-slate-900 font-bold bg-white border border-slate-200 rounded-2xl">Sign
                            In</a>
                        <a href="{{ route('register') }}"
                            class="btn-primary w-full py-4 text-center rounded-2xl font-bold">Join Now</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

</body>

</html>