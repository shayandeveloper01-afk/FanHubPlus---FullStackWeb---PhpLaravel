<x-app-layout>
    @push('head')
        <title>Add Merchandise — {{ config('app.name') }}</title>
    @endpush

    <div class="fh-merch-editor max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('merchandise.index') }}" class="fh-merch-editor__back inline-flex items-center gap-1 text-sm text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>

        <header class="fh-merch-editor__hero">
            <span class="fh-merch-editor__eyebrow">FanHub+ Marketplace <i></i> Creator studio</span>
            <h1 class="fh-merch-editor__title">Add Merchandise</h1>
            <p class="fh-merch-editor__description">Create a standout listing fans will love. Add the details, set your price, and give it a polished gallery.</p>
            <div class="fh-merch-editor__meta"><span>✦ Premium listing</span><span>◈ Image gallery</span></div>
        </header>

        <form method="POST" action="{{ route('merchandise.store') }}" enctype="multipart/form-data"
              class="fh-merch-form space-y-6">
            @csrf

            @include('merchandise._form', ['merchandise' => null])

            <div class="fh-merch-form__actions flex gap-3 pt-2">
                <button type="submit"
                        class="fh-merch-submit px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                    Create
                </button>
                <a href="{{ route('merchandise.index') }}"
                   class="fh-merch-cancel px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
