<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In · {{ setting('site_name', 'Admin') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Inter+Tight:wght@500;600;700&display=swap">
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
    <link rel="stylesheet" href="{{ asset('adminator/css/adminator.css') }}">
    <style>
        body { font-family: 'Inter', sans-serif; background: var(--bg-body); margin: 0; }
        .auth-body { min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; }
        .auth-aside { background: var(--t-base); color: var(--t-inverse); padding: 56px; display: flex; flex-direction: column; justify-content: space-between; }
        .auth-aside h1 { font-family: 'Inter Tight', sans-serif; font-weight: 700; font-size: 38px; line-height: 1.2; letter-spacing: -0.03em; margin: 0 0 16px; }
        .auth-aside p { font-size: 15px; opacity: .8; line-height: 1.7; max-width: 46ch; }
        .auth-brand { display: flex; align-items: center; gap: 12px; font-family: 'Inter Tight', sans-serif; font-weight: 700; font-size: 18px; }
        .auth-aside-footer { display: flex; justify-content: space-between; font-size: 12px; opacity: .55; }
        .auth-main { display: grid; place-items: center; padding: 40px; }
        .auth-card-custom { width: 100%; max-width: 400px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 18px; padding: 40px; box-shadow: var(--shadow-lg); }
        .auth-card-custom h2 { font-family: 'Inter Tight', sans-serif; font-weight: 700; font-size: 24px; color: var(--t-base); margin: 0 0 6px; letter-spacing: -0.02em; }
        .auth-card-custom .sub { font-size: 13.5px; color: var(--t-muted); margin: 0 0 26px; }
        .field { margin-bottom: 18px; }
        .field-label { display: block; font-size: 13px; font-weight: 500; color: var(--t-base); margin-bottom: 6px; }
        .input { width: 100%; padding: 11px 14px; border: 1px solid var(--border); border-radius: 10px; background: var(--bg-card); color: var(--t-base); font-size: 14px; font-family: 'Inter', sans-serif; }
        .input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-ring); }
        .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 11px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; border: none; cursor: pointer; text-decoration: none; transition: all .15s; width: 100%; }
        .btn--primary { background: var(--primary); color: #fff; }
        .btn--primary:hover { background: var(--primary-dark); }
        .auth-error { background: var(--danger-soft); color: var(--danger); border: 1px solid var(--danger); border-radius: 10px; padding: 12px 14px; font-size: 13px; margin-bottom: 18px; }
        .auth-error ul { margin: 0; padding-left: 18px; }
        .auth-quote { margin-top: 32px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,.15); font-size: 14px; font-style: italic; line-height: 1.7; opacity: .9; }
        .auth-quote-author { display: flex; align-items: center; gap: 10px; margin-top: 14px; font-style: normal; font-size: 13px; opacity: .8; }
        .av { width: 34px; height: 34px; border-radius: 50%; background: rgba(255,255,255,.2); display: grid; place-items: center; font-weight: 600; font-size: 12px; }
        .back-link { display: inline-flex; align-items: center; gap: 6px; color: var(--t-muted); font-size: 13px; text-decoration: none; margin-bottom: 24px; }
        .back-link:hover { color: var(--t-base); }
        @media (max-width: 900px) { .auth-body { grid-template-columns: 1fr; } .auth-aside { display: none; } .auth-main { padding: 24px; } }
    </style>
</head>
<body>
    <div class="auth-body">
        <aside class="auth-aside">
            <div class="auth-brand">
                <div class="brand-logo-el" style="width:38px;height:38px;border-radius:11px;background:#fff;color:var(--t-base);display:grid;place-items:center;font-weight:700">{{ strtoupper(substr(setting('site_name','Admin'),0,2)) }}</div>
                {{ setting('site_name', 'Admin Panel') }}
            </div>
            <div>
                <h1>Welcome back to your admin dashboard.</h1>
                <p>Manage your services, portfolio, blog, client messages, and website settings from one place.</p>
                <div class="auth-quote">
                    "Everything we need to run our business — beautifully organized."
                    <div class="auth-quote-author"><div class="av">SM</div><div>Sara M. · Agency Owner</div></div>
                </div>
            </div>
            <div class="auth-aside-footer"><span>© {{ date('Y') }}</span><span>Built with Adminator</span></div>
        </aside>
        <main class="auth-main">
            <div class="auth-card-custom">
                <a href="{{ route('home') }}" class="back-link">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                    Back to website
                </a>
                <h2>Welcome back</h2>
                <p class="sub">Sign in to your admin workspace to continue.</p>

                @if($errors->any())
                <div class="auth-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="field">
                        <label class="field-label" for="email">Email</label>
                        <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" autocomplete="email" required autofocus>
                    </div>
                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <input class="input" id="password" type="password" name="password" placeholder="••••••••" autocomplete="current-password" required>
                    </div>
                    <button type="submit" class="btn btn--primary">Sign in</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
