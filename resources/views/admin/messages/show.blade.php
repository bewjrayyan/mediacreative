@extends('admin.layouts.app')

@section('title', 'Message · ' . $message->name)
@section('crumb', 'Messages · View')
@section('active', 'messages')

@section('content')
@php
    $mailto = 'mailto:' . rawurlencode($message->email)
        . '?subject=' . rawurlencode('Re: ' . ($message->subject ?: 'Your enquiry'));
@endphp
<div class="saas-editor">
    <div class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.messages.index') }}" class="saas-back" title="Back to inbox" aria-label="Back to inbox">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
            </a>
            <div class="saas-toolbar__meta">
                <div class="saas-eyebrow">Inbox</div>
                <h1 class="saas-title">{{ $message->name }}</h1>
            </div>
            <span class="saas-status {{ $message->status === 'replied' ? 'is-live' : 'is-draft' }}">
                <span class="saas-status__dot"></span>
                {{ ucfirst($message->status) }}
            </span>
        </div>
        <div class="saas-toolbar__actions">
            <a href="{{ $mailto }}" class="btn btn--ghost saas-btn">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="m4 7 8 6 8-6"/></svg>
                Reply by email
            </a>
            @if($message->status !== 'replied')
            <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn--primary saas-btn">Mark as replied</button>
            </form>
            @endif
        </div>
    </div>

    <div class="saas-layout">
        <div class="saas-main">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">{{ $message->subject ?: 'No subject' }}</h2>
                        <p class="saas-panel__sub">Received {{ $message->created_at->format('M j, Y · g:i A') }} · {{ $message->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-message-body">{{ $message->message }}</div>

                    <div class="saas-message-actions">
                        @if($message->status === 'new')
                            <form method="POST" action="{{ route('admin.messages.mark-read', $message) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn--ghost saas-btn">Mark as read</button>
                            </form>
                        @endif
                        @if($message->status !== 'replied')
                            <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn--primary saas-btn">Mark as replied</button>
                            </form>
                        @endif
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" onsubmit="return confirm('Delete this message permanently?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn--ghost saas-btn" style="color:var(--danger)">Delete</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

        <aside class="saas-side">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Sender</h2>
                        <p class="saas-panel__sub">Contact details from the form</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <dl class="saas-meta">
                        <div>
                            <dt>Name</dt>
                            <dd>{{ $message->name }}</dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd><a href="mailto:{{ $message->email }}" style="color:var(--primary);text-decoration:none">{{ $message->email }}</a></dd>
                        </div>
                        @if($message->phone)
                        <div>
                            <dt>Phone</dt>
                            <dd><a href="tel:{{ preg_replace('/\s+/', '', $message->phone) }}" style="color:var(--primary);text-decoration:none">{{ $message->phone }}</a></dd>
                        </div>
                        @endif
                        @if($message->service)
                        <div>
                            <dt>Service interest</dt>
                            <dd><span class="saas-chip saas-chip--purple">{{ $message->service->title }}</span></dd>
                        </div>
                        @endif
                        <div>
                            <dt>Status</dt>
                            <dd>{{ ucfirst($message->status) }}</dd>
                        </div>
                    </dl>
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection
