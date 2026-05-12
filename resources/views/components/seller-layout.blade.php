<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Seller Center' }} — IZIFAI SellerCenter</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#006d38",
                        "primary-container": "#00a859",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#003317",
                        "primary-fixed-dim": "#59df89",
                        surface: "#f4fcf1",
                        "surface-dim": "#d5dcd2",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#eef6eb",
                        "surface-container": "#e8f0e6",
                        "surface-container-high": "#e3eae0",
                        "surface-container-highest": "#dde5db",
                        "on-surface": "#161d17",
                        "on-surface-variant": "#3d4a3f",
                        "outline-variant": "#bccabc",
                        outline: "#6d7b6e",
                        error: "#ba1a1a",
                        "error-container": "#ffdad6",
                        background: "#f4fcf1",
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                    },
                    spacing: {
                        xs: "4px",
                        sm: "8px",
                        md: "16px",
                        lg: "24px",
                        xl: "32px",
                        "sidebar-width": "260px",
                        "header-height": "72px",
                        "grid-gutter": "20px",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    fontSize: {
                        "headline-xl": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "700" }],
                        "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "label-lg": ["14px", { lineHeight: "20px", fontWeight: "600" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "label-sm": ["11px", { lineHeight: "14px", fontWeight: "500" }],
                    },
                },
            },
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4fcf1; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="text-on-surface" x-data="{ sidebarOpen: false }">

    @php $sellerUser = auth()->user(); $sellerStore = $sellerUser->store; @endphp

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/30 backdrop-blur-sm lg:hidden transition-opacity"
         x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <!-- Sidebar -->
    <aside x-show="sidebarOpen" x-cloak
           class="fixed left-0 top-0 h-screen w-sidebar-width z-50 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] bg-surface flex flex-col py-lg transition-transform duration-300 lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           style="transition-property: transform;"
           @click.away="sidebarOpen = false">
        <div class="flex items-center justify-between px-6 mb-10">
            <div>
                <h1 class="text-headline-xl tracking-tighter text-primary">IZIFAI</h1>
                <p class="text-label-sm text-on-surface-variant mt-1 uppercase tracking-widest">SellerCenter</p>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden p-1 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <nav class="flex-1 px-2 space-y-1">
            <a href="{{ route('seller.dashboard') }}"
               class="{{ request()->routeIs('seller.dashboard') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.dashboard') ? '1' : '0' }};">home</span>
                <span class="font-label-lg">My Shop Home</span>
            </a>
            <a href="{{ route('seller.products.index') }}"
               class="{{ request()->routeIs('seller.products.*') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.products.*') ? '1' : '0' }};">inventory_2</span>
                <span class="font-label-lg">All My Items</span>
            </a>
            <a href="{{ route('seller.ads.index') }}"
               class="{{ request()->routeIs('seller.ads.*') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.ads.*') ? '1' : '0' }};">campaign</span>
                <span class="font-label-lg">Promote Items</span>
            </a>
            <a href="{{ route('seller.reviews') }}"
               class="{{ request()->routeIs('seller.reviews') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.reviews') ? '1' : '0' }};">reviews</span>
                <span class="font-label-lg">Customer Reviews</span>
            </a>
            <a href="{{ route('seller.store.settings') }}"
               class="{{ request()->routeIs('seller.store.settings') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.store.settings') ? '1' : '0' }};">settings</span>
                <span class="font-label-lg">Change Settings</span>
            </a>
        </nav>

        <div class="px-4 mt-auto space-y-6">
            <div class="flex items-center px-4 py-3 bg-surface-container rounded-2xl">
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-sm shrink-0 border-2 border-white">
                    {{ substr($sellerUser->name, 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="font-label-lg text-on-surface truncate">{{ $sellerUser->name }}</p>
                    <p class="text-label-sm text-primary font-label-sm">Verified Partner</p>
                </div>
            </div>
            <div class="border-t border-outline-variant/30 pt-4 space-y-1">
                @if($sellerStore)
                    <a href="{{ route('stores.show', $sellerStore->slug) }}" target="_blank"
                       class="text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors duration-200 flex items-center px-4 py-2 mx-2 rounded-lg">
                        <span class="material-symbols-outlined mr-3">storefront</span>
                        <span class="font-label-md">View My Public Store</span>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-error hover:bg-error-container/20 transition-colors duration-200 flex items-center px-4 py-2 mx-2 rounded-lg">
                        <span class="material-symbols-outlined mr-3">logout</span>
                        <span class="font-label-md">Logout Now</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Sidebar (Desktop Static) -->
    <aside class="fixed left-0 top-0 h-screen w-sidebar-width z-30 shadow-[0px_4px_20px_rgba(0,0,0,0.05)] bg-surface flex-col py-lg hidden lg:flex">
        <div class="px-6 mb-10">
            <h1 class="text-headline-xl tracking-tighter text-primary">IZIFAI</h1>
            <p class="text-label-sm text-on-surface-variant mt-1 uppercase tracking-widest">SellerCenter</p>
        </div>
        <nav class="flex-1 px-2 space-y-1">
            <a href="{{ route('seller.dashboard') }}"
               class="{{ request()->routeIs('seller.dashboard') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.dashboard') ? '1' : '0' }};">home</span>
                <span class="font-label-lg">My Shop Home</span>
            </a>
            <a href="{{ route('seller.products.index') }}"
               class="{{ request()->routeIs('seller.products.*') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.products.*') ? '1' : '0' }};">inventory_2</span>
                <span class="font-label-lg">All My Items</span>
            </a>
            <a href="{{ route('seller.ads.index') }}"
               class="{{ request()->routeIs('seller.ads.*') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.ads.*') ? '1' : '0' }};">campaign</span>
                <span class="font-label-lg">Promote Items</span>
            </a>
            <a href="{{ route('seller.store.settings') }}"
               class="{{ request()->routeIs('seller.store.settings') ? 'bg-primary-container text-on-primary-container rounded-xl' : 'text-on-surface-variant hover:text-primary hover:bg-surface-container-high' }} flex items-center px-4 py-3 mx-2 my-1 transition-all duration-200">
                <span class="material-symbols-outlined mr-3" style="font-variation-settings: 'FILL' {{ request()->routeIs('seller.store.settings') ? '1' : '0' }};">settings</span>
                <span class="font-label-lg">Change Settings</span>
            </a>
        </nav>
        <div class="px-4 mt-auto space-y-6">
            <div class="flex items-center px-4 py-3 bg-surface-container rounded-2xl">
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-sm shrink-0 border-2 border-white">
                    {{ substr($sellerUser->name, 0, 1) }}
                </div>
                <div class="ml-3 overflow-hidden">
                    <p class="font-label-lg text-on-surface truncate">{{ $sellerUser->name }}</p>
                    <p class="text-label-sm text-primary font-label-sm">Verified Partner</p>
                </div>
            </div>
            <div class="border-t border-outline-variant/30 pt-4 space-y-1">
                @if($sellerStore)
                    <a href="{{ route('stores.show', $sellerStore->slug) }}" target="_blank"
                       class="text-on-surface-variant hover:text-primary hover:bg-surface-container-high transition-colors duration-200 flex items-center px-4 py-2 mx-2 rounded-lg">
                        <span class="material-symbols-outlined mr-3">storefront</span>
                        <span class="font-label-md">View My Public Store</span>
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-error hover:bg-error-container/20 transition-colors duration-200 flex items-center px-4 py-2 mx-2 rounded-lg">
                        <span class="material-symbols-outlined mr-3">logout</span>
                        <span class="font-label-md">Logout Now</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-sidebar-width min-h-screen">
        <!-- Top Bar -->
        <header class="h-header-height flex items-center justify-between px-4 md:px-xl bg-surface/80 backdrop-blur-md sticky top-0 z-30 border-b border-outline-variant/20 lg:border-0">
            <div class="flex items-center gap-2">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg transition-colors">
                    <span class="material-symbols-outlined" x-show="!sidebarOpen">menu</span>
                    <span class="material-symbols-outlined" x-show="sidebarOpen" x-cloak>close</span>
                </button>
                <div class="hidden sm:flex items-center bg-surface-container-low px-4 py-2 rounded-full w-56 md:w-72 lg:w-96">
                    <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                    <input class="bg-transparent border-none focus:ring-0 text-body-md w-full p-0 placeholder:text-on-surface-variant/50" placeholder="Search..." type="text">
                </div>
            </div>
            <div class="flex items-center gap-2 md:gap-md">
                <button class="relative p-2 text-on-surface-variant hover:bg-surface-container-high rounded-full transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <a href="{{ route('seller.products.create') }}"
                   class="bg-primary text-white px-4 md:px-6 py-2 md:py-2.5 rounded-full font-label-lg flex items-center gap-1 md:gap-2 hover:opacity-90 transition-opacity text-sm md:text-base">
                    <span class="material-symbols-outlined text-[18px] md:text-[20px]">add</span>
                    <span class="hidden md:inline">New Product Link</span>
                </a>
            </div>
        </header>

        <div class="p-4 md:p-xl max-w-7xl mx-auto space-y-4 md:space-y-grid-gutter">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <footer class="w-full py-xl mt-auto bg-surface-container-low">
            <div class="flex flex-col md:flex-row justify-between items-center px-lg max-w-7xl mx-auto gap-md">
                <div class="flex flex-col gap-1">
                    <span class="text-headline-md text-on-surface">IZIFAI</span>
                    <p class="text-body-md text-on-surface-variant">© {{ date('Y') }} IZIFAI. SIMPLIFY YOUR SHOPPING. All rights reserved.</p>
                </div>
                <div class="flex gap-lg">
                    <a class="text-label-md text-on-surface-variant hover:text-primary underline underline-offset-4" href="#">Help Center</a>
                    <a class="text-label-md text-on-surface-variant hover:text-primary underline underline-offset-4" href="#">Terms of Service</a>
                    <a class="text-label-md text-on-surface-variant hover:text-primary underline underline-offset-4" href="#">Privacy Policy</a>
                </div>
            </div>
        </footer>
    </main>

</body>
</html>
