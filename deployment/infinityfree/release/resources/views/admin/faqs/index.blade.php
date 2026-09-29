<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-lg font-semibold text-white">FAQs</h1>
            <a href="{{ route('admin.faqs.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">+ New</a>
        </div>
    </x-slot>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="min-w-full divide-y divide-gray-800 text-sm">
            <thead class="bg-gray-800/50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase w-8">#</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Question</th>
                    <th class="px-5 py-3 text-left text-xs font-medium text-gray-400 uppercase">Published</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse ($faqs as $faq)
                <tr class="hover:bg-gray-800/30 transition">
                    <td class="px-5 py-3 text-gray-500">{{ $faq->sort_order }}</td>
                    <td class="px-5 py-3 text-white max-w-md truncate">{{ $faq->question }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-0.5 text-xs rounded-full {{ $faq->is_published ? 'bg-green-500/20 text-green-300' : 'bg-gray-700 text-gray-400' }}">
                            {{ $faq->is_published ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-400 hover:text-indigo-300 transition">Edit</a>
                            <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                                <button class="text-red-400 hover:text-red-300 transition">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-10 text-center text-gray-500">No FAQs found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-4">{{ $faqs->links() }}</div>
    </div>
</x-admin-layout>
