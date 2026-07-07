@extends('layouts.guest')
@section('title', 'Notifications — Izifai')
@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 md:py-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="text-[11px] text-gray-500 mt-0.5">Stay updated on your orders, messages, and activity</p>
        </div>
        @if($notifications->where('read', false)->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">done_all</span>
                    Mark All Read
                </button>
            </form>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-4 flex items-center gap-3 animate-slide-down">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            <p class="text-sm font-semibold text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="space-y-1">
        @forelse($notifications as $notification)
            @php
                $notifUrl = $notification->data['url'] ?? match($notification->type) {
                    'order' => route('orders.show', $notification->data['order_id'] ?? 0),
                    'payment' => route('orders.show', $notification->data['order_id'] ?? 0),
                    'message' => route('conversations.show', $notification->data['conversation_id'] ?? 0),
                    'review' => $notification->data['product_id'] ?? null
                        ? route('products.show', \App\Models\Product::find($notification->data['product_id'])?->slug ?? '')
                        : ($notification->data['service_id'] ?? null
                            ? route('services.show', \App\Models\Service::find($notification->data['service_id'])?->slug ?? '')
                            : null),
                    'withdrawal' => route('seller.wallet.transactions'),
                    default => null,
                };
            @endphp
            <div class="bg-white rounded-2xl p-4 shadow-sm border transition-all hover:shadow-md {{ $notification->read ? 'border-gray-100/80' : 'border-primary/10 bg-primary/[0.02]' }}">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl {{ $notification->read ? 'bg-gray-50 text-gray-400' : 'bg-primary/10 text-primary' }} flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[18px]">
                            {{ match($notification->type) { 'order' => 'shopping_bag', 'payment' => 'payments', 'message' => 'chat', 'review' => 'star', 'promotion' => 'campaign', 'withdrawal' => 'account_balance_wallet', default => 'notifications' } }}
                        </span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <div>
                                <p class="text-sm font-bold {{ !$notification->read ? 'text-primary' : 'text-gray-900' }}">{{ $notification->title }}</p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $notification->message }}</p>
                            </div>
                            <span class="text-[10px] text-gray-400 shrink-0 whitespace-nowrap">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex items-center gap-3 mt-2">
                            @if($notifUrl)
                                <a href="{{ $notifUrl }}" class="text-[10px] font-semibold text-primary hover:underline">View Details</a>
                            @endif
                            @if(!$notification->read)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-semibold text-gray-400 hover:text-gray-600 underline">Mark as read</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl p-12 shadow-sm border border-gray-100/80 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl text-gray-300">notifications_none</span>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No notifications</h3>
                <p class="text-sm text-gray-500 mt-1">You're all caught up!</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="mt-6">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
