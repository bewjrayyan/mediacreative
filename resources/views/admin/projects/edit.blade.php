@extends('admin.layouts.app')

@section('title', 'Edit Project')
@section('crumb', 'Projects · Edit')
@section('active', 'projects')

@section('content')
@php
    $isPublished = old('status', $project->status) === 'published';
    $isFeatured = (bool) old('is_featured', $project->is_featured);
    $techList = old('technologies', $project->technologies ?? []);
    if (old('technologies_input') !== null) {
        $techList = array_values(array_filter(array_map('trim', explode(',', old('technologies_input')))));
    }
@endphp

<form id="projectForm" class="saas-editor" method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    {{-- Sticky toolbar --}}
    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.projects.index') }}" class="saas-back" aria-label="Back to projects">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Portfolio project</div>
                <h1 class="saas-title" id="liveTitle">{{ $project->title }}</h1>
            </div>
            <span class="saas-status {{ $isPublished ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isPublished ? 'Published' : 'Draft' }}
            </span>
            @if($isFeatured)
                <span class="saas-chip saas-chip--amber">Featured</span>
            @endif
        </div>
        <div class="saas-toolbar__actions">
            @if($project->url)
                <a href="{{ $project->url }}" target="_blank" rel="noopener" class="btn btn--ghost saas-btn">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                    View live
                </a>
            @endif
            <a href="{{ route('admin.projects.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
            <button type="submit" class="btn btn--primary saas-btn saas-btn--save">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
                Save changes
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
        {{-- Main column --}}
        <div class="saas-main">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Basics</h2>
                        <p class="saas-panel__sub">Name, URL slug, and how this project is classified.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="title">Project title <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('title') is-invalid @enderror" id="title" type="text" name="title" value="{{ old('title', $project->title) }}" required autocomplete="off" placeholder="e.g. Acme Commerce Platform">
                        @error('title')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="slug">Slug</label>
                            <div class="saas-input-group">
                                <span class="saas-input-prefix">/portfolio/</span>
                                <input class="saas-input @error('slug') is-invalid @enderror" id="slug" type="text" name="slug" value="{{ old('slug', $project->slug) }}" placeholder="auto-from-title">
                            </div>
                            @error('slug')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="category">Category <span class="req">*</span></label>
                            <select class="saas-input @error('category') is-invalid @enderror" id="category" name="category" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('category', $project->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                            @error('category')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="client">Client</label>
                            <input class="saas-input @error('client') is-invalid @enderror" id="client" type="text" name="client" value="{{ old('client', $project->client) }}" placeholder="Client or company name">
                            @error('client')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="url">Project URL</label>
                            <input class="saas-input @error('url') is-invalid @enderror" id="url" type="url" name="url" value="{{ old('url', $project->url) }}" placeholder="https://example.com">
                            @error('url')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Description</h2>
                        <p class="saas-panel__sub">Tell the story of the work — problem, approach, and outcome.</p>
                    </div>
                    <span class="saas-hint" id="descCount">0</span>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="description">Write-up <span class="req">*</span></label>
                        <textarea class="saas-input saas-textarea @error('description') is-invalid @enderror" id="description" name="description" rows="8" required placeholder="What did you build, for whom, and what changed?">{{ old('description', $project->description) }}</textarea>
                        @error('description')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Media</h2>
                        <p class="saas-panel__sub">Cover image and gallery shots shown on the case study.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Cover thumbnail</label>
                        <div class="saas-dropzone" data-dropzone="thumbnail">
                            <input type="file" name="thumbnail" id="thumbnail" accept="image/*" class="saas-dropzone__input" data-preview="thumbPreview">
                            <div class="saas-dropzone__preview" id="thumbPreview">
                                @if($project->thumbnail)
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Current thumbnail">
                                    <div class="saas-dropzone__overlay">
                                        <span>Replace cover image</span>
                                    </div>
                                @else
                                    <div class="saas-dropzone__empty">
                                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <strong>Drop cover image here</strong>
                                        <span>PNG, JPG, WEBP · up to 5MB</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('thumbnail')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label">Gallery</label>
                        @if(!empty($project->gallery_images))
                            <div class="saas-gallery" id="galleryExisting">
                                @foreach($project->gallery_images as $img)
                                    <figure class="saas-gallery__item">
                                        <img src="{{ asset('storage/' . $img) }}" alt="">
                                    </figure>
                                @endforeach
                            </div>
                        @endif
                        <div class="saas-dropzone saas-dropzone--compact" data-dropzone="gallery">
                            <input type="file" name="gallery_images[]" id="gallery" accept="image/*" multiple class="saas-dropzone__input" data-preview="galleryPreview">
                            <div class="saas-dropzone__empty saas-dropzone__empty--row">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 5v14M5 12h14"/></svg>
                                <div>
                                    <strong>Add gallery images</strong>
                                    <span>New uploads are appended to the existing gallery</span>
                                </div>
                            </div>
                            <div class="saas-gallery saas-gallery--pending" id="galleryPreview" hidden></div>
                        </div>
                        @error('gallery_images')<p class="saas-error">{{ $message }}</p>@enderror
                        @error('gallery_images.*')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Tech stack</h2>
                        <p class="saas-panel__sub">Tools and frameworks used on this project.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="technologies_input">Technologies</label>
                        <div class="saas-tags" id="techTags">
                            @foreach($techList as $tech)
                                <span class="saas-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                        <input class="saas-input" id="technologies_input" type="text" name="technologies_input" value="{{ old('technologies_input', implode(', ', $project->technologies ?? [])) }}" placeholder="Laravel, Vue.js, MySQL — press comma or Enter">
                        <p class="saas-help">Separate with commas. Tags update as you type.</p>
                    </div>

                    @if(isset($services) && $services->count())
                        <div class="saas-field">
                            <label class="saas-label">Related services</label>
                            <div class="saas-checkgrid">
                                @foreach($services as $service)
                                    @php $checked = in_array((string) $service->id, old('services', $project->services ?? []), true) || in_array($service->id, old('services', $project->services ?? []), false); @endphp
                                    <label class="saas-check">
                                        <input type="checkbox" name="services[]" value="{{ $service->id }}" {{ $checked ? 'checked' : '' }}>
                                        <span>{{ $service->title }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- Sticky sidebar --}}
        <aside class="saas-side">
            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Publishing</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <input type="hidden" name="status" id="statusValue" value="{{ $isPublished ? 'published' : 'draft' }}">
                    <input type="hidden" name="is_featured" id="featuredValue" value="{{ $isFeatured ? '1' : '0' }}">

                    <div class="saas-switch-row">
                        <div>
                            <div class="saas-switch-label">Visibility</div>
                            <div class="saas-switch-hint" id="statusHint">{{ $isPublished ? 'Visible on the public site' : 'Only visible in admin' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="statusToggle" {{ $isPublished ? 'checked' : '' }} aria-label="Publish project">
                            <span class="saas-switch__track"><span class="saas-switch__thumb"></span></span>
                        </label>
                    </div>

                    <div class="saas-switch-row">
                        <div>
                            <div class="saas-switch-label">Featured</div>
                            <div class="saas-switch-hint">Highlight on homepage &amp; listings</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="featuredToggle" {{ $isFeatured ? 'checked' : '' }} aria-label="Feature project">
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
                            @if($project->thumbnail)
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="">
                            @else
                                <div class="saas-preview-card__placeholder">No cover yet</div>
                            @endif
                        </div>
                        <div class="saas-preview-card__body">
                            <div class="saas-preview-card__cat" id="previewCategory">{{ $project->category }}</div>
                            <h3 class="saas-preview-card__title" id="previewTitle">{{ $project->title }}</h3>
                            <p class="saas-preview-card__client" id="previewClient">{{ $project->client ?: 'No client set' }}</p>
                        </div>
                    </article>
                </div>
            </section>

            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Details</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <dl class="saas-meta">
                        <div>
                            <dt>Created</dt>
                            <dd>{{ $project->created_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>Updated</dt>
                            <dd>{{ $project->updated_at?->diffForHumans() ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>ID</dt>
                            <dd class="saas-mono">#{{ $project->id }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <button type="submit" class="btn btn--primary saas-btn saas-btn--block">
                Save changes
            </button>
        </aside>
    </div>
</form>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('projectForm');
  const titleInput = document.getElementById('title');
  const categoryInput = document.getElementById('category');
  const clientInput = document.getElementById('client');
  const descInput = document.getElementById('description');
  const techInput = document.getElementById('technologies_input');
  const statusToggle = document.getElementById('statusToggle');
  const statusPill = document.getElementById('statusPill');
  const statusHint = document.getElementById('statusHint');

  function syncTitle() {
    const val = titleInput.value.trim() || 'Untitled project';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewTitle').textContent = val;
  }
  function syncCategory() {
    document.getElementById('previewCategory').textContent = categoryInput.value;
  }
  function syncClient() {
    document.getElementById('previewClient').textContent = clientInput.value.trim() || 'No client set';
  }
  function syncDescCount() {
    document.getElementById('descCount').textContent = descInput.value.length.toLocaleString() + ' chars';
  }
  function syncTechTags() {
    const tags = techInput.value.split(',').map(t => t.trim()).filter(Boolean);
    const wrap = document.getElementById('techTags');
    wrap.innerHTML = tags.map(t => '<span class="saas-tag">' + t.replace(/</g, '&lt;') + '</span>').join('');
  }
  const featuredToggle = document.getElementById('featuredToggle');
  const statusValue = document.getElementById('statusValue');
  const featuredValue = document.getElementById('featuredValue');

  function syncStatus() {
    const on = statusToggle.checked;
    statusValue.value = on ? 'published' : 'draft';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Published' : 'Draft');
    statusHint.textContent = on ? 'Visible on the public site' : 'Only visible in admin';
  }
  function syncFeatured() {
    featuredValue.value = featuredToggle.checked ? '1' : '0';
  }

  titleInput.addEventListener('input', syncTitle);
  categoryInput.addEventListener('change', syncCategory);
  clientInput.addEventListener('input', syncClient);
  descInput.addEventListener('input', syncDescCount);
  techInput.addEventListener('input', syncTechTags);
  statusToggle.addEventListener('change', syncStatus);
  featuredToggle.addEventListener('change', syncFeatured);
  syncTitle(); syncCategory(); syncClient(); syncDescCount(); syncTechTags(); syncStatus(); syncFeatured();

  // Dropzone preview helpers
  function bindFilePreview(input) {
    const zone = input.closest('[data-dropzone]');
    input.addEventListener('change', function () {
      const files = Array.from(input.files || []);
      if (!files.length) return;
      if (input.multiple) {
        const preview = document.getElementById(input.dataset.preview);
        if (!preview) return;
        preview.hidden = false;
        preview.innerHTML = '';
        files.forEach(file => {
          const fig = document.createElement('figure');
          fig.className = 'saas-gallery__item';
          const img = document.createElement('img');
          img.src = URL.createObjectURL(file);
          fig.appendChild(img);
          preview.appendChild(fig);
        });
      } else {
        const file = files[0];
        const url = URL.createObjectURL(file);
        const preview = document.getElementById(input.dataset.preview);
        if (preview) {
          preview.innerHTML = '<img src="' + url + '" alt="New thumbnail"><div class="saas-dropzone__overlay"><span>Replace cover image</span></div>';
        }
        const media = document.getElementById('previewMedia');
        if (media) media.innerHTML = '<img src="' + url + '" alt="">';
      }
    });
    ['dragenter', 'dragover'].forEach(evt => {
      zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.add('is-drag'); });
    });
    ['dragleave', 'drop'].forEach(evt => {
      zone.addEventListener(evt, e => { e.preventDefault(); zone.classList.remove('is-drag'); });
    });
  }
  document.querySelectorAll('.saas-dropzone__input').forEach(bindFilePreview);

  form.addEventListener('submit', function () {
    // Clear previous hidden tech fields
    form.querySelectorAll('input[name="technologies[]"]').forEach(el => el.remove());
    const techs = techInput.value.split(',').map(t => t.trim()).filter(Boolean);
    techs.forEach(t => {
      const el = document.createElement('input');
      el.type = 'hidden';
      el.name = 'technologies[]';
      el.value = t;
      form.appendChild(el);
    });
  });
});
</script>
@endpush
