@extends('layouts.app')

@section('title', setting('home.hero_heading', 'We Design & Build Digital Products That Make an Impact'))

@section('content')
{{-- Hero --}}
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3 7h8l-6.5 5 2.5 7.5L12 16l-7 5.5 2.5-7.5L1 9h8z"/></svg>
                    {{ setting('general.tagline', 'Design & Development') }}
                </div>
                <h1>{!! setting('home.hero_heading', 'We Design & Build Digital Products That Make an Impact') !!}</h1>
                <p class="hero-desc">{{ setting('home.hero_subheading', 'We are a full-service agency specializing in UI/UX design, web application development, and digital solutions that help ambitious businesses grow.') }}</p>
                <div class="hero-cta">
                    <a href="{{ setting('home.cta_link', '/contact') }}" class="btn btn-primary btn-lg">
                        {{ setting('home.cta_text', 'Start Your Project') }}
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('portfolio.index') }}" class="btn btn-outline btn-lg">View Our Work</a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <h3>{{ \App\Models\Project::published()->count() }}+</h3>
                        <p>Projects Delivered</p>
                    </div>
                    <div class="hero-stat">
                        <h3>{{ \App\Models\Client::active()->count() }}+</h3>
                        <p>Happy Clients</p>
                    </div>
                    <div class="hero-stat">
                        <h3>{{ \App\Models\TeamMember::active()->count() }}</h3>
                        <p>Team Members</p>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-card">
                    <h4>Latest Projects</h4>
                    @foreach(\App\Models\Project::published()->featured()->take(3)->get() as $p)
                    <div class="hero-card-row">
                        <span><span class="dot" style="background:var(--{{ ['var(--primary)', 'var(--purple)', 'var(--success)'][array_rand(['var(--primary)', 'var(--purple)', 'var(--success)'])] }});"></span>{{ $p->title }}</span>
                        <span style="color:var(--text-muted)">{{ $p->category }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Services Overview --}}
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">What We Do</span>
            <h2>Our Services</h2>
            <p>From design to development, we provide comprehensive digital solutions tailored to your needs.</p>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
            <a href="{{ route('services.show', $service->slug) }}" class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><path d="m8 12 3 3 5-6"/></svg>
                </div>
                <h3>{{ $service->title }}</h3>
                <p>{{ Str::limit($service->description, 110) }}</p>
                <span class="service-link">Learn more →</span>
                @if($service->price_from)
                <div class="service-price">Starting at <strong>${{ number_format($service->price_from) }}</strong></div>
                @endif
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Projects --}}
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">Portfolio</span>
            <h2>Featured Projects</h2>
            <p>Check out some of our recent work for clients across various industries.</p>
        </div>
        <div class="portfolio-grid">
            @foreach($featuredProjects as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="project-card">
                <div class="project-thumb">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
                    @else
                        <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">No Image</div>
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
            <a href="{{ route('portfolio.index') }}" class="btn btn-outline btn-lg">View All Projects</a>
        </div>
    </div>
</section>

{{-- Testimonials --}}
@if($testimonials->count() > 0)
<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">Testimonials</span>
            <h2>What Our Clients Say</h2>
            <p>Don't just take our word for it — hear from some of our happy clients.</p>
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
            <span class="section-eyebrow">Clients</span>
            <h2>Trusted by Great Companies</h2>
            <p>We've had the privilege of working with amazing businesses.</p>
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
            <h2>Ready to Start Your Project?</h2>
            <p>Let's discuss how we can help bring your vision to life.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">Get in Touch</a>
        </div>
    </div>
</section>
@endsection