@extends('layouts.auth')

@section('title', 'Confirm Password — iziFaii')

@section('content')

    {{-- LEFT: branding panel --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary flex-col justify-between p-10 xl:p-14 relative overflow-hidden min-h-screen">
        <div class="absolute top-[-120px] right-[-120px] w-80 h-80 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute bottom-[-80px] left-[-80px] w-96 h-96 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>
        <a href="/" class="relative z-10">
            <x-application-logo class="h-10 w-auto brightness-0 invert" />
        </a>
        <div class="relative z-10 max-w-lg">
            <h1 class="text-4xl xl:text-5xl font-black text-on-primary leading-[1.15] tracking-tight">
                Secure Area<br>
                <span class="text-primary-fixed-dim">Confirm Access</span>
            </h1>
            <p class="text-base text-on-primary/80 mt-4 leading-relaxed">
                This is a secure area of the application. Please confirm your password before continuing.
            </p>
        </div>
        <div class="relative z-10">
            <p class="text-xs text-on-primary/50">&copy; {{ date('Y') }} iziFaii. Simplify Your Shopping.</p>
        </div>
    </div>

    {{-- RIGHT: FORM --}}
    <div class="flex-1 flex flex-col min-h-dvh lg:min-h-screen bg-surface-container-lowest">
        <div class="lg:hidden flex items-center gap-3 px-6 py-5 border-b border-outline-variant/20 bg-surface">
            <a href="/"><x-application-logo class="h-7" /></a>
        </div>
        <div class="flex-1 flex items-center justify-center px-5 py-10 lg:py-0">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h2 class="text-2xl font-black text-on-surface tracking-tight">Confirm access</h2>
                    <p class="text-sm text-on-surface-variant mt-1">This is a secure area. Please confirm your password to continue.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="password" class="block text-xs font-bold text-on-surface-variant mb-1.5">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-error font-semibold" />
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-on-primary rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all active:scale-[0.98]">
                        Confirm Password
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <p class="hidden lg:block fixed bottom-4 right-4 text-xs text-on-surface-variant/50 z-10">
        &copy; {{ date('Y') }} iziFaii &mdash; Cameroon
    </p>

@endsection


