@extends('layouts.app')

@section('title', __('About Us') . ' - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ __('About :name', ['name' => setting('site_name', 'DesignPro')]) }}</h1>
        <p>{{ __("We're a team of passionate designers and developers dedicated to creating exceptional digital experiences.") }}</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="max-width:720px;margin:0 auto">
            <h2 style="font-size:26px;margin-bottom:16px">{{ __('Our Story') }}</h2>
            <p style="font-size:17px;color:var(--text-light);margin-bottom:18px">
                {{ __('About story p1', ['name' => setting('site_name', 'DesignPro')]) }}
            </p>
            <p style="font-size:17px;color:var(--text-light);margin-bottom:18px">
                {{ __('About story p2') }}
            </p>
            <p style="font-size:17px;color:var(--text-light)">
                {{ __('About story p3') }}
            </p>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">{{ __('Team') }}</span>
            <h2>{{ __('Meet Our Team') }}</h2>
            <p>{{ __('The talented people behind our success.') }}</p>
        </div>
        <div class="team-grid">
            @foreach($team as $member)
            <div class="team-card">
                <div class="team-avatar">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}">
                    @else
                        {{ strtoupper(substr($member->name, 0, 2)) }}
                    @endif
                </div>
                <h3>{{ $member->name }}</h3>
                <div class="position">{{ $member->position }}</div>
                <p>{{ Str::limit($member->bio, 80) }}</p>
                @if(!empty($member->social_links))
                <div class="team-social">
                    @foreach($member->social_links as $platform => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($platform) }}">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M12 2C6.5 2 2 6.5 2 12a10 10 0 0 0 6.8 9.5c.5.1.7-.2.7-.5v-1.9c-2.8.6-3.4-1.2-3.4-1.2-.5-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.5 1 1.5 1 .9 1.5 2.3 1.1 2.9.8.1-.6.4-1.1.7-1.3-2.2-.3-4.5-1.1-4.5-4.9 0-1.1.4-2 1-2.7-.1-.2-.4-1.2.1-2.6 0 0 .8-.3 2.7 1A9.4 9.4 0 0 1 12 6.3c.8 0 1.6.1 2.4.3 1.9-.7 2.7-1 2.7-1 .5 1.4.2 2.4.1 2.6.6.7 1 1.6 1 2.7 0 3.8-2.3 4.6-4.5 4.9.4.3.7.9.7 1.9V21c0 .3.2.6.7.5A10 10 0 0 0 22 12c0-5.4-4.5-10-10-10z"/></svg>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-head">
            <span class="section-eyebrow">{{ __('Values') }}</span>
            <h2>{{ __('Our Core Values') }}</h2>
        </div>
        <div class="values-grid">
            <div class="value-card">
                <div class="num">01</div>
                <h3>{{ __('Quality First') }}</h3>
                <p>{{ __('We never compromise on quality. Every detail matters in creating exceptional digital experiences.') }}</p>
            </div>
            <div class="value-card">
                <div class="num">02</div>
                <h3>{{ __('Client Partnership') }}</h3>
                <p>{{ __('We work as an extension of your team, fostering long-term relationships built on trust and results.') }}</p>
            </div>
            <div class="value-card">
                <div class="num">03</div>
                <h3>{{ __('Continuous Innovation') }}</h3>
                <p>{{ __('We stay ahead of the curve, adopting new technologies and methodologies to deliver the best solutions.') }}</p>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>{{ __('Want to Work With Us?') }}</h2>
            <p>{{ __("We're always looking for new challenges and exciting projects.") }}</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">{{ __('Get in Touch') }}</a>
        </div>
    </div>
</section>
@endsection
