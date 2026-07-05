<x-admin-layout>
    <x-slot name="header">Audit Log</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/business-team-using-laptop-discussing_53876-165548.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Audit <span class="text-gold-400">Log</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Track every admin action across the platform for security and accountability.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="flex flex-col gap-4">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search description or action..."
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <select name="admin_id" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Admins</option>
                            @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                            @endforeach
                        </select>
                        <select name="action" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ str_replace('.', ' / ', $action) }}</option>
                            @endforeach
                        </select>
                        <select name="entity_type" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="">All Entity Types</option>
                            @foreach($entityTypes as $type)
                                <option value="{{ $type }}" {{ request('entity_type') == $type ? 'selected' : '' }}>{{ class_basename($type) }}</option>
                            @endforeach
                        </select>
                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                               class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                               class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20">
                        <select name="per_page" class="px-3 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                            <option value="15" {{ request('per_page') == '15' ? 'selected' : '' }}>15</option>
                            <option value="30" {{ request('per_page') == '30' ? 'selected' : '' }}>30</option>
                            <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                        </select>
                        <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'admin_id', 'action', 'entity_type', 'date_from', 'date_to']))
                            <a href="{{ route('admin.audit-logs.index') }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">Clear</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div class="admin-card overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Time</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Admin</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Action</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Description</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Entity</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-[11px] font-medium text-slate-500">{{ $log->created_at->format('M j, H:i') }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center text-white text-[9px] font-bold shrink-0">
                                        {{ strtoupper(substr($log->admin?->name ?? '?', 0, 2)) }}
                                    </div>
                                    <span class="text-[12px] font-semibold text-navy-800">{{ $log->admin?->name ?? 'Deleted Admin' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $actionColors = [
                                        'created' => 'text-emerald-600 bg-emerald-50',
                                        'updated' => 'text-blue-600 bg-blue-50',
                                        'deleted' => 'text-rose-600 bg-rose-50',
                                        'approved' => 'text-emerald-600 bg-emerald-50',
                                        'rejected' => 'text-rose-600 bg-rose-50',
                                    ];
                                    $parts = explode('.', $log->action);
                                    $lastPart = end($parts);
                                    $actionClass = $actionColors[$lastPart] ?? 'text-slate-600 bg-slate-100';
                                @endphp
                                <span class="inline-flex px-2 py-1 rounded-md text-[10px] font-bold {{ $actionClass }}">
                                    {{ str_replace('.', ' ', $log->action) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 max-w-[250px]">
                                <p class="text-[12px] font-medium text-slate-600 truncate">{{ $log->description }}</p>
                            </td>
                            <td class="px-6 py-4">
                                @if($log->entity_type)
                                <span class="text-[11px] font-medium text-slate-500">
                                    {{ class_basename($log->entity_type) }}#{{ $log->entity_id }}
                                </span>
                                @else
                                <span class="text-[11px] text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.audit-logs.show', $log) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold hover:bg-slate-200 transition-all">
                                    <span class="material-symbols-outlined text-[14px]">visibility</span>
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">history</span>
                                    <p class="text-sm font-medium text-slate-400">No audit log entries found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-slate-100">
                @forelse($logs as $log)
                <a href="{{ route('admin.audit-logs.show', $log) }}" class="block p-4 hover:bg-slate-50 transition-all">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center text-white text-[8px] font-bold shrink-0">
                                    {{ strtoupper(substr($log->admin?->name ?? '?', 0, 2)) }}
                                </div>
                                <span class="text-[11px] font-semibold text-navy-800">{{ $log->admin?->name ?? 'Deleted Admin' }}</span>
                                <span class="text-[10px] text-slate-400 ml-auto">{{ $log->created_at->format('M j, H:i') }}</span>
                            </div>
                            <span class="inline-flex px-2 py-0.5 rounded-md text-[9px] font-bold {{ $actionColors[end($parts)] ?? 'text-slate-600 bg-slate-100' }}">
                                {{ str_replace('.', ' ', $log->action) }}
                            </span>
                            <p class="text-[11px] text-slate-600 font-medium mt-1 truncate">{{ $log->description }}</p>
                        </div>
                        <span class="material-symbols-outlined text-[16px] text-slate-300 shrink-0">chevron_right</span>
                    </div>
                </a>
                @empty
                <div class="p-12 text-center">
                    <span class="material-symbols-outlined text-3xl text-slate-300">history</span>
                    <p class="text-sm font-medium text-slate-400 mt-2">No audit log entries found</p>
                </div>
                @endforelse
            </div>

            <div class="px-6 py-4 border-t border-slate-100">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
