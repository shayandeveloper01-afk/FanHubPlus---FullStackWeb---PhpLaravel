{{-- Shared premium fields for merchandise create/edit --}}

@if ($errors->any())
    <div class="fh-merch-form__errors" role="alert">
        <strong>Please check the highlighted fields.</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<section class="fh-merch-form__panel">
    <div class="fh-merch-form__section-head">
        <span class="fh-merch-form__section-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12H4zM8 5V3m8 2V3M4 10h16m-12 4h3m-3 3h7" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <div>
            <h2>Product details</h2>
            <p>Give your item a clear title, category, and price.</p>
        </div>
    </div>

    <div class="fh-merch-form__grid">
        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label for="title" value="Title *" />
            <x-text-input id="title" name="title" type="text" class="fh-merch-control mt-1 block w-full"
                          :value="old('title', $merchandise?->title)" required placeholder="e.g. FanHub limited edition hoodie" />
            <x-input-error :messages="$errors->get('title')" />
        </div>

        <div class="fh-merch-form__field">
            <x-input-label for="category_id" value="Category *" />
            <select id="category_id" name="category_id" class="fh-merch-control mt-1 block w-full" required>
                <option value="">Select a category</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id', $merchandise?->category_id) == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category_id')" />
        </div>

        <div class="fh-merch-form__field">
            <x-input-label for="status" value="Listing status *" />
            <select id="status" name="status" class="fh-merch-control mt-1 block w-full" required>
                <option value="active" @selected(old('status', $merchandise?->status ?? 'active') === 'active')>Active</option>
                <option value="inactive" @selected(old('status', $merchandise?->status) === 'inactive')>Inactive</option>
            </select>
            <x-input-error :messages="$errors->get('status')" />
        </div>

        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label for="item_type" value="What are you selling? *" />
            <select id="item_type" name="item_type" class="fh-merch-control mt-1 block w-full" required>
                <option value="physical" @selected(old('item_type', $merchandise?->item_type ?? 'physical') === 'physical')>Physical merchandise</option>
                <option value="digital_image" @selected(old('item_type', $merchandise?->item_type) === 'digital_image')>Digital image / artwork</option>
                <option value="digital_video" @selected(old('item_type', $merchandise?->item_type) === 'digital_video')>Digital video</option>
            </select>
            <p class="mt-1 text-xs text-gray-400">Digital files are delivered by you after arranging payment directly with the buyer.</p>
            <x-input-error :messages="$errors->get('item_type')" />
        </div>

        <div class="fh-merch-form__field">
            <x-input-label for="price" value="Price *" />
            @php
                $priceCurrencyCode = strtoupper(old('currency', $merchandise?->currency ?? 'USD'));
                $priceCurrencySymbol = [
                    'USD' => '$', 'PKR' => 'Rs', 'EUR' => '€', 'GBP' => '£', 'INR' => '₹',
                    'JPY' => '¥', 'CNY' => '¥', 'KRW' => '₩', 'AED' => 'د.إ', 'SAR' => '﷼',
                    'TRY' => '₺', 'BRL' => 'R$', 'CHF' => 'CHF',
                ][$priceCurrencyCode] ?? $priceCurrencyCode;
            @endphp
            <div class="fh-merch-form__input-wrap">
                <span id="merchandise-currency-symbol" aria-hidden="true">{{ $priceCurrencySymbol }}</span>
                <x-text-input id="price" name="price" type="number" step="0.01" min="0" class="fh-merch-control mt-1 block w-full"
                              :value="old('price', $merchandise?->price)" required placeholder="0.00" />
            </div>
            <x-input-error :messages="$errors->get('price')" />
        </div>

        <div class="fh-merch-form__field">
            <x-input-label for="currency" value="Currency *" />
            @php($selectedCurrency = strtoupper(old('currency', $merchandise?->currency ?? 'USD')))
            @php($currencies = [
                'USD' => 'US Dollar', 'PKR' => 'Pakistani Rupee', 'EUR' => 'Euro', 'GBP' => 'British Pound',
                'INR' => 'Indian Rupee', 'AED' => 'UAE Dirham', 'SAR' => 'Saudi Riyal', 'QAR' => 'Qatari Riyal',
                'KWD' => 'Kuwaiti Dinar', 'BHD' => 'Bahraini Dinar', 'OMR' => 'Omani Rial', 'CAD' => 'Canadian Dollar',
                'AUD' => 'Australian Dollar', 'NZD' => 'New Zealand Dollar', 'JPY' => 'Japanese Yen', 'CNY' => 'Chinese Yuan',
                'KRW' => 'South Korean Won', 'TRY' => 'Turkish Lira', 'MYR' => 'Malaysian Ringgit', 'SGD' => 'Singapore Dollar',
                'IDR' => 'Indonesian Rupiah', 'THB' => 'Thai Baht', 'ZAR' => 'South African Rand', 'BRL' => 'Brazilian Real',
                'MXN' => 'Mexican Peso', 'CHF' => 'Swiss Franc', 'SEK' => 'Swedish Krona', 'NOK' => 'Norwegian Krone',
                'DKK' => 'Danish Krone', 'PLN' => 'Polish Złoty', 'RUB' => 'Russian Ruble', 'BDT' => 'Bangladeshi Taka',
                'LKR' => 'Sri Lankan Rupee', 'NPR' => 'Nepalese Rupee', 'PHP' => 'Philippine Peso', 'VND' => 'Vietnamese Dong',
            ])
            <select id="currency" name="currency" class="fh-merch-control mt-1 block w-full" required>
                @if (! isset($currencies[$selectedCurrency]) && preg_match('/^[A-Z]{3}$/', $selectedCurrency))
                    <option value="{{ $selectedCurrency }}" selected>{{ $selectedCurrency }} (saved currency)</option>
                @endif
                @foreach ($currencies as $code => $currencyName)
                    <option value="{{ $code }}" @selected($selectedCurrency === $code)>{{ $currencyName }} ({{ $code }})</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('currency')" />
        </div>

        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label for="external_purchase_link" value="Purchase link" />
            <x-text-input id="external_purchase_link" name="external_purchase_link" type="url" class="fh-merch-control mt-1 block w-full"
                          :value="old('external_purchase_link', $merchandise?->external_purchase_link)" placeholder="https://store.example.com/product" />
            <x-input-error :messages="$errors->get('external_purchase_link')" />
        </div>

        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label value="Let buyers contact you" />
            <p class="mb-3 text-xs text-gray-400">Add at least one option: WhatsApp, Instagram, Facebook/social, or a purchase link. Buyers can use it to arrange payment and delivery with you.</p>
            <div class="fh-merch-form__grid">
                <div class="fh-merch-form__field">
                    <x-input-label for="whatsapp_number" value="WhatsApp number (with country code)" />
                    <x-text-input id="whatsapp_number" name="whatsapp_number" type="tel" class="fh-merch-control mt-1 block w-full"
                                  :value="old('whatsapp_number', $merchandise?->whatsapp_number)" placeholder="+92 300 1234567" />
                    <x-input-error :messages="$errors->get('whatsapp_number')" />
                </div>
                <div class="fh-merch-form__field">
                    <x-input-label for="instagram_url" value="Instagram profile link" />
                    <x-text-input id="instagram_url" name="instagram_url" type="url" class="fh-merch-control mt-1 block w-full"
                                  :value="old('instagram_url', $merchandise?->instagram_url)" placeholder="https://instagram.com/yourname" />
                    <x-input-error :messages="$errors->get('instagram_url')" />
                </div>
                <div class="fh-merch-form__field fh-merch-form__field--full">
                    <x-input-label for="facebook_url" value="Facebook / other social profile link" />
                    <x-text-input id="facebook_url" name="facebook_url" type="url" class="fh-merch-control mt-1 block w-full"
                                  :value="old('facebook_url', $merchandise?->facebook_url)" placeholder="https://facebook.com/yourpage" />
                    <x-input-error :messages="$errors->get('facebook_url')" />
                </div>
            </div>
        </div>

        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label for="description" value="Description" />
            <textarea id="description" name="description" rows="5" placeholder="Tell fans what makes this item special...">{{ old('description', $merchandise?->description) }}</textarea>
            <x-input-error :messages="$errors->get('description')" />
        </div>

        <div class="fh-merch-form__field fh-merch-form__field--full">
            <x-input-label value="Tags" />
            <div class="fh-merch-form__tags mt-2">
                @forelse ($tags as $tag)
                    <label class="fh-merch-form__tag">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', $merchandise?->tags->pluck('id')->toArray() ?? [])))>
                        <span class="text-sm px-2 py-0.5 rounded-full border {{ $tag->badgeClass() }}">{{ $tag->name }}</span>
                    </label>
                @empty
                    <p class="text-sm text-gray-500">No merchandise tags are available yet.</p>
                @endforelse
            </div>
            <x-input-error :messages="$errors->get('tags')" />
        </div>
    </div>
