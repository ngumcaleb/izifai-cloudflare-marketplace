<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'iziFaii — Simplify Your Shopping')</title>
    <meta name="description" content="@yield('description', 'iziFaii helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                    spacing: {
                        "grid-gutter": "20px",
                        xl: "32px",
                        md: "16px",
                        lg: "24px",
                        "sidebar-width": "260px",
                        xs: "4px",
                        "header-height": "72px",
                        sm: "8px",
                        base: "4px"
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                    },
                    fontSize: {
                        "headline-md": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.01em", fontWeight: "700" }],
                        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "label-lg": ["14px", { lineHeight: "20px", fontWeight: "600" }],
                        "label-sm": ["11px", { lineHeight: "14px", fontWeight: "500" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "600" }],
                        "headline-xl": ["30px", { lineHeight: "38px", letterSpacing: "-0.02em", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .glass-card { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        .search-results-card { max-height: 70vh; overflow-y: auto; }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface overflow-x-hidden"
      x-data="{ mobileNav: false }">

    {{-- STOREFRONT: DESKTOP SIDEBAR --}}
    @hasSection('sidebar')
        @yield('sidebar')
    @endif

    {{-- STOREFRONT: MOBILE NAV DRAWER (teleports to body via x-teleport) --}}
    @hasSection('mobile-nav')
        @yield('mobile-nav')
    @endif

    {{-- ===== MAIN CONTENT ===== --}}
    @hasSection('sidebar')
        {{-- STOREFRONT MODE (with merchant sidebar) --}}
        <main class="lg:ml-[260px] min-h-screen bg-background">

            @hasSection('topbar')
                @yield('topbar')
            @endif

            @hasSection('mobile-search')
                @yield('mobile-search')
            @endif

            <div class="@hasSection('topbar') pt-[64px] lg:pt-[72px] @endif px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 space-y-4 sm:space-y-6 lg:space-y-8">
                @yield('content')
            </div>

            @hasSection('footer')
                @yield('footer')
            @else
                <footer class="bg-surface-container-low border-t border-outline-variant/20">
                    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-6">
                            <div class="flex items-center gap-4 sm:gap-6">
                                <a href="/"><x-application-logo class="h-7" /></a>
                                <a href="{{ \App\Models\Setting::get('whatsapp_community_link', '#') }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#25D366]/10 text-[#25D366] rounded-full text-[10px] font-bold hover:bg-[#25D366] hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                                    Join Izifai Community
                                </a>
                            </div>
                            <div class="flex items-center gap-4 sm:gap-6">
                                <a href="{{ route('login') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Log In</a>
                                <a href="{{ route('register') }}" class="text-xs font-semibold text-primary hover:underline transition-colors">Get Started</a>
                            </div>
                            <p class="text-xs text-on-surface-variant text-center sm:text-left">&copy; {{ date('Y') }} IZIFAI Platform. All rights reserved.</p>
                        </div>
                    </div>
                </footer>
            @endif

        </main>
    @else
        {{-- SIMPLE MODE (no sidebar — for stores index, products, etc.) --}}
        <main class="min-h-screen bg-background">

            {{-- Simple mode header --}}
            <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant/10">
                <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between gap-4">
                    <a href="/" class="shrink-0">
                        <x-application-logo class="h-7" />
                    </a>

                    <div class="flex-1 max-w-md hidden sm:block"
                         x-data="globalSearch()"
                         @click.away="results = []; open = false">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline z-10 text-[20px]">search</span>
                            <input x-model="query" @input.debounce.300ms="search()" @focus="if (results.length) open = true"
                                   type="text" placeholder="Search products..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-outline-variant/30 rounded-full text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>

                        <div x-show="open && results.length" x-cloak
                             class="absolute top-full mt-2 left-0 right-0 bg-surface-container-lowest rounded-2xl shadow-xl border border-outline-variant/20 overflow-hidden z-50 search-results-card">
                            <template x-for="product in results" :key="product.id">
                                <a :href="'/products/' + product.slug"
                                   class="flex items-center gap-3 p-3 hover:bg-surface-container transition-all border-b border-outline-variant/10 last:border-0">
                                    <div class="w-12 h-12 rounded-lg bg-surface-container-high overflow-hidden shrink-0">
                                        <img x-show="product.image" :src="'/storage/' + product.image"
                                             class="w-full h-full object-cover" alt="">
                                        <div x-show="!product.image"
                                             class="w-full h-full flex items-center justify-center text-outline">
                                            <span class="material-symbols-outlined text-[18px]">image</span>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-on-surface truncate" x-text="product.name"></p>
                                        <p class="text-xs text-on-surface-variant" x-text="product.category"></p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-black text-primary" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                                        <p x-show="product.old_price" class="text-[10px] text-on-surface-variant line-through"
                                           x-text="Number(product.old_price).toLocaleString() + ' FCFA'"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                        <div x-show="open && !results.length && query.length > 2" x-cloak
                             class="absolute top-full mt-2 left-0 right-0 bg-surface-container-lowest rounded-2xl shadow-xl border border-outline-variant/20 overflow-hidden z-50">
                            <div class="p-6 text-center text-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-2xl">search_off</span>
                                <p class="mt-1 font-medium">No products found</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('login') }}"
                           class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors">Log In</a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-primary text-on-primary rounded-full text-xs font-bold hover:opacity-90 transition-all shadow-sm">Get Started</a>
                    </div>

                    <button @click="document.getElementById('mobile-search-public').classList.toggle('hidden')"
                            class="sm:hidden p-2 text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>

                <div id="mobile-search-public" class="hidden sm:hidden px-4 pb-3"
                     x-data="globalSearch()"
                     @click.away="results = []; open = false">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline z-10 text-[20px]">search</span>
                        <input x-model="query" @input.debounce.300ms="search()" @focus="if (results.length) open = true"
                               type="text" placeholder="Search products..."
                               class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-outline-variant/30 rounded-full text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>
                    <div x-show="open && results.length" x-cloak
                         class="mt-2 bg-surface-container-lowest rounded-2xl shadow-xl border border-outline-variant/20 overflow-hidden">
                        <template x-for="product in results" :key="product.id">
                            <a :href="'/products/' + product.slug"
                               class="flex items-center gap-3 p-3 hover:bg-surface-container transition-all border-b border-outline-variant/10 last:border-0">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-high overflow-hidden shrink-0">
                                    <img x-show="product.image" :src="'/storage/' + product.image"
                                         class="w-full h-full object-cover" alt="">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-on-surface truncate" x-text="product.name"></p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-sm font-black text-primary" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </header>

            @yield('content')

            @hasSection('footer')
                @yield('footer')
            @else
                <footer class="bg-surface-container-low border-t border-outline-variant/20">
                    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-12">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 sm:gap-6">
                            <div class="flex items-center gap-4 sm:gap-6">
                                <a href="/"><x-application-logo class="h-7" /></a>
                                <a href="{{ \App\Models\Setting::get('whatsapp_community_link', '#') }}" target="_blank"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#25D366]/10 text-[#25D366] rounded-full text-[10px] font-bold hover:bg-[#25D366] hover:text-white transition-all">
                                    <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                                    Join Izifai Community
                                </a>
                            </div>
                            <div class="flex items-center gap-4 sm:gap-6">
                                <a href="{{ route('login') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Log In</a>
                                <a href="{{ route('register') }}" class="text-xs font-semibold text-primary hover:underline transition-colors">Get Started</a>
                            </div>
                            <p class="text-xs text-on-surface-variant text-center sm:text-left">&copy; {{ date('Y') }} IZIFAI Platform. All rights reserved.</p>
                        </div>
                    </div>
                </footer>
            @endif

        </main>
    @endif

    <script>
        function globalSearch() {
            return {
                query: '',
                results: [],
                open: false,
                search() {
                    const q = this.query.trim();
                    if (q.length < 2) { this.results = []; this.open = false; return; }
                    fetch('/products/autocomplete?q=' + encodeURIComponent(q))
                        .then(r => r.json())
                        .then(data => { this.results = data; this.open = true; })
                        .catch(() => {});
                }
            };
        }

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
