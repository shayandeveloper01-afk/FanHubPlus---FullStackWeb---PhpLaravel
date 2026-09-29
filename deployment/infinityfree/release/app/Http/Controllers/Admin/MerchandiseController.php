<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\LogsAdminActivity;
use App\Models\Category;
use App\Models\Merchandise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MerchandiseController extends Controller
{
    use LogsAdminActivity;

    public function index(Request $request): View
    {
        $merchandise = Merchandise::withTrashed()->with(['user', 'category'])
            ->when($request->search, fn($q, $s) => $q->where('title', 'like', "%$s%"))
            ->when($request->status, fn($q, $v) => $v === 'trashed' ? $q->onlyTrashed() : $q->where('status', $v))
            ->latest()->paginate(20)->withQueryString();

        $categories = Category::orderBy('name')->get();
        return view('admin.merchandise.index', compact('merchandise', 'categories'));
    }

    public function edit(Merchandise $merchandise): View
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.merchandise.edit', compact('merchandise', 'categories'));
    }

    public function update(Request $request, Merchandise $merchandise): RedirectResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'required|string|max:10',
            'status'      => 'required|in:active,inactive',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'remove_image' => 'nullable|boolean',
        ]);
        $oldImage = $merchandise->image;
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('merchandise', 'public');
        elseif ($request->boolean('remove_image')) $data['image'] = null;
        $merchandise->update($data);
        if ($oldImage && $oldImage !== $merchandise->image && !filter_var($oldImage, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldImage);
        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise updated.');
    }

    public function destroy(Merchandise $merchandise): RedirectResponse
    {
        $this->auditLog('merchandise.delete', 'Merchandise', $merchandise->id, "Removed listing: {$merchandise->title}");
        $merchandise->delete();
        return back()->with('success', 'Merchandise soft-deleted.');
    }

    public function moderate(Merchandise $merchandise): RedirectResponse
    {
        $nextStatus = $merchandise->status === 'active' ? 'inactive' : 'active';
        $merchandise->update(['status' => $nextStatus]);
        $this->auditLog('merchandise.moderate', 'Merchandise', $merchandise->id, "Set {$merchandise->title} to {$nextStatus}");

        return back()->with('success', $nextStatus === 'inactive'
            ? 'Shop listing deactivated.'
            : 'Shop listing reactivated.');
    }

    public function restore(int $id): RedirectResponse
    {
        Merchandise::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Merchandise restored.');
    }
}
