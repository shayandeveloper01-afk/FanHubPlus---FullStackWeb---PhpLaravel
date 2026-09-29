@props(['event'])
<div class="fh-event-art-fallback" role="img" aria-label="Event: {{ $event->category?->name ?? 'Community event' }} in {{ $event->city }}">
    <span>EVENT</span>
    <strong>{{ $event->category?->name ?? 'Community event' }}</strong>
    <small>{{ $event->city }}</small>
</div>
