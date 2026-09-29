@props(['content', 'bookmarked' => null, 'class' => '', 'showLabel' => false])

@auth
    @php($isBookmarked = $bookmarked ?? auth()->user()->bookmarks->contains('content_id', $content->id))
    <button type="button" class="bookmark-toggle {{ $class }}"
            data-content-id="{{ $content->id }}" data-bookmark-url="{{ route('bookmarks.toggle', $content) }}"
            data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
            aria-label="{{ $isBookmarked ? 'Remove bookmark' : 'Save bookmark' }}"
            aria-pressed="{{ $isBookmarked ? 'true' : 'false' }}" title="{{ $isBookmarked ? 'Remove bookmark' : 'Save to bookmarks' }}">
        <svg class="bookmark-icon h-4 w-4 shrink-0" fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
        </svg>
        @if ($showLabel)
            <span class="bookmark-label">{{ $isBookmarked ? 'Saved' : 'Bookmark' }}</span>
        @endif
    </button>
@endauth
