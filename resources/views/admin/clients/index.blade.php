@extends('admin.layouts.app')

@section('title', 'Clients')
@section('crumb', 'Clients')
@section('active', 'clients')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Clients</div>
            <h1 class="saas-list-head__title">Clients <span class="saas-count">{{ $clients->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage client logos and links shown on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.clients.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add client
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search, review status, and manage entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.clients.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search clients...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($client->logo)
                                    <img src="{{ asset('storage/' . $client->logo) }}" alt="" style="object-fit:contain;background:#fff;padding:4px">
                                @else
                                    <div class="saas-thumb" style="display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($client->name, 0, 2)) }}</div>
                                @endif
                                <div class="saas-table__name">{{ $client->name }}</div>
                            </div>
                        </td>
                        <td>
                            @if($client->website)
                                <a href="{{ $client->website }}" target="_blank" rel="noopener" style="color:var(--primary);text-decoration:none">{{ $client->website }}</a>
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.clients.toggle', $client) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $client->is_active ? 'is-on' : 'is-off' }}">{{ $client->is_active ? 'Active' : 'Inactive' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="delete-form" onsubmit="return confirm('Delete this client?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4"><div class="saas-empty">No clients found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $clients->links() }}</div>
    </section>
</div>
@endsection
