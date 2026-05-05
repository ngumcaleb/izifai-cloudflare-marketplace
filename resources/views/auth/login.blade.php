<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - Izifai Marketplace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center p-6">
    <div class="w-full max-w-[450px]">
        <div class="text-center mb-10">
            <a href="/">
                <x-application-logo class="h-14 mx-auto mb-6" />
            </a>
            <h1 class="text-3xl font-black text-[#0A1D37] tracking-tight">Welcome Back</h1>
            <p class="text-slate-500 font-medium mt-2">Sign in to manage your marketplace experience.</p>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 p-10 border border-slate-100">
            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-black text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full px-6 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="name@company.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-xs font-black text-slate-400 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-black text-green-600 uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">
                                Forgot?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="w-full px-6 py-4 rounded-2xl border-2 border-slate-100 focus:border-green-600 focus:ring-0 font-bold transition-all placeholder:text-slate-300" placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center px-1">
                    <input id="remember_me" type="checkbox" name="remember" class="w-5 h-5 rounded-lg border-2 border-slate-200 text-green-600 focus:ring-green-600 focus:ring-offset-0 transition-all">
                    <label for="remember_me" class="ml-3 text-sm font-bold text-slate-500 cursor-pointer select-none">Remember me</label>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#16A34A] text-white py-4 rounded-2xl font-black text-lg hover:bg-green-700 transition-all shadow-xl shadow-green-600/20 active:scale-[0.98]">
                        Sign In
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center mt-10 text-slate-500 font-bold text-sm">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-green-600 hover:underline">Create Account</a>
        </p>
    </div>
</body>
</html>
