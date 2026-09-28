<?php

namespace App\Services;

use App\Models\Faq;

/**
 * FaqMatcherService
 *
 * Scores every published FAQ against a user's input using three tiers:
 *
 *   Tier 1 — Exact keyword match  (+2 per keyword hit)
 *     Each FAQ stores a JSON array of keywords. If any keyword appears as a
 *     substring of the lowercased user input, the FAQ gains 2 points.
 *
 *   Tier 2 — Question-word match  (+1 per word hit)
 *     Individual words from the FAQ question (length > 3) that appear in the
 *     input each add 1 point. This catches paraphrasing without keywords.
 *
 *   Tier 3 — Fuzzy match  (+1 per fuzzy hit, only when Tier 1+2 score = 0)
 *     For each input word (length > 3) vs each keyword:
 *       - similar_text() >= FUZZY_SIMILARITY_PCT  → +1  (catches typos like "pasword")
 *       - levenshtein() <= adaptive distance       → +1  (short words: ≤1, longer: ≤2)
 *     This tier is gated behind score === 0 to avoid false positives on
 *     already-matched FAQs and to keep performance acceptable.
 *
 * The best-scoring FAQ is returned if its score meets MIN_SCORE.
 * If nothing clears the threshold, a fallback message with the feedback URL
 * is returned instead.
 *
 * ⚠️  Performance note: this service loads all published FAQs into memory and
 * runs O(n × k) comparisons per request (n = FAQs, k = keywords per FAQ).
 * With 15–50 FAQs this is negligible. If the FAQ table grows to hundreds of
 * entries, consider moving to a full-text search index (MySQL FULLTEXT or
 * a dedicated search service like Meilisearch) and retiring the fuzzy tier.
 */
class FaqMatcherService
{
    /**
     * Minimum score an FAQ must reach to be returned as a match.
     * Raise this to require stronger matches; lower it to be more permissive.
     */
    private const MIN_SCORE = 2;

    /**
     * Minimum similar_text() percentage to count as a fuzzy keyword match.
     */
    private const FUZZY_SIMILARITY_PCT = 70;

    /**
     * Find the best FAQ match for $input.
     *
     * @return array{0: string, 1: int|null}  [bot_reply, matched_faq_id|null]
     */
    public function match(string $input): array
    {
        $input = strtolower(trim($input));
        $faqs  = Faq::published()->get();

        $bestScore = 0;
        $bestFaq   = null;

        foreach ($faqs as $faq) {
            $score = 0;

            // ── Tier 1: exact keyword substring match ─────────────────────────
            // keywords is cast to array by the Faq model (JSON column)
            $keywords = array_map('strtolower', $faq->keywordList());

            foreach ($keywords as $kw) {
                if ($kw !== '' && str_contains($input, $kw)) {
                    $score += 2;
                }
            }

            // ── Tier 2: question-word substring match ─────────────────────────
            $questionWords = array_filter(
                explode(' ', strtolower($faq->question)),
                fn($w) => strlen($w) > 3
            );

            foreach ($questionWords as $word) {
                if (str_contains($input, $word)) {
                    $score += 1;
                }
            }

            // ── Tier 3: fuzzy match (only when tiers 1+2 scored nothing) ──────
            // Avoids wasting CPU on already-matched FAQs.
            if ($score === 0 && count($keywords) > 0) {
                $inputWords = array_filter(
                    explode(' ', $input),
                    fn($w) => strlen($w) > 3 && strlen($w) <= 255
                );

                foreach ($keywords as $kw) {
                    if ($kw === '' || strlen($kw) > 255) continue;
                    foreach ($inputWords as $iw) {
                        // similar_text fuzzy check
                        similar_text($iw, $kw, $pct);
                        if ($pct >= self::FUZZY_SIMILARITY_PCT) {
                            $score += 1;
                        }

                        // Levenshtein distance check (adaptive threshold)
                        $maxDist = strlen($kw) <= 5 ? 1 : 2;
                        if (levenshtein($iw, $kw) <= $maxDist) {
                            $score += 1;
                        }
                    }
                }
            }

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestFaq   = $faq;
            }
        }

        // Return best match only if it clears the minimum threshold
        if ($bestFaq && $bestScore >= self::MIN_SCORE) {
            return [$bestFaq->answer, $bestFaq->id];
        }

        // Fallback — no FAQ matched well enough
        $feedbackUrl = route('feedback.create');
        return [
            "Sorry, I couldn't find an answer to that. You can submit feedback at {$feedbackUrl}.",
            null,
        ];
    }
}
