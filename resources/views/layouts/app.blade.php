<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: var(--bg); line-height: 1.7; -webkit-font-smoothing: antialiased; }
        h1,h2,h3,h4,h5 { font-family: 'Inter Tight', sans-serif; color: var(--dark); line-height: 1.2; letter-spacing: -0.02em; }
        a { color: var(--primary); text-decoration: none; }
        img { max-width: 100%; display: block; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section { padding: 90px 0; }
        .section-alt { background: var(--bg-soft); }
        .section-head { text-align: center; max-width: 640px; margin: 0 auto 56px; }
        .section-eyebrow { display: inline-block; font-size: 13px; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.08em; background: var(--primary-light); padding: 6px 14px; border-radius: 20px; margin-bottom: 16px; }
        .section-head h2 { font-size: clamp(28px, 4vw, 40px); margin-bottom: 12px; }
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
        .hero-cta .btn-outline {
            border-color: rgba(148, 163, 184, 0.35); color: #E2E8F0; background: transparent;
        }
        .hero-cta .btn-outline:hover {
            border-color: #F8FAFC; color: #F8FAFC; background: rgba(255,255,255,.06);
        }
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
            font-size: clamp(32px, 4.5vw, 48px);
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
            .service-tile,
            .service-tile--feature {
                background: rgba(255,255,255,0.94);
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
        .service-card { background: var(--bg); border: 1px solid var(--border); border-radius: 18px; padding: 32px; transition: all .25s; cursor: pointer; position: relative; }
        .service-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); border-color: var(--primary); }
        .service-icon { width: 52px; height: 52px; border-radius: 13px; background: var(--primary-light); color: var(--primary); display: grid; place-items: center; margin-bottom: 20px; }
        .service-card h3 { font-size: 19px; margin-bottom: 10px; }
        .service-card p { font-size: 14.5px; color: var(--text-light); margin-bottom: 18px; }
        .service-link { font-size: 14px; font-weight: 600; color: var(--primary); display: inline-flex; align-items: center; gap: 6px; }
        .service-price { font-size: 13px; color: var(--text-muted); margin-top: 12px; }
        .service-price strong { color: var(--dark); }

        /* Portfolio */
        .portfolio-filter { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-bottom: 40px; }
        .filter-btn { padding: 9px 20px; border-radius: 30px; border: 1.5px solid var(--border); background: transparent; color: var(--text-light); font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Inter', sans-serif; transition: all .2s; }
        .filter-btn.active, .filter-btn:hover { border-color: var(--primary); background: var(--primary); color: #fff; }
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
        .project-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
        .project-card:hover .project-thumb img { transform: scale(1.05); }
        .project-body { padding: 22px; }
        .project-cat { font-size: 12px; font-weight: 600; color: var(--primary); text-transform: uppercase; letter-spacing: 0.06em; }
        .project-body h3 { font-size: 18px; margin: 8px 0; }
        .project-body p { font-size: 14px; color: var(--text-light); }

        /* Testimonials */
        .testimonial-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 26px; }
        .testimonial-card { background: var(--bg); border: 1px solid var(--border); border-radius: 18px; padding: 30px; transition: all .25s; }
        .testimonial-card:hover { box-shadow: var(--shadow); }
        .testimonial-stars { color: var(--warning); font-size: 16px; margin-bottom: 16px; }
        .testimonial-content { font-size: 15px; color: var(--text); font-style: italic; margin-bottom: 22px; }
        .testimonial-author { display: flex; align-items: center; gap: 12px; }
        .testimonial-avatar { width: 44px; height: 44px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: grid; place-items: center; font-weight: 700; font-size: 15px; }
        .testimonial-author h4 { font-size: 15px; }
        .testimonial-author p { font-size: 13px; color: var(--text-muted); }

        /* Clients logos */
        .clients-row { display: flex; align-items: center; justify-content: center; gap: 44px; flex-wrap: wrap; }
        .client-logo { font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 22px; color: var(--text-muted); opacity: .7; transition: all .2s; display: flex; align-items: center; gap: 8px; }
        .client-logo:hover { opacity: 1; color: var(--dark); }

        /* CTA */
        .cta-banner { background: linear-gradient(135deg, var(--primary) 0%, #7C3AED 100%); border-radius: 24px; padding: 64px 48px; text-align: center; color: #fff; position: relative; overflow: hidden; }
        .cta-banner h2 { color: #fff; font-size: clamp(28px, 4vw, 38px); margin-bottom: 12px; }
        .cta-banner p { color: rgba(255,255,255,.85); font-size: 17px; margin-bottom: 28px; }
        .cta-banner .btn { background: #fff; color: var(--primary); }
        .cta-banner .btn:hover { background: var(--bg-soft); }

        /* Footer */
        .footer { background: var(--dark); color: var(--text-muted); padding-top: 70px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1.5fr; gap: 40px; padding-bottom: 40px; }
        .footer h4 { color: #fff; font-size: 15px; margin-bottom: 16px; }
        .footer a { color: var(--text-muted); font-size: 14px; display: block; margin-bottom: 10px; transition: color .2s; }
        .footer a:hover { color: #fff; }
        .footer-logo { display: flex; align-items: center; gap: 10px; font-family: 'Inter Tight', sans-serif; font-weight: 800; font-size: 20px; color: #fff; margin-bottom: 14px; }
        .footer-about { font-size: 14px; margin-bottom: 20px; max-width: 32ch; }
        .footer-social, .social-links { display: flex; flex-wrap: wrap; gap: 10px; }
        .social-btn {
            width: 42px; height: 42px; border-radius: 12px;
            display: grid; place-items: center;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.12);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }
        .social-btn svg { width: 18px; height: 18px; display: block; }
        .social-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18); filter: brightness(1.06); }
        .social-btn--facebook { background: #1877F2; }
        .social-btn--instagram {
            background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);
        }
        .social-btn--linkedin { background: #0A66C2; }
        .social-btn--x { background: #111827; }
        .social-btn--github { background: #24292F; }
        .footer .social-btn { box-shadow: none; }
        .footer .social-btn:hover { box-shadow: 0 6px 16px rgba(0,0,0,.28); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding: 22px 0; font-size: 13px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }


        /* Services page — irekasoft-style extras */
        .services-page .svc-section-head h2 {
            color: var(--primary);
            font-size: clamp(26px, 3.2vw, 34px);
        }
        .services-page .page-hero.svc-hero {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            background: linear-gradient(145deg, #0B1220 0%, #111827 45%, #0F172A 100%);
            color: #fff;
            text-align: left;
            padding: 88px 0 72px;
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
            color: #fff;
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
        .services-page .page-hero .btn-outline {
            border-color: rgba(255,255,255,.35);
            color: #fff;
            background: transparent;
        }
        .services-page .page-hero .btn-outline:hover {
            background: rgba(255,255,255,.1);
            border-color: #fff;
        }
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
            box-shadow: 0 20px 50px rgba(0,0,0,.28);
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
            background: linear-gradient(145deg, #3B82F6 0%, #2563EB 55%, #1D4ED8 100%);
            border: 3px solid #EFF6FF;
            box-shadow:
                0 0 0 6px rgba(37,99,235,.12),
                0 10px 24px rgba(37,99,235,.28);
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
                0 0 0 8px rgba(37,99,235,.16),
                0 14px 30px rgba(37,99,235,.34);
        }
        .svc-timeline__content {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px 24px;
            box-shadow: 0 8px 24px rgba(15,23,42,.06);
        }
        .svc-timeline__num {
            display: inline-block;
            font-family: 'Inter Tight', sans-serif;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: .1em;
            color: var(--primary);
            margin-bottom: 8px;
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
            grid-template-columns: repeat(4, 1fr);
            gap: 36px 24px;
            max-width: 960px;
            margin-inline: auto;
        }
        .svc-tech-grid li {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
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
            box-shadow: 0 10px 28px rgba(15,23,42,.07);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .svc-tech-grid__icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 34px rgba(15,23,42,.12);
        }
        .svc-tech-grid__icon img {
            width: 72px;
            height: 72px;
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

        .svc-hire {
            background: linear-gradient(135deg, #1D4ED8 0%, #1E3A8A 55%, #312E81 100%);
            padding: 72px 0;
            color: #fff;
        }
        .svc-hire__inner {
            max-width: 720px;
            margin: 0 auto;
            text-align: center;
        }
        .svc-hire h2 {
            color: #fff;
            font-size: clamp(26px, 3.5vw, 36px);
            margin: 0 0 14px;
            line-height: 1.2;
        }
        .svc-hire p {
            color: rgba(255,255,255,.85);
            font-size: 17px;
            margin: 0 0 28px;
            line-height: 1.65;
        }
        .svc-hire .btn-primary {
            background: #fff;
            color: #1D4ED8;
            border-color: #fff;
        }
        .svc-hire .btn-primary:hover {
            background: #EFF6FF;
            color: #1E40AF;
        }

        @media (max-width: 900px) {
            .svc-timeline::before { left: 28px; transform: none; }
            .svc-timeline__row {
                grid-template-columns: 56px 1fr;
                gap: 16px;
            }
            .svc-timeline__row--left .svc-timeline__node,
            .svc-timeline__row--right .svc-timeline__node { grid-column: 1; grid-row: 1; }
            .svc-timeline__row--left .svc-timeline__content,
            .svc-timeline__row--right .svc-timeline__content {
                grid-column: 2;
                grid-row: 1;
                text-align: left;
            }
            .svc-timeline__spacer { display: none; }
            .svc-tech-grid { grid-template-columns: repeat(2, 1fr); }
            .services-page .page-hero { text-align: left; padding: 64px 0 52px; }
            .svc-hero-grid { grid-template-columns: 1fr; gap: 28px; }
        }

        /* Page hero (inner pages) */
        .page-hero { background: linear-gradient(180deg, #F0F7FF, var(--bg)); padding: 70px 0 56px; text-align: center; }
        .page-hero h1 { font-size: clamp(32px, 4vw, 44px); margin-bottom: 12px; }
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
    </style>
    @stack('styles')
</head>
<body>
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
                <div>
                    <div class="footer-logo">
                        <span class="logo-mark{{ $siteLogoUrl ? ' logo-mark--image' : '' }}" style="width:34px;height:34px;border-radius:9px;{{ $siteLogoUrl ? 'background:transparent;overflow:hidden;' : 'background:var(--primary);' }}display:grid;place-items:center">
                            @if($siteLogoUrl)
                                <img src="{{ $siteLogoUrl }}" alt="{{ setting('site_name', 'DesignPro') }}" style="width:100%;height:100%;object-fit:contain">
                            @else
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 19l7-7 3 3-7 7-3-3z"/></svg>
                            @endif
                        </span>
                        {{ setting('site_name', 'DesignPro') }}
                    </div>
                    <p class="footer-about">{{ setting('general.site_description', 'We design and build exceptional digital products.') }}</p>
                    <div class="footer-social social-links">
                        @if(setting('social.facebook'))
                        <a class="social-btn social-btn--facebook" href="{{ setting('social.facebook') }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14C17.17 2.09 15.92 2 14.71 2 11.93 2 10 3.66 10 6.79V9.5H7v4h3V22h4z"/></svg></a>
                        @endif
                        @if(setting('social.instagram'))
                        <a class="social-btn social-btn--instagram" href="{{ setting('social.instagram') }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm11.5 1.5a1.25 1.25 0 1 1 0 2.5 1.25 1.25 0 0 1 0-2.5zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg></a>
                        @endif
                        @if(setting('social.linkedin'))
                        <a class="social-btn social-btn--linkedin" href="{{ setting('social.linkedin') }}" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.94 6.5A2.19 2.19 0 1 1 4.76 4.3 2.19 2.19 0 0 1 6.94 6.5zM7 8.86H2.75V21H7zm5.5 0h-4.2V21h4.2v-6.55c0-1.73.82-2.84 2.33-2.84 1.4 0 2.07.96 2.07 2.84V21H21v-7.17c0-3.66-1.96-5.36-4.57-5.36a4.1 4.1 0 0 0-3.93 2.17V8.86z"/></svg></a>
                        @endif
                        @if(setting('social.twitter'))
                        <a class="social-btn social-btn--x" href="{{ setting('social.twitter') }}" target="_blank" rel="noopener" aria-label="X/Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.9 1.2h3.7l-8.1 9.3L24 22.8h-7.4l-5.8-7.6-6.7 7.6H.4l8.7-9.9L0 1.2h7.6l5.3 7 6-7z"/></svg></a>
                        @endif
                        @if(setting('social.github'))
                        <a class="social-btn social-btn--github" href="{{ setting('social.github') }}" target="_blank" rel="noopener" aria-label="GitHub"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.5 2 2 6.6 2 12a10 10 0 0 0 6.8 9.5c.5.1.7-.2.7-.5v-1.9c-2.8.6-3.4-1.2-3.4-1.2-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.4-1.1.7-1.3-2.2-.3-4.5-1.1-4.5-4.9 0-1.1.4-2 1-2.7-.1-.2-.4-1.2.1-2.6 0 0 .8-.3 2.7 1A9.4 9.4 0 0 1 12 6.3c.8 0 1.6.1 2.4.3 1.9-.7 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.6.6.7 1 1.6 1 2.7 0 3.8-2.3 4.6-4.5 4.9.4.3.7.9.7 1.9V21c0 .3.2.6.7.5A10 10 0 0 0 22 12c0-5.4-4.5-10-10-10z"/></svg></a>
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
    @stack('scripts')
</body>
</html>
