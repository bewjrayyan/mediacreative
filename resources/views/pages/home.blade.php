@extends('layouts.app')

@section('title', setting_trans('hero_heading', 'We Design & Build Digital Products That Make an Impact'))

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="hero-bg" aria-hidden="true">
        <div class="hero-bg__orb hero-bg__orb--1"></div>
        <div class="hero-bg__orb hero-bg__orb--2"></div>
        <div class="hero-bg__orb hero-bg__orb--3"></div>
        <div class="hero-bg__orb hero-bg__orb--4"></div>
        <div class="hero-bg__orb hero-bg__orb--5"></div>
        <div class="hero-bg__beam"></div>
        <div class="hero-bg__grid"></div>
    </div>
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h8l-6.5 5 2.5 7.5L12 16l-7 5.5 2.5-7.5L1 9h8z"/></svg>
                    {{ setting_trans('tagline', 'Design & Development') }}
                </div>
                @php
                    $heroHeadingPlain = trim(preg_replace('/\s+/u', ' ', strip_tags(setting_trans('hero_heading', 'We Design & Build Digital Products That Make an Impact'))));
                    $heroWords = $heroHeadingPlain === '' ? [] : explode(' ', $heroHeadingPlain);
                    $heroAccentCount = min(3, max(1, (int) ceil(count($heroWords) / 3)));
                    $heroBaseWords = array_slice($heroWords, 0, max(0, count($heroWords) - $heroAccentCount));
                    $heroAccentWords = array_slice($heroWords, max(0, count($heroWords) - $heroAccentCount));
                @endphp
                <h1 class="hero-title">
                    @if(count($heroWords) > 1)
                        <span class="hero-title__base">{{ implode(' ', $heroBaseWords) }} </span><span class="hero-title__accent">{{ implode(' ', $heroAccentWords) }}</span>
                    @else
                        <span class="hero-title__accent">{{ $heroHeadingPlain }}</span>
                    @endif
                </h1>
                <p class="hero-desc">{{ setting_trans('hero_subheading', 'We are a full-service agency specializing in UI/UX design, web application development, and digital solutions that help ambitious businesses grow.') }}</p>
                <div class="hero-cta">
                    <a href="{{ setting('cta_link', '/contact') }}" class="btn btn-primary btn-lg">
                        {{ setting_trans('cta_text', 'Start Your Project') }}
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('portfolio.index') }}" class="btn btn-outline btn-lg">{{ __('View Our Work') }}</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <h3>{{ \App\Models\Project::published()->count() }}+</h3>
                        <p>{{ __('Projects Delivered') }}</p>
                    </div>
                    <div class="hero-stat">
                        <h3>{{ \App\Models\Client::active()->count() }}+</h3>
                        <p>{{ __('Happy Clients') }}</p>
                    </div>
                    <div class="hero-stat">
                        <h3>{{ \App\Models\TeamMember::active()->count() }}</h3>
                        <p>{{ __('Team Members') }}</p>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                @php
                    $heroImage = setting('hero_image');
                    $heroImageUrl = $heroImage ? asset('storage/' . ltrim((string) $heroImage, '/')) : null;
                @endphp
                @if($heroImageUrl)
                    <div class="hero-visual__stack">
                        <div class="hero-visual__plate" aria-hidden="true"></div>
                        <div class="hero-visual__ring" aria-hidden="true"></div>
                        <figure class="hero-image">
                            <img src="{{ $heroImageUrl }}" alt="{{ setting('site_name', 'DesignPro') }}">
                            <span class="hero-image__shine" aria-hidden="true"></span>
                            <span class="hero-image__vignette" aria-hidden="true"></span>
                        </figure>
                        <div class="hero-visual__badge">
                            <strong>{{ __('Studio work') }}</strong>
                            <span>{{ __('Crafted for impact') }}</span>
                        </div>
                        <div class="hero-visual__chip">
                            <span class="hero-visual__chip-dot"></span>
                            {{ __('Live projects') }}
                        </div>
                    </div>
                @else
                    <div class="hero-card">
                        <h4>{{ __('Latest Projects') }}</h4>
                        @foreach(\App\Models\Project::published()->featured()->take(3)->get() as $p)
                        <div class="hero-card-row">
                            <span><span class="dot" style="background:var(--primary);"></span>{{ $p->title }}</span>
                            <span style="color:var(--text-muted)">{{ $p->category }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Services Overview — bento showcase --}}
