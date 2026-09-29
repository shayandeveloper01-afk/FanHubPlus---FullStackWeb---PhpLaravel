<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $slugs = ['anime', 'comics', 'cosplay', 'gaming', 'manga', 'movies', 'tv-series'];
        $categories = Category::where('status', 'active')
            ->whereIn('slug', $slugs)
            ->with(['contents' => fn ($query) => $query
                ->where('status', 'published')
                ->with('category')
                ->orderByDesc('views_count')
                ->limit(1)])
            ->withCount(['contents' => fn ($query) => $query->where('status', 'published')])
            ->get()
            ->sortBy(fn (Category $category) => array_search($category->slug, $slugs, true))
            ->values();

        return view('categories.index', compact('categories'));
    }

    public function show(Category $category): View
    {
        abort_unless($category->status === 'active', 404);
        $contents = $category->contents()->where('status', 'published')->with(['category', 'user'])->latest()->paginate(24);
        return view('categories.show', compact('category', 'contents'));
    }
}
