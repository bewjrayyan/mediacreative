@extends('admin.layouts.app')

@section('title', 'Add Testimonial')
@section('crumb', 'Testimonials · Create')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Testimonials</span><h1 class="hero-title">Add <span class="accent">testimonial</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Create</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Testimonial details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Client Name *</label>
                    <input class="input" type="text" name="client_name" value="{{ old('client_name') }}" required>
                    @error('client_name')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Company</label>
                    <input class="input" type="text" name="company" value="{{ old('company') }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Role</label>
                    <input class="input" type="text" name="role" value="{{ old('role') }}" placeholder="e.g. CEO">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Rating (1-5)</label>
                    <select class="input" name="rating">
                        @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Avatar</label>
                    <input class="input" type="file" name="avatar" accept="image/*">
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
            <div class="col-12">
                <div class="field"><label class="field-label">Content *</label>
                    <textarea class="input" name="content" rows="5" required>{{ old('content') }}</textarea>
                    @error('content')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
