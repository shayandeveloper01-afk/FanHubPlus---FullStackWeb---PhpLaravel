<x-admin-layout>
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[.18em] text-violet-300">Community moderation</p>
            <h1 class="mt-1 text-2xl font-bold text-white">Review queue</h1>
            <p class="mt-1 text-sm text-gray-400">User reviews appear publicly only after approval. Star ratings remain saved independently.</p>
        </div>
        <span class="rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-sm font-semibold text-amber-200">{{ $reviews->total() }} {{ $status === 'all' ? 'reviews' : $status }}</span>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg border border-emerald-400/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-200" role="status">{{ session('success') }}</div>
    @endif

    <nav class="mb-5 flex flex-wrap gap-2" aria-label="Review status filter">
        @foreach (['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'all' => 'All reviews'] as $key => $label)
            <a href="{{ route('admin.reviews.index', ['status' => $key]) }}" class="rounded-lg border px-4 py-2 text-sm font-medium transition {{ $status === $key ? 'border-violet-400 bg-violet-500/15 text-violet-200' : 'border-gray-800 bg-gray-900 text-gray-400 hover:text-white' }}">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="space-y-4">
        @forelse ($reviews as $review)
            <article class="rounded-xl border border-gray-800 bg-gray-900 p-5">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-white">{{ $review->content?->title ?? 'Deleted content' }}</h2>
                        <p class="mt-1 text-sm text-gray-400">By {{ $review->user?->name ?? 'Deleted user' }}
                            @if ($review->user?->email) · {{ $review->user->email }} @endif
                            · {{ $review->created_at?->diffForHumans() }}
                        </p>
                    </div>
                    <span class="text-lg tracking-wide text-amber-300" aria-label="{{ $review->rating }} out of 5 stars">{{ str_repeat('★', $review->rating) }}<span class="text-gray-600">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                </div>
                <p class="mt-4 whitespace-pre-line rounded-lg bg-gray-800/70 p-4 text-sm leading-relaxed text-gray-200">{{ $review->review }}</p>
                @if ($review->admin_reaction || $review->admin_reply)
                    <div class="mt-3 rounded-lg border border-violet-400/15 bg-violet-500/5 p-3 text-sm">
                        <p class="font-semibold text-violet-200">Current admin response{{ $review->admin_reaction ? ' · ' . ucfirst($review->admin_reaction) : '' }}</p>
                        @if ($review->admin_reply)<p class="mt-1 whitespace-pre-line text-gray-300">{{ $review->admin_reply }}</p>@endif
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.reviews.moderate', $review) }}" class="mt-4 space-y-3">
                    @csrf
                    <label class="block text-xs font-medium text-gray-400" for="admin-reply-{{ $review->id }}">Reply to the user (shown under their public review after approval)</label>
                    <textarea id="admin-reply-{{ $review->id }}" name="admin_reply" maxlength="2000" rows="3" placeholder="Write a helpful response..." class="w-full rounded-lg border border-gray-700 bg-gray-800 px-3 py-2 text-sm text-white placeholder-gray-500">{{ old('admin_reply', $review->admin_reply) }}</textarea>
                    <div class="flex flex-wrap items-center gap-2">
                        <label class="text-sm text-gray-300" for="admin-reaction-{{ $review->id }}">Reaction</label>
                        <select id="admin-reaction-{{ $review->id }}" name="admin_reaction" class="min-h-10 rounded-lg border border-gray-700 bg-gray-800 px-3 text-sm text-white">
                            <option value="">No reaction</option>
                            <option value="like" @selected(old('admin_reaction', $review->admin_reaction) === 'like')>Like</option>
                            <option value="heart" @selected(old('admin_reaction', $review->admin_reaction) === 'heart')>Heart</option>
                            <option value="thanks" @selected(old('admin_reaction', $review->admin_reaction) === 'thanks')>Thank you</option>
                        </select>
                        <input name="reason" maxlength="1000" placeholder="Optional rejection reason" value="{{ old('reason') }}" class="min-h-10 min-w-56 flex-1 rounded-lg border border-gray-700 bg-gray-800 px-3 text-sm text-white placeholder-gray-500">
                        <button name="decision" value="keep" class="min-h-10 rounded-lg bg-indigo-700 px-4 font-semibold text-white transition hover:bg-indigo-600">Save reply / reaction</button>
                        @if ($review->review_status !== 'approved')<button name="decision" value="approve" class="min-h-10 rounded-lg bg-emerald-700 px-4 font-semibold text-white transition hover:bg-emerald-600">Approve &amp; publish</button>@endif
                        @if ($review->review_status !== 'rejected')<button name="decision" value="reject" class="min-h-10 rounded-lg bg-rose-900 px-4 font-semibold text-white transition hover:bg-rose-800">Reject</button>@endif
                    </div>
                </form>
            </article>
        @empty
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-8 text-center">
                <h2 class="font-semibold text-white">No {{ $status === 'all' ? '' : $status }} reviews found</h2>
                <p class="mt-1 text-sm text-gray-400">Submitted reviews appear here for moderation and admin replies.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">{{ $reviews->links() }}</div>
</x-admin-layout>
