<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-white">Characters</h1>
            <a href="{{ route('admin.characters.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">+ New</a>
        </div>
    </x-slot>

    <form method="GET" class="flex gap-2 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name…"
               class="flex-1 bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">Search</button>
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Alias</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Role</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Content</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($characters as $char)
                <tr class="hover:bg-gray-800/30 transition">
                    <td class="px-5 py-3 font-medium text-white">{{ $char->name }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $char->alias ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $char->role ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-400 max-w-xs truncate">{{ $char->content->title }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.characters.edit', $char) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                            <form method="POST" action="{{ route('admin.characters.destroy', $char) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">No characters found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $characters->links() }}</div>
    </div>
</x-admin-layout>
