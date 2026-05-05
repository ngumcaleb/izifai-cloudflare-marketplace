<x-guest-layout>
    @section('title', 'Sign In')

    <div class="text-center mb-10">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-3">Welcome Back</h2>
        <p class="text-sm text-slate-500 font-medium">Please enter your details to sign in.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <label for="email" class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email Address</label>
            <div class="relative group">
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="name@company.com" class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between px-1">
                <label for="password" class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-green-600 hover:underline" href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <input id="password" type="password" name="password" required placeholder="••••••••" class="w-full px-5 py-4 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:border-green-600 focus:ring-0 text-sm font-semibold transition-all outline-none">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center px-1">
            <label for="remember_me" class="flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-200 text-green-600 focus:ring-green-600/20 transition-all">
                <span class="ml-2.5 text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors">Keep me signed in</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit" class="w-full bg-[#16A34A] text-white py-4 rounded-2xl font-bold text-sm hover:bg-green-700 transition-all shadow-xl shadow-green-600/10 active:scale-[0.98]">
                Sign In
            </button>
        </div>
    </form>

    <div class="mt-10 pt-8 border-t border-slate-50 text-center">
        <p class="text-xs text-slate-400 font-bold tracking-tight">
            New to Izifai? 
            <a href="{{ route('register') }}" class="text-green-600 hover:underline ml-1">Create an account</a>
        </p>
    </div>
</x-guest-layout>