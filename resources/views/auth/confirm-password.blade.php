<x-guest-layout>
    @section('title', 'Confirm Identity')

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-2">Confirm Identity</h2>
        <p class="text-sm text-slate-500">Please confirm your password to proceed.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
            </div>
            <input id="password" type="password" name="password" required placeholder="Password" class="w-full pl-12 pr-4 py-3 rounded-lg border border-slate-200 focus:border-green-600 focus:ring-0 text-sm font-medium transition-all bg-slate-50/30">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-[#16A34A] text-white py-3 rounded-lg font-bold text-sm hover:bg-green-700 transition-all shadow-lg shadow-green-600/10 active:scale-[0.98]">
                Confirm Password
            </button>
        </div>
    </form>

    <div class="mt-10 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs font-bold text-slate-400 uppercase tracking-widest hover:text-red-600 transition-colors">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>