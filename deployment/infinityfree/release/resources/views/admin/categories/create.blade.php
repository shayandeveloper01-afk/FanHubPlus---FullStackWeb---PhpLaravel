<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-white transition">← Categories</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">New Category</h1>
        </div>
    </x-slot>

    <div class="max-w-xl">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Status</label>
                    <select name="status" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        <option value="active"   {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Create</button>
                    <a href="{{ route('admin.categories.index') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
