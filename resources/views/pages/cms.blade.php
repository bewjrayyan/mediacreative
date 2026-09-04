@extends('layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('meta_description', $page->meta_description)

@section('content')
<section class="page-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="blog-content" style="max-width:800px;margin:0 auto">
            {!! $page->content !!}
        </div>
    </div>
</section>
@endsection