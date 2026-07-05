<x-admin-layout>
    <x-slot name="header">Rental Transaction</x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <a href="{{ route('admin.rental-transactions.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Transactions
        </a>

        <div class="admin-card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-bold text-navy-800">Transaction #{{ $rentalTransaction->id }}</h2>
                    <p class="text-xs text-slate-400">Created {{ $rentalTransaction->created_at->format('M d, Y H:i') }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase
                    {{ in_array($rentalTransaction->status, ['completed', 'returned']) ? 'bg-emerald-50 text-emerald-600' : '' }}
                    {{ in_array($rentalTransaction->status, ['active', 'confirmed']) ? 'bg-blue-50 text-blue-600' : '' }}
                    {{ $rentalTransaction->status === 'cancelled' ? 'bg-rose-50 text-rose-600' : '' }}
                    {{ $rentalTransaction->status === 'pending' ? 'bg-amber-50 text-amber-600' : '' }}">
                    {{ $rentalTransaction->status }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Customer</p>
                    <p class="text-sm font-bold text-navy-800">{{ $rentalTransaction->customer->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Rental Item</p>
                    <p class="text-sm font-bold text-navy-800">{{ $rentalTransaction->rentalItem->name }}</p>
                    <p class="text-xs text-slate-500">{{ $rentalTransaction->rentalItem->store->name }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Rental Period</p>
                    <p class="text-sm font-bold text-navy-800">{{ $rentalTransaction->start_date->format('M d, Y') }} - {{ $rentalTransaction->end_date->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Total Amount</p>
                    <p class="text-lg font-bold text-navy-800">XAF {{ number_format($rentalTransaction->total_amount) }}</p>
                </div>
            </div>

            @if($rentalTransaction->deposit_amount)
            <div class="border-t border-slate-100 pt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Deposit</p>
                <p class="text-sm font-bold text-navy-800">XAF {{ number_format($rentalTransaction->deposit_amount) }}</p>
            </div>
            @endif

            @if($rentalTransaction->notes)
            <div class="border-t border-slate-100 pt-4 mt-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Notes</p>
                <p class="text-sm text-slate-600">{{ $rentalTransaction->notes }}</p>
            </div>
            @endif

            <div class="border-t border-slate-100 pt-6 mt-6">
                <h3 class="text-sm font-bold text-navy-800 mb-3">Update Status</h3>
                <form action="{{ route('admin.rental-transactions.status', $rentalTransaction) }}" method="POST" class="flex items-center gap-3">
                    @csrf
                    <select name="status" class="flex-1 px-4 py-2.5 bg-slate-50 border-none rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-gold-400/20 appearance-none">
                        <option value="pending" {{ $rentalTransaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $rentalTransaction->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="active" {{ $rentalTransaction->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $rentalTransaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="returned" {{ $rentalTransaction->status === 'returned' ? 'selected' : '' }}>Returned</option>
                        <option value="cancelled" {{ $rentalTransaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold hover:bg-navy-900 transition-all">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
