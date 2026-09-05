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

{{-- Google Reviews–style carousel --}}
@if($testimonials->count() > 0)
@php
    $reviewAvg = round($testimonials->avg('rating'), 1);
    $reviewCount = $testimonials->count();
    $starSvg = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>';
@endphp
<section class="section g-reviews">
    <div class="container">
        <div class="g-reviews__head">
            <div class="g-reviews__brand">
                <svg class="g-reviews__logo" viewBox="0 0 48 48" aria-hidden="true">
                    <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34.2 6.1 29.4 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.9z"/>
                    <path fill="#FF3D00" d="M6.3 14.7 12.9 19.6C14.7 15.1 19 12 24 12c3.1 0 5.8 1.2 7.9 3.1l5.7-5.7C34.2 6.1 29.4 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.3 35.3 26.8 36 24 36c-5.3 0-9.7-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                    <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.2-2.3 4.1-4.1 5.5l.1.1 6.3 5.3C39 37.3 44 33 44 24c0-1.3-.1-2.7-.4-3.9z"/>
                </svg>
                <div>
                    <h2>{{ __('Google Reviews') }}</h2>
                    <div class="g-reviews__meta">
                        <span class="g-reviews__score">{{ number_format($reviewAvg, 1) }}</span>
                        <span class="g-reviews__stars-inline" aria-hidden="true">
                            @for($i = 1; $i <= 5; $i++)
                                {!! $starSvg !!}
                            @endfor
                        </span>
                        <span>{{ $reviewCount }} {{ __('reviews') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="t-carousel" data-t-carousel>
            <div class="t-carousel__viewport">
                <div class="t-carousel__track" tabindex="0" aria-label="{{ __('Google Reviews') }}">
                    @foreach($testimonials as $testimonial)
                    <article class="t-carousel__slide" data-slide aria-roledescription="slide" aria-label="{{ ($loop->iteration) }} / {{ $testimonials->count() }}">
                        <div class="g-review-card">
                            <div class="g-review-card__top">
                                @if($testimonial->avatar)
                                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" class="g-review-card__avatar" alt="{{ $testimonial->client_name }}">
                                @else
                                    <div class="g-review-card__avatar" aria-hidden="true">{{ strtoupper(substr($testimonial->client_name, 0, 1)) }}</div>
                                @endif
                                <div class="g-review-card__who">
                                    <h4>{{ $testimonial->client_name }}</h4>
                                    <p>{{ $testimonial->role }}@if($testimonial->company), {{ $testimonial->company }}@endif</p>
                                </div>
                                <svg class="g-review-card__g" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                            </div>
                            <div class="g-review-card__stars" aria-label="{{ $testimonial->rating }} / 5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="{{ $i <= $testimonial->rating ? '' : 'is-empty' }}" aria-hidden="true"><path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                @endfor
                            </div>
                            <p class="g-review-card__body">{{ $testimonial->content }}</p>
                            <p class="g-review-card__source">{{ __('Posted on Google') }}</p>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            <div class="t-carousel__controls">
                <button type="button" class="t-carousel__btn" data-prev aria-label="{{ __('Previous') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <div class="t-carousel__dots" data-dots role="tablist" aria-label="{{ __('Google Reviews') }}"></div>
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
            <span class="cta-banner__glow cta-banner__glow--a" aria-hidden="true"></span>
            <span class="cta-banner__glow cta-banner__glow--b" aria-hidden="true"></span>
            <span class="cta-banner__glow cta-banner__glow--c" aria-hidden="true"></span>
            <span class="cta-banner__grid" aria-hidden="true"></span>
            <div class="cta-banner__inner">
                <p class="cta-banner__eyebrow">{{ __('Start a Project') }}</p>
                <h2>{{ __('Ready to Start Your Project?') }}</h2>
                <p>{{ __("Let's discuss how we can help bring your vision to life.") }}</p>
                <div class="cta-banner__actions">
                    <a href="{{ route('contact.index') }}" class="btn btn-primary btn-lg">
                        {{ __('Get in Touch') }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
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

  /* Testimonials carousel */
  document.querySelectorAll('[data-t-carousel]').forEach(function (root) {
    if (root.dataset.carouselReady === '1') return;
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

    var index = 0;
    var timer = null;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var autoplay = false;
    var paused = true;

    slides.forEach(function (_, i) {
      var dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 't-carousel__dot' + (i === 0 ? ' is-active' : '');
      dot.setAttribute('aria-label', (i + 1) + ' / ' + slides.length);
      dot.addEventListener('click', function () { goTo(i, true); });
      dotsWrap.appendChild(dot);
    });
    var dots = Array.prototype.slice.call(dotsWrap.querySelectorAll('.t-carousel__dot'));

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

