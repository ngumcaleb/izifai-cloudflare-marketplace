<x-guest-layout>
    @section('title', 'Set New Password')

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">New Password</h2>
        <p class="text-sm text-slate-500">Please enter your new password below.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
            </div>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="Email" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 focus:border-green-600 focus:ring-0 text-sm font-medium transition-all bg-slate-50/30">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <input id="password" type="password" name="password" required placeholder="New Password" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 focus:border-green-600 focus:ring-0 text-sm font-medium transition-all bg-slate-50/30">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirm Password" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 focus:border-green-600 focus:ring-0 text-sm font-medium transition-all bg-slate-50/30">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#16A34A] text-white py-3 rounded-lg font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-600/10 active:scale-[0.98]">
                Reset Password
            </button>
        </div>
    </form>
</x-guest-layout>