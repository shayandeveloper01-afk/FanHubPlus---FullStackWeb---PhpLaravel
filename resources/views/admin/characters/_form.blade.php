<div class="space-y-5">
    <div>
        <label class="block text-sm text-gray-400 mb-1">Content</label>
        <select name="content_id" required class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="">— Select Content —</option>
            @foreach ($contents as $c)
                <option value="{{ $c->id }}" {{ old('content_id', $character->content_id ?? '') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
            @endforeach
        </select>
        @error('content_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-400 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $character->name ?? '') }}" required
                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Alias</label>
            <input type="text" name="alias" value="{{ old('alias', $character->alias ?? '') }}"
                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Role</label>
            <input type="text" name="role" value="{{ old('role', $character->role ?? '') }}"
                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('description', $character->description ?? '') }}</textarea>
    </div>
</div>
