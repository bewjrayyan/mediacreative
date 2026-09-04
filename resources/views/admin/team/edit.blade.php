@extends('admin.layouts.app')

@section('title', 'Edit Team Member')
@section('crumb', 'Team · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Team</span><h1 class="hero-title">Edit <span class="accent">team member</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.team.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Member details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.team.update', $teamMember) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name', $teamMember->name) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Position *</label>
                    <input class="input" type="text" name="position" value="{{ old('position', $teamMember->position) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Photo</label>
                    <input class="input" type="file" name="photo" accept="image/*">
                    @if($teamMember->photo)<img src="{{ asset('storage/' . $teamMember->photo) }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-top:8px" alt="">@endif
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $teamMember->sort_order) }}">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $teamMember->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$teamMember->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Bio</label>
                    <textarea class="input" name="bio" rows="4">{{ old('bio', $teamMember->bio) }}</textarea>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Social Links</label>
                    <div class="grid">
                        <div class="col-6"><input class="input" type="url" name="social_links[linkedin]" value="{{ old('social_links.linkedin', $teamMember->social_links['linkedin'] ?? '') }}" placeholder="LinkedIn URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[twitter]" value="{{ old('social_links.twitter', $teamMember->social_links['twitter'] ?? '') }}" placeholder="Twitter URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[github]" value="{{ old('social_links.github', $teamMember->social_links['github'] ?? '') }}" placeholder="GitHub URL"></div>
                        <div class="col-6"><input class="input" type="url" name="social_links[facebook]" value="{{ old('social_links.facebook', $teamMember->social_links['facebook'] ?? '') }}" placeholder="Facebook URL"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
