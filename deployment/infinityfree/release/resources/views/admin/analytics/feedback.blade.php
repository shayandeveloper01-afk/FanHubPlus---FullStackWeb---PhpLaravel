<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('admin.analytics.index') }}" class="hover:text-white transition">Analytics</a>
            <span>/</span>
            <span class="text-white">Feedback</span>
        </div>
    </x-slot>

    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endpush

    {{-- ── Date + Search Filters ──────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.feedback.analytics') }}"
          class="flex flex-wrap items-end gap-3 mb-6">
        <input type="date" name="from" value="{{ $from->toDateString() }}"
               class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
        <span class="text-gray-500 text-xs self-center">to</span>
        <input type="date" name="to" value="{{ $to->toDateString() }}"
               class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">

        <select name="type"
                class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
            <option value="">All Types</option>
            @foreach (['bug','suggestion','general','report'] as $t)
            <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
            @endforeach
        </select>

        <select name="status"
                class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
            <option value="">All Statuses</option>
            @foreach (['new','reviewed','resolved','dismissed'] as $s)
            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search subject / message…"
               class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500 w-52">

        <button type="submit"
                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs rounded-lg transition">
            Apply
        </button>
    </form>

    {{-- ── Stacked Bar: Category Breakdown Over Time ──────────────────────── --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 mb-6">
        <h2 class="text-sm font-semibold text-white mb-4">Category Breakdown Over Time</h2>
        <canvas id="chartFbBreakdown" height="120"></canvas>
    </div>

    {{-- ── Feedback Table ─────────────────────────────────────────────────── --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-xs">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Ref</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Subject</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Submitted</th>
                    <th class="px-4 py-3 text-left text-gray-400 font-medium uppercase">Resolution</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800" id="feedbackTableBody">
                @forelse ($feedback as $fb)
                <tr class="hover:bg-gray-800/30 transition" id="fb-row-{{ $fb->id }}">
                    <td class="px-4 py-3 text-gray-500 font-mono">{{ $fb->reference_code ?? '—' }}</td>
                    <td class="px-4 py-3 text-gray-300 max-w-xs truncate">{{ $fb->subject }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-0.5 rounded-full text-xs capitalize
                            {{ match($fb->type) {
                                'bug'        => 'bg-red-500/20 text-red-300',
                                'suggestion' => 'bg-blue-500/20 text-blue-300',
                                'report'     => 'bg-orange-500/20 text-orange-300',
                                default      => 'bg-gray-700 text-gray-400',
                            } }}">
                            {{ $fb->type }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        {{-- Inline status update --}}
                        <select data-fb-id="{{ $fb->id }}"
                                class="status-select bg-gray-800 border border-gray-700 text-white text-xs rounded px-2 py-1 focus:outline-none focus:border-indigo-500">
                            @foreach (['new','reviewed','resolved','dismissed'] as $s)
                            <option value="{{ $s }}" {{ $fb->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $fb->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-gray-500">
                        @if ($fb->status === 'resolved')
                            {{ round($fb->created_at->diffInHours($fb->updated_at), 1) }}h
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.feedback.show', $fb) }}"
                           class="text-indigo-400 hover:text-indigo-300 transition">View</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-10 text-center text-gray-600">No feedback found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-4">{{ $feedback->links() }}</div>
    </div>

    @push('scripts')
    <script>
    (function () {
        // ── Stacked bar: feedback by type per day ─────────────────────────────
        const raw = {!! json_encode($byTypePerDay) !!};
        const days   = Object.keys(raw);
        const types  = ['bug', 'suggestion', 'general', 'report'];
        const colors = {
            bug:        'rgba(239,68,68,0.8)',
            suggestion: 'rgba(59,130,246,0.8)',
            general:    'rgba(107,114,128,0.8)',
            report:     'rgba(234,179,8,0.8)',
        };

        const datasets = types.map(type => ({
            label: type.charAt(0).toUpperCase() + type.slice(1),
            backgroundColor: colors[type],
            data: days.map(day => {
                const rows = raw[day] ?? [];
                const row  = rows.find(r => r.type === type);
                return row ? row.total : 0;
            }),
        }));

        new Chart(document.getElementById('chartFbBreakdown'), {
            type: 'bar',
            data: { labels: days, datasets },
            options: {
                scales: {
                    x: { stacked: true, ticks: { color: '#6b7280', font: { size: 10 }, maxTicksLimit: 10 },
                         grid: { color: 'rgba(255,255,255,0.05)' } },
                    y: { stacked: true, ticks: { color: '#6b7280', font: { size: 10 } },
                         grid: { color: 'rgba(255,255,255,0.05)' }, beginAtZero: true }
                },
                plugins: { legend: { labels: { color: '#9ca3af', font: { size: 10 } } } }
            }
        });

        // ── Inline status update via AJAX ─────────────────────────────────────
        const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

        document.querySelectorAll('.status-select').forEach(sel => {
            sel.addEventListener('change', async function () {
                const id  = this.dataset.fbId;
                const val = this.value;
                try {
                    const res = await fetch(`/admin/feedback/${id}/status`, {
                        method:  'PATCH',
                        headers: {
                            'X-CSRF-TOKEN':  csrf,
                            'Content-Type':  'application/json',
                            'Accept':        'application/json',
                        },
                        body: JSON.stringify({ status: val }),
                    });
                    if (!res.ok) throw new Error();
                    // Flash the row green briefly
                    const row = document.getElementById(`fb-row-${id}`);
                    row.classList.add('bg-green-500/10');
                    setTimeout(() => row.classList.remove('bg-green-500/10'), 1200);
                } catch {
                    alert('Failed to update status.');
                }
            });
        });
    })();
    </script>
    @endpush
</x-admin-layout>
