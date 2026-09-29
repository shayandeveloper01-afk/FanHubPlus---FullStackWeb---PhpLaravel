<x-app-layout>
    @push('head')
        <title>Events — {{ config('app.name') }}</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/main.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/main.min.css" />
        <style>
            #event-calendar {
                --fc-border-color:#374151; --fc-button-bg-color:#374151;
                --fc-button-border-color:#4b5563; --fc-button-hover-bg-color:#4b5563;
                --fc-button-active-bg-color:#6366f1; --fc-button-active-border-color:#6366f1;
                --fc-today-bg-color:rgba(99,102,241,0.15); --fc-page-bg-color:#1f2937;
                --fc-neutral-bg-color:#111827;
            }
            #event-calendar .fc-toolbar-title { color:#f9fafb; font-size:1rem; }
            #event-calendar .fc-col-header-cell-cushion,
            #event-calendar .fc-daygrid-day-number { color:#d1d5db; text-decoration:none; }
            #event-calendar .fc-daygrid-day.fc-day-today .fc-daygrid-day-number { color:#818cf8; font-weight:700; }
            #event-calendar .fc-list-event-title a { color:#e5e7eb; }
            #event-calendar .fc-list-day-cushion { background:#111827; color:#9ca3af; }
        </style>
    @endpush

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
         x-data="eventDiscovery()"
         x-init="init()">

        {{-- Breadcrumb --}}
        <x-breadcrumb :crumbs="[['label' => 'Events']]" class="mb-4" />

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">Event Discovery</h1>
                <p class="text-gray-400 text-sm mt-1">
                    <span x-text="total"></span> upcoming event<span x-show="total !== 1">s</span>
                </p>
            </div>
            @auth
                <a href="{{ route('events.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Event
                </a>
            @endauth
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="mb-5 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if (!empty($filterErrors))
            <div class="mb-5 rounded-lg border border-rose-500/30 bg-rose-950/30 px-4 py-3 text-sm text-rose-200" role="alert">
                <p class="font-semibold">Some event filters could not be applied.</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($filterErrors as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        {{-- ── Filter bar ──────────────────────────────────────────────────── --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 mb-6 flex flex-wrap gap-3 items-end">

            {{-- Country --}}
            <div class="flex flex-col gap-1 min-w-[160px]">
                <label class="text-xs text-gray-400 font-medium">Country</label>
                <select id="country-filter" x-model="countryFilter" @change="changeCountry()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2">
                    <option value="">All Countries</option>
                    @foreach ($countries as $countryName => $countryData)
                        <option value="{{ $countryName }}">{{ $countryName }}</option>
                    @endforeach
                </select>
            </div>

            {{-- City --}}
            <div class="flex flex-col gap-1 min-w-[130px]">
                <label class="text-xs text-gray-400 font-medium">City</label>
                <select id="city-filter" x-model="cityFilter" @change="changeCity()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2">
                    <option value="">All Cities</option>
                    <template x-for="city in availableCities" :key="city">
                        <option :value="city" x-text="city"></option>
                    </template>
                </select>
            </div>

            {{-- Category --}}
            <div class="flex flex-col gap-1 min-w-[140px]">
                <label class="text-xs text-gray-400 font-medium">Category</label>
                <select id="category-filter" x-model="categoryFilter" @change="applyFilters()"
                        class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($category == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Radius (only relevant when using location) --}}
            <div class="flex flex-col gap-1 min-w-[110px]">
                <label class="text-xs text-gray-400 font-medium">Radius</label>
                <input id="radius-filter" type="range" min="5" max="100" step="5" x-model="radius" @change="applyFilters()"
                       :disabled="latitude === null || longitude === null"
                       aria-label="Search radius in kilometers"
                       class="accent-indigo-500">
                <output id="radius-value" for="radius-filter" class="text-xs text-gray-400" x-text="(latitude === null ? 'Use My Location · ' : '') + radius + ' km'"></output>
            </div>

            {{-- Date range --}}
            <div class="flex flex-col gap-1">
                <label class="text-xs text-gray-400 font-medium">From</label>
                <input id="date-from" type="date" x-model="dateFrom" @change="applyFilters()"
                       class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2">
            </div>
            <div class="flex flex-col gap-1">
                <label class="text-xs text-gray-400 font-medium">To</label>
                <input id="date-to" type="date" x-model="dateTo" @change="applyFilters()"
                       class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2">
            </div>

            {{-- Location text search across saved city, venue and address fields --}}
            <form id="location-search-form" @submit.prevent="applyFilters()" class="flex gap-2 items-end flex-1 min-w-[200px]">
                <div class="flex flex-col gap-1 flex-1">
                    <label class="text-xs text-gray-400 font-medium">Search Location</label>
                    <input id="location-search" type="search" x-model="locationQuery" placeholder="City, venue or address…"
                           class="bg-gray-800 border border-gray-700 text-gray-200 text-sm rounded-lg px-3 py-2 w-full">
                </div>
                <button type="submit" :disabled="searching"
                        class="px-3 py-2 bg-gray-700 hover:bg-gray-600 disabled:opacity-60 text-white text-sm rounded-lg transition whitespace-nowrap">
                    <span x-text="searching ? 'Searching…' : 'Search'"></span>
                </button>
            </form>

            {{-- Use My Location --}}
            <button id="use-my-location" type="button" @click="useMyLocation()" :disabled="locating"
                    class="flex items-center gap-1.5 px-3 py-2 bg-indigo-600/20 hover:bg-indigo-600/40 border border-indigo-500/40 text-indigo-300 text-sm rounded-lg transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span x-text="locating ? 'Locating…' : 'My Location'"></span>
            </button>

            {{-- Map / Calendar toggle --}}
            <div class="ml-auto flex rounded-lg overflow-hidden border border-gray-700">
                <button @click="switchTab('map')"
                        :class="tab === 'map' ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white'"
                        class="px-4 py-2 text-sm font-medium transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Map
                </button>
                <button @click="switchTab('calendar')"
                        :class="tab === 'calendar' ? 'bg-indigo-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white'"
                        class="px-4 py-2 text-sm font-medium transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Calendar
                </button>
            </div>
        </div>
        <p x-show="filterMessage" x-text="filterMessage" role="status" class="mb-4 text-sm text-rose-300" x-cloak></p>

        {{-- ── Map view ─────────────────────────────────────────────────────── --}}
        <div x-show="tab === 'map'" x-cloak>
            <section class="mt-6 bg-gray-900 border border-gray-800 rounded-xl overflow-hidden" aria-labelledby="events-default-location-title">
                <div class="flex flex-wrap items-center justify-between gap-3 p-5">
                    <div>
                        <h3 id="events-default-location-title" class="font-semibold text-white">Default Location</h3>
                <p class="text-sm text-gray-400 mt-1">{{ config('events.default_location.name') }}</p>
                    </div>
                    <a href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode(config('events.default_location.name').', '.config('events.default_location.city')) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="text-sm text-indigo-400 hover:text-indigo-300 transition">Open in Google Maps</a>
                </div>
                <div id="events-map" class="block w-full bg-gray-800" style="height:clamp(350px,62vh,560px);min-height:350px" role="application" aria-label="Map of upcoming events"></div>
                <p class="px-5 py-3 text-xs text-gray-500">Map markers show upcoming events with saved coordinates. Events without coordinates remain available in the event list and calendar.</p>
                <p x-show="mapEventCount === 0" class="px-5 pb-4 text-sm text-gray-400" role="status">No upcoming events with map locations yet.</p>
            </section>
        </div>

        {{-- ── Calendar view ────────────────────────────────────────────────── --}}
        <div x-show="tab === 'calendar'" x-cloak>
            <div id="event-calendar" class="rounded-xl border border-gray-700 overflow-hidden bg-gray-800 p-4"></div>

            {{-- Day-click panel: shows events for the selected day --}}
            <div id="day-events-panel" class="hidden mt-4 bg-gray-900 border border-gray-800 rounded-xl p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-white" id="day-events-title"></h3>
                    <button onclick="document.getElementById('day-events-panel').classList.add('hidden')"
                            class="text-gray-500 hover:text-white transition text-xs">✕ Close</button>
                </div>
                <div id="day-events-list" class="space-y-2"></div>
            </div>
        </div>

        {{-- ── Card list ────────────────────────────────────────────────────── --}}
        <div class="mt-10">
            <h2 class="text-lg font-semibold text-white mb-4">All Upcoming Events</h2>

            <div x-show="cardEvents.length === 0" class="text-center py-16 text-gray-500">
                <svg class="w-10 h-10 mx-auto mb-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p>No upcoming events found.</p>
            </div>

            <div x-show="cardEvents.length > 0"
                 class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="event in cardEvents" :key="event.url">
                    <a :href="event.url"
                       :data-event-url="event.url"
                       class="group relative flex flex-col rounded-xl overflow-hidden bg-gray-800 border border-gray-700
                              shadow-lg transition-all duration-200 hover:scale-[1.02] hover:shadow-2xl hover:border-indigo-500/50">
                        <div class="aspect-video w-full overflow-hidden bg-gray-700">
                            <img :src="event.image" :alt="event.title"
                                 x-on:error.once="$el.src=event.fallback_image"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]"
                                 loading="lazy">
                        </div>
                        <div class="absolute top-2 left-2">
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full border capitalize"
                                  :class="event.statusClass" x-text="event.status"></span>
                        </div>
                        <div class="p-3 flex flex-col gap-1 flex-1">
                            <p class="text-white text-sm font-semibold leading-tight line-clamp-2" x-text="event.title"></p>
                            <p class="text-indigo-300 text-xs" x-text="event.venue + ', ' + event.city"></p>
                            <p x-show="event.category" class="text-gray-400 text-xs" x-text="event.category"></p>
                            <p class="text-gray-400 text-xs mt-auto pt-1" x-text="event.date"></p>
                            <p x-show="event.distance_km != null"
                               class="text-emerald-400 text-xs" x-text="event.distance_km + ' km away'"></p>
                        </div>
                    </a>
                </template>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Leaflet --}}
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        {{-- FullCalendar --}}
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.15/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.15/index.global.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.15/index.global.min.js"></script>

        {{-- Seed data for external JS files --}}
        @php
            $mapEventsJson = $mapEvents->map(fn($e) => [
                'id'    => $e->id,
                'title' => $e->title,
                'lat'   => $e->latitude,
                'lng'   => $e->longitude,
                'venue' => $e->venue_name,
                'city'  => $e->city,
                'country' => $e->country,
                'date'  => $e->start_datetime->format('d M Y, h:i A'),
                'url'   => route('events.show', $e),
                'status'=> $e->status(),
                'category' => $e->category?->name,
            ])->values()->all();
            $cardEventsJson = $events->map(fn($e) => [
                'title'       => $e->title,
                'category'    => $e->category?->name,
                'venue'       => $e->venue_name,
                'city'        => $e->city,
                'country'     => $e->country,
                'date'        => $e->start_datetime->format('d M Y, h:i A'),
                'url'         => route('events.show', $e),
                'status'      => $e->status(),
                'statusClass' => $e->statusBadgeClass(),
                'image'       => $e->coverImageUrl(),
                'fallback_image' => \App\Support\ImageArtwork::fallbackSource($e->title, $e->category?->name ?? 'Events', 'event', $e->id),
                'distance_km' => isset($e->distance_km) ? round($e->distance_km, 1) : null,
            ])->values()->all();
        @endphp
        <script>
            window.FanHubEvents = {
                mapEvents:      {{ Illuminate\Support\Js::from($mapEventsJson) }},
                calendarEvents: {{ Illuminate\Support\Js::from($calendarEvents->values()->all()) }},
                locations: @json($countries),
                filterUrl:  '{{ route('events.filter') }}',
                nearbyUrl:  '{{ route('events.nearby') }}',
                csrfToken:  '{{ csrf_token() }}',
                defaultLocation: @json(config('events.default_location')),
            };
        </script>

        {{-- External map + calendar logic --}}
        <script src="{{ asset('js/events-map.js') }}"></script>
        <script src="{{ asset('js/events-calendar.js') }}"></script>

        <script>
        function eventDiscovery() {
            return {
                tab:            @json($tab),
                countryFilter:  @json($country),
                cityFilter:     @json($city ?? ''),
                categoryFilter: @json($category ?? ''),
                radius:         @json((string) ($radius ?? 25)),
                dateFrom:       @json($dateFrom ?? ''),
                dateTo:         @json($dateTo ?? ''),
                locationQuery:  @json($location ?? ''),
                latitude:       @json($latitude),
                longitude:      @json($longitude),
                searching:      false,
                locating:       false,
                filterMessage:  '',
                filterController: null,
                cardEvents:     {{ Illuminate\Support\Js::from($cardEventsJson) }},
                total:          {{ $events->count() }},
                mapEventCount:  {{ $mapEvents->count() }},

                init() {
                    // Restore tab from localStorage
                    const saved = localStorage.getItem('events_tab');
                    if (saved) this.tab = saved;
                    if (this.latitude !== null && this.longitude !== null) {
                        window.FanHubMap?.setUserLocation(this.latitude, this.longitude);
                    }
                    this.$nextTick(() => {
                        if (this.tab === 'map') window.FanHubMap?.renderMarkers(Array.isArray(window.FanHubEvents?.mapEvents) ? window.FanHubEvents.mapEvents : []);
                        else window.FanHubCalendar?.initCalendar(Array.isArray(window.FanHubEvents?.calendarEvents) ? window.FanHubEvents.calendarEvents : []);
                    });
                },

                get availableCities() {
                    return Object.keys(this.locations?.[this.countryFilter]?.cities || {});
                },

                changeCountry() {
                    const cities = this.availableCities;
                    this.cityFilter = this.countryFilter ? (cities[0] || '') : '';
                    this.centerSelectedCity();
                    this.applyFilters();
                },

                changeCity() {
                    this.centerSelectedCity();
                    this.applyFilters();
                },

                centerSelectedCity() {
                    const coords = this.locations?.[this.countryFilter]?.cities?.[this.cityFilter];
                    if (Array.isArray(coords)) window.FanHubMap?.flyToCity(coords[0], coords[1]);
                },

                switchTab(t) {
                    this.tab = t;
                    localStorage.setItem('events_tab', t);
                    this.$nextTick(() => {
                        if (t === 'map') window.FanHubMap?.renderMarkers(Array.isArray(window.FanHubEvents?.mapEvents) ? window.FanHubEvents.mapEvents : []);
                        else window.FanHubCalendar?.initCalendar(Array.isArray(window.FanHubEvents?.calendarEvents) ? window.FanHubEvents.calendarEvents : []);
                    });
                },

                applyFilters() {
                    this.filterController?.abort();
                    if (this.dateFrom && this.dateTo && this.dateTo < this.dateFrom) {
                        this.filterMessage = 'The end date must be on or after the start date.';
                        return;
                    }
                    this.filterMessage = '';
                    this.searching = true;
                    const controller = new AbortController();
                    this.filterController = controller;
                    const params = new URLSearchParams({
                        city:      this.cityFilter,
                        country:   this.countryFilter,
                        category:  this.categoryFilter,
                        date_from: this.dateFrom,
                        date_to:   this.dateTo,
                        q:         this.locationQuery,
                        radius:    this.radius,
                        lat:       this.latitude ?? '',
                        lng:       this.longitude ?? '',
                    });

                    fetch(`${window.FanHubEvents.filterUrl}?${params}`, { headers: { 'Accept': 'application/json' }, signal: controller.signal })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) throw new Error(data.message || 'Unable to load events. Please try again.');
                            return data;
                        })
                        .then(data => {
                            if (!Array.isArray(data.mapEvents) || !Array.isArray(data.cardEvents) || !Array.isArray(data.calendarEvents)) {
                                throw new Error('Event results were returned in an invalid format. Please refresh and try again.');
                            }
                            this.cardEvents     = data.cardEvents;
                            this.total          = data.total;
                            this.mapEventCount  = data.mapEvents.length;
                            window.FanHubMap?.renderMarkers(data.mapEvents);
                            window.FanHubCalendar?.updateCalendar(data.calendarEvents);
                            window.FanHubEvents.mapEvents = data.mapEvents;
                            window.FanHubEvents.calendarEvents = data.calendarEvents;
                        })
                        .catch(error => { if (error.name !== 'AbortError') this.filterMessage = error.message; })
                        .finally(() => { if (this.filterController === controller) this.searching = false; });
                },

                useMyLocation() {
                    if (!navigator.geolocation) {
                        this.filterMessage = 'Your browser does not support location services.';
                        return;
                    }
                    this.locating = true;
                    this.filterMessage = '';
                    navigator.geolocation.getCurrentPosition(position => {
                        this.countryFilter = '';
                        this.cityFilter = '';
                        this.latitude = position.coords.latitude;
                        this.longitude = position.coords.longitude;
                        window.FanHubMap?.setUserLocation(this.latitude, this.longitude);
                        this.locating = false;
                        this.applyFilters();
                    }, error => {
                        this.locating = false;
                        this.filterMessage = error.code === error.PERMISSION_DENIED
                            ? 'Location access was denied. You can still search by city, venue or address.'
                            : 'Your location could not be determined. Please try again.';
                    }, { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 });
                },
            };
        }
        </script>
    @endpush
</x-app-layout>
