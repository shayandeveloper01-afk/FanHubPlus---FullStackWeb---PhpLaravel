@props(['header' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Admin — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="fh-admin font-sans antialiased bg-gray-950 text-white">
<div class="fh-admin-shell flex min-h-screen" x-data="{ sidebarOpen: false }">

    {{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
    <aside class="fixed inset-y-0 left-0 z-40 w-60 bg-gray-900 border-r border-gray-800 flex flex-col transform transition-transform duration-200"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        <div class="h-16 flex items-center px-5 border-b border-gray-800 shrink-0">
            <a href="{{ route('admin.dashboard.index') }}" class="flex items-center gap-2 text-lg font-bold text-indigo-400">
                <img src="{{ asset('images/fanhub-plus-logo.png') }}" alt="FanHub+" class="h-10 w-28 object-contain">
                <span class="ml-1 text-xs font-normal text-gray-500">Admin</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5 text-sm">
            @php
                $navLinks = [
                    ['route' => 'admin.profile.index', 'label' => 'My Profile', 'active' => request()->routeIs('admin.profile*'),
                     'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['route' => 'admin.dashboard.index', 'label' => 'Dashboard',   'active' => request()->routeIs('admin.dashboard*'),
                     'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'admin.users.index',     'label' => 'Users',        'active' => request()->routeIs('admin.users*'),
                     'icon'  => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['route' => 'admin.contents.index',  'label' => 'Content',      'active' => request()->routeIs('admin.contents*'),
                     'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                    ['route' => 'admin.categories.index','label' => 'Categories',   'active' => request()->routeIs('admin.categories*'),
                     'icon'  => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                    ['route' => 'admin.events.index',    'label' => 'Events',       'active' => request()->routeIs('admin.events*'),
                     'icon'  => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['route' => 'admin.resources.index', 'label' => 'Resources', 'active' => request()->routeIs('admin.resources*'),
                     'icon' => 'M4 5h16M4 12h16M4 19h16'],
                    ['route' => 'admin.reviews.index', 'label' => 'Review queue', 'active' => request()->routeIs('admin.reviews*'),
                     'icon' => 'M7 8h10M7 12h10M7 16h6M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z'],
                    ['route' => 'admin.feedback.index',  'label' => 'Feedback',     'active' => request()->routeIs('admin.feedback*') && !request()->routeIs('admin.feedback.analytics'),
                     'icon'  => 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z'],
                    ['route' => 'admin.faqs.index',      'label' => 'FAQs',         'active' => request()->routeIs('admin.faqs*'),
                     'icon'  => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => 'admin.analytics.index', 'label' => 'Analytics',    'active' => request()->routeIs('admin.analytics*') || request()->routeIs('admin.feedback.analytics') || request()->routeIs('admin.chatbot.analytics'),
                     'icon'  => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                    ['route' => 'admin.settings.index',  'label' => 'Settings',     'active' => request()->routeIs('admin.settings*'),
                     'icon'  => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z'],
                    ['route' => 'admin.activity-log.index', 'label' => 'Audit Log', 'active' => request()->routeIs('admin.activity-log*'),
                     'icon'  => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ];
            @endphp

            @foreach ($navLinks as $l)
                <a href="{{ route($l['route']) }}"
                   class="fh-admin__nav-link flex items-center gap-3 px-3 py-2 rounded-lg transition
                          {{ $l['active'] ? 'bg-indigo-600/20 text-indigo-300' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $l['icon'] }}"/>
                    </svg>
                    {{ $l['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="border-t border-gray-800 p-4 text-xs text-gray-500">
            <a href="{{ route('home') }}" class="hover:text-white transition">← Back to site</a>
        </div>
    </aside>

    {{-- Overlay (mobile) --}}
    <div class="fixed inset-0 z-30 bg-black/50 lg:hidden"
         x-show="sidebarOpen" @click="sidebarOpen=false" x-cloak></div>

    {{-- ── Main content ─────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col lg:ml-60 min-w-0">

        {{-- Top bar --}}
        <header class="h-16 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-4 sm:px-6 shrink-0">
            {{-- Hamburger (mobile) --}}
            <button @click="sidebarOpen=true" class="lg:hidden text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page header slot --}}
            <div class="flex-1 lg:flex-none">
                {{ $header ?? '' }}
            </div>

            {{-- Top-right: avatar + name + logout --}}
            <div class="flex items-center gap-3 text-sm text-gray-400">
                <img src="{{ Auth::user()->avatarUrl() }}" class="h-7 w-7 rounded-full object-cover">
                <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="hover:text-white transition">Logout</button>
                </form>
            </div>
        </header>

        {{-- Page body --}}
        <main class="flex-1 p-4 sm:p-6 overflow-auto">
            @if (session('success'))
                <div class="mb-5 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-300 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-5 px-4 py-3 bg-red-500/10 border border-red-500/30 text-red-300 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
