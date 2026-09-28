@props([
    'title',
    'items',
    'myListIds' => [],
    'progress' => [],
    'matchScores' => [],
    'showNew' => false,
    'ranked' => false,
])

<div x-data="{ canLeft: false, canRight: true }"
     x-init="
        const el = $refs.track;
        const update = () => {
            canLeft = el.scrollLeft > 4;
            canRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 4);
        };
        update();
        el.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
     "
     class="relative group/row">

    <div class="flex items-center justify-between mb-3 px-1">
        <h2 class="text-base sm:text-lg font-semibold text-white">{{ $title }}</h2>
    </div>

    <div class="relative">
        {{-- Left arrow --}}
        <button x-show="canLeft" x-transition.opacity @click="$refs.track.scrollBy({ left: -$refs.track.clientWidth * 0.85, behavior: 'smooth' })"
                class="hidden sm:flex absolute -left-3 top-0 bottom-8 z-20 w-10 items-center justify-center
                       bg-gradient-to-r from-gray-950 via-gray-950/80 to-transparent
                       opacity-0 group-hover/row:opacity-100 transition-opacity">
            <span class="w-8 h-8 rounded-full bg-black/60 backdrop-blur flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </span>
        </button>

        {{-- Right arrow --}}
        <button x-show="canRight" x-transition.opacity @click="$refs.track.scrollBy({ left: $refs.track.clientWidth * 0.85, behavior: 'smooth' })"
                class="hidden sm:flex absolute -right-3 top-0 bottom-8 z-20 w-10 items-center justify-center
                       bg-gradient-to-l from-gray-950 via-gray-950/80 to-transparent
                       opacity-0 group-hover/row:opacity-100 transition-opacity">
            <span class="w-8 h-8 rounded-full bg-black/60 backdrop-blur flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </span>
        </button>

        <div x-ref="track"
             class="flex gap-3 sm:gap-4 overflow-x-auto scroll-smooth pb-8 scrollbar-hide snap-x snap-mandatory">
            @foreach ($items as $i => $item)
                @php
                    $inList = in_array($item->id, $myListIds ?? []);
                    $pct = $progress[$item->id] ?? null;
                    $match = $matchScores[$item->id] ?? null;
                    $isNew = $showNew ?? false;
                    // Real poster image with graceful fallback to a themed placeholder
                    $poster = method_exists($item, 'thumbnailUrl') ? $item->thumbnailUrl() : null;
                    $fallback = asset('images/thumbnail-placeholder.svg');
                @endphp
                <a href="{{ route('contents.show', $item) }}"
                   @if(!empty($item->trailer_url)) data-trailer="{{ $item->trailer_url }}" @endif
                   class="fh-card snap-start flex-shrink-0 {{ $ranked ? 'w-40 sm:w-48' : 'w-40 sm:w-48' }} relative rounded-xl overflow-hidden bg-gray-900 border border-gray-800/80 hover:border-indigo-500/50">

                    <div class="relative aspect-[2/3] overflow-hidden bg-gray-800 fh-skel">
                        <img src="{{ $poster ?: $fallback }}"
                             onerror="this.onerror=null;this.src='{{ $fallback }}'"
                             onload="this.closest('.fh-skel').classList.remove('fh-skel')"
                             alt="{{ $item->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                             loading="lazy">

                        @if (!empty($item->trailer_url))
                            <video class="trailer-video absolute inset-0 w-full h-full object-cover opacity-0 [.fh-card:hover_&]:opacity-100 transition-opacity duration-300"
                                   src="{{ $item->trailer_url }}" muted loop playsinline></video>
                        @endif

                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

                        {{-- Ranked number --}}
                        @if ($ranked)
                            <span class="absolute -left-1 -bottom-3 text-6xl font-black text-white/10 leading-none select-none"
                                  style="-webkit-text-stroke:1px rgba(255,255,255,.25);">{{ $i + 1 }}</span>
                        @endif

                        {{-- New badge --}}
                        @if ($isNew)
                            <span class="absolute top-2 left-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-600 text-white">NEW</span>
                        @endif

                        {{-- Match score --}}
                        @if ($match)
                            <span class="absolute top-2 right-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-500/90 text-black">{{ $match }}% match</span>
                        @endif

                        {{-- My List toggle --}}
                        <button type="button"
                                class="mylist-btn absolute bottom-2 right-2 w-7 h-7 rounded-full bg-black/60 hover:bg-black/80 backdrop-blur flex items-center justify-center transition"
                                data-content-id="{{ $item->id }}" data-in-list="{{ $inList ? 'true' : 'false' }}"
                                aria-label="{{ $inList ? 'Remove from My List' : 'Add to My List' }}">
                            <svg class="w-3.5 h-3.5 mylist-icon-add {{ $inList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            <svg class="w-3.5 h-3.5 mylist-icon-check {{ $inList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>

                        {{-- Continue-watching progress bar --}}
                        @if (!is_null($pct))
                            <div class="absolute left-0 right-0 bottom-0 h-1 bg-white/20">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500" style="width: {{ min(100, max(0, $pct)) }}%"></div>
                            </div>
                        @endif
                    </div>

                    <div class="p-2.5">
                        <p class="text-xs sm:text-sm font-semibold leading-snug line-clamp-2 text-gray-100">{{ $item->title }}</p>
                        @if ($item->year ?? null)
                            <p class="text-[11px] text-gray-500 mt-0.5">{{ $item->year }}</p>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
