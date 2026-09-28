<x-admin-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-white">My Profile</h1>
            <p class="text-sm text-gray-400 mt-1">Update your admin account details and password.</p>
        </div>
    </x-slot>

    <div class="max-w-3xl space-y-6">
        <section class="bg-gray-900 border border-gray-800 rounded-xl p-5 sm:p-7">
            <h2 class="text-base font-semibold text-white">Account details</h2>
            <p class="text-sm text-gray-400 mt-1 mb-6">These details are used on your account and in the admin header.</p>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-4">
                    <img src="{{ $user->avatarUrl() }}" alt="Current profile photo" class="h-16 w-16 rounded-full object-cover border border-gray-700">
                    <div class="flex-1">
                        <label for="avatar" class="block text-sm font-medium text-gray-300">Profile photo</label>
                        <input id="avatar" name="avatar" type="file" accept="image/jpeg,image/png,image/webp"
                               class="mt-2 block w-full text-sm text-gray-400 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-700 file:px-3 file:py-2 file:text-white hover:file:bg-gray-600">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG, or WebP; up to 2 MB.</p>
                    <x-input-error :messages="$errors->get('avatar')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required maxlength="255" autocomplete="name"
                           class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required maxlength="255" autocomplete="email"
                           class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    @if ($user->email_verified_at)
                        <p class="mt-2 text-xs text-green-400">Email verified</p>
                    @else
                        <p class="mt-2 text-xs text-amber-400">Email is not verified. Changing it requires verification again.</p>
                    @endif
                </div>

                <div class="flex justify-end border-t border-gray-800 pt-5">
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">Save profile</button>
                </div>
            </form>
            <div class="mt-5 rounded-xl border border-violet-400/15 bg-gradient-to-r from-violet-500/10 to-pink-500/5 p-4" aria-label="Password security status">
                <p class="text-xs font-semibold uppercase tracking-[.14em] text-violet-300">Security status</p>
                <p class="mt-2 text-xs text-gray-400">Last password changed</p>
                <p class="mt-1 text-sm font-semibold text-white">{{ $user->password_changed_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'Never' }}</p>
                <p class="mt-1 text-xs text-gray-500">Your password is securely hashed and protected.</p>
            </div>
        </section>

        <section class="bg-gray-900 border border-gray-800 rounded-xl p-5 sm:p-7">
            <h2 class="text-base font-semibold text-white">Change password</h2>
            <p class="text-sm text-gray-400 mt-1 mb-6">Confirm your current password before choosing a new one.</p>

            <form method="POST" action="{{ route('admin.profile.password.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300">Current password</label>
                    <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                           class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">New password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-lg border-gray-700 bg-gray-800 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex justify-end border-t border-gray-800 pt-5">
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">Update password</button>
                </div>
            </form>
        </section>
    </div>
</x-admin-layout>
