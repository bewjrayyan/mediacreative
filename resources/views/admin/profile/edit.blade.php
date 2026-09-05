@extends('admin.layouts.app')

@section('title', 'My Profile')
@section('crumb', 'Profile')
@section('active', 'profile')

@section('content')
@php
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->filter()
        ->map(fn ($p) => mb_strtoupper(mb_substr($p, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<form id="profileForm" class="saas-editor saas-profile" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" novalidate>
    @csrf
    @method('PUT')

    <header class="saas-toolbar">
        <div class="saas-toolbar__left">
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Account</div>
                <h1 class="saas-title" id="liveProfileTitle">{{ $user->name }}</h1>
            </div>
            <span class="saas-status is-live">
                <span class="saas-status__dot"></span>
                {{ ucfirst($user->role) }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <button type="submit" class="btn btn--primary saas-btn saas-btn--save">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
                Save profile
            </button>
        </div>
    </header>

    @if ($errors->any())
        <div class="saas-alert" role="alert" tabindex="-1" id="profileErrorSummary">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
            <div>
                <strong id="profileErrorTitle">Fix {{ $errors->count() }} {{ $errors->count() === 1 ? 'issue' : 'issues' }} before saving</strong>
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
                        <h2 class="saas-panel__title">Profile details</h2>
                        <p class="saas-panel__sub">Your display name and login email for the admin workspace.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="name">Full name <span class="req">*</span></label>
                        <input class="saas-input saas-input--lg @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" placeholder="Your name" aria-describedby="{{ $errors->has('name') ? 'name-error' : '' }}">
                        @error('name')<p class="saas-error" id="name-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="email">Email <span class="req">*</span></label>
                        <input class="saas-input @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="email" placeholder="you@company.com" aria-describedby="{{ $errors->has('email') ? 'email-error' : 'email-help' }}">
                        @error('email')
                            <p class="saas-error" id="email-error">{{ $message }}</p>
                        @else
                            <p class="saas-help" id="email-help">Used for login and admin notifications.</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Password</h2>
                        <p class="saas-panel__sub">Leave blank to keep your current password.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-field">
                        <label class="saas-label" for="current_password">Current password</label>
                        <input class="saas-input @error('current_password') is-invalid @enderror" id="current_password" type="password" name="current_password" autocomplete="current-password" placeholder="Required only when changing password" aria-describedby="{{ $errors->has('current_password') ? 'current_password-error' : '' }}">
                        @error('current_password')<p class="saas-error" id="current_password-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="saas-row saas-row--2">
                        <div class="saas-field">
                            <label class="saas-label" for="password">New password</label>
                            <input class="saas-input @error('password') is-invalid @enderror" id="password" type="password" name="password" autocomplete="new-password" placeholder="Min. 8 characters" aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}">
                            @error('password')<p class="saas-error" id="password-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="saas-field">
                            <label class="saas-label" for="password_confirmation">Confirm new password</label>
                            <input class="saas-input" id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Repeat new password">
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="saas-side">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Avatar</h2>
                        <p class="saas-panel__sub">Shown in the top bar and profile menu.</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-profile-avatar" aria-hidden="true">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="" id="profileAvatarImg">
                        @else
                            <span id="profileAvatarFallback">{{ $initials ?: 'U' }}</span>
                        @endif
                    </div>

                    <div class="saas-field">
                        <label class="saas-label" for="avatar">Upload photo</label>
                        <input class="saas-input @error('avatar') is-invalid @enderror" id="avatar" type="file" name="avatar" accept="image/jpeg,image/png,image/webp,image/gif" aria-describedby="{{ $errors->has('avatar') ? 'avatar-error' : 'avatar-help' }}">
                        @error('avatar')
                            <p class="saas-error" id="avatar-error">{{ $message }}</p>
                        @else
                            <p class="saas-help" id="avatar-help">JPG, PNG, WEBP or GIF · up to 5MB.</p>
                        @enderror
                    </div>

                    @if($user->avatar)
                        <label class="saas-check">
                            <input type="checkbox" name="remove_avatar" value="1" {{ old('remove_avatar') ? 'checked' : '' }}>
                            <span>Remove current avatar</span>
                        </label>
                    @endif
                </div>
            </section>

            <section class="saas-panel saas-panel--side">
                <div class="saas-panel__head">
                    <h2 class="saas-panel__title">Account info</h2>
                </div>
                <div class="saas-panel__body">
                    <dl class="saas-meta">
                        <div>
                            <dt>Role</dt>
                            <dd>{{ ucfirst($user->role) }}</dd>
                        </div>
                        <div>
                            <dt>Status</dt>
                            <dd>{{ $user->is_active ? 'Active' : 'Inactive' }}</dd>
                        </div>
                        <div>
                            <dt>Member since</dt>
                            <dd>{{ $user->created_at?->format('M j, Y') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </section>
        </aside>
    </div>
</form>
@endsection

@push('scripts')
<script>
(function () {
    var title = document.getElementById('liveProfileTitle');
    var nameInput = document.getElementById('name');
    if (title && nameInput) {
        nameInput.addEventListener('input', function () {
            title.textContent = nameInput.value.trim() || 'My Profile';
        });
    }
    var summary = document.getElementById('profileErrorSummary');
    if (summary) summary.focus();
})();
</script>
@endpush
