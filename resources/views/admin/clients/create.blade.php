@extends('admin.layouts.app')

@section('title', 'Create Client')
@section('crumb', 'Clients · Create')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Clients</span><h1 class="hero-title">Add <span class="accent">new client</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.clients.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="clientForm" type="submit" class="btn btn--primary">Create Client</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Client details</h2></div></div>
    <form id="clientForm" method="POST" action="{{ route('admin.clients.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name') }}" required>
                    @error('name')<span style="color:var(--danger);font-size:12px">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Website</label>
                    <input class="input" type="url" name="website" value="{{ old('website') }}" placeholder="https://...">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Logo</label>
                    <input class="input" type="file" name="logo" accept="image/*">
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
