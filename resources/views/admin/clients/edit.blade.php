@extends('admin.layouts.app')

@section('title', 'Edit Client')
@section('crumb', 'Clients · Edit')
@section('active', 'clients')

@section('content')
@php
    $isActive = (bool) old('is_active', $client->is_active);
    $websiteHost = null;
    if ($client->website) {
        $websiteHost = parse_url($client->website, PHP_URL_HOST) ?: $client->website;
    }
@endphp

<form id="clientForm" class="saas-editor" method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.clients.index') }}" class="saas-back" aria-label="Back to clients">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Agency client</div>
                <h1 class="saas-title" id="liveTitle">{{ $client->name }}</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            @if($client->website)
                <a href="{{ $client->website }}" target="_blank" rel="noopener" class="btn btn--ghost saas-btn">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14 21 3"/></svg>
                    Visit site
                </a>
            @endif
            <a href="{{ route('admin.clients.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
        <div class="saas-main">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Profile</h2>
                        <p class="saas-panel__sub">How this client appears in logos, case studies, and the public site.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="name">Client name <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $client->name) }}" required autocomplete="organization" placeholder="e.g. Acme Studio">
                        @error('name')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="website">Website</label>
                        <div class="saas-input-group">
                            <span class="saas-input-prefix">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15 15 0 0 1 0 20M12 2a15 15 0 0 0 0 20"/></svg>
                            </span>
                            <input class="saas-input @error('website') is-invalid @enderror" id="website" type="url" name="website" value="{{ old('website', $client->website) }}" placeholder="https://example.com">
                        </div>
                        @error('website')<p class="saas-error">{{ $message }}</p>@enderror
                        <p class="saas-help">Used for “Visit site” and logo-grid links on the frontend.</p>
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Brand mark</h2>
                        <p class="saas-panel__sub">Upload a clean logo on a transparent or light background for best results.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Logo</label>
                        <div class="saas-dropzone saas-dropzone--logo" data-dropzone="logo">
                            <input type="file" name="logo" id="logo" accept="image/*" class="saas-dropzone__input" data-preview="logoPreview">
                            <div class="saas-dropzone__preview saas-dropzone__preview--logo" id="logoPreview">
                                @if($client->logo)
                                    <div class="saas-logo-frame">
                                        <img src="{{ asset('storage/' . $client->logo) }}" alt="{{ $client->name }} logo">
                                    </div>
                                    <div class="saas-dropzone__overlay">
                                        <span>Replace logo</span>
                                    </div>
                                @else
                                    <div class="saas-dropzone__empty">
                                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <strong>Drop logo here</strong>
                                        <span>PNG, SVG, WEBP · up to 5MB</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('logo')<p class="saas-error">{{ $message }}</p>@enderror
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
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Included in public client logos' : 'Hidden from the public site' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate client">
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
                    <article class="saas-preview-card saas-preview-card--client">
                        <div class="saas-preview-card__logo" id="previewLogo">
                            @if($client->logo)
                                <img src="{{ asset('storage/' . $client->logo) }}" alt="">
                            @else
                                <div class="saas-preview-card__placeholder" id="previewInitials">{{ strtoupper(mb_substr($client->name, 0, 2)) }}</div>
                            @endif
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewName">{{ $client->name }}</h3>
                            <p class="saas-preview-card__client" id="previewWebsite">{{ $websiteHost ?: 'No website set' }}</p>
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
                            <dd>{{ $client->created_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>Updated</dt>
                            <dd>{{ $client->updated_at?->diffForHumans() ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>ID</dt>
                            <dd class="saas-mono">#{{ $client->id }}</dd>
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
  const nameInput = document.getElementById('name');
  const websiteInput = document.getElementById('website');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');
  const logoInput = document.getElementById('logo');

  function hostFromUrl(value) {
    try {
      if (!value) return '';
      const u = new URL(value);
      return u.host || value;
    } catch (e) {
      return value;
    }
  }

  function syncName() {
    const val = nameInput.value.trim() || 'Untitled client';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewName').textContent = val;
    const initials = document.getElementById('previewInitials');
    if (initials) initials.textContent = val.slice(0, 2).toUpperCase();
  }

  function syncWebsite() {
    const host = hostFromUrl(websiteInput.value.trim());
    document.getElementById('previewWebsite').textContent = host || 'No website set';
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Included in public client logos' : 'Hidden from the public site';
  }

  nameInput.addEventListener('input', syncName);
  websiteInput.addEventListener('input', syncWebsite);
  activeToggle.addEventListener('change', syncActive);
  syncName(); syncWebsite(); syncActive();

  const zone = logoInput.closest('[data-dropzone]');
  logoInput.addEventListener('change', function () {
    const file = (logoInput.files || [])[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    const preview = document.getElementById('logoPreview');
    preview.innerHTML =
      '<div class="saas-logo-frame"><img src="' + url + '" alt="New logo"></div>' +
      '<div class="saas-dropzone__overlay"><span>Replace logo</span></div>';
    document.getElementById('previewLogo').innerHTML = '<img src="' + url + '" alt="">';
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
