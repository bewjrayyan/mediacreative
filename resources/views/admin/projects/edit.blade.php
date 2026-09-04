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

@push('styles')
<style>
.saas-editor { --saas-radius: 14px; --saas-gap: 20px; max-width: 1180px; margin: 0 auto; }
.saas-toolbar {
  position: sticky; top: 0; z-index: 40;
  display: flex; align-items: center; justify-content: space-between; gap: 16px;
  padding: 14px 16px; margin: -8px 0 20px;
  background: color-mix(in srgb, var(--bg-card) 88%, transparent);
  backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
  border: 1px solid var(--border); border-radius: 16px;
  box-shadow: var(--shadow-sm);
}
.saas-toolbar__left { display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1; }
.saas-toolbar__actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
.saas-back {
  width: 36px; height: 36px; border-radius: 10px; display: grid; place-items: center;
  color: var(--t-muted); background: var(--bg-muted); border: 1px solid var(--border); flex-shrink: 0;
  transition: background .15s, color .15s;
}
.saas-back:hover { background: var(--bg-hover); color: var(--t-base); }
.saas-toolbar__meta { min-width: 0; }
.saas-eyebrow { font-size: 11px; letter-spacing: .06em; text-transform: uppercase; color: var(--t-light); font-weight: 600; }
.saas-title {
  margin: 2px 0 0; font-family: 'Inter Tight', Inter, sans-serif; font-size: 18px; font-weight: 700;
  letter-spacing: -.02em; color: var(--t-base); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 360px;
}
.saas-status {
  display: inline-flex; align-items: center; gap: 6px; padding: 5px 10px; border-radius: 999px;
  font-size: 12px; font-weight: 600; border: 1px solid transparent; flex-shrink: 0;
}
.saas-status.is-live { background: var(--success-soft); color: var(--success); border-color: color-mix(in srgb, var(--success) 25%, transparent); }
.saas-status.is-draft { background: var(--bg-muted); color: var(--t-muted); border-color: var(--border); }
.saas-status__dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; box-shadow: 0 0 0 3px color-mix(in srgb, currentColor 18%, transparent); }
.saas-chip { display: inline-flex; align-items: center; padding: 4px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: .02em; }
.saas-chip--amber { background: var(--warning-soft); color: #B45309; }
.saas-btn { display: inline-flex; align-items: center; gap: 7px; text-decoration: none; }
.saas-btn--save { box-shadow: 0 1px 2px rgb(37 99 235 / .25); }
.saas-btn--block { width: 100%; justify-content: center; }

.saas-alert {
  display: flex; gap: 12px; padding: 14px 16px; margin-bottom: 18px;
  border-radius: 12px; background: var(--danger-soft); color: var(--danger); border: 1px solid color-mix(in srgb, var(--danger) 28%, transparent);
}
.saas-alert ul { margin: 6px 0 0; padding-left: 18px; }
.saas-alert strong { display: block; color: var(--t-base); }

.saas-layout { display: grid; grid-template-columns: minmax(0, 1fr) 300px; gap: var(--saas-gap); align-items: start; }
.saas-main { display: flex; flex-direction: column; gap: var(--saas-gap); min-width: 0; }
.saas-side { display: flex; flex-direction: column; gap: 14px; position: sticky; top: 84px; }

.saas-panel {
  background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--saas-radius);
  box-shadow: var(--shadow-card); overflow: hidden;
}
.saas-panel__head {
  display: flex; align-items: flex-start; justify-content: space-between; gap: 12px;
  padding: 18px 20px 0;
}
.saas-panel__title { margin: 0; font-size: 15px; font-weight: 700; letter-spacing: -.01em; color: var(--t-base); }
.saas-panel__sub { margin: 4px 0 0; font-size: 13px; color: var(--t-muted); line-height: 1.45; }
.saas-panel__body { padding: 16px 20px 20px; display: flex; flex-direction: column; gap: 16px; }
.saas-panel__body--tight { gap: 14px; padding-top: 14px; }
.saas-hint { font-size: 12px; color: var(--t-light); font-variant-numeric: tabular-nums; }

