<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->except('avatar');
        $previousAvatar = $user->avatar;
        $newAvatar = null;

        if ($request->hasFile('avatar')) {
            $newAvatar = $request->file('avatar')->storePublicly('avatars', 'public');

            if (! $newAvatar || ! Storage::disk('public')->exists($newAvatar)) {
                if ($newAvatar) {
                    Storage::disk('public')->delete($newAvatar);
                }

                return redirect()->route('admin.profile.index')->withErrors(['avatar' => 'The profile picture could not be saved. Please try again.']);
            }

            $data['avatar'] = $newAvatar;
        }

        $user->fill($data);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        try {
            $saved = $user->save();
        } catch (\Throwable $exception) {
            if ($newAvatar) {
                Storage::disk('public')->delete($newAvatar);
            }

            throw $exception;
        }

        if (! $saved || ($newAvatar && $user->fresh()->avatar !== $newAvatar)) {
            if ($newAvatar) {
                Storage::disk('public')->delete($newAvatar);
            }

            return redirect()->route('admin.profile.index')->withErrors(['avatar' => 'The profile picture could not be saved. Please try again.']);
        }

        if ($newAvatar && $previousAvatar && $previousAvatar !== $newAvatar) {
            Storage::disk('public')->delete($previousAvatar);
        }

        return redirect()->route('admin.profile.index')->with('success', 'Profile details updated.');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8)],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'password_confirmation.same' => 'The new passwords do not match.',
        ]);

        $request->user()->forceFill([
            'password' => Hash::make($data['password']),
            'password_changed_at' => now(),
        ])->save();

        return redirect()->route('admin.profile.index')->with('success', 'Password updated.');
    }
}
