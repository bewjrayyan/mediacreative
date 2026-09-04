@extends('layouts.app')

@section('title', $project->title . ' - ' . __('Portfolio'))

@section('content')
<section class="page-hero">
    <div class="container">
        <span class="project-cat" style="color:var(--primary);font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:0.08em">{{ $project->category }}</span>
        <h1 style="margin-top:10px">{{ $project->title }}</h1>
        @if($project->client)<p style="color:var(--text-light)">{{ __('Client') }}: {{ $project->client }}</p>@endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="blog-single">
            @if($project->thumbnail)
            <div class="cover">
                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}">
            </div>
            @endif

            <div class="blog-content">
                <p style="font-size:18px;color:var(--text);line-height:1.8;margin-bottom:28px">{{ $project->description }}</p>

                @if(!empty($project->gallery_images))
                <h2>{{ __('Gallery') }}</h2>
                <div class="gallery-grid">
                    @foreach($project->gallery_images as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="{{ __('Gallery') }}">
                    @endforeach
                </div>
                @endif

                @if(!empty($project->technologies))
                <h2>{{ __('Technologies Used') }}</h2>
                <div class="tech-tags">
                    @foreach($project->technologies as $tech)
                    <span class="tech-tag">{{ $tech }}</span>
                    @endforeach
                </div>
                @endif

                @if($project->url)
                <div style="margin-top:32px">
                    <a href="{{ $project->url }}" target="_blank" class="btn btn-primary btn-lg">
                        {{ __('Visit Live Project') }}
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if($related->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <h2>{{ __('Related Projects') }}</h2>
        </div>
        <div class="portfolio-grid">
            @foreach($related as $rel)
            <a href="{{ route('portfolio.show', $rel->slug) }}" class="project-card">
                <div class="project-thumb">
                    @if($rel->thumbnail)
                        <img src="{{ asset('storage/' . $rel->thumbnail) }}" alt="{{ $rel->title }}">
                    @else
                        <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">{{ __('No Image') }}</div>
                    @endif
                </div>
                <div class="project-body">
                    <span class="project-cat">{{ $rel->category }}</span>
                    <h3>{{ $rel->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
