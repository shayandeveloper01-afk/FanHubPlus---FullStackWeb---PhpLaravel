<x-admin-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-white">Dashboard</h1>
    </x-slot>

    @push('head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    @endpush

    {{-- Date range filter --}}
    <form method="GET" class="flex flex-wrap items-end gap-3 mb-6">
        <div>
            <label class="block text-xs text-gray-400 mb-1">From</label>
            <input type="date" name="from" value="{{ $from->format('Y-m-d') }}"
                   class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label class="block text-xs text-gray-400 mb-1">To</label>
            <input type="date" name="to" value="{{ $to->format('Y-m-d') }}"
                   class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">
            Apply
        </button>
    </form>

    {{-- Summary cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        @foreach ([
            ['label' => 'Users',       'value' => $summary['users'],       'color' => 'text-indigo-400', 'href' => route('admin.users.index')],
            ['label' => 'Content',     'value' => $summary['contents'],    'color' => 'text-blue-400',   'href' => route('admin.contents.index')],
            ['label' => 'Articles',    'value' => $summary['articles'],    'color' => 'text-purple-400', 'href' => route('admin.articles.index')],
            ['label' => 'Merch',       'value' => $summary['merchandise'], 'color' => 'text-yellow-400', 'href' => route('admin.merchandise.index')],
            ['label' => 'Events',      'value' => $summary['events'],      'color' => 'text-green-400',  'href' => route('admin.events.index')],
            ['label' => 'New Reports', 'value' => $summary['feedback'],    'color' => 'text-red-400',    'href' => route('admin.feedback.index')],
        ] as $card)
        <a href="{{ $card['href'] }}" class="bg-gray-900 border border-gray-800 hover:border-gray-700 rounded-xl p-4 text-center transition">
            <p class="text-2xl font-bold {{ $card['color'] }}">{{ $card['value'] }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $card['label'] }}</p>
        </a>
        @endforeach
    </div>

    {{-- Charts grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-white mb-4">User Growth</h3>
            <canvas id="chartUserGrowth" height="200"></canvas>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-white mb-4">Content by Category</h3>
            <canvas id="chartContentCategory" height="200"></canvas>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-white mb-4">Most Viewed Content (Top 10)</h3>
            <canvas id="chartMostViewed" height="200"></canvas>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
            <h3 class="text-sm font-semibold text-white mb-4">Ratings Distribution</h3>
            <canvas id="chartRatings" height="200"></canvas>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 lg:col-span-2">
            <h3 class="text-sm font-semibold text-white mb-4">Engagement Over Time</h3>
            <canvas id="chartEngagement" height="80"></canvas>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const gridColor = 'rgba(55,65,81,0.6)';
            Chart.defaults.color = '#9ca3af';
            Chart.defaults.borderColor = '#374151';

            new Chart(document.getElementById('chartUserGrowth'), {
                type: 'line',
                data: {
                    labels: @json($userGrowth->keys()),
                    datasets: [{ label: 'New Users', data: @json($userGrowth->values()), borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.15)', fill: true, tension: 0.4, pointRadius: 3 }]
                },
                options: { plugins: { legend: { display: false } }, scales: { x: { grid: { color: gridColor } }, y: { grid: { color: gridColor }, beginAtZero: true, ticks: { precision: 0 } } } }
            });

            new Chart(document.getElementById('chartContentCategory'), {
                type: 'doughnut',
                data: {
                    labels: @json($contentByCategory->pluck('label')),
                    datasets: [{ data: @json($contentByCategory->pluck('value')), backgroundColor: ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#3b82f6','#ef4444','#14b8a6'], borderWidth: 0 }]
                },
                options: { plugins: { legend: { position: 'right' } }, cutout: '65%' }
            });

            new Chart(document.getElementById('chartMostViewed'), {
                type: 'bar',
                data: {
                    labels: @json($mostViewed->pluck('label')),
                    datasets: [{ label: 'Views', data: @json($mostViewed->pluck('value')), backgroundColor: 'rgba(99,102,241,0.7)', borderRadius: 4 }]
                },
                options: { indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { grid: { color: gridColor }, beginAtZero: true }, y: { grid: { color: gridColor } } } }
            });

            const ratingsRaw = @json($ratingsDistribution);
            new Chart(document.getElementById('chartRatings'), {
                type: 'bar',
                data: {
                    labels: ['1 ★','2 ★','3 ★','4 ★','5 ★'],
                    datasets: [{ label: 'Ratings', data: [1,2,3,4,5].map(r => ratingsRaw[r] || 0), backgroundColor: ['#ef4444','#f97316','#f59e0b','#84cc16','#10b981'], borderRadius: 4 }]
                },
                options: { plugins: { legend: { display: false } }, scales: { x: { grid: { color: gridColor } }, y: { grid: { color: gridColor }, beginAtZero: true, ticks: { precision: 0 } } } }
            });

            new Chart(document.getElementById('chartEngagement'), {
                type: 'line',
                data: {
                    labels: @json($engagement->keys()),
                    datasets: [{ label: 'Total Views', data: @json($engagement->values()), borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,0.1)', fill: true, tension: 0.4, pointRadius: 3 }]
                },
                options: { plugins: { legend: { display: false } }, scales: { x: { grid: { color: gridColor } }, y: { grid: { color: gridColor }, beginAtZero: true } } }
            });
        });
    </script>
    @endpush
</x-admin-layout>
