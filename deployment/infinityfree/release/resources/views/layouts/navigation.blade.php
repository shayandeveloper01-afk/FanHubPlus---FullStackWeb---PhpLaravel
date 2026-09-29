<style>
.fh-nav{position:fixed;top:0;left:0;right:0;z-index:50;
    background:rgba(10,10,18,.82);backdrop-filter:blur(20px) saturate(180%);
    -webkit-backdrop-filter:blur(20px) saturate(180%);
    transition:background .3s,box-shadow .3s}
.fh-nav::after{content:'';position:absolute;left:0;right:0;bottom:0;height:1px;
    background:linear-gradient(90deg,transparent,rgba(139,92,246,.5) 25%,rgba(236,72,153,.7) 50%,rgba(139,92,246,.5) 75%,transparent);opacity:.6}
.fh-nav.scrolled{background:rgba(10,10,18,.97);box-shadow:0 12px 40px -22px rgba(139,92,246,.6)}
.fh-nav__inner{max-width:1320px;margin:0 auto;padding:0 1.5rem;height:68px;
    display:flex;align-items:center;justify-content:space-between;gap:1rem}
.fh-brand{display:inline-flex;align-items:center;gap:.6rem;
    font-weight:700;letter-spacing:-.01em;color:#fff;text-decoration:none;transition:transform .3s}
.fh-brand:hover{transform:translateY(-1px)}
.fh-brand__logo{display:block;width:158px;height:62px;object-fit:contain;flex-shrink:0}
.fh-nav__links{display:none;align-items:center;gap:.1rem;margin-left:.55rem}
.fh-nav__link{position:relative;padding:.5rem .68rem;font-size:.84rem;font-weight:500;
    color:#9ca3af;border-radius:8px;transition:color .2s;text-decoration:none}
.fh-nav__link:hover{color:#fff}
.fh-nav__link::after{content:'';position:absolute;left:1rem;right:1rem;bottom:.15rem;
    height:2px;border-radius:2px;background:#fff;transform:scaleX(0);transform-origin:left;
    transition:transform .3s cubic-bezier(.22,.68,0,1.01)}
.fh-nav__link:hover::after,.fh-nav__link.is-active::after{transform:scaleX(1)}
.fh-nav__link.is-active{color:#fff;font-weight:600}
.fh-nav__actions{display:flex;align-items:center;gap:.5rem}
.fh-nav__btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.84rem;
    font-weight:600;padding:.55rem 1.1rem;border-radius:999px;transition:all .25s;
    text-decoration:none;border:none;cursor:pointer;font-family:inherit}
.fh-nav__btn--ghost{color:#d1d5db;background:transparent}
.fh-nav__btn--ghost:hover{color:#fff;background:rgba(255,255,255,.06)}
.fh-nav__btn--primary{color:#fff;background:linear-gradient(135deg,#8b5cf6,#a855f7);
    box-shadow:0 10px 24px -10px rgba(139,92,246,.9)}
.fh-nav__btn--primary:hover{transform:translateY(-1px);box-shadow:0 14px 30px -10px rgba(139,92,246,1)}
.fh-nav__icon-btn{position:relative;width:38px;height:38px;display:inline-flex;
    align-items:center;justify-content:center;border-radius:999px;color:#9ca3af;
    background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
    transition:all .25s;text-decoration:none;flex-shrink:0}
.fh-nav__icon-btn:hover{color:#fff;background:rgba(139,92,246,.15);border-color:rgba(139,92,246,.4)}
.fh-nav__icon-btn svg{width:17px;height:17px}
.fh-nav__avatar-btn{display:flex;align-items:center;gap:.5rem;font-size:.84rem;
    color:#d1d5db;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
    border-radius:999px;padding:.35rem .75rem .35rem .35rem;cursor:pointer;
    transition:all .25s;font-family:inherit}
.fh-nav__avatar-btn:hover{color:#fff;background:rgba(139,92,246,.12);border-color:rgba(139,92,246,.35)}
.fh-nav__avatar-btn img{width:28px;height:28px;border-radius:999px;object-fit:cover;flex-shrink:0}
.fh-nav__avatar-btn svg{width:14px;height:14px;color:#9ca3af}
.fh-nav__dropdown{position:absolute;top:calc(100% + .5rem);right:0;min-width:200px;
    background:#1a1d2e;border:1px solid rgba(255,255,255,.08);border-radius:.85rem;
    box-shadow:0 20px 40px -10px rgba(0,0,0,.6);padding:.4rem;z-index:100;
    animation:fh-nav-dd-in .18s cubic-bezier(.22,.68,0,1.01) both}
.fh-nav__dropdown--more{top:100%;right:0;left:auto;width:236px;padding:.5rem;border-color:rgba(167,139,250,.2);background:linear-gradient(145deg,rgba(31,25,49,.97),rgba(14,13,24,.98));backdrop-filter:blur(20px);box-shadow:0 20px 48px -20px rgba(0,0,0,.85),0 0 24px -14px rgba(139,92,246,.5)}
.fh-nav__dropdown--more .fh-nav__category-item{min-height:42px;gap:.7rem;padding:.4rem .5rem;border:1px solid transparent;border-radius:.72rem;color:#d1d5db;font-size:.84rem;font-weight:550;transition:color .18s,background .18s,border-color .18s,transform .18s}
.fh-nav__dropdown--more .fh-nav__category-item:hover,.fh-nav__dropdown--more .fh-nav__category-item:focus-visible{color:#fff;border-color:rgba(167,139,250,.2);background:linear-gradient(100deg,rgba(139,92,246,.2),rgba(139,92,246,.07));transform:translateX(2px);outline:none}
.fh-nav__dropdown--more .fh-nav__category-icon{width:28px;height:28px;flex-basis:28px}
.fh-nav__dropdown--more .fh-nav__category-icon svg{width:15px;height:15px}
.fh-nav__mobile-more-link{display:flex!important;align-items:center;gap:.7rem}
.fh-nav__mobile-more-link .fh-nav__category-icon{width:27px;height:27px;flex-basis:27px}
.fh-nav__mobile-more-link .fh-nav__category-icon svg{width:14px;height:14px}
.fh-nav__dropdown--categories{top:100%;width:252px;min-width:252px;padding:.55rem;
    overflow:hidden;border:1px solid rgba(167,139,250,.24);border-radius:1rem;
    background:linear-gradient(145deg,rgba(31,25,49,.96),rgba(14,13,24,.97));
    -webkit-backdrop-filter:blur(22px) saturate(170%);backdrop-filter:blur(22px) saturate(170%);
    box-shadow:0 22px 55px -24px rgba(0,0,0,.9),0 0 24px -12px rgba(139,92,246,.45),inset 0 1px 0 rgba(255,255,255,.06);
    animation:fh-categories-menu-in .2s cubic-bezier(.22,.68,0,1.01) both}
@keyframes fh-categories-menu-in{from{opacity:0;transform:translateY(-7px) scale(.985)}to{opacity:1;transform:translateY(0) scale(1)}}
.fh-nav__dropdown--categories .fh-nav__category-item{min-height:40px;gap:.7rem;padding:.4rem .5rem;border:1px solid transparent;
    border-radius:.72rem;color:#d1d5db;font-size:.84rem;font-weight:550;letter-spacing:.005em;
    transition:color .18s ease,background .18s ease,border-color .18s ease,transform .18s ease}
.fh-nav__dropdown--categories .fh-nav__category-item+.fh-nav__category-item{margin-top:.1rem}
.fh-nav__dropdown--categories .fh-nav__category-item:hover,.fh-nav__dropdown--categories .fh-nav__category-item:focus-visible{color:#fff;
    border-color:rgba(167,139,250,.19);background:linear-gradient(100deg,rgba(139,92,246,.2),rgba(139,92,246,.07));
    transform:translateX(2px);outline:none}
.fh-nav__category-icon{display:grid;width:29px;height:29px;flex:0 0 29px;place-items:center;
    border:1px solid rgba(167,139,250,.2);border-radius:.58rem;
    background:linear-gradient(145deg,rgba(139,92,246,.22),rgba(236,72,153,.09));color:#c4b5fd;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.06);transition:color .18s,border-color .18s,background .18s}
.fh-nav__category-icon svg{width:15px;height:15px}
.fh-nav__category-item:hover .fh-nav__category-icon,.fh-nav__category-item:focus-visible .fh-nav__category-icon{
    color:#fff;border-color:rgba(196,181,253,.42);background:linear-gradient(145deg,rgba(139,92,246,.42),rgba(236,72,153,.2))}
.fh-nav__category-arrow{width:13px;height:13px;margin-left:auto;color:#77718a;opacity:0;transform:translateX(-3px);
    transition:opacity .18s,transform .18s,color .18s}
.fh-nav__category-item:hover .fh-nav__category-arrow,.fh-nav__category-item:focus-visible .fh-nav__category-arrow{
    color:#c4b5fd;opacity:1;transform:translateX(0)}
@keyframes fh-nav-dd-in{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
.fh-nav__dd-item{display:flex;align-items:center;gap:.6rem;padding:.6rem .85rem;
    border-radius:.6rem;font-size:.84rem;color:#d1d5db;text-decoration:none;
    transition:background .15s,color .15s;cursor:pointer;width:100%;
    background:none;border:none;font-family:inherit;text-align:left}
.fh-nav__dd-item:hover{background:rgba(139,92,246,.12);color:#fff}
.fh-nav__dd-item svg{width:15px;height:15px;color:#8b5cf6;flex-shrink:0}
.fh-nav__dd-sep{height:1px;background:rgba(255,255,255,.06);margin:.3rem .5rem}
.fh-nav__dd-user{padding:.65rem .85rem .5rem;border-bottom:1px solid rgba(255,255,255,.06);margin-bottom:.3rem}
.fh-nav__dd-user-name{font-size:.85rem;font-weight:600;color:#fff}
.fh-nav__dd-user-email{font-size:.72rem;color:#6b7280;margin-top:.1rem;
    overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:160px}
.fh-nav__font-sizer{display:flex;align-items:center;gap:.15rem;
    border:1px solid rgba(255,255,255,.1);border-radius:.5rem;padding:.2rem .3rem}
.fh-nav__font-btn{background:none;border:none;cursor:pointer;color:#9ca3af;
    padding:.2rem .4rem;border-radius:.35rem;transition:all .2s;font-family:inherit;line-height:1}
.fh-nav__font-btn:hover,.fh-nav__font-btn.is-active{color:#fff;background:rgba(255,255,255,.1)}
.fh-nav__theme-btn{position:relative;width:38px;height:38px;display:inline-flex;
    align-items:center;justify-content:center;border-radius:999px;color:#9ca3af;
    background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
    cursor:pointer;transition:all .25s;flex-shrink:0}
.fh-nav__theme-btn:hover{color:#fff;background:rgba(139,92,246,.15);border-color:rgba(139,92,246,.4)}
.fh-nav__theme-btn svg{width:17px;height:17px;position:absolute;
    transition:opacity .2s,transform .3s cubic-bezier(.22,.68,0,1.01)}
.fh-nav__theme-btn .icon-sun{opacity:0;transform:rotate(-90deg) scale(.7)}
.fh-nav__theme-btn .icon-moon{opacity:0;transform:rotate(90deg) scale(.7)}
.fh-nav__theme-btn .icon-system{opacity:0;transform:scale(.7)}
[data-theme="dark"] .fh-nav__theme-btn .icon-moon{opacity:1;transform:rotate(0) scale(1)}
[data-theme="light"] .fh-nav__theme-btn .icon-sun{opacity:1;transform:rotate(0) scale(1)}
.fh-nav__theme-btn.is-system .icon-moon{opacity:0 !important}
.fh-nav__theme-btn.is-system .icon-system{opacity:1 !important;transform:scale(1) !important}
.fh-nav__theme-tooltip{position:absolute;top:calc(100% + .4rem);left:50%;
    transform:translateX(-50%);font-size:.7rem;font-weight:600;color:#fff;
    background:#1a1d2e;border:1px solid rgba(255,255,255,.1);border-radius:.4rem;
    padding:.2rem .5rem;white-space:nowrap;pointer-events:none;
    opacity:0;transition:opacity .15s;z-index:10}
.fh-nav__theme-btn:hover .fh-nav__theme-tooltip{opacity:1}
.fh-nav__hamburger{display:flex;align-items:center;justify-content:center;
    width:38px;height:38px;border-radius:8px;background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);color:#9ca3af;cursor:pointer;
    transition:all .25s}
.fh-nav__hamburger:hover{color:#fff;background:rgba(139,92,246,.12);border-color:rgba(139,92,246,.3)}
.fh-nav__hamburger svg{width:20px;height:20px}
.fh-nav__mobile{position:fixed;top:68px;left:0;right:0;z-index:49;
    background:rgba(10,10,18,.97);backdrop-filter:blur(20px);
    border-bottom:1px solid rgba(255,255,255,.07);
    max-height:calc(100vh - 68px);max-height:calc(100dvh - 68px);overflow-y:auto;overscroll-behavior:contain;
    padding:1rem 1.5rem 1.5rem;
    animation:fh-nav-mobile-in .2s cubic-bezier(.22,.68,0,1.01) both}
@keyframes fh-nav-mobile-in{from{opacity:0;transform:translateY(-8px)}to{opacity:1;transform:translateY(0)}}
.fh-nav__mobile-link{display:block;padding:.7rem .85rem;border-radius:.65rem;
    font-size:.9rem;font-weight:500;color:#9ca3af;text-decoration:none;transition:all .2s}
.fh-nav__mobile-link:hover,.fh-nav__mobile-link.is-active{color:#fff;background:rgba(139,92,246,.1)}
.fh-nav__mobile-sep{height:1px;background:rgba(255,255,255,.06);margin:.6rem 0}
.fh-nav__mobile-user{display:flex;align-items:center;gap:.75rem;padding:.5rem .85rem .85rem}
.fh-nav__mobile-user img{width:36px;height:36px;border-radius:999px;object-fit:cover}
.fh-nav__mobile-user-name{font-size:.88rem;font-weight:600;color:#fff}
.fh-nav__mobile-user-email{font-size:.75rem;color:#6b7280}
[x-cloak]{display:none!important}
/* Keep the full navigation usable from phones through compact laptops. */
.fh-nav__brand-area{display:flex;align-items:center;min-width:0;flex:1 1 auto}
@media(max-width:1199px){
    .fh-nav__links{display:none!important}
    .fh-nav__hamburger{display:inline-flex!important;flex:0 0 38px}
    nav#fhNav .fh-nav__avatar-btn{width:36px;height:36px;min-width:36px;justify-content:center;padding:.2rem}
    nav#fhNav .fh-nav__avatar-btn>span,nav#fhNav .fh-nav__avatar-btn>svg{display:none!important}
    nav#fhNav .fh-nav__icon-btn[aria-label="Bookmarks"]{display:none!important}
    .fh-nav__mobile{display:block}
}
@media(min-width:1200px){
    .fh-nav__links{display:inline-flex!important}
    .fh-nav__hamburger{display:none!important}
    .fh-nav__mobile{display:none!important}
}
@media(max-width:767px){
    nav#fhNav .fh-nav__inner{height:60px;padding-inline:clamp(.55rem,3vw,1rem);gap:.5rem;width:100%;box-sizing:border-box;justify-content:space-between}
    nav#fhNav .fh-nav__brand-area{min-width:0;flex:1 1 auto}
    nav#fhNav .fh-brand{min-width:0;flex:0 1 auto}
    .fh-brand__logo{width:clamp(96px,30vw,132px);height:54px}
    nav#fhNav .fh-nav__actions{min-width:max-content;flex:0 0 auto;gap:clamp(.22rem,1.2vw,.45rem)}
    .fh-nav__icon-btn,.fh-nav__theme-btn{width:34px;height:34px;flex:0 0 34px}
    .fh-nav__avatar-btn{min-width:34px;width:34px;height:34px;justify-content:center;padding:.2rem;border-radius:999px}
    .fh-nav__avatar-btn img{width:27px;height:27px}
    nav#fhNav .fh-nav__avatar-btn>span,nav#fhNav .fh-nav__avatar-btn>svg{display:none!important}
    nav#fhNav .fh-nav__icon-btn[aria-label="Bookmarks"]{display:none!important}
    .fh-nav__btn--primary{padding:.48rem .68rem;font-size:.75rem;white-space:nowrap}
    .fh-nav__btn--ghost{display:none!important}
    .fh-nav__mobile{top:60px;padding: .75rem max(1rem,env(safe-area-inset-left)) calc(1rem + env(safe-area-inset-bottom));max-height:calc(100vh - 60px);max-height:calc(100dvh - 60px)}
}
@media(max-width:390px){
    nav#fhNav .fh-nav__inner{padding-inline:.45rem;gap:.35rem}
    .fh-brand__logo{width:92px;height:50px}
    nav#fhNav .fh-nav__actions{gap:.2rem}
    .fh-nav__icon-btn,.fh-nav__theme-btn{width:31px;height:31px;flex-basis:31px}
    .fh-nav__avatar-btn{width:31px;height:31px;min-width:31px}
    .fh-nav__avatar-btn img{width:25px;height:25px}
    .fh-nav__hamburger{width:32px;height:32px;flex-basis:32px}
}
@media(max-width:350px){
    .fh-nav__inner{padding-inline:.35rem;gap:.15rem}
    .fh-brand__logo{width:82px;height:46px}
    .fh-nav__actions{gap:.12rem}
    .fh-nav__theme-btn{display:none!important}
    .fh-nav__icon-btn,.fh-nav__avatar-btn{width:29px;height:29px;flex-basis:29px;min-width:29px}
    .fh-nav__hamburger{width:30px;height:30px;flex-basis:30px}
}
</style>

<nav class="fh-nav" id="fhNav" x-data="{ mobileOpen: false, ddOpen: false }">
    <div class="fh-nav__inner">

        {{-- Brand + Links --}}
    <div class="fh-nav__brand-area">
            <a href="{{ route('home') }}" class="fh-brand">
                <x-fh-logo-mark class="fh-brand__logo" />
            </a>
            <div class="fh-nav__links" aria-label="Primary navigation">
                <a href="{{ route('home') }}"
                   class="fh-nav__link {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
                <a href="{{ route('explore') }}"
                   class="fh-nav__link {{ request()->routeIs('explore') ? 'is-active' : '' }}">Explore</a>
                <a href="{{ route('events.index') }}"
                   class="fh-nav__link {{ request()->routeIs('events.*') ? 'is-active' : '' }}">Events</a>
                <a href="{{ route('merchandise.index') }}"
                   class="fh-nav__link {{ request()->routeIs('merchandise.*') ? 'is-active' : '' }}">Shop</a>
                <div class="relative" x-data="{ categoryOpen: false, categoryCloseTimer: null, openCategoryMenu() { clearTimeout(this.categoryCloseTimer); this.categoryOpen = true; }, scheduleCategoryClose() { clearTimeout(this.categoryCloseTimer); this.categoryCloseTimer = setTimeout(() => this.categoryOpen = false, 180); } }" @mouseenter="openCategoryMenu()" @mouseleave="scheduleCategoryClose()" @keydown.escape.window="categoryOpen = false">
                    <button type="button" @click="categoryOpen = !categoryOpen" @keydown.escape="categoryOpen = false"
                            aria-haspopup="true"
                            class="fh-nav__link inline-flex items-center gap-1 border-0 bg-transparent font-sans cursor-pointer {{ request()->routeIs('categories.*') ? 'is-active' : '' }}" :aria-expanded="categoryOpen">
                        Categories
                        <svg class="w-3 h-3 transition-transform" :class="categoryOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="categoryOpen" @mouseenter="openCategoryMenu()" @click.outside="categoryOpen = false" x-cloak class="fh-nav__dropdown fh-nav__dropdown--categories" style="left:0;right:auto">
                        @foreach (['Anime', 'Comics', 'Cosplay', 'Gaming', 'Manga', 'Movies', 'TV Series'] as $categoryName)
                            <a href="{{ route('categories.show', \Illuminate\Support\Str::slug($categoryName)) }}" class="fh-nav__dd-item fh-nav__category-item">
                                <span class="fh-nav__category-icon" aria-hidden="true">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
                                        @switch($categoryName)
                                            @case('Anime')<circle cx="12" cy="12" r="8.5"/><path d="m10 8.5 5 3.5-5 3.5z"/>@break
                                            @case('Comics')<path d="M5 4.5h14v15H5zM9 4.5v15M12 9h4M12 12h4M12 15h3"/>@break
                                            @case('Cosplay')<path d="M4.5 8.5c2.2-2.7 4.7-4 7.5-4s5.3 1.3 7.5 4l-1.2 8.2c-.2 1.2-1.1 2-2.2 2h-8c-1.1 0-2-.8-2.2-2zM8 12h.01M16 12h.01M9.5 15c1.5 1 3.5 1 5 0"/>@break
                                            @case('Gaming')<path d="M7 9h10a3 3 0 0 1 2.8 2l1 3.2a2 2 0 0 1-3.3 2l-2-1.7h-5l-2 1.7a2 2 0 0 1-3.3-2l1-3.2A3 3 0 0 1 7 9zM8 11v3M6.5 12.5h3M16.5 12h.01M18 14h.01"/>@break
                                            @case('Manga')<path d="M4.5 5.5h6a2 2 0 0 1 2 2v11h-6a2 2 0 0 0-2 1zM19.5 5.5h-5a2 2 0 0 0-2 2v11h5a2 2 0 0 1 2 1z"/>@break
                                            @case('Movies')<rect x="3.5" y="5.5" width="17" height="13" rx="2"/><path d="M7.5 5.5v3M12 5.5v3M16.5 5.5v3M7.5 15.5v3M12 15.5v3M16.5 15.5v3"/>@break
                                            @default<rect x="3.5" y="5" width="17" height="13" rx="2"/><path d="M8 21h8M12 18v3M9 9l2 2-2 2M13 13h2"/>
                                        @endswitch
                                    </svg>
                                </span>
                                <span>{{ $categoryName }}</span>
                                <svg class="fh-nav__category-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="relative" x-data="{ moreOpen: false, moreCloseTimer: null, openMoreMenu() { clearTimeout(this.moreCloseTimer); this.moreOpen = true; }, scheduleMoreClose() { clearTimeout(this.moreCloseTimer); this.moreCloseTimer = setTimeout(() => this.moreOpen = false, 180); } }" @mouseenter="openMoreMenu()" @mouseleave="scheduleMoreClose()" @focusin="openMoreMenu()" @focusout="if (!$el.contains($event.relatedTarget)) scheduleMoreClose()" @click.outside="moreOpen = false" @keydown.escape.window="clearTimeout(moreCloseTimer); moreOpen = false">
                    <button type="button" @click="openMoreMenu()" @keydown.escape="clearTimeout(moreCloseTimer); moreOpen = false"
                            class="fh-nav__link inline-flex items-center gap-1 border-0 bg-transparent font-sans cursor-pointer {{ request()->routeIs('about', 'faqs.*', 'feedback.*', 'privacy-policy', 'terms') ? 'is-active' : '' }}"
                            aria-haspopup="true" aria-controls="fhMoreMenu" :aria-expanded="moreOpen">
                        More
                        <svg class="w-3 h-3 transition-transform" :class="moreOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div id="fhMoreMenu" x-show="moreOpen" @mouseenter="openMoreMenu()" x-cloak class="fh-nav__dropdown fh-nav__dropdown--more" aria-label="More links">
                        <a href="{{ route('about') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg></span><span>About</span></a>
                        <a href="{{ route('feedback.create') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg></span><span>Contact</span></a>
                        <a href="{{ route('feedback.create') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.4 8.4 0 0 1-3.3-.7L4 20l1.5-3.8A7.2 7.2 0 0 1 4 11.5 7.5 7.5 0 0 1 12 4a7.5 7.5 0 0 1 8 7.5Z"/><path d="M8.5 12h.01M12 12h.01M15.5 12h.01"/></svg></span><span>Feedback</span></a>
                        <a href="{{ route('faqs.index') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9.7 9a2.35 2.35 0 1 1 3.9 1.75c-1 .85-1.6 1.15-1.6 2.75m0 3h.01"/></svg></span><span>FAQ</span></a>
                        <div class="fh-nav__dd-sep"></div>
                        <a href="{{ route('privacy-policy') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3 20 6v5c0 5-3.4 8.3-8 10-4.6-1.7-8-5-8-10V6l8-3Z"/><path d="m9 12 2 2 4-4"/></svg></span><span>Privacy Policy</span></a>
                        <a href="{{ route('terms') }}" class="fh-nav__dd-item fh-nav__category-item"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v5h5M9 12h6M9 16h6"/></svg></span><span>Terms</span></a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right actions --}}
        <div class="fh-nav__actions">

            {{-- Theme toggle (desktop) --}}
            <button id="fhThemeBtn" class="fh-nav__theme-btn hidden sm:inline-flex"
                    aria-label="Toggle theme" title="">
                {{-- Sun: light mode --}}
                <svg class="icon-sun" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                </svg>
                {{-- Moon: dark mode --}}
                <svg class="icon-moon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                </svg>
                {{-- Monitor: system mode --}}
                <svg class="icon-system" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="fh-nav__theme-tooltip" id="fhThemeTip">Dark</span>
            </button>

            <x-notification-menu />

            @auth
                {{-- Bookmarks --}}
                <a href="{{ route('bookmarks.index') }}" class="fh-nav__icon-btn hidden sm:inline-flex"
                   aria-label="Bookmarks">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </a>

                {{-- User dropdown --}}
                <div class="relative" x-data="{ ddOpen: false }">
                    <button @click="ddOpen = !ddOpen" @keydown.escape="ddOpen = false"
                            class="fh-nav__avatar-btn" :aria-expanded="ddOpen">
                        <img src="{{ Auth::user()->avatarUrl() }}" data-auth-avatar data-default-avatar="{{ Auth::user()->defaultAvatarUrl() }}" alt="{{ Auth::user()->name }}" onerror="this.onerror=null;this.src=this.dataset.defaultAvatar">
                        <span class="hidden sm:inline text-sm">{{ Auth::user()->name }}</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             :style="ddOpen ? 'transform:rotate(180deg)' : ''"
                             style="transition:transform .2s">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="ddOpen" @click.outside="ddOpen = false" x-cloak
                         class="fh-nav__dropdown">
                        <div class="fh-nav__dd-user">
                            <div class="fh-nav__dd-user-name">{{ Auth::user()->name }}</div>
                            <div class="fh-nav__dd-user-email">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('dashboard') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('articles.index') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                            </svg>
                            Articles
                        </a>
                        <a href="{{ route('profile.edit') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('bookmarks.index') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Bookmarks
                        </a>
                        <a href="{{ route('feedback.create') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            Feedback
                        </a>
                        <a href="{{ route('feedback.mine') }}" class="fh-nav__dd-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h10"/></svg>
                            My messages
                        </a>
                        @if(Auth::user()->is_admin)
                            <div class="fh-nav__dd-sep"></div>
                            <a href="{{ route('admin.dashboard.index') }}" class="fh-nav__dd-item"
                               style="color:#a78bfa">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Admin Panel
                            </a>
                        @endif
                        <div class="fh-nav__dd-sep"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="fh-nav__dd-item" style="color:#f87171">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

            @else
                {{-- Guest buttons --}}
                <a href="{{ route('login') }}" class="fh-nav__btn fh-nav__btn--ghost hidden sm:inline-flex">Sign In</a>
                <a href="{{ route('register') }}" class="fh-nav__btn fh-nav__btn--primary">Join Free</a>
            @endauth

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="fh-nav__hamburger"
                    :aria-expanded="mobileOpen" aria-label="Toggle menu">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" @click.outside="mobileOpen = false" x-cloak
         class="fh-nav__mobile">

        @auth
            <div class="fh-nav__mobile-user">
                <img src="{{ Auth::user()->avatarUrl() }}" data-auth-avatar data-default-avatar="{{ Auth::user()->defaultAvatarUrl() }}" alt="{{ Auth::user()->name }}" onerror="this.onerror=null;this.src=this.dataset.defaultAvatar">
                <div>
                    <div class="fh-nav__mobile-user-name">{{ Auth::user()->name }}</div>
                    <div class="fh-nav__mobile-user-email">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="fh-nav__mobile-sep"></div>
        @endauth

        <a href="{{ route('home') }}"
           class="fh-nav__mobile-link {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
        <a href="{{ route('explore') }}"
           class="fh-nav__mobile-link {{ request()->routeIs('explore') ? 'is-active' : '' }}">Explore</a>
        <a href="{{ route('events.index') }}"
           class="fh-nav__mobile-link {{ request()->routeIs('events.*') ? 'is-active' : '' }}">Events</a>
        <a href="{{ route('merchandise.index') }}"
           class="fh-nav__mobile-link {{ request()->routeIs('merchandise.*') ? 'is-active' : '' }}">Shop</a>
        <div x-data="{ mobileCategoriesOpen: false }" @click.outside="mobileCategoriesOpen = false" @keydown.escape.window="mobileCategoriesOpen = false">
            <button type="button" @click="mobileCategoriesOpen = !mobileCategoriesOpen"
                    aria-haspopup="true" class="fh-nav__mobile-link w-full text-left flex items-center justify-between" :aria-expanded="mobileCategoriesOpen">
                Categories
                <svg class="w-3 h-3 transition-transform" :class="mobileCategoriesOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-show="mobileCategoriesOpen" x-cloak class="pl-4">
                @foreach (['Anime', 'Comics', 'Cosplay', 'Gaming', 'Manga', 'Movies', 'TV Series'] as $categoryName)
                    <a href="{{ route('categories.show', \Illuminate\Support\Str::slug($categoryName)) }}"
                       class="fh-nav__mobile-link">{{ $categoryName }}</a>
                @endforeach
            </div>
        </div>
        <div class="fh-nav__mobile-sep"></div>
        <div x-data="{ mobileMoreOpen: false }" @keydown.escape.window="mobileMoreOpen = false">
            <button type="button" @click="mobileMoreOpen = !mobileMoreOpen" aria-haspopup="true"
                    class="fh-nav__mobile-link w-full text-left flex items-center justify-between" :aria-expanded="mobileMoreOpen">
                More
                <svg class="w-3 h-3 transition-transform" :class="mobileMoreOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
            </button>
            <div x-show="mobileMoreOpen" x-cloak class="pl-4">
                <a href="{{ route('about') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link {{ request()->routeIs('about') ? 'is-active' : '' }}"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg></span>About</a>
                <a href="{{ route('feedback.create') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/></svg></span>Contact</a>
                <a href="{{ route('feedback.create') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 11.5a7.5 7.5 0 0 1-8 7.5 8.4 8.4 0 0 1-3.3-.7L4 20l1.5-3.8A7.2 7.2 0 0 1 4 11.5 7.5 7.5 0 0 1 12 4a7.5 7.5 0 0 1 8 7.5Z"/><path d="M8.5 12h.01M12 12h.01M15.5 12h.01"/></svg></span>Feedback</a>
                <a href="{{ route('faqs.index') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M9.7 9a2.35 2.35 0 1 1 3.9 1.75c-1 .85-1.6 1.15-1.6 2.75m0 3h.01"/></svg></span>FAQ</a>
                <a href="{{ route('privacy-policy') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 3 20 6v5c0 5-3.4 8.3-8 10-4.6-1.7-8-5-8-10V6l8-3Z"/><path d="m9 12 2 2 4-4"/></svg></span>Privacy Policy</a>
                <a href="{{ route('terms') }}" class="fh-nav__mobile-link fh-nav__mobile-more-link"><span class="fh-nav__category-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6z"/><path d="M14 3v5h5M9 12h6M9 16h6"/></svg></span>Terms</a>
            </div>
        </div>

        @auth
            <a href="{{ route('dashboard') }}"
               class="fh-nav__mobile-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">Dashboard</a>
            <a href="{{ route('articles.index') }}"
               class="fh-nav__mobile-link {{ request()->routeIs('articles.*') ? 'is-active' : '' }}">Articles</a>
            <a href="{{ route('bookmarks.index') }}"
               class="fh-nav__mobile-link {{ request()->routeIs('bookmarks.*') ? 'is-active' : '' }}">Bookmarks</a>
            <a href="{{ route('feedback.mine') }}"
               class="fh-nav__mobile-link {{ request()->routeIs('feedback.mine') ? 'is-active' : '' }}">My messages</a>
            <a href="{{ route('profile.edit') }}"
               class="fh-nav__mobile-link {{ request()->routeIs('profile.*') ? 'is-active' : '' }}">Profile</a>
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard.index') }}"
                   class="fh-nav__mobile-link" style="color:#a78bfa">Admin Panel</a>
            @endif
            <div class="fh-nav__mobile-sep"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="fh-nav__mobile-link" style="color:#f87171;width:100%;text-align:left">
                    Log Out
                </button>
            </form>
        @else
            <div class="fh-nav__mobile-sep"></div>
            <div class="flex gap-2 px-2 pt-1">
                <a href="{{ route('login') }}" class="fh-nav__btn fh-nav__btn--ghost" style="flex:1;justify-content:center">Sign In</a>
                <a href="{{ route('register') }}" class="fh-nav__btn fh-nav__btn--primary" style="flex:1;justify-content:center">Join Free</a>
            </div>
        @endauth
    </div>
</nav>

<script>
function fhFontSizer() {
    return {
        current: localStorage.getItem('fh_fontSize') || 'md',
        init() { this.apply(this.current); },
        set(size) {
            this.current = size;
            localStorage.setItem('fh_fontSize', size);
            this.apply(size);
        },
        apply(size) {
            const map = { sm: '14px', md: '16px', lg: '18px' };
            document.documentElement.style.fontSize = map[size] || '16px';
        }
    };
}

// ── Theme toggle (3-state: dark → light → system) ────────────────────────────
(function () {
    const btn  = document.getElementById('fhThemeBtn');
    const tip  = document.getElementById('fhThemeTip');
    const html = document.documentElement;
    const KEY  = 'fh-theme';
    const LABELS = { dark: 'Dark', light: 'Light', system: 'System' };
    const ORDER  = ['dark', 'light', 'system'];

    function resolve(pref) {
        if (pref === 'system') {
            return window.matchMedia('(prefers-color-scheme: light)').matches ? 'light' : 'dark';
        }
        return pref;
    }

    function apply(pref) {
        const resolved = resolve(pref);
        html.setAttribute('data-theme', resolved);
        if (btn) {
            btn.classList.toggle('is-system', pref === 'system');
            btn.setAttribute('aria-label', 'Theme: ' + LABELS[pref]);
        }
        if (tip) tip.textContent = LABELS[pref];
    }

    function current() {
        return localStorage.getItem(KEY) || 'system';
    }

    // Init
    apply(current());

    // Click cycles: dark → light → system → dark
    btn && btn.addEventListener('click', function () {
        const idx  = ORDER.indexOf(current());
        const next = ORDER[(idx + 1) % ORDER.length];
        localStorage.setItem(KEY, next);
        apply(next);
    });

    // React to OS preference change when in system mode
    window.matchMedia('(prefers-color-scheme: light)').addEventListener('change', function () {
        if (current() === 'system') apply('system');
    });
})();

// ── Navbar scroll effect ──────────────────────────────────────────────────────
(function(){
    const nav = document.getElementById('fhNav');
    if (!nav) return;
    const onScroll = () => nav.classList.toggle('scrolled', window.scrollY > 12);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
})();
</script>
