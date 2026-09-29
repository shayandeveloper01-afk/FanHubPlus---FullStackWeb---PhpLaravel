<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-white">Content</h1>
            <a href="{{ route('admin.contents.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">+ New</a>
        </div>
    </x-slot>

    <form method="GET" class="flex flex-wrap gap-2 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title…"
               class="flex-1 min-w-0 bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        <select name="category" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="">All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="">All Status</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="trashed"   {{ request('status') === 'trashed'   ? 'selected' : '' }}>Trashed</option>
        </select>
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">Filter</button>
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Uploaded by</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Author</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Views</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($contents as $content)
                <tr class="hover:bg-gray-800/30 transition {{ $content->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3 font-medium text-white max-w-xs truncate">{{ $content->title }}</td>
                    <td class="px-5 py-3 text-gray-400">
                        @if ($content->user)
                            <a href="{{ route('admin.users.show', $content->user) }}" class="text-purple-200 hover:text-white">{{ $content->user->name }}</a>
                        @else
                            Unknown user
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ $content->category->name }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $content->user->name }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $content->trashed() ? 'bg-gray-700 text-gray-400' : ($content->isPublished() ? 'bg-green-500/20 text-green-300' : 'bg-yellow-500/20 text-yellow-300') }}">
                            {{ $content->trashed() ? 'Trashed' : ucfirst($content->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ number_format($content->views_count) }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if ($content->trashed())
                                <form method="POST" action="{{ route('admin.contents.restore', $content->id) }}">@csrf
                                    <button class="text-green-400 hover:text-green-300 transition">Restore</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('admin.contents.moderate', $content) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-amber-300 hover:text-amber-200 transition">{{ $content->isPublished() ? 'Hide' : 'Publish' }}</button>
                                </form>
                                <a href="{{ route('admin.contents.edit', $content) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                <form method="POST" action="{{ route('admin.contents.destroy', $content) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">No content found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $contents->links() }}</div>
    </div>
</x-admin-layout>
