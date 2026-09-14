@extends('admin.layouts.app')

@section('title', 'Edit Lead')
@section('crumb', 'Lead Form | Edit Lead')
@section('active', 'lead-form')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Modules · Lead Form</div>
            <h1 class="saas-list-head__title">Edit Lead: {{ $lead->name }}</h1>
            <p class="saas-list-head__sub">Update prospect contact info or change status pipeline.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.leads.index') }}" class="btn btn--ghost saas-btn">← Back to Leads</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.leads.update', $lead) }}" class="saas-panel">
        @csrf @method('PUT')
        <div class="saas-panel__head">
            <div>
                <h2 class="saas-panel__title">Prospect Details</h2>
                <p class="saas-panel__sub">Update lead record details below.</p>
            </div>
        </div>

        <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div class="field">
                <label class="saas-label">Name / Nama Prospek <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="saas-input" value="{{ old('name', $lead->name) }}" required>
                @error('name')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Email</label>
                <input type="email" name="email" class="saas-input" value="{{ old('email', $lead->email) }}">
                @error('email')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Phone / No. Telefon</label>
                <input type="text" name="phone" class="saas-input" value="{{ old('phone', $lead->phone) }}">
                @error('phone')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Company / Syarikat</label>
                <input type="text" name="company" class="saas-input" value="{{ old('company', $lead->company) }}">
                @error('company')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Lead Source / Sumber</label>
                <input type="text" name="source" class="saas-input" value="{{ old('source', $lead->source) }}">
                @error('source')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Status Pipeline <span style="color:var(--danger)">*</span></label>
                <select name="status" class="saas-input" required>
                    <option value="New" {{ old('status', $lead->status) === 'New' ? 'selected' : '' }}>New (Baru)</option>
                    <option value="Contacted" {{ old('status', $lead->status) === 'Contacted' ? 'selected' : '' }}>Contacted (Telah Dihubungi)</option>
                    <option value="Qualified" {{ old('status', $lead->status) === 'Qualified' ? 'selected' : '' }}>Qualified (Layak/Potensi Tinggi)</option>
                    <option value="Converted" {{ old('status', $lead->status) === 'Converted' ? 'selected' : '' }}>Converted (Tukar Pelanggan)</option>
                    <option value="Lost" {{ old('status', $lead->status) === 'Lost' ? 'selected' : '' }}>Lost (Gagal/Batal)</option>
                </select>
                @error('status')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field" style="grid-column:1/-1">
                <label class="saas-label">Notes / Catatan</label>
                <textarea name="notes" class="saas-input" rows="4">{{ old('notes', $lead->notes) }}</textarea>
                @error('notes')<p class="saas-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div style="padding:16px 24px;background:var(--bg-body);border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:12px;border-radius:0 0 16px 16px">
            <a href="{{ route('admin.leads.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
            <button type="submit" class="btn btn--primary saas-btn">Update Lead</button>
        </div>
    </form>
</div>
@endsection
