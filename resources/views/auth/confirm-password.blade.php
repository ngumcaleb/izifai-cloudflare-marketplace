<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900">Confirm access</h2>
        <p class="text-sm text-slate-500 mt-2">This is a secure area. Please confirm your password to continue.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                   class="block w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all text-slate-900 bg-white" 
                   placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs" />
        </div>

        <div>
            <button type="submit" class="w-full bg-brand text-white py-3.5 rounded-lg font-bold text-sm hover:bg-brand-700 transition-all active:scale-[0.99] shadow-sm">
                Confirm Password
            </button>
        </div>
    </form>
</x-guest-layout>


