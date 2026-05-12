<x-admin-layout>
    <x-slot name="header">Report Details</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center gap-2 text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] hover:text-navy-800 transition-colors px-1">
            <i data-lucide="chevron-left" class="w-3 h-3"></i>
            Back to Queue
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Report Content -->
        <div class="lg:col-span-2 space-y-6">
            <div class="relative bg-navy-800 rounded-xl overflow-hidden shadow-sm p-5 md:p-8">
                <div class="absolute top-4 right-4">
                    <span class="px-2 py-0.5 bg-rose-500 text-white text-[7px] font-bold uppercase rounded tracking-widest">High Priority</span>
                </div>
                <div class="relative z-10">
                    <h2 class="text-lg md:text-2xl font-bold text-white tracking-tight">
                        Issue #{{ substr($report->id, 0, 8) }}
                    </h2>
                    <p class="text-[9px] md:text-sm text-slate-400 font-medium mt-1">
                        Resolution tracking for "{{ $report->reason }}"
                    </p>
                </div>
            </div>

            <!-- Subject Details -->
            <div class="admin-card p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xs md:text-sm font-bold text-navy-800 uppercase tracking-widest">Reported Content</h3>
                    <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[9px] font-bold uppercase rounded-lg tracking-wider">{{ $type }}</span>
                </div>

                @if($type === 'product')
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-6 p-4 bg-slate-50 rounded-xl">
                        <div class="w-20 h-20 md:w-32 md:h-32 bg-white rounded-lg overflow-hidden shrink-0 border border-slate-100 shadow-sm">
                            @if($report->product->mainImage)
                                <img src="{{ asset('storage/' . $report->product->mainImage->path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-lucide="package" class="w-8 h-8"></i>
                                </div>
                            @endif
                        </div>
                        <div class="text-center sm:text-left min-w-0">
                            <h3 class="text-xs md:text-lg font-bold text-navy-800 truncate mb-1">{{ $report->product->name }}</h3>
                            <p class="text-[8px] md:text-xs text-slate-500 font-medium mb-3 uppercase tracking-wider">Store: {{ $report->product->store->name }}</p>
                            <span class="inline-flex items-center gap-1.5 text-[8px] md:text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                                Public Listing (Removed)
                            </span>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row items-center gap-4 md:gap-6 p-4 bg-slate-50 rounded-xl">
                        <div class="w-16 h-16 md:w-24 md:h-24 bg-navy-800 rounded-lg shadow-sm flex items-center justify-center text-white font-bold text-lg md:text-2xl shrink-0">
                            {{ substr($report->store->name, 0, 1) }}
                        </div>
                        <div class="text-center sm:text-left min-w-0">
                            <h3 class="text-xs md:text-lg font-bold text-navy-800 truncate mb-1">{{ $report->store->name }}</h3>
                            <p class="text-[8px] md:text-xs text-slate-500 font-medium mb-3 uppercase tracking-wider">Owner: {{ $report->store->user->name }}</p>
                            <span class="inline-flex items-center gap-1.5 text-[8px] md:text-[9px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                                <i data-lucide="external-link" class="w-3 h-3"></i>
                                Storefront (Removed)
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Complaint Details -->
                <div class="mt-8 space-y-4">
                    <div class="p-5 border border-slate-100 rounded-xl bg-white">
                        <h4 class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Reporter's Statement</h4>
                        <p class="text-[11px] md:text-xs text-navy-800 leading-relaxed font-medium">
                            {{ $report->details ?? 'No additional details provided by the reporter.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Reporter Info -->
            <div class="admin-card p-6">
                <h4 class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Reporter Information</h4>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs uppercase">
                        {{ substr($report->user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] md:text-xs font-bold text-navy-800 truncate">{{ $report->user->name }}</p>
                        <p class="text-[9px] text-slate-400 font-medium">{{ $report->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Management -->
            <div class="admin-card p-6">
                <h4 class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-4">Resolution Actions</h4>
                
                <div class="space-y-3">
                    <form action="{{ route('admin.reports.action', ['type' => $type, 'id' => $report->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="resolve">
                        <button type="submit" class="w-full py-3 bg-emerald-600 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-sm">
                            Mark as Resolved
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.reports.action', ['type' => $type, 'id' => $report->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="dismiss">
                        <button type="submit" class="w-full py-3 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">
                            Dismiss Report
                        </button>
                    </form>

                    <div class="pt-4 border-t border-slate-100 mt-4">
                        <div class="bg-rose-50 p-4 rounded-xl border border-rose-100">
                            <p class="text-[9px] text-rose-500 font-bold uppercase tracking-widest mb-3">Danger Zone</p>
                            <form action="{{ route('admin.reports.action', ['type' => $type, 'id' => $report->id]) }}" method="POST" onsubmit="return confirm('This action cannot be undone.')">
                                @csrf
                                <input type="hidden" name="action" value="delete">
                                <button type="submit" class="w-full py-3 border border-rose-200 text-rose-500 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all">
                                    {{ $type === 'product' ? 'Delete Listing' : 'Suspend Store' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
