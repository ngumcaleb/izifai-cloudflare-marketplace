@extends('layouts.guest')

@section('title', 'Inbox — Izifai')
@section('description', 'Your messages on Izifai')

@section('content')
<div class="fixed inset-x-0 top-[112px] bottom-[72px] sm:relative sm:inset-x-auto sm:top-auto sm:bottom-auto sm:max-w-3xl sm:mx-auto sm:w-full sm:h-[calc(100dvh-124px)] sm:my-0 sm:rounded-2xl sm:shadow-sm sm:border sm:border-outline-variant/10 sm:overflow-hidden flex flex-col"
     style="background-color: #efeae2; background-image: url('data:image/svg+xml,%3Csvg width%3D%2228%22 height%3D%2249%22 xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath d%3D%22M28 18L14 35L0 18L14 1Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3Cpath d%3D%22M28 32L14 49L0 32L14 15Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3C%2Fsvg%3E'); background-size: 28px 49px;">

    {{-- HEADER --}}
    <div class="shrink-0 bg-white/95 backdrop-blur-md border-b border-black/5 px-4 py-3 z-10">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-bold text-on-surface">Inbox</h1>
            <span class="text-[11px] font-medium text-on-surface-variant/50">{{ $conversations->total() }} conversation{{ $conversations->total() !== 1 ? 's' : '' }}</span>
        </div>
    </div>

    {{-- LIST --}}
    <div class="flex-1 overflow-y-auto no-scrollbar py-1">
        @if($conversations->count() === 0)
            <div class="h-full flex items-center justify-center px-6">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/70 flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[32px] text-black/20">chat_bubble</span>
                    </div>
                    <h2 class="text-base font-bold text-black/50">No conversations yet</h2>
                    <p class="text-sm text-black/30 mt-1.5 max-w-xs mx-auto">When you message a seller or a buyer messages you, conversations will appear here.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 mt-6 px-5 py-2.5 bg-primary text-on-primary rounded-xl text-xs font-bold hover:opacity-90 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[16px]">shopping_bag</span>
                        Browse Products
                    </a>
                </div>
            </div>
        @else
            <div class="px-2 space-y-0.5">
                @foreach($conversations as $conv)
                    @php
                        $userId = auth()->id();
                        $otherUser = $conv->buyer_id === $userId ? $conv->seller : $conv->buyer;
                        $otherStore = $otherUser->store;
                        $unread = $conv->buyer_id === $userId ? $conv->buyer_unread : $conv->seller_unread;
                        $lastMsg = $conv->messages->first();
                        $targetLabel = match (class_basename($conv->target_type)) {
                            'Product' => 'Product',
                            'Service' => 'Service',
                            'RentalItem' => 'Rental',
                            default => 'Store',
                        };
                        $targetName = $conv->target?->name ?? null;
                    @endphp
                    <a href="{{ route('conversations.show', $conv) }}"
                       class="flex items-center gap-3 px-3 py-3 rounded-xl transition-all {{ $unread > 0 ? 'bg-white/70 hover:bg-white/90 shadow-sm' : 'hover:bg-white/40' }} group active:scale-[0.98]">
                        <div class="relative shrink-0">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-white/80 flex items-center justify-center shadow-sm ring-2 {{ $unread > 0 ? 'ring-primary' : 'ring-white' }}">
                                @if($otherStore && $otherStore->logo)
                                    <img src="{{ $otherStore->logo_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <span class="text-sm font-bold text-on-surface-variant/60">{{ substr($otherUser->name ?? '?', 0, 1) }}</span>
                                @endif
                            </div>
                            @if($unread > 0)
                                <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-primary text-on-primary text-[10px] font-bold rounded-full flex items-center justify-center shadow-sm border-2 border-white">{{ min($unread, 99) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-sm font-bold text-on-surface truncate {{ $unread > 0 ? '' : '' }}">
                                    {{ $otherUser->name }}
                                </h3>
                                <span class="text-[10px] text-on-surface-variant/40 shrink-0 whitespace-nowrap">
                                    {{ $lastMsg?->created_at?->diffForHumans() ?? '' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                @if($targetName || $targetLabel)
                                    <span class="text-[9px] font-semibold text-primary/60 bg-primary/5 px-1.5 py-0.5 rounded-md shrink-0 leading-tight">{{ $targetName ? $targetLabel : '' }}</span>
                                @endif
                                <p class="text-xs text-on-surface-variant truncate leading-tight {{ $unread > 0 ? 'font-semibold text-on-surface' : '' }}">
                                    @if($lastMsg)
                                        @if($lastMsg->sender_id === $userId)
                                            <span class="text-on-surface-variant/40">You: </span>
                                        @endif
                                        {{ $lastMsg->body ?: '[Image]' }}
                                    @else
                                        <span class="italic text-on-surface-variant/30">No messages yet</span>
                                    @endif
                                </p>
                            </div>
                            @if($targetName)
                                <p class="text-[10px] text-on-surface-variant/40 truncate mt-0.5 leading-tight">{{ $targetName }}</p>
                            @endif
                        </div>
                        <form action="{{ route('conversations.destroy', $conv) }}" method="POST"
                              onsubmit="return confirm('Delete this conversation?')"
                              class="opacity-0 group-hover:opacity-100 transition-all shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-on-surface-variant/30 hover:text-error hover:bg-error/10 transition-all"
                                    title="Delete conversation">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                        <span class="material-symbols-outlined text-[18px] text-on-surface-variant/20 group-hover:text-on-surface-variant/40 transition-all shrink-0">chevron_right</span>
                    </a>
                @endforeach
            </div>

            @if($conversations->hasPages())
                <div class="shrink-0 px-4 py-3 border-t border-black/5 bg-white/50">
                    {{ $conversations->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
