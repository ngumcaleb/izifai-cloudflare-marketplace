<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - Izifai Marketplace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-6 py-16">
    <div class="w-full max-w-[550px]">
        <div class="text-center mb-10">
            <a href="/">
                <x-application-logo class="h-12 mx-auto mb-6" />
            </a>
            <h1 class="text-3xl font-black text-[#0A1D37] tracking-tight">Create your Account</h1>
            <p class="text-slate-500 font-medium mt-2">Join Cameroon's most professional marketplace.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 p-10 border border-slate-100" x-data="{ role: 'buyer' }">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-8 p-1 bg-slate-50 rounded-2xl">
                    <button type="button" @click="role = 'buyer'" :class="role === 'buyer' ? 'bg-white shadow-sm text-green-600' : 'text-slate-400'" class="py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                        I am a Buyer
                    </button>
                    <button type="button" @click="role = 'seller'" :class="role === 'seller' ? 'bg-white shadow-sm text-green-600' : 'text-slate-400'" class="py-3 rounded-xl font-black text-xs uppercase tracking-widest transition-all">
                        I am a Seller
                    </button>
                    <input type="hidden" name="role" :value="role">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="John Doe">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="john@example.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="670 000 000">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Store Name (Conditional) -->
                    <div class="space-y-2" x-show="role === 'seller'" x-transition>
                        <label for="store_name" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Store Name</label>
                        <input id="store_name" type="text" name="store_name" value="{{ old('store_name') }}" :required="role === 'seller'" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="My Awesome Store">
                        <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Confirm</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full px-5 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-[#16A34A] text-white py-4 rounded-2xl font-black text-lg hover:bg-green-700 transition-all shadow-xl shadow-green-600/20 active:scale-[0.98]">
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center mt-10 text-slate-500 font-bold text-sm">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-green-600 hover:underline">Sign In</a>
        </p>
    </div>
</body>
</html>
