<style>
    .fh-premium-footer{position:relative;isolation:isolate;overflow:hidden;margin-top:2rem;border-top:1px solid rgba(167,139,250,.24);background:radial-gradient(ellipse at 12% 0%,rgba(124,58,237,.18),transparent 42%),linear-gradient(180deg,#0b0a13,#0e0d18);color:#9ca3af}
    .fh-premium-footer::before{content:"";position:absolute;z-index:-1;inset:0 0 auto;height:1px;background:linear-gradient(90deg,transparent,rgba(139,92,246,.8),rgba(236,72,153,.65),transparent)}
    .fh-premium-footer__inner{max-width:1320px;margin:auto;padding:2.5rem 1.5rem 1.25rem}
    .fh-premium-footer__grid{display:grid;grid-template-columns:1.35fr repeat(3,minmax(0,1fr));gap:2rem}
    .fh-premium-footer__brand{display:inline-flex;align-items:center;gap:.7rem;color:#fff;text-decoration:none;font-size:1.15rem;font-weight:750;letter-spacing:-.02em}
    .fh-premium-footer__brand-column{scroll-margin-top:84px}
    .fh-premium-footer__brand span span{color:#c084fc}
    .fh-premium-footer__description{max-width:260px;margin:.9rem 0 1rem;color:#9ca3af;font-size:.88rem;line-height:1.65}
    .fh-premium-footer__title{margin:0 0 .9rem;color:#f3f4f6;font-size:.75rem;font-weight:750;letter-spacing:.12em;text-transform:uppercase}
    .fh-premium-footer__list{list-style:none;margin:0;padding:0}
    .fh-premium-footer__list li+li{margin-top:.52rem}
    .fh-premium-footer__list a{display:inline-flex;color:#9ca3af;text-decoration:none;font-size:.84rem;transition:color .2s,transform .2s}
    .fh-premium-footer__list a:hover{color:#d8b4fe;transform:translateX(3px)}
    .fh-premium-footer a:focus-visible{outline:2px solid #c084fc;outline-offset:4px;border-radius:3px}
    .fh-premium-footer__social{display:flex;gap:.55rem;margin-top:1.15rem}
    .fh-premium-footer__social a{display:grid;width:36px;height:36px;place-items:center;border:1px solid rgba(255,255,255,.1);border-radius:11px;background:rgba(255,255,255,.035);color:#a78bfa;transition:transform .2s,border-color .2s,background .2s,color .2s}
    .fh-premium-footer__social a:hover{transform:translateY(-2px);border-color:rgba(167,139,250,.55);background:rgba(139,92,246,.16);color:#fff}
    .fh-premium-footer__social svg{width:17px;height:17px;fill:currentColor}
    .fh-premium-footer__bottom{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:.65rem 1.5rem;margin-top:1.55rem;padding-top:.9rem;border-top:1px solid rgba(255,255,255,.08);font-size:.76rem;color:#777487}
    .fh-premium-footer__legal{display:flex;flex-wrap:wrap;gap:.75rem 1rem}
    .fh-premium-footer__legal a{color:inherit;text-decoration:none;transition:color .2s}
    .fh-premium-footer__legal a:hover{color:#c4b5fd}
    [data-theme="light"] .fh-premium-footer{background:radial-gradient(ellipse at 12% 0%,rgba(124,58,237,.1),transparent 42%),linear-gradient(180deg,#f2f0f8,#e8e7f1);border-color:rgba(139,92,246,.24)}
    [data-theme="light"] .fh-premium-footer__brand,[data-theme="light"] .fh-premium-footer__title{color:#171521}
    [data-theme="light"] .fh-premium-footer__description,[data-theme="light"] .fh-premium-footer__list a,[data-theme="light"] .fh-premium-footer__bottom{color:#696779}
    [data-theme="light"] .fh-premium-footer__social a{border-color:rgba(0,0,0,.1);background:rgba(0,0,0,.035);color:#6d42bd}
    @media(max-width:767px){.fh-premium-footer__grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:1.75rem 1.25rem}.fh-premium-footer__brand-column{grid-column:1/-1}.fh-premium-footer__inner{padding:2rem 1.25rem 1rem}}
    @media(max-width:420px){.fh-premium-footer__list a{font-size:.8rem}}
</style>
<footer class="fh-premium-footer" aria-label="Site footer">
    <div class="fh-premium-footer__inner">
        <div class="fh-premium-footer__grid">
            <div class="fh-premium-footer__brand-column">
                <a class="fh-premium-footer__brand" href="{{ route('home') }}" aria-label="FanHub Plus home">
                    <x-fh-logo-mark /><span>FanHub<span>+</span></span>
                </a>
                <p class="fh-premium-footer__description">Discover, watch, and share fan-made content.</p>
                <div class="fh-premium-footer__social" aria-label="Share FanHub Plus">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url('/')) }}" target="_blank" rel="noopener noreferrer" aria-label="Share FanHub Plus on X"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23.2 22h-6.3L12 14.6 5.6 22H2.5l7.3-8.4L1.9 2h6.5l4.5 6.8L18.9 2Zm-1.1 18h1.7L7.4 3.9H5.6L17.8 20Z"/></svg></a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url('/')) }}" target="_blank" rel="noopener noreferrer" aria-label="Share FanHub Plus on Facebook"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2v-2c0-.9.3-1.6 1.6-1.6h1.7V4.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.3H7.3v3.2h2.8V22h3.4Z"/></svg></a>
                </div>
            </div>
            <nav aria-label="Explore links"><h2 class="fh-premium-footer__title">Explore</h2><ul class="fh-premium-footer__list">
                <li><a href="{{ route('home') }}">Home</a></li><li><a href="{{ route('explore') }}">Explore</a></li><li><a href="{{ route('events.index') }}">Events</a></li><li><a href="{{ route('merchandise.index') }}">Shop</a></li>
            </ul></nav>
            <nav aria-label="Category links"><h2 class="fh-premium-footer__title">Categories</h2><ul class="fh-premium-footer__list">
                @foreach (['Anime', 'Comics', 'Cosplay', 'Gaming', 'Manga', 'Movies', 'TV Series'] as $categoryName)
                    <li><a href="{{ route('categories.show', \Illuminate\Support\Str::slug($categoryName)) }}">{{ $categoryName }}</a></li>
                @endforeach
            </ul></nav>
            <nav aria-label="Quick links"><h2 class="fh-premium-footer__title">Quick Links</h2><ul class="fh-premium-footer__list">
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('feedback.create') }}">Contact</a></li>
                <li><a href="{{ route('feedback.create') }}">Feedback</a></li>
                <li><a href="{{ route('faqs.index') }}">FAQ</a></li>
                <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                <li><a href="{{ route('terms') }}">Terms</a></li>
            </ul></nav>
        </div>
        <div class="fh-premium-footer__bottom">
            <span>&copy; {{ date('Y') }} FanHub Plus. All rights reserved.</span>
            <div class="fh-premium-footer__legal" aria-label="Legal links">
                <a href="{{ route('privacy-policy') }}">Privacy</a>
                <a href="{{ route('terms') }}">Terms</a>
            </div>
            <span>Built with Laravel.</span>
        </div>
    </div>
</footer>
{{-- Retired footer markup. The shared premium footer is rendered above.
    <div class="fh-site-footer__inner">
        <div class="fh-site-footer__grid">
            <div>
                <a class="fh-site-footer__brand" href="{{ route('home') }}">FanHub+</a>
                <p>Discover, watch, and share fan-made content.</p>
            </div>
            <div>
                <h2>Explore</h2>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('explore') }}">Explore</a>
                <a href="{{ route('events.index') }}">Cosplay Events</a>
                <a href="{{ route('merchandise.index') }}">Shop</a>
            </div>
            <div>
                <h3>Categories</h3>
                @foreach (['Anime', 'Comics', 'Cosplay', 'Gaming', 'Manga', 'Movies', 'TV Series'] as $categoryName)
                    <a href="{{ route('categories.show', \Illuminate\Support\Str::slug($categoryName)) }}">{{ $categoryName }}</a>
                @endforeach
            </div>
        </div>
        <div class="fh-site-footer__bottom">© {{ date('Y') }} FanHub Plus · Built with Laravel</div>
    </div>
</footer>
--}}
