@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('crumb', 'Testimonials · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Testimonials</span><h1 class="hero-title">Edit <span class="accent">testimonial</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="form" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Testimonial details</h2></div></div>
    <form id="form" method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Client Name *</label>
                    <input class="input" type="text" name="client_name" value="{{ old('client_name', $testimonial->client_name) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Company</label>
                    <input class="input" type="text" name="company" value="{{ old('company', $testimonial->company) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Role</label>
                    <input class="input" type="text" name="role" value="{{ old('role', $testimonial->role) }}">
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Rating</label>
                    <select class="input" name="rating">
                        @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ $testimonial->rating == $i ? 'selected' : '' }}>{{ $i }} ★</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="field"><label class="field-label">Sort Order</label>
                    <input class="input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Avatar</label>
                    <input class="input" type="file" name="avatar" accept="image/*">
                    @if($testimonial->avatar)<img src="{{ asset('storage/' . $testimonial->avatar) }}" style="width:60px;height:60px;border-radius:50%;object-fit:cover;margin-top:8px" alt="">@endif
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $testimonial->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$testimonial->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="field"><label class="field-label">Content *</label>
                    <textarea class="input" name="content" rows="5" required>{{ old('content', $testimonial->content) }}</textarea>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
