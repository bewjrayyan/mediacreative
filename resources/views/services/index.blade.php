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

<section class="section">
    <div class="container">
        <div class="section-head svc-section-head">
            <h2>{{ __('Services We Provide') }}</h2>
            <p>{{ __('From planning to deployment.') }}</p>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="m8 12 3 3 5-6"/></svg>
                </div>
                <h3>{{ $service->title }}</h3>
                <p>{{ Str::limit($service->description, 110) }}</p>
                <span class="service-link">{{ __('Learn more') }} →</span>
                @if($service->price_from)
                <div class="service-price">{{ __('Starting at') }} <strong>{{ format_price($service->price_from) }}</strong></div>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</section>

@if(count($flowSteps) > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-head svc-section-head">
            @if(setting('services_flow_heading'))
                <h2>{{ setting('services_flow_heading') }}</h2>
            @endif
            @if(setting('services_flow_subheading'))
                <p>{{ setting('services_flow_subheading') }}</p>
            @endif
        </div>
        <div class="svc-timeline">
            @foreach($flowSteps as $i => $step)
                @php
                    $title = is_array($step) ? ($step['title'] ?? '') : '';
                    $desc = is_array($step) ? ($step['description'] ?? '') : '';
                    $side = $i % 2 === 0 ? 'left' : 'right';
                @endphp
                @if($title !== '')
                <div class="svc-timeline__row svc-timeline__row--{{ $side }}">
                    <div class="svc-timeline__content">
                        <span class="svc-timeline__num">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
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
<section class="section">
    <div class="container">
        <div class="section-head svc-section-head">
            <h2>{{ __('Previous Clients') }}</h2>
            <p>{{ __("We've had the privilege of working with amazing businesses.") }}</p>
        </div>
        <div class="clients-row svc-clients">
            @foreach($clients as $client)
            <div class="client-logo">
                @if($client->logo)
                    <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" style="height:40px;width:auto;object-fit:contain;filter:grayscale(1);opacity:.75">
                @else
                    {{ strtoupper(substr($client->name, 0, 2)) }}
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="svc-hire">
    <div class="container">
        <div class="svc-hire__inner">
            <h2>{{ setting('services_bottom_cta_title') ?: __('Need Something Custom?') }}</h2>
            <p>{{ setting('services_bottom_cta_body') ?: __("Let's discuss your unique requirements and find the perfect solution.") }}</p>
            <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">{{ setting('services_bottom_cta_button') ?: __('Talk to Us') }}</a>
        </div>
    </div>
</section>
</div>
@endsection