.saas-field { display: flex; flex-direction: column; gap: 7px; }
.saas-label { font-size: 13px; font-weight: 600; color: var(--t-base); }
.saas-label .req { color: var(--danger); }
.saas-help { margin: 0; font-size: 12px; color: var(--t-light); }
.saas-error { margin: 0; font-size: 12px; color: var(--danger); }
.saas-row { display: grid; gap: 14px; }
.saas-row--2 { grid-template-columns: 1fr 1fr; }

.saas-input, .saas-textarea {
  width: 100%; border: 1px solid var(--border); background: var(--bg-card); color: var(--t-base);
  border-radius: 10px; padding: 10px 12px; font: inherit; font-size: 14px;
  transition: border-color .15s, box-shadow .15s, background .15s;
}
.saas-input:hover, .saas-textarea:hover { border-color: color-mix(in srgb, var(--primary) 35%, var(--border)); }
.saas-input:focus, .saas-textarea:focus {
  outline: none; border-color: var(--primary);
  box-shadow: 0 0 0 4px var(--primary-ring); background: var(--bg-card);
}
.saas-input.is-invalid, .saas-textarea.is-invalid { border-color: var(--danger); box-shadow: 0 0 0 4px color-mix(in srgb, var(--danger) 18%, transparent); }
.saas-input--lg { padding: 12px 14px; font-size: 15px; font-weight: 550; }
.saas-textarea { resize: vertical; min-height: 160px; line-height: 1.55; }
.saas-input-group { display: flex; align-items: stretch; }
.saas-input-prefix {
  display: grid; place-items: center; padding: 0 12px; font-size: 12.5px; color: var(--t-muted);
  background: var(--bg-muted); border: 1px solid var(--border); border-right: 0; border-radius: 10px 0 0 10px; white-space: nowrap;
}
.saas-input-group .saas-input { border-radius: 0 10px 10px 0; }

.saas-dropzone {
  position: relative; border: 1.5px dashed var(--border); border-radius: 12px; overflow: hidden;
  background: linear-gradient(180deg, var(--bg-muted), var(--bg-card));
  transition: border-color .15s, background .15s, box-shadow .15s; cursor: pointer;
}
.saas-dropzone:hover, .saas-dropzone.is-drag {
  border-color: var(--primary); background: var(--primary-soft);
  box-shadow: 0 0 0 4px var(--primary-ring);
}
.saas-dropzone__input { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2; }
.saas-dropzone__preview { min-height: 180px; position: relative; }
.saas-dropzone__preview img { width: 100%; height: 220px; object-fit: cover; display: block; }
.saas-dropzone__overlay {
  position: absolute; inset: 0; display: grid; place-items: center;
  background: rgb(15 23 42 / .45); color: #fff; font-weight: 600; font-size: 13px;
  opacity: 0; transition: opacity .15s;
}
.saas-dropzone:hover .saas-dropzone__overlay { opacity: 1; }
.saas-dropzone__empty {
  min-height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center;
  gap: 6px; padding: 24px; text-align: center; color: var(--t-muted);
}
.saas-dropzone__empty strong { color: var(--t-base); font-size: 14px; }
.saas-dropzone__empty span { font-size: 12px; color: var(--t-light); }
.saas-dropzone--compact { min-height: auto; }
.saas-dropzone__empty--row {
  min-height: 72px; flex-direction: row; justify-content: flex-start; text-align: left; gap: 12px; padding: 14px 16px;
}
.saas-dropzone__empty--row strong { display: block; }
.saas-dropzone__empty--row span { display: block; }

.saas-gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(96px, 1fr)); gap: 10px; margin-bottom: 12px; }
.saas-gallery--pending { margin: 12px 16px 16px; }
.saas-gallery__item {
  margin: 0; aspect-ratio: 4/3; border-radius: 10px; overflow: hidden; border: 1px solid var(--border); background: var(--bg-muted);
}
.saas-gallery__item img { width: 100%; height: 100%; object-fit: cover; display: block; }

