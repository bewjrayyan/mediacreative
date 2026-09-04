@extends('layouts.app')

@section('title', 'Blog - ' . setting('site_name', 'DesignPro'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>Blog</h1>
        <p>Insights, thoughts, and expertise from our team.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="blog-grid">
            @forelse($posts as $post)
            <article class="blog-card">
                <a href="{{ route('blog.show', $post->slug) }}">
                    <div class="blog-thumb">
                        @if($post->cover_image)
                            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
                        @else
                            <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">No Image</div>
                        @endif
                    </div>
                    <div class="blog-body">
                        <div class="blog-date">{{ $post->published_at?->format('F j, Y') }}</div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>
                    </div>
                </a>
            </article>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:60px 0;color:var(--text-muted)">
                <p>No blog posts yet.</p>
            </div>
            @endforelse
        </div>

        @if($posts->hasPages())
        <div class="pagination">
            @if($posts->onFirstPage())
                <span class="page-item disabled"><span class="page-link">← Previous</span></span>
            @else
                <a class="page-item" href="{{ $posts->previousPageUrl() }}"><span class="page-link">← Previous</span></a>
            @endif

            @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                @if($page == $posts->currentPage())
                    <span class="page-item active"><span class="page-link">{{ $page }}</span></span>
                @else
                    <a class="page-item" href="{{ $url }}"><span class="page-link">{{ $page }}</span></a>
                @endif
            @endforeach

            @if($posts->hasMorePages())
                <a class="page-item" href="{{ $posts->nextPageUrl() }}"><span class="page-link">Next →</span></a>
            @else
                <span class="page-item disabled"><span class="page-link">Next →</span></span>
            @endif
        </div>
        @endif
    </div>
</section>
@endsection