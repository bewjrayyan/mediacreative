<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · {{ setting('site_name', 'Adminator') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Inter+Tight:wght@500;600;700&family=JetBrains+Mono:wght@400;500&display=swap">
    <script>
      (function () {
        try {
          var saved = localStorage.getItem('dash26-theme');
          var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
          document.documentElement.setAttribute('data-theme', saved || (prefersDark ? 'dark' : 'light'));
        } catch (e) {
          document.documentElement.setAttribute('data-theme', 'light');
        }
      })();
    </script>
    <link rel="stylesheet" href="{{ asset('adminator/css/adminator.css') }}" fetchpriority="high">
    <link rel="stylesheet" href="{{ asset('adminator/css/saas-admin.css') }}">
    <style>
        .flash { position: fixed; top: 80px; right: 24px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .flash-alert { display: flex; align-items: flex-start; gap: 10px; padding: 14px 18px; border-radius: 10px; font-size: 14px; box-shadow: var(--shadow-lg); max-width: 380px; background: var(--bg-card); border: 1px solid var(--border); }
        .flash-success { background: var(--success-soft); color: var(--success); border-color: var(--success); }
        .flash-error { background: var(--danger-soft); color: var(--danger); border-color: var(--danger); }
        .admin-table-wrap { overflow-x: auto; }
        .thumb-img { width: 48px; height: 48px; border-radius: 8px; object-fit: cover; }
        .logo-img { width: 40px; height: 40px; border-radius: 8px; object-fit: contain; background: #fff; }
        .empty-state { text-align: center; color: var(--t-muted); padding: 60px 20px; }
        .delete-form { display: inline; }
        .auth-body { background: var(--bg-body); min-height: 100vh; display: grid; place-items: center; padding: 24px; }
        .auth-card-custom { width: 100%; max-width: 420px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 18px; padding: 36px; box-shadow: var(--shadow-lg); }
    </style>
    @stack('styles')
</head>
@php
        $shellCrumbs = trim($__env->yieldContent('crumbs'));
        if ($shellCrumbs === '') {
            $shellCrumbs = 'Workspace | ' . trim($__env->yieldContent('crumb', 'Admin'));
        }
        $shellActive = trim($__env->yieldContent('active'));
    @endphp
<body data-active="{{ $shellActive }}" data-crumbs="{{ $shellCrumbs }}">
    @if(session('success') || session('error'))
    <div class="flash">
        @if(session('success'))
            <div class="flash-alert flash-success">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="flash-alert flash-error">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
    @endif

    <div class="shell">
        <div data-shell-sidebar></div>
        <div class="main">
            <div data-shell-topbar></div>
            <main class="content">
                @yield('content')
            </main>
            <div data-shell-footer></div>
        </div>
    </div>

    <form id="adminLogoutForm" method="POST" action="{{ route('admin.logout') }}" style="display:none">
        @csrf
    </form>

    @php
        $adminName = auth()->user()->name ?? 'John Doe';
        $adminInitials = collect(preg_split('/\s+/', trim($adminName)))
            ->filter()
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->take(2)
            ->implode('');
    @endphp
    <script>
      window.ADMINATOR_BASE_PATH = @json(rtrim(parse_url(url('/'), PHP_URL_PATH) ?: '', '/'));
      window.ADMINATOR_USER = {
        name: @json($adminName),
        email: @json(auth()->user()->email ?? 'john@adminator.app'),
        initials: @json($adminInitials ?: 'JD'),
        role: @json(auth()->user()->role ?? 'admin'),
        settingsUrl: @json(route('admin.settings.index')),
        messagesUrl: @json(route('admin.messages.index')),
        homeUrl: @json(route('admin.dashboard')),
      };
      window.ADMINATOR_ROUTES = {
        'index.html': @json(url('/admin')),
        'email.html': @json(url('/admin/email')),
        'compose.html': @json(url('/admin/compose')),
        'calendar.html': @json(url('/admin/calendar')),
        'chat.html': @json(url('/admin/chat')),
        'charts.html': @json(url('/admin/charts')),
        'forms.html': @json(url('/admin/forms')),
        'ui.html': @json(url('/admin/ui-elements')),
        'buttons.html': @json(url('/admin/buttons')),
        'basic-table.html': @json(url('/admin/basic-table')),
        'datatable.html': @json(url('/admin/datatable')),
        'google-maps.html': @json(url('/admin/google-maps')),
        'vector-maps.html': @json(url('/admin/vector-maps')),
        'blank.html': @json(url('/admin/blank')),
        '404.html': @json(url('/admin/errors/404')),
        '500.html': @json(url('/admin/errors/500')),
        'signin.html': @json(route('admin.login')),
        'signup.html': @json(url('/admin/signup')),
      };
      window.ADMINATOR_API = {
        stats: @json(url('/api/admin/stats')),
        messages: @json(url('/api/admin/messages')),
        messagesChart: @json(url('/api/admin/messages/chart')),
        csrf: document.querySelector('meta[name="csrf-token"]')?.content,
      };
    </script>
    <script defer src="{{ asset('adminator/js/runtime.8f81f023.js') }}"></script>
    <script defer src="{{ asset('adminator/js/2026.d80bdaa4.js') }}"></script>
    <script defer src="{{ asset('adminator/js/admin-bridge.js') }}"></script>
    @stack('scripts')
</body>
</html>
