@props(['item'])

<a href="{{ route('merchandise.show', $item) }}"
   class="group relative flex flex-col rounded-xl overflow-hidden bg-gray-800 border border-gray-700 shadow-lg transition-transform duration-200 hover:scale-[1.02] hover:shadow-2xl hover:border-indigo-500/50 focus:outline-none focus:ring-2 focus:ring-indigo-500">

    {{-- Cover image --}}
    <div class="aspect-square w-full overflow-hidden bg-gray-700">
        <x-media-image :src="$item->imageUrl()" :title="$item->title" :category="$item->category?->name ?? 'Merchandise'" kind="merchandise" :record-key="$item->id" :alt="$item->title" class="w-full h-full object-cover transition-opacity duration-200 group-hover:opacity-80" />
    </div>

    {{-- Tags overlay --}}
    @if ($item->tags->isNotEmpty())
        <div class="absolute top-2 left-2 flex flex-wrap gap-1">
            @foreach ($item->tags as $tag)
                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full border {{ $tag->badgeClass() }}">
                    {{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    {{-- Info --}}
    <div class="p-3 flex flex-col gap-1 flex-1">
        <p class="text-white text-sm font-semibold leading-tight line-clamp-2">{{ $item->title }}</p>
        <div class="flex items-center justify-between mt-auto pt-2">
            <span class="text-indigo-300 text-xs font-bold">{{ $item->formattedPrice() }}</span>
            <span class="text-gray-500 text-[10px] flex items-center gap-1">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                {{ number_format($item->views_count) }}
            </span>
        </div>
    </div>
</a>
