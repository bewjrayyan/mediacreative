@extends('layouts.app')

@section('title', $post->title . ' - ' . __('Blog'))

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <div class="meta">
            @if($post->author)<span>{{ $post->author->name }}</span> · @endif
            <span>{{ $post->published_at?->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="blog-single">
            @if($post->cover_image)
            <div class="cover">
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}">
            </div>
            @endif

            <div class="blog-content">
                {!! $post->content !!}
            </div>
        </div>
    </div>
</section>

@if($recent->count() > 0)
<section class="section section-alt">
    <div class="container">
        <div class="section-head">
            <h2>{{ __('Recent Posts') }}</h2>
        </div>
        <div class="blog-grid">
            @foreach($recent as $r)
            <article class="blog-card">
                <a href="{{ route('blog.show', $r->slug) }}">
                    <div class="blog-thumb">
                        @if($r->cover_image)
                            <img src="{{ asset('storage/' . $r->cover_image) }}" alt="{{ $r->title }}">
                        @else
                            <div style="width:100%;height:100%;background:var(--bg-soft);display:grid;place-items:center;color:var(--text-muted)">{{ __('No Image') }}</div>
                        @endif
                    </div>
                    <div class="blog-body">
                        <div class="blog-date">{{ $r->published_at?->translatedFormat('d F Y') }}</div>
                        <h3>{{ $r->title }}</h3>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
