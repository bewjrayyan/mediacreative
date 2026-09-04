@extends('admin.layouts.app')

@section('title', 'Contact Messages')
@section('crumb', 'Messages')
@section('active', 'messages')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Inbox</div>
            <h1 class="saas-list-head__title">Contact messages <span class="saas-count">{{ $messages->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage messages received through your contact form.</p>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center;flex-wrap:wrap">
            <div>
                <h2 class="saas-panel__title">Inbox</h2>
                <p class="saas-panel__sub">Filter by status and search conversations.</p>
            </div>
            <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                <div class="saas-tags">
                    <a href="{{ route('admin.messages.index') }}" class="saas-chip {{ !request('status') ? 'saas-chip--purple' : '' }}" style="text-decoration:none;{{ !request('status') ? '' : 'background:var(--bg-muted);color:var(--t-muted);border-color:var(--border)' }}">All</a>
                    <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="saas-chip {{ request('status') === 'new' ? 'saas-chip--amber' : '' }}" style="text-decoration:none;{{ request('status') === 'new' ? '' : 'background:var(--bg-muted);color:var(--t-muted);border-color:var(--border)' }}">New ({{ $statusCounts['new'] }})</a>
                    <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="saas-chip {{ request('status') === 'read' ? 'saas-chip--purple' : '' }}" style="text-decoration:none;{{ request('status') === 'read' ? '' : 'background:var(--bg-muted);color:var(--t-muted);border-color:var(--border)' }}">Read ({{ $statusCounts['read'] }})</a>
                    <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="saas-chip {{ request('status') === 'replied' ? 'saas-chip--amber' : '' }}" style="text-decoration:none;{{ request('status') === 'replied' ? '' : 'background:var(--bg-muted);color:var(--t-muted);border-color:var(--border)' }}">Replied ({{ $statusCounts['replied'] }})</a>
                </div>
                <form method="GET" action="{{ route('admin.messages.index') }}" class="saas-search">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                    <button type="submit" class="btn btn--ghost saas-btn">Search</button>
                </form>
            </div>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Service</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr @if($message->status === 'new') style="background:color-mix(in srgb, var(--primary-soft) 70%, transparent)" @endif>
                        <td>
                            <div class="saas-table__entity">
                                <div class="saas-thumb" style="border-radius:50%;display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($message->name, 0, 2)) }}</div>
                                <div>
                                    <div class="saas-table__name">{{ $message->name }}</div>
                                    <div class="saas-table__meta">{{ $message->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $message->subject ?: '—' }}</td>
                        <td>{{ $message->service?->title ?? '—' }}</td>
                        <td>
                            <span class="saas-status {{ $message->status === 'replied' ? 'is-live' : 'is-draft' }}">
                                <span class="saas-status__dot"></span>
                                {{ ucfirst($message->status) }}
                            </span>
                        </td>
                        <td>{{ $message->created_at->format('M j, Y') }}</td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn--ghost">View</a>
                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="delete-form" onsubmit="return confirm('Delete this message?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="saas-empty">No messages found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $messages->links() }}</div>
    </section>
</div>
@endsection
