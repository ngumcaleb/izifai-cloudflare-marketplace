{{-- ============ TRANSIENT TOASTS (flash success / error) ============ --}}
<style>
    .toast-progress { animation: toast-progress 4.8s linear forwards; }
    @keyframes toast-progress { from { width: 100%; } to { width: 0%; } }
</style>

<script type="application/json" id="flash-messages">{!! json_encode([
    'success' => session('success'),
    'error' => session('error'),
    'errors' => $errors->any() ? $errors->all() : [],
], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

<div x-data="toastHost()"
     class="fixed z-[90] right-3 sm:right-6 bottom-[72px] sm:bottom-6 flex flex-col gap-2 w-[calc(100%-1.5rem)] sm:w-[380px] pointer-events-none"
     aria-live="polite">
    <template x-for="t in toasts" :key="t.id">
        <div role="status"
             class="relative pointer-events-auto overflow-hidden rounded-[16px] bg-white border border-[#eceeec] shadow-[0_12px_32px_-12px_rgba(28,32,30,0.25)]"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8 translate-y-1 scale-[0.97]"
             x-transition:enter-end="opacity-100 translate-x-0 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-250"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-[0.97]">

            <span class="absolute inset-x-0 top-0 h-[3px]"
                  :class="t.type === 'error' ? 'bg-[#ef4444]' : 'bg-[#9acd32]'"></span>

            <div class="flex items-center gap-3 pl-4 pr-2.5 py-3">
                <span class="shrink-0 grid place-items-center w-8 h-8 rounded-full text-[14px] font-bold"
                      :class="t.type === 'error' ? 'bg-[#fdecec] text-[#dc2626]' : 'bg-[#f0f9da] text-[#659316]'">
                    <i :class="t.type === 'error' ? 'fa-solid fa-xmark' : 'fa-solid fa-check'" style=""></i>
                </span>
                <div class="min-w-0 flex-1">
                    <p class="text-[12.5px] font-medium text-[#1c201e] leading-snug" x-text="t.message"></p>
                    <p class="mt-1 text-[9.5px] font-medium text-[#a3aaa4]">Izifai</p>
                </div>
                <button @click="dismiss(t.id)"
                        class="shrink-0 w-7 h-7 rounded-full grid place-items-center text-[#c2c8c3] hover:text-[#3f453f] hover:bg-[#f5f6f5] transition-colors">
                    <i class="fa-solid fa-xmark text-[13px]" style=""></i>
                </button>
            </div>

            <span class="absolute bottom-0 left-0 h-[2px] toast-progress"
                  :class="t.type === 'error' ? 'bg-[#ef4444]/40' : 'bg-[#9acd32]/40'"></span>
        </div>
    </template>
</div>

@push('scripts')
<script>
    function toastHost() {
        return {
            toasts: [],
            init() {
                var el = document.getElementById('flash-messages');
                if (!el) return;
                var data;
                try { data = JSON.parse(el.textContent); } catch (e) { return; }
                if (data.success) this.pushToast(data.success, 'success');
                if (data.error) this.pushToast(data.error, 'error');
                if (Array.isArray(data.errors) && data.errors.length) {
                    this.pushToast(data.errors[0], 'error');
                }
            },
            pushToast(message, type) {
                var self = this;
                var id = String(Date.now()) + Math.random();
                this.toasts = this.toasts.concat([{ id: id, message: message, type: type }]);
                this.playSound(type);
                setTimeout(function() { self.dismiss(id); }, 4800);
            },
            playSound(type) {
                try {
                    var a = new Audio(type === 'error' ? '{{ asset('sounds/error.mp3') }}' : '{{ asset('sounds/success.mp3') }}');
                    a.volume = 0.6;
                    var p = a.play();
                    if (p && p.catch) p.catch(function() {});
                } catch (e) {}
            },
            dismiss(id) {
                this.toasts = this.toasts.filter(function(t) { return t.id !== id; });
            }
        };
    }
</script>
@endpush