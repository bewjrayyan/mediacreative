@extends('admin.layouts.app')

@section('title', 'Add Blog Post')
@section('crumb', 'Blog · Create')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Blog</span><h1 class="hero-title">Add <span class="accent">blog post</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.posts.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Create Post</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Post details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Title *</label>
                    <input class="input" type="text" name="title" value="{{ old('title') }}" required>
                    @error('title')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Slug</label>
                    <input class="input" type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated">
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Excerpt</label>
                    <input class="input" type="text" name="excerpt" value="{{ old('excerpt') }}" placeholder="Short summary shown on blog listing">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Cover Image</label>
                    <input class="input" type="file" name="cover_image" accept="image/*">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Published</label>
                    <select class="input" name="is_published">
                        <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ old('is_published') === null || old('is_published') == '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Publish Date</label>
                    <input class="input" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Content (HTML) *</label>
                    <textarea class="input monospace" name="content" rows="14" placeholder="&lt;p&gt;Write your post content in HTML...&lt;/p&gt;" required style="font-family:'JetBrains Mono',monospace;font-size:13px">{{ old('content') }}</textarea>
                    @error('content')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
