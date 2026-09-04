@extends('admin.layouts.app')

@section('title', 'Add Team Member')
@section('crumb', 'Team · Create')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Team</span><h1 class="hero-title">Add <span class="accent">team member</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.team.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Create</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Member details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Position *</label>
                    <input class="input" type="text" name="position" value="{{ old('position') }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Photo</label>
                    <input class="input" type="file" name="photo" accept="image/*">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Bio</label>
                    <textarea class="input" name="bio" rows="4">{{ old('bio') }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Social Links</label>
                    <div class="grid">
                        <div class="col-6"><input class="input" type="url" name="social_links[linkedin]" value="{{ old('social_links.linkedin') }}" placeholder="LinkedIn URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[twitter]" value="{{ old('social_links.twitter') }}" placeholder="Twitter URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[github]" value="{{ old('social_links.github') }}" placeholder="GitHub URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[facebook]" value="{{ old('social_links.facebook') }}" placeholder="Facebook URL"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
