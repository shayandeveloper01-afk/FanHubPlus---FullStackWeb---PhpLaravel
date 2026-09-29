<x-app-layout>
    @php($categories = $categories ?? collect())
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Edit Article</h2>
    </x-slot>

    @push('head')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    @endpush

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-6">

                <form method="POST" action="{{ route('articles.update', $article) }}"
                      enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Title *</label>
                        <input name="title" type="text" required value="{{ old('title', $article->title) }}"
                               class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm text-gray-400 mb-1">Category</label>
                        <select id="category_id" name="category_id" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <option value="">— No category —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-red-300 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Excerpt</label>
                        <textarea name="excerpt" rows="2"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('excerpt', $article->excerpt) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Body *</label>
                        <textarea name="body" id="article-body" rows="12"
                                  class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('body', $article->body) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Cover Image</label>
                        @if ($article->cover_image)
                            <div class="mb-2">
                                <x-media-image :src="$article->coverImageUrl()" :title="$article->title" :category="$article->category?->name ?? 'Editorial'" kind="article" :record-key="$article->id" alt="Cover" class="h-24 w-40 object-cover rounded-lg border border-gray-700" />
                            </div>
                        @endif
                        <input name="cover_image" type="file" accept="image/*"
                               class="text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-sm file:bg-gray-700 file:text-gray-200 hover:file:bg-gray-600">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Status</label>
                            <select name="status"
                                    class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="draft"     {{ old('status', $article->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-3 pt-6">
                            <input type="hidden" name="is_featured" value="0">
                            <input id="is_featured" name="is_featured" type="checkbox" value="1"
                                   {{ old('is_featured', $article->is_featured) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_featured" class="text-sm text-gray-300">Feature on homepage</label>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition">
                            Update Article
                        </button>
                        <a href="{{ route('articles.index') }}" class="text-sm text-gray-500 hover:text-gray-300 transition">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    ClassicEditor.create(document.querySelector('#article-body'), {
        toolbar: ['heading','|','bold','italic','underline','strikethrough','|',
                  'bulletedList','numberedList','blockQuote','|',
                  'link','insertTable','|','undo','redo'],
    }).catch(console.error);
    </script>
    @endpush
</x-app-layout>
