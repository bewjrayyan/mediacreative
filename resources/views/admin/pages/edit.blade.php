@extends('admin.layouts.app')

@section('title', 'Edit CMS Page')
@section('crumb', 'Pages · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Pages</span><h1 class="hero-title">Edit <span class="accent">page</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.pages.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Page details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.pages.update', $page) }}">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Title *</label>
                    <input class="input" type="text" name="title" value="{{ old('title', $page->title) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Slug</label>
                    <input class="input" type="text" name="slug" value="{{ old('slug', $page->slug) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Meta Title</label>
                    <input class="input" type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $page->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$page->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Meta Description</label>
                    <textarea class="input" name="meta_description" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Content (HTML) *</label>
                    <textarea class="input monospace" name="content" rows="14" style="font-family:'JetBrains Mono',monospace;font-size:13px" required>{{ old('content', $page->content) }}</textarea>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
