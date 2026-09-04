@extends('admin.layouts.app')

@section('title', 'Edit Client')
@section('crumb', 'Clients · Edit')

@section('content')
<section class="hero">
    <div class="hero-text"><span class="eyebrow">Content · Clients</span><h1 class="hero-title">Edit <span class="accent">client</span></h1></div>
    <div class="hero-actions">
        <a href="{{ route('admin.clients.index') }}" class="btn btn--ghost">Cancel</a>
        <button form="clientForm" type="submit" class="btn btn--primary">Save Changes</button>
    </div>
</section>
<section class="card">
    <div class="card-head"><div class="card-title-wrap"><span class="eyebrow">Form</span><h2 class="card-title">Client details</h2></div></div>
    <form id="clientForm" method="POST" action="{{ route('admin.clients.update', $client) }}" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="grid">
            <div class="col-6">
                <div class="field"><label class="field-label">Name *</label>
                    <input class="input" type="text" name="name" value="{{ old('name', $client->name) }}" required>
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Website</label>
                    <input class="input" type="url" name="website" value="{{ old('website', $client->website) }}">
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Logo</label>
                    <input class="input" type="file" name="logo" accept="image/*">
                    @if($client->logo)<img src="{{ asset('storage/' . $client->logo) }}" style="width:100px;margin-top:8px;border-radius:8px;background:#fff" alt="">@endif
                </div>
            </div>
            <div class="col-6">
                <div class="field"><label class="field-label">Active</label>
                    <select class="input" name="is_active">
                        <option value="1" {{ $client->is_active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$client->is_active ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
