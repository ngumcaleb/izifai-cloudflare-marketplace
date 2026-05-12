<x-admin-layout>
    <x-slot name="header">Promotion Details</x-slot>

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('admin.ads.index') }}" class="p-2 bg-white rounded-lg border border-slate-200 text-slate-400 hover:text-navy-800 transition-all">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h2 class="text-xl font-bold text-navy-800">Request #{{ $ad->id }}</h2>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Promotion Review</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Info -->
            <div class="admin-card p-6 md:p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="w-full md:w-64 shrink-0">
                        <div class="aspect-square bg-slate-50 rounded-xl overflow-hidden border border-slate-100 group relative">
                            @if($ad->product->mainImage)
                                <img src="{{ asset('storage/' . $ad->product->mainImage->path) }}" class="w-full h-full object-cover">
                            @elseif($ad->product->images->first())
                                <img src="{{ asset('storage/' . $ad->product->images->first()->path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-200">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2 py-0.5 bg-navy-800 text-white text-[8px] font-bold uppercase rounded">{{ $ad->product->category->name ?? 'Product' }}</span>
                            @if($ad->status === 'pending')
                                <span class="px-2 py-0.5 bg-amber-50 text-amber-600 text-[8px] font-bold uppercase rounded">Pending Review</span>
                            @elseif($ad->status === 'approved')
                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-bold uppercase rounded">Active</span>
                            @else
                                <span class="px-2 py-0.5 bg-rose-50 text-rose-600 text-[8px] font-bold uppercase rounded">Rejected</span>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold text-navy-800 mb-4">{{ $ad->product->name }}</h3>
                        
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pricing</span>
                                <span class="block text-base font-bold text-emerald-600">XAF {{ number_format($ad->product->price) }}</span>
                            </div>
                            <div>
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Promotion Type</span>
                                <span class="block text-base font-bold text-gold-500 uppercase">{{ $ad->type }}</span>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <h4 class="text-[10px] font-bold text-navy-800 uppercase tracking-widest mb-2 flex items-center gap-2">
                                <i data-lucide="info" class="w-3 h-3 text-gold-500"></i>
                                Promotion Terms
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <span class="block text-[8px] text-slate-400 font-bold uppercase mb-0.5">Duration</span>
                                    <span class="text-xs font-bold text-navy-800">{{ $ad->duration_days }} Days</span>
                                </div>
                                <div>
                                    <span class="block text-[8px] text-slate-400 font-bold uppercase mb-0.5">Coverage</span>
                                    <span class="text-xs font-bold text-navy-800">Featured</span>
                                </div>
                                <div>
                                    <span class="block text-[8px] text-slate-400 font-bold uppercase mb-0.5">Total Paid</span>
                                    <span class="text-xs font-bold text-emerald-600">XAF {{ number_format($ad->total_amount ?? 0) }}</span>
                                </div>
                                <div>
                                    <span class="block text-[8px] text-slate-400 font-bold uppercase mb-0.5">Sender Number</span>
                                    <span class="text-xs font-bold text-navy-800">{{ $ad->payment_sender_number ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        @if($ad->payment_proof)
                        <div class="mt-6">
                            <h4 class="text-[10px] font-bold text-navy-800 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <i data-lucide="camera" class="w-3 h-3 text-emerald-500"></i>
                                Payment Evidence (Screenshot)
                            </h4>
                            <a href="{{ asset('storage/' . $ad->payment_proof) }}" target="_blank" class="block w-48 aspect-[3/4] bg-white rounded-xl border border-slate-200 overflow-hidden group relative shadow-sm hover:shadow-md transition-all">
                                <img src="{{ asset('storage/' . $ad->payment_proof) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-navy-800/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <span class="text-[10px] font-bold text-white uppercase tracking-widest">View Full Size</span>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Merchant Note -->
            @if($ad->seller_notes)
            <div class="admin-card p-6 md:p-8">
                <h4 class="text-sm font-bold text-navy-800 mb-4 flex items-center gap-2">
                    <i data-lucide="message-square" class="w-4 h-4 text-gold-400"></i>
                    Merchant's Message
                </h4>
                <div class="p-5 bg-navy-900/5 rounded-xl border border-navy-900/5 italic text-slate-600 text-sm leading-relaxed">
                    "{{ $ad->seller_notes }}"
                </div>
            </div>
            @endif

            <!-- Admin Actions -->
            @if($ad->status === 'pending')
            <div class="admin-card p-6 md:p-8 border-gold-400/20">
                <h4 class="text-sm font-bold text-navy-800 mb-6 flex items-center gap-2">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                    Take Action
                </h4>
                
                <form action="{{ route('admin.ads.action', $ad) }}" method="POST" x-data="{ rejection: false }">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 px-1">Reviewer's Internal Notes</label>
                        <textarea name="admin_notes" rows="4" 
                                  placeholder="Provide context for approval or rejection. This will be visible to the merchant."
                                  class="w-full p-4 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-navy-800/10 transition-all"></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4">
                        <button type="submit" name="action" value="approve" 
                                class="flex-1 py-4 bg-navy-800 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-lg">
                            Approve Promotion
                        </button>
                        <button type="button" @click="rejection = true"
                                class="flex-1 py-4 bg-white border border-rose-200 text-rose-500 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-rose-50 transition-all">
                            Decline Request
                        </button>
                    </div>

                    <!-- Confirm Rejection Modal-ish -->
                    <div x-show="rejection" x-cloak class="mt-6 p-6 bg-rose-50 rounded-xl border border-rose-100 animate-in fade-in slide-in-from-top-4">
                        <p class="text-sm font-bold text-rose-600 mb-4">Are you sure you want to decline this request?</p>
                        <div class="flex gap-3">
                            <button type="submit" name="action" value="reject" class="px-6 py-2 bg-rose-500 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest">Yes, Decline</button>
                            <button type="button" @click="rejection = false" class="px-6 py-2 bg-white text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-widest border border-slate-200">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
            @elseif($ad->admin_notes)
            <div class="admin-card p-6 md:p-8">
                <h4 class="text-sm font-bold text-navy-800 mb-4 flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4 text-slate-400"></i>
                    Resolution Note
                </h4>
                <p class="text-sm text-slate-500 leading-relaxed">{{ $ad->admin_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Merchant Profile -->
            <div class="admin-card p-6">
                <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">Merchant Info</h4>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 bg-navy-800 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($ad->store->name, 0, 1) }}
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-navy-800 leading-tight">{{ $ad->store->name }}</h5>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">{{ $ad->store->user->name }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Trust Level</span>
                        <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[8px] font-bold rounded uppercase">{{ $ad->store->badge ?? 'Standard' }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Joined</span>
                        <span class="text-[11px] font-bold text-navy-800">{{ $ad->store->created_at->format('M Y') }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.stores.show', $ad->store) }}" class="block w-full mt-6 py-3 bg-slate-50 text-navy-800 rounded-xl text-[10px] font-bold uppercase tracking-widest text-center hover:bg-navy-800 hover:text-white transition-all">View Store Profile</a>
            </div>

            <!-- Ad Stats if Active -->
            @if($ad->status === 'approved')
            <div class="admin-card p-6 bg-emerald-50 border-none">
                <h4 class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-4">Live Status</h4>
                <div class="space-y-4">
                    <div>
                        <span class="block text-[8px] text-emerald-600/60 font-bold uppercase mb-0.5">Starts At</span>
                        <span class="text-xs font-bold text-navy-800">{{ $ad->starts_at->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="block text-[8px] text-emerald-600/60 font-bold uppercase mb-0.5">Ends At</span>
                        <span class="text-xs font-bold text-navy-800">{{ $ad->ends_at->format('M d, Y') }}</span>
                    </div>
                    @php
                        $remaining = now()->diffInDays($ad->ends_at, false);
                    @endphp
                    <div class="pt-4 border-t border-emerald-100">
                        <span class="text-[10px] font-bold text-emerald-700">
                            {{ $remaining > 0 ? $remaining . ' Days Remaining' : 'Expired' }}
                        </span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
