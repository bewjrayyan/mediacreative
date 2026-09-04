@extends('admin.layouts.app')

@section('title', 'Contact Messages')
@section('crumb', 'Messages')
@section('active', 'messages')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Inbox</span>
        <h1 class="hero-title">Contact <span class="accent">messages</span></h1>
        <p class="hero-sub">Manage messages received through your contact form.</p>
    </div>
</section>

<div class="grid">
    <section class="col-12 card">
        <div class="card-head">
            <div class="card-title-wrap">
                <span class="eyebrow">Filters</span>
                <h2 class="card-title">Messages ({{ $messages->total() }})</h2>
            </div>
            <div style="display:flex;gap:8px;align-items:center">
                <a href="{{ route('admin.messages.index') }}" class="badge {{ !request('status') ? 'primary' : '' }}" style="text-decoration:none;cursor:pointer">All</a>
                <a href="{{ route('admin.messages.index', ['status' => 'new']) }}" class="badge {{ request('status') === 'new' ? 'danger' : '' }}" style="text-decoration:none;cursor:pointer">New ({{ $statusCounts['new'] }})</a>
                <a href="{{ route('admin.messages.index', ['status' => 'read']) }}" class="badge {{ request('status') === 'read' ? 'info' : '' }}" style="text-decoration:none;cursor:pointer">Read ({{ $statusCounts['read'] }})</a>
                <a href="{{ route('admin.messages.index', ['status' => 'replied']) }}" class="badge {{ request('status') === 'replied' ? 'success' : '' }}" style="text-decoration:none;cursor:pointer">Replied ({{ $statusCounts['replied'] }})</a>
            </div>
            <form method="GET" action="{{ route('admin.messages.index') }}" style="display:flex;gap:8px">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <input class="input" style="width:200px" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                <button type="submit" class="btn btn--ghost">Search</button>
            </form>
        </div>
        <div class="admin-table-wrap">
            <table class="table">
                <thead><tr><th>From</th><th>Subject</th><th>Service</th><th>Status</th><th>Received</th><th style="text-align:right">Actions</th></tr></thead>
                <tbody>
                    @forelse($messages as $message)
                    <tr style="{{ $message->status === 'new' ? 'background:var(--primary-soft)' : '' }}">
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                <div class="user-avatar" style="width:38px;height:38px">{{ strtoupper(substr($message->name, 0, 2)) }}</div>
                                <div>
                                    <div style="font-weight:600;color:var(--t-base);font-size:13.5px">{{ $message->name }}</div>
                                    <div style="font-size:12px;color:var(--t-muted)">{{ $message->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $message->subject ?: '—' }}</td>
                        <td>{{ $message->service?->title ?? '—' }}</td>
                        <td><span class="badge {{ $message->status === 'new' ? 'danger' : ($message->status === 'replied' ? 'success' : 'info') }}">{{ ucfirst($message->status) }}</span></td>
                        <td>{{ $message->created_at->format('M j, Y') }}</td>
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn--ghost" style="padding:7px 14px">View</a>
                            <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="delete-form" onsubmit="return confirm('Delete this message?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state">No messages found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px">{{ $messages->links() }}</div>
    </section>
</div>
@endsection
