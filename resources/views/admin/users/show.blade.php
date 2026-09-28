<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition">← Users</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">{{ $user->name }}</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl space-y-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 flex items-center gap-5">
            <img src="{{ $user->avatarUrl() }}" class="h-16 w-16 rounded-full object-cover">
            <div>
                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <div class="flex gap-2 mt-2">
                    @if ($user->is_admin)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/40">Admin</span>
                    @endif
                    @if ($user->isBanned())
                        <span class="px-2 py-0.5 text-xs rounded-full bg-red-500/20 text-red-300 border border-red-500/40">Banned since {{ $user->banned_at->format('d M Y') }}</span>
                    @endif
                    @if ($user->trashed())
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-700 text-gray-400 border border-gray-600">Deleted {{ $user->deleted_at->format('d M Y') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Content',   'value' => $user->contents()->count()],
                ['label' => 'Articles',  'value' => $user->articles()->count()],
                ['label' => 'Bookmarks', 'value' => $user->bookmarks()->count()],
                ['label' => 'Ratings',   'value' => $user->ratings()->count()],
            ] as $stat)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-indigo-400">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-sm text-gray-400 space-y-2">
            <p>Joined: <span class="text-white">{{ $user->created_at->format('d F Y \\a\\t h:i A') }}</span></p>
            <p>Email verified: <span class="text-white">{{ $user->email_verified_at ? $user->email_verified_at->format('d M Y') : 'No' }}</span></p>
        </div>
    </div>
</x-admin-layout>
