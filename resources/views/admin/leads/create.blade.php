@extends('admin.layouts.app')

@section('title', 'Add New Lead')
@section('crumb', 'Lead Form | Add Lead')
@section('active', 'lead-form')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Modules · Lead Form</div>
            <h1 class="saas-list-head__title">Add New Prospect Lead</h1>
            <p class="saas-list-head__sub">Create a new prospect lead entry manually.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.leads.index') }}" class="btn btn--ghost saas-btn">← Back to Leads</a>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.leads.store') }}" class="saas-panel">
        @csrf
        <div class="saas-panel__head">
            <div>
                <h2 class="saas-panel__title">Prospect Details</h2>
                <p class="saas-panel__sub">Fill in contact information and current sales pipeline status.</p>
            </div>
        </div>

        <div style="padding:24px;display:grid;grid-template-columns:1fr 1fr;gap:20px">
            <div class="field">
                <label class="saas-label">Name / Nama Prospek <span style="color:var(--danger)">*</span></label>
                <input type="text" name="name" class="saas-input" value="{{ old('name') }}" required placeholder="e.g. Ahmad Farhan">
                @error('name')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Email</label>
                <input type="email" name="email" class="saas-input" value="{{ old('email') }}" placeholder="e.g. ahmad@example.com">
                @error('email')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Phone / No. Telefon</label>
                <input type="text" name="phone" class="saas-input" value="{{ old('phone') }}" placeholder="e.g. 012-3456789">
                @error('phone')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Company / Syarikat</label>
                <input type="text" name="company" class="saas-input" value="{{ old('company') }}" placeholder="e.g. Farhan Tech Enterprise">
                @error('company')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Lead Source / Sumber</label>
                <input type="text" name="source" class="saas-input" value="{{ old('source', 'Manual Entry') }}" placeholder="e.g. Website, Facebook, WhatsApp, Referral">
                @error('source')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field">
                <label class="saas-label">Status Pipeline <span style="color:var(--danger)">*</span></label>
                <select name="status" class="saas-input" required>
                    <option value="New" {{ old('status') === 'New' ? 'selected' : '' }}>New (Baru)</option>
                    <option value="Contacted" {{ old('status') === 'Contacted' ? 'selected' : '' }}>Contacted (Telah Dihubungi)</option>
                    <option value="Qualified" {{ old('status') === 'Qualified' ? 'selected' : '' }}>Qualified (Layak/Potensi Tinggi)</option>
                    <option value="Converted" {{ old('status') === 'Converted' ? 'selected' : '' }}>Converted (Tukar Pelanggan)</option>
                    <option value="Lost" {{ old('status') === 'Lost' ? 'selected' : '' }}>Lost (Gagal/Batal)</option>
                </select>
                @error('status')<p class="saas-error">{{ $message }}</p>@enderror
            </div>

            <div class="field" style="grid-column:1/-1">
                <label class="saas-label">Notes / Catatan</label>
                <textarea name="notes" class="saas-input" rows="4" placeholder="Ringkasan keperluan prospek, perbincangan, atau catatan susulan...">{{ old('notes') }}</textarea>
                @error('notes')<p class="saas-error">{{ $message }}</p>@enderror
            </div>
        </div>

        <div style="padding:16px 24px;background:var(--bg-body);border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:12px;border-radius:0 0 16px 16px">
            <a href="{{ route('admin.leads.index') }}" class="btn btn--ghost saas-btn">Cancel</a>
            <button type="submit" class="btn btn--primary saas-btn">Save Lead</button>
        </div>
    </form>
</div>
@endsection
