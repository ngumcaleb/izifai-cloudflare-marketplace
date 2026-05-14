<x-admin-layout>
    <x-slot name="header">New Category</x-slot>

    <div class="max-w-2xl mx-auto">
        <!-- Header Card -->
        <div class="relative bg-navy-800 rounded-xl h-[100px] md:h-[130px] overflow-hidden shadow-sm mb-6">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/40 to-transparent"></div>
            <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Create <span class="text-gold-400">Category</span>
                </h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-medium mt-1">
                    Add a new product category to organize the marketplace.
                </p>
            </div>
        </div>

        <div class="admin-card p-6 md:p-8">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Category Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('name') ring-2 ring-rose-200 @enderror"
                               placeholder="e.g. Electronics, Fashion, Home & Garden">
                        @error('name')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Slug <span class="text-slate-400 font-normal normal-case">(leave blank to auto-generate)</span></label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-mono font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('slug') ring-2 ring-rose-200 @enderror"
                               placeholder="e.g. electronics">
                        @error('slug')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Parent Category -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Parent Category <span class="text-slate-400 font-normal normal-case">(optional)</span></label>
                        <select name="parent_id" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all appearance-none">
                            <option value="">— No Parent (Top Level) —</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Icon <span class="text-slate-400 font-normal normal-case">(SVG or HTML)</span></label>
                        <input type="text" name="icon" value="{{ old('icon') }}"
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-mono font-medium focus:ring-2 focus:ring-gold-400/20 transition-all"
                               placeholder='e.g. <svg ...> or <i class="fas fa-tag"></i>'>
                        <p class="text-[9px] text-slate-400 mt-1.5">Optional icon displayed alongside the category name throughout the marketplace.</p>
                    </div>

                    <!-- Image Path -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Image Path <span class="text-slate-400 font-normal normal-case">(storage path)</span></label>
                        <input type="text" name="image_path" value="{{ old('image_path') }}"
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-mono font-medium focus:ring-2 focus:ring-gold-400/20 transition-all"
                               placeholder="e.g. categories/electronics.jpg">
                        <p class="text-[9px] text-slate-400 mt-1.5">Relative path inside <code class="text-[9px] font-mono bg-slate-100 px-1 py-0.5 rounded">storage/app/public/</code></p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}" class="text-[11px] font-bold text-slate-400 hover:text-navy-800 transition-colors">
                        ← Back to Categories
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gold-500 text-navy-900 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-gold-400 transition-all shadow-sm">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
