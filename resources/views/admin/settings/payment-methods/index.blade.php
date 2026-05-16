<x-admin-layout>
    <x-slot name="header">Payment Methods</x-slot>

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Promotion Payment Options</h2>
            <p class="text-[10px] text-slate-400 font-medium mt-0.5">Manage how sellers pay for ads</p>
        </div>
        <button @click="$dispatch('open-modal', 'add-payment-method')" class="px-5 py-2.5 bg-navy-800 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm flex items-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Method
        </button>
    </div>

    @if(session('success'))
    <div class="bg-emerald-500 text-white p-4 rounded-xl shadow-lg flex items-center gap-3 mb-6">
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($methods as $method)
        <div class="admin-card overflow-hidden flex flex-col">
            <div class="p-6 pb-3 flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-center overflow-hidden shrink-0">
                        @if($method->icon)
                            <img src="{{ $method->icon_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy-800 text-white">
                                <i data-lucide="credit-card" class="w-6 h-6"></i>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-[13px] font-bold text-navy-800">{{ $method->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-2 h-2 rounded-full {{ $method->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"></div>
                            <span class="text-[9px] font-bold uppercase tracking-widest text-slate-400">
                                {{ $method->is_active ? 'Online' : 'Offline' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-1.5">
                    <button @click="$dispatch('open-modal', 'edit-method-{{ $method->id }}')" class="p-2 bg-slate-50 text-slate-400 hover:text-navy-800 hover:bg-slate-100 rounded-lg transition-all">
                        <i data-lucide="edit-3" class="w-4 h-4"></i>
                    </button>
                    <form action="{{ route('admin.payment-methods.destroy', $method) }}" method="POST" onsubmit="return confirm('Delete this payment method?')">
                        @csrf @method('DELETE')
                        <button class="p-2 bg-slate-50 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="px-6 py-5 space-y-4 flex-1">
                <div class="p-4 bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                    <div class="space-y-3">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Account Number</p>
                            <p class="text-xs font-bold text-navy-900 tracking-tight flex items-center gap-2">
                                {{ $method->number }}
                                <i data-lucide="copy" class="w-3 h-3 text-slate-300 cursor-pointer hover:text-navy-800 transition-colors" @click="navigator.clipboard.writeText('{{ $method->number }}')"></i>
                            </p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">Registered Name</p>
                            <p class="text-[11px] font-bold text-navy-800">{{ $method->account_name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50/30 border-t border-slate-50 flex items-center justify-between mt-auto">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Service Status</span>
                <form action="{{ route('admin.payment-methods.toggle', $method) }}" method="POST">
                    @csrf
                    <button class="flex items-center gap-3 group/toggle">
                        <div class="w-10 h-5 rounded-full relative transition-all duration-300 {{ $method->is_active ? 'bg-emerald-500 shadow-sm' : 'bg-slate-200' }}">
                            <div class="absolute top-1 left-1 w-3 h-3 bg-white rounded-full transition-transform duration-300 {{ $method->is_active ? 'translate-x-5' : '' }}"></div>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $method->is_active ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $method->is_active ? 'Enabled' : 'Disabled' }}
                        </span>
                    </button>
                </form>
            </div>

            <!-- Edit Modal -->
            <x-modal name="edit-method-{{ $method->id }}" focusable maxWidth="lg">
                <form method="post" action="{{ route('admin.payment-methods.update', $method) }}" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <h2 class="text-xs font-bold text-navy-800 uppercase tracking-widest">Edit {{ $method->name }}</h2>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5">Update gateway credentials.</p>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Network Name</label>
                            <input type="text" name="name" value="{{ $method->name }}" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Phone Number</label>
                                <input type="text" name="number" value="{{ $method->number }}" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Account Name</label>
                                <input type="text" name="account_name" value="{{ $method->account_name }}" required class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Update Icon (Optional)</label>
                            <input type="file" name="icon" accept="image/*" class="w-full bg-slate-50 border border-dashed border-slate-200 rounded-lg px-4 py-5 text-[10px] font-bold text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-bold file:bg-navy-800 file:text-white cursor-pointer hover:border-gold-400/30 transition-all">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                        <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                        <button type="submit" class="flex-1 py-3 bg-navy-800 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm hover:bg-navy-900 transition-all">Update Method</button>
                    </div>
                </form>
            </x-modal>
        </div>
        @endforeach

        @if($methods->isEmpty())
        <div class="md:col-span-2 xl:col-span-3 py-20 text-center">
            <div class="w-14 h-14 bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                <i data-lucide="credit-card" class="w-7 h-7 text-slate-200"></i>
            </div>
            <p class="text-slate-400 italic text-sm">No payment methods added yet.</p>
        </div>
        @endif
    </div>

    <!-- Add Modal -->
    <x-modal name="add-payment-method" focusable maxWidth="lg">
        <form method="post" action="{{ route('admin.payment-methods.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <div>
                <h2 class="text-xs font-bold text-navy-800 uppercase tracking-widest">New Payment Method</h2>
                <p class="text-[10px] text-slate-400 font-medium mt-0.5">Configure a new gateway for merchant promotions.</p>
            </div>
            
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Network Name</label>
                    <input type="text" name="name" required placeholder="e.g. MTN Mobile Money" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Phone Number</label>
                        <input type="text" name="number" required placeholder="6xx xxx xxx" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Account Name</label>
                        <input type="text" name="account_name" required placeholder="Full Name" class="w-full bg-slate-50 border border-slate-100 rounded-lg px-4 py-3 text-xs font-bold text-navy-800 focus:bg-white focus:border-gold-400/30 focus:ring-0 transition-all outline-none">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest px-1">Service Icon</label>
                    <input type="file" name="icon" accept="image/*" class="w-full bg-slate-50 border border-dashed border-slate-200 rounded-lg px-4 py-5 text-[10px] font-bold text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[9px] file:font-bold file:bg-navy-800 file:text-white cursor-pointer hover:border-gold-400/30 transition-all">
                    <p class="text-[9px] text-slate-400 italic px-1">Best results with square PNG images.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-2.5 pt-2">
                <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-3 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">Cancel</button>
                <button type="submit" class="flex-1 py-3 bg-navy-800 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest shadow-sm hover:bg-navy-900 transition-all">Create Gateway</button>
            </div>
        </form>
    </x-modal>
</x-admin-layout>
