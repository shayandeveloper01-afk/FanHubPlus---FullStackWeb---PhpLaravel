<x-admin-layout>
    <h1 class="text-2xl font-bold text-white mb-6">Fan Resource Review</h1>
    <div class="space-y-4">
        @forelse ($resources as $resource)
            <article class="bg-gray-900 border border-gray-800 rounded-xl p-5">
                <h2 class="text-white font-semibold">{{ $resource->title }}</h2>
                <p class="text-gray-400">{{ $resource->type }} · {{ $resource->user->name }} · {{ $resource->file_size_kb }} KB</p>
                @if ($resource->moderation_reason)<p class="text-red-300">{{ $resource->moderation_reason }}</p>@endif
                @unless ($resource->is_approved)
                    <form method="POST" action="{{ route('admin.resources.moderate', $resource) }}" class="mt-3 flex gap-2">
                        @csrf
                        <button name="decision" value="approve" class="px-3 py-2 rounded bg-green-700 text-white">Approve</button>
                        <input name="reason" placeholder="Reason if rejecting" class="rounded bg-gray-800 text-white">
                        <button name="decision" value="reject" class="px-3 py-2 rounded bg-red-700 text-white">Reject</button>
                    </form>
                @endunless
            </article>
        @empty
            <p class="text-gray-400">No submitted resources.</p>
        @endforelse
        {{ $resources->links() }}
    </div>
</x-admin-layout>
