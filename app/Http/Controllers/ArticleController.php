<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Services\HtmlPurifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('user')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('articles.create', [
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'body'        => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $data['body'] = HtmlPurifier::clean($data['body']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        $request->user()->articles()->create($data);

        return redirect()->route('articles.index')->with('success', 'Article saved.');
    }

    public function show(Article $article): View
    {
        abort_if(! $article->isPublished() && $article->user_id !== auth()->id(), 404);
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article): View
    {
        $this->authorize('update', $article);
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $this->authorize('update', $article);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'excerpt'     => ['nullable', 'string', 'max:500'],
            'body'        => ['required', 'string'],
            'status'      => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $data['body'] = HtmlPurifier::clean($data['body']);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorize('delete', $article);

        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Article deleted.');
    }
}
