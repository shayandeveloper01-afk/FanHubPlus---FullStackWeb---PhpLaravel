<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3"><a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-white">← Events</a><span class="text-gray-600">/</span><h1 class="text-lg font-semibold text-white">Edit Event</h1></div>
    </x-slot>
    <div class="max-w-4xl">
        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-rose-500/30 bg-rose-950/30 px-4 py-3 text-sm text-rose-200" role="alert"><p class="font-semibold">Please review these event details.</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" id="adminEventForm" class="fh-event-form-shell">
            @csrf @method('PUT')
            @include('events._form', ['event' => $event])
            <div class="flex gap-3 pt-5"><button type="submit" class="px-5 py-2 text-white rounded-lg">Update Event</button><a href="{{ route('admin.events.index') }}" class="px-5 py-2 bg-gray-800 text-gray-300 rounded-lg">Cancel</a></div>
        </form>
    </div>
    @push('scripts')
    <script>
    (() => { const form = document.getElementById('adminEventForm'); const file = document.getElementById('cover_image'); const preview = document.getElementById('cover_image_preview'); let url;
        form?.addEventListener('submit', () => { const button = form.querySelector('[type=submit]'); if (form.checkValidity() && !button.disabled) { button.disabled = true; button.textContent = 'Saving…'; } });
        file?.addEventListener('change', () => { if (url) URL.revokeObjectURL(url); const image = file.files?.[0]; if (!image) return; url = URL.createObjectURL(image); preview.src = url; preview.classList.add('is-visible'); });
    })();
    </script>
    @endpush
</x-admin-layout>
