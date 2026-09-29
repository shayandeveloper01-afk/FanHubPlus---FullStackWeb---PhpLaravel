<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.articles.index') }}" class="text-gray-400 hover:text-white transition">← Articles</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">Edit Article</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.articles.update', $article) }}">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required
                               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1" for="admin-article-cover">Featured image</label>
                        <x-media-image :src="$article->coverImageUrl()" :title="$article->title" :category="$article->category?->name ?? 'Editorial'" kind="article" :record-key="$article->id" :alt="'Current '.$article->title.' cover'" class="w-48 aspect-video object-cover rounded-lg border border-gray-700 mb-3" />
                        <input id="admin-article-cover" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" class="block w-full text-sm text-gray-300 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-white">
                        <img id="admin-article-cover-preview" alt="Selected article cover preview" class="hidden mt-3 w-48 aspect-video object-cover rounded-lg border border-purple-500/50">
                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or WebP, up to 3 MB.</p>
                        <label class="mt-2 flex items-center gap-2 text-xs text-gray-400"><input type="checkbox" name="remove_cover_image" value="1" class="rounded bg-gray-800 border-gray-600"> Remove current cover</label>
                        @error('cover_image')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        <script>document.getElementById('admin-article-cover')?.addEventListener('change',event=>{const preview=document.getElementById('admin-article-cover-preview');const file=event.target.files?.[0];if(file){preview.src=URL.createObjectURL(file);preview.classList.remove('hidden')}else{preview.removeAttribute('src');preview.classList.add('hidden')}});</script>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Excerpt</label>
                        <textarea name="excerpt" rows="2"
                                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Body</label>
                        <textarea name="body" rows="10" required
                                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('body', $article->body) }}</textarea>
                        @error('body')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm text-gray-400 mb-1">Status</label>
                            <select name="status" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                                <option value="draft"     {{ old('status', $article->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-600 bg-gray-800 text-indigo-600">
                                Featured
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Update</button>
                    <a href="{{ route('admin.articles.index') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
