<x-admin-layout>
    <x-slot name="header">Edit Admin</x-slot>

    <div class="space-y-6">
        <a href="{{ route('admin.admin-management.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-gold-500 uppercase tracking-widest transition-all">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Back to Admin Management
        </a>

        <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
            <img src="https://img.freepik.com/free-photo/business-team-using-laptop-discussing_53876-165548.jpg"
                 class="absolute inset-0 w-full h-full object-cover opacity-10">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
            <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Edit <span class="text-gold-400">Admin</span>
                </h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                    Update admin account details and role.
                </p>
            </div>
        </div>

        @if(session('error'))
        <div class="bg-rose-500 text-white p-4 rounded-xl shadow-lg flex items-center gap-4">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="text-xs font-bold">{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('admin.admin-management.update', $admin) }}" method="POST" class="space-y-6">
            @csrf @method('PUT')

            <div class="admin-card p-6 md:p-8">
                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-6">Account Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all @error('name') ring-2 ring-rose-200 @enderror"
                               placeholder="John Doe">
                        @error('name')
                            <p class="text-[10px] font-medium text-rose-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all @error('email') ring-2 ring-rose-200 @enderror"
                               placeholder="admin@izifai.com">
                        @error('email')
                            <p class="text-[10px] font-medium text-rose-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Role</label>
                        <select name="role" required
                                class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all @error('role') ring-2 ring-rose-200 @enderror">
                            <option value="super_admin" {{ old('role', $admin->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ old('role', $admin->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="support" {{ old('role', $admin->role) == 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                        @error('role')
                            <p class="text-[10px] font-medium text-rose-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1 mb-1.5">Current Role</p>
                        @php
                            $roleLabels = ['super_admin' => 'Super Admin', 'admin' => 'Admin', 'support' => 'Support'];
                            $roleColors = ['super_admin' => 'bg-amber-100 text-amber-700', 'admin' => 'bg-blue-100 text-blue-700', 'support' => 'bg-emerald-100 text-emerald-700'];
                        @endphp
                        <span class="inline-flex px-3 py-1.5 rounded-lg text-[11px] font-bold border {{ $roleColors[$admin->role] ?? 'bg-slate-100 text-slate-600' }} border-current">
                            {{ $roleLabels[$admin->role] ?? ucfirst($admin->role) }}
                        </span>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">
                            New Password
                            <span class="text-slate-300 font-normal normal-case">(leave blank to keep current)</span>
                        </label>
                        <input type="password" name="password"
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all @error('password') ring-2 ring-rose-200 @enderror"
                               placeholder="Min. 8 characters">
                        @error('password')
                            <p class="text-[10px] font-medium text-rose-500 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all"
                               placeholder="Repeat password">
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.admin-management.index') }}"
                   class="px-6 py-3 bg-slate-100 text-slate-500 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-gold-500 text-navy-900 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-gold-400 transition-all shadow-sm">
                    <span class="material-symbols-outlined text-[16px] align-middle mr-1">save</span>
                    Update Admin
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
