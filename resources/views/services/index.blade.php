@extends('layouts.app')

@section('title', __('Services') . ' - ' . setting('site_name', 'DesignPro'))

@section('content')
@php
    $flowSteps = setting_json('services_flow_steps', []);
    $techRaw = (string) setting('services_technologies', '');
    $technologies = array_values(array_filter(array_map('trim', explode(',', $techRaw))));
    $introBody = trim((string) setting('services_intro_body', ''));
    $introParagraphs = $introBody === '' ? [] : (preg_split("/\n\s*\n/", $introBody) ?: []);

    $techLogos = [
        'laravel' => 'laravel.svg',
        'react' => 'react.svg',
        'react native' => 'react.svg',
        'expo' => 'expo.svg',
        'tailwind css' => 'tailwindcss.svg',
        'tailwind' => 'tailwindcss.svg',
        'bootstrap' => 'bootstrap.svg',
        'ios' => 'apple.svg',
        'apple' => 'apple.svg',
        'android' => 'android.svg',
        'flutter' => 'flutter.svg',
        'swift' => 'swift.svg',
        'node' => 'nodedotjs.svg',
        'nodejs' => 'nodedotjs.svg',
        'node.js' => 'nodedotjs.svg',
        'typescript' => 'typescript.svg',
        'php' => 'php.svg',
    ];

    $flowIcons = [
        // Discovery
        '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/><path d="M11 8v6M8 11h6"/>',
        // Design
        '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
        // Development
        '<path d="m16 18 6-6-6-6"/><path d="m8 6-6 6 6 6"/>',
        // Testing
        '<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>',
        // Launch
        '<path d="M5 13c1.5-1.5 4-3 7.5-3S18.5 11.5 20 13"/><path d="M12 10V3l3 2"/><path d="M12 10 9 5"/><path d="m9 17 1.5 4h3L15 17"/><path d="M8 14c0 2-1 4-3 5 2 0 4-1 5-3"/><path d="M16 14c0 2 1 4 3 5-2 0-4-1-5-3"/>',
        // Support
        '<path d="M3 14v-3a9 9 0 0 1 18 0v3"/><path d="M21 16a2 2 0 0 1-2 2h-1v-6h1a2 2 0 0 1 2 2v2z"/><path d="M3 16a2 2 0 0 0 2 2h1v-6H5a2 2 0 0 0-2 2v2z"/><path d="M12 20a3 3 0 0 0 3-3"/>',
    ];

    $serviceAccents = ['#2563EB', '#0EA5E9', '#7C3AED', '#059669', '#D97706', '#DB2777'];
    $serviceIcons = [
        'palette' => '<path d="M12 22a1 1 0 0 1 0-8"/><path d="M12 2a10 10 0 0 1 0 20"/><circle cx="13.5" cy="6.5" r="1"/><circle cx="17.5" cy="10.5" r="1"/><circle cx="8.5" cy="7.5" r="1"/><circle cx="6.5" cy="12.5" r="1"/>',
        'code' => '<path d="m16 18 6-6-6-6"/><path d="m8 6-6 6 6 6"/>',
        'smartphone' => '<rect x="7" y="2" width="10" height="20" rx="2"/><path d="M11 18h2"/>',
        'globe' => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15 15 0 0 1 0 20"/><path d="M12 2a15 15 0 0 0 0 20"/>',
        'layers' => '<path d="m12 2 9 5-9 5-9-5z"/><path d="m3 12 9 5 9-5"/><path d="m3 17 9 5 9-5"/>',
        'zap' => '<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
        'default' => '<circle cx="12" cy="12" r="10"/><path d="m8 12 3 3 5-6"/>',
    ];
@endphp

