@extends('admin.layouts.app')

@section('title', 'CMS Pages')
@section('crumb', 'CMS Pages')
@section('active', 'cms-pages')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Pages</div>
            <h1 class="saas-list-head__title">CMS pages <span class="saas-count">{{ $pages->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage static pages on your website.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.pages.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add page
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Review status and manage CMS pages.</p>
            </div>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                    <tr>
                        <td>
                            <div class="saas-table__name">{{ $page->title }}</div>
                        </td>
                        <td>
                            <a href="{{ route('pages.show', $page->slug) }}" target="_blank" rel="noopener" style="color:var(--primary);text-decoration:none">/{{ $page->slug }} →</a>
                        </td>
                        <td>
                            <span class="saas-status {{ $page->is_active ? 'is-live' : 'is-draft' }}">
                                <span class="saas-status__dot"></span>
                                {{ $page->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" class="delete-form" onsubmit="return confirm('Delete this page?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4"><div class="saas-empty">No pages found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $pages->links() }}</div>
    </section>
</div>
@endsection
