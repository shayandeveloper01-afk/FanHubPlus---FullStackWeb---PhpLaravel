<x-admin-layout>
    <x-slot name="header"><h1 class="text-lg font-semibold text-white">Users</h1></x-slot>

    <div class="flex flex-wrap gap-3 mb-5">
        <form method="GET" class="flex gap-2 flex-1 min-w-0">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email…"
                   class="flex-1 bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <select name="filter" class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                <option value="">All</option>
                <option value="admin"   {{ request('filter') === 'admin'   ? 'selected' : '' }}>Admins</option>
                <option value="banned"  {{ request('filter') === 'banned'  ? 'selected' : '' }}>Banned</option>
                <option value="deleted" {{ request('filter') === 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">Filter</button>
        </form>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">User</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Joined</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($users as $user)
                <tr class="hover:bg-gray-800/30 transition {{ $user->trashed() ? 'opacity-50' : '' }}">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatarUrl() }}" class="h-8 w-8 rounded-full object-cover">
                            <div>
                                <p class="font-medium text-white">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-5 py-3">
                        <div class="flex flex-wrap gap-1">
                            @if ($user->is_admin)
                                <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/40">Admin</span>
                            @endif
                            @if ($user->isBanned())
                                <span class="px-2 py-0.5 text-xs rounded-full bg-red-500/20 text-red-300 border border-red-500/40">Banned</span>
                            @endif
                            @if ($user->trashed())
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-700 text-gray-400 border border-gray-600">Deleted</span>
                            @endif
                            @if (!$user->is_admin && !$user->isBanned() && !$user->trashed())
                                <span class="px-2 py-0.5 text-xs rounded-full bg-green-500/20 text-green-300 border border-green-500/40">Active</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-3 flex-wrap">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="text-indigo-400 hover:text-indigo-300 transition">View</a>

                            @if ($user->id !== auth()->id())
                                @if (!$user->trashed())
                                    @if ($user->is_admin)
                                        <form method="POST" action="{{ route('admin.users.demote', $user) }}">@csrf
                                            <button class="text-yellow-400 hover:text-yellow-300 transition">Demote</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.promote', $user) }}">@csrf
                                            <button class="text-green-400 hover:text-green-300 transition">Promote</button>
                                        </form>
                                    @endif

                                    @if (!$user->is_admin)
                                        @if ($user->isBanned())
                                            <form method="POST" action="{{ route('admin.users.unban', $user) }}">@csrf
                                                <button class="text-blue-400 hover:text-blue-300 transition">Unban</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.users.ban', $user) }}">@csrf
                                                <button class="text-orange-400 hover:text-orange-300 transition">Ban</button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                              onsubmit="return confirm('Soft-delete this user?')">@csrf @method('DELETE')
                                            <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                                        </form>
                                    @endif
                                @else
                                    <form method="POST" action="{{ route('admin.users.restore', $user->id) }}">@csrf
                                        <button class="text-green-400 hover:text-green-300 transition">Restore</button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-10 text-center text-gray-500">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $users->links() }}</div>
    </div>
</x-admin-layout>
