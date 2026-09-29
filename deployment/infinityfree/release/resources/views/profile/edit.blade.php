<x-app-layout>
    <style>
        .fh-profile-page{--profile-card:rgba(18,17,31,.88);--profile-line:rgba(196,181,253,.14);--profile-muted:#a09caf;max-width:68rem;min-height:calc(100vh - 68px);margin:0 auto;padding:1.6rem 1.25rem 3.5rem;color:#f4f1fb}
        .fh-profile-hero{position:relative;isolation:isolate;overflow:hidden;margin-bottom:1.35rem;padding:1.5rem clamp(1.2rem,3vw,2rem);border:1px solid var(--profile-line);border-radius:1.35rem;background:radial-gradient(ellipse at 85% 0,rgba(192,132,252,.17),transparent 45%),linear-gradient(125deg,rgba(31,24,52,.96),rgba(15,14,25,.94));box-shadow:0 20px 48px rgba(0,0,0,.2)}
        .fh-profile-hero::after{content:"";position:absolute;z-index:-1;right:-4rem;bottom:-8rem;width:18rem;height:18rem;border-radius:50%;background:radial-gradient(circle,rgba(219,39,119,.14),transparent 68%);pointer-events:none}
        .fh-profile-eyebrow{display:inline-flex;align-items:center;gap:.45rem;color:#c4b5fd;font-size:.68rem;font-weight:750;letter-spacing:.16em;text-transform:uppercase}
        .fh-profile-hero h1{margin:.4rem 0 .3rem;color:#fff;font-size:clamp(1.55rem,3vw,2rem);font-weight:800;letter-spacing:-.035em;line-height:1.15}
        .fh-profile-hero p{max-width:42rem;margin:0;color:var(--profile-muted);font-size:.9rem;line-height:1.6}
        .fh-profile-stack{display:grid;gap:1rem}
        .fh-profile-card{min-width:0;padding:clamp(1.1rem,2.8vw,1.65rem);border:1px solid var(--profile-line);border-radius:1.2rem;background:var(--profile-card);box-shadow:0 20px 48px rgba(0,0,0,.18),inset 0 1px rgba(255,255,255,.035);backdrop-filter:blur(16px);animation:fh-profile-enter .48s cubic-bezier(.2,.7,.2,1) both}
        .fh-profile-card:nth-child(2){animation-delay:.07s}.fh-profile-card:nth-child(3){animation-delay:.14s}
        @keyframes fh-profile-enter{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
        .fh-profile-card__heading{display:flex;align-items:flex-start;gap:.85rem;margin-bottom:1.25rem}
        .fh-profile-card__icon{display:grid;width:2.55rem;height:2.55rem;flex:0 0 2.55rem;place-items:center;border:1px solid rgba(167,139,250,.22);border-radius:.8rem;background:linear-gradient(145deg,rgba(139,92,246,.2),rgba(236,72,153,.08));color:#d8b4fe}
        .fh-profile-card__icon svg{width:1.2rem;height:1.2rem}
        .fh-profile-card h2{margin:0;color:#fff;font-size:1.04rem;font-weight:750;letter-spacing:-.015em}
        .fh-profile-card__intro{margin:.28rem 0 0;color:var(--profile-muted);font-size:.82rem;line-height:1.55}
        .fh-profile-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem}
        .fh-profile-field{display:grid;min-width:0;gap:.42rem}
        .fh-profile-field--full{grid-column:1/-1}
        .fh-profile-label{color:#e2deed;font-size:.8rem;font-weight:650}
        .fh-profile-input{display:block;width:100%;min-width:0;min-height:45px;border:1px solid rgba(255,255,255,.12);border-radius:.78rem;background:rgba(7,8,16,.62);padding:.67rem .82rem;color:#f8f7fb;font:inherit;font-size:.9rem;transition:border-color .2s,box-shadow .2s,background .2s}
        .fh-profile-input::placeholder{color:#777387}
        .fh-profile-input:focus{outline:none;border-color:#a78bfa;background:rgba(13,10,25,.92);box-shadow:0 0 0 3px rgba(139,92,246,.18),0 0 18px rgba(139,92,246,.08)}
        .fh-profile-input[aria-invalid="true"]{border-color:#f87171;box-shadow:0 0 0 3px rgba(248,113,113,.12)}
        .fh-profile-error{margin:0;color:#fca5a5;font-size:.76rem;line-height:1.45}
        .fh-profile-help{margin:0;color:#89859a;font-size:.74rem;line-height:1.5}
        .fh-profile-avatar-row{display:flex;align-items:center;gap:1.15rem;min-width:0;margin-bottom:1.25rem;padding:1rem;border:1px solid rgba(255,255,255,.075);border-radius:1rem;background:rgba(255,255,255,.025)}
        .fh-profile-avatar-shell{position:relative;isolation:isolate;flex:0 0 auto;width:clamp(5rem,13vw,6.25rem);height:clamp(5rem,13vw,6.25rem);padding:3px;border-radius:50%;background:linear-gradient(140deg,#a78bfa,#9333ea 52%,#ec4899);box-shadow:0 0 0 5px rgba(139,92,246,.08),0 0 28px rgba(139,92,246,.28);transition:transform .25s,box-shadow .25s}
        .fh-profile-avatar-shell:hover{transform:translateY(-2px) scale(1.035);box-shadow:0 0 0 6px rgba(139,92,246,.11),0 0 36px rgba(236,72,153,.27)}
        .fh-profile-avatar{display:block;width:100%;height:100%;border:2px solid #151222;border-radius:50%;background:#1a1728;object-fit:cover}
        .fh-profile-avatar-actions{display:flex;flex-wrap:wrap;align-items:center;gap:.5rem .65rem;min-width:0}
        .fh-profile-avatar-copy{flex-basis:100%;margin:0 0 .1rem;color:#b8b3c8;font-size:.82rem;font-weight:650}
        .fh-profile-file-label,.fh-profile-button,.fh-profile-button--quiet,.fh-profile-button--danger{display:inline-flex;min-height:42px;align-items:center;justify-content:center;gap:.5rem;padding:.6rem .9rem;border:1px solid transparent;border-radius:.75rem;font:inherit;font-size:.8rem;font-weight:700;text-decoration:none;cursor:pointer;transition:transform .2s,background .2s,border-color .2s,box-shadow .2s,color .2s}
        .fh-profile-file-label,.fh-profile-button{border-color:rgba(196,181,253,.2);background:linear-gradient(110deg,#7c3aed,#9333ea 58%,#be185d);color:#fff;box-shadow:0 10px 24px -14px rgba(139,92,246,.85)}
        .fh-profile-file-label:hover,.fh-profile-button:hover{transform:translateY(-1px);box-shadow:0 14px 28px -14px rgba(168,85,247,.85);filter:brightness(1.08)}
        .fh-profile-button--quiet{border-color:rgba(255,255,255,.12);background:rgba(255,255,255,.04);color:#d6d2e2}
        .fh-profile-button--quiet:hover{border-color:rgba(196,181,253,.35);background:rgba(139,92,246,.11);color:#fff}
        .fh-profile-button--danger{border-color:rgba(248,113,113,.25);background:rgba(127,29,29,.2);color:#fca5a5}
        .fh-profile-button--danger:hover{border-color:rgba(248,113,113,.55);background:rgba(185,28,28,.25);color:#fff}
        .fh-profile-button:focus-visible,.fh-profile-button--quiet:focus-visible,.fh-profile-button--danger:focus-visible,.fh-profile-file-label:focus-within{outline:2px solid #c4b5fd;outline-offset:3px}
        .fh-profile-file-input{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;clip-path:inset(50%)}
        .fh-profile-avatar-status{flex-basis:100%;min-height:1rem;color:#a5b4fc;font-size:.73rem}
        .fh-profile-avatar-actions>.fh-profile-help,.fh-profile-avatar-actions>.fh-profile-avatar-status,.fh-profile-avatar-actions>.fh-profile-upload-progress{flex-basis:100%}
        .fh-profile-avatar-status.fh-profile-error{color:#fca5a5}
        .fh-profile-actions{display:flex;flex-wrap:wrap;align-items:center;gap:.75rem;margin-top:1.2rem;padding-top:1rem;border-top:1px solid rgba(255,255,255,.07)}
        .fh-profile-status{display:flex;align-items:flex-start;gap:.55rem;margin-bottom:1rem;padding:.78rem .9rem;border:1px solid rgba(52,211,153,.22);border-radius:.8rem;background:rgba(16,185,129,.08);color:#a7f3d0;font-size:.82rem;line-height:1.5;animation:fh-profile-enter .3s ease both}
        .fh-profile-status svg{width:1.05rem;height:1.05rem;flex:none;margin-top:.05rem}
        .fh-profile-avatar-toast{margin:.8rem 0;padding:.72rem .85rem;border:1px solid rgba(52,211,153,.24);border-radius:.75rem;background:rgba(16,185,129,.08);color:#a7f3d0;font-size:.8rem;line-height:1.5;animation:fh-profile-enter .25s ease both}
        .fh-profile-avatar-toast.is-error{border-color:rgba(248,113,113,.3);background:rgba(127,29,29,.2);color:#fecaca}
        .fh-profile-danger-card{border-color:rgba(248,113,113,.22);background:linear-gradient(145deg,rgba(48,20,31,.7),rgba(19,16,25,.94));box-shadow:0 18px 42px rgba(0,0,0,.17),inset 0 1px rgba(255,255,255,.025)}
        .fh-profile-danger-card .fh-profile-card__icon{border-color:rgba(248,113,113,.25);background:rgba(239,68,68,.1);color:#fca5a5}
        .fh-profile-danger-copy{max-width:55rem;margin:0 0 1rem;color:#d0bdc4;font-size:.84rem;line-height:1.6}
        .fh-profile-password-wrap{position:relative}
        .fh-profile-password-wrap .fh-profile-input{padding-right:3rem}
        .fh-profile-eye{position:absolute;top:50%;right:.65rem;display:grid;width:2rem;height:2rem;place-items:center;transform:translateY(-50%);border:0;border-radius:.55rem;background:transparent;color:#9b96aa;cursor:pointer}
        .fh-profile-eye:hover,.fh-profile-eye:focus-visible{background:rgba(139,92,246,.13);color:#e9d5ff;outline:none}
        .fh-profile-eye svg{width:1rem;height:1rem}
        .fh-profile-strength{display:flex;align-items:center;gap:.55rem;margin-top:.45rem}
        .fh-profile-strength__track{display:flex;flex:1;gap:.25rem}
        .fh-profile-strength__segment{height:4px;flex:1;border-radius:999px;background:rgba(255,255,255,.1);transition:background .2s,box-shadow .2s}
        .fh-profile-strength__segment.is-active{background:#8b5cf6;box-shadow:0 0 8px rgba(139,92,246,.4)}
        .fh-profile-strength[data-strength="2"] .fh-profile-strength__segment.is-active{background:#f59e0b}
        .fh-profile-strength[data-strength="3"] .fh-profile-strength__segment.is-active,.fh-profile-strength[data-strength="4"] .fh-profile-strength__segment.is-active{background:#34d399}
        .fh-profile-strength__label{min-width:4rem;color:#858095;font-size:.7rem;text-align:right}
        .fh-profile-match{min-height:.9rem;margin-top:.35rem;color:#89859a;font-size:.72rem}
        .fh-profile-match.is-match{color:#6ee7b7}.fh-profile-match.is-mismatch{color:#fca5a5}
        .fh-profile-security{display:flex;align-items:flex-start;gap:.8rem;margin-top:1.15rem;padding:1rem;border:1px solid rgba(167,139,250,.17);border-radius:.95rem;background:radial-gradient(ellipse at 0 0,rgba(139,92,246,.12),transparent 62%),linear-gradient(125deg,rgba(139,92,246,.06),rgba(236,72,153,.035));box-shadow:inset 0 1px rgba(255,255,255,.025)}
        .fh-profile-security__icon{display:grid;width:2.25rem;height:2.25rem;flex:none;place-items:center;border:1px solid rgba(167,139,250,.24);border-radius:.7rem;background:rgba(139,92,246,.13);color:#c4b5fd}
        .fh-profile-security__icon svg{width:1.15rem;height:1.15rem}.fh-profile-security__body{min-width:0}.fh-profile-security__eyebrow{margin:0 0 .4rem;color:#c4b5fd;font-size:.67rem;font-weight:750;letter-spacing:.13em;text-transform:uppercase}
        .fh-profile-security__label{margin:0;color:#bcb7ca;font-size:.74rem}.fh-profile-security__value{margin:.17rem 0 0;color:#f4f1fb;font-size:.88rem;font-weight:700}.fh-profile-security__note{margin:.3rem 0 0;color:#89859a;font-size:.7rem;line-height:1.5}
        .fh-profile-button.is-loading .fh-profile-button__loading{display:inline}.fh-profile-button.is-loading .fh-profile-button__loading~.fh-profile-button__spinner{display:none}
        .fh-modal-panel{overflow:hidden;border:1px solid rgba(196,181,253,.22);border-radius:1.2rem;background:linear-gradient(145deg,#1a1728,#100f19);color:#f4f1fb;box-shadow:0 30px 90px rgba(0,0,0,.65),0 0 30px rgba(139,92,246,.15)}
        .fh-modal-panel input{border-color:rgba(255,255,255,.14)!important;background:#0c0b13!important;color:#fff!important}
        .fh-modal-title{margin:0;color:#fff;font-size:1.1rem;font-weight:750;line-height:1.35}
        .fh-modal-copy{margin:.5rem 0 0;color:#b8b3c8;font-size:.84rem;line-height:1.65}
        .fh-profile-button__spinner{display:none;width:1rem;height:1rem;border:2px solid rgba(255,255,255,.35);border-top-color:#fff;border-radius:50%;animation:fh-profile-spin .7s linear infinite}
        .fh-profile-button.is-loading .fh-profile-button__spinner,.fh-profile-button--danger.is-loading .fh-profile-button__spinner{display:inline-block}
        .fh-profile-button.is-loading .fh-profile-button__text,.fh-profile-button--danger.is-loading .fh-profile-button__text{display:none}
        @keyframes fh-profile-spin{to{transform:rotate(360deg)}}
        .fh-profile-upload-progress{display:none;flex-basis:100%;height:3px;overflow:hidden;border-radius:99px;background:rgba(255,255,255,.1)}
        .fh-profile-upload-progress.is-active{display:block}
        .fh-profile-upload-progress span{display:block;width:34%;height:100%;border-radius:inherit;background:linear-gradient(90deg,#8b5cf6,#ec4899);animation:fh-upload-progress 1.15s ease-in-out infinite}
        @keyframes fh-upload-progress{0%{transform:translateX(-110%)}100%{transform:translateX(310%)}}
        .fh-profile-page [hidden]{display:none!important}
        @media(max-width:620px){.fh-profile-page{padding:1.1rem .85rem 2.5rem}.fh-profile-grid{grid-template-columns:1fr}.fh-profile-avatar-row{align-items:flex-start;padding:.85rem}.fh-profile-avatar-actions{gap:.45rem}.fh-profile-file-label,.fh-profile-button--quiet{min-height:40px;padding:.55rem .7rem;font-size:.74rem}}
        @media(max-width:390px){.fh-profile-grid{grid-template-columns:1fr}.fh-profile-avatar-row{gap:.8rem}.fh-profile-avatar-shell{width:4.5rem;height:4.5rem}.fh-profile-avatar-actions{gap:.4rem}.fh-profile-file-label,.fh-profile-button--quiet{font-size:.7rem}}
        @media(prefers-reduced-motion:reduce){.fh-profile-card,.fh-profile-status,.fh-profile-upload-progress span{animation:none!important}.fh-profile-card,.fh-profile-avatar-shell,.fh-profile-input,.fh-profile-button,.fh-profile-button--quiet,.fh-profile-button--danger{transition-duration:.01ms!important}}
    </style>

    <div class="fh-profile-page" id="fh-profile-page" x-data="{}">
        <header class="fh-profile-hero">
            <span class="fh-profile-eyebrow"><x-fh-logo-mark class="h-7 w-16" /> Account settings</span>
            <h1>Your FanHub+ profile</h1>
            <p>Manage your identity, keep your account secure, and choose how you appear around the FanHub+ community.</p>
        </header>

        <div class="fh-profile-stack">
            <section class="fh-profile-card" aria-labelledby="profile-information-title">
                @include('profile.partials.update-profile-information-form')
            </section>
            <section class="fh-profile-card" aria-labelledby="update-password-title">
                @include('profile.partials.update-password-form')
            </section>
            <section class="fh-profile-card fh-profile-danger-card" aria-labelledby="delete-account-title">
                @include('profile.partials.delete-user-form')
            </section>
        </div>

    <template x-teleport="body">
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" maxWidth="md" variant="fanhub" aria-labelledby="confirm-user-deletion-title" focusable>
            <form id="profile-delete-account-form" method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-7">
                @csrf
                @method('delete')

                <span class="fh-profile-card__icon mb-4" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg></span>
                <h2 id="confirm-user-deletion-title" class="fh-modal-title">Permanently delete your account?</h2>
                <p class="fh-modal-copy">This action cannot be undone. Enter your current password to confirm account deletion.</p>

                <div class="mt-5 grid gap-2">
                    <label for="profile-delete-password" class="fh-profile-label">Current password</label>
                    <input id="profile-delete-password" name="password" type="password" class="fh-profile-input" autocomplete="current-password" required aria-describedby="delete-password-error">
                    @if ($errors->userDeletion->has('password'))
                        <p id="delete-password-error" class="fh-profile-error" role="alert">{{ $errors->userDeletion->first('password') }}</p>
                    @endif
                    @if ($errors->userDeletion->has('account'))
                        <p id="delete-account-error" class="fh-profile-error" role="alert">{{ $errors->userDeletion->first('account') }}</p>
                    @endif
                </div>

                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                    <button type="button" class="fh-profile-button--quiet" x-on:click="$dispatch('close')">Cancel</button>
                    <button type="submit" class="fh-profile-button--danger"><span class="fh-profile-button__text">Delete permanently</span><span class="fh-profile-button__spinner" aria-hidden="true"></span></button>
                </div>
            </form>
        </x-modal>
    </template>
    </div>

    <script>
        (() => {
            const root = document.getElementById('fh-profile-page');
            if (!root) return;

            const avatarInput = root.querySelector('[data-profile-avatar-input]');
            const avatarPreview = root.querySelector('[data-profile-avatar-preview]');
            const avatarStatus = root.querySelector('[data-profile-avatar-status]');
            const profileForm = root.querySelector('#profile-information-form');
            const profileSubmit = profileForm?.querySelector('[type="submit"]');
            const removeAvatarForm = root.querySelector('[data-avatar-remove-form]');
            const removeAvatarButton = root.querySelector('[data-avatar-remove-submit]');
            const removeAvatarTrigger = removeAvatarButton;
            const avatarUploadLabel = root.querySelector('[data-avatar-upload-label]');
            const avatarToast = root.querySelector('[data-avatar-toast]');
            let previewUrl = null;

            const setNavbarAvatar = (url) => {
                document.querySelectorAll('[data-auth-avatar]').forEach((image) => {
                    image.src = url || image.dataset.defaultAvatar;
                });
            };

            const showAvatarToast = (message, isError = false) => {
                if (!avatarToast) return;
                avatarToast.textContent = message;
                avatarToast.classList.toggle('is-error', isError);
                avatarToast.setAttribute('role', isError ? 'alert' : 'status');
                avatarToast.hidden = false;
            };

            avatarPreview?.addEventListener('error', () => {
                if (avatarPreview.src !== avatarPreview.dataset.fallbackSrc) {
                    avatarPreview.src = avatarPreview.dataset.fallbackSrc;
                }
            });

            avatarInput?.addEventListener('change', () => {
                const file = avatarInput.files?.[0];
                avatarInput.setCustomValidity('');
                avatarInput.setAttribute('aria-invalid', 'false');
                if (!file) {
                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                    avatarPreview.src = avatarPreview.dataset.savedSrc;
                    avatarStatus.textContent = '';
                    avatarStatus.classList.remove('fh-profile-error');
                    return;
                }

                const allowed = ['image/jpeg', 'image/png', 'image/webp'];
                if (!allowed.includes(file.type) || file.size > 2 * 1024 * 1024) {
                    const message = !allowed.includes(file.type)
                        ? 'Choose a JPG, JPEG, PNG, or WebP image.'
                        : 'Choose an image smaller than 2 MB.';
                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                    avatarPreview.src = avatarPreview.dataset.savedSrc;
                    avatarInput.setCustomValidity(message);
                    avatarInput.setAttribute('aria-invalid', 'true');
                    avatarStatus.textContent = message;
                    avatarStatus.classList.add('fh-profile-error');
                    return;
                }

                avatarStatus.classList.remove('fh-profile-error');
                if (previewUrl) URL.revokeObjectURL(previewUrl);
                previewUrl = URL.createObjectURL(file);
                avatarPreview.src = previewUrl;
                avatarStatus.textContent = `${file.name} selected · ${(file.size / 1024 / 1024).toFixed(2)} MB`;
            });

            removeAvatarForm?.addEventListener('submit', async (event) => {
                event.preventDefault();
                if (!removeAvatarButton || removeAvatarButton.disabled) return;

                const previousPreview = avatarPreview?.src;
                const previousSavedAvatar = avatarPreview?.dataset.savedSrc;
                const token = removeAvatarForm.querySelector('input[name="_token"]')?.value;

                if (avatarPreview) avatarPreview.src = avatarPreview.dataset.fallbackSrc;
                setNavbarAvatar();
                removeAvatarButton.classList.add('is-loading');
                removeAvatarButton.disabled = true;
                removeAvatarButton.setAttribute('aria-busy', 'true');

                try {
                    const response = await fetch(removeAvatarForm.action, {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                    });
                    const result = await response.json().catch(() => ({}));

                    if (!response.ok || !result.success) {
                        throw new Error(result.message || 'The profile picture could not be removed. Please try again.');
                    }

                    const defaultUrl = result.avatar_url || avatarPreview?.dataset.fallbackSrc;
                    if (avatarPreview) {
                        avatarPreview.src = defaultUrl;
                        avatarPreview.dataset.savedSrc = defaultUrl;
                    }
                    setNavbarAvatar();
                    if (previewUrl) URL.revokeObjectURL(previewUrl);
                    previewUrl = null;
                    if (avatarInput) avatarInput.value = '';
                    if (avatarStatus) avatarStatus.textContent = '';
                    if (avatarUploadLabel) avatarUploadLabel.textContent = 'Add profile picture';
                    if (removeAvatarTrigger) removeAvatarTrigger.hidden = true;

                    showAvatarToast(result.message || 'Your profile picture was removed.');
                } catch (error) {
                    if (avatarPreview && previousPreview) avatarPreview.src = previousPreview;
                    setNavbarAvatar(previousSavedAvatar);
                    showAvatarToast(error.message || 'The profile picture could not be removed. Please try again.', true);
                } finally {
                    removeAvatarButton.classList.remove('is-loading');
                    removeAvatarButton.disabled = false;
                    removeAvatarButton.removeAttribute('aria-busy');
                }
            });

            profileForm?.addEventListener('submit', () => {
                if (!profileForm.checkValidity()) return;
                profileSubmit?.classList.add('is-loading');
                profileSubmit?.setAttribute('aria-busy', 'true');
                if (avatarInput?.files?.length) {
                    root.querySelector('[data-profile-upload-progress]')?.classList.add('is-active');
                    if (avatarStatus) avatarStatus.textContent = 'Uploading your profile picture…';
                }
                profileSubmit?.setAttribute('disabled', 'disabled');
            });

            root.querySelectorAll('[data-profile-password-toggle]').forEach((button) => {
                const input = root.querySelector(`#${button.dataset.profilePasswordToggle}`);
                button.addEventListener('click', () => {
                    const show = input.type === 'password';
                    input.type = show ? 'text' : 'password';
                    button.setAttribute('aria-pressed', String(show));
                    button.setAttribute('aria-label', `${show ? 'Hide' : 'Show'} ${input.dataset.label}`);
                    button.querySelector('[data-eye-show]').hidden = show;
                    button.querySelector('[data-eye-hide]').hidden = !show;
                });
            });

            const newPassword = root.querySelector('#profile-new-password');
            const confirmation = root.querySelector('#profile-password-confirmation');
            const meter = root.querySelector('[data-profile-password-strength]');
            const meterText = root.querySelector('[data-profile-password-strength-label]');
            const matchText = root.querySelector('[data-profile-password-match]');
            const segments = [...(meter?.querySelectorAll('.fh-profile-strength__segment') ?? [])];

            const updateMatch = () => {
                if (!matchText || !confirmation?.value) {
                    if (matchText) matchText.textContent = '';
                    return;
                }
                const matches = confirmation.value === newPassword.value;
                matchText.textContent = matches ? 'Passwords match.' : 'Passwords do not match yet.';
                matchText.classList.toggle('is-match', matches);
                matchText.classList.toggle('is-mismatch', !matches);
            };

            newPassword?.addEventListener('input', () => {
                const value = newPassword.value;
                let score = 0;
                if (value.length >= 8) {
                    score = 1;
                    if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
                    if (/\d/.test(value)) score++;
                    if (/[^A-Za-z0-9]/.test(value) || value.length >= 14) score++;
                }
                if (meter) {
                    meter.dataset.strength = String(score);
                    meter.setAttribute('aria-valuenow', String(score));
                }
                if (meterText) meterText.textContent = value ? ['Too short', 'Weak', 'Fair', 'Good', 'Strong'][score] : 'Not set';
                segments.forEach((segment, index) => segment.classList.toggle('is-active', index < score));
                updateMatch();
            });
            confirmation?.addEventListener('input', updateMatch);

            root.querySelector('#profile-password-form')?.addEventListener('submit', (event) => {
                const form = event.currentTarget;
                if (!form.checkValidity()) return;
                const button = form.querySelector('[type="submit"]');
                button?.classList.add('is-loading');
                const loading = button?.querySelector('.fh-profile-button__loading');
                if (loading) loading.hidden = false;
                button?.setAttribute('aria-busy', 'true');
            });

            // The confirmation modal is teleported to <body> after Alpine
            // initializes, so use delegation for its submit/loading state.
            document.addEventListener('submit', (event) => {
                const form = event.target;
                if (form?.id !== 'profile-delete-account-form') return;
                if (!form.checkValidity()) return;
                const button = form.querySelector('[type="submit"]');
                button?.classList.add('is-loading');
                button?.setAttribute('aria-busy', 'true');
                button?.setAttribute('disabled', 'disabled');
            });
        })();
    </script>
</x-app-layout>
