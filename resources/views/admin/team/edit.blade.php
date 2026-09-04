@extends('admin.layouts.app')

@section('title', 'Edit Team Member')
@section('crumb', 'Team · Edit')
@section('active', 'team')

@section('content')
@php
    $isActive = (bool) old('is_active', $teamMember->is_active);
@endphp

<form id="teamForm" class="saas-editor" method="POST" action="{{ route('admin.team.update', $teamMember) }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.team.index') }}" class="saas-back" aria-label="Back to team">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Team member</div>
                <h1 class="saas-title" id="liveTitle">{{ $teamMember->name }}</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.team.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
                        <p class="saas-panel__sub">Name, role, and how this person appears on the team page.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="name">Name <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $teamMember->name) }}" required autocomplete="name" placeholder="e.g. Alex Rivera">
                        @error('name')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="position">Position <span class="req">*</span></label>
                            <input class="saas-input @error('position') is-invalid @enderror" id="position" type="text" name="position" value="{{ old('position', $teamMember->position) }}" required placeholder="e.g. Creative Director">
                            @error('position')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="sort_order">Sort order</label>
                            <input class="saas-input @error('sort_order') is-invalid @enderror" id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order) }}">
                            @error('sort_order')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="bio">Bio</label>
                        <textarea class="saas-textarea @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Short bio shown on the team page">{{ old('bio', $teamMember->bio) }}</textarea>
                        @error('bio')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Photo</h2>
                        <p class="saas-panel__sub">Portrait used on team cards and about pages.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Headshot</label>
                        <div class="saas-dropzone" data-dropzone="photo">
                            <input type="file" name="photo" id="photo" accept="image/*" class="saas-dropzone__input" data-preview="photoPreview">
                            <div class="saas-dropzone__preview" id="photoPreview">
                                @if($teamMember->photo)
                                    <img class="cover" src="{{ asset('storage/' . $teamMember->photo) }}" alt="{{ $teamMember->name }}">
                                    <div class="saas-dropzone__overlay"><span>Replace photo</span></div>
                                @else
                                    <div class="saas-dropzone__empty">
                                        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                        <strong>Drop photo here</strong>
                                        <span>PNG, JPG, WEBP · up to 5MB</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @error('photo')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Social links</h2>
                        <p class="saas-panel__sub">Optional profile URLs shown on the team card.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="linkedin">LinkedIn</label>
                            <input class="saas-input @error('social_links.linkedin') is-invalid @enderror" id="linkedin" type="url" name="social_links[linkedin]" value="{{ old('social_links.linkedin', $teamMember->social_links['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/...">
                            @error('social_links.linkedin')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="twitter">Twitter</label>
                            <input class="saas-input @error('social_links.twitter') is-invalid @enderror" id="twitter" type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $teamMember->social_links['twitter'] ?? '') }}" placeholder="https://twitter.com/...">
                            @error('social_links.twitter')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="github">GitHub</label>
                            <input class="saas-input @error('social_links.github') is-invalid @enderror" id="github" type="url" name="social_links[github]" value="{{ old('social_links.github', $teamMember->social_links['github'] ?? '') }}" placeholder="https://github.com/...">
                            @error('social_links.github')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="facebook">Facebook</label>
                            <input class="saas-input @error('social_links.facebook') is-invalid @enderror" id="facebook" type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $teamMember->social_links['facebook'] ?? '') }}" placeholder="https://facebook.com/...">
                            @error('social_links.facebook')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
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
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Included on the public team page' : 'Hidden from the public site' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate team member">
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
                            @if($teamMember->photo)
                                <img src="{{ asset('storage/' . $teamMember->photo) }}" alt="">
                            @else
                                <div class="saas-preview-card__placeholder" id="previewInitials">{{ strtoupper(mb_substr($teamMember->name, 0, 2)) }}</div>
                            @endif
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewName">{{ $teamMember->name }}</h3>
                            <p class="saas-preview-card__client" id="previewPosition">{{ $teamMember->position ?: 'No position set' }}</p>
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
                            <dd>{{ $teamMember->created_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>Updated</dt>
                            <dd>{{ $teamMember->updated_at?->diffForHumans() ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt>ID</dt>
                            <dd class="saas-mono">#{{ $teamMember->id }}</dd>
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
  const nameInput = document.getElementById('name');
  const positionInput = document.getElementById('position');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');
  const photoInput = document.getElementById('photo');

  function syncName() {
    const val = nameInput.value.trim() || 'Untitled member';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewName').textContent = val;
    const initials = document.getElementById('previewInitials');
    if (initials) initials.textContent = val.slice(0, 2).toUpperCase();
  }

  function syncPosition() {
    document.getElementById('previewPosition').textContent = positionInput.value.trim() || 'No position set';
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Included on the public team page' : 'Hidden from the public site';
  }

  nameInput.addEventListener('input', syncName);
  positionInput.addEventListener('input', syncPosition);
  activeToggle.addEventListener('change', syncActive);
  syncName(); syncPosition(); syncActive();

  const zone = photoInput.closest('[data-dropzone]');
  photoInput.addEventListener('change', function () {
    const file = (photoInput.files || [])[0];
    if (!file) return;
    const url = URL.createObjectURL(file);
    document.getElementById('photoPreview').innerHTML =
      '<img class="cover" src="' + url + '" alt="New photo"><div class="saas-dropzone__overlay"><span>Replace photo</span></div>';
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
