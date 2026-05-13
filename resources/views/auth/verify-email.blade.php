@extends('layouts.auth')

@section('title', 'Verify Email — iziFaii')

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
                One Last Step<br>
                <span class="text-primary-fixed-dim">Verify Your Email</span>
            </h1>
            <p class="text-base text-on-primary/80 mt-4 leading-relaxed">
                Check your inbox for the verification link we sent you.
            </p>
        </div>
        <div class="relative z-10">
            <p class="text-xs text-on-primary/50">&copy; {{ date('Y') }} iziFaii. Simplify Your Shopping.</p>
        </div>
    </div>

    {{-- RIGHT: CONTENT --}}
    <div class="flex-1 flex flex-col min-h-dvh lg:min-h-screen bg-surface-container-lowest">
        <div class="lg:hidden flex items-center gap-3 px-6 py-5 border-b border-outline-variant/20 bg-surface">
            <a href="/"><x-application-logo class="h-7" /></a>
        </div>
        <div class="flex-1 flex items-center justify-center px-5 py-10 lg:py-0">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <h2 class="text-2xl font-black text-on-surface tracking-tight">Verify email</h2>
                    <p class="text-sm text-on-surface-variant mt-4 leading-relaxed">
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?
                    </p>
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-5 p-3 bg-primary/10 border border-primary/20 rounded-lg text-sm text-primary font-semibold">
                        A new verification link has been sent to your email.
                    </div>
                @endif

                <div class="space-y-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center justify-center gap-2 px-6 py-3.5 bg-primary text-on-primary rounded-lg text-sm font-bold shadow-lg hover:opacity-90 transition-all active:scale-[0.98]">
                            Resend Verification Email
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-on-surface-variant hover:text-primary transition-colors uppercase tracking-widest underline underline-offset-4">
                            Log Out
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <p class="hidden lg:block fixed bottom-4 right-4 text-xs text-on-surface-variant/50 z-10">
        &copy; {{ date('Y') }} iziFaii &mdash; Cameroon
    </p>

@endsection


