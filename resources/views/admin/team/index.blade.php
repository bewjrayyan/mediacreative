@extends('admin.layouts.app')

@section('title', 'Team Members')
@section('crumb', 'Team')
@section('active', 'team')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Team</span>
        <h1 class="hero-title">Team <span class="accent">members</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.team.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Member
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Members ({{ $team->total() }})</h2></div>
        <form method="GET" action="{{ route('admin.team.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>Member</th><th>Position</th><th>Order</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($team as $member)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" class="thumb-img" style="border-radius:50%" alt="">
                            @else
                                <div class="user-avatar" style="width:40px;height:40px;border-radius:50%">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                            @endif
                            <div style="font-weight:600;color:var(--t-base)">{{ $member->name }}</div>
                        </div>
                    </td>
                    <td>{{ $member->position }}</td>
                    <td>{{ $member->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.team.toggle', $member) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $member->is_active ? 'success' : 'danger' }}" style="cursor:pointer;border:none;background:var(--{{ $member->is_active ? 'success-soft' : 'danger-soft' }});color:var(--{{ $member->is_active ? 'success' : 'danger' }});">
                                {{ $member->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.team.edit', $member) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" class="delete-form" onsubmit="return confirm('Delete this team member?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state">No team members found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $team->links() }}</div>
</section>
@endsection
