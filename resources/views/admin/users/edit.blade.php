<x-admin-layout>
    <x-slot name="header">Edit User</x-slot>

    <div class="space-y-6">
        <!-- Back Button -->
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold text-slate-400 hover:text-gold-500 uppercase tracking-widest transition-all">
            <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i>
            Back to User Database
        </a>

        <!-- Header Card -->
        <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
            <img src="https://img.freepik.com/free-photo/group-diverse-people-social-network-concept_53876-121016.jpg"
                 class="absolute inset-0 w-full h-full object-cover opacity-10">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
            <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Edit <span class="text-gold-400">User</span>
                </h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                    Update account details, role, status, and profile photo.
                </p>
            </div>
        </div>

        @if(session('error'))
        <div class="bg-rose-500 text-white p-4 rounded-xl shadow-lg flex items-center gap-4">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="text-xs font-bold">{{ session('error') }}</span>
        </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6"
              x-data="{
                  role: '{{ $user->role->value }}',
                  status: '{{ $user->status }}',
                  photoPreview: null,
                  previewPhoto(event) {
                      const file = event.target.files[0];
                      if (file) { const r = new FileReader(); r.onload = e => this.photoPreview = e.target.result; r.readAsDataURL(file); }
                  }
              }">
            @csrf @method('PUT')

            <!-- Profile Photo -->
            <div class="admin-card p-6 md:p-8">
                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-6">Profile Photo</h3>
                <div class="flex items-center gap-6">
                    <label class="relative group cursor-pointer w-24 h-24 rounded-2xl border-2 border-dashed border-slate-200 overflow-hidden flex items-center justify-center hover:border-gold-400 transition-all bg-slate-50 shrink-0">
                        <input type="file" name="profile_photo" class="hidden" accept="image/*" @change="previewPhoto">
                        <img x-show="photoPreview" :src="photoPreview" class="w-full h-full object-cover">
                        <div x-show="!photoPreview" class="w-full h-full">
                            @if($user->profile_photo_path)
                                <img src="{{ r2_url($user->profile_photo_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <span class="material-symbols-outlined text-3xl">add_photo_alternate</span>
                                </div>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-navy-900/80 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center text-white rounded-2xl">
                            <span class="material-symbols-outlined text-2xl">camera_alt</span>
                        </div>
                    </label>
                    <div>
                        <p class="text-[13px] font-bold text-navy-800">{{ $user->name }}</p>
                        <p class="text-[10px] text-slate-400 font-medium">Click avatar to change photo</p>
                    </div>
                </div>
            </div>

            <!-- Account Details -->
            <div class="admin-card p-6 md:p-8">
                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-6">Account Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all">
                        @error('name') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all">
                        @error('email') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all">
                        @error('phone') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest ml-1">Account Role</label>
                        <select name="role" x-model="role"
                                class="w-full h-11 bg-slate-50 border-none rounded-xl px-4 text-sm font-medium text-navy-800 focus:ring-2 focus:ring-gold-400/20 transition-all appearance-none">
                            <option value="User" {{ $user->role === \App\Enums\Role::User ? 'selected' : '' }}>User</option>
                            <option value="Superadmin" {{ $user->role === \App\Enums\Role::Superadmin ? 'selected' : '' }}>Superadmin</option>
                        </select>
                        @error('role') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Store Ownership -->
            <div class="admin-card p-6 md:p-8">
                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-6">Store Ownership</h3>
                <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all"
                       :class="role === 'Superadmin' ? 'opacity-50 pointer-events-none border-slate-200' : 'hover:bg-slate-50 border-slate-200'">
                    <input type="checkbox" name="has_store" value="1"
                           {{ $user->store ? 'checked' : '' }}
                           {{ $user->role === \App\Enums\Role::Superadmin ? 'disabled' : '' }}
                           class="w-4 h-4 text-gold-500 focus:ring-0 rounded">
                    <div>
                        <span class="text-[13px] font-bold text-navy-800">Has Store</span>
                        <p class="text-[9px] text-slate-400 font-medium">User owns a store on the platform</p>
                    </div>
                </label>
            </div>

            <!-- Account Status -->
            <div class="admin-card p-6 md:p-8">
                <h3 class="text-xs font-bold text-navy-800 uppercase tracking-widest mb-6">Account Status</h3>

                <div class="flex flex-wrap gap-4">
                    <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all hover:bg-slate-50"
                           :class="status === 'active' ? 'border-emerald-300 bg-emerald-50' : 'border-slate-200'">
                        <input type="radio" name="status" value="active" x-model="status" class="w-4 h-4 text-emerald-500 focus:ring-0">
                        <div>
                            <span class="text-[13px] font-bold text-navy-800">Active</span>
                            <p class="text-[9px] text-slate-400 font-medium">Full platform access</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition-all hover:bg-slate-50"
                           :class="status === 'suspended' ? 'border-rose-300 bg-rose-50' : 'border-slate-200'">
                        <input type="radio" name="status" value="suspended" x-model="status" class="w-4 h-4 text-rose-500 focus:ring-0">
                        <div>
                            <span class="text-[13px] font-bold text-navy-800">Suspended</span>
                            <p class="text-[9px] text-slate-400 font-medium">No access to platform</p>
                        </div>
                    </label>
                </div>
                @error('status') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Submit -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-navy-800 text-white rounded-xl text-[11px] font-black uppercase tracking-widest hover:bg-navy-900 transition-all shadow-lg shadow-navy-800/20 flex items-center justify-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>