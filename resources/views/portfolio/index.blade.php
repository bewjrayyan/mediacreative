@extends('layouts.app')

@section('title', __('Portfolio') . ' - ' . setting('site_name', 'DesignPro'))

@section('content')
@php
    $activeCategory = request('category');

    $pfHref = function (string $key, string $fallback): string {
        $link = trim((string) setting($key, $fallback));
        if ($link === '') {
            $link = $fallback;
        }
        if (str_starts_with($link, 'http://') || str_starts_with($link, 'https://') || str_starts_with($link, '#')) {
            return $link;
        }

        return url($link);
    };

    $pfKicker = setting('portfolio_kicker') ?: __('Portfolio');
    $pfTitle = setting('portfolio_title') ?: __('Our Work');
    $pfLead = setting('portfolio_lead') ?: __('Explore our portfolio of successful projects for clients across various industries.');
    $pfPrimaryText = setting('portfolio_primary_cta_text') ?: __('Start a Project');
    $pfSecondaryText = setting('portfolio_secondary_cta_text') ?: __('Our Services');
    $pfGalleryHeading = setting('portfolio_gallery_heading') ?: __('Selected Work');
    $pfGallerySub = setting('portfolio_gallery_subheading') ?: __('Filter by type, then open a case study.');
    $pfGalleryFilteredSub = setting('portfolio_gallery_filtered_subheading') ?: __('Showing projects in this category.');
    $pfCtaEyebrow = setting('portfolio_cta_eyebrow') ?: __('Start a Project');
    $pfCtaTitle = setting('portfolio_cta_title') ?: __('Have a Project in Mind?');
    $pfCtaBody = setting('portfolio_cta_body') ?: __("Let's discuss how we can help bring your vision to life.");
    $pfCtaButton = setting('portfolio_cta_button') ?: __('Start Your Project');
@endphp

