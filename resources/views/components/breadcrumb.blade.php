@props(['crumbs' => []])

@php
    $allCrumbs = array_merge(
        [['label' => 'Home', 'url' => route('home')]],
        $crumbs
    );
@endphp

<nav class="fh-breadcrumb" aria-label="Breadcrumb">
    <ol vocab="https://schema.org/" typeof="BreadcrumbList"
        style="list-style:none;display:flex;align-items:center;flex-wrap:wrap;gap:.25rem;margin:0;padding:0">
        @foreach ($allCrumbs as $i => $crumb)
            @php $isLast = $i === count($allCrumbs) - 1; @endphp
            <li property="itemListElement" typeof="ListItem"
                style="display:flex;align-items:center;gap:.25rem">
                @if (!$isLast)
                    <a href="{{ $crumb['url'] }}"
                       class="fh-breadcrumb__link"
                       property="item" typeof="WebPage">
                        <span property="name">{{ $crumb['label'] }}</span>
                    </a>
                    <meta property="position" content="{{ $i + 1 }}">
                    <svg class="fh-breadcrumb__sep" width="12" height="12"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @else
                    <span class="fh-breadcrumb__current"
                          property="name" aria-current="page">{{ $crumb['label'] }}</span>
                    <meta property="position" content="{{ $i + 1 }}">
                    @if (!empty($crumb['url']))
                        <link property="item" href="{{ $crumb['url'] }}">
                    @endif
                @endif
            </li>
        @endforeach
    </ol>
</nav>
