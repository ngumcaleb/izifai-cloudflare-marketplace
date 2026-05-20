<!DOCTYPE html>
<html class="light overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#006d38">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.svg') }}">
    <title>@yield('title', 'Izifai — Your Store in a Link')</title>
    <meta name="description" content="@yield('description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <meta property="og:title" content="@yield('og_title', 'Izifai — Your Store in a Link')">
    <meta property="og:description" content="@yield('og_description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Izifai">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Izifai — Your Store in a Link')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/logo.png'))">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-highest": "#dde5db",
                        "primary-fixed-dim": "#59df89",
                        "outline-variant": "#bccabc",
                        "on-tertiary-container": "#212e26",
                        "on-secondary-container": "#5e6473",
                        "inverse-primary": "#59df89",
                        "on-primary": "#ffffff",
                        "on-error-container": "#93000a",
                        "outline": "#6d7b6e",
                        "on-tertiary-fixed-variant": "#3c4a41",
                        "tertiary-fixed-dim": "#bbcabe",
                        "secondary-fixed": "#dde2f3",
                        "surface-bright": "#f4fcf1",
                        "secondary-container": "#dde2f3",
                        "inverse-surface": "#2b322c",
                        "tertiary-fixed": "#d7e6da",
                        "surface-variant": "#dde5db",
                        "tertiary-container": "#87968b",
                        "on-secondary-fixed-variant": "#414754",
                        "on-background": "#161d17",
                        "secondary": "#585e6c",
                        "background": "#f4fcf1",
                        "primary-container": "#00a859",
                        "tertiary": "#536258",
                        "on-secondary": "#ffffff",
                        "primary-fixed": "#77fca3",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#003317",
                        "on-primary-fixed-variant": "#005228",
                        "on-error": "#ffffff",
                        "surface-container-high": "#e3eae0",
                        "surface-dim": "#d5dcd2",
                        "on-surface": "#161d17",
                        "inverse-on-surface": "#ebf3e9",
                        "error-container": "#ffdad6",
                        "surface-container": "#e8f0e6",
                        "on-surface-variant": "#3d4a3f",
                        "surface-tint": "#006d38",
                        "primary": "#006d38",
                        "on-tertiary-fixed": "#111e17",
                        "secondary-fixed-dim": "#c1c6d7",
                        "surface-container-low": "#eef6eb",
                        "surface": "#f4fcf1",
                        "on-secondary-fixed": "#161c27",
                        "on-primary-fixed": "#00210d",
                        "error": "#ba1a1a"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fafcfa; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .touch-none { touch-action: none; }
        [x-cloak] { display: none !important; }

        @keyframes reveal { 0% { opacity: 0; transform: translateY(24px) scale(0.98); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes slideDown { 0% { opacity: 0; transform: translateY(-8px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }
        @keyframes slideIn { 0% { opacity: 0; transform: translateX(-32px); } 100% { opacity: 1; transform: translateX(0); } }
        @keyframes shimmer { 0% { transform: translateX(-100%) skewX(-15deg); } 100% { transform: translateX(200%) skewX(-15deg); } }
        @keyframes pulse { 0%, 100% { opacity: 0.4; } 50% { opacity: 0.8; } }
        @keyframes drawLine { 0% { width: 0; } 100% { width: 100%; } }

        .animate-reveal { animation: reveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in { animation: fadeIn 0.6s ease forwards; }
        .animate-slide-down { animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-scale-in { animation: scaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-shimmer { animation: shimmer 3s infinite; }

        .header-scrolled { background: rgba(255, 255, 255, 0.78); backdrop-filter: blur(24px) saturate(1.2); -webkit-backdrop-filter: blur(24px) saturate(1.2); border-bottom: 1px solid rgba(0, 0, 0, 0.04); }
        .header-top { background: transparent; border-bottom: 1px solid transparent; }

        .nav-link { position: relative; padding: 0.375rem 0; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 1.5px; background: #006d38; transition: width 0.5s cubic-bezier(0.16, 1, 0.3, 1); border-radius: 2px; }
        .nav-link:hover::after { width: 100%; }

        .search-card { background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .search-card::before { content: ''; position: absolute; inset: 0; border-radius: inherit; padding: 1px; background: linear-gradient(135deg, rgba(0, 109, 56, 0.15), transparent 50%, rgba(0, 109, 56, 0.08)); -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0); -webkit-mask-composite: xor; mask-composite: exclude; pointer-events: none; }



        .back-to-top-btn { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(0, 0, 0, 0.06); box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08); }
        .back-to-top-btn:hover { background: #006d38; border-color: #006d38; box-shadow: 0 8px 32px rgba(0, 109, 56, 0.25); }

        ::selection { background: rgba(0, 109, 56, 0.15); color: #003317; }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface overflow-x-hidden antialiased" x-data="{ mobileMenu: false }" :class="mobileMenu ? 'overflow-hidden' : ''">

    {{-- ============ FIXED HEADER WRAPPER ============ --}}
    <div class="fixed top-0 left-0 right-0 z-50">
    {{-- ============ TOP BAR ============ --}}
    <div class="h-9 flex items-center justify-center bg-[#00210d] text-on-primary/80 text-[10px] font-medium tracking-wide overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] bg-[radial-gradient(ellipse_at_center,_rgba(89,223,137,0.3)_0%,_transparent_70%)]"></div>
        @auth
            @php $userStore = auth()->user()->store; @endphp
            @if($userStore)
                <span class="inline-flex items-center gap-2 relative">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed-dim animate-pulse"></span>
                    <a href="{{ route('stores.show', $userStore->slug) }}" class="font-semibold hover:opacity-80 transition-opacity underline underline-offset-2">{{ $userStore->name }}</a>
                    <span class="opacity-40">•</span>
                    <a href="{{ route('seller.dashboard') }}" class="underline underline-offset-2 font-semibold text-primary-fixed-dim hover:opacity-80 transition-opacity">Dashboard</a>
                </span>
            @else
                <span class="inline-flex items-center gap-2 relative">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed-dim animate-pulse"></span>
                    Welcome back! Ready to start selling?
                    <a href="{{ route('seller.dashboard') }}" class="ml-0.5 underline underline-offset-2 font-semibold text-primary-fixed-dim hover:opacity-80 transition-opacity">Create Your Store</a>
                </span>
            @endif
        @else
            <span class="inline-flex items-center gap-2 relative">
                <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed-dim animate-pulse"></span>
                Free to Start — Create your catalog in 2 minutes
                <a href="{{ route('register') }}" class="ml-0.5 underline underline-offset-2 font-semibold text-primary-fixed-dim hover:opacity-80 transition-opacity">Get Started</a>
            </span>
        @endauth
    </div>

    {{-- ============ HEADER ============ --}}
    <header class="header-scrolled shadow-[0_1px_0_rgba(0,0,0,0.04)]">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 h-16 sm:h-[72px] flex items-center justify-between gap-4">

            {{-- Hamburger + Logo (mobile) --}}
            <div class="flex items-center gap-2 sm:gap-0">
                <button @click="mobileMenu = !mobileMenu" class="sm:hidden relative w-9 h-9 flex items-center justify-center rounded-xl text-on-surface-variant hover:text-primary hover:bg-black/5 transition-all active:scale-90" aria-label="Menu">
                    <svg x-show="!mobileMenu" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    <svg x-show="mobileMenu" class="w-5 h-5" x-cloak fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <a href="/" class="shrink-0 transition-opacity hover:opacity-80">
                    <x-application-logo class="h-7 sm:h-[30px]" />
                </a>
            </div>

            {{-- Desktop Nav --}}
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link text-[13px] font-semibold text-on-surface transition-colors">Home</a>
                <a href="{{ route('stores.index') }}" class="nav-link text-[13px] font-semibold text-on-surface-variant/80 hover:text-on-surface transition-colors">Stores</a>
                <a href="{{ route('products.index') }}" class="nav-link text-[13px] font-semibold text-on-surface-variant/80 hover:text-on-surface transition-colors">Products</a>
            </nav>

            {{-- Right --}}
            <div class="flex items-center gap-2 sm:gap-3">
                @hasSection('header-search')
                    @yield('header-search')
                @else
                {{-- Search trigger (desktop) --}}
                <div class="hidden sm:block flex-1 max-w-xs lg:max-w-sm">
                    <button @click="$dispatch('open-search')"
                            class="w-full flex items-center gap-2.5 px-4 py-2.5 bg-gray-100/80 hover:bg-gray-100 border border-gray-200/60 rounded-xl text-left transition-all group">
                        <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <span class="text-[13px] text-gray-400 flex-1">Search products, stores...</span>
                        <kbd class="text-[9px] text-gray-400 bg-white px-1.5 py-0.5 rounded-md border border-gray-200/80 font-medium shrink-0">/</kbd>
                    </button>
                </div>
                @endif

                {{-- Auth --}}
                @auth
                    @php $userStore = auth()->user()->store; $dashboard = auth()->user()->role === 'seller' ? route('seller.dashboard') : route('stores.index'); @endphp
                    @if(!$userStore)
                        <a href="{{ route('seller.dashboard') }}"
                           class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 text-[13px] font-semibold text-primary bg-primary/5 hover:bg-primary/10 rounded-xl transition-all">Open Your Store</a>
                    @endif
                    <a href="{{ $dashboard }}"
                       class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 text-[13px] font-semibold text-on-surface-variant/80 hover:text-on-surface hover:bg-black/5 rounded-xl transition-all">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline">
                        @csrf
                        <button type="submit" class="text-[13px] font-semibold text-on-surface-variant/60 hover:text-error transition-colors px-2.5 py-2 rounded-xl hover:bg-error/5">Log Out</button>
                    </form>
                    <a href="{{ $dashboard }}"
                       class="w-8 h-8 rounded-full overflow-hidden bg-black/5 flex items-center justify-center text-on-surface/60 text-xs font-bold hover:bg-primary hover:text-on-primary hover:scale-105 active:scale-95 transition-all ring-1 ring-black/5">
                        @if($userStore && $userStore->logo)
                            <img src="{{ $userStore->logo_url }}" alt="{{ $userStore->name }}" class="w-full h-full object-cover">
                        @else
                            {{ substr(auth()->user()->name ?? auth()->user()->email, 0, 1) }}
                        @endif
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex text-[13px] font-semibold text-on-surface-variant/80 hover:text-on-surface transition-colors px-3 py-2 rounded-xl hover:bg-black/5">Log In</a>
                    <a href="{{ route('register') }}"
                       class="relative px-5 py-2 bg-on-surface text-on-primary rounded-full text-[12px] font-bold hover:bg-on-surface/90 active:scale-[0.97] transition-all duration-200 shadow-sm overflow-hidden group">
                        Create Catalog
                        <span class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></span>
                    </a>
                @endauth

                {{-- Search trigger (mobile) --}}
                @hasSection('header-search-mobile')
                    @yield('header-search-mobile')
                @else
                <button @click="$dispatch('open-search')"
                        class="sm:hidden p-2 text-on-surface-variant hover:text-on-surface hover:bg-black/5 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                </button>
                @endif
            </div>
        </div>

        @hasSection('header-search-mobile-drawer')
            @yield('header-search-mobile-drawer')
        @endif
    </header>
    </div>

    {{-- ============ MOBILE NAV ============ --}}
    <div x-show="mobileMenu" x-cloak
         class="fixed inset-0 z-[60] sm:hidden"
         @keydown.escape.window="mobileMenu = false">
        <div class="absolute inset-0 bg-black/50"
             @click="mobileMenu = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
        <div class="absolute left-0 top-0 h-full w-full max-w-sm bg-white shadow-2xl"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div class="flex flex-col h-full">
                <div class="h-1 shrink-0 bg-gradient-to-r from-primary to-emerald-500"></div>

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 pt-4 pb-3 shrink-0">
                    <x-application-logo class="h-6" />
                    <button @click="mobileMenu = false"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- User / Guest --}}
                @auth
                    @php
                        $user = auth()->user();
                        $userStore = $user->store;
                        $isSeller = $user->role === 'seller';
                    @endphp
                    <div class="px-5 py-4 border-b border-gray-100 shrink-0">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl overflow-hidden bg-gray-100 ring-2 ring-gray-100 shrink-0">
                                @if($userStore && $userStore->logo)
                                    <img src="{{ $userStore->logo_url }}" class="w-full h-full object-cover">
                                @elseif($userStore)
                                    <x-store-default-logo :store="$userStore" size="sm" />
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-primary/10 text-primary font-bold text-sm">
                                        {{ substr($user->name ?? $user->email, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $user->name ?? 'User' }}</p>
                                    @if($isSeller)
                                        <span class="shrink-0 text-[9px] font-bold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md border border-amber-200/50">SELLER</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="px-5 py-5 border-b border-gray-100 shrink-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Account</p>
                        <a href="{{ route('register') }}" @click="mobileMenu = false"
                           class="block w-full text-center py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-800 transition-all active:scale-[0.98]">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" @click="mobileMenu = false"
                           class="block w-full text-center py-2.5 mt-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-xl hover:bg-gray-50 transition-all active:scale-[0.98]">
                            Log In
                        </a>
                    </div>
                @endauth

                {{-- Nav Links --}}
                <div class="flex-1 overflow-y-auto px-4 py-3">
                    <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Browse</p>
                    <div class="space-y-0.5">
                        <a href="{{ route('home') }}" @click="mobileMenu = false"
                           class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-gray-700 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all group">
                            <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary">home</span>
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" @click="mobileMenu = false"
                           class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-gray-700 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all group">
                            <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary">shopping_bag</span>
                            Products
                        </a>
                        <a href="{{ route('stores.index') }}" @click="mobileMenu = false"
                           class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-gray-700 rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all group">
                            <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-primary">store</span>
                            Stores
                        </a>
                    </div>

                    @auth
                        @if($isSeller)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Selling</p>
                                <a href="{{ route('seller.dashboard') }}" @click="mobileMenu = false"
                                   class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-gray-700 rounded-xl hover:bg-amber-50 hover:text-amber-800 transition-all group">
                                    <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-amber-500">dashboard</span>
                                    Dashboard
                                </a>
                                @if($userStore)
                                    <a href="{{ route('seller.products.index') }}" @click="mobileMenu = false"
                                       class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-gray-700 rounded-xl hover:bg-amber-50 hover:text-amber-800 transition-all group">
                                        <span class="material-symbols-outlined text-[20px] text-gray-400 group-hover:text-amber-500">inventory_2</span>
                                        Manage Products
                                    </a>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Sell</p>
                            <a href="{{ route('register') }}" @click="mobileMenu = false"
                               class="flex items-center gap-3.5 px-3 py-3 text-sm font-medium text-amber-700 rounded-xl hover:bg-amber-50 transition-all group">
                                <span class="material-symbols-outlined text-[20px] text-amber-500">storefront</span>
                                Open a Store
                            </a>
                        </div>
                    @endauth
                </div>

                {{-- Logout --}}
                @auth
                    <div class="px-5 py-4 border-t border-gray-100 shrink-0">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-3 text-sm font-medium text-red-600 hover:text-red-700 transition-all group">
                                <span class="material-symbols-outlined text-[20px]">logout</span>
                                Log Out
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- ============ SEARCH OVERLAY (Alibaba-style fullscreen) ============ --}}
    <div x-data="globalSearch()"
         @open-search.window="searchOpen = true; $nextTick(() => $refs.searchInput?.focus())"
         @keydown.escape.window="searchOpen = false"
         x-show="searchOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] bg-black/50 backdrop-blur-md"
         @click="searchOpen = false">
        <div @click.stop
             class="flex flex-col h-full sm:h-auto sm:max-h-[85vh] sm:mx-auto sm:mt-[8vh] sm:max-w-4xl sm:rounded-3xl sm:shadow-2xl bg-white overflow-hidden"
             x-transition:enter="sm:transition sm:ease-out sm:duration-300"
             x-transition:enter-start="sm:opacity-0 sm:scale-[0.96] sm:translate-y-6"
             x-transition:enter-end="sm:opacity-100 sm:scale-100 sm:translate-y-0"
             x-transition:leave="sm:transition sm:ease-in sm:duration-200"
             x-transition:leave-start="sm:opacity-100 sm:scale-100 sm:translate-y-0"
             x-transition:leave-end="sm:opacity-0 sm:scale-[0.96] sm:translate-y-6">

            {{-- Colored Branded Header --}}
            <div class="shrink-0 bg-gradient-to-r from-primary/5 via-primary/[0.02] to-transparent border-b border-primary/10">
                <div class="flex items-center gap-3 px-4 sm:px-6 h-14 sm:h-16">
                    <button @click="searchOpen = false" class="sm:hidden p-1.5 -ml-1.5 text-gray-500 hover:text-gray-700 rounded-xl hover:bg-gray-100 transition-all">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                    </button>
                    <div class="hidden sm:flex items-center gap-2.5 shrink-0 mr-1">
                        <x-application-logo class="w-7 h-7" />
                        <span class="text-[11px] font-bold text-primary/60 uppercase tracking-[0.12em]">Search</span>
                    </div>
                    <div class="flex-1 relative">
                        <span class="material-symbols-outlined text-[20px] text-primary/40 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">search</span>
                        <input x-ref="searchInput" x-model="query" @input.debounce.150ms="search()"
                               type="text" placeholder="Search products, stores, categories..."
                               class="w-full h-10 sm:h-11 pl-11 pr-4 text-sm sm:text-[15px] focus:outline-none placeholder:text-gray-300 font-medium text-gray-800"
                               style="border-radius:9999px;background:#f4fcf1;border:1.5px solid #e8f0e6;transition:all 0.2s"
                               @focus=" $el.style.borderColor='#00a859'; $el.style.background='#fafff8' "
                               @blur=" $el.style.borderColor='#e8f0e6'; $el.style.background='#f4fcf1' ">
                    </div>
                    <button x-show="query.length > 0"
                            @click="query = ''; results = { products: [], stores: [], categories: [], locations: [], users: [] }"
                            x-cloak
                            class="p-1.5 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-all">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                    <button @click="searchOpen = false; results = { products: [], stores: [], categories: [], locations: [], users: [] }; query = ''"
                            class="hidden sm:inline-flex text-sm font-semibold text-gray-500 hover:text-gray-700 px-4 py-1.5 rounded-full hover:bg-gray-100 transition-all shrink-0">
                        Cancel
                    </button>
                </div>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto no-scrollbar">
                {{-- Pre-search state (empty input) --}}
                <div x-show="query.length < 2 && !loading" class="px-5 sm:px-8 py-8 sm:py-10">
                    <div class="max-w-3xl mx-auto">
                        {{-- Brand intro --}}
                        <div class="text-center sm:text-left mb-8 sm:mb-10">
                            <p class="text-sm text-gray-400 max-w-md">Discover products from stores across Cameroon.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-start gap-8 sm:gap-12">
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-4">Trending Searches</p>
                                <div class="flex flex-wrap gap-2" x-show="trending.length">
                                    <template x-for="item in trending" :key="item.id">
                                        <a :href="item.url" @click="searchOpen = false"
                                           class="px-4 py-2 bg-gray-50 hover:bg-gray-100 hover:text-primary text-[12px] font-semibold text-gray-600 rounded-full transition-all cursor-pointer"
                                           x-text="item.name"></a>
                                    </template>
                                </div>
                                <p x-show="!trending.length" class="text-sm text-gray-300 italic">Loading...</p>
                            </div>
                            <div class="flex-1 sm:max-w-xs">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.1em] mb-4">Browse Categories</p>
                                <div class="space-y-1">
                                    <a href="{{ route('products.index') }}" @click="searchOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-primary/5 transition-all text-sm font-medium text-gray-700 hover:text-primary">
                                        <span class="material-symbols-outlined text-[18px] text-primary/40">category</span>
                                        All Products
                                    </a>
                                    <a href="{{ route('stores.index') }}" @click="searchOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-primary/5 transition-all text-sm font-medium text-gray-700 hover:text-primary">
                                        <span class="material-symbols-outlined text-[18px] text-primary/40">store</span>
                                        All Stores
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loading --}}
                <div x-show="loading" class="px-6 py-20 text-center">
                    <svg class="w-7 h-7 mx-auto animate-spin text-primary mb-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <p class="text-sm text-gray-400">Searching <span class="text-gray-500 font-medium" x-text="query"></span>&hellip;</p>
                </div>

                {{-- Results --}}
                <div x-show="!loading && query.length >= 2" class="pb-4">
                    <template x-if="hasResults">
                        <div class="sm:grid sm:grid-cols-5 sm:gap-0">
                            {{-- Left column: Products (primary) --}}
                            <div class="sm:col-span-3 sm:border-r sm:border-gray-50">
                                <template x-if="results.products.length">
                                    <div class="px-4 sm:px-6 pt-4 pb-2">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.08em]">Products</p>
                                            <a :href="'/products?search=' + encodeURIComponent(query)" @click="searchOpen = false" class="text-[11px] font-semibold text-primary hover:text-primary/80 transition-colors">View All</a>
                                        </div>
                                        <div class="space-y-1">
                                            <template x-for="product in results.products" :key="product.id">
                                                <a :href="product.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3.5 px-3 py-3 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all -mx-3 group">
                                                    <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-xl bg-gray-100 overflow-hidden shrink-0 ring-1 ring-black/5">
                                                        <img x-show="product.image" :src="'/r2/' + product.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="">
                                                        <div x-show="!product.image" class="w-full h-full flex items-center justify-center text-gray-300">
                                                            <span class="material-symbols-outlined text-[18px]">image</span>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-primary transition-colors" x-text="product.name"></p>
                                                        <p class="text-[11px] text-gray-400" x-text="product.category"></p>
                                                    </div>
                                                    <p class="text-xs font-bold text-primary shrink-0 whitespace-nowrap" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Right column: Categories, Stores, Locations --}}
                            <div class="sm:col-span-2">
                                <template x-if="results.categories.length">
                                    <div class="px-4 sm:px-6 pt-4 pb-2">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.08em] mb-2.5">Categories</p>
                                        <div class="space-y-0.5">
                                            <template x-for="cat in results.categories" :key="cat.id">
                                                <a :href="cat.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all -mx-2">
                                                    <span class="w-7 h-7 rounded-lg bg-primary/[0.06] flex items-center justify-center text-primary shrink-0">
                                                        <span class="material-symbols-outlined text-[14px]">category</span>
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-800" x-text="cat.name"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.stores.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.08em] mb-2.5">Stores</p>
                                        <div class="space-y-0.5">
                                            <template x-for="store in results.stores" :key="store.id">
                                                <a :href="store.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all -mx-2">
                                                    <div class="w-7 h-7 rounded-lg bg-gray-100 overflow-hidden shrink-0 flex items-center justify-center">
                                                        <img x-show="store.logo" :src="store.logo_url" class="w-full h-full object-cover" alt="">
                                                        <span x-show="!store.logo" class="text-[9px] font-bold text-gray-400" x-text="store.name.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-gray-800 truncate" x-text="store.name"></p>
                                                    </div>
                                                    <span x-show="store.is_verified" class="text-primary shrink-0">
                                                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                                    </span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.locations.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.08em] mb-2.5">Locations</p>
                                        <div class="space-y-0.5">
                                            <template x-for="loc in results.locations" :key="loc.name">
                                                <a :href="'/stores?location=' + encodeURIComponent(loc.name)" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all -mx-2">
                                                    <span class="w-7 h-7 rounded-lg bg-primary/[0.06] flex items-center justify-center text-primary shrink-0">
                                                        <span class="material-symbols-outlined text-[14px]">location_on</span>
                                                    </span>
                                                    <span class="text-sm font-semibold text-gray-800" x-text="loc.name"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.users.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-[0.08em] mb-2.5">People</p>
                                        <div class="space-y-0.5">
                                            <template x-for="user in results.users" :key="user.id">
                                                <a :href="user.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-gray-50 active:bg-gray-100 transition-all -mx-2">
                                                    <div class="w-7 h-7 rounded-lg bg-primary/[0.08] flex items-center justify-center text-primary font-bold text-[10px] shrink-0">
                                                        <span x-text="user.name.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-gray-800 truncate" x-text="user.name"></p>
                                                        <p class="text-[11px] text-gray-400 truncate" x-show="user.store" x-text="user.store"></p>
                                                    </div>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- No results --}}
                    <div x-show="!hasResults" class="px-6 py-16 sm:py-14 text-center">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-gray-50 flex items-center justify-center ring-1 ring-black/5">
                            <span class="material-symbols-outlined text-[24px] text-gray-300">search_off</span>
                        </div>
                        <p class="text-base font-bold text-gray-800">No results for "<span class="text-primary" x-text="query"></span>"</p>
                        <p class="text-sm text-gray-400 mt-1.5 max-w-xs mx-auto leading-relaxed">Try different keywords, check your spelling, or browse categories.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="min-h-screen bg-[#fafcfa] pt-[112px] sm:pt-[124px]">
        {{-- Left sidebar (store show page) --}}
        @hasSection('store-sidebar')
            <aside class="fixed left-0 top-[100px] sm:top-[108px] h-[calc(100vh-100px)] sm:h-[calc(100vh-108px)] w-[260px] bg-white border-r border-gray-100 shadow-sm z-30 hidden lg:block overflow-y-auto no-scrollbar">
                @yield('store-sidebar')
            </aside>
            <div class="lg:ml-[260px]">
        @endif

        {{-- Store nav bar (mobile: fixed below header, desktop: static or hidden when sidebar exists) --}}
        @hasSection('store-nav')
            <div class="fixed lg:static top-[100px] sm:top-[108px] left-0 right-0 z-30 bg-white border-b border-gray-100 shadow-sm overflow-x-auto no-scrollbar @hasSection('store-sidebar') lg:hidden @endif">
                <div class="max-w-7xl mx-auto px-5 sm:px-8">
                    @yield('store-nav')
                </div>
            </div>
        @endif

        @yield('content')

        @hasSection('store-sidebar')
            </div>
        @endif
    </main>

    {{-- ============ FOOTER ============ --}}
    @hasSection('footer')
        @yield('footer')
    @else
    <footer class="bg-[#fafcfa] border-t border-black/5">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-10 sm:py-14">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex flex-col items-center sm:items-start gap-3">
                    <a href="/" class="transition-opacity hover:opacity-80">
                        <x-application-logo class="h-7" />
                    </a>
                    <p class="text-xs text-on-surface-variant/50 text-center sm:text-left max-w-xs">
                        Cameroon's marketplace for merchants.
                    </p>
                </div>
                <div class="flex items-center gap-4 sm:gap-6">
                    @auth
                        @php $userStore = auth()->user()->store; @endphp
                        @if($userStore)
                            <a href="{{ route('stores.show', $userStore->slug) }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">My Store</a>
                            <a href="{{ route('seller.dashboard') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('seller.dashboard') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Open Your Store</a>
                            <a href="{{ route('seller.dashboard') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Create Store</a>
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Log In</a>
                    @endauth
                    <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Browse</a>
                    @hasSection('storeWhatsApp')
                        <a href="https://wa.me/{{ wa_url(($__env->yieldContent('storeWhatsApp'))) }}?text={{ urlencode('Hi, I saw your store on Izifai.') }}" target="_blank" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Contact</a>
                    @else
                        <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Community</a>
                    @endif
                </div>
            </div>
            <div class="mt-8 pt-5 border-t border-black/5 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-[11px] text-on-surface-variant/40">&copy; {{ date('Y') }} Izifai. Simplify Your Shopping.</p>
                <span class="text-[11px] text-on-surface-variant/40 flex items-center gap-1">
                    Trusted by {{ number_format(\App\Models\Store::count()) }}+ sellers
                </span>
            </div>
        </div>
    </footer>
    @endif

    {{-- ============ BACK TO TOP ============ --}}
    <button x-data="{ visible: false }"
            @scroll.window="visible = window.pageYOffset > 500 ? true : false"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            x-show="visible"
            x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-3 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-3 scale-90"
            class="back-to-top-btn fixed bottom-6 right-6 z-40 w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95 group">
        <svg class="w-5 h-5 text-on-surface-variant/60 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
    </button>

    <script>
        function globalSearch() {
            return {
                query: '',
                results: { products: [], stores: [], categories: [], locations: [], users: [] },
                searchOpen: false,
                loading: false,
                trending: [],
                get hasResults() {
                    return this.results.products.length > 0 || this.results.stores.length > 0 || this.results.categories.length > 0 || this.results.locations.length > 0 || this.results.users.length > 0;
                },
                init() {
                    this.$watch('searchOpen', val => {
                        document.body.classList.toggle('overflow-hidden', val);
                        if (!val) {
                            this.query = '';
                            this.results = { products: [], stores: [], categories: [], locations: [], users: [] };
                        }
                    });
                    fetch('/search/trending').then(r => r.json()).then(data => { this.trending = data; }).catch(() => {});
                },
                search() {
                    const q = this.query.trim();
                    if (q.length < 1) { this.results = { products: [], stores: [], categories: [], locations: [], users: [] }; this.loading = false; return; }
                    this.loading = true;
                    fetch('/search/autocomplete?q=' + encodeURIComponent(q))
                        .then(r => r.json())
                        .then(data => { this.results = data; this.loading = false; })
                        .catch(() => { this.loading = false; });
                }
            };
        }
    </script>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === '/' && !e.ctrlKey && !e.metaKey && !['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
                e.preventDefault();
                window.dispatchEvent(new CustomEvent('open-search'));
            }
        });
    </script>

    <script>
        function copyToClipboard(text, btn, successMsg, resetDelay) {
            const label = btn.querySelector('.copy-label');
            const icon = btn.querySelector('.copy-icon');
            const origLabel = label ? label.textContent : icon ? icon.textContent : '';
            const origIcon = icon ? icon.textContent : '';

            function done() {
                if (icon) icon.textContent = 'check';
                if (label) label.textContent = successMsg || 'Copied!';
                setTimeout(() => {
                    if (label) label.textContent = origLabel;
                    if (icon) icon.textContent = origIcon;
                }, resetDelay || 2000);
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(done).catch(fallback);
            } else {
                fallback();
            }

            function fallback() {
                const ta = document.createElement('textarea');
                ta.value = text;
                ta.style.position = 'fixed';
                ta.style.opacity = '0';
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
        }
    </script>

    {{-- ============ FLOATING "HOW IT WORKS" DRAGGABLE BUTTON ============ --}}
    <div x-data="{
        isDragging: false,
        startX: 0,
        startY: 0,
        offsetX: 0,
        offsetY: 0,
        currentX: 0,
        currentY: 0,
        draggingIntent: false,
        btnSize: 56,
        savedX: localStorage.getItem('fabX'),
        savedY: localStorage.getItem('fabY'),
        maxX() { return window.innerWidth - 80 },
        maxY() { return window.innerHeight - 80 },
        init() {
            if (this.savedX) this.currentX = Math.min(0, Math.max(parseFloat(this.savedX), -this.maxX()));
            if (this.savedY) this.currentY = Math.min(0, Math.max(parseFloat(this.savedY), -this.maxY()));
            this.$watch('currentX', val => localStorage.setItem('fabX', val));
            this.$watch('currentY', val => localStorage.setItem('fabY', val));
        },
        startDrag(e) {
            const ev = e.touches ? e.touches[0] : e;
            this.isDragging = true;
            this.draggingIntent = false;
            this.startX = ev.clientX - this.offsetX;
            this.startY = ev.clientY - this.offsetY;
        },
        moveDrag(e) {
            if (!this.isDragging) return;
            if (e.touches) e.preventDefault();
            const ev = e.touches ? e.touches[0] : e;
            let rawX = ev.clientX - this.startX;
            let rawY = ev.clientY - this.startY;
            this.offsetX = Math.min(0, Math.max(rawX, -this.maxX()));
            this.offsetY = Math.min(0, Math.max(rawY, -this.maxY()));
            this.currentX = this.offsetX;
            this.currentY = this.offsetY;
            if (Math.abs(rawX) > 5 || Math.abs(rawY) > 5) {
                this.draggingIntent = true;
            }
        },
        endDrag(e) {
            if (!this.isDragging) return;
            this.isDragging = false;
            if (!this.draggingIntent) {
                window.dispatchEvent(new CustomEvent('open-about-modal'));
            }
        }
    }"
    x-init="init()"
    :style="`transform: translate(${currentX}px, ${currentY}px)`"
    @mousedown="startDrag"
    @mousemove="moveDrag"
    @mouseup="endDrag"
    @mouseleave="isDragging = false"
    @touchstart="startDrag"
    @touchmove="moveDrag"
    @touchend="endDrag"
    class="fixed bottom-6 right-6 z-[500] cursor-grab select-none active:cursor-grabbing touch-none"
    x-cloak>
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-primary to-emerald-600 shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 hover:scale-105 active:scale-95 transition-all duration-200 flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                <path d="M12 17h.01"/>
            </svg>
        </div>
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-amber-400 rounded-full animate-ping ring-2 ring-white"></span>
    </div>

    {{-- ============ "HOW IT WORKS" MODAL (standalone, no transform ancestor) ============ --}}
    <div x-data="{ open: false }"
         @open-about-modal.window="open = true"
         @keydown.escape.window="open = false"
         x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[600] flex items-end sm:items-center justify-center"
         @click="open = false">
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" aria-hidden="true"></div>
        <div @click.stop
             x-transition:enter="sm:transition sm:ease-out sm:duration-200"
             x-transition:enter-start="sm:opacity-0 sm:scale-95 sm:translate-y-4"
             x-transition:enter-end="sm:opacity-100 sm:scale-100 sm:translate-y-0"
             x-transition:leave="sm:transition sm:ease-in sm:duration-150"
             x-transition:leave-start="sm:opacity-100 sm:scale-100 sm:translate-y-0"
             x-transition:leave-end="sm:opacity-0 sm:scale-95 sm:translate-y-4"
             class="relative w-full sm:max-w-lg bg-white sm:rounded-2xl rounded-t-2xl sm:shadow-2xl max-h-[90vh] sm:max-h-[85vh] flex flex-col overflow-hidden">
            {{-- Header --}}
            <div class="shrink-0 px-5 sm:px-7 py-4 sm:py-5 border-b border-gray-200 flex items-center justify-between bg-white">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[20px] text-gray-600">info</span>
                    </div>
                    <div>
                        <h2 class="text-[15px] sm:text-lg font-bold text-gray-900 leading-tight">How Izifai Works</h2>
                        <p class="text-[11px] sm:text-xs text-gray-500 mt-0.5">Your catalog in one link. No more WhatsApp spam.</p>
                    </div>
                </div>
                <button @click="open = false" class="p-1.5 -mr-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>

            {{-- Body --}}
            @php
                $chatStore = \App\Models\Store::where('status', 'active')->has('products')->inRandomOrder()->first();
                $chatProducts = $chatStore?->products()->with('images')->inRandomOrder()->take(3)->get() ?? collect();
                $chatProd1 = $chatProducts->get(0);
                $chatProd2 = $chatProducts->get(1);
                $chatProd3 = $chatProducts->get(2);
                $chatStoreName = $chatStore?->name ?? 'a local shop';
                $chatStoreInitial = substr($chatStoreName, 0, 1);
            @endphp
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-4 sm:px-6 py-4 sm:py-6 space-y-5 sm:space-y-6">

                {{-- ===== BEFORE: WhatsApp chaos ===== --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-bold text-red-500 uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[14px]">warning</span>
                            Before Izifai
                        </div>
                        <div class="flex-1 h-px bg-red-200"></div>
                    </div>

                    <div class="bg-[#e5ddd6] rounded-xl p-3 sm:p-4 space-y-2.5 shadow-inner" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,.03) 0px, rgba(255,255,255,.03) 2px, transparent 2px, transparent 4px)">
                        {{-- Group header --}}
                        <div class="flex items-center gap-2 pb-2 border-b border-black/10">
                            <div class="w-7 h-7 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[10px] font-bold">M</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] sm:text-[12px] font-bold text-gray-800 truncate">Marketplace Cameroon 🇨🇲</p>
                                <p class="text-[9px] text-gray-500">1,284 members</p>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-gray-400">more_vert</span>
                        </div>

                        {{-- Owner sends product images --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">{{ $chatStoreInitial }}</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-emerald-800">{{ $chatStoreName }}</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <div class="flex gap-1">
                                        @if($chatProd1 && $chatProd1->images->first())
                                            <div class="w-10 h-10 rounded overflow-hidden bg-gray-100"><img src="{{ $chatProd1->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-[16px]">📱</div>
                                        @endif
                                        @if($chatProd2 && $chatProd2->images->first())
                                            <div class="w-10 h-10 rounded overflow-hidden bg-gray-100"><img src="{{ $chatProd2->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-[16px]">👕</div>
                                        @endif
                                        @if($chatProd3 && $chatProd3->images->first())
                                            <div class="w-10 h-10 rounded overflow-hidden bg-gray-100"><img src="{{ $chatProd3->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-[16px]">👟</div>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-1">Fresh stock don land o! Check am make you see 🫡🔥</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">08:32</p>
                            </div>
                        </div>

                        {{-- Owner sends more --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">{{ $chatStoreInitial }}</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-emerald-800">{{ $chatStoreName }}</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <div class="flex gap-1">
                                        @if($chatProd1 && $chatProd1->images->first())
                                            <div class="w-10 h-10 rounded overflow-hidden bg-gray-100"><img src="{{ $chatProd1->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-[16px]">📱</div>
                                        @endif
                                        @if($chatProd2 && $chatProd2->images->first())
                                            <div class="w-10 h-10 rounded overflow-hidden bg-gray-100"><img src="{{ $chatProd2->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center text-[16px]">📱</div>
                                        @endif
                                    </div>
                                    <p class="text-[11px] text-gray-500 mt-1">Price don drop! Special offer na today o 🏃💨</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">09:15</p>
                            </div>
                        </div>

                        {{-- Complaints --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">K</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-blue-700 text-right">Kofi</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Na di same pictures evri day? Abeg make una stop 😤</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">09:16</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">A</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-purple-700 text-right">Caleb</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Ah my data don finish abeg! 🥲 Every day picture, picture. Who get data for that?</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">09:18</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">C</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-gray-600 text-right">Chris</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">I don commot for di group o. Too many notifications dey worry me 📴</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">09:20</p>
                            </div>
                        </div>

                        {{-- System message --}}
                        <div class="text-center py-1">
                            <span class="inline-block bg-red-100 text-red-600 text-[9px] font-semibold px-3 py-1 rounded-full">⚠️ Chris reported &amp; archived this group</span>
                        </div>
                    </div>
                </div>

                {{-- ===== Arrow transition ===== --}}
                <div class="flex items-center gap-3 py-1">
                    <div class="flex-1 h-px bg-emerald-200"></div>
                    <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-emerald-600">arrow_downward</span>
                    </div>
                    <div class="flex-1 h-px bg-emerald-200"></div>
                </div>

                {{-- ===== AFTER: Izifai happiness ===== --}}
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] font-bold text-emerald-600 uppercase tracking-wider">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span>
                            After Izifai
                        </div>
                        <div class="flex-1 h-px bg-emerald-200"></div>
                    </div>

                    <div class="bg-[#e5ddd6] rounded-xl p-3 sm:p-4 space-y-2.5 shadow-inner" style="background-image: repeating-linear-gradient(45deg, rgba(255,255,255,.03) 0px, rgba(255,255,255,.03) 2px, transparent 2px, transparent 4px)">
                        {{-- Group header --}}
                        <div class="flex items-center gap-2 pb-2 border-b border-black/10">
                            <div class="w-7 h-7 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[10px] font-bold">M</div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[11px] sm:text-[12px] font-bold text-gray-800 truncate">Marketplace Cameroon 🇨🇲</p>
                                <p class="text-[9px] text-gray-500">1,512 members <span class="text-emerald-600 font-semibold">+228 this week</span></p>
                            </div>
                            <span class="material-symbols-outlined text-[16px] text-gray-400">more_vert</span>
                        </div>

                        {{-- Merchant shares Izifai catalog link --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">{{ $chatStoreInitial }}</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-emerald-800">{{ $chatStoreName }}</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <div class="w-7 h-7 rounded bg-emerald-100 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[14px] text-emerald-600">store</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] font-bold text-gray-800 truncate">{{ $chatStoreName }}</p>
                                            <p class="text-[7px] text-gray-400 truncate">izifai.com/shop/{{ strtolower(str_replace(' ', '', $chatStoreName)) }}</p>
                                        </div>
                                    </div>
                                    {{-- Link preview card with actual product image --}}
                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                        @if($chatProd1 && $chatProd1->images->first())
                                            <div class="w-full h-24 bg-gray-100"><img src="{{ $chatProd1->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-full h-24 bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-[28px] text-emerald-400">storefront</span>
                                            </div>
                                        @endif
                                        <div class="px-2.5 py-2 bg-white">
                                            <p class="text-[9px] font-bold text-gray-800 truncate">View {{ $chatStoreName }} Catalog</p>
                                            <p class="text-[7px] text-gray-400 truncate">izifai.com/shop/{{ strtolower(str_replace(' ', '', $chatStoreName)) }}</p>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-600 mt-1.5 break-words">My people, I don create my shop for Izifai. Instead of posting images every day, I just share one link — my whole business dey there. Prices, photos, descriptions, everything. Anybody wey get the link fit share am too. No more flooding groups! 🥳🙌</p>
                                    <div class="text-[9px] text-gray-400 mt-1 flex items-center gap-2">
                                        <span>😊 4</span>
                                        <span>💬 12</span>
                                    </div>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:02</p>
                            </div>
                        </div>

                        {{-- Also shares a product link --}}
                        <div class="flex items-start gap-2 max-w-[80%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">{{ $chatStoreInitial }}</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-emerald-800">{{ $chatStoreName }}</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <div class="border border-gray-200 rounded-lg overflow-hidden flex">
                                        @if($chatProd1 && $chatProd1->images->first())
                                            <div class="w-12 h-12 shrink-0 bg-gray-100"><img src="{{ $chatProd1->images->first()->url }}" alt="" class="w-full h-full object-cover"></div>
                                        @else
                                            <div class="w-12 h-12 shrink-0 bg-gray-200 flex items-center justify-center text-[20px]">📦</div>
                                        @endif
                                        <div class="flex-1 min-w-0 px-2 py-1.5">
                                            <p class="text-[9px] font-bold text-gray-800 truncate">{{ $chatProd1?->name ?? 'Product' }}</p>
                                            <p class="text-[8px] text-gray-500 truncate">izifai.com/product/{{ $chatProd1?->id ?? '#' }}</p>
                                            <p class="text-[8px] font-bold text-emerald-600 mt-0.5">Click to view &rarr;</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:03</p>
                            </div>
                        </div>

                        {{-- Happy replies --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">K</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-blue-700 text-right">Kofi</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Na real talk! Now instead of your pictures dey worry our data, I just share your one link for any group. Your entire business dey inside one link. E easy to spread! 🔥🙌</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">10:05</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-purple-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">A</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-purple-700 text-right">Caleb</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Waah my data don rest small! 😂 I just check your shop, e clean well well. No more wasting mb 🤩</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">10:07</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[85%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-gray-400 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">C</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-gray-600 text-right">Chris</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">I come back o 😂 I don cancel my own report. Your shop profile proper! You organize well well 👏</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">10:10</p>
                            </div>
                        </div>

                        {{-- System message --}}
                        <div class="text-center py-1">
                            <span class="inline-block bg-emerald-100 text-emerald-700 text-[9px] font-semibold px-3 py-1 rounded-full">✅ Chris unarchived group &amp; rejoined</span>
                        </div>

                        <div class="flex items-start gap-2 max-w-[80%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">T</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-orange-700">Tata</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">I don see di {{ $chatProd1?->name ?? 'product' }}, I like am. How I take order?</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:15</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[80%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">K</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-blue-700">Kofi</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Even me self, I don share your link with my friends for another group. Dem want order too</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:17</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[85%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-emerald-600 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">{{ $chatStoreInitial }}</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-emerald-800">{{ $chatStoreName }}</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Simple! Just click di WhatsApp button on di product you want, my number go show with di product description already dey there. I go know wetin you want ✨</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:18</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2 max-w-[80%] min-w-0 ml-auto flex-row-reverse">
                            <div class="w-6 h-6 rounded-full bg-orange-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">T</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-orange-700 text-right">Tata</p>
                                <div class="bg-[#dcf8c6] rounded-lg rounded-tr-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Ahh okay! I don see di WhatsApp button. I tap am now 👌</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5 text-right">10:20</p>
                            </div>
                        </div>

                        {{-- System: new member joined via Izifai --}}
                        <div class="text-center py-1">
                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-[9px] font-semibold px-3 py-1 rounded-full">👤 +237 6 23 456 789 joined via Izifai</span>
                        </div>

                        {{-- New customer found the store on Izifai --}}
                        <div class="flex items-start gap-2 max-w-[85%] min-w-0">
                            <div class="w-6 h-6 rounded-full bg-pink-500 flex items-center justify-center text-white text-[8px] font-bold shrink-0 mt-0.5">F</div>
                            <div class="min-w-0">
                                <p class="text-[9px] font-bold text-pink-700">Faith</p>
                                <div class="bg-white rounded-lg rounded-tl-none p-2 mt-0.5 shadow-sm">
                                    <p class="text-[11px] sm:text-[12px] text-gray-800 break-words">Your business dey public now! I just find di {{ $chatProd1?->name ?? 'product' }} wey I dey find for months 😭 I don join plenty WhatsApp groups for am but nobody get am like that. But I see am for your Izifai shop just now. I happy! Your whole shop dey online, I dey share am for my status. God bless Izifai! 🙌🎉</p>
                                </div>
                                <p class="text-[8px] text-gray-400 mt-0.5">10:25</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="shrink-0 px-5 sm:px-7 py-3 sm:py-3.5 border-t border-gray-100 bg-gray-50/70 flex items-center justify-between gap-3">
                <p class="text-[11px] sm:text-xs text-gray-400">No more spam. Just shopping.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center gap-1 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs sm:text-sm font-semibold rounded-xl transition-all whitespace-nowrap">
                    Join Izifai
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>