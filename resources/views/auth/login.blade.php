<x-guest-layout>
    {{-- Heading --}}
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">Welcome back</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Sign in to your Izifai account to continue.</p>
    </div>

    {{-- Session Status --}}
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2">Email Address</label>
            <div class="relative">
                <i class="fa-regular fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full pl-11 pr-4 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                       placeholder="your@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-500 font-semibold" />
        </div>

        {{-- Password --}}
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between mb-2">
                <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-brand hover:underline">Forgot password?</a>
                @endif
            </div>
            <div class="relative">
                <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                       class="w-full pl-11 pr-12 py-3.5 rounded-xl border-2 border-slate-200 bg-slate-50 text-slate-900 text-sm font-medium outline-none transition-all focus:border-brand focus:bg-white focus:ring-4 focus:ring-brand/10 placeholder:text-slate-400 placeholder:font-normal"
                       placeholder="••••••••">
                <button type="button" @click="show = !show"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-700 transition-colors">
                    <i :class="show ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-sm"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-500 font-semibold" />
        </div>

        {{-- Remember me --}}
        <label class="flex items-center gap-3 cursor-pointer group">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-slate-300 text-brand focus:ring-brand">
            <span class="text-sm font-medium text-slate-600 group-hover:text-slate-900 transition-colors">Keep me signed in</span>
        </label>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-brand text-white py-4 rounded-xl font-black text-sm uppercase tracking-widest hover:bg-brand-dark transition-all shadow-lg shadow-brand/20 active:scale-[0.99]">
            Sign In &nbsp;<i class="fa-solid fa-arrow-right text-xs"></i>
        </button>
    </form>

    {{-- Divider --}}
    <div class="flex items-center gap-4 my-7">
        <div class="h-px flex-1 bg-slate-100"></div>
        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Or</span>
        <div class="h-px flex-1 bg-slate-100"></div>
    </div>

    <a href="{{ route('register') }}"
       class="flex items-center justify-center gap-3 w-full py-4 rounded-xl border-2 border-slate-200 text-slate-700 font-bold text-sm hover:border-brand/40 hover:text-brand transition-all group">
        <i class="fa-solid fa-store text-slate-400 group-hover:text-brand transition-colors text-sm"></i>
        Create a new account
    </a>

    <p class="text-center text-[11px] text-slate-400 font-medium mt-6 flex items-center justify-center gap-1.5">
        <i class="fa-solid fa-shield-halved text-brand"></i>
        Your data is encrypted and secure on Izifai.
    </p>
</x-guest-layout>
