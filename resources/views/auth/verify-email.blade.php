<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Verify email</h2>
        <p class="text-sm text-slate-500 mt-4 leading-relaxed">
            Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? 
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 rounded-lg bg-brand-50 border border-brand-100 font-semibold text-xs text-brand-700">
            A new verification link has been sent to your email.
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-brand text-white py-3.5 rounded-lg font-bold text-sm hover:bg-brand-700 transition-all active:scale-[0.99] shadow-sm">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest underline underline-offset-4">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>


