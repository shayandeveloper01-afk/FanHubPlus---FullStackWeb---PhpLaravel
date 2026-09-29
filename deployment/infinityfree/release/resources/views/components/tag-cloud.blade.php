@props(['tags'])

@if ($tags->isNotEmpty())
    <nav class="fh-tag-cloud" aria-label="Content tags">
        @foreach ($tags as $tag)
            @php $size = min(1.2, .8 + log(max(1, $tag->contents_count ?? 1), 10) * .25); @endphp
            <a href="{{ route('explore', ['tag' => $tag->slug]) }}"
               class="fh-tag-cloud__tag" style="--fh-tag-color:{{ $tag->color }};font-size:{{ $size }}rem">
                {{ $tag->name }}
            </a>
        @endforeach
    </nav>
@endif
