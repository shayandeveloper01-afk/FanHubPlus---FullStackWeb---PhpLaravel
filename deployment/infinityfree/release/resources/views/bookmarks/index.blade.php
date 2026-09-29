<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">My Bookmarks</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if ($bookmarks->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <svg class="w-16 h-16 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <p class="text-gray-400 text-lg font-medium">No bookmarks yet</p>
                    <p class="text-gray-600 text-sm mt-1">Browse content and hit the bookmark button to save it here.</p>
                    <a href="{{ route('explore') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 text-sm transition">
                        Explore Content
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                    @foreach ($bookmarks as $bookmark)
                        <x-content-card :content="$bookmark->content" :bookmarked="true" />
                    @endforeach
                </div>
                <div class="mt-8 dark-pagination">
                    {{ $bookmarks->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
