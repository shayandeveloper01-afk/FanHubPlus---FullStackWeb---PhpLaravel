<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-white transition">← Events</a>
            <span class="text-gray-600">/</span>
            <h1 class="text-lg font-semibold text-white">Edit Event</h1>
        </div>
    </x-slot>

    <div class="max-w-3xl">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <form method="POST" action="{{ route('admin.events.update', $event) }}">
                @csrf @method('PUT')
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        @error('title')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Category</label>
                        <select name="category_id" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                            <option value="">— None —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $event->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">{{ old('description', $event->description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Venue</label>
                            <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}"
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">City</label>
                            <input type="text" name="city" value="{{ old('city', $event->city) }}"
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Start Date/Time</label>
                            <input type="datetime-local" name="start_datetime"
                                   value="{{ old('start_datetime', $event->start_datetime->format('Y-m-d\TH:i')) }}" required
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                            @error('start_datetime')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">End Date/Time</label>
                            <input type="datetime-local" name="end_datetime"
                                   value="{{ old('end_datetime', $event->end_datetime?->format('Y-m-d\TH:i')) }}"
                                   class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Ticket Link</label>
                        <input type="url" name="ticket_link" value="{{ old('ticket_link', $event->ticket_link) }}"
                               class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-lg px-3 py-2">
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg transition">Update</button>
                    <a href="{{ route('admin.events.index') }}" class="px-5 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-sm rounded-lg transition">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
