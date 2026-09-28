<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function index(Request $request): View
    {
        $bookmarks = Bookmark::with(['content.category'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(18);

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function toggle(Request $request, Content $content): JsonResponse
    {
        $user = $request->user();

        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('content_id', $content->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
        } else {
            Bookmark::create(['user_id' => $user->id, 'content_id' => $content->id]);
            $bookmarked = true;
        }

        return response()->json(['bookmarked' => $bookmarked]);
    }
}
