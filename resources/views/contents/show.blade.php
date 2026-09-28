<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $content->title }} — {{ config('app.name') }}</title>

    {{-- Open Graph --}}
    <meta property="og:title"       content="{{ $content->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($content->body), 160) }}">
    <meta property="og:image"       content="{{ $content->thumbnailUrl() }}">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="article">
    <meta name="twitter:card"       content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased">

{{-- Nav --}}
@include('layouts.navigation')

{{-- Hero Banner --}}
<div class="relative h-64 sm:h-80 overflow-hidden">
    <img src="{{ $content->thumbnailUrl() }}" alt="{{ $content->title }}"
         class="w-full h-full object-cover opacity-40" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/60 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="flex flex-wrap items-center gap-2 mb-2 text-xs text-gray-400">
            <a href="{{ route('explore', ['category' => $content->category_id]) }}"
               class="text-indigo-400 font-semibold uppercase tracking-widest hover:text-indigo-300 transition">
                {{ $content->category->name }}
            </a>
            @if ($content->type) <span>· {{ ucfirst($content->type) }}</span> @endif
            @if ($content->genre) <span>· {{ $content->genre }}</span> @endif
            @if ($content->year)  <span>· {{ $content->year }}</span>  @endif
            <span>· {{ $content->views_count }} views</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-bold leading-tight">{{ $content->title }}</h1>
        <p class="text-sm text-gray-400 mt-1">by {{ $content->user->name }} · {{ $content->created_at->format('d M Y') }}</p>
    </div>
</div>

