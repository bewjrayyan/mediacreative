@extends('admin.layouts.app')

@section('title', 'Add Blog Post')
@section('crumb', 'Blog · Create')
@section('active', 'posts')

@section('content')
@php
    $isPublished = old('is_published', '0') == '1';
@endphp

<form id="postForm" class="saas-editor" method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.posts.index') }}" class="saas-back" aria-label="Back to posts">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Blog post</div>
                <h1 class="saas-title" id="liveTitle">New post</h1>
            </div>
            <span class="saas-status {{ $isPublished ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isPublished ? 'Published' : 'Draft' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.posts.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
            <button type="submit" class="btn btn--primary saas-btn saas-btn--save">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Create
            </button>
        </div>
    </header>

    @if ($errors->any())
        <div class="saas-alert" role="alert">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <div>
                <strong>Fix {{ $errors->count() }} {{ $errors->count() === 1 ? 'issue' : 'issues' }} before saving</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="saas-layout">
        <div class="saas-main">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Basics</h2>
                        <p class="saas-panel__sub">Title, slug, and listing excerpt for this post.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="title">Title <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title') }}" required autocomplete="off" placeholder="e.g. How we ship faster">
                        @error('title')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="slug">Slug</label>
                        <div class="saas-input-group">
                            <span class="saas-input-prefix">/blog/</span>
                            <input class="saas-input @error('slug') is-invalid @enderror" id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-from-title">
                        </div>
                        @error('slug')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="excerpt">Excerpt</label>
                        <input class="saas-input @error('excerpt') is-invalid @enderror" id="excerpt" type="text" name="excerpt" value="{{ old('excerpt') }}" placeholder="Short summary shown on blog listing">
                        @error('excerpt')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="published_at">Publish date</label>
                        <input class="saas-input @error('published_at') is-invalid @enderror" id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at') }}">
                        @error('published_at')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Cover image</h2>
                        <p class="saas-panel__sub">Hero image for the post listing and detail page.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Cover</label>
                        <div class="saas-dropzone" data-dropzone="cover">
                            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="saas-dropzone__input" data-preview="coverPreview">
                            <div class="saas-dropzone__preview" id="coverPreview">
                                <div class="saas-dropzone__empty">
                                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                    <strong>Drop cover image here</strong>
                                    <span>PNG, JPG, WEBP · up to 5MB</span>
                                </div>
                            </div>
                        </div>
                        @error('cover_image')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Content</h2>
                        <p class="saas-panel__sub">Post body shown on the public blog.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field saas-rich-editor">
                        <label class="saas-label" for="content">Content <span class="req">*</span></label>
                        <textarea class="saas-textarea @error('content') is-invalid @enderror" id="content" name="content" rows="14" required data-rich-editor data-rich-height="420" placeholder="Write the post content…">{{ old('content') }}</textarea>
                        @error('content')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>
        </div>

        <aside class="saas-side">
            @include('admin.partials.seo-sidebar', [
                'metaTitle' => null, 'metaDescription' => null, 'metaKeywords' => null,
                'urlPrefix' => '/blog/',
                'descSources' => ['#excerpt','#content'],
                'keywordSources' => ['#title','#excerpt','#content'],
            ])
            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Publishing</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <input type="hidden" name="is_published" id="publishedValue" value="{{ $isPublished ? '1' : '0' }}">
                    <div class="saas-switch-row">
                        <div>
                            <div class="saas-switch-label">Published</div>
                            <div class="saas-switch-hint" id="publishedHint">{{ $isPublished ? 'Visible on the public blog' : 'Saved as draft' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="publishedToggle" {{ $isPublished ? 'checked' : '' }} aria-label="Publish post">
                            <span class="saas-switch__track"><span class="saas-switch__thumb"></span></span>
                        </label>
                    </div>
                </div>
            </section>

            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Preview</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <article class="saas-preview-card">
                        <div class="saas-preview-card__media" id="previewMedia">
                            <div class="saas-preview-card__placeholder">No cover yet</div>
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewTitle">New post</h3>
                            <p class="saas-preview-card__client" id="previewExcerpt">No excerpt yet</p>
                        </div>
                    </article>
                </div>
            </section>

            <button type="submit" class="btn btn--primary saas-btn saas-btn--block">Create</button>
        </aside>
    </div>
</form>
@endsection

@include('admin.partials.tinymce')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const titleInput = document.getElementById('title');
  const excerptInput = document.getElementById('excerpt');
  const publishedToggle = document.getElementById('publishedToggle');
  const publishedValue = document.getElementById('publishedValue');
  const statusPill = document.getElementById('statusPill');
  const publishedHint = document.getElementById('publishedHint');
  const coverInput = document.getElementById('cover_image');

  function syncTitle() {
    const val = titleInput.value.trim() || 'New post';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewTitle').textContent = val;
  }

  function syncExcerpt() {
    document.getElementById('previewExcerpt').textContent = excerptInput.value.trim() || 'No excerpt yet';
  }

  function syncPublished() {
    const on = publishedToggle.checked;
    publishedValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Published' : 'Draft');
    publishedHint.textContent = on ? 'Visible on the public blog' : 'Saved as draft';
  }

  titleInput.addEventListener('input', syncTitle);
  excerptInput.addEventListener('input', syncExcerpt);
  publishedToggle.addEventListener('change', syncPublished);
  syncTitle(); syncExcerpt(); syncPublished();

  const zone = coverInput.closest('[data-dropzone]');
  coverInput.addEventListener('change', function () {
    const file = (coverInput.files || [])[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    document.getElementById('coverPreview').innerHTML =
      '<img class="cover" src="' + url + '" alt="New cover"><div class="saas-dropzone__overlay"><span>Replace cover</span></div>';
    document.getElementById('previewMedia').innerHTML = '<img src="' + url + '" alt="">';
  });
  ['dragenter', 'dragover'].forEach(evt => {
    zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.add('is-drag'); });
  });
  ['dragleave', 'drop'].forEach(evt => {
    zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.remove('is-drag'); });
  });
});
</script>
@endpush
