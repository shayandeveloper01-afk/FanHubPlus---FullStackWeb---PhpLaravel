<?php

namespace App\Services;

use App\Models\AnalyticsEvent;
use App\Models\ChatMessage;
use App\Models\Content;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Models\Faq;
use App\Models\Feedback;
use App\Models\MyList;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class AnalyticsService
{
    // ── Feedback Stats ────────────────────────────────────────────────────────

    /**
     * Feedback totals by type and status, plus average resolution time.
     * Cached 10 minutes — these are expensive GROUP BY queries.
     */
    public function getFeedbackStats(Carbon $from, Carbon $to): array
    {
        $cacheKey = "analytics.feedback.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Count by type (bug/suggestion/general/report)
            $byType = Feedback::whereBetween('created_at', [$from, $to])
                ->selectRaw('type, COUNT(*) as total')
                ->groupBy('type')
                ->pluck('total', 'type');

            // Count by status (new/reviewed/resolved/dismissed)
            $byStatus = Feedback::whereBetween('created_at', [$from, $to])
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            // Average resolution time in hours: time from created_at → updated_at for resolved items.
            // Calculate in PHP so the metric works on both MySQL and SQLite.
            $avgResolutionHours = Feedback::whereBetween('created_at', [$from, $to])
                ->where('status', 'resolved')
                ->get(['created_at', 'updated_at'])
                ->filter(fn (Feedback $feedback) => $feedback->created_at && $feedback->updated_at)
                ->map(fn (Feedback $feedback) => max(0, $feedback->created_at->diffInHours($feedback->updated_at)))
                ->avg();

            return [
                'by_type'              => $byType,
                'by_status'            => $byStatus,
                'avg_resolution_hours' => $avgResolutionHours ? round($avgResolutionHours, 1) : null,
                'total'                => $byType->sum(),
            ];
        });
    }

    /**
     * Daily feedback submission counts over the date range (for line chart).
     * Returns a Collection keyed by date string 'Y-m-d' → count.
     */
    public function getFeedbackTrend(Carbon $from, Carbon $to): Collection
    {
        $cacheKey = "analytics.feedback_trend.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            $rows = Feedback::whereBetween('created_at', [$from, $to])
                ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');

            // Fill in zero-count days so the chart has a continuous x-axis
            return $this->fillDateRange($from, $to, $rows);
        });
    }

    // ── Chatbot Stats ─────────────────────────────────────────────────────────

    /**
     * Chatbot usage stats:
     *  - total_conversations: distinct chat sessions with at least one user message
     *  - top_faqs: top 5 FAQ questions matched (from metadata.faq_id in analytics_events)
     *  - fallback_rate: % of bot replies that were fallback (no FAQ matched)
     *
     * Fallback detection: bot messages containing the feedback form link are fallbacks.
     * We track this via analytics_events with event_type = 'chatbot_fallback'.
     */
    public function getChatbotStats(Carbon $from, Carbon $to): array
    {
        $cacheKey = "analytics.chatbot.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Total unique sessions that sent at least one message in range
            $totalConversations = ChatMessage::whereBetween('created_at', [$from, $to])
                ->where('sender', 'user')
                ->distinct('chat_session_id')
                ->count('chat_session_id');

            // Total bot replies in range
            $totalBotReplies = ChatMessage::whereBetween('created_at', [$from, $to])
                ->where('sender', 'bot')
                ->count();

            // Fallback replies = bot messages containing the feedback form URL
            $fallbackCount = ChatMessage::whereBetween('created_at', [$from, $to])
                ->where('sender', 'bot')
                ->where('message', 'like', '%feedback%')
                ->count();

            // Fallback rate as a percentage
            $fallbackRate = $totalBotReplies > 0
                ? round(($fallbackCount / $totalBotReplies) * 100, 1)
                : 0;

            // Top 5 matched FAQs from analytics_events metadata. Aggregate in PHP
            // because JSON extraction functions differ between MySQL and SQLite.
            $topFaqHits = AnalyticsEvent::whereBetween('created_at', [$from, $to])
                ->where('event_type', 'chatbot_faq_matched')
                ->get(['metadata'])
                ->map(fn ($event) => data_get($event->metadata, 'faq_id'))
                ->filter(fn ($faqId) => filled($faqId))
                ->map(fn ($faqId) => (int) $faqId)
                ->filter(fn ($faqId) => $faqId > 0)
                ->countBy()
                ->sortByDesc(fn ($hits) => $hits)
                ->take(5);
            $matchedFaqs = Faq::whereIn('id', $topFaqHits->keys())->get()->keyBy('id');
            $topFaqs = $topFaqHits->map(fn ($hits, $faqId) => [
                'question' => $matchedFaqs->get($faqId)?->question ?? 'Unknown FAQ',
                'hits'     => $hits,
            ])->values();

            // Unmatched messages (fallback triggered) — last 50 for the insights table
            $unmatchedMessages = ChatMessage::whereBetween('created_at', [$from, $to])
                ->where('sender', 'bot')
                ->where('message', 'like', '%feedback%')
                ->with('session')
                ->latest('created_at')
                ->limit(50)
                ->get()
                ->map(function ($botMsg) {
                    // Find the user message that preceded this bot reply in the same session
                    $userMsg = ChatMessage::where('chat_session_id', $botMsg->chat_session_id)
                        ->where('sender', 'user')
                        ->where('id', '<', $botMsg->id)
                        ->latest('id')
                        ->value('message');
                    return [
                        'user_message' => $userMsg ?? '(unknown)',
                        'at'           => $botMsg->created_at,
                    ];
                });

            return [
                'total_conversations' => $totalConversations,
                'total_bot_replies'   => $totalBotReplies,
                'fallback_count'      => $fallbackCount,
                'fallback_rate'       => $fallbackRate,
                'top_faqs'            => $topFaqs,
                'unmatched_messages'  => $unmatchedMessages,
            ];
        });
    }

    /**
     * FAQ match frequency table — all FAQs with their hit count, sorted by most-used.
     */
    public function getFaqMatchStats(Carbon $from, Carbon $to): Collection
    {
        $cacheKey = "analytics.faq_matches.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Aggregate hits per faq_id from analytics_events in PHP for
            // consistent JSON handling across supported database drivers.
            $hits = AnalyticsEvent::whereBetween('created_at', [$from, $to])
                ->where('event_type', 'chatbot_faq_matched')
                ->get(['metadata', 'created_at'])
                ->map(fn ($event) => [
                    'faq_id'     => (int) data_get($event->metadata, 'faq_id'),
                    'created_at' => $event->created_at,
                ])
                ->filter(fn ($row) => $row['faq_id'] > 0)
                ->groupBy('faq_id')
                ->map(function (Collection $events) {
                    $latest = $events->sortByDesc('created_at')->first();

                    return [
                        'hits'         => $events->count(),
                        'last_matched' => $latest['created_at'] ?? null,
                    ];
                });

            // Join with all FAQs so zero-hit FAQs still appear
            return Faq::orderBy('sort_order')->get()->map(function ($faq) use ($hits) {
                $row = $hits->get($faq->id);
                return [
                    'id'           => $faq->id,
                    'question'     => $faq->question,
                    'hits'         => $row['hits'] ?? 0,
                    'last_matched' => $row['last_matched'] ?? null,
                    'is_published' => $faq->is_published,
                ];
            })->sortByDesc('hits')->values();
        });
    }

    // ── Content Engagement ────────────────────────────────────────────────────

    /**
     * Content engagement stats:
     *  - most_viewed: top 10 by views_count
     *  - most_listed: top 10 most added to My List
     *  - most_trailer_hover: top 10 trailer hover events from analytics_events
     */
    public function getContentEngagement(Carbon $from, Carbon $to): array
    {
        $cacheKey = "analytics.content.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Most viewed — views_count is a running total, not date-filtered
            $mostViewed = Content::where('status', 'published')
                ->orderByDesc('views_count')
                ->limit(10)
                ->get(['id', 'title', 'views_count']);

            // Most added to My List in date range
            $mostListed = MyList::whereBetween('added_at', [$from, $to])
                ->selectRaw('content_id, COUNT(*) as list_count')
                ->groupBy('content_id')
                ->orderByDesc('list_count')
                ->limit(10)
                ->with('content:id,title')
                ->get()
                ->map(fn($r) => [
                    'title'      => $r->content?->title ?? 'Deleted',
                    'list_count' => $r->list_count,
                ]);

            // Trailer hover events from analytics_events. Aggregate in PHP so
            // JSON extraction works on both MySQL and SQLite.
            $trailerHoverHits = AnalyticsEvent::whereBetween('created_at', [$from, $to])
                ->where('event_type', 'trailer_hover')
                ->get(['metadata'])
                ->map(fn ($event) => data_get($event->metadata, 'content_id'))
                ->filter(fn ($contentId) => filled($contentId))
                ->map(fn ($contentId) => (int) $contentId)
                ->filter(fn ($contentId) => $contentId > 0)
                ->countBy()
                ->sortByDesc(fn ($hits) => $hits)
                ->take(10);
            $hoverContents = Content::whereIn('id', $trailerHoverHits->keys())->get()->keyBy('id');
            $trailerHovers = $trailerHoverHits->map(fn ($hoverCount, $contentId) => [
                'title'       => $hoverContents->get($contentId)?->title ?? 'Deleted',
                'hover_count' => $hoverCount,
            ])->values();

            return [
                'most_viewed'    => $mostViewed,
                'most_listed'    => $mostListed,
                'trailer_hovers' => $trailerHovers,
            ];
        });
    }

    // ── Event Engagement ──────────────────────────────────────────────────────

    /**
     * Event RSVP stats:
     *  - most_rsvpd: top 10 events by total RSVP count
     *  - conversion_rate: % of 'interested' RSVPs that upgraded to 'going'
     *    (approximated as going_count / (going_count + interested_count) * 100)
     */
    public function getEventEngagement(Carbon $from, Carbon $to): array
    {
        $cacheKey = "analytics.events.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Most RSVP'd events in date range
            $mostRsvpd = EventRsvp::whereBetween('created_at', [$from, $to])
                ->selectRaw('event_id, COUNT(*) as rsvp_count,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as going_count,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as interested_count', ['going', 'interested'])
                ->groupBy('event_id')
                ->orderByDesc('rsvp_count')
                ->limit(10)
                ->with('event:id,title,start_datetime')
                ->get()
                ->map(fn($r) => [
                    'title'            => $r->event?->title ?? 'Deleted',
                    'date'             => $r->event?->start_datetime?->format('d M Y'),
                    'rsvp_count'       => $r->rsvp_count,
                    'going_count'      => $r->going_count,
                    'interested_count' => $r->interested_count,
                ]);

            // Overall conversion rate: going / (going + interested) across all RSVPs in range
            $totals = EventRsvp::whereBetween('created_at', [$from, $to])
                ->selectRaw('SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as going,
                    SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as interested', ['going', 'interested'])
                ->first();

            $total = ($totals->going ?? 0) + ($totals->interested ?? 0);
            $conversionRate = $total > 0
                ? round(($totals->going / $total) * 100, 1)
                : 0;

            return [
                'most_rsvpd'      => $mostRsvpd,
                'conversion_rate' => $conversionRate,
                'total_going'     => $totals->going ?? 0,
                'total_interested'=> $totals->interested ?? 0,
            ];
        });
    }

    // ── Site Activity ─────────────────────────────────────────────────────────

    /**
     * Daily unique sessions and page views over the date range.
     * Returns ['sessions' => Collection, 'page_views' => Collection] keyed by date.
     */
    public function getSiteActivity(Carbon $from, Carbon $to): array
    {
        $cacheKey = "analytics.activity.{$from->toDateString()}.{$to->toDateString()}";

        return Cache::remember($cacheKey, 600, function () use ($from, $to) {
            // Daily unique session_ids (proxy for daily active users)
            $sessions = AnalyticsEvent::whereBetween('created_at', [$from, $to])
                ->whereNotNull('session_id')
                ->selectRaw('DATE(created_at) as day, COUNT(DISTINCT session_id) as total')
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');

            // Daily page_view events
            $pageViews = AnalyticsEvent::whereBetween('created_at', [$from, $to])
                ->where('event_type', 'page_view')
                ->selectRaw('DATE(created_at) as day, COUNT(*) as total')
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('total', 'day');

            return [
                'sessions'   => $this->fillDateRange($from, $to, $sessions),
                'page_views' => $this->fillDateRange($from, $to, $pageViews),
            ];
        });
    }

    // ── Trending Content (homepage widget) ────────────────────────────────────

    /**
     * Most content_view + my_list_added events in last 7 days.
     * Used for the "Trending Now" homepage widget.
     * Cached 10 minutes.
     */
    public function getTrendingContent(int $limit = 6): Collection
    {
        return Cache::remember('analytics.trending', 600, function () use ($limit) {
            $from = now()->subDays(7);

            // Score = content_views + (my_list_adds * 3) — list adds weighted higher.
            // Aggregate in PHP so this works consistently on MySQL and SQLite.
            $scores = AnalyticsEvent::where('created_at', '>=', $from)
                ->whereIn('event_type', ['content_view', 'my_list_added'])
                ->get(['event_type', 'metadata'])
                ->map(function ($event) {
                    $contentId = data_get($event->metadata, 'content_id');

                    if (blank($contentId)) {
                        return null;
                    }

                    return [
                        'content_id' => (string) $contentId,
                        'score'      => $event->event_type === 'content_view' ? 1 : 3,
                    ];
                })
                ->filter()
                ->groupBy('content_id')
                ->map->sum('score')
                ->sortByDesc(fn ($score) => $score)
                ->take($limit)
                ->keys()
                ->map(fn ($contentId) => (int) $contentId)
                ->values();

            if ($scores->isEmpty()) {
                // Fallback: most viewed content overall
                return Content::with('category')
                    ->where('status', 'published')
                    ->orderByDesc('views_count')
                    ->limit($limit)
                    ->get();
            }

            return Content::with('category')
                ->whereIn('id', $scores)
                ->where('status', 'published')
                ->get()
                ->sortBy(fn($c) => array_search($c->id, $scores->toArray()))
                ->values();
        });
    }

    // ── CSV Export ────────────────────────────────────────────────────────────

    /**
     * Build a flat array of rows for CSV export of the main dashboard.
     */
    public function exportDashboardCsv(Carbon $from, Carbon $to): array
    {
        $feedback = $this->getFeedbackStats($from, $to);
        $chatbot  = $this->getChatbotStats($from, $to);
        $events   = $this->getEventEngagement($from, $to);

        $rows = [['Section', 'Metric', 'Value']];

        foreach ($feedback['by_type'] as $type => $count) {
            $rows[] = ['Feedback', "Type: {$type}", $count];
        }
        foreach ($feedback['by_status'] as $status => $count) {
            $rows[] = ['Feedback', "Status: {$status}", $count];
        }
        $rows[] = ['Feedback', 'Avg Resolution (hours)', $feedback['avg_resolution_hours'] ?? 'N/A'];
        $rows[] = ['Chatbot', 'Total Conversations', $chatbot['total_conversations']];
        $rows[] = ['Chatbot', 'Fallback Rate (%)', $chatbot['fallback_rate']];
        $rows[] = ['Events', 'RSVP Conversion Rate (%)', $events['conversion_rate']];
        $rows[] = ['Events', 'Total Going', $events['total_going']];
        $rows[] = ['Events', 'Total Interested', $events['total_interested']];

        return $rows;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Fill a date-keyed collection with zeros for missing days.
     * Ensures charts always have a continuous x-axis.
     */
    private function fillDateRange(Carbon $from, Carbon $to, $data): Collection
    {
        $filled = collect();
        $cursor = $from->copy()->startOfDay();

        while ($cursor->lte($to)) {
            $key = $cursor->toDateString();
            $filled[$key] = $data[$key] ?? 0;
            $cursor->addDay();
        }

        return $filled;
    }
}
