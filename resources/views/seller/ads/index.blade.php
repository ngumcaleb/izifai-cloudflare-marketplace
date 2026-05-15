<x-seller-layout>
    <x-slot name="title">Promotions Hub</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-gray-900">Promotions Hub</h1>
            <p class="text-sm text-gray-500 mt-0.5">Boost your products to reach more customers</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
            <!-- REQUEST FORM -->
            <div class="lg:col-span-4" x-data="{ days: 7, price: {{ $adPricePerDay }} }">
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80">
                    <div class="flex items-center gap-3 mb-4 md:mb-5 pb-3 md:pb-4 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">campaign</span>
                        </div>
                        <h2 class="text-base md:text-lg font-bold text-gray-900">Start New Boost</h2>
                    </div>

                    <form action="{{ route('seller.ads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Choose Product</label>
                            <select name="product_id" required
                                    class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <option value="">Select item...</option>
                                @foreach($products as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">How Many Days?</label>
                            <input type="number" name="duration_days" x-model="days" required min="1"
                                   class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                        </div>

                        <div class="p-4 md:p-5 bg-gray-50 rounded-xl space-y-4">
                            <div class="text-center">
                                <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Pay This Amount</p>
                                <p class="text-3xl md:text-4xl font-black text-primary mt-1">XAF <span x-text="(days * price).toLocaleString()"></span></p>
                                <p class="text-[11px] text-gray-400 mt-1">to any account below, then submit screenshot</p>
                            </div>
                            <div class="space-y-2">
                            @forelse($paymentMethods as $pm)
                                <div class="flex items-center gap-3 p-2.5 bg-white rounded-xl border border-gray-100">
                                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center p-1 shrink-0">
                                        @if($pm->icon) <img src="{{ $pm->icon_url }}" class="w-full h-full object-contain"> @else <span class="material-symbols-outlined text-[16px] text-gray-300">account_balance</span> @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-gray-900">{{ $pm->name }}</p>
                                        <p class="text-[11px] text-gray-500 truncate">{{ $pm->account_name }}</p>
                                        <p class="text-[11px] text-gray-900 font-mono mt-0.5">{{ $pm->number }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center py-2">No payment methods configured yet.</p>
                            @endforelse
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-gray-500 ml-1">Confirm Payment</label>
                                <input type="text" name="payment_sender_number" required placeholder="Your Phone Number"
                                       class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            </div>
                            <label class="block w-full py-3 md:py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl text-center cursor-pointer hover:border-primary hover:bg-white transition-all">
                                <input type="file" name="payment_proof" required accept="image/*" class="hidden">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="material-symbols-outlined text-gray-300">cloud_upload</span>
                                    <span class="text-xs font-semibold text-gray-400">Upload Payment Screenshot</span>
                                </div>
                            </label>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-gray-100">
                            <button type="submit"
                                    class="w-full sm:w-auto bg-primary text-white px-8 py-3 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">send</span>
                                Submit Boost Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- REQUEST LOG -->
            <div class="lg:col-span-8">
                <!-- Desktop Table -->
                <div class="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">My Promotion History</h2>
                    </div>
                    <table class="w-full text-left">
                        <thead class="bg-gray-50/80 border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Boosted Item</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Days</th>
                                <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-right">Fee Paid</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($adRequests as $ad)
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-200 group-hover:border-primary/50 transition-all">
                                                @if($ad->product->images->first())
                                                    <img src="{{ $ad->product->images->first()->url }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                        <span class="material-symbols-outlined text-[16px]">image</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="min-w-0 truncate">
                                                <h6 class="text-sm font-bold text-gray-900 truncate leading-tight" title="{{ $ad->product->name }}">{{ $ad->product->name }}</h6>
                                                <p class="text-[11px] text-gray-500 mt-0.5">{{ $ad->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @php
                                            $statusStyles = [
                                                'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                                'approved' => 'bg-primary/5 text-primary border border-primary/20',
                                                'rejected' => 'bg-red-50 text-red-600 border border-red-200',
                                                'expired' => 'bg-gray-100 text-gray-500 border border-gray-200'
                                            ];
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $statusStyles[$ad->status] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ $ad->status }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center text-sm text-gray-500">
                                        {{ $ad->duration_days }}
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <span class="text-sm font-bold text-gray-900">{{ number_format($ad->amount_paid) }} <span class="text-xs text-gray-500">XAF</span></span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-16 text-center">
                                        <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                            <span class="material-symbols-outlined text-3xl text-gray-300">campaign</span>
                                        </div>
                                        <p class="text-base font-bold text-gray-900">No boosts yet</p>
                                        <p class="text-sm text-gray-500 mt-1">Start promoting your products to reach more customers.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="md:hidden space-y-3">
                    <h2 class="text-base font-bold text-gray-900">My Promotion History</h2>
                    @forelse($adRequests as $ad)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-4 space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-100 overflow-hidden shrink-0 border border-gray-200">
                                    @if($ad->product->images->first())
                                        <img src="{{ $ad->product->images->first()->url }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <span class="material-symbols-outlined text-[16px]">image</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h6 class="text-sm font-bold text-gray-900 truncate leading-tight">{{ $ad->product->name }}</h6>
                                    <p class="text-[11px] text-gray-500 mt-0.5">{{ $ad->created_at->format('M d, Y') }}</p>
                                </div>
                                @php
                                    $statusStyles = [
                                        'pending' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                        'approved' => 'bg-primary/5 text-primary border border-primary/20',
                                        'rejected' => 'bg-red-50 text-red-600 border border-red-200',
                                        'expired' => 'bg-gray-100 text-gray-500 border border-gray-200'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider shrink-0 {{ $statusStyles[$ad->status] ?? 'bg-gray-100 text-gray-500' }}">
                                    {{ $ad->status }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                    {{ $ad->duration_days }} days
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ number_format($ad->amount_paid) }} <span class="text-xs text-gray-500">XAF</span></span>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 p-8 text-center">
                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                <span class="material-symbols-outlined text-3xl text-gray-300">campaign</span>
                            </div>
                            <p class="text-base font-bold text-gray-900">No boosts yet</p>
                            <p class="text-sm text-gray-500 mt-1">Start promoting your products.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>