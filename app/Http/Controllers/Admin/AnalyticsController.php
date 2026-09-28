<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function __construct(private AnalyticsService $analytics) {}

    /** GET /admin/analytics */
    public function index(Request $request): View
    {
        [$from, $to] = $this->parseDateRange($request);

        return view('admin.analytics.index', [
            'from'            => $from,
            'to'              => $to,
            'preset'          => $request->input('preset', '30'),
            'feedbackStats'   => $this->analytics->getFeedbackStats($from, $to),
            'feedbackTrend'   => $this->analytics->getFeedbackTrend($from, $to),
            'chatbotStats'    => $this->analytics->getChatbotStats($from, $to),
            'contentStats'    => $this->analytics->getContentEngagement($from, $to),
            'eventStats'      => $this->analytics->getEventEngagement($from, $to),
            'siteActivity'    => $this->analytics->getSiteActivity($from, $to),
        ]);
    }

    /** GET /admin/analytics/data — AJAX date-range refresh */
    public function data(Request $request): \Illuminate\Http\JsonResponse
    {
        [$from, $to] = $this->parseDateRange($request);

        return response()->json([
            'feedbackStats'  => $this->analytics->getFeedbackStats($from, $to),
            'feedbackTrend'  => $this->analytics->getFeedbackTrend($from, $to),
            'chatbotStats'   => $this->analytics->getChatbotStats($from, $to),
            'contentStats'   => $this->analytics->getContentEngagement($from, $to),
            'eventStats'     => $this->analytics->getEventEngagement($from, $to),
            'siteActivity'   => $this->analytics->getSiteActivity($from, $to),
        ]);
    }

    /** GET /admin/analytics/export — CSV download */
    public function export(Request $request): Response
    {
        [$from, $to] = $this->parseDateRange($request);

        $rows = $this->analytics->exportDashboardCsv($from, $to);

        $csv = implode("\n", array_map(fn($r) => implode(',', array_map(function ($value) {
            $value = (string) $value;
            if (preg_match('/^[\s]*[=+@-]/u', $value)) {
                $value = "'" . $value;
            }
            return '"' . str_replace('"', '""', $value) . '"';
        }, $r)), $rows));

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="analytics-' . $from->toDateString() . '-to-' . $to->toDateString() . '.csv"',
        ]);
    }

    /** GET /admin/feedback/analytics */
    public function feedbackAnalytics(Request $request): View
    {
        [$from, $to] = $this->parseDateRange($request);

        // Stacked bar: feedback by type per day
        $byTypePerDay = \App\Models\Feedback::whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as day, type, COUNT(*) as total')
            ->groupBy('day', 'type')
            ->orderBy('day')
            ->get()
            ->groupBy('day');

        // All feedback for the filterable table
        $feedback = \App\Models\Feedback::with('user')
            ->whereBetween('created_at', [$from, $to])
            ->when($request->type,   fn($q, $v) => $q->where('type', $v))
            ->when($request->status, fn($q, $v) => $q->where('status', $v))
            ->when($request->search, fn($q, $v) => $q->where(function ($q) use ($v) {
                $q->where('subject', 'like', "%{$v}%")->orWhere('message', 'like', "%{$v}%");
            }))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.analytics.feedback', compact(
            'from', 'to', 'byTypePerDay', 'feedback'
        ));
    }

    /** GET /admin/chatbot/analytics */
    public function chatbotAnalytics(Request $request): View
    {
        [$from, $to] = $this->parseDateRange($request);

        $chatbotStats = $this->analytics->getChatbotStats($from, $to);
        $faqStats     = $this->analytics->getFaqMatchStats($from, $to);

        return view('admin.analytics.chatbot', compact(
            'from', 'to', 'chatbotStats', 'faqStats'
        ));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function parseDateRange(Request $request): array
    {
        $data = $request->validate([
            'from' => ['nullable', 'date', 'required_with:to'],
            'to' => ['nullable', 'date', 'after_or_equal:from', 'required_with:from'],
            'preset' => ['nullable', 'in:7,30,90'],
        ]);
        $preset = $data['preset'] ?? '30';

        if (! empty($data['from']) && ! empty($data['to'])) {
            $from = Carbon::parse($data['from'])->startOfDay();
            $to   = Carbon::parse($data['to'])->endOfDay();
        } else {
            $days = match ($preset) {
                '7'  => 7,
                '90' => 90,
                default => 30,
            };
            $from = now()->subDays($days)->startOfDay();
            $to   = now()->endOfDay();
        }

        return [$from, $to];
    }
}
