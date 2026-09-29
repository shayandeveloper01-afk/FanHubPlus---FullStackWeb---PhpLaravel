<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.merchandise.index') }}" class="text-gray-400 hover:text-white transition">← Merchandise</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">Edit Merchandise</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.merchandise.update', $merchandise) }}">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $merchandise->title) }}" required
                               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Category</label>
                        <select name="category_id" required class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                            <option value="">— Select —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $merchandise->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1" for="admin-merch-image">Product image</label>
                        @if ($currentImageUrl = $merchandise->imageUrl())
                            <img src="{{ $currentImageUrl }}" alt="Current {{ $merchandise->title }} product image" class="w-32 h-32 object-cover rounded-lg border border-gray-700 mb-3">
                        @else
                            <div class="mb-3 flex h-32 w-32 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-center text-xs text-gray-400">No product photo</div>
                        @endif
                        <input id="admin-merch-image" type="file" name="image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white">
                        <img id="admin-merch-image-preview" alt="Selected product image preview" class="hidden mt-3 w-32 h-32 object-cover rounded-lg border border-purple-500/50">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or WebP, up to 3 MB.</p>
                        <label class="mt-2 flex items-center gap-2 text-xs text-gray-400"><input type="checkbox" name="remove_image" value="1" class="rounded bg-gray-800 border-gray-600"> Remove current image</label>
                        @error('image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        <script>document.getElementById('admin-merch-image')?.addEventListener('change',event=>{const preview=document.getElementById('admin-merch-image-preview');const file=event.target.files?.[0];if(file){preview.src=URL.createObjectURL(file);preview.classList.remove('hidden')}else{preview.removeAttribute('src');preview.classList.add('hidden')}});</script>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('description', $merchandise->description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Price</label>
                            <input type="number" name="price" value="{{ old('price', $merchandise->price) }}" step="0.01" min="0" required
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                            @error('price')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Currency</label>
                            <input type="text" name="currency" value="{{ old('currency', $merchandise->currency) }}" required maxlength="10"
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Status</label>
                        <select name="status" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                            <option value="active"   {{ old('status', $merchandise->status) === 'active'   ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $merchandise->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Update</button>
                    <a href="{{ route('admin.merchandise.index') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
