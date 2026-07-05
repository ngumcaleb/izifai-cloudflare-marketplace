@extends('layouts.guest')

@section('title', $otherUser->name . ' — Izifai Chat')
@section('description', 'Chat with ' . $otherUser->name . ' on Izifai')

@php
$userId = auth()->id();
$store = $otherUser->store;
$whatsappNumber = $store?->whatsapp_number;
@endphp

@section('content')
<div class="fixed inset-x-0 top-[112px] bottom-[72px] sm:relative sm:inset-x-auto sm:top-auto sm:bottom-auto sm:max-w-3xl sm:mx-auto sm:w-full sm:h-[calc(100dvh-124px)] sm:my-0 sm:rounded-2xl sm:shadow-sm sm:border sm:border-outline-variant/10 sm:overflow-hidden flex flex-col"
     style="background-color: #efeae2; background-image: url('data:image/svg+xml,%3Csvg width%3D%2228%22 height%3D%2249%22 xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath d%3D%22M28 18L14 35L0 18L14 1Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3Cpath d%3D%22M28 32L14 49L0 32L14 15Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3C%2Fsvg%3E'); background-size: 28px 49px;"
     x-data="chatWindow({{ $conversation->id }}, '{{ csrf_token() }}', {{ $userId }}, '{{ ($store->logo_url ?? '') }}', '{{ $otherUser->name }}')"
     x-init="init()">

    {{-- HEADER --}}
    <div class="shrink-0 bg-white/95 backdrop-blur-md border-b border-black/5 px-4 py-2.5 flex items-center gap-3 z-10">
        <a href="{{ route('conversations.index') }}" class="w-8 h-8 flex items-center justify-center rounded-xl text-on-surface-variant hover:bg-black/5 transition-all -ml-1.5 active:scale-90">
            <span class="material-symbols-outlined text-[22px]">arrow_back</span>
        </a>
        <div class="w-9 h-9 rounded-full overflow-hidden bg-surface-container-high flex items-center justify-center shrink-0 ring-2 ring-white shadow-sm">
            @if($store && $store->logo)
                <img src="{{ $store->logo_url }}" alt="" class="w-full h-full object-cover">
            @else
                <span class="text-sm font-bold text-on-surface-variant">{{ substr($otherUser->name ?? '?', 0, 1) }}</span>
            @endif
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                @if($store)
                    <a href="{{ route('stores.show', $store->slug) }}" class="text-sm font-bold text-on-surface truncate hover:text-primary transition-colors">{{ $otherUser->name }}</a>
                @else
                    <h2 class="text-sm font-bold text-on-surface truncate">{{ $otherUser->name }}</h2>
                @endif
                @if($store && $store->is_verified)
                    <span class="material-symbols-outlined text-[14px] text-primary shrink-0" style="font-variation-settings: 'FILL' 1;">verified</span>
                @endif
            </div>
            <p class="text-[11px] text-on-surface-variant/50">online</p>
        </div>
        <form action="{{ route('conversations.destroy', $conversation) }}" method="POST"
              onsubmit="return confirm('Delete this conversation?')"
              class="shrink-0">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="w-9 h-9 flex items-center justify-center rounded-xl text-on-surface-variant/30 hover:text-error hover:bg-error/10 transition-all active:scale-90"
                    title="Delete conversation">
                <span class="material-symbols-outlined text-[18px]">delete</span>
            </button>
        </form>
        @if($whatsappNumber)
            <a href="https://wa.me/{{ wa_url($whatsappNumber) }}?text={{ urlencode('Hi ' . $otherUser->name . ', I am chatting with you on Izifai.') }}"
               target="_blank"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all shrink-0 active:scale-90"
               title="Continue on WhatsApp">
                <svg viewBox="0 0 24 24" fill="currentColor" class="w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c 0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            </a>
        @endif
    </div>

    {{-- MESSAGES --}}
    <div class="flex-1 overflow-y-auto no-scrollbar px-3 sm:px-4 py-3 space-y-2"
         x-ref="messagesContainer"
         @scroll="handleScroll">
        <template x-for="msg in messages" :key="msg.id">
            <div>
                {{-- Inline target card --}}
                <template x-if="msg.metadata?.target">
                    <div class="flex justify-center px-4 py-1 messages-animate">
                        <a :href="msg.metadata.target.url || '#'" target="_blank"
                           class="flex items-center gap-2.5 bg-white/90 backdrop-blur-sm rounded-xl px-3 py-2.5 shadow-sm border border-black/5 hover:bg-white transition-all active:scale-[0.98] group w-full max-w-xs">
                            <template x-if="msg.metadata.target.image">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-surface-container-high shrink-0 shadow-sm">
                                    <img :src="msg.metadata.target.image" alt="" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                </div>
                            </template>
                            <template x-if="!msg.metadata.target.image">
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center shrink-0 shadow-sm">
                                    <span class="material-symbols-outlined text-[20px] text-primary/40">shopping_bag</span>
                                </div>
                            </template>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[8px] font-semibold text-primary/60 bg-primary/5 px-1.5 py-0.5 rounded-md shrink-0" x-text="msg.metadata.target.label"></span>
                                    <template x-if="msg.metadata.target.price">
                                        <span class="text-[9px] font-bold text-on-surface shrink-0" x-text="numFormat(msg.metadata.target.price) + ' ' + msg.metadata.target.currency"></span>
                                    </template>
                                </div>
                                <p class="text-[11px] font-semibold text-on-surface truncate mt-0.5" x-text="msg.metadata.target.name"></p>
                            </div>
                            <span class="material-symbols-outlined text-[14px] text-on-surface-variant/30 group-hover:text-on-surface-variant/60 shrink-0">open_in_new</span>
                        </a>
                    </div>
                </template>
                {{-- Message bubble --}}
                <div class="flex items-end gap-2 messages-animate" :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                    {{-- Avatar for received messages --}}
                    <template x-if="msg.sender_id !== currentUserId">
                        <div class="w-7 h-7 rounded-full overflow-hidden bg-white/80 flex items-center justify-center shadow-sm ring-2 ring-white shrink-0 mb-1">
                            <template x-if="otherAvatar">
                                <img :src="otherAvatar" alt="" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!otherAvatar">
                                <span class="text-[10px] font-bold text-on-surface-variant/60" x-text="otherName.charAt(0)"></span>
                            </template>
                        </div>
                    </template>
                    <div class="max-w-[78%] sm:max-w-[72%]"
                         :class="msg.sender_id === currentUserId ? 'items-end' : 'items-start'">
                        <div class="px-3.5 py-2.5 rounded-2xl text-sm leading-relaxed break-words shadow-sm"
                             :class="msg.sender_id === currentUserId
                                 ? 'bg-[#d9fdd3] text-gray-900 rounded-br-sm'
                                 : 'bg-white text-gray-900 rounded-bl-sm'">
                            <p x-text="msg.body"></p>
                        </div>
                        <div class="flex items-center gap-1.5 mt-0.5 px-1"
                             :class="msg.sender_id === currentUserId ? 'justify-end' : 'justify-start'">
                            <span class="text-[9px] text-black/30 font-medium"
                                  x-text="formatTime(msg.created_at)"></span>
                            <template x-if="msg.sender_id === currentUserId">
                                <span class="material-symbols-outlined text-[11px]"
                                      :class="msg.read ? 'text-[#53bdeb]' : 'text-black/25'"
                                      style="font-variation-settings: 'FILL' 1;">done_all</span>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template x-if="!loading && messages.length === 0">
            <div class="h-full flex items-center justify-center">
                <div class="text-center px-6">
                    <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-white/70 flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[28px] text-black/20">chat_bubble_outline</span>
                    </div>
                    <p class="text-sm font-semibold text-black/40">Send a message to start</p>
                </div>
            </div>
        </template>
        <div x-ref="scrollAnchor"></div>
    </div>

    {{-- LOADING --}}
    <div x-show="loading" class="absolute inset-0 flex items-center justify-center bg-[#efeae2]/80 z-20" style="background-image: url('data:image/svg+xml,%3Csvg width%3D%2228%22 height%3D%2249%22 xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath d%3D%22M28 18L14 35L0 18L14 1Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3Cpath d%3D%22M28 32L14 49L0 32L14 15Z%22 fill%3D%22none%22 stroke%3D%22rgba(0%2C0%2C0%2C0.027)%22 stroke-width%3D%221.2%22%2F%3E%3C%2Fsvg%3E'); background-size: 28px 49px;">
        <svg class="w-7 h-7 animate-spin text-primary" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
    </div>

    {{-- INPUT --}}
    <div class="shrink-0 px-3 sm:px-4 pb-3 pt-1 z-10"
         x-data="{ focused: false }">
        <form @submit.prevent="sendMessage"
              class="relative flex items-end gap-1.5 rounded-xl bg-white/95 backdrop-blur-sm border transition-all duration-200 px-3 py-2.5 shadow-sm"
              :class="focused ? 'border-primary/40 shadow-md' : 'border-black/10'">
            <textarea x-model="newMessage"
                      @keydown.enter.prevent="if(!$event.shiftKey) { sendMessage() }"
                      @focus="focused = true"
                      @blur="focused = false"
                      placeholder="Type a message..."
                      rows="1"
                      class="flex-1 bg-transparent resize-none focus:outline-none text-sm text-on-surface leading-relaxed placeholder:text-black/20 min-h-[24px] max-h-[100px] py-0.5"
                      @input="autoResize($event.target)"></textarea>
            <button type="submit"
                    :disabled="!newMessage.trim()"
                    class="shrink-0 w-8 h-8 rounded-lg flex items-center justify-center transition-all duration-200 active:scale-90"
                    :class="newMessage.trim()
                        ? 'bg-primary text-on-primary shadow-sm hover:shadow-md active:scale-85'
                        : 'bg-transparent text-black/15'">
                <span class="material-symbols-outlined text-[17px]" style="font-variation-settings: 'FILL' 1;">send</span>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .messages-animate {
        animation: msgIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(8px) scale(0.98);
    }
    @keyframes msgIn {
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
</style>
<script>
    function chatWindow(conversationId, csrfToken, currentUserId, otherAvatar, otherName) {
        return {
            conversationId,
            csrfToken,
            currentUserId,
            otherAvatar,
            otherName,
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
