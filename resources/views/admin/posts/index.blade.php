@extends('admin.layouts.app')

@section('title', 'Blog Posts')
@section('crumb', 'Blog Posts')
@section('active', 'posts')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Content · Blog</span>
        <h1 class="hero-title">Blog <span class="accent">posts</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.posts.create') }}" class="btn btn--primary">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
            Add Post
        </a>
    </div>
</section>

<section class="card">
    <div class="card-head">
        <div class="card-title-wrap"><span class="eyebrow">Records</span><h2 class="card-title">All Posts ({{ $posts->total() }})</h2></div>
        <form method="GET" action="{{ route('admin.posts.index') }}" style="display:flex;gap:8px">
            <input class="input" style="width:220px" type="text" name="search" value="{{ request('search') }}" placeholder="Search posts...">
            <button type="submit" class="btn btn--ghost">Search</button>
        </form>
    </div>
    <div class="admin-table-wrap">
        <table class="table">
            <thead><tr><th>Title</th><th>Author</th><th>Status</th><th>Published</th><th style="text-align:right">Actions</th></tr></thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:12px">
                            @if($post->cover_image)
                                <img src="{{ asset('storage/' . $post->cover_image) }}" class="thumb-img" alt="">
                            @else
                                <div class="user-avatar" style="width:44px;height:44px;border-radius:10px">{{ strtoupper(substr($post->title, 0, 1)) }}</div>
                            @endif
                            <div>
                                <div style="font-weight:600;color:var(--t-base)">{{ $post->title }}</div>
                                <div style="font-size:12px;color:var(--t-muted)">/{{ $post->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $post->author?->name ?? '—' }}</td>
                    <td><span class="badge {{ $post->is_published ? 'success' : 'warning' }}">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
                    <td>{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn--ghost" style="padding:7px 14px">Edit</a>
                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="delete-form" onsubmit="return confirm('Delete this post?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost" style="padding:7px 14px;color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5"><div class="empty-state">No posts found.</div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:16px 20px">{{ $posts->links() }}</div>
</section>
@endsection
