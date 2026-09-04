@extends('layouts.app')

@section('title', 'Services - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Our Services</h1>
        <p>Comprehensive digital solutions tailored to your business needs. From design to deployment, we've got you covered.</p>
    </div>
</section>

<section class="section">
    <div class="container">
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

<section class="section section-alt">
    <div class="container">
        <div class="cta-banner">
            <h2>Need Something Custom?</h2>
            <p>Let's discuss your unique requirements and find the perfect solution.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">Talk to Us</a>
        </div>
    </div>
</section>
@endsection