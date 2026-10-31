<!doctype html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AtilaShop | فروشگاه آنلاین پوشاک')</title>
    
    <script>
        (function() {
            var t = localStorage.getItem('theme');
            if (t) document.documentElement.dataset.theme = t;
        })();
    </script>
    
    <!-- Digikala Official Font Preload -->
    <link rel="preload" href="/fonts/digikala-variable.woff2" as="font" type="font/woff2" crossorigin>
    
    <style>
        /* Digikala & IRANSansX Variable Webfont */
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 100 1000;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2-variations'),
                 url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 500;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'Digikala';
            font-style: normal;
            font-weight: 800;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2');
        }
        @font-face {
            font-family: 'IRANSansX';
            font-style: normal;
            font-weight: 100 1000;
            font-display: swap;
            src: url('/fonts/digikala-variable.woff2') format('woff2-variations'),
                 url('/fonts/digikala-variable.woff2') format('woff2');
        }

        :root {
            /* Velvety Vintage Rose Light Theme (Harmonized with Announcement Bar) */
            --bg: #fff6f9;
            --bg-subtle: #fdf1f6;
            --card: #ffffff;
            --ink: #22121b;
            --muted: #7d6572;
            --line: #f5d7e4;
            --line-subtle: #fbeaf1;
            --brand: #a82b59;
            --brand-hover: #8f214a;
            --brand-light: #fdf3f7;
            --brand-border: #f7cadb;
            --brand-glow: rgba(168, 43, 89, 0.22);
            --brand-gradient: linear-gradient(135deg, #b63468 0%, #8c2049 100%);
            --sale: #c52250;
            --success: #10b981;
            --warning: #f59e0b;
            --bgl: 95%;
            --gl: 44%;
            --hbg: 94%;
            --arch: 90%;
            --card-media-bg: linear-gradient(180deg, #fff4f8 0%, #fde8f0 100%);
            --card-shadow: 0 4px 16px rgba(168, 43, 89, 0.04);
            --card-shadow-hover: 0 12px 30px rgba(168, 43, 89, 0.12);
            --pill-shadow: 0 2px 8px rgba(168, 43, 89, 0.08);
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) {
                /* Luxury Velvet Obsidian Dark Theme */
                --bg: #0b0a0f;
                --bg-subtle: #121118;
                --card: #16151e;
                --ink: #ffffff;
                --muted: #9ea3b2;
                --line: #252330;
                --line-subtle: #1c1b26;
                --brand: #f43f7a;
                --brand-hover: #fb7185;
                --brand-light: rgba(244, 63, 122, 0.12);
                --brand-border: rgba(244, 63, 122, 0.32);
                --brand-glow: rgba(244, 63, 122, 0.32);
                --brand-gradient: linear-gradient(135deg, #f43f7a 0%, #be185d 100%);
                --sale: #ff4d6d;
                --success: #10b981;
                --warning: #f59e0b;
                --bgl: 18%;
                --gl: 72%;
                --hbg: 13%;
                --arch: 18%;
                --card-media-bg: linear-gradient(180deg, #1d1b26 0%, #15141d 100%);
                --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
                --card-shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.6), 0 0 18px rgba(244, 63, 122, 0.2);
                --pill-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
            }
        }

        :root[data-theme="dark"] {
            /* Luxury Velvet Obsidian Dark Theme */
            --bg: #0b0a0f;
            --bg-subtle: #121118;
            --card: #16151e;
            --ink: #ffffff;
            --muted: #9ea3b2;
            --line: #252330;
            --line-subtle: #1c1b26;
            --brand: #f43f7a;
            --brand-hover: #fb7185;
            --brand-light: rgba(244, 63, 122, 0.12);
            --brand-border: rgba(244, 63, 122, 0.32);
            --brand-glow: rgba(244, 63, 122, 0.32);
            --brand-gradient: linear-gradient(135deg, #f43f7a 0%, #be185d 100%);
            --sale: #ff4d6d;
            --success: #10b981;
            --warning: #f59e0b;
            --bgl: 18%;
            --gl: 72%;
            --hbg: 13%;
            --arch: 18%;
            --card-media-bg: linear-gradient(180deg, #1d1b26 0%, #15141d 100%);
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
            --card-shadow-hover: 0 12px 32px rgba(0, 0, 0, 0.6), 0 0 18px rgba(244, 63, 122, 0.2);
            --pill-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
        }

        html {
            scroll-padding-top: calc(env(safe-area-inset-top, 0px) + 70px);
            scroll-behavior: smooth;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Digikala', 'IRANSansX', 'IRANSans', system-ui, -apple-system, BlinkMacSystemFont, Tahoma, sans-serif;
            background: var(--bg);
            background-image: radial-gradient(120% 75% at 50% -8%, #ffe8f2 0%, var(--bg) 60%);
            background-attachment: fixed;
            color: var(--ink);
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        :root[data-theme="dark"] body {
            background-image: radial-gradient(120% 75% at 50% -8%, rgba(244, 63, 122, 0.08) 0%, var(--bg) 60%);
        }
        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) body {
                background-image: radial-gradient(120% 75% at 50% -8%, rgba(244, 63, 122, 0.08) 0%, var(--bg) 60%);
            }
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0 0 auto;
            height: env(safe-area-inset-top, 0px);
            z-index: 10;
            background: var(--bg);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font: inherit;
            color: inherit;
            cursor: pointer;
            border: 0;
            background: none;
            padding: 0;
        }

        input, select, textarea {
            font: inherit;
            color: inherit;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 10px 14px;
            width: 100%;
            transition: border-color .2s, box-shadow .2s;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--brand);
            box-shadow: 0 0 0 3.5px var(--brand-glow);
        }
        select option {
            background: var(--card);
            color: var(--ink);
        }

        input[type="radio"], input[type="checkbox"] {
            accent-color: var(--brand);
        }

        label:has(input[type="radio"]:checked) {
            border-color: var(--brand) !important;
            background: var(--brand-light) !important;
            box-shadow: 0 4px 14px var(--brand-glow) !important;
        }

        .ic {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex: none;
        }

        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 18px;
            width: 100%;
        }

        /* Announcement Bar */
        .ann {
            background: linear-gradient(90deg, #fff0f5 0%, #fde4ee 50%, #fff0f5 100%);
            color: #8c254e;
            text-align: center;
            font-size: 12.5px;
            padding: 7px 14px;
            font-weight: 600;
            letter-spacing: .2px;
            border-bottom: 1px solid #f9d1e0;
            box-shadow: 0 1px 4px rgba(168, 43, 89, 0.04);
        }

        :root[data-theme="dark"] .ann {
            background: #1c1017;
            color: #f7d5e2;
            border-bottom: 1px solid #331926;
            box-shadow: none;
        }
        @media (prefers-color-scheme: dark) {
            :root:not([data-theme="light"]) .ann {
                background: #1c1017;
                color: #f7d5e2;
                border-bottom: 1px solid #331926;
                box-shadow: none;
            }
        }

        /* Header */
        header {
            position: sticky;
            top: env(safe-area-inset-top, 0px);
            z-index: 25;
            background: color-mix(in srgb, var(--bg) 88%, transparent);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 2px 14px rgba(168, 43, 89, 0.04);
        }

        .hd {
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 64px;
            flex-wrap: wrap;
        }

        .logo {
            font-weight: 800;
            font-size: 24px;
            letter-spacing: -.5px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .logo b {
            color: var(--brand);
            background: var(--brand-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav {
            display: flex;
            gap: 20px;
            margin-inline-start: 24px;
            font-size: 14px;
            font-weight: 500;
            align-items: center;
        }
        .nav a, .nav button {
            padding: 6px 0;
            border-bottom: 2px solid transparent;
            transition: border-color .2s, color .2s;
            white-space: nowrap;
        }
        .nav a:hover, .nav button:hover {
            border-color: var(--brand);
            color: var(--brand);
        }
        .nav a.active {
            border-color: var(--brand);
            color: var(--brand);
            font-weight: 700;
        }
        .nav .hot {
            color: var(--sale);
            font-weight: 700;
        }
        .size-guide-pill {
            background: var(--brand-light) !important;
            color: var(--brand) !important;
            border: 1px solid var(--brand-border) !important;
            border-radius: 99px !important;
            padding: 6px 15px !important;
            font-size: 12.5px !important;
            font-weight: 700 !important;
            display: inline-flex !important;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(168, 43, 89, 0.08);
            transition: all .2s ease;
            cursor: pointer;
        }
        .size-guide-pill:hover {
            background: var(--brand-gradient) !important;
            color: #fff !important;
            border-color: transparent !important;
            box-shadow: 0 4px 14px rgba(168, 43, 89, 0.3) !important;
            transform: translateY(-1px);
        }

        /* Size Guide Modal & Tabs */
        .sg-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid var(--line);
            margin-bottom: 20px;
            overflow-x: auto;
        }
        .sg-tab {
            padding: 10px 16px;
            font-weight: 700;
            font-size: 14px;
            color: var(--muted);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            transition: all .2s;
            cursor: pointer;
            white-space: nowrap;
        }
        .sg-tab:hover {
            color: var(--ink);
        }
        .sg-tab.active {
            color: var(--brand);
            border-color: var(--brand);
        }
        .sg-pane {
            display: none;
        }
        .sg-pane.active {
            display: block;
        }
        .sg-calc-box {
            background: color-mix(in srgb, var(--brand) 7%, var(--card));
            border: 1px solid color-mix(in srgb, var(--brand) 25%, transparent);
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 20px;
        }
        .sg-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            margin-top: 12px;
        }
        .sg-table th, .sg-table td {
            padding: 10px 12px;
            border: 1px solid var(--line);
            text-align: center;
        }
        .sg-table th {
            background: color-mix(in srgb, var(--ink) 4%, var(--card));
            font-weight: 700;
        }

        /* Notifications Dropdown */
        .notif-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 8px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 12px;
            min-width: 320px;
            max-width: 90vw;
            box-shadow: 0 12px 30px rgba(0,0,0,.15);
            display: none;
            flex-direction: column;
            z-index: 50;
        }
        .notif-dropdown.show {
            display: flex;
        }
        .notif-item {
            padding: 10px 12px;
            border-radius: 12px;
            background: var(--bg);
            border: 1px solid var(--line);
            font-size: 13px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
            transition: background .15s;
            text-align: right;
            text-decoration: none;
            color: inherit;
        }
        .notif-item:hover {
            background: color-mix(in srgb, var(--brand) 10%, var(--bg));
        }
        .notif-item.unread {
            border-right: 4px solid var(--brand);
            background: color-mix(in srgb, var(--brand) 6%, var(--card));
        }

        /* Order Stepper (Digikala Style 5-Steps) */
        .order-stepper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            position: relative;
            padding: 16px 8px 12px;
            margin: 16px 0 24px;
            overflow-x: auto;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
            min-width: 90px;
            text-align: center;
        }
        .step-node {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--card);
            border: 2px solid var(--line);
            display: grid;
            place-items: center;
            font-weight: 800;
            font-size: 14px;
            color: var(--muted);
            transition: all .3s ease;
            margin-bottom: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.05);
        }
        .step-item.completed .step-node {
            background: var(--success);
            border-color: var(--success);
            color: #fff;
        }
        .step-item.active .step-node {
            background: var(--brand-gradient);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 0 0 5px var(--brand-glow);
            animation: pulse-step 2s infinite;
        }
        @keyframes pulse-step {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.06); }
        }

        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
        .step-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 2px;
        }
        .step-item.active .step-label {
            color: var(--brand);
            font-weight: 800;
        }
        .step-item.completed .step-label {
            color: var(--ink);
        }
        .step-sub {
            font-size: 11px;
            color: var(--muted);
        }
        .step-connector {
            position: absolute;
            top: 22px;
            right: 50%;
            left: -50%;
            height: 3px;
            background: var(--line);
            z-index: 1;
        }
        .step-item.completed .step-connector {
            background: var(--success);
        }
        .step-item.active .step-connector {
            background: linear-gradient(to left, var(--success), var(--brand));
        }
        .step-item:first-child .step-connector {
            display: none;
        }

        .sp {
            flex: 1;
        }

        .ib {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, color .2s;
        }
        .ib:hover {
            background: var(--brand-light);
            color: var(--brand);
        }

        .bg2 {
            position: absolute;
            top: 1px;
            left: -1px;
            background: var(--brand-gradient);
            color: #fff;
            border-radius: 99px;
            font-size: 11px;
            min-width: 19px;
            height: 19px;
            line-height: 19px;
            text-align: center;
            padding: 0 4px;
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(168, 43, 89, 0.4);
            border: 1.5px solid var(--card);
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }
        .user-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 8px;
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 8px;
            min-width: 210px;
            box-shadow: 0 12px 30px rgba(0,0,0,.15);
            display: none;
            flex-direction: column;
            gap: 4px;
            z-index: 50;
        }
        .user-dropdown.show {
            display: flex;
        }
        .user-dropdown a, .user-dropdown button {
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-align: right;
            width: 100%;
            transition: background .15s;
        }
        .user-dropdown a:hover, .user-dropdown button:hover {
            background: var(--line);
        }
        .user-dropdown .user-meta {
            padding: 8px 12px 10px;
            border-bottom: 1px solid var(--line);
            margin-bottom: 4px;
        }
        .user-meta .name {
            font-weight: 700;
            font-size: 14px;
        }
        .user-meta .email {
            font-size: 12px;
            color: var(--muted);
        }

        @media(max-width: 760px) {
            .nav {
                order: 3;
                width: 100%;
                margin: 0;
                overflow-x: auto;
                padding-bottom: 8px;
                gap: 20px;
            }
        }

        /* Buttons */
        .btn {
            background: var(--brand-gradient);
            color: #ffffff;
            border-radius: 99px;
            padding: 12px 28px;
            font-weight: 700;
            display: inline-flex;
            gap: 8px;
            align-items: center;
            justify-content: center;
            transition: all .2s ease;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(168, 43, 89, 0.3);
            border: 0;
        }
        .btn:hover {
            opacity: .95;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(168, 43, 89, 0.42);
        }
        .btn.o {
            background: var(--card);
            color: var(--brand);
            border: 1.5px solid var(--brand-border);
            box-shadow: 0 2px 8px rgba(168, 43, 89, 0.08);
        }
        .btn.o:hover {
            background: var(--brand-light);
            border-color: var(--brand);
            color: var(--brand-hover);
            transform: translateY(-1px);
        }
        .btn.brand {
            background: var(--brand-gradient);
            color: #ffffff;
            box-shadow: 0 4px 18px rgba(168, 43, 89, 0.35);
        }
        .btn.brand:hover {
            box-shadow: 0 8px 26px rgba(168, 43, 89, 0.48);
        }
        .btn.dark {
            background: var(--ink);
            color: var(--bg);
            box-shadow: 0 4px 14px rgba(0,0,0,.15);
        }

        /* Hero */
        .hero {
            position: relative;
            margin: 18px 0 0;
            border-radius: 28px;
            overflow: hidden;
            min-height: 430px;
            border: 1px solid var(--line);
            box-shadow: 0 8px 30px rgba(168, 43, 89, 0.08);
        }
        .sl {
            position: absolute;
            inset: 0;
            display: grid;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            gap: 20px;
            padding: 0 clamp(22px, 6vw, 70px);
            background: hsl(var(--h) 55% var(--hbg));
            opacity: 0;
            pointer-events: none;
            transition: opacity .8s ease;
        }
        .sl.on {
            opacity: 1;
            pointer-events: auto;
        }
        .kick {
            display: inline-block;
            font-size: 12.5px;
            letter-spacing: .5px;
            color: var(--brand);
            font-weight: 800;
            background: var(--brand-light);
            border: 1px solid var(--brand-border);
            border-radius: 99px;
            padding: 4px 14px;
            margin-bottom: 8px;
        }
        .sl h1 {
            font-size: clamp(28px, 4.5vw, 52px);
            line-height: 1.25;
            margin: 8px 0 12px;
            font-weight: 800;
            letter-spacing: -1px;
        }
        .sl p {
            color: var(--muted);
            max-width: 420px;
            margin: 0 0 22px;
            font-size: 15px;
        }
        .arch {
            justify-self: center;
            position: relative;
            width: min(300px, 100%);
            aspect-ratio: 3/4;
            border-radius: 999px 999px 24px 24px;
            background: hsl(var(--h) 45% var(--arch));
            display: grid;
            place-items: center;
            max-height: 360px;
            box-shadow: 0 12px 32px rgba(168, 43, 89, 0.15);
        }
        .tag {
            position: absolute;
            bottom: 18px;
            right: -14px;
            background: var(--card);
            border: 1px solid var(--brand-border);
            border-radius: 14px;
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 700;
            color: var(--brand);
            box-shadow: 0 8px 24px rgba(168, 43, 89, 0.18);
        }
        .pg {
            position: absolute;
            bottom: 16px;
            right: clamp(22px, 6vw, 70px);
            display: flex;
            gap: 8px;
            z-index: 2;
        }
        .pg i {
            width: 38px;
            height: 4px;
            background: rgba(0,0,0,.15);
            border-radius: 2px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: block;
        }
        .pg i.on::after {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--brand);
            animation: fill 5s linear forwards;
            transform-origin: right;
        }
        @keyframes fill {
            from { transform: scaleX(0); }
            to { transform: scaleX(1); }
        }
        @media(max-width: 760px) {
            .hero {
                min-height: 500px;
            }
            .sl {
                grid-template-columns: 1fr;
                align-content: center;
                padding-top: 20px;
            }
            .arch {
                width: 150px;
                max-height: 200px;
                order: -1;
            }
            .tag {
                display: none;
            }
            .sl h1 {
                font-size: 26px;
            }
        }

        :root[data-theme="dark"] .hero,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .hero } {
            box-shadow: 0 14px 40px rgba(0, 0, 0, 0.55);
        }
        :root[data-theme="dark"] .sl,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .sl } {
            background: radial-gradient(circle at 82% 45%, color-mix(in srgb, hsl(var(--h) 70% 38%) 22%, transparent) 0%, transparent 60%),
                        linear-gradient(135deg, #131119 0%, #181522 50%, #121017 100%);
        }
        :root[data-theme="dark"] .arch,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .arch } {
            background: #1b1924;
            border: 1px solid rgba(244, 63, 122, 0.22);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.6);
        }
        :root[data-theme="dark"] .pg i,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .pg i } {
            background: rgba(255, 255, 255, 0.22);
        }

        /* Trust */
        .trust {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin: 24px 0;
        }
        .trust div {
            display: flex;
            gap: 12px;
            align-items: center;
            font-size: 13px;
            color: var(--muted);
            background: var(--card);
            padding: 14px 16px;
            border-radius: 18px;
            border: 1px solid var(--line);
            box-shadow: var(--card-shadow);
            transition: all .2s ease;
        }
        .trust div:hover {
            border-color: var(--brand-border);
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-1px);
        }
        .trust b {
            display: block;
            color: var(--ink);
            font-size: 14px;
        }
        .trust .ic {
            width: 26px;
            height: 26px;
            color: var(--brand);
            background: var(--brand-light);
            padding: 7px;
            border-radius: 12px;
            box-sizing: content-box;
            border: 1px solid var(--brand-border);
            flex-shrink: 0;
        }
        @media(max-width: 760px) {
            .trust {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Section Titles */
        h2.t {
            font-size: 24px;
            margin: 36px 0 16px;
            font-weight: 800;
            letter-spacing: -.5px;
            display: flex;
            align-items: baseline;
            gap: 12px;
        }
        h2.t small {
            font-size: 14px;
            color: var(--muted);
            font-weight: 400;
        }

        /* Category Tiles */
        .tiles {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }
        .tile {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            text-align: right;
            display: block;
            width: 100%;
            cursor: pointer;
            border: 1px solid var(--line);
            background: var(--card);
            box-shadow: var(--card-shadow);
            transition: all .25s ease;
        }
        .tile:hover {
            border-color: var(--brand-border);
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        .tile .art {
            aspect-ratio: 4/5;
        }
        .tile span {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: color-mix(in srgb, var(--card) 92%, transparent);
            color: var(--ink);
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 13.5px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            border: 1px solid var(--line);
            backdrop-filter: blur(8px);
            transition: all .2s ease;
        }
        :root[data-theme="dark"] .tile span,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .tile span } {
            background: rgba(22, 21, 30, 0.88);
            border-color: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.45);
        }
        .tile:hover span {
            color: var(--brand);
            border-color: var(--brand-border);
            background: var(--card);
        }
        .tile:hover .g {
            transform: scale(1.08);
        }
        .tile:hover img {
            transform: scale(1.08);
        }
        @media(max-width: 760px) {
            .tiles {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* Reassurance Banner (Discreet Packaging & Privacy) */
        .reassurance-banner {
            position: relative;
            overflow: hidden;
            background-color: var(--card);
            background-image: 
                radial-gradient(ellipse 65% 130% at 100% 50%, color-mix(in srgb, var(--brand) 16%, transparent) 0%, color-mix(in srgb, var(--brand) 4%, transparent) 45%, transparent 70%),
                linear-gradient(to left, color-mix(in srgb, var(--brand) 7%, transparent) 0%, transparent 50%);
            border: 1px solid var(--line);
            border-right: 2px solid color-mix(in srgb, var(--brand) 45%, var(--line));
            border-radius: 22px;
            padding: 22px 26px;
            margin: 28px 0 34px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
            box-shadow: var(--card-shadow);
        }
        .reassurance-banner::after {
            content: "";
            position: absolute;
            top: 50%;
            right: -30px;
            transform: translateY(-50%);
            width: 220px;
            height: 220px;
            background: radial-gradient(circle, color-mix(in srgb, var(--brand) 22%, transparent) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
            filter: blur(16px);
            z-index: 1;
        }
        .reassurance-content {
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 2;
        }
        .reassurance-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: color-mix(in srgb, var(--brand) 12%, var(--card));
            border: 1px solid color-mix(in srgb, var(--brand) 30%, var(--line));
            display: grid;
            place-items: center;
            color: var(--brand);
            flex-shrink: 0;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--brand) 20%, transparent);
        }
        .reassurance-title {
            font-size: 16px;
            display: block;
            margin-bottom: 4px;
            color: var(--ink);
            font-weight: 800;
        }
        .reassurance-desc {
            margin: 0;
            font-size: 13px;
            line-height: 1.7;
            color: var(--muted);
        }
        .reassurance-banner .btn.o {
            position: relative;
            z-index: 2;
        }

        /* Apparel Art Vector */
        .art {
            aspect-ratio: 3/4;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: hsl(var(--h, 345) 45% var(--bgl, 93%));
        }
        .g {
            width: 60%;
            color: hsl(var(--h, 345) 36% var(--gl, 44%));
            filter: drop-shadow(0 12px 14px rgba(0,0,0,.14));
            transition: transform .5s ease;
        }

        /* Filter Toolbar */
        .tool {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 18px;
        }
        .chips {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            flex: 1 1 100%;
            padding-bottom: 6px;
            scrollbar-width: none;
        }
        .chips::-webkit-scrollbar {
            display: none;
        }
        .chip {
            flex: none;
            padding: 8px 18px;
            border-radius: 99px;
            border: 1px solid var(--line);
            font-size: 14px;
            background: var(--card);
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(168, 43, 89, 0.03);
            transition: all .2s ease;
        }
        .chip:hover {
            border-color: var(--brand-border);
            color: var(--brand);
            background: var(--brand-light);
            transform: translateY(-1px);
        }
        .chip.on {
            background: var(--brand-gradient);
            color: #ffffff;
            border-color: transparent;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(168, 43, 89, 0.3);
        }
        .tool input {
            flex: 1 1 200px;
        }
        .tool select {
            flex: 0 1 180px;
        }

        /* Product Grid */
        .grid {
            display: grid;
            gap: 22px 16px;
            grid-template-columns: repeat(4, 1fr);
        }
        @media(max-width: 980px) {
            .grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        @media(max-width: 640px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px 10px;
            }
        }

        /* Product Card */
        .card {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
            box-shadow: var(--card-shadow);
        }
        .card:hover {
            border-color: var(--brand-border);
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-3px);
        }
        .card:hover .g {
            transform: scale(1.06) translateY(-4px);
        }
        .card:hover .card-photo {
            transform: scale(1.06);
        }
        .im {
            position: relative;
            cursor: pointer;
            background: hsl(var(--h, 345) 45% var(--bgl, 93%));
        }
        .bd {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            align-items: flex-start;
            z-index: 2;
        }
        .bd b {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 99px;
        }
        .b1 {
            background: color-mix(in srgb, var(--card) 92%, transparent);
            color: var(--brand);
            border: 1px solid var(--brand-border);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(6px);
        }
        .b2 {
            background: linear-gradient(135deg, #ff3d6f 0%, #db2454 100%);
            color: #fff;
            box-shadow: 0 2px 8px rgba(219, 36, 84, 0.35);
        }
        .hb {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--card) 92%, transparent);
            backdrop-filter: blur(6px);
            display: grid;
            place-items: center;
            color: var(--ink);
            z-index: 3;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--line-subtle);
            transition: all .2s ease;
        }
        .hb:hover {
            transform: scale(1.12);
            background: var(--card);
            box-shadow: 0 4px 14px var(--brand-glow);
            color: var(--brand);
            border-color: var(--brand-border);
        }
        .hb.on {
            background: var(--card);
            border-color: var(--brand-border);
            box-shadow: 0 4px 12px var(--brand-glow);
        }
        .hb.on .ic {
            fill: var(--brand);
            stroke: var(--brand);
        }
        .qa {
            position: absolute;
            inset: auto 8px 8px;
            background: color-mix(in srgb, var(--card) 92%, transparent);
            border-radius: 12px;
            padding: 6px 8px;
            display: none;
            gap: 4px;
            align-items: center;
            font-size: 12px;
            flex-wrap: wrap;
            justify-content: center;
            z-index: 4;
            backdrop-filter: blur(4px);
        }
        @media(hover: hover) {
            .im:hover .qa {
                display: flex;
            }
        }
        .qa button {
            padding: 4px 10px;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: var(--card);
            font-weight: 600;
            transition: all .15s ease;
        }
        .qa button:hover {
            background: var(--brand-gradient);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 2px 8px rgba(168, 43, 89, 0.3);
        }
        .inf {
            padding: 12px 14px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .sw {
            display: flex;
            gap: 6px;
            margin-bottom: 8px;
        }
        .dot {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: hsl(var(--h) 40% 52%);
            outline: 2px solid transparent;
            outline-offset: 2px;
            cursor: pointer;
        }
        .dot.on {
            outline-color: var(--brand);
        }
        .nm {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.4;
        }
        .pr {
            font-size: 15px;
            font-weight: 700;
            margin-top: 6px;
        }
        .pr s {
            color: var(--muted);
            font-size: 13px;
            font-weight: 400;
            margin-inline-start: 6px;
        }
        .low {
            color: var(--sale);
            font-size: 12px;
            font-weight: 600;
            margin-top: 4px;
        }
        .muted {
            color: var(--muted);
        }

        /* Promo Banner */
        .promo {
            margin: 48px 0;
            border-radius: 28px;
            background: linear-gradient(135deg, #2a111e 0%, #46142c 50%, #63173a 100%);
            color: #ffffff;
            padding: clamp(28px, 6vw, 64px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(168, 43, 89, 0.3);
            box-shadow: 0 16px 40px rgba(70, 20, 44, 0.16);
        }
        :root[data-theme="dark"] .promo,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .promo } {
            background: linear-gradient(135deg, #150f1a 0%, #261122 50%, #3a1127 100%);
            border-color: rgba(244, 63, 122, 0.28);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.55);
        }
        .promo::before {
            content: "";
            position: absolute;
            top: -40%;
            right: -15%;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(168, 43, 89, 0.35) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .promo h3 {
            font-size: clamp(24px, 4vw, 40px);
            margin: 0;
            line-height: 1.3;
            font-weight: 800;
        }
        .promo p {
            margin: 6px 0 0;
            opacity: .85;
        }
        .promo .btn {
            background: var(--brand-gradient);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(168, 43, 89, 0.45);
            border: 0;
        }

        /* Newsletter */
        .nl {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 24px 28px;
            background: linear-gradient(180deg, var(--card) 0%, var(--brand-light) 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }
        .nl div {
            display: flex;
            gap: 8px;
            flex: 1 1 280px;
            max-width: 440px;
        }
        .nl input {
            flex: 1;
        }

        /* Footer */
        footer {
            margin-top: auto;
            border-top: 1px solid var(--line);
            padding: 48px 0 28px;
            font-size: 14px;
            background: linear-gradient(180deg, var(--card) 0%, var(--bg) 100%);
        }
        .fg {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 28px;
        }
        @media(max-width: 760px) {
            .fg {
                grid-template-columns: 1fr 1fr;
            }
        }
        .fg h4 {
            margin: 0 0 12px;
            font-weight: 700;
        }
        .fg a, .fg button {
            display: block;
            color: var(--muted);
            padding: 4px 0;
            transition: color .2s;
            text-align: right;
        }
        .fg a:hover, .fg button:hover {
            color: var(--ink);
        }
        .cp {
            text-align: center;
            color: var(--muted);
            margin-top: 32px;
            font-size: 13px;
            border-top: 1px solid var(--line);
            padding-top: 18px;
        }

        /* Modal Overlay */
        .ov {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .6);
            display: none;
            z-index: 50;
            align-items: center;
            justify-content: center;
            padding: 14px;
            backdrop-filter: blur(4px);
        }
        .ov.on {
            display: flex;
        }
        .md {
            background: var(--bg);
            border: 1px solid var(--line);
            border-radius: 26px;
            max-width: 880px;
            width: 100%;
            max-height: 92vh;
            overflow-y: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px;
            padding: 24px;
            position: relative;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
        }
        :root[data-theme="dark"] .md,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .md } {
            background: #131219;
            border-color: #282635;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.75);
        }
        @media(max-width: 720px) {
            .md {
                grid-template-columns: 1fr;
            }
        }
        .x {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 10;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--card);
            display: grid;
            place-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }
        .zoom {
            border-radius: 20px;
            overflow: hidden;
            cursor: zoom-in;
            background: hsl(var(--h, 345) 45% var(--bgl, 93%));
        }
        .zoom .g {
            width: 68%;
            transition: transform .2s ease;
        }
        .th {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }
        .th button {
            width: 64px;
            border-radius: 12px;
            overflow: hidden;
            outline: 2px solid transparent;
            outline-offset: 2px;
            cursor: pointer;
        }
        .th button.on {
            outline-color: var(--ink);
        }
        .th .g {
            width: 60%;
            filter: none;
        }
        .sz {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin: 8px 0 16px;
        }
        .sz button {
            min-width: 48px;
            padding: 8px 14px;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--card);
            font-weight: 600;
            transition: all .2s ease;
        }
        .sz button:hover {
            border-color: var(--brand-border);
            color: var(--brand);
            background: var(--brand-light);
        }
        .sz button.on {
            background: var(--brand-gradient);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(168, 43, 89, 0.35);
        }
        .ft {
            list-style: none;
            padding: 0;
            margin: 16px 0 0;
            font-size: 13px;
            color: var(--muted);
            display: grid;
            gap: 6px;
        }
        .ft li {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .ft .ic {
            width: 16px;
            height: 16px;
            color: var(--brand);
        }
        .mini {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }
        .mini a, .mini button {
            width: 84px;
            text-align: center;
            font-size: 12px;
        }
        .mini .art {
            border-radius: 12px;
        }
        .mini .g {
            width: 56%;
        }

        /* Cart Drawer */
        .dr {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: min(420px, 100%);
            background: var(--bg);
            z-index: 60;
            transform: translateX(-103%);
            transition: transform .3s ease;
            display: flex;
            flex-direction: column;
            padding: 20px;
            padding-top: calc(20px + env(safe-area-inset-top, 0px));
            padding-bottom: calc(20px + env(safe-area-inset-bottom, 0px));
            box-shadow: 0 0 50px rgba(0,0,0,.35);
        }
        :root[data-theme="dark"] .dr,
        @media (prefers-color-scheme: dark) { :root:not([data-theme="light"]) .dr } {
            background: #111017;
            border-right: 1px solid #252330;
            box-shadow: 0 0 60px rgba(0, 0, 0, 0.7);
        }
        .dr.on {
            transform: none;
        }
        .bar {
            height: 6px;
            border-radius: 3px;
            background: var(--line);
            margin: 6px 0 14px;
            overflow: hidden;
        }
        .bar i {
            display: block;
            height: 100%;
            background: var(--brand);
            transition: width .3s ease;
        }
        .ci {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--line);
            font-size: 14px;
        }
        .ci .art {
            width: 60px;
            flex: none;
            border-radius: 10px;
        }
        .ci .g {
            width: 60%;
            filter: none;
        }
        .q {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .q button {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid var(--line);
            display: grid;
            place-items: center;
            background: var(--card);
        }
        .q .ic {
            width: 14px;
            height: 14px;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: calc(24px + env(safe-area-inset-bottom, 0px));
            left: 50%;
            transform: translateX(-50%);
            background: var(--ink);
            color: var(--bg);
            padding: 11px 24px;
            border-radius: 99px;
            z-index: 70;
            opacity: 0;
            transition: opacity .3s, transform .3s;
            pointer-events: none;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 10px 25px rgba(0,0,0,.2);
        }
        .toast.on {
            opacity: 1;
            transform: translateX(-50%) translateY(-5px);
        }

        /* Alerts & Badges */
        .alert {
            padding: 12px 16px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success {
            background: color-mix(in srgb, var(--success) 15%, transparent);
            color: var(--success);
            border: 1px solid color-mix(in srgb, var(--success) 30%, transparent);
        }
        .alert-error {
            background: color-mix(in srgb, var(--sale) 15%, transparent);
            color: var(--sale);
            border: 1px solid color-mix(in srgb, var(--sale) 30%, transparent);
        }
        .alert-info {
            background: color-mix(in srgb, var(--brand) 15%, transparent);
            color: var(--brand);
            border: 1px solid color-mix(in srgb, var(--brand) 30%, transparent);
        }

        /* Card container */
        .box {
            background: var(--card);
            border: 1px solid var(--line);
            border-radius: 24px;
            padding: 24px;
            box-shadow: 0 6px 24px rgba(168, 43, 89, 0.05);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- SVG Definitions for Apparel & Icons -->
    <svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>
        <symbol id="bra" viewBox="0 0 100 130"><path d="M16 64 C24 38 42 42 50 62 C58 42 76 38 84 64 C94 94 62 104 50 82 C38 104 6 94 16 64 Z" fill="currentColor"/><path d="M26 46 L20 14 M74 46 L80 14" fill="none" stroke="currentColor" stroke-width="2.5"/><circle cx="50" cy="66" r="3" fill="#fff" opacity=".8"/></symbol>
        <symbol id="panty" viewBox="0 0 100 130"><path d="M12 42 H88 L72 90 C62 108 38 108 28 90 Z" fill="currentColor"/><path d="M12 42 Q50 48 88 42" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="2"/></symbol>
        <symbol id="set" viewBox="0 0 100 130"><path d="M20 34 C26 18 40 22 50 34 C60 22 74 18 80 34 C88 54 62 62 50 48 C38 62 12 54 20 34 Z" fill="currentColor"/><path d="M28 24 L22 8 M72 24 L78 8" fill="none" stroke="currentColor" stroke-width="2"/><path d="M20 74 H80 L68 114 C58 126 42 126 32 114 Z" fill="currentColor"/></symbol>
        <symbol id="bodysuit" viewBox="0 0 100 130"><path d="M28 14 L28 32 C22 42 34 56 42 54 C50 52 50 52 58 54 C66 56 78 42 72 32 L72 14 H68 L68 30 C62 26 50 26 50 32 C50 26 38 26 32 30 L32 14 Z M32 58 C36 78 30 96 38 118 H62 C70 96 64 78 68 58 Z" fill="currentColor"/></symbol>
        <symbol id="boxer" viewBox="0 0 100 130"><path d="M20 28 H80 L82 92 H56 L50 64 L44 92 H18 Z" fill="currentColor"/><path d="M20 38 H80" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="2.5"/></symbol>
        <symbol id="tee" viewBox="0 0 100 130"><path d="M30 12 42 8Q50 17 58 8L70 12 92 34 80 46 70 38V118H30V38L20 46 8 34Z" fill="currentColor"/></symbol>
        <symbol id="shirt" viewBox="0 0 100 130"><path d="M30 12 42 8Q50 17 58 8L70 12 94 74 82 78 68 42V120H32V42L18 78 6 74Z" fill="currentColor"/><path d="M50 17V120M42 8 50 24 58 8" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="1.4"/></symbol>
        <symbol id="coat" viewBox="0 0 100 130"><path d="M32 10 43 6 50 22 57 6 68 10 92 84 81 88 68 46 72 126H28L32 46 19 88 8 84Z" fill="currentColor"/><path d="M50 22V126" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="1.4"/></symbol>
        <symbol id="hoodie" viewBox="0 0 100 130"><path d="M30 20Q50 -2 70 20L92 78 80 82 70 46V114H30V46L20 82 8 78Z" fill="currentColor"/><path d="M38 14Q50 34 62 14M37 90H63L60 108H40Z" fill="none" stroke="#fff" stroke-opacity=".5" stroke-width="1.4"/></symbol>
        <symbol id="pants" viewBox="0 0 100 130"><path d="M30 8H70L77 124H56L50 44 44 124H23Z" fill="currentColor"/></symbol>
        <symbol id="dress" viewBox="0 0 100 130"><path d="M38 8H44Q50 18 56 8H62L65 48 86 124H14L35 48Z" fill="currentColor"/></symbol>
        <symbol id="scarf" viewBox="0 0 100 130"><path d="M18 22Q50 0 82 22L76 122H58L50 52 42 122H24Z" fill="currentColor"/></symbol>
        <symbol id="i-heart" viewBox="0 0 24 24"><path d="M12 20.500S4.500 15.900 2.800 11.200C1.700 8 3.600 4.800 6.900 4.800c2 0 3.500 1.100 5.100 3 1.600-1.900 3.100-3 5.100-3 3.300 0 5.200 3.200 4.100 6.400C19.500 15.900 12 20.500 12 20.500z"/></symbol>
        <symbol id="i-bag" viewBox="0 0 24 24"><path d="M5 8h14l-1 12H6zM9 8V6a3 3 0 0 1 6 0v2"/></symbol>
        <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6.500"/><path d="m16 16 4.500 4.500"/></symbol>
        <symbol id="i-moon" viewBox="0 0 24 24"><path d="M20 14.500A8 8 0 1 1 9.500 4a6.500 6.500 0 0 0 10.500 10.500z"/></symbol>
        <symbol id="i-sun" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M5 5l2 2M17 17l2 2M19 5l-2 2M7 17l-2 2"/></symbol>
        <symbol id="i-truck" viewBox="0 0 24 24"><path d="M2 6h11v9H2zM13 9h4l3 3v3h-7zM7 18a1.500 1.500 0 1 0 .01 0M17 18a1.500 1.500 0 1 0 .01 0"/></symbol>
        <symbol id="i-return" viewBox="0 0 24 24"><path d="M4 12a8 8 0 1 0 3-6.200M4 4v4h4"/></symbol>
        <symbol id="i-shield" viewBox="0 0 24 24"><path d="m12 3 7 3v5c0 4.500-3 8-7 10-4-2-7-5.500-7-10V6zM9 12l2 2 4-4"/></symbol>
        <symbol id="i-check" viewBox="0 0 24 24"><path d="m5 12 5 5 9-10"/></symbol>
        <symbol id="i-x" viewBox="0 0 24 24"><path d="m6 6 12 12M18 6 6 18"/></symbol>
        <symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
        <symbol id="i-minus" viewBox="0 0 24 24"><path d="M5 12h14"/></symbol>
        <symbol id="i-user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 0 0-16 0"/></symbol>
        <symbol id="i-orders" viewBox="0 0 24 24"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 7h6M9 11h6M9 15h4"/></symbol>
        <symbol id="i-admin" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M9 3v18M3 9h18"/></symbol>
        <symbol id="i-logout" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></symbol>
        <symbol id="i-ruler" viewBox="0 0 24 24"><path d="M21.3 8.7 8.7 21.3c-.4.4-1 .4-1.4 0l-6-6c-.4-.4-.4-1 0-1.4L13.9 1.3c.4-.4 1-.4 1.4 0l6 6c.4.4.4 1 0 1.4z"/><path d="m14 4 2 2M11 7l3 3M8 10l2 2M5 13l3 3"/></symbol>
        <symbol id="i-box-lock" viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5M12 22V12"/></symbol>
        <symbol id="i-sparkle" viewBox="0 0 24 24"><path d="m12 3-1.9 5.8a2 2 0 0 1-1.3 1.3L3 12l5.8 1.9a2 2 0 0 1 1.3 1.3L12 21l1.9-5.8a2 2 0 0 1 1.3-1.3L21 12l-5.8-1.9a2 2 0 0 1-1.3-1.3Z"/></symbol>
        <symbol id="i-feather" viewBox="0 0 24 24"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5zM16 8 2 22M17.5 15H9"/></symbol>
        <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></symbol>
    </defs></svg>

    <!-- Top Announcement Bar -->
    <div class="ann">{{ \App\Models\Setting::get('announcement_bar_text', '📦 ارسال کاملاً محرمانه در بسته‌بندی بدون نام · پلمپ بهداشتی اصالت کالا · ارسال رایگان بالای ۲ میلیون تومان') }}</div>

    <!-- Header -->
    <header>
        <div class="wrap hd">
            <a href="{{ route('home') }}" class="logo">
                Atila<b>Shop</b>
            </a>

            <nav class="nav">
                <a href="{{ route('home', ['c' => 'ست لباس زیر']) }}" class="{{ request('c') === 'ست لباس زیر' ? 'active' : '' }}">ست لباس زیر</a>
                <a href="{{ route('home', ['c' => 'سوتین']) }}" class="{{ request('c') === 'سوتین' ? 'active' : '' }}">سوتین</a>
                <a href="{{ route('home', ['c' => 'شورت زنانه']) }}" class="{{ request('c') === 'شورت زنانه' ? 'active' : '' }}">شورت زنانه</a>
                <a href="{{ route('home', ['c' => 'بادی']) }}" class="{{ request('c') === 'بادی' ? 'active' : '' }}">بادی</a>
                <a href="{{ route('home', ['c' => 'لباس زیر مردانه']) }}" class="{{ request('c') === 'لباس زیر مردانه' ? 'active' : '' }}">لباس زیر مردانه</a>
                <a href="{{ route('home', ['x' => 'sale']) }}" class="hot">حراج</a>
                <button type="button" onclick="openSizeGuide()" class="size-guide-pill" aria-label="راهنمای سایز">
                    <svg class="ic" style="width: 15px; height: 15px;"><use href="#i-ruler"/></svg>
                    <span>راهنمای سایز</span>
                </button>
            </nav>

            <span class="sp"></span>

            <button class="ib" id="btn-search-focus" aria-label="جستجو">
                <svg class="ic"><use href="#i-search"/></svg>
            </button>

            <!-- Notification Bell (Auth Users) -->
            @auth
                <div class="user-menu" id="notif-wrapper" style="position: relative;">
                    <button class="ib" id="btn-notif" aria-label="اعلان‌ها" onclick="toggleNotifDropdown(event)">
                        <svg class="ic"><use href="#i-bell"/></svg>
                        <span class="bg2" id="notif-badge" style="display: {{ Auth::user()->unreadCustomNotificationsCount() > 0 ? 'inline-block' : 'none' }};">
                            {{ Auth::user()->unreadCustomNotificationsCount() }}
                        </span>
                    </button>
                    <div class="notif-dropdown" id="notif-dropdown">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 8px; border-bottom: 1px solid var(--line); margin-bottom: 8px;">
                            <b style="font-size: 13.5px;">اعلان‌های سفارش</b>
                            <button type="button" onclick="markAllNotificationsRead()" style="font-size: 11px; color: var(--brand); cursor: pointer; text-decoration: underline;">
                                خوانده شدن همه
                            </button>
                        </div>
                        <div id="notif-list" style="max-height: 280px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px;">
                            <div class="muted" style="text-align: center; padding: 20px 0; font-size: 12px;">در حال بارگذاری اعلان‌ها...</div>
                        </div>
                    </div>
                </div>
            @endauth

            <!-- Wishlist Button -->
            <a href="{{ route('wishlist.index') }}" class="ib" id="wl-btn" aria-label="علاقه‌مندی‌ها">
                <svg class="ic"><use href="#i-heart"/></svg>
                <span class="bg2" id="wc">{{ Auth::check() ? Auth::user()->wishlists()->count() : 0 }}</span>
            </a>

            <!-- Cart Drawer Button -->
            <button class="ib" id="btn-cart" aria-label="سبد خرید">
                <svg class="ic"><use href="#i-bag"/></svg>
                <span class="bg2" id="cc">{{ array_sum(array_column(session('cart', []), 'qty')) }}</span>
            </button>

            <!-- Theme Toggle -->
            <button class="ib" id="theme-btn" aria-label="تغییر تم">
                <svg class="ic"><use id="tu" href="#i-moon"/></svg>
            </button>

            <!-- User Menu -->
            <div class="user-menu">
                @auth
                    <button class="ib" id="user-menu-btn" aria-label="حساب کاربری">
                        <svg class="ic"><use href="#i-user"/></svg>
                    </button>
                    <div class="user-dropdown" id="user-dropdown">
                        <div class="user-meta">
                            <div class="name">{{ Auth::user()->name }}</div>
                            <div class="email">{{ Auth::user()->email }}</div>
                        </div>

                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" style="color: var(--brand); font-weight: 700;">
                                <svg class="ic"><use href="#i-admin"/></svg>
                                پنل مدیریت ادمین
                            </a>
                        @endif

                        <a href="{{ route('orders.my_orders') }}">
                            <svg class="ic"><use href="#i-orders"/></svg>
                            سفارش‌های من
                        </a>

                        <a href="{{ route('wishlist.index') }}">
                            <svg class="ic"><use href="#i-heart"/></svg>
                            علاقه‌مندی‌ها
                        </a>

                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit">
                                <svg class="ic"><use href="#i-logout"/></svg>
                                خروج از حساب
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn o" style="padding: 7px 18px; font-size: 13px;">
                        ورود / ثبت‌نام
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="wrap" style="flex: 1; padding-top: 10px; padding-bottom: 30px;">
        @if(session('success'))
            <div class="alert alert-success" style="margin-top: 14px;">
                <svg class="ic"><use href="#i-check"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error" style="margin-top: 14px;">
                <svg class="ic"><use href="#i-x"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info" style="margin-top: 14px;">
                <svg class="ic"><use href="#i-shield"/></svg>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="wrap">
            <div class="fg">
                <div>
                    <span class="logo">Atila<b>Shop</b></span>
                    <p class="muted" style="margin-top: 10px; font-size: 13px; line-height: 1.8;">
                        بوتیک تخصصی لباس زیر زنانه و مردانه آتیلاشاپ؛ تمرکز بر سلامت پوست، لطافت الیاف پنبه‌ای ارگانیک و طراحی مد روز با تضمین بسته‌بندی ۱۰۰٪ محرمانه و پلمپ بهداشتی.
                    </p>
                </div>
                <div>
                    <h4>دسته‌بندی لباس زیر</h4>
                    <a href="{{ route('home', ['c' => 'ست لباس زیر']) }}">ست شورت و سوتین</a>
                    <a href="{{ route('home', ['c' => 'سوتین']) }}">سوتین و نیم‌تنه</a>
                    <a href="{{ route('home', ['c' => 'شورت زنانه']) }}">شورت زنانه نخی و لیزری</a>
                    <a href="{{ route('home', ['c' => 'بادی']) }}">بادی مجلسی و فانتزی</a>
                    <a href="{{ route('home', ['c' => 'لباس زیر مردانه']) }}">لباس زیر مردانه (باکسر و اسلیپ)</a>
                </div>
                <div>
                    <h4>خدمات و راهنمایی</h4>
                    <a href="javascript:void(0)" onclick="openSizeGuide()">📐 راهنمای تخصصی انتخاب سایز</a>
                    <a href="{{ route('orders.my_orders') }}">پیگیری آنلاین سفارش‌ها</a>
                    <a href="javascript:void(0)" onclick="toast('بسته‌ها در کارتن کاملاً مات و بدون هیچ نام یا لوگوی کالا ارسال می‌شوند.')">📦 تضمین بسته‌بندی محرمانه</a>
                    <a href="javascript:void(0)" onclick="toast('محصولات دارای پلمپ بهداشتی بوده و ارسال بالای ۲ میلیون تومان رایگان است.')">🛡️ پلمپ بهداشتی و ارسال رایگان</a>
                </div>
                <div>
                    <h4>پشتیبانی و ارتباط</h4>
                    <p class="muted" style="margin: 0 0 6px;">پشتیبانی تلفنی: {{ \App\Models\Setting::get('support_phone', '۰۲۱-۹۱۰۰۱۲۳۴') }}</p>
                    <p class="muted" style="margin: 0 0 6px;">ساعات پاسخگویی: ۹ الی ۱۸ (همه‌روزه)</p>
                    <p class="muted" style="margin: 0 0 6px;">ارسال با پست پیشتاز و تیپاکس به سراسر ایران</p>
                    <p class="muted" style="margin: 0;">پلمپ بهداشتی و بسته‌بندی کاملاً مات</p>
                </div>
            </div>
            <div class="cp">© {{ date('Y') }} AtilaShop — بوتیک تخصصی لباس زیر · تمامی حقوق محفوظ است.</div>
        </div>
    </footer>

    <!-- Cart Drawer -->
    <aside class="dr" id="cart-drawer">
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <b style="font-size: 20px;">سبد خرید</b>
            <button class="ib" id="btn-close-cart" aria-label="بستن">
                <svg class="ic"><use href="#i-x"/></svg>
            </button>
        </div>

        <div id="drawer-shipping-text" style="font-size: 13px; margin-top: 8px;"></div>
        <div class="bar"><i id="drawer-shipping-bar" style="width: 0%;"></i></div>

        <div id="drawer-items" style="flex: 1; overflow-y: auto;">
            <!-- Rendered dynamically via JS -->
        </div>

        <div style="padding-top: 14px; border-top: 1px solid var(--line); margin-top: auto;">
            <div style="display: flex; justify-content: space-between; font-weight: 800; font-size: 16px; margin-bottom: 14px;">
                <span>جمع کل:</span>
                <span id="drawer-total">۰ تومان</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn" style="width: 100%; justify-content: center;">
                ثبت سفارش و پرداخت
            </a>
        </div>
    </aside>

    <!-- Product Detail Modal Overlay -->
    <div class="ov" id="modal-overlay">
        <div class="md" id="modal-content">
            <!-- Loaded dynamically or rendered by Blade -->
        </div>
    </div>

    <!-- Size Guide Modal Overlay -->
    <div class="ov" id="size-guide-modal">
        <div class="md" style="max-width: 740px; grid-template-columns: 1fr; max-height: 90vh;">
            <button class="x" onclick="closeSizeGuide()" aria-label="بستن">
                <svg class="ic"><use href="#i-x"/></svg>
            </button>
            <div>
                <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: color-mix(in srgb, var(--brand) 15%, transparent); display: grid; place-items: center; color: var(--brand); flex-shrink: 0;">
                        <svg class="ic" style="width: 24px; height: 24px;"><use href="#i-ruler"/></svg>
                    </div>
                    <div>
                        <h3 style="margin: 0; font-size: 19px; font-weight: 800;">راهنمای تخصصی انتخاب سایز لباس زیر</h3>
                        <p class="muted" style="margin: 2px 0 0; font-size: 12px;">نحوه اندازه‌گیری با متر و محاسبه‌گر هوشمند کاپ و سایز سوتین، شورت و لباس زیر</p>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="sg-tabs">
                    <button type="button" class="sg-tab active" onclick="switchSgTab('bra', this)">سوتین و نیم‌تنه (Bra)</button>
                    <button type="button" class="sg-tab" onclick="switchSgTab('panty', this)">شورت زنانه (Panties)</button>
                    <button type="button" class="sg-tab" onclick="switchSgTab('men', this)">لباس زیر مردانه (Men)</button>
                </div>

                <!-- Pane 1: Bra -->
                <div class="sg-pane active" id="sg-pane-bra">
                    <!-- Smart Calculator -->
                    <div class="sg-calc-box">
                        <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 6px;">
                            <svg class="ic" style="color: var(--brand); width: 18px; height: 18px;"><use href="#i-sparkle"/></svg>
                            <b style="font-size: 14px;">محاسبه‌گر آنلاین سایز سوتین شما:</b>
                        </div>
                        <p class="muted" style="font-size: 12px; margin-bottom: 12px; line-height: 1.7;">
                            یک متر پارچه‌ای بردارید؛ اندازه دور زیر سینه (خط زیر پستان‌ها) و اندازه برجسته‌ترین بخش سینه را صاف و بدون کشیدگی وارد کنید:
                        </p>
                        <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: end;">
                            <div>
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">۱. دور زیر سینه (Band) cm:</label>
                                <input type="number" id="sg-underbust" placeholder="مثلاً: 78" min="60" max="120" style="padding: 8px 12px; font-size: 13px;">
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 4px;">۲. دور روی سینه (Bust) cm:</label>
                                <input type="number" id="sg-bust" placeholder="مثلاً: 92" min="65" max="140" style="padding: 8px 12px; font-size: 13px;">
                            </div>
                            <div>
                                <button type="button" class="btn brand" onclick="calculateBraSize()" style="padding: 9px 18px; font-size: 13px; white-space: nowrap;">
                                    محاسبه سایز
                                </button>
                            </div>
                        </div>
                        <div id="sg-calc-result" style="display: none; margin-top: 14px; padding: 12px 14px; border-radius: 12px; background: var(--card); border: 1px solid var(--brand); font-size: 13px;">
                        </div>
                    </div>

                    <!-- Bra Reference Table -->
                    <b style="font-size: 13.5px; display: block; margin-top: 16px;">جدول سایزبندی استاندارد سوتین:</b>
                    <div style="overflow-x: auto;">
                        <table class="sg-table">
                            <thead>
                                <tr>
                                    <th>سایز سوتین</th>
                                    <th>اندازه دور زیر سینه</th>
                                    <th>کاپ A (اختلاف ۱۰-۱۲cm)</th>
                                    <th>کاپ B (اختلاف ۱۲-۱۴cm)</th>
                                    <th>کاپ C (اختلاف ۱۴-۱۶cm)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><b>70</b></td><td>۶۸ تا ۷۲ سانتی‌متر</td><td>۸۰ - ۸۲ cm</td><td>۸۲ - ۸۴ cm</td><td>۸۴ - ۸۶ cm</td></tr>
                                <tr><td><b>75</b></td><td>۷۳ تا ۷۷ سانتی‌متر</td><td>۸۵ - ۸۷ cm</td><td>۸۷ - ۸۹ cm</td><td>۸۹ - ۹۱ cm</td></tr>
                                <tr><td><b>80</b></td><td>۷۸ تا ۸۲ سانتی‌متر</td><td>۹۰ - ۹۲ cm</td><td>۹۲ - ۹۴ cm</td><td>۹۴ - ۹۶ cm</td></tr>
                                <tr><td><b>85</b></td><td>۸۳ تا ۸۷ سانتی‌متر</td><td>۹۵ - ۹۷ cm</td><td>۹۷ - ۹۹ cm</td><td>۹۹ - ۱۰۱ cm</td></tr>
                                <tr><td><b>90</b></td><td>۸۸ تا ۹۲ سانتی‌متر</td><td>۱۰۰ - ۱۰۲ cm</td><td>۱۰۲ - ۱۰۴ cm</td><td>۱۰۴ - ۱۰۶ cm</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pane 2: Panties -->
                <div class="sg-pane" id="sg-pane-panty">
                    <p class="muted" style="font-size: 13px; line-height: 1.7; margin-bottom: 14px;">
                        برای انتخاب شورت زنانه، متر را دور پهن‌ترین بخش باسن قرار دهید؛ عدد حاصل را با جدول زیر تطبیق دهید:
                    </p>
                    <div style="overflow-x: auto;">
                        <table class="sg-table">
                            <thead>
                                <tr>
                                    <th>سایز برچسب</th>
                                    <th>معادل سایز لباس / شلوار</th>
                                    <th>اندازه دور باسن (Hip)</th>
                                    <th>اندازه دور کمر (Waist)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><b>M</b></td><td>۳۶ تا ۳۸</td><td>۸۸ تا ۹۴ سانتی‌متر</td><td>۶۴ تا ۷۰ سانتی‌متر</td></tr>
                                <tr><td><b>L</b></td><td>۴۰ تا ۴۲</td><td>۹۵ تا ۱۰۱ سانتی‌متر</td><td>۷۱ تا ۷۷ سانتی‌متر</td></tr>
                                <tr><td><b>XL</b></td><td>۴۲ تا ۴۴</td><td>۱۰۲ تا ۱۰۸ سانتی‌متر</td><td>۷۸ تا ۸۴ سانتی‌متر</td></tr>
                                <tr><td><b>2XL</b></td><td>۴۶ تا ۴۸</td><td>۱۰۹ تا ۱۱۶ سانتی‌متر</td><td>۸۵ تا ۹۲ سانتی‌متر</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-info" style="margin-top: 16px; font-size: 13px;">
                        🛡️ کلیه شورت‌های زنانه فروشگاه دارای فاق دولایه ۱۰۰٪ نخ‌پنبه ارگانیک ضدحساسیت و پلمپ بهداشتی هستند.
                    </div>
                </div>

                <!-- Pane 3: Men's -->
                <div class="sg-pane" id="sg-pane-men">
                    <p class="muted" style="font-size: 13px; line-height: 1.7; margin-bottom: 14px;">
                        برای شورت‌های پادار (باکسر) و اسلیپ مردانه، اندازه دور کمر روی خط کمربند ملاک انتخاب است:
                    </p>
                    <div style="overflow-x: auto;">
                        <table class="sg-table">
                            <thead>
                                <tr>
                                    <th>سایز</th>
                                    <th>معادل سایز شلوار</th>
                                    <th>دور کمر (سانتی‌متر)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td><b>M</b></td><td>۳۸ تا ۴۰</td><td>۷۸ تا ۸۴ سانتی‌متر</td></tr>
                                <tr><td><b>L</b></td><td>۴۲ تا ۴۴</td><td>۸۵ تا ۹۱ سانتی‌متر</td></tr>
                                <tr><td><b>XL</b></td><td>۴۶ تا ۴۸</td><td>۹۲ تا ۹۸ سانتی‌متر</td></tr>
                                <tr><td><b>2XL</b></td><td>۵۰ تا ۵۲</td><td>۹۹ تا ۱۰۶ سانتی‌متر</td></tr>
                                <tr><td><b>3XL</b></td><td>۵۴ تا ۵۶</td><td>۱۰۷ تا ۱۱۵ سانتی‌متر</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <!-- Core Scripts -->
    <script>
        const $ = s => document.querySelector(s);
        const $$ = s => document.querySelectorAll(s);
        const fa = n => Number(n).toLocaleString('fa-IR');
        const fmt = n => fa(n) + ' تومان';
        const ic = n => `<svg class="ic"><use href="#i-${n}"/></svg>`;
        const csrfToken = $('meta[name="csrf-token"]').getAttribute('content');

        // Toast Helper
        const toast = (msg) => {
            const t = $('#toast');
            t.textContent = msg;
            t.classList.add('on');
            clearTimeout(toast.t);
            toast.t = setTimeout(() => t.classList.remove('on'), 2200);
        };

        // Theme Support
        const isDark = () => {
            const t = document.documentElement.dataset.theme;
            return t ? t === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches;
        };
        const updateThemeIcon = () => {
            const tu = $('#tu');
            if (tu) tu.setAttribute('href', isDark() ? '#i-sun' : '#i-moon');
        };
        const toggleTheme = () => {
            const nextTheme = isDark() ? 'light' : 'dark';
            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('theme', nextTheme);
            updateThemeIcon();
        };
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            document.documentElement.dataset.theme = savedTheme;
        }
        updateThemeIcon();

        // User dropdown menu toggle
        const userMenuBtn = $('#user-menu-btn');
        const userDropdown = $('#user-dropdown');
        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });
            document.addEventListener('click', (e) => {
                if (!userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });
        }

        // Cart Drawer Management
        const cartDrawer = $('#cart-drawer');
        const openCart = () => {
            loadCart();
            cartDrawer.classList.add('on');
        };
        const closeCart = () => cartDrawer.classList.remove('on');
        $('#btn-cart')?.addEventListener('click', openCart);
        $('#btn-close-cart')?.addEventListener('click', closeCart);

        // Load Cart via AJAX
        async function loadCart() {
            try {
                const res = await fetch("{{ route('cart.index') }}");
                const data = await res.json();
                renderCartDrawer(data);
                $('#cc').textContent = fa(data.count);
            } catch (err) {
                console.error('Error fetching cart:', err);
            }
        }

        function renderCartDrawer(data) {
            const itemsContainer = $('#drawer-items');
            const totalContainer = $('#drawer-total');
            const shippingText = $('#drawer-shipping-text');
            const shippingBar = $('#drawer-shipping-bar');

            totalContainer.textContent = data.total_formatted;

            if (data.free_shipping) {
                shippingText.innerHTML = 'ارسال سفارش شما <b>رایگان</b> است! 🎉';
                shippingBar.style.width = '100%';
            } else {
                const pct = Math.min(100, Math.round((data.total / 2000000) * 100));
                shippingText.innerHTML = `با <b>${data.remaining_formatted}</b> خرید بیشتر، ارسال رایگان می‌شود`;
                shippingBar.style.width = pct + '%';
            }

            if (!data.items || data.items.length === 0) {
                itemsContainer.innerHTML = '<p class="muted" style="text-align: center; margin: 40px 0;">سبد خرید شما خالی است.</p>';
                return;
            }

            itemsContainer.innerHTML = data.items.map(item => {
                const hue = (item.hues && item.hues[item.ci]) ? item.hues[item.ci] : 345;
                return `
                <div class="ci">
                    <div class="art" style="--h: ${hue}; width: 62px; height: 75px; border-radius: 12px; margin-inline-end: 10px;">
                        <svg class="g" viewBox="0 0 100 130" style="width: 58%; filter: none;"><use href="#${item.icon || 'tee'}"/></svg>
                    </div>
                    <div style="flex: 1;">
                        <div class="nm" style="font-size: 14px;">${item.name}</div>
                        <div class="muted" style="font-size: 12px; margin-top: 2px;">
                            سایز: <b>${item.size}</b> · ${fmt(item.price)}
                        </div>
                    </div>
                    <div class="q">
                        <button onclick="updateCartQty('${item.key}', 1)" aria-label="افزایش">${ic('plus')}</button>
                        <span style="font-weight: 700; min-width: 18px; text-align: center;">${fa(item.qty)}</span>
                        <button onclick="updateCartQty('${item.key}', -1)" aria-label="کاهش">${ic('minus')}</button>
                    </div>
                </div>`;
            }).join('');
        }

        async function addToCart(id, size, ci = 0) {
            try {
                const res = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ id, size, ci })
                });
                const data = await res.json();
                if (data.success) {
                    $('#cc').textContent = fa(data.count);
                    toast(data.message || 'به سبد خرید اضافه شد.');
                    closeModal();
                    openCart();
                } else {
                    toast(data.message || 'خطا در افزودن به سبد خرید.');
                }
            } catch (err) {
                toast('خطا در برقراری ارتباط.');
            }
        }

        async function updateCartQty(key, delta) {
            try {
                const res = await fetch("{{ route('cart.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ key, delta })
                });
                const data = await res.json();
                renderCartDrawer(data);
                $('#cc').textContent = fa(data.count);
            } catch (err) {
                toast('خطا در به‌روزرسانی سبد خرید.');
            }
        }

        // Wishlist Toggle
        async function toggleWishlist(productId, btnElement = null) {
            try {
                const res = await fetch("{{ route('wishlist.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                if (res.status === 401) {
                    const data = await res.json();
                    toast(data.message);
                    setTimeout(() => window.location.href = data.redirect, 1200);
                    return;
                }

                const data = await res.json();
                $('#wc').textContent = fa(data.count);
                toast(data.message);

                if (btnElement) {
                    btnElement.classList.toggle('on', data.added);
                } else {
                    // Update all matching wishlist buttons on screen
                    $$(`.hb[data-id="${productId}"]`).forEach(b => b.classList.toggle('on', data.added));
                }
            } catch (err) {
                toast('خطا در ثبت علاقه‌مندی.');
            }
        }

        // Modal Helpers
        const modalOverlay = $('#modal-overlay');
        const sizeGuideModal = $('#size-guide-modal');

        const closeModal = () => {
            modalOverlay?.classList.remove('on');
            cartDrawer?.classList.remove('on');
            sizeGuideModal?.classList.remove('on');
        };
        modalOverlay?.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });
        sizeGuideModal?.addEventListener('click', (e) => {
            if (e.target === sizeGuideModal) closeSizeGuide();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal();
                closeSizeGuide();
            }
        });

        // Size Guide Functions
        function openSizeGuide(tab = 'bra') {
            if (sizeGuideModal) {
                sizeGuideModal.classList.add('on');
                switchSgTab(tab);
            }
        }
        function closeSizeGuide() {
            if (sizeGuideModal) {
                sizeGuideModal.classList.remove('on');
            }
        }
        function switchSgTab(tabName, btnElem = null) {
            $$('.sg-tab').forEach(b => b.classList.remove('active'));
            $$('.sg-pane').forEach(p => p.classList.remove('active'));
            
            const activePane = $(`#sg-pane-${tabName}`);
            if (activePane) activePane.classList.add('active');

            if (btnElem) {
                btnElem.classList.add('active');
            } else {
                const targetBtn = $(`button[onclick*="'${tabName}'"]`);
                if (targetBtn) targetBtn.classList.add('active');
            }
        }

        function calculateBraSize() {
            const underbust = parseFloat($('#sg-underbust').value);
            const bust = parseFloat($('#sg-bust').value);
            const res = $('#sg-calc-result');
            if (!underbust || !bust || bust <= underbust) {
                res.style.display = 'block';
                res.innerHTML = '<span style="color: var(--sale);">لطفاً مقادیر معتبر را به سانتی‌متر وارد نمایید (دور روی سینه باید از دور زیر سینه بیشتر باشد).</span>';
                return;
            }

            let band = 70;
            if (underbust < 73) band = 70;
            else if (underbust < 78) band = 75;
            else if (underbust < 83) band = 80;
            else if (underbust < 88) band = 85;
            else if (underbust < 93) band = 90;
            else band = 95;

            const diff = bust - underbust;
            let cup = 'B';
            if (diff <= 11.5) cup = 'A';
            else if (diff <= 14) cup = 'B';
            else if (diff <= 16.5) cup = 'C';
            else cup = 'D';

            res.style.display = 'block';
            res.innerHTML = `
                <div style="font-weight: 800; font-size: 15px; color: var(--brand); margin-bottom: 4px;">
                    🎉 سایز پیشنهادی سوتین شما: <b>${band}${cup}</b> (معادل سایز ${band})
                </div>
                <div class="muted" style="font-size: 12px; line-height: 1.6;">
                    بر اساس دور زیر سینه (${fa(underbust)} سانتی‌متر) و اختلاف ${fa(diff.toFixed(1))} سانتی‌متر با برجستگی سینه، کاپ <b>${cup}</b> خوش‌فرم‌ترین ایستایی و راحتی را برای شما فراهم می‌آورد.
                </div>
            `;
        }

        // Theme button click
        $('#theme-btn')?.addEventListener('click', toggleTheme);

        // Notification Dropdown & Live Loading
        const notifDropdown = $('#notif-dropdown');
        const notifBadge = $('#notif-badge');
        const notifList = $('#notif-list');

        function toggleNotifDropdown(e) {
            e.stopPropagation();
            if (!notifDropdown) return;
            const willShow = !notifDropdown.classList.contains('show');
            notifDropdown.classList.toggle('show');
            if (willShow) {
                loadNotifications();
            }
        }

        document.addEventListener('click', (e) => {
            if (notifDropdown && !notifDropdown.contains(e.target) && !e.target.closest('#btn-notif')) {
                notifDropdown.classList.remove('show');
            }
        });

        async function loadNotifications() {
            if (!notifList) return;
            try {
                const res = await fetch("{{ route('notifications.index') }}");
                if (res.ok) {
                    const data = await res.json();
                    renderNotifications(data);
                }
            } catch (err) {
                console.error('Error loading notifications', err);
            }
        }

        function renderNotifications(data) {
            if (notifBadge) {
                if (data.unread_count > 0) {
                    notifBadge.textContent = fa(data.unread_count);
                    notifBadge.style.display = 'inline-block';
                } else {
                    notifBadge.style.display = 'none';
                }
            }

            if (!data.notifications || data.notifications.length === 0) {
                notifList.innerHTML = '<div class="muted" style="text-align: center; padding: 24px 0; font-size: 13px;">هیچ اعلانی برای نمایش وجود ندارد.</div>';
                return;
            }

            notifList.innerHTML = data.notifications.map(n => `
                <a href="${n.order_url || 'javascript:void(0)'}" class="notif-item ${n.is_read ? '' : 'unread'}" onclick="markNotifRead(${n.id}, event, '${n.order_url || ''}')">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <b style="font-size: 13px;">${n.title}</b>
                        <span class="muted" style="font-size: 11px;">${n.time_ago}</span>
                    </div>
                    <div class="muted" style="font-size: 12px; line-height: 1.6;">${n.message}</div>
                </a>
            `).join('');
        }

        async function markAllNotificationsRead() {
            try {
                const res = await fetch("{{ route('notifications.read_all') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
                if (res.ok) {
                    if (notifBadge) notifBadge.style.display = 'none';
                    $$('.notif-item').forEach(el => el.classList.remove('unread'));
                    toast('تمام اعلان‌ها به عنوان خوانده شده علامت‌گذاری شدند.');
                }
            } catch (err) {
                console.error(err);
            }
        }

        async function markNotifRead(id, e, url) {
            try {
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
                });
            } catch (err) {}
            if (url) {
                window.location.href = url;
            }
        }

        @auth
            // بررسی اعلان‌ها در بارگذاری صفحه
            loadNotifications();
        @endauth

        // Search Focus Shortcut
        $('#btn-search-focus')?.addEventListener('click', () => {
            const qInput = $('#q');
            if (qInput) {
                qInput.scrollIntoView({ behavior: 'smooth' });
                setTimeout(() => qInput.focus(), 300);
            } else {
                window.location.href = "{{ route('home') }}#q";
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
