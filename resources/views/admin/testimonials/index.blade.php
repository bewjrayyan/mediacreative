@extends('admin.layouts.app')

@section('title', 'Testimonials')
@section('crumb', 'Testimonials')
@section('active', 'testimonials')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Testimonials</span>
        <h1 class="hero-title">Testimonials <span class="accent">manager</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Testimonial
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Testimonials ({{ $testimonials->total() }})</h2></div>
        <form method="GET" action="{{ route('admin.testimonials.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>Client</th><th>Rating</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($testimonials as $testimonial)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($testimonial->avatar)
                                <img src="{{ asset('storage/' . $testimonial->avatar) }}" class="thumb-img" style="border-radius:50%" alt="">
                            @else
                                <div class="user-avatar" style="width:40px;height:40px;border-radius:50%">{{ strtoupper(substr($testimonial->client_name, 0, 2)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--t-base)">{{ $testimonial->client_name }}</div>
                                <div style="font-size:12px;color:var(--t-muted)">{{ $testimonial->role }} {{ $testimonial->company ? '· ' . $testimonial->company : '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span style="color:var(--warning);font-size:14px">{{ str_repeat('★', $testimonial->rating) }}{{ str_repeat('☆', 5 - $testimonial->rating) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.testimonials.toggle', $testimonial) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="badge {{ $testimonial->is_active ? 'success' : 'danger' }}" style="cursor:pointer;border:none;background:var(--{{ $testimonial->is_active ? 'success-soft' : 'danger-soft' }});color:var(--{{ $testimonial->is_active ? 'success' : 'danger' }});">
                                {{ $testimonial->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" class="delete-form" onsubmit="return confirm('Delete this testimonial?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state">No testimonials found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $testimonials->links() }}</div>
</section>
@endsection
