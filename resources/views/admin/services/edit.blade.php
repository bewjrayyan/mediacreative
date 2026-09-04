@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('crumb', 'Services · Edit')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Services</span>
        <h1 class="hero-title">Edit <span class="accent">service</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.services.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="serviceForm" type="submit" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8M7 3v5h8"/></svg>
            Save Changes
        </button>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Service details</h2></div>
    </div>
    <form id="serviceForm" method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Title *</label>
                    <input class="input" type="text" name="title" value="{{ old('title', $service->title) }}" required>
                    @error('title')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Slug</label>
                    <input class="input" type="text" name="slug" value="{{ old('slug', $service->slug) }}" placeholder="auto-generated if empty">
                    @error('slug')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Description *</label>
                    <textarea class="input" name="description" rows="5" required>{{ old('description', $service->description) }}</textarea>
                    @error('description')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Icon (name)</label>
                    <input class="input" type="text" name="icon" value="{{ old('icon', $service->icon) }}" placeholder="e.g. palette, code">
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Price From ($)</label>
                    <input class="input" type="number" step="0.01" min="0" name="price_from" value="{{ old('price_from', $service->price_from) }}">
                </div>
            </div>
            <div class="col-4">
                <div class="field">
                    <label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Image</label>
                    <input class="input" type="file" name="image" accept="image/*">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" style="width:100px;margin-top:8px;border-radius:8px" alt="">
                    @endif
                    @error('image')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field">
                    <label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $service->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$service->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field">
                    <label class="field-label">Features (one per line)</label>
                    <textarea class="input" name="features_hidden" style="display:none"></textarea>
                    <textarea class="input" id="featuresTextarea" rows="6" placeholder="Feature 1&#10;Feature 2&#10;Feature 3">{{ implode("\n", $service->features ?? []) }}</textarea>
                    <div id="featuresStorage"></div>
                    @error('features')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
        <input type="hidden" name="features" id="featuresInput" value="">
    </form>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('featuresTextarea');
    const input = document.getElementById('featuresInput');
    const form = document.getElementById('serviceForm');
    // Pre-populate features as hidden inputs
    const features = {!! json_encode($service->features ?? []) !!};
    features.forEach((f, i) => {
        const el = document.createElement('input');
        el.type = 'hidden';
        el.name = 'features[]';
        el.value = f;
        document.getElementById('featuresStorage').appendChild(el);
    });
    textarea.addEventListener('input', function() {
        document.getElementById('featuresStorage').innerHTML = '';
        const lines = this.value.split('\n').filter(l => l.trim());
        lines.forEach(l => {
            const el = document.createElement('input');
            el.type = 'hidden';
            el.name = 'features[]';
            el.value = l.trim();
            document.getElementById('featuresStorage').appendChild(el);
        });
    });
});
</script>
@endpush
