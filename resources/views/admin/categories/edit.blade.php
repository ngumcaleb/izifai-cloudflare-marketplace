<x-admin-layout>
    <x-slot name="header">Edit Category</x-slot>

    <div class="max-w-2xl mx-auto">
        <!-- Header Card -->
        <div class="relative bg-navy-800 rounded-xl h-[100px] md:h-[130px] overflow-hidden shadow-sm mb-6">
            <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/40 to-transparent"></div>
            <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                    Edit <span class="text-gold-400">{{ $category->name }}</span>
                </h2>
                <p class="text-[10px] md:text-xs text-slate-400 font-medium mt-1">
                    Update category details and organization.
                </p>
            </div>
        </div>

        <div class="admin-card p-6 md:p-8">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Category Name <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all @error('name') ring-2 ring-rose-200 @enderror"
                               placeholder="e.g. Electronics, Fashion, Home & Garden">
                        @error('name')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Slug <span class="text-slate-400 font-normal normal-case">(leave blank to auto-generate)</span></label>
                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}"
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
                                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        @error('parent_id')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Icon <span class="text-slate-400 font-normal normal-case">(SVG or HTML)</span></label>
                        <input type="text" name="icon" value="{{ old('icon', $category->icon) }}"
                               class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-mono font-medium focus:ring-2 focus:ring-gold-400/20 transition-all"
                               placeholder='e.g. <svg ...> or <i class="fas fa-tag"></i>'>
                        <p class="text-[9px] text-slate-400 mt-1.5">Optional icon displayed alongside the category name throughout the marketplace.</p>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-[11px] font-bold text-navy-800 uppercase tracking-widest mb-2">Image <span class="text-slate-400 font-normal normal-case">(upload to replace)</span></label>
                        <label for="category-image"
                               class="flex items-center gap-4 p-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-xl cursor-pointer hover:border-gold-400 hover:bg-gold-400/5 transition-all">
                            <span class="w-14 h-14 bg-white rounded-lg border border-slate-100 overflow-hidden grid place-items-center shrink-0">
                                @if($category->image_path)
                                    <img id="imagePreview" src="{{ $category->image_url }}" alt="" class="w-full h-full object-cover">
                                @else
                                    <img id="imagePreview" src="data:," alt="" class="w-full h-full object-cover hidden">
                                @endif
                                <i data-lucide="image" id="imagePlaceholder" class="w-5 h-5 text-slate-300 {{ $category->image_path ? 'hidden' : '' }}"></i>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-bold text-navy-800">Click to upload a category image</span>
                                <span class="block text-[10px] text-slate-400 mt-0.5">JPG, PNG, WebP or GIF · max 2 MB · uploads replace the current image</span>
                            </span>
                        </label>
                        <input type="file" id="category-image" name="image" accept="image/*" class="sr-only" onchange="previewCategoryImage(this, 'imagePreview', 'imagePlaceholder')">
                        @error('image')
                            <p class="text-[10px] text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <script>
                    function previewCategoryImage(input, previewId, placeholderId) {
                        var img = document.getElementById(previewId);
                        var ph = document.getElementById(placeholderId);
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                img.src = e.target.result;
                                img.classList.remove('hidden');
                                if (ph) ph.style.display = 'none';
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}" class="text-[11px] font-bold text-slate-400 hover:text-navy-800 transition-colors">
                        ← Back to Categories
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gold-500 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-gold-400 transition-all shadow-sm">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