@php
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
<section class="section section-services" id="services">
    <div class="container">
        <div class="section-intro" data-reveal>
            <div>
                <span class="section-eyebrow">{{ __('What We Do') }}</span>
                <h2>{{ __('Services built for ambitious brands') }}</h2>
            </div>
            <div class="section-intro__copy">
                <p>{{ __('From design to development, we provide comprehensive digital solutions tailored to your needs.') }}</p>
                <a href="{{ route('services.index') }}" class="btn btn-outline">{{ __('Explore all services') }}</a>
            </div>
        </div>

        <div class="services-bento">
            @foreach($services as $index => $service)
                @php
                    $accent = $serviceAccents[$index % count($serviceAccents)];
                    $iconKey = strtolower(trim((string) ($service->icon ?: 'default')));
                    $iconPath = $serviceIcons[$iconKey] ?? $serviceIcons['default'];
                @endphp
                <a
                    href="{{ route('services.show', $service->slug) }}"
                    class="service-tile"
                    style="--accent: {{ $accent }}; --reveal-delay: {{ min($index * 70, 280) }}ms"
                    data-reveal
                >
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
                            {{ __('Learn more') }}
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                        </span>
                        @if($service->price_from)
                            <span class="service-tile__price">{{ __('From') }} <strong>{{ format_price($service->price_from) }}</strong></span>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Projects --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">{{ __('Portfolio') }}</span>
            <h2>{{ __('Featured Projects') }}</h2>
            <p>{{ __('Check out some of our recent work for clients across various industries.') }}</p>
        </div>
        <div class="portfolio-grid">
            @foreach($featuredProjects as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="project-card">
                <div class="project-thumb">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
                    @else
                        <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">{{ __('No Image') }}</div>
                    @endif
                </div>
                <div class="project-body">
                    <span class="project-cat">{{ $project->category }}</span>
                    <h3>{{ $project->title }}</h3>
                    <p>{{ Str::limit($project->description, 80) }}</p>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:40px">
            <a href="{{ route('portfolio.index') }}" class="btn btn-outline btn-lg">{{ __('View All Projects') }}</a>
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if($testimonials->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">{{ __('Testimonials') }}</span>
            <h2>{{ __('What Our Clients Say') }}</h2>
            <p>{{ __("Don't just take our word for it — hear from some of our happy clients.") }}</p>
        </div>
        <div class="testimonial-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="testimonial-stars">{{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}</div>
                <p class="testimonial-content">"{{ $testimonial->content }}"</p>
                <div class="testimonial-author">
                    @if($testimonial->avatar)
                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" class="testimonial-avatar" alt="{{ $testimonial->client_name }}">
                    @else
                        <div class="testimonial-avatar">{{ strtoupper(substr($testimonial->client_name, 0, 2)) }}</div>
                    @endif
                    <div>
                        <h4>{{ $testimonial->client_name }}</h4>
                        <p>{{ $testimonial->role }}@if($testimonial->company), {{ $testimonial->company }}@endif</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Clients --}}
@if($clients->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">{{ __('Clients') }}</span>
            <h2>{{ __('Trusted by Great Companies') }}</h2>
            <p>{{ __("We've had the privilege of working with amazing businesses.") }}</p>
        </div>
        <div class="clients-row">
            @foreach($clients as $client)
            <div class="client-logo">
                @if($client->logo)
                    <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }}" style="height:36px;width:auto;object-fit:contain">
                @else
                    {{ strtoupper(substr($client->name, 0, 2)) }}
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>{{ __('Ready to Start Your Project?') }}</h2>
            <p>{{ __("Let's discuss how we can help bring your vision to life.") }}</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">{{ __('Get in Touch') }}</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
  var hero = document.querySelector('section.hero');
  if (hero) {
    var palette = [
      '#22d3ee', '#38bdf8', '#60a5fa', '#818cf8', '#a78bfa',
      '#c084fc', '#e879f9', '#f472b6', '#fb7185', '#fb923c',
      '#fbbf24', '#a3e635', '#34d399', '#2dd4bf', '#f43f5e'
    ];

    function pick() {
      return palette[Math.floor(Math.random() * palette.length)];
    }

    function shuffleDistinct(count) {
      var used = {};
      var out = [];
      var guard = 0;
      while (out.length < count && guard < 80) {
        guard += 1;
        var c = pick();
        if (!used[c]) {
          used[c] = true;
          out.push(c);
        }
      }
      while (out.length < count) out.push(pick());
      return out;
    }

    function applyColors() {
      var colors = shuffleDistinct(5);
      hero.style.setProperty('--orb-1', colors[0]);
      hero.style.setProperty('--orb-2', colors[1]);
      hero.style.setProperty('--orb-3', colors[2]);
      hero.style.setProperty('--orb-4', colors[3]);
      hero.style.setProperty('--orb-5', colors[4]);
    }

    applyColors();
    setInterval(applyColors, 9000);
  }

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var nodes = document.querySelectorAll('[data-reveal]');
  if (!nodes.length) return;

  if (reduceMotion || !('IntersectionObserver' in window)) {
    nodes.forEach(function (el) { el.classList.add('is-visible'); });
    return;
  }

  var io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      entry.target.classList.add('is-visible');
      io.unobserve(entry.target);
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -6% 0px' });

  nodes.forEach(function (el) { io.observe(el); });
})();
</script>
@endpush

