{{-- Shared form fields for event create/edit --}}

@once
<style>
    .fh-event-form-shell{position:relative;isolation:isolate;overflow:hidden;padding:clamp(1.1rem,3vw,2rem);border:1px solid rgba(196,181,253,.17);border-radius:1.25rem;background:radial-gradient(ellipse at 100% 0,rgba(139,92,246,.14),transparent 45%),linear-gradient(145deg,rgba(22,20,36,.97),rgba(14,13,23,.98));box-shadow:0 25px 70px rgba(0,0,0,.3),0 0 32px rgba(139,92,246,.07);animation:fh-event-form-enter .45s cubic-bezier(.2,.7,.2,1) both}
    .fh-event-form-shell label{color:#ded9e9!important;font-weight:600}
    .fh-event-form-shell input:not([type=file]),.fh-event-form-shell select,.fh-event-form-shell textarea{width:100%;min-height:44px;border:1px solid rgba(255,255,255,.14)!important;border-radius:.72rem!important;background:rgba(7,8,16,.72)!important;padding:.65rem .8rem;color:#f8f7fb!important;transition:border-color .2s,box-shadow .2s,background .2s}
    .fh-event-form-shell input:focus,.fh-event-form-shell select:focus,.fh-event-form-shell textarea:focus{outline:none!important;border-color:#a78bfa!important;background:#100d1d!important;box-shadow:0 0 0 3px rgba(139,92,246,.2),0 0 20px rgba(139,92,246,.1)!important}
    .fh-event-form-shell select option{background:#17142a;color:white}.fh-event-form-shell input[type=file]{color:#aaa5b8;font-size:.8rem}.fh-event-form-shell input[type=file]::file-selector-button{margin-right:.7rem;padding:.5rem .75rem;border:1px solid rgba(168,85,247,.35);border-radius:.6rem;background:rgba(139,92,246,.14);color:#e9d5ff;cursor:pointer}
    .fh-event-form-shell button[type=submit]{border:1px solid rgba(196,181,253,.24);background:linear-gradient(110deg,#7c3aed,#9333ea 58%,#be185d);box-shadow:0 10px 26px -14px rgba(139,92,246,.9);transition:transform .2s,filter .2s,box-shadow .2s}.fh-event-form-shell button[type=submit]:hover{transform:translateY(-2px);filter:brightness(1.08);box-shadow:0 14px 30px -12px rgba(236,72,153,.55)}.fh-event-form-shell button[type=submit]:disabled{opacity:.75;cursor:wait;transform:none}
    .fh-event-form-preview{display:none;width:min(100%,24rem);max-height:14rem;object-fit:cover;border:1px solid rgba(196,181,253,.25);border-radius:.8rem;box-shadow:0 0 22px rgba(139,92,246,.14)}.fh-event-form-preview.is-visible{display:block;animation:fh-event-form-enter .25s ease both}
    @keyframes fh-event-form-enter{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}@media(prefers-reduced-motion:reduce){.fh-event-form-shell,.fh-event-form-preview{animation:none!important}.fh-event-form-shell input,.fh-event-form-shell select,.fh-event-form-shell textarea,.fh-event-form-shell button{transition:none!important}}
</style>
@endonce

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

    {{-- Title --}}
    <div class="sm:col-span-2">
        <x-input-label for="title" value="Title *" class="text-gray-300" />
        <x-text-input id="title" name="title" type="text"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('title', $event?->title)" required />
        <x-input-error :messages="$errors->get('title')" class="mt-1" />
    </div>

    {{-- Category --}}
    <div>
        <x-input-label for="category_id" value="Category" class="text-gray-300" />
        <select id="category_id" name="category_id"
                class="mt-1 block w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">None</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(old('category_id', $event?->category_id) == $cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('category_id')" class="mt-1" />
    </div>

    @php
        $selectedCountry = old('country', $event?->country ?: config('event_locations.default_country', 'Pakistan'));
        $selectedCity = old('city', $event?->city ?: config('event_locations.default_city', 'Karachi'));
        $availableCities = $countries[$selectedCountry]['cities'] ?? [];
        $isCustomCity = !array_key_exists($selectedCity, $availableCities);
        $catalogCoordinates = $availableCities[$selectedCity] ?? null;
        $hasCustomCoordinates = $event && $catalogCoordinates && $event->latitude !== null && $event->longitude !== null
            && (abs((float) $event->latitude - $catalogCoordinates[0]) > 0.00005 || abs((float) $event->longitude - $catalogCoordinates[1]) > 0.00005);
        $customLocationChecked = old('custom_location', $isCustomCity || $hasCustomCoordinates);
    @endphp
    <div>
        <x-input-label for="event-country" value="Country *" class="text-gray-300" />
        <select id="event-country" name="country" required>
            @foreach ($countries as $countryName => $countryData)
                <option value="{{ $countryName }}" @selected($selectedCountry === $countryName)>{{ $countryName }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('country')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="event-city-choice" value="City *" class="text-gray-300" />
        <select id="event-city-choice" required></select>
        <input id="city" name="city" type="hidden" value="{{ $selectedCity }}">
        <input id="event-custom-city" type="text" value="{{ $isCustomCity ? $selectedCity : '' }}"
               placeholder="Enter city or locality" class="mt-2 {{ $isCustomCity ? '' : 'hidden' }}" maxlength="100">
        <x-input-error :messages="$errors->get('city')" class="mt-1" />
    </div>

    {{-- Venue --}}
    <div class="sm:col-span-2">
        <x-input-label for="venue_name" value="Venue Name *" class="text-gray-300" />
        <x-text-input id="venue_name" name="venue_name" type="text"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('venue_name', $event?->venue_name)" required />
        <x-input-error :messages="$errors->get('venue_name')" class="mt-1" />
    </div>

    {{-- Address --}}
    <div class="sm:col-span-2">
        <x-input-label for="address" value="Address" class="text-gray-300" />
        <x-text-input id="address" name="address" type="text"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('address', $event?->address)" />
        <x-input-error :messages="$errors->get('address')" class="mt-1" />
    </div>

    {{-- Custom location coordinates --}}
    <div class="sm:col-span-2 flex items-center gap-2">
        <input id="custom_location" name="custom_location" type="checkbox" value="1" @checked($customLocationChecked)
               class="h-4 w-4 rounded border-purple-400/40 bg-gray-900 text-purple-500 focus:ring-purple-500">
        <label for="custom_location" class="text-sm text-gray-300">Use a custom city or event location (enter coordinates manually)</label>
    </div>
    <div id="event-coordinate-fields" class="sm:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6 {{ $customLocationChecked ? '' : 'hidden' }}">
    <div>
        <x-input-label for="latitude" value="Latitude" class="text-gray-300" />
        <x-text-input id="latitude" name="latitude" type="number" step="any"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('latitude', $event?->latitude)"
                      placeholder="e.g. 40.7128" />
        <x-input-error :messages="$errors->get('latitude')" class="mt-1" />
    </div>

    <div>
        <x-input-label for="longitude" value="Longitude" class="text-gray-300" />
        <x-text-input id="longitude" name="longitude" type="number" step="any"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('longitude', $event?->longitude)"
                      placeholder="e.g. -74.0060" />
        <x-input-error :messages="$errors->get('longitude')" class="mt-1" />
    </div>
    </div>

    {{-- Start datetime --}}
    <div>
        <x-input-label for="start_datetime" value="Start Date & Time *" class="text-gray-300" />
        <x-text-input id="start_datetime" name="start_datetime" type="datetime-local"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('start_datetime', $event?->start_datetime?->format('Y-m-d\TH:i'))" required />
        <x-input-error :messages="$errors->get('start_datetime')" class="mt-1" />
    </div>

    {{-- End datetime --}}
    <div>
        <x-input-label for="end_datetime" value="End Date & Time" class="text-gray-300" />
        <x-text-input id="end_datetime" name="end_datetime" type="datetime-local"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('end_datetime', $event?->end_datetime?->format('Y-m-d\TH:i'))" />
        <x-input-error :messages="$errors->get('end_datetime')" class="mt-1" />
    </div>

    {{-- Ticket link --}}
    <div class="sm:col-span-2">
        <x-input-label for="ticket_link" value="Ticket Link" class="text-gray-300" />
        <x-text-input id="ticket_link" name="ticket_link" type="url"
                      class="mt-1 block w-full bg-gray-800 border-gray-700 text-white"
                      :value="old('ticket_link', $event?->ticket_link)"
                      placeholder="https://..." />
        <x-input-error :messages="$errors->get('ticket_link')" class="mt-1" />
    </div>

    {{-- Description --}}
    <div class="sm:col-span-2">
        <x-input-label for="description" value="Description" class="text-gray-300" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $event?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-1" />
    </div>

    {{-- Cover image --}}
    <div class="sm:col-span-2">
        <x-input-label for="cover_image" value="Cover Image" class="text-gray-300" />
        @if ($event?->cover_image)
            <x-media-image :src="$event->coverImageUrl()" :title="$event->title" :category="$event->category?->name ?? 'Events'" kind="event" :record-key="$event->id" :alt="'Current '.$event->title.' cover'" class="w-32 h-20 object-cover rounded-lg border border-gray-700 mb-2" />
        @elseif ($event)
            <div class="relative aspect-video max-w-sm overflow-hidden rounded-lg border border-gray-700 mb-2"><x-event-art-fallback :event="$event" /></div>
        @endif
        <input id="cover_image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp"
               class="mt-1 block w-full text-sm text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white file:text-sm hover:file:bg-indigo-500 cursor-pointer">
        <img id="cover_image_preview" class="fh-event-form-preview mt-3" alt="Selected event cover preview">
        <x-input-error :messages="$errors->get('cover_image')" class="mt-1" />
    </div>
</div>

@once
    @push('scripts')
    <script>
    (() => {
        const countries = @json($countries);
        const country = document.getElementById('event-country');
        const cityChoice = document.getElementById('event-city-choice');
        const cityValue = document.getElementById('city');
        const customCity = document.getElementById('event-custom-city');
        const customToggle = document.getElementById('custom_location');
        const coordinateFields = document.getElementById('event-coordinate-fields');
        const latitude = document.getElementById('latitude');
        const longitude = document.getElementById('longitude');
        if (!country || !cityChoice || !cityValue) return;

        const cityMap = () => countries[country.value]?.cities || {};
        function populateCity(selected = null, updateCoordinates = false) {
            const cities = cityMap();
            const known = Object.keys(cities);
            cityChoice.replaceChildren();
            known.forEach(name => cityChoice.add(new Option(name, name)));
            cityChoice.add(new Option('Custom city / location…', '__custom__'));
            if (selected && known.includes(selected)) {
                cityChoice.value = selected;
                customCity?.classList.add('hidden');
            } else if (selected) {
                cityChoice.value = '__custom__';
                if (customCity) { customCity.value = selected; customCity.classList.remove('hidden'); }
                customToggle.checked = true;
            } else if (known.length) {
                cityChoice.value = known[0];
            }
            syncCity(updateCoordinates);
        }
        function syncCity(updateCoordinates = false) {
            const custom = cityChoice.value === '__custom__';
            customCity?.classList.toggle('hidden', !custom);
            if (customCity) customCity.required = custom;
            if (custom) {
                cityValue.value = customCity?.value.trim() || '';
                if (customCity?.value) customToggle.checked = true;
            } else {
                cityValue.value = cityChoice.value;
                const coords = cityMap()[cityChoice.value];
                if (coords && updateCoordinates && !customToggle.checked) { latitude.value = coords[0]; longitude.value = coords[1]; }
            }
            customToggle.checked = custom || customToggle.checked;
            coordinateFields?.classList.toggle('hidden', !customToggle.checked);
        }
        country.addEventListener('change', () => { customToggle.checked = false; populateCity(Object.keys(cityMap())[0] || null, true); });
        cityChoice.addEventListener('change', () => {
            if (cityChoice.value !== '__custom__') customToggle.checked = false;
            syncCity(true);
        });
        customCity?.addEventListener('input', () => syncCity(false));
        customToggle.addEventListener('change', () => coordinateFields?.classList.toggle('hidden', !customToggle.checked));
        cityChoice.form?.addEventListener('submit', () => { syncCity(false); });
        populateCity(@json($selectedCity), false);
        if (customToggle.checked) coordinateFields?.classList.remove('hidden');
    })();
    </script>
    @endpush
@endonce