</section>

<section class="fh-merch-form__panel fh-merch-form__panel--media">
    <div class="fh-merch-form__section-head">
        <span class="fh-merch-form__section-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.7"/><circle cx="8.5" cy="9" r="1.5"/><path d="m21 15-5-5L5 20" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <div>
            <h2>Product imagery</h2>
            <p>Add a cover image and optional gallery photos.</p>
        </div>
    </div>

    <div class="fh-merch-form__grid">
        <div class="fh-merch-form__field">
            <x-input-label for="image" value="Cover image" />
            <label class="fh-merch-upload mt-2" for="image">
                @if ($merchandise?->image)
                    <x-media-image id="cover-preview" :src="$merchandise->imageUrl()" :title="$merchandise->title" :category="$merchandise->category?->name ?? 'Merchandise'" kind="merchandise" :record-key="$merchandise->id" :alt="'Current '.$merchandise->title.' product image'" class="fh-merch-upload__preview" />
                @else
                    <img id="cover-preview" class="fh-merch-upload__preview" alt="Selected cover image preview" hidden>
                    <span id="cover-placeholder" class="fh-merch-upload__placeholder" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 16V4m0 0L7 9m5-5 5 5M5 14v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                @endif
                <span class="fh-merch-upload__copy"><strong>Choose a cover image</strong><small>Click to browse · image files</small><small id="cover-file-name" class="fh-merch-upload__filename"></small></span>
                <input id="image" name="image" type="file" accept="image/*">
            </label>
            <x-input-error :messages="$errors->get('image')" />
        </div>

        <div class="fh-merch-form__field">
            <x-input-label for="gallery" value="Gallery images (up to 6)" />
            <label class="fh-merch-upload fh-merch-upload--gallery mt-2" for="gallery">
                <span class="fh-merch-upload__placeholder" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 16V4m0 0L7 9m5-5 5 5M5 14v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                <span class="fh-merch-upload__copy"><strong>Choose gallery images</strong><small>Select up to six additional photos</small><small id="gallery-file-name" class="fh-merch-upload__filename"></small></span>
                <input id="gallery" name="gallery[]" type="file" accept="image/*" multiple>
            </label>
            <div id="gallery-preview" class="fh-merch-gallery-preview" aria-live="polite"></div>
            <x-input-error :messages="$errors->get('gallery')" />
        </div>
    </div>
