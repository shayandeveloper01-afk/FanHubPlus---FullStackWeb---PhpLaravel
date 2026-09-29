<x-app-layout>
    <section class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
        <header class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-[.18em] text-violet-300">Your account</p>
            <h1 class="mt-1 text-3xl font-bold text-white">My messages</h1>
            <p class="mt-2 text-sm text-gray-400">Contact messages, their status, and replies from the FanHub team.</p>
        </header>

        <div class="space-y-4">
            @forelse ($messages as $message)
                <article class="rounded-xl border border-gray-800 bg-gray-900 p-5">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <h2 class="font-semibold text-white">{{ $message->subject }}</h2>
                            <p class="mt-1 text-xs text-gray-500">Ref: <span class="font-mono text-violet-300">{{ $message->reference_code }}</span> · {{ $message->created_at?->format('M j, Y') }}</p>
                        </div>
                        <span class="rounded-full border px-2.5 py-1 text-xs {{ $message->statusBadgeClass() }}">{{ $message->statusLabel() }}</span>
                    </div>
                    <p class="mt-3 whitespace-pre-line text-sm text-gray-300">{{ $message->message }}</p>
                    @if ($message->admin_notes || $message->admin_reaction)
                        <div class="mt-4 rounded-lg border border-violet-400/15 bg-violet-500/5 p-4">
                            <p class="text-xs font-semibold uppercase tracking-wide text-violet-200">Reply from the FanHub team</p>
                            @if ($message->admin_notes)<p class="mt-2 whitespace-pre-line text-sm text-gray-200">{{ $message->admin_notes }}</p>@endif
                            @if ($message->admin_reaction)<p class="mt-2 text-xs font-semibold text-violet-300">Reaction: {{ ucfirst($message->admin_reaction) }}</p>@endif
                        </div>
                    @else
                        <p class="mt-3 text-xs text-gray-500">The team has not replied yet.</p>
                    @endif
                </article>
            @empty
                <div class="rounded-xl border border-gray-800 bg-gray-900 p-8 text-center">
                    <h2 class="font-semibold text-white">No messages yet</h2>
                    <p class="mt-1 text-sm text-gray-400">Messages you send while signed in will appear here.</p>
                    <a href="{{ route('feedback.create') }}" class="mt-4 inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 font-semibold text-white hover:bg-indigo-500">Contact the team</a>
                </div>
            @endforelse
        </div>
        <div class="mt-6">{{ $messages->links() }}</div>
    </section>
</x-app-layout>
