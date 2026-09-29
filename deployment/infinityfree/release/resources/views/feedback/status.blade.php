<x-app-layout>
    <x-slot name="header">
        <x-breadcrumb :crumbs="[['label' => 'Feedback', 'url' => route('feedback.create')], ['label' => 'Track Status']]" />
        <h1 class="text-lg font-semibold text-white mt-1">Track Feedback Status</h1>
    </x-slot>

    <div class="max-w-2xl mx-auto px-4 py-10">

        <form method="POST" action="{{ route('feedback.status') }}"
              class="bg-gray-900 border border-gray-800 rounded-2xl p-6 sm:p-8 space-y-4">
            @csrf
            <p class="text-sm text-gray-400">Enter the reference code shown after you submitted feedback (e.g. <code class="text-indigo-400">AB12CD34</code>).</p>

            <div class="flex gap-3">
                <x-text-input name="query" type="text" class="flex-1"
                              placeholder="Reference code"
                              value="{{ old('query', request('query')) }}" required
                              aria-label="Feedback reference code" />
                <button type="submit" id="statusBtn"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition whitespace-nowrap">
                    <span id="statusText">Check Status</span>
                    <x-spinner class="hidden" id="statusSpinner" />
                </button>
            </div>
            <x-input-error :messages="$errors->get('query')" />
        </form>

        @push('scripts')
        <script>
            document.querySelector('form')?.addEventListener('submit', function () {
                document.getElementById('statusSpinner')?.classList.remove('hidden');
                document.getElementById('statusText').textContent = 'Checking…';
                document.getElementById('statusBtn').disabled = true;
            });
        </script>
        @endpush

        @if ($searched)
            <div class="mt-8 space-y-4">
                @forelse ($feedback as $item)
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <p class="text-white font-medium text-sm">{{ $item->subject }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">
                                Ref: <span class="text-indigo-400 font-mono">{{ $item->reference_code }}</span>
                                · {{ $item->created_at->format('M j, Y') }}
                            </p>
                        </div>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full border {{ $item->statusBadgeClass() }}">
                            {{ $item->statusLabel() }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-400 mt-3 line-clamp-3">{{ $item->message }}</p>
                    @if ($item->admin_notes)
                        <div class="mt-3 pt-3 border-t border-gray-800">
                            <p class="text-xs text-violet-300 mb-1">Reply from the FanHub team:</p>
                            <p class="text-sm text-gray-300">{{ $item->admin_notes }}</p>
                        </div>
                    @endif
                    @if ($item->admin_reaction)
                        <p class="mt-3 text-xs font-semibold text-violet-300">FanHub reaction: {{ ucfirst($item->admin_reaction) }}</p>
                    @endif
                </div>
                @empty
                <div class="text-center py-12 text-gray-500 text-sm">
                    No feedback found for that reference code.
                </div>
                @endforelse
            </div>
        @endif
    </div>
</x-app-layout>
