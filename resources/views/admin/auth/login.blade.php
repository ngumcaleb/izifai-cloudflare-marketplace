@extends('layouts.auth')

@section('title', 'Admin Login — Izifai')

@section('content')

    {{-- ADMIN LOGIN: Full-screen dark themed --}}
    <div class="fixed inset-0 bg-[#0A1D37] flex items-center justify-center p-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-green-500 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[400px] h-[400px] bg-blue-500 rounded-full blur-[100px]"></div>
        </div>

        <div class="w-full max-w-md relative z-10">
            <div class="text-center mb-10">
                <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 px-4 py-2 rounded-full backdrop-blur-md mb-6">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-white text-[10px] font-black uppercase tracking-[0.2em]">Secure Gateway</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight mb-2">Admin Control Panel</h1>
                <p class="text-slate-400 text-sm font-medium">Authentication required to access Izifai marketplace systems.</p>
            </div>

            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-2xl shadow-2xl">
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-[10px] font-black text-slate-300 uppercase tracking-widest mb-2">Admin Identifier</label>
                        <input id="email" class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium text-sm" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@izifai.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-[10px] font-black text-slate-300 uppercase tracking-widest">Access Key</label>
                        </div>
                        <input id="password" class="block w-full px-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all font-medium text-sm" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                    </div>

                    <div class="block mb-8">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded bg-white/5 border-white/10 text-green-500 shadow-sm focus:ring-green-500" name="remember">
                            <span class="ml-2 text-sm text-slate-300 font-medium">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-black text-sm uppercase tracking-widest py-4 rounded-xl shadow-lg shadow-green-500/20 transition-all active:scale-[0.98]">
                        Authorize Access
                    </button>
                </form>
            </div>

            <div class="text-center mt-8">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Izifai Marketplace &copy; {{ date('Y') }}</p>
            </div>
        </div>
    </div>

@endsection
