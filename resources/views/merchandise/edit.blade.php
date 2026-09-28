<x-app-layout>
    @push('head')
        <title>Edit Merchandise — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('merchandise.show', $merchandise) }}" class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>

        <h1 class="text-2xl font-bold text-white mb-8">Edit Merchandise</h1>

        <form method="POST" action="{{ route('merchandise.update', $merchandise) }}" enctype="multipart/form-data"
              class="space-y-6">
            @csrf @method('PATCH')

            @include('merchandise._form', ['merchandise' => $merchandise])

            {{-- Existing gallery images --}}
            @if ($merchandise->images->isNotEmpty())
                <div>
                    <p class="text-sm font-medium text-gray-300 mb-2">Current Gallery Images</p>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($merchandise->images as $img)
                            <div class="relative group">
                                <img src="{{ $img->url() }}" class="w-20 h-20 object-cover rounded-lg border border-gray-700">
                                <form method="POST"
                                      action="{{ route('merchandise.images.destroy', [$merchandise, $img]) }}"
                                      onsubmit="return confirm('Remove this image?')">
                                    @csrf @method('DELETE')
                                    <button class="absolute -top-2 -right-2 w-5 h-5 bg-red-600 rounded-full text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">×</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                    Save Changes
                </button>
                <a href="{{ route('merchandise.show', $merchandise) }}"
                   class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
