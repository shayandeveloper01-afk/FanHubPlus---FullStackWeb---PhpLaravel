<x-app-layout>
    @php
        $contactEmail = \App\Models\SiteSetting::get('contact_email', config('mail.from.address'));
    @endphp

    <style>
        .fh-contact{max-width:76rem;margin:0 auto;padding:1.5rem 1.25rem 3.5rem;color:var(--fh-text,#f3f4f6)}
        .fh-contact__hero{max-width:46rem;margin:0 auto 2rem;text-align:center}
        .fh-contact__eyebrow{color:#c4b5fd;font-size:.7rem;font-weight:750;letter-spacing:.16em;text-transform:uppercase}
        .fh-contact__hero h1{margin:.55rem 0;font-size:clamp(1.9rem,4vw,3rem);font-weight:800;letter-spacing:-.04em;line-height:1.1}
        .fh-contact__hero p{margin:0;color:var(--fh-text-muted,#9ca3af);font-size:1rem;line-height:1.7}
        .fh-contact__layout{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(16rem,.8fr);gap:1.2rem;align-items:start}
        .fh-contact__panel{min-width:0;padding:clamp(1.15rem,3vw,2rem);border:1px solid var(--fh-border,rgba(255,255,255,.08));border-radius:1.35rem;background:linear-gradient(145deg,rgba(255,255,255,.045),rgba(255,255,255,.018));box-shadow:0 24px 65px rgba(0,0,0,.2),inset 0 1px rgba(255,255,255,.04)}
        .fh-contact__form{display:grid;gap:1.05rem}
        .fh-contact__fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .fh-contact__field{display:grid;min-width:0;gap:.4rem}
        .fh-contact__field label{color:#d1d5db;font-size:.82rem;font-weight:650}
        .fh-contact__field input,.fh-contact__field select,.fh-contact__field textarea{width:100%;min-width:0;border:1px solid rgba(255,255,255,.1);border-radius:.78rem;background:rgba(8,9,17,.62);padding:.78rem .85rem;color:#f9fafb;font:inherit;font-size:.9rem;transition:border-color .2s,box-shadow .2s,background .2s}
        .fh-contact__field select{color-scheme:dark}
        .fh-contact__field textarea{min-height:9rem;resize:vertical;line-height:1.6}
        .fh-contact__field input::placeholder,.fh-contact__field textarea::placeholder{color:#6b7280}
        .fh-contact__field input:focus,.fh-contact__field select:focus,.fh-contact__field textarea:focus{outline:none;border-color:#a78bfa;background:rgba(15,12,29,.85);box-shadow:0 0 0 3px rgba(139,92,246,.17)}
        .fh-contact__field [aria-invalid="true"]{border-color:#f87171;box-shadow:0 0 0 3px rgba(248,113,113,.12)}
        .fh-contact__hint{color:#777487;font-size:.74rem;line-height:1.5}
        .fh-contact__submit{display:inline-flex;min-height:48px;align-items:center;justify-content:center;gap:.55rem;width:fit-content;padding:.75rem 1.15rem;border:1px solid rgba(196,181,253,.2);border-radius:.8rem;background:linear-gradient(110deg,#7c3aed,#9333ea 58%,#c026d3);color:#fff;font-size:.9rem;font-weight:700;box-shadow:0 12px 28px -14px rgba(139,92,246,.9);cursor:pointer;transition:transform .2s,filter .2s,box-shadow .2s}
        .fh-contact__submit:hover{transform:translateY(-2px);filter:brightness(1.08);box-shadow:0 16px 32px -14px rgba(139,92,246,.8)}
        .fh-contact__submit:focus-visible,.fh-contact a:focus-visible{outline:2px solid #c4b5fd;outline-offset:3px}
        .fh-contact__submit:disabled{cursor:wait;opacity:.72;transform:none}
        .fh-contact__side{display:grid;gap:1rem}
        .fh-contact__info-card{padding:1.2rem;border:1px solid rgba(167,139,250,.17);border-radius:1.1rem;background:radial-gradient(ellipse at top left,rgba(124,58,237,.16),transparent 65%),rgba(255,255,255,.025)}
        .fh-contact__info-card h2{margin:0 0 .55rem;color:#f3f4f6;font-size:1rem;font-weight:750}
        .fh-contact__info-card p{margin:0;color:#9ca3af;font-size:.85rem;line-height:1.65}
        .fh-contact__info-card a{color:#c4b5fd;text-decoration:none;overflow-wrap:anywhere}
        .fh-contact__info-card a:hover{color:#fff;text-decoration:underline}
        .fh-contact__info-icon{display:grid;width:2.25rem;height:2.25rem;margin-bottom:.9rem;place-items:center;border:1px solid rgba(167,139,250,.24);border-radius:.7rem;background:rgba(139,92,246,.13);color:#c4b5fd}
        .fh-contact__info-icon svg{width:1.1rem;height:1.1rem}
        .fh-contact__alert{margin:0 0 1rem;padding:1rem 1.1rem;border:1px solid rgba(52,211,153,.25);border-radius:.9rem;background:rgba(16,185,129,.08);color:#a7f3d0;font-size:.9rem;line-height:1.6}
        .fh-contact__alert strong{color:#fff;font-family:ui-monospace,monospace;letter-spacing:.08em}
        @media(max-width:760px){.fh-contact__layout{grid-template-columns:1fr}.fh-contact__side{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:520px){.fh-contact{padding:1.25rem .9rem 2.5rem}.fh-contact__hero{margin-bottom:1.35rem}.fh-contact__fields,.fh-contact__side{grid-template-columns:1fr}.fh-contact__panel{border-radius:1rem}.fh-contact__submit{width:100%}}
        @media(prefers-reduced-motion:reduce){.fh-contact *{scroll-behavior:auto!important;transition-duration:.01ms!important}}
    </style>

    <section class="fh-contact" id="fh-contact">
        <x-breadcrumb :crumbs="[['label' => 'Home', 'url' => route('home')], ['label' => 'Contact']]" />
        <header class="fh-contact__hero">
            <span class="fh-contact__eyebrow">FanHub Plus support</span>
            <h1>Let’s talk fandom.</h1>
            <p>Questions, ideas, or something that needs our attention? Send a note and the FanHub team will take it from here.</p>
        </header>

        @if (session('success'))
            <div class="fh-contact__alert" role="status" aria-live="polite">
                {{ session('success') }}
                @if (session('feedback_reference'))
                    <span> Your reference code is <strong>{{ session('feedback_reference') }}</strong>. <a href="{{ route('feedback.status') }}" class="underline">Track its status</a>.</span>
                    @auth
                        <a href="{{ route('feedback.mine') }}" class="ml-2 underline">View my messages and team replies</a>
                    @endauth
                @endif
            </div>
        @endif

        <div class="fh-contact__layout">
            <section class="fh-contact__panel" aria-labelledby="fh-contact-form-title">
                <h2 id="fh-contact-form-title" class="mb-5 text-lg font-bold text-white">Send a message</h2>
                <form method="POST" action="{{ route('feedback.store') }}" id="feedbackForm" class="fh-contact__form">
                    @csrf
                    <div class="fh-contact__fields">
                        <div class="fh-contact__field">
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" autocomplete="name" maxlength="100" value="{{ old('name', auth()->user()?->name) }}" @guest required @endguest aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" aria-describedby="name-error">
                            <x-input-error id="name-error" :messages="$errors->get('name')" class="text-red-400" />
                        </div>
                        <div class="fh-contact__field">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" autocomplete="email" maxlength="255" value="{{ old('email', auth()->user()?->email) }}" @guest required @endguest aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" aria-describedby="email-error">
                            <x-input-error id="email-error" :messages="$errors->get('email')" class="text-red-400" />
                        </div>
                        <div class="fh-contact__field">
                            <label for="type">Category / reason</label>
                            <select id="type" name="type" required aria-invalid="{{ $errors->has('type') ? 'true' : 'false' }}" aria-describedby="type-error">
                                <option value="">Choose a reason</option>
                                <option value="general" @selected(old('type') === 'general')>General question</option>
                                <option value="suggestion" @selected(old('type') === 'suggestion')>Suggestion</option>
                                <option value="bug" @selected(old('type') === 'bug')>Report a bug</option>
                                <option value="report" @selected(old('type') === 'report')>Report content</option>
                            </select>
                            <x-input-error id="type-error" :messages="$errors->get('type')" class="text-red-400" />
                        </div>
                        <div class="fh-contact__field">
                            <label for="subject">Subject</label>
                            <input id="subject" name="subject" type="text" maxlength="255" value="{{ old('subject') }}" placeholder="What can we help with?" required aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}" aria-describedby="subject-error">
                            <x-input-error id="subject-error" :messages="$errors->get('subject')" class="text-red-400" />
                        </div>
                    </div>
                    <div class="fh-contact__field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" maxlength="5000" rows="6" placeholder="Share the details with us…" required aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}" aria-describedby="message-hint message-error">{{ old('message') }}</textarea>
                        <div class="flex items-center justify-between gap-3"><span id="message-hint" class="fh-contact__hint">Please don’t include passwords or sensitive account details.</span><span id="charCount" class="fh-contact__hint shrink-0">{{ mb_strlen(old('message', '')) }} / 5000</span></div>
                        <x-input-error id="message-error" :messages="$errors->get('message')" class="text-red-400" />
                    </div>
                    <div><button type="submit" id="submitBtn" class="fh-contact__submit"><span id="submitText">Send message</span><x-spinner class="hidden" id="submitSpinner" /></button></div>
                </form>
            </section>

            <aside class="fh-contact__side" aria-label="Contact information and help">
                <section class="fh-contact__info-card">
                    <span class="fh-contact__info-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 7.5 12 13l9-5.5M5 5h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg></span>
                    <h2>Email</h2>
                    @if ($contactEmail)
                        <p>Reach our team directly at<br><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                    @else
                        <p>Send a message using the form and our team will follow up using your email address.</p>
                    @endif
                </section>
                <section class="fh-contact__info-card">
                    <span class="fh-contact__info-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2h-5l-5 5v-5Z"/></svg></span>
                    <h2>Need a quick answer?</h2>
                    <p>Browse the <a href="{{ route('faqs.index') }}">frequently asked questions</a> or <a href="{{ route('feedback.status') }}">track a previous message</a> with its reference code.</p>
                </section>
            </aside>
        </div>
    </section>

    @push('scripts')
    <script>
        (() => {
            const form = document.getElementById('feedbackForm');
            const message = document.getElementById('message');
            const counter = document.getElementById('charCount');
            const button = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const spinner = document.getElementById('submitSpinner');
            message?.addEventListener('input', () => { counter.textContent = `${message.value.length} / 5000`; });
            form?.addEventListener('submit', () => {
                if (!form.checkValidity()) return;
                spinner?.classList.remove('hidden');
                submitText.textContent = 'Sending…';
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
            });
        })();
    </script>
    @endpush
</x-app-layout>
