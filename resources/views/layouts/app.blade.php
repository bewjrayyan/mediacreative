<!DOCTYPE html>
<html lang="en">
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
        .nav-logo .logo-mark { width: 34px; height: 34px; border-radius: 9px; background: var(--primary); display: grid; place-items: center; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { color: var(--text-light); font-size: 14.5px; font-weight: 500; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        .nav-cta { display: flex; align-items: center; gap: 16px; }
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

        /* Hero */
        .hero { padding: 100px 0 90px; background: linear-gradient(180deg, #F0F7FF 0%, var(--bg) 100%); position: relative; overflow: hidden; }
        .hero-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center; }
        .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--primary); background: #fff; border: 1px solid var(--border); padding: 7px 14px; border-radius: 30px; margin-bottom: 24px; box-shadow: var(--shadow); }
        .hero h1 { font-size: clamp(36px, 5vw, 56px); font-weight: 800; margin-bottom: 20px; }
        .hero h1 .accent { color: var(--primary); }
        .hero-desc { font-size: 18px; color: var(--text-light); margin-bottom: 32px; max-width: 52ch; }
        .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
        .hero-stats { display: flex; gap: 48px; margin-top: 48px; padding-top: 32px; border-top: 1px solid var(--border); }
        .hero-stat h3 { font-size: 28px; font-weight: 800; color: var(--dark); }
        .hero-stat p { font-size: 13.5px; color: var(--text-muted); }
        .hero-visual { position: relative; }
        .hero-card { background: gradient(145deg, #fff, #f8fafc); border: 1px solid var(--border); border-radius: 20px; padding: 32px; box-shadow: var(--shadow-lg); }
        .hero-card h4 { margin-bottom: 16px; }
        .hero-card-row { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border-soft, #f1f5f9); font-size: 14px; }
        .hero-card-row:last-child { border: none; }
        .hero-card-row .dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 8px; }

        /* Services */
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
        .project-card { border-radius: 16px; overflow: hidden; border: 1px solid var(--border); background: var(--bg); transition: all .25s; }
        .project-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-4px); }
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
        .footer-social { display: flex; gap: 10px; }
        .footer-social a { width: 36px; height: 36px; border-radius: 8px; background: rgba(255,255,255,.08); display: grid; place-items: center; font-size: 16px; }
        .footer-social a:hover { background: var(--primary); }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.1); padding: 22px 0; font-size: 13px; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px; }

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
                <span class="logo-mark">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5z"/><circle cx="11" cy="11" r="2"/></svg>
                </span>
                {{ setting('site_name', 'DesignPro') }}
            </a>
            <div class="nav-links" id="navLinks">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'active' : '' }}">Services</a>
                <a href="{{ route('portfolio.index') }}" class="{{ request()->routeIs('portfolio.*') ? 'active' : '' }}">Portfolio</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                <a href="{{ route('contact.index') }}" class="{{ request()->routeIs('contact.*') ? 'active' : '' }}">Contact</a>
            </div>
            <div class="nav-cta">
                <a href="{{ route('contact.index') }}" class="btn btn-primary">Start a Project</a>
                <button class="nav-toggle" id="navToggle" aria-label="Toggle menu">
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
                        <span style="width:34px;height:34px;border-radius:9px;background:var(--primary);display:grid;place-items:center">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#fff" stroke-width="2.4"><path d="M12 19l7-7 3 3-7 7-3-3z"/></svg>
                        </span>
                        {{ setting('site_name', 'DesignPro') }}
                    </div>
                    <p class="footer-about">{{ setting('general.site_description', 'We design and build exceptional digital products.') }}</p>
                    <div class="footer-social">
                        @if(setting('social.facebook'))
                        <a href="{{ setting('social.facebook') }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                        @endif
                        @if(setting('social.instagram'))
                        <a href="{{ setting('social.instagram') }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1.2"/></svg></a>
                        @endif
                        @if(setting('social.linkedin'))
                        <a href="{{ setting('social.linkedin') }}" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4V9h4v1.5A6 6 0 0 1 16 8z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                        @endif
                        @if(setting('social.twitter'))
                        <a href="{{ setting('social.twitter') }}" target="_blank" rel="noopener" aria-label="X/Twitter"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18.9 1.2h3.7l-8.1 9.3L24 22.8h-7.4l-5.8-7.6-6.7 7.6H.4l8.7-9.9L0 1.2h7.6l5.3 7 6-7z"/></svg></a>
                        @endif
                        @if(setting('social.github'))
                        <a href="{{ setting('social.github') }}" target="_blank" rel="noopener" aria-label="GitHub"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C6.5 2 2 6.6 2 12a10 10 0 0 0 6.8 9.5c.5.1.7-.2.7-.5v-1.9c-2.8.6-3.4-1.2-3.4-1.2-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.4-1.1.7-1.3-2.2-.3-4.5-1.1-4.5-4.9 0-1.1.4-2 1-2.7-.1-.2-.4-1.2.1-2.6 0 0 .8-.3 2.7 1A9.4 9.4 0 0 1 12 6.3c.8 0 1.6.1 2.4.3 1.9-.7 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.6.6.7 1 1.6 1 2.7 0 3.8-2.3 4.6-4.5 4.9.4.3.7.9.7 1.9V21c0 .3.2.6.7.5A10 10 0 0 0 22 12c0-5.4-4.5-10-10-10z"/></svg></a>
                        @endif
                    </div>
                </div>
                <div>
                    <h4>Services</h4>
                    @php $footerServices = \App\Models\Service::active()->ordered()->take(5)->get(); @endphp
                    @foreach($footerServices as $s)
                        <a href="{{ route('services.show', $s->slug) }}">{{ $s->title }}</a>
                    @endforeach
                </div>
                <div>
                    <h4>Company</h4>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="{{ route('portfolio.index') }}">Portfolio</a>
                    <a href="{{ route('blog.index') }}">Blog</a>
                    <a href="{{ route('contact.index') }}">Contact</a>
                    @foreach(\App\Models\Page::active()->take(3)->get() as $page)
                        <a href="{{ route('pages.show', $page->slug) }}">{{ $page->title }}</a>
                    @endforeach
                </div>
                <div>
                    <h4>Get in Touch</h4>
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
                <span>Designed &amp; developed by {{ setting('site_name', 'DesignPro') }}</span>
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
        });
    </script>
    @stack('scripts')
</body>
</html>
