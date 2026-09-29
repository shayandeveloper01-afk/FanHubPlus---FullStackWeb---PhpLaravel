<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function toggle(Request $request, Content $content)
    {
        $bookmarked = DB::transaction(function () use ($request, $content) {
            // Serializing toggles per user avoids two quick clicks racing into
            // the unique (user_id, content_id) constraint.
            $user = $request->user()->newQuery()->whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
            $bookmark = Bookmark::where('user_id', $user->id)
                ->where('content_id', $content->id)
                ->first();

            if ($bookmark) {
                $bookmark->delete();
                return false;
            }

            Bookmark::firstOrCreate([
                'user_id' => $user->id,
                'content_id' => $content->id,
            ]);

            return true;
        });

        if ($request->expectsJson()) {
            return response()->json(['bookmarked' => $bookmarked]);
        }

        return back()->with('status', $bookmarked ? 'Bookmark saved.' : 'Bookmark removed.');
    }
}
