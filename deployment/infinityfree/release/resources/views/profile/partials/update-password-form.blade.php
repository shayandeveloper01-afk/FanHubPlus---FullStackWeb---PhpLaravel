<header class="fh-profile-card__heading">
    <span class="fh-profile-card__icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Zm10-10V7a4 4 0 0 0-8 0v4h8Z"/></svg></span>
    <div><h2 id="update-password-title">Update password</h2><p class="fh-profile-card__intro">Use a unique, strong password to keep your account secure.</p></div>
</header>

@if (session('status') === 'password-updated')
    <div class="fh-profile-status" role="status" aria-live="polite"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/></svg><span>Password updated successfully.</span></div>
@endif
@if ($errors->updatePassword->has('password') && ! $errors->updatePassword->has('current_password'))
    <div class="fh-profile-error" role="alert" aria-live="assertive">{{ $errors->updatePassword->first('password') }}</div>
@endif

<form method="post" action="{{ route('profile.password.update') }}" id="profile-password-form" class="space-y-4">
    @csrf
    @method('put')

    @foreach ([
        ['id' => 'update_password_current_password', 'name' => 'current_password', 'label' => __('Current password'), 'autocomplete' => 'current-password', 'error' => 'current_password'],
        ['id' => 'profile-new-password', 'name' => 'password', 'label' => __('New password'), 'autocomplete' => 'new-password', 'error' => 'password'],
        ['id' => 'profile-password-confirmation', 'name' => 'password_confirmation', 'label' => __('Confirm new password'), 'autocomplete' => 'new-password', 'error' => 'password_confirmation'],
    ] as $field)
        <div class="fh-profile-field">
            <label for="{{ $field['id'] }}" class="fh-profile-label">{{ $field['label'] }}</label>
            <div class="fh-profile-password-wrap">
                <input id="{{ $field['id'] }}" name="{{ $field['name'] }}" type="password" class="fh-profile-input" autocomplete="{{ $field['autocomplete'] }}" required @if ($field['name'] === 'password') data-label="new password" @elseif ($field['name'] === 'current_password') data-label="current password" @else data-label="password confirmation" @endif aria-invalid="{{ $errors->updatePassword->has($field['error']) ? 'true' : 'false' }}" aria-describedby="{{ $field['id'] }}-error">
                <button type="button" class="fh-profile-eye" data-profile-password-toggle="{{ $field['id'] }}" aria-label="Show {{ strtolower($field['label']) }}" aria-pressed="false">
                    <svg data-eye-show fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.3-7 9.5-7 9.5 7 9.5 7-3.3 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.8"/></svg>
                    <svg data-eye-hide fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" hidden><path stroke="currentColor" stroke-linecap="round" stroke-width="1.8" d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9.9 5.2A10.6 10.6 0 0 1 12 5c6.2 0 9.5 7 9.5 7a11.4 11.4 0 0 1-3 4.1M6.2 6.2A11.2 11.2 0 0 0 2.5 12s3.3 7 9.5 7c1 0 2-.2 2.9-.5"/></svg>
                </button>
            </div>
            @if ($field['name'] === 'password')
                <div class="fh-profile-strength" data-profile-password-strength data-strength="0" role="meter" aria-label="New password strength" aria-valuemin="0" aria-valuemax="4" aria-valuenow="0">
                    <div class="fh-profile-strength__track" aria-hidden="true"><span class="fh-profile-strength__segment"></span><span class="fh-profile-strength__segment"></span><span class="fh-profile-strength__segment"></span><span class="fh-profile-strength__segment"></span></div>
                    <span class="fh-profile-strength__label" data-profile-password-strength-label>Not set</span>
                </div>
            @elseif ($field['name'] === 'password_confirmation')
                <p class="fh-profile-match" data-profile-password-match aria-live="polite"></p>
            @endif
            @if ($errors->updatePassword->has($field['error']))
                <p id="{{ $field['id'] }}-error" class="fh-profile-error" role="alert">{{ $errors->updatePassword->first($field['error']) }}</p>
            @endif
        </div>
    @endforeach

    <div class="fh-profile-actions">
        <button type="submit" class="fh-profile-button"><span class="fh-profile-button__text">Update password</span><span class="fh-profile-button__loading" hidden>Updating password...</span><span class="fh-profile-button__spinner" aria-hidden="true"></span></button>
    </div>
</form>

<aside class="fh-profile-security" aria-label="Password security status">
    <span class="fh-profile-security__icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3 5 6v5c0 4.5 2.9 8.1 7 10 4.1-1.9 7-5.5 7-10V6l-7-3Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 12 2 2 4-4"/></svg></span>
    <div class="fh-profile-security__body">
        <p class="fh-profile-security__eyebrow">Security status</p>
        <p class="fh-profile-security__label">Last password changed</p>
        <p class="fh-profile-security__value">{{ $user->password_changed_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'Never' }}</p>
        <p class="fh-profile-security__note">Your password is securely hashed and protected.</p>
    </div>
</aside>
