<?php

namespace App\Services;

use App\Models\Content;
use App\Models\Profile;

/**
 * Rule-based match score between a fandom profile and a piece of content.
 *
 * Scoring factors (all additive, then normalised to 40-98%):
 *  1. Genre overlap  — profile's watched/rated genres vs content genre (+40 pts max)
 *  2. Category match — profile has watched content in same category (+30 pts)
 *  3. High rating    — profile rated similar content 4-5 stars (+20 pts)
 *  4. Recency boost  — content created in last 30 days (+10 pts)
 *
 * Max raw score = 100. Clamped output: 40–98 for realism.
 */
class MatchScoreService
{
    /**
     * Calculate match percentage for a profile/content pair.
     *
     * @return int  Integer between 40 and 98
     */
    public function calculate(Profile $profile, Content $content): int
    {
        // Eager-load profile ratings with their content (genre/category)
        $ratings = $profile->ratings()->with('content')->get();

        $score = 0;

        // ── Factor 1: Genre overlap (40 pts) ─────────────────────────────────
        // Count how many times the profile has engaged with this genre
        if ($content->genre) {
            $genreHits = $ratings->filter(
                fn($r) => $r->content?->genre === $content->genre
            )->count();

            // Each genre hit worth up to 10 pts, capped at 40
            $score += min(40, $genreHits * 10);
        }

        // ── Factor 2: Category match (30 pts) ────────────────────────────────
        $categoryHits = $ratings->filter(
            fn($r) => $r->content?->category_id === $content->category_id
        )->count();

        $score += min(30, $categoryHits * 10);

        // ── Factor 3: High ratings on similar content (20 pts) ───────────────
        // Profile gave 4+ stars to content in same genre or category
        $highRatings = $ratings->filter(
            fn($r) => $r->rating >= 4 && (
                $r->content?->genre === $content->genre ||
                $r->content?->category_id === $content->category_id
            )
        )->count();

        $score += min(20, $highRatings * 10);

        // ── Factor 4: Recency boost (10 pts) ─────────────────────────────────
        if ($content->created_at?->diffInDays(now()) <= 30) {
            $score += 10;
        }

        // ── Normalise to 40–98 range ──────────────────────────────────────────
        // Map raw 0-100 → 40-98 linearly, then clamp
        $normalised = 40 + (int) round(($score / 100) * 58);

        return max(40, min(98, $normalised));
    }
}
