@props([
    'variant'    => 'default',   {{-- default | bookmarks | search | error | offline --}}
    'title'      => null,
    'desc'       => null,
    'actionUrl'  => null,
    'actionText' => null,
    'icon'       => null,
])

@php
    $variants = [
        'default'   => ['icon' => '📭', 'title' => 'Nothing here yet',       'desc' => 'There\'s no content to show right now.'],
        'bookmarks' => ['icon' => '🔖', 'title' => 'No bookmarks yet',        'desc' => 'Save content you love and find it here later.'],
        'search'    => ['icon' => '🔍', 'title' => 'No results found',        'desc' => 'Try different keywords or browse all content.'],
        'error'     => ['icon' => '⚠️', 'title' => 'Something went wrong',    'desc' => 'We couldn\'t load this content. Please try again.'],
        'offline'   => ['icon' => '📡', 'title' => 'You\'re offline',         'desc' => 'Check your connection and refresh the page.'],
    ];
    $v = $variants[$variant] ?? $variants['default'];
    $displayIcon  = $icon  ?? $v['icon'];
    $displayTitle = $title ?? $v['title'];
    $displayDesc  = $desc  ?? $v['desc'];
@endphp

<div class="fh-empty" role="status" aria-label="{{ $displayTitle }}">
    <div class="fh-empty__icon" aria-hidden="true">{{ $displayIcon }}</div>
    <p class="fh-empty__title">{{ $displayTitle }}</p>
    <p class="fh-empty__desc">{{ $displayDesc }}</p>

    @if ($actionUrl && $actionText)
        <a href="{{ $actionUrl }}" class="fh-empty__action">
            {{ $actionText }}
        </a>
    @endif

    {{ $slot }}
</div>
