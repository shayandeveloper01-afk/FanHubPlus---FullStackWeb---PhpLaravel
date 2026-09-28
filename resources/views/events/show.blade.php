<x-app-layout>
    @push('head')
        <title>{{ $event->title }} — {{ config('app.name') }}</title>
        @if ($event->hasCoordinates())
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <style>#detail-map { height: 280px; }</style>
        @endif
    @endpush

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb --}}
        <x-breadcrumb :crumbs="[
            ['label' => 'Events', 'url' => route('events.index')],
            ['label' => $event->title],
        ]" class="mb-6" />

        @if (session('success'))
            <div class="mb-5 rounded-lg border border-emerald-500/30 bg-emerald-950/25 px-4 py-3 text-sm text-emerald-200" role="status">{{ session('success') }}</div>
        @endif

        {{-- Cover image --}}
        <div class="aspect-video w-full rounded-xl overflow-hidden bg-gray-800 border border-gray-700 mb-8">
            <img src="{{ $event->coverImageUrl() }}" alt="{{ $event->title }}"
                 class="w-full h-full object-cover">
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ── Main column ──────────────────────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Status + category badges --}}
                <div class="flex flex-wrap items-center gap-3">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $event->statusBadgeClass() }} capitalize">
                        {{ $event->status() }}
                    </span>
                    @if ($event->category)
                        <span class="text-xs text-indigo-300 font-medium">{{ $event->category->name }}</span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-white leading-tight">{{ $event->title }}</h1>

                @if ($event->description)
                    <p class="text-gray-300 leading-relaxed">{{ $event->description }}</p>
                @endif

                {{-- Organizer --}}
                <div class="text-sm text-gray-400">
                    Organised by <span class="text-white font-medium">{{ $event->user->name }}</span>
                </div>

                {{-- Mini map --}}
                @if ($event->hasCoordinates())
                    <div id="detail-map" class="rounded-xl border border-gray-700 overflow-hidden"></div>
                @endif

                {{-- RSVP buttons (auth required) --}}
                @auth
                <div x-data="rsvpWidget(
                        '{{ $userRsvp?->status }}',
                        {{ $event->goingCount() }},
                        {{ $event->interestedCount() }},
                        {{ $event->id }}
                     )"
                     class="flex flex-wrap gap-3 items-center">

                    <button @click="toggle('going')"
                            :class="status === 'going'
                                ? 'bg-green-600 hover:bg-green-500 text-white'
                                : 'bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300'"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Going
                        <span class="ml-1 text-xs opacity-70" x-text="'(' + goingCount + ')'"></span>
                    </button>

                    <button @click="toggle('interested')"
                            :class="status === 'interested'
                                ? 'bg-yellow-600 hover:bg-yellow-500 text-white'
                                : 'bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300'"
                            class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Interested
                        <span class="ml-1 text-xs opacity-70" x-text="'(' + interestedCount + ')'"></span>
                    </button>

                    <span x-show="msg" x-text="msg" class="text-xs text-gray-400" x-cloak></span>
                </div>
                @else
                <div class="flex items-center gap-3 text-sm text-gray-400">
                    <span>{{ $event->goingCount() }} going · {{ $event->interestedCount() }} interested</span>
                    <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 transition">Sign in to RSVP</a>
                </div>
                @endauth

            </div>

            {{-- ── Sidebar ───────────────────────────────────────────────────── --}}
            <div class="space-y-4">
                <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 space-y-5">

                    {{-- Date & Time --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Date & Time</p>
                        <p class="text-white font-medium">{{ $event->start_datetime->format('D, d M Y') }}</p>
                        <p class="text-gray-300 text-sm">
                            {{ $event->start_datetime->format('h:i A') }}
                            @if ($event->end_datetime)
                                – {{ $event->end_datetime->format('h:i A') }}
                            @endif
                        </p>
                    </div>

                    {{-- Venue --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Venue</p>
                        <p class="text-white font-medium">{{ $event->venue_name }}</p>
                        @if ($event->address)
                            <p class="text-gray-400 text-sm">{{ $event->address }}</p>
                        @endif
                        <p class="text-indigo-300 text-sm">{{ $event->city }}</p>
                        @php
                            $eventMapsQuery = $event->hasCoordinates()
                                ? $event->latitude . ',' . $event->longitude
                                : implode(', ', array_filter([$event->venue_name, $event->address, $event->city]));
                        @endphp
                        @if ($eventMapsQuery !== '')
                            <a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($eventMapsQuery) }}" target="_blank" rel="noopener noreferrer" class="mt-2 inline-flex text-sm text-indigo-300 hover:text-purple-200 transition">Open in Google Maps</a>
                        @endif
                    </div>

                    {{-- Ticket link --}}
                    @if ($event->ticket_link && in_array(strtolower((string) parse_url($event->ticket_link, PHP_URL_SCHEME)), ['http', 'https'], true))
                        <a href="{{ $event->ticket_link }}" target="_blank" rel="noopener noreferrer"
                           class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            Get Tickets
                        </a>
                    @endif

                    {{-- Add to Calendar (.ics) --}}
                    <a href="{{ route('events.ics', $event) }}"
                       class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Add to My Calendar
                    </a>

                    {{-- Share --}}
                    <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { this.textContent = '✓ Copied!'; setTimeout(() => this.textContent = 'Copy Link', 2000); })"
                            class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Copy Link
                    </button>
                </div>

                {{-- Owner actions --}}
                @can('update', $event)
                    <div class="flex gap-3">
                        <a href="{{ route('events.edit', $event) }}"
                           class="flex-1 text-center px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('events.destroy', $event) }}"
                              onsubmit="return confirm('Delete this event?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button class="w-full px-4 py-2 text-sm bg-red-600/20 hover:bg-red-600/40 text-red-400 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    @if ($event->hasCoordinates())
        @push('scripts')
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
            <script>
                const detailMap = L.map('detail-map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 14);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                    attribution: '© OpenStreetMap © CARTO', maxZoom: 19
                }).addTo(detailMap);
                L.circleMarker([{{ $event->latitude }}, {{ $event->longitude }}], {
                    radius: 10, fillColor: '#6366f1', color: '#818cf8', weight: 2, fillOpacity: 0.9
                }).addTo(detailMap)
                  .bindPopup(document.createTextNode(@json($event->venue_name . ', ' . $event->city)))
                  .openPopup();
            </script>
        @endpush
    @endif

    @push('scripts')
    <script>
    function rsvpWidget(initialStatus, initialGoing, initialInterested, eventId) {
        return {
            status:          initialStatus || null,
            goingCount:      initialGoing,
            interestedCount: initialInterested,
            msg:             '',

            async toggle(newStatus) {
                try {
                    const res = await fetch(`/events/${eventId}/rsvp`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept':       'application/json',
                        },
                        body: JSON.stringify({ status: newStatus }),
                    });
                    const data = await res.json();
                    this.status          = data.status;
                    this.goingCount      = data.going_count;
                    this.interestedCount = data.interested_count;
                    this.msg = data.status
                        ? (data.status === 'going' ? "✓ You're going!" : '★ Marked as interested')
                        : 'RSVP removed';
                    setTimeout(() => this.msg = '', 2500);
                } catch {
                    this.msg = 'Something went wrong.';
                }
            },
        };
    }
    </script>
    @endpush
</x-app-layout>
