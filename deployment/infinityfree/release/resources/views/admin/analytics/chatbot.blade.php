<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('admin.analytics.index') }}" class="hover:text-white transition">Analytics</a>
            <span>/</span>
            <span class="text-white">Chatbot Insights</span>
        </div>
    </x-slot>

    {{-- ── Date Filter ────────────────────────────────────────────────────── --}}
    <form method="GET" action="{{ route('admin.chatbot.analytics') }}"
          class="flex flex-wrap items-end gap-3 mb-6">
        <input type="date" name="from" value="{{ $from->toDateString() }}"
               class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
        <span class="text-gray-500 text-xs self-center">to</span>
        <input type="date" name="to" value="{{ $to->toDateString() }}"
               class="bg-gray-800 border border-gray-700 text-white text-xs rounded-lg px-3 py-1.5 focus:outline-none focus:border-indigo-500">
        <button type="submit"
                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white text-xs rounded-lg transition">
            Apply
        </button>
        <a href="{{ route('admin.faqs.create') }}"
           class="ml-auto px-3 py-1.5 bg-green-600 hover:bg-green-500 text-white text-xs rounded-lg transition">
            + New FAQ
        </a>
    </form>

    {{-- ── Stats Row ──────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        @foreach ([
            ['Conversations',  $chatbotStats['total_conversations'], 'text-white'],
            ['Bot Replies',    $chatbotStats['total_bot_replies'],   'text-white'],
            ['Fallbacks',      $chatbotStats['fallback_count'],      'text-red-400'],
            ['Fallback Rate',  $chatbotStats['fallback_rate'] . '%', 'text-red-400'],
        ] as [$label, $val, $color])
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
            <p class="text-2xl font-bold {{ $color }}">{{ $val }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $label }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- ── FAQ Usage Table ────────────────────────────────────────────── --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-800 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-white">FAQ Usage</h2>
                <span class="text-xs text-gray-500">Times matched · Last matched</span>
            </div>
            <table class="min-w-full divide-y divide-gray-800 text-xs">
                <thead class="bg-gray-800/50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-400 font-medium">Question</th>
                        <th class="px-4 py-2 text-right text-gray-400 font-medium">Hits</th>
                        <th class="px-4 py-2 text-right text-gray-400 font-medium">Last Match</th>
                        <th class="px-4 py-2 text-right text-gray-400 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($faqStats as $row)
                    <tr class="hover:bg-gray-800/30 transition">
                        <td class="px-4 py-2.5 text-gray-300 max-w-xs">
                            <span class="line-clamp-2">{{ $row['question'] }}</span>
                            @if (!$row['is_published'])
                                <span class="text-gray-600 text-[10px]">(unpublished)</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-right font-semibold {{ $row['hits'] > 0 ? 'text-indigo-400' : 'text-gray-600' }}">
                            {{ $row['hits'] }}
                        </td>
                        <td class="px-4 py-2.5 text-right text-gray-500">
                            {{ $row['last_matched'] ? \Carbon\Carbon::parse($row['last_matched'])->diffForHumans() : '—' }}
                        </td>
                        <td class="px-4 py-2.5 text-right">
                            <a href="{{ route('admin.faqs.edit', $row['id']) }}"
                               class="text-indigo-400 hover:text-indigo-300 transition mr-2">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $row['id']) }}"
                                  class="inline" onsubmit="return confirm('Delete this FAQ?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 transition">Del</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-600">No FAQs found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Unmatched Messages ──────────────────────────────────────────── --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-800">
                <h2 class="text-sm font-semibold text-white">Unmatched Messages
                    <span class="text-xs text-gray-500 font-normal ml-1">(triggered fallback)</span>
                </h2>
            </div>
            <div class="divide-y divide-gray-800 max-h-[520px] overflow-y-auto">
                @forelse ($chatbotStats['unmatched_messages'] as $msg)
                <div class="px-5 py-3 flex items-start justify-between gap-3 hover:bg-gray-800/30 transition">
                    <div class="min-w-0">
                        <p class="text-xs text-gray-300 truncate">{{ $msg['user_message'] }}</p>
                        <p class="text-[10px] text-gray-600 mt-0.5">
                            {{ \Carbon\Carbon::parse($msg['at'])->diffForHumans() }}
                        </p>
                    </div>
                    {{-- "Add as FAQ" quick-action: pre-fills the create form --}}
                    <a href="{{ route('admin.faqs.create') }}?question={{ urlencode($msg['user_message']) }}"
                       class="shrink-0 px-2 py-1 bg-indigo-600/20 hover:bg-indigo-600/40 text-indigo-400 text-[10px] rounded transition whitespace-nowrap">
                        + Add FAQ
                    </a>
                </div>
                @empty
                <div class="px-5 py-10 text-center text-gray-600 text-xs">
                    No unmatched messages in this period.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-admin-layout>
