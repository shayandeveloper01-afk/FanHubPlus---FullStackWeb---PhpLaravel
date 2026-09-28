<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'category_id'    => 'nullable|exists:categories,id',
            'description'    => 'nullable|string',
            'venue_name'     => 'required|string|max:255',
            'city'           => 'required|string|max:100',
            'start_datetime' => 'required|date',
            'end_datetime'   => 'nullable|date|after:start_datetime',
            'ticket_link'    => ['nullable', 'url', 'max:255', function (string $attribute, mixed $value, \Closure $fail): void {
                if ($value && ! in_array(strtolower((string) parse_url($value, PHP_URL_SCHEME)), ['http', 'https'], true)) {
                    $fail('The ticket link must use HTTP or HTTPS.');
                }
            }],
        ]);
        $event->update($data);
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
}
