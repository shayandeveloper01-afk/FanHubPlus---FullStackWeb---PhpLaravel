<x-app-layout>
    @push('head')
        <title>Merchandise — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">Merchandise</h1>
                <p class="text-gray-400 text-sm mt-1">{{ $items->total() }} item{{ $items->total() !== 1 ? 's' : '' }}</p>
            </div>
            @auth
                <a href="{{ route('merchandise.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Merchandise
                </a>
            @endauth
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('merchandise.index') }}"
              class="flex flex-wrap gap-3 mb-8 items-end">

            <div class="flex flex-col gap-1">
                <label class="text-xs text-gray-400 font-medium">Category</label>
                <select name="category" onchange="this.form.submit()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(($filters['category'] ?? '') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs text-gray-400 font-medium">Tag</label>
                <select name="tag" onchange="this.form.submit()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Tags</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected(($filters['tag'] ?? '') == $tag->id)>{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col gap-1">
                <label class="text-xs text-gray-400 font-medium">Sort</label>
                <select name="sort" onchange="this.form.submit()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="latest"     @selected($sort === 'latest')>Latest</option>
                    <option value="popular"    @selected($sort === 'popular')>Most Viewed</option>
                    <option value="price_asc"  @selected($sort === 'price_asc')>Price: Low → High</option>
                    <option value="price_desc" @selected($sort === 'price_desc')>Price: High → Low</option>
                </select>
            </div>

            @if (count($activeFilters))
                <a href="{{ route('merchandise.index') }}"
                   class="self-end px-3 py-2 text-xs text-gray-400 hover:text-white border border-gray-700 rounded-lg transition">
                    Clear filters
                </a>
            @endif
        </form>

        {{-- Flash --}}
        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid --}}
        @if ($items->isEmpty())
            <div class="text-center py-24 text-gray-500">
                <svg class="w-12 h-12 mx-auto mb-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/></svg>
                <p class="text-lg font-medium">No merchandise found</p>
                <p class="text-sm mt-1">Try adjusting your filters.</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                @foreach ($items as $item)
                    <x-merchandise-card :item="$item" />
                @endforeach
            </div>

            <div class="mt-8 dark-pagination">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
