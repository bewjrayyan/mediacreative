@extends('admin.layouts.app')

@section('title', 'Users')
@section('crumb', 'Users')
@section('active', 'users')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">System · Users</span>
        <h1 class="hero-title">Users <span class="accent">manager</span></h1>
        <p class="hero-sub">Manage administrator accounts and roles.</p>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.users.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add User
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Users ({{ $users->total() }})</h2></div>
        <form method="GET" action="{{ route('admin.users.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>User</th><th>Role</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="thumb-img" style="border-radius:50%" alt="">
                            @else
                                <div class="user-avatar" style="width:40px;height:40px;border-radius:50%">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--t-base)">{{ $user->name }} @if($user->id === auth()->id()) <span class="badge info">You</span> @endif</div>
                                <div style="font-size:12px;color:var(--t-muted)">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge {{ $user->role === 'admin' ? 'purple' : 'info' }}">{{ ucfirst($user->role) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.toggle', $user) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $user->is_active ? 'success' : 'danger' }}" style="cursor:pointer;border:none;background:var(--{{ $user->is_active ? 'success-soft' : 'danger-soft' }});color:var(--{{ $user->is_active ? 'success' : 'danger' }});">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="delete-form" onsubmit="return confirm('Delete this user?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state">No users found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $users->links() }}</div>
</section>
@endsection
