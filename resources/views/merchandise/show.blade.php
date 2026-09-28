<x-app-layout>
    @push('head')
        <title>{{ $merchandise->title }} — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Back --}}
        <a href="{{ route('merchandise.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Merchandise
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- Gallery --}}
            <div x-data="{ active: '{{ $merchandise->imageUrl() }}' }">
                {{-- Main image --}}
                <div class="aspect-square rounded-xl overflow-hidden bg-gray-800 border border-gray-700">
                    <img :src="active" alt="{{ $merchandise->title }}"
                         class="w-full h-full object-cover">
                </div>

                {{-- Thumbnails --}}
                @if ($merchandise->images->isNotEmpty())
                    <div class="flex gap-2 mt-3 flex-wrap">
                        {{-- Cover thumb --}}
                        <button @click="active = '{{ $merchandise->imageUrl() }}'"
                                class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                                :class="active === '{{ $merchandise->imageUrl() }}' ? 'border-indigo-500' : 'border-gray-700 hover:border-gray-500'">
                            <img src="{{ $merchandise->imageUrl() }}" class="w-full h-full object-cover">
                        </button>
                        @foreach ($merchandise->images as $img)
                            <button @click="active = '{{ $img->url() }}'"
                                    class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                                    :class="active === '{{ $img->url() }}' ? 'border-indigo-500' : 'border-gray-700 hover:border-gray-500'">
                                <img src="{{ $img->url() }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="flex flex-col gap-5">
                {{-- Tags --}}
                @if ($merchandise->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($merchandise->tags as $tag)
                            <span class="text-xs font-semibold px-3 py-1 rounded-full border {{ $tag->badgeClass() }}">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <h1 class="text-2xl font-bold text-white leading-tight">{{ $merchandise->title }}</h1>

                <div class="flex items-center gap-4">
                    <span class="text-3xl font-bold text-indigo-400">{{ $merchandise->formattedPrice() }}</span>
                    <span class="text-gray-500 text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ number_format($merchandise->views_count) }} views
                    </span>
                </div>

                @if ($merchandise->category)
                    <p class="text-indigo-300 text-sm">{{ $merchandise->category->name }}</p>
                @endif

                @if ($merchandise->description)
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $merchandise->description }}</p>
                @endif

                {{-- Buy button --}}
                @if ($merchandise->external_purchase_link)
                    <a href="{{ $merchandise->external_purchase_link }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Buy Now
                    </a>
                @else
                    <div class="px-6 py-3 bg-gray-700 text-gray-400 font-semibold rounded-xl text-center text-sm">
                        No purchase link available
                    </div>
                @endif

                {{-- Owner actions --}}
                @can('update', $merchandise)
                    <div class="flex gap-3 pt-2 border-t border-gray-700">
                        <a href="{{ route('merchandise.edit', $merchandise) }}"
                           class="px-4 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('merchandise.destroy', $merchandise) }}"
                              onsubmit="return confirm('Delete this merchandise?')">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2 text-sm bg-red-600/20 hover:bg-red-600/40 text-red-400 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
