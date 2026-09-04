@extends('admin.layouts.app')

@section('title', 'Create Service')
@section('crumb', 'Services · Create')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Services</span>
        <h1 class="hero-title">Add <span class="accent">new service</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.services.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="serviceForm" type="submit" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Create Service
        </button>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Service details</h2></div>
    </div>
    <form id="serviceForm" method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
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
                    @error('slug')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Description *</label>
                    <textarea class="input" name="description" rows="5" required>{{ old('description') }}</textarea>
                    @error('description')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Icon (name)</label>
                    <input class="input" type="text" name="icon" value="{{ old('icon') }}" placeholder="e.g. palette, code">
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Price From ($)</label>
                    <input class="input" type="number" step="0.01" min="0" name="price_from" value="{{ old('price_from') }}">
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Image</label>
                    <input class="input" type="file" name="image" accept="image/*">
                    @error('image')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Features (one per line)</label>
                    <textarea class="input" id="featuresTextarea" rows="6" placeholder="Feature 1&#10;Feature 2&#10;Feature 3"></textarea>
                    <div id="featuresStorage"></div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('featuresTextarea');
    const storage = document.getElementById('featuresStorage');
    textarea.addEventListener('input', function() {
        storage.innerHTML = '';
        const lines = this.value.split('\n').filter(l => l.trim());
        lines.forEach(l => {
            const el = document.createElement('input');
            el.type = 'hidden';
            el.name = 'features[]';
            el.value = l.trim();
            storage.appendChild(el);
        });
    });
});
</script>
@endpush
