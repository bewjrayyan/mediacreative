@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')
@section('crumb', 'Blog · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Blog</span><h1 class="hero-title">Edit <span class="accent">blog post</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.posts.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Post details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Title *</label>
                    <input class="input" type="text" name="title" value="{{ old('title', $post->title) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Slug</label>
                    <input class="input" type="text" name="slug" value="{{ old('slug', $post->slug) }}">
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Excerpt</label>
                    <input class="input" type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Cover Image</label>
                    <input class="input" type="file" name="cover_image" accept="image/*">
                    @if($post->cover_image)<img src="{{ asset('storage/' . $post->cover_image) }}" style="width:120px;margin-top:8px;border-radius:8px" alt="">@endif
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Published</label>
                    <select class="input" name="is_published">
                        <option value="1" {{ $post->is_published ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ !$post->is_published ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Publish Date</label>
                    <input class="input" type="datetime-local" name="published_at" value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}">
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Content (HTML) *</label>
                    <textarea class="input monospace" name="content" rows="14" style="font-family:'JetBrains Mono',monospace;font-size:13px" required>{{ old('content', $post->content) }}</textarea>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
