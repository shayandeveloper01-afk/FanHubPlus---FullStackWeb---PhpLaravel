{{-- Shared form fields for admin content create/edit --}}
<div class="space-y-5">
    <div>
        <label class="block text-sm text-gray-400 mb-1">Title</label>
        <input type="text" name="title" value="{{ old('title', $content->title ?? '') }}" required
               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm text-gray-400 mb-1">Category</label>
            <select name="category_id" required class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                <option value="">— Select —</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $content->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Type</label>
            <select name="type" required class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                @foreach (['movie','series','anime','music','game','art','podcast','other'] as $t)
                    <option value="{{ $t }}" {{ old('type', $content->type ?? '') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Genre</label>
            <input type="text" name="genre" value="{{ old('genre', $content->genre ?? '') }}"
                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-1">Year</label>
            <input type="number" name="year" value="{{ old('year', $content->year ?? '') }}" min="1900" max="{{ date('Y') + 2 }}"
                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
        </div>
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1">Body</label>
        <textarea name="body" rows="8" required
                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('body', $content->body ?? '') }}</textarea>
        @error('body')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm text-gray-400 mb-1">Status</label>
        <select name="status" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
            <option value="draft"     {{ old('status', $content->status ?? 'draft') === 'draft'     ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ old('status', $content->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
    </div>
</div>
