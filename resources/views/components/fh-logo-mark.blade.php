@php($gradientId = 'fh-logo-gradient-' . \Illuminate\Support\Str::uuid())
<svg viewBox="0 0 36 36" width="36" height="36" xmlns="http://www.w3.org/2000/svg"
     {{ $attributes->merge(['class' => 'fh-logo-mark', 'role' => 'img', 'aria-label' => 'FanHub+']) }}>
    <defs>
        <linearGradient id="{{ $gradientId }}" x1="3" y1="3" x2="33" y2="33" gradientUnits="userSpaceOnUse">
            <stop stop-color="#8b5cf6"/>
            <stop offset=".52" stop-color="#a855f7"/>
            <stop offset="1" stop-color="#ec4899"/>
        </linearGradient>
    </defs>
    <rect x="1" y="1" width="34" height="34" rx="10" fill="url(#{{ $gradientId }})"/>
    <path d="M12 25V11h11M12 17h8M23 11v14m0-7h5m0-7v14"
          fill="none" stroke="#fff" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
