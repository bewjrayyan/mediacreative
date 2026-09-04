@extends('admin.layouts.app')

@section('title', 'Blog Posts')
@section('crumb', 'Blog Posts')
@section('active', 'posts')

@section('content')
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Content · Blog</div>
            <h1 class="saas-list-head__title">Blog posts <span class="saas-count">{{ $posts->total() }}</span></h1>
            <p class="saas-list-head__sub">Manage articles published on your blog.</p>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ route('admin.posts.create') }}" class="btn btn--primary saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                Add post
            </a>
        </div>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head" style="align-items:center">
            <div>
                <h2 class="saas-panel__title">All records</h2>
                <p class="saas-panel__sub">Search and manage blog entries.</p>
            </div>
            <form method="GET" action="{{ route('admin.posts.index') }}" class="saas-search">
                <input class="saas-input" type="text" name="search" value="{{ request('search') }}" placeholder="Search posts...">
                <button type="submit" class="btn btn--ghost saas-btn">Search</button>
            </form>
        </div>
        <div class="saas-table-wrap">
            <table class="saas-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th style="text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            <div class="saas-table__entity">
                                @if($post->cover_image)
                                    <img src="{{ asset('storage/' . $post->cover_image) }}" alt="">
                                @else
                                    <div class="saas-thumb" style="display:grid;place-items:center;font-weight:700;color:var(--primary);background:var(--primary-soft)">{{ strtoupper(substr($post->title, 0, 1)) }}</div>
                                @endif
                                <div>
                                    <div class="saas-table__name">{{ $post->title }}</div>
                                    <div class="saas-table__meta">/{{ $post->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $post->author?->name ?? '—' }}</td>
                        <td>
                            <span class="saas-status {{ $post->is_published ? 'is-live' : 'is-draft' }}">
                                <span class="saas-status__dot"></span>
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td>{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                        <td>
                            <div class="saas-actions">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn--ghost">Edit</a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="delete-form" onsubmit="return confirm('Delete this post?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn--ghost" style="color:var(--danger)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5"><div class="saas-empty">No posts found.</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="saas-pager">{{ $posts->links() }}</div>
    </section>
</div>
@endsection
