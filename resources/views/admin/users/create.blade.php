@extends('admin.layouts.app')

@section('title', 'Add User')
@section('crumb', 'Users · Create')
@section('active', 'users')

@section('content')
@php
    $isActive = old('is_active', '1') == '1';
@endphp

<form id="userForm" class="saas-editor" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" novalidate>
    @csrf

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.users.index') }}" class="saas-back" aria-label="Back to users">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Admin user</div>
                <h1 class="saas-title" id="liveTitle">New user</h1>
            </div>
            <span class="saas-status {{ $isActive ? 'is-live' : 'is-draft' }}" id="statusPill">
                <span class="saas-status__dot"></span>
                {{ $isActive ? 'Active' : 'Inactive' }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.users.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
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
                        <h2 class="saas-panel__title">Account</h2>
                        <p class="saas-panel__sub">Login credentials and display name for this admin user.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="name">Name <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="e.g. Sam Admin">
                        @error('name')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="email">Email <span class="req">*</span></label>
                            <input class="saas-input @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="user@example.com">
                            @error('email')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="password">Password <span class="req">*</span></label>
                            <input class="saas-input @error('password') is-invalid @enderror" id="password" type="password" name="password" required autocomplete="new-password">
                            @error('password')<p class="saas-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="role">Role</label>
                        <select class="saas-input @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="editor" {{ old('role', 'editor') === 'editor' ? 'selected' : '' }}>Editor</option>
                        </select>
                        @error('role')<p class="saas-error">{{ $message }}</p>@enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Avatar</h2>
                        <p class="saas-panel__sub">Optional profile photo shown in the admin UI.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label">Photo</label>
                        <div class="saas-dropzone saas-dropzone--logo" data-dropzone="avatar">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="saas-dropzone__input" data-preview="avatarPreview">
                            <div class="saas-dropzone__preview saas-dropzone__preview--logo" id="avatarPreview">
                                <div class="saas-dropzone__empty">
                                    <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/></svg>
                                    <strong>Drop avatar here</strong>
                                    <span>PNG, JPG, WEBP · up to 5MB</span>
                                </div>
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
                    <h2 class="saas-panel__title">Status</h2>
                </div>
                <div class="saas-panel__body saas-panel__body--tight">
                    <input type="hidden" name="is_active" id="activeValue" value="{{ $isActive ? '1' : '0' }}">
                    <div class="saas-switch-row">
                        <div>
                            <div class="saas-switch-label">Active account</div>
                            <div class="saas-switch-hint" id="activeHint">{{ $isActive ? 'Can sign in to the admin' : 'Login disabled' }}</div>
                        </div>
                        <label class="saas-switch">
                            <input type="checkbox" id="activeToggle" {{ $isActive ? 'checked' : '' }} aria-label="Activate user">
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
                            <div class="saas-preview-card__placeholder" id="previewInitials">?</div>
                        </div>
                        <div class="saas-preview-card__body">
                            <h3 class="saas-preview-card__title" id="previewName">New user</h3>
                            <p class="saas-preview-card__client" id="previewEmail">No email set</p>
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
  const nameInput = document.getElementById('name');
  const emailInput = document.getElementById('email');
  const activeToggle = document.getElementById('activeToggle');
  const activeValue = document.getElementById('activeValue');
  const statusPill = document.getElementById('statusPill');
  const activeHint = document.getElementById('activeHint');
  const avatarInput = document.getElementById('avatar');

  function syncName() {
    const val = nameInput.value.trim() || 'New user';
    document.getElementById('liveTitle').textContent = val;
    document.getElementById('previewName').textContent = val;
    const initials = document.getElementById('previewInitials');
    if (initials) initials.textContent = val.slice(0, 2).toUpperCase();
  }

  function syncEmail() {
    document.getElementById('previewEmail').textContent = emailInput.value.trim() || 'No email set';
  }

  function syncActive() {
    const on = activeToggle.checked;
    activeValue.value = on ? '1' : '0';
    statusPill.className = 'saas-status ' + (on ? 'is-live' : 'is-draft');
    statusPill.innerHTML = '<span class="saas-status__dot"></span>' + (on ? 'Active' : 'Inactive');
    activeHint.textContent = on ? 'Can sign in to the admin' : 'Login disabled';
  }

  nameInput.addEventListener('input', syncName);
  emailInput.addEventListener('input', syncEmail);
  activeToggle.addEventListener('change', syncActive);
  syncName(); syncEmail(); syncActive();

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
