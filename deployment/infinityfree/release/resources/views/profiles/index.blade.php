<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Who's Watching? — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased min-h-screen flex flex-col items-center justify-center px-4 py-12">

    <h1 class="text-3xl font-bold mb-2">Who's Watching?</h1>
    <p class="text-gray-400 text-sm mb-10">Select a profile to personalise your experience.</p>

    <div class="flex flex-wrap justify-center gap-6 mb-10">

        {{-- Existing profiles --}}
        @foreach ($profiles as $profile)
        <div class="flex flex-col items-center gap-3 group">
            <form method="POST" action="{{ route('profiles.select', $profile) }}">
                @csrf
                <button type="submit"
                        class="w-24 h-24 rounded-xl overflow-hidden border-2 border-transparent group-hover:border-indigo-500 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <img src="{{ $profile->avatarUrl() }}" alt="{{ $profile->name }}"
                         class="w-full h-full object-cover">
                </button>
            </form>
            <span class="text-sm text-gray-300 group-hover:text-white transition">{{ $profile->name }}</span>
            @if ($profile->is_kid)
                <span class="text-[10px] bg-yellow-500/20 text-yellow-300 px-2 py-0.5 rounded-full">Kids</span>
            @endif
            {{-- Delete (small, subtle) --}}
            <form method="POST" action="{{ route('profiles.destroy', $profile) }}"
                  onsubmit="return confirm('Delete profile {{ $profile->name }}?')">
                @csrf @method('DELETE')
                <button class="text-[10px] text-gray-600 hover:text-red-400 transition">Remove</button>
            </form>
        </div>
        @endforeach

        {{-- Add Profile card --}}
        @if ($profiles->count() < 5)
        <div x-data="{ open: false }" class="flex flex-col items-center gap-3">
            <button @click="open = !open"
                    class="w-24 h-24 rounded-xl border-2 border-dashed border-gray-700 hover:border-indigo-500 flex items-center justify-center transition-all duration-200 text-gray-500 hover:text-indigo-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
            <span class="text-sm text-gray-500">Add Profile</span>

            {{-- Inline add form --}}
            <div x-show="open" x-transition class="mt-2 bg-gray-900 border border-gray-800 rounded-xl p-5 w-64">
                <form method="POST" action="{{ route('profiles.store') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Profile Name</label>
                        <input name="name" required maxlength="50" autofocus
                               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                               placeholder="e.g. Alex">
                    </div>
                    <label class="flex items-center gap-2 text-sm text-gray-300 cursor-pointer">
                        <input type="checkbox" name="is_kid" value="1"
                               class="rounded border-gray-600 bg-gray-800 text-indigo-500 focus:ring-indigo-500">
                        Kids profile
                    </label>
                    <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium py-2 rounded-lg transition">
                        Create Profile
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-300 transition">
        Continue without a profile →
    </a>

</body>
</html>
