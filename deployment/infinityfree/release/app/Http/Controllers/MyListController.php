<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\MyList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MyListController extends Controller
{
    /** POST /my-list/{content}/toggle — add or remove from active profile's list */
    public function toggle(Request $request, Content $content): JsonResponse
    {
        $profileId = session('active_profile_id');

        if (!$profileId) {
            return response()->json(['error' => 'No active profile selected.'], 422);
        }
        abort_unless($request->user()->profiles()->whereKey($profileId)->exists(), 403);

        $existing = MyList::where('profile_id', $profileId)
            ->where('content_id', $content->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $inList = false;
        } else {
            MyList::create(['profile_id' => $profileId, 'content_id' => $content->id]);
            $inList = true;
        }

        return response()->json(['in_list' => $inList]);
    }
}
