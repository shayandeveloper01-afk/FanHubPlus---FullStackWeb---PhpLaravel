<x-app-layout>
    @push('head')
        <title>Add Event — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 text-gray-100">
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>

        <div class="mb-6 rounded-2xl border border-purple-300/15 bg-gradient-to-br from-purple-950/70 via-gray-950 to-pink-950/30 p-6 sm:p-8 shadow-2xl">
            <p class="text-xs font-bold uppercase tracking-[.18em] text-purple-200">FanHub+ Community</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white">Add Event</h1>
            <p class="mt-2 text-sm text-gray-300">Share an upcoming gathering with fans. Location coordinates are optional; we never fill unverified coordinates.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-rose-500/30 bg-rose-950/30 px-4 py-3 text-sm text-rose-200" role="alert">
                <p class="font-semibold">Please review these event details.</p>
                <ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data"
              id="eventForm" class="fh-event-form-shell">
            @csrf

            @include('events._form', ['event' => null])

            <div class="flex flex-wrap gap-3 pt-5">
                <button type="submit" id="eventSubmitBtn"
                        class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                    <span id="eventSubmitText">Create Event</span>
                    <x-spinner class="hidden" id="eventSubmitSpinner" />
                </button>
                <a href="{{ route('events.index') }}"
                   class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('eventForm')?.addEventListener('submit', function () {
            if (!this.checkValidity()) return;
            const button = document.getElementById('eventSubmitBtn');
            if (button.disabled) return;
            document.getElementById('eventSubmitSpinner')?.classList.remove('hidden');
            document.getElementById('eventSubmitText').textContent = 'Creating…';
            button.disabled = true;
        });
        (() => {
            const input = document.getElementById('cover_image');
            const preview = document.getElementById('cover_image_preview');
            let currentUrl;
            input?.addEventListener('change', () => {
                if (currentUrl) URL.revokeObjectURL(currentUrl);
                const file = input.files?.[0];
                if (!file) { preview.classList.remove('is-visible'); preview.removeAttribute('src'); return; }
                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 3 * 1024 * 1024) {
                    input.value = ''; preview.classList.remove('is-visible'); return;
                }
                currentUrl = URL.createObjectURL(file); preview.src = currentUrl; preview.classList.add('is-visible');
            });
        })();
    </script>
    @endpush
</x-app-layout>
