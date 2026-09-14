@extends('admin.layouts.app')

@section('title', 'Lead Form & Prospects')
@section('crumb', 'Modules | Lead Form')
@section('active', 'lead-form')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Modules · Lead Form</div>
            <h1 class="saas-list-head__title">Lead Form & Prospects <span class="saas-count">{{ $stats['total'] }}</span></h1>
            <p class="saas-list-head__sub">Manage captured prospect leads, track sales statuses, and import data from Excel/CSV files.</p>
        </div>
        <div class="saas-toolbar__actions" style="display:flex;gap:10px">
            <button type="button" class="btn btn--ghost saas-btn" onclick="openSaasModal('importExcelModal')" style="border:1.5px solid var(--border);display:inline-flex;align-items:center;gap:6px">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Import Excel / CSV
            </button>
            <a href="{{ route('admin.leads.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add Lead
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(5, 1fr);gap:14px;margin-bottom:24px">
        <a href="{{ route('admin.leads.index') }}" class="saas-panel" style="padding:16px;margin:0;text-decoration:none;border-color:{{ !request('status') ? 'var(--primary)' : 'var(--border)' }}">
            <div style="font-size:11px;font-weight:600;color:var(--t-muted);text-transform:uppercase;letter-spacing:0.05em">Total Leads</div>
            <div style="font-size:24px;font-weight:700;margin-top:4px;color:var(--t-base)">{{ $stats['total'] }}</div>
        </a>
        <a href="{{ route('admin.leads.index', ['status' => 'New']) }}" class="saas-panel" style="padding:16px;margin:0;text-decoration:none;border-color:{{ request('status') === 'New' ? 'var(--primary)' : 'var(--border)' }}">
            <div style="font-size:11px;font-weight:600;color:#2563EB;text-transform:uppercase;letter-spacing:0.05em">New</div>
            <div style="font-size:24px;font-weight:700;margin-top:4px;color:#2563EB">{{ $stats['new'] }}</div>
        </a>
        <a href="{{ route('admin.leads.index', ['status' => 'Contacted']) }}" class="saas-panel" style="padding:16px;margin:0;text-decoration:none;border-color:{{ request('status') === 'Contacted' ? 'var(--primary)' : 'var(--border)' }}">
            <div style="font-size:11px;font-weight:600;color:#D97706;text-transform:uppercase;letter-spacing:0.05em">Contacted</div>
            <div style="font-size:24px;font-weight:700;margin-top:4px;color:#D97706">{{ $stats['contacted'] }}</div>
        </a>
        <a href="{{ route('admin.leads.index', ['status' => 'Qualified']) }}" class="saas-panel" style="padding:16px;margin:0;text-decoration:none;border-color:{{ request('status') === 'Qualified' ? 'var(--primary)' : 'var(--border)' }}">
            <div style="font-size:11px;font-weight:600;color:#7C3AED;text-transform:uppercase;letter-spacing:0.05em">Qualified</div>
            <div style="font-size:24px;font-weight:700;margin-top:4px;color:#7C3AED">{{ $stats['qualified'] }}</div>
        </a>
        <a href="{{ route('admin.leads.index', ['status' => 'Converted']) }}" class="saas-panel" style="padding:16px;margin:0;text-decoration:none;border-color:{{ request('status') === 'Converted' ? 'var(--primary)' : 'var(--border)' }}">
            <div style="font-size:11px;font-weight:600;color:#059669;text-transform:uppercase;letter-spacing:0.05em">Converted</div>
            <div style="font-size:24px;font-weight:700;margin-top:4px;color:#059669">{{ $stats['converted'] }}</div>
        </a>
    </div>

    {{-- Leads Table --}}
    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">Lead Records</h2>
                <p class="saas-panel__sub">Search, review status, and manage prospect enquiries.</p>
            </div>
            <form method="GET" action="{{ route('admin.leads.index') }}" class="saas-search" style="display:flex;gap:8px">
                @if(request('status'))<input type="hidden" name="status" value="{{ request('status') }}">@endif
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>

        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Lead Name</th>
                        <th>Contact Info</th>
                        <th>Company</th>
                        <th>Source</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div style="font-weight:700;color:var(--t-base);font-size:14px">{{ $lead->name }}</div>
                            @if($lead->notes)
                                <div style="font-size:12px;color:var(--t-muted);max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="{{ $lead->notes }}">{{ $lead->notes }}</div>
                            @endif
                        </td>
                        <td>
                            @if($lead->email)<div style="font-size:13px;color:var(--t-base)">{{ $lead->email }}</div>@endif
                            @if($lead->phone)<div style="font-size:12px;color:var(--t-muted)">{{ $lead->phone }}</div>@endif
                        </td>
                        <td>{{ $lead->company ?: '—' }}</td>
                        <td>
                            <span style="font-size:12px;background:var(--bg-body);padding:3px 8px;border-radius:6px;border:1px solid var(--border)">
                                {{ $lead->source }}
                            </span>
                        </td>
                        <td>
                            @php
                                $badgeStyle = match($lead->status) {
                                    'New' => 'background:#EFF6FF;color:#2563EB;border:1px solid #93C5FD',
                                    'Contacted' => 'background:#FEF3C7;color:#D97706;border:1px solid #FDE68A',
                                    'Qualified' => 'background:#F3E8FF;color:#7C3AED;border:1px solid #DDD6FE',
                                    'Converted' => 'background:#ECFDF5;color:#059669;border:1px solid #6EE7B7',
                                    'Lost' => 'background:#FEE2E2;color:#DC2626;border:1px solid #FCA5A5',
                                    default => 'background:var(--bg-body);color:var(--t-muted);border:1px solid var(--border)',
                                };
                            @endphp
                            <span style="{{ $badgeStyle }};font-size:11px;font-weight:600;padding:3px 10px;border-radius:999px">
                                {{ $lead->status }}
                            </span>
                        </td>
                        <td style="font-size:13px;color:var(--t-muted)">{{ $lead->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.leads.edit', $lead) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.leads.destroy', $lead) }}" class="delete-form" onsubmit="return confirm('Delete this lead record?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7"><div class="saas-empty">No lead records found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $leads->links() }}</div>
    </section>
</div>

{{-- Excel / CSV Import Modal --}}
<div id="importExcelModal" class="saas-modal" hidden>
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:18px;width:100%;max-width:540px;padding:28px;box-shadow:var(--shadow-lg);position:relative">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
            <h3 style="font-size:18px;font-weight:700;margin:0">Import Leads from Excel / CSV</h3>
            <button type="button" style="border:0;background:transparent;font-size:24px;cursor:pointer;color:var(--t-muted);line-height:1" onclick="closeSaasModal('importExcelModal')">&times;</button>
        </div>

        <p style="font-size:13.5px;color:var(--t-muted);line-height:1.5;margin-bottom:20px">
            Muat naik fail spreadsheet <code>.xlsx</code> atau <code>.csv</code>. Sistem akan membaca lajur automatik (<em>Name/Nama, Email, Phone/Telefon, Company/Syarikat, Source, Status, Notes</em>).
        </p>

        <form method="POST" action="{{ route('admin.leads.import') }}" enctype="multipart/form-data">
            @csrf
            <div style="border:2px dashed var(--border);border-radius:12px;padding:32px 20px;text-align:center;background:var(--bg-body);margin-bottom:20px">
                <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="var(--primary)" stroke-width="2" style="margin:0 auto 12px;display:block"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 12 15 15"/></svg>
                <input type="file" name="file" accept=".xlsx,.xls,.csv,.txt" required style="display:block;margin:0 auto;font-size:13px">
                <div style="font-size:12px;color:var(--t-muted);margin-top:8px">Sokongan fail: .xlsx, .csv (Maksimum 10MB)</div>
            </div>

            <div style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                <a href="{{ route('admin.leads.sample-template') }}" style="font-size:13px;color:var(--primary);text-decoration:underline">Muat Turun Templat Sample (.csv)</a>
                <div style="display:flex;gap:10px">
                    <button type="button" class="btn btn--ghost saas-btn" onclick="closeSaasModal('importExcelModal')">Batal</button>
                    <button type="submit" class="btn btn--primary saas-btn">Muat Naik & Import</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