<div class="services-page">
<section class="page-hero svc-hero">
    <div class="svc-hero-bg" aria-hidden="true">
        <div class="svc-hero-bg__orb svc-hero-bg__orb--1"></div>
        <div class="svc-hero-bg__orb svc-hero-bg__orb--2"></div>
        <div class="svc-hero-bg__orb svc-hero-bg__orb--3"></div>
        <div class="svc-hero-bg__grid"></div>
        <div class="svc-hero-bg__dots"></div>
        <div class="svc-hero-bg__beam"></div>
    </div>
    <div class="container">
        <div class="svc-hero-grid">
            <div class="svc-hero-copy">
                <p class="svc-kicker">{{ __('Services') }}</p>
                @if(setting('services_intro_title'))
                    <h1>{{ setting('services_intro_title') }}</h1>
                @else
                    <h1>{{ __('Our Services') }}</h1>
                @endif
                @foreach($introParagraphs as $para)
                    <p class="svc-hero-lead">{{ $para }}</p>
                @endforeach
                @if(setting('services_intro_stack'))
                    <div class="svc-hero-note">
                        <span class="svc-hero-note__icon" aria-hidden="true">💡</span>
                        <p>{{ setting('services_intro_stack') }}</p>
                    </div>
                @endif
                <div class="svc-hero-actions">
                    <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">{{ setting('services_bottom_cta_button') ?: __('Get in Touch') }}</a>
                    <a href="{{ route('portfolio.index') }}" class="btn btn-outline btn-lg">{{ __('View Our Work') }}</a>
                </div>
            </div>
            <div class="svc-hero-visual">
                <div class="svc-hero-panel">
                    <div class="svc-hero-panel__head">
                        <span class="svc-hero-panel__dot"></span>
                        {{ __('From planning to deployment.') }}
                    </div>
                    <ul class="svc-hero-panel__list">
                        <li>
                            <strong>01</strong>
                            <span>{{ __('UI / UX Design') }}</span>
                        </li>
                        <li>
                            <strong>02</strong>
                            <span>{{ __('Mobile App Development') }}</span>
                        </li>
                        <li>
                            <strong>03</strong>
                            <span>{{ __('API & Admin Web') }}</span>
                        </li>
                    </ul>
                    @if(count($technologies) > 0)
                        <div class="svc-hero-panel__tags">
                            @foreach(array_slice($technologies, 0, 6) as $tech)
                                <span>{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section services-page-list">
    <div class="container">
        <div class="section-head svc-section-head">
            <h2>{{ __('Services We Provide') }}</h2>
            <p>{{ __('From planning to deployment.') }}</p>
        </div>
        <div class="t-carousel" data-t-carousel>
            <div class="t-carousel__viewport">
                <div class="t-carousel__track" tabindex="0" aria-label="{{ __('Services') }}">
                    @foreach($services as $index => $service)
                        @php
                            $accent = $serviceAccents[$index % count($serviceAccents)];
                            $iconKey = strtolower(trim((string) ($service->icon ?: 'default')));
                            $iconPath = $serviceIcons[$iconKey] ?? $serviceIcons['default'];
                        @endphp
                        <article class="t-carousel__slide" data-slide aria-roledescription="slide" aria-label="{{ ($loop->iteration) }} / {{ $services->count() }}">
                            <a
                                href="{{ route('services.show', $service->slug) }}"
                                class="service-tile service-tile--mesh"
                                style="--accent: {{ $accent }}"
                            >
                                <div class="service-tile__inner">
                                    <div class="service-tile__top">
                                        <div class="service-tile__icon" aria-hidden="true">
                                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $iconPath !!}</svg>
                                        </div>
                                        <span class="service-tile__index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                    <h3>{{ $service->title }}</h3>
                                    <p>{{ Str::limit($service->description, 110) }}</p>
                                    <div class="service-tile__meta">
                                        <span class="service-tile__link">
                                            {{ __('See') }}
                                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                                        </span>
                                        @if($service->price_from)
                                            <span class="service-tile__price">{{ __('From') }} <strong>{{ format_price($service->price_from) }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="t-carousel__controls">
                <button type="button" class="t-carousel__btn" data-prev aria-label="{{ __('Previous') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="t-carousel__dots" data-dots role="tablist" aria-label="{{ __('Services') }}"></div>
                <button type="button" class="t-carousel__btn" data-next aria-label="{{ __('Next') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                <button type="button" class="t-carousel__pause" data-pause aria-pressed="false" aria-label="{{ __('Pause autoplay') }}" hidden>
                    <svg data-icon="pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 5h3v14H7zm7 0h3v14h-3z"/></svg>
                    <svg data-icon="play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" hidden><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>
            <p class="t-carousel__status" data-status aria-live="polite"></p>
        </div>
    </div>
</section>

@if(count($flowSteps) > 0)
<section class="section section-alt svc-flow">
    <div class="container">
        <div class="section-head svc-section-head">
            @if(setting('services_flow_heading'))
                <h2>{{ setting('services_flow_heading') }}</h2>
            @endif
            @if(setting('services_flow_subheading'))
                <p>{{ setting('services_flow_subheading') }}</p>
            @endif
        </div>
        <div class="svc-timeline svc-timeline--journey" role="list">
            @foreach($flowSteps as $i => $step)
                @php
                    $title = is_array($step) ? ($step['title'] ?? '') : '';
                    $desc = is_array($step) ? ($step['description'] ?? '') : '';
                    $side = $i % 2 === 0 ? 'left' : 'right';
                    $stepAccent = ['#2563EB', '#0EA5E9', '#7C3AED', '#059669', '#D97706', '#DB2777'][$i % 6];
                @endphp
                @if($title !== '')
                <div
                    class="svc-timeline__row svc-timeline__row--{{ $side }}"
                    role="listitem"
                    style="--step-accent: {{ $stepAccent }}; --step-i: {{ $i }};"
                >
                    <div class="svc-timeline__content">
                        <div class="svc-timeline__head">
                            <span class="svc-timeline__chip">{{ __('Step') }} {{ $i + 1 }}</span>
                        </div>
                        <h3>{{ $title }}</h3>
                        @if($desc !== '')
                            <p>{{ $desc }}</p>
                        @endif
                    </div>
                    <div class="svc-timeline__node" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $flowIcons[$i % count($flowIcons)] !!}</svg>
                    </div>
                    <div class="svc-timeline__spacer" aria-hidden="true"></div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</section>
