<x-seller-layout>
    <x-slot name="title">Deposit Funds</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="flex items-center justify-between mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Deposit Funds</h1>
                <p class="text-[11px] text-gray-500 mt-0.5">Add money to your wallet to pay for ads and other services. After making a transfer, enter the details below.</p>
            </div>
            <a href="{{ route('seller.wallet.index') }}" class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back to Wallet
            </a>
        </div>

        <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80">
            <div class="mb-4 pb-4 border-b border-gray-100">
                <p class="text-xs text-gray-500">Current Balance</p>
                <p class="text-2xl font-black text-gray-900">{{ number_format($wallet->balance) }} XAF</p>
            </div>

            <form action="{{ route('seller.wallet.deposit.store') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Amount (XAF)</label>
                    <input type="number" name="amount" id="deposit-amount" value="{{ old('amount') }}" required min="100" step="100"
                           placeholder="e.g. 5000"
                           class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-lg font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                    @error('amount') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-3 sm:grid-cols-6 gap-2">
                    @foreach([1000, 2000, 5000, 10000, 25000, 50000] as $amt)
                        <button type="button" onclick="document.getElementById('deposit-amount').value = {{ $amt }}"
                                class="py-2 rounded-xl border border-gray-200 text-[11px] md:text-xs font-bold text-gray-600 hover:border-primary hover:text-primary hover:bg-primary/5 transition-all active:scale-95">
                            {{ number_format($amt) }}
                        </button>
                    @endforeach
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Payment Method</label>
                    <select name="payment_method" required
                            class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                        <option value="">Select payment method</option>
                        @foreach($paymentMethods as $pm)
                            <option value="{{ $pm->name }}" {{ old('payment_method') === $pm->name ? 'selected' : '' }}>{{ $pm->name }} {{ $pm->number ? '- ' . $pm->number : '' }}</option>
                        @endforeach
                    </select>
                    @error('payment_method') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Transaction Reference <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" name="reference" value="{{ old('reference') }}"
                           placeholder="e.g. MTC-1234567890"
                           class="w-full h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                </div>

                <div class="bg-amber-50 rounded-xl p-4 space-y-2">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[16px] text-amber-600 shrink-0 mt-0.5">info</span>
                        <p class="text-xs font-bold text-amber-800">How to deposit</p>
                    </div>
                    <ol class="text-xs text-amber-700 space-y-1 ml-7 list-decimal">
                        <li>Transfer the amount to the selected payment account via mobile money.</li>
                        <li>Enter the amount and transaction reference from your mobile money confirmation.</li>
                        <li>Your wallet will be credited automatically after verification.</li>
                    </ol>
                </div>

                <button type="submit"
                        class="w-full h-12 bg-primary text-white rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    Deposit Funds
                </button>
            </form>
        </div>
    </div>
</x-seller-layout>