</section>

@once
    @push('scripts')
        <script>
            (() => {
                const coverInput = document.getElementById('image');
                const coverPreview = document.getElementById('cover-preview');
                const coverPlaceholder = document.getElementById('cover-placeholder');
                const coverName = document.getElementById('cover-file-name');
                let coverUrl = null;

                coverInput?.addEventListener('change', () => {
                    const file = coverInput.files?.[0];
                    if (!file) return;
                    if (coverUrl) URL.revokeObjectURL(coverUrl);
                    coverUrl = URL.createObjectURL(file);
                    coverPreview.src = coverUrl;
                    coverPreview.hidden = false;
                    if (coverPlaceholder) coverPlaceholder.hidden = true;
                    coverName.textContent = file.name;
                });

                const galleryInput = document.getElementById('gallery');
                const galleryPreview = document.getElementById('gallery-preview');
                const galleryName = document.getElementById('gallery-file-name');
                let galleryUrls = [];
                galleryInput?.addEventListener('change', () => {
                    galleryUrls.forEach((url) => URL.revokeObjectURL(url));
                    galleryUrls = [];
                    galleryPreview.replaceChildren();
                    const files = Array.from(galleryInput.files || []).slice(0, 6);
                    galleryName.textContent = files.length ? `${files.length} image${files.length === 1 ? '' : 's'} selected` : '';
                    files.forEach((file) => {
                        const url = URL.createObjectURL(file);
                        galleryUrls.push(url);
                        const image = document.createElement('img');
                        image.src = url;
                        image.alt = file.name;
                        image.title = file.name;
                        galleryPreview.append(image);
                    });
                });

            const currencyInput = document.getElementById('currency');
            const currencySymbol = document.getElementById('merchandise-currency-symbol');
            const currencySymbols = { USD: '$', PKR: 'Rs', EUR: '€', GBP: '£', INR: '₹', JPY: '¥', CNY: '¥', KRW: '₩', AED: 'د.إ', SAR: '﷼', TRY: '₺', BRL: 'R$', CHF: 'CHF' };
            currencyInput?.addEventListener('change', () => {
                const code = currencyInput.value.trim().toUpperCase();
                currencySymbol.textContent = currencySymbols[code] || code || '¤';
            });
            })();
        </script>
    @endpush
@endonce
