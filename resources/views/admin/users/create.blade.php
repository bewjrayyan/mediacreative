@extends('admin.layouts.app')

@section('title', 'Add User')
@section('crumb', 'Users · Create')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">System · Users</span><h1 class="hero-title">Add <span class="accent">new user</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Create User</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">User details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Email *</label>
                    <input class="input" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Password *</label>
                    <input class="input" type="password" name="password" required>
                    @error('password')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Avatar</label>
                    <input class="input" type="file" name="avatar" accept="image/*">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Role</label>
                    <select class="input" name="role">
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="editor" {{ old('role') === 'editor' ? 'selected' : '' }}>Editor</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
