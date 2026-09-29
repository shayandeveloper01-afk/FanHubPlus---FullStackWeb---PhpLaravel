<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMerchandiseRequest;
use App\Http\Requests\UpdateMerchandiseRequest;
use App\Models\Category;
use App\Models\Merchandise;
use App\Models\MerchandiseImage;
use App\Models\MerchandiseTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MerchandiseController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['category', 'tag']);
        $sort    = $request->input('sort', 'latest');

        $items = Merchandise::with(['category', 'tags'])
            ->where('status', 'active')
            ->filter($filters)
            ->sort($sort)
            ->paginate(18)
            ->withQueryString();

        $categories = Category::where('status', 'active')->orderBy('name')->get();
        $tags       = MerchandiseTag::orderBy('name')->get();

        $activeFilters = array_filter(
            array_merge($filters, ['sort' => $sort !== 'latest' ? $sort : null]),
            fn($v) => filled($v)
        );

        return view('merchandise.index', compact('items', 'categories', 'tags', 'filters', 'sort', 'activeFilters'));
    }

    public function show(Request $request, Merchandise $merchandise): View
    {
        abort_if(! $merchandise->isActive() && $merchandise->user_id !== auth()->id(), 404);

        $sessionKey = 'viewed_merch_' . $merchandise->id;
        if (! session()->has($sessionKey)) {
            $merchandise->increment('views_count');
            session()->put($sessionKey, true);
        }

        $merchandise->load(['category', 'tags', 'images', 'content', 'user']);

        return view('merchandise.show', compact('merchandise'));
    }

    public function create(): View
    {
        return view('merchandise.create', [
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
            'tags'       => MerchandiseTag::orderBy('name')->get(),
        ]);
    }

    public function store(StoreMerchandiseRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'gallery', 'tags']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('merchandise', 'public');
        }

        $merch = $request->user()->merchandise()->create($data);

        // Gallery images
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $i => $file) {
                $path = $file->store('merchandise', 'public');
                $merch->images()->create(['image_path' => $path, 'sort_order' => $i]);
            }
        }

        // Tags
        if ($request->filled('tags')) {
            $merch->tags()->sync($request->tags);
        }

        return redirect()->route('merchandise.index')
            ->with('success', 'Merchandise created successfully.');
    }

    public function edit(Merchandise $merchandise): View
    {
        $this->authorize('update', $merchandise);

        return view('merchandise.edit', [
            'merchandise' => $merchandise->load(['tags', 'images']),
            'categories'  => Category::where('status', 'active')->orderBy('name')->get(),
            'tags'        => MerchandiseTag::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateMerchandiseRequest $request, Merchandise $merchandise): RedirectResponse
    {
        $data = $request->safe()->except(['image', 'gallery', 'tags']);

        if ($request->hasFile('image')) {
            if ($merchandise->image) {
                Storage::disk('public')->delete($merchandise->image);
            }
            $data['image'] = $request->file('image')->store('merchandise', 'public');
        }

        $merchandise->update($data);

        // New gallery images (appended, not replaced)
        if ($request->hasFile('gallery')) {
            $nextOrder = $merchandise->images()->max('sort_order') + 1;
            foreach ($request->file('gallery') as $i => $file) {
                $path = $file->store('merchandise', 'public');
                $merchandise->images()->create(['image_path' => $path, 'sort_order' => $nextOrder + $i]);
            }
        }

        $merchandise->tags()->sync($request->input('tags', []));

        return redirect()->route('merchandise.index')
            ->with('success', 'Merchandise updated.');
    }

    public function destroyImage(Merchandise $merchandise, MerchandiseImage $image): RedirectResponse
    {
        $this->authorize('update', $merchandise);
        $image = $merchandise->images()->findOrFail($image->id);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function destroy(Merchandise $merchandise): RedirectResponse
    {
        $this->authorize('delete', $merchandise);

        // Delete all stored files
        if ($merchandise->image) {
            Storage::disk('public')->delete($merchandise->image);
        }
        foreach ($merchandise->images as $img) {
            Storage::disk('public')->delete($img->image_path);
        }

        $merchandise->delete();

        return redirect()->route('merchandise.index')
            ->with('success', 'Merchandise deleted.');
    }
}
