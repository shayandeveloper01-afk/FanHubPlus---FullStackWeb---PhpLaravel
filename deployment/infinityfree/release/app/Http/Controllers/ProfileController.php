<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->safe()->except('avatar');
        $previousAvatar = $user->avatar;
        $newAvatar = null;
        $avatarUpload = $request->file('avatar');

        if ($avatarUpload instanceof UploadedFile && ! $avatarUpload->isValid()) {
            return back()->withErrors(['avatar' => 'The profile picture upload failed. Please choose the image again.'])->withInput();
        }

        if ($request->hasFile('avatar')) {
            $newAvatar = $avatarUpload->storePublicly('profile-pictures', 'public');

            if (! $newAvatar || ! Storage::disk('public')->exists($newAvatar)) {
                if ($newAvatar) {
                    Storage::disk('public')->delete($newAvatar);
                }

                return back()->withErrors(['avatar' => 'The profile picture could not be saved. Please try again.'])->withInput();
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

            report($exception);

            return back()->withErrors(['avatar' => 'Your profile could not be saved. Please try again.'])->withInput();
        }

        if (! $saved || ($newAvatar && $user->fresh()->avatar !== $newAvatar)) {
            if ($newAvatar) {
                Storage::disk('public')->delete($newAvatar);
            }

            return back()->withErrors(['avatar' => 'Your profile picture could not be saved. Please try again.'])->withInput();
        }

        if ($newAvatar && $previousAvatar && $previousAvatar !== $newAvatar
            && (str_starts_with($previousAvatar, 'profile-pictures/') || str_starts_with($previousAvatar, 'avatars/'))) {
            Storage::disk('public')->delete($previousAvatar);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroyAvatar(Request $request): RedirectResponse|JsonResponse
    {
        $user = $request->user();
        $avatar = $user->avatar;
        $disk = Storage::disk('public');

        try {
            if ($avatar) {
                $user->forceFill(['avatar' => null]);

                if (! $user->save()) {
                    throw new \RuntimeException('The profile picture path could not be cleared.');
                }

                if ($disk->exists($avatar) && ! $disk->delete($avatar)) {
                    $user->forceFill(['avatar' => $avatar])->save();

                    throw new \RuntimeException('The profile picture file could not be deleted.');
                }
            }
        } catch (\Throwable $exception) {
            report($exception);

            $user->refresh();

            // Restore the database path if the file is still present after a failed delete.
            if ($avatar && $user->avatar === null && $disk->exists($avatar)) {
                try {
                    $user->forceFill(['avatar' => $avatar])->save();
                } catch (\Throwable $restoreException) {
                    report($restoreException);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'The profile picture could not be removed. Please try again.'], 500);
            }

            return Redirect::route('profile.edit')->withErrors(['avatar' => 'The profile picture could not be removed. Please try again.']);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your profile picture was removed.',
                'avatar_url' => $user->defaultAvatarUrl(),
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'avatar-deleted');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->is_admin || $user->role === 'admin') {
            return back()->withErrors([
                'account' => 'Administrator accounts cannot be deleted from profile settings. Ask another administrator to review this account.',
            ], 'userDeletion');
        }

        $avatar = $user->avatar;
        $disk = Storage::disk('public');
        $avatarContents = null;
        $avatarDeleted = false;

        try {
            if ($avatar && $disk->exists($avatar)) {
                $avatarContents = $disk->get($avatar);
            }

            DB::transaction(function () use ($user, $avatar, $disk, &$avatarDeleted): void {
                if ($avatar && $disk->exists($avatar)) {
                    $deleted = $disk->delete($avatar);
                    $avatarDeleted = ! $disk->exists($avatar);

                    if (! $deleted && ! $avatarDeleted) {
                        throw new \RuntimeException('The uploaded profile picture could not be deleted.');
                    }
                }

                // User uses SoftDeletes, so forceDelete is required to remove the
                // row and let the database apply its configured foreign-key rules.
                if (! $user->forceDelete()) {
                    throw new \RuntimeException('The account could not be deleted.');
                }
            });
        } catch (\Throwable $exception) {
            report($exception);

            if ($avatarDeleted && $avatarContents !== null && ! $disk->exists($avatar)) {
                if (! $disk->put($avatar, $avatarContents)) {
                    report(new \RuntimeException('The profile picture could not be restored after account deletion failed.'));
                }
            }

            return back()->withErrors([
                'account' => 'We could not delete your account right now. Your account is still active; please try again.',
            ], 'userDeletion');
        }

        // Laravel rotates a remembered user's token during logout by saving
        // the model. The row has already been hard-deleted, so clear the
        // in-memory token first to prevent logout from inserting it again.
        $user->setRememberToken(null);
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::route('login')->with('status', 'Your FanHub+ account has been permanently deleted.');
    }
}
