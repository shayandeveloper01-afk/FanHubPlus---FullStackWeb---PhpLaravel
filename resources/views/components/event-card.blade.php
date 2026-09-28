@php
    $isInList   = in_array($item->id, (array) $myListIds);
    $matchScore = $matchScores[$item->id] ?? null;
    $rank       = $rank ?? null;
    $thumbnail  = method_exists($item, 'thumbnailUrl')
                    ? $item->thumbnailUrl()
                    : asset('images/thumbnail-placeholder.svg');
@endphp

<a href="{{ route('contents.show', $item) }}" class="fh-card">
    <div class="fh-card__media">
        <img src="{{ $thumbnail }}"
             alt="{{ $item->title }}"
             loading="lazy"
             onerror="this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'">

        @if ($rank)
            <span class="fh-card__rank">{{ $rank }}</span>
        @elseif ($matchScore)
            <span class="fh-card__badge">{{ round($matchScore * 100) }}% Match</span>
        @endif

        <button type="button"
                class="fh-card__add mylist-btn"
                data-content-id="{{ $item->id }}"
                data-in-list="{{ $isInList ? 'true' : 'false' }}"
                aria-label="{{ $isInList ? 'Remove from My List' : 'Add to My List' }}">
            <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
            </svg>
            <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
        </button>

        @if (isset($progress) && $progress)
            <div class="fh-card__progress">
                <span style="width: {{ $progress }}%"></span>
            </div>
        @endif
    </div>

    <div class="fh-card__body">
        <h3 class="fh-card__title">{{ $item->title }}</h3>
        <div class="fh-card__meta">
            @if (!empty($item->release_year))
                <span>{{ $item->release_year }}</span>
                <span class="fh-card__dot"></span>
            @endif
            @if ($item->category)
                <span>{{ $item->category->name }}</span>
            @endif
        </div>
    </div>
</a>
