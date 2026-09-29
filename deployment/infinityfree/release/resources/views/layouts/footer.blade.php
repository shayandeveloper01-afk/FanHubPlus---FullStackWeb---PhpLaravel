<style>
    .fh-premium-footer{position:relative;isolation:isolate;overflow:hidden;margin-top:2rem;border-top:1px solid rgba(167,139,250,.24);background:radial-gradient(ellipse at 12% 0%,rgba(124,58,237,.18),transparent 42%),linear-gradient(180deg,#0b0a13,#0e0d18);color:#9ca3af}
    .fh-premium-footer::before{content:"";position:absolute;z-index:-1;inset:0 0 auto;height:1px;background:linear-gradient(90deg,transparent,rgba(139,92,246,.8),rgba(236,72,153,.65),transparent)}
    .fh-premium-footer__inner{max-width:1320px;margin:auto;padding:2.5rem 1.5rem 1.25rem}
    .fh-premium-footer__grid{display:grid;grid-template-columns:1.35fr repeat(3,minmax(0,1fr));gap:2rem}
    .fh-premium-footer__brand{display:inline-flex;align-items:center;color:#fff;text-decoration:none}
    .fh-premium-footer__logo{display:block;width:220px;height:90px;object-fit:contain}
    .fh-premium-footer__brand-column{scroll-margin-top:84px}
    .fh-premium-footer__description{max-width:260px;margin:.9rem 0 1rem;color:#9ca3af;font-size:.88rem;line-height:1.65}
    .fh-premium-footer__title{margin:0 0 .9rem;color:#f3f4f6;font-size:.75rem;font-weight:750;letter-spacing:.12em;text-transform:uppercase}
    .fh-premium-footer__list{list-style:none;margin:0;padding:0}
    .fh-premium-footer__list li+li{margin-top:.52rem}
    .fh-premium-footer__list a{display:inline-flex;color:#9ca3af;text-decoration:none;font-size:.84rem;transition:color .2s,transform .2s}
    .fh-premium-footer__list a:hover{color:#d8b4fe;transform:translateX(3px)}
    .fh-premium-footer a:focus-visible{outline:2px solid #c084fc;outline-offset:4px;border-radius:3px}
    .fh-premium-footer__social{display:flex;gap:.55rem;margin-top:1.15rem}
    .fh-premium-footer__social a{display:grid;width:36px;height:36px;place-items:center;border:1px solid rgba(255,255,255,.1);border-radius:11px;background:rgba(255,255,255,.035);color:#a78bfa;transition:transform .2s,border-color .2s,background .2s,color .2s}
    .fh-premium-footer__social a[aria-label^="GitHub"]{order:1}
    .fh-premium-footer__social a[aria-label^="LinkedIn"]{order:2}
    .fh-premium-footer__social a[aria-label^="WhatsApp"]{order:3}
    .fh-premium-footer__social a[aria-label^="Facebook"]{order:4}
    .fh-premium-footer__social a[aria-label^="Instagram"]{order:5}
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
    @media(max-width:767px){
        .fh-premium-footer{overflow-wrap:anywhere}
        .fh-premium-footer__inner{padding-left:max(1rem,env(safe-area-inset-left));padding-right:max(1rem,env(safe-area-inset-right))}
        .fh-premium-footer__logo{width:min(220px,75vw);height:auto;max-height:82px}
        .fh-premium-footer__grid>nav{min-width:0}
        .fh-premium-footer__list a{display:inline;line-height:1.55}
        .fh-premium-footer__bottom{align-items:flex-start;flex-direction:column;gap:.65rem}
        .fh-premium-footer__legal{gap:.6rem 1rem}
    }
    @media(max-width:360px){.fh-premium-footer__grid{column-gap:.85rem}.fh-premium-footer__title{font-size:.69rem}.fh-premium-footer__list a{font-size:.76rem}}
</style>
<footer class="fh-premium-footer" aria-label="Site footer">
    <div class="fh-premium-footer__inner">
        <div class="fh-premium-footer__grid">
            <div class="fh-premium-footer__brand-column">
                <a class="fh-premium-footer__brand" href="{{ route('home') }}" aria-label="FanHub Plus home">
                    <img src="{{ asset('images/fanhub-plus-logo.png') }}" alt="FanHub+" class="fh-premium-footer__logo">
                </a>
                <p class="fh-premium-footer__description">Discover, watch, and share fan-made content.</p>
                <div class="fh-premium-footer__social" aria-label="Share FanHub Plus">
                    <a href="https://wa.me/923352697296" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Muhammad Shayan"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 3.5A11.8 11.8 0 0 0 2 17.7L.5 23.5l6-1.6A11.8 11.8 0 1 0 20.5 3.5ZM12 21a9.1 9.1 0 0 1-4.6-1.2l-.3-.2-3.5.9.9-3.4-.2-.4A9.1 9.1 0 1 1 12 21Zm5-6.8c-.3-.2-1.7-.9-2-.9s-.5-.2-.7.2-.8.9-1 1.1-.4.2-.7.1a7.5 7.5 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.9c-.2-.3 0-.5.1-.6l.5-.6.2-.5c.1-.2 0-.4 0-.6l-.9-2.1c-.2-.5-.5-.4-.7-.4h-.6a1.2 1.2 0 0 0-.8.4 3.3 3.3 0 0 0-1 2.4 5.7 5.7 0 0 0 1.2 3c.2.3 1.8 2.8 4.4 3.9 2.2 1 3.1 1 4.2.8.7-.1 1.7-.7 1.9-1.4.3-.7.3-1.3.2-1.4s-.3-.2-.6-.4Z"/></svg></a>
                    <a href="https://www.facebook.com/share/1DJs4qqpjj/" target="_blank" rel="noopener noreferrer" aria-label="Facebook Muhammad Shayan"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.4c0-3.03 1.79-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.96.93-1.96 1.88v2.28h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07Z"/></svg></a>
                    <a href="https://www.instagram.com/muhammadshayanrizvii/" target="_blank" rel="noopener noreferrer" aria-label="Instagram muhammadshayanrizvii"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm0 2.1A2.9 2.9 0 0 0 4.1 7v10A2.9 2.9 0 0 0 7 19.9h10a2.9 2.9 0 0 0 2.9-2.9V7A2.9 2.9 0 0 0 17 4.1H7Zm5 2.4a5.5 5.5 0 1 1 0 11 5.5 5.5 0 0 1 0-11Zm0 2.1a3.4 3.4 0 1 0 0 6.8 3.4 3.4 0 0 0 0-6.8Zm5.7-3.1a1.3 1.3 0 1 1 0 2.6 1.3 1.3 0 0 1 0-2.6Z"/></svg></a>
                    <a href="https://www.linkedin.com/in/𝗠𝗨𝗛𝗔𝗠𝗠𝗔𝗗-𝗦𝗛𝗔𝗬𝗔𝗡-709964398" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn Muhammad Shayan"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.45 2H3.55A1.55 1.55 0 0 0 2 3.55v16.9A1.55 1.55 0 0 0 3.55 22h16.9A1.55 1.55 0 0 0 22 20.45V3.55A1.55 1.55 0 0 0 20.45 2ZM8 19H4.9V9H8v10ZM6.45 7.63a1.8 1.8 0 1 1 0-3.6 1.8 1.8 0 0 1 0 3.6ZM19.1 19H16v-4.86c0-1.16-.02-2.65-1.62-2.65-1.62 0-1.87 1.27-1.87 2.57V19H9.4V9h2.98v1.37h.04a3.27 3.27 0 0 1 2.95-1.62c3.15 0 3.73 2.07 3.73 4.76V19Z"/></svg></a>
                    <a href="https://github.com/shayandeveloper01-afk" target="_blank" rel="noopener noreferrer" aria-label="GitHub shayandeveloper01-afk"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 .8a11.2 11.2 0 0 0-3.54 21.83c.56.1.76-.24.76-.54v-2.1c-3.1.67-3.76-1.32-3.76-1.32-.51-1.3-1.25-1.65-1.25-1.65-1.02-.7.08-.69.08-.69 1.13.08 1.72 1.16 1.72 1.16 1 .1.73 2.23 3.26 1.58.1-.73.4-1.23.7-1.51-2.48-.28-5.09-1.25-5.09-5.54 0-1.22.44-2.22 1.16-3-.12-.28-.5-1.43.11-2.97 0 0 .95-.3 3.08 1.15a10.7 10.7 0 0 1 5.6 0c2.13-1.45 3.07-1.15 3.07-1.15.62 1.54.23 2.69.12 2.97.72.78 1.15 1.78 1.15 3 0 4.3-2.61 5.25-5.1 5.53.4.35.75 1.03.75 2.08v3.08c0 .3.2.65.76.54A11.2 11.2 0 0 0 12 .8Z"/></svg></a>
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
