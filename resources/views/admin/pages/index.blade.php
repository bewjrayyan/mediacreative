@extends('admin.layouts.app')

@section('title', 'CMS Pages')
@section('crumb', 'CMS Pages')
@section('active', 'cms-pages')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Pages</span>
        <h1 class="hero-title">CMS <span class="accent">pages</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.pages.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Page
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Pages ({{ $pages->total() }})</h2></div>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>Title</th><th>Slug</th><th>Status</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($pages as $page)
                <tr>
                    <td style="font-weight:600;color:var(--t-base)">{{ $page->title }}</td>
                    <td><a href="{{ route('pages.show', $page->slug) }}" target="_blank" style="color:var(--primary);text-decoration:none;font-size:13px">/{{ $page->slug }} →</a></td>
                    <td><span class="badge {{ $page->is_active ? 'success' : 'warning' }}">{{ $page->is_active ? 'Active' : 'Inactive' }}</span></td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="delete-form" onsubmit="return confirm('Delete this page?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4"><div class="empty-state">No pages found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $pages->links() }}</div>
</section>
@endsection
