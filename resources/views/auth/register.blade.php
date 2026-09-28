<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create your account — FanHub+</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('auth.partials.styles')
    <style>
        .fh-register-avatar{display:flex;align-items:center;gap:.9rem;padding:.8rem;border:1px solid rgba(196,181,253,.14);border-radius:1rem;background:linear-gradient(135deg,rgba(139,92,246,.08),rgba(255,255,255,.02));transition:border-color .2s,box-shadow .2s,transform .2s}
        .fh-register-avatar:hover{border-color:rgba(168,85,247,.38);box-shadow:0 8px 24px -16px rgba(139,92,246,.65);transform:translateY(-1px)}
        .fh-register-avatar__preview{width:3.8rem;height:3.8rem;flex:none;border:2px solid rgba(196,181,253,.4);border-radius:50%;object-fit:cover;background:#211936;box-shadow:0 0 0 4px rgba(139,92,246,.1),0 0 22px rgba(139,92,246,.2);transition:box-shadow .2s,transform .2s}
        .fh-register-avatar:hover .fh-register-avatar__preview{transform:scale(1.04);box-shadow:0 0 0 4px rgba(139,92,246,.16),0 0 28px rgba(236,72,153,.24)}
        .fh-register-avatar__copy{min-width:0;flex:1}.fh-register-avatar__title{color:#e9e4f3;font-size:.8rem;font-weight:600}.fh-register-avatar__hint{margin-top:.18rem;color:#888398;font-size:.7rem;line-height:1.4}
        .fh-register-avatar__input{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        .fh-register-avatar__control{position:relative;display:inline-flex;align-items:center;justify-content:center;min-height:2.25rem;padding:.48rem .72rem;border:1px solid rgba(168,85,247,.3);border-radius:.65rem;background:rgba(139,92,246,.13);color:#ddd2ff;font-size:.72rem;font-weight:600;white-space:nowrap;cursor:pointer;transition:background .2s,border-color .2s,box-shadow .2s}
        .fh-register-avatar__control:hover{background:rgba(139,92,246,.23);border-color:rgba(192,132,252,.65);color:#fff}.fh-register-avatar__input:focus-visible + .fh-register-avatar__control{outline:none;box-shadow:0 0 0 3px rgba(139,92,246,.24)}
        .fh-register-avatar__input[aria-invalid="true"] + .fh-register-avatar__control{border-color:rgba(248,113,113,.75)}
        @media(max-width:390px){.fh-register-avatar{gap:.65rem;padding:.65rem}.fh-register-avatar__preview{width:3.25rem;height:3.25rem}.fh-register-avatar__control{padding:.45rem .55rem;font-size:.68rem}}
        @media(prefers-reduced-motion:reduce){.fh-register-avatar,.fh-register-avatar__preview,.fh-register-avatar__control{transition-duration:.01ms!important}}
    </style>
</head>
<body class="fh-auth-body fh-auth-body--register">
    <div class="fh-auth-bg" aria-hidden="true">
        <div class="fh-auth-orb fh-auth-orb--1"></div>
        <div class="fh-auth-orb fh-auth-orb--2"></div>
        <div class="fh-auth-orb fh-auth-orb--3"></div>
    </div>

    <a href="{{ route('home') }}" class="fh-auth-back" aria-label="Back to FanHub Plus home">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to home
    </a>

    <main class="fh-auth-wrap" aria-labelledby="register-heading">
        <aside class="fh-auth-brand" aria-label="About FanHub Plus">
            <div class="fh-auth-brand__orb-a" aria-hidden="true"></div>
            <div class="fh-auth-brand__orb-b" aria-hidden="true"></div>
            <a href="{{ route('home') }}" class="fh-auth-logo" aria-label="FanHub Plus home">
                <x-fh-logo-mark class="fh-auth-logo__mark" />
                <span class="fh-auth-logo__text">FanHub<span>+</span></span>
            </a>

            <div class="fh-auth-brand__body">
                <p class="fh-auth-brand__tagline">Find your next<br><span>favorite fandom.</span></p>
                <p class="mb-5 text-sm leading-6 text-gray-400">Join a community built around the stories, worlds, and creativity you love.</p>
                <ul class="fh-auth-features">
                    <li><span class="fh-auth-feat-icon" aria-hidden="true">✦</span>Discover entertainment across fandoms</li>
                    <li><span class="fh-auth-feat-icon" aria-hidden="true">♡</span>Save and rate the titles you love</li>
                    <li><span class="fh-auth-feat-icon" aria-hidden="true">⌁</span>Find community events and fan creations</li>
                </ul>
                <div class="fh-register-art" aria-hidden="true">
                    <span class="fh-register-art__center"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 2.8 14.2 9l6.5.2-5.1 4 1.8 6.3-5.4-3.7-5.4 3.7 1.8-6.3-5.1-4L9.8 9 12 2.8Z"/></svg></span>
                    <span class="fh-register-art__caption">Your fandom, your hub</span>
                </div>
            </div>
            <p class="fh-auth-brand__footer">&copy; {{ date('Y') }} FanHub Plus</p>
        </aside>

        <section class="fh-auth-form-panel fh-auth-form-panel--register">
            <h1 class="fh-auth-heading" id="register-heading">Create your account</h1>
            <p class="fh-auth-subheading">Welcome to FanHub+. Your next great discovery starts here.</p>

            <form method="POST" action="{{ route('register') }}" id="fh-register-form" enctype="multipart/form-data">
                @csrf

                <div class="fh-auth-field">
                    <label for="avatar" class="fh-auth-label">Profile picture <span style="font-weight:400;color:#777286">(optional)</span></label>
                    <div class="fh-register-avatar" id="fh-register-avatar-control">
                        <img id="fh-register-avatar-preview" class="fh-register-avatar__preview" src="{{ asset('images/fanhub-avatar.svg') }}" alt="Profile picture preview">
                        <div class="fh-register-avatar__copy">
                            <p class="fh-register-avatar__title">Make your profile yours</p>
                            <p class="fh-register-avatar__hint" id="avatar-help">JPG, PNG, or WebP · up to 2 MB</p>
                        </div>
                        <input class="fh-register-avatar__input" id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" aria-describedby="avatar-help avatar-error" aria-invalid="{{ $errors->has('avatar') ? 'true' : 'false' }}">
                        <label for="avatar" class="fh-register-avatar__control">Choose profile picture</label>
                    </div>
                    <p id="avatar-error" class="fh-auth-error" role="alert" aria-live="polite" @if (! $errors->has('avatar')) hidden @endif>@error('avatar'){{ $message }}@enderror</p>
                </div>

                <div class="fh-auth-field">
                    <label for="name" class="fh-auth-label">Name</label>
                    <div class="fh-auth-input-wrap">
                        <span class="fh-auth-input-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21a8 8 0 0 0-16 0m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"/></svg></span>
                        <input id="name" type="text" name="name" class="fh-auth-input @error('name') border-red-400 @enderror" value="{{ old('name') }}" placeholder="Your name" required autofocus autocomplete="name" maxlength="255" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" aria-describedby="name-error">
                    </div>
                    @error('name')<p id="name-error" class="fh-auth-error" role="alert">{{ $message }}</p>@enderror
                </div>

                <div class="fh-auth-field">
                    <label for="email" class="fh-auth-label">Email address</label>
                    <div class="fh-auth-input-wrap">
                        <span class="fh-auth-input-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"/></svg></span>
                        <input id="email" type="email" name="email" class="fh-auth-input" value="{{ old('email') }}" placeholder="you@example.com" required autocomplete="username" maxlength="255" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error">
                    </div>
                    @error('email')<p id="email-error" class="fh-auth-error" role="alert">{{ $message }}</p>@enderror
                </div>

                <div class="fh-auth-field">
                    <label for="password" class="fh-auth-label">Password</label>
                    <div class="fh-auth-input-wrap">
                        <span class="fh-auth-input-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2Zm10-10V7a4 4 0 0 0-8 0v4h8Z"/></svg></span>
                        <input id="password" type="password" name="password" class="fh-auth-input fh-auth-input--has-trail" placeholder="At least 8 characters" required minlength="8" autocomplete="new-password" aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}" aria-describedby="password-strength password-error">
                        <button type="button" class="fh-auth-eye" data-auth-password-toggle="password" aria-label="Show password" aria-pressed="false">
                            <svg data-eye-show fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/></svg>
                            <svg data-eye-hide fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.9 5.2A10.6 10.6 0 0 1 12 5c4.5 0 8.3 2.9 9.5 7a10.6 10.6 0 0 1-3 4.4M6.2 6.2A10.7 10.7 0 0 0 2.5 12c1.3 4.1 5.1 7 9.5 7 1 0 2-.2 2.9-.5"/></svg>
                        </button>
                    </div>
                    <div class="fh-auth-strength" id="password-strength" data-strength="0" role="meter" aria-label="Password strength" aria-valuemin="0" aria-valuemax="4" aria-valuenow="0">
                        <div class="fh-auth-strength__track" aria-hidden="true"><span class="fh-auth-strength__segment"></span><span class="fh-auth-strength__segment"></span><span class="fh-auth-strength__segment"></span><span class="fh-auth-strength__segment"></span></div>
                        <span class="fh-auth-strength__label" id="password-strength-label">Enter a password</span>
                    </div>
                    @error('password')<p id="password-error" class="fh-auth-error" role="alert">{{ $message }}</p>@enderror
                </div>

                <div class="fh-auth-field">
                    <label for="password_confirmation" class="fh-auth-label">Confirm password</label>
                    <div class="fh-auth-input-wrap">
                        <span class="fh-auth-input-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.5 11 14.5l4-5m5-1.5v4a8 8 0 0 1-16 0v-4a8 8 0 0 1 16 0Z"/></svg></span>
                        <input id="password_confirmation" type="password" name="password_confirmation" class="fh-auth-input fh-auth-input--has-trail" placeholder="Re-enter your password" required minlength="8" autocomplete="new-password" aria-describedby="password-match">
                        <button type="button" class="fh-auth-eye" data-auth-password-toggle="password_confirmation" aria-label="Show confirmation password" aria-pressed="false">
                            <svg data-eye-show fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7Z"/></svg>
                            <svg data-eye-hide fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" style="display:none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 3 18 18M10.6 10.6a2 2 0 0 0 2.8 2.8"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.9 5.2A10.6 10.6 0 0 1 12 5c4.5 0 8.3 2.9 9.5 7a10.6 10.6 0 0 1-3 4.4M6.2 6.2A10.7 10.7 0 0 0 2.5 12c1.3 4.1 5.1 7 9.5 7 1 0 2-.2 2.9-.5"/></svg>
                        </button>
                    </div>
                    <p class="fh-auth-match" id="password-match" aria-live="polite"></p>
                    @error('password_confirmation')<p class="fh-auth-error" role="alert">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="fh-auth-submit" id="fh-register-submit">
                    <span class="fh-auth-btn-text">Create account</span>
                    <span class="fh-auth-spinner" aria-hidden="true"></span>
                </button>
            </form>

            <p class="fh-auth-footer-links">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
            <p class="fh-auth-legal">By creating an account, you agree to our <a href="{{ route('terms') }}">Terms</a> &amp; <a href="{{ route('privacy-policy') }}">Privacy Policy</a>.</p>
        </section>
    </main>

    <script>
        (() => {
            document.querySelectorAll('[data-auth-password-toggle]').forEach((button) => {
                const input = document.getElementById(button.dataset.authPasswordToggle);
                const show = button.querySelector('[data-eye-show]');
                const hide = button.querySelector('[data-eye-hide]');
                button.addEventListener('click', () => {
                    const visible = input.type === 'password';
                    input.type = visible ? 'text' : 'password';
                    show.style.display = visible ? 'none' : '';
                    hide.style.display = visible ? '' : 'none';
                    button.setAttribute('aria-pressed', String(visible));
                    button.setAttribute('aria-label', `${visible ? 'Hide' : 'Show'} ${input.id === 'password' ? 'password' : 'confirmation password'}`);
                });
            });

            const password = document.getElementById('password');
            const confirmation = document.getElementById('password_confirmation');
            const meter = document.getElementById('password-strength');
            const meterLabel = document.getElementById('password-strength-label');
            const matchLabel = document.getElementById('password-match');
            const segments = [...meter.querySelectorAll('.fh-auth-strength__segment')];
            const updateStrength = () => {
                const value = password.value;
                let score = 0;
                if (value.length >= 8) {
                    score = 1;
                    if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
                    if (/\d/.test(value)) score++;
                    if (/[^A-Za-z0-9]/.test(value) || value.length >= 14) score++;
                }
                meter.dataset.strength = String(score);
                meter.setAttribute('aria-valuenow', String(score));
                meterLabel.textContent = value.length === 0 ? 'Enter a password' : ['Too short', 'Weak', 'Fair', 'Good', 'Strong'][score];
                segments.forEach((segment, index) => segment.classList.toggle('is-active', index < score));
                updateMatch();
            };
            const updateMatch = () => {
                matchLabel.classList.remove('is-match', 'is-mismatch');
                if (!confirmation.value) { matchLabel.textContent = ''; return; }
                const matches = password.value === confirmation.value;
                matchLabel.textContent = matches ? 'Passwords match' : 'Passwords do not match yet';
                matchLabel.classList.add(matches ? 'is-match' : 'is-mismatch');
            };
            password.addEventListener('input', updateStrength);
            confirmation.addEventListener('input', updateMatch);

            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('fh-register-avatar-preview');
            const avatarError = document.getElementById('avatar-error');
            const defaultAvatar = @json(asset('images/fanhub-avatar.svg'));
            let avatarPreviewUrl = null;
            avatarInput.addEventListener('change', () => {
                const file = avatarInput.files?.[0];
                avatarError.textContent = '';
                avatarError.hidden = true;
                avatarInput.setAttribute('aria-invalid', 'false');
                if (avatarPreviewUrl) URL.revokeObjectURL(avatarPreviewUrl);
                avatarPreviewUrl = null;

                if (!file) {
                    avatarPreview.src = defaultAvatar;
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                const error = !allowedTypes.includes(file.type)
                    ? 'Choose a JPG, JPEG, PNG, or WebP image.'
                    : file.size > 2 * 1024 * 1024
                        ? 'Choose an image smaller than 2 MB.'
                        : null;

                if (error) {
                    avatarInput.value = '';
                    avatarInput.setAttribute('aria-invalid', 'true');
                    avatarPreview.src = defaultAvatar;
                    avatarError.textContent = error;
                    avatarError.hidden = false;
                    return;
                }

                avatarPreviewUrl = URL.createObjectURL(file);
                avatarPreview.src = avatarPreviewUrl;
            });
            avatarPreview.addEventListener('error', () => { avatarPreview.src = defaultAvatar; });

            const form = document.getElementById('fh-register-form');
            const submit = document.getElementById('fh-register-submit');
            form.addEventListener('submit', () => {
                if (!form.checkValidity()) return;
                submit.classList.add('is-loading');
                submit.disabled = true;
                submit.setAttribute('aria-busy', 'true');
            });
        })();
    </script>
</body>
</html>
