<x-guest-layout>
    @section('title', 'Verify Email')

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Verify Email</h2>
        <p class="text-sm text-slate-500">Please click the link in your email to activate your account.</p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-lg text-xs font-bold text-green-700">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full bg-[#16A34A] text-white py-3 rounded-lg font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-600/10 active:scale-[0.98]">
                Resend Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-red-600 transition-colors">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>