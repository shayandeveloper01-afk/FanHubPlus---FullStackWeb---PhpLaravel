<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-white">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">+ New</a>
        </div>
    </x-slot>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Name</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Description</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Contents</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($categories as $category)
                <tr class="hover:bg-gray-800/30 transition">
                    <td class="px-5 py-3 font-medium text-white">{{ $category->name }}</td>
                    <td class="px-5 py-3 text-gray-400 max-w-xs truncate">{{ $category->description ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $category->contents_count }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $category->isActive() ? 'bg-green-500/20 text-green-300' : 'bg-gray-700 text-gray-400' }}">
                            {{ ucfirst($category->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?')">@csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>
