@props([
    'content',
    'rank'       => null,
    'isNew'      => false,
    'matchPct'   => null,
    'progress'   => null,
    'inList'     => false,
    'bookmarked' => null,
])

@php
    $poster = $content->thumbnailUrl();
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

<article class="fh-content-card group" data-content-id="{{ $content->id }}">
    <a href="{{ route('contents.show', $content) }}" class="fh-content-card__link" data-content-id="{{ $content->id }}" @if(!empty($content->trailer_url)) data-trailer="{{ $content->trailer_url }}" @endif>
        <div class="fh-content-card__media">
            <x-media-image :src="$poster" :title="$content->title" :category="$content->category?->name ?? $content->type" kind="content" :record-key="$content->id" :alt="$content->title.' poster'" class="w-full h-full object-cover" />

            @if ($isNew)
                <span class="fh-content-card__badge fh-content-card__badge--new">NEW</span>
            @elseif ($matchPct !== null)
                <span class="fh-content-card__badge fh-content-card__badge--match">{{ round($matchPct * 100) }}% Match</span>
            @endif

            @if ($rank !== null)
                <span class="fh-content-card__rank" aria-label="Rank {{ $rank }}">{{ $rank }}</span>
            @endif

            @auth
                <button type="button" class="fh-content-card__add mylist-btn"
                        data-content-id="{{ $content->id }}" data-in-list="{{ $inList ? 'true' : 'false' }}"
                        aria-label="{{ $inList ? 'Remove from My List' : 'Add to My List' }}"
                        title="{{ $inList ? 'Remove from My List' : 'Add to My List' }}">
                    <svg class="mylist-icon-add {{ $inList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <svg class="mylist-icon-check {{ $inList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </button>
            @endauth

            @if ($progress !== null && $progress > 0)
                <div class="fh-content-card__progress" aria-label="{{ $progress }}% complete"><span style="width: {{ min(100, max(0, $progress)) }}%"></span></div>
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

    <x-bookmark-button :content="$content" :bookmarked="$bookmarked" :show-label="true" class="fh-content-card__bookmark" />
</article>
