<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Support\EventLocations;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $validator = Validator::make($request->query(), $this->eventFilterRules($request) + [
            'tab' => ['nullable', 'in:map,calendar'],
        ]);
        $filtersAreValid = $validator->passes();
        $filterErrors = $validator->errors()->all();
        $filters = $filtersAreValid ? $validator->validated() : [];
        $country = $filters['country'] ?? config('event_locations.default_country', 'Pakistan');
        if (! array_key_exists($country, config('event_locations.countries', []))) $country = config('event_locations.default_country', 'Pakistan');
        $city = $filters['city'] ?? config('event_locations.default_city', 'Karachi');
        if ($city && ! array_key_exists($city, EventLocations::cities($country))) $city = '';
        $filters['country'] = $country;
        $filters['city'] = $city;
        $category = $filters['category'] ?? '';
        $dateFrom = $filters['date_from'] ?? '';
        $dateTo = $filters['date_to'] ?? '';
        $location = $filters['q'] ?? '';
        $radius = $filters['radius'] ?? 25;
        $latitude = $filters['lat'] ?? null;
        $longitude = $filters['lng'] ?? null;
        $tab = $filters['tab'] ?? 'map';

        $events = $this->annotateDistances($this->filteredEvents($filters)->get(), $filters);

        $mapEvents = $events->filter(fn($e) => $e->hasCoordinates())->values();

        $countries = config('event_locations.countries', []);
        $cities = EventLocations::cities($country);
        $categories = Category::where('status', 'active')->orderBy('name')->get();

        $calendarEvents = $events->map(fn($e) => [
            'id'    => $e->id,
            'title' => $e->title,
            // Event datetime inputs use the site's Karachi wall time. Keep
            // that value un-offset so FullCalendar does not convert it to a
            // visitor's workstation timezone.
            'start' => $e->start_datetime->format('Y-m-d\\TH:i:s'),
            'end'   => $e->end_datetime?->format('Y-m-d\\TH:i:s'),
            'url'   => route('events.show', $e),
            'extendedProps' => ['venue' => $e->venue_name, 'city' => $e->city, 'category' => $e->category?->name],
        ]);

        return view('events.index', compact(
            'events', 'mapEvents', 'calendarEvents',
            'countries', 'cities', 'categories', 'country', 'city', 'category', 'tab', 'dateFrom', 'dateTo', 'location', 'radius', 'latitude', 'longitude', 'filterErrors'
        ));
    }

    public function show(Request $request, Event $event): View
    {
        $event->load(['category', 'content', 'user', 'rsvps']);

        $userRsvp = auth()->check()
            ? $event->rsvps->firstWhere('user_id', auth()->id())
            : null;

        return view('events.show', compact('event', 'userRsvp'));
    }

    public function create(): View
    {
        return view('events.create', [
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
            'countries' => config('event_locations.countries', []),
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data = $this->applyCityCoordinates($data);

        // Auto-geocode via Nominatim if lat/lng not provided but address/city is
        if (!isset($data['latitude'], $data['longitude']) && !empty($data['city'])) {
            $coords = $this->geocode(($data['address'] ?? '') . ' ' . $data['city']);
            if ($coords) {
                $data['latitude']  = $coords['lat'];
                $data['longitude'] = $coords['lng'];
            }
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $request->user()->events()->create($data);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        return view('events.edit', [
            'event'      => $event,
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
            'countries' => config('event_locations.countries', []),
        ]);
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $request->safe()->except('cover_image');
        $data = $this->applyCityCoordinates($data);
        $previousCover = $event->cover_image;
        $newCover = null;

        if (!isset($data['latitude'], $data['longitude']) && !empty($data['city'])) {
            $coords = $this->geocode(($data['address'] ?? '') . ' ' . $data['city']);
            if ($coords) {
                $data['latitude']  = $coords['lat'];
                $data['longitude'] = $coords['lng'];
            }
        }

        if ($request->hasFile('cover_image')) {
            $newCover = $request->file('cover_image')->store('events', 'public');
            $data['cover_image'] = $newCover;
        }

        try {
            $event->update($data);
        } catch (\Throwable $exception) {
            if ($newCover) Storage::disk('public')->delete($newCover);
            throw $exception;
        }

        if ($newCover && $previousCover) Storage::disk('public')->delete($previousCover);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted.');
    }

    /**
     * AJAX: events filtered by city/category for map+calendar re-render.
     */
    public function filter(Request $request): JsonResponse
    {
        $filters = $request->validate($this->eventFilterRules($request));
        $events = $this->annotateDistances($this->filteredEvents($filters)->get(), $filters);

        return response()->json($this->formatEventsForJs($events));
    }

    /**
     * AJAX: events within radius of user's coordinates (Haversine).
     * Accepts: lat, lng, radius (km, default 25), category, date_from, date_to.
     */
    public function nearby(Request $request): JsonResponse
    {
        $filters = $request->validate($this->eventFilterRules($request, true));
        $events = $this->annotateDistances($this->filteredEvents($filters)->get(), $filters);

        return response()->json($this->formatEventsForJs($events, true));
    }

    /**
     * AJAX: toggle RSVP status (going / interested).
     * If same status sent again → removes the RSVP (toggle off).
     */
    public function rsvp(Request $request, Event $event): JsonResponse
    {
        $request->validate(['status' => 'required|in:going,interested']);

        $existing = EventRsvp::where('event_id', $event->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existing && $existing->status === $request->status) {
            // Toggle off — remove RSVP
            $existing->delete();
            $newStatus = null;
        } elseif ($existing) {
            // Switch status
            $existing->update(['status' => $request->status]);
            $newStatus = $request->status;
        } else {
            EventRsvp::create([
                'event_id' => $event->id,
                'user_id'  => auth()->id(),
                'status'   => $request->status,
            ]);
            $newStatus = $request->status;
        }

        $event->load('rsvps');

        return response()->json([
            'status'          => $newStatus,
            'going_count'     => $event->goingCount(),
            'interested_count'=> $event->interestedCount(),
        ]);
    }

    /**
     * Generate and download a .ics calendar file for the event.
     */
    public function ics(Event $event): Response
    {
        $uid     = 'event-' . $event->id . '@fanhubplus';
        $dtStart = $event->start_datetime->utc()->format('Ymd\THis\Z');
        $dtEnd   = ($event->end_datetime ?? $event->start_datetime->addHour())->utc()->format('Ymd\THis\Z');
        $now     = now()->utc()->format('Ymd\THis\Z');
        $summary = addcslashes($event->title, ',;\\');
        $desc    = addcslashes(strip_tags($event->description ?? ''), ',;\\');
        $loc     = addcslashes(($event->venue_name . ', ' . $event->city), ',;\\');

        $ics = implode("\r\n", [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//FanHub+//Events//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            "UID:{$uid}",
            "DTSTAMP:{$now}",
            "DTSTART:{$dtStart}",
            "DTEND:{$dtEnd}",
            "SUMMARY:{$summary}",
            "DESCRIPTION:{$desc}",
            "LOCATION:{$loc}",
            'END:VEVENT',
            'END:VCALENDAR',
        ]);

        return response($ics, 200, [
            'Content-Type'        => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . \Illuminate\Support\Str::slug($event->title) . '.ics"',
        ]);
    }

    // ── Private helpers ───────────────────────────────────────────────────────

    /**
     * Geocode an address string using Nominatim (OpenStreetMap) — free, no API key.
     * Returns ['lat' => float, 'lng' => float] or null on failure.
     */
    private function geocode(string $address): ?array
    {
        try {
            $response = Http::withHeaders(['User-Agent' => 'FanHubPlus/1.0'])
                ->timeout(5)
                ->get('https://nominatim.openstreetmap.org/search', [
                    'q'      => $address,
                    'format' => 'json',
                    'limit'  => 1,
                ]);

            $results = $response->json();

            if (!empty($results[0])) {
                return [
                    'lat' => (float) $results[0]['lat'],
                    'lng' => (float) $results[0]['lon'],
                ];
            }
        } catch (\Throwable) {
            // Geocoding is best-effort; silently fail
        }

        return null;
    }

    /** Shared formatter: converts Event collection to JS-ready arrays. */
    private function formatEventsForJs($events, bool $includeDistance = false): array
    {
        $mapEvents = $events->filter(fn($e) => $e->hasCoordinates())->values()->map(function ($e) use ($includeDistance) {
            $data = [
                'id'     => $e->id,
                'title'  => $e->title,
                'lat'    => $e->latitude,
                'lng'    => $e->longitude,
                'venue'  => $e->venue_name,
                'city'   => $e->city,
                'country' => $e->country,
                'date'   => $e->start_datetime->format('d M Y, h:i A'),
                'url'    => route('events.show', $e),
                'status' => $e->status(),
                'category' => $e->category?->name,
                'ticket_link' => $e->ticket_link && in_array(strtolower((string) parse_url($e->ticket_link, PHP_URL_SCHEME)), ['http', 'https'], true) ? $e->ticket_link : null,
                'description' => $e->description,
            ];
            if ($includeDistance && isset($e->distance_km)) {
                $data['distance_km'] = round($e->distance_km, 1);
            }
            return $data;
        });

        $calendarEvents = $events->map(fn($e) => [
            'id'    => $e->id,
            'title' => $e->title,
            'start' => $e->start_datetime->format('Y-m-d\\TH:i:s'),
            'end'   => $e->end_datetime?->format('Y-m-d\\TH:i:s'),
            'url'   => route('events.show', $e),
            'extendedProps' => ['venue' => $e->venue_name, 'city' => $e->city, 'category' => $e->category?->name],
        ]);

        $cardEvents = $events->map(fn($e) => [
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
            'distance_km' => isset($e->distance_km) ? round($e->distance_km, 1) : null,
        ]);

        return [
            'mapEvents'      => $mapEvents,
            'calendarEvents' => $calendarEvents,
            'cardEvents'     => $cardEvents,
            'total'          => $events->count(),
        ];
    }

    /** Filter endpoint rules shared by the page and AJAX requests. */
    private function eventFilterRules(Request $request, bool $requireCoordinates = false): array
    {
        $dateToRule = function (string $attribute, mixed $value, \Closure $fail) use ($request): void {
            $from = $request->input('date_from');
            if ($value && $from && strtotime((string) $value) < strtotime((string) $from)) {
                $fail('The end date must be on or after the start date.');
            }
        };

        return [
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', \Illuminate\Validation\Rule::in(EventLocations::countryNames())],
            'category' => ['nullable', 'integer', 'exists:categories,id'],
            'q' => ['nullable', 'string', 'max:150'],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', $dateToRule],
            'lat' => [$requireCoordinates ? 'required' : 'nullable', 'numeric', 'between:-90,90', 'required_with:lng'],
            'lng' => [$requireCoordinates ? 'required' : 'nullable', 'numeric', 'between:-180,180', 'required_with:lat'],
            'radius' => ['nullable', 'integer', 'between:5,100'],
        ];
    }

    /** Build the common upcoming event query with every active filter applied. */
    private function filteredEvents(array $filters): \Illuminate\Database\Eloquent\Builder
    {
        $query = Event::with('category')
            ->upcoming()
            ->filterCity($filters['city'] ?? null)
            ->filterCountry($filters['country'] ?? null)
            ->filterCategory($filters['category'] ?? null)
            ->filterLocation($filters['q'] ?? null)
            ->inDateRange($filters['date_from'] ?? null, $filters['date_to'] ?? null);

        if (isset($filters['lat'], $filters['lng'])) {
            return $query->nearby((float) $filters['lat'], (float) $filters['lng'], (float) ($filters['radius'] ?? 25));
        }

        return $query->orderBy('start_datetime');
    }

    private function annotateDistances(\Illuminate\Support\Collection $events, array $filters): \Illuminate\Support\Collection
    {
        if (! isset($filters['lat'], $filters['lng'])) return $events;

        $latitude = (float) $filters['lat'];
        $longitude = (float) $filters['lng'];
        return $events->each(function (Event $event) use ($latitude, $longitude): void {
            if ($event->hasCoordinates()) {
                $event->setAttribute('distance_km', round($event->distanceFrom($latitude, $longitude), 1));
            }
        })->sortBy('distance_km')->values();
    }

    private function applyCityCoordinates(array $data): array
    {
        $custom = (bool) ($data['custom_location'] ?? false);
        unset($data['custom_location']);
        $coordinates = $custom ? null : EventLocations::coordinates($data['country'] ?? null, $data['city'] ?? null);
        if ($coordinates) {
            [$data['latitude'], $data['longitude']] = $coordinates;
        }

        return $data;
    }
}
