<x-seller-layout>
    <x-slot name="title">Promote Your Items</x-slot>

    <div class="space-y-4 md:space-y-6 animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Promote Your Items</h1>
                <p class="text-sm text-gray-500 mt-0.5">{{ number_format($dailyRate) }} XAF/day · admin approval required</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 md:gap-6">
            <!-- FORM -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4"
                     x-data="{
                         type: 'product',
                         itemId: '',
                         days: 7,
                         dailyRate: {{ $dailyRate }},
                         get total() { return this.days * this.dailyRate; },
                     }">
                    <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                        <div class="w-8 h-8 rounded-xl bg-primary/5 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">campaign</span>
                        </div>
                        <h2 class="text-base font-bold text-gray-900">Boost an Item</h2>
                    </div>

                    <form action="{{ route('seller.ads.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Item type</label>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="cursor-pointer">
                                    <input type="radio" name="promotable_type" value="product" x-model="type" class="sr-only peer">
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-gray-200 text-gray-500 bg-gray-50">
                                        <span class="material-symbols-outlined text-[14px]">inventory_2</span> Product
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="promotable_type" value="service" x-model="type" class="sr-only peer">
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-gray-200 text-gray-500 bg-gray-50">
                                        <span class="material-symbols-outlined text-[14px]">handyman</span> Service
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="promotable_type" value="rental" x-model="type" class="sr-only peer">
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-gray-200 text-gray-500 bg-gray-50">
                                        <span class="material-symbols-outlined text-[14px]">shelves</span> Rental
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="promotable_type" value="custom" x-model="type" class="sr-only peer">
                                    <div class="flex items-center justify-center gap-1.5 px-3 py-2.5 rounded-xl text-xs font-bold border-2 transition-all peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary border-gray-200 text-gray-500 bg-gray-50">
                                        <span class="material-symbols-outlined text-[14px]">edit_note</span> Custom
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div x-show="type !== 'custom'" class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Choose item</label>
                            <select name="promotable_id" x-model="itemId" :required="type !== 'custom'"
                                    class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <option value="">Select...</option>
                                <template x-if="type === 'product'">
                                    <optgroup label="Products">
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </template>
                                <template x-if="type === 'service'">
                                    <optgroup label="Services">
                                        @foreach($services as $s)
                                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </template>
                                <template x-if="type === 'rental'">
                                    <optgroup label="Rentals">
                                        @foreach($rentals as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </optgroup>
                                </template>
                            </select>
                        </div>

                        <div x-show="type === 'custom'" class="space-y-3">
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-gray-500 ml-1">Title</label>
                                <input type="text" name="title" placeholder="e.g. Weekend Mega Sale"
                                       class="w-full h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-gray-500 ml-1">Description</label>
                                <textarea name="description" rows="3" placeholder="Describe what you're promoting..."
                                          class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 resize-none"></textarea>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-semibold text-gray-500 ml-1">Image</label>
                                <input type="file" name="image" accept="image/*"
                                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/5 file:text-primary hover:file:bg-primary/10 file:cursor-pointer">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Duration (days)</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="days" x-model.number="days" min="1" max="365"
                                       class="w-24 h-10 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm text-center focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                                <span class="text-sm text-gray-500">
                                    = <strong class="text-primary" x-text="total.toLocaleString() + ' XAF'"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="bg-primary/5 rounded-xl p-4 space-y-1.5">
                            <label class="text-xs font-semibold text-gray-500 ml-1">Your phone for payment</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" required
                                   placeholder="e.g. 670000000"
                                   class="w-full h-10 bg-white border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                            <p class="text-xs text-gray-400 ml-1">You'll receive a USSD prompt on this number.</p>
                        </div>

                        <button type="submit"
                                class="w-full bg-primary text-white py-3 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">payments</span>
                            Pay &amp; Submit
                        </button>
                    </form>
                </div>
            </div>

            <!-- AD HISTORY -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100/80 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h2 class="text-base font-bold text-gray-900">My Ad History</h2>
                    </div>

                    <!-- Desktop -->
                    <div class="hidden md:block">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50/80 border-b border-gray-100">
                                <tr>
                                    <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Item</th>
                                    <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Status</th>
                                    <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Payment</th>
                                    <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-center">Days</th>
                                    <th class="px-5 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-right">Paid</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($adRequests as $ad)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-5 py-4">
                                            <a href="{{ route('seller.ads.show', $ad->id) }}" class="flex items-center gap-3">
                                                <div class="min-w-0">
                                                    <h6 class="text-sm font-bold text-gray-900 truncate leading-tight group-hover:text-primary transition-colors">{{ $ad->title }}</h6>
                                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $ad->promotable_type ? class_basename($ad->promotable_type) : 'Custom' }} · {{ $ad->created_at->format('M d, Y') }}</p>
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                {{ $ad->status === 'approved' ? 'bg-primary/5 text-primary border border-primary/20' : ($ad->status === 'pending' ? 'bg-amber-50 text-amber-600 border border-amber-200' : 'bg-red-50 text-red-600 border border-red-200') }}">
                                                {{ $ad->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                {{ $ad->payment_status === 'paid' ? 'bg-green-50 text-green-600 border border-green-200' : ($ad->payment_status === 'processing' ? 'bg-blue-50 text-blue-600' : 'bg-amber-50 text-amber-600') }}">
                                                {{ $ad->payment_status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center text-sm text-gray-500">{{ $ad->days }}</td>
                                        <td class="px-5 py-4 text-right">
                                            <span class="text-sm font-bold text-gray-900">{{ number_format($ad->total_amount) }} <span class="text-xs text-gray-500">XAF</span></span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-16 text-center">
                                            <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center mx-auto mb-3">
                                                <span class="material-symbols-outlined text-3xl text-gray-300">campaign</span>
                                            </div>
                                            <p class="text-base font-bold text-gray-900">No ads yet</p>
                                            <p class="text-sm text-gray-500 mt-1">Boost an item to get started.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile -->
                    <div class="md:hidden space-y-0 divide-y divide-gray-50">
                        @forelse($adRequests as $ad)
                            <a href="{{ route('seller.ads.show', $ad->id) }}" class="block p-4 hover:bg-gray-50/50 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <h6 class="text-sm font-bold text-gray-900 truncate">{{ $ad->title }}</h6>
                                    <span class="shrink-0 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                        {{ $ad->status === 'approved' ? 'bg-primary/5 text-primary' : ($ad->status === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                                        {{ $ad->status }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <span>{{ $ad->promotable_type ? class_basename($ad->promotable_type) : 'Custom' }}</span>
                                    <span>·</span>
                                    <span>{{ $ad->days }} days</span>
                                    <span>·</span>
                                    <span class="font-bold text-gray-800">{{ number_format($ad->total_amount) }} XAF</span>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-sm text-gray-400">No ads yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
