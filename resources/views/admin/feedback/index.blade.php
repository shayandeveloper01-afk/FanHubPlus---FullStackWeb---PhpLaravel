<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Feedback</h1>
    </x-slot>

    {{-- Filters --}}
    <x-breadcrumb :crumbs="[['label' => 'Feedback']]" class="mb-4" />

    <form method="GET" class="flex flex-wrap gap-3 mb-5">
        <select name="type" onchange="this.form.submit()"
                class="bg-gray-800 border border-gray-700 text-sm text-white rounded-lg px-3 py-2">
            <option value="">All Types</option>
            <option value="bug"        {{ request('type') === 'bug'        ? 'selected' : '' }}>Bug</option>
            <option value="suggestion" {{ request('type') === 'suggestion' ? 'selected' : '' }}>Suggestion</option>
            <option value="general"    {{ request('type') === 'general'    ? 'selected' : '' }}>General</option>
            <option value="report"     {{ request('type') === 'report'     ? 'selected' : '' }}>Report</option>
        </select>
        <select name="status" onchange="this.form.submit()"
                class="bg-gray-800 border border-gray-700 text-sm text-white rounded-lg px-3 py-2">
            <option value="">All Statuses</option>
            <option value="new"       {{ request('status') === 'new'       ? 'selected' : '' }}>Pending</option>
            <option value="reviewed"  {{ request('status') === 'reviewed'  ? 'selected' : '' }}>In Review</option>
            <option value="resolved"  {{ request('status') === 'resolved'  ? 'selected' : '' }}>Resolved</option>
            <option value="dismissed" {{ request('status') === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
        </select>
    </form>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Ref</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">From</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Subject</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Type</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Date</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($feedback as $item)
                <tr class="hover:bg-gray-800/30 transition">
                    <td class="px-5 py-3 font-mono text-xs text-indigo-400">{{ $item->reference_code }}</td>
                    <td class="px-5 py-3 text-gray-300 max-w-[140px] truncate">
                        {{ $item->user?->name ?? $item->name ?? '—' }}
                        @if ($item->email)
                            <span class="block text-xs text-gray-500 truncate">{{ $item->email }}</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-white max-w-xs truncate">{{ $item->subject }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full border {{ $item->typeBadgeClass() }}">
                            {{ ucfirst($item->type) }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full border {{ $item->statusBadgeClass() }}">
                            {{ $item->statusLabel() }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs whitespace-nowrap">{{ $item->created_at->format('M j, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.feedback.show', $item) }}" class="text-indigo-400 hover:text-indigo-300 transition">View</a>
                            <form method="POST" action="{{ route('admin.feedback.destroy', $item) }}" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">No feedback found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $feedback->links() }}</div>
    </div>
</x-admin-layout>