<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ── Main Column ──────────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-10">

        {{-- Quick Facts / Full Story toggle --}}
        <div x-data="{ tab: 'facts' }" class="space-y-4">
            <x-tag-cloud :tags="$content->tags" />
            <div class="flex gap-1 bg-gray-900 border border-gray-800 rounded-lg p-1 w-fit">
                <button @click="tab = 'facts'"
                        :class="tab === 'facts' ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition">
                    Quick Facts
                </button>
                <button @click="tab = 'story'"
                        :class="tab === 'story' ? 'bg-indigo-600 text-white' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-1.5 text-sm font-medium rounded-md transition">
                    Full Story
                </button>
            </div>

            {{-- Quick Facts: bullet-list of key metadata --}}
            <div x-show="tab === 'facts'" x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <ul class="space-y-2 text-sm text-gray-300">
                    @if ($content->category)
                        <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Category</span> {{ $content->category->name }}</li>
                    @endif
                    @if ($content->genre)
                        <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Genre</span> {{ $content->genre }}</li>
                    @endif
                    @if ($content->type)
                        <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Type</span> {{ ucfirst($content->type) }}</li>
                    @endif
                    @if ($content->year)
                        <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Year</span> {{ $content->year }}</li>
                    @endif
                    <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Views</span> {{ number_format($content->views_count) }}</li>
                    <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Rating</span>
                        {{ $content->averageRating() ? $content->averageRating() . '/5 (' . $content->ratingsCount() . ' ratings)' : 'No ratings yet' }}
                    </li>
                    <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Author</span> {{ $content->user->name }}</li>
                    <li class="flex gap-2"><span class="text-gray-500 w-24 shrink-0">Published</span> {{ $content->created_at->format('d M Y') }}</li>
                </ul>
            </div>

            {{-- Full Story: full body text --}}
            <div x-show="tab === 'story'" x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 class="prose prose-invert prose-sm sm:prose max-w-none leading-relaxed">
                {!! nl2br(e($content->body)) !!}
            </div>
        </div>

        {{-- ── Characters ──────────────────────────────────────────────── --}}
        @if ($content->characters->isNotEmpty())
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b border-gray-800 pb-2">Characters</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($content->characters as $char)
                <div class="bg-gray-900 rounded-lg p-3 text-center">
                    <img src="{{ $char->imageUrl() }}" alt="{{ $char->name }}"
                         class="w-16 h-16 rounded-full object-cover mx-auto mb-2" loading="lazy">
                    <p class="text-sm font-semibold leading-tight">{{ $char->name }}</p>
                    @if ($char->alias)
                        <p class="text-xs text-gray-400">"{{ $char->alias }}"</p>
                    @endif
                    <span class="inline-block mt-1 text-[10px] px-2 py-0.5 rounded-full
                        {{ match($char->role) {
                            'protagonist' => 'bg-indigo-600/30 text-indigo-300',
                            'antagonist'  => 'bg-red-600/30 text-red-300',
                            'supporting'  => 'bg-gray-700 text-gray-300',
                            default       => 'bg-gray-800 text-gray-400',
                        } }}">
                        {{ ucfirst($char->role) }}
                    </span>
                    @if ($char->description)
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $char->description }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ── Timeline ─────────────────────────────────────────────────── --}}
        @if ($content->timelineEvents->isNotEmpty())
        <section>
            <h2 class="text-lg font-semibold mb-4 border-b border-gray-800 pb-2">Timeline</h2>
            <div class="relative pl-6 border-l-2 border-indigo-600/40 space-y-6">
                @foreach ($content->timelineEvents as $event)
                <div class="relative">
                    <div class="absolute -left-[1.35rem] top-1 w-3 h-3 rounded-full bg-indigo-500 border-2 border-gray-950"></div>
                    <div class="bg-gray-900 rounded-lg p-4">
                        <div class="flex items-center gap-3 mb-1">
                            <p class="font-semibold text-sm">{{ $event->title }}</p>
                            @if ($event->event_date)
                                <span class="text-xs text-gray-500">{{ $event->event_date->format('d M Y') }}</span>
                            @endif
                        </div>
                        @if ($event->description)
                            <p class="text-sm text-gray-400">{{ $event->description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- ── Add Character (owner only) ──────────────────────────────── --}}
        @can('update', $content)
        <section x-data="{ openChar: false, openTimeline: false }">
            <div class="flex gap-3 flex-wrap">
                <button @click="openChar = !openChar"
                        class="text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700 px-4 py-2 rounded-lg transition">
                    + Add Character
                </button>
                <button @click="openTimeline = !openTimeline"
                        class="text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700 px-4 py-2 rounded-lg transition">
                    + Add Timeline Event
                </button>
                <a href="{{ route('contents.edit', $content) }}"
                   class="text-sm bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition">
                    Edit Content
                </a>
            </div>

            {{-- Add Character Form --}}
            <div x-show="openChar" x-transition class="mt-4 bg-gray-900 border border-gray-800 rounded-lg p-5">
                <h3 class="font-semibold mb-4 text-sm">Add Character</h3>
                <form method="POST" action="{{ route('characters.store', $content) }}"
                      enctype="multipart/form-data" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Name *</label>
                        <input name="name" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Alias</label>
                        <input name="alias" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Role *</label>
                        <select name="role" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @foreach (['protagonist','antagonist','supporting','other'] as $r)
                                <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Order</label>
                        <input name="order_index" type="number" min="0" value="0"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Description</label>
                        <textarea name="description" rows="2"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Image</label>
                        <input name="image" type="file" accept="image/*"
                               class="text-sm text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-sm file:bg-gray-700 file:text-gray-200">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-lg transition">
                            Save Character
                        </button>
                    </div>
                </form>
            </div>

            {{-- Add Timeline Form --}}
            <div x-show="openTimeline" x-transition class="mt-4 bg-gray-900 border border-gray-800 rounded-lg p-5">
                <h3 class="font-semibold mb-4 text-sm">Add Timeline Event</h3>
                <form method="POST" action="{{ route('timeline.store', $content) }}"
                      class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @csrf
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Title *</label>
                        <input name="title" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Date (optional)</label>
                        <input name="event_date" type="date"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-400 mb-1">Description</label>
                        <textarea name="description" rows="2"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Order</label>
                        <input name="order_index" type="number" min="0" value="0"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm px-5 py-2 rounded-lg transition">
                            Save Event
                        </button>
                    </div>
                </form>
            </div>
        </section>
        @endcan

    </div>

    {{-- ── Sidebar ───────────────────────────────────────────────────────── --}}
    <div class="space-y-6">

        {{-- ── Bookmark + Share ─────────────────────────────────────────── --}}
        <div class="bg-gray-900 rounded-xl p-5 space-y-4">

            {{-- Bookmark toggle --}}
            @auth
            <div x-data="bookmarkWidget({{ $userBookmarked ? 'true' : 'false' }}, {{ $content->id }})"
                 class="flex items-center gap-3">
                <button @click="toggle()"
                        :class="bookmarked ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-800 hover:bg-gray-700 border border-gray-700'"
                        class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg transition-all duration-200 font-medium">
                    <svg class="w-4 h-4 transition-transform duration-200"
                         :class="bookmarked ? 'scale-110' : 'scale-100'"
                         :fill="bookmarked ? 'currentColor' : 'none'"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                    <span x-text="bookmarked ? 'Bookmarked' : 'Bookmark'"></span>
                </button>
            </div>

            {{-- My List toggle (profile-scoped, AJAX) --}}
            @if ($profile)
            <div x-data="myListWidget({{ $inList ? 'true' : 'false' }}, {{ $content->id }})">
                <button @click="toggle()"
                        :class="inList ? 'bg-green-700 hover:bg-green-600' : 'bg-gray-800 hover:bg-gray-700 border border-gray-700'"
                        class="flex items-center gap-2 text-sm px-4 py-2 rounded-lg transition-all duration-200 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!inList" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        <path x-show="inList" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span x-text="inList ? '✓ In My List' : '+ My List'"></span>
                </button>
                <p x-show="msg" x-text="msg" class="text-xs text-gray-400 mt-1" x-cloak></p>
            </div>
            @endif
            @else
            <a href="{{ route('login') }}"
               class="flex items-center gap-2 text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700 px-4 py-2 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                Sign in to Bookmark
            </a>
            @endauth

            {{-- Share buttons --}}
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-2">Share</p>
                <div class="flex gap-2 flex-wrap">
                    @php $shareUrl = urlencode(url()->current()); $shareTitle = urlencode($content->title); @endphp
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                       target="_blank" rel="noopener" data-fh-share="twitter"
                       class="text-xs bg-gray-800 hover:bg-sky-600 border border-gray-700 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        X
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                       target="_blank" rel="noopener" data-fh-share="facebook"
                       class="text-xs bg-gray-800 hover:bg-blue-600 border border-gray-700 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        Facebook
                    </a>
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                       target="_blank" rel="noopener" data-fh-share="whatsapp"
                       class="text-xs bg-gray-800 hover:bg-green-600 border border-gray-700 px-3 py-1.5 rounded-lg transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                    <a href="https://www.reddit.com/submit?url={{ $shareUrl }}&title={{ $shareTitle }}"
                       target="_blank" rel="noopener" data-fh-share="reddit"
                       class="text-xs bg-gray-800 hover:bg-orange-600 border border-gray-700 px-3 py-1.5 rounded-lg transition">Reddit</a>
                    <button data-fh-share="copy" onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('Link copied!'))"
                            class="text-xs bg-gray-800 hover:bg-gray-700 border border-gray-700 px-3 py-1.5 rounded-lg transition">
                        Copy Link
                    </button>
                </div>
            </div>
        </div>

        {{-- ── Star Rating ───────────────────────────────────────────────── --}}
        <div class="bg-gray-900 rounded-xl p-5">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Rating</p>
            <div class="flex items-center gap-3 mb-3">
                <span class="text-3xl font-bold text-yellow-400">
                    {{ $content->averageRating() ?? '—' }}
                </span>
                <div>
                    <p class="text-sm text-gray-300">out of 5</p>
                    <p class="text-xs text-gray-500">{{ $content->ratingsCount() }} {{ Str::plural('rating', $content->ratingsCount()) }}</p>
                </div>
            </div>

            @auth
            <div x-data="starRating({{ $userRating ?? 0 }}, {{ $content->id }}, @js($userReview ?? ''))" class="space-y-2">
                <p class="text-xs text-gray-400">Your rating:</p>
                <div class="flex gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                    <button @click="rate({{ $i }})"
                            @mouseenter="hovered = {{ $i }}"
                            @mouseleave="hovered = 0"
                            class="text-2xl transition-transform duration-100 hover:scale-125 focus:outline-none"
                            :class="(hovered || selected) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-600'"
                            aria-label="Rate {{ $i }} stars">★</button>
                    @endfor
                </div>
                <label class="block text-xs text-gray-400" for="rating-review">Review (optional)</label>
                <textarea id="rating-review" x-model="review" maxlength="2000" rows="3"
                          class="w-full rounded-lg border border-gray-700 bg-gray-800 p-2 text-sm text-white"
                          placeholder="What did you think?"></textarea>
                <p x-show="selected > 0" class="text-xs text-gray-400">
                    You rated <span x-text="selected" class="text-yellow-400 font-semibold"></span>/5
                </p>
            </div>
            @else
            <a href="{{ route('login') }}" class="text-sm text-indigo-400 hover:text-indigo-300 transition">
                Sign in to rate
            </a>
            @endauth
        </div>

        {{-- ── Private Note ──────────────────────────────────────────────── --}}
        @auth
        <div class="bg-gray-900 rounded-xl p-5"
             x-data="noteWidget(@js($userNote ?? ''), {{ $content->id }}, {{ $noteDetails?->timestamp_seconds ?? 'null' }}, {{ $noteDetails?->is_spoiler ? 'true' : 'false' }})">
            <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">My Private Note</p>
            <textarea x-model="note" rows="4" placeholder="Write a private note about this content…"
                      class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"></textarea>
            <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-gray-300">
                <label class="flex items-center gap-2">Timestamp (seconds)
                    <input type="number" min="0" x-model="timestampSeconds" class="w-28 rounded bg-gray-800 border border-gray-700 px-2 py-1 text-white">
                </label>
                <label class="flex items-center gap-2"><input type="checkbox" x-model="isSpoiler"> Contains spoilers</label>
            </div>
            <p x-show="isSpoiler" class="mt-2 text-xs text-amber-300" role="status">Spoiler warning: this note includes story details.</p>
            <div class="flex items-center gap-3 mt-2">
                <button @click="save()"
                        class="text-sm bg-indigo-600 hover:bg-indigo-700 px-4 py-1.5 rounded-lg transition">
                    Save Note
                </button>
                <button x-show="note.length > 0" @click="deleteNote()"
                        class="text-sm text-red-400 hover:text-red-300 transition">
                    Delete
                </button>
                <span x-show="saved" x-transition class="text-xs text-green-400">Saved!</span>
            </div>
        </div>
        @endauth

    </div>
