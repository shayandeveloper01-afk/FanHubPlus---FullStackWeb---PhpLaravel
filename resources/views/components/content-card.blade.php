@props([
    'content',
    'rank'       => null,
    'isNew'      => false,
    'matchPct'   => null,
    'progress'   => null,
    'inList'     => false,
])

@php
    $title = mb_strtolower($content->title);
    $posterByTitle = [
        'dune: part two' => '1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg',
        'oppenheimer' => 'ptpr0kGAckfQkJeJIt8st5dglvd.jpg',
        'alien: romulus' => 'b33nnKl1GSFbao4l3fZDDqsMx0F.jpg',
        'interstellar' => 'gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
        'the last of us' => 'dmo6TYuuJgaYinXBPjrgG9mB5od.jpg',
        'severance' => 'pPHpeI2X1qEd1CS1SeyrdhZ4qnT.jpg',
        'house of the dragon' => '7QMsOTMUswlwxJP0rTTZfmz2tX2.jpg',
        'demon slayer' => 'xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg',
        'kimetsu' => 'xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg',
        'jujutsu kaisen' => 'fHp4JmgyWaLVp2nBcLhPJcHGLyY.jpg',
        'jujutsu' => 'fHp4JmgyWaLVp2nBcLhPJcHGLyY.jpg',
    ];
    $titlePoster = collect($posterByTitle)
        ->first(fn ($image, $match) => str_contains($title, $match));
    $poster = $content->thumbnail
        ? $content->thumbnailUrl()
        : ($titlePoster ? 'https://image.tmdb.org/t/p/w500/' . $titlePoster : null);
    $typeLabel = match (strtolower((string) $content->type)) {
        'movie', 'film' => 'Film',
        'series', 'tv', 'television' => 'TV',
        'anime' => 'Anime',
        'game', 'gaming' => 'Gaming',
        'music' => 'Music',
        'podcast' => 'Podcast',
        default => $content->category?->name ?? Str::headline((string) $content->type),
    };
@endphp

<a href="{{ route('contents.show', $content) }}" class="fh-content-card group" data-content-id="{{ $content->id }}">
    <div class="fh-content-card__media">
        @if ($poster)
            <img src="{{ $poster }}"
                 alt="{{ $content->title }} poster"
                 loading="lazy"
                 onerror="this.onerror=null;this.hidden=true;this.nextElementSibling.hidden=false">
        @endif

        <div class="fh-content-card__fallback" @if ($poster) hidden @endif aria-hidden="true">
            <span>{{ $typeLabel }}</span>
            <i></i><i></i><i></i>
        </div>

        @if ($isNew)
            <span class="fh-content-card__badge fh-content-card__badge--new">NEW</span>
        @elseif ($matchPct !== null)
            <span class="fh-content-card__badge fh-content-card__badge--match">{{ round($matchPct * 100) }}% Match</span>
        @endif

        @if ($rank !== null)
            <span class="fh-content-card__rank" aria-label="Rank {{ $rank }}">{{ $rank }}</span>
        @endif

        @auth
            <button type="button"
                    class="fh-content-card__add mylist-btn"
                    data-content-id="{{ $content->id }}"
                    data-in-list="{{ $inList ? 'true' : 'false' }}"
                    aria-label="{{ $inList ? 'Remove from My List' : 'Add to My List' }}"
                    title="{{ $inList ? 'Remove from My List' : 'Add to My List' }}">
                <svg class="mylist-icon-add {{ $inList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <svg class="mylist-icon-check {{ $inList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        @endauth

        @if ($progress !== null && $progress > 0)
            <div class="fh-content-card__progress" aria-label="{{ $progress }}% complete">
                <span style="width: {{ min(100, max(0, $progress)) }}%"></span>
            </div>
        @endif
    </div>

    <div class="fh-content-card__details">
        <h3 class="fh-content-card__title" title="{{ $content->title }}">{{ $content->title }}</h3>
        <div class="fh-content-card__meta">
            <span>{{ $typeLabel }}</span>
            @if ($content->year)
                <span class="fh-content-card__separator" aria-hidden="true">•</span>
                <span>{{ $content->year }}</span>
            @endif
        </div>
    </div>
</a>
