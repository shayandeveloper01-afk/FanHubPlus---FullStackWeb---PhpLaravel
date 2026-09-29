<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Character;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CharacterController extends Controller
{
    public function index(Request $request): View
    {
        $characters = Character::with('content')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%$s%"))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.characters.index', compact('characters'));
    }

    public function create(): View
    {
        $contents = Content::orderBy('title')->get();
        return view('admin.characters.create', compact('contents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'content_id'  => 'required|exists:contents,id',
            'name'        => 'required|string|max:255',
            'alias'       => 'nullable|string|max:255',
            'role'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('characters', 'public');
        Character::create($data);
        return redirect()->route('admin.characters.index')->with('success', 'Character created.');
    }

    public function edit(Character $character): View
    {
        $contents = Content::orderBy('title')->get();
        return view('admin.characters.edit', compact('character', 'contents'));
    }

    public function update(Request $request, Character $character): RedirectResponse
    {
        $data = $request->validate([
            'content_id'  => 'required|exists:contents,id',
            'name'        => 'required|string|max:255',
            'alias'       => 'nullable|string|max:255',
            'role'        => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'nullable|boolean',
        ]);
        $oldImage = $character->image;
        if ($request->hasFile('image')) $data['image'] = $request->file('image')->store('characters', 'public');
        elseif ($request->boolean('remove_image')) $data['image'] = null;
        $character->update($data);
        if ($oldImage && $oldImage !== $character->image && !filter_var($oldImage, FILTER_VALIDATE_URL)) Storage::disk('public')->delete($oldImage);
        return redirect()->route('admin.characters.index')->with('success', 'Character updated.');
    }

    public function destroy(Character $character): RedirectResponse
    {
        $character->delete();
        return back()->with('success', 'Character deleted.');
    }
}
