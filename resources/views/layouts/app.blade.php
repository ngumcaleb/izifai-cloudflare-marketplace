<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Izifai - Buy easily, Get it fast' }}</title>
    <!-- Tailwind CDN for cross-device stability -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Montserrat', 'sans-serif'],
                        barlow: ['Barlow', 'sans-serif'],
                        source: ['Source Sans 3', 'sans-serif'],
                        montserrat: ['Montserrat', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=Barlow:wght@300;400;500;600;700;800;900&family=Source+Sans+3:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', () => lucide.createIcons());</script>
    <style>
        body { font-family: 'Montserrat', sans-serif; font-size: 13px; }
        h1, h2, h3, h4, h5, h6, .font-display { font-family: 'Montserrat', sans-serif; }
        .font-barlow { font-family: 'Barlow', sans-serif; }
        .font-source { font-family: 'Source Sans 3', sans-serif; }
        p, li, td, input, textarea, select { font-family: 'Source Sans 3', sans-serif; }
        nav, button, label, .nav-item { font-family: 'Barlow', sans-serif; }
        [x-cloak] { display: none !important; }
        .search-shadow { box-shadow: 0 4px 20px rgba(22, 163, 74, 0.15); }
        .mega-menu-shadow { box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="antialiased bg-[#F4F7F9] text-slate-900 overflow-x-hidden" x-data="{ mobileMenu: false, megaMenu: false, userDropdown: false }">
    <!-- Alibaba Top Navigation -->
    <nav class="hidden lg:block bg-white border-b border-slate-100 py-2 text-[11px] font-medium text-slate-500">
        <div class="max-w-[1400px] mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2 pr-6 border-r border-slate-100">
                    <img src="https://flagcdn.com/w20/cm.png" class="w-4 rounded-[1px]">
                    <span class="text-slate-900 font-bold">Cameroon</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="{{ route('seller.dashboard') }}" class="hover:text-green-600 transition-colors">{{ auth()->check() && auth()->user()->role === 'seller' ? 'Seller Dashboard' : 'Sell on Izifai' }}</a>
                    <a href="{{ route('help') }}" class="hover:text-green-600 transition-colors">Help Center</a>
                </div>
            </div>
            <div class="flex items-center gap-6">
                @auth
                    <div class="relative" @click.away="userDropdown = false">
                        <button @click="userDropdown = !userDropdown" class="flex items-center gap-2 hover:text-green-600 transition-colors font-bold text-slate-900">
                            {{ auth()->user()->name }}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="userDropdown" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-2xl border border-slate-100 py-2 z-[200]">
                            <a href="{{ auth()->user()->role === 'seller' ? route('seller.dashboard') : route('dashboard') }}" class="block px-4 py-2 hover:bg-slate-50 font-bold text-slate-700">{{ auth()->user()->role === 'seller' ? 'Seller Dashboard' : 'My Dashboard' }}</a>
                            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-bold text-slate-700">My Favorites</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-slate-50 font-bold text-slate-700">Settings</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-50 mt-2">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-red-50 text-red-600 font-bold">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-5">
                        <a href="{{ route('login') }}" class="hover:text-green-600 font-bold text-slate-900">Sign In</a>
                        <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-1.5 rounded-lg font-black uppercase tracking-widest text-[9px] hover:bg-green-700 transition-all">Join Free</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Header -->
    <header class="bg-white sticky top-0 z-[100] border-b border-slate-100 lg:py-4 shadow-sm lg:shadow-none">
        <div class="max-w-[1400px] mx-auto px-4 lg:px-6 h-16 lg:h-auto flex items-center gap-4 lg:gap-10">
            <!-- Mobile Toggle -->
            <button @click="mobileMenu = true" class="lg:hidden p-2 text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>

            <!-- Logo -->
            <a href="/" class="shrink-0"><x-application-logo class="h-8 lg:h-12" /></a>

            <!-- Professional Search Bar -->
            <div class="hidden lg:flex flex-1 max-w-3xl relative" x-data="searchAutocomplete()">
                <form action="{{ route('search') }}" method="GET" class="flex w-full h-11 bg-white border-2 border-green-600 rounded-lg overflow-hidden search-shadow group">
                    <input type="hidden" name="type" :value="searchType">
                    
                    <div class="relative flex items-center h-full border-r border-slate-100 bg-slate-50" @click.away="showTypeDropdown = false">
                        <button type="button" @click="showTypeDropdown = !showTypeDropdown" class="flex items-center px-5 h-full text-[11px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition-colors">
                            <span x-text="searchType"></span>
                            <svg class="w-3 h-3 ml-2 transition-transform duration-300" :class="showTypeDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Type Dropdown -->
                        <div x-show="showTypeDropdown" x-cloak class="absolute top-full left-0 mt-1 w-32 bg-white border border-slate-100 rounded-lg shadow-2xl py-2 z-[200]">
                            <button type="button" @click="searchType = 'products'; showTypeDropdown = false" class="w-full text-left px-4 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50 transition-colors" :class="searchType === 'products' ? 'text-green-600' : 'text-slate-500'">Products</button>
                            <button type="button" @click="searchType = 'sellers'; showTypeDropdown = false" class="w-full text-left px-4 py-2 text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50 transition-colors" :class="searchType === 'sellers' ? 'text-green-600' : 'text-slate-500'">Sellers</button>
                        </div>
                    </div>

                    <input type="text" name="q" x-model="query" @input.debounce.300ms="fetchSuggestions" @focus="showSuggestions = true" autocomplete="off" placeholder="What are you looking for today?" class="flex-1 px-6 text-sm font-medium outline-none focus:ring-0 border-none">
                    
                    <button type="submit" class="bg-green-600 text-white px-10 h-full font-black text-xs uppercase tracking-[0.2em] hover:bg-green-700 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Search
                    </button>
                </form>

                <!-- Desktop Suggestions Dropdown -->
                <div x-show="showSuggestions && query.length >= 2" @click.away="showSuggestions = false" x-cloak class="absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-2xl border border-slate-100 py-2 z-[200] max-h-[70vh] overflow-y-auto">
                    <div x-show="isLoading" class="px-6 py-4 flex justify-center items-center gap-3 text-slate-400 text-xs font-bold uppercase tracking-widest">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Loading...
                    </div>
                    <div x-show="!isLoading && suggestions.length === 0" class="px-6 py-4 text-center text-slate-500 text-sm font-medium">No results found for "<span x-text="query" class="font-bold text-slate-900"></span>"</div>
                    
                    <template x-for="item in suggestions" :key="item.id + item.type">
                        <a :href="item.url" class="flex items-center justify-between px-6 py-2.5 hover:bg-slate-50 transition-colors group">
                            <div class="flex items-center gap-3 overflow-hidden">
                                <div class="shrink-0 text-slate-400 group-hover:text-green-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <h4 class="text-[13px] font-semibold text-slate-700 group-hover:text-slate-900 truncate" x-text="item.name"></h4>
                            </div>
                            <span class="shrink-0 pl-4 text-[10px] text-slate-400 uppercase tracking-widest font-bold" x-text="item.type === 'product' && item.category ? item.category : item.type"></span>
                        </a>
                    </template>
                </div>
            </div>

            <!-- Mobile Search Trigger -->
            <div class="lg:hidden" x-data="{ mobileSearch: false }">
                <button @click="mobileSearch = true" class="p-2 text-slate-500 hover:text-green-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </button>

                <!-- Full Screen Mobile Search Takeover (Alibaba Style) -->
                <div x-show="mobileSearch" x-cloak 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     class="fixed inset-0 z-[400] bg-[#F4F7F9] flex flex-col">
                    
                    <!-- Search Header -->
                    <div class="bg-white px-4 py-3 flex items-center gap-3 border-b border-slate-100 shadow-sm z-10" x-data="searchAutocomplete()">
                        <button @click="mobileSearch = false" class="text-slate-400 p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        
                        <form action="{{ route('search') }}" method="GET" class="flex-1 flex items-center bg-slate-100 rounded-full h-10 border border-slate-200 focus-within:border-green-600 focus-within:bg-white transition-colors overflow-hidden px-3">
                            <input type="hidden" name="type" :value="searchType">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="q" x-model="query" @input.debounce.300ms="fetchSuggestions" autocomplete="off" placeholder="Search products or sellers..." autofocus class="w-full bg-transparent border-none focus:ring-0 text-sm font-medium text-slate-900 px-3 placeholder:text-slate-400">
                        </form>
                        
                        <button type="submit" onclick="document.querySelector('.lg\\:hidden form[action=\'{{ route('search') }}\']').submit()" class="text-green-600 font-bold text-sm tracking-tight px-1">Search</button>
                    </div>

                    <!-- Search Body Filters -->
                    <div class="flex-1 overflow-y-auto bg-white" x-data="searchAutocomplete()">
                        <div class="p-5 space-y-8" x-show="query.length < 2">
                            
                            <!-- Search Type Toggle -->
                            <div class="bg-slate-50 p-1.5 rounded-xl flex" x-data="{ localType: 'products' }">
                                <button type="button" @click="localType = 'products'; document.querySelector('input[name=type]').value = 'products'" :class="localType === 'products' ? 'bg-white text-green-600 shadow-sm' : 'text-slate-500'" class="flex-1 py-2 text-[11px] font-bold uppercase tracking-widest rounded-lg transition-all">Products</button>
                                <button type="button" @click="localType = 'sellers'; document.querySelector('input[name=type]').value = 'sellers'" :class="localType === 'sellers' ? 'bg-white text-green-600 shadow-sm' : 'text-slate-500'" class="flex-1 py-2 text-[11px] font-bold uppercase tracking-widest rounded-lg transition-all">Sellers</button>
                            </div>

                            <!-- City Filter -->
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 mb-3">Location Filter</h3>
                                <select name="city" form="search-form" onchange="const url = new URL('{{ route('search') }}'); url.searchParams.set('city', this.value); url.searchParams.set('type', document.querySelector('input[name=type]').value); window.location.href = url.toString();" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 focus:border-green-600 focus:ring-1 focus:ring-green-600 transition-all appearance-none outline-none">
                                    <option value="">All Regions</option>
                                    @php 
                                        $activeCities = \App\Models\Store::whereHas('products')->select('location')->distinct()->whereNotNull('location')->pluck('location'); 
                                    @endphp
                                    @foreach($activeCities as $city)
                                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hot Categories -->
                            <div>
                                <h3 class="text-xs font-bold text-slate-900 mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                                    Hot Categories
                                </h3>
                                <div class="flex flex-wrap gap-2.5">
                                    @php $searchCats = \App\Models\Category::has('products')->take(8)->get(); @endphp
                                    @foreach($searchCats as $cat)
                                        <a href="{{ route('categories.show', $cat->slug) }}" class="bg-slate-50 border border-slate-100 px-4 py-2 rounded-full text-[11px] font-semibold text-slate-600 hover:bg-green-50 hover:text-green-700 hover:border-green-200 transition-all">
                                            {{ $cat->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        
                        <!-- Mobile Suggestions List -->
                        <div x-show="query.length >= 2" class="py-2" x-cloak>
                            <div x-show="isLoading" class="px-6 py-10 flex justify-center items-center gap-3 text-slate-400 text-xs font-bold uppercase tracking-widest">
                                <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Loading...
                            </div>
                            <div x-show="!isLoading && suggestions.length === 0" class="px-6 py-10 text-center text-slate-500 text-sm font-medium">
                                No results found for "<span x-text="query" class="font-bold text-slate-900"></span>"
                            </div>
                            
                            <template x-for="item in suggestions" :key="item.id + item.type">
                                <a :href="item.url" class="flex items-center justify-between px-5 py-3 hover:bg-slate-50 transition-colors active:bg-slate-100">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div class="shrink-0 text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        </div>
                                        <h4 class="text-[14px] font-medium text-slate-800 truncate" x-text="item.name"></h4>
                                    </div>
                                    <div class="flex items-center gap-3 pl-3 shrink-0">
                                        <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold" x-text="item.type === 'product' && item.category ? item.category : item.type"></span>
                                        <svg class="w-3 h-3 text-slate-300 -rotate-45" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Icons (Hidden on Mobile, simplified) -->
            <div class="flex items-center gap-4 lg:gap-8 ml-auto">
                <a href="{{ route('favorites.index') }}" class="hidden lg:flex flex-col items-center gap-1 text-slate-400 hover:text-green-600 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <span class="text-[9px] font-black uppercase tracking-tighter">Favorites</span>
                </a>
                <!-- Language Dropdown (Desktop) -->
                <div class="hidden lg:block relative" x-data="{ langDropdown: false }" @click.away="langDropdown = false">
                    <button @click="langDropdown = !langDropdown" class="flex items-center gap-2 bg-slate-50 px-3 py-2 rounded-lg border border-slate-100 hover:bg-white transition-all group">
                        <img src="https://flagcdn.com/w20/cm.png" class="w-4 h-3 object-cover rounded-[1px]">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter group-hover:text-slate-900 transition-colors">EN / FR</span>
                        <svg class="w-3 h-3 text-slate-300 transition-transform duration-300" :class="langDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="langDropdown" x-cloak 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute right-0 mt-2 w-32 bg-white border border-slate-100 rounded-lg shadow-2xl py-1.5 z-[200]">
                        <a href="#" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 text-[10px] font-bold text-slate-900">
                            English <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                        </a>
                        <a href="#" class="block px-4 py-2 hover:bg-slate-50 text-[10px] font-bold text-slate-500 hover:text-slate-900">Français</a>
                    </div>
                </div>

                <!-- Language Dropdown (Mobile) -->
                <div class="lg:hidden relative" x-data="{ langDropdown: false }" @click.away="langDropdown = false">
                    <button @click="langDropdown = !langDropdown" class="flex items-center gap-1.5 bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100 active:bg-white transition-all">
                        <img src="https://flagcdn.com/w20/cm.png" class="w-4 h-3 object-cover rounded-[1px]">
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-tighter">EN</span>
                        <svg class="w-2.5 h-2.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="langDropdown" x-cloak class="absolute right-0 mt-2 w-32 bg-white border border-slate-100 rounded-lg shadow-2xl py-1.5 z-[200]">
                        <a href="#" class="flex items-center justify-between px-4 py-2 hover:bg-slate-50 text-[10px] font-bold text-slate-900">English</a>
                        <a href="#" class="block px-4 py-2 hover:bg-slate-50 text-[10px] font-bold text-slate-500">Français</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Sub-Nav -->
        <div class="hidden lg:block bg-white border-t border-slate-50">
            <div class="max-w-[1400px] mx-auto px-6 h-11 flex items-center justify-between">
                <div class="flex items-center gap-8 h-full">
                    <button @click="megaMenu = !megaMenu" class="flex items-center gap-2 h-full text-[12px] font-black text-[#0A1D37] border-b-2 border-green-600 pr-6 transition-all hover:text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        All Categories
                    </button>
                    <nav class="flex items-center gap-8 text-[11px] font-bold text-slate-500 h-full">
                        <a href="{{ url('/') }}" class="flex items-center gap-1.5 hover:text-green-600 transition-colors {{ request()->is('/') ? 'text-green-600' : '' }}">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Marketplace
                        </a>
                        <a href="{{ route('stores.index') }}" class="hover:text-green-600 transition-colors {{ request()->routeIs('stores.*') ? 'text-green-600' : '' }}">Featured Sellers</a>
                        <a href="{{ route('products.new-arrivals') }}" class="hover:text-green-600 transition-colors {{ request()->routeIs('products.new-arrivals') ? 'text-green-600' : '' }}">Newest Items</a>
                        <a href="{{ route('products.local-sourcing') }}" class="hover:text-green-600 transition-colors {{ request()->routeIs('products.local-sourcing') ? 'text-green-600' : '' }}">Buy Near Me</a>
                    </nav>
                </div>
            </div>

            <!-- Alibaba-style Mega Menu -->
            <div x-show="megaMenu" x-cloak @click.away="megaMenu = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="absolute top-full left-0 right-0 bg-white border-b border-slate-200 shadow-2xl z-[150]">
                <div class="max-w-[1400px] mx-auto px-10 py-12 grid grid-cols-5 gap-12">
                    @php $megaCategories = \App\Models\Category::has('products')->with('products')->take(4)->get(); @endphp
                    @foreach($megaCategories as $mCat)
                        <div>
                            <div class="flex items-center gap-2 mb-6 pb-2 border-b border-slate-50">
                                <div class="w-5 h-5 bg-green-50 rounded flex items-center justify-center text-green-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="{{ $mCat->icon ?? 'M9 5l7 7-7 7' }}"></path></svg>
                                </div>
                                <h4 class="font-black text-[#0A1D37] uppercase text-[10px] tracking-widest">{{ $mCat->name }}</h4>
                            </div>
                            <ul class="space-y-3.5 text-[11px] font-bold text-slate-500">
                                @foreach($mCat->products->take(5) as $p)
                                    <li><a href="{{ route('products.show', $p->slug) }}" class="hover:text-green-600 transition-colors flex items-center gap-2">
                                        <div class="w-1 h-1 bg-slate-200 rounded-full"></div>
                                        {{ $p->name }}
                                    </a></li>
                                @endforeach
                                <li><a href="{{ route('categories.show', $mCat->slug) }}" class="text-green-600 hover:underline flex items-center gap-1 mt-2">View All {{ $mCat->name }}</a></li>
                            </ul>
                        </div>
                    @endforeach
                    <div class="bg-slate-50 p-8 rounded border border-slate-100 flex flex-col justify-between relative overflow-hidden group">
                        <div class="relative z-10">
                            <span class="inline-block bg-green-600 text-white text-[8px] font-black px-3 py-1 rounded uppercase tracking-widest mb-4">Market Insight</span>
                            <h5 class="font-black text-[#0A1D37] text-base mb-4 leading-tight">Trending <br> Wholesalers</h5>
                            <a href="{{ route('stores.index') }}" class="inline-flex items-center gap-2 bg-[#0A1D37] text-white px-6 py-3 rounded font-black text-[9px] uppercase tracking-widest hover:bg-slate-800 transition-all">View Rankings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 pb-24 lg:pb-0">
        @if(isset($sidebar))
            <div class="flex min-h-screen">
                <div class="shrink-0 hidden lg:block border-r border-slate-100">{{ $sidebar }}</div>
                <div class="flex-1">{{ $slot }}</div>
            </div>
        @else
            {{ $slot }}
        @endif
    </main>

    <!-- Alibaba Footer -->
    <footer class="bg-white border-t border-slate-100 py-16 hidden lg:block">
        <div class="max-w-[1400px] mx-auto px-6">
            <div class="grid grid-cols-3 gap-12 mb-16">
                <div>
                    <h4 class="font-black text-[#0A1D37] uppercase text-[10px] tracking-widest mb-6">Buy on Izifai.com</h4>
                    <ul class="space-y-3 text-[11px] font-bold text-slate-500">
                        <li><a href="#" class="hover:text-green-600">How to Buy</a></li>
                        <li><a href="#" class="hover:text-green-600">Market Categories</a></li>
                        <li><a href="#" class="hover:text-green-600">Regional Items</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-black text-[#0A1D37] uppercase text-[10px] tracking-widest mb-6">Sell on Izifai.com</h4>
                    <ul class="space-y-3 text-[11px] font-bold text-slate-500">
                        <li><a href="#" class="hover:text-green-600">Seller Center</a></li>
                        <li><a href="#" class="hover:text-green-600">Trusted Sellers</a></li>
                        <li><a href="#" class="hover:text-green-600">Partner with Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-black text-[#0A1D37] uppercase text-[10px] tracking-widest mb-6">Customer Service</h4>
                    <ul class="space-y-3 text-[11px] font-bold text-slate-500">
                        <li><a href="{{ route('help') }}" class="hover:text-green-600">Help Center</a></li>
                        <li><a href="#" class="hover:text-green-600">Contact Us</a></li>
                        <li><a href="#" class="hover:text-green-600">Policies & Rules</a></li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-slate-50 flex justify-between items-center">
                <div class="flex items-center gap-6">
                    <x-application-logo class="h-6 opacity-30 grayscale" />
                    <p class="text-[10px] text-slate-400 font-bold">© {{ date('Y') }} Izifai. All rights reserved. Cameroon's Professional Marketplace.</p>
                </div>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-400 hover:text-[#0A1D37] transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                    <a href="#" class="text-slate-400 hover:text-[#0A1D37] transition-all"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Clean Mobile Navigation Stack (Alibaba Style) -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-[250]">
        <!-- Refined White Guest CTA Bar -->
        @guest
            <div class="bg-white/95 backdrop-blur-md border-t border-slate-100 px-5 py-3 flex items-center justify-between shadow-[0_-10px_30px_rgba(0,0,0,0.03)]">
                <div class="flex items-center gap-3">
                    <div class="bg-slate-900 text-white text-[8px] font-black px-2 py-1 transform -skew-x-12 uppercase tracking-tighter">
                        Best Sellers
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 tracking-tight">Buy and sell on Izifai</p>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-[11px] font-bold text-slate-500 hover:text-slate-900 transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg text-[11px] font-black shadow-lg shadow-green-900/20 active:scale-95 transition-all">Join Izifai</a>
                </div>
            </div>
        @endguest

        <nav class="bg-white border-t border-slate-100 px-2 py-2 flex items-center justify-around shadow-[0_-10px_40px_rgba(0,0,0,0.04)]">
            <!-- Market -->
            <a href="/" class="flex flex-col items-center gap-1 group">
                <svg class="w-5 h-5 {{ request()->is('/') ? 'text-green-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <span class="text-[8px] font-bold uppercase tracking-widest {{ request()->is('/') ? 'text-slate-900' : 'text-slate-400' }}">Market</span>
            </a>

            <!-- Explore -->
            <a href="{{ route('categories.index') }}" class="flex flex-col items-center gap-1 group">
                <svg class="w-5 h-5 {{ request()->is('categories*') ? 'text-green-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                <span class="text-[8px] font-bold uppercase tracking-widest {{ request()->is('categories*') ? 'text-slate-900' : 'text-slate-400' }}">Explore</span>
            </a>

            <!-- Saved -->
            <a href="{{ route('favorites.index') }}" class="flex flex-col items-center gap-1 group">
                <svg class="w-5 h-5 {{ request()->is('favorites*') ? 'text-green-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <span class="text-[8px] font-bold uppercase tracking-widest {{ request()->is('favorites*') ? 'text-slate-900' : 'text-slate-400' }}">Saved</span>
            </a>

            <!-- Profile -->
            @auth
                <a href="{{ auth()->user()->role === 'seller' ? route('seller.dashboard') : route('dashboard') }}" class="flex flex-col items-center gap-1 group">
                    <svg class="w-5 h-5 {{ (request()->is('dashboard*') || request()->is('profile*') || request()->is('seller*')) ? 'text-green-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span class="text-[8px] font-bold uppercase tracking-widest {{ (request()->is('dashboard*') || request()->is('profile*') || request()->is('seller*')) ? 'text-slate-900' : 'text-slate-400' }}">{{ auth()->user()->role === 'seller' ? '' : 'Profile' }} Dashboard</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 group">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    <span class="text-[8px] font-bold uppercase tracking-widest text-slate-400">Login</span>
                </a>
            @endauth
        </nav>
    </div>

    <!-- Alibaba-Inspired Off-Canvas Mobile Menu -->
    <div x-show="mobileMenu" x-cloak class="lg:hidden relative z-[500]" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        
        <!-- Background backdrop -->
        <div x-show="mobileMenu"
             x-transition:enter="ease-in-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in-out duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenu = false"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 left-0 flex max-w-full pr-14">
                    
                    <!-- Sliding panel -->
                    <div x-show="mobileMenu"
                         x-transition:enter="transform transition ease-in-out duration-300"
                         x-transition:enter-start="-translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="-translate-x-full"
                         class="pointer-events-auto w-screen max-w-[280px]">
                        
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-2xl no-scrollbar">
                            
                            <!-- Header / Profile Section -->
                            <div class="bg-[#0A1D37] p-6 relative overflow-hidden">
                                <!-- Decorative circle -->
                                <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full bg-white/5"></div>
                                
                                <div class="relative z-10 flex flex-col gap-4">
                                    <div class="flex items-center justify-between">
                                        <x-application-logo class="h-6 brightness-0 invert" />
                                        <button @click="mobileMenu = false" class="text-white/50 hover:text-white p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    
                                    @auth
                                        <div class="flex items-center gap-3 mt-2">
                                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-lg">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-white text-sm font-bold">{{ auth()->user()->name }}</p>
                                                <a href="{{ auth()->user()->role === 'seller' ? route('seller.dashboard') : route('dashboard') }}" class="text-green-400 text-[10px] uppercase tracking-wider font-bold hover:underline">{{ auth()->user()->role === 'seller' ? 'Seller Dashboard' : 'My Dashboard' }}</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2">
                                            <p class="text-white/80 text-xs mb-3 font-medium">Welcome to Izifai! Sign in for the best experience.</p>
                                            <div class="flex gap-2">
                                                <a href="{{ route('login') }}" class="flex-1 bg-white text-[#0A1D37] text-center py-2 rounded-lg text-xs font-bold transition-transform active:scale-95">Sign In</a>
                                                <a href="{{ route('register') }}" class="flex-1 bg-green-600 text-white text-center py-2 rounded-lg text-xs font-bold transition-transform active:scale-95">Join Free</a>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>

                            <!-- Navigation Links -->
                            <div class="flex-1 py-4">
                                <!-- Discovery -->
                                <div class="px-4 pb-4 border-b border-slate-100 mb-4">
                                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3 px-2">Discover</h3>
                                    <ul class="space-y-1">
                                        <li>
                                            <a href="{{ route('stores.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors">
                                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                                                Trusted Sellers
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('products.new-arrivals') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors">
                                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                New Arrivals
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('products.local-sourcing') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors">
                                                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Buy Near Me
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Categories Accordion -->
                                <div class="px-4 pb-4 border-b border-slate-100 mb-4" x-data="{ open: true }">
                                    <button @click="open = !open" class="w-full flex items-center justify-between mb-2 px-2">
                                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">All Categories</h3>
                                        <svg class="w-3 h-3 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-collapse>
                                        <ul class="space-y-0.5 pb-2">
                                            @php $allCats = \App\Models\Category::has('products')->get(); @endphp
                                            @foreach($allCats as $cat)
                                                <li>
                                                    <a href="{{ route('categories.show', $cat->slug) }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-green-600 transition-colors">
                                                        {{ $cat->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <!-- Support -->
                                <div class="px-4 pb-6">
                                    <ul class="space-y-1">
                                        <li>
                                            <a href="{{ route('help') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-slate-50 text-slate-700 font-semibold text-sm transition-colors">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                Help & Support
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchAutocomplete', () => ({
                query: '{{ request('q') }}',
                suggestions: [],
                showSuggestions: false,
                isLoading: false,
                searchType: 'products',
                showTypeDropdown: false,

                async fetchSuggestions() {
                    if (this.query.length < 2) {
                        this.suggestions = [];
                        return;
                    }
                    
                    this.isLoading = true;
                    this.showSuggestions = true;
                    
                    // Allow external components (like mobile wrapper) to sync state
                    const mobileQueryInput = document.querySelector('.lg\\:hidden input[name=q]');
                    const desktopQueryInput = document.querySelector('.hidden.lg\\:flex input[name=q]');
                    if (mobileQueryInput && mobileQueryInput !== this.$el) mobileQueryInput.value = this.query;
                    if (desktopQueryInput && desktopQueryInput !== this.$el) desktopQueryInput.value = this.query;
                    
                    try {
                        const response = await fetch(`{{ route('search.autocomplete') }}?q=${encodeURIComponent(this.query)}`);
                        if (response.ok) {
                            const data = await response.json();
                            this.suggestions = data;
                        }
                    } catch (error) {
                        console.error('Autocomplete API Error:', error);
                    } finally {
                        this.isLoading = false;
                    }
                }
            }));
        });
    </script>
</body>
</html>