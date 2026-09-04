@extends('admin.layouts.app')

@section('title', 'Projects')
@section('crumb', 'Projects')
@section('active', 'projects')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Portfolio</div>
            <h1 class="saas-list-head__title">Projects <span class="saas-count">{{ $projects->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage the portfolio projects shown on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.projects.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add project
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Filter by category, search, and manage portfolio entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.projects.index') }}" class="saas-search">
                <select class="saas-input" name="category" onchange="this.form.submit()" style="width:auto">
                    <option value="all">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search projects...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
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
                            <div class="saas-table__entity">
                                @if($project->thumbnail)
                                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="">
                                @else
                                    <div class="saas-thumb" style="display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($project->title, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="saas-table__name">{{ $project->title }}</div>
                                    <div class="saas-table__meta">/{{ $project->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="saas-chip saas-chip--purple">{{ $project->category }}</span></td>
                        <td>{{ $project->client ?? '—' }}</td>
                        <td>
                            <span class="saas-status {{ $project->status === 'published' ? 'is-live' : 'is-draft' }}">
                                <span class="saas-status__dot"></span>
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.projects.toggle-featured', $project) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="saas-badge-btn {{ $project->is_featured ? 'is-on' : 'is-off' }}">{{ $project->is_featured ? 'Featured' : 'Not featured' }}</button>
                            </form>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" class="delete-form" onsubmit="return confirm('Delete this project?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="saas-empty">No projects found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $projects->links() }}</div>
    </section>
</div>
@endsection
