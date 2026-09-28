<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.feedback.index') }}" class="text-gray-400 hover:text-white transition">← Feedback</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white truncate">{{ $feedback->subject }}</h1>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Breadcrumb --}}
        <div class="lg:col-span-3">
            <x-breadcrumb :crumbs="[
                ['label' => 'Feedback', 'url' => route('admin.feedback.index')],
                ['label' => $feedback->subject],
            ]" />
        </div>

        {{-- Message --}}
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 text-xs rounded-full border {{ $feedback->typeBadgeClass() }}">{{ ucfirst($feedback->type) }}</span>
                    <span class="px-2.5 py-1 text-xs rounded-full border {{ $feedback->statusBadgeClass() }}">{{ $feedback->statusLabel() }}</span>
                    <span class="text-xs text-gray-500 ml-auto">{{ $feedback->created_at->format('d F Y \\a\\t h:i A') }}</span>
                </div>
                <h2 class="text-white font-semibold mb-3">{{ $feedback->subject }}</h2>
                <p class="text-gray-300 text-sm leading-relaxed whitespace-pre-wrap">{{ $feedback->message }}</p>
            </div>

            {{-- Submitter info --}}
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-5 text-sm space-y-2">
                <p class="text-gray-400 font-medium text-xs uppercase tracking-wide mb-3">Submitted By</p>
                <p class="text-white">{{ $feedback->user?->name ?? $feedback->name ?? 'Anonymous' }}</p>
                @if ($feedback->email)
                    <p class="text-gray-400">{{ $feedback->email }}</p>
                @endif
                <p class="text-gray-500 font-mono text-xs">Ref: {{ $feedback->reference_code }}</p>
            </div>
        </div>

        {{-- Update status --}}
        <div>
            <form method="POST" action="{{ route('admin.feedback.update', $feedback) }}"
                  class="bg-gray-900 border border-gray-800 rounded-xl p-5 space-y-4">
                @csrf @method('PATCH')

                <p class="text-sm font-medium text-white">Update Status</p>

                <div>
                    <x-input-label for="status" value="Status" />
                    <select id="status" name="status"
                            class="mt-1 block w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        <option value="new"       {{ $feedback->status === 'new'       ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed"  {{ $feedback->status === 'reviewed'  ? 'selected' : '' }}>In Review</option>
                        <option value="resolved"  {{ $feedback->status === 'resolved'  ? 'selected' : '' }}>Resolved</option>
                        <option value="dismissed" {{ $feedback->status === 'dismissed' ? 'selected' : '' }}>Dismissed</option>
                    </select>
                </div>

                <div>
                    <x-input-label for="admin_notes" value="Admin Notes (visible to user)" />
                    <textarea id="admin_notes" name="admin_notes" rows="5"
                              class="mt-1 block w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 resize-none">{{ old('admin_notes', $feedback->admin_notes) }}</textarea>
                </div>

                <x-primary-button class="w-full justify-center">Save Changes</x-primary-button>
            </form>
        </div>
    </div>
</x-admin-layout>
