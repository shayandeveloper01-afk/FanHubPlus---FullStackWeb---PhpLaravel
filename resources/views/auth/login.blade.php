<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Sign In — FanHub+</title>
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
@vite(['resources/css/app.css', 'resources/js/app.js'])
@include('auth.partials.styles')

</head>
<body class="fh-auth-body">

<div class="fh-auth-bg">
    <div class="fh-auth-orb fh-auth-orb--1"></div>
    <div class="fh-auth-orb fh-auth-orb--2"></div>
    <div class="fh-auth-orb fh-auth-orb--3"></div>
</div>

<a href="{{ route('home') }}" class="fh-auth-back" aria-label="Back to home">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    Back to home
</a>

<div class="fh-auth-wrap">

    {{-- LEFT: BRAND PANEL --}}
    <div class="fh-auth-brand" aria-hidden="true">
        <div class="fh-auth-brand__orb-a"></div>
        <div class="fh-auth-brand__orb-b"></div>

        <div class="fh-auth-logo">
            <x-fh-logo-mark class="fh-auth-logo__mark" />
            <span class="fh-auth-logo__text">FanHub<span>+</span></span>
        </div>

        <div class="fh-auth-brand__body">
            <p class="fh-auth-brand__tagline">
                Discover, watch &amp;<br>
                <span>share fan-made content</span>
            </p>
            <ul class="fh-auth-features">
                <li>
                    <span class="fh-auth-feat-icon">🎬</span>
                    Movies, TV &amp; Anime
                </li>
                <li>
                    <span class="fh-auth-feat-icon">🎨</span>
                    Fan-made content
                </li>
                <li>
                    <span class="fh-auth-feat-icon">🎉</span>
                    Local events
                </li>
                <li>
                    <span class="fh-auth-feat-icon">💜</span>
                    Community driven
                </li>
            </ul>
        </div>

        <p class="fh-auth-brand__footer">© {{ date('Y') }} FanHub Plus</p>
    </div>

    {{-- RIGHT: FORM PANEL --}}
    <div class="fh-auth-form-panel">

        <h1 class="fh-auth-heading">Welcome back</h1>
        <p class="fh-auth-subheading">Sign in to continue to FanHub+</p>

        @if (session('status'))
            <div class="fh-auth-status" role="alert">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="fh-login-form" novalidate>
            @csrf

            {{-- Email --}}
            <div class="fh-auth-field">
                <label for="email" class="fh-auth-label">Email address</label>
                <div class="fh-auth-input-wrap">
                    <span class="fh-auth-input-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="fh-auth-input"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        required
                        autofocus
                        autocomplete="username"
                        aria-describedby="email-error"
                    >
                </div>
                @error('email')
                    <p id="email-error" class="fh-auth-error" role="alert">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Remember + Forgot row --}}
            <div class="fh-auth-row">
                <label class="fh-auth-check-label" for="remember_me">
                    <input id="remember_me" type="checkbox" name="remember" class="fh-auth-check">
                    Remember me
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="fh-auth-forgot">Forgot password?</a>
                @endif
            </div>

            {{-- Password --}}
            <div class="fh-auth-field">
                <label for="password" class="fh-auth-label">Password</label>
                <div class="fh-auth-input-wrap">
                    <span class="fh-auth-input-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="fh-auth-input fh-auth-input--has-trail"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                        aria-describedby="password-error"
                    >
                    <button
                        type="button"
                        class="fh-auth-eye"
                        id="fh-eye-toggle"
                        aria-label="Toggle password visibility"
                        aria-pressed="false"
                    >
                        <svg id="fh-eye-show" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg id="fh-eye-hide" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p id="password-error" class="fh-auth-error" role="alert">
                        <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="fh-auth-submit" id="fh-submit-btn">
                <span class="fh-auth-btn-text">Sign in</span>
                <span class="fh-auth-spinner" aria-hidden="true"></span>
            </button>
        </form>

        <div class="fh-auth-divider">or continue with</div>

        <div class="fh-auth-socials">
            <a href="#" class="fh-auth-social-btn" role="button" aria-label="Sign in with Google">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Google
            </a>
            <a href="#" class="fh-auth-social-btn" role="button" aria-label="Sign in with GitHub">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"/>
                </svg>
                GitHub
            </a>
        </div>

        <p class="fh-auth-footer-links">
            Don't have an account? <a href="{{ route('register') }}">Sign up</a>
        </p>
        <p class="fh-auth-legal">
            By signing in, you agree to our
            <a href="{{ route('terms') }}">Terms</a> &amp; <a href="{{ route('privacy-policy') }}">Privacy</a>
        </p>

    </div>{{-- /form panel --}}
</div>{{-- /wrap --}}

<script>
(function () {
    // Password toggle
    const pwInput = document.getElementById('password');
    const eyeBtn  = document.getElementById('fh-eye-toggle');
    const eyeShow = document.getElementById('fh-eye-show');
    const eyeHide = document.getElementById('fh-eye-hide');
    if (eyeBtn && pwInput) {
        eyeBtn.addEventListener('click', function () {
            const visible = pwInput.type === 'text';
            pwInput.type = visible ? 'password' : 'text';
            eyeShow.style.display = visible ? '' : 'none';
            eyeHide.style.display = visible ? 'none' : '';
            eyeBtn.setAttribute('aria-pressed', String(!visible));
        });
    }

    // Submit loading state + ripple
    const form    = document.getElementById('fh-login-form');
    const submitBtn = document.getElementById('fh-submit-btn');
    if (form && submitBtn) {
        form.addEventListener('submit', function () {
            submitBtn.classList.add('is-loading');
            submitBtn.disabled = true;
        });
        submitBtn.addEventListener('click', function (e) {
            const rect = submitBtn.getBoundingClientRect();
            const ripple = document.createElement('span');
            const size = Math.max(rect.width, rect.height);
            ripple.className = 'fh-auth-ripple';
            ripple.style.cssText = `width:${size}px;height:${size}px;left:${e.clientX - rect.left - size/2}px;top:${e.clientY - rect.top - size/2}px`;
            submitBtn.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    }
})();
</script>
</body>
</html>
