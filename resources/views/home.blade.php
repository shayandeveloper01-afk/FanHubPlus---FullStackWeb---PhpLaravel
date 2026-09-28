<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} — Discover Fan Content</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>/* fh-theme anti-flash */(function(){var t=localStorage.getItem('fh-theme')||'dark';document.documentElement.setAttribute('data-theme',t==='system'?(window.matchMedia('(prefers-color-scheme:light)').matches?'light':'dark'):t);})();</script>
    <style>
        /* ═══════════════════════════════════════════════════════════════════
           NAVBAR
        ═══════════════════════════════════════════════════════════════════ */
        .fh-nav{position:fixed;top:0;left:0;right:0;z-index:50;
            background:rgba(10,10,18,.82);backdrop-filter:blur(20px) saturate(180%);
            -webkit-backdrop-filter:blur(20px) saturate(180%);
            transition:background .3s,box-shadow .3s}
        .fh-nav::after{content:'';position:absolute;left:0;right:0;bottom:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(139,92,246,.5) 25%,rgba(236,72,153,.7) 50%,rgba(139,92,246,.5) 75%,transparent);opacity:.6}
        .fh-nav.scrolled{background:rgba(10,10,18,.97);box-shadow:0 12px 40px -22px rgba(139,92,246,.6)}
        .fh-nav__inner{max-width:1320px;margin:0 auto;padding:0 1.5rem;height:68px;
            display:flex;align-items:center;justify-content:space-between;gap:1rem}
        .fh-brand{display:inline-flex;align-items:center;gap:.6rem;font-size:1.15rem;
            font-weight:700;letter-spacing:-.01em;color:#fff;transition:transform .3s}
        .fh-brand:hover{transform:translateY(-1px)}
        .fh-brand__mark{width:36px;height:36px;border-radius:10px;display:inline-flex;
            align-items:center;justify-content:center;
            background:linear-gradient(135deg,#8b5cf6,#a855f7 50%,#ec4899);
            box-shadow:0 8px 20px -8px rgba(139,92,246,.9),inset 0 1px 0 rgba(255,255,255,.2);
            font-weight:800;font-size:.95rem;color:#fff}
        .fh-brand__text{color:#e5e7eb}
        .fh-brand__text span{background:linear-gradient(135deg,#a855f7,#ec4899);
            -webkit-background-clip:text;background-clip:text;color:transparent;font-weight:800}
        .fh-links{display:none;align-items:center;gap:.35rem;margin-left:1.25rem}
        @media(min-width:768px){.fh-links{display:inline-flex}}
        .fh-link{position:relative;padding:.5rem 1rem;font-size:.875rem;font-weight:500;
            color:#9ca3af;border-radius:8px;transition:color .2s}
        .fh-link:hover{color:#fff}
        .fh-link::after{content:'';position:absolute;left:1rem;right:1rem;bottom:.15rem;
            height:2px;border-radius:2px;background:#fff;transform:scaleX(0);transform-origin:left;
            transition:transform .3s cubic-bezier(.22,.68,0,1.01)}
        .fh-link:hover::after,.fh-link.is-active::after{transform:scaleX(1)}
        .fh-link.is-active{color:#fff;font-weight:600}
        .fh-actions{display:flex;align-items:center;gap:.5rem}
        .fh-search{display:none;align-items:center;gap:.5rem;font-size:.82rem;color:#9ca3af;
            padding:.55rem 1rem;border-radius:999px;border:1px solid rgba(255,255,255,.1);
            background:rgba(255,255,255,.03);transition:all .25s}
        .fh-search:hover{color:#fff;border-color:rgba(139,92,246,.5);background:rgba(139,92,246,.08)}
        @media(min-width:640px){.fh-search{display:inline-flex}}
        .fh-icon-btn{position:relative;width:38px;height:38px;display:inline-flex;
            align-items:center;justify-content:center;border-radius:999px;color:#9ca3af;
            background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);transition:all .25s}
        .fh-icon-btn:hover{color:#fff;background:rgba(139,92,246,.15);border-color:rgba(139,92,246,.4)}
        .fh-icon-btn svg{width:17px;height:17px}
        .fh-icon-btn__dot{position:absolute;top:8px;right:9px;width:7px;height:7px;
            border-radius:999px;background:#ec4899;box-shadow:0 0 0 2px rgba(10,10,18,.95)}
        .fh-btn{display:inline-flex;align-items:center;gap:.4rem;font-size:.84rem;
            font-weight:600;padding:.55rem 1.1rem;border-radius:999px;transition:all .25s}
        .fh-btn--ghost{color:#d1d5db}
        .fh-btn--ghost:hover{color:#fff;background:rgba(255,255,255,.06)}
        .fh-btn--primary{color:#fff;background:linear-gradient(135deg,#8b5cf6,#a855f7);
            box-shadow:0 10px 24px -10px rgba(139,92,246,.9)}
        .fh-btn--primary:hover{transform:translateY(-1px);box-shadow:0 14px 30px -10px rgba(139,92,246,1)}

        /* ═══════════════════════════════════════════════════════════════════
           GRID
        ═══════════════════════════════════════════════════════════════════ */
        .fh-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem}
        @media(min-width:1200px){.fh-grid{grid-template-columns:repeat(4,minmax(0,1fr))}}
        .fh-grid--3{grid-template-columns:repeat(auto-fit,minmax(260px,1fr))}
        @media(min-width:1200px){.fh-grid--3{grid-template-columns:repeat(3,minmax(0,1fr))}}
        .fh-grid--5{grid-template-columns:repeat(auto-fit,minmax(200px,1fr))}
        @media(min-width:1200px){.fh-grid--5{grid-template-columns:repeat(5,minmax(0,1fr))}}
        @media(max-width:480px){.fh-grid,.fh-grid--3,.fh-grid--5{grid-template-columns:1fr;gap:1rem}}

        /* ═══════════════════════════════════════════════════════════════════
           CONTENT CARD
        ═══════════════════════════════════════════════════════════════════ */
        .fh-card{position:relative;display:block;border-radius:1rem;overflow:hidden;
            background:#12141f;border:1px solid rgba(255,255,255,.07);cursor:pointer;
            transition:transform .45s cubic-bezier(.22,.68,0,1.01),box-shadow .45s,border-color .45s;
            will-change:transform}
        .fh-card__media{position:relative;aspect-ratio:16/9;overflow:hidden;
            background:linear-gradient(135deg,#1a1d2e,#241c3d)}
        .fh-card__media img{width:100%;height:100%;object-fit:cover;display:block;
            filter:brightness(.85) saturate(1.05);
            transition:transform .8s cubic-bezier(.22,.68,0,1.01),filter .5s}
        .fh-card__media::after{content:'';position:absolute;inset:0;
            background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,.85));
            opacity:.75;transition:opacity .4s}
        .fh-card__badge{position:absolute;top:.7rem;left:.7rem;z-index:2;
            font-size:.65rem;font-weight:700;letter-spacing:.03em;padding:.3rem .65rem;
            border-radius:999px;color:#fff;background:rgba(0,0,0,.65);
            border:1px solid rgba(255,255,255,.15);backdrop-filter:blur(8px)}
        .fh-card__rank{position:absolute;bottom:-10px;left:6px;font-size:4rem;font-weight:900;
            line-height:1;color:#fff;-webkit-text-stroke:2px rgba(139,92,246,.95);
            text-shadow:0 4px 20px rgba(0,0,0,.85);z-index:2;opacity:.95}
        .fh-card__body{padding:.85rem 1rem 1rem;position:relative;z-index:2}
        .fh-card__title{font-size:.9rem;font-weight:600;line-height:1.35;color:#f3f4f6;
            transition:color .3s;display:-webkit-box;-webkit-line-clamp:2;
            -webkit-box-orient:vertical;overflow:hidden}
        .fh-card__meta{display:flex;align-items:center;gap:.5rem;margin-top:.5rem;
            font-size:.72rem;color:#9ca3af}
        .fh-card__dot{width:3px;height:3px;background:#4b5563;border-radius:999px}
        .fh-card__date{display:flex;align-items:center;gap:.35rem;
            margin-top:.35rem;font-size:.7rem;color:#6b7280}
        .fh-card__date svg{width:11px;height:11px;color:#8b5cf6;flex-shrink:0}
        .fh-card:hover{transform:translateY(-6px) scale(1.02);
            border-color:rgba(139,92,246,.5);
            box-shadow:0 24px 48px -20px rgba(139,92,246,.55),0 0 0 1px rgba(139,92,246,.1);z-index:5}
        .fh-card:hover .fh-card__media img{transform:scale(1.1);filter:brightness(1) saturate(1.1)}
        .fh-card:hover .fh-card__media::after{opacity:.5}
        .fh-card:hover .fh-card__title{color:#c7d2fe}
        .fh-card__add{position:absolute;top:.7rem;right:.7rem;z-index:3;width:30px;height:30px;
            display:inline-flex;align-items:center;justify-content:center;border-radius:999px;
            color:#fff;background:rgba(0,0,0,.65);border:1px solid rgba(255,255,255,.2);
            backdrop-filter:blur(8px);transition:all .25s;opacity:0;cursor:pointer}
        .fh-card:hover .fh-card__add{opacity:1}
        .fh-card__add:hover{background:#8b5cf6;border-color:#8b5cf6;transform:scale(1.1)}
        .fh-card__add svg{width:14px;height:14px}
        .fh-card__progress{position:absolute;left:0;right:0;bottom:0;height:3px;
            background:rgba(255,255,255,.12);z-index:3}
        .fh-card__progress span{display:block;height:100%;
            background:linear-gradient(90deg,#8b5cf6,#ec4899)}

        /* ═══════════════════════════════════════════════════════════════════
           HEADING
        ═══════════════════════════════════════════════════════════════════ */
        .fh-heading{display:flex;align-items:center;gap:.5rem;font-size:1rem;
            font-weight:700;color:#fff;margin-bottom:.9rem;padding-left:.1rem}
        .fh-heading::before{content:'';width:3px;height:18px;border-radius:2px;
            background:linear-gradient(180deg,#8b5cf6,#ec4899)}
        .fh-heading__badge{margin-left:auto;font-size:.72rem;color:#a5b4fc;font-weight:600;
            padding:.25rem .65rem;border-radius:999px;background:rgba(139,92,246,.1);
            border:1px solid rgba(139,92,246,.25);transition:all .2s;text-decoration:none}
        .fh-heading__badge:hover{background:rgba(139,92,246,.2);color:#fff}

        /* ═══════════════════════════════════════════════════════════════════
           CURVED ARC SLIDER — 5 CARDS VISIBLE (T.RICKS style)
        ═══════════════════════════════════════════════════════════════════ */
        .arc-slider{
            padding:7.5rem 0 2.5rem;   /* ✅ Top se neeche kiya */
            position:relative;overflow:hidden;
            margin-top:2rem;            /* ✅ Extra gap navbar se */
        }
        .arc-slider__viewport{position:relative;
            height:clamp(460px,62vw,640px);   /* ✅ Zyada height */
            display:flex;align-items:center;justify-content:center;
            perspective:2200px}                /* ✅ Better 3D depth */
        .arc-slider__stage{position:relative;width:100%;height:100%;
            display:flex;align-items:center;justify-content:center;
            transform-style:preserve-3d}
        .arc-slider__card{position:absolute;top:50%;left:50%;
            width:clamp(190px,25vw,340px);     /* ✅ Chhota card, zyada fit */
            aspect-ratio:16/10;
            border-radius:1.1rem;overflow:hidden;
            transition:transform 1.1s cubic-bezier(.22,.68,0,1.01),
                filter .9s ease,opacity .9s ease,box-shadow .9s ease;
            transform-origin:50% 100%;will-change:transform;
            cursor:pointer;box-shadow:0 25px 55px -20px rgba(0,0,0,.75)}
        .arc-slider__card img{width:100%;height:100%;object-fit:cover;display:block}

        /* ✅ 5 positions — sab clearly visible, arc shape perfect */

        /* FAR LEFT — visible, small */
        .arc-slider__card.pos--2{opacity:1;z-index:1;pointer-events:auto;
            transform:translate(-50%,-50%) translateX(-165%) translateY(38px)
                rotate(-12deg) scale(.62);
            filter:blur(1px) brightness(.65)}

        /* MID LEFT — clear */
        .arc-slider__card.pos--1{opacity:1;z-index:3;pointer-events:auto;
            transform:translate(-50%,-50%) translateX(-88%) translateY(18px)
                rotate(-7deg) scale(.82);
            filter:blur(.3px) brightness(.82)}

        /* CENTER — biggest, brightest */
        .arc-slider__card.pos-0{opacity:1;z-index:5;
            transform:translate(-50%,-50%) scale(1) rotate(0deg);
            filter:blur(0) brightness(1.05);
            box-shadow:0 45px 90px -25px rgba(139,92,246,.6)}

        /* MID RIGHT — clear */
        .arc-slider__card.pos-1{opacity:1;z-index:3;pointer-events:auto;
            transform:translate(-50%,-50%) translateX(88%) translateY(18px)
                rotate(7deg) scale(.82);
            filter:blur(.3px) brightness(.82)}

        /* FAR RIGHT — visible, small */
        .arc-slider__card.pos-2{opacity:1;z-index:1;pointer-events:auto;
            transform:translate(-50%,-50%) translateX(165%) translateY(38px)
                rotate(12deg) scale(.62);
            filter:blur(1px) brightness(.65)}

        /* Hide cards beyond ±2 */
        .arc-slider__card.is-hidden{
            opacity:0 !important;
            pointer-events:none !important;
            z-index:0 !important;
            filter:blur(8px) brightness(.3) !important;
        }

        /* Hover side cards → brighten */
        .arc-slider__card.pos--2:hover,
        .arc-slider__card.pos--1:hover,
        .arc-slider__card.pos-1:hover,
        .arc-slider__card.pos-2:hover{
            filter:blur(0) brightness(1) !important;
            z-index:4}

        /* Meta overlay */
        .arc-slider__meta{position:absolute;inset:auto 0 0 0;padding:1.1rem 1.1rem 1.25rem;
            background:linear-gradient(0deg,rgba(0,0,0,.92),rgba(0,0,0,.4) 60%,transparent);
            opacity:0;transition:opacity .5s ease}
        .arc-slider__card.pos-0 .arc-slider__meta{opacity:1}
        .arc-slider__card.pos--2 .arc-slider__meta,
        .arc-slider__card.pos--1 .arc-slider__meta,
        .arc-slider__card.pos-1 .arc-slider__meta,
        .arc-slider__card.pos-2 .arc-slider__meta{opacity:.55}
        .arc-slider__meta h3{font-size:1.05rem;font-weight:700;color:#fff;line-height:1.25;
            text-shadow:0 2px 12px rgba(0,0,0,.9);
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .arc-slider__meta p{font-size:.72rem;color:#a5b4fc;margin-top:.2rem;font-weight:500}

        /* Nav buttons */
        .arc-slider__nav{display:flex;justify-content:center;gap:.5rem;margin-top:2rem}
        .arc-slider__nav button{width:46px;height:46px;border-radius:999px;
            display:inline-flex;align-items:center;justify-content:center;
            background:rgba(139,92,246,.14);border:1px solid rgba(139,92,246,.38);
            color:#c7d2fe;cursor:pointer;transition:all .25s}
        .arc-slider__nav button:hover{background:rgba(139,92,246,.32);
            border-color:rgba(139,92,246,.75);color:#fff;transform:scale(1.1)}
        .arc-slider__nav svg{width:19px;height:19px}

        /* Dots */
        .arc-slider__dots{display:flex;justify-content:center;gap:.4rem;margin-top:1.1rem}
        .arc-slider__dots button{width:6px;height:6px;border-radius:999px;
            background:#4b5563;border:none;cursor:pointer;
            transition:background .3s,width .3s}
        .arc-slider__dots button.is-active{background:#8b5cf6;width:22px}

        /* Mobile: 3 cards only */
        @media(max-width:640px){
            .arc-slider{padding:6rem 0 1.5rem}
            .arc-slider__card.pos--2,
            .arc-slider__card.pos-2{
                opacity:0 !important;pointer-events:none !important;
                transform:translate(-50%,-50%) translateX(-200%) scale(.5)}
            .arc-slider__card.pos--1{transform:translate(-50%,-50%) translateX(-72%) translateY(14px) rotate(-8deg) scale(.78)}
            .arc-slider__card.pos-1{transform:translate(-50%,-50%) translateX(72%) translateY(14px) rotate(8deg) scale(.78)}
        }

        /* ═══════════════════════════════════════════════════════════════════
           MARQUEE
        ═══════════════════════════════════════════════════════════════════ */
        .marquee-hero{position:relative;padding:1.5rem 0 3rem;overflow:hidden;
            background:radial-gradient(120% 100% at 50% 0%,#1a1233 0%,#0b0b14 60%)}
        .marquee-hero__mask{-webkit-mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent);
            mask-image:linear-gradient(90deg,transparent,#000 8%,#000 92%,transparent)}
       .marquee-hero__track{
    display:flex;
    width:max-content;       /* ✅ Ye zaroori hai — track shrink na ho */
    gap:1.5rem;
    will-change:transform;
    padding:1rem 0;
    min-width:100%;          /* ✅ Fallback */
}
        .marquee-hero__arrow{position:absolute;top:55%;transform:translateY(-50%);z-index:10;
            width:44px;height:44px;display:flex;align-items:center;justify-content:center;
            border-radius:999px;background:rgba(17,17,27,.7);border:1px solid rgba(255,255,255,.14);
            color:#fff;backdrop-filter:blur(8px);cursor:pointer;transition:all .25s}
        .marquee-hero__arrow:hover{background:rgba(139,92,246,.6);
            border-color:rgba(165,180,252,.6);transform:translateY(-50%) scale(1.08)}
        .marquee-hero__arrow--prev{left:.75rem}
        .marquee-hero__arrow--next{right:.75rem}
        .marquee-hero__arrow svg{width:20px;height:20px}
        @media(min-width:640px){.marquee-hero__arrow{width:48px;height:48px}
            .marquee-hero__arrow--prev{left:1.25rem}
            .marquee-hero__arrow--next{right:1.25rem}}

        .marquee-hero__slide{position:relative;flex:0 0 auto;
            width:clamp(160px,calc((100vw - 4.5rem)/4),480px);aspect-ratio:2/3;border-radius:1.15rem;
            overflow:hidden;display:block;
            transition:transform .4s cubic-bezier(.22,.68,0,1.01),box-shadow .4s;
            box-shadow:0 20px 40px -18px rgba(0,0,0,.75);
            transform-origin:center bottom}
        .marquee-hero__slide:nth-child(3n+1){transform:translateY(0) rotate(0deg)}
        .marquee-hero__slide:nth-child(3n+2){transform:translateY(-18px) rotate(-2.5deg)}
        .marquee-hero__slide:nth-child(3n+3){transform:translateY(8px) rotate(2deg)}
        .marquee-hero__slide:hover{transform:translateY(-10px) rotate(0) scale(1.05);
            z-index:5;box-shadow:0 30px 55px -20px rgba(139,92,246,.6)}
        .marquee-hero__slide img{width:100%;height:100%;object-fit:cover;
            filter:saturate(1.08);transition:transform .6s ease}
        .marquee-hero__slide:hover img{transform:scale(1.06)}
        .marquee-hero__slide::after{content:'';position:absolute;inset:0;
            background:linear-gradient(180deg,transparent 45%,rgba(0,0,0,.92));
            pointer-events:none}
        .marquee-hero__caption{position:absolute;inset:auto 0 0 0;padding:1rem .9rem .9rem;z-index:2}
        .marquee-hero__cat{display:inline-block;font-size:.6rem;font-weight:700;
            letter-spacing:.06em;text-transform:uppercase;padding:.2rem .55rem;
            border-radius:999px;color:#c7d2fe;background:rgba(139,92,246,.25);
            border:1px solid rgba(139,92,246,.4);margin-bottom:.4rem;
            backdrop-filter:blur(6px)}
        .marquee-hero__caption h3{font-size:.85rem;font-weight:600;line-height:1.25;
            color:#fff;text-shadow:0 2px 10px rgba(0,0,0,.9);
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;
            overflow:hidden}

        /* ═══════════════════════════════════════════════════════════════════
           FEATURE
        ═══════════════════════════════════════════════════════════════════ */
        .fh-feature{position:relative;background:#12141f;border-radius:1rem;overflow:hidden;
            border:1px solid rgba(255,255,255,.07);display:block;
            transition:transform .45s cubic-bezier(.22,.68,0,1.01),
                box-shadow .45s,border-color .45s}
        .fh-feature:hover{transform:translateY(-6px);border-color:rgba(139,92,246,.5);
            box-shadow:0 24px 48px -20px rgba(139,92,246,.5)}
        .fh-feature__media{position:relative;aspect-ratio:16/9;overflow:hidden;background:#1a1d2e}
        .fh-feature__media img{width:100%;height:100%;object-fit:cover;
            transition:transform .7s cubic-bezier(.22,.68,0,1.01)}
        .fh-feature:hover .fh-feature__media img{transform:scale(1.08)}
        .fh-feature__badge{position:absolute;top:.7rem;left:.7rem;font-size:.65rem;
            font-weight:700;padding:.3rem .65rem;border-radius:999px;color:#fff;
            background:rgba(139,92,246,.9);backdrop-filter:blur(8px)}
        .fh-feature__body{padding:1rem}
        .fh-feature__title{font-size:.9rem;font-weight:600;line-height:1.3;color:#f3f4f6;
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .fh-feature__sub{font-size:.72rem;color:#9ca3af;margin-top:.35rem}
        .fh-feature__date{display:flex;align-items:center;gap:.35rem;margin-top:.35rem;
            font-size:.7rem;color:#6b7280}
        .fh-feature__date svg{width:11px;height:11px;color:#8b5cf6;flex-shrink:0}

        /* ═══════════════════════════════════════════════════════════════════
           FOOTER
        ═══════════════════════════════════════════════════════════════════ */
        .fh-footer{position:relative;margin-top:3rem;
            background:linear-gradient(180deg,#0a0a12 0%,#0f0f1c 100%);
            border-top:1px solid rgba(139,92,246,.15)}
        .fh-footer::before{content:'';position:absolute;top:0;left:0;right:0;height:1px;
            background:linear-gradient(90deg,transparent,rgba(139,92,246,.5) 25%,
                rgba(236,72,153,.7) 50%,rgba(139,92,246,.5) 75%,transparent)}
        .fh-footer__inner{max-width:1320px;margin:0 auto;padding:3rem 1.5rem 2rem}
        .fh-footer__grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
            gap:2rem;margin-bottom:2rem}
        .fh-footer__brand{font-size:1.1rem;font-weight:700;color:#fff;
            display:inline-flex;align-items:center;gap:.5rem;margin-bottom:.75rem}
        .fh-footer__desc{font-size:.82rem;color:#9ca3af;line-height:1.6;max-width:320px}
        .fh-footer__title{font-size:.82rem;font-weight:700;color:#fff;
            margin-bottom:.9rem;letter-spacing:.02em;text-transform:uppercase}
        .fh-footer__list{list-style:none;padding:0;margin:0}
        .fh-footer__list li{margin-bottom:.5rem}
        .fh-footer__list a{font-size:.82rem;color:#9ca3af;text-decoration:none;transition:color .2s}
        .fh-footer__list a:hover{color:#a5b4fc}
        .fh-footer__social{display:flex;gap:.5rem;margin-top:1rem}
        .fh-footer__social a{width:36px;height:36px;display:inline-flex;
            align-items:center;justify-content:center;border-radius:999px;
            background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);
            color:#9ca3af;transition:all .25s}
        .fh-footer__social a:hover{color:#fff;background:rgba(139,92,246,.15);
            border-color:rgba(139,92,246,.4);transform:translateY(-2px)}
        .fh-footer__social svg{width:16px;height:16px}
        .fh-footer__bottom{border-top:1px solid rgba(255,255,255,.06);
            padding-top:1.5rem;display:flex;flex-wrap:wrap;gap:1rem;
            align-items:center;justify-content:space-between;
            font-size:.78rem;color:#6b7280}
        .fh-footer__bottom a{color:#9ca3af;text-decoration:none;transition:color .2s}
        .fh-footer__bottom a:hover{color:#a5b4fc}

        [x-cloak]{display:none!important}

        /* ── Theme CSS variables ── */
        :root,[data-theme="dark"]{--fh-bg:#0a0a12;--fh-bg-soft:#12141f;--fh-text:#f3f4f6;--fh-text-muted:#9ca3af;--fh-border:rgba(255,255,255,.07)}
        [data-theme="light"]{--fh-bg:#f8f9fc;--fh-bg-soft:#ffffff;--fh-text:#111827;--fh-text-muted:#6b7280;--fh-border:rgba(0,0,0,.08)}
        html{transition:background-color .3s,color .3s}
        [data-theme="light"] body{background-color:#f8f9fc!important;color:#111827!important}

        /* ── Light overrides ── */
        [data-theme="light"] .fh-nav{background:rgba(248,249,252,.88)!important}
        [data-theme="light"] .fh-nav.scrolled{background:rgba(248,249,252,.97)!important;box-shadow:0 12px 40px -22px rgba(139,92,246,.2)!important}
        [data-theme="light"] .fh-brand__text{color:#111827!important}
        [data-theme="light"] .fh-link{color:#6b7280!important}
        [data-theme="light"] .fh-link:hover,[data-theme="light"] .fh-link.is-active{color:#111827!important}
        [data-theme="light"] .fh-link::after{background:#111827!important}
        [data-theme="light"] .fh-icon-btn{background:rgba(0,0,0,.04)!important;border-color:rgba(0,0,0,.1)!important;color:#6b7280!important}
        [data-theme="light"] .fh-icon-btn:hover{background:rgba(139,92,246,.1)!important;border-color:rgba(139,92,246,.35)!important;color:#8b5cf6!important}
        [data-theme="light"] .fh-search{background:rgba(0,0,0,.04)!important;border-color:rgba(0,0,0,.1)!important;color:#6b7280!important}
        [data-theme="light"] .fh-search:hover{color:#111827!important;border-color:rgba(139,92,246,.4)!important;background:rgba(139,92,246,.06)!important}
        [data-theme="light"] .fh-btn--ghost{color:#374151!important}
        [data-theme="light"] .fh-btn--ghost:hover{background:rgba(0,0,0,.06)!important}
        [data-theme="light"] .fh-card{background:#ffffff!important;border-color:rgba(0,0,0,.08)!important}
        [data-theme="light"] .fh-card__title{color:#111827!important}
        [data-theme="light"] .fh-card__meta,[data-theme="light"] .fh-card__date{color:#6b7280!important}
        [data-theme="light"] .fh-card:hover{border-color:rgba(139,92,246,.4)!important}
        [data-theme="light"] .fh-feature{background:#ffffff!important;border-color:rgba(0,0,0,.08)!important}
        [data-theme="light"] .fh-feature__title{color:#111827!important}
        [data-theme="light"] .fh-feature__sub,[data-theme="light"] .fh-feature__date{color:#6b7280!important}
        [data-theme="light"] .fh-heading{color:#111827!important}
        [data-theme="light"] .fh-footer{background:linear-gradient(180deg,#f0f0f8,#e8e8f0)!important;border-top-color:rgba(139,92,246,.2)!important}
        [data-theme="light"] .fh-footer__brand,[data-theme="light"] .fh-footer__title{color:#111827!important}
        [data-theme="light"] .fh-footer__desc,[data-theme="light"] .fh-footer__list a,[data-theme="light"] .fh-footer__bottom{color:#6b7280!important}
        [data-theme="light"] .fh-footer__social a{background:rgba(0,0,0,.04)!important;border-color:rgba(0,0,0,.1)!important;color:#6b7280!important}
        [data-theme="light"] .fh-footer__bottom{border-top-color:rgba(0,0,0,.08)!important}
        [data-theme="light"] .marquee-hero{background:radial-gradient(120% 100% at 50% 0%,#e8e0f8 0%,#f0f0f8 60%)!important}

        /* ── Theme toggle button ── */
        .fh-theme-btn{position:relative;width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;border-radius:999px;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);cursor:pointer;transition:all .25s;flex-shrink:0;overflow:hidden}
        .fh-theme-btn:hover{background:rgba(139,92,246,.15);border-color:rgba(139,92,246,.4)}
        .fh-theme-btn svg{width:17px;height:17px;position:absolute;transition:opacity .3s,transform .3s cubic-bezier(.22,.68,0,1.01)}
        .fh-theme-btn .fh-icon-sun{color:#f59e0b;opacity:0;transform:rotate(90deg) scale(.6)}
        .fh-theme-btn .fh-icon-moon{color:#a78bfa;opacity:1;transform:rotate(0) scale(1)}
        [data-theme="light"] .fh-theme-btn .fh-icon-sun{opacity:1;transform:rotate(0) scale(1)}
        [data-theme="light"] .fh-theme-btn .fh-icon-moon{opacity:0;transform:rotate(-90deg) scale(.6)}
        [data-theme="light"] .fh-theme-btn{background:rgba(0,0,0,.04)!important;border-color:rgba(0,0,0,.1)!important}
        [data-theme="light"] .fh-theme-btn:hover{background:rgba(139,92,246,.1)!important;border-color:rgba(139,92,246,.35)!important}

        /* Spotlight: compact, cinematic, and responsive */
        body{overflow-x:clip}
        @supports not (overflow-x:clip){body{overflow-x:hidden}}
        .arc-slider{isolation:isolate;overflow:hidden;margin:0 auto;padding:5rem 1rem .8rem;position:relative}
        .arc-slider::before{content:"";position:absolute;z-index:-1;top:47%;left:50%;width:min(76vw,850px);height:clamp(260px,34vw,450px);border-radius:50%;
            background:radial-gradient(ellipse,rgba(124,58,237,.22),rgba(139,92,246,.08) 42%,transparent 72%);filter:blur(28px);pointer-events:none;
            transform:translate3d(-50%,-50%,0);animation:spotlight-glow 11s ease-in-out infinite alternate}
        .arc-slider__intro{position:relative;z-index:1;margin:0 auto .35rem;animation:spotlight-enter .55s cubic-bezier(.2,.7,.2,1) both}
        .arc-slider__eyebrow{display:block;margin-bottom:.38rem;color:#c4b5fd;font-size:.68rem;font-weight:700;letter-spacing:.17em;text-transform:uppercase}
        .arc-slider__intro .fh-heading{margin:0 0 .35rem;font-size:clamp(1.35rem,2.5vw,1.8rem);letter-spacing:-.025em}
        .arc-slider__intro-copy{margin:0;color:#9ca3af;font-size:clamp(.8rem,1.1vw,.92rem);line-height:1.5}
        .arc-slider__viewport{height:clamp(320px,35vw,490px);margin:0 auto;position:relative;display:flex;align-items:center;justify-content:center;
            perspective:1500px;perspective-origin:50% 45%;overflow:hidden;animation:spotlight-enter .7s .06s cubic-bezier(.2,.7,.2,1) both}
        .arc-slider__viewport::before{content:"";position:absolute;z-index:0;left:50%;top:50%;width:min(78%,740px);height:75%;border-radius:50%;
            background:radial-gradient(ellipse,rgba(139,92,246,.13),transparent 68%);filter:blur(24px);transform:translate3d(-50%,-48%,0);pointer-events:none}
        .arc-slider__stage{position:relative;z-index:1;width:100%;height:100%;display:flex;align-items:center;justify-content:center;transform-style:preserve-3d;touch-action:pan-y}
        .arc-slider__card{position:absolute;top:50%;left:50%;width:clamp(240px,34vw,440px);aspect-ratio:16/10;overflow:hidden;border:1px solid rgba(255,255,255,.12);border-radius:clamp(1rem,2vw,1.45rem);
            background:#171326;transform-origin:50% 55%;backface-visibility:hidden;text-decoration:none;cursor:pointer;
            transition:transform .78s cubic-bezier(.2,.72,.18,1),filter .55s ease,opacity .55s ease,box-shadow .65s ease,border-color .35s ease;
            box-shadow:0 25px 65px -28px rgba(0,0,0,.85)}
        .arc-slider__card img{display:block;width:100%;height:100%;object-fit:cover;transform:scale(1.015);transition:transform .8s cubic-bezier(.2,.72,.18,1),filter .55s ease}
        .arc-slider__card::before{content:"";position:absolute;z-index:1;inset:0;pointer-events:none;
            background:linear-gradient(180deg,rgba(8,7,18,.18),transparent 35%,rgba(8,7,18,.08) 55%,rgba(7,6,16,.88) 100%),linear-gradient(110deg,rgba(40,24,78,.16),transparent 52%)}
        .arc-slider__card.pos--2{opacity:.62;z-index:1;pointer-events:auto;transform:translate3d(-50%,-50%,0) translateX(-153%) translateY(22px) rotateY(15deg) rotateZ(-7deg) scale(.64);filter:brightness(.65) saturate(.78)}
        .arc-slider__card.pos--1{opacity:.92;z-index:3;pointer-events:auto;transform:translate3d(-50%,-50%,0) translateX(-83%) translateY(12px) rotateY(10deg) rotateZ(-4deg) scale(.83);filter:brightness(.82) saturate(.86)}
        .arc-slider__card.pos-0{opacity:1;z-index:5;transform:translate3d(-50%,-50%,0) scale(1.035);filter:brightness(1.04) saturate(1.04);
            border-color:rgba(196,181,253,.52);box-shadow:0 38px 90px -30px rgba(124,58,237,.66),0 0 36px -20px rgba(236,72,153,.52),inset 0 1px 0 rgba(255,255,255,.2)}
        .arc-slider__card.pos-1{opacity:.92;z-index:3;pointer-events:auto;transform:translate3d(-50%,-50%,0) translateX(83%) translateY(12px) rotateY(-10deg) rotateZ(4deg) scale(.83);filter:brightness(.82) saturate(.86)}
        .arc-slider__card.pos-2{opacity:.62;z-index:1;pointer-events:auto;transform:translate3d(-50%,-50%,0) translateX(153%) translateY(22px) rotateY(-15deg) rotateZ(7deg) scale(.64);filter:brightness(.65) saturate(.78)}
        .arc-slider__card.is-hidden{opacity:0!important;pointer-events:none!important;z-index:0!important;filter:blur(5px) brightness(.35)!important}
        .arc-slider__card.pos--2:hover,.arc-slider__card.pos--1:hover,.arc-slider__card.pos-1:hover,.arc-slider__card.pos-2:hover{filter:brightness(1) saturate(1);border-color:rgba(196,181,253,.4)}
        .arc-slider__card.pos-0:hover{transform:translate3d(-50%,-50%,0) translateY(-4px) scale(1.05)}
        .arc-slider__card:hover img{transform:scale(1.055)}
        .arc-slider__card:focus-visible{outline:3px solid #c4b5fd;outline-offset:4px}
        .arc-slider__meta{position:absolute;z-index:2;inset:auto 0 0;padding:clamp(.85rem,2vw,1.35rem);opacity:0;transform:translateY(8px);transition:opacity .35s ease,transform .4s ease}
        .arc-slider__card.pos-0 .arc-slider__meta{opacity:1;transform:translateY(0)}
        .arc-slider__card.pos--2 .arc-slider__meta,.arc-slider__card.pos--1 .arc-slider__meta,.arc-slider__card.pos-1 .arc-slider__meta,.arc-slider__card.pos-2 .arc-slider__meta{opacity:.5}
        .arc-slider__meta h3{max-width:90%;font-size:clamp(1rem,1.8vw,1.45rem);font-weight:750;line-height:1.2;color:#fff;text-shadow:0 2px 15px rgba(0,0,0,.9);
            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        .arc-slider__meta p{display:inline-flex;align-items:center;gap:.35rem;margin-top:.45rem;color:#c4b5fd;font-size:.75rem;font-weight:650}
        .arc-slider__meta p::before{content:"";width:6px;height:6px;border-radius:50%;background:#c084fc;box-shadow:0 0 10px rgba(192,132,252,.8)}
        .arc-slider__controls{display:flex;align-items:center;justify-content:center;gap:1rem;margin-top:.25rem;animation:spotlight-enter .7s .12s cubic-bezier(.2,.7,.2,1) both}
        .arc-slider__nav{display:flex;align-items:center;justify-content:center;gap:.65rem;margin:0}
        .arc-slider__nav button{width:48px;height:48px;display:inline-flex;align-items:center;justify-content:center;border:1px solid rgba(167,139,250,.34);border-radius:999px;
            background:linear-gradient(145deg,rgba(139,92,246,.17),rgba(255,255,255,.035));color:#ddd6fe;cursor:pointer;touch-action:manipulation;
            box-shadow:inset 0 1px 0 rgba(255,255,255,.07);transition:transform .22s ease,border-color .22s ease,background .22s ease,box-shadow .22s ease}
        .arc-slider__nav button:hover{transform:translateY(-2px);border-color:rgba(196,181,253,.75);background:linear-gradient(145deg,rgba(139,92,246,.38),rgba(236,72,153,.13));color:#fff;box-shadow:0 8px 22px -12px rgba(139,92,246,.8)}
        .arc-slider__nav button:active{transform:scale(.96)}
        .arc-slider__nav button:focus-visible,.arc-slider__dots button:focus-visible{outline:2px solid #c4b5fd;outline-offset:3px}
        .arc-slider__nav svg{width:19px;height:19px}
        .arc-slider__dots{min-height:40px;display:flex;align-items:center;justify-content:center;gap:.3rem;margin:0}
        .arc-slider__dots button{position:relative;width:34px;height:36px;display:grid;place-items:center;padding:0;border:0;background:transparent;cursor:pointer;touch-action:manipulation}
        .arc-slider__dots button::before{content:"";width:6px;height:6px;border-radius:999px;background:#55516b;transition:width .28s ease,background .28s ease,box-shadow .28s ease}
        .arc-slider__dots button:hover::before{background:#a78bfa}
        .arc-slider__dots button.is-active::before{width:22px;background:linear-gradient(90deg,#8b5cf6,#ec4899);box-shadow:0 0 12px rgba(139,92,246,.55)}
        @keyframes spotlight-enter{from{opacity:0;transform:translate3d(0,14px,0)}to{opacity:1;transform:translate3d(0,0,0)}}
        @keyframes spotlight-glow{from{opacity:.65;transform:translate3d(-50%,-50%,0) scale(.96)}to{opacity:1;transform:translate3d(-50%,-50%,0) scale(1.04)}}
        @media(max-width:1024px){
            .arc-slider{padding-top:4.65rem}
            .arc-slider__viewport{height:clamp(300px,40vw,400px);perspective:1200px}
            .arc-slider__card{width:clamp(230px,38vw,360px)}
            .arc-slider__card.pos--1{transform:translate3d(-50%,-50%,0) translateX(-82%) translateY(13px) rotateY(8deg) rotateZ(-3deg) scale(.78)}
            .arc-slider__card.pos-1{transform:translate3d(-50%,-50%,0) translateX(82%) translateY(13px) rotateY(-8deg) rotateZ(3deg) scale(.78)}
        }
        @media(max-width:640px){
            .arc-slider{padding:4.4rem .25rem .85rem}
            .arc-slider::before{width:105vw;height:270px;filter:blur(20px)}
            .arc-slider__intro{padding:0 .9rem;margin-bottom:.15rem}
            .arc-slider__eyebrow{font-size:.62rem;letter-spacing:.14em}
            .arc-slider__intro .fh-heading{font-size:1.3rem}
            .arc-slider__intro-copy{max-width:32rem;font-size:.78rem}
            .arc-slider__viewport{height:clamp(225px,68vw,340px);perspective:900px}
            .arc-slider__card{width:min(78vw,350px);border-radius:1rem}
            .arc-slider__card.pos--2,.arc-slider__card.pos-2{opacity:0!important;pointer-events:none!important;transform:translate3d(-50%,-50%,0) scale(.5)}
            .arc-slider__card.pos--1{opacity:.64;transform:translate3d(-50%,-50%,0) translateX(-88%) translateY(8px) rotateY(5deg) rotateZ(-3deg) scale(.72);filter:brightness(.65)}
            .arc-slider__card.pos-1{opacity:.64;transform:translate3d(-50%,-50%,0) translateX(88%) translateY(8px) rotateY(-5deg) rotateZ(3deg) scale(.72);filter:brightness(.65)}
            .arc-slider__card.pos-0{transform:translate3d(-50%,-50%,0) scale(1.015)}
            .arc-slider__card.pos-0:hover{transform:translate3d(-50%,-50%,0) translateY(-2px) scale(1.025)}
            .arc-slider__meta{padding:.85rem}
            .arc-slider__meta h3{font-size:clamp(.98rem,4.5vw,1.2rem)}
            .arc-slider__meta p{margin-top:.3rem;font-size:.68rem}
            .arc-slider__controls{gap:.65rem;margin-top:.1rem}
            .arc-slider__nav{gap:.55rem}
            .arc-slider__nav button{width:48px;height:48px}
            .arc-slider__dots{gap:.12rem}
            .arc-slider__dots button{width:30px;height:36px}
        }
        @media(max-width:380px){
            .arc-slider__viewport{height:230px}
            .arc-slider__card{width:78vw}
            .arc-slider__meta h3{font-size:.98rem}
            .arc-slider__nav button{width:46px;height:46px}
        }
        @media(prefers-reduced-motion:reduce){
            .arc-slider::before,.arc-slider__intro,.arc-slider__viewport,.arc-slider__controls{animation:none!important}
            .arc-slider__card,.arc-slider__card img,.arc-slider__meta,.arc-slider__nav button,.arc-slider__dots button::before{transition-duration:.01ms!important}
        }
    </style>
</head>
<body class="bg-gray-950 text-white font-sans antialiased">

@include('layouts.navigation')

@php
    $titleImageMap = [
        'demon slayer'      => ['https://image.tmdb.org/t/p/w500/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg','https://image.tmdb.org/t/p/w780/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg'],
        'kimetsu'           => ['https://image.tmdb.org/t/p/w500/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg','https://image.tmdb.org/t/p/w780/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg'],
        'attack on titan'   => ['https://image.tmdb.org/t/p/w500/hTP1DtLGFamjfu8WqjnuQdP1n4i.jpg','https://image.tmdb.org/t/p/w780/rqbCbjB19amtOtFQbb3K2lgm2zv.jpg'],
        'shingeki'          => ['https://image.tmdb.org/t/p/w500/hTP1DtLGFamjfu8WqjnuQdP1n4i.jpg','https://image.tmdb.org/t/p/w780/rqbCbjB19amtOtFQbb3K2lgm2zv.jpg'],
        'jujutsu kaisen'    => ['https://image.tmdb.org/t/p/w500/fHp4JmgyWaLVp2nBcLhPJcHGLyY.jpg','https://image.tmdb.org/t/p/w780/7n3Yo50c9X1cZf8n8v6J8f0d7fH.jpg'],
        'jujutsu'           => ['https://image.tmdb.org/t/p/w500/fHp4JmgyWaLVp2nBcLhPJcHGLyY.jpg','https://image.tmdb.org/t/p/w780/7n3Yo50c9X1cZf8n8v6J8f0d7fH.jpg'],
        'my hero academia'  => ['https://image.tmdb.org/t/p/w500/phA0f6i3m9c3QpqZ8m7mY1tZq9k.jpg','https://image.tmdb.org/t/p/w780/6H0s5lY8qW4cR3mN9vK6j2Tf4zX.jpg'],
        'boku no hero'      => ['https://image.tmdb.org/t/p/w500/phA0f6i3m9c3QpqZ8m7mY1tZq9k.jpg','https://image.tmdb.org/t/p/w780/6H0s5lY8qW4cR3mN9vK6j2Tf4zX.jpg'],
        'death note'        => ['https://image.tmdb.org/t/p/w500/iigTq2ZgvN4b5zKkS1M9wBqZ2nJ.jpg','https://image.tmdb.org/t/p/w780/l6S6h4C9wE2yW3fV7q8jR1mY9xK.jpg'],
        'one piece'         => ['https://image.tmdb.org/t/p/w500/fcRB5BOtt1zHt0zS0dZk4g1n2z3.jpg','https://image.tmdb.org/t/p/w780/2f6vQ2z9w8Y4nM3kR7bL5xJ1pHs.jpg'],
        'naruto'            => ['https://image.tmdb.org/t/p/w500/x2LSRK2Cm7MZhjluni1msVJ3wDF.jpg','https://image.tmdb.org/t/p/w780/hY8tQ4jL2nW3xK6vR9m5fB7cZ0d.jpg'],
        'spy x family'      => ['https://image.tmdb.org/t/p/w500/3r4iXf4eZ4fW3tQ8jL2nR9mK6vX.jpg','https://image.tmdb.org/t/p/w780/w7tW3mY9qK5nR2fL8bX4jH1zC6v.jpg'],
        'spy family'        => ['https://image.tmdb.org/t/p/w500/3r4iXf4eZ4fW3tQ8jL2nR9mK6vX.jpg','https://image.tmdb.org/t/p/w780/w7tW3mY9qK5nR2fL8bX4jH1zC6v.jpg'],
        'chainsaw man'      => ['https://image.tmdb.org/t/p/w500/o8v6hT7oJ2E5M1C9wH2qL3mY6rB.jpg','https://image.tmdb.org/t/p/w780/vQ7yF4nL2wX9mK6bR3jH5tZ1cB8.jpg'],
        'fullmetal'         => ['https://image.tmdb.org/t/p/w500/p0aC6C9qP4F8tY6mQ5jGg0d2w3d.jpg','https://image.tmdb.org/t/p/w780/yT6mK4nB2wR9fX3jH5tZ7cV1qL8.jpg'],
        'one punch man'     => ['https://image.tmdb.org/t/p/w500/oOce9hLMVF43lHTiVB6P5WOJZRh.jpg','https://image.tmdb.org/t/p/w780/nM5bK3wR8fX4jH2tZ6cV9qL1yT7.jpg'],
        'tokyo ghoul'       => ['https://image.tmdb.org/t/p/w500/hE3LRZAY84fG19a18pzpkZERjTE.jpg','https://image.tmdb.org/t/p/w780/bR4wK7nF2yT9jH5tZ3cV6qL8mX1.jpg'],
        'bleach'            => ['https://image.tmdb.org/t/p/w500/2EewmxXe72ogD0EaWM8XHw1W32a.jpg','https://image.tmdb.org/t/p/w780/2EewmxXe72ogD0EaWM8XHw1W32a.jpg'],
        'stranger things'   => ['https://image.tmdb.org/t/p/w500/49WJfeN0moxb9IPfGn8AIqMGskD.jpg','https://image.tmdb.org/t/p/w780/56v2KjBlU4XaOv9rVYEQypROD7P.jpg'],
        'game of thrones'   => ['https://image.tmdb.org/t/p/w500/1XS1oqL89opfnbLl8WnZY1O1uJx.jpg','https://image.tmdb.org/t/p/w780/suopoADq0k8YZr4dQXcU6pToj6s.jpg'],
        'got'               => ['https://image.tmdb.org/t/p/w500/1XS1oqL89opfnbLl8WnZY1O1uJx.jpg','https://image.tmdb.org/t/p/w780/suopoADq0k8YZr4dQXcU6pToj6s.jpg'],
        'breaking bad'      => ['https://image.tmdb.org/t/p/w500/ggFHVNu6YYI5L9pCfOacjizRGt.jpg','https://image.tmdb.org/t/p/w780/tsRy63Mu5cu8etL1X7ZLyf7UP1M.jpg'],
        'money heist'       => ['https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg','https://image.tmdb.org/t/p/w780/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg'],
        'la casa de papel'  => ['https://image.tmdb.org/t/p/w500/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg','https://image.tmdb.org/t/p/w780/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg'],
        'wednesday'         => ['https://image.tmdb.org/t/p/w500/9PFonBhy4cQy7Jz20NpMygczOkv.jpg','https://image.tmdb.org/t/p/w780/9msXr1ZHsGqXdK3UqgBLz9jRhSS.jpg'],
        'last of us'        => ['https://image.tmdb.org/t/p/w500/uKvVjHNqB5VmOrdxqAt2F7J78ED.jpg','https://image.tmdb.org/t/p/w780/uDgy6hyPd82kOHh6I95FLtLnj6p.jpg'],
        'the crown'         => ['https://image.tmdb.org/t/p/w500/1M876KPjulVwppEpldhdc8V4o68.jpg','https://image.tmdb.org/t/p/w780/1bBQ2Q4zJ3mGg9jXf2Y3cV6qL8m.jpg'],
        'witcher'           => ['https://image.tmdb.org/t/p/w500/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg','https://image.tmdb.org/t/p/w780/jBJWbJkWQG1eCbH4dJ3Y4cV6qL8m.jpg'],
        'house of the dragon'=>['https://image.tmdb.org/t/p/w500/z2yahl2uefxDCl0nogcRBstwruJ.jpg','https://image.tmdb.org/t/p/w780/1HccZGkY4oHxE4o6HVJKrNRS5ff.jpg'],
        'hotd'              => ['https://image.tmdb.org/t/p/w500/z2yahl2uefxDCl0nogcRBstwruJ.jpg','https://image.tmdb.org/t/p/w780/1HccZGkY4oHxE4o6HVJKrNRS5ff.jpg'],
        'severance'         => ['https://image.tmdb.org/t/p/w500/lFf6LLrQjYldcZItzOkGmMMigP7.jpg','https://image.tmdb.org/t/p/w780/1yeVJox3rjo2jBKrrihIMj7uoS9.jpg'],
        'the boys'          => ['https://image.tmdb.org/t/p/w500/2zmTngn1tYC1AvfnrFLhxeD82hz.jpg','https://image.tmdb.org/t/p/w780/2OMB0ynKlyIenMJWI2Dy9IWT4c.jpg'],
        'squid game'        => ['https://image.tmdb.org/t/p/w500/dDlEmu3EZ0Pgg93K2SVNLCjCSvE.jpg','https://image.tmdb.org/t/p/w780/dK4H5yL2nW3xK6vR9m5fB7cZ0dV.jpg'],
        'abbott elementary' => ['https://image.tmdb.org/t/p/w500/2AYM3fW3kOGLlAdW5QmX8s2q9yE.jpg','https://image.tmdb.org/t/p/w780/2AYM3fW3kOGLlAdW5QmX8s2q9yE.jpg'],
        'oppenheimer'       => ['https://image.tmdb.org/t/p/w500/ptpr0kGAckfQkJeJIt8st5dglvd.jpg','https://image.tmdb.org/t/p/w780/rLb2cs7wcITYRhUI7Wydsb2qJ5.jpg'],
        'dune'              => ['https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg','https://image.tmdb.org/t/p/w780/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg'],
        'barbie'            => ['https://image.tmdb.org/t/p/w500/iuFNMS8U5cb6xfzi51Dbkovj7vM.jpg','https://image.tmdb.org/t/p/w780/nHf61UzkfFno5X1ofIhugCPus2R.jpg'],
        'batman'            => ['https://image.tmdb.org/t/p/w500/rktDFPbfHfUbArZ6OOOKsXcv0Bm.jpg','https://image.tmdb.org/t/p/w780/b0PlSFdDwbyK0cf5RxwDpaOJQvQ.jpg'],
        'inception'         => ['https://image.tmdb.org/t/p/w500/5a4JdoFwll5DRtKNNWC8CwABwvp.jpg','https://image.tmdb.org/t/p/w780/s3TBrRGB1iav7gFOCNx3H31MoES.jpg'],
        'interstellar'      => ['https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg','https://image.tmdb.org/t/p/w780/xJHokMbljvjADYdit5fK5VQsXEG.jpg'],
        'dark knight'       => ['https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg','https://image.tmdb.org/t/p/w780/hqkIcbrOHL86UncnHIsHVcVmzue.jpg'],
        'blade runner'      => ['https://image.tmdb.org/t/p/w500/q719jXXEzOoYaps6babgKnONONX.jpg','https://image.tmdb.org/t/p/w780/ilRyazdMJwN05exqhwK4tMKBYZs.jpg'],
        'pulp fiction'      => ['https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg','https://image.tmdb.org/t/p/w780/suaEOtk1N1sgg2MTM7oZd2cfVp3.jpg'],
        'mad max'           => ['https://image.tmdb.org/t/p/w500/6ELCZlTA5lGUops70hKdB83WJxH.jpg','https://image.tmdb.org/t/p/w780/hmB7baPdxnM3rP9vZoRLLg0H0mD.jpg'],
        'matrix'            => ['https://image.tmdb.org/t/p/w500/4q2NNj4S5dG2RLF9CpXsej7yXl.jpg','https://image.tmdb.org/t/p/w780/fNG7i7RqMErkcqhohV2a6cV1Ehy.jpg'],
        'fight club'        => ['https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg','https://image.tmdb.org/t/p/w780/hZkgoQYus5vegHoetLkCJzb17zJ.jpg'],
    ];

    $animeBackdrops = [
        'https://image.tmdb.org/t/p/w780/xUfRZu2mi8jH6SzQEJGP6tjBuYj.jpg',
        'https://image.tmdb.org/t/p/w780/rqbCbjB19amtOtFQbb3K2lgm2zv.jpg',
        'https://image.tmdb.org/t/p/w780/7n3Yo50c9X1cZf8n8v6J8f0d7fH.jpg',
        'https://image.tmdb.org/t/p/w780/6H0s5lY8qW4cR3mN9vK6j2Tf4zX.jpg',
        'https://image.tmdb.org/t/p/w780/l6S6h4C9wE2yW3fV7q8jR1mY9xK.jpg',
        'https://image.tmdb.org/t/p/w780/2f6vQ2z9w8Y4nM3kR7bL5xJ1pHs.jpg',
        'https://image.tmdb.org/t/p/w780/hY8tQ4jL2nW3xK6vR9m5fB7cZ0d.jpg',
        'https://image.tmdb.org/t/p/w780/w7tW3mY9qK5nR2fL8bX4jH1zC6v.jpg',
        'https://image.tmdb.org/t/p/w780/vQ7yF4nL2wX9mK6bR3jH5tZ1cB8.jpg',
        'https://image.tmdb.org/t/p/w780/yT6mK4nB2wR9fX3jH5tZ7cV1qL8.jpg',
        'https://image.tmdb.org/t/p/w780/nM5bK3wR8fX4jH2tZ6cV9qL1yT7.jpg',
        'https://image.tmdb.org/t/p/w780/bR4wK7nF2yT9jH5tZ3cV6qL8mX1.jpg',
    ];
    $tvBackdrops = [
        'https://image.tmdb.org/t/p/w780/56v2KjBlU4XaOv9rVYEQypROD7P.jpg',
        'https://image.tmdb.org/t/p/w780/suopoADq0k8YZr4dQXcU6pToj6s.jpg',
        'https://image.tmdb.org/t/p/w780/tsRy63Mu5cu8etL1X7ZLyf7UP1M.jpg',
        'https://image.tmdb.org/t/p/w780/reEMJA1uzscCbkpeRJeTT2bjqUp.jpg',
        'https://image.tmdb.org/t/p/w780/9msXr1ZHsGqXdK3UqgBLz9jRhSS.jpg',
        'https://image.tmdb.org/t/p/w780/uDgy6hyPd82kOHh6I95FLtLnj6p.jpg',
        'https://image.tmdb.org/t/p/w780/1bBQ2Q4zJ3mGg9jXf2Y3cV6qL8m.jpg',
        'https://image.tmdb.org/t/p/w780/jBJWbJkWQG1eCbH4dJ3Y4cV6qL8m.jpg',
        'https://image.tmdb.org/t/p/w780/1HccZGkY4oHxE4o6HVJKrNRS5ff.jpg',
        'https://image.tmdb.org/t/p/w780/1yeVJox3rjo2jBKrrihIMj7uoS9.jpg',
        'https://image.tmdb.org/t/p/w780/2OMB0ynKlyIenMJWI2Dy9IWT4c.jpg',
        'https://image.tmdb.org/t/p/w780/dK4H5yL2nW3xK6vR9m5fB7cZ0dV.jpg',
    ];
    $movieBackdrops = [
        'https://image.tmdb.org/t/p/w780/nb3xI8XI3w4pMVZ38VijbsyBqP4.jpg',
        'https://image.tmdb.org/t/p/w780/xOMo8BRK7PfcJv9JCnx7s5hj0PX.jpg',
        'https://image.tmdb.org/t/p/w780/nHf61UzkfFno5X1ofIhugCPus2R.jpg',
        'https://image.tmdb.org/t/p/w780/b0PlSFdDwbyK0cf5RxwDpaOJQvQ.jpg',
        'https://image.tmdb.org/t/p/w780/s3TBrRGB1iav7gFOCNx3H31MoES.jpg',
        'https://image.tmdb.org/t/p/w780/xJHokMbljvjADYdit5fK5VQsXEG.jpg',
        'https://image.tmdb.org/t/p/w780/hqkIcbrOHL86UncnHIsHVcVmzue.jpg',
        'https://image.tmdb.org/t/p/w780/ilRyazdMJwN05exqhwK4tMKBYZs.jpg',
        'https://image.tmdb.org/t/p/w780/suaEOtk1N1sgg2MTM7oZd2cfVp3.jpg',
        'https://image.tmdb.org/t/p/w780/hmB7baPdxnM3rP9vZoRLLg0H0mD.jpg',
        'https://image.tmdb.org/t/p/w780/fNG7i7RqMErkcqhohV2a6cV1Ehy.jpg',
        'https://image.tmdb.org/t/p/w780/hZkgoQYus5vegHoetLkCJzb17zJ.jpg',
    ];

    $musicBackdrops = [
        'https://images.unsplash.com/photo-1511379938547-c1f69419868d?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1516280440614-37939bbacd81?auto=format&fit=crop&w=1280&q=85',
    ];
    $sportsBackdrops = [
        'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1540747913346-19e32dc3e97e?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=1280&q=85',
    ];
    $gamingBackdrops = [
        'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1593305841991-05c297ba4575?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=1280&q=85',
    ];
    $artBackdrops = [
        'https://images.unsplash.com/photo-1541961017774-22349e4a1262?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1577083552431-6e5fd01aa342?auto=format&fit=crop&w=1280&q=85',
    ];
    $podcastBackdrops = [
        'https://images.unsplash.com/photo-1590602847861-f357a9332bbc?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1598488035139-bdbb2231ce04?auto=format&fit=crop&w=1280&q=85',
    ];
    $editorialBackdrops = [
        'https://images.unsplash.com/photo-1455390582262-044c97d9f0d7?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1456324504439-367cee3b3c32?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1455885666463-1fb5f0d1853e?auto=format&fit=crop&w=1280&q=85',
    ];
    $eventBackdrops = [
        'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?auto=format&fit=crop&w=1280&q=85',
        'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=1280&q=85',
    ];

    $categoryImage = function ($item, int $index = 0, string $kind = 'content') use ($animeBackdrops, $tvBackdrops, $movieBackdrops, $musicBackdrops, $sportsBackdrops, $gamingBackdrops, $artBackdrops, $podcastBackdrops, $editorialBackdrops, $eventBackdrops) {
        if ($kind === 'article') return $editorialBackdrops[$index % count($editorialBackdrops)];
        if ($kind === 'event') return $eventBackdrops[$index % count($eventBackdrops)];

        $cat = strtolower(trim((string) ($item->category->name ?? '')));
        $type = strtolower(trim((string) ($item->type ?? '')));
        if (str_contains($cat, 'music') || $type === 'music') $pool = $musicBackdrops;
        elseif (str_contains($cat, 'sport') || str_contains($cat, 'cricket') || str_contains($cat, 'football')) $pool = $sportsBackdrops;
        elseif (str_contains($cat, 'game') || $type === 'game' || $type === 'gaming') $pool = $gamingBackdrops;
        elseif (str_contains($cat, 'art') || $type === 'art') $pool = $artBackdrops;
        elseif (str_contains($cat, 'podcast') || $type === 'podcast') $pool = $podcastBackdrops;
        elseif (str_contains($cat, 'anime') || str_contains($cat, 'manga') || $type === 'anime') $pool = $animeBackdrops;
        elseif (str_contains($cat, 'tv') || str_contains($cat, 'series') || str_contains($cat, 'show') || $type === 'series') $pool = $tvBackdrops;
        else $pool = $movieBackdrops;

        return $pool[($item->id + $index) % count($pool)];
    };

    $smartImage = function ($item, int $index = 0, string $type = 'backdrop') use ($titleImageMap, $categoryImage) {
        if ($type !== 'fallback' && !empty($item->thumbnail)) return $item->thumbnailUrl();
        $title = strtolower(trim((string) $item->title));
        if ($type !== 'fallback') {
            foreach ($titleImageMap as $keyword => $imgs) {
                if (str_contains($title, $keyword)) return $type === 'poster' ? $imgs[0] : $imgs[1];
            }
        }
        return $categoryImage($item, $index);
    };

    $sampleDates = ['Nov 15, 2024','Oct 22, 2024','Sep 08, 2024','Dec 01, 2024','Aug 19, 2024','Jul 30, 2024','Jun 14, 2024','May 03, 2024'];

    // Merge curated sources so both top sliders keep showing distinct titles
    // when the trending list itself contains only a couple of items.
    $sliderItems = collect($trending ?? [])
        ->concat($popular ?? [])
        ->concat($latest ?? [])
        ->filter()
        ->unique('id')
        ->take(12)
        ->values();

    $marqueeItems = $sliderItems->take(4)->values();
    foreach ($marqueeItems as $i => $item) {
        $item->smart_poster = $smartImage($item, $i, 'poster');
    }

    $spotlightItems = $sliderItems->take(7)->values();
    foreach ($spotlightItems as $i => $item) {
        $item->smart_backdrop = $smartImage($item, $i, 'backdrop');
    }
@endphp

{{-- ═══════════════════════════════════════════════════════════════════════
     1) CURVED ARC SLIDER — 5 CARDS VISIBLE
═══════════════════════════════════════════════════════════════════════ --}}
@if ($spotlightItems->count() >= 5)
@php
    $totalSpotlight = $spotlightItems->count();
    $midSpotlight   = (int) floor($totalSpotlight / 2);
@endphp
<section class="arc-slider max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8" data-arc-carousel role="region" aria-label="Editor's Spotlight" aria-roledescription="carousel">
    <div class="arc-slider__intro">
        <span class="arc-slider__eyebrow">Picked for your next watch</span>
        <h2 class="fh-heading">Editor's Spotlight</h2>
        <p class="arc-slider__intro-copy">A closer look at standout stories from the FanHub+ community.</p>
    </div>

    <div class="arc-slider__viewport">
        <div class="arc-slider__stage" data-arc-slider>
            @foreach ($spotlightItems as $i => $item)
                @php
                    $initialPos = $i - $midSpotlight;
                    $posClass = $initialPos;
                    $isExtra  = false;
                    if ($posClass < -2) { $posClass = -2; $isExtra = true; }
                    if ($posClass > 2)  { $posClass = 2;  $isExtra = true; }
                @endphp
                <a href="{{ route('contents.show', $item) }}"
                   class="arc-slider__card pos-{{ $posClass }} {{ $isExtra ? 'is-hidden' : '' }}"
                   data-arc-index="{{ $i }}" aria-label="{{ $item->title }}">
                    <img src="{{ $item->smart_backdrop }}" alt="{{ $item->title }}" loading="lazy"
                         onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                    <div class="arc-slider__meta">
                        <h3>{{ $item->title }}</h3>
                        @if ($item->category)<p>{{ $item->category->name }}</p>@endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="arc-slider__controls">
      <div class="arc-slider__nav" aria-label="Spotlight controls">
        <button type="button" data-arc-prev aria-label="Previous spotlight">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        <button type="button" data-arc-next aria-label="Next spotlight">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
      </div>
      <div class="arc-slider__dots" data-arc-dots role="group" aria-label="Choose a spotlight"></div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════════════════════
     2) MARQUEE
═══════════════════════════════════════════════════════════════════════ --}}
@if ($marqueeItems->isNotEmpty())
@php
    // ✅ Pad to minimum 8 items so track always fills viewport
    $marqueeLoop = $marqueeItems;
    $safety = 0;
    while ($marqueeLoop->count() < 8 && $marqueeItems->isNotEmpty() && $safety < 10) {
        $marqueeLoop = $marqueeLoop->concat($marqueeItems);
        $safety++;
    }
@endphp
<section class="marquee-hero" data-marquee data-speed="{{ 45 }}" data-loop-count="{{ $marqueeLoop->count() }}">
    <button type="button" class="marquee-hero__arrow marquee-hero__arrow--prev" data-marquee-prev aria-label="Previous">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button type="button" class="marquee-hero__arrow marquee-hero__arrow--next" data-marquee-next aria-label="Next">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>
    <div class="marquee-hero__mask">
        <div class="marquee-hero__track" data-marquee-track>
            {{-- Four identical passes provide seamless coverage while one pass loops. --}}
            @for ($pass = 0; $pass < 4; $pass++)
                @foreach ($marqueeLoop as $item)
                    <a href="{{ route('contents.show', $item) }}" class="marquee-hero__slide"
                       @if($pass > 0) aria-hidden="true" tabindex="-1" @endif>
                        <img src="{{ $item->smart_poster }}" alt="{{ $pass === 0 ? $item->title : '' }}"
                             loading="{{ $pass === 0 ? 'eager' : 'lazy' }}"
                             onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                        <div class="marquee-hero__caption">
                            @if ($item->category)
                                <span class="marquee-hero__cat">{{ $item->category->name }}</span>
                            @endif
                            <h3>{{ $item->title }}</h3>
                        </div>
                    </a>
                @endforeach
            @endfor
        </div>
    </div>
</section>
@endif
 

{{-- MAIN CONTENT --}}
<div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 space-y-10 mt-6">

    {{-- Continue Exploring --}}
    @if ($continueRow->isNotEmpty())
        @php
            $progressMap = \App\Models\WatchProgress::where('profile_id', $profile->id)
                ->pluck('progress_pct', 'content_id')->toArray();
            $cnt = $continueRow->count();
        @endphp
        <div>
            <h2 class="fh-heading">Continue Exploring</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($continueRow as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $pct = $progressMap[$item->id] ?? null;
                        $img = $smartImage($item, $i, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                            @if ($pct)
                                <div class="fh-card__progress"><span style="width: {{ $pct }}%"></span></div>
                            @endif
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Trending Now --}}
    @if ($trending->isNotEmpty())
        @php $cnt = $trending->count(); @endphp
        <div>
            <h2 class="fh-heading">🔥 Trending Now
                <a href="{{ route('explore') }}" class="fh-heading__badge">See all →</a>
            </h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($trending as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Because You Liked --}}
    @foreach ($becauseRows as $rowIdx => $row)
        @php $cnt = $row['items']->count(); @endphp
        <div>
            <h2 class="fh-heading">{{ $row['title'] }}</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($row['items'] as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + $rowIdx, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + $rowIdx) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- New This Week --}}
    @if ($newThisWeek->isNotEmpty())
        @php $cnt = $newThisWeek->count(); @endphp
        <div>
            <h2 class="fh-heading">New This Week <span class="fh-heading__badge">Fresh</span></h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($newThisWeek as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + 2, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + 2) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <span class="fh-card__badge">NEW</span>
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Top 10 --}}
    @foreach ($top10Rows as $rowIdx => $row)
        @php $cnt = $row['items']->count(); @endphp
        <div>
            <h2 class="fh-heading">{{ $row['title'] }}</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($row['items'] as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + $rowIdx + 1, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + $rowIdx) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <span class="fh-card__rank">{{ $i + 1 }}</span>
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

    {{-- Featured Articles --}}
    @if (isset($featuredArticles) && $featuredArticles->isNotEmpty())
        @php $cnt = $featuredArticles->count(); @endphp
        <div>
            <h2 class="fh-heading">Featured Articles</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($featuredArticles as $i => $article)
                    @php
                        $articleDate = $sampleDates[($article->id + $i) % count($sampleDates)];
                        $articleImg = $article->cover_image ? $article->coverImageUrl() : $editorialBackdrops[$i % count($editorialBackdrops)];
                    @endphp
                    <a href="{{ route('articles.show', $article) }}" class="fh-feature">
                        <div class="fh-feature__media">
                            <img src="{{ $articleImg }}" alt="{{ $article->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $editorialBackdrops[$i % count($editorialBackdrops)] }}'">
                            <span class="fh-feature__badge">★ Featured</span>
                        </div>
                        <div class="fh-feature__body">
                            <h3 class="fh-feature__title">{{ $article->title }}</h3>
                            <p class="fh-feature__sub">{{ $article->user->name ?? 'Anonymous' }}</p>
                            <div class="fh-feature__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $articleDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Events Near You --}}
    @if ($eventsNearby->isNotEmpty())
    @php $cnt = $eventsNearby->count(); @endphp
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="fh-heading" style="margin-bottom:0;">Events Near You</h2>
            <a href="{{ route('events.index') }}" class="fh-heading__badge">See all →</a>
        </div>
        <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
            @foreach ($eventsNearby as $i => $event)
                @php
                    $eventDate = $event->start_datetime ? $event->start_datetime->format('M d, Y') : $sampleDates[($event->id + $i) % count($sampleDates)];
                    $eventImg = $event->cover_image ? $event->coverImageUrl() : $eventBackdrops[$i % count($eventBackdrops)];
                @endphp
                <a href="{{ route('events.show', $event) }}" class="fh-feature">
                    <div class="fh-feature__media">
                        <img src="{{ $eventImg }}" alt="{{ $event->title }}" loading="lazy"
                             onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $eventBackdrops[$i % count($eventBackdrops)] }}'">
                        <span class="fh-feature__badge capitalize">{{ $event->status() }}</span>
                    </div>
                    <div class="fh-feature__body">
                        <h3 class="fh-feature__title">{{ $event->title }}</h3>
                        <p class="fh-feature__sub">{{ $event->venue_name }}, {{ $event->city }}</p>
                        <div class="fh-feature__date">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $eventDate }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Latest --}}
    @if ($latest->isNotEmpty())
        @php $cnt = $latest->count(); @endphp
        <div>
            <h2 class="fh-heading">Latest Additions</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($latest as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + 3, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + 3) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Popular --}}
    @if ($popular->isNotEmpty())
        @php $cnt = $popular->count(); @endphp
        <div>
            <h2 class="fh-heading">Most Popular</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($popular as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + 4, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + 4) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Per-category --}}
    @foreach ($categories as $catIdx => $category)
        @php $cnt = $category->contents->count(); @endphp
        <div>
            <h2 class="fh-heading">{{ $category->name }}</h2>
            <div class="fh-grid {{ $cnt === 3 ? 'fh-grid--3' : ($cnt === 5 ? 'fh-grid--5' : '') }}">
                @foreach ($category->contents as $i => $item)
                    @php
                        $isInList = in_array($item->id, (array) $myListIds);
                        $img = $smartImage($item, $i + $catIdx, 'backdrop');
                        $cardDate = $sampleDates[($item->id + $i + $catIdx) % count($sampleDates)];
                    @endphp
                    <a href="{{ route('contents.show', $item) }}" class="fh-card">
                        <div class="fh-card__media">
                            <img src="{{ $img }}" alt="{{ $item->title }}" loading="lazy"
                                 onerror="this.onerror=function(){this.onerror=null;this.src='{{ asset('images/thumbnail-placeholder.svg') }}'};this.src='{{ $categoryImage($item, $item->id) }}'">
                            <button type="button" class="fh-card__add mylist-btn"
                                    data-content-id="{{ $item->id }}"
                                    data-in-list="{{ $isInList ? 'true' : 'false' }}">
                                <svg class="mylist-icon-add {{ $isInList ? 'hidden' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <svg class="mylist-icon-check {{ $isInList ? '' : 'hidden' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>
                        </div>
                        <div class="fh-card__body">
                            <h3 class="fh-card__title">{{ $item->title }}</h3>
                            <div class="fh-card__meta">
                                @if (!empty($item->release_year))<span>{{ $item->release_year }}</span><span class="fh-card__dot"></span>@endif
                                @if ($item->category)<span>{{ $item->category->name }}</span>@endif
                            </div>
                            <div class="fh-card__date">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $cardDate }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach

</div>

{{-- FOOTER --}}
@include('layouts.footer')

<div id="toast"
     class="fixed bottom-24 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-sm px-5 py-2.5
            rounded-full shadow-xl opacity-0 transition-opacity duration-300 pointer-events-none z-50">
</div>

<script src="/js/analytics-beacon.js" defer></script>
<x-chatbot />
@stack('scripts')

<script>


// ── fh-theme toggle ──────────────────────────────────────────────────────────


// ── Curved Arc Slider — 5 cards visible ──────────────────────────────────────
(function(){
    const stage = document.querySelector('[data-arc-slider]');
    if (!stage) return;
    const carousel = stage.closest('[data-arc-carousel]');
    const cards  = Array.from(stage.querySelectorAll('.arc-slider__card'));
    const total  = cards.length;
    if (total < 2 || !carousel) return;

    const prevBtn  = carousel.querySelector('[data-arc-prev]');
    const nextBtn  = carousel.querySelector('[data-arc-next]');
    const dotsWrap = carousel.querySelector('[data-arc-dots]');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const autoplayDelay = 5500;

    let active = cards.findIndex(c => /\bpos-0\b/.test(c.className));
    if (active === -1) active = 0;
    let timer = null;
    let paused = false;
    let inView = true;

    cards.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', `Show spotlight ${i + 1}: ${cards[i].getAttribute('aria-label')}`);
        dot.setAttribute('aria-pressed', i === active ? 'true' : 'false');
        if (i === active) dot.classList.add('is-active');
        dot.addEventListener('click', () => setActive(i));
        dotsWrap?.appendChild(dot);
    });

    function render() {
        cards.forEach((card, i) => {
            card.className = card.className.replace(/\bpos--?\d+\b|\bis-hidden\b/g, '').trim();
            card.style.transform = '';
            card.style.opacity = '';
            card.style.filter = '';

            let offset = i - active;
            if (offset > total / 2)  offset -= total;
            if (offset < -total / 2) offset += total;

            if (offset < -2 || offset > 2) {
                card.classList.add('is-hidden', offset < 0 ? 'pos--2' : 'pos-2');
                card.setAttribute('aria-hidden', 'true');
                card.tabIndex = -1;
            } else {
                card.classList.add(`pos-${offset}`);
                card.removeAttribute('aria-hidden');
                card.tabIndex = 0;
            }
        });

        dotsWrap?.querySelectorAll('button').forEach((dot, i) => {
            const isActive = i === active;
            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });
    }

    function setActive(i) {
        active = (i + total) % total;
        render();
        scheduleAutoplay();
    }

    function next() { setActive(active + 1); }
    function prev() { setActive(active - 1); }

    prevBtn?.addEventListener('click', prev);
    nextBtn?.addEventListener('click', next);

    cards.forEach((card, i) => {
        card.addEventListener('click', (e) => {
            if (/\bpos-0\b/.test(card.className)) return;
            e.preventDefault();
            setActive(i);
        });
    });

    carousel.addEventListener('keydown', (event) => {
        if (event.target.closest('input, textarea, select, [contenteditable="true"]')) return;
        if (event.key === 'ArrowLeft') { event.preventDefault(); prev(); }
        if (event.key === 'ArrowRight') { event.preventDefault(); next(); }
    });

    function stopAutoplay() {
        window.clearTimeout(timer);
        timer = null;
    }

    function scheduleAutoplay() {
        stopAutoplay();
        if (paused || reduceMotion || !inView || document.hidden) return;
        timer = window.setTimeout(() => {
            active = (active + 1) % total;
            render();
            scheduleAutoplay();
        }, autoplayDelay);
    }

    carousel.addEventListener('mouseenter', () => { paused = true; stopAutoplay(); });
    carousel.addEventListener('mouseleave', () => { paused = false; scheduleAutoplay(); });
    carousel.addEventListener('focusin', () => { paused = true; stopAutoplay(); });
    carousel.addEventListener('focusout', (event) => {
        if (!carousel.contains(event.relatedTarget)) { paused = false; scheduleAutoplay(); }
    });
    document.addEventListener('visibilitychange', scheduleAutoplay);

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(([entry]) => {
            inView = entry.isIntersecting;
            scheduleAutoplay();
        }, { threshold: 0.15 });
        observer.observe(carousel);
    }

    render();
    scheduleAutoplay();
})();

// Marquee
// ── Continuous marquee — one exact repeated group loops via requestAnimationFrame ──
(function(){
    const section = document.querySelector('[data-marquee]');
    const track   = section?.querySelector('[data-marquee-track]');
    if (!section || !track) return;
    const prevBtn = section.querySelector('[data-marquee-prev]');
    const nextBtn = section.querySelector('[data-marquee-next]');
    const speed   = parseFloat(section.dataset.speed || '45');
    const loopCount = Number(section.dataset.loopCount || 0);
    let pos = 0, loopWidth = 0;

    function measure() {
        const slides = track.querySelectorAll('.marquee-hero__slide');
        // Measure from the first card to the matching card in the next copy.
        // This includes the inter-card gaps exactly, avoiding a reset seam.
        loopWidth = slides[loopCount]?.offsetLeft - slides[0]?.offsetLeft || 0;
        if (loopWidth > 0) {
            pos %= loopWidth;
            if (pos > 0) pos -= loopWidth;
            apply();
        }
    }
    measure();
    window.addEventListener('resize', measure);

    function apply() { track.style.transform = `translateX(${pos}px)`; }

    function step(one) {
        const f = track.querySelector('.marquee-hero__slide');
        const gap = parseFloat(getComputedStyle(track).gap || '24');
        const cardStep = (f?.getBoundingClientRect().width || 280) + gap;
        pos -= one * cardStep;
        if (loopWidth > 0) {
            pos %= loopWidth;
            if (pos > 0) pos -= loopWidth;
        }
        apply();
    }

    prevBtn?.addEventListener('click', () => step(-1));
    nextBtn?.addEventListener('click', () => step(1));

    let last = performance.now();
    (function tick(now) {
        // Clamp a resumed/background frame so the strip never visibly jumps.
        const dt = Math.min((now - last) / 1000, 0.05);
        last = now;
        if (loopWidth > 0) {
            pos -= speed * dt;
            if (pos <= -loopWidth) pos += loopWidth;
            apply();
        }
        requestAnimationFrame(tick);
    })(last);
})();

// My List toggle
(function(){
    const csrf=document.querySelector('meta[name="csrf-token"]')?.content;
    const toast=document.getElementById('toast');
    function showToast(msg){toast.textContent=msg;toast.style.opacity='1';
        setTimeout(()=>toast.style.opacity='0',2000);}
    document.addEventListener('click',async function(e){
        const btn=e.target.closest('.mylist-btn');if(!btn)return;
        e.preventDefault();e.stopPropagation();
        const contentId=btn.dataset.contentId;
        try{const res=await fetch(`/my-list/${contentId}/toggle`,{method:'POST',
            headers:{'X-CSRF-TOKEN':csrf,'Accept':'application/json','Content-Type':'application/json'}});
            const data=await res.json();if(data.error){showToast(data.error);return;}
            btn.dataset.inList=data.in_list?'true':'false';
            btn.querySelector('.mylist-icon-add')?.classList.toggle('hidden',data.in_list);
            btn.querySelector('.mylist-icon-check')?.classList.toggle('hidden',!data.in_list);
            showToast(data.in_list?'✓ Added to My List':'Removed from My List');
        }catch{showToast('Something went wrong.');}});
})();
</script>
</body>
</html>
