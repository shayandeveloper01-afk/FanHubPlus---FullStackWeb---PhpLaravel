<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExploreController extends Controller
{
    public function __invoke(Request $request): View
    {
        $filters = $request->only(['category', 'genre', 'year', 'type', 'tags', 'min_rating']);
        $search  = $request->input('q', $request->input('search'));
        $sort    = $request->input('sort', 'newest');

        $categoryFilter = $filters['category'] ?? null;
        if (filled($categoryFilter) && ! is_numeric($categoryFilter)) {
            unset($filters['category']);
        }

        $query = Content::with(['category', 'user'])->withAvg('ratings', 'rating')
            ->where('status', 'published')
            ->search($search)
            ->filter($filters);
        if (filled($categoryFilter) && ! is_numeric($categoryFilter)) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $categoryFilter));
        }
        if (filled($filters['min_rating'] ?? null)) {
            $query->whereRaw('(SELECT AVG(rating) FROM ratings WHERE ratings.content_id = contents.id) >= ?', [min(5, max(1, (float) $filters['min_rating']))]);
        }
        $query->when($sort === 'rating', fn ($q) => $q->orderByDesc('ratings_avg_rating'))
            ->when(in_array($sort, ['trending', 'views', 'popular'], true), fn ($q) => $q->orderByDesc('views_count'))
            ->when(in_array($sort, ['newest', 'latest'], true), fn ($q) => $q->orderByDesc('created_at'))
            ->when(! in_array($sort, ['rating', 'trending', 'views', 'popular', 'newest', 'latest'], true), fn ($q) => $q->orderByDesc('created_at'));
        $contents = $query->paginate(24)->withQueryString();

        // Populate filter dropdowns from actual data
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $genres     = Content::where('status', 'published')->whereNotNull('genre')
                        ->distinct()->orderBy('genre')->pluck('genre');
        $years      = Content::where('status', 'published')->whereNotNull('year')
                        ->distinct()->orderByDesc('year')->pluck('year');
        $types      = ['movie', 'series', 'anime', 'music', 'game', 'art', 'podcast', 'other'];

        // Active filters for chips display (non-null, non-sort values)
        $activeFilters = array_filter(
            array_merge($filters, ['search' => $search, 'sort' => $sort !== 'latest' ? $sort : null]),
            fn($v) => filled($v)
        );

        return view('explore.index', compact(
            'contents', 'categories', 'genres', 'years', 'types',
            'filters', 'search', 'sort', 'activeFilters'
        ));
    }

    public function search(Request $request)
    {
        $data = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        return response()->json(Content::query()->where('status', 'published')
            ->search($data['q'] ?? null)->orderByDesc('views_count')->limit(8)
            ->get(['id', 'title', 'slug', 'thumbnail', 'year'])
            ->map(fn ($content) => ['title' => $content->title, 'url' => route('contents.show', $content), 'thumbnail' => $content->thumbnailUrl(), 'year' => $content->year]));
    }
}
