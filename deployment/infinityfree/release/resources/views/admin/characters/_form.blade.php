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
        <label class="block text-sm text-gray-400 mb-1" for="admin-character-image">Character image</label>
        @if (!empty($character?->image)) <x-media-image :src="$character->imageUrl()" :title="$character->name" :category="$character->content?->category?->name ?? 'Character'" kind="character" :record-key="$character->id" :alt="'Current '.$character->name.' portrait'" class="w-32 h-32 object-cover rounded-lg border border-gray-700 mb-3" /> @endif
        <input id="admin-character-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white">
        <img id="admin-character-image-preview" alt="Selected character image preview" class="hidden mt-3 w-32 h-32 object-cover rounded-lg border border-purple-500/50">
        <p class="text-xs text-gray-500 mt-1">JPG, PNG or WebP, up to 2 MB.</p>
        @if (!empty($character?->image)) <label class="mt-2 flex items-center gap-2 text-xs text-gray-400"><input type="checkbox" name="remove_image" value="1" class="rounded bg-gray-800 border-gray-600"> Remove current image</label> @endif
        @error('image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        <script>document.getElementById('admin-character-image')?.addEventListener('change',event=>{const preview=document.getElementById('admin-character-image-preview');const file=event.target.files?.[0];if(file){preview.src=URL.createObjectURL(file);preview.classList.remove('hidden')}else{preview.removeAttribute('src');preview.classList.add('hidden')}});</script>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('description', $character->description ?? '') }}</textarea>
    </div>
</div>
