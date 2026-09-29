@props(['size' => 'sm'])

@php
$sizeClass = match($size) {
    'lg' => 'w-8 h-8 border-2',
    'md' => 'w-5 h-5 border-2',
    default => 'w-4 h-4 border-2',
};
@endphp

<svg {{ $attributes->merge(['class' => "animate-spin $sizeClass border-white/30 border-t-white rounded-full"]) }}
     viewBox="0 0 24 24" fill="none">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
</svg>
