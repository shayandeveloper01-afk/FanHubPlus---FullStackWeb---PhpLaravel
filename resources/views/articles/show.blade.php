<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} — {{ config('app.name') }}</title>

    {{-- Open Graph --}}
    <meta property="og:title"       content="{{ $article->title }}">
    <meta property="og:description" content="{{ $article->excerpt ?? Str::limit(strip_tags($article->body), 160) }}">
    <meta property="og:image"       content="{{ $article->coverImageUrl() }}">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:type"        content="article">
    <meta name="twitter:card"       content="summary_large_image">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased">

@include('layouts.navigation')

@if ($article->cover_image)
<div class="relative h-64 sm:h-96 overflow-hidden">
    <img src="{{ $article->coverImageUrl() }}" alt="{{ $article->title }}"
         class="w-full h-full object-cover opacity-50" loading="lazy">
    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/50 to-transparent"></div>
</div>
@endif

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-6">
        @if ($article->is_featured)
            <span class="inline-block text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 px-2 py-0.5 rounded-full mb-3">
                ★ Featured
            </span>
        @endif
        <h1 class="text-3xl sm:text-4xl font-bold leading-tight mb-3">{{ $article->title }}</h1>
        @if ($article->excerpt)
            <p class="text-gray-400 text-lg leading-relaxed mb-4">{{ $article->excerpt }}</p>
        @endif
        <div class="flex items-center gap-3 text-sm text-gray-500">
            <span>by {{ $article->user->name }}</span>
            <span>· {{ $article->read_time_minutes }} min read</span>
            @if ($article->published_at)
                <span>· {{ $article->published_at->format('d M Y') }}</span>
            @endif
        </div>
    </div>

    <div class="prose prose-invert prose-sm sm:prose max-w-none">
        {!! $article->body !!}
    </div>

    {{-- Share --}}
    <div class="mt-10 pt-6 border-t border-gray-800">
        <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Share this article</p>
        @php $shareUrl = urlencode(url()->current()); $shareTitle = urlencode($article->title); @endphp
        <div class="flex gap-2 flex-wrap">
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
               target="_blank" rel="noopener"
               class="text-xs bg-gray-800 hover:bg-sky-600 border border-gray-700 px-3 py-1.5 rounded-lg transition">
                Share on X
            </a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
               target="_blank" rel="noopener"
               class="text-xs bg-gray-800 hover:bg-blue-600 border border-gray-700 px-3 py-1.5 rounded-lg transition">
                Share on Facebook
            </a>
            <button onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(() => alert('Link copied!'))"
                    class="text-xs bg-gray-800 hover:bg-gray-700 border border-gray-700 px-3 py-1.5 rounded-lg transition">
                Copy Link
            </button>
        </div>
    </div>

</div>



@include('layouts.footer')
</body>
</html>
