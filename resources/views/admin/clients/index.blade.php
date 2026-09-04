@extends('admin.layouts.app')

@section('title', 'Clients')
@section('crumb', 'Clients')
@section('active', 'clients')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Clients</span>
        <h1 class="hero-title">Clients <span class="accent">manager</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.clients.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Client
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Clients ({{ $clients->total() }})</h2></div>
        <form method="GET" action="{{ route('admin.clients.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search clients...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>Name</th><th>Website</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($client->logo)
                                <img src="{{ asset('storage/' . $client->logo) }}" class="logo-img" alt="">
                            @else
                                <div class="user-avatar" style="width:40px;height:40px;border-radius:10px">{{ strtoupper(substr($client->name, 0, 2)) }}</div>
                            @endif
                            <div style="font-weight:600;color:var(--t-base)">{{ $client->name }}</div>
                        </div>
                    </td>
                    <td>
                        @if($client->website)
                            <a href="{{ $client->website }}" target="_blank" style="color:var(--primary);text-decoration:none;font-size:13px">{{ $client->website }}</a>
                        @else — @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.clients.toggle', $client) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $client->is_active ? 'success' : 'danger' }}" style="cursor:pointer;border:none;background:var(--{{ $client->is_active ? 'success-soft' : 'danger-soft' }});color:var(--{{ $client->is_active ? 'success' : 'danger' }});">
                                {{ $client->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="delete-form" onsubmit="return confirm('Delete this client?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state">No clients found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $clients->links() }}</div>
</section>
@endsection
