<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', setting('seo.meta_title', setting('site_name', 'DesignPro'))) · {{ setting('site_name', 'DesignPro') }}</title>
    <meta name="description" content="@yield('meta_description', setting('seo.meta_description', ''))">
    <meta name="keywords" content="{{ setting('seo.keywords', '') }}">
    @if(setting('seo.og_image'))
    <meta property="og:image" content="{{ asset('storage/' . setting('seo.og_image')) }}">
    @endif
    @if(setting('general.favicon'))
    <link rel="icon" href="{{ asset('storage/' . setting('general.favicon')) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Inter+Tight:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --primary-light: #EFF6FF;
            --dark: #0F172A;
            --dark-2: #1E293B;
            --text: #334155;
            --text-light: #64748B;
            --text-muted: #94A3B8;
            --bg: #FFFFFF;
            --bg-soft: #F8FAFC;
            --border: #E2E8F0;
            --success: #10B981;
            --warning: #F59E0B;
            --danger: #EF4444;
            --purple: #8B5CF6;
            --radius: 14px;
            --shadow: 0 1px 3px rgba(15,23,42,.06), 0 10px 30px -10px rgba(15,23,42,.08);
            --shadow-lg: 0 20px 50px -20px rgba(15,23,42,.25);
            --title-grad-start: #0F172A;
            --title-grad-from: #1D4ED8;
            --title-grad-to: #7C3AED;
            --title-grad: linear-gradient(105deg, var(--title-grad-start) 0%, var(--title-grad-start) 28%, var(--title-grad-from) 62%, var(--title-grad-to) 100%);
            /* Global page gutters — same left/right inset on every page */
            --page-gutter: 24px;
            /* White-glass CTA — bright frost so it pops on dark surfaces */
            --btn-glass-bg: rgba(255, 255, 255, 0.88);
            --btn-glass-bg-hover: rgba(255, 255, 255, 0.98);
            --btn-glass-border: rgba(255, 255, 255, 0.95);
            --btn-glass-text: #0F172A;
            --btn-glass-blur: 20px;
            --btn-glass-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 1),
                0 0 0 1px rgba(255, 255, 255, 0.35),
                0 8px 24px rgba(15, 23, 42, 0.28),
                0 0 40px rgba(255, 255, 255, 0.22);
            --btn-glass-shadow-hover:
                inset 0 1px 0 rgba(255, 255, 255, 1),
                0 0 0 1px rgba(255, 255, 255, 0.5),
                0 12px 32px rgba(15, 23, 42, 0.32),
                0 0 48px rgba(255, 255, 255, 0.35);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: var(--bg); line-height: 1.7; -webkit-font-smoothing: antialiased; }
        h1,h2,h3,h4,h5 { font-family: 'Inter Tight', sans-serif; color: var(--dark); line-height: 1.2; letter-spacing: -0.02em; }
        /* Global section / page title h2 — black first, then blue→purple */
        body.site-shell h2 {
            font-size: clamp(32px, 4.6vw, 46px);
            letter-spacing: -0.03em;
            background-image: var(--title-grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        /* Keep solid light text on dark CTA surfaces (hire uses light gradient) */
        body.site-shell .cta-banner h2 {
            background-image: none;
            -webkit-background-clip: border-box;
            background-clip: border-box;
            color: #fff;
            -webkit-text-fill-color: #fff;
        }
        body.site-shell .svc-hire h2 {
            background-image: linear-gradient(
                115deg,
                #ffffff 0%,
                #E0F2FE 28%,
                #BFDBFE 52%,
                #C7D2FE 72%,
                #F5F3FF 100%
            );
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        a { color: var(--primary); text-decoration: none; }
        img { max-width: 100%; display: block; }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: max(var(--page-gutter), env(safe-area-inset-left, 0px));
            padding-right: max(var(--page-gutter), env(safe-area-inset-right, 0px));
            box-sizing: border-box;
            width: 100%;
        }
        .section { padding: 90px 0; }
        .section-alt { background: var(--bg-soft); }
        .section-head { text-align: center; max-width: 640px; margin: 0 auto 56px; }
        .section-eyebrow { display: inline-block; font-size: 13px; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.08em; background: var(--primary-light); padding: 6px 14px; border-radius: 20px; margin-bottom: 16px; }
        .section-head h2 { font-size: clamp(34px, 5vw, 48px); margin-bottom: 12px; }
        .section-head p { color: var(--text-light); font-size: 17px; }

        /* Navbar */
        .navbar { position: sticky; top: 0; z-index: 100; background: rgba(255,255,255,.9); backdrop-filter: blur(12px); border-bottom: 1px solid var(--border); }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 72px; }
        .nav-logo { display: flex; align-items: center; gap: 10px; font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 20px; color: var(--dark); letter-spacing: -0.02em; }
        .nav-logo .logo-mark { width: 34px; height: 34px; border-radius: 9px; background: var(--primary); display: grid; place-items: center; overflow: hidden; }
        .nav-logo .logo-mark--image { background: transparent; }
        .nav-logo .logo-mark img { width: 100%; height: 100%; object-fit: contain; display: block; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { color: var(--text-light); font-size: 14.5px; font-weight: 500; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        .nav-cta { display: flex; align-items: center; gap: 12px; }
        .lang-switch { position: relative; }
        .lang-switch__btn {
            display: inline-flex; align-items: center; gap: 8px;
            min-height: 40px; padding: 6px 10px;
            border-radius: 10px; border: 1.5px solid var(--border);
            background: #fff; color: var(--dark); cursor: pointer;
            font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600;
            transition: border-color .2s, background .2s;
        }
        .lang-switch__btn:hover, .lang-switch__btn[aria-expanded="true"] {
            border-color: var(--primary); background: var(--primary-light);
        }
        .lang-switch__flag {
            width: 22px; height: 16px; border-radius: 3px; overflow: hidden;
            display: inline-flex; box-shadow: 0 0 0 1px rgba(15,23,42,.08);
            flex-shrink: 0;
        }
        .lang-switch__flag svg { width: 100%; height: 100%; display: block; }
        .lang-switch__code { letter-spacing: 0.04em; }
        .lang-switch__chev { color: var(--text-muted); transition: transform .2s; }
        .lang-switch__btn[aria-expanded="true"] .lang-switch__chev { transform: rotate(180deg); }
        .lang-switch__menu {
            position: absolute; right: 0; top: calc(100% + 8px);
            min-width: 200px; padding: 6px;
            background: #fff; border: 1px solid var(--border); border-radius: 12px;
            box-shadow: var(--shadow-lg); display: none; z-index: 120;
        }
        .lang-switch__menu.open { display: grid; gap: 2px; }
        .lang-switch__item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px;
            color: var(--dark); font-size: 13.5px; font-weight: 500;
            transition: background .15s;
        }
        .lang-switch__item:hover { background: var(--bg-soft); }
        .lang-switch__item.is-active {
            background: var(--primary-light); color: var(--primary); font-weight: 600;
        }
        .lang-switch__item span { flex: 1; }
        @media (max-width: 900px) {
            .lang-switch { order: -1; }
            .lang-switch__menu { right: auto; left: 0; }
        }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 24px; border-radius: 10px; font-size: 14.5px; font-weight: 600; font-family: 'Inter', sans-serif; border: none; cursor: pointer; transition: all .2s; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn-outline { border: 1.5px solid var(--border); color: var(--dark); background: transparent; }
        .btn-outline:hover { border-color: var(--dark); }
        .btn-light { background: #fff; color: var(--dark); }
        .btn-light:hover { background: #f1f5f9; }
        .btn-lg { padding: 15px 30px; font-size: 16px; }

        /* White glass + shine — only secondary/outline CTAs on dark surfaces */
        .btn-glass,
        .hero-cta .btn-outline,
        .svc-hero-actions .btn-outline,
        .services-page .page-hero .btn-outline,
        .portfolio-page .page-hero .btn-outline,
        .cta-banner .btn,
        .cta-banner .btn-primary,
        .cta-banner .btn-light,
        .cta-banner .btn-glass,
        .svc-hire .btn-primary,
        .svc-hire .btn-glass,
        .service-tile--mesh .service-tile__link {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.82) 100%);
            backdrop-filter: blur(var(--btn-glass-blur)) saturate(180%);
            -webkit-backdrop-filter: blur(var(--btn-glass-blur)) saturate(180%);
            border: 1.5px solid var(--btn-glass-border);
            color: var(--btn-glass-text) !important;
            box-shadow: var(--btn-glass-shadow);
            -webkit-text-fill-color: var(--btn-glass-text);
            font-weight: 700;
        }
        .btn-glass::after,
        .hero-cta .btn-outline::after,
        .svc-hero-actions .btn-outline::after,
        .services-page .page-hero .btn-outline::after,
        .portfolio-page .page-hero .btn-outline::after,
        .cta-banner .btn::after,
        .svc-hire .btn-primary::after,
        .svc-hire .btn-glass::after,
        .service-tile--mesh .service-tile__link::after {
            content: "";
            position: absolute;
            top: -20%;
            left: -55%;
            width: 46%;
            height: 140%;
            background: linear-gradient(
                100deg,
                transparent 0%,
                rgba(255, 255, 255, 0.45) 38%,
                rgba(255, 255, 255, 1) 50%,
                rgba(255, 255, 255, 0.45) 62%,
                transparent 100%
            );
            transform: skewX(-18deg);
            animation: btn-glass-shine 2.8s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
            mix-blend-mode: soft-light;
        }
        .btn-glass:hover,
        .hero-cta .btn-outline:hover,
        .svc-hero-actions .btn-outline:hover,
        .services-page .page-hero .btn-outline:hover,
        .portfolio-page .page-hero .btn-outline:hover,
        .cta-banner .btn:hover,
        .cta-banner .btn-primary:hover,
        .cta-banner .btn-light:hover,
        .svc-hire .btn-primary:hover,
        .svc-hire .btn-glass:hover,
        .service-tile--mesh:hover .service-tile__link, .service-tile--mesh:focus-visible .service-tile__link {
            background: var(--btn-glass-bg-hover);
            border-color: #fff;
            color: var(--btn-glass-text) !important;
            -webkit-text-fill-color: var(--btn-glass-text);
            transform: translateY(-2px);
            box-shadow: var(--btn-glass-shadow-hover);
        }
        @keyframes btn-glass-shine {
            0%, 45% { left: -55%; opacity: 0; }
            52% { opacity: 1; }
            72% { left: 125%; opacity: 1; }
            78%, 100% { left: 125%; opacity: 0; }
        }
        @media (prefers-reduced-motion: reduce) {
            .btn-glass::after,
            .hero-cta .btn-outline::after,
            .svc-hero-actions .btn-outline::after,
            .services-page .page-hero .btn-outline::after,
            .portfolio-page .page-hero .btn-outline::after,
            .cta-banner .btn::after,
            .svc-hire .btn-primary::after,
            .svc-hire .btn-glass::after,
            .service-tile--mesh .service-tile__link::after {
                animation: none;
                display: none;
            }
            .btn-glass:hover,
            .hero-cta .btn-outline:hover,
            .svc-hero-actions .btn-outline:hover,
            .cta-banner .btn:hover,
            .svc-hire .btn-primary:hover {
                transform: none;
            }
        }
        @media (prefers-reduced-transparency: reduce) {
            .btn-glass,
            .hero-cta .btn-outline,
            .svc-hero-actions .btn-outline,
            .services-page .page-hero .btn-outline,
            .portfolio-page .page-hero .btn-outline,
            .cta-banner .btn,
            .cta-banner .btn-primary,
            .svc-hire .btn-primary,
            .service-tile--mesh .service-tile__link {
                background: #fff;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
        }
        .nav-toggle { display: none; background: none; border: none; cursor: pointer; font-size: 24px; color: var(--dark); }
        @media (max-width: 900px) {
            .nav-links, .nav-cta .btn { display: none; }
            .nav-toggle { display: block; }
            .nav-links.open { display: flex; flex-direction: column; position: absolute; top: 72px; left: 0; right: 0; background: #fff; padding: 20px; gap: 16px; border-bottom: 1px solid var(--border); }
            .nav-links.open a { font-size: 16px; }
        }

        /* Hero — soft motion + vivid title */
        .hero {
            padding: 100px 0 110px;
            --orb-1: #38bdf8;
            --orb-2: #818cf8;
            --orb-3: #34d399;
            --orb-4: #f472b6;
            --orb-5: #fbbf24;
            background:
                radial-gradient(ellipse 80% 60% at 18% 12%, color-mix(in srgb, var(--orb-1) 18%, transparent), transparent 55%),
                radial-gradient(ellipse 70% 50% at 88% 28%, color-mix(in srgb, var(--orb-2) 14%, transparent), transparent 50%),
                linear-gradient(180deg, #05070f 0%, #0a1020 55%, #101826 100%);
            position: relative;
            overflow: hidden;
            color: #E2E8F0;
        }
        .hero > .container { position: relative; z-index: 1; }
        .hero-bg {
            position: absolute; inset: 0; pointer-events: none; overflow: hidden; z-index: 0;
        }
        .hero-bg__orb {
            position: absolute; display: block; border-radius: 50%;
            filter: blur(42px); opacity: .52;
            animation-name: heroOrbDrift;
            animation-timing-function: ease-in-out;
            animation-iteration-count: infinite;
            transform: translate3d(0, 0, 0);
        }
        .hero-bg__orb--1 {
            width: min(58vw, 560px); height: min(58vw, 560px);
            top: -18%; left: -12%;
            background: radial-gradient(circle at 35% 35%, var(--orb-1), transparent 70%);
            animation-duration: 12s;
        }
        .hero-bg__orb--2 {
            width: min(46vw, 440px); height: min(46vw, 440px);
            top: 10%; right: -10%;
            background: radial-gradient(circle at 50% 50%, var(--orb-2), transparent 70%);
            animation-duration: 14s; animation-direction: reverse; animation-delay: -3s;
        }
        .hero-bg__orb--3 {
            width: min(40vw, 380px); height: min(40vw, 380px);
            bottom: -10%; left: 32%;
            background: radial-gradient(circle at 40% 40%, var(--orb-3), transparent 70%);
            animation-duration: 13s; animation-delay: -1.5s;
        }
        .hero-bg__orb--4 {
            width: min(24vw, 240px); height: min(24vw, 240px);
            top: 48%; left: 10%;
            background: radial-gradient(circle at 50% 50%, var(--orb-4), transparent 72%);
            animation-duration: 11s; animation-direction: reverse;
            opacity: .4;
        }
        .hero-bg__orb--5 {
            width: min(22vw, 220px); height: min(22vw, 220px);
            top: 60%; right: 20%;
            background: radial-gradient(circle at 50% 50%, var(--orb-5), transparent 72%);
            animation-duration: 12s;
            opacity: .38;
        }
        .hero-bg__beam {
            position: absolute; display: block;
            width: 140%; height: 40%;
            top: 18%; left: -22%;
            background: linear-gradient(105deg,
                transparent 22%,
                color-mix(in srgb, var(--orb-1) 22%, transparent) 48%,
                color-mix(in srgb, var(--orb-2) 18%, transparent) 56%,
                transparent 74%);
            filter: blur(22px);
            transform-origin: center;
            animation: heroBeamSweep 14s ease-in-out infinite;
            opacity: .7;
        }
        .hero-bg__grid {
            position: absolute; inset: 0; display: block; opacity: .55;
            background-image:
                linear-gradient(rgba(186, 198, 220, 0.28) 1px, transparent 1px),
                linear-gradient(90deg, rgba(186, 198, 220, 0.24) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse 78% 68% at 50% 42%, #000 30%, transparent 82%);
            -webkit-mask-image: radial-gradient(ellipse 78% 68% at 50% 42%, #000 30%, transparent 82%);
            animation: heroGridDrift 22s linear infinite;
        }
        @keyframes heroOrbDrift {
            0%, 100% { transform: translate3d(0, 0, 0) scale(1); }
            33% { transform: translate3d(7%, 8%, 0) scale(1.08); }
            66% { transform: translate3d(-5%, 5%, 0) scale(0.96); }
        }
        @keyframes heroBeamSweep {
            0%, 100% { transform: translate3d(-6%, 0, 0) rotate(-3deg); }
            50% { transform: translate3d(8%, 4%, 0) rotate(3deg); }
        }
        @keyframes heroGridDrift {
            0% { background-position: 0 0, 0 0; }
            100% { background-position: 40px 40px, 40px 40px; }
        }
        @keyframes heroFloat {
            0%, 100% { transform: translate3d(0, 0, 0) rotate(0deg); }
            25% { transform: translate3d(4px, -14px, 0) rotate(0.6deg); }
            50% { transform: translate3d(0, -22px, 0) rotate(0deg); }
            75% { transform: translate3d(-4px, -12px, 0) rotate(-0.6deg); }
        }
        @media (prefers-reduced-motion: reduce) {
            .hero-bg__orb, .hero-bg__grid, .hero-bg__beam, .hero-visual__stack { animation: none !important; }
        }

        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }
        .hero-eyebrow {
            display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600;
            color: #93C5FD; background: rgba(255,255,255,.06);
            border: 1px solid rgba(148, 163, 184, 0.22); padding: 7px 14px; border-radius: 30px;
            margin-bottom: 24px; backdrop-filter: blur(8px);
        }
        .hero h1,
        .hero-title {
            font-size: clamp(36px, 5vw, 56px); font-weight: 800; margin-bottom: 20px;
            line-height: 1.12; letter-spacing: -0.03em;
            color: #FFFFFF;
        }
        .hero-title__base { color: #FFFFFF; }
        .hero-title__accent {
            display: inline;
            background: linear-gradient(105deg, #FFFFFF 0%, #7DD3FC 28%, #38BDF8 55%, #818CF8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        .hero h1 .accent { color: #38BDF8; }
        .hero-desc { font-size: 18px; color: #94A3B8; margin-bottom: 32px; max-width: 52ch; }
        .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
        .hero-stats { display: flex; gap: 48px; margin-top: 48px; padding-top: 32px; border-top: 1px solid rgba(148, 163, 184, 0.18); }
        .hero-stat h3 { font-size: 28px; font-weight: 800; color: #F8FAFC; }
        .hero-stat p { font-size: 13.5px; color: #94A3B8; }

        /* Layered / tilted hero visual */
        .hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            padding: 28px 12px 36px;
        }
        .hero-visual__stack {
            position: relative;
            width: min(100%, 420px);
            animation: heroFloat 4.5s ease-in-out infinite;
        }
        .hero-visual__plate {
            position: absolute;
            inset: 18px -10px -14px 18px;
            border-radius: 24px;
            background:
                linear-gradient(145deg, rgba(37, 99, 235, 0.55), rgba(14, 165, 233, 0.2) 45%, rgba(15, 23, 42, 0.9));
            border: 1px solid rgba(96, 165, 250, 0.28);
            transform: rotate(-8deg);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.35);
            z-index: 0;
        }
        .hero-visual__ring {
            position: absolute;
            inset: -10px -18px 8px 8px;
            border-radius: 28px;
            border: 1px dashed rgba(148, 163, 184, 0.28);
            transform: rotate(5deg);
            z-index: 0;
        }
        .hero-image {
            position: relative;
            z-index: 2;
            margin: 0;
            border-radius: 22px;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.16);
            box-shadow:
                0 28px 50px rgba(0, 0, 0, 0.45),
                0 0 0 1px rgba(255, 255, 255, 0.04) inset;
            background: #0f172a;
            aspect-ratio: 4 / 5;
            max-height: 520px;
            transform: rotate(3.5deg);
        }
        .hero-image img {
            width: 100%; height: 100%; object-fit: cover; display: block;
            transform: scale(1.04);
        }
        .hero-image__shine {
            position: absolute; inset: 0; pointer-events: none;
            background: linear-gradient(125deg, rgba(255,255,255,0.22) 0%, transparent 32%, transparent 60%, rgba(255,255,255,0.06) 100%);
            mix-blend-mode: soft-light;
        }
        .hero-image__vignette {
            position: absolute; inset: 0; pointer-events: none;
            background: radial-gradient(ellipse at center, transparent 48%, rgba(2, 6, 23, 0.45) 100%);
        }
        .hero-visual__badge {
            position: absolute;
            left: -18px; bottom: 42px;
            z-index: 3;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(15, 23, 42, 0.88);
            border: 1px solid rgba(148, 163, 184, 0.22);
            backdrop-filter: blur(12px);
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.35);
            transform: rotate(-3deg);
            display: grid; gap: 2px;
        }
        .hero-visual__badge strong {
            font-size: 13px; color: #F8FAFC; font-weight: 700;
        }
        .hero-visual__badge span {
            font-size: 12px; color: #94A3B8;
        }
        .hero-visual__chip {
            position: absolute;
            right: -8px; top: 28px;
            z-index: 3;
            display: inline-flex; align-items: center; gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.92);
            color: #fff;
            font-size: 12px; font-weight: 600;
            box-shadow: 0 12px 28px rgba(37, 99, 235, 0.4);
            transform: rotate(4deg);
        }
        .hero-visual__chip-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #86EFAC;
            box-shadow: 0 0 0 4px rgba(134, 239, 172, 0.25);
            animation: heroChipPulse 1.8s ease-in-out infinite;
        }
        @keyframes heroChipPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .65; transform: scale(0.85); }
        }
        .hero-card {
            background: rgba(15, 23, 42, 0.72); border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 20px; padding: 32px; box-shadow: 0 24px 48px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px); color: #E2E8F0;
        }
        .hero-card h4 { margin-bottom: 16px; color: #F8FAFC; }
        .hero-card-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(148, 163, 184, 0.14); font-size: 14px; }
        .hero-card-row:last-child { border: none; }
        .hero-card-row .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 8px; }
        @media (max-width: 900px) {
            .hero-visual__badge { left: 8px; bottom: 24px; }
            .hero-visual__chip { right: 8px; top: 16px; }
            .hero-image { transform: rotate(2deg); }
            .hero-visual__plate { transform: rotate(-5deg); }
        }

        /* Services — bento + glassmorphism cards */
        .section-services {
            --blur-amount: 16px;
            --glass-opacity: 0.55;
            position: relative;
            padding: 100px 0 110px;
            background:
                radial-gradient(ellipse 55% 45% at 12% 20%, rgba(14, 165, 233, 0.22), transparent 58%),
                radial-gradient(ellipse 50% 40% at 88% 18%, rgba(124, 58, 237, 0.16), transparent 55%),
                radial-gradient(ellipse 45% 35% at 70% 85%, rgba(37, 99, 235, 0.14), transparent 50%),
                radial-gradient(ellipse 40% 30% at 20% 90%, rgba(16, 185, 129, 0.12), transparent 50%),
                linear-gradient(180deg, #EEF4FF 0%, #F8FAFC 45%, #FFFFFF 100%);
            overflow: hidden;
        }
        .section-services::before {
            content: '';
            position: absolute; inset: 0; pointer-events: none;
            background-image:
                linear-gradient(rgba(15, 23, 42, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, 0.04) 1px, transparent 1px);
            background-size: 56px 56px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 20%, #000 10%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 20%, #000 10%, transparent 75%);
        }
        .section-services > .container { position: relative; z-index: 1; }
        .section-intro {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 40px;
            align-items: end;
            margin-bottom: 48px;
        }
        .section-intro .section-eyebrow { margin-bottom: 14px; }
        .section-intro h2 {
            font-size: clamp(36px, 5.2vw, 54px);
            letter-spacing: -0.03em;
            max-width: 14ch;
            margin: 0;
        }
        .section-intro__copy p {
            color: var(--text-light);
            font-size: 17px;
            margin-bottom: 20px;
            max-width: 42ch;
        }
        .services-bento {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }
        /* Home services — horizontal carousel (same peek rhythm as Google reviews) */
        .section-services .t-carousel {
            margin-top: 4px;
        }
        .section-services .t-carousel__slide {
            flex: 0 0 calc(100% - 90px);
            width: calc(100% - 90px);
            scroll-snap-align: start;
            scroll-snap-stop: always;
            box-sizing: border-box;
            min-width: 0;
        }
        .section-services .t-carousel__controls,
        .services-page .t-carousel__controls {
            justify-content: flex-end;
            margin-top: 12px;
        }
        @media (min-width: 900px) {
            .section-services .t-carousel__slide,
            .services-page .t-carousel__slide {
                flex-basis: calc(48% - 6px);
                width: calc(48% - 6px);
                max-width: 400px;
            }
            .services-page .t-carousel--clients .t-carousel__slide,
            .t-carousel--clients .t-carousel__slide {
                flex: 0 0 calc((100% - 24px) / 3.5);
                width: calc((100% - 24px) / 3.5);
                max-width: none;
            }
        }
        .service-tile {
            --accent: var(--primary);
            display: flex;
            flex-direction: column;
            min-height: 280px;
            padding: 38px 28px 28px;
            border-radius: 22px;
            background:
                linear-gradient(145deg, rgba(255,255,255,0.72) 0%, rgba(255,255,255,0.38) 100%);
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow:
                0 8px 32px rgba(15, 23, 42, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(var(--blur-amount));
            -webkit-backdrop-filter: blur(var(--blur-amount));
            color: inherit;
            text-decoration: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            isolation: isolate;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease, background .28s ease;
            outline: none;
        }
        .service-tile::before {
            content: '';
            position: absolute;
            top: 12px;
            left: 14px;
            right: 14px;
            height: 7px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--accent) 0%, color-mix(in srgb, var(--accent) 55%, transparent) 55%, transparent 100%);
            opacity: .95;
            z-index: 1;
        }
        .service-tile::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            z-index: 0;
            background:
                linear-gradient(125deg, rgba(255,255,255,0.55) 0%, transparent 38%, transparent 62%, rgba(255,255,255,0.12) 100%);
            opacity: .9;
        }
        .service-tile > * { position: relative; z-index: 1; }
        .service-tile:hover,
        .service-tile:focus-visible {
            transform: translateY(-6px);
            border-color: rgba(255, 255, 255, 0.85);
            background:
                linear-gradient(145deg, rgba(255,255,255,0.82) 0%, rgba(255,255,255,0.48) 100%);
            box-shadow:
                0 22px 48px rgba(15, 23, 42, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.9),
                0 0 0 1px color-mix(in srgb, var(--accent) 18%, transparent);
        }
        .service-tile:focus-visible {
            box-shadow:
                0 0 0 3px color-mix(in srgb, var(--accent) 30%, transparent),
                0 22px 48px rgba(15, 23, 42, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
        }
        .service-tile.service-tile--mesh {
            height: 100%;
            min-height: 0;
            width: 100%;
            padding: 10px;
            border-radius: 18px;
            color: #fff;
            background: #0B1224;
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.1) inset,
                0 12px 28px rgba(2, 6, 23, 0.3);
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
        }
        .service-tile.service-tile--mesh::before {
            content: '';
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: auto;
            border-radius: inherit;
            opacity: 1;
            background:
                radial-gradient(ellipse 80% 70% at 0% 0%, color-mix(in srgb, var(--accent) 55%, transparent), transparent 55%),
                radial-gradient(ellipse 70% 60% at 100% 100%, color-mix(in srgb, var(--accent) 35%, #7C3AED), transparent 55%),
                radial-gradient(ellipse 50% 40% at 70% 20%, rgba(56, 189, 248, 0.28), transparent 60%);
            filter: blur(0);
            z-index: 0;
        }
        .service-tile.service-tile--mesh::after {
            opacity: 0.28;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 36px 36px;
            mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 15%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 80% 70% at 50% 40%, #000 15%, transparent 75%);
        }
        .service-tile.service-tile--mesh .service-tile__inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            flex: 1;
            height: 100%;
            padding: 14px 14px 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 1px 0 rgba(255, 255, 255, 0.08) inset;
            backdrop-filter: blur(14px) saturate(140%);
            -webkit-backdrop-filter: blur(14px) saturate(140%);
        }
        .service-tile.service-tile--mesh:hover,
        .service-tile.service-tile--mesh:focus-visible {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, 0.28);
            background: #0B1224;
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.14) inset,
                0 14px 32px rgba(2, 6, 23, 0.4),
                0 0 0 1px color-mix(in srgb, var(--accent) 35%, transparent);
        }
        .service-tile.service-tile--mesh .service-tile__top {
            margin-bottom: 12px;
            gap: 10px;
        }
        .service-tile.service-tile--mesh .service-tile__icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: color-mix(in srgb, var(--accent) 22%, rgba(255,255,255,0.08));
            color: #E0F2FE;
            border: 1px solid rgba(255, 255, 255, 0.16);
            box-shadow: none;
        }
        .service-tile.service-tile--mesh .service-tile__icon svg {
            width: 18px;
            height: 18px;
        }
        .service-tile.service-tile--mesh h3 {
            color: #fff;
            font-size: 18px;
            margin: 0 0 6px;
            letter-spacing: -0.03em;
            background: none;
            -webkit-text-fill-color: #fff;
        }
        .service-tile.service-tile--mesh p {
            color: rgba(226, 232, 240, 0.88);
            font-size: 13.5px;
            margin: 0 0 12px;
            line-height: 1.5;
            flex: 1;
        }
        .service-tile.service-tile--mesh .service-tile__index {
            color: rgba(191, 219, 254, 0.7);
            font-size: 12px;
        }
        .service-tile.service-tile--mesh .service-tile__link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            min-height: 34px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }
        .service-tile.service-tile--mesh .service-tile__price {
            color: rgba(226, 232, 240, 0.72);
            font-size: 12.5px;
        }
        .service-tile.service-tile--mesh .service-tile__price strong {
            color: #fff;
        }
        .service-tile.service-tile--mesh .service-tile__meta {
            align-items: center;
            gap: 10px;
            margin-top: auto;
            padding-top: 8px;
        }

        .services-page .t-carousel__slide .service-tile.service-tile--mesh {
            min-height: 228px;
        }


        .service-tile--feature {
            min-height: 280px;
            padding: 38px 28px 28px;
            background:
                radial-gradient(ellipse 90% 80% at 100% 0%, color-mix(in srgb, var(--accent) 28%, transparent), transparent 55%),
                linear-gradient(145deg, rgba(255,255,255,0.58) 0%, color-mix(in srgb, var(--accent) 12%, rgba(255,255,255,0.28)) 100%);
            border: 1px solid rgba(255, 255, 255, 0.65);
            box-shadow:
                0 16px 48px color-mix(in srgb, var(--accent) 16%, rgba(15, 23, 42, 0.1)),
                inset 0 1px 0 rgba(255, 255, 255, 0.8),
                inset 0 -1px 0 rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(20px) saturate(1.25);
            -webkit-backdrop-filter: blur(20px) saturate(1.25);
            color: inherit;
        }
        .service-tile--feature::before {
            top: 14px;
            left: 16px;
            right: 16px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--accent) 0%, color-mix(in srgb, var(--accent) 50%, transparent) 50%, transparent 100%);
            opacity: 1;
        }
        .service-tile--feature::after {
            background:
                linear-gradient(125deg, rgba(255,255,255,0.65) 0%, transparent 36%, transparent 58%, color-mix(in srgb, var(--accent) 12%, transparent) 100%);
            opacity: 1;
        }
        .service-tile--feature:hover,
        .service-tile--feature:focus-visible {
            background:
                radial-gradient(ellipse 90% 80% at 100% 0%, color-mix(in srgb, var(--accent) 34%, transparent), transparent 55%),
                linear-gradient(145deg, rgba(255,255,255,0.7) 0%, color-mix(in srgb, var(--accent) 16%, rgba(255,255,255,0.36)) 100%);
            border-color: rgba(255, 255, 255, 0.9);
            box-shadow:
                0 28px 56px color-mix(in srgb, var(--accent) 20%, rgba(15, 23, 42, 0.12)),
                inset 0 1px 0 rgba(255, 255, 255, 0.95),
                0 0 0 1px color-mix(in srgb, var(--accent) 22%, transparent);
        }
        .service-tile--feature h3 {
            color: #0F172A;
            font-size: 20px;
            max-width: none;
        }
        .service-tile--feature p {
            color: #334155;
            font-size: 14.5px;
            max-width: none;
        }
        .service-tile--feature .service-tile__link { color: var(--accent); }
        .service-tile--feature .service-tile__index { color: color-mix(in srgb, var(--accent) 45%, #94A3B8); }
        .service-tile--feature .service-tile__icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: color-mix(in srgb, var(--accent) 18%, rgba(255,255,255,0.45));
            color: var(--accent);
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.75),
                0 8px 20px color-mix(in srgb, var(--accent) 18%, transparent);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .service-tile--feature .service-tile__price { color: #64748B; }
        .service-tile--feature .service-tile__price strong { color: #0F172A; }
        .service-tile__top {
            display: flex; align-items: flex-start; justify-content: space-between;
            gap: 16px; margin-bottom: 28px;
        }
        .service-tile__icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: grid; place-items: center;
            background: color-mix(in srgb, var(--accent) 14%, rgba(255,255,255,0.55));
            color: var(--accent);
            border: 1px solid rgba(255, 255, 255, 0.55);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.65);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            flex-shrink: 0;
        }
        .service-tile__index {
            font-family: 'Inter Tight', sans-serif;
            font-size: 13px; font-weight: 700; letter-spacing: 0.08em;
            color: #94A3B8;
        }
        .service-tile h3 {
            font-size: 20px; margin: 0 0 10px; color: #0F172A;
            letter-spacing: -0.02em;
        }
        .service-tile p {
            font-size: 14.5px; color: #334155; margin: 0 0 22px;
            flex: 1;
        }
        .service-tile__meta {
            display: flex; align-items: center; justify-content: space-between; gap: 12px;
            margin-top: auto; padding-top: 8px;
        }
        .service-tile__link {
            font-size: 14px; font-weight: 600; color: var(--accent);
            display: inline-flex; align-items: center; gap: 6px;
        }
        .service-tile__link svg { transition: transform .2s ease; }
        .service-tile:hover .service-tile__link svg,
        .service-tile:focus-visible .service-tile__link svg { transform: translateX(3px); }
        .service-tile__price {
            font-size: 12.5px; color: #64748B; white-space: nowrap;
        }
        .service-tile__price strong { color: #0F172A; }
        .service-tile__art {
            position: absolute; right: -6%; bottom: -14%;
            width: min(42%, 260px); height: 68%;
            border-radius: 18px; overflow: hidden;
            opacity: .88;
            border: 1px solid rgba(255,255,255,.45);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.16);
            transform: rotate(-5deg);
            pointer-events: none;
            z-index: 0;
        }
        .service-tile__art img { width: 100%; height: 100%; object-fit: cover; }
        @media (prefers-reduced-transparency: reduce) {
            .service-tile:not(.service-tile--mesh),
            .service-tile--feature {
                background: rgba(255,255,255,0.94);
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
            .service-tile.service-tile--mesh {
                background: #0B1224;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
        }

        [data-reveal] {
            opacity: 0;
            transform: translate3d(0, 18px, 0);
            transition: opacity .55s ease, transform .55s ease;
            transition-delay: var(--reveal-delay, 0ms);
        }
        [data-reveal].is-visible {
            opacity: 1;
            transform: none;
        }
        @media (prefers-reduced-motion: reduce) {
            [data-reveal] { opacity: 1; transform: none; transition: none; }
            .service-tile:hover, .service-tile:focus-visible { transform: none; }
        }
        @media (max-width: 980px) {
            .section-intro { grid-template-columns: 1fr; gap: 18px; align-items: start; }
            .section-intro h2 { max-width: none; }
            .services-bento { grid-template-columns: 1fr; }
            .service-tile { min-height: 0; }
            .service-tile__art { display: none; }
        }
        @media (min-width: 641px) and (max-width: 980px) {
            .services-bento { grid-template-columns: repeat(2, 1fr); }
        }

        /* Legacy service cards (inner pages) */
        .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .services-grid--tiles {
            gap: 18px;
            align-items: stretch;
        }
        .services-grid--tiles .service-tile--mesh {
            min-height: 228px;
            height: auto;
        }
        .services-page .services-grid--tiles .service-tile--mesh h3 {
            /* keep solid white — override global title gradient */
            background-image: none;
            -webkit-background-clip: border-box;
            background-clip: border-box;
            color: #fff;
            -webkit-text-fill-color: #fff;
        }
        @media (max-width: 900px) {
            .services-grid--tiles { grid-template-columns: 1fr; }
        }
        @media (min-width: 641px) and (max-width: 900px) {
            .services-grid--tiles { grid-template-columns: repeat(2, 1fr); }
        }
        .service-card { background: var(--bg); border: 1px solid var(--border); border-radius: 18px; padding: 32px; transition: all .25s; cursor: pointer; position: relative; }
        .service-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); border-color: var(--primary); }
        .service-icon { width: 52px; height: 52px; border-radius: 13px; background: var(--primary-light); color: var(--primary); display: grid; place-items: center; margin-bottom: 20px; }
        .service-card h3 { font-size: 19px; margin-bottom: 10px; }
        .service-card p { font-size: 14.5px; color: var(--text-light); margin-bottom: 18px; }
        .service-link { font-size: 14px; font-weight: 600; color: var(--primary); display: inline-flex; align-items: center; gap: 6px; }
        .service-price { font-size: 13px; color: var(--text-muted); margin-top: 12px; }
        .service-price strong { color: var(--dark); }

        /* Portfolio */
        .portfolio-filter { display: flex; justify-content: flex-end; gap: 8px; flex-wrap: wrap; }
        .filter-btn {
            padding: 9px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            background: #fff;
            color: var(--text-light);
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: border-color .2s, background .2s, color .2s, transform .2s;
            text-decoration: none;
        }
        .filter-btn.active, .filter-btn:hover {
            border-color: #1E3A8A;
            background: linear-gradient(145deg, #2563EB 0%, #1D4ED8 55%, #1E3A8A 100%);
            color: #fff;
        }
        .filter-btn:focus-visible {
            outline: 3px solid color-mix(in srgb, var(--primary) 40%, transparent);
            outline-offset: 2px;
        }
        .portfolio-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .project-card {
            border-radius: 16px;
            overflow: hidden;
            border: 1.5px solid #CBD5E1;
            background: var(--bg);
            box-shadow:
                0 4px 6px -1px rgba(15, 23, 42, 0.08),
                0 10px 24px -4px rgba(15, 23, 42, 0.12);
            transition: border-color .25s, box-shadow .25s, transform .25s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .project-card:hover {
            border-color: #94A3B8;
            box-shadow:
                0 10px 15px -3px rgba(15, 23, 42, 0.12),
                0 20px 40px -8px rgba(15, 23, 42, 0.18);
            transform: translateY(-4px);
        }
        .project-card:focus-visible {
            outline: 3px solid color-mix(in srgb, var(--primary) 45%, transparent);
            outline-offset: 3px;
        }
        .project-thumb { position: relative; height: 230px; overflow: hidden; background: var(--bg-soft); }
        .project-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
        .project-card:hover .project-thumb img { transform: scale(1.06); }
        .project-body { padding: 22px; }
        .project-cat { font-size: 12px; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.06em; }
        .project-body h3 { font-size: 18px; margin: 8px 0; color: var(--dark); }
        .project-body p { font-size: 14px; color: var(--text-light); }

        /* Portfolio page — elevated layout */
        .portfolio-page {
            overflow-x: clip;
            max-width: 100%;
        }
        .portfolio-page .page-hero.pf-hero {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            background: linear-gradient(145deg, #0B1220 0%, #111827 45%, #0F172A 100%);
            color: #fff;
            text-align: left;
            padding: 88px 0 72px;
            max-width: 100%;
            box-sizing: border-box;
        }
        .portfolio-page .page-hero.pf-hero .container {
            position: relative;
            z-index: 1;
        }
        .portfolio-page .page-hero h1 {
            background-image: linear-gradient(115deg, #fff 0%, #E0F2FE 40%, #BFDBFE 70%, #F5F3FF 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            font-size: clamp(34px, 4.6vw, 50px);
            line-height: 1.12;
            margin-bottom: 18px;
        }
        .portfolio-page .page-hero .btn-primary {
            background: #FBBF24;
            border-color: #FBBF24;
            color: #0f172a;
        }
        .portfolio-page .page-hero .btn-primary:hover {
            background: #F59E0B;
            border-color: #F59E0B;
            color: #0f172a;
        }
        .pf-hero-meta {
            display: flex;
            gap: 28px;
            margin: 22px 0 4px;
        }
        .pf-hero-meta__item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .pf-hero-meta__item strong {
            font-family: 'Inter Tight', sans-serif;
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #fff;
            line-height: 1;
        }
        .pf-hero-meta__item span {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: rgba(191, 219, 254, 0.85);
        }
        .pf-hero-visual {
            gap: 28px;
        }
        .pf-hero-stack {
            position: relative;
            height: 240px;
            margin-bottom: 0;
        }
        .pf-hero-stack__card {
            position: absolute;
            inset: 0 auto auto 0;
            width: 78%;
            height: 180px;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 18px 40px rgba(2, 6, 23, 0.45);
            background: #1e293b;
        }
        .pf-hero-stack__card img,
        .pf-hero-stack__placeholder {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .pf-hero-stack__placeholder {
            background: linear-gradient(135deg, #1e3a8a, #0ea5e9);
        }
        .pf-hero-stack__card--1 {
            z-index: 3;
            transform: rotate(-2deg) translate(0, 8px);
            animation: pfStackFloat 7s ease-in-out infinite alternate;
        }
        .pf-hero-stack__card--2 {
            z-index: 2;
            width: 72%;
            left: 18%;
            top: 18px;
            transform: rotate(3deg);
            opacity: 0.92;
            animation: pfStackFloat 9s ease-in-out infinite alternate-reverse;
        }
        .pf-hero-stack__card--3 {
            z-index: 1;
            width: 66%;
            left: 28%;
            top: 36px;
            transform: rotate(-4deg);
            opacity: 0.78;
            animation: pfStackFloat 8s ease-in-out infinite alternate;
        }
        @keyframes pfStackFloat {
            from { translate: 0 0; }
            to { translate: 0 -8px; }
        }
        .pf-gallery {
            padding-top: 56px;
        }
        .pf-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 36px;
            flex-wrap: wrap;
        }
        .pf-toolbar__copy {
            flex: 1 1 240px;
            min-width: 0;
        }
        .pf-toolbar__copy h2 {
            font-size: clamp(26px, 3.4vw, 36px);
            margin: 0 0 8px;
        }
        .pf-toolbar__copy p {
            margin: 0;
            color: var(--text-light);
            font-size: 15px;
            max-width: 42ch;
        }
        .portfolio-page .portfolio-filter {
            flex: 1 1 320px;
            justify-content: flex-end;
            margin-bottom: 0;
        }
        .portfolio-page .portfolio-grid--showcase .project-card:first-child {
            grid-column: span 2;
        }
        .portfolio-page .portfolio-grid--showcase .project-card:first-child .project-thumb {
            height: 460px;
        }
        .portfolio-page .project-card--rich .project-thumb {
            height: 320px;
        }
        .project-thumb__empty {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: rgba(226, 232, 240, 0.9);
            background:
                radial-gradient(ellipse 80% 70% at 20% 20%, rgba(59, 130, 246, 0.55), transparent 55%),
                radial-gradient(ellipse 70% 60% at 90% 80%, rgba(14, 165, 233, 0.35), transparent 50%),
                linear-gradient(145deg, #0F172A, #1E3A8A);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .project-thumb__shade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0.55) 100%);
            opacity: 0.85;
            transition: opacity .3s;
            pointer-events: none;
        }
        .project-card--rich:hover .project-thumb__shade {
            opacity: 1;
        }
        .project-thumb__top {
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            z-index: 1;
        }
        .project-card--rich .project-cat {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.92);
            color: #1E3A8A;
            font-size: 11px;
            letter-spacing: 0.05em;
            backdrop-filter: blur(8px);
        }
        .project-badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 8px;
            background: rgba(251, 191, 36, 0.95);
            color: #0f172a;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .project-thumb__cta {
            position: absolute;
            left: 16px;
            bottom: 16px;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            opacity: 0;
            transform: translateY(8px);
            transition: opacity .25s, transform .25s;
        }
        .project-thumb__cta svg {
            width: 16px;
            height: 16px;
        }
        .project-card--rich:hover .project-thumb__cta {
            opacity: 1;
            transform: translateY(0);
        }
        .project-card--rich .project-body h3 {
            margin: 0 0 6px;
            font-size: 19px;
            letter-spacing: -0.02em;
        }
        .project-client {
            font-size: 12.5px !important;
            font-weight: 600;
            color: #64748B !important;
            margin: 0 0 8px !important;
        }
        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 14px;
        }
        .project-tech span {
            font-size: 11.5px;
            font-weight: 600;
            color: #334155;
            background: #F1F5F9;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 4px 9px;
        }
        .pf-empty {
            grid-column: 1 / -1;
            text-align: center;
            padding: 72px 24px;
            border: 1.5px dashed #CBD5E1;
            border-radius: 18px;
            background: linear-gradient(180deg, #F8FAFC, #fff);
        }
        .pf-empty__icon {
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: #EFF6FF;
            color: #1D4ED8;
        }
        .pf-empty__icon svg {
            width: 28px;
            height: 28px;
        }
        .pf-empty h3 {
            font-size: 20px;
            margin: 0 0 8px;
            color: var(--dark);
        }
        .pf-empty p {
            color: var(--text-light);
            margin: 0 0 20px;
        }
        .portfolio-page .pf-hire {
            margin-top: 8px;
        }
        @media (prefers-reduced-motion: reduce) {
            .pf-hero-stack__card {
                animation: none !important;
            }
            .project-card--rich:hover .project-thumb__cta {
                opacity: 1;
                transform: none;
            }
        }
        @media (max-width: 900px) {
            .portfolio-page .portfolio-grid--showcase .project-card:first-child {
                grid-column: auto;
            }
            .portfolio-page .portfolio-grid--showcase .project-card:first-child .project-thumb,
            .portfolio-page .project-card--rich .project-thumb {
                height: 300px;
            }
            .pf-toolbar {
                align-items: stretch;
            }
            .portfolio-page .portfolio-filter {
                justify-content: flex-start;
            }
            .pf-hero-stack {
                height: 230px;
            }
            .pf-hero-visual {
                gap: 32px;
            }
        }

        /* Google Reviews–style carousel */
        .testimonial-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; }
        .g-reviews {
            --g-star: #FABB05;
            --g-card: #fff;
            --g-muted: #5F6368;
            --g-text: #202124;
            --g-border: #E8EAED;
            --g-surface: #F8F9FA;
        }
        .section.g-reviews {
            background: var(--g-surface);
        }
        .g-reviews__head {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px 24px;
            margin-bottom: 28px;
        }
        .g-reviews__brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .g-reviews__logo {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }
        .g-reviews__brand h2 {
            font-size: clamp(28px, 4vw, 36px);
            margin: 0 0 4px;
            letter-spacing: -0.02em;
        }
        .g-reviews__meta {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--g-muted);
            font-size: 14px;
        }
        .g-reviews__score {
            font-weight: 700;
            color: var(--g-text);
            font-size: 16px;
        }
        .g-reviews__stars-inline {
            display: inline-flex;
            gap: 2px;
            color: var(--g-star);
        }
        .g-reviews__stars-inline svg {
            width: 16px;
            height: 16px;
        }
        .t-carousel { position: relative; }
        .t-carousel__viewport {
            overflow: hidden;
            margin-inline: -4px;
        }
        .t-carousel__track {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 4px 4px 8px;
        }
        .t-carousel__track::-webkit-scrollbar { display: none; }
        /* Nearly full card + peek of next (~90px) */
        .t-carousel__slide {
            flex: 0 0 calc(100% - 90px);
            width: calc(100% - 90px);
            scroll-snap-align: start;
            scroll-snap-stop: always;
            box-sizing: border-box;
            min-width: 0;
        }
        @media (min-width: 900px) {
            .t-carousel__slide {
                flex-basis: calc(45% - 6px);
                width: calc(45% - 6px);
                max-width: 380px;
            }
        }
        .g-review-card {
            background: var(--g-card);
            border: 1px solid var(--g-border);
            border-radius: 12px;
            padding: 16px;
            height: 100%;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 2px rgba(60, 64, 67, 0.08), 0 1px 3px 1px rgba(60, 64, 67, 0.06);
            transition: box-shadow .2s ease;
        }
        .g-review-card:hover {
            box-shadow: 0 1px 3px rgba(60, 64, 67, 0.12), 0 4px 8px 3px rgba(60, 64, 67, 0.08);
        }
        .g-review-card__top {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
        }
        .g-review-card__avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
            background: #E8F0FE;
            color: #1A73E8;
            display: grid;
            place-items: center;
            font-weight: 600;
            font-size: 14px;
        }
        .g-review-card__who {
            flex: 1;
            min-width: 0;
        }
        .g-review-card__who h4 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: var(--g-text);
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .g-review-card__who p {
            margin: 2px 0 0;
            font-size: 12px;
            color: var(--g-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .g-review-card__g {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .g-review-card__stars {
            display: flex;
            gap: 2px;
            color: var(--g-star);
            margin-bottom: 10px;
        }
        .g-review-card__stars svg {
            width: 14px;
            height: 14px;
        }
        .g-review-card__stars svg.is-empty {
            color: #DADCE0;
        }
        .g-review-card__body {
            margin: 0;
            font-size: 14px;
            line-height: 1.5;
            color: var(--g-text);
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }
        .g-review-card__source {
            margin-top: 12px;
            font-size: 12px;
            color: var(--g-muted);
        }
        .t-carousel__controls {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 12px;
        }
        .t-carousel__btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--g-border);
            background: #fff;
            color: #3C4043;
            display: grid;
            place-items: center;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(60, 64, 67, 0.1);
            transition: background .15s ease, box-shadow .15s ease;
        }
        .t-carousel__btn svg { width: 18px; height: 18px; display: block; }
        .t-carousel__btn:hover {
            background: #F8F9FA;
            box-shadow: 0 1px 3px rgba(60, 64, 67, 0.15);
        }
        .t-carousel__btn:active { background: #F1F3F4; }
        .t-carousel__btn:focus-visible {
            outline: 2px solid #1A73E8;
            outline-offset: 2px;
        }
        .t-carousel__btn:disabled {
            opacity: 0.35;
            cursor: default;
        }
        .t-carousel__dots {
            display: none;
        }
        .t-carousel__pause {
            display: none;
        }
        .t-carousel__status {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
        @media (prefers-reduced-motion: reduce) {
            .t-carousel__track { scroll-behavior: auto; }
            .g-review-card { transition: none; }
        }

        /* Clients logos */
        .clients-row { display: flex; align-items: center; justify-content: center; gap: 44px; flex-wrap: wrap; }
        .client-logo { font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 22px; color: var(--text-muted); opacity: .7; transition: all .2s; display: flex; align-items: center; gap: 8px; }
        .client-logo:hover { opacity: 1; color: var(--dark); }

        /* CTA — mesh/aurora glass (same pattern as .svc-hire) */
        .cta-banner {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            border-radius: 28px;
            padding: 48px 28px;
            text-align: center;
            color: #fff;
            background: #0B1224;
        }
        .cta-banner__glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(64px);
            pointer-events: none;
            z-index: 0;
            will-change: transform;
        }
        .cta-banner__glow--a {
            width: min(70%, 360px);
            height: min(70%, 360px);
            top: -28%;
            left: -12%;
            background: rgba(37, 99, 235, 0.55);
            animation: svc-hire-drift 14s ease-in-out infinite alternate;
        }
        .cta-banner__glow--b {
            width: min(60%, 300px);
            height: min(60%, 300px);
            right: -10%;
            bottom: -30%;
            background: rgba(124, 58, 237, 0.45);
            animation: svc-hire-drift 18s ease-in-out infinite alternate-reverse;
        }
        .cta-banner__glow--c {
            width: min(40%, 200px);
            height: min(40%, 200px);
            left: 42%;
            top: 40%;
            background: rgba(56, 189, 248, 0.28);
            animation: svc-hire-drift 11s ease-in-out infinite alternate;
        }
        .cta-banner__grid {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: 0.35;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 45%, #000 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 45%, #000 20%, transparent 75%);
        }
        .cta-banner__inner {
            position: relative;
            z-index: 2;
            max-width: 640px;
            margin: 0 auto;
            padding: 36px 24px;
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.1) inset,
                0 24px 64px rgba(2, 6, 23, 0.35);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
        }
        .cta-banner__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 16px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #BFDBFE;
            background: rgba(59, 130, 246, 0.18);
            border: 1px solid rgba(147, 197, 253, 0.28);
        }
        .cta-banner__eyebrow::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #60A5FA;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        }
        .cta-banner h2 {
            background-image: none;
            -webkit-background-clip: border-box;
            background-clip: border-box;
            color: #fff;
            -webkit-text-fill-color: #fff;
            font-size: clamp(26px, 4vw, 38px);
            margin: 0 0 12px;
            line-height: 1.15;
            letter-spacing: -0.03em;
            text-wrap: balance;
        }
        .cta-banner p {
            color: rgba(226, 232, 240, 0.88);
            font-size: 16.5px;
            margin: 0 auto 28px;
            max-width: 42ch;
            line-height: 1.65;
        }
        .cta-banner__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }
        .cta-banner .btn,
        .cta-banner .btn-light,
        .cta-banner .btn-primary {
            gap: 8px;
        }
        .cta-banner .btn svg {
            width: 18px;
            height: 18px;
            transition: transform .2s ease;
            position: relative;
            z-index: 2;
        }
        .cta-banner .btn:hover svg {
            transform: translateX(3px);
        }
        @media (prefers-reduced-motion: reduce) {
            .cta-banner__glow {
                animation: none;
            }
            .cta-banner .btn:hover,
            .cta-banner .btn:hover svg {
                transform: none;
            }
        }
        @media (max-width: 768px) {
            :root {
                --page-gutter: 16px;
            }
            .cta-banner {
                padding: 16px 0;
                border-radius: 22px;
            }
            .cta-banner__inner {
                padding: 28px 20px;
                border-radius: 18px;
            }
            .cta-banner p {
                font-size: 15.5px;
            }
            .cta-banner__actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Footer */
        .footer { background: var(--dark); color: var(--text-muted); padding-top: 70px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; padding-bottom: 40px; }
        .footer h4 { color: #fff; font-size: 15px; margin-bottom: 16px; }
        .footer a { color: var(--text-muted); font-size: 14px; display: block; margin-bottom: 10px; transition: color .2s; }
        .footer a:hover { color: #fff; }
        .footer-logo { display: flex; align-items: center; gap: 10px; font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 20px; color: #fff; margin-bottom: 14px; }
        .footer-about { font-size: 14px; line-height: 1.6; margin-bottom: 20px; max-width: 36ch; color: rgba(255,255,255,.62); }
        .footer-social, .social-links { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; }
        .social-btn {
            width: 44px; height: 44px; min-width: 44px; min-height: 44px;
            border-radius: 50%;
            display: grid !important; place-items: center;
            margin: 0 !important;
            color: #fff !important;
            border: 1px solid transparent;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease, background-color .2s ease, border-color .2s ease;
        }
        .social-btn svg { width: 18px; height: 18px; display: block; pointer-events: none; }
        .social-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18); filter: brightness(1.06); }
        .social-btn:focus-visible { outline: 2px solid #fff; outline-offset: 3px; }
        .social-btn--facebook { background: #1877F2; }
        .social-btn--instagram {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .social-btn--linkedin { background: #0A66C2; }
        .social-btn--x { background: #000; }
        .social-btn--github { background: #24292F; }
        .footer .social-btn {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.14);
            box-shadow: none;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .footer .social-btn--facebook { color: #4C9AFF !important; }
        .footer .social-btn--instagram { color: #FF7AB8 !important; background: rgba(255, 255, 255, 0.08); }
        .footer .social-btn--linkedin { color: #5BAAF5 !important; }
        .footer .social-btn--x { color: #F3F4F6 !important; }
        .footer .social-btn--github { color: #E5E7EB !important; }
        .footer .social-btn:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(255, 255, 255, 0.28);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.28);
            filter: none;
            transform: translateY(-2px);
        }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding: 22px 0; font-size: 13px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }


        /* Services page — irekasoft-style extras */
        .services-page .svc-section-head h2 {
            font-size: clamp(30px, 4vw, 40px);
        }
        .services-page .page-hero.svc-hero {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            background: linear-gradient(145deg, #0B1220 0%, #111827 45%, #0F172A 100%);
            color: #fff;
            text-align: left;
            padding: 88px 0 72px;
            max-width: 100%;
            box-sizing: border-box;
        }
        .services-page {
            overflow-x: clip;
            max-width: 100%;
        }
        .services-page .page-hero.svc-hero .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        .svc-hero-bg {
            position: absolute;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }
        .svc-hero-bg__orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            opacity: .55;
            animation: svcHeroOrb 14s ease-in-out infinite alternate;
        }
        .svc-hero-bg__orb--1 {
            width: 420px; height: 420px;
            top: -120px; left: -80px;
            background: radial-gradient(circle, rgba(59,130,246,.55), transparent 70%);
        }
        .svc-hero-bg__orb--2 {
            width: 360px; height: 360px;
            right: -60px; top: 18%;
            background: radial-gradient(circle, rgba(124,58,237,.42), transparent 70%);
            animation-delay: -4s;
        }
        .svc-hero-bg__orb--3 {
            width: 480px; height: 480px;
            left: 35%; bottom: -220px;
            background: radial-gradient(circle, rgba(14,165,233,.28), transparent 70%);
            animation-delay: -7s;
        }
        .svc-hero-bg__grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(148,163,184,.11) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148,163,184,.11) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse at 40% 30%, #000 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at 40% 30%, #000 20%, transparent 75%);
            opacity: .55;
        }
        .svc-hero-bg__dots {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(148,163,184,.28) 1.1px, transparent 1.1px);
            background-size: 22px 22px;
            opacity: .35;
            mask-image: linear-gradient(180deg, #000 0%, transparent 85%);
            -webkit-mask-image: linear-gradient(180deg, #000 0%, transparent 85%);
        }
        .svc-hero-bg__beam {
            position: absolute;
            top: -20%;
            right: 8%;
            width: 280px;
            height: 140%;
            background: linear-gradient(180deg, transparent, rgba(96,165,250,.12), transparent);
            transform: rotate(18deg);
            filter: blur(8px);
            animation: svcHeroBeam 10s ease-in-out infinite alternate;
        }
        @keyframes svcHeroOrb {
            from { transform: translate3d(0,0,0) scale(1); }
            to { transform: translate3d(18px, -14px, 0) scale(1.08); }
        }
        @keyframes svcHeroBeam {
            from { opacity: .45; transform: rotate(18deg) translateY(0); }
            to { opacity: .8; transform: rotate(18deg) translateY(24px); }
        }
        @media (prefers-reduced-motion: reduce) {
            .svc-hero-bg__orb, .svc-hero-bg__beam { animation: none !important; }
        }
        .svc-hero-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 48px;
            align-items: center;
        }
        .services-page .page-hero h1 {
            background-image: none;
            -webkit-background-clip: border-box;
            background-clip: border-box;
            color: #fff;
            -webkit-text-fill-color: #fff;
            font-size: clamp(34px, 4.6vw, 50px);
            line-height: 1.12;
            margin-bottom: 18px;
            white-space: pre-line;
        }
        .svc-kicker {
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #93C5FD;
            margin-bottom: 14px;
        }
        .svc-hero-lead {
            color: rgba(255,255,255,.82) !important;
            font-size: 16.5px;
            line-height: 1.7;
            max-width: 54ch !important;
            margin: 0 0 12px !important;
            text-align: left !important;
        }
        .svc-hero-copy .svc-hero-note { margin: 18px 0 0; }
        .svc-hero-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 22px; }
        .services-page .page-hero .btn-primary {
            background: #FBBF24;
            border-color: #FBBF24;
            color: #0f172a;
        }
        .services-page .page-hero .btn-primary:hover {
            background: #F59E0B;
            border-color: #F59E0B;
            color: #0f172a;
        }
        .svc-hero-visual {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .svc-hero-note {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            margin: 0;
            padding: 16px 18px;
            border-radius: 14px;
            background: rgba(15,23,42,.45);
            border: 1px solid rgba(251,191,36,.55);
            box-shadow: 0 0 0 1px rgba(255,255,255,.04) inset;
        }
        .svc-hero-note__icon { font-size: 18px; line-height: 1.4; }
        .svc-hero-note p {
            margin: 0 !important;
            color: rgba(255,255,255,.9) !important;
            font-size: 14.5px;
            line-height: 1.65;
            max-width: none !important;
            text-align: left !important;
        }
        .svc-hero-panel {
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 20px;
            padding: 22px;
            backdrop-filter: blur(10px);
            box-shadow:
                0 20px 50px rgba(0,0,0,.28),
                0 0 0 1px rgba(255,255,255,.04) inset;
            transform-origin: 50% 0%;
            will-change: transform;
            animation: svc-hero-hang 5.2s ease-in-out infinite;
        }
        @keyframes svc-hero-hang {
            0%, 100% {
                transform: translate3d(0, 0, 0) rotate(0deg);
            }
            20% {
                transform: translate3d(3px, -10px, 0) rotate(0.7deg);
            }
            45% {
                transform: translate3d(-2px, -18px, 0) rotate(-0.45deg);
            }
            70% {
                transform: translate3d(2px, -8px, 0) rotate(0.35deg);
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .svc-hero-panel {
                animation: none;
                will-change: auto;
            }
        }
        .svc-hero-panel__head {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 600;
            color: #BFDBFE;
            margin-bottom: 16px;
        }
        .svc-hero-panel__dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #34D399;
            box-shadow: 0 0 0 4px rgba(52,211,153,.2);
        }
        .svc-hero-panel__list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .svc-hero-panel__list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(15,23,42,.35);
            border: 1px solid rgba(255,255,255,.08);
            color: #F8FAFC;
            font-size: 14.5px;
            font-weight: 600;
        }
        .svc-hero-panel__list strong {
            font-family: 'Inter Tight', sans-serif;
            font-size: 12px;
            letter-spacing: .08em;
            color: #93C5FD;
            min-width: 28px;
        }
        .svc-hero-panel__tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }
        .svc-hero-panel__tags span {
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            color: #E2E8F0;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.1);
        }


        .svc-timeline {
            position: relative;
            max-width: 920px;
            margin: 0 auto;
            padding: 12px 0 8px;
        }
        .svc-timeline::before {
            content: "";
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 0;
            border-left: 2px dashed #93C5FD;
            transform: translateX(-50%);
        }
        .svc-timeline__row {
            display: grid;
            grid-template-columns: 1fr 64px 1fr;
            gap: 22px;
            align-items: center;
            margin-bottom: 40px;
        }
        .svc-timeline__row:last-child { margin-bottom: 0; }
        .svc-timeline__node {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: linear-gradient(145deg, #2563EB 0%, #1D4ED8 55%, #1E3A8A 100%);
            border: 3px solid #EFF6FF;
            box-shadow:
                0 0 0 6px rgba(30, 58, 138, 0.12),
                0 10px 24px rgba(30, 58, 138, 0.28);
            justify-self: center;
            z-index: 1;
            display: grid;
            place-items: center;
            color: #fff;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .svc-timeline__node svg {
            width: 26px;
            height: 26px;
            display: block;
        }
        .svc-timeline__row:hover .svc-timeline__node {
            transform: translateY(-2px) scale(1.04);
            box-shadow:
                0 0 0 8px rgba(30, 58, 138, 0.16),
                0 14px 30px rgba(30, 58, 138, 0.34);
        }
        .svc-timeline__content {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 8px 24px rgba(15,23,42,.06);
        }
        .svc-timeline__head {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }
        .svc-timeline__num {
            display: none;
        }
        .svc-timeline__chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--primary);
            background: var(--primary-light);
            border: 1px solid color-mix(in srgb, var(--primary) 18%, transparent);
        }
        .svc-timeline__content h3 {
            font-size: 18px;
            margin: 0 0 8px;
            color: var(--dark);
        }
        .svc-timeline__content p {
            margin: 0;
            font-size: 14.5px;
            color: var(--text-light);
            line-height: 1.65;
        }
        .svc-timeline__row--left .svc-timeline__content { grid-column: 1; grid-row: 1; text-align: right; }
        .svc-timeline__row--left .svc-timeline__node { grid-column: 2; grid-row: 1; }
        .svc-timeline__row--left .svc-timeline__spacer { grid-column: 3; grid-row: 1; }
        .svc-timeline__row--right .svc-timeline__spacer { grid-column: 1; grid-row: 1; }
        .svc-timeline__row--right .svc-timeline__node { grid-column: 2; grid-row: 1; }
        .svc-timeline__row--right .svc-timeline__content { grid-column: 3; grid-row: 1; text-align: left; }

        .svc-tech-grid {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px 14px;
            max-width: 960px;
            margin-inline: auto;
        }
        .svc-tech-grid li {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
        }
        .svc-tech-grid__icon {
            width: 120px;
            height: 120px;
            border-radius: 28px;
            background: #fff;
            border: 1px solid var(--border);
            display: grid;
            place-items: center;
            padding: 18px;
            box-shadow: 0 10px 28px rgba(15,23,42,.07);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .svc-tech-grid__icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 34px rgba(15,23,42,.12);
        }
        .svc-tech-grid__icon img {
            width: 100%;
            height: 100%;
            max-width: 72px;
            max-height: 72px;
            object-fit: contain;
            display: block;
        }
        .svc-tech-grid__icon span {
            font-family: 'Inter Tight', sans-serif;
            font-weight: 800;
            font-size: 36px;
            color: var(--primary);
        }
        .svc-tech-grid__label {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
        }

        .svc-quote-band {
            position: relative;
            padding: 88px 0;
            background:
                radial-gradient(ellipse at 50% 0%, rgba(124,58,237,.35), transparent 55%),
                radial-gradient(ellipse at 80% 100%, rgba(37,99,235,.25), transparent 45%),
                #0B1220;
            overflow: hidden;
        }
        .svc-quote-band::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(148,163,184,.08) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(148,163,184,.08) 1px, transparent 1px);
            background-size: 28px 28px;
            opacity: .35;
            pointer-events: none;
        }
        .svc-quote-band blockquote {
            position: relative;
            margin: 0 auto;
            max-width: 760px;
            text-align: center;
            border: 0;
            padding: 0;
        }
        .svc-quote-band p {
            margin: 0;
            font-family: Georgia, 'Times New Roman', serif;
            font-style: italic;
            font-size: clamp(22px, 3vw, 34px);
            line-height: 1.45;
            color: #F8FAFC;
            font-weight: 500;
        }

        .svc-clients .client-logo {
            min-width: 110px;
            justify-content: center;
        }

        /* Clients carousel — 3.5 logos visible (peek next) */
        .t-carousel--clients .t-carousel__track {
            gap: 12px;
        }
        .t-carousel--clients .t-carousel__slide {
            flex: 0 0 calc((100% - 24px) / 3.5);
            width: calc((100% - 24px) / 3.5);
            max-width: none;
        }
        .t-carousel--clients .client-logo--card {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 88px;
            padding: 16px 12px;
            border-radius: 0;
            background: transparent;
            border: none;
            box-shadow: none;
            opacity: 1;
            color: var(--dark);
        }
        .t-carousel--clients .client-logo--card img {
            width: auto;
            max-width: 100%;
            height: 40px;
            object-fit: contain;
            filter: grayscale(1);
            opacity: 0.78;
            transition: filter .2s ease, opacity .2s ease;
        }
        .t-carousel--clients .client-logo--card:hover img {
            filter: grayscale(0);
            opacity: 1;
        }
        .t-carousel--clients .client-logo__fallback {
            font-family: 'Inter Tight', sans-serif;
            font-weight: 800;
            font-size: 20px;
            letter-spacing: 0.04em;
            color: var(--text-muted);
        }
        .t-carousel--clients .t-carousel__controls {
            justify-content: flex-end;
            margin-top: 14px;
        }
        @media (max-width: 768px) {
            .t-carousel--clients .t-carousel__slide {
                flex: 0 0 calc((100% - 18px) / 3.5);
                width: calc((100% - 18px) / 3.5);
            }
            .t-carousel--clients .t-carousel__track {
                gap: 9px;
            }
            .t-carousel--clients .client-logo--card {
                min-height: 76px;
                padding: 12px 8px;
                border-radius: 0;
                background: transparent;
                border: none;
                box-shadow: none;
            }
            .t-carousel--clients .client-logo--card img {
                height: 32px;
            }
        }

        .svc-hire {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            padding: 88px 0;
            color: #fff;
            background: #0B1224;
        }
        .svc-hire__glow {
            position: absolute;
            border-radius: 50%;
            filter: blur(64px);
            pointer-events: none;
            z-index: 0;
            will-change: transform;
        }
        .svc-hire__glow--a {
            width: min(70vw, 420px);
            height: min(70vw, 420px);
            top: -18%;
            left: -12%;
            background: rgba(37, 99, 235, 0.55);
            animation: svc-hire-drift 14s ease-in-out infinite alternate;
        }
        .svc-hire__glow--b {
            width: min(60vw, 360px);
            height: min(60vw, 360px);
            right: -10%;
            bottom: -22%;
            background: rgba(124, 58, 237, 0.45);
            animation: svc-hire-drift 18s ease-in-out infinite alternate-reverse;
        }
        .svc-hire__glow--c {
            width: min(40vw, 240px);
            height: min(40vw, 240px);
            left: 42%;
            top: 38%;
            background: rgba(56, 189, 248, 0.28);
            animation: svc-hire-drift 11s ease-in-out infinite alternate;
        }
        .svc-hire__grid {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            opacity: 0.35;
            background-image:
                linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 70% 60% at 50% 45%, #000 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse 70% 60% at 50% 45%, #000 20%, transparent 75%);
        }
        .svc-hire > .container {
            position: relative;
            z-index: 2;
        }
        .svc-hire__inner {
            max-width: 640px;
            margin: 0 auto;
            text-align: center;
            padding: 40px 28px;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow:
                0 1px 0 rgba(255, 255, 255, 0.1) inset,
                0 24px 64px rgba(2, 6, 23, 0.35);
            backdrop-filter: blur(18px) saturate(140%);
            -webkit-backdrop-filter: blur(18px) saturate(140%);
        }
        .svc-hire__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 18px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #BFDBFE;
            background: rgba(59, 130, 246, 0.18);
            border: 1px solid rgba(147, 197, 253, 0.28);
        }
        .svc-hire__eyebrow::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #60A5FA;
            box-shadow: 0 0 0 4px rgba(96, 165, 250, 0.2);
        }
        .svc-hire h2 {
            background-image: linear-gradient(
                115deg,
                #ffffff 0%,
                #E0F2FE 28%,
                #BFDBFE 52%,
                #C7D2FE 72%,
                #F5F3FF 100%
            );
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
            font-size: clamp(26px, 4vw, 38px);
            margin: 0 0 14px;
            line-height: 1.15;
            letter-spacing: -0.03em;
            text-wrap: balance;
        }
        .svc-hire p {
            color: rgba(226, 232, 240, 0.88);
            font-size: 16.5px;
            margin: 0 auto 28px;
            max-width: 42ch;
            line-height: 1.65;
        }
        .svc-hire__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }
        .svc-hire .btn-primary {
            gap: 8px;
        }
        .svc-hire .btn-primary svg {
            width: 18px;
            height: 18px;
            transition: transform .2s ease;
            position: relative;
            z-index: 2;
        }
        .svc-hire .btn-primary:hover svg {
            transform: translateX(3px);
        }
        @keyframes svc-hire-drift {
            from { transform: translate(0, 0) scale(1); }
            to { transform: translate(24px, -18px) scale(1.08); }
        }
        @media (prefers-reduced-motion: reduce) {
            .svc-hire__glow {
                animation: none;
            }
            .svc-hire .btn-primary:hover,
            .svc-hire .btn-primary:hover svg {
                transform: none;
            }
        }
        @media (max-width: 768px) {
            .svc-hire {
                padding: 56px 0;
            }
            .svc-hire__inner {
                padding: 28px 20px;
                border-radius: 22px;
            }
            .svc-hire p {
                font-size: 15.5px;
            }
            .svc-hire__actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 900px) {
            /* Service Flow — mobile journey rail + glass steps */
            .svc-flow {
                position: relative;
                overflow: hidden;
                background:
                    radial-gradient(ellipse 70% 45% at 8% 12%, rgba(37, 99, 235, 0.16), transparent 55%),
                    radial-gradient(ellipse 60% 40% at 92% 8%, rgba(124, 58, 237, 0.14), transparent 50%),
                    radial-gradient(ellipse 50% 35% at 70% 90%, rgba(14, 165, 233, 0.12), transparent 55%),
                    linear-gradient(180deg, #EEF4FF 0%, #F8FAFC 48%, #FFFFFF 100%);
                padding: 48px 0 56px;
            }
            .svc-flow::before {
                content: '';
                position: absolute;
                inset: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(15, 23, 42, 0.035) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(15, 23, 42, 0.035) 1px, transparent 1px);
                background-size: 40px 40px;
                mask-image: radial-gradient(ellipse 75% 55% at 50% 20%, #000 15%, transparent 75%);
                -webkit-mask-image: radial-gradient(ellipse 75% 55% at 50% 20%, #000 15%, transparent 75%);
                opacity: 0.9;
            }
            .svc-flow > .container {
                position: relative;
                z-index: 1;
            }
            .svc-flow .section-head {
                margin-bottom: 28px;
            }
            .svc-timeline--journey {
                max-width: none;
                padding: 4px 0 0;
            }
            .svc-timeline--journey::before {
                left: 21px;
                top: 8px;
                bottom: 8px;
                width: 3px;
                border: none;
                transform: none;
                border-radius: 999px;
                background: linear-gradient(
                    180deg,
                    #38BDF8 0%,
                    #2563EB 40%,
                    #7C3AED 75%,
                    rgba(124, 58, 237, 0.15) 100%
                );
                box-shadow: 0 0 16px rgba(37, 99, 235, 0.35);
            }
            .svc-timeline--journey .svc-timeline__row {
                display: grid;
                grid-template-columns: 44px minmax(0, 1fr);
                gap: 14px;
                align-items: stretch;
                margin-bottom: 16px;
                animation: svc-flow-rise 0.55s cubic-bezier(0.2, 0, 0, 1) both;
                animation-delay: calc(var(--step-i, 0) * 70ms);
            }
            .svc-timeline--journey .svc-timeline__row:last-child {
                margin-bottom: 0;
            }
            .svc-timeline--journey .svc-timeline__spacer {
                display: none;
            }
            .svc-timeline--journey .svc-timeline__row--left .svc-timeline__node,
            .svc-timeline--journey .svc-timeline__row--right .svc-timeline__node {
                grid-column: 1;
                grid-row: 1;
            }
            .svc-timeline--journey .svc-timeline__row--left .svc-timeline__content,
            .svc-timeline--journey .svc-timeline__row--right .svc-timeline__content {
                grid-column: 2;
                grid-row: 1;
                text-align: left;
            }
            .svc-timeline--journey .svc-timeline__node {
                grid-column: 1;
                grid-row: 1;
                align-self: start;
                width: 44px;
                height: 44px;
                margin-top: 18px;
                border-radius: 14px;
                border: 1px solid rgba(255, 255, 255, 0.28);
                background: linear-gradient(145deg, #2563EB 0%, #1D4ED8 55%, #1E3A8A 100%);
                box-shadow:
                    0 0 0 4px rgba(30, 58, 138, 0.18),
                    0 10px 22px rgba(30, 58, 138, 0.35);
                justify-self: center;
            }
            .svc-timeline--journey .svc-timeline__node svg {
                width: 20px;
                height: 20px;
            }
            .svc-timeline--journey .svc-timeline__content {
                grid-column: 2;
                grid-row: 1;
                text-align: left;
                position: relative;
                overflow: hidden;
                isolation: isolate;
                padding: 16px 16px 15px;
                border-radius: 18px;
                color: #E2E8F0;
                background: #0B1224;
                border: 1px solid rgba(255, 255, 255, 0.14);
                box-shadow:
                    0 1px 0 rgba(255, 255, 255, 0.1) inset,
                    0 14px 32px rgba(2, 6, 23, 0.22);
            }
            .svc-timeline--journey .svc-timeline__content::before {
                content: '';
                position: absolute;
                inset: 0;
                z-index: 0;
                pointer-events: none;
                background:
                    radial-gradient(ellipse 90% 80% at 0% 0%, color-mix(in srgb, var(--step-accent, #2563EB) 45%, transparent), transparent 55%),
                    radial-gradient(ellipse 70% 60% at 100% 100%, color-mix(in srgb, var(--step-accent, #2563EB) 28%, #7C3AED), transparent 55%);
            }
            .svc-timeline--journey .svc-timeline__content::after {
                content: '';
                position: absolute;
                inset: 0;
                z-index: 0;
                pointer-events: none;
                opacity: 0.22;
                background-image:
                    linear-gradient(rgba(255,255,255,0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px);
                background-size: 28px 28px;
                mask-image: radial-gradient(ellipse 80% 70% at 40% 30%, #000 10%, transparent 75%);
                -webkit-mask-image: radial-gradient(ellipse 80% 70% at 40% 30%, #000 10%, transparent 75%);
            }
            .svc-timeline--journey .svc-timeline__head,
            .svc-timeline--journey .svc-timeline__content h3,
            .svc-timeline--journey .svc-timeline__content p {
                position: relative;
                z-index: 1;
            }
            .svc-timeline--journey .svc-timeline__head {
                margin-bottom: 10px;
            }
            .svc-timeline--journey .svc-timeline__chip {
                display: inline-flex;
                align-items: center;
                padding: 4px 10px;
                border-radius: 999px;
                font-size: 11px;
                font-weight: 600;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                color: #E0F2FE;
                background: color-mix(in srgb, var(--step-accent, #2563EB) 22%, rgba(255,255,255,0.06));
                border: 1px solid rgba(255, 255, 255, 0.14);
            }
            .svc-timeline--journey .svc-timeline__content h3 {
                color: #fff;
                font-size: 17px;
                letter-spacing: -0.02em;
                margin: 0 0 6px;
                background: none;
                -webkit-text-fill-color: #fff;
            }
            .svc-timeline--journey .svc-timeline__content p {
                color: rgba(226, 232, 240, 0.86);
                font-size: 13.5px;
                line-height: 1.55;
            }
            .svc-timeline--journey .svc-timeline__row:active .svc-timeline__content {
                transform: scale(0.985);
            }
            .svc-timeline--journey .svc-timeline__row:active .svc-timeline__node {
                transform: scale(0.96);
            }
            @keyframes svc-flow-rise {
                from {
                    opacity: 0;
                    transform: translate3d(0, 16px, 0);
                }
                to {
                    opacity: 1;
                    transform: none;
                }
            }
            @media (prefers-reduced-motion: reduce) {
                .svc-timeline--journey .svc-timeline__row {
                    animation: none;
                }
                .svc-timeline--journey .svc-timeline__row:active .svc-timeline__content,
                .svc-timeline--journey .svc-timeline__row:active .svc-timeline__node {
                    transform: none;
                }
            }

            .svc-tech-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px 8px;
            }
            .svc-tech-grid li {
                gap: 6px;
                min-width: 0;
            }
            .svc-tech-grid__icon {
                width: 100%;
                height: auto;
                aspect-ratio: 1;
                max-width: none;
                border-radius: 18px;
                padding: 14px;
            }
            .svc-tech-grid__icon img {
                width: 100%;
                height: 100%;
                max-width: 64px;
                max-height: 64px;
            }
            .svc-tech-grid__icon span {
                font-size: 28px;
            }
            .svc-tech-grid__label {
                font-size: 12px;
                line-height: 1.25;
            }
            .services-page .section:has(.svc-tech-grid) .svc-section-head {
                margin-bottom: 24px;
            }
            .services-page .page-hero { text-align: left; padding: 64px 0 52px; }
            .svc-hero-grid { grid-template-columns: 1fr; gap: 28px; }
        }

        /* Page hero (inner pages) */
        .page-hero { background: linear-gradient(180deg, #F0F7FF, var(--bg)); padding: 70px 0 56px; text-align: center; }
        .page-hero h1 {
            font-size: clamp(36px, 5vw, 50px);
            margin-bottom: 12px;
            background-image: var(--title-grad);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }
        .services-page .page-hero h1 {
            background-image: none;
            -webkit-background-clip: border-box;
            background-clip: border-box;
            color: #fff;
            -webkit-text-fill-color: #fff;
        }
        .page-hero p { color: var(--text-light); font-size: 17px; max-width: 560px; margin: 0 auto; }

        /* Blog */
        .blog-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 28px; }
        .blog-card { border-radius: 16px; overflow: hidden; border: 1px solid var(--border); background: var(--bg); transition: all .25s; }
        .blog-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .blog-thumb { height: 200px; background: var(--bg-soft); overflow: hidden; }
        .blog-thumb img { width: 100%; height: 100%; object-fit: cover; }
        .blog-body { padding: 22px; }
        .blog-date { font-size: 12.5px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 10px; }
        .blog-body h3 { font-size: 18px; margin-bottom: 10px; }
        .blog-body h3 a { color: var(--dark); }
        .blog-body h3 a:hover { color: var(--primary); }
        .blog-body p { font-size: 14px; color: var(--text-light); }

        /* Blog single */
        .blog-single { max-width: 760px; margin: 0 auto; }
        .blog-single h1 { font-size: clamp(30px, 4vw, 40px); margin-bottom: 14px; }
        .blog-single .meta { color: var(--text-muted); font-size: 14px; margin-bottom: 30px; }
        .blog-single .cover { border-radius: 16px; margin-bottom: 30px; background: var(--bg-soft); }
        .blog-single .cover img { border-radius: 16px; }
        .blog-content { font-size: 17px; line-height: 1.8; }
        .blog-content h2 { font-size: 26px; margin: 32px 0 12px; }
        .blog-content h3 { font-size: 20px; margin: 24px 0 10px; }
        .blog-content p { margin-bottom: 18px; }
        .blog-content ul, .blog-content ol { margin: 0 0 18px 24px; }

        /* Service detail */
        .service-detail-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 48px; align-items: start; }
        .service-content h2 { font-size: 26px; margin: 32px 0 14px; }
        .service-content p { margin-bottom: 16px; font-size: 16.5px; }
        .feature-list { list-style: none; }
        .feature-list li { display: flex; gap: 10px; align-items: flex-start; padding: 10px 0; font-size: 15.5px; border-bottom: 1px solid var(--border-soft, #f1f5f9); }
        .feature-list li::before { content: '✓'; color: var(--success); font-weight: 700; flex-shrink: 0; }
        .process-steps { display: flex; flex-direction: column; gap: 24px; margin-top: 8px; }
        .process-step { display: flex; gap: 16px; }
        .process-num { width: 40px; height: 40px; border-radius: 10px; background: var(--primary-light); color: var(--primary); font-weight: 700; display: grid; place-items: center; flex-shrink: 0; font-family: 'Inter Tight', sans-serif; }
        .process-step h4 { font-size: 16px; margin-bottom: 4px; }
        .process-step p { font-size: 14.5px; color: var(--text-light); }
        .quote-card { background: var(--bg-soft); border: 1px solid var(--border); border-radius: 18px; padding: 32px; position: sticky; top: 96px; }
        .quote-card h3 { margin-bottom: 20px; font-size: 20px; }
        .quote-form { display: flex; flex-direction: column; gap: 14px; }
        .quote-form .input { width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14.5px; font-family: 'Inter', sans-serif; }
        .quote-form .input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
        .quote-card .price-note { font-size: 18px; font-family: 'Inter Tight', sans-serif; font-weight: 700; color: var(--dark); margin-bottom: 20px; }
        .quote-card .price-note span { font-size: 13px; color: var(--text-muted); font-weight: 400; }

        /* Contact */
        .contact-grid { display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 48px; }
        .contact-info { display: flex; flex-direction: column; gap: 24px; }
        .contact-item { display: flex; gap: 16px; align-items: flex-start; }
        .contact-item .icon { width: 46px; height: 46px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: grid; place-items: center; flex-shrink: 0; }
        .contact-item h4 { font-size: 15px; margin-bottom: 4px; }
        .contact-item p { font-size: 14.5px; color: var(--text-light); }
        .contact-form-wrap { background: var(--bg); border: 1px solid var(--border); border-radius: 18px; padding: 36px; box-shadow: var(--shadow); }
        .contact-form .field { margin-bottom: 18px; }
        .contact-form .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .contact-form label { display: block; font-size: 13.5px; font-weight: 600; color: var(--dark); margin-bottom: 7px; }
        .contact-form .input, .contact-form select, .contact-form textarea { width: 100%; padding: 12px 16px; border: 1.5px solid var(--border); border-radius: 10px; font-size: 14.5px; font-family: 'Inter', sans-serif; background: var(--bg); color: var(--dark); }
        .contact-form .input:focus, .contact-form textarea:focus, .contact-form select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-light); }
        .flash-success-banner { background: #ECFDF5; border: 1px solid var(--success); color: #065F46; padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14.5px; font-weight: 500; }
        .map-wrap { border-radius: 18px; overflow: hidden; border: 1px solid var(--border); margin-top: 60px; height: 380px; }
        .map-wrap iframe { width: 100%; height: 100%; border: 0; }

        /* Team */
        .team-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 26px; }
        .team-card { text-align: center; background: var(--bg); border: 1px solid var(--border); border-radius: 18px; padding: 30px 24px; transition: all .25s; }
        .team-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
        .team-avatar { width: 90px; height: 90px; border-radius: 50%; margin: 0 auto 16px; background: var(--primary-light); color: var(--primary); display: grid; place-items: center; font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 28px; overflow: hidden; }
        .team-avatar img { width: 100%; height: 100%; object-fit: cover; }
        .team-card h3 { font-size: 18px; }
        .team-card .position { color: var(--primary); font-size: 13.5px; font-weight: 600; margin: 4px 0 10px; }
        .team-card p { font-size: 14px; color: var(--text-light); }
        .team-social { display: flex; gap: 8px; justify-content: center; margin-top: 14px; }
        .team-social a { width: 32px; height: 32px; border-radius: 8px; background: var(--bg-soft); display: grid; place-items: center; font-size: 14px; color: var(--text-muted); }
        .team-social a:hover { background: var(--primary-light); color: var(--primary); }

        /* Pagination */
        .pagination { display: flex; justify-content: center; gap: 6px; margin-top: 40px; }
        .pagination .page-item { }
        .pagination .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 12px; border: 1.5px solid var(--border); border-radius: 10px; color: var(--text-light); font-size: 14px; font-weight: 500; }
        .pagination .page-link:hover { border-color: var(--primary); color: var(--primary); }
        .pagination .active .page-link { background: var(--primary); border-color: var(--primary); color: #fff; }
        .pagination .disabled .page-link { opacity: .5; cursor: not-allowed; }

        /* Project gallery */
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin: 30px 0; }
        .gallery-grid img { border-radius: 12px; height: 220px; object-fit: cover; }
        .tech-tags { display: flex; flex-wrap: wrap; gap: 8px; margin: 22px 0; }
        .tech-tag { background: var(--bg-soft); border: 1px solid var(--border); padding: 6px 14px; border-radius: 20px; font-size: 13px; color: var(--text-light); font-weight: 500; }
        .alert-message { padding: 14px 18px; border-radius: 10px; margin-bottom: 20px; font-size: 14px; font-weight: 500; }

        /* Error pages */
        .error-wrap { min-height: 80vh; display: grid; place-items: center; text-align: center; padding: 60px 24px; }
        .error-code { font-family: 'Inter Tight', sans-serif; font-size: 120px; font-weight: 800; line-height: 1; color: var(--primary); background: linear-gradient(135deg, var(--primary), #7C3AED); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .error-wrap h1 { font-size: 32px; margin: 20px 0 12px; }
        .error-wrap p { color: var(--text-light); margin-bottom: 30px; }

        /* Values */
        .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; }
        .value-card { padding: 30px; border: 1px solid var(--border); border-radius: 16px; background: var(--bg); }
        .value-card .num { font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 32px; color: var(--primary); margin-bottom: 10px; }
        .value-card h3 { font-size: 18px; margin-bottom: 8px; }
        .value-card p { font-size: 14.5px; color: var(--text-light); }

        @media (max-width: 900px) {
            .hero-grid, .service-detail-grid, .contact-grid { grid-template-columns: 1fr; }
            .hero-grid .hero-visual { order: -1; }
            .svc-hero-grid .svc-hero-visual { order: -1; }
            .services-grid, .portfolio-grid, .testimonial-grid, .blog-grid, .values-grid { grid-template-columns: 1fr; }
            .team-grid { grid-template-columns: 1fr 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .section { padding: 60px 0; }
            .hero { padding: 70px 0; }
        }
        @media (max-width: 600px) {
            .team-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr; }
            .hero-stats { gap: 24px; flex-wrap: wrap; }
        }

        /* ── iOS-app mobile shell (phones) ───────────────── */
        .ios-tabbar { display: none; }
        @media (max-width: 768px) {
            /* Continuous surface — dock floats over dark footer, no white gap */
            body.site-shell {
                --page-gutter: 16px;
                --ios-topbar-h: 56px;
                --ios-tabbar-h: 68px;
                --ios-tabbar-inset: 16px;
                --ios-tabbar-clearance: calc(var(--ios-tabbar-h) + var(--ios-tabbar-inset) + env(safe-area-inset-bottom, 0px));
                padding-bottom: 0;
                background: #fff;
                -webkit-tap-highlight-color: transparent;
                overflow-x: clip;
                max-width: 100%;
            }
            html:has(body.site-shell) {
                background: #fff;
                overflow-x: clip;
                max-width: 100%;
            }
            body.site-shell .navbar {
                position: sticky;
                top: 0;
                z-index: 200;
                height: calc(var(--ios-topbar-h) + env(safe-area-inset-top, 0px));
                padding-top: env(safe-area-inset-top, 0px);
                background: transparent;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                border-bottom: none;
                box-shadow: none;
            }
            body.site-shell .navbar::after {
                display: none;
            }
            body.site-shell .nav-inner {
                height: var(--ios-topbar-h);
                padding-left: 0;
                padding-right: 0;
                /* .container already applies --page-gutter */
            }
            body.site-shell .nav-logo {
                font-size: 17px;
                font-weight: 700;
                letter-spacing: -0.03em;
            }
            body.site-shell .nav-logo .logo-mark {
                width: 30px;
                height: 30px;
                border-radius: 8px;
            }
            body.site-shell .nav-links,
            body.site-shell .nav-toggle,
            body.site-shell .nav-cta .btn {
                display: none !important;
            }
            body.site-shell .nav-cta {
                gap: 8px;
            }
            body.site-shell .lang-switch__btn {
                height: 34px;
                padding: 0 10px;
                border-radius: 999px;
                background: rgba(15, 23, 42, 0.05);
                border: none;
            }
            /* Global mobile page gutters — one source of truth for all pages */
            body.site-shell .container {
                padding-left: max(var(--page-gutter), env(safe-area-inset-left, 0px));
                padding-right: max(var(--page-gutter), env(safe-area-inset-right, 0px));
            }
            body.site-shell .section {
                padding: 36px 0;
            }
            body.site-shell .section-alt {
                background: #F8FAFC;
            }
            body.site-shell .page-hero {
                border-radius: 0;
            }
            body.site-shell .hero,
            body.site-shell .page-hero,
            body.site-shell .svc-hire,
            body.site-shell .svc-quote-band,
            body.site-shell .footer,
            body.site-shell .section-services {
                padding-left: 0;
                padding-right: 0;
            }
            body.site-shell .error-wrap {
                padding-left: max(var(--page-gutter), env(safe-area-inset-left, 0px));
                padding-right: max(var(--page-gutter), env(safe-area-inset-right, 0px));
            }
            body.site-shell .services-page {
                overflow-x: clip;
                max-width: 100%;
            }
            body.site-shell .services-page .page-hero.svc-hero {
                padding: 36px 0 40px;
                margin: 0;
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-sizing: border-box;
            }
            body.site-shell .portfolio-page .page-hero.pf-hero {
                padding: 36px 0 40px;
                margin: 0;
                width: 100%;
                max-width: 100%;
                border-radius: 0;
                box-sizing: border-box;
            }
            body.site-shell .services-page .page-hero.svc-hero .container {
                max-width: 100%;
                width: 100%;
                box-sizing: border-box;
            }
            body.site-shell .portfolio-page .page-hero.pf-hero .container {
                max-width: 100%;
                width: 100%;
                box-sizing: border-box;
            }
            body.site-shell .pf-hero-meta {
                gap: 20px;
            }
            body.site-shell .pf-hero-stack {
                height: 220px;
            }
            body.site-shell .pf-hero-visual {
                gap: 28px;
            }
            body.site-shell .project-thumb__cta {
                opacity: 1;
                transform: none;
            }
            body.site-shell .svc-hero-grid,
            body.site-shell .svc-hero-copy,
            body.site-shell .svc-hero-visual,
            body.site-shell .svc-hero-panel {
                min-width: 0;
                max-width: 100%;
            }
            body.site-shell .svc-hero-bg__orb--1,
            body.site-shell .svc-hero-bg__orb--2,
            body.site-shell .svc-hero-bg__orb--3 {
                max-width: 70vw;
                max-height: 70vw;
            }
            body.site-shell .svc-hire {
                max-width: 100%;
                overflow: hidden;
            }
            body.site-shell .svc-tech-grid {
                gap: 10px 8px;
            }
            body.site-shell .svc-tech-grid li {
                gap: 5px;
                width: 100%;
            }
            body.site-shell .svc-tech-grid__icon {
                width: 100%;
                height: auto;
                aspect-ratio: 1;
                border-radius: 16px;
                padding: 12px;
            }
            body.site-shell .svc-tech-grid__icon img {
                width: 100%;
                height: 100%;
                max-width: 58px;
                max-height: 58px;
            }
            body.site-shell .services-page .section:has(.svc-tech-grid) {
                padding-top: 28px;
                padding-bottom: 28px;
            }
            body.site-shell .services-page .section:has(.svc-tech-grid) .svc-section-head {
                margin-bottom: 18px;
            }
            body.site-shell .service-card,
            body.site-shell .project-card,
            body.site-shell .blog-card,
            body.site-shell .g-review-card,
            body.site-shell .contact-form-wrap,
            body.site-shell .svc-hero-panel {
                border-radius: 14px;
                border-color: rgba(15, 23, 42, 0.08);
                box-shadow: none;
            }
            body.site-shell .svc-flow .svc-timeline__content {
                border-radius: 18px;
                box-shadow:
                    0 1px 0 rgba(255, 255, 255, 0.1) inset,
                    0 14px 32px rgba(2, 6, 23, 0.22);
            }
            body.site-shell .svc-flow {
                margin-inline: 0;
                padding-top: 40px;
                padding-bottom: 48px;
            }
            body.site-shell .g-review-card {
                border-radius: 12px;
                box-shadow: 0 1px 2px rgba(60, 64, 67, 0.08), 0 1px 3px 1px rgba(60, 64, 67, 0.06);
            }
            body.site-shell .cta-banner {
                border-radius: 22px;
                margin: 0;
                padding: 12px 0;
            }
            body.site-shell .cta-banner__inner {
                padding-left: 20px;
                padding-right: 20px;
            }
            body.site-shell .btn {
                border-radius: 14px;
                min-height: 48px;
                font-weight: 600;
            }
            body.site-shell .btn-lg {
                min-height: 52px;
                padding-left: 22px;
                padding-right: 22px;
            }
            body.site-shell .hero-grid .hero-visual,
            body.site-shell .svc-hero-grid .svc-hero-visual {
                order: -1;
            }
            body.site-shell .hero-grid,
            body.site-shell .svc-hero-grid {
                gap: 24px;
            }
            body.site-shell .svc-hero-actions {
                flex-direction: column;
            }
            body.site-shell .svc-hero-actions .btn {
                width: 100%;
                justify-content: center;
            }
            body.site-shell .footer {
                padding-top: 40px;
                /* Extend dark footer under floating dock — kills white strip */
                padding-bottom: calc(var(--ios-tabbar-clearance) + 12px);
                margin-bottom: 0;
                border-radius: 0;
            }
            body.site-shell .footer-grid > div:nth-child(n+2) {
                display: none;
            }
            body.site-shell .footer-grid {
                grid-template-columns: 1fr;
            }
            body.site-shell .footer-brand {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
            body.site-shell .footer-logo {
                justify-content: center;
            }
            body.site-shell .footer-about {
                max-width: 34ch;
                margin-left: auto;
                margin-right: auto;
            }
            body.site-shell .footer-social {
                justify-content: center;
                gap: 12px;
            }
            body.site-shell .footer .social-btn {
                width: 48px;
                height: 48px;
                min-width: 48px;
                min-height: 48px;
            }
            body.site-shell .footer .social-btn svg {
                width: 20px;
                height: 20px;
            }
            body.site-shell .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            /* Modern liquid-glass dock — dark capsule + active primary pill */
            .ios-tabbar {
                display: grid;
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 4px;
                position: fixed;
                left: 0;
                right: 0;
                bottom: calc(var(--ios-tabbar-inset) + env(safe-area-inset-bottom, 0px));
                z-index: 300;
                height: var(--ios-tabbar-h);
                width: min(420px, calc(100% - 32px));
                margin-inline: auto;
                padding: 6px;
                border-radius: 999px;
                background: rgba(15, 23, 42, 0.82);
                backdrop-filter: saturate(160%) blur(28px);
                -webkit-backdrop-filter: saturate(160%) blur(28px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow:
                    0 1px 0 rgba(255, 255, 255, 0.12) inset,
                    0 12px 40px rgba(15, 23, 42, 0.28),
                    0 4px 12px rgba(37, 99, 235, 0.18);
                isolation: isolate;
            }
            .ios-tabbar::before {
                content: "";
                position: absolute;
                inset: 0;
                border-radius: inherit;
                pointer-events: none;
                background: linear-gradient(180deg, rgba(255,255,255,0.14) 0%, rgba(255,255,255,0) 42%);
                z-index: 0;
            }
            .ios-tabbar__item {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 2px;
                min-width: 0;
                min-height: 56px;
                padding: 6px 2px;
                border-radius: 999px;
                color: rgba(255, 255, 255, 0.55);
                text-decoration: none;
                font-size: 9px;
                font-weight: 600;
                letter-spacing: 0.01em;
                line-height: 1.1;
                -webkit-font-smoothing: antialiased;
                transition:
                    color .2s ease,
                    background-color .2s ease,
                    box-shadow .2s ease,
                    transform .15s ease;
            }
            .ios-tabbar__icon {
                display: grid;
                place-items: center;
                width: 28px;
                height: 28px;
                border-radius: 999px;
                transition: transform .2s cubic-bezier(.34,1.4,.64,1), background-color .2s ease;
            }
            .ios-tabbar__item svg {
                width: 20px;
                height: 20px;
                display: block;
            }
            .ios-tabbar__item svg[data-icon="filled"] {
                display: none;
            }
            .ios-tabbar__label {
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                opacity: 0.9;
            }
            .ios-tabbar__item.is-active {
                color: #fff;
                background: var(--primary);
                box-shadow:
                    0 6px 18px rgba(37, 99, 235, 0.45),
                    0 1px 0 rgba(255, 255, 255, 0.25) inset;
            }
            .ios-tabbar__item.is-active .ios-tabbar__icon {
                background: transparent;
                transform: translateY(-1px);
            }
            .ios-tabbar__item.is-active .ios-tabbar__label {
                opacity: 1;
            }
            .ios-tabbar__item.is-active svg[data-icon="outline"] {
                display: none;
            }
            .ios-tabbar__item.is-active svg[data-icon="filled"] {
                display: block;
            }
            .ios-tabbar__item:focus-visible {
                outline: 2px solid #fff;
                outline-offset: 2px;
            }
            .ios-tabbar__item:active {
                transform: scale(0.96);
            }
            @media (prefers-reduced-motion: reduce) {
                .ios-tabbar__item,
                .ios-tabbar__icon {
                    transition: none;
                }
                .ios-tabbar__item:active,
                .ios-tabbar__item.is-active .ios-tabbar__icon {
                    transform: none;
                }
            }
        }

    </style>
    @stack('styles')
</head>
<body class="site-shell">
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="container nav-inner">
            <a href="{{ route('home') }}" class="nav-logo">
                @php
                    $siteLogo = setting('logo');
                    $siteLogoUrl = $siteLogo ? asset('storage/' . ltrim((string) $siteLogo, '/')) : null;
                @endphp
                <span class="logo-mark{{ $siteLogoUrl ? ' logo-mark--image' : '' }}">
                    @if($siteLogoUrl)
                        <img src="{{ $siteLogoUrl }}" alt="{{ setting('site_name', 'DesignPro') }}">
                    @else
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5z"/><circle cx="11" cy="11" r="2"/></svg>
                    @endif
                </span>
                {{ setting('site_name', 'DesignPro') }}
            </a>
            <div class="nav-links" id="navLinks">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('Home') }}</a>
                <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">{{ __('Services') }}</a>
                <a href="{{ route('portfolio.index') }}" class="{{ request()->routeIs('portfolio.*') ? 'active' : '' }}">{{ __('Portfolio') }}</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">{{ __('About') }}</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">{{ __('Blog') }}</a>
                <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">{{ __('Contact') }}</a>
            </div>
            <div class="nav-cta">
                @php
                    $currentLocale = app()->getLocale();
                    $languages = [
                        'en' => ['label' => __('English'), 'code' => 'EN'],
                        'ms' => ['label' => __('Malay'), 'code' => 'MS'],
                        'id' => ['label' => __('Indonesian'), 'code' => 'ID'],
                    ];
                @endphp
                <div class="lang-switch" data-lang-switch>
                    <button
                        type="button"
                        class="lang-switch__btn"
                        id="langSwitchBtn"
                        aria-haspopup="listbox"
                        aria-expanded="false"
                        aria-label="{{ __('Language') }}"
                    >
                        <span class="lang-switch__flag" aria-hidden="true">
                            @if($currentLocale === 'ms')
                                <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="16" fill="#C8102E"/><rect width="22" height="1.14" y="0" fill="#fff"/><rect width="22" height="1.14" y="2.28" fill="#fff"/><rect width="22" height="1.14" y="4.57" fill="#fff"/><rect width="22" height="1.14" y="6.85" fill="#fff"/><rect width="22" height="1.14" y="9.14" fill="#fff"/><rect width="22" height="1.14" y="11.42" fill="#fff"/><rect width="22" height="1.14" y="13.71" fill="#fff"/><rect width="11" height="8" fill="#012169"/><circle cx="5.5" cy="4" r="2.2" fill="#fff"/><circle cx="6.1" cy="4" r="1.8" fill="#012169"/><polygon fill="#FC0" points="7.4,4 8.6,4.4 7.4,4.8 8.6,5.2 7.2,5.1 7.8,6.1 6.8,5.3 6.3,6.4 6.3,5.2 5.2,5.8 5.9,4.9 4.7,4.8 5.8,4.3 4.8,3.5 5.9,3.8 5.5,2.7 6.4,3.5 6.7,2.4 7,3.5"/></svg>
                            @elseif($currentLocale === 'id')
                                <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="8" fill="#E70011"/><rect y="8" width="22" height="8" fill="#fff"/></svg>
                            @else
                                <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="16" fill="#012169"/><path stroke="#fff" stroke-width="2" d="M0,0 22,16 M22,0 0,16"/><path stroke="#C8102E" stroke-width="1.2" d="M0,0 22,16 M22,0 0,16"/><path stroke="#fff" stroke-width="3.2" d="M11,0 V16 M0,8 H22"/><path stroke="#C8102E" stroke-width="1.8" d="M11,0 V16 M0,8 H22"/></svg>
                            @endif
                        </span>
                        <span class="lang-switch__code">{{ $languages[$currentLocale]['code'] ?? 'EN' }}</span>
                        <svg class="lang-switch__chev" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div class="lang-switch__menu" id="langSwitchMenu" role="listbox" aria-label="{{ __('Language') }}">
                        @foreach($languages as $code => $meta)
                            <a
                                href="{{ route('locale.switch', $code) }}"
                                class="lang-switch__item{{ $currentLocale === $code ? ' is-active' : '' }}"
                                role="option"
                                aria-selected="{{ $currentLocale === $code ? 'true' : 'false' }}"
                            >
                                <span class="lang-switch__flag" aria-hidden="true">
                                    @if($code === 'ms')
                                        <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="16" fill="#C8102E"/><rect width="22" height="1.14" y="0" fill="#fff"/><rect width="22" height="1.14" y="2.28" fill="#fff"/><rect width="22" height="1.14" y="4.57" fill="#fff"/><rect width="22" height="1.14" y="6.85" fill="#fff"/><rect width="22" height="1.14" y="9.14" fill="#fff"/><rect width="22" height="1.14" y="11.42" fill="#fff"/><rect width="22" height="1.14" y="13.71" fill="#fff"/><rect width="11" height="8" fill="#012169"/><circle cx="5.5" cy="4" r="2.2" fill="#fff"/><circle cx="6.1" cy="4" r="1.8" fill="#012169"/></svg>
                                    @elseif($code === 'id')
                                        <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="8" fill="#E70011"/><rect y="8" width="22" height="8" fill="#fff"/></svg>
                                    @else
                                        <svg viewBox="0 0 22 16" xmlns="http://www.w3.org/2000/svg"><rect width="22" height="16" fill="#012169"/><path stroke="#fff" stroke-width="2" d="M0,0 22,16 M22,0 0,16"/><path stroke="#C8102E" stroke-width="1.2" d="M0,0 22,16 M22,0 0,16"/><path stroke="#fff" stroke-width="3.2" d="M11,0 V16 M0,8 H22"/><path stroke="#C8102E" stroke-width="1.8" d="M11,0 V16 M0,8 H22"/></svg>
                                    @endif
                                </span>
                                <span>{{ $meta['label'] }}</span>
                                <strong style="font-size:11px;opacity:.7">{{ $meta['code'] }}</strong>
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('contact.index') }}" class="btn btn-primary">{{ __('Start a Project') }}</a>
                <button class="nav-toggle" id="navToggle" aria-label="{{ __('Toggle menu') }}">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Flash success --}}
    @if(session('success'))
    <div class="container" style="margin-top:24px">
        <div class="flash-success-banner">{{ session('success') }}</div>
    </div>
    @endif

    @yield('content')

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <span class="logo-mark{{ $siteLogoUrl ? ' logo-mark--image' : '' }}" style="width:34px;height:34px;border-radius:9px;{{ $siteLogoUrl ? 'background:transparent;overflow:hidden;' : 'background:var(--primary);' }}display:grid;place-items:center">
                            @if($siteLogoUrl)
                                <img src="{{ $siteLogoUrl }}" alt="{{ setting('site_name', 'DesignPro') }}" style="width:100%;height:100%;object-fit:contain">
                            @else
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2.4" aria-hidden="true"><path d="M12 19l7-7 3 3-7 7-3-3z"/></svg>
                            @endif
                        </span>
                        {{ setting('site_name', 'DesignPro') }}
                    </div>
                    <p class="footer-about">{{ setting('general.site_description', 'We design and build exceptional digital products.') }}</p>
                    <div class="footer-social social-links" aria-label="{{ __('Social media') }}">
                        @if(setting('social.facebook'))
                        <a class="social-btn social-btn--facebook" href="{{ setting('social.facebook') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14C17.17 2.09 15.92 2 14.71 2 11.93 2 10 3.66 10 6.79V9.5H7v4h3V22h4z"/></svg></a>
                        @endif
                        @if(setting('social.instagram'))
                        <a class="social-btn social-btn--instagram" href="{{ setting('social.instagram') }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm11.5 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg></a>
                        @endif
                        @if(setting('social.linkedin'))
                        <a class="social-btn social-btn--linkedin" href="{{ setting('social.linkedin') }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.94 6.5A2.19 2.19 0 1 1 4.76 4.3 2.19 2.19 0 0 1 6.94 6.5zM7 8.86H2.75V21H7zm5.5 0h-4.2V21h4.2v-6.55c0-1.73.82-2.84 2.33-2.84 1.4 0 2.07.96 2.07 2.84V21H21v-7.17c0-3.66-1.96-5.36-4.57-5.36a4.1 4.1 0 0 0-3.93 2.17V8.86z"/></svg></a>
                        @endif
                        @if(setting('social.twitter'))
                        <a class="social-btn social-btn--x" href="{{ setting('social.twitter') }}" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 1.2h3.7l-8.1 9.3L24 22.8h-7.4l-5.8-7.6-6.7 7.6H.4l8.7-9.9L0 1.2h7.6l5.3 7 6-7z"/></svg></a>
                        @endif
                        @if(setting('social.github'))
                        <a class="social-btn social-btn--github" href="{{ setting('social.github') }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub"><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2C6.5 2 2 6.6 2 12a10 10 0 0 0 6.8 9.5c.5.1.7-.2.7-.5v-1.9c-2.8.6-3.4-1.2-3.4-1.2-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.4-1.1.7-1.3-2.2-.3-4.5-1.1-4.5-4.9 0-1.1.4-2 1-2.7-.1-.2-.4-1.2.1-2.6 0 0 .8-.3 2.7 1A9.4 9.4 0 0 1 12 6.3c.8 0 1.6.1 2.4.3 1.9-.7 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.6.6.7 1 1.6 1 2.7 0 3.8-2.3 4.6-4.5 4.9.4.3.7.9.7 1.9V21c0 .3.2.6.7.5A10 10 0 0 0 22 12c0-5.4-4.5-10-10-10z"/></svg></a>
                        @endif
                    </div>
                </div>
                <div>
                    <h4>{{ __('Services') }}</h4>
                    @php $footerServices = \App\Models\Service::active()->ordered()->take(5)->get(); @endphp
                    @foreach($footerServices as $s)
                        <a href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a>
                    @endforeach
                </div>
                <div>
                    <h4>{{ __('Company') }}</h4>
                    <a href="{{ route('about') }}">{{ __('About Us') }}</a>
                    <a href="{{ route('portfolio.index') }}">{{ __('Portfolio') }}</a>
                    <a href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
                    <a href="{{ route('contact.index') }}">{{ __('Contact') }}</a>
                    @foreach(\App\Models\Page::active()->take(3)->get() as $page)
                        <a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a>
                    @endforeach
                </div>
                <div>
                    <h4>{{ __('Get in Touch') }}</h4>
                    @if(setting('contact.email'))
                    <a href="mailto:{{ setting('contact.email') }}">✉ {{ setting('contact.email') }}</a>
                    @endif
                    @if(setting('contact.phone'))
                    <a href="tel:{{ setting('contact.phone') }}">☎ {{ setting('contact.phone') }}</a>
                    @endif
                    @if(setting('contact.address'))
                    <a href="{{ route('contact.index') }}">📍 {{ setting('contact.address') }}</a>
                    @endif
                </div>
            </div>
            <div class="footer-bottom">
                <span>{!! setting('copyright', '© ' . date('Y') . ' ' . setting('site_name', 'DesignPro') . '. All rights reserved.') !!}</span>
                <span>{{ __('Designed & developed by') }} {{ setting('site_name', 'DesignPro') }}</span>
            </div>
        </div>
    </footer>

    {{-- Modern liquid-glass mobile dock --}}
    <nav class="ios-tabbar" aria-label="{{ __('Primary') }}">
        <a href="{{ route('home') }}" class="ios-tabbar__item {{ request()->routeIs('home') ? 'is-active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V20a1 1 0 0 0 1 1h4.5v-6h3V21H18a1 1 0 0 0 1-1V9.5"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.6 2.8 10.2a1 1 0 0 0-.3.7V20a2 2 0 0 0 2 2h4.7v-6.2h5.6V22H19.5a2 2 0 0 0 2-2v-9.1a1 1 0 0 0-.3-.7L12 2.6z"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('Home') }}</span>
        </a>
        <a href="{{ route('services.index') }}" class="ios-tabbar__item {{ request()->routeIs('services.*') ? 'is-active' : '' }}" @if(request()->routeIs('services.*')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><rect x="2.5" y="2.5" width="8.2" height="8.2" rx="2"/><rect x="13.3" y="2.5" width="8.2" height="8.2" rx="2"/><rect x="2.5" y="13.3" width="8.2" height="8.2" rx="2"/><rect x="13.3" y="13.3" width="8.2" height="8.2" rx="2"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('Services') }}</span>
        </a>
        <a href="{{ route('portfolio.index') }}" class="ios-tabbar__item {{ request()->routeIs('portfolio.*') ? 'is-active' : '' }}" @if(request()->routeIs('portfolio.*')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 15 4.5-4.5a2 2 0 0 1 2.8 0L16 16"/><path d="m14 14 1.5-1.5a2 2 0 0 1 2.8 0L21 15"/><circle cx="8.5" cy="9" r="1.2"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4.5A2.5 2.5 0 0 0 1.5 7v11A2.5 2.5 0 0 0 4 20.5h16a2.5 2.5 0 0 0 2.5-2.5V7A2.5 2.5 0 0 0 20 4.5H4zm4.2 4.2a1.4 1.4 0 1 1 0 2.8 1.4 1.4 0 0 1 0-2.8zM3.2 16.8l3.9-3.9a2.2 2.2 0 0 1 3.1 0l3.2 3.2 1.3-1.3a2.2 2.2 0 0 1 3.1 0l2.9 2.9v.8A1.2 1.2 0 0 1 20 19.2H4a1.2 1.2 0 0 1-1.2-1.2v-1.2z"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('Portfolio') }}</span>
        </a>
        <a href="{{ route('about') }}" class="ios-tabbar__item {{ request()->routeIs('about') ? 'is-active' : '' }}" @if(request()->routeIs('about')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="3.5"/><path d="M5.5 19.5c1.2-3.2 3.6-4.8 6.5-4.8s5.3 1.6 6.5 4.8"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3.2a4.3 4.3 0 1 1 0 8.6 4.3 4.3 0 0 1 0-8.6zm0 10c3.5 0 6.4 1.8 7.8 5.1a1.4 1.4 0 0 1-1.3 1.9H5.5a1.4 1.4 0 0 1-1.3-1.9C5.6 15 8.5 13.2 12 13.2z"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('About') }}</span>
        </a>
        <a href="{{ route('blog.index') }}" class="ios-tabbar__item {{ request()->routeIs('blog.*') ? 'is-active' : '' }}" @if(request()->routeIs('blog.*')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 4h10a2 2 0 0 1 2 2v14l-7-3-7 3V6a2 2 0 0 1 2-2z"/><path d="M19 6h.5A2.5 2.5 0 0 1 22 8.5V20l-3-1.2"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><path d="M5.2 2.8h9.6A2.7 2.7 0 0 1 17.5 5.5V19.8l-6.3-2.7-6.3 2.7V5.5A2.7 2.7 0 0 1 5.2 2.8zm13.3 2.4h.3A3.2 3.2 0 0 1 22 8.4V19.6l-3.5-1.4V5.2z"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('Blog') }}</span>
        </a>
        <a href="{{ route('contact.index') }}" class="ios-tabbar__item {{ request()->routeIs('contact.*') ? 'is-active' : '' }}" @if(request()->routeIs('contact.*')) aria-current="page" @endif>
            <span class="ios-tabbar__icon" aria-hidden="true">
                <svg data-icon="outline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3.1-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.8.3 1.6.6 2.3a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.7.3 1.5.5 2.3.6a2 2 0 0 1 1.7 2.1z"/></svg>
                <svg data-icon="filled" viewBox="0 0 24 24" fill="currentColor"><path d="M21.2 16.7v2.8a2.4 2.4 0 0 1-2.6 2.4 20.4 20.4 0 0 1-8.9-3.2 20 20 0 0 1-6.2-6.2A20.4 20.4 0 0 1 .4 3.6 2.4 2.4 0 0 1 2.8.9h2.8a2.4 2.4 0 0 1 2.4 2c.1.9.4 1.8.7 2.6a2.4 2.4 0 0 1-.5 2.5L6.6 9.6a16.8 16.8 0 0 0 6.4 6.4l1.6-1.6a2.4 2.4 0 0 1 2.5-.5c.8.3 1.7.6 2.6.7a2.4 2.4 0 0 1 1.5 2.1z"/></svg>
            </span>
            <span class="ios-tabbar__label">{{ __('Contact') }}</span>
        </a>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toggle = document.getElementById('navToggle');
            var links = document.getElementById('navLinks');
            if (toggle && links) {
                toggle.addEventListener('click', function() {
                    links.classList.toggle('open');
                });
            }

            var langRoot = document.querySelector('[data-lang-switch]');
            var langBtn = document.getElementById('langSwitchBtn');
            var langMenu = document.getElementById('langSwitchMenu');
            if (langRoot && langBtn && langMenu) {
                langBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    var open = langMenu.classList.toggle('open');
                    langBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
                });
                document.addEventListener('click', function () {
                    langMenu.classList.remove('open');
                    langBtn.setAttribute('aria-expanded', 'false');
                });
                langMenu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        });
    </script>

    <script>
    (function () {
      document.querySelectorAll('[data-t-carousel]').forEach(function (root) {
        var track = root.querySelector('.t-carousel__track');
        var slides = Array.prototype.slice.call(root.querySelectorAll('[data-slide]'));
        var dotsWrap = root.querySelector('[data-dots]');
        var prevBtn = root.querySelector('[data-prev]');
        var nextBtn = root.querySelector('[data-next]');
        var pauseBtn = root.querySelector('[data-pause]');
        var statusEl = root.querySelector('[data-status]');
        var pauseIcon = pauseBtn ? pauseBtn.querySelector('[data-icon="pause"]') : null;
        var playIcon = pauseBtn ? pauseBtn.querySelector('[data-icon="play"]') : null;
        if (!track || slides.length === 0) return;
        if (root.dataset.carouselReady === '1') return;
        root.dataset.carouselReady = '1';

        var index = 0;
        var timer = null;
        var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var autoplay = false;
        var paused = true;

        if (dotsWrap) {
          slides.forEach(function (_, i) {
            var dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 't-carousel__dot' + (i === 0 ? ' is-active' : '');
            dot.setAttribute('aria-label', (i + 1) + ' / ' + slides.length);
            dot.addEventListener('click', function () { goTo(i, true); });
            dotsWrap.appendChild(dot);
          });
        }
        var dots = dotsWrap ? Array.prototype.slice.call(dotsWrap.querySelectorAll('.t-carousel__dot')) : [];

        function slideLeft(i) {
          return slides[i].offsetLeft;
        }

        function goTo(i, user) {
          index = (i + slides.length) % slides.length;
          track.scrollTo({ left: slideLeft(index), behavior: reduceMotion ? 'auto' : 'smooth' });
          dots.forEach(function (d, di) { d.classList.toggle('is-active', di === index); });
          if (statusEl) statusEl.textContent = (index + 1) + ' / ' + slides.length;
          if (user) restart();
        }

        function nearestIndex() {
          var x = track.scrollLeft;
          var best = 0;
          var bestDist = Infinity;
          slides.forEach(function (slide, i) {
            var d = Math.abs(slide.offsetLeft - x);
            if (d < bestDist) { bestDist = d; best = i; }
          });
          return best;
        }

        function onScroll() {
          var i = nearestIndex();
          if (i === index) return;
          index = i;
          dots.forEach(function (d, di) { d.classList.toggle('is-active', di === index); });
          if (statusEl) statusEl.textContent = (index + 1) + ' / ' + slides.length;
        }

        function stop() {
          if (timer) { clearInterval(timer); timer = null; }
        }

        function start() {
          stop();
          if (paused || !autoplay) return;
          timer = setInterval(function () { goTo(index + 1, false); }, 5500);
        }

        function restart() {
          if (!paused) start();
        }

        function setPaused(next) {
          paused = next;
          if (pauseBtn) {
            pauseBtn.setAttribute('aria-pressed', paused ? 'true' : 'false');
            pauseBtn.setAttribute('aria-label', paused ? @json(__('Play autoplay')) : @json(__('Pause autoplay')));
            if (pauseIcon) pauseIcon.hidden = paused;
            if (playIcon) playIcon.hidden = !paused;
          }
          if (paused) stop(); else start();
        }

        if (prevBtn) prevBtn.addEventListener('click', function () { goTo(index - 1, true); });
        if (nextBtn) nextBtn.addEventListener('click', function () { goTo(index + 1, true); });
        if (slides.length < 2) {
          var controls = root.querySelector('.t-carousel__controls');
          if (controls) controls.hidden = true;
        }
        if (pauseBtn) {
          if (!autoplay) {
            pauseBtn.hidden = true;
          } else {
            pauseBtn.addEventListener('click', function () { setPaused(!paused); });
          }
        }

        track.addEventListener('scroll', function () {
          window.requestAnimationFrame(onScroll);
        }, { passive: true });

        track.addEventListener('keydown', function (e) {
          if (e.key === 'ArrowLeft') { e.preventDefault(); goTo(index - 1, true); }
          if (e.key === 'ArrowRight') { e.preventDefault(); goTo(index + 1, true); }
        });

        root.addEventListener('mouseenter', stop);
        root.addEventListener('mouseleave', function () { if (!paused) start(); });
        root.addEventListener('focusin', stop);
        root.addEventListener('focusout', function (e) {
          if (!root.contains(e.relatedTarget) && !paused) start();
        });

        if (typeof IntersectionObserver !== 'undefined') {
          var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
              if (!entry.isIntersecting) stop();
              else if (!paused) start();
            });
          }, { threshold: 0.25 });
          io.observe(root);
        }

        goTo(0, false);
        if (!paused) start();
      });
    })();
    </script>

    @stack('scripts')
</body>
</html>
