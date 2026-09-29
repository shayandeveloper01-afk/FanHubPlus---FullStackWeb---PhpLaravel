<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Activity Log</h1>
    </x-slot>

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap gap-2 mb-5">
        <select name="admin_id"
                class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
            <option value="">All Admins</option>
            @foreach ($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                    {{ $admin->name }}
                </option>
            @endforeach
        </select>

        <input type="text" name="action" value="{{ request('action') }}" placeholder="Action (e.g. user.ban)…"
               class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500 w-48">

        <input type="date" name="from" value="{{ request('from') }}"
               class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">
        <span class="text-gray-500 text-sm self-center">to</span>
        <input type="date" name="to" value="{{ request('to') }}"
               class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:border-indigo-500">

        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm rounded-lg transition">
            Filter
        </button>
        @if (request()->hasAny(['admin_id','action','from','to']))
            <a href="{{ route('admin.activity-log.index') }}"
               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition">
                Clear
            </a>
        @endif
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">When</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Admin</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Action</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Target</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Notes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($logs as $log)
                <tr class="hover:bg-gray-800/30 transition">
                    <td class="px-5 py-3 text-gray-500 whitespace-nowrap">
                        {{ $log->created_at->format('d M Y, h:i A') }}
                    </td>
                    <td class="px-5 py-3 text-gray-300">{{ $log->admin?->name ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="font-mono text-xs px-2 py-0.5 rounded
                            {{ str_starts_with($log->action, 'user.')     ? 'bg-indigo-500/20 text-indigo-300' :
                              (str_starts_with($log->action, 'content.')  ? 'bg-blue-500/20 text-blue-300'   :
                              (str_starts_with($log->action, 'event.')    ? 'bg-green-500/20 text-green-300' :
                              (str_starts_with($log->action, 'settings.') ? 'bg-yellow-500/20 text-yellow-300' :
                               'bg-gray-700 text-gray-400'))) }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs">
                        @if ($log->target_type && $log->target_id)
                            {{ $log->target_type }} #{{ $log->target_id }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-5 py-3 text-gray-400 max-w-xs truncate">{{ $log->notes ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-10 text-center text-gray-500">No activity logged yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $logs->links() }}</div>
    </div>
</x-admin-layout>
