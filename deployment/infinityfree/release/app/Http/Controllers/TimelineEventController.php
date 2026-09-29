<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\TimelineEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TimelineEventController extends Controller
{
    public function store(Request $request, Content $content): RedirectResponse
    {
        $this->authorize('update', $content);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'event_date'  => ['nullable', 'date'],
            'order_index' => ['nullable', 'integer', 'min:0'],
        ]);

        $content->timelineEvents()->create($data);

        return back()->with('success', 'Timeline event added.');
    }

    public function destroy(Request $request, Content $content, TimelineEvent $timelineEvent): RedirectResponse
    {
        $this->authorize('update', $content);
        $timelineEvent = $content->timelineEvents()->findOrFail($timelineEvent->id);
        $timelineEvent->delete();

        return back()->with('success', 'Event removed.');
    }
}
