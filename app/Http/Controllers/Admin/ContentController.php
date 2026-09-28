<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\Category;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentController extends Controller
{
    use LogsAdminActivity;
    public function index(Request $request): View
    {
        $contents = Content::withTrashed()->with(['user', 'category'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->when($request->category, fn($q, $v) => $q->where('category_id', $v))
            ->when($request->status, fn($q, $v) => $v === 'trashed' ? $q->onlyTrashed() : $q->where('status', $v))
            ->latest()->paginate(20)->withQueryString();

        $categories = Category::orderBy('name')->get();
        return view('admin.contents.index', compact('contents', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.contents.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|string',
            'genre'       => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'body'        => 'required|string',
            'status'      => 'required|in:draft,published',
        ]);
        $data['user_id'] = auth()->id();
        Content::create($data);
        return redirect()->route('admin.contents.index')->with('success', 'Content created.');
    }

    public function edit(Content $content): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.contents.edit', compact('content', 'categories'));
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type'        => 'required|string',
            'genre'       => 'nullable|string|max:100',
            'year'        => 'nullable|integer|min:1900|max:' . (date('Y') + 2),
            'body'        => 'required|string',
            'status'      => 'required|in:draft,published',
        ]);
        $content->update($data);
        return redirect()->route('admin.contents.index')->with('success', 'Content updated.');
    }

    public function destroy(Content $content): RedirectResponse
    {
        $this->auditLog('content.delete', 'Content', $content->id, "Deleted: {$content->title}");
        $content->delete();
        return back()->with('success', 'Content soft-deleted.');
    }

    public function restore(int $id): RedirectResponse
    {
        Content::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Content restored.');
    }
}
