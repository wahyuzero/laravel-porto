<x-public-layout pageTitle="Badge Leaderboard"
    metaDescription="FrugalDev Badge Leaderboard — see who earned the most badges.">

    <h1>$ cat /var/log/achievements</h1>

    <div class="ascii-border mt-2" style="padding:12px 16px">
        <span class="mono text-muted" style="font-size:11px">// badge leaderboard — client-side achievement
            tracking</span>
    </div>

    <div class="mono mt-2" style="font-size:12px">
        <div id="leaderboard" style="margin-top:8px"></div>
    </div>

    <div class="ascii-border mt-2" style="padding:12px 16px">
        <h3 class="mono text-heading" style="font-size:12px">// all badges</h3>
        <div class="mono mt-1" style="font-size:11px">
            <div id="allBadgesList"></div>
        </div>
    </div>

    <script>
        (function () {
            const allBadges = {
                first_visit: { name: 'First Steps', rarity: 'Common', icon: '🏅' },
                explorer: { name: 'Explorer', rarity: 'Common', icon: '🧭' },
                night_owl: { name: 'Night Owl', rarity: 'Rare', icon: '🦉' },
                archaeologist: { name: 'Archaeologist', rarity: 'Legendary', icon: '🏛️' },
                reader: { name: 'Reader', rarity: 'Rare', icon: '📖' },
                writer: { name: 'Writer', rarity: 'Common', icon: '✍️' },
                holiday_spirit: { name: 'Holiday Spirit', rarity: 'Rare', icon: '🎄' },
                spring_bloom: { name: 'Spring Bloom', rarity: 'Common', icon: '🌸' },
                summer_coder: { name: 'Summer Coder', rarity: 'Common', icon: '☀️' },
            };

            const earned = JSON.parse(localStorage.getItem('fd_badges') || '{}');
            const count = Object.keys(earned).length;
            const total = Object.keys(allBadges).length;

            // Leaderboard (your progress)
            const lb = document.getElementById('leaderboard');
            const pct = Math.round((count / total) * 100);
            lb.innerHTML = `
                <div style="margin-bottom:12px">
                    <span class="text-heading">Your Progress: ${count}/${total} badges (${pct}%)</span>
                    <div style="background:var(--border);height:8px;border-radius:4px;margin-top:4px;overflow:hidden">
                        <div style="background:var(--green);height:100%;width:${pct}%;transition:width 0.3s"></div>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:8px">
                    ${Object.entries(allBadges).map(([key, b]) => {
                const has = earned[key];
                const rarityColor = b.rarity === 'Legendary' ? 'var(--accent)' : b.rarity === 'Rare' ? 'var(--green)' : 'var(--muted)';
                return `<div style="padding:8px;border:1px solid ${has ? 'var(--green)' : 'var(--border)'};border-radius:4px;opacity:${has ? 1 : 0.5}">
                            <span style="font-size:16px">${b.icon}</span>
                            <span style="color:${has ? 'var(--heading)' : 'var(--muted)'}">${b.name}</span>
                            <span style="color:${rarityColor};font-size:9px;float:right">${b.rarity}</span>
                            ${has ? '<span style="color:var(--green);font-size:9px;display:block">✓ earned ' + new Date(earned[key]).toLocaleDateString() + '</span>' : '<span style="color:var(--muted);font-size:9px;display:block">locked</span>'}
                        </div>`;
            }).join('')}
                </div>
            `;
        })();
    </script>

</x-public-layout>