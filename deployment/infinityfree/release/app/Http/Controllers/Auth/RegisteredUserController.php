<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $avatarPath = $request->hasFile('avatar')
            ? $request->file('avatar')->storePublicly('avatars', 'public')
            : null;

        if ($request->hasFile('avatar') && ! $avatarPath) {
            throw ValidationException::withMessages([
                'avatar' => 'The profile picture could not be saved. Please try again.',
            ]);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
                'email_verified_at' => now(),
                'avatar' => $avatarPath,
            ]);
        } catch (\Throwable $exception) {
            if ($avatarPath) {
                Storage::disk('public')->delete($avatarPath);
            }

            throw $exception;
        }

        // event(new Registered($user)); // skipped — email verification disabled

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
