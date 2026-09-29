<style>

:root {
    --fh-purple: #8b5cf6;
    --fh-purple-light: #a855f7;
    --fh-pink: #ec4899;
    --fh-bg: #0a0a12;
    --fh-card: #12141f;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body.fh-auth-body {
    font-family: 'Figtree', sans-serif;
    background: var(--fh-bg);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow-x: hidden;
    color: #fff;
}
.fh-auth-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background: radial-gradient(ellipse 80% 60% at 20% 40%, rgba(139,92,246,.18) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(236,72,153,.12) 0%, transparent 55%),
                var(--fh-bg);
    pointer-events: none;
}
.fh-auth-orb {
    position: absolute;
    border-radius: 999px;
    filter: blur(80px);
    pointer-events: none;
    animation: fh-auth-float 8s ease-in-out infinite;
}
.fh-auth-orb--1 {
    width: 400px; height: 400px;
    background: rgba(139,92,246,.15);
    top: -100px; left: -100px;
    animation-delay: 0s;
}
.fh-auth-orb--2 {
    width: 300px; height: 300px;
    background: rgba(236,72,153,.1);
    bottom: -80px; right: -80px;
    animation-delay: -4s;
}
.fh-auth-orb--3 {
    width: 200px; height: 200px;
    background: rgba(168,85,247,.12);
    top: 50%; left: 30%;
    animation-delay: -2s;
}
@keyframes fh-auth-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}
.fh-auth-back {
    position: fixed;
    top: 1.25rem;
    left: 1.25rem;
    z-index: 10;
    display: inline-flex;
    align-items: center;
    gap: .4rem;
    font-size: .82rem;
    font-weight: 500;
    color: #9ca3af;
    text-decoration: none;
    padding: .45rem .85rem;
    border-radius: 999px;
    border: 1px solid rgba(255,255,255,.08);
    background: rgba(255,255,255,.03);
    backdrop-filter: blur(12px);
    transition: color .2s, background .2s, border-color .2s;
}
.fh-auth-back:hover { color: #fff; background: rgba(255,255,255,.07); border-color: rgba(255,255,255,.15); }
.fh-auth-back svg { width: 14px; height: 14px; flex-shrink: 0; }
.fh-auth-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 960px;
    margin: 2rem 1rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: 1.25rem;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,.07);
    box-shadow: 0 40px 80px -20px rgba(0,0,0,.7), 0 0 0 1px rgba(139,92,246,.08);
    animation: fh-auth-enter .35s cubic-bezier(.22,.68,0,1.01) both;
}
@keyframes fh-auth-enter {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
}
@media (max-width: 767px) {
    .fh-auth-wrap { grid-template-columns: 1fr; max-width: 440px; }
    .fh-auth-brand { display: none !important; }
}


