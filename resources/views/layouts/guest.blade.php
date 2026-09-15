<!DOCTYPE html>
<html class="light overflow-x-hidden" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, interactive-widget=resizes-content">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>@yield('title', 'Izifai — Your Store in a Link')</title>
    <meta name="description" content="@yield('description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <meta property="og:title" content="@yield('og_title', 'Izifai — Your Store in a Link')">
    <meta property="og:description" content="@yield('og_description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <meta property="og:image" content="@yield('og_image', asset('images/izifai-onboarding-logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="Izifai">
    <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Izifai — Your Store in a Link')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/izifai-onboarding-logo.png'))">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        accent: {
                            DEFAULT: "#9acd32",
                            dark: "#7ca81d",
                            soft: "#f2f9df",
                        },
                        ink: "#1c201e",
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
                        "background": "#f5f6f5",
                        "primary-container": "#9acd32",
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
                        "surface-container": "#e8f0e6",
                        "on-surface-variant": "#3d4a3f",
                        "surface-tint": "#659316",
                        "primary": "#659316",
                        "on-tertiary-fixed": "#111e17",
                        "secondary-fixed-dim": "#c1c6d7",
                        "surface-container-low": "#eef6eb",
                        "surface": "#f4fcf1",
                        "on-secondary-fixed": "#161c27",
                        "on-primary-fixed": "#00210d",
                        "error": "#dc2626"
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
                        sans: ["Poppins", "system-ui", "-apple-system", "Segoe UI", "Roboto", "sans-serif"],
                    }
                }
            }
        }
    </script>
    <style>
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif; background-color: #f5f6f5; }
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
        @keyframes cardFadeIn { 0% { opacity: 0; transform: translateY(16px) scale(0.96); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes floaty { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes popIn { 0% { opacity:0; transform: scale(0.55); } 60% { transform: scale(1.08); } 100% { opacity:1; transform: scale(1); } }
        @keyframes featureSlide { 0% { opacity:0; transform: translateY(12px); } 100% { opacity:1; transform: translateY(0); } }

        .animate-reveal { animation: reveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in { animation: fadeIn 0.6s ease forwards; }
        .animate-slide-down { animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-scale-in { animation: scaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-shimmer { animation: shimmer 3s infinite; }
        .card-enter { opacity: 0; animation: cardFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-floaty { animation: floaty 3s ease-in-out infinite; }
        .animate-pop-in { opacity: 0; animation: popIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-feature-1 { opacity: 0; animation: featureSlide 0.5s 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-feature-2 { opacity: 0; animation: featureSlide 0.5s 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-feature-3 { opacity: 0; animation: featureSlide 0.5s 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .header-scrolled { background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(18px) saturate(1.1); -webkit-backdrop-filter: blur(18px) saturate(1.1); border-bottom: 1px solid rgba(0, 0, 0, 0.05); }
        .header-top { background: transparent; border-bottom: 1px solid transparent; }

        .nav-link { position: relative; padding: 0.375rem 0; }
        .nav-link::after { content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px; background: #9acd32; transition: width 0.5s cubic-bezier(0.16, 1, 0.3, 1); border-radius: 2px; }
        .nav-link:hover::after { width: 100%; }

        .back-to-top-btn { background: #9acd32; box-shadow: 0 8px 24px rgba(154, 205, 50, 0.25); }
        .back-to-top-btn:hover { background: #7ca81d; }

        .tnum { font-variant-numeric: tabular-nums; }

        ::selection { background: rgba(154, 205, 50, 0.14); color: #431d00; }
        .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom, 0px); }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface overflow-x-hidden antialiased" x-data="guestLayout()" :class="(mobileMenu || onboarding) ? 'overflow-hidden' : ''">

    {{-- ============ FIXED HEADER WRAPPER ============ --}}
    <div class="fixed top-0 left-0 right-0 z-50">

    {{-- ============ TOP BAR (desktop only) ============ --}}
    <div class="hidden sm:flex h-9 items-center justify-center bg-[#0b3a24] text-white/80 text-[10px] font-medium tracking-wide overflow-hidden">
        @auth
            @php $userStore = auth()->user()->store; @endphp
            @if($userStore)
                <span class="inline-flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#59df89]"></span>
                    <a href="{{ route('stores.show', $userStore->slug) }}" class="font-semibold hover:opacity-80 transition-opacity underline underline-offset-2">{{ $userStore->name }}</a>
                    <span class="opacity-40">•</span>
                    <a href="{{ route('seller.dashboard') }}" class="underline underline-offset-2 font-semibold text-[#59df89] hover:opacity-80 transition-opacity">Dashboard</a>
                </span>
            @else
                <span class="inline-flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#59df89]"></span>
                    Welcome back! Ready to start selling?
                    <a href="{{ route('seller.store.create') }}" class="ml-0.5 underline underline-offset-2 font-semibold text-[#59df89] hover:opacity-80 transition-opacity">Create Your Store</a>
                </span>
            @endif
        @else
            <span class="inline-flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-[#9acd32]"></span>
                Free to Start — Create your catalog in 2 minutes
                <a href="{{ route('register') }}" class="ml-0.5 underline underline-offset-2 font-semibold text-[#ffb27a] hover:opacity-80 transition-opacity">Get Started</a>
            </span>
        @endauth
    </div>

    {{-- ============ HEADER ============ --}}
    <header class="header-scrolled bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            {{-- Main header row --}}
            <div class="h-14 sm:h-16 flex items-center justify-between gap-3">

                {{-- Hamburger + Logo --}}
                <div class="flex items-center gap-2 shrink-0">
                    {{-- Mobile hamburger triggers bottom sheet --}}
                    <button @click="mobileMenu = !mobileMenu" class="sm:hidden relative w-9 h-9 flex items-center justify-center rounded-xl text-[#3f453f] hover:bg-black/5 transition-all active:scale-90" aria-label="Menu">
        <span x-show="!mobileMenu" class="fa-solid fa-bars text-[22px]"></span>
                <span x-show="mobileMenu" x-cloak class="fa-solid fa-xmark text-[22px]"></span>
                    </button>
                    <a href="/" class="shrink-0 transition-opacity hover:opacity-80">
                        <x-application-logo class="h-7 sm:h-8" />
                    </a>
                    <span class="hidden lg:inline-flex items-center gap-1 text-[9px] font-extrabold uppercase tracking-[0.14em] text-[#9acd32] bg-[#9acd32]/10 px-2 py-1 rounded-md ml-1">
                        Marketplace
                    </span>
                </div>

                {{-- Search bar (desktop, prominent) --}}
                @hasSection('header-search')
                    @yield('header-search')
                @else
                <div class="hidden sm:flex flex-1 max-w-xl lg:max-w-2xl mx-4">
                    <div class="group w-full flex items-center rounded-full bg-white border border-[#e4e7e4] focus-within:border-[#9acd32] focus-within:ring-4 focus-within:ring-[#9acd32]/10 hover:border-[#c9cdc9] shadow-sm transition-all duration-200">
                        <span class="grid place-items-center pl-4 pr-1 text-[#9aa19c] group-focus-within:text-[#7ca81d] transition-colors">
                            <i class="fa-solid fa-magnifying-glass text-[20px]" style=""></i>
                        </span>
                        <input type="text" placeholder="What are you looking for?"
                               @click="$dispatch('open-search')"
                               class="w-full h-11 bg-transparent text-[13px] px-2 outline-none text-[#1c201e] placeholder-[#9aa19c] cursor-pointer truncate" readonly>
                        <button @click="$dispatch('open-search')" class="m-1 h-9 shrink-0 rounded-full px-4 bg-[#9acd32] hover:bg-[#7ca81d] text-white text-[13px] font-bold flex items-center gap-1.5 transition-all active:scale-[0.98]">
                            <i class="fa-solid fa-magnifying-glass text-[18px]" style=""></i>
                            Search
                        </button>
                    </div>
                </div>
                @endif

                {{-- Right icons --}}
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <button @click="$dispatch('open-search')" aria-label="Search"
                            class="sm:hidden w-9 h-9 grid place-items-center rounded-xl text-[#3f453f] hover:text-[#1c201e] hover:bg-black/5 transition-all">
                        <i class="fa-solid fa-magnifying-glass text-[21px]" style=""></i>
                    </button>
                    @auth
                        @php
                            $userStore = auth()->user()->store;
                        @endphp
                        <a href="{{ route('notifications.index') }}"
                           class="relative w-9 h-9 flex items-center justify-center rounded-xl text-[#5c625e] hover:text-[#1c201e] hover:bg-black/5 transition-all">
                            <i class="fa-solid fa-bell text-[20px]" style=""></i>
                            <span class="notif-badge hidden absolute -top-0.5 -right-0.5 w-4 h-4 bg-[#dc2626] text-white text-[8px] font-bold rounded-full flex items-center justify-center">0</span>
                        </a>
                        <a href="{{ route('conversations.index') }}"
                           class="relative w-9 h-9 flex items-center justify-center rounded-xl text-[#5c625e] hover:text-[#1c201e] hover:bg-black/5 transition-all">
                            <i class="fa-solid fa-comment text-[20px]" style=""></i>
                            <span class="unread-badge hidden absolute -top-0.5 -right-0.5 w-4 h-4 bg-[#dc2626] text-white text-[8px] font-bold rounded-full flex items-center justify-center">0</span>
                        </a>
                        <div class="w-px h-6 bg-[#e5e7e5] mx-1 hidden sm:block"></div>
                        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <button class="w-8 h-8 rounded-full overflow-hidden bg-black/5 flex items-center justify-center text-[#3f453f] text-xs font-bold hover:ring-2 hover:ring-[#9acd32]/40 transition-all ring-1 ring-black/10">
                                @if($userStore && $userStore->logo)
                                    <img src="{{ $userStore->logo_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    {{ substr(auth()->user()->name ?? auth()->user()->email, 0, 1) }}
                                @endif
                            </button>
                            <div x-show="open" x-cloak @click="open = false"
                                 class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-[#e8eae8] py-2 z-50">
<a href="{{ $userStore ? route('seller.dashboard') : route('seller.store.create') }}" class="flex items-center gap-2.5 px-4 py-2 text-[12px] font-medium text-[#3f453f] hover:bg-[#f5f6f5] transition-colors">
                                    <i class="fa-solid fa-store text-[16px] text-[#9aa19c]"></i> {{ $userStore ? 'Dashboard' : 'Open a Store' }}
                                </a>
                                @if(!$userStore)
                                    <a href="{{ route('seller.store.create') }}" class="flex items-center gap-2.5 px-4 py-2 text-[12px] font-medium text-[#3f453f] hover:bg-[#f5f6f5] transition-colors">
                                        <i class="fa-solid fa-store text-[16px] text-[#9aa19c]" style=""></i> Create Your Store
                                    </a>
                                @endif
                                <hr class="my-1 border-[#e8eae8]">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-[12px] font-medium text-[#dc2626] hover:bg-[#dc2626]/5 transition-colors">
                                        <i class="fa-solid fa-right-from-bracket text-[16px]" style=""></i> Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center gap-1.5 px-4 py-2 text-[12px] font-bold text-white bg-[#9acd32] hover:bg-[#7ca81d] rounded-full transition-all">
                            Join Free
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-[12px] font-semibold text-[#3f453f] hover:text-[#1c201e] hover:bg-black/5 rounded-full transition-all">
                            Sign In
                        </a>
                    @endguest
                </div>
            </div>

            {{-- Navigation row (desktop) --}}
            <div class="hidden sm:flex items-center h-11 border-t border-[#eff1ef]">
                {{-- Categories mega menu --}}
                <div class="relative h-full" x-data="{ catOpen: false }" @mouseenter="catOpen = true" @mouseleave="catOpen = false">
                    <button class="h-full flex items-center gap-2 px-5 text-[12px] font-bold text-white bg-[#9acd32] hover:bg-[#7ca81d] rounded-b-xl transition-colors">
                        <i class="fa-solid fa-tags text-[18px]" style=""></i>
                        All Categories
                        <i class="fa-solid fa-chevron-down text-[14px] opacity-80" :class="catOpen ? 'rotate-180' : ''" style="transition: transform 0.2s"></i>
                    </button>
                    <div x-show="catOpen" x-cloak
                         @click="catOpen = false"
                         class="absolute left-0 top-full mt-1 z-50 w-[min(42rem,calc(100vw-2rem))] bg-white rounded-2xl shadow-xl border border-[#e8eae8] lg:grid lg:grid-cols-[1fr_11rem] overflow-hidden">
                        <div class="p-2.5">
                            <div class="flex items-center justify-between px-3 py-1.5 mb-1">
                                <span class="text-[10px] font-extrabold uppercase tracking-[0.14em] text-[#9aa19c]">Categories</span>
                                <a href="{{ route('products.index') }}"
                                   class="text-[11px] font-bold text-[#9acd32] hover:text-[#7ca81d] transition-colors inline-flex items-center gap-0.5">
                                    Browse all <i class="fa-solid fa-arrow-right text-[13px]" style=""></i>
                                </a>
                            </div>
                            <div class="grid grid-cols-2 min-[480px]:grid-cols-3 gap-0.5 max-h-[21rem] overflow-y-auto no-scrollbar">
                                @php $catTints = [['#fff0e4', '#c25400'], ['#e6f2ec', '#659316'], ['#eff1f4', '#454b57'], ['#fbf0c8', '#8a6d00']]; @endphp
                                @foreach($headerCategories->whereNull('parent_id')->take(18) as $cat)
                                    @php $tc = $catTints[$loop->index % count($catTints)]; @endphp
                                    <a href="{{ route('products.index', ['category' => $cat->slug]) }}"
                                       class="flex items-center gap-2.5 px-2.5 py-2 rounded-xl hover:bg-[#f2f9df] hover:text-[#7ca81d] transition-all text-[12px] font-medium text-[#3f453f] group">
                                        <span class="w-8 h-8 rounded-lg grid place-items-center shrink-0 overflow-hidden">
                                            @if($cat->image_url)
                                                <img src="{{ $cat->image_url }}" alt="" class="w-full h-full object-cover">
                                            @elseif($cat->icon && str_starts_with($cat->icon, '<'))
                                                <span class="text-[15px] leading-none flex items-center justify-center w-full h-full" style="background: {{ $tc[0] }}">{!! $cat->icon !!}</span>
                                            @else
                                                <span class="text-[12px] font-extrabold w-full h-full flex items-center justify-center" style="background: {{ $tc[0] }}; color: {{ $tc[1] }};">{{ strtoupper(substr($cat->name, 0, 1)) }}</span>
                                            @endif
                                        </span>
                                        <span class="truncate flex-1">{{ $cat->name }}</span>
                                        @if($cat->products_count > 0)
                                            <span class="text-[10px] font-semibold text-[#9aa19c] group-hover:text-[#7ca81d] transition-colors tnum">{{ number_format($cat->products_count) }}</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="hidden lg:flex flex-col gap-1 bg-[#f5f6f5] border-l border-[#e8eae8] p-3">
                            <span class="text-[9px] font-bold text-[#9aa19c] uppercase tracking-wider mb-1 px-2">Quick Links</span>
                            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 text-[11px] font-medium text-[#3f453f] hover:text-[#7ca81d] transition-colors px-2 py-1.5 rounded-lg hover:bg-white">
                                <i class="fa-solid fa-store text-[14px] text-[#9aa19c]"></i> Top Stores
                            </a>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-[11px] font-medium text-[#3f453f] hover:text-[#7ca81d] transition-colors px-2 py-1.5 rounded-lg hover:bg-white">
                                <i class="fa-solid fa-certificate text-[14px] text-[#9aa19c]"></i> New Arrivals
                            </a>
                            <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-[11px] font-medium text-[#3f453f] hover:text-[#7ca81d] transition-colors px-2 py-1.5 rounded-lg hover:bg-white">
                                <i class="fa-solid fa-screwdriver-wrench text-[14px] text-[#9aa19c]"></i> Services
                            </a>
                            <a href="{{ route('rentals.index') }}" class="inline-flex items-center gap-2 text-[11px] font-medium text-[#3f453f] hover:text-[#7ca81d] transition-colors px-2 py-1.5 rounded-lg hover:bg-white">
                                <i class="fa-solid fa-warehouse text-[14px] text-[#9aa19c]"></i> Rentals
                            </a>
                            <a href="{{ route('stores.index') }}" class="mt-auto inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-[#9acd32] text-white text-[11px] font-bold rounded-full hover:bg-[#7ca81d] transition-colors">
                                Explore stores
                                <i class="fa-solid fa-arrow-right text-[13px]" style=""></i>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Nav links --}}
                <nav class="flex items-center h-full gap-1 ml-2">
                    <a href="{{ route('home') }}" class="h-full flex items-center px-3.5 text-[12px] font-semibold text-[#1c201e] border-b-2 border-[#9acd32] transition-colors">Home</a>
                    <a href="{{ route('products.index') }}" class="h-full flex items-center px-3.5 text-[12px] font-medium text-[#5c625e] hover:text-[#1c201e] hover:bg-black/[0.03] transition-all">Products</a>
                    <a href="{{ route('stores.index') }}" class="h-full flex items-center px-3.5 text-[12px] font-medium text-[#5c625e] hover:text-[#1c201e] hover:bg-black/[0.03] transition-all">Stores</a>
                    <a href="{{ route('services.index') }}" class="h-full flex items-center px-3.5 text-[12px] font-medium text-[#5c625e] hover:text-[#1c201e] hover:bg-black/[0.03] transition-all">Services</a>
                    <a href="{{ route('rentals.index') }}" class="h-full flex items-center px-3.5 text-[12px] font-medium text-[#5c625e] hover:text-[#1c201e] hover:bg-black/[0.03] transition-all">Rentals</a>
                </nav>

                <div class="ml-auto flex items-center gap-2 text-[11px]">
                    @auth
                        @if(!($userStore ?? null))
                            <a href="{{ route('seller.store.create') }}" class="font-semibold text-[#9acd32] hover:text-[#7ca81d] hover:underline">Open Your Store</a>
                        @else
                            <a href="{{ route('seller.dashboard') }}" class="font-semibold text-[#9acd32] hover:text-[#7ca81d] hover:underline">Seller Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-[#7ca81d] text-white font-bold rounded-full hover:bg-[#7ca81d] transition-colors">
                            Start Selling
                            <i class="fa-solid fa-arrow-right text-[14px]" style=""></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>
    </div>

    {{-- ============ MOBILE BOTTOM-SHEET MENU ============ --}}
    <div x-show="mobileMenu" x-cloak
         class="fixed inset-0 z-[60] sm:hidden"
         @keydown.escape.window="mobileMenu = false">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"
             @click="mobileMenu = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        {{-- Bottom sheet panel --}}
        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-[28px] shadow-2xl max-h-[88vh] flex flex-col overflow-hidden"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full">

            {{-- Drag handle --}}
            <div class="shrink-0 flex justify-center pt-3 pb-1" @click="mobileMenu = false">
                <div class="w-10 h-1 rounded-full bg-[#d0d4d0]"></div>
            </div>

            {{-- User / Guest hero area --}}
            @auth
                @php
                    $user = auth()->user();
                    $userStore = $user->store;
                    $isSeller = $user->store !== null;
                @endphp
                <div class="px-5 pt-3 pb-4 shrink-0">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl overflow-hidden bg-[#f2f9df] ring-2 ring-[#9acd32]/20 shrink-0 flex items-center justify-center">
                            @if($userStore && $userStore->logo)
                                <img src="{{ $userStore->logo_url }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-[15px] font-black text-[#9acd32]">{{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <p class="text-[14px] font-bold text-[#1c201e] truncate">{{ $user->name ?? 'User' }}</p>
                                @if($isSeller)
                                    <span class="shrink-0 text-[8.5px] font-extrabold text-amber-600 bg-amber-50 px-1.5 py-0.5 rounded-md border border-amber-200/60">SELLER</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-[#9aa19c] truncate mt-0.5">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('home') }}" @click="mobileMenu = false"
                           class="shrink-0 w-9 h-9 rounded-xl bg-[#f5f6f5] grid place-items-center text-[#5c625e]">
                            <i class="fa-solid fa-user-gear text-[18px]"></i>
                        </a>
                    </div>
                    @if($isSeller)
                    <a href="{{ route('seller.dashboard') }}" @click="mobileMenu = false"
                       class="mt-3 flex items-center justify-center gap-2 w-full py-2.5 rounded-2xl bg-[#9acd32] text-[#1c201e] text-[13px] font-bold active:scale-[0.98] transition-transform">
                        <i class="fa-solid fa-gauge-high text-[16px]" style=""></i>
                        Seller Dashboard
                    </a>
                    @else
                    <a href="{{ route('seller.store.create') }}" @click="mobileMenu = false"
                       class="mt-3 flex items-center justify-center gap-2 w-full py-2.5 rounded-2xl border-2 border-dashed border-[#9acd32]/40 text-[#7ca81d] text-[13px] font-bold active:scale-[0.98] transition-transform">
                        <i class="fa-solid fa-store text-[16px]" style=""></i>
                        Open Your Store
                    </a>
                    @endif
                </div>
            @else
                <div class="px-5 pt-3 pb-4 shrink-0">
                    <p class="text-[12px] font-semibold text-[#6b716c] mb-3">Join Cameroon's marketplace</p>
                    <div class="grid grid-cols-2 gap-2.5">
                        <a href="{{ route('register') }}" @click="mobileMenu = false"
                           class="flex items-center justify-center gap-1.5 py-3 bg-[#9acd32] text-[#1c201e] text-[13px] font-bold rounded-2xl active:scale-[0.98] transition-transform">
                            <i class="fa-solid fa-user-plus text-[16px]" style=""></i>
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" @click="mobileMenu = false"
                           class="flex items-center justify-center gap-1.5 py-3 border border-[#e4e7e4] text-[#3f453f] text-[13px] font-bold rounded-2xl active:scale-[0.98] transition-transform">
                            <i class="fa-solid fa-right-to-bracket text-[16px]"></i>
                            Sign In
                        </a>
                    </div>
                </div>
            @endauth

            {{-- Divider --}}
            <div class="h-px bg-[#f0f2f0] mx-5 shrink-0"></div>

            {{-- ============ INSTALL APP CARD ============ --}}
            <button x-show="!installed"
                    x-cloak
                    @click="openOnboarding()"
                    class="shrink-0 mx-5 mt-3 mb-1 text-left flex items-center gap-3.5 px-4 py-3.5 rounded-2xl border border-[#9acd32]/25 bg-[#f2f9df] group active:scale-[0.98] transition-all"
                    x-transition:enter="transition ease-out duration-400"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                <span class="relative shrink-0 grid place-items-center w-11 h-11 rounded-2xl bg-[#9acd32] text-[#1c201e] shadow-lg shadow-[#9acd32]/30">
                    <i class="fa-solid fa-download text-[20px] group-hover:animate-bounce" style=""></i>
                    <span class="absolute -top-1 -right-1 w-3 h-3 rounded-full bg-white grid place-items-center">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#dc2626] animate-pulse"></span>
                    </span>
                </span>
                <span class="min-w-0 flex-1">
                    <span class="block text-[13px] font-bold text-[#1c201e]">Get the Izifai App</span>
                    <span class="block text-[10.5px] text-[#6b716c] mt-0.5"
                          x-text="isIOS ? 'Tap share, then Add to Home Screen' : 'Install &amp; shop instantly'"></span>
                </span>
                <i class="fa-solid fa-chevron-right text-[14px] text-[#9acd32] shrink-0 transition-transform group-hover:translate-x-0.5"></i>
            </button>

            {{-- Scrollable nav links --}}
            <div class="flex-1 overflow-y-auto no-scrollbar px-3 py-3">

                {{-- Browse section --}}
                <p class="text-[9.5px] font-extrabold uppercase tracking-[0.12em] text-[#b0b6b1] px-3 mb-2">Browse</p>
                <div class="grid grid-cols-2 gap-1.5 mb-4">
                    @php
                        $mobileNavItems = [
                            ['icon' => 'fa-house', 'label' => 'Home', 'route' => route('home')],
                            ['icon' => 'fa-bag-shopping', 'label' => 'Products', 'route' => route('products.index')],
                            ['icon' => 'fa-store', 'label' => 'Stores', 'route' => route('stores.index')],
                            ['icon' => 'fa-screwdriver-wrench', 'label' => 'Services', 'route' => route('services.index')],
                            ['icon' => 'fa-warehouse', 'label' => 'Rentals', 'route' => route('rentals.index')],
                        ];
                    @endphp
                    @foreach($mobileNavItems as $item)
                    <a href="{{ $item['route'] }}" @click="mobileMenu = false"
                       class="flex items-center gap-3 px-3.5 py-3.5 rounded-2xl bg-[#f8f9f8] hover:bg-[#f2f9df] hover:text-[#7ca81d] transition-all active:scale-[0.97] group">
                        <span class="grid place-items-center w-8 h-8 rounded-xl bg-white shadow-sm shrink-0">
                            <i class="fa-solid {{ $item['icon'] }} text-[18px] text-[#9acd32]"></i>
                        </span>
                        <span class="text-[13px] font-semibold text-[#2e332f] group-hover:text-[#7ca81d] truncate">{{ $item['label'] }}</span>
                    </a>
                    @endforeach
                </div>

                @auth
                {{-- Account section --}}
                <p class="text-[9.5px] font-extrabold uppercase tracking-[0.12em] text-[#b0b6b1] px-3 mb-2">My Account</p>
                <div class="space-y-1 mb-3">
                    <a href="{{ route('favorites.index') }}" @click="mobileMenu = false"
                       class="flex items-center gap-3 px-3.5 py-3 rounded-2xl hover:bg-[#f2f9df] transition-all active:scale-[0.98] group">
                        <i class="fa-solid fa-heart text-[20px] text-[#9aa19c] group-hover:text-[#9acd32]" style=""></i>
                        <span class="text-[13px] font-semibold text-[#3f453f] group-hover:text-[#7ca81d]">Saved Items</span>
                    </a>
                    <a href="{{ route('conversations.index') }}" @click="mobileMenu = false"
                       class="flex items-center gap-3 px-3.5 py-3 rounded-2xl hover:bg-[#f2f9df] transition-all active:scale-[0.98] group">
                        <i class="fa-solid fa-comment text-[20px] text-[#9aa19c] group-hover:text-[#9acd32]" style=""></i>
                        <span class="text-[13px] font-semibold text-[#3f453f] group-hover:text-[#7ca81d]">Messages</span>
                        <span class="unread-badge hidden ml-auto min-w-[18px] h-[18px] bg-[#dc2626] text-white text-[9px] font-bold rounded-full flex items-center justify-center leading-none px-1">0</span>
                    </a>
                    <a href="{{ route('notifications.index') }}" @click="mobileMenu = false"
                       class="flex items-center gap-3 px-3.5 py-3 rounded-2xl hover:bg-[#f2f9df] transition-all active:scale-[0.98] group">
                        <i class="fa-solid fa-bell text-[20px] text-[#9aa19c] group-hover:text-[#9acd32]" style=""></i>
                        <span class="text-[13px] font-semibold text-[#3f453f] group-hover:text-[#7ca81d]">Notifications</span>
                        <span class="notif-badge hidden ml-auto min-w-[18px] h-[18px] bg-[#dc2626] text-white text-[9px] font-bold rounded-full flex items-center justify-center leading-none px-1">0</span>
                    </a>
                </div>
                @endauth
            </div>

            {{-- Bottom logout / safe area --}}
            @auth
            <div class="shrink-0 px-5 pt-3 pb-5 border-t border-[#f0f2f0] safe-area-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2.5 text-[13px] font-semibold text-[#dc2626] hover:opacity-80 transition-opacity">
                        <i class="fa-solid fa-right-from-bracket text-[18px]"></i>
                        Log Out
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    {{-- ============ PWA INSTALL ONBOARDING ============ --}}
    <div x-show="onboarding" x-cloak
         class="fixed inset-0 z-[100] flex items-end sm:items-center justify-center sm:p-6"
         @keydown.escape.window="closeOnboarding()"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-[#1c201e]/70 backdrop-blur-md"
             @click="closeOnboarding()"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"></div>

        {{-- Card --}}
        <div class="relative w-full max-w-[360px] bg-white sm:rounded-[32px] rounded-t-[32px] shadow-2xl overflow-hidden"
             x-transition:enter="transition ease-out duration-500 delay-100"
             x-transition:enter-start="opacity-0 translate-y-12 sm:translate-y-0 sm:scale-90"
             x-transition:enter-end="opacity-100 translate-y-0 sm:translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-12 sm:translate-y-0 sm:scale-90">

            {{-- Top accent bar --}}
            <div class="h-1 w-full bg-gradient-to-r from-[#9acd32] via-[#659316] to-[#9acd32]"></div>

            <div class="px-6 pt-7 pb-8 sm:p-8 text-center">

                {{-- Logo: clean wordmark + small app-icon tile --}}
                <div class="mx-auto mb-5 animate-pop-in">
                    <div class="flex flex-col items-center gap-3.5 animate-floaty">
                        <x-application-logo class="h-9 sm:h-10 w-auto" />
                        <span class="inline-flex items-center gap-2 rounded-full bg-white border border-[#eef1ee] shadow-sm pl-1 pr-3.5 py-1">
                            <span class="w-7 h-7 rounded-lg overflow-hidden ring-1 ring-black/5 shadow-sm shrink-0">
                                <img src="{{ asset('icons/icon-192.png') }}" alt="Izifai app icon" class="w-full h-full object-cover">
                            </span>
                            <span class="text-[10px] font-bold text-[#3f453f] tracking-tight">iziFaii App</span>
                        </span>
                    </div>
                </div>

                <h2 class="text-[17px] font-bold text-[#1c201e] mb-1 animate-pop-in" style="animation-delay:0.15s;">Get the Izifai App</h2>
                <p class="text-[11.5px] text-[#6b716c] leading-relaxed mb-6 animate-pop-in" style="animation-delay:0.2s;">
                    Shop, sell & manage your store — all in your pocket.
                </p>

                {{-- Features --}}
                <div class="space-y-3 mb-7">
                    <div class="animate-feature-1 flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#f8f9f8] text-left">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-[#9acd32]/15 shrink-0">
                            <i class="fa-solid fa-bag-shopping text-[16px] text-[#659316]"></i>
                        </span>
                        <span class="text-[12px] font-semibold text-[#2e332f]">Browse & buy from local sellers instantly</span>
                    </div>
                    <div class="animate-feature-2 flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#f8f9f8] text-left">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-[#9acd32]/15 shrink-0">
                            <i class="fa-solid fa-bolt text-[16px] text-[#659316]"></i>
                        </span>
                        <span class="text-[12px] font-semibold text-[#2e332f]">Lightning-fast — loads instantly from your home screen</span>
                    </div>
                    <div class="animate-feature-3 flex items-center gap-3 px-4 py-3 rounded-2xl bg-[#f8f9f8] text-left">
                        <span class="grid place-items-center w-9 h-9 rounded-xl bg-[#9acd32]/15 shrink-0">
                            <i class="fa-solid fa-bell text-[16px] text-[#659316]"></i>
                        </span>
                        <span class="text-[12px] font-semibold text-[#2e332f]">Get notified the moment a buyer messages you</span>
                    </div>
                </div>

                {{-- iOS instructions (shown only on iOS) --}}
                <div x-show="isIOS" class="mb-6 animate-feature-2">
                    <p class="text-[11px] font-semibold text-[#6b716c] uppercase tracking-wider mb-3">How to install</p>
                    <div class="flex items-center justify-center gap-3">
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="w-10 h-10 rounded-xl bg-[#f5f6f5] border border-[#e4e7e4] grid place-items-center">
                                <i class="fa-solid fa-arrow-up-from-bracket text-[16px] text-[#659316]"></i>
                            </span>
                            <span class="text-[10px] font-semibold text-[#3f453f]">Tap Share</span>
                        </div>
                        <i class="fa-solid fa-arrow-right text-[12px] text-[#b0b6b1]"></i>
                        <div class="flex flex-col items-center gap-1.5">
                            <span class="w-10 h-10 rounded-xl bg-[#f5f6f5] border border-[#e4e7e4] grid place-items-center">
                                <i class="fa-solid fa-plus text-[16px] text-[#659316]"></i>
                            </span>
                            <span class="text-[10px] font-semibold text-[#3f453f]">Add to Home Screen</span>
                        </div>
                    </div>
                </div>

                {{-- Install / Got it button --}}
                <button @click="install()"
                        class="w-full py-3.5 rounded-2xl text-[13px] font-bold transition-all active:scale-[0.98]"
                        :class="isIOS ? 'bg-[#1c201e] text-white shadow-lg shadow-[#1c201e]/15' : 'bg-[#9acd32] text-[#1c201e] shadow-lg shadow-[#9acd32]/30'">
                    <span x-show="!isIOS" class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-download text-[14px]"></i>
                        Install Now
                    </span>
                    <span x-show="isIOS" class="inline-flex items-center gap-2">
                        <i class="fa-solid fa-check text-[14px]"></i>
                        Got It
                    </span>
                </button>
            </div>

            {{-- Close button --}}
            <button @click="closeOnboarding()"
                    class="absolute top-4 right-4 w-8 h-8 rounded-full bg-black/5 hover:bg-black/10 grid place-items-center transition-colors"
                    aria-label="Close">
                <i class="fa-solid fa-xmark text-[14px] text-[#6b716c]"></i>
            </button>
        </div>
    </div>

    {{-- ============ SEARCH OVERLAY ============ --}}
    <div x-data="globalSearch()"
         @open-search.window="searchOpen = true; $nextTick(() => $refs.searchInput?.focus())"
         @keydown.escape.window="searchOpen = false"
         x-show="searchOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-250"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-14 sm:top-[144px] inset-x-0 bottom-0 z-40 bg-black/50 backdrop-blur-sm"
         @click="searchOpen = false">
        <div @click.stop
             class="flex flex-col h-full sm:h-auto sm:max-h-[82vh] sm:mx-auto sm:mt-4 sm:max-w-4xl sm:rounded-2xl sm:shadow-2xl bg-white overflow-hidden border-t sm:border border-[#e8eae8]"
             x-transition:enter="transition ease-out duration-250"
             x-transition:enter-start="opacity-0 -translate-y-3 sm:scale-[0.98]"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 -translate-y-3 sm:scale-[0.98]">

            {{-- Header --}}
            <div class="shrink-0 border-b border-[#eff1ef]">
                <div class="flex items-center gap-3 px-4 sm:px-6 h-14 sm:h-16">
                    <button @click="searchOpen = false" class="sm:hidden p-1.5 -ml-1.5 text-[#5c625e] hover:text-[#1c201e] rounded-xl hover:bg-[#f5f6f5] transition-all">
                        <i class="fa-solid fa-arrow-left text-[20px]"></i>
                    </button>
                    <div class="hidden sm:flex items-center gap-2.5 shrink-0 mr-1">
                        <x-application-logo class="w-7 h-7" />
                        <span class="text-[11px] font-bold text-[#9acd32] uppercase tracking-[0.12em]">Search</span>
                    </div>
                    <div class="flex-1 relative">
                        <i class="fa-solid fa-magnifying-glass text-[20px] text-[#9acd32] absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                        <input x-ref="searchInput" x-model="query" @input.debounce.150ms="search()"
                               type="text" x-bind:placeholder="placeholderText"
                               class="w-full h-10 sm:h-11 pl-11 pr-4 text-sm sm:text-[15px] focus:outline-none placeholder:text-[#b9beb9] font-medium text-[#1c201e]"
                               style="border-radius:9999px;background:#f5f6f5;border:1.5px solid #e4e7e4;transition:all 0.2s"
                               @focus=" $el.style.borderColor='#9acd32'; $el.style.background='#fff' "
                               @blur=" $el.style.borderColor='#e4e7e4'; $el.style.background='#f5f6f5' ">
                    </div>
                    <button x-show="query.length > 0"
                            @click="query = ''; results = { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] }"
                            x-cloak
                            class="p-1.5 text-[#9aa19c] hover:text-[#3f453f] rounded-full hover:bg-[#f5f6f5] transition-all">
                        <i class="fa-solid fa-xmark text-[18px]"></i>
                    </button>
                    <button @click="searchOpen = false; results = { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] }; query = ''"
                            class="hidden sm:inline-flex text-sm font-semibold text-[#5c625e] hover:text-[#1c201e] px-4 py-1.5 rounded-full hover:bg-[#f5f6f5] transition-all shrink-0">
                        Cancel
                    </button>
                </div>
            </div>

            {{-- Scope Tabs --}}
            <div class="shrink-0 px-4 sm:px-6 py-2.5 border-b border-[#f0f2f0] bg-white/80 backdrop-blur-sm">
                <div class="flex items-center gap-1">
                    <template x-for="tab in ['products', 'services', 'rentals']" :key="tab">
                        <button @click="switchScope(tab)"
                                class="px-4 py-1.5 rounded-full text-[11px] font-bold transition-all capitalize"
                                :class="scope === tab ? 'bg-[#9acd32] text-white shadow-sm' : 'text-[#5c625e] hover:text-[#1c201e] hover:bg-[#f5f6f5]'"
                                x-text="tab"></button>
                    </template>
                </div>
            </div>

            {{-- Body --}}
            <div class="flex-1 overflow-y-auto no-scrollbar">
                {{-- Pre-search state (empty input) --}}
                <div x-show="query.length < 2 && !loading" class="px-5 sm:px-8 py-8 sm:py-10">
                    <div class="max-w-3xl mx-auto">
                        {{-- Brand intro --}}
                        <div class="mb-8 sm:mb-10">
                            <p class="text-sm text-[#6b716c] max-w-md" x-text="'Discover ' + scope + ' from stores across Cameroon.'"></p>
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-start gap-8 sm:gap-12">
                            <div class="flex-1">
                                <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.1em] mb-4">Trending Searches</p>
                                <div class="flex flex-wrap gap-2" x-show="trending.length">
                                    <template x-for="item in trending" :key="item.id">
                                        <a :href="item.url" @click="searchOpen = false"
                                           class="px-4 py-2 bg-[#f5f6f5] hover:bg-[#f2f9df] hover:text-[#7ca81d] text-[12px] font-semibold text-[#5c625e] rounded-full transition-all cursor-pointer"
                                           x-text="item.name"></a>
                                    </template>
                                </div>
                                <p x-show="!trending.length" class="text-sm text-[#c9cdc9] italic">Loading...</p>
                            </div>
                            <div class="flex-1 sm:max-w-xs">
                                <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.1em] mb-4">Browse Categories</p>
                                <div class="space-y-1">
                                    <a :href="scopeRoute" @click="searchOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f2f9df] transition-all text-sm font-medium text-[#3f453f] hover:text-[#7ca81d]">
                                        <i class="fa-solid fa-tags text-[18px] text-[#9acd32]"></i>
                                        <span x-text="'All ' + scope.charAt(0).toUpperCase() + scope.slice(1)"></span>
                                    </a>
                                    <a href="{{ route('stores.index') }}" @click="searchOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f2f9df] transition-all text-sm font-medium text-[#3f453f] hover:text-[#7ca81d]">
                                        <i class="fa-solid fa-store text-[18px] text-[#9acd32]"></i>
                                        All Stores
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Loading --}}
                <div x-show="loading" class="px-6 py-20 text-center">
                    <svg class="w-7 h-7 mx-auto animate-spin text-[#9acd32] mb-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <p class="text-sm text-[#6b716c]">Searching <span class="text-[#1c201e] font-medium" x-text="query"></span>&hellip;</p>
                </div>

                {{-- Results --}}
                <div x-show="!loading && query.length >= 2" class="pb-4">
                    <template x-if="hasResults">
                        <div class="sm:grid sm:grid-cols-5 sm:gap-0">
                            {{-- Left column: Primary results (Products / Services / Rentals) --}}
                            <div class="sm:col-span-3 sm:border-r sm:border-[#f0f2f0]">
                                {{-- Products --}}
                                <template x-if="scope === 'products' && results.products.length">
                                    <div class="px-4 sm:px-6 pt-4 pb-2">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em]">Products</p>
                                            <a :href="'/search?q=' + encodeURIComponent(query) + '&scope=products'" @click="searchOpen = false" class="text-[11px] font-semibold text-[#9acd32] hover:text-[#7ca81d] transition-colors">View All</a>
                                        </div>
                                        <div class="space-y-1">
                                            <template x-for="product in results.products" :key="product.id">
                                                <a :href="product.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3.5 px-3 py-3 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-3 group">
                                                    <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-xl bg-[#f0f2f0] overflow-hidden shrink-0 ring-1 ring-black/5">
                                                        <img x-show="product.image" :src="'/r2/' + product.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="">
                                                        <div x-show="!product.image" class="w-full h-full flex items-center justify-center text-[#c9cdc9]">
                                                            <i class="fa-solid fa-image text-[18px]"></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-[#3f453f] truncate group-hover:text-[#1c201e] transition-colors" x-text="product.name"></p>
                                                        <p class="text-[11px] text-[#9aa19c]" x-text="product.category"></p>
                                                    </div>
                                                    <p class="text-xs font-bold text-[#9acd32] shrink-0 whitespace-nowrap" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                {{-- Services --}}
                                <template x-if="scope === 'services' && results.services.length">
                                    <div class="px-4 sm:px-6 pt-4 pb-2">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em]">Services</p>
                                            <a :href="'/search?q=' + encodeURIComponent(query) + '&scope=services'" @click="searchOpen = false" class="text-[11px] font-semibold text-[#9acd32] hover:text-[#7ca81d] transition-colors">View All</a>
                                        </div>
                                        <div class="space-y-1">
                                            <template x-for="service in results.services" :key="service.id">
                                                <a :href="service.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3.5 px-3 py-3 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-3 group">
                                                    <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-xl bg-[#f0f2f0] overflow-hidden shrink-0 ring-1 ring-black/5">
                                                        <img x-show="service.image" :src="service.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="">
                                                        <div x-show="!service.image" class="w-full h-full flex items-center justify-center text-[#c9cdc9]">
                                                            <i class="fa-solid fa-image text-[18px]"></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-[#3f453f] truncate group-hover:text-[#1c201e] transition-colors" x-text="service.name"></p>
                                                        <p class="text-[11px] text-[#9aa19c]" x-text="service.category"></p>
                                                    </div>
                                                    <p class="text-xs font-bold text-[#9acd32] shrink-0 whitespace-nowrap" x-text="'From ' + Number(service.price).toLocaleString() + ' FCFA'"></p>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                {{-- Rentals --}}
                                <template x-if="scope === 'rentals' && results.rentals.length">
                                    <div class="px-4 sm:px-6 pt-4 pb-2">
                                        <div class="flex items-center justify-between mb-3">
                                            <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em]">Rentals</p>
                                            <a :href="'/rentals?search=' + encodeURIComponent(query)" @click="searchOpen = false" class="text-[11px] font-semibold text-[#9acd32] hover:text-[#7ca81d] transition-colors">View All</a>
                                        </div>
                                        <div class="space-y-1">
                                            <template x-for="item in results.rentals" :key="item.id">
                                                <a :href="item.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3.5 px-3 py-3 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-3 group">
                                                    <div class="w-12 h-12 sm:w-10 sm:h-10 rounded-xl bg-[#f0f2f0] overflow-hidden shrink-0 ring-1 ring-black/5">
                                                        <img x-show="item.image" :src="item.image" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="">
                                                        <div x-show="!item.image" class="w-full h-full flex items-center justify-center text-[#c9cdc9]">
                                                            <i class="fa-solid fa-image text-[18px]"></i>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-[#3f453f] truncate group-hover:text-[#1c201e] transition-colors" x-text="item.name"></p>
                                                        <p class="text-[11px] text-[#9aa19c]" x-text="item.category"></p>
                                                    </div>
                                                    <p class="text-xs font-bold text-[#9acd32] shrink-0 whitespace-nowrap" x-text="Number(item.rate).toLocaleString() + ' FCFA/' + item.billing_unit"></p>
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
                                        <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em] mb-2.5">Categories</p>
                                        <div class="space-y-0.5">
                                            <template x-for="cat in results.categories" :key="cat.id">
                                                <a :href="cat.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-2">
                                                    <span class="w-7 h-7 rounded-lg bg-[#9acd32]/10 flex items-center justify-center text-[#9acd32] shrink-0">
                                                        <i class="fa-solid fa-tags text-[14px]"></i>
                                                    </span>
                                                    <span class="text-sm font-semibold text-[#3f453f]" x-text="cat.name"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.stores.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em] mb-2.5">Stores</p>
                                        <div class="space-y-0.5">
                                            <template x-for="store in results.stores" :key="store.id">
                                                <a :href="store.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-2">
                                                    <div class="w-7 h-7 rounded-lg bg-[#f0f2f0] overflow-hidden shrink-0 flex items-center justify-center">
                                                        <img x-show="store.logo" :src="store.logo_url" class="w-full h-full object-cover" alt="">
                                                        <span x-show="!store.logo" class="text-[9px] font-bold text-[#9aa19c]" x-text="store.name.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-[#3f453f] truncate" x-text="store.name"></p>
                                                    </div>
                                                    <span x-show="store.is_verified" class="text-[#659316] shrink-0">
                                                        <i class="fa-solid fa-circle-check text-[14px]" style=""></i>
                                                    </span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.locations.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em] mb-2.5">Locations</p>
                                        <div class="space-y-0.5">
                                            <template x-for="loc in results.locations" :key="loc.name">
                                                <a :href="'/stores?location=' + encodeURIComponent(loc.name)" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-2">
                                                    <span class="w-7 h-7 rounded-lg bg-[#9acd32]/10 flex items-center justify-center text-[#9acd32] shrink-0">
                                                        <i class="fa-solid fa-location-dot text-[14px]"></i>
                                                    </span>
                                                    <span class="text-sm font-semibold text-[#3f453f]" x-text="loc.name"></span>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="results.users.length">
                                    <div class="px-4 sm:px-6 pt-3 pb-2">
                                        <p class="text-[11px] font-bold text-[#9aa19c] uppercase tracking-[0.08em] mb-2.5">People</p>
                                        <div class="space-y-0.5">
                                            <template x-for="user in results.users" :key="user.id">
                                                <a :href="user.url" @click="searchOpen = false"
                                                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl hover:bg-[#f5f6f5] active:bg-[#ededee] transition-all -mx-2">
                                                    <div class="w-7 h-7 rounded-lg bg-[#9acd32]/10 flex items-center justify-center text-[#9acd32] font-bold text-[10px] shrink-0">
                                                        <span x-text="user.name.charAt(0).toUpperCase()"></span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-semibold text-[#3f453f] truncate" x-text="user.name"></p>
                                                        <p class="text-[11px] text-[#9aa19c] truncate" x-show="user.store" x-text="user.store"></p>
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
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-[#f0f2f0] flex items-center justify-center ring-1 ring-black/5">
                            <i class="fa-solid fa-magnifying-glass-minus text-[24px] text-[#c9cdc9]"></i>
                        </div>
                        <p class="text-base font-bold text-[#1c201e]">No results for "<span class="text-[#9acd32]" x-text="query"></span>"</p>
                        <p class="text-sm text-[#6b716c] mt-1.5 max-w-xs mx-auto leading-relaxed">Try different keywords, check your spelling, or browse categories.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ MAIN CONTENT ============ --}}
    <main class="min-h-screen bg-[#f5f6f5] pt-[57px] sm:pt-[160px] pb-[72px] sm:pb-0">
        {{-- Left sidebar (store show page) --}}
        @hasSection('store-sidebar')
            <aside class="fixed left-0 top-[100px] sm:top-[108px] h-[calc(100vh-100px)] sm:h-[calc(100vh-108px)] w-[260px] bg-white border-r border-[#eff1ef] shadow-sm z-30 hidden lg:block overflow-y-auto no-scrollbar">
                @yield('store-sidebar')
            </aside>
            <div class="lg:ml-[260px]">
        @endif

        {{-- Store nav bar (mobile: fixed below header, desktop: static or hidden when sidebar exists) --}}
        @hasSection('store-nav')
            <div class="fixed lg:static top-[100px] sm:top-[108px] left-0 right-0 z-30 bg-white border-b border-[#eff1ef] shadow-sm overflow-x-auto no-scrollbar @hasSection('store-sidebar') lg:hidden @endif">
                <div class="max-w-7xl mx-auto px-5 sm:px-8">
                    @yield('store-nav')
                </div>
            </div>
        @endif

        @include('partials.toasts')

        @yield('content')

        @hasSection('store-sidebar')
            </div>
        @endif
    </main>

    {{-- ============ FOOTER ============ --}}
    @hasSection('footer')
        @yield('footer')
    @else
    <footer class="bg-white border-t border-[#eceeec] pb-[72px] sm:pb-0">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-12 sm:py-16">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                <div class="col-span-2 md:col-span-1">
                    <a href="/" class="inline-block transition-opacity hover:opacity-80">
                        <x-application-logo class="h-7" />
                    </a>
                    <p class="text-xs text-[#6b716c] max-w-xs mt-3 leading-relaxed">
                        Cameroon's marketplace — buy products, book services, rent equipment, and sell your own catalog in one link.
                    </p>
                    <div class="flex items-center gap-2 mt-5">
                        @hasSection('storeWhatsApp')
                            <a href="https://wa.me/{{ wa_url(($__env->yieldContent('storeWhatsApp'))) }}?text={{ urlencode('Hi, I saw your store on Izifai.') }}" target="_blank"
                               class="inline-flex items-center gap-1.5 text-[11px] font-bold text-white bg-[#7ca81d] px-3.5 py-2 rounded-full hover:bg-[#7ca81d] transition-colors">
                                <i class="fa-solid fa-comment text-[14px]"></i> Contact
                            </a>
                        @else
                            <a href="https://chat.whatsapp.com/J3of97nRhL5IdTSXpScYLl" target="_blank"
                               class="inline-flex items-center gap-1.5 text-[11px] font-bold text-white bg-[#7ca81d] px-3.5 py-2 rounded-full hover:bg-[#7ca81d] transition-colors">
                                <i class="fa-solid fa-users text-[14px]"></i> Community
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.12em] text-[#9aa19c] mb-4">Marketplace</p>
                    <div class="space-y-2.5">
                        <a href="{{ route('home') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Home</a>
                        <a href="{{ route('products.index') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Products</a>
                        <a href="{{ route('stores.index') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Stores</a>
                        <a href="{{ route('services.index') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Services</a>
                        <a href="{{ route('rentals.index') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Rentals</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.12em] text-[#9aa19c] mb-4">Account</p>
                    <div class="space-y-2.5">
                        @auth
                            @php $userStore = auth()->user()->store; @endphp
                            <a href="{{ route('notifications.index') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Notifications</a>
                            @if($userStore)
                                <a href="{{ route('seller.dashboard') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Seller Dashboard</a>
                            @else
                                <a href="{{ route('seller.store.create') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Open Your Store</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Log In</a>
                            <a href="{{ route('register') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Create Account</a>
                            <a href="{{ route('register') }}" class="block text-[13px] font-medium text-[#3f453f] hover:text-[#9acd32] transition-colors">Start Selling</a>
                        @endauth
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-extrabold uppercase tracking-[0.12em] text-[#9aa19c] mb-4">Why Izifai</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#3f453f] bg-[#f5f6f5] border border-[#e8eae8] px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-shield-halved text-[14px] text-[#9acd32]"></i> Verified sellers
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#3f453f] bg-[#f5f6f5] border border-[#e8eae8] px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-comment-dots text-[14px] text-[#9acd32]"></i> Direct seller chat
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold text-[#3f453f] bg-[#f5f6f5] border border-[#e8eae8] px-3 py-1.5 rounded-full">
                            <i class="fa-solid fa-location-dot text-[14px] text-[#9acd32]"></i> Made in Cameroon
                        </span>
                    </div>
                    <p class="text-[11px] text-[#6b716c] mt-5 leading-relaxed">
                        Trusted by {{ number_format(\App\Models\Store::count()) }}+ sellers across Cameroon.
                    </p>
                </div>
            </div>
            <div class="mt-10 pt-6 border-t border-[#eff1ef] flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-[11px] text-[#9aa19c]">&copy; {{ date('Y') }} Izifai. Simplify Your Shopping.</p>
                <span class="text-[11px] text-[#9aa19c] inline-flex items-center gap-1">
                    <i class="fa-solid fa-location-dot text-[13px] text-[#9acd32]" style=""></i>
                    Made in Cameroon
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
             class="back-to-top-btn fixed bottom-[76px] sm:bottom-6 right-6 z-40 w-11 h-11 rounded-2xl flex items-center justify-center transition-all duration-200 hover:scale-110 active:scale-95 group">
        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
    </button>

    <script>
        function globalSearch() {
            return {
                query: '',
                scope: 'products',
                results: { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] },
                searchOpen: false,
                loading: false,
                trending: [],
                get placeholderText() {
                    const map = { products: 'Search products, stores...', services: 'Search services, professionals...', rentals: 'Search rental items...' };
                    return map[this.scope] || 'Search products, stores...';
                },
                get hasResults() {
                    return Object.values(this.results).some(arr => arr.length > 0);
                },
                get primaryResults() {
                    return this.results[this.scope] || [];
                },
                get scopeRoute() {
                    const map = { products: '/products', services: '/services', rentals: '/rentals' };
                    return map[this.scope] || '/products';
                },
                switchScope(newScope) {
                    if (newScope === this.scope) return;
                    this.scope = newScope;
                    this.results = { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] };
                    fetch('/search/trending?scope=' + newScope).then(r => r.json()).then(data => { this.trending = data; }).catch(() => {});
                    if (this.query.trim().length >= 2) this.search();
                },
                init() {
                    this.$watch('searchOpen', val => {
                        document.body.classList.toggle('overflow-hidden', val);
                        if (!val) {
                            this.query = '';
                            this.scope = 'products';
                            this.results = { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] };
                        }
                    });
                    fetch('/search/trending?scope=products').then(r => r.json()).then(data => { this.trending = data; }).catch(() => {});
                },
                search() {
                    const q = this.query.trim();
                    if (q.length < 1) { this.results = { products: [], services: [], rentals: [], stores: [], categories: [], locations: [], users: [] }; this.loading = false; return; }
                    this.loading = true;
                    fetch('/search/autocomplete?q=' + encodeURIComponent(q) + '&scope=' + this.scope)
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
            let origIconClass = icon ? icon.className : '';
            const origLabel = label ? label.textContent : '';

            function done() {
                if (icon) icon.className = origIconClass.replace(/(fa-(?:solid|regular|brands))\s+fa-[-a-z]+/, '$1 fa-check');
                if (label) label.textContent = successMsg || 'Copied!';
                setTimeout(() => {
                    if (icon) icon.className = origIconClass;
                    if (label) label.textContent = origLabel;
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

    <script>
        function guestLayout() {
            return {
                mobileMenu: false,
                onboarding: false,
                installReady: false,
                isIOS: false,
                installed: false,
                _prompt: null,

                init() {
                    this.isIOS = /iphone|ipad|ipod/i.test(navigator.userAgent) && !window.MSStream;
                    this.installed = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone === true;

                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        this._prompt = e;
                        this.installReady = true;
                    });

                    window.addEventListener('appinstalled', () => {
                        this._prompt = null;
                        this.installReady = false;
                        this.installed = true;
                        this.onboarding = false;
                    });

                    if ('serviceWorker' in navigator) {
                        window.addEventListener('load', () => {
                            navigator.serviceWorker.register('/sw.js').catch(() => {});
                        });
                    }
                },

                openOnboarding() {
                    this.mobileMenu = false;
                    this.onboarding = true;
                },

                closeOnboarding() {
                    this.onboarding = false;
                },

                install() {
                    if (this._prompt) {
                        this._prompt.prompt();
                        this._prompt.userChoice.then(() => {
                            this._prompt = null;
                            this.installReady = false;
                        });
                    }
                    this.onboarding = false;
                }
            };
        }
    </script>

    <script>
        window.autoScroll = function() {
            return {
                interval: null,
                init() {
                    const el = this.$el;
                    this.$nextTick(() => {
                        this.start(el);
                        el.addEventListener('mouseenter', () => this.stop());
                        el.addEventListener('mouseleave', () => this.start(el));
                    });
                },
                start(el) {
                    this.stop();
                    this.interval = setInterval(() => {
                        if (!el || el.matches(':hover')) return;
                        const maxScroll = el.scrollWidth - el.clientWidth;
                        if (maxScroll <= 5) return;
                        const card = el.querySelector('.shrink-0');
                        const cardWidth = card ? card.offsetWidth : 160;
                        const gap = parseInt(getComputedStyle(el).gap) || 12;
                        const step = cardWidth + gap;
                        let target = el.scrollLeft + step;
                        if (target >= maxScroll - 5) target = 0;
                        el.scrollTo({ left: target, behavior: 'smooth' });
                    }, 4000);
                },
                stop() {
                    if (this.interval) { clearInterval(this.interval); this.interval = null; }
                }
            };
        };
    </script>

    {{-- ============ MOBILE BOTTOM TAB BAR ============ --}}
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-[#eceeec] sm:hidden safe-area-bottom shadow-[0_-2px_10px_rgba(0,0,0,0.04)]">
        <div class="flex items-stretch h-[60px]">
            @php
                $currentRoute = request()->route()?->getName() ?? '';
                $isActive = fn($prefix) => str_starts_with($currentRoute, $prefix);
                $homeOn = $isActive('home') && !$isActive('home.');
                $shopOn = $isActive('products.') || $isActive('rentals.') || $isActive('stores.');
                $chatOn = $isActive('conversations.');
                $profileOn = $isActive('seller.') || $isActive('login') || $isActive('register');
            @endphp

            {{-- Tab 1: Home --}}
            <a href="{{ route('home') }}"
               class="flex-1 flex flex-col items-center justify-center gap-1 py-1.5 {{ $homeOn ? 'text-[#9acd32]' : 'text-[#a0a6a1] hover:text-[#3f453f]' }} transition-colors">
                <i class="fa-solid fa-house text-[23px] leading-none" style=""></i>
                <span class="text-[9px] {{ $homeOn ? 'font-extrabold' : 'font-medium' }}">Home</span>
            </a>

            {{-- Tab 2: Shop --}}
            <a href="{{ route('products.index') }}"
               class="flex-1 flex flex-col items-center justify-center gap-1 py-1.5 {{ $shopOn ? 'text-[#9acd32]' : 'text-[#a0a6a1] hover:text-[#3f453f]' }} transition-colors">
                <i class="fa-solid fa-store text-[23px] leading-none" style=""></i>
                <span class="text-[9px] {{ $shopOn ? 'font-extrabold' : 'font-medium' }}">Shop</span>
            </a>

            {{-- Tab 3: Chat --}}
            <a href="{{ auth()->check() ? route('conversations.index') : route('login') }}"
               class="flex-1 flex flex-col items-center justify-center gap-1 py-1.5 {{ $chatOn ? 'text-[#9acd32]' : 'text-[#a0a6a1] hover:text-[#3f453f]' }} transition-colors">
                <span class="relative inline-flex items-center justify-center">
                    <i class="fa-solid fa-comment text-[23px] leading-none" style=""></i>
                    <span class="unread-badge hidden absolute -top-1 -right-2.5 min-w-[16px] h-[16px] bg-[#dc2626] text-white text-[9px] font-bold rounded-full flex items-center justify-center px-1 leading-none border border-white">0</span>
                </span>
                <span class="text-[9px] {{ $chatOn ? 'font-extrabold' : 'font-medium' }}">Chat</span>
            </a>

            {{-- Tab 4: Profile (Dashboard) --}}
            <a href="{{ auth()->check() ? route('seller.dashboard') : route('login') }}"
               class="flex-1 flex flex-col items-center justify-center gap-1 py-1.5 {{ $profileOn ? 'text-[#9acd32]' : 'text-[#a0a6a1] hover:text-[#3f453f]' }} transition-colors">
                <i class="fa-solid fa-user text-[23px] leading-none" style=""></i>
                <span class="text-[9px] {{ $profileOn ? 'font-extrabold' : 'font-medium' }}">Profile</span>
            </a>
        </div>
    </nav>

    @auth
    <script>
    (function() {
        var badges = document.querySelectorAll('.unread-badge');
        if (!badges.length) return;

        function updateCount() {
            fetch('{{ route('conversations.unread') }}')
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    var c = d.count || 0;
                    badges.forEach(function(b) {
                        b.textContent = c > 99 ? '99+' : c;
                        b.classList.toggle('hidden', c === 0);
                    });
                })
                .catch(function() {});
        }

        var notifBadges = document.querySelectorAll('.notif-badge');
        if (notifBadges.length) {
            function updateNotifCount() {
                fetch('{{ route('notifications.unread-count') }}')
                    .then(function(r) { return r.json(); })
                    .then(function(d) {
                        var c = d.unread_count || 0;
                        notifBadges.forEach(function(b) {
                            b.textContent = c > 99 ? '99+' : c;
                            b.classList.toggle('hidden', c === 0);
                        });
                    })
                    .catch(function() {});
            }
            updateNotifCount();
            setInterval(updateNotifCount, 30000);
        }

        updateCount();
        setInterval(updateCount, 30000);
    })();
    </script>
    @endauth

    @stack('scripts')
</body>
</html>