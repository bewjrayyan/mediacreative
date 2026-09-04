@extends('admin.layouts.app')

@section('title', 'Message Detail')
@section('crumb', 'Messages · View')

@section('content')
<section class="hero">
    <div class="hero-text">
        <span class="eyebrow">Inbox</span>
        <h1 class="hero-title">Message from <span class="accent">{{ $message->name }}</span></h1>
    </div>
    <div class="hero-actions">
        <a href="{{ route('admin.messages.index') }}" class="btn btn--ghost">Back to Inbox</a>
        @if($message->status !== 'replied')
        <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}" style="display:inline">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn--primary">Mark as Replied</button>
        </form>
        @endif
    </div>
</section>

<div class="grid">
    <section class="col-8 card">
        <div class="card-head">
            <div class="card-title-wrap">
                <span class="eyebrow">Message</span>
                <h2 class="card-title">{{ $message->subject ?: 'No Subject' }}</h2>
            </div>
            <span class="badge {{ $message->status === 'new' ? 'danger' : ($message->status === 'replied' ? 'success' : 'info') }}">{{ ucfirst($message->status) }}</span>
        </div>
        <div style="padding:8px 0;line-height:1.8;color:var(--t-base);font-size:14.5px;white-space:pre-wrap">{{ $message->message }}</div>
    </section>
    <section class="col-4 card">
        <div class="card-head">
            <div class="card-title-wrap"><span class="eyebrow">Info</span><h2 class="card-title">Contact details</h2></div>
        </div>
        <div style="display:flex;flex-direction:column;gap:16px">
            <div>
                <div class="eyebrow">Name</div>
                <div style="font-weight:600;color:var(--t-base);font-size:14.5px">{{ $message->name }}</div>
            </div>
            <div>
                <div class="eyebrow">Email</div>
                <a href="mailto:{{ $message->email }}" style="color:var(--primary);text-decoration:none;font-size:14px">{{ $message->email }}</a>
            </div>
            @if($message->phone)
            <div>
                <div class="eyebrow">Phone</div>
                <div style="color:var(--t-base);font-size:14px">{{ $message->phone }}</div>
            </div>
            @endif
            @if($message->service)
            <div>
                <div class="eyebrow">Service</div>
                <span class="badge info">{{ $message->service->title }}</span>
            </div>
            @endif
            <div>
                <div class="eyebrow">Received</div>
                <div style="color:var(--t-base);font-size:14px">{{ $message->created_at->format('F j, Y g:i A') }}</div>
                <div style="color:var(--t-light);font-size:12px">{{ $message->created_at->diffForHumans() }}</div>
            </div>
            @if($message->status === 'read')
            <div>
                <form method="POST" action="{{ route('admin.messages.mark-replied', $message) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn--primary" style="width:100%">Mark as Replied</button>
                </form>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection
