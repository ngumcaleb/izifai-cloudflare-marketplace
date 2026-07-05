<x-admin-layout>
    <x-slot name="header">Notifications</x-slot>

    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-navy-900 via-navy-800 to-navy-900"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                <span class="text-gold-400">Notifications</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Stay updated with system alerts, withdrawal requests, and reports.
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-navy-900 border border-gold-500/30 text-white p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
        <span class="text-xs font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <div class="space-y-6">
        <div class="admin-card p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.notifications.index') }}"
                       class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest transition-all {{ request('filter') !== 'unread' ? 'bg-navy-800 text-white shadow-sm' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        All
                    </a>
                    <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
                       class="px-4 py-2 rounded-lg text-xs font-bold uppercase tracking-widest transition-all {{ request('filter') === 'unread' ? 'bg-navy-800 text-white shadow-sm' : 'bg-slate-50 text-slate-500 hover:bg-slate-100' }}">
                        Unread
                        @if($unreadCount > 0)
                        <span class="ml-1.5 px-1.5 py-0.5 bg-rose-500 text-white text-[9px] rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                @if($unreadCount > 0)
                <form action="{{ route('admin.notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-[10px] font-bold text-gold-500 uppercase tracking-widest hover:text-gold-600 transition-colors">
                        Mark All as Read
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="space-y-3">
            @forelse($notifications as $notification)
            <div class="admin-card p-4 md:p-5 hover:border-gold-400/30 transition-all {{ !$notification->read ? 'border-l-4 border-l-gold-400 bg-gold-50/20' : '' }}">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                        {{ $notification->type === 'withdrawal' ? 'bg-amber-50 text-amber-500' : '' }}
                        {{ $notification->type === 'report' ? 'bg-rose-50 text-rose-500' : '' }}
                        {{ $notification->type === 'system' ? 'bg-blue-50 text-blue-500' : '' }}
                        {{ !in_array($notification->type, ['withdrawal', 'report', 'system']) ? 'bg-slate-50 text-slate-500' : '' }}">
                        <span class="material-symbols-outlined text-[20px]">
                            {{ $notification->type === 'withdrawal' ? 'account_balance' : ($notification->type === 'report' ? 'flag' : 'notifications') }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-navy-800 {{ !$notification->read ? 'text-navy-900' : '' }}">
                                    {{ $notification->title }}
                                </h4>
                                <p class="text-xs text-slate-500 mt-1">{{ $notification->message }}</p>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <span class="text-[9px] text-slate-400 font-medium whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                                @if(!$notification->read)
                                <form action="{{ route('admin.notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-6 h-6 rounded-full bg-gold-400/10 text-gold-500 flex items-center justify-center hover:bg-gold-400/20 transition-colors">
                                        <span class="material-symbols-outlined text-[14px]">check</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="admin-card p-12 text-center">
                <div class="w-16 h-16 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[32px] text-slate-300">notifications_off</span>
                </div>
                <h3 class="text-sm font-bold text-navy-800 mb-1">No notifications yet</h3>
                <p class="text-xs text-slate-400 font-medium">
                    {{ request('filter') === 'unread' ? 'You have no unread notifications.' : 'Notifications will appear here when something happens.' }}
                </p>
            </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
        <div class="admin-card p-4">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>
