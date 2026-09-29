<x-app-layout>
    <style>
        .fh-create{--line:rgba(196,181,253,.16);max-width:60rem;margin:0 auto;padding:2rem 1rem 4rem;color:#f4f1fb}
        .fh-create__hero{position:relative;isolation:isolate;overflow:hidden;margin-bottom:1.25rem;padding:clamp(1.4rem,4vw,2.3rem);border:1px solid var(--line);border-radius:1.4rem;background:radial-gradient(ellipse at 85% 0,rgba(192,132,252,.2),transparent 45%),linear-gradient(135deg,#17142a,#100f19);box-shadow:0 24px 65px rgba(0,0,0,.3);animation:fh-create-in .5s cubic-bezier(.2,.7,.2,1) both}
        .fh-create__hero:after{content:"";position:absolute;z-index:-1;right:-5rem;bottom:-9rem;width:18rem;height:18rem;border-radius:50%;background:radial-gradient(circle,rgba(236,72,153,.17),transparent 68%)}
        .fh-create__eyebrow{color:#c4b5fd;font-size:.7rem;font-weight:750;letter-spacing:.16em;text-transform:uppercase}.fh-create h1{margin:.5rem 0;color:white;font-size:clamp(1.6rem,4vw,2.25rem);font-weight:800;letter-spacing:-.04em}.fh-create__hero p{max-width:42rem;margin:0;color:#aaa5b8;font-size:.9rem;line-height:1.6}
        .fh-create__card{padding:clamp(1.1rem,3vw,2rem);border:1px solid var(--line);border-radius:1.25rem;background:linear-gradient(145deg,rgba(22,20,36,.97),rgba(14,13,23,.98));box-shadow:0 25px 70px rgba(0,0,0,.3),0 0 32px rgba(139,92,246,.06);animation:fh-create-in .55s .06s cubic-bezier(.2,.7,.2,1) both}
        .fh-create__grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1.15rem}.fh-create__field{min-width:0}.fh-create__field--full{grid-column:1/-1}.fh-create label{display:block;margin-bottom:.42rem;color:#ded9e9;font-size:.8rem;font-weight:650}
        .fh-create input:not([type=file]),.fh-create select,.fh-create textarea{display:block;width:100%;min-height:46px;border:1px solid rgba(255,255,255,.13);border-radius:.78rem;background:rgba(7,8,16,.72);padding:.72rem .85rem;color:#f8f7fb;font:inherit;font-size:.9rem;transition:border-color .2s,box-shadow .2s,background .2s}.fh-create textarea{min-height:11rem;resize:vertical}.fh-create select option{background:#17142a;color:#fff}.fh-create input::placeholder,.fh-create textarea::placeholder{color:#777387}.fh-create input:focus,.fh-create select:focus,.fh-create textarea:focus{outline:none;border-color:#a78bfa;background:#100d1d;box-shadow:0 0 0 3px rgba(139,92,246,.2),0 0 22px rgba(139,92,246,.1)}
        .fh-create input[type=file]{max-width:100%;color:#aaa5b8;font-size:.8rem}.fh-create input[type=file]::file-selector-button{margin-right:.8rem;padding:.55rem .8rem;border:1px solid rgba(168,85,247,.35);border-radius:.6rem;background:rgba(139,92,246,.14);color:#e9d5ff;font-weight:650;cursor:pointer;transition:background .2s}.fh-create input[type=file]::file-selector-button:hover{background:rgba(139,92,246,.26)}
        .fh-create__hint{margin:.4rem 0 0;color:#858095;font-size:.72rem}.fh-create__error{margin:.4rem 0 0;color:#fca5a5;font-size:.76rem;line-height:1.45}.fh-create__alert{margin-bottom:1rem;padding:.8rem 1rem;border:1px solid rgba(248,113,113,.32);border-radius:.8rem;background:rgba(127,29,29,.18);color:#fecaca;font-size:.84rem}.fh-create__success{margin-bottom:1rem;padding:.8rem 1rem;border:1px solid rgba(52,211,153,.24);border-radius:.8rem;background:rgba(16,185,129,.08);color:#a7f3d0;font-size:.84rem}
        .fh-create__preview{display:none;width:min(100%,25rem);max-height:15rem;margin-top:.8rem;border:1px solid rgba(196,181,253,.25);border-radius:.9rem;object-fit:cover;box-shadow:0 0 24px rgba(139,92,246,.14)}.fh-create__preview.is-visible{display:block;animation:fh-create-in .25s ease both}
        .fh-create__actions{display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;margin-top:1.4rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,.08)}.fh-create__submit{display:inline-flex;min-height:45px;align-items:center;justify-content:center;gap:.6rem;padding:.7rem 1.15rem;border:1px solid rgba(196,181,253,.25);border-radius:.78rem;background:linear-gradient(110deg,#7c3aed,#9333ea 58%,#be185d);color:#fff;font-size:.84rem;font-weight:750;cursor:pointer;box-shadow:0 10px 26px -14px rgba(139,92,246,.9);transition:transform .2s,filter .2s,box-shadow .2s}.fh-create__submit:hover{transform:translateY(-2px);filter:brightness(1.1);box-shadow:0 14px 30px -12px rgba(236,72,153,.65)}.fh-create__submit:focus-visible{outline:2px solid #c4b5fd;outline-offset:3px}.fh-create__submit:disabled{cursor:wait;opacity:.82;transform:none}.fh-create__spinner{display:none;width:1rem;height:1rem;border:2px solid rgba(255,255,255,.35);border-top-color:white;border-radius:50%;animation:fh-create-spin .7s linear infinite}.fh-create__submit[aria-busy=true] .fh-create__spinner{display:block}.fh-create__cancel{color:#aaa5b8;font-size:.82rem;text-decoration:none;transition:color .2s}.fh-create__cancel:hover{color:white}
        @keyframes fh-create-in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}@keyframes fh-create-spin{to{transform:rotate(360deg)}}@media(max-width:600px){.fh-create{padding:1rem .8rem 2.5rem}.fh-create__grid{grid-template-columns:1fr}.fh-create__field--full{grid-column:auto}.fh-create__actions{align-items:stretch}.fh-create__submit{flex:1}}@media(prefers-reduced-motion:reduce){.fh-create__hero,.fh-create__card,.fh-create__preview{animation:none!important}.fh-create__submit,.fh-create input,.fh-create select,.fh-create textarea{transition:none!important}}
    </style>
    <main class="fh-create" aria-labelledby="create-content-title">
        <header class="fh-create__hero"><span class="fh-create__eyebrow">FanHub+ · Community library</span><h1 id="create-content-title">New Content</h1><p>Share a film, series, game, album or fandom favorite with the community.</p></header>
        <section class="fh-create__card">
            @if (session('success'))<div class="fh-create__success" role="status">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="fh-create__alert" role="alert"><strong>Please review the form.</strong><ul class="mt-2 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ route('contents.store') }}" enctype="multipart/form-data" class="fh-create__grid" data-fh-submit>
                @csrf
                <div class="fh-create__field fh-create__field--full"><label for="title">Title <span aria-hidden="true">*</span></label><input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus placeholder="Give your content a memorable title">@error('title')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="category_id">Category <span aria-hidden="true">*</span></label><select id="category_id" name="category_id" required><option value="">— Select category —</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="type">Type</label><select id="type" name="type"><option value="">— Select type —</option>@foreach (['movie','series','anime','music','game','art','podcast','other'] as $t)<option value="{{ $t }}" @selected(old('type') === $t)>{{ ucfirst($t) }}</option>@endforeach</select>@error('type')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="genre">Genre</label><input id="genre" name="genre" type="text" value="{{ old('genre') }}" placeholder="Action, K-Pop, RPG">@error('genre')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="year">Year</label><input id="year" name="year" type="number" value="{{ old('year') }}" min="1900" max="{{ date('Y') + 2 }}" placeholder="{{ date('Y') }}">@error('year')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="release_date">Release date</label><input id="release_date" name="release_date" type="date" value="{{ old('release_date') }}">@error('release_date')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="trailer_url">Media URL</label><input id="trailer_url" name="trailer_url" type="url" value="{{ old('trailer_url') }}" placeholder="https://…">@error('trailer_url')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field fh-create__field--full"><label for="thumbnail">Thumbnail image</label><input id="thumbnail" name="thumbnail" type="file" accept="image/jpeg,image/png,image/webp"><p class="fh-create__hint">JPG, PNG or WebP · up to 2 MB</p><img id="thumbnail-preview" class="fh-create__preview" alt="Selected thumbnail preview">@error('thumbnail')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field fh-create__field--full"><label for="body">Description <span aria-hidden="true">*</span></label><textarea id="body" name="body" rows="8" required placeholder="Tell the community what makes this one special…">{{ old('body') }}</textarea>@error('body')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field"><label for="status">Status</label><select id="status" name="status"><option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status') === 'published')>Published</option></select>@error('status')<p class="fh-create__error">{{ $message }}</p>@enderror</div>
                <div class="fh-create__field fh-create__field--full fh-create__actions"><button type="submit" class="fh-create__submit"><span data-submit-label>Save content</span><span class="fh-create__spinner" aria-hidden="true"></span></button><a href="{{ route('contents.index') }}" class="fh-create__cancel">Cancel</a></div>
            </form>
        </section>
    </main>
    <script>
        (() => {
            const form = document.querySelector('[data-fh-submit]');
            const submit = form?.querySelector('[type="submit"]');
            form?.addEventListener('submit', (event) => {
                if (!form.checkValidity()) { event.preventDefault(); form.reportValidity(); return; }
                if (submit?.disabled) { event.preventDefault(); return; }
                submit.disabled = true; submit.setAttribute('aria-busy', 'true');
                submit.querySelector('[data-submit-label]').textContent = 'Saving…';
            });
            const input = document.getElementById('thumbnail');
            const preview = document.getElementById('thumbnail-preview');
            let previewUrl;
            input?.addEventListener('change', () => {
                if (previewUrl) URL.revokeObjectURL(previewUrl);
                const file = input.files?.[0];
                if (!file) { preview.classList.remove('is-visible'); preview.removeAttribute('src'); return; }
                if (!['image/jpeg','image/png','image/webp'].includes(file.type) || file.size > 2 * 1024 * 1024) {
                    input.value = ''; preview.classList.remove('is-visible'); return;
                }
                previewUrl = URL.createObjectURL(file); preview.src = previewUrl; preview.classList.add('is-visible');
            });
        })();
    </script>
</x-app-layout>
