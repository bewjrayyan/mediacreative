@extends('admin.layouts.app')

@section('title', 'Frontend Menu')
@section('crumb', 'Frontend Menu')
@section('active', 'frontend-menu')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Navigation</div>
            <h1 class="saas-list-head__title">Frontend menu <span class="saas-count">{{ $menuItems->count() }}</span></h1>
            <p class="saas-list-head__sub">Manage the links shown in the public header and footer.</p>
        </div>
        <a href="{{ route('admin.menu.create') }}" class="btn btn--primary saas-btn">Add menu item</a>
    </div>
    <section class="saas-panel">
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead><tr><th>Label</th><th>URL</th><th>Location</th><th>Order</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
                <tbody>
                @forelse($menuItems as $menuItem)
                    <tr>
                        <td><div class="saas-table__name">{{ $menuItem->label }}</div></td>
                        <td>{{ $menuItem->url }}</td>
                        <td>{{ ucfirst($menuItem->location) }}</td>
                        <td>{{ $menuItem->sort_order }}</td>
                        <td><span class="saas-status {{ $menuItem->is_active ? 'is-live' : 'is-draft' }}"><span class="saas-status__dot"></span>{{ $menuItem->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td><div class="saas-actions"><a href="{{ route('admin.menu.edit', $menuItem) }}" class="btn btn--ghost">Edit</a><form method="POST" action="{{ route('admin.menu.destroy', $menuItem) }}" onsubmit="return confirm('Delete this menu item?');">@csrf @method('DELETE')<button class="btn btn--ghost" style="color:var(--danger)">Delete</button></form></div></td>
                    </tr>
                @empty
                    <tr><td colspan="6"><div class="saas-empty">No menu items found.</div></td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