</div>

{{-- ── Binge-Style Related Chain ─────────────────────────────────────── --}}
@if ($related->isNotEmpty())
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-8 border-t border-gray-800">

    {{-- Play Next CTA --}}
    @if ($playNext)
    <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
        <h2 class="text-base sm:text-lg font-semibold text-white">Up Next</h2>
        <a href="{{ route('contents.show', $playNext) }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-5 py-2 rounded-lg transition">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
            </svg>
            Play Next: {{ Str::limit($playNext->title, 40) }}
        </a>
    </div>
    @endif

    {{-- Horizontal scroll row of related content --}}
    <h2 class="text-base sm:text-lg font-semibold text-white mb-3">More Like This</h2>
    <div class="flex gap-3 overflow-x-auto scroll-smooth pb-2 scrollbar-hide snap-x snap-mandatory">
        @foreach ($related as $item)
        <div class="snap-start flex-shrink-0 w-36 sm:w-44 group relative rounded-lg overflow-hidden bg-gray-800 shadow-lg
                    transition-transform duration-200 hover:scale-105 hover:z-10">
            <div class="aspect-[2/3] overflow-hidden bg-gray-700">
                <img src="{{ $item->thumbnailUrl() }}" alt="{{ $item->title }}"
                     class="w-full h-full object-cover" loading="lazy">
            </div>
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-2">
                <p class="text-white text-xs font-semibold leading-tight line-clamp-2">{{ $item->title }}</p>
                <p class="text-indigo-300 text-[10px] mt-0.5">{{ $item->category->name }}</p>
            </div>
            <a href="{{ route('contents.show', $item) }}" class="absolute inset-0" aria-label="View {{ $item->title }}"></a>
        </div>
        @endforeach
    </div>
