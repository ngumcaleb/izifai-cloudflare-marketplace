<x-guest-layout>
    <div class="mb-10 text-center lg:text-left">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight leading-none mb-3">Password Recovery</h2>
        <p class="text-sm font-medium text-slate-500">Enter your email and we'll send you a secure reset link.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1 group-focus-within:text-brand transition-colors">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   class="block w-full px-5 py-4 rounded-xl border-2 border-slate-100 focus:border-brand focus:ring-4 focus:ring-brand/5 transition-all text-sm font-bold text-slate-700 bg-slate-50/30 placeholder:text-slate-300" 
                   placeholder="name@company.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase tracking-widest" />
        </div>

        <div>
            <button type="submit" class="w-full bg-brand text-white py-5 rounded-xl font-black text-xs uppercase tracking-[0.2em] hover:bg-brand-700 hover:shadow-xl hover:shadow-brand/20 focus:ring-4 focus:ring-brand/10 transition-all active:scale-[0.98]">
                Send Recovery Link
            </button>
        </div>
    </form>

    <div class="mt-10 pt-8 border-t border-slate-100 text-center">
        <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 hover:text-brand transition-colors uppercase tracking-[0.2em]">
            Back to Secure Login
        </a>
    </div>
</x-guest-layout>



