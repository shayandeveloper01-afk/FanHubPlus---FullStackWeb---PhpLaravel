<x-app-layout>
    @push('head')<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>@endpush
    <style>
        .fh-write{--line:rgba(196,181,253,.16);max-width:64rem;margin:0 auto;padding:2rem 1rem 4rem;color:#f4f1fb}.fh-write__hero{position:relative;isolation:isolate;overflow:hidden;margin-bottom:1.25rem;padding:clamp(1.4rem,4vw,2.3rem);border:1px solid var(--line);border-radius:1.4rem;background:radial-gradient(ellipse at 85% 0,rgba(192,132,252,.2),transparent 45%),linear-gradient(135deg,#17142a,#100f19);box-shadow:0 24px 65px rgba(0,0,0,.3);animation:fh-write-in .5s cubic-bezier(.2,.7,.2,1) both}.fh-write__hero:after{content:"";position:absolute;z-index:-1;right:-5rem;bottom:-9rem;width:18rem;height:18rem;border-radius:50%;background:radial-gradient(circle,rgba(236,72,153,.17),transparent 68%)}.fh-write__eyebrow{color:#c4b5fd;font-size:.7rem;font-weight:750;letter-spacing:.16em;text-transform:uppercase}.fh-write h1{margin:.5rem 0;color:white;font-size:clamp(1.6rem,4vw,2.25rem);font-weight:800;letter-spacing:-.04em}.fh-write__hero p{margin:0;color:#aaa5b8;font-size:.9rem;line-height:1.6}.fh-write__card{padding:clamp(1.1rem,3vw,2rem);border:1px solid var(--line);border-radius:1.25rem;background:linear-gradient(145deg,rgba(22,20,36,.97),rgba(14,13,23,.98));box-shadow:0 25px 70px rgba(0,0,0,.3),0 0 32px rgba(139,92,246,.06);animation:fh-write-in .55s .06s cubic-bezier(.2,.7,.2,1) both}.fh-write__grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1.15rem}.fh-write__field{min-width:0}.fh-write__field--full{grid-column:1/-1}.fh-write label{display:block;margin-bottom:.42rem;color:#ded9e9;font-size:.8rem;font-weight:650}.fh-write input:not([type=file]),.fh-write select,.fh-write textarea{display:block;width:100%;min-height:46px;border:1px solid rgba(255,255,255,.13);border-radius:.78rem;background:rgba(7,8,16,.72);padding:.72rem .85rem;color:#f8f7fb;font:inherit;font-size:.9rem;transition:border-color .2s,box-shadow .2s,background .2s}.fh-write textarea{min-height:9rem;resize:vertical}.fh-write select option{background:#17142a;color:#fff}.fh-write input::placeholder,.fh-write textarea::placeholder{color:#777387}.fh-write input:focus,.fh-write select:focus,.fh-write textarea:focus{outline:none;border-color:#a78bfa;background:#100d1d;box-shadow:0 0 0 3px rgba(139,92,246,.2),0 0 22px rgba(139,92,246,.1)}.fh-write input[type=file]{max-width:100%;color:#aaa5b8;font-size:.8rem}.fh-write input[type=file]::file-selector-button{margin-right:.8rem;padding:.55rem .8rem;border:1px solid rgba(168,85,247,.35);border-radius:.6rem;background:rgba(139,92,246,.14);color:#e9d5ff;font-weight:650;cursor:pointer;transition:background .2s}.fh-write input[type=file]::file-selector-button:hover{background:rgba(139,92,246,.26)}.fh-write__hint,.fh-write__error{margin:.4rem 0 0;font-size:.75rem;line-height:1.45}.fh-write__hint{color:#858095}.fh-write__error{color:#fca5a5}.fh-write__alert{margin-bottom:1rem;padding:.8rem 1rem;border:1px solid rgba(248,113,113,.32);border-radius:.8rem;background:rgba(127,29,29,.18);color:#fecaca;font-size:.84rem}.fh-write__success{margin-bottom:1rem;padding:.8rem 1rem;border:1px solid rgba(52,211,153,.24);border-radius:.8rem;background:rgba(16,185,129,.08);color:#a7f3d0;font-size:.84rem}.fh-write__preview{display:none;width:min(100%,30rem);max-height:17rem;margin-top:.8rem;border:1px solid rgba(196,181,253,.25);border-radius:.9rem;object-fit:cover;box-shadow:0 0 24px rgba(139,92,246,.14)}.fh-write__preview.is-visible{display:block;animation:fh-write-in .25s ease both}.fh-write .ck.ck-editor{color:#211b30}.fh-write .ck.ck-toolbar{border-color:rgba(196,181,253,.22);border-radius:.75rem .75rem 0 0;background:#201a31}.fh-write .ck.ck-toolbar .ck-button{color:#e9e2f5}.fh-write .ck.ck-toolbar .ck-button:hover,.fh-write .ck.ck-toolbar .ck-button.ck-on{background:rgba(139,92,246,.3);color:white}.fh-write .ck.ck-editor__main>.ck-editor__editable{min-height:17rem;border-color:rgba(196,181,253,.22);border-radius:0 0 .75rem .75rem;background:#fbfaff;color:#211b30}.fh-write .ck.ck-editor__main>.ck-editor__editable:focus{border-color:#a78bfa;box-shadow:0 0 0 3px rgba(139,92,246,.2)}.fh-write__check{display:flex;align-items:center;gap:.65rem;min-height:46px}.fh-write__check input{width:1rem;height:1rem;accent-color:#a855f7}.fh-write__check label{margin:0}.fh-write__actions{display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;margin-top:.3rem;padding-top:1.2rem;border-top:1px solid rgba(255,255,255,.08)}.fh-write__submit{display:inline-flex;min-height:45px;align-items:center;justify-content:center;gap:.6rem;padding:.7rem 1.15rem;border:1px solid rgba(196,181,253,.25);border-radius:.78rem;background:linear-gradient(110deg,#7c3aed,#9333ea 58%,#be185d);color:#fff;font-size:.84rem;font-weight:750;cursor:pointer;box-shadow:0 10px 26px -14px rgba(139,92,246,.9);transition:transform .2s,filter .2s,box-shadow .2s}.fh-write__submit:hover{transform:translateY(-2px);filter:brightness(1.1);box-shadow:0 14px 30px -12px rgba(236,72,153,.65)}.fh-write__submit:focus-visible{outline:2px solid #c4b5fd;outline-offset:3px}.fh-write__submit:disabled{cursor:wait;opacity:.82;transform:none}.fh-write__spinner{display:none;width:1rem;height:1rem;border:2px solid rgba(255,255,255,.35);border-top-color:white;border-radius:50%;animation:fh-write-spin .7s linear infinite}.fh-write__submit[aria-busy=true] .fh-write__spinner{display:block}.fh-write__cancel{color:#aaa5b8;font-size:.82rem;text-decoration:none;transition:color .2s}.fh-write__cancel:hover{color:white}@keyframes fh-write-in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)}}@keyframes fh-write-spin{to{transform:rotate(360deg)}}@media(max-width:600px){.fh-write{padding:1rem .8rem 2.5rem}.fh-write__grid{grid-template-columns:1fr}.fh-write__field--full{grid-column:auto}.fh-write__actions{align-items:stretch}.fh-write__submit{flex:1}}@media(prefers-reduced-motion:reduce){.fh-write__hero,.fh-write__card,.fh-write__preview{animation:none!important}.fh-write__submit,.fh-write input,.fh-write select,.fh-write textarea{transition:none!important}}
    </style>
    <main class="fh-write" aria-labelledby="write-article-title">
        <header class="fh-write__hero"><span class="fh-write__eyebrow">FanHub+ · Editorial studio</span><h1 id="write-article-title">Write Article</h1><p>Tell a story, share a perspective, and give fellow fans something worth reading.</p></header>
        <section class="fh-write__card">
            @if (session('success'))<div class="fh-write__success" role="status">{{ session('success') }}</div>@endif
            @if ($errors->any())<div class="fh-write__alert" role="alert"><strong>Please review the form.</strong><ul class="mt-2 list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data" class="fh-write__grid" id="article-form" data-fh-submit>
                @csrf
                <div class="fh-write__field fh-write__field--full"><label for="article-title">Title <span aria-hidden="true">*</span></label><input id="article-title" name="title" type="text" required maxlength="255" value="{{ old('title') }}" placeholder="A compelling headline">@error('title')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field"><label for="category_id">Category</label><select id="category_id" name="category_id"><option value="">— No category —</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field fh-write__field--full"><label for="excerpt">Excerpt</label><textarea id="excerpt" name="excerpt" rows="3" maxlength="500" placeholder="A short introduction for article cards…">{{ old('excerpt') }}</textarea><p class="fh-write__hint">Up to 500 characters.</p>@error('excerpt')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field fh-write__field--full"><label for="article-body">Article body <span aria-hidden="true">*</span></label><textarea name="body" id="article-body" rows="12" required>{{ old('body') }}</textarea>@error('body')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field fh-write__field--full"><label for="cover-image">Featured image</label><input id="cover-image" name="cover_image" type="file" accept="image/jpeg,image/png,image/webp"><p class="fh-write__hint">JPG, PNG or WebP · up to 3 MB</p><img id="cover-preview" class="fh-write__preview" alt="Featured image preview">@error('cover_image')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field"><label for="status">Status</label><select id="status" name="status"><option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option><option value="published" @selected(old('status') === 'published')>Published</option></select>@error('status')<p class="fh-write__error">{{ $message }}</p>@enderror</div>
                <div class="fh-write__field fh-write__check"><input type="hidden" name="is_featured" value="0"><input id="is_featured" name="is_featured" type="checkbox" value="1" @checked(old('is_featured'))><label for="is_featured">Feature on homepage</label></div>
                <div class="fh-write__field fh-write__field--full fh-write__actions"><button type="submit" class="fh-write__submit"><span data-submit-label>Save article</span><span class="fh-write__spinner" aria-hidden="true"></span></button><a href="{{ route('articles.index') }}" class="fh-write__cancel">Cancel</a></div>
            </form>
        </section>
    </main>
    @push('scripts')
    <script>
        (() => {
            const body = document.querySelector('#article-body');
            let editor;
            const form = document.querySelector('#article-form');
            const submit = form?.querySelector('[type="submit"]');
            const label = submit?.querySelector('[data-submit-label]');
            const setLoading = () => { if (!submit || submit.disabled) return; submit.disabled = true; submit.setAttribute('aria-busy', 'true'); label.textContent = 'Saving…'; };
            if (window.ClassicEditor && body) {
                ClassicEditor.create(body, { toolbar: ['heading','|','bold','italic','underline','strikethrough','|','bulletedList','numberedList','blockQuote','|','link','insertTable','|','undo','redo'] })
                .then((instance) => { editor = instance; body.required = false; })
                    .catch((error) => console.error('Article editor could not start.', error));
            }
            form?.addEventListener('submit', (event) => {
                if (editor) body.value = editor.getData();
                const editorText = editor ? editor.getData().replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim() : body.value.trim();
                if (!editorText) {
                    event.preventDefault();
                    let message = document.querySelector('#article-body-error');
                    if (!message) {
                        message = document.createElement('p'); message.id = 'article-body-error'; message.className = 'fh-write__error'; message.setAttribute('role', 'alert');
                        body.closest('.fh-write__field').append(message);
                    }
                    message.textContent = 'The article body is required.';
                    editor?.ui.view.editable.element.focus();
                    return;
                }
                if (!form.checkValidity()) { event.preventDefault(); form.reportValidity(); return; }
                if (submit?.disabled) { event.preventDefault(); return; }
                setLoading();
            });
            const input = document.querySelector('#cover-image');
            const preview = document.querySelector('#cover-preview');
            let previewUrl;
            input?.addEventListener('change', () => {
                if (previewUrl) URL.revokeObjectURL(previewUrl);
                const file = input.files?.[0];
                if (!file) { preview.classList.remove('is-visible'); preview.removeAttribute('src'); return; }
                if (!['image/jpeg','image/png','image/webp'].includes(file.type) || file.size > 3 * 1024 * 1024) { input.value = ''; preview.classList.remove('is-visible'); return; }
                previewUrl = URL.createObjectURL(file); preview.src = previewUrl; preview.classList.add('is-visible');
            });
        })();
    </script>
    @endpush
</x-app-layout>
