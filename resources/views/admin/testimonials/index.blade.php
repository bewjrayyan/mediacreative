@extends('admin.layouts.app')

@section('title', 'Testimonials')
@section('crumb', 'Testimonials')
@section('active', 'testimonials')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Testimonials</div>
            <h1 class="saas-list-head__title">Testimonials <span class="saas-count">{{ $testimonials->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage client reviews shown on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add testimonial
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search, review status, and manage entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.testimonials.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($testimonial->avatar)
                                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="" style="border-radius:50%">
                                @else
                                    <div class="saas-thumb" style="border-radius:50%;display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($testimonial->client_name, 0, 2)) }}</div>
                                @endif
                                <div>
                                    <div class="saas-table__name">{{ $testimonial->client_name }}</div>
                                    <div class="saas-table__meta">{{ $testimonial->role }}{{ $testimonial->company ? ' · ' . $testimonial->company : '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="color:var(--warning)">{{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $testimonial->is_active ? 'is-on' : 'is-off' }}">{{ $testimonial->is_active ? 'Active' : 'Inactive' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="delete-form" onsubmit="return confirm('Delete this testimonial?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4"><div class="saas-empty">No testimonials found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $testimonials->links() }}</div>
    </section>
</div>
@endsection
