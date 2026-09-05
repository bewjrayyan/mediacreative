@extends('admin.layouts.app')

@section('title', 'Sales')
@section('active', 'sales')
@section('crumbs', 'Workspace | Sales')

@section('content')
<section class="hero">
  <div class="hero-text">
    <span class="eyebrow">Workspace</span>
    <h1 class="hero-title">Sales <span class="accent">overview</span></h1>
    <p class="hero-sub">Track orders, revenue, and conversion. This page is ready for KPIs, charts, and sales reports.</p>
  </div>
  <div class="hero-actions">
    <button type="button" class="btn btn--ghost">
      <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
      Export
    </button>
    <button type="button" class="btn btn--primary">
      <svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
      New sale
    </button>
  </div>
</section>

<section class="card" style="min-height: 360px; align-items: center; justify-content: center;">
  <div style="text-align: center; color: var(--t-light); padding: 60px 20px;">
    <div style="width: 56px; height: 56px; margin: 0 auto 18px; border-radius: 14px; background: var(--bg-muted); color: var(--t-muted); display: grid; place-items: center;">
      <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
    </div>
    <div style="font-family: 'Inter Tight', sans-serif; font-weight: 700; font-size: 18px; color: var(--t-base); letter-spacing: -0.018em; margin-bottom: 6px;">Sales workspace</div>
    <div style="font-size: 13px; max-width: 40ch; margin: 0 auto;">Starter view for sales metrics and order history. Hook up your data here when ready.</div>
  </div>
</section>
@endsection
