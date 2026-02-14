<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="{{ $metaDescription ?? 'FrugalDev — Full Stack Developer. Build more. Bloat less.' }}">
    <meta property="og:title" content="{{ $pageTitle ?? 'FrugalDev' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Build more. Bloat less.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="FrugalDev">
    <meta property="og:image" content="{{ asset('img/og-image.png') }}">
    <meta name="twitter:card" content="summary">
    <link rel="alternate" type="application/rss+xml" title="FrugalDev Blog" href="{{ route('feed') }}">
    <link rel="sitemap" type="application/xml" href="{{ route('sitemap') }}">
    <title>{{ $pageTitle ?? 'FrugalDev' }} {{ isset($pageTitle) ? '— FrugalDev' : '' }}</title>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "FrugalDev",
        "url": "{{ url('/') }}",
        "description": "{{ $metaDescription ?? 'Build more. Bloat less.' }}",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/blog') }}?q={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Person",
        "name": "FrugalDev",
        "url": "{{ url('/') }}",
        "jobTitle": "Full Stack Developer",
        "sameAs": [
            @php
                $gh = \App\Models\Profile::first()?->social_links['github'] ?? null;
            @endphp
            @if($gh)"{{ $gh }}"@endif
        ]
    }
    </script>
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "FrugalDev",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('img/og-image.png') }}",
        "description": "Build more. Bloat less. Full Stack Developer portfolio."
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #1a1a2e;
            --bg2: #16213e;
            --bg3: #0f3460;
            --text: #c8d6e5;
            --heading: #00d2d3;
            --accent: #ff6b6b;
            --link: #48dbfb;
            --muted: #576574;
            --border: #2e4057;
            --green: #00ff41;
            --pixel-font: 'Press Start 2P', monospace;
            --mono: 'Courier New', Consolas, monospace;
            --system: system-ui, -apple-system, monospace;
        }

        [data-theme="paper"] {
            --bg: #f5f0e8;
            --bg2: #ebe5d9;
            --bg3: #ddd7cb;
            --text: #2c2c2c;
            --heading: #8b0000;
            --accent: #cc5500;
            --link: #00008b;
            --muted: #666;
            --border: #999;
            --green: #006400;
        }

        [data-theme="amber"] {
            --bg: #0a0a00;
            --bg2: #111100;
            --bg3: #1a1a00;
            --text: #ffb000;
            --heading: #ffcc00;
            --accent: #ff8800;
            --link: #ffdd44;
            --muted: #886600;
            --border: #554400;
            --green: #ffcc00;
        }

        [data-theme="highcontrast"] {
            --bg: #000000;
            --bg2: #111111;
            --bg3: #222222;
            --text: #ffffff;
            --heading: #ffff00;
            --accent: #ff4444;
            --link: #00ffff;
            --muted: #aaaaaa;
            --border: #666666;
            --green: #00ff00;
        }

        /* ═══ LOADING INDICATOR ═══ */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--heading);
            z-index: 99999;
            transition: width 0.3s ease;
        }
        .page-loader.active { width: 70%; }
        .page-loader.done { width: 100%; opacity: 0; transition: width 0.2s, opacity 0.3s 0.2s; }

        /* ═══ REDUCED MOTION ═══ */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--system);
            font-size: 14px;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        a {
            color: var(--link);
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .pixel {
            font-family: var(--pixel-font);
        }

        .mono {
            font-family: var(--mono);
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 16px;
            width: 100%;
        }

        .ascii-border {
            border: 2px solid var(--border);
            padding: 16px;
            margin: 16px 0;
            box-shadow: 4px 4px 0px var(--border);
        }

        .ascii-hr {
            color: var(--border);
            text-align: center;
            margin: 24px 0;
            overflow: hidden;
            white-space: nowrap;
            font-family: var(--mono);
            font-size: 12px;
        }

        h1,
        h2,
        h3 {
            color: var(--heading);
            margin-bottom: 8px;
        }

        h1 {
            font-family: var(--pixel-font);
            font-size: 14px;
            letter-spacing: 1px;
        }

        h2 {
            font-family: var(--pixel-font);
            font-size: 11px;
        }

        h3 {
            font-family: var(--mono);
            font-size: 14px;
        }

        .tag {
            display: inline-block;
            border: 1px solid var(--border);
            padding: 1px 6px;
            font-size: 11px;
            color: var(--muted);
            margin: 2px;
            font-family: var(--mono);
        }

        .btn {
            display: inline-block;
            border: 2px solid var(--heading);
            padding: 4px 12px;
            color: var(--heading);
            font-family: var(--mono);
            font-size: 12px;
            cursor: pointer;
            background: transparent;
            box-shadow: 2px 2px 0px var(--heading);
        }

        .btn:hover {
            background: var(--heading);
            color: var(--bg);
            text-decoration: none;
            box-shadow: none;
            transform: translate(2px, 2px);
        }

        .text-accent {
            color: var(--accent);
        }

        .text-green {
            color: var(--green);
        }

        .text-muted {
            color: var(--muted);
        }

        .text-heading {
            color: var(--heading);
        }

        .mt-1 {
            margin-top: 8px;
        }

        .mt-2 {
            margin-top: 16px;
        }

        .mb-1 {
            margin-bottom: 8px;
        }

        .mb-2 {
            margin-bottom: 16px;
        }

        /* ═══ HEADER ═══ */
        .site-header {
            border-bottom: 2px solid var(--border);
            padding: 12px 0;
        }

        .site-header .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .site-logo {
            font-family: var(--pixel-font);
            font-size: 12px;
            color: var(--heading);
        }

        .site-logo a {
            color: var(--heading);
        }

        .site-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            font-family: var(--mono);
            font-size: 13px;
        }

        .site-nav a {
            padding: 2px 4px;
        }

        .site-nav a::before {
            content: '[';
            color: var(--muted);
        }

        .site-nav a::after {
            content: ']';
            color: var(--muted);
        }

        .site-nav a.active {
            color: var(--heading);
        }

        /* ═══ MAIN ═══ */
        .site-main {
            flex: 1;
            padding: 24px 0;
        }

        /* ═══ FOOTER ═══ */
        .site-footer {
            border-top: 2px solid var(--border);
            padding: 16px 0;
            font-family: var(--mono);
            font-size: 11px;
            color: var(--muted);
        }

        .footer-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 16px;
        }

        .footer-counter {
            color: var(--green);
        }

        /* ═══ STATUS BAR ═══ */
        .status-bar {
            background: var(--bg2);
            border-top: 1px solid var(--border);
            padding: 4px 16px;
            font-family: var(--mono);
            font-size: 10px;
            color: var(--muted);
            display: flex;
            justify-content: space-between;
        }

        /* ═══ COMMAND PALETTE ═══ */
        .cmd-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            justify-content: center;
            padding-top: 20vh;
        }

        .cmd-overlay.active {
            display: flex;
        }

        .cmd-box {
            background: var(--bg2);
            border: 2px solid var(--heading);
            box-shadow: 4px 4px 0px var(--heading);
            width: 90%;
            max-width: 500px;
            height: fit-content;
        }

        .cmd-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid var(--border);
            color: var(--text);
            font-family: var(--mono);
            font-size: 14px;
            padding: 12px;
            outline: none;
        }

        .cmd-input::placeholder {
            color: var(--muted);
        }

        .cmd-results {
            padding: 8px;
            max-height: 300px;
            overflow-y: auto;
        }

        .cmd-item {
            padding: 6px 12px;
            cursor: pointer;
            font-family: var(--mono);
            font-size: 13px;
        }

        .cmd-item:hover,
        .cmd-item.selected {
            background: var(--bg3);
            color: var(--heading);
        }

        .cmd-hint {
            padding: 8px 12px;
            font-size: 10px;
            color: var(--muted);
            border-top: 1px solid var(--border);
            font-family: var(--mono);
        }

        /* ═══ TOAST ═══ */
        .toast {
            position: fixed;
            bottom: 40px;
            right: 16px;
            background: var(--bg2);
            border: 2px solid var(--green);
            padding: 8px 16px;
            font-family: var(--mono);
            font-size: 12px;
            color: var(--green);
            box-shadow: 2px 2px 0px var(--green);
            z-index: 999;
            display: none;
        }

        .toast.show {
            display: block;
        }

        /* ═══ THEME SWITCHER ═══ */
        .theme-sw {
            font-family: var(--mono);
            font-size: 10px;
            cursor: pointer;
        }

        .theme-sw select {
            background: var(--bg2);
            color: var(--text);
            border: 1px solid var(--border);
            font-family: var(--mono);
            font-size: 10px;
            padding: 1px 4px;
        }

        /* ═══ FLASH ═══ */
        .flash-success {
            border: 1px solid var(--green);
            padding: 8px 12px;
            margin-bottom: 16px;
            color: var(--green);
            font-family: var(--mono);
            font-size: 12px;
            animation: flash-fade 5s ease-in forwards;
        }
        @keyframes flash-fade {
            0%, 80% { opacity: 1; }
            100% { opacity: 0; height: 0; padding: 0; margin: 0; overflow: hidden; }
        }

        /* ═══ RESPONSIVE ═══ */
        @media (max-width: 600px) {
            .site-header .container {
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-grid {
                flex-direction: column;
            }

            h1 {
                font-size: 11px;
            }
        }

        /* ═══ BLINK (for "new" badges) ═══ */
        @keyframes retro-blink {
            50% {
                opacity: 0;
            }
        }

        .blink {
            animation: retro-blink 1s step-end infinite;
        }

        .cursor-blink::after {
            content: '█';
            animation: retro-blink 1s step-end infinite;
            color: var(--heading);
        }

        /* ═══ SKILL BAR ═══ */
        .skill-bar {
            font-family: var(--mono);
            font-size: 13px;
            white-space: pre;
        }

        /* ═══ TABLE ═══ */
        .retro-table {
            width: 100%;
            border-collapse: collapse;
            font-family: var(--mono);
            font-size: 13px;
        }

        .retro-table th {
            text-align: left;
            color: var(--heading);
            border-bottom: 2px solid var(--border);
            padding: 4px 8px;
            font-weight: normal;
        }

        .retro-table td {
            padding: 4px 8px;
            border-bottom: 1px solid var(--border);
        }

        .retro-table tr:hover {
            background: var(--bg2);
        }

        /* ═══ FORM ═══ */
        .retro-input {
            background: var(--bg2);
            border: 1px solid var(--border);
            color: var(--text);
            font-family: var(--mono);
            font-size: 13px;
            padding: 6px 8px;
            width: 100%;
        }

        .retro-input:focus {
            border-color: var(--heading);
            outline: none;
        }

        .retro-label {
            font-family: var(--mono);
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 4px;
            display: block;
        }

        .form-group {
            margin-bottom: 12px;
        }

        textarea.retro-input {
            resize: vertical;
            min-height: 80px;
        }

        /* Details/expand */
        details {
            margin: 4px 0;
        }

        details summary {
            cursor: pointer;
            font-family: var(--mono);
            color: var(--link);
            font-size: 12px;
        }

        details summary:hover {
            color: var(--heading);
        }
            /* ═══ PRINT ═══ */
        @media print {
            .site-header, .site-footer, .status-bar, .cmd-overlay, .toast, .theme-sw, .btn { display: none !important; }
            body { background: #fff; color: #000; font-size: 12pt; }
            a { color: #000; text-decoration: underline; }
            .ascii-border { border: 1px solid #999; box-shadow: none; }
            h1, h2, h3 { color: #000; }
        }

        /* ═══ FOCUS ═══ */
        :focus-visible {
            outline: 2px solid var(--heading);
            outline-offset: 2px;
        }

        .skip-link {
            position: absolute;
            top: -100px;
            left: 0;
            background: var(--heading);
            color: var(--bg);
            padding: 4px 12px;
            z-index: 9999;
            font-family: var(--mono);
            font-size: 12px;
        }
    .skip-link:focus { top: 0; }
    </style>
</head>

<body data-theme="{{ session('theme', 'retro') }}">

    <div class="page-loader" id="pageLoader"></div>
    <a href="#main-content" class="skip-link">Skip to content</a>

    <header class="site-header" role="banner">
        <div class="container">
            <div class="site-logo"><a href="{{ route('home') }}">FrugalDev</a></div>
            <nav class="site-nav" role="navigation" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">home</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">about</a>
                <a href="{{ route('projects.index') }}"
                    class="{{ request()->routeIs('projects.*') ? 'active' : '' }}">projects</a>
                <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">blog</a>
                <a href="{{ route('guestbook.index') }}"
                    class="{{ request()->routeIs('guestbook.*') ? 'active' : '' }}">guestbook</a>
                <a href="{{ route('changelog.index') }}"
                    class="{{ request()->routeIs('changelog.*') ? 'active' : '' }}">changelog</a>
                <a href="{{ route('search') }}" class="{{ request()->routeIs('search') ? 'active' : '' }}" aria-label="Search">🔍</a>
            </nav>
        </div>
    </header>

    <main class="site-main" id="main-content" role="main">
        <div class="container">
            @if (session('success'))
                <div class="flash-success">✓ {{ session('success') }}</div>
            @endif
            {{ $slot }}
        </div>
    </main>

    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div>
                    © {{ date('Y') }} FrugalDev | Made with &lt;3 and Laravel<br>
                    Best viewed in any browser
                </div>
                <div>
                    <span class="footer-counter">visitors:
                        {{ \App\Models\SiteSetting::get('hit_counter', '0') }}</span><br>
                    <span class="theme-sw">theme: <select id="themeSelect" onchange="switchTheme(this.value)" aria-label="Theme selector">
                            <option value="retro">retro</option>
                            <option value="paper">paper</option>
                            <option value="amber">amber</option>
                            <option value="highcontrast">high contrast</option>
                        </select></span>
                <div id="themePreview" style="display:none;position:absolute;bottom:100%;left:0;background:var(--bg2);border:1px solid var(--border);padding:6px;border-radius:4px;font-size:9px;width:140px;margin-bottom:4px">
                    <div style="display:flex;gap:3px;margin-bottom:2px">
                        <span id="tp1" style="width:20px;height:12px;display:inline-block;border-radius:2px"></span>
                        <span id="tp2" style="width:20px;height:12px;display:inline-block;border-radius:2px"></span>
                        <span id="tp3" style="width:20px;height:12px;display:inline-block;border-radius:2px"></span>
                    </div>
                    <span id="tpLabel" class="mono"></span>
                </div>
                <button onclick="switchTheme('retro');showToast('Theme reset')" style="background:none;border:none;color:var(--muted);cursor:pointer;font-family:var(--mono);font-size:10px">[reset]</button>
                <button onclick="document.getElementById('themeCustomizer').style.display=document.getElementById('themeCustomizer').style.display==='none'?'flex':'none'" style="background:none;border:none;color:var(--muted);cursor:pointer;font-family:var(--mono);font-size:10px">[customize]</button>
                <div id="themeCustomizer" style="display:none;gap:6px;margin-top:4px;align-items:center;font-size:10px">
                    <label>bg<input type="color" id="cBg" onchange="customTheme('--bg',this.value)" style="width:20px;height:14px;border:none;padding:0;cursor:pointer"></label>
                    <label>text<input type="color" id="cFg" onchange="customTheme('--text',this.value)" style="width:20px;height:14px;border:none;padding:0;cursor:pointer"></label>
                    <label>accent<input type="color" id="cAc" onchange="customTheme('--accent',this.value)" style="width:20px;height:14px;border:none;padding:0;cursor:pointer"></label>
                </div>
                </div>
                <div>
                    <a href="{{ route('feed') }}">[rss]</a>
                    <a href="{{ route('feed.comments') }}">[rss:comments]</a>
                    <a href="{{ route('plan') }}">[.plan]</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">[admin]</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" style="display:inline">
                            @csrf
                            <button type="submit"
                                style="background:none;border:none;color:var(--link);cursor:pointer;font-family:var(--mono);font-size:11px">[logout]</button>
                        </form>
                    @endauth
                </div>
            </div>
            {{-- Newsletter --}}
            <div style="margin-top:12px;padding-top:10px;border-top:1px solid var(--border)">
                <form action="{{ route('newsletter.subscribe') }}" method="POST" style="display:flex;gap:6px;align-items:center;flex-wrap:wrap">
                    @csrf
                    <span class="text-muted" style="font-size:10px">📬 subscribe:</span>
                    <input type="email" name="email" placeholder="your@email.com" required class="retro-input" style="width:180px;padding:2px 6px;font-size:10px" aria-label="Email for newsletter">
                    <button type="submit" class="btn" style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)" aria-label="Subscribe to newsletter">join</button>
                </form>
            </div>
        </div>
    </footer>

    <div class="status-bar">
        <span>{{ date('H:i') }} | <span id="loadTime"></span> | <span id="badgeProgress" class="text-green"></span></span>
        <span>Ctrl+K or / to open command palette</span>
    </div>

    <!-- Command Palette -->
    <div class="cmd-overlay" id="cmdPalette">
        <div class="cmd-box">
            <input type="text" class="cmd-input" id="cmdInput" placeholder="$ type a command..." autocomplete="off">
            <div class="cmd-results" id="cmdResults"></div>
            <div class="cmd-hint">commands: cd &lt;page&gt; | ls | help | theme &lt;retro|paper|amber&gt; | search &lt;query&gt; | ascii</div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast"></div>

    <script>
        // ═══ Page load time ═══
        document.getElementById('loadTime').textContent = Math.round(performance.now()) + 'ms';

        // ═══ Theme (with auto dark-mode detection) ═══
        const saved = localStorage.getItem('theme');
        if (saved) {
            document.body.dataset.theme = saved;
            document.getElementById('themeSelect').value = saved;
        } else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
            document.body.dataset.theme = 'paper';
            document.getElementById('themeSelect').value = 'paper';
        }
        function switchTheme(t) { document.body.dataset.theme = t; localStorage.setItem('theme', t); }
        function customTheme(prop, val) {
            document.documentElement.style.setProperty(prop, val);
            const custom = JSON.parse(localStorage.getItem('fd_custom_theme') || '{}');
            custom[prop] = val;
            localStorage.setItem('fd_custom_theme', JSON.stringify(custom));
        }
        // Restore custom theme colors
        (function() {
            const custom = JSON.parse(localStorage.getItem('fd_custom_theme') || '{}');
            Object.entries(custom).forEach(([prop, val]) => document.documentElement.style.setProperty(prop, val));
        })();

        // Theme preview on hover
        (function() {
            const colors = {
                retro: { bg: '#0a0a0a', fg: '#33ff33', accent: '#ff5555', label: 'Dark terminal' },
                paper: { bg: '#f5f0e8', fg: '#2c2c2c', accent: '#b33a3a', label: 'Light paper' },
                amber: { bg: '#1a1000', fg: '#ffaa00', accent: '#ff6600', label: 'Amber CRT' },
                highcontrast: { bg: '#000000', fg: '#ffffff', accent: '#ffff00', label: 'High contrast' }
            };
            const sel = document.getElementById('themeSelect');
            const preview = document.getElementById('themePreview');
            if (!sel || !preview) return;
            sel.addEventListener('mouseover', function() {
                const c = colors[this.value] || colors.retro;
                document.getElementById('tp1').style.background = c.bg;
                document.getElementById('tp2').style.background = c.fg;
                document.getElementById('tp3').style.background = c.accent;
                document.getElementById('tpLabel').textContent = c.label;
                preview.style.display = '';
            });
            sel.addEventListener('mouseout', function() { preview.style.display = 'none'; });
            sel.addEventListener('change', function() {
                const c = colors[this.value] || colors.retro;
                document.getElementById('tp1').style.background = c.bg;
                document.getElementById('tp2').style.background = c.fg;
                document.getElementById('tp3').style.background = c.accent;
                document.getElementById('tpLabel').textContent = c.label;
            });
        })();

        // ═══ Toast ═══
        function showToast(msg, dur = 3000) {
            const t = document.getElementById('toast');
            t.textContent = msg; t.classList.add('show');
            setTimeout(() => t.classList.remove('show'), dur);
        }

        // ═══ Command Palette ═══
        const pages = {
            home: '/', about: '/about', projects: '/projects', blog: '/blog',
            guestbook: '/guestbook', changelog: '/changelog', inspect: '/inspect',
            login: '/login', plan: '/.plan', feed: '/feed', search: '/search'
        };
        const cmdEl = document.getElementById('cmdPalette');
        const cmdIn = document.getElementById('cmdInput');
        const cmdRes = document.getElementById('cmdResults');

        document.addEventListener('keydown', (e) => {
            if ((e.key === 'k' && (e.ctrlKey || e.metaKey)) || (e.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName))) {
                e.preventDefault();
                cmdEl.classList.toggle('active');
                if (cmdEl.classList.contains('active')) { cmdIn.value = ''; cmdIn.focus(); updateResults(''); }
            }
            if (e.key === 'Escape') { cmdEl.classList.remove('active'); }
            // Focus trap in command palette
            if (e.key === 'Tab' && cmdEl.classList.contains('active')) {
                e.preventDefault();
                cmdIn.focus();
            }
        });
        cmdEl.addEventListener('click', (e) => { if (e.target === cmdEl) cmdEl.classList.remove('active'); });

        cmdIn.addEventListener('input', () => updateResults(cmdIn.value));
        cmdIn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') executeCmd(cmdIn.value);
        });

        function updateResults(q) {
            if (!q) { cmdRes.innerHTML = Object.keys(pages).map(p => `<div class="cmd-item" onclick="navigate('${pages[p]}')">${p}</div>`).join(''); return; }
            const parts = q.trim().split(/\s+/);
            const cmd = parts[0].toLowerCase();
            if (cmd === 'cd' || cmd === 'goto') {
                const target = parts[1] || '';
                const matches = Object.keys(pages).filter(p => p.includes(target));
                cmdRes.innerHTML = matches.map(p => `<div class="cmd-item" onclick="navigate('${pages[p]}')">→ ${p}</div>`).join('') || '<div class="cmd-item">not found</div>';
            } else if (cmd === 'ls') {
                cmdRes.innerHTML = Object.keys(pages).map(p => `<div class="cmd-item" onclick="navigate('${pages[p]}')">${p}/</div>`).join('');
            } else if (cmd === 'help') {
                cmdRes.innerHTML = '<div class="cmd-item">cd &lt;page&gt; - navigate</div><div class="cmd-item">ls - list pages</div><div class="cmd-item">theme &lt;name&gt; - switch theme</div><div class="cmd-item">search &lt;query&gt; - search content</div><div class="cmd-item">keys - keyboard shortcuts</div><div class="cmd-item">ascii - random art</div>';
            } else if (cmd === 'theme' && parts[1]) {
                switchTheme(parts[1]); cmdEl.classList.remove('active'); showToast('Theme: ' + parts[1]);
            } else {
                const matches = Object.keys(pages).filter(p => p.includes(q.toLowerCase()));
                cmdRes.innerHTML = matches.map(p => `<div class="cmd-item" onclick="navigate('${pages[p]}')">${p}</div>`).join('') || '<div class="cmd-item">no matches</div>';
            }
        }
        function executeCmd(q) {
            const parts = q.trim().split(/\s+/);
            const cmd = parts[0].toLowerCase();
            if (cmd === 'cd' || cmd === 'goto') { const p = pages[parts[1]]; if (p) navigate(p); }
            else if (cmd === 'search' || cmd === 'grep' || cmd === 'find') { const sq = parts.slice(1).join(' '); if (sq) navigate('/search?q=' + encodeURIComponent(sq)); }
            else if (cmd === 'theme' && parts[1]) { switchTheme(parts[1]); cmdEl.classList.remove('active'); showToast('Theme: ' + parts[1]); }
            else if (cmd === 'ascii') { cmdRes.innerHTML = '<pre class="cmd-item" style="font-size:10px;color:var(--green)">  /\\_/\\\n ( o.o )\n  > ^ <\n FrugalDev</pre>'; }
            else if (cmd === 'keys' || cmd === 'shortcuts') {
                cmdRes.innerHTML = '<div class="cmd-item"><b>Ctrl+K</b> / <b>/</b> — Command palette</div><div class="cmd-item"><b>/</b> — Focus search (outside inputs)</div><div class="cmd-item"><b>Esc</b> — Close palette</div><div class="cmd-item"><b>↑↑↓↓←→←→BA</b> — Konami Code</div><div class="cmd-item"><b>help</b> — Show all commands</div><div class="cmd-item"><b>theme retro|paper|amber|highcontrast</b> — Switch theme</div>';
                return;
            }
            else if (pages[cmd]) navigate(pages[cmd]);
        }
        function navigate(url) { cmdEl.classList.remove('active'); window.location.href = url; }

        // ═══ Badges ═══
        (function () {
            const b = JSON.parse(localStorage.getItem('fd_badges') || '{}');
            function earn(slug, label) { if (!b[slug]) { b[slug] = Date.now(); localStorage.setItem('fd_badges', JSON.stringify(b)); showToast('🏆 Badge: ' + label); } }
            earn('first_visit', 'First Steps');
            const visited = JSON.parse(localStorage.getItem('fd_visited') || '[]');
            const path = location.pathname;
            if (!visited.includes(path)) { visited.push(path); localStorage.setItem('fd_visited', JSON.stringify(visited)); }
            if (visited.length >= 5) earn('explorer', 'Explorer');
            const h = new Date().getHours();
            if (h >= 0 && h < 5) earn('night_owl', 'Night Owl');
            if (path === '/inspect') earn('archaeologist', 'Archaeologist');
            // Seasonal badges
            const month = new Date().getMonth() + 1;
            if (month === 12) earn('holiday_spirit', '🎄 Holiday Spirit');
            if (month >= 3 && month <= 5) earn('spring_bloom', '🌸 Spring Bloom');
            if (month >= 6 && month <= 8) earn('summer_coder', '☀️ Summer Coder');
        })();

        // ═══ Konami Code ═══
        (function () {
            const seq = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]; let pos = 0;
            document.addEventListener('keydown', (e) => {
                if (e.keyCode === seq[pos]) { pos++; if (pos === seq.length) { document.body.style.filter = 'invert(1) hue-rotate(180deg)'; showToast('🎮 KONAMI CODE ACTIVATED!', 5000); pos = 0; setTimeout(() => document.body.style.filter = '', 5000); } } else { pos = 0; }
            });
        })();

        // ═══ Loading Indicator ═══
        (function() {
            const loader = document.getElementById('pageLoader');
            document.addEventListener('click', function(e) {
                const a = e.target.closest('a[href]');
                if (a && a.href && !a.href.startsWith('javascript') && !a.target && a.host === location.host) {
                    loader.className = 'page-loader active';
                }
            });
            window.addEventListener('beforeunload', () => loader.className = 'page-loader active');
        })();

        // ═══ Badge Progress ═══
        (function() {
            const allBadges = ['first_visit','explorer','night_owl','archaeologist','reader','holiday_spirit','spring_bloom','summer_coder'];
            const rarity = {first_visit:'Common',explorer:'Common',night_owl:'Rare',archaeologist:'Legendary',reader:'Rare',holiday_spirit:'Rare',spring_bloom:'Common',summer_coder:'Common'};
            const earned = JSON.parse(localStorage.getItem('fd_badges') || '{}');
            const count = allBadges.filter(b => earned[b]).length;
            const el = document.getElementById('badgeProgress');
            if (el) el.textContent = count + '/' + allBadges.length + ' badges';
            // Rarity tooltip on badge display
            document.querySelectorAll('[data-badge]').forEach(b => {
                const r = rarity[b.dataset.badge] || 'Common';
                b.title = r;
                if (r === 'Legendary') b.style.color = 'var(--accent)';
                else if (r === 'Rare') b.style.color = 'var(--green)';
            });
        })();

        // ═══ Search Shortcut ═══
        document.addEventListener('keydown', function(e) {
            if (e.key === '/' && !['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName) && !document.getElementById('cmdPalette').classList.contains('active')) {
                e.preventDefault();
                const searchInput = document.querySelector('input[name="q"]');
                if (searchInput) searchInput.focus();
                else window.location.href = '/search';
            }
        });
    </script>
</body>

</html>