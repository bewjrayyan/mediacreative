@extends('layouts.app')

@section('title', __('Contact') . ' - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ __('Get in Touch') }}</h1>
        <p>{{ __("Have a project in mind? Let's talk about how we can help bring your vision to life.") }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2 style="font-size:26px;margin-bottom:24px">{{ __("Let's Connect") }}</h2>
                
                @if(setting('contact.email'))
                <div class="contact-item">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    </div>
                    <div>
                        <h4>{{ __('Email') }}</h4>
                        <p><a href="mailto:{{ setting('contact.email') }}" style="color:var(--text-light)">{{ setting('contact.email') }}</a></p>
                    </div>
                </div>
                @endif

                @if(setting('contact.phone'))
                <div class="contact-item">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <div>
                        <h4>{{ __('Phone') }}</h4>
                        <p><a href="tel:{{ setting('contact.phone') }}" style="color:var(--text-light)">{{ setting('contact.phone') }}</a></p>
                    </div>
                </div>
                @endif

                @if(setting('contact.address'))
                <div class="contact-item">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <div>
                        <h4>{{ __('Address') }}</h4>
                        <p style="color:var(--text-light)">{{ setting('contact.address') }}</p>
                    </div>
                </div>
                @endif

                <div style="margin-top:32px">
                    <h4 style="margin-bottom:12px">{{ __('Follow Us') }}</h4>
                    <div class="social-links">
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
            </div>

            <div class="contact-form-wrap">
                <h2 style="font-size:22px;margin-bottom:20px">{{ __('Send us a Message') }}</h2>
                
                <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    
                    @if(session('success'))
                    <div class="alert-message" style="background:#ECFDF5;border:1px solid #10B981;color:#065F46;">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <div class="field-row">
                        <div class="field">
                            <label>{{ __('Name') }} *</label>
                            <input type="text" name="name" class="input" value="{{ old('name') }}" required>
                        </div>
                        <div class="field">
                            <label>{{ __('Email') }} *</label>
                            <input type="email" name="email" class="input" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    
                    <div class="field-row">
                        <div class="field">
                            <label>{{ __('Phone') }}</label>
                            <input type="text" name="phone" class="input" value="{{ old('phone') }}">
                        </div>
                        <div class="field">
                            <label>{{ __('Service') }}</label>
                            <select name="service_id" class="input">
                                <option value="">{{ __('Select a service') }}</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label>{{ __('Subject') }}</label>
                        <input type="text" name="subject" class="input" value="{{ old('subject') }}">
                    </div>
                    
                    <div class="field">
                        <label>{{ __('Message') }} *</label>
                        <textarea name="message" class="input" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%">
                        {{ __('Send Message') }}
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        @if(setting('contact.map_embed'))
        <div class="map-wrap">
            <iframe src="{{ setting('contact.map_embed') }}" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        @endif
    </div>
</section>
@endsection
