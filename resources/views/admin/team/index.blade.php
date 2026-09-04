@extends('admin.layouts.app')

@section('title', 'Team Members')
@section('crumb', 'Team')
@section('active', 'team')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Team</div>
            <h1 class="saas-list-head__title">Team members <span class="saas-count">{{ $team->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage the team members shown on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.team.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add member
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search, review status, and manage entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.team.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Position</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($team as $member)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($member->photo)
                                    <img src="{{ asset('storage/' . $member->photo) }}" alt="" style="border-radius:50%">
                                @else
                                    <div class="saas-thumb" style="border-radius:50%;display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($member->name, 0, 2)) }}</div>
                                @endif
                                <div class="saas-table__name">{{ $member->name }}</div>
                            </div>
                        </td>
                        <td>{{ $member->position }}</td>
                        <td>{{ $member->sort_order }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.team.toggle', $member) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $member->is_active ? 'is-on' : 'is-off' }}">{{ $member->is_active ? 'Active' : 'Inactive' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.team.destroy', $member) }}" class="delete-form" onsubmit="return confirm('Delete this team member?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="saas-empty">No team members found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $team->links() }}</div>
    </section>
</div>
@endsection
