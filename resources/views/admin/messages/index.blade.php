@extends('admin.layouts.app')

@section('title', 'Contact Messages')
@section('crumb', 'Messages')
@section('active', 'messages')

@section('content')
@php
    $totalAll = ($statusCounts['new'] ?? 0) + ($statusCounts['read'] ?? 0) + ($statusCounts['replied'] ?? 0);
@endphp
<div class="saas-editor">
    <div class="saas-list-head">
        <div>
            <div class="saas-eyebrow">Communications</div>
            <h1 class="saas-list-head__title">Messages <span class="saas-count">{{ $messages->total() }}</span></h1>
            <p class="saas-list-head__sub">Inbox for contact form enquiries — read, reply, and archive.</p>
        </div>
        <form method="GET" action="{{ route('admin.messages.index') }}" class="saas-search" role="search">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <input class="saas-input" id="messageSearch" type="search" name="search" value="{{ request('search') }}" placeholder="Search name, email, message…" aria-label="Search messages">
            <button type="submit" class="btn btn--ghost saas-btn">Search</button>
        </form>
    </div>

    <div class="saas-inbox-stats" role="navigation" aria-label="Message status filters">
        <a href="{{ route('admin.messages.index', request()->except('status', 'page')) }}" class="saas-inbox-stat {{ !request('status') ? 'is-active' : '' }}">
            <span class="saas-inbox-stat__label">All</span>
            <span class="saas-inbox-stat__value">{{ $totalAll }}</span>
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->except('page'), ['status' => 'new'])) }}" class="saas-inbox-stat {{ request('status') === 'new' ? 'is-active' : '' }}">
            <span class="saas-inbox-stat__label">New</span>
            <span class="saas-inbox-stat__value">{{ $statusCounts['new'] }}</span>
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->except('page'), ['status' => 'read'])) }}" class="saas-inbox-stat {{ request('status') === 'read' ? 'is-active' : '' }}">
            <span class="saas-inbox-stat__label">Read</span>
            <span class="saas-inbox-stat__value">{{ $statusCounts['read'] }}</span>
        </a>
        <a href="{{ route('admin.messages.index', array_merge(request()->except('page'), ['status' => 'replied'])) }}" class="saas-inbox-stat {{ request('status') === 'replied' ? 'is-active' : '' }}">
            <span class="saas-inbox-stat__label">Replied</span>
            <span class="saas-inbox-stat__value">{{ $statusCounts['replied'] }}</span>
        </a>
    </div>

    <section class="saas-panel">
        <div class="saas-panel__head">
            <div>
                <h2 class="saas-panel__title">Inbox</h2>
                <p class="saas-panel__sub">
                    @if(request('search'))
                        Results for “{{ request('search') }}”
                    @elseif(request('status'))
                        Showing {{ request('status') }} messages
                    @else
                        Newest enquiries first
                    @endif
                </p>
            </div>
        </div>

        <div class="saas-inbox-list">
            @forelse($messages as $message)
                <a href="{{ route('admin.messages.show', $message) }}" class="saas-inbox-item {{ $message->status === 'new' ? 'is-new' : '' }}">
                    <div class="saas-inbox-item__avatar" aria-hidden="true">{{ strtoupper(mb_substr($message->name, 0, 2)) }}</div>
                    <div>
                        <div class="saas-inbox-item__top">
                            <span class="saas-inbox-item__name">{{ $message->name }}</span>
                            <time class="saas-inbox-item__time" datetime="{{ $message->created_at->toIso8601String() }}">{{ $message->created_at->diffForHumans() }}</time>
                        </div>
                        <div class="saas-inbox-item__subject">{{ $message->subject ?: 'No subject' }}</div>
                        <div class="saas-inbox-item__preview">{{ \Illuminate\Support\Str::limit($message->message, 140) }}</div>
                    </div>
                    <div class="saas-inbox-item__side">
                        <span class="saas-status {{ $message->status === 'replied' ? 'is-live' : 'is-draft' }}">
                            <span class="saas-status__dot"></span>
                            {{ ucfirst($message->status) }}
                        </span>
                        @if($message->service)
                            <span class="saas-chip saas-chip--purple">{{ $message->service->title }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="saas-empty" style="padding:48px 24px">
                    <strong>No messages found</strong>
                    <p style="margin-top:6px;color:var(--t-muted)">Try another filter, or wait for new contact form submissions.</p>
                    @if(request()->hasAny(['status', 'search']))
                        <a href="{{ route('admin.messages.index') }}" class="btn btn--primary saas-btn" style="margin-top:16px">Clear filters</a>
                    @endif
                </div>
            @endforelse
        </div>

        @if($messages->hasPages())
            <div class="saas-pager">{{ $messages->links() }}</div>
        @endif
    </section>
</div>
@endsection