<div class="portfolio-page">
<section class="page-hero pf-hero">
    <div class="svc-hero-bg" aria-hidden="true">
        <div class="svc-hero-bg__orb svc-hero-bg__orb--1"></div>
        <div class="svc-hero-bg__orb svc-hero-bg__orb--2"></div>
        <div class="svc-hero-bg__orb svc-hero-bg__orb--3"></div>
        <div class="svc-hero-bg__grid"></div>
        <div class="svc-hero-bg__dots"></div>
        <div class="svc-hero-bg__beam"></div>
    </div>
    <div class="container">
        <div class="svc-hero-grid pf-hero-grid">
            <div class="svc-hero-copy">
                <p class="svc-kicker">{{ $pfKicker }}</p>
                <h1>{{ $pfTitle }}</h1>
                <p class="svc-hero-lead">{{ $pfLead }}</p>
                <div class="pf-hero-meta" aria-label="{{ $pfKicker }}">
                    <div class="pf-hero-meta__item">
                        <strong>{{ $totalProjects }}</strong>
                        <span>{{ __('Projects') }}</span>
                    </div>
                    <div class="pf-hero-meta__item">
                        <strong>{{ count($categories) }}</strong>
                        <span>{{ __('Categories') }}</span>
                    </div>
                </div>
                <div class="svc-hero-actions">
                    <a href="{{ $pfHref('portfolio_primary_cta_link', '/contact') }}" class="btn btn-primary btn-lg">{{ $pfPrimaryText }}</a>
                    <a href="{{ $pfHref('portfolio_secondary_cta_link', '/services') }}" class="btn btn-outline btn-lg">{{ $pfSecondaryText }}</a>
                </div>
            </div>
            <div class="svc-hero-visual pf-hero-visual">
                <div class="pf-hero-stack" aria-hidden="true">
                    @forelse($previewProjects as $i => $preview)
                        <div class="pf-hero-stack__card pf-hero-stack__card--{{ $i + 1 }}">
                            @if($preview->thumbnail)
                                <img src="{{ asset('storage/' . $preview->thumbnail) }}" alt="">
                            @else
                                <div class="pf-hero-stack__placeholder"></div>
                            @endif
                        </div>
                    @empty
                        <div class="pf-hero-stack__card pf-hero-stack__card--1">
                            <div class="pf-hero-stack__placeholder"></div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section pf-gallery">
    <div class="container">
        <div class="pf-toolbar">
            <div class="pf-toolbar__copy">
                <h2>{{ $activeCategory ? $activeCategory : $pfGalleryHeading }}</h2>
                <p>
                    @if($activeCategory)
                        {{ $pfGalleryFilteredSub }}
                    @else
                        {{ $pfGallerySub }}
                    @endif
                </p>
            </div>
            <nav class="portfolio-filter" aria-label="{{ __('Categories') }}">
                <a href="{{ route('portfolio.index') }}" class="filter-btn {{ !$activeCategory ? 'active' : '' }}">{{ __('All') }}</a>
                @foreach($categories as $cat)
                    <a href="{{ route('portfolio.index', ['category' => $cat]) }}" class="filter-btn {{ $activeCategory === $cat ? 'active' : '' }}">{{ $cat }}</a>
                @endforeach
            </nav>
        </div>

        <div class="portfolio-grid {{ !$activeCategory && $projects->count() > 0 ? 'portfolio-grid--showcase' : '' }}">
            @forelse($projects as $project)
            <a href="{{ route('portfolio.show', $project->slug) }}" class="project-card project-card--rich {{ $project->is_featured ? 'project-card--featured' : '' }}">
                <div class="project-thumb">
                    @if($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}" loading="lazy">
                    @else
                        <div class="project-thumb__empty">{{ __('No Image') }}</div>
                    @endif
                    <div class="project-thumb__shade" aria-hidden="true"></div>
                    <div class="project-thumb__top">
                        <span class="project-cat">{{ $project->category }}</span>
                        @if($project->is_featured)
                            <span class="project-badge">{{ __('Featured') }}</span>
                        @endif
                    </div>
                    <span class="project-thumb__cta" aria-hidden="true">
                        {{ __('View case') }}
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                    </span>
                </div>
                <div class="project-body">
                    <h3>{{ $project->title }}</h3>
                    @if($project->client)
                        <p class="project-client">{{ __('Client') }}: {{ $project->client }}</p>
                    @endif
                    <p>{{ Str::limit($project->description, 90) }}</p>
                    @if(!empty($project->technologies))
                        <div class="project-tech">
                            @foreach(array_slice((array) $project->technologies, 0, 3) as $tech)
                                <span>{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
            @empty
            <div class="pf-empty">
                <div class="pf-empty__icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                </div>
                <h3>{{ __('No projects found in this category.') }}</h3>
                <p>{{ __('Try another filter, or browse everything we have shipped.') }}</p>
                <a href="{{ route('portfolio.index') }}" class="btn btn-primary">{{ __('View all projects') }}</a>
            </div>
            @endforelse
        </div>

        @if($projects->hasPages())
        <div class="pagination">
            @if($projects->onFirstPage())
                <span class="page-item disabled"><span class="page-link">← {{ __('Previous') }}</span></span>
            @else
                <a class="page-item" href="{{ $projects->previousPageUrl() }}"><span class="page-link">← {{ __('Previous') }}</span></a>
            @endif

            @foreach($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                @if($page == $projects->currentPage())
                    <span class="page-item active"><span class="page-link">{{ $page }}</span></span>
                @else
                    <a class="page-item" href="{{ $url }}"><span class="page-link">{{ $page }}</span></a>
                @endif
            @endforeach

            @if($projects->hasMorePages())
                <a class="page-item" href="{{ $projects->nextPageUrl() }}"><span class="page-link">{{ __('Next') }} →</span></a>
            @else
                <span class="page-item disabled"><span class="page-link">{{ __('Next') }} →</span></span>
            @endif
        </div>
        @endif
    </div>
</section>

<section class="svc-hire pf-hire">
    <span class="svc-hire__glow svc-hire__glow--a" aria-hidden="true"></span>
    <span class="svc-hire__glow svc-hire__glow--b" aria-hidden="true"></span>
    <span class="svc-hire__glow svc-hire__glow--c" aria-hidden="true"></span>
    <span class="svc-hire__grid" aria-hidden="true"></span>
    <div class="container">
        <div class="svc-hire__inner">
            <p class="svc-hire__eyebrow">{{ $pfCtaEyebrow }}</p>
            <h2>{{ $pfCtaTitle }}</h2>
            <p>{{ $pfCtaBody }}</p>
            <div class="svc-hire__actions">
                <a href="{{ $pfHref('portfolio_cta_link', '/contact') }}" class="btn btn-primary btn-lg">
                    {{ $pfCtaButton }}
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
