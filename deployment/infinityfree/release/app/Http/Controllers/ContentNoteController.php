<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ContentNoteController extends Controller
{
    public function upsert(Request $request, Content $content): JsonResponse|RedirectResponse
    {
        $request->validate([
            'note' => ['required', 'string', 'max:5000'],
            'timestamp_seconds' => ['nullable', 'integer', 'min:0'],
            'is_spoiler' => ['nullable', 'boolean'],
        ]);

        $note = ContentNote::updateOrCreate(
            ['user_id' => $request->user()->id, 'content_id' => $content->id],
            [
                'note' => $request->note,
                'timestamp_seconds' => $request->input('timestamp_seconds'),
                'is_spoiler' => $request->boolean('is_spoiler'),
            ]
        );

        if (! $request->expectsJson()) {
            return back()->with('note_saved', 'Your private note has been saved.');
        }

        return response()->json(['saved' => true, 'note' => $note->note]);
    }

    public function destroy(Request $request, Content $content): JsonResponse|RedirectResponse
    {
        ContentNote::where('user_id', $request->user()->id)
            ->where('content_id', $content->id)
            ->delete();

        if (! $request->expectsJson()) {
            return back()->with('note_saved', 'Your private note has been deleted.');
        }

        return response()->json(['deleted' => true]);
    }
}
