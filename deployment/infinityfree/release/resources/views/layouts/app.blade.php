<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="htmlRoot" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        {{-- No-flash theme + font-size script: runs before CSS paints --}}
        <script>
            (function () {
                var pref = localStorage.getItem('fh-theme') || 'system';
                var resolved = pref === 'system'
                    ? (window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark')
                    : pref;
                document.documentElement.setAttribute('data-theme', resolved);
                var fs = localStorage.getItem('fh_fontSize') || 'md';
                var fsMap = { sm: '14px', md: '16px', lg: '18px' };
                document.documentElement.style.fontSize = fsMap[fs] || '16px';
            })();
        </script>
        <style>
            :root, [data-theme="dark"] {
                --fh-bg: #0a0a12;
                --fh-bg-soft: #12141f;
                --fh-bg-card: #12141f;
                --fh-text: #f3f4f6;
                --fh-text-muted: #9ca3af;
                --fh-border: rgba(255,255,255,.07);
                --fh-purple: #8b5cf6;
                --fh-purple-light: #a855f7;
                --fh-pink: #ec4899;
            }
            [data-theme="light"] {
                --fh-bg: #f8f9fc;
                --fh-bg-soft: #ffffff;
                --fh-bg-card: #ffffff;
                --fh-text: #111827;
                --fh-text-muted: #6b7280;
                --fh-border: rgba(0,0,0,.08);
                --fh-purple: #8b5cf6;
                --fh-purple-light: #a855f7;
                --fh-pink: #ec4899;
            }
            html { transition: background-color .3s, color .3s; }
            [data-theme="light"] body {
                background-color: var(--fh-bg) !important;
                color: var(--fh-text) !important;
            }
            [data-theme="light"] .fh-nav {
                background: rgba(248,249,252,.88) !important;
            }
            [data-theme="light"] .fh-nav.scrolled {
                background: rgba(248,249,252,.97) !important;
                box-shadow: 0 12px 40px -22px rgba(139,92,246,.25) !important;
            }
            [data-theme="light"] .fh-nav__link { color: #6b7280 !important; }
            [data-theme="light"] .fh-nav__link:hover,
            [data-theme="light"] .fh-nav__link.is-active { color: #111827 !important; }
            [data-theme="light"] .fh-nav__icon-btn {
                background: rgba(0,0,0,.04) !important;
                border-color: rgba(0,0,0,.1) !important;
                color: #6b7280 !important;
            }
            [data-theme="light"] .fh-nav__avatar-btn {
                background: rgba(0,0,0,.04) !important;
                border-color: rgba(0,0,0,.1) !important;
                color: #374151 !important;
            }
            [data-theme="light"] .fh-nav__dropdown {
                background: #ffffff !important;
                border-color: rgba(0,0,0,.08) !important;
                box-shadow: 0 20px 40px -10px rgba(0,0,0,.15) !important;
            }
            [data-theme="light"] .fh-nav__dd-item { color: #374151 !important; }
            [data-theme="light"] .fh-nav__dd-item:hover { background: rgba(139,92,246,.08) !important; color: #111827 !important; }
            [data-theme="light"] .fh-nav__dd-user-name { color: #111827 !important; }
            [data-theme="light"] .fh-nav__mobile {
                background: rgba(248,249,252,.97) !important;
                border-color: rgba(0,0,0,.08) !important;
            }
            [data-theme="light"] .fh-nav__mobile-link { color: #6b7280 !important; }
            [data-theme="light"] .fh-nav__mobile-link:hover,
            [data-theme="light"] .fh-nav__mobile-link.is-active { color: #111827 !important; background: rgba(139,92,246,.08) !important; }
            [data-theme="light"] .fh-nav__btn--ghost { color: #374151 !important; }
            [data-theme="light"] .fh-nav__btn--ghost:hover { background: rgba(0,0,0,.06) !important; }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="font-sans antialiased" style="background:var(--fh-bg);color:var(--fh-text);transition:background-color .3s,color .3s">
        {{-- Skip to content --}}
        <a href="#fh-main-content" class="fh-skip-link">Skip to content</a>
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-gray-900 border-b border-gray-800">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main id="fh-main-content" class="fh-app-main" tabindex="-1">
                {{ $slot }}
            </main>
            @include('layouts.footer')
        </div>

        {{-- Chatbot widget on all authenticated pages --}}
        <x-chatbot />

        @stack('scripts')
    </body>
</html>