.saas-tags { display: flex; flex-wrap: wrap; gap: 8px; min-height: 0; }
.saas-tags:empty { display: none; }
.saas-tag {
  display: inline-flex; align-items: center; padding: 5px 10px; border-radius: 999px;
  background: var(--primary-soft); color: var(--primary-dark); font-size: 12px; font-weight: 600;
  border: 1px solid color-mix(in srgb, var(--primary) 18%, transparent);
}

.saas-checkgrid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.saas-check {
  display: flex; align-items: center; gap: 8px; padding: 10px 12px; border-radius: 10px;
  border: 1px solid var(--border); background: var(--bg-card); font-size: 13px; color: var(--t-base); cursor: pointer;
  transition: border-color .15s, background .15s;
}
.saas-check:has(input:checked) { border-color: var(--primary); background: var(--primary-soft); }
.saas-check input { accent-color: var(--primary); }

.saas-switch-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
.saas-switch-label { font-size: 13.5px; font-weight: 650; color: var(--t-base); }
.saas-switch-hint { font-size: 12px; color: var(--t-muted); margin-top: 2px; }
.saas-switch { position: relative; display: inline-flex; cursor: pointer; }
.saas-switch input { position: absolute; opacity: 0; width: 0; height: 0; }
.saas-switch__track {
  width: 44px; height: 26px; border-radius: 999px; background: var(--border); display: block; position: relative;
  transition: background .18s;
}
.saas-switch__thumb {
  position: absolute; top: 3px; left: 3px; width: 20px; height: 20px; border-radius: 50%;
  background: #fff; box-shadow: 0 1px 3px rgb(15 23 42 / .2); transition: transform .18s;
}
.saas-switch input:checked + .saas-switch__track { background: var(--primary); }
.saas-switch input:checked + .saas-switch__track .saas-switch__thumb { transform: translateX(18px); }
.saas-switch input:focus-visible + .saas-switch__track { box-shadow: 0 0 0 4px var(--primary-ring); }

.saas-preview-card { border: 1px solid var(--border); border-radius: 12px; overflow: hidden; background: var(--bg-card); }
.saas-preview-card__media { aspect-ratio: 16/10; background: var(--bg-muted); }
.saas-preview-card__media img { width: 100%; height: 100%; object-fit: cover; display: block; }
.saas-preview-card__placeholder {
  height: 100%; min-height: 110px; display: grid; place-items: center; color: var(--t-light); font-size: 12px;
}
.saas-preview-card__body { padding: 12px 14px 14px; }
.saas-preview-card__cat { font-size: 11px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; color: var(--primary); }
.saas-preview-card__title { margin: 4px 0 0; font-size: 14px; font-weight: 700; color: var(--t-base); letter-spacing: -.01em; }
.saas-preview-card__client { margin: 4px 0 0; font-size: 12.5px; color: var(--t-muted); }

.saas-meta { margin: 0; display: grid; gap: 12px; }
.saas-meta > div { display: flex; justify-content: space-between; gap: 12px; font-size: 13px; }
.saas-meta dt { color: var(--t-muted); }
.saas-meta dd { margin: 0; color: var(--t-base); font-weight: 600; text-align: right; }
.saas-mono { font-family: 'JetBrains Mono', ui-monospace, monospace; font-size: 12px; font-weight: 500; color: var(--t-muted); }

@media (max-width: 980px) {
  .saas-layout { grid-template-columns: 1fr; }
  .saas-side { position: static; }
  .saas-title { max-width: 200px; }
}
@media (max-width: 720px) {
  .saas-toolbar { flex-direction: column; align-items: stretch; }
  .saas-toolbar__actions { justify-content: stretch; }
  .saas-toolbar__actions .btn { flex: 1; justify-content: center; }
  .saas-row--2, .saas-checkgrid { grid-template-columns: 1fr; }
}
</style>
@endpush

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
