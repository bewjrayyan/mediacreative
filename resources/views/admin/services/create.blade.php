@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('crumb', 'Services · Create')
@section('active', 'services')

@section('content')
@php
    $isActive = old('is_active', '1') == '1';
@endphp

<form id="serviceForm" class="saas-editor" method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.services.index') }}" class="saas-back" aria-label="Back to services">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Website service</div>
                <h1 class="saas-title" id="liveTitle">New service</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.services.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
                        <p class="saas-panel__sub">Name, slug, and short description for this service.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="title">Title <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title') }}" required autocomplete="off" placeholder="e.g. Brand Identity">
                        @error('title')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="slug">Slug</label>
                        <div class="saas-input-group">
                            <span class="saas-input-prefix">/services/</span>
                            <input class="saas-input @error('slug') is-invalid @enderror" id="slug" type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-from-title">
                        </div>
                        @error('slug')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="description">Description <span class="req">*</span></label>
                        <textarea class="saas-textarea @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Pricing &amp; display</h2>
                        <p class="saas-panel__sub">Icon, starting price, and sort order on listings.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-row saas-row--3">
                        <div class="saas-field">
                            <label class="saas-label" for="icon">Icon name</label>
                            <input class="saas-input @error('icon') is-invalid @enderror" id="icon" type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g. palette, code">
                            @error('icon')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="price_from">Price from ($)</label>
                            <input class="saas-input @error('price_from') is-invalid @enderror" id="price_from" type="number" step="0.01" min="0" name="price_from" value="{{ old('price_from') }}">
                            @error('price_from')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="sort_order">Sort order</label>
                            <input class="saas-input @error('sort_order') is-invalid @enderror" id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                            @error('sort_order')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Image</h2>
                        <p class="saas-panel__sub">Cover image shown on service cards and detail pages.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Service image</label>
                        <div class="saas-dropzone" data-dropzone="image">
                            <input type="file" name="image" id="image" accept="image/*" class="saas-dropzone__input" data-preview="imagePreview">
                            <div class="saas-dropzone__preview" id="imagePreview">
                                <div class="saas-dropzone__empty">
                                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                    <strong>Drop image here</strong>
                                    <span>PNG, JPG, WEBP · up to 5MB</span>
                                </div>
                            </div>
                        </div>
                        @error('image')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Features</h2>
                        <p class="saas-panel__sub">One feature per line — shown as a checklist on the service page.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="featuresTextarea">Feature list</label>
                        <textarea class="saas-textarea" id="featuresTextarea" rows="6" placeholder="Feature 1&#10;Feature 2&#10;Feature 3">{{ old('features_text') }}</textarea>
                        <div id="featuresStorage"></div>
                        @error('features')<p class="saas-error">{{ $message }}</p>@enderror
                        <p class="saas-help">Each non-empty line becomes one features[] value on save.</p>
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
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Included in public services' : 'Hidden from the public site' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate service">
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
                            <div class="saas-preview-card__placeholder" id="previewInitials">?</div>
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewTitle">New service</h3>
                            <p class="saas-preview-card__client" id="previewPrice">No price set</p>
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
  const priceInput = document.getElementById('price_from');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');
  const textarea = document.getElementById('featuresTextarea');
  const storage = document.getElementById('featuresStorage');
  const imageInput = document.getElementById('image');

  function syncFeatures() {
    storage.innerHTML = '';
    textarea.value.split('\n').map(l => l.trim()).filter(Boolean).forEach(l => {
      const el = document.createElement('input');
      el.type = 'hidden';
      el.name = 'features[]';
      el.value = l;
      storage.appendChild(el);
    });
  }

  function syncTitle() {
    const val = titleInput.value.trim() || 'New service';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewTitle').textContent = val;
    const initials = document.getElementById('previewInitials');
    if (initials) initials.textContent = val.slice(0, 1).toUpperCase();
  }

  function syncPrice() {
    const v = priceInput.value;
    document.getElementById('previewPrice').textContent = v !== '' ? ('From $' + Number(v).toFixed(2)) : 'No price set';
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Included in public services' : 'Hidden from the public site';
  }

  titleInput.addEventListener('input', syncTitle);
  priceInput.addEventListener('input', syncPrice);
  activeToggle.addEventListener('change', syncActive);
  textarea.addEventListener('input', syncFeatures);
  syncTitle(); syncPrice(); syncActive(); syncFeatures();

  const zone = imageInput.closest('[data-dropzone]');
  imageInput.addEventListener('change', function () {
    const file = (imageInput.files || [])[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    document.getElementById('imagePreview').innerHTML =
      '<img class="cover" src="' + url + '" alt="New image"><div class="saas-dropzone__overlay"><span>Replace image</span></div>';
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
