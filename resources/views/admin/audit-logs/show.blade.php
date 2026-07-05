<x-admin-layout>
    <x-slot name="header">Audit Log Detail</x-slot>

    <div class="space-y-6">
        <a href="{{ route('admin.audit-logs.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-gold-500 uppercase tracking-widest transition-all">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Back to Audit Log
        </a>

        <div class="admin-card p-6 md:p-8">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-navy-700 to-navy-900 flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ strtoupper(substr($auditLog->admin?->name ?? '?', 0, 2)) }}
                </div>
                <div>
                    <h3 class="text-sm font-bold text-navy-800">{{ $auditLog->admin?->name ?? 'Deleted Admin' }}</h3>
                    <p class="text-[11px] text-slate-400 font-medium">{{ $auditLog->created_at->format('F j, Y g:i A') }}</p>
                </div>
                <div class="ml-auto">
                    <span class="inline-flex px-3 py-1.5 rounded-lg text-[10px] font-bold bg-navy-800 text-white">
                        IP: {{ $auditLog->ip_address ?? 'N/A' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Action</label>
                        <p class="text-[13px] font-bold text-navy-800 mt-1">{{ str_replace('.', ' / ', $auditLog->action) }}</p>
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Description</label>
                        <p class="text-[13px] font-medium text-slate-600 mt-1">{{ $auditLog->description }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Entity</label>
                        <p class="text-[13px] font-bold text-navy-800 mt-1">
                            @if($auditLog->entity_type)
                                {{ class_basename($auditLog->entity_type) }} #{{ $auditLog->entity_id }}
                                <span class="text-[10px] text-slate-400 font-medium">({{ $auditLog->entity_type }})</span>
                            @else
                                <span class="text-slate-400 font-medium">—</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">User Agent</label>
                        <p class="text-[11px] font-medium text-slate-500 mt-1 break-words">{{ $auditLog->user_agent ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($auditLog->old_values || $auditLog->new_values)
            <div class="mt-6 pt-6 border-t border-slate-100">
                <h4 class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Changes</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($auditLog->old_values)
                    <div>
                        <label class="text-[9px] font-bold text-rose-400 uppercase tracking-widest">Old Values</label>
                        <div class="mt-2 bg-rose-50 rounded-xl p-4">
                            <pre class="text-[11px] font-mono text-rose-800 whitespace-pre-wrap">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif
                    @if($auditLog->new_values)
                    <div>
                        <label class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest">New Values</label>
                        <div class="mt-2 bg-emerald-50 rounded-xl p-4">
                            <pre class="text-[11px] font-mono text-emerald-800 whitespace-pre-wrap">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
