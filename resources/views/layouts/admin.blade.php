<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'پنل مدیریت | AtilaShop')</title>

    <!-- Digikala Official Font Preload -->
    <link rel="preload" href="/fonts/IRANYekanWebRegular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/IRANYekanWebBold.woff2" as="font" type="font/woff2" crossorigin>

    <style>
        /* IRANYekan Official Webfonts */
        @font-face {
            font-family: 'IRANYekan';
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url('/fonts/IRANYekanWebLight.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekan';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url('/fonts/IRANYekanWebRegular.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekan';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url('/fonts/IRANYekanWebMedium.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekan';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/IRANYekanWebBold.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekan';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url('/fonts/IRANYekanWebExtraBold.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IranYekan';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url('/fonts/IRANYekanWebRegular.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IranYekan';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/IRANYekanWebBold.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekanWeb';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url('/fonts/IRANYekanWebRegular.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANYekanWeb';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/IRANYekanWebBold.woff2') format('woff2');
        }
        :root {
            --bg: #f8fafc;
            --card: #ffffff;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
            --brand: #c2506f;
            --brand-hover: #ab3f5c;
            --primary: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) {
                --bg: #0b0f19;
                --card: #111827;
                --ink: #f8fafc;
                --muted: #94a3b8;
                --line: #1f2937;
                --brand: #e07a97;
                --brand-hover: #f195af;
                --primary: #3b82f6;
            }
        }

        :root[data-theme="dark"] {
            --bg: #0b0f19;
            --card: #111827;
            --ink: #f8fafc;
            --muted: #94a3b8;
            --line: #1f2937;
            --brand: #e07a97;
            --brand-hover: #f195af;
            --primary: #3b82f6;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'IRANYekan', 'IranYekan', 'IRANYekanWeb', 'IRANSansX', 'Digikala', system-ui, -apple-system, BlinkMacSystemFont, Tahoma, sans-serif;
            background: var(--bg);
            color: var(--ink);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        a { color: inherit; text-decoration: none; }
        button { font: inherit; cursor: pointer; border: 0; background: none; }
        input, select, textarea {
            font: inherit;
            color: inherit;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 8px 12px;
            width: 100%;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--brand);
        }

        .ic {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex: none;
        }

        /* Sidebar */
        aside.admin-sidebar {
            width: 260px;
            background: var(--card);
            border-left: 1px solid var(--line);
            display: flex;
            flex-direction: column;
            flex: none;
            min-height: 100vh;
            position: sticky;
            top: 0;
        }
        .sb-head {
            padding: 20px 22px;
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sb-head .badge {
            background: var(--brand);
            color: #fff;
            padding: 2px 8px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
        }
        .sb-nav {
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .sb-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: var(--muted);
            transition: background .15s, color .15s;
        }
        .sb-link:hover, .sb-link.active {
            background: color-mix(in srgb, var(--brand) 12%, transparent);
            color: var(--brand);
            font-weight: 700;
        }
        .sb-foot {
            padding: 16px;
            border-top: 1px solid var(--line);
            font-size: 13px;
        }

        /* Main Content */
        .admin-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        header.admin-top {
            height: 64px;
            background: var(--card);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 20;
        }
        .content-area {
            padding: 28px;
            flex: 1;
        }

        /* Cards & Tables */
        .box {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 20px;
        }
        .table-responsive {
            overflow-x: auto;
        }
        table.tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            text-align: right;
        }
        table.tbl th {
            padding: 12px 14px;
            background: color-mix(in srgb, var(--line) 40%, transparent);
            color: var(--muted);
            font-weight: 600;
            border-bottom: 1px solid var(--line);
        }
        table.tbl td {
            padding: 14px;
            border-bottom: 1px solid var(--line);
            vertical-align: middle;
        }
        table.tbl tr:hover td {
            background: color-mix(in srgb, var(--line) 20%, transparent);
        }

        /* Buttons & Badges */
        .btn {
            background: var(--ink);
            color: var(--bg);
            border-radius: 10px;
            padding: 8px 18px;
            font-weight: 600;
            display: inline-flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: opacity .2s;
        }
        .btn:hover { opacity: .85; }
        .btn.brand { background: var(--brand); color: #fff; }
        .btn.success { background: var(--success); color: #fff; }
        .btn.danger { background: var(--danger); color: #fff; }
        .btn.o { background: none; color: var(--ink); border: 1px solid var(--line); }

        .badge-status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #e0f2fe; color: #075985; }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        @media(max-width: 860px) {
            aside.admin-sidebar { width: 70px; }
            .sb-link span, .sb-head span, .sb-head .badge, .sb-foot .user-name { display: none; }
            .sb-link { justify-content: center; padding: 12px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar">
        <div class="sb-head">
            <span style="font-weight: 800; font-size: 18px;">Atila<b>Shop</b></span>
            <span class="badge">مدیریت</span>
        </div>

        <nav class="sb-nav">
            <a href="{{ route('admin.dashboard') }}" class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="ic" viewBox="0 0 24 24"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                <span>داشبورد آماری</span>
            </a>

            <a href="{{ route('admin.products.index') }}" class="sb-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <svg class="ic" viewBox="0 0 24 24"><path d="m2 9 10-5 10 5-10 5Z"/><path d="m2 14 10 5 10-5"/><path d="m2 19 10 5 10-5"/></svg>
                <span>مدیریت محصولات</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="sb-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <svg class="ic" viewBox="0 0 24 24"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/></svg>
                <span>مدیریت سفارش‌ها</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="sb-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <svg class="ic" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                <span>تنظیمات درگاه و پرداخت</span>
            </a>

            <div style="height: 1px; background: var(--line); margin: 12px 0;"></div>

            <a href="{{ route('home') }}" target="_blank" class="sb-link">
                <svg class="ic" viewBox="0 0 24 24"><path d="M15 3h6v6M10 14 21 3M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>
                <span>مشاهده سایت فروشگاه</span>
            </a>
        </nav>

        <div class="sb-foot">
            <div class="user-name" style="font-weight: 700; margin-bottom: 2px;">{{ Auth::user()->name }}</div>
            <div class="user-name" style="font-size: 11px; color: var(--muted); margin-bottom: 10px;">{{ Auth::user()->email }}</div>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn o" style="width: 100%; padding: 6px; font-size: 12px;">
                    خروج از حساب
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="admin-main">
        <header class="admin-top">
            <div style="font-size: 14px; font-weight: 600;">
                @yield('breadcrumb', 'پنل مدیریت آتیلاشاپ')
            </div>

            <div style="display: flex; align-items: center; gap: 14px;">
                <button id="theme-btn" style="padding: 6px; border-radius: 8px; border: 1px solid var(--line); font-size: 13px;">
                    🌓 تم شب / روز
                </button>
                <div style="font-size: 13px; font-weight: 600;">
                    خوش آمدید، {{ Auth::user()->name }}
                </div>
            </div>
        </header>

        <div class="content-area">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        // Dark mode toggle in admin
        const themeBtn = document.getElementById('theme-btn');
        if (themeBtn) {
            themeBtn.addEventListener('click', () => {
                const current = document.documentElement.dataset.theme;
                const next = current === 'dark' ? 'light' : 'dark';
                document.documentElement.dataset.theme = next;
                localStorage.setItem('theme', next);
            });
        }
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.dataset.theme = savedTheme;
        }
    </script>
    @yield('scripts')
</body>
</html>
