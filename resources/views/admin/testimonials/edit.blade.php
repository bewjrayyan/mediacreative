@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('crumb', 'Testimonials · Edit')
@section('active', 'testimonials')

@section('content')
@php
    $isActive = (bool) old('is_active', $testimonial->is_active);
@endphp

<form id="testimonialForm" class="saas-editor" method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.testimonials.index') }}" class="saas-back" aria-label="Back to testimonials">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Client testimonial</div>
                <h1 class="saas-title" id="liveTitle">{{ $testimonial->client_name }}</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
                        <h2 class="saas-panel__title">Attribution</h2>
                        <p class="saas-panel__sub">Who said it, and how they should appear on the site.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="client_name">Client name <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('client_name') is-invalid @enderror" id="client_name" type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required autocomplete="name" placeholder="e.g. Jane Cooper">
                        @error('client_name')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="company">Company</label>
                            <input class="saas-input @error('company') is-invalid @enderror" id="company" type="text" name="company" value="{{ old('company', $testimonial->company) }}" placeholder="Company name">
                            @error('company')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="role">Role</label>
                            <input class="saas-input @error('role') is-invalid @enderror" id="role" type="text" name="role" value="{{ old('role', $testimonial->role) }}" placeholder="e.g. CEO">
                            @error('role')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="rating">Rating</label>
                            <select class="saas-input @error('rating') is-invalid @enderror" id="rating" name="rating">
                                @for($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating', $testimonial->rating) == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                                @endfor
                            </select>
                            @error('rating')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="sort_order">Sort order</label>
                            <input class="saas-input @error('sort_order') is-invalid @enderror" id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}">
                            @error('sort_order')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Quote</h2>
                        <p class="saas-panel__sub">The testimonial text shown on the public site.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="content">Content <span class="req">*</span></label>
                        <textarea class="saas-textarea @error('content') is-invalid @enderror" id="content" name="content" rows="6" required placeholder="What did they say about working with you?">{{ old('content', $testimonial->content) }}</textarea>
                        @error('content')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Avatar</h2>
                        <p class="saas-panel__sub">Optional headshot shown beside the quote.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Photo</label>
                        <div class="saas-dropzone saas-dropzone--logo" data-dropzone="avatar">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="saas-dropzone__input" data-preview="avatarPreview">
                            <div class="saas-dropzone__preview saas-dropzone__preview--logo" id="avatarPreview">
                                @if($testimonial->avatar)
                                    <div class="saas-logo-frame">
                                        <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}">
                                    </div>
                                    <div class="saas-dropzone__overlay"><span>Replace avatar</span></div>
                                @else
                                    <div class="saas-dropzone__empty">
                                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <strong>Drop avatar here</strong>
                                        <span>PNG, JPG, WEBP · up to 5MB</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('avatar')<p class="saas-error">{{ $message }}</p>@enderror
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
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Included in public testimonials' : 'Hidden from the public site' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate testimonial">
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
                            @if($testimonial->avatar)
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="">
                            @else
                                <div class="saas-preview-card__placeholder" id="previewInitials">{{ strtoupper(mb_substr($testimonial->client_name, 0, 2)) }}</div>
                            @endif
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewName">{{ $testimonial->client_name }}</h3>
                            <p class="saas-preview-card__client" id="previewMeta">
                                @if($testimonial->role && $testimonial->company)
                                    {{ $testimonial->role }} · {{ $testimonial->company }}
                                @elseif($testimonial->company)
                                    {{ $testimonial->company }}
                                @elseif($testimonial->role)
                                    {{ $testimonial->role }}
                                @else
                                    No company set
                                @endif
                            </p>
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
                            <dd>{{ $testimonial->created_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>Updated</dt>
                            <dd>{{ $testimonial->updated_at?->diffForHumans() ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>ID</dt>
                            <dd class="saas-mono">#{{ $testimonial->id }}</dd>
                        </div>
                    </dl>
                </div>
            </section>

            <button type="submit" class="btn btn--primary saas-btn saas-btn--block">Save changes</button>
        </aside>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const nameInput = document.getElementById('client_name');
  const companyInput = document.getElementById('company');
  const roleInput = document.getElementById('role');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');
  const avatarInput = document.getElementById('avatar');

  function syncName() {
    const val = nameInput.value.trim() || 'Untitled testimonial';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewName').textContent = val;
    const initials = document.getElementById('previewInitials');
    if (initials) initials.textContent = val.slice(0, 2).toUpperCase();
  }

  function syncMeta() {
    const company = companyInput.value.trim();
    const role = roleInput.value.trim();
    let meta = 'No company set';
    if (company && role) meta = role + ' · ' + company;
    else if (company) meta = company;
    else if (role) meta = role;
    document.getElementById('previewMeta').textContent = meta;
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Included in public testimonials' : 'Hidden from the public site';
  }

  nameInput.addEventListener('input', syncName);
  companyInput.addEventListener('input', syncMeta);
  roleInput.addEventListener('input', syncMeta);
  activeToggle.addEventListener('change', syncActive);
  syncName(); syncMeta(); syncActive();

  const zone = avatarInput.closest('[data-dropzone]');
  avatarInput.addEventListener('change', function () {
    const file = (avatarInput.files || [])[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    document.getElementById('avatarPreview').innerHTML =
      '<div class="saas-logo-frame"><img src="' + url + '" alt="New avatar"></div>' +
      '<div class="saas-dropzone__overlay"><span>Replace avatar</span></div>';
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
