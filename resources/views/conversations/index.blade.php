@extends('layouts.guest')

@section('title', 'Inbox — Izifai')
@section('description', 'Your messages on Izifai')

@section('footer')
@endsection

@section('content')
<div class="fixed inset-x-0 top-[56px] sm:top-[160px] bottom-[60px] sm:bottom-0 bg-[#f5f6f5]">
    <div class="h-full w-full max-w-3xl mx-auto sm:py-5">
        <div class="h-full flex flex-col bg-white sm:border sm:border-[#e8eae8] sm:rounded-2xl sm:shadow-sm sm:overflow-hidden">

    {{-- HEADER --}}
    <div class="shrink-0 bg-white border-b border-[#e8eae8] px-3 sm:px-4 py-2.5 sm:py-3 z-10">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 sm:gap-2.5 min-w-0">
                <span class="grid place-items-center w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#f2f9df] text-[#659316] shrink-0">
                    <i class="fa-solid fa-comment text-[14px] sm:text-[15px]" style=""></i>
                </span>
                <div class="min-w-0">
                    <h1 class="text-[14px] sm:text-[15px] font-extrabold text-[#1c201e] leading-tight">Inbox</h1>
                    <p class="text-[9px] sm:text-[10px] text-[#9aa19c] leading-tight mt-0.5 truncate">Messages with buyers and sellers</p>
                </div>
            </div>
            <span class="shrink-0 inline-flex items-center gap-1.5 text-[9px] sm:text-[10px] font-bold text-[#659316] bg-[#f2f9df] px-2 sm:px-3 py-1 rounded-full border border-[#9acd32]/20 tnum">
                <i class="fa-solid fa-circle text-[4px] sm:text-[5px]" style=""></i>
                {{ $conversations->total() }} conversation{{ $conversations->total() !== 1 ? 's' : '' }}
            </span>
        </div>
    </div>

    {{-- LIST --}}
    <div class="flex-1 overflow-y-auto no-scrollbar bg-[#f5f6f5] py-1.5 sm:py-2">
        @if($conversations->count() === 0)
            <div class="h-full flex items-center justify-center px-6">
                <div class="text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 sm:mb-5 rounded-2xl bg-[#f2f9df] border border-[#9acd32]/25 flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-comment text-[22px] sm:text-[30px] text-[#659316]" style=""></i>
                    </div>
                    <h2 class="text-[15px] sm:text-lg font-extrabold text-[#1c201e]">No conversations yet</h2>
                    <p class="text-[12px] sm:text-sm text-[#9aa19c] mt-2 max-w-xs mx-auto leading-relaxed">
                        When you message a seller or a buyer messages you, conversations will appear here.
                    </p>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 mt-6 sm:mt-7 px-4 sm:px-5 py-2.5 sm:py-3 bg-[#1c201e] text-[#9acd32] rounded-xl text-[11px] sm:text-xs font-bold hover:bg-[#2a2f2b] active:scale-[0.98] transition-all shadow-sm">
                        <i class="fa-solid fa-bag-shopping text-[14px] sm:text-[16px]" style=""></i>
                        Browse Products
                    </a>
                </div>
            </div>
        @else
            <div class="px-2 space-y-1 sm:space-y-1.5">
                @foreach($conversations as $conv)
                    @php
                        $userId = auth()->id();
                        $otherUser = $conv->buyer_id === $userId ? $conv->seller : $conv->buyer;
                        $otherStore = $otherUser->store;
                        $unread = $conv->buyer_id === $userId ? $conv->buyer_unread : $conv->seller_unread;
                        $lastMsg = $conv->messages->first();
                        $lastTime = $lastMsg?->created_at?->shortAbsoluteDiffForHumans() ?? '';
                        $targetLabel = match (class_basename($conv->target_type)) {
                            'Product' => 'Product',
                            'Service' => 'Service',
                            'RentalItem' => 'Rental',
                            default => 'Store',
                        };
                        $targetName = $conv->target?->name ?? null;
                    @endphp
                    <div class="flex items-center rounded-xl sm:rounded-2xl transition-all {{ $unread > 0 ? 'bg-white shadow-[0_1px_8px_rgba(28,32,30,0.07)] ring-1 ring-[#9acd32]/25' : 'bg-white hover:bg-[#f2f9df]/70' }}">
                    <a href="{{ route('conversations.show', $conv) }}"
                       class="flex-1 min-w-0 flex items-center gap-2.5 sm:gap-3 pl-2.5 sm:pl-3 pr-0.5 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl transition-all group active:scale-[0.98]">
                        <div class="relative shrink-0">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full overflow-hidden bg-[#f2f9df] flex items-center justify-center shadow-sm ring-2 {{ $unread > 0 ? 'ring-[#9acd32]' : 'ring-[#e8eae8]' }}">
                                @if($otherStore && $otherStore->logo)
                                    <img src="{{ $otherStore->logo_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs sm:text-sm font-extrabold text-[#659316]">{{ substr($otherUser->name ?? '?', 0, 1) }}</span>
                                @endif
                            </div>
                            @if($unread > 0)
                                <span class="absolute -top-1 -right-1 min-w-4 h-4 sm:min-w-5 sm:h-5 bg-[#9acd32] text-[#1c201e] text-[9px] sm:text-[10px] font-extrabold rounded-full flex items-center justify-center px-0.5 sm:px-1 shadow-sm border-2 border-[#f5f6f5] tnum">{{ min($unread, 99) }}</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h3 class="text-[13px] sm:text-sm font-bold text-[#1c201e] truncate {{ $unread > 0 ? '' : 'text-[#3f453f]' }}">
                                    {{ $otherUser->name }}
                                </h3>
                                <span class="text-[9px] sm:text-[10px] text-[#9aa19c] shrink-0 whitespace-nowrap tnum">
                                    {{ $lastTime }}
                                </span>
                            </div>

                            <div class="flex items-center gap-1.5 sm:gap-2 mt-0.5 sm:mt-1">
                                @if($targetLabel)
                                    <span class="text-[8px] sm:text-[9px] font-bold uppercase tracking-wide text-[#659316] bg-[#f2f9df] px-1 sm:px-1.5 py-0.5 rounded-md shrink-0 leading-tight">{{ $targetLabel }}</span>
                                @endif
                                <p class="text-[11px] sm:text-xs truncate leading-tight {{ $unread > 0 ? 'font-semibold text-[#1c201e]' : 'text-[#9aa19c]' }}">
                                    @if($lastMsg)
                                        @if($lastMsg->sender_id === $userId)
                                            <span class="text-[#9aa19c]">You: </span>
                                        @endif
                                        {{ $lastMsg->body ?: '[Image]' }}
                                    @else
                                        <span class="italic text-[#b6bcb8]">No messages yet</span>
                                    @endif
                                </p>
                            </div>

                            @if($targetName)
                                <p class="text-[9px] sm:text-[10px] text-[#9aa19c]/70 truncate mt-0.5 sm:mt-1 leading-tight">{{ $targetName }}</p>
                            @endif
                        </div>

                        <form action="{{ route('conversations.destroy', $conv) }}" method="POST"
                              id="delete-conv-{{ $conv->id }}"
                              class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <i class="fa-solid fa-chevron-right text-[14px] sm:text-[16px] text-[#d4d9d5] sm:group-hover:text-[#1c201e] transition-all shrink-0" style=""></i>
                    </a>

                    <div class="shrink-0 relative pr-1.5" x-data="{ menuOpen: false, deleteOpen: false }" @click.outside="menuOpen = false">
                        <button @click.stop="menuOpen = !menuOpen; deleteOpen = false"
                                class="w-7 h-7 sm:w-8 sm:h-8 flex items-center justify-center rounded-lg text-[#9aa19c] hover:bg-[#eef2ee] hover:text-[#1c201e] active:scale-95 transition-all"
                                title="More options" aria-label="More options">
                            <i class="fa-solid fa-ellipsis-vertical text-[16px] sm:text-[18px]" style=""></i>
                        </button>

                        {{-- Dropdown menu --}}
                        <div x-show="menuOpen" x-transition x-cloak
                             class="absolute right-1.5 top-9 z-30 w-44 sm:w-48 bg-white border border-[#e8eae8] rounded-xl shadow-lg overflow-hidden">
                            <button type="button" @click.stop="menuOpen = false; deleteOpen = true"
                                    class="w-full flex items-center gap-2.5 px-3 sm:px-3.5 py-2 sm:py-2.5 text-[11px] sm:text-[12px] font-semibold text-[#dc2626] hover:bg-[#fdecec] transition-all">
                                <i class="fa-solid fa-trash text-[13px] sm:text-[14px]" style=""></i>
                                Delete conversation
                            </button>
                        </div>

                        {{-- Confirm modal --}}
                        <div x-show="deleteOpen" x-transition.opacity x-cloak
                             class="fixed inset-0 z-[200] flex items-center justify-center p-4 sm:p-6">
                            <div class="absolute inset-0 bg-[#1c201e]/50 backdrop-blur-sm" @click="deleteOpen = false"></div>
                            <div x-show="deleteOpen" x-transition x-cloak
                                 class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden">
                                <div class="p-5 sm:p-6">
                                    <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-2xl bg-[#fdecec] flex items-center justify-center mb-3.5 sm:mb-4">
                                        <i class="fa-solid fa-trash text-[18px] sm:text-[20px] text-[#dc2626]" style=""></i>
                                    </div>
                                    <h3 class="text-[14px] sm:text-base font-extrabold text-[#1c201e]">Delete conversation?</h3>
                                    <p class="text-[11px] sm:text-[13px] text-[#6b716c] mt-1.5 leading-relaxed">
                                        This will permanently remove the chat with <span class="font-bold text-[#1c201e]">{{ $otherUser->name }}</span> and all its messages. This action cannot be undone.
                                    </p>
                                    <div class="flex items-center gap-2 mt-5 sm:mt-6">
                                        <button type="button" @click="deleteOpen = false"
                                                class="flex-1 h-10 sm:h-11 rounded-xl border border-[#e8eae8] bg-white text-[#3f453f] text-[11px] sm:text-[13px] font-bold hover:border-[#1c201e] active:scale-[0.98] transition-all">
                                            Cancel
                                        </button>
                                        <button type="submit" form="delete-conv-{{ $conv->id }}"
                                                class="flex-1 h-10 sm:h-11 rounded-xl bg-[#dc2626] text-white text-[11px] sm:text-[13px] font-bold hover:bg-[#b91c1c] active:scale-[0.98] transition-all shadow-sm">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>

            @if($conversations->hasPages())
                <div class="shrink-0 px-4 py-2.5 sm:py-3 mt-1 border-t border-[#e8eae8] bg-white">
                    {{ $conversations->links() }}
                </div>
            @endif
        @endif
    </div>
        </div>
    </div>
</div>
@endsection