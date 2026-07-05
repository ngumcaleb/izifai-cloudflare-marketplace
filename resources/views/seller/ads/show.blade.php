<x-seller-layout>
    <x-slot name="title">{{ $ad->title }}</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in" x-data="paymentCheck()">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">{{ $ad->title }}</h1>
                <p class="text-sm text-gray-500 mt-0.5">Ad request details</p>
            </div>
            <a href="{{ route('seller.ads.index') }}"
               class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                All Ads
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <span class="text-xs font-semibold text-gray-400">Status</span>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                            {{ $ad->status === 'approved' ? 'bg-primary/5 text-primary' : ($ad->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                            {{ $ad->status }}
                        </span>
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400">Payment</span>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                            {{ $ad->payment_status === 'paid' ? 'bg-green-50 text-green-600' : ($ad->payment_status === 'processing' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600') }}">
                            {{ $ad->payment_status }}
                        </span>
                    </p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400">Duration</span>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $ad->days }} day{{ $ad->days > 1 ? 's' : '' }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold text-gray-400">Total paid</span>
                    <p class="text-sm font-bold text-primary mt-0.5">{{ number_format($ad->total_amount) }} XAF</p>
                </div>
                @if($ad->starts_at)
                <div>
                    <span class="text-xs font-semibold text-gray-400">Start</span>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $ad->starts_at->format('M d, Y') }}</p>
                </div>
                @endif
                @if($ad->ends_at)
                <div>
                    <span class="text-xs font-semibold text-gray-400">End</span>
                    <p class="text-sm font-bold text-gray-900 mt-0.5">{{ $ad->ends_at->format('M d, Y') }}</p>
                </div>
                @endif
            </div>

            @if($ad->image)
                <div class="rounded-xl overflow-hidden border border-gray-100">
                    <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="w-full h-48 md:h-64 object-cover">
                </div>
            @endif

            @if($ad->description)
                <div class="bg-gray-50 rounded-xl p-4">
                    <span class="text-xs font-semibold text-gray-400">Description</span>
                    <p class="text-sm text-gray-700 mt-1">{{ $ad->description }}</p>
                </div>
            @endif

            @if($ad->payment_status === 'processing' || $ad->payment_status === 'pending')
                <div x-show="!checked" class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-amber-500 mt-0.5">pending</span>
                        <div>
                            <h4 class="text-sm font-bold text-amber-800">Payment pending</h4>
                            <p class="text-xs text-amber-700 mt-0.5">Complete the USSD prompt on your phone ({{ $ad->payer_phone }}).</p>
                            <button @click="checkPayment()" :disabled="loading"
                                    class="mt-3 px-4 py-2 bg-amber-600 text-white rounded-xl text-xs font-bold hover:opacity-90 active:scale-[0.97] transition-all disabled:opacity-50">
                                <span x-text="loading ? 'Checking...' : 'I have paid'">I have paid</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div x-show="checked" class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                        <div>
                            <h4 class="text-sm font-bold text-green-800">Payment confirmed!</h4>
                            <p class="text-xs text-green-700 mt-0.5">Awaiting admin approval.</p>
                        </div>
                    </div>
                </div>
            @elseif($ad->payment_status === 'paid' && $ad->status === 'pending')
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-blue-600">hourglass_top</span>
                        <div>
                            <h4 class="text-sm font-bold text-blue-800">Awaiting approval</h4>
                            <p class="text-xs text-blue-700 mt-0.5">Payment received. An admin will review and activate your ad shortly.</p>
                        </div>
                    </div>
                </div>
            @elseif($ad->status === 'approved')
                <div class="bg-green-50 border border-green-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-green-600">check_circle</span>
                        <div>
                            <h4 class="text-sm font-bold text-green-800">Active</h4>
                            <p class="text-xs text-green-700 mt-0.5">
                                Running from {{ $ad->starts_at?->format('M d') }} to {{ $ad->ends_at?->format('M d, Y') }}.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($ad->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-600">cancel</span>
                        <div>
                            <h4 class="text-sm font-bold text-red-800">Rejected</h4>
                            @if($ad->admin_notes)
                                <p class="text-xs text-red-700 mt-0.5">{{ $ad->admin_notes }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <script>
            function paymentCheck() {
                return {
                    loading: false,
                    checked: false,
                    async checkPayment() {
                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('seller.ads.check-payment', $ad->id) }}');
                            const data = await res.json();
                            if (data.status === 'paid') {
                                this.checked = true;
                                location.reload();
                            } else {
                                alert('Payment not yet confirmed. Complete the USSD prompt on your phone.');
                            }
                        } catch (e) {
                            alert('Could not verify payment. Try again.');
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        </script>
    </div>
</x-seller-layout>
