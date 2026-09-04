@extends('admin.layouts.app')

@section('title', 'Create Project')
@section('crumb', 'Projects · Create')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Portfolio</span>
        <h1 class="hero-title">Add <span class="accent">new project</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.projects.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="projectForm" type="submit" class="btn btn--primary">Create Project</button>
    </div>
</section>

<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Project details</h2></div></div>
    <form id="projectForm" method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Title *</label>
                    <input class="input" type="text" name="title" value="{{ old('title') }}" required>
                    @error('title')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Slug</label>
                    <input class="input" type="text" name="slug" value="{{ old('slug') }}" placeholder="auto-generated if empty">
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Category *</label>
                    <select class="input" name="category" required>
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Client</label>
                    <input class="input" type="text" name="client" value="{{ old('client') }}">
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Description *</label>
                    <textarea class="input" name="description" rows="6" required>{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Thumbnail</label>
                    <input class="input" type="file" name="thumbnail" accept="image/*">
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Project URL</label>
                    <input class="input" type="url" name="url" value="{{ old('url') }}" placeholder="https://...">
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Gallery Images (multiple)</label>
                    <input class="input" type="file" name="gallery_images[]" accept="image/*" multiple>
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Technologies (comma separated)</label>
                    <input class="input" type="text" name="technologies_input" value="{{ old('technologies_input') }}" placeholder="Laravel, Vue.js, MySQL">
                </div>
            </div>
            <div class="col-3">
                <div class="field">
                    <label class="field-label">Status</label>
                    <select class="input" name="status">
                        <option value="draft" selected>Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="field">
                    <label class="field-label">Featured</label>
                    <select class="input" name="is_featured">
                        <option value="0" selected>No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('projectForm');
    form.addEventListener('submit', function() {
        const techInput = document.querySelector('[name="technologies_input"]');
        if (techInput) {
            const techs = techInput.value.split(',').map(t => t.trim()).filter(Boolean);
            techs.forEach(t => {
                const el = document.createElement('input');
                el.type = 'hidden';
                el.name = 'technologies[]';
                el.value = t;
                form.appendChild(el);
            });
        }
    });
});
</script>
@endpush
