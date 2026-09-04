@extends('layouts.app')

@section('title', $service->title . ' - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $service->title }}</h1>
        <p>{{ Str::limit($service->description, 180) }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="service-detail-grid">
            <div class="service-content">
                <h2>{{ __('Overview') }}</h2>
                <p>{{ $service->description }}</p>

                @if(!empty($service->features))
                <h2>{{ __("What's Included") }}</h2>
                <ul class="feature-list">
                    @foreach($service->features as $feature)
                    <li>{{ $feature }}</li>
                    @endforeach
                </ul>
                @endif

                <h2>{{ __('Our Process') }}</h2>
                <div class="process-steps">
                    <div class="process-step">
                        <div class="process-num">1</div>
                        <div>
                            <h4>{{ __('Discovery') }}</h4>
                            <p>{{ __('We dive deep into your requirements, target audience, and business goals.') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num">2</div>
                        <div>
                            <h4>{{ __('Design & Prototyping') }}</h4>
                            <p>{{ __('Create wireframes and high-fidelity designs for your approval.') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num">3</div>
                        <div>
                            <h4>{{ __('Development') }}</h4>
                            <p>{{ __('Build your solution using modern technologies and best practices.') }}</p>
                        </div>
                    </div>
                    <div class="process-step">
                        <div class="process-num">4</div>
                        <div>
                            <h4>{{ __('Launch & Support') }}</h4>
                            <p>{{ __('Deploy to production and provide ongoing maintenance support.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="quote-card">
                <h3>{{ __('Get a Quote') }}</h3>
                @if($service->price_from)
                <div class="price-note">{{ __('From') }} {{ format_price($service->price_from) }} <span>{{ __('/ project') }}</span></div>
                @endif
                <form class="quote-form" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <input type="text" name="name" class="input" placeholder="{{ __('Your Name') }}" required>
                    <input type="email" name="email" class="input" placeholder="{{ __('Email Address') }}" required>
                    <input type="text" name="subject" class="input" placeholder="{{ __('Project Details') }}" required>
                    <textarea name="message" class="input" rows="4" placeholder="{{ __('Tell us about your project...') }}" required></textarea>
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%">{{ __('Request Quote') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="cta-banner">
            <h2>{{ __('Have Questions?') }}</h2>
            <p>{{ __('Our team is ready to help you with any questions about this service.') }}</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">{{ __('Contact Us') }}</a>
        </div>
    </div>
</section>
@endsection
