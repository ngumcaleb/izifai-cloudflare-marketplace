<x-seller-layout>
    <x-slot name="title">Promotions Hub</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
        <!-- REQUEST FORM -->
        <div class="lg:col-span-4" x-data="{ days: 7, price: {{ $adPricePerDay }} }">
            <div class="bg-surface-container-lowest p-4 md:p-xl rounded-2xl md:rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)]">
                <h3 class="font-headline-md text-on-surface mb-4 md:mb-6 border-b border-outline-variant/30 pb-3 md:pb-4">Start New Boost</h3>

                <form action="{{ route('seller.ads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-5">
                    @csrf
                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">Choose Product</label>
                        <select name="product_id" required
                                class="w-full h-11 bg-surface-container-low border-none rounded-xl px-4 text-body-md focus:ring-2 focus:ring-primary outline-none">
                            <option value="">Select item...</option>
                            @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label class="font-label-sm text-on-surface-variant ml-1">How Many Days?</label>
                        <input type="number" name="duration_days" x-model="days" required min="1"
                               class="w-full h-11 bg-surface-container-low border-none rounded-xl px-4 text-body-md focus:ring-2 focus:ring-primary outline-none">
                    </div>

                    <div class="p-3 md:p-4 bg-surface-container-low rounded-2xl space-y-3">
                        <p class="font-label-sm text-on-surface-variant">Pay into any account below:</p>
                        @forelse($paymentMethods as $pm)
                            <div class="flex items-center gap-3 p-2.5 bg-white rounded-xl border border-outline-variant/20">
                                <div class="w-8 h-8 rounded-lg bg-surface flex items-center justify-center p-1 shadow-sm shrink-0">
                                    @if($pm->icon) <img src="{{ asset('storage/' . $pm->icon) }}" class="w-full h-full object-contain"> @else <span class="material-symbols-outlined text-[16px] text-on-surface-variant/40">account_balance</span> @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-label-sm text-on-surface font-semibold">{{ $pm->name }}</p>
                                    <p class="text-label-sm text-on-surface-variant truncate">{{ $pm->account_name }}</p>
                                    <p class="text-label-sm text-on-surface font-mono mt-0.5">{{ $pm->number }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-label-sm text-on-surface-variant/60 text-center py-2">No payment methods configured yet.</p>
                        @endforelse
                    </div>

                    <div class="space-y-3">
                        <div class="space-y-1.5">
                            <label class="font-label-sm text-on-surface-variant ml-1">Confirm Payment</label>
                            <input type="text" name="payment_sender_number" required placeholder="Your Phone Number"
                                   class="w-full h-10 bg-surface-container-low border-none rounded-xl px-4 text-body-md focus:ring-2 focus:ring-primary outline-none">
                        </div>
                        <label class="block w-full py-3 md:py-4 bg-surface-container-low border-2 border-dashed border-outline-variant rounded-2xl text-center cursor-pointer hover:border-primary hover:bg-surface-container-lowest transition-all">
                            <input type="file" name="payment_proof" required accept="image/*" class="hidden">
                            <div class="flex flex-col items-center gap-1">
                                <span class="material-symbols-outlined text-on-surface-variant/40">cloud_upload</span>
                                <span class="font-label-sm text-on-surface-variant">Upload Payment Screenshot</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 border-t border-outline-variant/30 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-label-sm text-on-surface-variant">Estimated Cost</span>
                            <span class="text-headline-md text-on-surface tracking-tight">XAF <span x-text="(days * price).toLocaleString()"></span></span>
                        </div>
                        <button type="submit"
                                class="whitespace-nowrap bg-primary text-white px-5 md:px-6 py-2.5 md:py-3 rounded-full font-label-md md:font-label-lg hover:opacity-90 transition-opacity shadow-lg shadow-primary/20 flex items-center gap-1.5 md:gap-2">
                            <span class="material-symbols-outlined text-[18px] md:text-[20px]">send</span>
                            <span class="text-sm md:text-base">Request Boost</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- REQUEST LOG -->
        <div class="lg:col-span-8">
            <!-- Desktop Table -->
            <div class="hidden md:block bg-surface-container-lowest rounded-3xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)]">
                <div class="p-xl border-b border-outline-variant/30">
                    <h3 class="font-headline-md text-on-surface">My Promotion History</h3>
                </div>
                <table class="w-full text-left table-fixed">
                    <colgroup>
                        <col class="w-[44%]">
                        <col class="w-[22%]">
                        <col class="w-[14%]">
                        <col class="w-[20%]">
                    </colgroup>
                    <thead class="bg-surface-container-low/30">
                        <tr>
                            <th class="px-6 py-4 font-label-md text-on-surface-variant">Boosted Item</th>
                            <th class="px-6 py-4 font-label-md text-on-surface-variant text-center">Status</th>
                            <th class="px-6 py-4 font-label-md text-on-surface-variant text-center">Days</th>
                            <th class="px-6 py-4 font-label-md text-on-surface-variant text-right">Fee Paid</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        @forelse($adRequests as $ad)
                            <tr class="group hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-surface-container-high overflow-hidden shrink-0 border border-outline-variant/30 group-hover:border-primary transition-all">
                                            @if($ad->product->images->first())
                                                <img src="{{ asset('storage/' . $ad->product->images->first()->path) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                                    <span class="material-symbols-outlined text-[16px]">image</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 truncate">
                                            <h6 class="font-label-sm text-on-surface truncate leading-tight" title="{{ $ad->product->name }}">{{ $ad->product->name }}</h6>
                                            <p class="text-label-sm text-on-surface-variant mt-1">{{ $ad->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                            'approved' => 'bg-primary/10 text-primary border border-primary/20',
                                            'rejected' => 'bg-error-container text-error border border-error/20',
                                            'expired' => 'bg-surface-container text-on-surface-variant border border-outline-variant'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusColors[$ad->status] ?? 'bg-surface-container text-on-surface-variant' }}">
                                        {{ $ad->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center font-label-sm text-on-surface-variant">
                                    {{ $ad->duration_days }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-label-lg text-on-surface tracking-tight">{{ number_format($ad->amount_paid) }} <span class="text-label-sm text-on-surface-variant">XAF</span></span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/30">campaign</span>
                                    <p class="text-headline-md text-on-surface-variant mt-4">No boosts yet</p>
                                    <p class="text-body-md text-on-surface-variant/60 mt-2">Start promoting your products</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden space-y-3">
                <h3 class="font-headline-md text-on-surface">My Promotion History</h3>
                @forelse($adRequests as $ad)
                    <div class="bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] p-4 space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-surface-container-high overflow-hidden shrink-0 border border-outline-variant/30">
                                @if($ad->product->images->first())
                                    <img src="{{ asset('storage/' . $ad->product->images->first()->path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-on-surface-variant/30">
                                        <span class="material-symbols-outlined text-[16px]">image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h6 class="font-label-sm text-on-surface truncate leading-tight">{{ $ad->product->name }}</h6>
                                <p class="text-label-sm text-on-surface-variant mt-0.5">{{ $ad->created_at->format('M d, Y') }}</p>
                            </div>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'approved' => 'bg-primary/10 text-primary border border-primary/20',
                                    'rejected' => 'bg-error-container text-error border border-error/20',
                                    'expired' => 'bg-surface-container text-on-surface-variant border border-outline-variant'
                                ];
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider shrink-0 {{ $statusColors[$ad->status] ?? 'bg-surface-container text-on-surface-variant' }}">
                                {{ $ad->status }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-outline-variant/20">
                            <div class="flex items-center gap-2 text-label-sm text-on-surface-variant">
                                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                {{ $ad->duration_days }} days
                            </div>
                            <span class="font-label-lg text-on-surface tracking-tight">{{ number_format($ad->amount_paid) }} <span class="text-label-sm text-on-surface-variant">XAF</span></span>
                        </div>
                    </div>
                @empty
                    <div class="bg-surface-container-lowest rounded-2xl shadow-[0px_4px_20px_rgba(0,0,0,0.05)] p-8 text-center">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant/30">campaign</span>
                        <p class="text-headline-md text-on-surface-variant mt-3">No boosts yet</p>
                        <p class="text-body-md text-on-surface-variant/60 mt-1">Start promoting your products</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-seller-layout>
