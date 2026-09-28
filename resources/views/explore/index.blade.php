<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Explore — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen">

{{-- ── Nav (same as home) ───────────────────────────────────────────────── --}}
@include('layouts.navigation')

<main id="fh-main-content" class="fh-explore-page max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-6" tabindex="-1">

    <h1 class="text-2xl font-bold mb-6">Explore Content</h1>

    {{-- ── Filter Bar ───────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('explore') }}" id="filter-form"
          x-data="{ open: false }">

        {{-- Search + Sort row --}}
        <div class="flex flex-col sm:flex-row gap-3 mb-4">
            {{-- Search input --}}
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" name="q" value="{{ $search }}" data-fh-search autocomplete="off"
                       placeholder="Search titles, descriptions…"
                       class="w-full bg-gray-800 border border-gray-700 text-white placeholder-gray-500
                              rounded-lg pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2
                              focus:ring-indigo-500 focus:border-transparent">
            </div>

            {{-- Sort --}}
            <select name="sort" onchange="document.getElementById('filter-form').submit()"
                    class="bg-gray-800 border border-gray-700 text-white rounded-lg px-4 py-2.5
                           text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:w-44">
                <option value="newest" {{ in_array($sort, ['newest', 'latest']) ? 'selected' : '' }}>Newest</option>
                <option value="trending" {{ in_array($sort, ['trending', 'popular']) ? 'selected' : '' }}>Trending</option>
                <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Top rated</option>
                <option value="views" {{ $sort === 'views' ? 'selected' : '' }}>Most viewed</option>
            </select>

            {{-- Toggle filters button (mobile) --}}
            <button type="button" @click="open = !open"
                    class="sm:hidden flex items-center gap-2 bg-gray-800 border border-gray-700
                           text-white rounded-lg px-4 py-2.5 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4h18M7 8h10M11 12h4"/>
                </svg>
                Filters
            </button>

            {{-- Search submit --}}
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-5 py-2.5 text-sm font-medium transition">
                Search
            </button>
        </div>

        {{-- Filter dropdowns (always visible on sm+, toggle on mobile) --}}
        <div :class="open ? 'flex' : 'hidden sm:flex'" class="flex-wrap gap-3 mb-4">

            {{-- Category --}}
            <select name="category" onchange="document.getElementById('filter-form').submit()"
                    class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2
                           text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($filters['category'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            {{-- Genre --}}
            <select name="genre" onchange="document.getElementById('filter-form').submit()"
                    class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2
                           text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Genres</option>
                @foreach ($genres as $g)
                    <option value="{{ $g }}" {{ ($filters['genre'] ?? '') === $g ? 'selected' : '' }}>
                        {{ $g }}
                    </option>
                @endforeach
            </select>

            {{-- Year --}}
            <select name="year" onchange="document.getElementById('filter-form').submit()"
                    class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2
                           text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Years</option>
                @foreach ($years as $y)
                    <option value="{{ $y }}" {{ ($filters['year'] ?? '') == $y ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>

            {{-- Type --}}
            <select name="type" onchange="document.getElementById('filter-form').submit()"
                    class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2
                           text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">All Types</option>
                @foreach ($types as $t)
                    <option value="{{ $t }}" {{ ($filters['type'] ?? '') === $t ? 'selected' : '' }}>
                        {{ ucfirst($t) }}
                    </option>
                @endforeach
            </select>

            <label class="text-sm text-gray-400 flex items-center gap-2">Minimum rating
                <select name="min_rating" class="bg-gray-800 border border-gray-700 text-white rounded-lg px-3 py-2">
                    <option value="">Any</option>
                    @foreach ([3, 4, 5] as $rating)
                        <option value="{{ $rating }}" @selected(($filters['min_rating'] ?? '') == $rating)>{{ $rating }}+</option>
                    @endforeach
                </select>
            </label>

        </div>
    </form>

    {{-- ── Active Filter Chips ──────────────────────────────────────────── --}}
    @if (count($activeFilters) > 0)
        <div class="flex flex-wrap gap-2 mb-5">
            @foreach ($activeFilters as $key => $value)
                @php
                    $label = match($key) {
                        'category' => 'Category: ' . ($categories->firstWhere('id', $value)?->name ?? $value),
                        'genre'    => 'Genre: ' . $value,
                        'year'     => 'Year: ' . $value,
                        'type'     => 'Type: ' . ucfirst($value),
                        'search'   => 'Search: "' . $value . '"',
                        'sort'     => 'Sort: ' . ucfirst($value),
                        default    => $key . ': ' . $value,
                    };
                    // Build URL without this filter
                    $remaining = array_filter(
                        array_merge($filters, ['search' => $search, 'sort' => $sort]),
                        fn($v, $k) => filled($v) && $k !== $key,
                        ARRAY_FILTER_USE_BOTH
                    );
                @endphp
                <a href="{{ route('explore', $remaining) }}"
                   class="inline-flex items-center gap-1.5 bg-indigo-600/20 border border-indigo-500/40
                          text-indigo-300 text-xs px-3 py-1 rounded-full hover:bg-red-600/20
                          hover:border-red-500/40 hover:text-red-300 transition">
                    {{ $label }}
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            @endforeach
            <a href="{{ route('explore') }}"
               class="text-xs text-gray-500 hover:text-gray-300 px-2 py-1 transition">
                Clear all
            </a>
        </div>
    @endif

    {{-- ── Results count ────────────────────────────────────────────────── --}}
    <p class="text-sm text-gray-400 mb-5">
        {{ $contents->total() }} {{ Str::plural('result', $contents->total()) }} found
    </p>

    {{-- ── Content Grid ─────────────────────────────────────────────────── --}}
    @if ($contents->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <svg class="w-16 h-16 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-400 text-lg font-medium">No content found</p>
            <p class="text-gray-600 text-sm mt-1">Try adjusting your filters or search term.</p>
            <a href="{{ route('explore') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 text-sm transition">
                Clear all filters
            </a>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach ($contents as $content)
                <x-content-card :content="$content" />
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10 dark-pagination">
            {{ $contents->links() }}
        </div>
    @endif

</main>

@include('layouts.footer')


<script>
(() => {
    const input = document.querySelector('[data-fh-search]');
    if (!input) return;
    let timer;
    const list = document.createElement('div');
    list.className = 'fh-search-suggestions';
    list.setAttribute('role', 'listbox');
    input.parentElement.appendChild(list);
    input.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(async () => {
            const term = input.value.trim();
            if (!term) { list.replaceChildren(); return; }
            try {
                const response = await fetch(`{{ route('api.contents.search') }}?q=${encodeURIComponent(term)}`, { headers: { Accept: 'application/json' } });
                const results = await response.json();
                list.replaceChildren(...results.map((item) => {
                    const link = document.createElement('a');
                    link.className = 'fh-search-suggestion';
                    link.href = item.url;
                    link.textContent = item.title + (item.year ? ` (${item.year})` : '');
                    link.setAttribute('role', 'option');
                    return link;
                }));
            } catch (_) { list.replaceChildren(); }
        }, 300);
    });
    document.addEventListener('click', (event) => { if (!input.parentElement.contains(event.target)) list.replaceChildren(); });
})();
</script>

@stack('scripts')
</body>
</html>
