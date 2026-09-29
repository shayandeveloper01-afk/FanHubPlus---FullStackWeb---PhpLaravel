<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Content;
use App\Models\Event;
use App\Models\Profile;
use App\Models\WatchProgress;
use App\Services\AnalyticsService;
use App\Services\MatchScoreService;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(MatchScoreService $matchService, AnalyticsService $analytics): View
    {
        // Resolve active fandom profile (null for guests)
        $profile = $this->activeProfile();

        $hero             = $this->buildHero();
        $latest           = $this->buildLatest();
        $popular          = $this->buildPopular();
        $newThisWeek      = $this->buildNewThisWeek();
        $categories       = $this->buildCategoryRows();
        $top10Rows        = $this->buildTop10Rows();
        $continueRow      = $this->buildContinueRow($profile);
        $becauseRows      = $this->buildBecauseRows($profile);
        $featuredArticles = $this->buildFeaturedArticles();
        $eventsNearby     = $this->buildEventsNearby();

        $myListIds   = $this->myListIds($profile);
        $bookmarkIds = auth()->check()
            ? auth()->user()->bookmarks()->pluck('content_id')->map(fn ($id) => (int) $id)->all()
            : [];
        $matchScores = $this->buildMatchScores($profile, $matchService, $latest, $popular);
        $trending    = $analytics->getTrendingContent(12);

        return view('home', compact(
            'hero', 'latest', 'popular', 'newThisWeek',
            'categories', 'top10Rows', 'continueRow',
            'becauseRows', 'featuredArticles', 'profile',
            'myListIds', 'matchScores', 'eventsNearby', 'trending', 'bookmarkIds'
        ));
    }

    // ── Private row builders ──────────────────────────────────────────────────

    private function buildHero(): ?Content
    {
        return Content::with(['category', 'user'])
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->first();
    }

    private function buildLatest(): Collection
    {
        $contents = Content::with('category')
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->limit(36)->get();

        return $this->uniqueContent($contents)->take(12)->values();
    }

    private function buildPopular(): Collection
    {
        $contents = Content::with('category')
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->limit(36)->get();

        return $this->uniqueContent($contents)->take(12)->values();
    }

    /**
     * "New This Week" — content created in the last 7 days.
     */
    private function buildNewThisWeek(): Collection
    {
        $contents = Content::with('category')
            ->where('status', 'published')
            ->where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('created_at')
            ->limit(36)->get();

        return $this->uniqueContent($contents)->take(12)->values();
    }

    private function buildCategoryRows(): Collection
    {
        return Category::where('status', 'active')
            ->with(['contents' => function ($q) {
                $q->where('status', 'published')
                  ->orderByDesc('views_count')
                  ->limit(36);
            }])
            ->get()
            ->each(function (Category $category) {
                $category->setRelation(
                    'contents',
                    $this->uniqueContent($category->contents)->take(12)->values()
                );
            })
            ->filter(fn($c) => $c->contents->isNotEmpty());
    }

    /** Remove duplicate videos and repeated artwork while preserving sort order. */
    private function uniqueContent(Collection $contents): Collection
    {
        $seenVideos = [];
        $seenArtwork = [];

        return $contents->filter(function (Content $content) use (&$seenVideos, &$seenArtwork) {
            $videoKey = null;
            $trailer = (string) $content->trailer_url;
            if (preg_match('~(?:youtu\\.be/|youtube\\.com/(?:watch\\?v=|embed/|shorts/))([^?&/]+)~i', $trailer, $match)) {
                $videoKey = strtolower($match[1]);
            } elseif ($trailer !== '') {
                $videoKey = strtolower(rtrim($trailer, '/'));
            }

            $artworkKey = strtolower(trim((string) $content->thumbnailUrl()));
            $artworkKey = strtok($artworkKey, '?') ?: $artworkKey;

            if (($videoKey && isset($seenVideos[$videoKey])) || ($artworkKey !== '' && isset($seenArtwork[$artworkKey]))) {
                return false;
            }

            if ($videoKey) {
                $seenVideos[$videoKey] = true;
            }
            if ($artworkKey !== '') {
                $seenArtwork[$artworkKey] = true;
            }

            return true;
        })->values();
    }

    /**
     * "Top 10 in [Category]" — top 10 per category ranked by a weighted score:
     *   score = views_count + (avg_rating * 20)
     * Returns array of ['title' => string, 'items' => Collection].
     */
    private function buildTop10Rows(): array
    {
        $rows = [];

        $categories = Category::where('status', 'active')
            ->with(['contents' => function ($q) {
                $q->where('status', 'published')
                  ->withAvg('ratings', 'rating')
                  ->orderByDesc('views_count')
                  ->limit(20); // fetch 20, rank in PHP
            }])
            ->get()
            ->filter(fn($c) => $c->contents->count() >= 3); // only show if enough content

        foreach ($categories as $category) {
            // Weighted rank: views + (avg_rating * 20) to balance popularity vs quality
            $ranked = $category->contents
                ->sortByDesc(fn($c) => $c->views_count + (($c->ratings_avg_rating ?? 0) * 20))
                ->values()
                ->take(10);

            $rows[] = [
                'title' => "Top 10 in {$category->name}",
                'items' => $ranked,
            ];
        }

        return $rows;
    }

    /**
     * "Continue Exploring" — profile's in-progress content (5%–90% progress),
     * sorted by most recently updated.
     */
    private function buildContinueRow(?Profile $profile): Collection
    {
        if (!$profile) return collect();

        return WatchProgress::where('profile_id', $profile->id)
            ->whereBetween('progress_pct', [5, 90])
            ->orderByDesc('updated_at')
            ->with(['content.category'])
            ->limit(12)
            ->get()
            ->pluck('content')
            ->filter(); // remove any soft-deleted content
    }

    /**
     * "Because You Liked X" — for the profile's top 2-3 rated content items,
     * find other content sharing the same genre or category.
     * Returns array of ['title' => string, 'items' => Collection].
     */
    private function buildBecauseRows(?Profile $profile): array
    {
        if (!$profile) return [];

        // Top 3 highest-rated content by this profile
        $topRated = $profile->ratings()
            ->with('content.category')
            ->orderByDesc('rating')
            ->limit(3)
            ->get()
            ->filter(fn($r) => $r->content !== null);

        $rows = [];

        foreach ($topRated as $rating) {
            $seed = $rating->content;

            // Find similar content: same genre OR same category, excluding the seed itself
            $similar = Content::with('category')
                ->where('status', 'published')
                ->where('id', '!=', $seed->id)
                ->where(function ($q) use ($seed) {
                    $q->where('genre', $seed->genre)
                      ->orWhere('category_id', $seed->category_id);
                })
                ->orderByDesc('views_count')
                ->limit(12)
                ->get();

            if ($similar->isNotEmpty()) {
                $rows[] = [
                    'title' => "Because you liked {$seed->title}",
                    'items' => $similar,
                ];
            }
        }

        return $rows;
    }

    private function buildFeaturedArticles(): Collection
    {
        return Article::with('user')
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderByDesc('published_at')
            ->limit(4)
            ->get();
    }

    /**
     * "Events Near You" — upcoming events ordered by start date.
     * Returns a flat collection of up to 8 events for the homepage row.
     * Actual proximity filtering happens client-side via the /events/nearby
     * AJAX endpoint once the user grants geolocation; this provides a
     * sensible default (soonest upcoming events) for guests and users
     * who haven't shared their location yet.
     */
    private function buildEventsNearby(): Collection
    {
        return Event::with('category')
            ->upcoming()
            ->orderBy('start_datetime')
            ->limit(8)
            ->get();
    }

    /** Resolve the active fandom profile from session. */
    private function activeProfile(): ?Profile
    {
        $profileId = session('active_profile_id');
        if (!$profileId || !auth()->check()) return null;

        return auth()->user()->profiles()->whereKey($profileId)->first();
    }

    /** IDs of content in the active profile's My List (for card UI state). */
    private function myListIds(?Profile $profile): array
    {
        if (!$profile) return [];

        return $profile->myList()->pluck('content_id')->toArray();
    }

    /**
     * Build a content_id => match_pct map for the main visible rows.
     * Only calculated when a profile is active (avoids wasted queries for guests).
     * Scores the union of latest + popular to cover most visible cards.
     */
    private function buildMatchScores(?Profile $profile, MatchScoreService $svc, Collection $latest, Collection $popular): array
    {
        if (!$profile) return [];

        $scores = [];
        // Deduplicate by id across both rows
        $items = $latest->merge($popular)->unique('id');

        foreach ($items as $content) {
            $scores[$content->id] = $svc->calculate($profile, $content);
        }

        return $scores;
    }
}
