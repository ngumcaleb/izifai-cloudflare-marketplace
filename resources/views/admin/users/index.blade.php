<x-admin-layout>
    <x-slot name="header">User Database</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/group-diverse-people-social-network-concept_53876-121016.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                User <span class="text-gold-400">Database</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Manage account access, verify seller identities, and monitor platform activity.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <!-- Search & Filters -->
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Search by name, email..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                    <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                </div>
                <div class="flex gap-2">
                    <select name="role" class="px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                        <option value="">All Roles</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Public Users</option>
                        <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Sellers</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm grow md:grow-0">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
        <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
        </div>
        @endif

        <!-- Users List -->
        <div class="admin-card overflow-hidden">
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Identity</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Role</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Business</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-xs text-navy-800 border border-slate-100 shrink-0">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $user->name }}</h4>
                                        <p class="text-[10px] text-slate-400 font-medium truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-bold uppercase rounded border border-rose-100">Admin</span>
                                @elseif($user->role === 'seller')
                                    <span class="px-2 py-0.5 bg-gold-50 text-gold-600 text-[8px] font-bold uppercase rounded border border-gold-100">Seller</span>
                                @else
                                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-bold uppercase rounded border border-blue-100">Public</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'suspended')
                                    <span class="px-2 py-0.5 bg-rose-500 text-white text-[8px] font-bold uppercase rounded">Suspended</span>
                                @else
                                    <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($user->store)
                                    <span class="text-[11px] font-bold text-navy-800">{{ $user->store->name }}</span>
                                @else
                                    <span class="text-[10px] text-slate-400 italic">None</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                @if($user->role !== 'admin')
                                <div class="flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.users.status', $user) }}" method="POST">
                                        @csrf
                                        <button class="p-2 bg-slate-50 {{ $user->status === 'active' ? 'text-amber-500 hover:bg-amber-500' : 'text-emerald-500 hover:bg-emerald-500' }} hover:text-white rounded-lg transition-all" title="{{ $user->status === 'active' ? 'Suspend' : 'Activate' }}">
                                            <i data-lucide="{{ $user->status === 'active' ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Permanently delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No users found in database.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List (Cards) -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($users as $user)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-xs text-navy-800 border border-slate-100 shrink-0">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $user->name }}</h4>
                            <div class="flex gap-1.5 mt-0.5">
                                <span class="px-1 py-0.5 bg-slate-50 text-slate-500 text-[7px] font-bold uppercase rounded">{{ $user->role }}</span>
                                @if($user->status === 'suspended')
                                    <span class="px-1 py-0.5 bg-rose-500 text-white text-[7px] font-bold uppercase rounded">Suspended</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if($user->role !== 'admin')
                    <div class="flex gap-2 shrink-0">
                        <form action="{{ route('admin.users.status', $user) }}" method="POST">
                            @csrf
                            <button class="p-2 bg-slate-50 {{ $user->status === 'active' ? 'text-amber-500' : 'text-emerald-500' }} rounded-lg">
                                <i data-lucide="{{ $user->status === 'active' ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No users found.</div>
                @endforelse
            </div>
        </div>

        @if($users->hasPages())
        <div class="mt-4">
            {{ $users->links('partials.pagination') }}
        </div>
        @endif
    </div>
</x-admin-layout>
