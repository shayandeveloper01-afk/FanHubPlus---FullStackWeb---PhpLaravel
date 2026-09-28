<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">My Articles</h2>
            <a href="{{ route('articles.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition">
                + New Article
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-900/40 border border-green-700 text-green-300 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($articles->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <svg class="w-16 h-16 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-gray-400 text-lg font-medium">No articles yet</p>
                    <a href="{{ route('articles.create') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 text-sm transition">
                        Write your first article
                    </a>
                </div>
            @else
                <div class="bg-gray-900 rounded-xl overflow-hidden border border-gray-800">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Thumbnail</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Featured</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Date</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach ($articles as $article)
                            <tr class="hover:bg-gray-800/30 transition">
                                <td class="px-6 py-4">
                                    <a href="{{ route('articles.show', $article) }}">
                                        <img src="{{ $article->coverImageUrl() }}" alt="{{ $article->title }}"
                                             class="w-16 h-10 object-cover rounded-md">
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('articles.show', $article) }}"
                                       class="text-indigo-400 hover:text-indigo-300 font-medium transition">
                                        {{ $article->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $article->isPublished() ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                                        {{ ucfirst($article->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if ($article->is_featured)
                                        <span class="text-yellow-400">★ Featured</span>
                                    @else
                                        <span class="text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $article->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right space-x-3 text-sm">
                                    <a href="{{ route('articles.edit', $article) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                    <form method="POST" action="{{ route('articles.destroy', $article) }}" class="inline"
                                          onsubmit="return confirm('Delete this article?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="px-6 py-4 dark-pagination">{{ $articles->links() }}</div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