</div>
@endif



@push('scripts')
<script>
function bookmarkWidget(initial, contentId) {
    return {
        bookmarked: initial,
        async toggle() {
            const res = await fetch(`/bookmarks/${contentId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            const data = await res.json();
            this.bookmarked = data.bookmarked;
        }
    }
}

function starRating(initial, contentId, initialReview) {
    return {
        selected: initial,
        hovered: 0,
        review: initialReview || '',
        async rate(value) {
            this.selected = value;
            await fetch(`/ratings/${contentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ rating: value, review: this.review })
            });
        }
    }
}

function noteWidget(initial, contentId, initialTimestamp, initialSpoiler) {
    return {
        note: initial,
        timestampSeconds: initialTimestamp,
        isSpoiler: initialSpoiler,
        saved: false,
        async save() {
            await fetch(`/notes/${contentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ note: this.note, timestamp_seconds: this.timestampSeconds, is_spoiler: this.isSpoiler })
            });
            this.saved = true;
            setTimeout(() => this.saved = false, 2000);
        },
        async deleteNote() {
            await fetch(`/notes/${contentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                }
            });
            this.note = '';
        }
    }
}

function myListWidget(initial, contentId) {
    return {
        inList: initial,
        msg: '',
        async toggle() {
            try {
                const res = await fetch(`/my-list/${contentId}/toggle`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                });
                const data = await res.json();
                if (data.error) { this.msg = data.error; return; }
                this.inList = data.in_list;
                this.msg = data.in_list ? '✓ Added to My List' : 'Removed from My List';
                setTimeout(() => this.msg = '', 2000);
            } catch {
                this.msg = 'Something went wrong.';
            }
        }
    };
}

document.querySelectorAll('[data-fh-share]').forEach((button) => {
    button.addEventListener('click', () => {
        fetch('{{ route('analytics.track') }}', {
            method: 'POST',
            keepalive: true,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({ event_type: 'share_clicked', metadata: { content_id: {{ $content->id }}, platform: button.dataset.fhShare } }),
        }).catch(() => {});
    });
});
</script>
@endpush

@include('layouts.footer')
</body>
</html>
