<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FandomProfileController extends Controller
{
    /** GET /profiles — profile selection screen shown after login */
    public function index(): View
    {
        $profiles = auth()->user()->profiles()->orderBy('created_at')->get();

        return view('profiles.index', compact('profiles'));
    }

    /** POST /profiles — create a new profile */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'   => 'required|string|max:50',
            'is_kid' => 'boolean',
            'fandom_tags' => 'nullable|array|max:20',
            'fandom_tags.*' => 'string|max:40',
            'avatar_url' => 'nullable|url|max:500',
        ]);

        $profile = auth()->user()->profiles()->create([
            'name'   => $request->name,
            'is_kid' => $request->boolean('is_kid'),
            'fandom_tags' => $request->input('fandom_tags', []),
            'avatar_url' => $request->input('avatar_url'),
            'sort_order' => (int) auth()->user()->profiles()->count(),
        ]);

        // Auto-select the newly created profile
        session(['active_profile_id' => $profile->id]);

        return redirect()->route('home');
    }

    /** POST /profiles/{profile}/select — switch active profile */
    public function select(Profile $profile): RedirectResponse
    {
        // Ensure the profile belongs to the authenticated user
        abort_unless($profile->user_id === auth()->id(), 403);

        session(['active_profile_id' => $profile->id]);

        return redirect()->intended(route('home'));
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        abort_unless($profile->user_id === $request->user()->id, 403);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'fandom_tags' => ['nullable', 'array', 'max:20'],
            'fandom_tags.*' => ['string', 'max:40'],
            'is_kid' => ['boolean'],
            'avatar_url' => ['nullable', 'url', 'max:500'],
        ]);
        $profile->update($data);
        return back()->with('success', 'Profile updated.');
    }

    /** DELETE /profiles/{profile} — remove a profile */
    public function destroy(Profile $profile): RedirectResponse
    {
        abort_unless($profile->user_id === auth()->id(), 403);

        // Clear session if deleting the active profile
        if (session('active_profile_id') === $profile->id) {
            session()->forget('active_profile_id');
        }

        $profile->delete();

        return redirect()->route('profiles.index');
    }
}