@endif

@if(count($technologies) > 0)
<section class="section">
    <div class="container">
        <div class="section-head svc-section-head">
            @if(setting('services_tech_heading'))
                <h2>{{ setting('services_tech_heading') }}</h2>
            @endif
            @if(setting('services_tech_subheading'))
                <p>{{ setting('services_tech_subheading') }}</p>
            @endif
        </div>
        <ul class="svc-tech-grid">
            @foreach($technologies as $tech)
                @php
                    $logoFile = $techLogos[strtolower($tech)] ?? null;
                    $logoUrl = $logoFile ? asset('images/tech/' . $logoFile) : null;
                @endphp
                <li>
                    <div class="svc-tech-grid__icon">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $tech }}" width="72" height="72" loading="lazy">
                        @else
                            <span>{{ strtoupper(substr($tech, 0, 1)) }}</span>
                        @endif
                    </div>
                    <span class="svc-tech-grid__label">{{ $tech }}</span>
                </li>
            @endforeach
        </ul>
    </div>
</section>
@endif

@if(setting('services_quote'))
<section class="svc-quote-band">
    <div class="container">
        <blockquote>
            <p>“{{ setting('services_quote') }}”</p>
        </blockquote>
    </div>
</section>
@endif

@if(isset($clients) && $clients->count() > 0)
<section class="section svc-clients-section">
    <div class="container">
        <div class="section-head svc-section-head">
            <h2>{{ __('Previous Clients') }}</h2>
            <p>{{ __("We've had the privilege of working with amazing businesses.") }}</p>
        </div>
        <div class="t-carousel t-carousel--clients" data-t-carousel>
            <div class="t-carousel__viewport">
                <div class="t-carousel__track" tabindex="0" aria-label="{{ __('Previous Clients') }}">
                    @foreach($clients as $client)
                        <article
                            class="t-carousel__slide"
                            data-slide
                            aria-roledescription="slide"
                            aria-label="{{ $client->name }} · {{ $loop->iteration }} / {{ $clients->count() }}"
                        >
                            <div class="client-logo client-logo--card">
                                @if($client->logo)
                                    <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" loading="lazy">
                                @else
                                    <span class="client-logo__fallback">{{ strtoupper(substr($client->name, 0, 2)) }}</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
            <div class="t-carousel__controls">
                <button type="button" class="t-carousel__btn" data-prev aria-label="{{ __('Previous') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="t-carousel__dots" data-dots role="tablist" aria-label="{{ __('Previous Clients') }}"></div>
                <button type="button" class="t-carousel__btn" data-next aria-label="{{ __('Next') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                </button>
                <button type="button" class="t-carousel__pause" data-pause aria-pressed="false" aria-label="{{ __('Pause autoplay') }}" hidden>
                    <svg data-icon="pause" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 5h3v14H7zm7 0h3v14h-3z"/></svg>
                    <svg data-icon="play" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" hidden><path d="M8 5v14l11-7z"/></svg>
                </button>
            </div>
            <p class="t-carousel__status" data-status aria-live="polite"></p>
        </div>
    </div>
</section>
@endif

<section class="svc-hire">
    <span class="svc-hire__glow svc-hire__glow--a" aria-hidden="true"></span>
    <span class="svc-hire__glow svc-hire__glow--b" aria-hidden="true"></span>
    <span class="svc-hire__glow svc-hire__glow--c" aria-hidden="true"></span>
    <span class="svc-hire__grid" aria-hidden="true"></span>
    <div class="container">
        <div class="svc-hire__inner">
            <p class="svc-hire__eyebrow">{{ __('Start a Project') }}</p>
            <h2>{{ setting('services_bottom_cta_title') ?: __('Need Something Custom?') }}</h2>
            <p>{{ setting('services_bottom_cta_body') ?: __("Let's discuss your unique requirements and find the perfect solution.") }}</p>
            <div class="svc-hire__actions">
                <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                    {{ setting('services_bottom_cta_button') ?: __('Talk to Us') }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
