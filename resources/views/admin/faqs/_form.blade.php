@php
    $keywordValue = old('keywords');
    if ($keywordValue === null) {
        $keywordValue = isset($faq) ? implode(', ', $faq->keywordList()) : '';
    } elseif (is_array($keywordValue)) {
        $keywordValue = implode(', ', $keywordValue);
    }
@endphp

<div>
    <label class="block text-sm text-gray-400 mb-1">Question</label>
    <input type="text" name="question" value="{{ old('question', $faq->question ?? request('question', '')) }}" required maxlength="500"
           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
    @error('question')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm text-gray-400 mb-1">Answer</label>
    <textarea name="answer" rows="5" required
              class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('answer', $faq->answer ?? '') }}</textarea>
    @error('answer')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div>
    <label class="block text-sm text-gray-400 mb-1">Keywords <span class="text-gray-600 text-xs">(comma-separated, for search)</span></label>
    <input type="text" name="keywords" value="{{ $keywordValue }}" maxlength="500"
           class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
    @error('keywords')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-400 mb-1">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0"
               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
    </div>
    <div class="flex items-end pb-1">
        <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
            <input type="checkbox" name="is_published" value="1"
                   {{ old('is_published', $faq->is_published ?? false) ? 'checked' : '' }}
                   class="rounded border-gray-600 bg-gray-800 text-indigo-600">
            Published
        </label>
    </div>
</div>
