<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::min(8)],
            'password_confirmation' => ['required', 'string', 'same:password'],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'password_confirmation.same' => 'The new passwords do not match.',
        ]);

        $saved = $request->user()->forceFill([
            // The User model's hashed cast applies Laravel's password hasher.
            'password' => $validated['password'],
            'password_changed_at' => now(),
        ])->save();

        if (! $saved) {
            return back()->withErrors([
                'password' => 'Something went wrong. Your password was not updated. Please try again.',
            ], 'updatePassword');
        }

        return back()->with('status', 'password-updated');
    }
}
