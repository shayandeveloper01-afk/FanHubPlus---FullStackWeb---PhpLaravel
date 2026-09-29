<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Welcome back, {{ Auth::user()->name }} 👋
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Stats --}}
            @php
                $contentCount  = Auth::user()->contents()->count();
                $bookmarkCount = Auth::user()->bookmarks()->count();
                $articleCount  = Auth::user()->articles()->count();
                $ratingCount   = Auth::user()->ratings()->count();
            @endphp
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-400">{{ $contentCount }}</p>
                    <p class="text-sm text-gray-400 mt-1">My Content</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-400">{{ $bookmarkCount }}</p>
                    <p class="text-sm text-gray-400 mt-1">Bookmarks</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-400">{{ $articleCount }}</p>
                    <p class="text-sm text-gray-400 mt-1">Articles</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-center">
                    <p class="text-3xl font-bold text-indigo-400">{{ $ratingCount }}</p>
                    <p class="text-sm text-gray-400 mt-1">Ratings Given</p>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('contents.create') }}"
                   class="flex items-center gap-4 bg-gray-900 border border-gray-800 hover:border-indigo-500/50 rounded-xl p-5 transition group">
                    <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center group-hover:bg-indigo-600/40 transition">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">New Content</p>
                        <p class="text-xs text-gray-500">Post a review or fan page</p>
                    </div>
                </a>
                <a href="{{ route('articles.create') }}"
                   class="flex items-center gap-4 bg-gray-900 border border-gray-800 hover:border-indigo-500/50 rounded-xl p-5 transition group">
                    <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center group-hover:bg-indigo-600/40 transition">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">Write Article</p>
                        <p class="text-xs text-gray-500">Rich-text with CKEditor</p>
                    </div>
                </a>
                <a href="{{ route('bookmarks.index') }}"
                   class="flex items-center gap-4 bg-gray-900 border border-gray-800 hover:border-indigo-500/50 rounded-xl p-5 transition group">
                    <div class="w-10 h-10 bg-indigo-600/20 rounded-lg flex items-center justify-center group-hover:bg-indigo-600/40 transition">
                        <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-white text-sm">My Bookmarks</p>
                        <p class="text-xs text-gray-500">{{ $bookmarkCount }} saved items</p>
                    </div>
                </a>
            </div>

            {{-- Recent Content --}}
            @if ($contentCount > 0)
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-white">Recent Content</h3>
                    <a href="{{ route('contents.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300 transition">View all</a>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-800">
                        <tbody class="divide-y divide-gray-800">
                            @foreach (Auth::user()->contents()->with('category')->latest()->limit(5)->get() as $content)
                            <tr class="hover:bg-gray-800/30 transition">
                                <td class="px-5 py-3">
                                    <a href="{{ route('contents.show', $content) }}">
                                        <x-media-image :src="$content->thumbnailUrl()" :title="$content->title" :category="$content->category?->name ?? $content->type" kind="content" :record-key="$content->id" :alt="$content->title" class="w-10 h-14 object-cover rounded-md" />
                                    </a>
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('contents.show', $content) }}"
                                       class="text-sm text-indigo-400 hover:text-indigo-300 font-medium transition">
                                        {{ $content->title }}
                                    </a>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-500">{{ $content->category->name }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs px-2 py-0.5 rounded-full
                                        {{ $content->isPublished() ? 'bg-green-900/50 text-green-400' : 'bg-yellow-900/50 text-yellow-400' }}">
                                        {{ ucfirst($content->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-600">{{ $content->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
