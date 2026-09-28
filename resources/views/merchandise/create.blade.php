<x-app-layout>
    @push('head')
        <title>Add Merchandise — {{ config('app.name') }}</title>
    @endpush

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <a href="{{ route('merchandise.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-400 hover:text-white mb-6 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>

        <h1 class="text-2xl font-bold text-white mb-8">Add Merchandise</h1>

        <form method="POST" action="{{ route('merchandise.store') }}" enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            @include('merchandise._form', ['merchandise' => null])

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg transition">
                    Create
                </button>
                <a href="{{ route('merchandise.index') }}"
                   class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
