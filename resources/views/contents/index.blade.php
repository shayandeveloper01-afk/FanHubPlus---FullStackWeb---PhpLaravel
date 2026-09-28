<x-app-layout>
    @push('head')
        <title>My Content — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-white">My Content</h1>
                <p class="text-gray-400 text-sm mt-1">{{ $contents->total() }} post{{ $contents->total() !== 1 ? 's' : '' }}</p>
            </div>
            <a href="{{ route('contents.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                New Content
            </a>
        </div>

        @if (session('success'))
            <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($contents->isEmpty())
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <svg class="w-14 h-14 text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-gray-400 text-lg font-medium">No content yet</p>
                <a href="{{ route('contents.create') }}" class="mt-4 text-indigo-400 hover:text-indigo-300 text-sm transition">
                    Create your first post
                </a>
            </div>
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
                <table class="min-w-full divide-y divide-gray-800">
                    <thead class="bg-gray-800/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach ($contents as $content)
                        <tr class="hover:bg-gray-800/30 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('contents.show', $content) }}">
                                    <img src="{{ $content->thumbnailUrl() }}" alt="{{ $content->title }}"
                                         class="w-12 h-16 object-cover rounded-md">
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('contents.show', $content) }}"
                                   class="text-indigo-400 hover:text-indigo-300 font-medium transition text-sm">
                                    {{ $content->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $content->category->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $content->isPublished() ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                                    {{ ucfirst($content->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $content->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-right flex items-center justify-end gap-4 text-sm">
                                <a href="{{ route('contents.edit', $content) }}"
                                   class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                <form method="POST" action="{{ route('contents.destroy', $content) }}"
                                      onsubmit="return confirm('Delete this content?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 dark-pagination">{{ $contents->links() }}</div>
            </div>
        @endif

    </div>
</x-app-layout>
