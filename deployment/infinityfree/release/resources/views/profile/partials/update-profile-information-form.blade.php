<header class="fh-profile-card__heading">
    <span class="fh-profile-card__icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 21a8 8 0 0 0-16 0m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg></span>
    <div><h2 id="profile-information-title">Profile information</h2><p class="fh-profile-card__intro">Update your public identity and account email.</p></div>
</header>

@if (session('status') === 'profile-updated')
    <div class="fh-profile-status" role="status" aria-live="polite"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/></svg><span>Your profile details were saved.</span></div>
@elseif (session('status') === 'avatar-deleted')
    <div class="fh-profile-status" role="status" aria-live="polite"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/></svg><span>Your profile picture was removed.</span></div>
@endif

<form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>
<form id="remove-avatar-form" method="post" action="{{ route('profile.avatar.destroy') }}" data-avatar-remove-form hidden>
    @csrf
    @method('delete')
</form>

<form id="profile-information-form" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
    @csrf
    @method('patch')

    <div class="fh-profile-avatar-row">
        <div class="fh-profile-avatar-shell">
            <img src="{{ $user->avatarUrl() }}" data-saved-src="{{ $user->avatarUrl() }}" data-fallback-src="{{ $user->defaultAvatarUrl() }}" data-profile-avatar-preview alt="Profile picture for {{ $user->name }}" class="fh-profile-avatar" onerror="this.onerror=null;this.src=this.dataset.fallbackSrc">
        </div>
        <div class="fh-profile-avatar-actions">
            <p class="fh-profile-avatar-copy">Profile picture</p>
            <label for="avatar" class="fh-profile-file-label">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 16V4m0 0L7 9m5-5 5 5M5 15v4a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-4"/></svg>
                <span data-avatar-upload-label>{{ $user->avatar ? 'Change profile picture' : 'Add profile picture' }}</span>
                <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="fh-profile-file-input" data-profile-avatar-input aria-label="Choose a profile picture" aria-describedby="avatar-help avatar-error">
            </label>
            @if ($user->avatar)
                <button form="remove-avatar-form" type="submit" class="fh-profile-button--danger" data-avatar-remove-submit>
                    <span class="fh-profile-button__text">Remove picture</span>
                    <span class="fh-profile-button__spinner" aria-hidden="true"></span>
                </button>
            @endif
            <p class="fh-profile-help fh-profile-field--full" id="avatar-help">JPG, JPEG, PNG, or WebP · Maximum 2 MB. Your picture appears in your navbar and account areas.</p>
            <span class="fh-profile-avatar-status" data-profile-avatar-status role="status" aria-live="polite"></span>
            <span class="fh-profile-upload-progress" data-profile-upload-progress role="progressbar" aria-label="Profile picture upload in progress" aria-valuetext="Upload in progress"><span></span></span>
        </div>
    </div>
    @error('avatar')<p class="fh-profile-error" id="avatar-error" role="alert">{{ $message }}</p>@enderror

    <div class="fh-profile-grid">
        <div class="fh-profile-field">
            <label for="name" class="fh-profile-label">Name</label>
            <input id="name" name="name" type="text" class="fh-profile-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" maxlength="255" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" aria-describedby="name-error">
            @error('name')<p id="name-error" class="fh-profile-error" role="alert">{{ $message }}</p>@enderror
        </div>
        <div class="fh-profile-field">
            <label for="email" class="fh-profile-label">Email address</label>
            <input id="email" name="email" type="email" class="fh-profile-input" value="{{ old('email', $user->email) }}" required autocomplete="email" maxlength="255" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error">
            @error('email')<p id="email-error" class="fh-profile-error" role="alert">{{ $message }}</p>@enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-1">
                    <p class="fh-profile-help">Your email address is not verified yet.</p>
                    <button form="send-verification" type="submit" class="mt-1 text-left text-xs font-semibold text-violet-300 underline decoration-violet-400/40 underline-offset-4 transition hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-violet-300">Resend verification email</button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-xs font-medium text-emerald-300" role="status">A new verification link has been sent to your email.</p>
                    @endif
                </div>
            @else
                <p class="fh-profile-help">Your email address is verified.</p>
            @endif
        </div>
    </div>

    <div class="fh-profile-actions">
        <button type="submit" class="fh-profile-button" data-profile-submit>
            <span class="fh-profile-button__text">Save profile</span>
            <span class="fh-profile-button__spinner" aria-hidden="true"></span>
        </button>
        <span class="fh-profile-help">Changes are saved to your FanHub+ account.</span>
    </div>
</form>

<div class="fh-profile-avatar-toast" data-avatar-toast role="status" aria-live="polite" hidden></div>
