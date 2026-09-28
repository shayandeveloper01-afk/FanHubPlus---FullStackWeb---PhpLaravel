<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.characters.index') }}" class="text-gray-400 hover:text-white transition">← Characters</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">Edit: {{ $character->name }}</h1>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <form method="POST" action="{{ route('admin.characters.update', $character) }}">
                @csrf @method('PUT')
                @include('admin.characters._form')
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Update</button>
                    <a href="{{ route('admin.characters.index') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
