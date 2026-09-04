@extends('layouts.app')

@section('title', 'Contact - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Get in Touch</h1>
        <p>Have a project in mind? Let's talk about how we can help bring your vision to life.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <h2 style="font-size:26px;margin-bottom:24px">Let's Connect</h2>
                
                @if(setting('contact.email'))
                <div class="contact-item">
                    <div class="icon">
                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    </div>
                    <div>
                        <h4>Email</h4>
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
                        <h4>Phone</h4>
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
                        <h4>Address</h4>
                        <p style="color:var(--text-light)">{{ setting('contact.address') }}</p>
                    </div>
                </div>
                @endif

                <div style="margin-top:32px">
                    <h4 style="margin-bottom:12px">Follow Us</h4>
                    <div class="footer-social">
                        @if(setting('social.facebook'))
                        <a href="{{ setting('social.facebook') }}" target="_blank" rel="noopener" aria-label="Facebook"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                        @endif
                        @if(setting('social.instagram'))
                        <a href="{{ setting('social.instagram') }}" target="_blank" rel="noopener" aria-label="Instagram"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1.2"/></svg></a>
                        @endif
                        @if(setting('social.linkedin'))
                        <a href="{{ setting('social.linkedin') }}" target="_blank" rel="noopener" aria-label="LinkedIn"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4V9h4v1.5A6 6 0 0 1 16 8z"/></svg></a>
                        @endif
                        @if(setting('social.twitter'))
                        <a href="{{ setting('social.twitter') }}" target="_blank" rel="noopener" aria-label="X/Twitter"><svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M18.9 1.2h3.7l-8.1 9.3L24 22.8h-7.4l-5.8-7.6-6.7 7.6H.4l8.7-9.9L0 1.2h7.6l5.3 7 6-7z"/></svg></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="contact-form-wrap">
                <h2 style="font-size:22px;margin-bottom:20px">Send us a Message</h2>
                
                <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    
                    @if(session('success'))
                    <div class="alert-message" style="background:#ECFDF5;border:1px solid #10B981;color:#065F46;">
                        {{ session('success') }}
                    </div>
                    @endif
                    
                    <div class="field-row">
                        <div class="field">
                            <label>Name *</label>
                            <input type="text" name="name" class="input" value="{{ old('name') }}" required>
                        </div>
                        <div class="field">
                            <label>Email *</label>
                            <input type="email" name="email" class="input" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    
                    <div class="field-row">
                        <div class="field">
                            <label>Phone</label>
                            <input type="text" name="phone" class="input" value="{{ old('phone') }}">
                        </div>
                        <div class="field">
                            <label>Service</label>
                            <select name="service_id" class="input">
                                <option value="">Select a service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="field">
                        <label>Subject</label>
                        <input type="text" name="subject" class="input" value="{{ old('subject') }}">
                    </div>
                    
                    <div class="field">
                        <label>Message *</label>
                        <textarea name="message" class="input" rows="5" required>{{ old('message') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg" style="width:100%">
                        Send Message
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