<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Content;
use App\Models\Event;
use App\Models\Feedback;
use App\Models\Merchandise;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'from' => ['nullable', 'date', 'required_with:to'],
            'to' => ['nullable', 'date', 'after_or_equal:from', 'required_with:from'],
        ]);
        $from = isset($filters['from']) ? \Illuminate\Support\Carbon::parse($filters['from'])->startOfDay() : now()->subDays(29)->startOfDay();
        $to = isset($filters['to']) ? \Illuminate\Support\Carbon::parse($filters['to'])->endOfDay() : now()->endOfDay();

        // Summary cards
        $summary = [
            'users'       => User::count(),
            'contents'    => Content::count(),
            'articles'    => Article::count(),
            'merchandise' => Merchandise::count(),
            'events'      => Event::count(),
            'feedback'    => Feedback::where('status', 'new')->count(),
        ];

        // 1. User growth (registrations per day in range)
        $userGrowth = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')->orderBy('date')
            ->pluck('total', 'date');

        // 2. Content by category
        $contentByCategory = Category::withCount('contents')->orderByDesc('contents_count')->get()
            ->map(fn($c) => ['label' => $c->name, 'value' => $c->contents_count]);

        // 3. Most viewed content (top 10)
        $mostViewed = Content::select('title', 'views_count')
            ->orderByDesc('views_count')->limit(10)->get()
            ->map(fn($c) => ['label' => str($c->title)->limit(30), 'value' => $c->views_count]);

        // 4. Ratings distribution (1–5)
        $ratingsDistribution = Rating::select('rating', DB::raw('COUNT(*) as total'))
            ->groupBy('rating')->orderBy('rating')
            ->pluck('total', 'rating');

        // 5. Engagement over time (views_count sum of content created per day in range)
        $engagement = Content::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(views_count) as total'))
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('date')->orderBy('date')
            ->pluck('total', 'date');

        return view('admin.dashboard.index', compact(
            'summary', 'userGrowth', 'contentByCategory',
            'mostViewed', 'ratingsDistribution', 'engagement',
            'from', 'to'
        ));
    }
}
