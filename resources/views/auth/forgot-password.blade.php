<x-guest-layout>
    @section('title', 'Reset Password')

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Reset Password</h2>
        <p class="text-sm text-slate-500">Forgot your password? Enter your email and we'll send you a reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 focus:border-green-600 focus:ring-0 text-sm font-medium transition-all bg-slate-50/30">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#16A34A] text-white py-3 rounded-lg font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-600/10 active:scale-[0.98]">
                Send Reset Link
            </button>
        </div>
    </form>

    <div class="mt-10 text-center">
        <a href="{{ route('login') }}" class="inline-flex items-center text-xs font-bold text-slate-400 hover:text-green-600 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Sign In
        </a>
    </div>
</x-guest-layout>