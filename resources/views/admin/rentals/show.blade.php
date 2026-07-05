<x-admin-layout>
    <x-slot name="header">Rental Item Details</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <a href="{{ route('admin.rentals.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-navy-800 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Back to Rentals
        </a>

        <div class="admin-card overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-64 h-64 bg-slate-100 rounded-xl overflow-hidden shrink-0">
                        @if($rentalItem->images && count($rentalItem->images) > 0)
                            <img src="{{ $rentalItem->main_image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i data-lucide="shelves" class="w-12 h-12"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0 space-y-4">
                        <div>
                            <h1 class="text-xl font-bold text-navy-800">{{ $rentalItem->name }}</h1>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $rentalItem->status === 'active' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                                {{ $rentalItem->status }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Rate</p>
                                <p class="text-lg font-bold text-navy-800">XAF {{ number_format($rentalItem->rate) }}/{{ $rentalItem->billing_unit ?? 'day' }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Deposit</p>
                                <p class="text-sm font-bold text-navy-800">XAF {{ number_format($rentalItem->deposit ?? 0) }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Seller</p>
                                <p class="text-sm font-bold text-navy-800">{{ $rentalItem->store->name }}</p>
                            </div>
                        </div>
                        @if($rentalItem->description)
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Description</p>
                                <p class="text-sm text-slate-600">{{ $rentalItem->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('rentals.show', $rentalItem->slug) }}" target="_blank" class="px-6 py-2.5 bg-slate-100 text-navy-800 rounded-lg text-xs font-bold hover:bg-slate-200 transition-all">View on Site</a>
            <form action="{{ route('admin.rentals.destroy', $rentalItem) }}" method="POST" onsubmit="return confirm('Delete this rental item permanently?')">
                @csrf
                @method('DELETE')
                <button class="px-6 py-2.5 bg-rose-500 text-white rounded-lg text-xs font-bold hover:bg-rose-600 transition-all">Delete</button>
            </form>
        </div>

        @if($rentalItem->transactions->count() > 0)
            <div class="admin-card p-6">
                <h3 class="text-sm font-bold text-navy-800 mb-4">Transactions ({{ $rentalItem->transactions->count() }})</h3>
                <div class="space-y-2">
                    @foreach($rentalItem->transactions as $txn)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <div>
                                <p class="text-xs font-bold text-navy-800">{{ $txn->customer->name }}</p>
                                <p class="text-[10px] text-slate-500">{{ $txn->start_date->format('M d') }} - {{ $txn->end_date->format('M d, Y') }}</p>
                            </div>
                            <span class="text-xs font-bold text-navy-800">XAF {{ number_format($txn->total_amount) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-admin-layout>
