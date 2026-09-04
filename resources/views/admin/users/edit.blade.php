@extends('admin.layouts.app')

@section('title', 'Edit User')
@section('crumb', 'Users · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">System · Users</span><h1 class="hero-title">Edit <span class="accent">user</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">User details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Email *</label>
                    <input class="input" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">New Password (leave blank to keep)</label>
                    <input class="input" type="password" name="password">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Avatar</label>
                    <input class="input" type="file" name="avatar" accept="image/*">
                    @if($user->avatar)<img src="{{ asset('storage/' . $user->avatar) }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-top:8px" alt="">@endif
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Role</label>
                    <select class="input" name="role">
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
