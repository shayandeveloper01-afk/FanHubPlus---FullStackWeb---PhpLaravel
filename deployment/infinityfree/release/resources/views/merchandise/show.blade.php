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
                         x-on:error.once="$el.src='{{ \App\Support\ImageArtwork::fallbackSource($merchandise->title, $merchandise->category?->name ?? 'Merchandise', 'merchandise', $merchandise->id) }}'"
                         class="w-full h-full object-cover">
                </div>

                {{-- Thumbnails --}}
                @if ($merchandise->images->isNotEmpty())
                    <div class="flex gap-2 mt-3 flex-wrap">
                        {{-- Cover thumb --}}
                        <button @click="active = '{{ $merchandise->imageUrl() }}'"
                                class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                                :class="active === '{{ $merchandise->imageUrl() }}' ? 'border-indigo-500' : 'border-gray-700 hover:border-gray-500'">
                            <x-media-image :src="$merchandise->imageUrl()" :title="$merchandise->title" :category="$merchandise->category?->name ?? 'Merchandise'" kind="merchandise" :record-key="$merchandise->id" :alt="$merchandise->title" class="w-full h-full object-cover" />
                        </button>
                        @foreach ($merchandise->images as $img)
                            <button @click="active = '{{ $img->url() }}'"
                                    class="w-16 h-16 rounded-lg overflow-hidden border-2 transition"
                                    :class="active === '{{ $img->url() }}' ? 'border-indigo-500' : 'border-gray-700 hover:border-gray-500'">
                                <x-media-image :src="$img->url()" :title="$merchandise->title" :category="$merchandise->category?->name ?? 'Merchandise'" kind="merchandise" :record-key="$img->id" :alt="$merchandise->title.' gallery image'" class="w-full h-full object-cover" />
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

                @php($itemTypeLabel = ['digital_image' => 'Digital image / artwork', 'digital_video' => 'Digital video', 'physical' => 'Physical merchandise'][$merchandise->item_type ?? 'physical'] ?? 'Physical merchandise')
                <span class="inline-flex w-fit items-center gap-2 rounded-full border border-purple-400/25 bg-purple-500/10 px-3 py-1 text-xs font-semibold text-purple-200">{{ $itemTypeLabel }}</span>

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

                {{-- Contact seller to arrange purchase and delivery --}}
                @php($whatsappDigits = preg_replace('/\D+/', '', (string) $merchandise->whatsapp_number))
                @if ($merchandise->whatsapp_number || $merchandise->instagram_url || $merchandise->facebook_url || $merchandise->external_purchase_link)
                    <div class="rounded-xl border border-purple-400/15 bg-slate-900/70 p-4">
                        <p class="mb-3 text-sm font-semibold text-white">Contact the seller to arrange payment and delivery</p>
                        <div class="flex flex-wrap gap-3">
                            @if ($whatsappDigits)
                                <a href="https://wa.me/{{ $whatsappDigits }}?text={{ rawurlencode('Hi, I am interested in '.$merchandise->title) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 font-semibold text-white transition hover:bg-green-500">WhatsApp seller</a>
                            @endif
                            @if ($merchandise->instagram_url)
                                <a href="{{ $merchandise->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-xl bg-fuchsia-700 px-5 py-3 font-semibold text-white transition hover:bg-fuchsia-600">Instagram</a>
                            @endif
                            @if ($merchandise->facebook_url)
                                <a href="{{ $merchandise->facebook_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-700 px-5 py-3 font-semibold text-white transition hover:bg-blue-600">Facebook / Social</a>
                            @endif
                            @if ($merchandise->external_purchase_link)
                                <a href="{{ $merchandise->external_purchase_link }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white transition hover:bg-indigo-500">Purchase / other link</a>
                            @endif
                        </div>
                        <p class="mt-3 text-xs text-gray-400">Payment and digital file delivery are arranged directly with the seller. FanHub+ does not process this payment.</p>
                    </div>
                @else
                    <div class="rounded-xl bg-gray-800 px-6 py-3 text-center text-sm font-semibold text-gray-400">Seller has not added contact or purchase links yet.</div>
                @endif

                {{-- Legacy purchase link fallback is handled in the contact panel above. --}}

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
