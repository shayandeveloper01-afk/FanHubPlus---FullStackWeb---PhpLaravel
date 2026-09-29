<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\WatchProgress;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchProgressController extends Controller
{
    /** POST /watch-progress/{content} — upsert progress for active profile */
    public function update(Request $request, Content $content): JsonResponse
    {
        $request->validate(['progress_pct' => 'required|integer|min:0|max:100']);

        $profileId = session('active_profile_id');

        if (!$profileId) {
            return response()->json(['error' => 'No active profile.'], 422);
        }
        abort_unless($request->user()->profiles()->whereKey($profileId)->exists(), 403);

        WatchProgress::updateOrCreate(
            ['profile_id' => $profileId, 'content_id' => $content->id],
            ['progress_pct' => $request->progress_pct]
        );

        return response()->json(['ok' => true]);
    }
}
