@extends('admin.layouts.app')

@section('title', 'Message Detail')
@section('crumb', 'Messages · View')
@section('active', 'messages')

@section('content')
<div class="saas-editor">
    <div class="saas-toolbar">
        <div class="saas-toolbar__left">
            <a href="{{ route('admin.messages.index') }}" class="saas-back" title="Back to inbox" aria-label="Back to inbox">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
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
            @if($message->status !== 'replied')
            <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}">
                @csrf @method('PATCH')
                <button type="submit" class="btn btn--primary saas-btn">Mark as Replied</button>
            </form>
            @endif
        </div>
    </div>

    <div class="saas-layout">
        <div class="saas-main">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">{{ $message->subject ?: 'No Subject' }}</h2>
                        <p class="saas-panel__sub">Message body</p>
                    </div>
                </div>
                <div class="saas-panel__body">
                    <div class="saas-message-body">{{ $message->message }}</div>
                </div>
            </section>
        </div>

        <aside class="saas-side">
            <section class="saas-panel">
                <div class="saas-panel__head">
                    <div>
                        <h2 class="saas-panel__title">Contact details</h2>
                        <p class="saas-panel__sub">Sender information</p>
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
                            <dd>{{ $message->phone }}</dd>
                        </div>
                        @endif
                        @if($message->service)
                        <div>
                            <dt>Service</dt>
                            <dd><span class="saas-chip saas-chip--purple">{{ $message->service->title }}</span></dd>
                        </div>
                        @endif
                        <div>
                            <dt>Received</dt>
                            <dd>
                                {{ $message->created_at->format('F j, Y g:i A') }}
                                <div class="saas-hint">{{ $message->created_at->diffForHumans() }}</div>
                            </dd>
                        </div>
                    </dl>
                    @if($message->status === 'read')
                    <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn--primary saas-btn saas-btn--block">Mark as Replied</button>
                    </form>
                    @endif
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection
