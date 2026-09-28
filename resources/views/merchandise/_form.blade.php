{{-- Shared form fields for merchandise create/edit --}}

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    {{-- Title --}}
    <div class="sm:col-span-2">
        <x-input-label for="title" value="Title *" class="text-gray-300" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('title', $merchandise?->title)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
    </div>

    {{-- Category --}}
    <div>
        <x-input-label for="category_id" value="Category *" class="text-gray-300" />
        <select id="category_id" name="category_id"
                class="mt-1 block w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">Select category</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $merchandise?->category_id) == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
    </div>

    {{-- Status --}}
    <div>
        <x-input-label for="status" value="Status *" class="text-gray-300" />
        <select id="status" name="status"
                class="mt-1 block w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="active"   @selected(old('status', $merchandise?->status ?? 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $merchandise?->status) === 'inactive')>Inactive</option>
        </select>
        <x-input-error :messages="$errors->get('status')" class="mt-1" />
    </div>

    {{-- Price --}}
    <div>
        <x-input-label for="price" value="Price *" class="text-gray-300" />
        <x-text-input id="price" name="price" type="number" step="0.01" min="0"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('price', $merchandise?->price)" required />
        <x-input-error :messages="$errors->get('price')" class="mt-1" />
    </div>

    {{-- Currency --}}
    <div>
        <x-input-label for="currency" value="Currency *" class="text-gray-300" />
        <x-text-input id="currency" name="currency" type="text" maxlength="3"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('currency', $merchandise?->currency ?? 'USD')" required />
        <x-input-error :messages="$errors->get('currency')" class="mt-1" />
    </div>

    {{-- Purchase link --}}
    <div class="sm:col-span-2">
        <x-input-label for="external_purchase_link" value="Purchase Link" class="text-gray-300" />
        <x-text-input id="external_purchase_link" name="external_purchase_link" type="url"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('external_purchase_link', $merchandise?->external_purchase_link)"
                      placeholder="https://..." />
        <x-input-error :messages="$errors->get('external_purchase_link')" class="mt-1" />
    </div>

    {{-- Description --}}
    <div class="sm:col-span-2">
        <x-input-label for="description" value="Description" class="text-gray-300" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $merchandise?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-1" />
    </div>

    {{-- Tags --}}
    <div class="sm:col-span-2">
        <x-input-label value="Tags" class="text-gray-300 mb-2" />
        <div class="flex flex-wrap gap-3">
            @foreach ($tags as $tag)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                           class="rounded border-gray-600 bg-gray-800 text-indigo-500 focus:ring-indigo-500"
                           @checked(in_array($tag->id, old('tags', $merchandise?->tags->pluck('id')->toArray() ?? [])))>
                    <span class="text-sm px-2 py-0.5 rounded-full border {{ $tag->badgeClass() }}">{{ $tag->name }}</span>
                </label>
            @endforeach
        </div>
        <x-input-error :messages="$errors->get('tags')" class="mt-1" />
    </div>

    {{-- Cover image --}}
    <div>
        <x-input-label for="image" value="Cover Image" class="text-gray-300" />
        @if ($merchandise?->image)
            <img src="{{ $merchandise->imageUrl() }}" class="w-24 h-24 object-cover rounded-lg border border-gray-700 mb-2">
        @endif
        <input id="image" name="image" type="file" accept="image/*"
               class="mt-1 block w-full text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white file:text-sm hover:file:bg-indigo-500 cursor-pointer">
        <x-input-error :messages="$errors->get('image')" class="mt-1" />
    </div>

    {{-- Gallery --}}
    <div>
        <x-input-label for="gallery" value="Gallery Images (up to 6)" class="text-gray-300" />
        <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple
               class="mt-1 block w-full text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-700 file:text-white file:text-sm hover:file:bg-gray-600 cursor-pointer">
        <x-input-error :messages="$errors->get('gallery')" class="mt-1" />
    </div>
</div>
