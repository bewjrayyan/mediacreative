@extends('admin.layouts.app')

@section('title', 'Services')
@section('crumb', 'Services')
@section('active', 'services')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Services</div>
            <h1 class="saas-list-head__title">Services <span class="saas-count">{{$services->total()}}</span></h1>
            <p class="saas-list-head__sub">Manage the services shown on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.services.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add service
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search, review status, and manage entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.services.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Price from</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="">
                                @else
                                    <div class="saas-thumb" style="display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($service->title, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="saas-table__name">{{ $service->title }}</div>
                                    <div class="saas-table__meta">/{{ $service->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td>${{ number_format($service->price_from, 2) }}</td>
                        <td>{{ $service->sort_order }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $service->is_active ? 'is-on' : 'is-off' }}">{{ $service->is_active ? 'Active' : 'Inactive' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.services.edit', $service) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.services.destroy', $service) }}" class="delete-form" onsubmit="return confirm('Delete this service?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="saas-empty">No services found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{$services->links()}}</div>
    </section>
</div>
@endsection
