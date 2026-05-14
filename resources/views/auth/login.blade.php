@extends('layouts.auth')

@section('title', 'Log In — iziFaii')

@section('content')

    {{-- LEFT: VALUE PROPS (desktop only) --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary flex-col justify-between p-10 xl:p-14 relative overflow-hidden min-h-screen">

        <div class="absolute top-[-120px] right-[-120px] w-80 h-80 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute bottom-[-80px] left-[-80px] w-96 h-96 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>

        <a href="/" class="relative z-10">
            <x-application-logo class="h-10 w-auto brightness-0 invert" />
        </a>

        <div class="relative z-10 space-y-8 max-w-lg">
            <div>
                <h1 class="text-4xl xl:text-5xl font-black text-on-primary leading-[1.15] tracking-tight">
                    Welcome Back to<br>
                    <span class="text-primary-fixed-dim">Your Catalog</span>
                </h1>
                <p class="text-base text-on-primary/80 mt-4 leading-relaxed">
                    Access your store, manage your products, and track your sales — all from one place.
                </p>
            </div>

            <div class="space-y-3">
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Manage your products</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">Add, edit, or remove items. Update prices and stock in real time.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">bar_chart</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Track your performance</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">See which products get the most views and clicks. Know what's working.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container text-[22px]" style="font-variation-settings: 'FILL' 1;">call</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-on-primary">Login with WhatsApp</p>
                        <p class="text-xs text-on-primary/70 mt-0.5">Use your registered WhatsApp number to sign in. No email needed.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-xs text-on-primary/50">&copy; {{ date('Y') }} iziFaii. Simplify Your Shopping.</p>
        </div>
    </div>

    {{-- RIGHT: FORM PANEL --}}
    <div class="flex-1 flex flex-col min-h-dvh lg:min-h-screen bg-surface-container-lowest lg:bg-surface-container-lowest">

        {{-- Mobile: Hero with background --}}
        <div class="lg:hidden relative overflow-hidden bg-gradient-to-br from-[#00210d] via-[#003317] to-[#005228] px-6 pt-5 pb-8">
            <div class="absolute top-[-60px] right-[-60px] w-40 h-40 rounded-full bg-white/5 blur-2xl"></div>
            <div class="absolute bottom-[-40px] left-[-40px] w-48 h-48 rounded-full bg-white/5 blur-2xl"></div>
            <a href="/" class="relative z-10 inline-block mb-5">
                <x-application-logo class="h-7 w-auto brightness-0 invert" />
            </a>
            <div class="relative z-10 flex items-center gap-3">
                <span class="text-3xl leading-none">🇨🇲</span>
                <div>
                    <p class="text-sm font-bold text-white">Welcome Back to Your Store</p>
                    <p class="text-xs text-white/70">Cameroon's marketplace — manage your catalog, track sales, grow your business.</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-5 py-6 lg:py-0">
            <div class="w-full max-w-md">

                <div class="hidden lg:block mb-8">
                    <h1 class="text-2xl font-black text-on-surface tracking-tight">Welcome back</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Sign in to your account to continue.</p>
                </div>

                @if (session('status'))
                    <div class="mb-5 p-3 bg-primary/10 border border-primary/20 rounded-lg text-sm text-primary font-semibold">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5" x-data="{ showPassword: false }">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Email or WhatsApp Number</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">person</span>
                            <input type="text" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="your@email.com or 670 000 000">
                        </div>
                        @error('email') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-xs font-bold text-on-surface-variant">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-bold text-primary hover:underline">Forgot password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required
                                   class="w-full pl-11 pr-11 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Enter your password">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary/20 cursor-pointer">
                        <span class="text-sm font-medium text-on-surface-variant group-hover:text-on-surface transition-colors">Keep me signed in</span>
                    </label>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-on-primary rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all active:scale-[0.98]">
                        Sign In
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-on-surface-variant">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary font-bold hover:underline">Create one</a>
                    </p>
                </div>

                <div class="mt-6 pt-5 border-t border-outline-variant/20 flex items-center justify-center gap-6">
                    <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/60">
                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        Secure Data
                    </div>
                    <div class="flex items-center gap-1.5 text-xs text-on-surface-variant/60">
                        <span class="material-symbols-outlined text-[16px]" style="font-variation-settings: 'FILL' 1;">support_agent</span>
                        Local Support
                    </div>
                </div>

            </div>
        </div>

    </div>

    <p class="hidden lg:block fixed bottom-4 right-4 text-xs text-on-surface-variant/50 z-10">
        &copy; {{ date('Y') }} iziFaii &mdash; Cameroon
    </p>

@endsection