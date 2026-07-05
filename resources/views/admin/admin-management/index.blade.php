<x-admin-layout>
    <x-slot name="header">Admin Management</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/business-team-using-laptop-discussing_53876-165548.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Admin <span class="text-gold-400">Management</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Create, edit, and manage admin panel accounts and their roles.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.admin-management.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by name or email..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="role" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Roles</option>
                            <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="support" {{ request('role') == 'support' ? 'selected' : '' }}>Support</option>
                        </select>
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10</option>
                            <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'role']))
                            <a href="{{ route('admin.admin-management.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.admin-management.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-navy-900 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-gold-400 transition-all shadow-sm">
                <span class="material-symbols-outlined text-[16px]">add</span>
                New Admin
            </a>
        </div>

        @if(session('success'))
        <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-rose-500 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-200"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('error') }}</span>
        </div>
        @endif

        <div class="admin-card overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    @php
                        $roleColors = [
                            'super_admin' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'admin' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'support' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        ];
                        $roleLabels = [
                            'super_admin' => 'Super Admin',
                            'admin' => 'Admin',
                            'support' => 'Support',
                        ];
                    @endphp
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Admin</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Email</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Role</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Joined</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($admin->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-bold text-navy-800">{{ $admin->name }}</p>
                                        <p class="text-[9px] text-slate-400 font-medium">ID: #{{ $admin->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[12px] font-medium text-slate-600">{{ $admin->email }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $roleColors[$admin->role] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ $roleLabels[$admin->role] ?? ucfirst($admin->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-[12px] font-medium text-slate-500">{{ $admin->created_at->format('M j, Y') }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.admin-management.edit', $admin) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold hover:bg-slate-200 transition-all">
                                        <span class="material-symbols-outlined text-[14px]">edit</span>
                                        Edit
                                    </a>
                                    @if($admin->id !== auth('admin')->id())
                                    <form action="{{ route('admin.admin-management.destroy', $admin) }}" method="POST"
                                          onsubmit="return confirm('Delete this admin account? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-bold hover:bg-rose-100 transition-all">
                                            <span class="material-symbols-outlined text-[14px]">delete</span>
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">shield_person</span>
                                    <p class="text-sm font-medium text-slate-400">No admin accounts found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-100">
                @forelse($admins as $admin)
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center text-white text-xs font-bold shrink-0">
                            {{ strtoupper(substr($admin->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="text-[13px] font-bold text-navy-800">{{ $admin->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium">{{ $admin->email }}</p>
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[9px] font-bold border {{ $roleColors[$admin->role] ?? 'bg-slate-100 text-slate-600' }} mt-1">
                                {{ $roleLabels[$admin->role] ?? ucfirst($admin->role) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.admin-management.edit', $admin) }}"
                           class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </a>
                        @if($admin->id !== auth('admin')->id())
                        <form action="{{ route('admin.admin-management.destroy', $admin) }}" method="POST"
                              onsubmit="return confirm('Delete this admin account?')">
                            @csrf @method('DELETE')
                            <button class="p-2 bg-rose-50 text-rose-600 rounded-lg hover:bg-rose-100 transition-all">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-3xl text-slate-300">shield_person</span>
                    <p class="text-sm font-medium text-slate-400 mt-2">No admin accounts found</p>
                </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
