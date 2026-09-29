<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-white transition">← Users</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">{{ $user->name }}</h1>
        </div>
    </x-slot>

        <div class="max-w-4xl space-y-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 flex items-center gap-5">
            <img src="{{ $user->avatarUrl() }}" class="h-16 w-16 rounded-full object-cover">
            <div>
                <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                <div class="flex gap-2 mt-2">
                    @if ($user->is_admin)
                        <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-500/20 text-indigo-300 border border-indigo-500/40">Admin</span>
                    @endif
                    @if ($user->isBanned())
                        <span class="px-2 py-0.5 text-xs rounded-full bg-red-500/20 text-red-300 border border-red-500/40">Banned since {{ $user->banned_at->format('d M Y') }}</span>
                    @endif
                    @if ($user->trashed())
                        <span class="px-2 py-0.5 text-xs rounded-full bg-gray-700 text-gray-400 border border-gray-600">Deleted {{ $user->deleted_at->format('d M Y') }}</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            @foreach ([
                ['label' => 'Content',   'value' => $user->contents()->count()],
                ['label' => 'Articles',  'value' => $user->articles()->count()],
                ['label' => 'Bookmarks', 'value' => $user->bookmarks()->count()],
                ['label' => 'Ratings',   'value' => $user->ratings()->count()],
            ] as $stat)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-indigo-400">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $stat['label'] }}</p>
            </div>
            @endforeach
        </div>

        <section class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900">
            <div class="flex items-center justify-between gap-3 border-b border-gray-800 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-white">User ratings &amp; reviews</h2>
                    <p class="mt-1 text-xs text-gray-500">All star ratings are stored here; review text is public after admin approval.</p>
                </div>
                <a href="{{ route('admin.reviews.index', ['status' => 'all']) }}" class="text-sm font-medium text-violet-300 hover:text-white">Review panel</a>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse ($ratings as $rating)
                    <article class="px-5 py-4">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <p class="font-medium text-white">{{ $rating->content?->title ?? 'Deleted content' }}</p>
                            <div class="flex items-center gap-2">
                                <span class="text-amber-300">{{ $rating->rating }}/5</span>
                                @if ($rating->review)
                                    <span class="rounded-full px-2 py-0.5 text-xs {{ $rating->review_status === 'approved' ? 'bg-emerald-500/10 text-emerald-300' : ($rating->review_status === 'rejected' ? 'bg-rose-500/10 text-rose-300' : 'bg-amber-500/10 text-amber-300') }}">{{ ucfirst($rating->review_status ?? 'pending') }}</span>
                                @else
                                    <span class="text-xs text-gray-500">Rating only</span>
                                @endif
                            </div>
                        </div>
                        @if ($rating->review)<p class="mt-2 whitespace-pre-line text-sm text-gray-300">{{ $rating->review }}</p>@endif
                        <p class="mt-2 text-xs text-gray-600">{{ $rating->created_at?->format('M j, Y g:i A') }}</p>
                    </article>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-500">This user has not rated any content.</p>
                @endforelse
            </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900">
            <div class="flex items-center justify-between border-b border-gray-800 px-5 py-4">
                <div>
                    <h2 class="font-semibold text-white">Contact form messages</h2>
                    <p class="mt-1 text-xs text-gray-500">Replies and reactions are managed in Feedback and shown to the user in My messages.</p>
                </div>
                <a href="{{ route('admin.feedback.index') }}" class="text-sm font-medium text-violet-300 hover:text-white">Feedback inbox</a>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse ($feedbackMessages as $message)
                    <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4">
                        <div>
                            <p class="font-medium text-white">{{ $message->subject }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $message->reference_code }} · {{ $message->statusLabel() }} · {{ $message->created_at?->format('M j, Y') }}</p>
                        </div>
                        <a href="{{ route('admin.feedback.show', $message) }}" class="text-sm text-indigo-300 hover:text-white">Open &amp; reply</a>
                    </div>
                @empty
                    <p class="px-5 py-6 text-sm text-gray-500">No contact form messages from this user.</p>
                @endforelse
            </div>
        </section>

        <div class="grid gap-4 rounded-xl border border-gray-800 bg-gray-900 p-5 text-sm sm:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Account created</p>
                <p class="mt-1 text-white">{{ $user->created_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'Unavailable' }}</p>
                <p class="mt-1 text-xs text-gray-500">Live from the account record · {{ config('app.timezone') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Current password last set / changed</p>
                @if ($user->password_changed_at)
                    <p class="mt-1 text-white">{{ $user->password_changed_at->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') }}</p>
                    <p class="mt-1 text-xs text-gray-500">Exact timestamp saved when the password was last changed or reset.</p>
                @else
                    <p class="mt-1 text-white">{{ $user->created_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'Not recorded' }}</p>
                    <p class="mt-1 text-xs text-amber-300">Estimate from account creation; this older account's exact password-change date was not stored. Future changes and resets will show the exact time.</p>
                @endif
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Account last updated</p>
                <p class="mt-1 text-white">{{ $user->updated_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'Unavailable' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Email verified</p>
                <p class="mt-1 text-white">{{ $user->email_verified_at?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'No' }}</p>
            </div>
            <div class="sm:col-span-2 border-t border-gray-800 pt-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Website data first recorded</p>
                <p class="mt-1 text-white">{{ $firstSiteRecordAt?->timezone(config('app.timezone'))->format('d F Y \\a\\t h:i A') ?? 'No dated records found' }}</p>
                <p class="mt-1 text-xs text-gray-500">Calculated from the earliest user, content, category, article, or contact record. This is the earliest database activity; a separate website launch date is not stored.</p>
            </div>
        </div>
    </div>
</x-admin-layout>
