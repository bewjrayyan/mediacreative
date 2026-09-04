@extends('layouts.app')

@section('title', 'Portfolio - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Our Work</h1>
        <p>Explore our portfolio of successful projects for clients across various industries.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="portfolio-filter">
            <a href="{{ route('portfolio.index') }}" class="filter-btn {{ !request('category') ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
            <a href="{{ route('portfolio.index', ['category' => $cat]) }}" class="filter-btn {{ request('category') === $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>

        <div class="portfolio-grid">
            @forelse($projects as $project)
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
            @empty
            <div style="grid-column: 1/-1; text-align:center; padding: 60px 0; color: var(--text-muted);">
                <p>No projects found in this category.</p>
            </div>
            @endforelse
        </div>

        @if($projects->hasPages())
        <div class="pagination">
            @if($projects->onFirstPage())
                <span class="page-item disabled"><span class="page-link">← Previous</span></span>
            @else
                <a class="page-item" href="{{ $projects->previousPageUrl() }}"><span class="page-link">← Previous</span></a>
            @endif

            @foreach($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                @if($page == $projects->currentPage())
                    <span class="page-item active"><span class="page-link">{{ $page }}</span></span>
                @else
                    <a class="page-item" href="{{ $url }}"><span class="page-link">{{ $page }}</span></a>
                @endif
            @endforeach

            @if($projects->hasMorePages())
                <a class="page-item" href="{{ $projects->nextPageUrl() }}"><span class="page-link">Next →</span></a>
            @else
                <span class="page-item disabled"><span class="page-link">Next →</span></span>
            @endif
        </div>
        @endif
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="cta-banner">
            <h2>Have a Project in Mind?</h2>
            <p>Let's discuss how we can help bring your vision to life.</p>
            <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">Start Your Project</a>
        </div>
    </div>
</section>
@endsection