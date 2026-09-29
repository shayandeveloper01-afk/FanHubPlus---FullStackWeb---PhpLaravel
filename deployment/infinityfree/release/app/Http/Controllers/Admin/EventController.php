<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\Category;
use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Support\EventLocations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EventController extends Controller
{
    use LogsAdminActivity;
    public function index(Request $request): View
    {
        $events = Event::withTrashed()->with(['user', 'category'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->when($request->status, fn($q, $v) => $v === 'trashed' ? $q->onlyTrashed() : $q)
            ->latest()->paginate(20)->withQueryString();

        return view('admin.events.index', compact('events'));
    }

    public function edit(Event $event): View
    {
        $categories = Category::orderBy('name')->get();
        $countries = config('event_locations.countries', []);
        return view('admin.events.edit', compact('event', 'categories', 'countries'));
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'event' => null,
            'categories' => Category::orderBy('name')->get(),
            'countries' => config('event_locations.countries', []),
        ]);
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        $data = $this->prepareLocation($request->safe()->except('cover_image'));
        if ($request->hasFile('cover_image')) $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        $event = Event::create($data + ['user_id' => $request->user()->id]);
        $this->auditLog('event.create', 'Event', $event->id, "Created: {$event->title}");

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $data = $this->prepareLocation($request->safe()->except('cover_image'));
        $oldCover = $event->cover_image;
        $newCover = null;
        if ($request->hasFile('cover_image')) {
            $newCover = $request->file('cover_image')->store('events', 'public');
            $data['cover_image'] = $newCover;
        }
        try { $event->update($data); }
        catch (\Throwable $exception) { if ($newCover) Storage::disk('public')->delete($newCover); throw $exception; }
        if ($newCover && $oldCover) Storage::disk('public')->delete($oldCover);

        $this->auditLog('event.update', 'Event', $event->id, "Updated: {$event->title}");
        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $this->auditLog('event.delete', 'Event', $event->id, "Deleted: {$event->title}");
        $event->delete();
        return back()->with('success', 'Event soft-deleted.');
    }

    public function restore(int $id): RedirectResponse
    {
        Event::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Event restored.');
    }

    private function prepareLocation(array $data): array
    {
        $custom = (bool) ($data['custom_location'] ?? false);
        unset($data['custom_location']);
        $coordinates = $custom ? null : EventLocations::coordinates($data['country'] ?? null, $data['city'] ?? null);
        if ($coordinates) [$data['latitude'], $data['longitude']] = $coordinates;
        return $data;
    }
}
