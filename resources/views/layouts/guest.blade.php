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

        .mobile-menu-item { position: relative; overflow: hidden; border-radius: 12px; }
        .mobile-menu-item::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent, rgba(0, 109, 56, 0.06), transparent); transform: translateX(-100%); transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .mobile-menu-item:hover::before { transform: translateX(100%); }

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
        <div class="absolute inset-0 bg-black/40 backdrop-blur-lg"
             @click="mobileMenu = false"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>
        <div class="absolute left-0 top-0 h-full w-[300px] max-w-[85vw] bg-surface shadow-2xl overflow-y-auto"
             x-transition:enter="transition ease-out duration-400"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            {{-- Header --}}
            <div class="px-5 pt-5 pb-4">
                <div class="flex items-center justify-between mb-4">
                    <x-application-logo class="h-7" />
                    <button @click="mobileMenu = false" class="w-8 h-8 flex items-center justify-center rounded-xl text-on-surface-variant hover:text-on-surface hover:bg-black/5 transition-all active:scale-90">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex items-center gap-2 text-[10px] text-on-surface-variant/50 font-medium">
                    <span class="flex items-center gap-1.5 bg-primary/5 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary"></span>
                        {{ number_format(\App\Models\Store::count()) }}+ Stores
                    </span>
                    <span class="flex items-center gap-1.5 bg-primary/5 px-2.5 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-primary/60"></span>
                        {{ number_format(\App\Models\Product::count()) }}+ Products
                    </span>
                </div>
            </div>

            {{-- User / Auth Card --}}
            @auth
                @php $dashboard = auth()->user()->role === 'seller' ? route('seller.dashboard') : route('stores.index'); @endphp
                <div class="mx-3 mb-3 p-3 rounded-xl bg-gradient-to-br from-primary/[0.04] to-primary/[0.01] border border-primary/10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary font-bold text-sm ring-2 ring-primary/20 shrink-0">
                            {{ substr(auth()->user()->name ?? auth()->user()->email, 0, 1) }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-on-surface truncate">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-[10px] text-on-surface-variant/60 truncate">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-primary/10">
                        <a href="{{ $dashboard }}" @click="mobileMenu = false"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2 text-[11px] font-bold text-primary bg-primary/10 rounded-lg hover:bg-primary/20 transition-all">
                            <span class="material-symbols-outlined text-[14px]">dashboard</span>
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-1.5 py-2 text-[11px] font-bold text-error bg-error/5 rounded-lg hover:bg-error/10 transition-all">
                                <span class="material-symbols-outlined text-[14px]">logout</span>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="mx-3 mb-3 p-4 rounded-xl bg-gradient-to-br from-primary/[0.06] to-primary/[0.02] border border-primary/10">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-on-surface">Join Izifai</p>
                            <p class="text-[10px] text-on-surface-variant/60">Create your store in 2 minutes</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('register') }}" @click="mobileMenu = false"
                           class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-[11px] font-bold text-on-primary bg-on-surface rounded-lg hover:bg-on-surface/90 transition-all active:scale-[0.98]">
                            Get Started
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="{{ route('login') }}" @click="mobileMenu = false"
                           class="flex items-center justify-center gap-1.5 py-2.5 px-4 text-[11px] font-bold text-on-surface-variant border border-outline-variant/30 rounded-lg hover:bg-black/5 transition-all">
                            Log In
                        </a>
                    </div>
                </div>
            @endauth

            {{-- Nav Section --}}
            <div class="px-3">
                <p class="px-3 py-2 text-[9px] font-bold text-on-surface-variant/40 uppercase tracking-[0.2em]">Browse</p>
                <a href="{{ route('home') }}" @click="mobileMenu = false"
                   class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                    <span class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors shrink-0">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.126 1.126 0 011.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                    </span>
                    <span class="flex-1">Home</span>
                    <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('stores.index') }}" @click="mobileMenu = false"
                   class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                    <span class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors shrink-0">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
                    </span>
                    <span class="flex-1">Stores</span>
                    <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
                <a href="{{ route('products.index') }}" @click="mobileMenu = false"
                   class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                    <span class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary group-hover:bg-primary/10 transition-colors shrink-0">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </span>
                    <span class="flex-1">Products</span>
                    <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>

            {{-- Sell Section --}}
            <div class="px-3 mt-1">
                <p class="px-3 py-2 text-[9px] font-bold text-on-surface-variant/40 uppercase tracking-[0.2em]">Sell</p>
                @auth
                    @php $userStore = auth()->user()->store; @endphp
                    @if($userStore)
                        <a href="{{ route('stores.show', $userStore->slug) }}" @click="mobileMenu = false"
                           class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                            <span class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors shrink-0">
                                <span class="material-symbols-outlined text-[18px]">store</span>
                            </span>
                            <span class="flex-1">My Store</span>
                            <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <a href="{{ route('seller.dashboard') }}" @click="mobileMenu = false"
                           class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                            <span class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors shrink-0">
                                <span class="material-symbols-outlined text-[18px]">store</span>
                            </span>
                            <span class="flex-1">Open Your Store</span>
                            <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @endif
                @else
                    <a href="{{ route('register') }}" @click="mobileMenu = false"
                       class="flex items-center gap-3 px-3.5 py-3 text-sm font-semibold text-on-surface rounded-xl hover:bg-black/[0.03] transition-all group">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:bg-amber-100 transition-colors shrink-0">
                            <span class="material-symbols-outlined text-[18px]">store</span>
                        </span>
                        <span class="flex-1">Open Your Store</span>
                        <svg class="w-3.5 h-3.5 text-on-surface-variant/20 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @endauth
            </div>

            {{-- WhatsApp Community Card --}}
            <div class="mx-3 mt-3 mb-4 p-4 rounded-xl bg-gradient-to-br from-[#25D366]/10 to-[#25D366]/5 border border-[#25D366]/15">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#25D366] flex items-center justify-center shrink-0 shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-on-surface">Izifai Community</p>
                        <p class="text-[10px] text-on-surface-variant/70 mt-0.5 leading-relaxed">Connect with merchants, share feedback, and stay updated.</p>
                        <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank"
                           class="inline-flex items-center gap-1 mt-2.5 text-[11px] font-bold text-[#25D366] hover:text-[#128C7E] transition-colors">
                            Join the Group
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="px-5 py-4 border-t border-black/5">
                <p class="text-[10px] text-on-surface-variant/30 text-center">&copy; {{ date('Y') }} Izifai. Simplify Your Shopping.</p>
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
                    <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Community</a>
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

    @stack('scripts')
</body>
</html>
