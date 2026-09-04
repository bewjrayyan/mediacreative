@extends('admin.layouts.app')

@section('title', 'Add CMS Page')
@section('crumb', 'Pages · Create')
@section('active', 'cms-pages')

@section('content')
@php
    $isActive = old('is_active', '1') == '1';
@endphp

<form id="pageForm" class="saas-editor" method="POST" action="{{ route('admin.pages.store') }}" novalidate>
    @csrf

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.pages.index') }}" class="saas-back" aria-label="Back to pages">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">CMS page</div>
                <h1 class="saas-title" id="liveTitle">New page</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.pages.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
                        <p class="saas-panel__sub">Title, slug, and SEO metadata for this page.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="title">Title <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title') }}" required autocomplete="off" placeholder="e.g. About Us">
                        @error('title')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="slug">Slug</label>
                        <div class="saas-input-group">
                            <span class="saas-input-prefix">/</span>
                            <input class="saas-input @error('slug') is-invalid @enderror" id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-from-title">
                        </div>
                        @error('slug')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="meta_title">Meta title</label>
                        <input class="saas-input @error('meta_title') is-invalid @enderror" id="meta_title" type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="SEO title override">
                        @error('meta_title')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="meta_description">Meta description</label>
                        <textarea class="saas-textarea @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="2" placeholder="Short SEO description">{{ old('meta_description') }}</textarea>
                        @error('meta_description')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Content</h2>
                        <p class="saas-panel__sub">HTML body of the page.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="content">HTML <span class="req">*</span></label>
                        <textarea class="saas-textarea saas-textarea--mono @error('content') is-invalid @enderror" id="content" name="content" rows="14" required placeholder="<p>Page content...</p>">{{ old('content') }}</textarea>
                        @error('content')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>
        </div>

        <aside class="saas-side">
            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Visibility</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <input type="hidden" name="is_active" id="activeValue" value="{{ $isActive ? '1' : '0' }}">
                    <div class="saas-switch-row">
                        <div>
                            <div class="saas-switch-label">Show on website</div>
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Page is publicly reachable' : 'Hidden from the public site' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate page">
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
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewTitle">New page</h3>
                            <p class="saas-preview-card__client" id="previewSlug">/…</p>
                        </div>
                    </article>
                </div>
            </section>

            <button type="submit" class="btn btn--primary saas-btn saas-btn--block">Create</button>
        </aside>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const titleInput = document.getElementById('title');
  const slugInput = document.getElementById('slug');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');

  function syncTitle() {
    const val = titleInput.value.trim() || 'New page';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewTitle').textContent = val;
  }

  function syncSlug() {
    const slug = slugInput.value.trim();
    document.getElementById('previewSlug').textContent = slug ? ('/' + slug) : '/…';
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Page is publicly reachable' : 'Hidden from the public site';
  }

  titleInput.addEventListener('input', syncTitle);
  slugInput.addEventListener('input', syncSlug);
  activeToggle.addEventListener('change', syncActive);
  syncTitle(); syncSlug(); syncActive();
});
</script>
@endpush
