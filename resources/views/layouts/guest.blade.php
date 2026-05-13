<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Izifai — Your Store in a Link')</title>
    <meta name="description" content="@yield('description', 'Izifai helps Cameroon merchants create beautiful, shareable product catalogs. No app needed — just a link.')">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8F9FA; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="text-on-surface overflow-x-hidden">

    <header class="sticky top-0 z-50 bg-surface/80 backdrop-blur-md border-b border-outline-variant/10">
        <div class="max-w-7xl mx-auto px-4 h-14 sm:h-16 flex items-center justify-between gap-4">
            <a href="/" class="shrink-0">
                <x-application-logo class="h-6 sm:h-7" />
            </a>

            <div class="flex-1 max-w-md hidden sm:block"
                 x-data="globalSearch()"
                 @click.away="results = []; open = false">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline z-10 text-[18px]">search</span>
                    <input x-model="query" @input.debounce.300ms="search()" @focus="if (results.length) open = true"
                           type="text" placeholder="Search products..."
                           class="w-full pl-9 pr-4 py-2 bg-surface-container-low border border-outline-variant/30 rounded-full text-xs sm:text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                </div>
                <div x-show="open && results.length" x-cloak
                     class="absolute top-full mt-2 left-0 right-0 bg-surface-container-lowest rounded-xl shadow-xl border border-outline-variant/20 overflow-hidden z-50 max-h-[60vh] overflow-y-auto">
                    <template x-for="product in results" :key="product.id">
                        <a :href="'/products/' + product.slug"
                           class="flex items-center gap-3 p-3 hover:bg-surface-container transition-all border-b border-outline-variant/10 last:border-0">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-high overflow-hidden shrink-0">
                                <img x-show="product.image" :src="'/storage/' + product.image"
                                     class="w-full h-full object-cover" alt="">
                                <div x-show="!product.image"
                                     class="w-full h-full flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-[16px]">image</span>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-on-surface truncate" x-text="product.name"></p>
                                <p class="text-xs text-on-surface-variant" x-text="product.category"></p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs font-black text-primary" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                                <p x-show="product.old_price" class="text-[9px] text-on-surface-variant line-through"
                                   x-text="Number(product.old_price).toLocaleString() + ' FCFA'"></p>
                            </div>
                        </a>
                    </template>
                </div>
                <div x-show="open && !results.length && query.length > 2" x-cloak
                     class="absolute top-full mt-2 left-0 right-0 bg-surface-container-lowest rounded-xl shadow-xl border border-outline-variant/20 overflow-hidden z-50">
                    <div class="p-5 text-center text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-2xl">search_off</span>
                        <p class="mt-1 font-medium">No products found</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                @auth
                    @php $dashboard = auth()->user()->role === 'seller' ? route('seller.dashboard') : route('stores.index'); @endphp
                    <a href="{{ $dashboard }}"
                       class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span>
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                                class="text-xs sm:text-sm font-semibold text-on-surface-variant hover:text-error transition-colors px-2">
                            Log Out
                        </button>
                    </form>
                    <a href="{{ $dashboard }}"
                       class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-black hover:bg-primary hover:text-on-primary transition-all">
                        {{ substr(auth()->user()->name ?? auth()->user()->email, 0, 1) }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-xs sm:text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors px-2">Log In</a>
                    <a href="{{ route('register') }}"
                       class="px-3 sm:px-4 py-1.5 sm:py-2 bg-primary text-on-primary rounded-full text-[11px] sm:text-xs font-bold hover:opacity-90 transition-all shadow-sm">Get Started</a>
                @endauth
                <button @click="document.getElementById('mobile-search-guest').classList.toggle('hidden')"
                        class="sm:hidden p-1.5 text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">search</span>
                </button>
            </div>
        </div>

        <div id="mobile-search-guest" class="hidden sm:hidden px-4 pb-3"
             x-data="globalSearch()"
             @click.away="results = []; open = false">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline z-10 text-[18px]">search</span>
                <input x-model="query" @input.debounce.300ms="search()" @focus="if (results.length) open = true"
                       type="text" placeholder="Search products..."
                       class="w-full pl-9 pr-4 py-2.5 bg-surface-container-low border border-outline-variant/30 rounded-full text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
            </div>
            <div x-show="open && results.length" x-cloak
                 class="mt-2 bg-surface-container-lowest rounded-xl shadow-xl border border-outline-variant/20 overflow-hidden max-h-[60vh] overflow-y-auto">
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
                            <p class="text-xs font-black text-primary" x-text="Number(product.price).toLocaleString() + ' FCFA'"></p>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </header>

    <main class="min-h-screen bg-background">
        @yield('content')
    </main>

    <footer class="bg-surface-container-low border-t border-outline-variant/20">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:py-8">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="/"><x-application-logo class="h-5 sm:h-6" /></a>
                    <a href="{{ \App\Models\Setting::get('whatsapp_community_link', '#') }}" target="_blank"
                       class="inline-flex items-center gap-1 px-2.5 py-1 bg-[#25D366]/10 text-[#25D366] rounded-full text-[9px] sm:text-[10px] font-bold hover:bg-[#25D366] hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[12px] sm:text-[14px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                        Join Izifai Community
                    </a>
                </div>
                <div class="flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('stores.index') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Browse Stores</a>
                    @auth
                        <a href="{{ auth()->user()->role === 'seller' ? route('seller.dashboard') : route('stores.index') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-error hover:text-error/80 transition-colors">Log Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold text-on-surface-variant hover:text-primary transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="text-xs font-semibold text-primary hover:underline transition-colors">Get Started</a>
                    @endauth
                </div>
                <p class="text-[10px] sm:text-xs text-on-surface-variant text-center sm:text-left">&copy; {{ date('Y') }} Izifai. Simplify Your Shopping.</p>
            </div>
        </div>
    </footer>

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
    </script>

    @stack('scripts')
</body>
</html>
