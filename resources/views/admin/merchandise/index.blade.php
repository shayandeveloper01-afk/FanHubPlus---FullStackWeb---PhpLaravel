<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Merchandise</h1>
    </x-slot>

    <form method="GET" class="flex flex-wrap gap-2 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title…"
               class="flex-1 min-w-0 bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        <select name="status" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="">All Status</option>
            <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            <option value="trashed"  {{ request('status') === 'trashed'  ? 'selected' : '' }}>Trashed</option>
        </select>
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">Filter</button>
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Category</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Price</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($merchandise as $item)
                <tr class="hover:bg-gray-800/30 transition {{ $item->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3 font-medium text-white max-w-xs truncate">{{ $item->title }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $item->category->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $item->formattedPrice() }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $item->trashed() ? 'bg-gray-700 text-gray-400' : ($item->isActive() ? 'bg-green-500/20 text-green-300' : 'bg-yellow-500/20 text-yellow-300') }}">
                            {{ $item->trashed() ? 'Trashed' : ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if ($item->trashed())
                                <form method="POST" action="{{ route('admin.merchandise.restore', $item->id) }}">@csrf
                                    <button class="text-green-400 hover:text-green-300 transition">Restore</button>
                                </form>
                            @else
                                <a href="{{ route('admin.merchandise.edit', $item) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                <form method="POST" action="{{ route('admin.merchandise.destroy', $item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">No merchandise found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $merchandise->links() }}</div>
    </div>
</x-admin-layout>
