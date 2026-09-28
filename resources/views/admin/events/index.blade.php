<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Events</h1>
    </x-slot>

    <form method="GET" class="flex flex-wrap gap-2 mb-5">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title…"
               class="flex-1 min-w-0 bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        <select name="status" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="">All Status</option>
            <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>Trashed</option>
        </select>
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">Filter</button>
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Title</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Author</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Start</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($events as $event)
                <tr class="hover:bg-gray-800/30 transition {{ $event->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3 font-medium text-white max-w-xs truncate">{{ $event->title }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $event->user->name }}</td>
                    <td class="px-5 py-3 text-gray-400">{{ $event->start_datetime->format('d M Y') }}</td>
                    <td class="px-5 py-3">
                        @if ($event->trashed())
                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-700 text-gray-400">Trashed</span>
                        @else
                            <span class="px-2 py-0.5 text-xs rounded-full border {{ $event->statusBadgeClass() }}">{{ ucfirst($event->status()) }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if ($event->trashed())
                                <form method="POST" action="{{ route('admin.events.restore', $event->id) }}">@csrf
                                    <button class="text-green-400 hover:text-green-300 transition">Restore</button>
                                </form>
                            @else
                                <a href="{{ route('admin.events.edit', $event) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">No events found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $events->links() }}</div>
    </div>
</x-admin-layout>