.fh-auth-brand {
    position: relative;
    padding: 2.5rem 2rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: linear-gradient(145deg, #0f0f1e 0%, #13102a 50%, #0f0f1e 100%);
    border-right: 1px solid rgba(255,255,255,.06);
    overflow: hidden;
    min-height: 560px;
}
.fh-auth-brand__orb-a {
    position: absolute;
    width: 320px; height: 320px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(139,92,246,.25) 0%, transparent 70%);
    top: -80px; right: -80px;
    animation: fh-auth-float 9s ease-in-out infinite;
}
.fh-auth-brand__orb-b {
    position: absolute;
    width: 240px; height: 240px;
    border-radius: 999px;
    background: radial-gradient(circle, rgba(236,72,153,.18) 0%, transparent 70%);
    bottom: -60px; left: -60px;
    animation: fh-auth-float 11s ease-in-out infinite reverse;
}
.fh-auth-logo {
    display: inline-flex;
    align-items: center;
    gap: .65rem;
    position: relative;
    z-index: 1;
}
.fh-auth-logo__mark {
    width: 160px; height: 72px;
    object-fit: contain;
    flex-shrink: 0;
}
.fh-auth-logo__text {
    font-size: 1.25rem;
    font-weight: 700;
    color: #e5e7eb;
    letter-spacing: -.01em;
}
.fh-auth-logo__text span {
    background: linear-gradient(135deg, #a855f7, #ec4899);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 800;
}
.fh-auth-brand__body {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 2rem 0;
}
.fh-auth-brand__tagline {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.3;
    color: #fff;
    margin-bottom: 1.75rem;
    letter-spacing: -.02em;
}
.fh-auth-brand__tagline span {
    background: linear-gradient(135deg, var(--fh-purple), var(--fh-pink));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.fh-auth-features {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: .9rem;
}
.fh-auth-features li {
    display: flex;
    align-items: center;
    gap: .75rem;
    font-size: .9rem;
    color: #d1d5db;
    font-weight: 500;
}
.fh-auth-features li .fh-auth-feat-icon {
    width: 34px; height: 34px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(139,92,246,.12);
    border: 1px solid rgba(139,92,246,.2);
    font-size: 1rem;
    flex-shrink: 0;
}
.fh-auth-brand__footer {
    position: relative;
    z-index: 1;
    font-size: .75rem;
    color: #6b7280;
}
.fh-auth-form-panel {
    background: var(--fh-card);
    padding: 2.5rem 2.25rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
@media (max-width: 767px) {
    .fh-auth-form-panel { padding: 2rem 1.5rem; }
}
.fh-auth-heading { font-size: 1.5rem; font-weight: 700; color: #fff; letter-spacing: -.02em; }
.fh-auth-subheading { font-size: .875rem; color: #9ca3af; margin-top: .35rem; margin-bottom: 1.75rem; }
.fh-auth-status {
    margin-bottom: 1rem;
    padding: .75rem 1rem;
    border-radius: .75rem;
    background: rgba(139,92,246,.1);
    border: 1px solid rgba(139,92,246,.25);
    font-size: .82rem;
    color: #c4b5fd;
}
.fh-auth-field { margin-bottom: 1.1rem; }
.fh-auth-label {
    display: block;
    font-size: .8rem;
    font-weight: 600;
    color: #d1d5db;
    margin-bottom: .45rem;
    letter-spacing: .01em;
}
.fh-auth-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
}
.fh-auth-input-icon {
    position: absolute;
    left: .85rem;
    color: #6b7280;
    pointer-events: none;
    display: flex;
    align-items: center;
}
.fh-auth-input-icon svg { width: 16px; height: 16px; }
.fh-auth-input {
    width: 100%;
    padding: .7rem .9rem .7rem 2.6rem;
    background: rgba(255,255,255,.03);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: .75rem;
    color: #f3f4f6;
    font-size: .9rem;
    font-family: 'Figtree', sans-serif;
    outline: none;
    transition: border-color .2s, box-shadow .2s, transform .2s;
    -webkit-appearance: none;
}
.fh-auth-input::placeholder { color: #4b5563; }
.fh-auth-input:focus {
    border-color: var(--fh-purple);
    box-shadow: 0 0 0 3px rgba(139,92,246,.18);
    transform: scale(1.005);
}
.fh-auth-input--has-trail { padding-right: 2.8rem; }
.fh-auth-eye {
    position: absolute;
    right: .75rem;
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    padding: .25rem;
    border-radius: 4px;
    transition: color .2s;
}
.fh-auth-eye:hover { color: #d1d5db; }
.fh-auth-eye svg { width: 16px; height: 16px; }
.fh-auth-error {
    margin-top: .4rem;
    font-size: .78rem;
    color: #f87171;
    display: flex;
    align-items: center;
    gap: .3rem;
}
.fh-auth-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    gap: .5rem;
}
.fh-auth-check-label {
    display: inline-flex;
    align-items: center;
    gap: .5rem;
    font-size: .82rem;
    color: #9ca3af;
    cursor: pointer;
    user-select: none;
}
.fh-auth-check {
    width: 16px; height: 16px;
    border-radius: 4px;
    border: 1.5px solid rgba(255,255,255,.2);
    background: rgba(255,255,255,.04);
    accent-color: var(--fh-purple);
    cursor: pointer;
    flex-shrink: 0;
}
.fh-auth-forgot {
    font-size: .82rem;
    color: #a78bfa;
    text-decoration: none;
    transition: color .2s;
    white-space: nowrap;
}
.fh-auth-forgot:hover { color: #fff; }
.fh-auth-submit {
    width: 100%;
    padding: .8rem 1rem;
    border: none;
    border-radius: .75rem;
    background: linear-gradient(135deg, #8b5cf6, #a855f7);
    color: #fff;
    font-size: .95rem;
    font-weight: 600;
    font-family: 'Figtree', sans-serif;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    box-shadow: 0 10px 28px -10px rgba(139,92,246,.8);
    transition: transform .25s cubic-bezier(.22,.68,0,1.01), box-shadow .25s;
    position: relative;
    overflow: hidden;
}
.fh-auth-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 16px 36px -10px rgba(139,92,246,1);
}
.fh-auth-submit:active { transform: translateY(0); }
.fh-auth-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }
.fh-auth-spinner {
    width: 18px; height: 18px;
    border: 2px solid rgba(255,255,255,.3);
    border-top-color: #fff;
    border-radius: 999px;
    animation: fh-auth-spin .7s linear infinite;
    display: none;
}
@keyframes fh-auth-spin { to { transform: rotate(360deg); } }
.fh-auth-submit.is-loading .fh-auth-spinner { display: block; }
.fh-auth-submit.is-loading .fh-auth-btn-text { display: none; }
.fh-auth-ripple {
    position: absolute;
    border-radius: 999px;
    background: rgba(255,255,255,.25);
    transform: scale(0);
    animation: fh-auth-ripple-anim .5s linear;
    pointer-events: none;
}
@keyframes fh-auth-ripple-anim {
    to { transform: scale(4); opacity: 0; }
}
.fh-auth-divider {
    display: flex;
    align-items: center;
    gap: .75rem;
    margin: 1.25rem 0;
    font-size: .75rem;
    color: #4b5563;
}
.fh-auth-divider::before,
.fh-auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255,255,255,.07);
}
.fh-auth-socials {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: .75rem;
    margin-bottom: 1.5rem;
}
.fh-auth-social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    padding: .65rem .9rem;
    border-radius: .75rem;
    border: 1px solid rgba(255,255,255,.1);
    background: rgba(255,255,255,.03);
    color: #d1d5db;
    font-size: .82rem;
    font-weight: 600;
    font-family: 'Figtree', sans-serif;
    cursor: pointer;
    text-decoration: none;
    transition: border-color .2s, background .2s, color .2s;
}
.fh-auth-social-btn:hover {
    border-color: rgba(255,255,255,.22);
    background: rgba(255,255,255,.07);
    color: #fff;
}
.fh-auth-social-btn svg {
    width: 18px; height: 18px;
    flex-shrink: 0;
    transition: transform .3s cubic-bezier(.22,.68,0,1.01);
}
.fh-auth-social-btn:hover svg { transform: rotate(8deg) scale(1.1); }
.fh-auth-footer-links {
    text-align: center;
    font-size: .82rem;
    color: #6b7280;
    margin-bottom: .6rem;
}
.fh-auth-footer-links a {
    color: #a78bfa;
    text-decoration: none;
    font-weight: 600;
    transition: color .2s;
}
.fh-auth-footer-links a:hover { color: #fff; }
.fh-auth-legal {
    text-align: center;
    font-size: .72rem;
    color: #4b5563;
}
.fh-auth-legal a { color: #6b7280; text-decoration: none; transition: color .2s; }
.fh-auth-legal a:hover { color: #9ca3af; }

.fh-register-art{position:relative;isolation:isolate;display:grid;min-height:148px;place-items:center;overflow:hidden;margin-top:1.45rem;border:1px solid rgba(196,181,253,.16);border-radius:1rem;background:radial-gradient(ellipse at 50% 110%,rgba(139,92,246,.3),transparent 60%),linear-gradient(135deg,rgba(255,255,255,.05),rgba(255,255,255,.01))}
.fh-register-art::before,.fh-register-art::after{content:"";position:absolute;z-index:-1;width:110px;height:145px;border:1px solid rgba(196,181,253,.3);border-radius:1rem;background:linear-gradient(145deg,rgba(139,92,246,.22),rgba(236,72,153,.06));box-shadow:0 16px 35px rgba(0,0,0,.28)}
.fh-register-art::before{transform:translateX(-36px) rotate(-13deg)}
.fh-register-art::after{transform:translateX(36px) rotate(13deg);background:linear-gradient(145deg,rgba(236,72,153,.16),rgba(139,92,246,.12))}
.fh-register-art__center{position:relative;z-index:1;display:grid;width:86px;height:112px;place-items:center;border:1px solid rgba(255,255,255,.22);border-radius:.85rem;background:linear-gradient(145deg,rgba(34,26,58,.96),rgba(18,15,32,.96));box-shadow:0 18px 42px rgba(0,0,0,.45),0 0 26px rgba(139,92,246,.2);color:#d8b4fe}
.fh-register-art__center svg{width:36px;height:36px;filter:drop-shadow(0 0 12px rgba(192,132,252,.5))}
.fh-register-art__caption{position:absolute;right:.85rem;bottom:.7rem;left:.85rem;color:#a5a0b9;font-size:.61rem;font-weight:700;letter-spacing:.2em;text-align:center;text-transform:uppercase}
.fh-auth-strength{display:flex;align-items:center;gap:.55rem;margin-top:.55rem}
.fh-auth-strength__track{display:flex;flex:1;gap:.25rem}
.fh-auth-strength__segment{height:4px;flex:1;border-radius:99px;background:rgba(255,255,255,.1);transition:background .2s,box-shadow .2s}
.fh-auth-strength__segment.is-active{background:#8b5cf6;box-shadow:0 0 9px rgba(139,92,246,.45)}
.fh-auth-strength[data-strength="2"] .fh-auth-strength__segment.is-active{background:#f59e0b;box-shadow:0 0 9px rgba(245,158,11,.3)}
.fh-auth-strength[data-strength="3"] .fh-auth-strength__segment.is-active,.fh-auth-strength[data-strength="4"] .fh-auth-strength__segment.is-active{background:#34d399;box-shadow:0 0 9px rgba(52,211,153,.32)}
.fh-auth-strength__label{min-width:4.5rem;color:#6b7280;font-size:.7rem;text-align:right}
.fh-auth-match{min-height:1rem;margin-top:.4rem;color:#6b7280;font-size:.72rem}
.fh-auth-match.is-match{color:#6ee7b7}
.fh-auth-match.is-mismatch{color:#fca5a5}
.fh-auth-field .fh-auth-error{margin:.4rem 0 0}
.fh-auth-input[aria-invalid="true"]{border-color:rgba(248,113,113,.8);box-shadow:0 0 0 3px rgba(248,113,113,.12)}
.fh-auth-form-panel--register{padding-top:2rem;padding-bottom:2rem}
.fh-auth-form-panel--register .fh-auth-subheading{margin-bottom:1.1rem}
.fh-auth-form-panel--register .fh-auth-field{margin-bottom:.82rem}
.fh-auth-form-panel--register .fh-auth-input{padding-top:.66rem;padding-bottom:.66rem}
.fh-auth-form-panel--register .fh-auth-footer-links{margin-top:1.05rem}
@media(max-width:767px){.fh-auth-wrap{margin:4rem .85rem 1.25rem}.fh-auth-form-panel--register{padding:1.6rem 1.25rem}.fh-auth-brand{display:none!important}}
@media(max-width:380px){.fh-auth-back{top:.65rem;left:.65rem}.fh-auth-form-panel--register{padding:1.4rem 1rem}.fh-auth-heading{font-size:1.35rem}}
@media(prefers-reduced-motion:reduce){.fh-auth-orb,.fh-auth-brand__orb-a,.fh-auth-brand__orb-b,.fh-auth-wrap{animation:none!important}.fh-auth-wrap,.fh-auth-submit,.fh-auth-input,.fh-auth-eye,.fh-auth-strength__segment{transition-duration:.01ms!important}}
</style>
