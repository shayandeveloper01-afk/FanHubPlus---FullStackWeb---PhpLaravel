<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Analytics Dashboard</h1>
    </x-slot>

    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endpush

    {{-- ── Date Range Filter ──────────────────────────────────────────────── --}}
    <form id="rangeForm" method="GET" action="{{ route('admin.analytics.index') }}"
          class="flex flex-wrap items-end gap-3 mb-6">
        <div class="flex gap-2">
            @foreach (['7' => '7d', '30' => '30d', '90' => '90d'] as $val => $label)
            <button type="submit" name="preset" value="{{ $val }}"
                    class="px-3 py-1.5 text-xs rounded-lg border transition
                           {{ $preset === $val ? 'bg-indigo-600 border-indigo-500 text-white' : 'border-gray-700 text-gray-400 hover:text-white hover:border-gray-500' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
        <div class="flex items-center gap-2">
            <input type="date" name="from" value="{{ $from->toDateString() }}"
                   class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
            <span class="text-gray-500 text-xs">to</span>
            <input type="date" name="to" value="{{ $to->toDateString() }}"
                   class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
            <button type="submit"
                    class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs rounded-lg transition">
                Apply
            </button>
        </div>
        <a href="{{ route('admin.analytics.export', request()->query()) }}"
           class="ml-auto px-3 py-1.5 bg-gray-700 hover:bg-gray-600 text-white text-xs rounded-lg transition flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Export CSV
        </a>
    </form>

    <div class="space-y-6">

        {{-- ── Row 1: Feedback Overview + Trend ─────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Feedback Overview --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-white">Feedback Overview</h2>
                    <a href="{{ route('admin.feedback.analytics', request()->query()) }}"
                       class="text-xs text-indigo-400 hover:text-indigo-300 transition">Details →</a>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-800/50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-white">{{ $feedbackStats['total'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Total Submissions</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-3 text-center">
                        <p class="text-2xl font-bold text-white">
                            {{ $feedbackStats['avg_resolution_hours'] !== null ? $feedbackStats['avg_resolution_hours'] . 'h' : '—' }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">Avg Resolution Time</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-2">By Type</p>
                        <canvas id="chartFbType" height="140"></canvas>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-2">By Status</p>
                        <canvas id="chartFbStatus" height="140"></canvas>
                    </div>
                </div>
            </div>

            {{-- Feedback Trend --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-white mb-4">Feedback Trend</h2>
                <canvas id="chartFbTrend" height="180"></canvas>
            </div>
        </div>

        {{-- ── Row 2: Chatbot Usage + Site Activity ──────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Chatbot Usage --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-white">Chatbot Usage</h2>
                    <a href="{{ route('admin.chatbot.analytics', request()->query()) }}"
                       class="text-xs text-indigo-400 hover:text-indigo-300 transition">Details →</a>
                </div>
                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gray-800/50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-white">{{ $chatbotStats['total_conversations'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Conversations</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-white">{{ $chatbotStats['fallback_rate'] }}%</p>
                        <p class="text-xs text-gray-400 mt-0.5">Fallback Rate</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-lg p-3 text-center">
                        <p class="text-xl font-bold text-white">{{ $chatbotStats['fallback_count'] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Fallbacks</p>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mb-2">Top 5 FAQs Matched</p>
                @forelse ($chatbotStats['top_faqs'] as $faq)
                <div class="flex items-center justify-between py-1.5 border-b border-gray-800 last:border-0">
                    <span class="text-xs text-gray-300 truncate max-w-[75%]">{{ $faq['question'] }}</span>
                    <span class="text-xs font-semibold text-indigo-400">{{ $faq['hits'] }}</span>
                </div>
                @empty
                <p class="text-xs text-gray-600 py-2">No FAQ matches in this period.</p>
                @endforelse
            </div>

            {{-- Site Activity --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <h2 class="text-sm font-semibold text-white mb-4">Site Activity</h2>
                <canvas id="chartActivity" height="200"></canvas>
            </div>
        </div>

        {{-- ── Row 3: Content Engagement ─────────────────────────────────── --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h2 class="text-sm font-semibold text-white mb-4">Content Engagement</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-xs text-gray-500 mb-2">Most Viewed</p>
                    @foreach ($contentStats['most_viewed'] as $c)
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-800 last:border-0">
                        <span class="text-xs text-gray-300 truncate max-w-[75%]">{{ $c->title }}</span>
                        <span class="text-xs text-gray-400">{{ number_format($c->views_count) }}</span>
                    </div>
                    @endforeach
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-2">Most Added to My List</p>
                    @forelse ($contentStats['most_listed'] as $c)
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-800 last:border-0">
                        <span class="text-xs text-gray-300 truncate max-w-[75%]">{{ $c['title'] }}</span>
                        <span class="text-xs text-gray-400">{{ $c['list_count'] }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-600 py-2">No data.</p>
                    @endforelse
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-2">Top Trailer Hovers</p>
                    @forelse ($contentStats['trailer_hovers'] as $c)
                    <div class="flex items-center justify-between py-1.5 border-b border-gray-800 last:border-0">
                        <span class="text-xs text-gray-300 truncate max-w-[75%]">{{ $c['title'] }}</span>
                        <span class="text-xs text-gray-400">{{ $c['hover_count'] }}</span>
                    </div>
                    @empty
                    <p class="text-xs text-gray-600 py-2">No data.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ── Row 4: Event Engagement ────────────────────────────────────── --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-white">Event Engagement</h2>
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    <span>Going: <strong class="text-white">{{ $eventStats['total_going'] }}</strong></span>
                    <span>Interested: <strong class="text-white">{{ $eventStats['total_interested'] }}</strong></span>
                    <span class="text-indigo-400 font-semibold">{{ $eventStats['conversion_rate'] }}% conversion</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-800">
                            <th class="text-left py-2 pr-4 font-medium">Event</th>
                            <th class="text-left py-2 pr-4 font-medium">Date</th>
                            <th class="text-right py-2 pr-4 font-medium">RSVPs</th>
                            <th class="text-right py-2 pr-4 font-medium">Going</th>
                            <th class="text-right py-2 font-medium">Interested</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse ($eventStats['most_rsvpd'] as $e)
                        <tr class="hover:bg-gray-800/30 transition">
                            <td class="py-2 pr-4 text-gray-300 max-w-xs truncate">{{ $e['title'] }}</td>
                            <td class="py-2 pr-4 text-gray-500">{{ $e['date'] ?? '—' }}</td>
                            <td class="py-2 pr-4 text-right text-white font-semibold">{{ $e['rsvp_count'] }}</td>
                            <td class="py-2 pr-4 text-right text-green-400">{{ $e['going_count'] }}</td>
                            <td class="py-2 text-right text-yellow-400">{{ $e['interested_count'] }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="py-6 text-center text-gray-600">No RSVPs in this period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
    (function () {
        const COLORS = {
            indigo: 'rgba(99,102,241,0.8)',
            green:  'rgba(34,197,94,0.8)',
            yellow: 'rgba(234,179,8,0.8)',
            red:    'rgba(239,68,68,0.8)',
            gray:   'rgba(107,114,128,0.8)',
            blue:   'rgba(59,130,246,0.8)',
        };
        const GRID = { color: 'rgba(255,255,255,0.05)' };
        const TICK = { color: '#6b7280', font: { size: 10 } };

        // Feedback by type (doughnut)
        new Chart(document.getElementById('chartFbType'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($feedbackStats['by_type']->keys()) !!},
                datasets: [{ data: {!! json_encode($feedbackStats['by_type']->values()) !!},
                    backgroundColor: [COLORS.indigo, COLORS.green, COLORS.yellow, COLORS.red] }]
            },
            options: { plugins: { legend: { labels: { color: '#9ca3af', font: { size: 10 } } } } }
        });

        // Feedback by status (doughnut)
        new Chart(document.getElementById('chartFbStatus'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($feedbackStats['by_status']->keys()) !!},
                datasets: [{ data: {!! json_encode($feedbackStats['by_status']->values()) !!},
                    backgroundColor: [COLORS.gray, COLORS.blue, COLORS.green, COLORS.red] }]
            },
            options: { plugins: { legend: { labels: { color: '#9ca3af', font: { size: 10 } } } } }
        });

        // Feedback trend (line)
        const trendData = {!! json_encode($feedbackTrend) !!};
        new Chart(document.getElementById('chartFbTrend'), {
            type: 'line',
            data: {
                labels: Object.keys(trendData),
                datasets: [{ label: 'Submissions', data: Object.values(trendData),
                    borderColor: COLORS.indigo, backgroundColor: 'rgba(99,102,241,0.1)',
                    fill: true, tension: 0.3, pointRadius: 2 }]
            },
            options: {
                scales: {
                    x: { ticks: { ...TICK, maxTicksLimit: 8 }, grid: GRID },
                    y: { ticks: TICK, grid: GRID, beginAtZero: true }
                },
                plugins: { legend: { display: false } }
            }
        });

        // Site activity (line — sessions + page views)
        const actData = {!! json_encode($siteActivity) !!};
        new Chart(document.getElementById('chartActivity'), {
            type: 'line',
            data: {
                labels: Object.keys(actData.sessions),
                datasets: [
                    { label: 'Sessions', data: Object.values(actData.sessions),
                      borderColor: COLORS.indigo, backgroundColor: 'rgba(99,102,241,0.1)',
                      fill: true, tension: 0.3, pointRadius: 2 },
                    { label: 'Page Views', data: Object.values(actData.page_views),
                      borderColor: COLORS.green, backgroundColor: 'rgba(34,197,94,0.05)',
                      fill: true, tension: 0.3, pointRadius: 2 }
                ]
            },
            options: {
                scales: {
                    x: { ticks: { ...TICK, maxTicksLimit: 8 }, grid: GRID },
                    y: { ticks: TICK, grid: GRID, beginAtZero: true }
                },
                plugins: { legend: { labels: { color: '#9ca3af', font: { size: 10 } } } }
            }
        });
    })();
    </script>
    @endpush
</x-admin-layout>
