<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Content</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form method="POST" action="{{ route('contents.update', $content) }}"
                      enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="title" value="Title" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                            :value="old('title', $content->title)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="category_id" value="Category" />
                            <select id="category_id" name="category_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">— Select —</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $content->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div>
                            <x-input-label for="type" value="Type" />
                            <select id="type" name="type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">— Select —</option>
                                @foreach (['movie','series','anime','music','game','art','podcast','other'] as $t)
                                    <option value="{{ $t }}" {{ old('type', $content->type) === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('type')" />
                        </div>

                        <div>
                            <x-input-label for="genre" value="Genre" />
                            <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full"
                                :value="old('genre', $content->genre)" placeholder="e.g. Action, K-Pop, RPG" />
                            <x-input-error class="mt-2" :messages="$errors->get('genre')" />
                        </div>

                        <div>
                            <x-input-label for="year" value="Year" />
                            <x-text-input id="year" name="year" type="number" class="mt-1 block w-full"
                                :value="old('year', $content->year)" min="1900" max="{{ date('Y') + 2 }}" />
                            <x-input-error class="mt-2" :messages="$errors->get('year')" />
                        </div>

                        <div>
                            <x-input-label for="release_date" value="Release date" />
                            <input id="release_date" name="release_date" type="date" value="{{ old('release_date', $content->release_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-700 bg-gray-900 text-white shadow-sm focus:border-purple-400 focus:ring-purple-400">
                            <x-input-error class="mt-2" :messages="$errors->get('release_date')" />
                        </div>

                        <div>
                            <x-input-label for="trailer_url" value="Media URL" />
                            <x-text-input id="trailer_url" name="trailer_url" type="url" class="mt-1 block w-full" :value="old('trailer_url', $content->trailer_url)" placeholder="https://…" />
                            <x-input-error class="mt-2" :messages="$errors->get('trailer_url')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="thumbnail" value="Thumbnail" />
                        @if ($content->thumbnail)
                            <div class="mt-2 mb-3 flex items-center gap-3">
                                <img src="{{ $content->thumbnailUrl() }}" alt="Current thumbnail"
                                     class="h-20 w-32 object-cover rounded-md border border-gray-200">
                                <span class="text-xs text-gray-500">Current thumbnail</span>
                            </div>
                        @endif
                        <input id="thumbnail" name="thumbnail" type="file"
                               accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="mt-1 block w-full text-sm text-gray-600
                                      file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0
                                      file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                        <x-input-error class="mt-2" :messages="$errors->get('thumbnail')" />
                    </div>

                    <div>
                        <x-input-label for="body" value="Body / Description" />
                        <textarea id="body" name="body" rows="8"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('body', $content->body) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('body')" />
                    </div>

                    <div>
                        <x-input-label for="status" value="Status" />
                        <select id="status" name="status"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="draft"     {{ old('status', $content->status) === 'draft'     ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $content->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>Update</x-primary-button>
                        <a href="{{ route('contents.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
