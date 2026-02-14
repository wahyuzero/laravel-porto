<x-public-layout pageTitle="Inspect" metaDescription="You found the secret page!">

    <div class="ascii-border">
        <pre class="mono text-green" style="font-size:10px">
 ___ ___ _   _ _  _ ___
| __/ _ \ | | | \| |   \
| _| (_) | |_| |    | |) |
|_| \___/\___/|_|\_|___/
    </pre>
        <h1 class="mt-2">You found the secret page!</h1>
        <p class="text-green mono" style="font-size:12px">Welcome, fellow developer. 🏆</p>
    </div>

    <div class="ascii-hr">═══ SITE INTERNALS ═══</div>

    <div class="mono" style="font-size:12px">
        <div>framework : Laravel {{ app()->version() }}</div>
        <div>php : {{ phpversion() }}</div>
        <div>database : SQLite</div>
        <div>css : Tailwind v4 + Custom Retro</div>
        <div>js_framework : None (vanilla, ~5KB)</div>
        <div>font : Press Start 2P + system-ui</div>
        <div>themes : retro, paper, amber</div>
        <div>total_models : 12</div>
        <div>total_routes : {{ count(app('router')->getRoutes()) }}</div>
        <div>db_size : {{ round(filesize(database_path('database.sqlite')) / 1024) }}KB</div>
        <div>philosophy : Build more. Bloat less.</div>
    </div>

    <div class="ascii-hr">═══ YOUR BADGES ═══</div>

    <div id="badgeList" class="mono" style="font-size:12px">
        <p class="text-muted">Loading from localStorage...</p>
    </div>

    <script>
        const allBadges = {
            first_visit: '🏠 First Steps — Visited the site',
            explorer: '🗺️ Explorer — Visited 5+ pages',
            reader: '📖 Reader — Read 3+ blog posts',
            night_owl: '🌙 Night Owl — Visited between midnight and 5am',
            writer: '✍️ Writer — Signed the guest book',
            hacker: '💻 Hacker — Used command palette',
            archaeologist: '🔍 Archaeologist — Found this page!',
            veteran: '⭐ Veteran — Returned after 7+ days',
        };
        const earned = JSON.parse(localStorage.getItem('fd_badges') || '{}');
        let html = '';
        for (const [slug, desc] of Object.entries(allBadges)) {
            const has = earned[slug];
            html += `<div style="margin:4px 0;${has ? '' : 'opacity:0.3'}">${has ? '✓' : '○'} ${desc}${has ? ' <span class="text-muted">(' + new Date(has).toLocaleDateString() + ')</span>' : ''}</div>`;
        }
        document.getElementById('badgeList').innerHTML = html;
    </script>

</x-public-layout>