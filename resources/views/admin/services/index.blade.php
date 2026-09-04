@extends('admin.layouts.app')

@section('title', 'Services')
@section('crumb', 'Services')
@section('active', 'services')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Services</span>
        <h1 class="hero-title">Services <span class="accent">manager</span></h1>
        <p class="hero-sub">Manage the services shown on your website.</p>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.services.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Service
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap">
            <span class="eyebrow">Records</span>
            <h2 class="card-title">All Services ({{ $services->total() }})</h2>
        </div>
        <form method="GET" action="{{ route('admin.services.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:240px" type="text" name="search" value="{{ request('search') }}" placeholder="Search services...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Price From</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" class="thumb-img" alt="">
                            @else
                                <div class="user-avatar" style="width:44px;height:44px;border-radius:10px">{{ strtoupper(substr($service->title, 0, 1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--t-base)">{{ $service->title }}</div>
                                <div style="font-size:12px;color:var(--t-muted)" class="text-muted">/{{ $service->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>${{ number_format($service->price_from, 2) }}</td>
                    <td>{{ $service->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $service->is_active ? 'success' : 'danger' }}" style="cursor:pointer;border:none;background:var(--{{ $service->is_active ? 'success-soft' : 'danger-soft' }});color:var(--{{ $service->is_active ? 'success' : 'danger' }});">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.services.edit', $service) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="delete-form" onsubmit="return confirm('Delete this service? This cannot be undone.');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state">No services found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">
        {{ $services->links() }}
    </div>
</section>
@endsection
