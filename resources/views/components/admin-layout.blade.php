<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — {{ $pageTitle ?? 'Dashboard' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            display: flex;
            min-height: 100vh;
        }

        /* Admin Light Mode */
        body.admin-light {
            background: #f8fafc;
            color: #1e293b;
        }

        body.admin-light .admin-sidebar {
            background: #ffffff;
            border-color: #e2e8f0;
        }

        body.admin-light .admin-sidebar a {
            color: #475569;
        }

        body.admin-light .admin-sidebar a:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        body.admin-light .admin-sidebar a.active {
            color: #0284c7;
            background: #e0f2fe;
        }

        body.admin-light .admin-sidebar .logo {
            color: #0284c7;
            border-color: #e2e8f0;
        }

        body.admin-light .stat-card {
            background: #ffffff;
            border-color: #e2e8f0;
        }

        body.admin-light .flash {
            border-color: #e2e8f0;
        }

        body.admin-light .admin-main {
            border-color: #e2e8f0;
        }

        /* Sidebar */
        .admin-sidebar {
            width: 220px;
            background: #1e293b;
            border-right: 1px solid #334155;
            padding: 16px 0;
            flex-shrink: 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .admin-sidebar .logo {
            padding: 0 16px 16px;
            font-weight: 700;
            color: #38bdf8;
            font-size: 14px;
            border-bottom: 1px solid #334155;
            margin-bottom: 8px;
        }

        .admin-sidebar a {
            display: block;
            padding: 8px 16px;
            color: #94a3b8;
            font-size: 13px;
            text-decoration: none;
        }

        .admin-sidebar a:hover {
            background: #334155;
            color: #e2e8f0;
        }

        .admin-sidebar a.active {
            color: #38bdf8;
            background: #1e3a5f;
            border-right: 2px solid #38bdf8;
        }

        .admin-sidebar .sep {
            border-top: 1px solid #334155;
            margin: 8px 0;
        }

        /* Main */
        .admin-main {
            flex: 1;
            margin-left: 220px;
            padding: 24px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .admin-header h1 {
            font-size: 20px;
            color: #f1f5f9;
        }

        .breadcrumb {
            font-size: 12px;
            color: #64748b;
        }

        .breadcrumb a {
            color: #38bdf8;
            text-decoration: none;
        }

        /* Flash */
        .flash {
            padding: 10px 16px;
            margin-bottom: 16px;
            border-radius: 4px;
            font-size: 13px;
        }

        .flash-success {
            background: #064e3b;
            color: #6ee7b7;
            border: 1px solid #065f46;
        }

        .flash-error {
            background: #7f1d1d;
            color: #fca5a5;
            border: 1px solid #991b1b;
        }

        /* Cards */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #1e293b;
            border: 1px solid #334155;
            padding: 16px;
            border-radius: 6px;
        }

        .stat-card .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card .value {
            font-size: 28px;
            font-weight: 700;
            color: #f1f5f9;
            margin-top: 4px;
        }

        /* Table */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .admin-table th {
            text-align: left;
            padding: 8px 12px;
            background: #1e293b;
            color: #94a3b8;
            font-weight: 500;
            border-bottom: 1px solid #334155;
        }

        .admin-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #1e293b;
        }

        .admin-table tr:hover {
            background: #1e293b;
        }

        /* Forms */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 12px;
            color: #94a3b8;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 8px 12px;
            background: #1e293b;
            border: 1px solid #334155;
            color: #e2e8f0;
            border-radius: 4px;
            font-size: 13px;
        }

        .form-input:focus {
            outline: none;
            border-color: #38bdf8;
        }

        textarea.form-input {
            min-height: 100px;
            resize: vertical;
            font-family: monospace;
        }

        select.form-input {
            cursor: pointer;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
        }

        .form-hint {
            font-size: 11px;
            color: #64748b;
            margin-top: 2px;
        }

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #334155;
            color: #94a3b8;
        }

        .btn-outline:hover {
            border-color: #38bdf8;
            color: #38bdf8;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            font-size: 11px;
            border-radius: 10px;
        }

        .badge-green {
            background: #064e3b;
            color: #6ee7b7;
        }

        .badge-yellow {
            background: #713f12;
            color: #fde047;
        }

        .badge-red {
            background: #7f1d1d;
            color: #fca5a5;
        }

        .badge-blue {
            background: #1e3a5f;
            color: #38bdf8;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                display: none;
            }

            .admin-main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <aside class="admin-sidebar">
        <div class="logo">⚡ FrugalDev Admin
            <button onclick="toggleAdminTheme()"
                style="float:right;background:none;border:none;cursor:pointer;font-size:14px"
                title="Toggle light/dark mode">🌓</button>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊
            Dashboard</a>
        <a href="{{ route('admin.analytics.index') }}"
            class="{{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">📈 Analytics</a>
        <a href="{{ route('admin.profile.edit') }}"
            class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">👤 Profile</a>
        <div class="sep"></div>
        <a href="{{ route('admin.projects.index') }}"
            class="{{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">📁 Projects</a>
        <a href="{{ route('admin.skills.index') }}"
            class="{{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">⚙️ Skills</a>
        <a href="{{ route('admin.experiences.index') }}"
            class="{{ request()->routeIs('admin.experiences.*') ? 'active' : '' }}">📋 Experience</a>
        <a href="{{ route('admin.blog.index') }}" class="{{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">📝
            Blog Posts</a>
        <a href="{{ route('admin.testimonials.index') }}"
            class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">💬 Testimonials</a>
        <div class="sep"></div>
        <a href="{{ route('admin.messages.index') }}"
            class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">📨 Messages
            @if(($unread = \App\Models\ContactMessage::unread()->count()) > 0)
                <span class="badge badge-red">{{ $unread }}</span>
            @endif
        </a>
        <a href="{{ route('admin.guestbook.index') }}"
            class="{{ request()->routeIs('admin.guestbook.*') ? 'active' : '' }}">📖 Guest Book
            @if(($pending = \App\Models\GuestBookEntry::where('is_approved', false)->count()) > 0)
                <span class="badge badge-yellow">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.comments.index') }}"
            class="{{ request()->routeIs('admin.comments.*') ? 'active' : '' }}">💬 Comments
            @if(($pendingComments = \App\Models\Comment::pending()->count()) > 0)
                <span class="badge badge-yellow">{{ $pendingComments }}</span>
            @endif
        </a>
        <div class="sep"></div>
        <a href="{{ route('admin.changelog.index') }}"
            class="{{ request()->routeIs('admin.changelog.*') ? 'active' : '' }}">📋 Changelog</a>
        <a href="{{ route('admin.export.index') }}"
            class="{{ request()->routeIs('admin.export.*') ? 'active' : '' }}">📦 Data Export</a>
        <a href="{{ route('admin.activity-log.index') }}"
            class="{{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}">📋 Activity Log</a>
        <a href="{{ route('admin.import.index') }}"
            class="{{ request()->routeIs('admin.import.*') ? 'active' : '' }}">📥 Import</a>
        <a href="{{ route('admin.newsletter-preview') }}"
            class="{{ request()->routeIs('admin.newsletter-preview') ? 'active' : '' }}">📧 Email Preview</a>
        <div class="sep"></div>
        <div style="font-size:10px;color:#64748b;padding:4px 12px">⭐ FAVORITES</div>
        <div id="adminFavs" style="font-size:12px"></div>
        <button onclick="addAdminFav()"
            style="background:none;border:none;color:#38bdf8;cursor:pointer;font-size:11px;padding:4px 12px;text-align:left">+
            Add current page</button>
        <div class="sep"></div>
        <a href="{{ route('admin.settings.edit') }}"
            class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">⚙️ Settings</a>
        <div class="sep"></div>
        <a href="{{ route('home') }}" target="_blank">🌐 View Site</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                style="width:100%;text-align:left;background:none;border:none;color:#94a3b8;padding:8px 16px;font-size:13px;cursor:pointer">🚪
                Logout</button>
        </form>
    </aside>

    {{-- FAB Quick Create --}}
    <div id="adminFab" style="position:fixed;bottom:24px;right:24px;z-index:100">
        <div id="fabMenu"
            style="display:none;margin-bottom:8px;background:#1e293b;border:1px solid #334155;border-radius:8px;padding:8px;min-width:160px">
            <a href="{{ route('admin.blog.create') }}"
                style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;font-size:13px;border-radius:4px">📝
                New Post</a>
            <a href="{{ route('admin.projects.create') }}"
                style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;font-size:13px;border-radius:4px">📁
                New Project</a>
            <a href="{{ route('admin.skills.create') }}"
                style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;font-size:13px;border-radius:4px">⚙️
                New Skill</a>
            <a href="{{ route('admin.changelog.create') }}"
                style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;font-size:13px;border-radius:4px">📋
                New Changelog</a>
        </div>
        <button
            onclick="document.getElementById('fabMenu').style.display=document.getElementById('fabMenu').style.display==='none'?'block':'none'"
            style="width:48px;height:48px;border-radius:50%;background:#38bdf8;color:#0f172a;border:none;font-size:24px;cursor:pointer;box-shadow:0 4px 12px rgba(56,189,248,0.3);transition:transform 0.2s"
            onmouseenter="this.style.transform='scale(1.1)'" onmouseleave="this.style.transform=''">+</button>
    </div>

    <main class="admin-main">
        @if(session('success'))
            <div class="flash flash-success">✓ {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        {{ $slot }}
    </main>

    <script>
        // Admin dark/light mode toggle
        (function () {
            const mode = localStorage.getItem('admin_theme');
            if (mode === 'light') document.body.classList.add('admin-light');
        })();
        function toggleAdminTheme() {
            document.body.classList.toggle('admin-light');
            localStorage.setItem('admin_theme', document.body.classList.contains('admin-light') ? 'light' : 'dark');
        }

        // Admin favorites
        function addAdminFav() {
            const favs = JSON.parse(localStorage.getItem('admin_favs') || '[]');
            const url = window.location.pathname;
            const title = document.title.replace(' | Admin', '').replace(' - Admin', '');
            if (favs.find(f => f.url === url)) return;
            favs.push({ url, title });
            localStorage.setItem('admin_favs', JSON.stringify(favs));
            loadAdminFavs();
        }
        function removeAdminFav(url) {
            let favs = JSON.parse(localStorage.getItem('admin_favs') || '[]');
            favs = favs.filter(f => f.url !== url);
            localStorage.setItem('admin_favs', JSON.stringify(favs));
            loadAdminFavs();
        }
        function loadAdminFavs() {
            const favs = JSON.parse(localStorage.getItem('admin_favs') || '[]');
            const el = document.getElementById('adminFavs');
            if (!el) return;
            el.innerHTML = favs.map(f =>
                `<a href="${f.url}" style="display:flex;justify-content:space-between;align-items:center;padding:4px 12px;font-size:11px;color:#e2e8f0;text-decoration:none">
                    <span>${f.title}</span>
                    <span onclick="event.preventDefault();removeAdminFav('${f.url}')" style="cursor:pointer;color:#ef4444;font-size:9px">✕</span>
                </a>`
            ).join('');
        }
        loadAdminFavs();

        // Admin keyboard shortcuts
        document.addEventListener('keydown', function (e) {
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) return;
            if (e.altKey && e.key === 'n') { e.preventDefault(); window.location.href = '{{ route("admin.blog.create") }}'; }
            if (e.altKey && e.key === 'd') { e.preventDefault(); window.location.href = '{{ route("admin.dashboard") }}'; }
            if (e.altKey && e.key === 'p') { e.preventDefault(); window.location.href = '{{ route("admin.projects.index") }}'; }
            if (e.altKey && e.key === 'h') {
                e.preventDefault();
                alert('Admin Shortcuts:\n\nAlt+N = New Blog Post\nAlt+D = Dashboard\nAlt+P = Projects\nAlt+H = This Help\nCtrl+Z = Undo (in forms)\nCtrl+Y = Redo (in forms)\nRight-click = Quick Actions');
            }
        });

        // ═══ Quick Actions Context Menu ═══
        (function () {
            const menu = document.createElement('div');
            menu.id = 'ctxMenu';
            menu.style.cssText = 'display:none;position:fixed;z-index:9999;background:#1e293b;border:1px solid #334155;border-radius:6px;padding:4px;min-width:180px;box-shadow:0 8px 24px rgba(0,0,0,.4);font-size:13px';
            menu.innerHTML = `
                <a href="{{ route('admin.dashboard') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📊 Dashboard</a>
                <a href="{{ route('admin.blog.create') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📝 New Post</a>
                <a href="{{ route('admin.projects.create') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📁 New Project</a>
                <div style="border-top:1px solid #334155;margin:4px 0"></div>
                <a href="{{ route('admin.export.index') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📦 Export</a>
                <a href="{{ route('admin.import.index') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📥 Import</a>
                <a href="{{ route('admin.activity-log.index') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">📋 Activity Log</a>
                <div style="border-top:1px solid #334155;margin:4px 0"></div>
                <a href="{{ route('admin.settings.edit') }}" style="display:block;padding:6px 12px;color:#e2e8f0;text-decoration:none;border-radius:4px">⚙️ Settings</a>
            `;
            document.body.appendChild(menu);

            // Hover effect
            menu.querySelectorAll('a').forEach(a => {
                a.addEventListener('mouseenter', () => a.style.background = '#334155');
                a.addEventListener('mouseleave', () => a.style.background = 'none');
            });

            document.addEventListener('contextmenu', function (e) {
                // Only show on main content area, not on inputs/links
                if (['INPUT', 'TEXTAREA', 'SELECT', 'A'].includes(e.target.tagName)) return;
                e.preventDefault();
                menu.style.display = 'block';
                menu.style.left = Math.min(e.clientX, window.innerWidth - 200) + 'px';
                menu.style.top = Math.min(e.clientY, window.innerHeight - 300) + 'px';
            });
            document.addEventListener('click', () => menu.style.display = 'none');
        })();

        // ═══ Undo/Redo for Form Fields ═══
        (function () {
            const history = {};
            const redoStack = {};
            const maxHistory = 50;

            function getKey(el) {
                return el.name || el.id || el.className;
            }

            // Track changes on all inputs/textareas
            document.querySelectorAll('input[type="text"], textarea').forEach(el => {
                const key = getKey(el);
                if (!key) return;
                history[key] = [el.value];
                redoStack[key] = [];

                el.addEventListener('input', function () {
                    if (!history[key]) history[key] = [];
                    history[key].push(el.value);
                    if (history[key].length > maxHistory) history[key].shift();
                    redoStack[key] = []; // clear redo on new input
                });
            });

            document.addEventListener('keydown', function (e) {
                const el = document.activeElement;
                if (!['INPUT', 'TEXTAREA'].includes(el.tagName)) return;
                const key = getKey(el);
                if (!key) return;

                // Ctrl+Z = Undo
                if (e.ctrlKey && e.key === 'z' && !e.shiftKey) {
                    e.preventDefault();
                    if (history[key] && history[key].length > 1) {
                        redoStack[key] = redoStack[key] || [];
                        redoStack[key].push(history[key].pop());
                        el.value = history[key][history[key].length - 1];
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }

                // Ctrl+Y = Redo
                if ((e.ctrlKey && e.key === 'y') || (e.ctrlKey && e.shiftKey && e.key === 'z')) {
                    e.preventDefault();
                    if (redoStack[key] && redoStack[key].length > 0) {
                        const val = redoStack[key].pop();
                        history[key].push(val);
                        el.value = val;
                        el.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                }
            });
        })();
    </script>
</body>

</html>