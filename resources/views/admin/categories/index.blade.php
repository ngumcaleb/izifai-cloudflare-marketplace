<x-admin-layout>
    <x-slot name="header">Category Management</x-slot>

    <!-- Header Card -->
    <div class="relative bg-navy-800 rounded-xl h-[120px] md:h-[160px] overflow-hidden shadow-sm mb-6">
        <img src="https://img.freepik.com/free-photo/online-fashion-shopping-with-credit-card_23-2148681568.jpg"
             class="absolute inset-0 w-full h-full object-cover opacity-10">
        <div class="absolute inset-0 bg-gradient-to-r from-navy-900 via-navy-800/20 to-transparent"></div>
        <div class="relative z-10 h-full p-6 md:p-8 flex flex-col justify-center">
            <h2 class="text-xl md:text-2xl font-bold text-white tracking-tight">
                Category <span class="text-gold-400">Management</span>
            </h2>
            <p class="text-[10px] md:text-xs text-slate-400 font-medium max-w-md mt-1">
                Organize products into categories. Create, edit, or remove categories across the platform.
            </p>
        </div>
    </div>

    <div class="space-y-6">
        @if(session('success'))
        <div class="bg-navy-900 border border-gold-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="check-circle" class="w-4 h-4 text-gold-400"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-rose-900/80 border border-rose-500/30 text-white p-3 rounded-xl shadow-lg flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-4 h-4 text-rose-400"></i>
            <span class="text-xs font-bold uppercase tracking-wider">{{ session('error') }}</span>
        </div>
        @endif

        <!-- Search & Actions -->
        <div class="admin-card p-4 md:p-6">
            <div class="flex flex-col md:flex-row gap-4 items-start md:items-center justify-between">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 flex-1">
                    <div class="flex-1 relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search categories..." 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-gold-400/20 transition-all">
                        <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-navy-800 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-navy-900 transition-all shadow-sm">
                        Filter
                    </button>
                </form>
                <a href="{{ route('admin.categories.create') }}" 
                   class="flex items-center gap-2 px-5 py-2.5 bg-gold-500 text-navy-900 rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-gold-400 transition-all shadow-sm shrink-0">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    New Category
                </a>
            </div>
        </div>

        <!-- Stats Bar -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="admin-card p-4">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Total Categories</p>
                <h3 class="text-lg font-bold text-navy-800 mt-1">{{ $categories->total() }}</h3>
            </div>
            <div class="admin-card p-4">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Products Categorized</p>
                <h3 class="text-lg font-bold text-navy-800 mt-1">{{ number_format($totalProducts) }}</h3>
            </div>
            <div class="admin-card p-4">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">With Subcategories</p>
                <h3 class="text-lg font-bold text-navy-800 mt-1">{{ $categories->filter(fn($c) => $c->parent)->count() }}</h3>
            </div>
            <div class="admin-card p-4">
                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Top Level</p>
                <h3 class="text-lg font-bold text-navy-800 mt-1">{{ $categories->filter(fn($c) => !$c->parent)->count() }}</h3>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="admin-card overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Slug</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest">Parent</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-center">Products</th>
                            <th class="px-6 py-4 text-[9px] font-bold text-slate-400 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center text-navy-800 shrink-0 border border-slate-100">
                                        @if($category->icon && str_starts_with($category->icon, '<'))
                                            <span class="text-xs">{!! $category->icon !!}</span>
                                        @elseif($category->image_path)
                                            <img src="{{ $category->image_url }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <i data-lucide="folder" class="w-4 h-4 text-slate-400"></i>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-[13px] font-bold text-navy-800 truncate">{{ $category->name }}</h4>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <code class="text-[10px] font-mono text-slate-400 bg-slate-50 px-1.5 py-0.5 rounded">{{ $category->slug }}</code>
                            </td>
                            <td class="px-6 py-4">
                                @if($category->parent)
                                    <span class="text-[11px] font-medium text-slate-600">{{ $category->parent->name }}</span>
                                @else
                                    <span class="text-[10px] text-slate-400 italic">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[32px] px-2 py-0.5 text-[10px] font-bold rounded {{ $category->products_count > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-50 text-slate-400' }}">
                                    {{ $category->products_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       class="p-2 bg-slate-50 text-navy-800 hover:bg-navy-800 hover:text-white rounded-lg transition-all" title="Edit">
                                        <i data-lucide="pencil" class="w-4 h-4"></i>
                                    </a>
                                    @if($category->products_count === 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete &ldquo;{{ $category->name }}&rdquo; permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="p-2 bg-slate-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all" title="Delete">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="p-2 bg-slate-50 text-slate-300 rounded-lg cursor-not-allowed" title="Has {{ $category->products_count }} product(s) — cannot delete">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic text-sm">No categories found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Cards -->
            <div class="md:hidden divide-y divide-slate-50">
                @forelse($categories as $category)
                <div class="p-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center text-navy-800 shrink-0 border border-slate-100">
                            @if($category->icon && str_starts_with($category->icon, '<'))
                                <span class="text-xs">{!! $category->icon !!}</span>
                            @else
                                <i data-lucide="folder" class="w-4 h-4 text-slate-400"></i>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-[13px] font-bold text-navy-800">{{ $category->name }}</h4>
                            <div class="flex gap-1.5 mt-0.5">
                                <span class="text-[9px] text-slate-400 font-mono">{{ $category->slug }}</span>
                                <span class="text-[9px] text-slate-300">·</span>
                                <span class="text-[9px] {{ $category->products_count > 0 ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">{{ $category->products_count }} products</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 shrink-0">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="p-2 bg-slate-50 text-navy-800 rounded-lg">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        @if($category->products_count === 0)
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete &quot;{{ $category->name }}&quot; permanently?')">
                            @csrf
                            @method('DELETE')
                            <button class="p-2 bg-slate-50 text-rose-500 rounded-lg">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-10 text-center text-slate-400 italic text-xs">No categories yet.</div>
                @endforelse
            </div>
        </div>

        @if($categories->hasPages())
        <div class="mt-4">
            {{ $categories->links('partials.pagination') }}
        </div>
        @endif
    </div>
</x-admin-layout>
