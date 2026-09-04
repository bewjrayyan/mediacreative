@extends('admin.layouts.app')

@section('title', 'Projects')
@section('crumb', 'Projects')
@section('active', 'projects')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Portfolio</span>
        <h1 class="hero-title">Projects <span class="accent">manager</span></h1>
        <p class="hero-sub">Manage the portfolio projects shown on your website.</p>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.projects.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Project
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap">
            <span class="eyebrow">Records</span>
            <h2 class="card-title">All Projects ({{ $projects->total() }})</h2>
        </div>
        <form method="GET" action="{{ route('admin.projects.index') }}" style="display:flex;gap:8px;align-items:center">
            <select class="input" name="category" onchange="this.form.submit()" style="width:auto">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                @endforeach
            </select>
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search projects...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Project</th>
                    <th>Category</th>
                    <th>Client</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th style="text-align:right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($projects as $project)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($project->thumbnail)
                                <img src="{{ asset('storage/' . $project->thumbnail) }}" class="thumb-img" alt="">
                            @else
                                <div class="user-avatar" style="width:44px;height:44px;border-radius:10px">{{ strtoupper(substr($project->title, 0, 1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--t-base)">{{ $project->title }}</div>
                                <div style="font-size:12px;color:var(--t-muted)">/{{ $project->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge info">{{ $project->category }}</span></td>
                    <td>{{ $project->client ?? '—' }}</td>
                    <td><span class="badge {{ $project->status === 'published' ? 'success' : 'warning' }}">{{ ucfirst($project->status) }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.projects.toggle-featured', $project) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn--ghost" style="padding:6px 12px;font-size:12px">{{ $project->is_featured ? '★ Featured' : '☆ Not featured' }}</button>
                        </form>
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="delete-form" onsubmit="return confirm('Delete this project?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state">No projects found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $projects->links() }}</div>
</section>
@endsection
