<x-seller-layout>
    <x-slot name="title">New Category</x-slot>

    <div class="max-w-2xl mx-auto animate-fade-in">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 md:mb-6">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-gray-900">Add Category</h1>
                <p class="text-sm text-gray-500 mt-0.5">Create a custom category for your store</p>
            </div>
            <a href="{{ route('seller.store-categories.index') }}"
               class="text-xs font-semibold text-gray-500 hover:text-primary flex items-center gap-1.5 transition-colors">
                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                Back
            </a>
        </div>

        <form action="{{ route('seller.store-categories.store') }}" method="POST" class="space-y-4 md:space-y-6">
            @csrf

            <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100/80 space-y-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Category Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           placeholder="e.g. Heavy Machinery, Electrical Work"
                           class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-gray-500 ml-1">Parent Category (optional)</label>
                    <select name="parent_id"
                            class="w-full h-11 md:h-12 bg-gray-50 border border-gray-200 rounded-xl px-4 text-sm focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50">
                        <option value="">— Top-level category —</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 ml-1">Leave empty to create a top-level category, or select a parent to create a subcategory.</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('seller.store-categories.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors border border-gray-200">
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto whitespace-nowrap bg-primary text-white px-8 py-3 rounded-xl text-sm font-bold hover:opacity-90 active:scale-[0.97] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    Create Category
                </button>
            </div>
        </form>
    </div>
</x-seller-layout>
