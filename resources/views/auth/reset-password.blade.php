@extends('layouts.auth')

@section('title', 'Set New Password — iziFaii')

@section('content')

    {{-- LEFT --}}
    <div class="hidden lg:flex lg:w-1/2 bg-primary flex-col justify-between p-10 xl:p-14 relative overflow-hidden min-h-screen">
        <div class="absolute top-[-120px] right-[-120px] w-80 h-80 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute bottom-[-80px] left-[-80px] w-96 h-96 rounded-full bg-white/5 blur-2xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 rounded-full bg-white/5 blur-3xl"></div>
        <a href="/" class="relative z-10">
            <x-application-logo class="h-10 w-auto brightness-0 invert" />
        </a>
        <div class="relative z-10 max-w-lg">
            <h1 class="text-4xl xl:text-5xl font-black text-on-primary leading-[1.15] tracking-tight">
                Choose a New<br>
                <span class="text-primary-fixed-dim">Password</span>
            </h1>
            <p class="text-base text-on-primary/80 mt-4 leading-relaxed">
                Set a strong, unique password to keep your account secure.
            </p>
        </div>
        <div class="relative z-10">
            <p class="text-xs text-on-primary/50">&copy; {{ date('Y') }} iziFaii. Simplify Your Shopping.</p>
        </div>
    </div>

    {{-- RIGHT --}}
    <div class="flex-1 flex flex-col min-h-dvh lg:min-h-screen bg-surface-container-lowest">
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
                    <p class="text-sm font-bold text-white">Choose a New Password</p>
                    <p class="text-xs text-white/70">Set a strong password to keep your Cameroon store account secure.</p>
                </div>
            </div>
        </div>

        <div class="flex-1 flex items-center justify-center px-5 py-6 lg:py-0">
            <div class="w-full max-w-md">

                <div class="hidden lg:block mb-8">
                    <h1 class="text-2xl font-black text-on-surface tracking-tight">Set new password</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Choose a strong password to secure your account.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5" x-data="{ showPassword: false, showConfirm: false }">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Email Address</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">mail</span>
                            <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                   class="w-full pl-11 pr-4 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none">
                        </div>
                        @error('email') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">New Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                                   class="w-full pl-11 pr-11 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Min 8 characters">
                            <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[20px]" x-text="showPassword ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                        @error('password') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-on-surface-variant mb-1.5">Confirm Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] pointer-events-none">lock</span>
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                                   class="w-full pl-11 pr-11 py-3 bg-surface-container-lowest border border-outline-variant/50 rounded-lg text-sm text-on-surface font-medium placeholder:text-on-surface-variant/40 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                   placeholder="Repeat password">
                            <button type="button" @click="showConfirm = !showConfirm"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[20px]" x-text="showConfirm ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                        @error('password_confirmation') <p class="text-xs text-error font-semibold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-on-primary rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all active:scale-[0.98]">
                        Reset Password
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[16px] align-text-bottom">arrow_back</span>
                        Back to login
                    </a>
                </div>

            </div>
        </div>
    </div>

    <p class="hidden lg:block fixed bottom-4 right-4 text-xs text-on-surface-variant/50 z-10">
        &copy; {{ date('Y') }} iziFaii &mdash; Cameroon
    </p>

@endsection