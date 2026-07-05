<x-admin-layout>
    <x-slot name="header">Profile</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Admin <span class="text-gold-400">Profile</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Manage your account details and security credentials.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="admin-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                    <i data-lucide="user" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-navy-800">Profile Information</h3>
                    <p class="text-[10px] text-slate-400 font-medium">Update your name and email</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('name') ring-2 ring-rose-300 @enderror">
                    @error('name')
                    <p class="text-[9px] text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                           class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('email') ring-2 ring-rose-300 @enderror">
                    @error('email')
                    <p class="text-[9px] text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                    Save Changes
                </button>
            </form>
        </div>

        <div class="admin-card p-6 md:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <i data-lucide="lock" class="w-5 h-5"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-navy-800">Change Password</h3>
                    <p class="text-[10px] text-slate-400 font-medium">Update your password</p>
                </div>
            </div>

            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Current Password</label>
                    <input type="password" name="current_password"
                           class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('current_password') ring-2 ring-rose-300 @enderror">
                    @error('current_password')
                    <p class="text-[9px] text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">New Password</label>
                    <input type="password" name="password"
                           class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('password') ring-2 ring-rose-300 @enderror">
                    @error('password')
                    <p class="text-[9px] text-rose-500 font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                </div>
                <button type="submit" class="w-full py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</x-admin-layout>
