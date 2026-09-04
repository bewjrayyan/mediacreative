@extends('admin.layouts.app')

@section('title', 'Users')
@section('crumb', 'Users')
@section('active', 'users')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">System · Users</div>
            <h1 class="saas-list-head__title">Users <span class="saas-count">{{ $users->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage administrator accounts and roles.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.users.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add user
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search, review status, and manage accounts.</p>
            </div>
            <form method="GET" action="{{ route('admin.users.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="" style="border-radius:50%">
                                @else
                                    <div class="saas-thumb" style="border-radius:50%;display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                @endif
                                <div>
                                    <div class="saas-table__name">
                                        {{ $user->name }}
                                        @if($user->id === auth()->id())
                                            <span class="saas-chip saas-chip--purple">You</span>
                                        @endif
                                    </div>
                                    <div class="saas-table__meta">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="saas-chip {{ $user->role === 'admin' ? 'saas-chip--purple' : 'saas-chip--amber' }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $user->is_active ? 'is-on' : 'is-off' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn--ghost">Edit</a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="delete-form" onsubmit="return confirm('Delete this user?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4"><div class="saas-empty">No users found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $users->links() }}</div>
    </section>
</div>
@endsection
