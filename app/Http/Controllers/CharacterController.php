<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    public function store(Request $request, Content $content): RedirectResponse
    {
        $this->authorize('update', $content);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'alias'       => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'role'        => ['required', 'in:protagonist,antagonist,supporting,other'],
            'order_index' => ['nullable', 'integer', 'min:0'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        $content->characters()->create($data);

        return back()->with('success', 'Character added.');
    }

    public function destroy(Request $request, Content $content, Character $character): RedirectResponse
    {
        $this->authorize('update', $content);
        $character = $content->characters()->findOrFail($character->id);

        if ($character->image) {
            Storage::disk('public')->delete($character->image);
        }
        $character->delete();

        return back()->with('success', 'Character removed.');
    }
}
