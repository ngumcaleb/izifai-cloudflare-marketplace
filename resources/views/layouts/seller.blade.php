<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Seller Center') — IZIFAI SellerCenter</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

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
        html { scroll-behavior: smooth; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fafcfa; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        [x-cloak] { display: none !important; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        @keyframes reveal { 0% { opacity: 0; transform: translateY(24px) scale(0.98); } 100% { opacity: 1; transform: translateY(0) scale(1); } }
        @keyframes fadeIn { 0% { opacity: 0; } 100% { opacity: 1; } }
        @keyframes slideDown { 0% { opacity: 0; transform: translateY(-8px); } 100% { opacity: 1; transform: translateY(0); } }
        @keyframes scaleIn { 0% { opacity: 0; transform: scale(0.95); } 100% { opacity: 1; transform: scale(1); } }

        .animate-reveal { animation: reveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-fade-in { animation: fadeIn 0.6s ease forwards; }
        .animate-slide-down { animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .animate-scale-in { animation: scaleIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        .header-scrolled { background: rgba(255, 255, 255, 0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(0,0,0,0.04); }
        .header-top { background: transparent; border-bottom: 1px solid transparent; }

        ::selection { background: rgba(0, 109, 56, 0.15); color: #003317; }
    </style>
    @stack('styles')
</head>
<body class="text-gray-900 antialiased" x-data="{ sidebarOpen: false }">

    @php $sellerUser = auth()->user(); $sellerStore = $sellerUser->store; @endphp

    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/20 backdrop-blur-sm lg:hidden transition-opacity"
         x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <!-- Mobile Sidebar -->
    <aside x-show="sidebarOpen" x-cloak
           class="fixed left-0 top-0 h-dvh w-sidebar-width z-50 bg-white flex flex-col transition-transform duration-300 lg:translate-x-0 shadow-lg border-r border-gray-100"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           style="transition-property: transform;"
           @click.away="sidebarOpen = false">
        <div class="relative h-16 lg:h-24 shrink-0">
            @if($sellerStore && $sellerStore->banner)
                <img src="{{ $sellerStore->banner_url }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary/50 to-primary"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            <button @click="sidebarOpen = false" class="lg:hidden absolute top-2 right-2 w-6 h-6 bg-black/30 text-white rounded-full flex items-center justify-center hover:bg-black/50 transition-all">
                <span class="material-symbols-outlined text-[14px]">close</span>
            </button>
            <div class="absolute -bottom-6 lg:-bottom-7 left-3 lg:left-4">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl border-2 border-white bg-white shadow-lg overflow-hidden">
                    @if($sellerStore && $sellerStore->logo)
                        <img src="{{ $sellerStore->logo_url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-primary/10 flex items-center justify-center text-base lg:text-lg font-black text-primary">
                            {{ $sellerStore ? substr($sellerStore->name, 0, 1) : 'S' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="pt-8 px-4 pb-3 border-b border-gray-100 shrink-0">
            <h2 class="text-sm font-bold text-gray-900 truncate">{{ $sellerStore ? $sellerStore->name : 'My Store' }}</h2>
            <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center gap-0.5 text-[10px] font-bold text-primary bg-primary/5 px-1.5 py-0.5 rounded-full">
                    <span class="material-symbols-outlined text-[11px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    Seller
                </span>
                <span class="text-[10px] text-gray-500">{{ $sellerStore ? $sellerStore->products()->count() : 0 }} products</span>
            </div>
        </div>

        <nav class="flex-1 min-h-0 overflow-y-auto py-3 px-3 space-y-0.5">
            @php $isDashboard = request()->routeIs('seller.dashboard'); @endphp
            <a href="{{ route('seller.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isDashboard ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isDashboard ? '1' : '0' }};">home</span>
                My Shop Home
            </a>
            @php $isProducts = request()->routeIs('seller.products.*'); @endphp
            <a href="{{ route('seller.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isProducts ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isProducts ? '1' : '0' }};">inventory_2</span>
                All My Items
            </a>
            @php $isAds = request()->routeIs('seller.ads.*'); @endphp
            <a href="{{ route('seller.ads.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isAds ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isAds ? '1' : '0' }};">campaign</span>
                Promote Items
            </a>
            @php $isReviews = request()->routeIs('seller.reviews'); @endphp
            <a href="{{ route('seller.reviews') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isReviews ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isReviews ? '1' : '0' }};">reviews</span>
                Customer Reviews
            </a>
            @php $isSettings = request()->routeIs('seller.store.settings'); @endphp
            <a href="{{ route('seller.store.settings') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isSettings ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isSettings ? '1' : '0' }};">settings</span>
                Store Settings
            </a>
        </nav>

        <div class="px-3 py-3 border-t border-gray-100 space-y-1 shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50/50">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                    {{ substr($sellerUser->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ $sellerUser->name }}</p>
                    <p class="text-[10px] font-medium text-primary">Verified Seller</p>
                </div>
            </div>
            @if($sellerStore)
                <a href="{{ route('stores.show', $sellerStore->slug) }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-gray-500 hover:text-primary hover:bg-gray-50 transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">storefront</span>
                    View My Public Store
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Desktop Sidebar -->
    <aside class="fixed left-0 top-0 h-dvh w-sidebar-width z-30 bg-white flex-col hidden lg:flex shadow-lg border-r border-gray-100">
        <div class="relative h-24 shrink-0">
            @if($sellerStore && $sellerStore->banner)
                <img src="{{ $sellerStore->banner_url }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-primary/50 to-primary"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
            <div class="absolute -bottom-7 left-4">
                <div class="w-12 h-12 rounded-xl border-2 border-white bg-white shadow-lg overflow-hidden">
                    @if($sellerStore && $sellerStore->logo)
                        <img src="{{ $sellerStore->logo_url }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-primary/10 flex items-center justify-center text-lg font-black text-primary">
                            {{ $sellerStore ? substr($sellerStore->name, 0, 1) : 'S' }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="pt-8 px-4 pb-3 border-b border-gray-100 shrink-0">
            <h2 class="text-sm font-bold text-gray-900 truncate">{{ $sellerStore ? $sellerStore->name : 'My Store' }}</h2>
            <div class="flex flex-wrap items-center gap-1.5 mt-0.5">
                <span class="inline-flex items-center gap-0.5 text-[10px] font-bold text-primary bg-primary/5 px-1.5 py-0.5 rounded-full">
                    <span class="material-symbols-outlined text-[11px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                    Seller
                </span>
                <span class="text-[10px] text-gray-500">{{ $sellerStore ? $sellerStore->products()->count() : 0 }} products</span>
            </div>
        </div>

        <nav class="flex-1 min-h-0 overflow-y-auto py-3 px-3 space-y-0.5">
            @php $isDashboard = request()->routeIs('seller.dashboard'); @endphp
            <a href="{{ route('seller.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isDashboard ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isDashboard ? '1' : '0' }};">home</span>
                My Shop Home
            </a>
            @php $isProducts = request()->routeIs('seller.products.*'); @endphp
            <a href="{{ route('seller.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isProducts ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isProducts ? '1' : '0' }};">inventory_2</span>
                All My Items
            </a>
            @php $isAds = request()->routeIs('seller.ads.*'); @endphp
            <a href="{{ route('seller.ads.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isAds ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isAds ? '1' : '0' }};">campaign</span>
                Promote Items
            </a>
            @php $isReviews = request()->routeIs('seller.reviews'); @endphp
            <a href="{{ route('seller.reviews') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isReviews ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isReviews ? '1' : '0' }};">reviews</span>
                Customer Reviews
            </a>
            @php $isSettings = request()->routeIs('seller.store.settings'); @endphp
            <a href="{{ route('seller.store.settings') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 {{ $isSettings ? 'text-primary bg-primary/5 shadow-sm' : 'text-gray-500 hover:text-primary hover:bg-gray-50/80 font-medium' }}">
                <span class="material-symbols-outlined text-[20px]" style="font-variation-settings: 'FILL' {{ $isSettings ? '1' : '0' }};">settings</span>
                Store Settings
            </a>
        </nav>

        <div class="px-3 py-3 border-t border-gray-100 space-y-1 shrink-0">
            <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-gray-50/50">
                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                    {{ substr($sellerUser->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-gray-900 truncate">{{ $sellerUser->name }}</p>
                    <p class="text-[10px] font-medium text-primary">Verified Seller</p>
                </div>
            </div>
            @if($sellerStore)
                <a href="{{ route('stores.show', $sellerStore->slug) }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-gray-500 hover:text-primary hover:bg-gray-50 transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">storefront</span>
                    View My Public Store
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-medium text-red-600 hover:bg-red-50 transition-all duration-200">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="lg:ml-sidebar-width min-h-screen">
        <header class="header-scrolled h-16 lg:h-[72px] flex items-center justify-between px-4 md:px-6 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl text-gray-500 hover:text-primary hover:bg-black/5 transition-all active:scale-90">
                    <span class="material-symbols-outlined text-[20px]" x-show="!sidebarOpen">menu</span>
                    <span class="material-symbols-outlined text-[20px]" x-show="sidebarOpen" x-cloak>close</span>
                </button>
                <a href="/" class="shrink-0 transition-opacity hover:opacity-80">
                    <x-application-logo class="h-7 sm:h-[30px]" />
                </a>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-primary/5 text-primary text-[10px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-primary-fixed-dim"></span>
                    Seller Center
                </span>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('seller.products.create') }}"
                   class="bg-primary text-white px-4 md:px-5 py-2 rounded-xl text-[13px] font-bold flex items-center gap-1.5 hover:opacity-90 active:scale-[0.97] transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span class="hidden md:inline">New Product</span>
                </a>
            </div>
        </header>

        <div class="px-4 md:px-6 py-4 md:py-6 max-w-7xl mx-auto space-y-4 md:space-y-6">
            @yield('content')
        </div>

        <footer class="w-full py-8 mt-auto bg-white border-t border-gray-100">
            <div class="flex flex-col md:flex-row justify-between items-center px-4 md:px-6 max-w-7xl mx-auto gap-4">
                <div class="flex flex-col gap-1.5">
                    <a href="/" class="transition-opacity hover:opacity-80"><x-application-logo class="h-7" /></a>
                    <p class="text-xs text-gray-400">© {{ date('Y') }} IZIFAI. Simplify Your Shopping.</p>
                </div>
                <div class="flex items-center gap-4">
                    <a class="text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors" href="#">Help Center</a>
                    <a class="text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors" href="#">Terms</a>
                    <a class="text-[11px] font-semibold text-gray-400 hover:text-primary transition-colors" href="#">Privacy</a>
                </div>
            </div>
        </footer>
    </main>

    <script>
        function copyToClipboard(text, btn, successMsg, resetDelay) {
            const label = btn.querySelector('.copy-label') || btn.querySelector('span:last-child');
            const icon = btn.querySelector('.copy-icon') || btn.querySelector('span:first-child');
            const origLabel = label ? label.textContent : '';
            const origIcon = icon ? icon.textContent : '';

            function done() {
                if (label) label.textContent = successMsg || 'Copied!';
                if (icon) icon.textContent = 'check';
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
