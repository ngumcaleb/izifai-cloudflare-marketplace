<x-seller-layout>
    <x-slot name="title">Withdraw Funds</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Withdraw Funds</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">Transfer your available balance to your mobile money account. Withdrawals are processed within 1-3 business days.</p>
            </div>
            <a href="{{ route('seller.wallet.index') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Wallet
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80">
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-xs text-gray-500">Available Balance</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($wallet->balance) }} XAF</p>
            </div>

            <form action="{{ route('seller.wallet.withdraw.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Amount (XAF)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="100" max="{{ $wallet->balance }}" step="100"
                           placeholder="e.g. 10000"
                           class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-lg font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-4 gap-2">
                    @foreach([
                        round($wallet->balance * 0.25 / 100) * 100,
                        round($wallet->balance * 0.5 / 100) * 100,
                        round($wallet->balance * 0.75 / 100) * 100,
                        $wallet->balance
                    ] as $amt)
                        @if($amt >= 100)
                            <button type="button" onclick="document.getElementById('amount').value = {{ $amt }}"
                                    class="py-2 rounded-xl border border-gray-200 text-[11px] md:text-xs font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all active:scale-95">
                                {{ $amt === $wallet->balance ? 'All' : number_format($amt) }}
                            </button>
                        @endif
                    @endforeach
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Withdrawal Method</label>
                    <select name="method" required
                            class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                        <option value="">Select method</option>
                        <option value="mtn_momo" {{ old('method') === 'mtn_momo' ? 'selected' : '' }}>MTN Mobile Money</option>
                        <option value="orange_money" {{ old('method') === 'orange_money' ? 'selected' : '' }}>Orange Money</option>
                    </select>
                    @error('method') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Account Number</label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" required
                           placeholder="e.g. 670123456"
                           class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    @error('account_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Account Name</label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}" required
                           placeholder="e.g. John Doe"
                           class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    @error('account_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="bg-amber-50 rounded-xl p-4 space-y-2">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-amber-600 shrink-0 mt-0.5">info</span>
                        <p class="text-xs font-bold text-amber-800">Before you withdraw</p>
                    </div>
                    <ul class="text-xs text-amber-700 space-y-1 ml-7 list-disc">
                        <li>Ensure your account details are correct — we cannot reverse transfers to wrong accounts.</li>
                        <li>Withdrawals are manually processed and may take 1-3 business days.</li>
                        <li>Minimum withdrawal amount is 100 XAF.</li>
                    </ul>
                </div>

                <button type="submit"
                        @if($wallet->balance <= 0) disabled @endif
                        class="w-full h-12 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 @if($wallet->balance <= 0) opacity-50 cursor-not-allowed @endif">
                    <span class="material-symbols-outlined text-[18px]">output</span>
                    Request Withdrawal
                </button>
            </form>
        </div>

        {{-- Saved accounts --}}
        @if($paymentMethods->count() > 0)
            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 mt-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-8 h-8 rounded-xl bg-primary/5 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <h2 class="text-sm font-bold text-gray-900">Accepted Payment Methods</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    @foreach($paymentMethods as $pm)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                            @if($pm->icon)
                                <img src="{{ $pm->icon_url }}" class="w-8 h-8 rounded-lg object-cover">
                            @else
                                <div class="w-8 h-8 rounded-lg bg-primary/5 flex items-center justify-center text-primary text-[10px] font-bold">
                                    {{ substr($pm->name, 0, 2) }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $pm->name }}</p>
                                <p class="text-xs text-gray-500">{{ $pm->account_name }} — {{ $pm->number }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-seller-layout>
