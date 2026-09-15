@extends('layouts.guest')

@section('title', $otherUser->name . ' — Izifai Chat')
@section('description', 'Chat with ' . $otherUser->name . ' on Izifai')

@section('footer')
@endsection

@php
$userId = auth()->id();
$store = $otherUser->store;
$whatsappNumber = $store?->whatsapp_number;
@endphp

@section('content')
<div class="fixed inset-x-0 top-[56px] sm:top-[160px] bottom-[60px] sm:bottom-0 bg-[#f5f6f5]">
    <div class="h-full w-full max-w-3xl mx-auto sm:py-5">
        <div class="h-full flex flex-col bg-white sm:border sm:border-[#e8eae8] sm:rounded-2xl sm:shadow-sm sm:overflow-hidden"
             x-data="chatWindow({{ $conversation->id }}, '{{ csrf_token() }}', {{ $userId }}, '{{ ($store?->logo_url ?: $otherUser->profile_photo_url) }}', '{{ $otherUser->name }}', '{{ (auth()->user()->store?->logo_url ?: auth()->user()->profile_photo_url) }}', '{{ auth()->user()->name }}')"
             x-init="init()">

    {{-- HEADER --}}
    <div class="shrink-0 bg-white border-b border-[#e8eae8] px-2.5 sm:px-4 py-2 sm:py-2.5 flex items-center gap-2 sm:gap-2.5 z-10">
        <a href="{{ route('conversations.index') }}" class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-xl text-[#1c201e] hover:bg-[#f2f9df] hover:text-[#659316] -ml-1 transition-all active:scale-90">
            <i class="fa-solid fa-arrow-left text-[18px] sm:text-[20px]" style=""></i>
        </a>
        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full overflow-hidden bg-[#f2f9df] flex items-center justify-center shrink-0 ring-2 ring-[#e8eae8] shadow-sm">
            @if($store && $store->logo)
                <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
            @else
                <span class="text-xs sm:text-sm font-extrabold text-[#659316]">{{ substr($otherUser->name ?? '?', 0, 1) }}</span>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-1.5 min-w-0">
                @if($store)
                    <a href="{{ route('stores.show', $store->slug) }}" class="text-[13px] sm:text-sm font-bold text-[#1c201e] truncate hover:text-[#659316] transition-colors">{{ $otherUser->name }}</a>
                @else
                    <h2 class="text-[13px] sm:text-sm font-bold text-[#1c201e] truncate">{{ $otherUser->name }}</h2>
                @endif
                @if($store && $store->is_verified)
                    <i class="fa-solid fa-circle-check text-[13px] sm:text-[14px] text-[#659316] shrink-0" style=""></i>
                @endif
            </div>
            <p class="flex items-center gap-1.5 text-[10px] sm:text-[11px] text-[#9aa19c] mt-0.5">
                <span class="w-1 h-1 sm:w-1.5 sm:h-1.5 rounded-full bg-[#8cc63f] animate-pulse" style=""></span>
                online
            </p>
        </div>
        <div class="shrink-0 relative" x-data="{ menuOpen: false, deleteOpen: false }" @click.outside="menuOpen = false">
            <button @click.stop="menuOpen = !menuOpen; deleteOpen = false"
                    class="w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center rounded-xl text-[#9aa19c] hover:bg-[#eef2ee] hover:text-[#1c201e] active:scale-90 transition-all"
                    title="More options" aria-label="More options">
                <i class="fa-solid fa-ellipsis-vertical text-[18px] sm:text-[20px]" style=""></i>
            </button>

            {{-- Dropdown menu --}}
            <div x-show="menuOpen" x-transition x-cloak
                 class="absolute right-0 top-10 sm:top-11 z-30 w-60 bg-white border border-[#e8eae8] rounded-xl shadow-lg overflow-hidden">
                @if($whatsappNumber)
                <a href="https://wa.me/{{ wa_url($whatsappNumber) }}?text={{ urlencode('Hi ' . $otherUser->name . ', I am chatting with you on Izifai.') }}"
                   target="_blank"
                   class="w-full flex items-center gap-2.5 px-3.5 py-2 whitespace-nowrap text-[12px] font-semibold text-[#1c201e] hover:bg-[#f2f9df] transition-all">
                    <span class="w-6 h-6 rounded-lg bg-[#25D366]/10 text-[#25D366] flex items-center justify-center shrink-0">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="w-[13px] h-[13px]" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </span>
                    Continue on WhatsApp
                </a>
                @endif
                <button type="button" @click.stop="menuOpen = false; deleteOpen = true"
                        class="w-full flex items-center gap-2.5 px-3.5 py-2 whitespace-nowrap text-[12px] font-semibold text-[#dc2626] hover:bg-[#fdecec] transition-all rounded-b-xl">
                    <span class="w-6 h-6 rounded-lg bg-[#fdecec] text-[#dc2626] flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-trash text-[13px]" style=""></i>
                    </span>
                    Delete conversation
                </button>
            </div>

            {{-- Hidden form + confirm modal --}}
            <form id="delete-conv-show" action="{{ route('conversations.destroy', $conversation) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>

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
                            <button type="submit" form="delete-conv-show"
                                    class="flex-1 h-10 sm:h-11 rounded-xl bg-[#dc2626] text-white text-[11px] sm:text-[13px] font-bold hover:bg-[#b91c1c] active:scale-[0.98] transition-all shadow-sm">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="flex-1 overflow-y-auto no-scrollbar bg-[#f5f6f5] px-2 sm:px-4 py-2 sm:py-3 space-y-1.5 sm:space-y-2"
         x-ref="messagesContainer"
         @scroll="handleScroll">
        <template x-for="msg in messages" :key="msg.id">
            <div>
                {{-- Inline target card --}}
                <template x-if="msg.metadata?.target">
                    <div class="flex justify-center px-4 py-1 messages-animate">
                        <a :href="msg.metadata.target.url || '#'" target="_blank"
                           class="flex items-center gap-2 sm:gap-2.5 bg-white rounded-lg sm:rounded-xl px-2.5 sm:px-3 py-2 sm:py-2.5 shadow-[0_1px_6px_rgba(28,32,30,0.06)] border border-[#e8eae8] hover:border-[#9acd32]/50 hover:shadow-md transition-all active:scale-[0.98] group w-full max-w-[240px] sm:max-w-xs">
                            <template x-if="msg.metadata.target.image">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md sm:rounded-lg overflow-hidden bg-[#f5f6f5] shrink-0 shadow-sm">
                                    <img :src="msg.metadata.target.image" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                            </template>
                            <template x-if="!msg.metadata.target.image">
                                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-md sm:rounded-lg bg-[#f2f9df] flex items-center justify-center shrink-0 shadow-sm">
                                    <i class="fa-solid fa-bag-shopping text-[15px] sm:text-[19px] text-[#9acd32]"></i>
                                </div>
                            </template>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[7px] sm:text-[8px] font-extrabold uppercase tracking-wide text-[#659316] bg-[#f2f9df] px-1 sm:px-1.5 py-0.5 rounded-md shrink-0" x-text="msg.metadata.target.label"></span>
                                    <template x-if="msg.metadata.target.price">
                                        <span class="text-[8px] sm:text-[9px] font-bold text-[#1c201e] shrink-0 tnum" x-text="numFormat(msg.metadata.target.price) + ' ' + msg.metadata.target.currency"></span>
                                    </template>
                                </div>
                                <p class="text-[10px] sm:text-[11px] font-semibold text-[#3f453f] truncate mt-0.5" x-text="msg.metadata.target.name"></p>
                            </div>
                            <i class="fa-solid fa-up-right-from-square text-[12px] sm:text-[14px] text-[#9aa19c] group-hover:text-[#1c201e] transition-colors shrink-0" style=""></i>
                        </a>
                    </div>
                </template>
                {{-- Message bubble --}}
                <div class="flex items-end gap-1.5 sm:gap-2 messages-animate" :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                    {{-- Avatar for received messages --}}
                    <template x-if="msg.sender_id !== currentUserId">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full overflow-hidden bg-[#f2f9df] flex items-center justify-center shadow-sm ring-2 ring-white shrink-0 mb-1">
                            <template x-if="otherAvatar">
                                <img :src="otherAvatar" alt="" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!otherAvatar">
                                <span class="text-[9px] sm:text-[10px] font-extrabold text-[#659316]" x-text="otherName.charAt(0)"></span>
                            </template>
                        </div>
                    </template>
                    <div class="max-w-[80%] sm:max-w-[72%]"
                         :class="msg.sender_id === currentUserId ? 'items-end' : 'items-start'">
                        <div class="px-3 py-2 sm:px-3.5 sm:py-2.5 rounded-xl sm:rounded-2xl text-[13px] sm:text-sm leading-relaxed break-words shadow-[0_1px_4px_rgba(28,32,30,0.05)] border"
                             :class="msg.sender_id === currentUserId
                                 ? 'bg-[#e8f5ce] border-[#d3eca4] text-[#1c201e] rounded-br-md sm:rounded-br-sm'
                                 : 'bg-white border-[#e8eae8] text-[#1c201e] rounded-bl-md sm:rounded-bl-sm'">
                            <p x-text="msg.body"></p>
                        </div>
                        <div class="flex items-center gap-1.5 mt-0.5 px-1"
                             :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                            <span class="text-[8px] sm:text-[9px] text-[#9aa19c] font-medium tnum"
                                  x-text="formatTime(msg.created_at)"></span>
                            <template x-if="msg.sender_id === currentUserId">
                                <i class="fa-solid fa-check-double text-[10px] sm:text-[11px]" :class="msg.read ? 'text-[#659316]' : 'text-[#b6bcb8]'"
                                      style=""></i>
                            </template>
                        </div>
                    </div>
                    {{-- Avatar for sent messages --}}
                    <template x-if="msg.sender_id === currentUserId">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-full overflow-hidden bg-[#f2f9df] flex items-center justify-center shadow-sm ring-2 ring-white shrink-0 mb-1">
                            <template x-if="myAvatar">
                                <img :src="myAvatar" alt="" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!myAvatar">
                                <span class="text-[9px] sm:text-[10px] font-extrabold text-[#659316]" x-text="myName.charAt(0)"></span>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        <template x-if="!loading && messages.length === 0">
            <div class="h-full flex items-center justify-center">
                <div class="text-center px-6">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-3 rounded-2xl bg-[#f2f9df] border border-[#9acd32]/25 flex items-center justify-center shadow-sm">
                        <i class="fa-regular fa-comment text-[22px] sm:text-[26px] text-[#659316]" style=""></i>
                    </div>
                    <p class="text-[13px] sm:text-sm font-bold text-[#3f453f]">Send a message to start</p>
                    <p class="text-[11px] sm:text-xs text-[#9aa19c] mt-1">The seller will get your message instantly.</p>
                </div>
            </div>
        </template>
        <div x-ref="scrollAnchor"></div>
    </div>

    {{-- LOADING --}}
    <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm z-20">
        <svg class="w-6 h-6 sm:w-7 sm:h-7 animate-spin text-[#659316]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
    </div>

    {{-- INPUT --}}
    <div class="shrink-0 bg-white border-t border-[#e8eae8] px-3 sm:px-4 pt-2.5 sm:pt-3 pb-2.5 sm:pb-4 z-10"
         x-data="{ focused: false }">
        <form @submit.prevent="sendMessage"
              class="group flex items-end gap-2 rounded-3xl bg-white border transition-all duration-200 pl-4 sm:pl-5 pr-2 py-2 sm:py-2.5 shadow-[0_4px_16px_rgba(28,32,30,0.06)]"
              :class="focused ? 'border-[#9acd32]/70 ring-4 ring-[#9acd32]/15 shadow-[0_6px_20px_rgba(154,205,50,0.18)]' : 'border-[#e8eae8]'">
            <textarea x-model="newMessage"
                      @keydown.enter.prevent="if(!$event.shiftKey) { sendMessage() }"
                      @focus="focused = true; lockScroll()"
                      @blur="focused = false; unlockScroll()"
                      placeholder="Write a message..."
                      rows="1"
                      class="composer-input flex-1 bg-transparent resize-none focus:outline-none text-[13px] sm:text-[14px] text-[#1c201e] leading-relaxed placeholder:text-[#b0b7b3] min-h-[26px] max-h-[120px] py-1"
                      @input="autoResize($event.target)"></textarea>
            <button type="submit"
                    :disabled="!newMessage.trim()"
                    class="composer-send shrink-0 w-9 h-9 sm:w-10 sm:h-10 rounded-full grid place-items-center transition-all duration-200 active:scale-90 hover:scale-105"
                    :class="newMessage.trim()
                        ? 'bg-[#9acd32] text-[#1c201e] shadow-[0_4px_12px_rgba(154,205,50,0.45)]'
                        : 'bg-[#eef0ee] text-[#a8afaa]'">
                <i class="fa-solid fa-paper-plane text-[14px] sm:text-[16px] transition-transform duration-200" :class="newMessage.trim() ? 'group-hover:rotate-[10deg]' : ''" style=""></i>
            </button>
        </form>
    </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    html, body {
        height: 100%;
        overflow: hidden;
        overscroll-behavior: none;
    }
    .messages-animate {
        animation: msgIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(8px) scale(0.98);
    }
    @keyframes msgIn {
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    .composer-input {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: none !important;
        outline: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        background: transparent !important;
    }
    .composer-input::-webkit-scrollbar {
        display: none;
        width: 0;
        height: 0;
    }
    .composer-input:focus,
    .composer-input:focus-visible {
        outline: none !important;
        box-shadow: none !important;
        border: none !important;
    }
    .composer-input:-webkit-autofill,
    .composer-input:-webkit-autofill:hover,
    .composer-input:-webkit-autofill:focus,
    .composer-input:-webkit-autofill:active {
        -webkit-text-fill-color: #1c201e;
        -webkit-box-shadow: 0 0 0 1000px transparent inset;
        transition: background-color 5000s ease-in-out 0s;
        caret-color: #1c201e;
    }
    .composer-send:focus,
    .composer-send:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }
</style>
<script>
    function chatWindow(conversationId, csrfToken, currentUserId, otherAvatar, otherName, myAvatar, myName) {
        return {
            conversationId,
            csrfToken,
            currentUserId,
            otherAvatar,
            otherName,
            myAvatar,
            myName,
            messages: [],
            newMessage: '',
            loading: true,
            pollInterval: null,
            lastMessageId: 0,
            isAtBottom: true,
            pendingSends: new Set(),

            init() {
                this.fetchMessages();
                this.pollInterval = setInterval(() => this.pollNewMessages(), 4000);
                this.$watch('messages', () => {
                    if (this.isAtBottom) {
                        this.$nextTick(() => this.scrollToBottom());
                    }
                });
            },

            lockScroll() {
                const docEl = document.documentElement;
                const body = document.body;
                docEl.style.overflow = 'hidden';
                body.style.overflow = 'hidden';
                docEl.style.overscrollBehavior = 'none';
                body.style.overscrollBehavior = 'none';
            },

            unlockScroll() {
                const docEl = document.documentElement;
                const body = document.body;
                docEl.style.overflow = '';
                body.style.overflow = '';
                docEl.style.overscrollBehavior = '';
                body.style.overscrollBehavior = '';
            },

            numFormat(n) {
                if (n == null) return '';
                return Number(n).toLocaleString('en-US');
            },

            async fetchMessages() {
                try {
                    const resp = await fetch(`/conversations/${this.conversationId}/fetch`);
                    const data = await resp.json();
                    this.messages = data.messages;
                    this.lastMessageId = this.messages.length > 0 ? this.messages[this.messages.length - 1].id : 0;
                    this.loading = false;
                    this.$nextTick(() => this.scrollToBottom());
                } catch (e) {
                    this.loading = false;
                }
            },

            async pollNewMessages() {
                try {
                    const resp = await fetch(`/conversations/${this.conversationId}/fetch?after=${this.lastMessageId}`);
                    const data = await resp.json();
                    if (data.messages.length > 0) {
                        const existingIds = new Set(this.messages.map(m => m.id));
                        const fresh = data.messages.filter(m => !existingIds.has(m.id));
                        if (fresh.length > 0) {
                            this.messages = [...this.messages, ...fresh];
                            this.lastMessageId = fresh[fresh.length - 1].id;
                            if (this.isAtBottom) {
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        }
                    }
                } catch (e) {}
            },

            async sendMessage() {
                const body = this.newMessage.trim();
                if (!body || this.pendingSends.size > 0) return;

                const tempId = -Date.now();
                this.pendingSends.add(tempId);

                this.messages.push({
                    id: tempId,
                    sender_id: currentUserId,
                    body: body,
                    sender_name: 'You',
                    created_at: new Date().toISOString(),
                    read: false,
                });
                this.lastMessageId = tempId;
                this.newMessage = '';
                this.$nextTick(() => this.scrollToBottom());

                try {
                    const resp = await fetch(`/conversations/${this.conversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ body }),
                    });

                    if (!resp.ok) throw new Error('Failed');

                    const data = await resp.json();
                    if (data.message) {
                        const idx = this.messages.findIndex(m => m.id === tempId);
                        if (idx !== -1) {
                            this.messages[idx] = data.message;
                        } else {
                            this.messages.push(data.message);
                        }
                        this.lastMessageId = data.message.id;
                        this.$nextTick(() => this.scrollToBottom());
                    }

                    const textarea = document.querySelector('textarea');
                    if (textarea) textarea.style.height = 'auto';
                } catch (e) {
                    this.messages = this.messages.filter(m => m.id !== tempId);
                    this.newMessage = body;
                } finally {
                    this.pendingSends.delete(tempId);
                }
            },

            scrollToBottom() {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
                this.isAtBottom = true;
            },

            handleScroll() {
                const container = this.$refs.messagesContainer;
                if (container) {
                    this.isAtBottom = container.scrollHeight - container.scrollTop - container.clientHeight < 60;
                }
            },

            autoResize(el) {
                el.style.height = 'auto';
                el.style.height = Math.min(el.scrollHeight, 100) + 'px';
            },

            formatTime(isoString) {
                if (!isoString) return '';
                const d = new Date(isoString);
                const now = new Date();
                const diff = now - d;
                const oneDay = 86400000;

                if (diff < oneDay && d.getDate() === now.getDate()) {
                    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                }
                if (diff < 2 * oneDay) return 'Yesterday';
                if (diff < 7 * oneDay) {
                    return d.toLocaleDateString([], { weekday: 'short' });
                }
                return d.toLocaleDateString([], { day: 'numeric', month: 'short' });
            },
        };
    }
</script>
@endpush