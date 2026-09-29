<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContentRequest;
use App\Http\Requests\UpdateContentRequest;
use App\Models\Category;
use App\Models\Content;
use App\Services\AnalyticsLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Request $request): View
    {
        $contents = Content::with(['user', 'category'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('contents.index', compact('contents'));
    }

    public function create(): View
    {
        return view('contents.create', [
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(StoreContentRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $request->user()->contents()->create($data);

        return redirect()->route('contents.index')
            ->with('success', 'Content created successfully.');
    }

    public function show(Request $request, Content $content, AnalyticsLogger $analytics): View
    {
        abort_unless(
            $content->isPublished() || $request->user()?->can('update', $content),
            404
        );

        $analytics->log('content_view', ['content_id' => $content->id]);
        $sessionKey = 'viewed_content_' . $content->id;
        if (! session()->has($sessionKey)) {
            $content->increment('views_count');
            session()->put($sessionKey, true);
        }

        $content->load([
            'user', 'category',
            'tags' => fn ($query) => $query->withCount('contents'),
            'characters',
            'timelineEvents',
            'ratings',
        ]);

        $userBookmarked = auth()->check()
            ? $content->bookmarks()->where('user_id', auth()->id())->exists()
            : false;

        $userRating = auth()->check()
            ? $content->ratings()->where('user_id', auth()->id())->value('rating')
            : null;
        $userReview = auth()->check()
            ? $content->ratings()->where('user_id', auth()->id())->value('review')
            : '';
        $userReviewStatus = auth()->check()
            ? $content->ratings()->where('user_id', auth()->id())->value('review_status')
            : null;

        // Reviews are public; private notes are loaded only for their owner below.
        $reviews = $content->ratings()
            ->with('user:id,name')
            ->whereNotNull('review')
            ->where('review', '<>', '')
            ->where('review_status', 'approved')
            ->latest()
            ->get(['id', 'user_id', 'content_id', 'rating', 'review', 'admin_reply', 'admin_reaction', 'created_at']);

        $userNote = auth()->check()
            ? $content->notes()->where('user_id', auth()->id())->value('note')
            : null;
        $noteDetails = auth()->check()
            ? $content->notes()->where('user_id', auth()->id())->first(['timestamp_seconds', 'is_spoiler'])
            : null;

        // Active fandom profile (for My List state)
        $profileId = session('active_profile_id');
        $profile   = ($profileId && $request->user())
            ? $request->user()->profiles()->whereKey($profileId)->first()
            : null;
        $inList    = $profile
            ? \App\Models\MyList::where('profile_id', $profile->id)->where('content_id', $content->id)->exists()
            : false;

        // Related chain: same genre OR category, excluding self, ordered by views
        $related = Content::with('category')
            ->where('status', 'published')
            ->where('id', '!=', $content->id)
            ->where(function ($q) use ($content) {
                $q->where('genre', $content->genre)
                  ->orWhere('category_id', $content->category_id);
            })
            ->orderByDesc('views_count')
            ->limit(12)
            ->get();

        // "Play Next" = highest-viewed related item
        $playNext = $related->first();

        return view('contents.show', compact(
            'content', 'userBookmarked', 'userRating', 'userReview', 'userReviewStatus', 'reviews', 'userNote', 'noteDetails',
            'profile', 'inList', 'related', 'playNext'
        ));
    }

    public function edit(Content $content): View
    {
        $this->authorize('update', $content);

        return view('contents.edit', [
            'content'    => $content,
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateContentRequest $request, Content $content): RedirectResponse
    {
        $data = $request->safe()->except('thumbnail');

        if ($request->hasFile('thumbnail')) {
            if ($content->thumbnail) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($content->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $content->update($data);

        return redirect()->route('contents.index')
            ->with('success', 'Content updated successfully.');
    }

    public function destroy(Request $request, Content $content): RedirectResponse
    {
        $this->authorize('delete', $content);

        $content->delete();

        return redirect()->route('contents.index')
            ->with('success', 'Content deleted.');
    }
}
