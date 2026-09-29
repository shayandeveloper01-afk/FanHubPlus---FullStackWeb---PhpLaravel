<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Services\HtmlPurifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $articles = Article::withTrashed()->with('user')
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->when($request->status, fn($q, $v) => $v === 'trashed' ? $q->onlyTrashed() : $q->where('status', $v))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.articles.index', compact('articles'));
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'excerpt'     => 'nullable|string|max:500',
            'body'        => 'required|string',
            'status'      => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'remove_cover_image' => 'nullable|boolean',
        ]);
        $data['body'] = HtmlPurifier::clean($data['body']);
        $data['is_featured'] = $request->boolean('is_featured');
        $oldCover = $article->cover_image;
        if ($request->hasFile('cover_image')) $data['cover_image'] = $request->file('cover_image')->store('article-covers', 'public');
        elseif ($request->boolean('remove_cover_image')) $data['cover_image'] = null;
        $article->update($data);
        if ($oldCover && $oldCover !== $article->cover_image && !filter_var($oldCover, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldCover);
        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();
        return back()->with('success', 'Article soft-deleted.');
    }

    public function restore(int $id): RedirectResponse
    {
        Article::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Article restored.');
    }
}
