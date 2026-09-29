@props([
    'src' => null,
    'title' => 'FanHub+ artwork',
    'category' => '',
    'kind' => 'content',
    'alt' => null,
    'class' => '',
    'loading' => 'lazy',
    'recordKey' => null,
])
@php
    $fallback = \App\Support\ImageArtwork::fallbackSource($title, $category, $kind, $recordKey);
    // Callers normally pass the model resolver's result. Resolve here too when
    // a caller has no stored image so a title/category match can still reach
    // TMDB or Jikan before the SVG fallback.
    $resolved = $src ?: \App\Support\ImageArtwork::source(null, $title, $category, $kind, $recordKey);
@endphp
<img src="{{ $resolved }}" alt="{{ $alt ?? $title }}" class="{{ $class }}" loading="{{ $loading }}" decoding="async"
     onload="this.closest('.fh-skel')?.classList.remove('fh-skel')"
     onerror="this.onerror=null;this.src='{{ $fallback }}'" {{ $attributes }}>
