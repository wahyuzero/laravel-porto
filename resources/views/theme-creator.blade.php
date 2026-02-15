<x-public-layout pageTitle="Theme Creator" metaDescription="Create your own custom FrugalDev theme.">

    <h1>$ ./theme-builder.sh</h1>

    <div class="ascii-border mt-2" style="padding:12px 16px">
        <span class="mono text-muted" style="font-size:11px">// build a custom theme from scratch</span>
    </div>

    <div class="mt-2" style="display:grid;grid-template-columns:1fr 1fr;gap:16px">

        {{-- Left: Builder --}}
        <div>
            <h3 class="mono text-heading" style="font-size:13px;margin-bottom:8px">// configure</h3>
            <div class="ascii-border" style="padding:12px">
                <div class="form-group" style="margin-bottom:8px">
                    <label class="retro-label" style="font-size:11px">theme name:</label>
                    <input type="text" id="tc_name" class="retro-input" placeholder="my-theme" maxlength="30"
                        style="font-size:12px;padding:4px 8px">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px">
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">background</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_bg" value="#0a0a0a" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_bg_hex" value="#0a0a0a" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_bg').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">text</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_text" value="#b0b0b0" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_text_hex" value="#b0b0b0" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_text').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">headings</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_heading" value="#e0e0e0" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_heading_hex" value="#e0e0e0" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_heading').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">accent</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_accent" value="#ff6b6b" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_accent_hex" value="#ff6b6b" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_accent').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">links</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_link" value="#6bb5ff" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_link_hex" value="#6bb5ff" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_link').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">green/success</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_green" value="#4ade80" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_green_hex" value="#4ade80" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_green').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">border</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_border" value="#333333" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_border_hex" value="#333333" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_border').value=this.value;tcUpdate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="retro-label" style="font-size:10px">muted</label>
                        <div style="display:flex;align-items:center;gap:6px">
                            <input type="color" id="tc_muted" value="#666666" onchange="tcUpdate()"
                                style="width:28px;height:20px;border:none;padding:0;cursor:pointer">
                            <input type="text" id="tc_muted_hex" value="#666666" maxlength="7" class="retro-input"
                                style="font-size:10px;padding:2px 4px;width:70px"
                                onchange="document.getElementById('tc_muted').value=this.value;tcUpdate()">
                        </div>
                    </div>
                </div>

                <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap">
                    <button onclick="tcApply()" class="btn" style="font-size:11px">▶ apply to site</button>
                    <button onclick="tcSave()" class="btn" style="font-size:11px">💾 save theme</button>
                    <button onclick="tcExport()" class="btn" style="font-size:11px">📋 copy CSS</button>
                    <button onclick="tcReset()" class="btn" style="font-size:11px">↺ reset</button>
                </div>

                {{-- Presets --}}
                <div style="margin-top:12px">
                    <span class="retro-label" style="font-size:10px">quick presets:</span>
                    <div style="display:flex;gap:4px;margin-top:4px;flex-wrap:wrap">
                        <button onclick="tcPreset('cyberpunk')" class="btn" style="font-size:9px;padding:1px 6px">🌆
                            Cyberpunk</button>
                        <button onclick="tcPreset('forest')" class="btn" style="font-size:9px;padding:1px 6px">🌲
                            Forest</button>
                        <button onclick="tcPreset('ocean')" class="btn" style="font-size:9px;padding:1px 6px">🌊
                            Ocean</button>
                        <button onclick="tcPreset('sunset')" class="btn" style="font-size:9px;padding:1px 6px">🌅
                            Sunset</button>
                        <button onclick="tcPreset('mono')" class="btn" style="font-size:9px;padding:1px 6px">⬜
                            Mono</button>
                    </div>
                </div>
            </div>

            {{-- Saved Themes --}}
            <div class="mt-2">
                <h3 class="mono text-heading" style="font-size:13px;margin-bottom:8px">// saved themes</h3>
                <div id="tc_saved" class="ascii-border" style="padding:8px 12px;font-size:11px">
                    <span class="text-muted">No saved themes yet.</span>
                </div>
            </div>
        </div>

        {{-- Right: Preview --}}
        <div>
            <h3 class="mono text-heading" style="font-size:13px;margin-bottom:8px">// live preview</h3>
            <div id="tc_preview" style="border:1px solid var(--border);border-radius:4px;overflow:hidden">
                <div id="tp_container" style="padding:16px;font-family:var(--mono);font-size:11px;transition:all 0.2s">
                    <div id="tp_header" style="margin-bottom:12px">
                        <span id="tp_h1" style="font-size:16px;font-weight:bold">$ cat preview.txt</span>
                        <div style="margin-top:4px">
                            <span id="tp_nav_link" style="cursor:pointer">[home]</span>
                            <span id="tp_nav_link2" style="cursor:pointer">[blog]</span>
                            <span id="tp_nav_link3" style="cursor:pointer">[about]</span>
                        </div>
                    </div>
                    <div id="tp_border_box" style="padding:8px;margin-bottom:8px">
                        <span id="tp_text">This is how your body text will look. The theme affects all pages across the
                            site.</span>
                    </div>
                    <div style="margin-bottom:8px">
                        <span id="tp_muted_text" style="font-size:10px">// muted comment text</span>
                    </div>
                    <div style="margin-bottom:8px">
                        <span id="tp_green_text">✓ Success message looks like this</span>
                    </div>
                    <div style="margin-bottom:8px">
                        <span id="tp_accent_text">✗ Error/accent text looks like this</span>
                    </div>
                    <div id="tp_btn" style="display:inline-block;padding:4px 12px;cursor:pointer;font-size:10px">
                        [button]
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const fields = ['bg', 'text', 'heading', 'accent', 'link', 'green', 'border', 'muted'];
        const cssMap = {
            bg: '--bg', text: '--text', heading: '--heading',
            accent: '--accent', link: '--link', green: '--green',
            border: '--border', muted: '--muted'
        };

        const presets = {
            cyberpunk: { bg: '#0d0221', text: '#e0b0ff', heading: '#ff00ff', accent: '#ff2079', link: '#00ffff', green: '#39ff14', border: '#4a0080', muted: '#7b2fa0' },
            forest: { bg: '#0a1a0a', text: '#88b090', heading: '#c8e6c0', accent: '#ff6347', link: '#90c890', green: '#32cd32', border: '#1a3a1a', muted: '#4a6a4a' },
            ocean: { bg: '#0a1628', text: '#8eb8d8', heading: '#d0e8ff', accent: '#ff7043', link: '#64b5f6', green: '#26a69a', border: '#1a3050', muted: '#4a6888' },
            sunset: { bg: '#1a0a0a', text: '#d4a07a', heading: '#ffe0c0', accent: '#ff4500', link: '#ffa07a', green: '#98fb98', border: '#3a1a1a', muted: '#8a5a3a' },
            mono: { bg: '#ffffff', text: '#333333', heading: '#000000', accent: '#666666', link: '#333333', green: '#333333', border: '#cccccc', muted: '#999999' },
        };

        function tcUpdate() {
            fields.forEach(f => {
                const v = document.getElementById('tc_' + f).value;
                document.getElementById('tc_' + f + '_hex').value = v;
            });
            tcRenderPreview();
        }

        function tcRenderPreview() {
            const v = {};
            fields.forEach(f => v[f] = document.getElementById('tc_' + f).value);

            const c = document.getElementById('tp_container');
            c.style.background = v.bg;
            c.style.color = v.text;
            document.getElementById('tp_h1').style.color = v.heading;
            ['tp_nav_link', 'tp_nav_link2', 'tp_nav_link3'].forEach(id =>
                document.getElementById(id).style.color = v.link);
            document.getElementById('tp_border_box').style.border = '1px solid ' + v.border;
            document.getElementById('tp_muted_text').style.color = v.muted;
            document.getElementById('tp_green_text').style.color = v.green;
            document.getElementById('tp_accent_text').style.color = v.accent;
            const btn = document.getElementById('tp_btn');
            btn.style.border = '1px solid ' + v.border;
            btn.style.color = v.heading;
        }

        function tcApply() {
            fields.forEach(f => {
                const v = document.getElementById('tc_' + f).value;
                document.documentElement.style.setProperty(cssMap[f], v);
            });
            // Also save to custom theme localStorage
            const custom = {};
            fields.forEach(f => custom[cssMap[f]] = document.getElementById('tc_' + f).value);
            localStorage.setItem('fd_custom_theme', JSON.stringify(custom));
        }

        function tcSave() {
            const name = document.getElementById('tc_name').value.trim();
            if (!name) { alert('Please enter a theme name'); return; }
            const themes = JSON.parse(localStorage.getItem('fd_custom_themes') || '{}');
            const v = {};
            fields.forEach(f => v[f] = document.getElementById('tc_' + f).value);
            themes[name] = v;
            localStorage.setItem('fd_custom_themes', JSON.stringify(themes));
            tcLoadSaved();
        }

        function tcLoadTheme(name) {
            const themes = JSON.parse(localStorage.getItem('fd_custom_themes') || '{}');
            const v = themes[name];
            if (!v) return;
            fields.forEach(f => {
                document.getElementById('tc_' + f).value = v[f];
                document.getElementById('tc_' + f + '_hex').value = v[f];
            });
            document.getElementById('tc_name').value = name;
            tcRenderPreview();
        }

        function tcDeleteTheme(name) {
            if (!confirm('Delete theme "' + name + '"?')) return;
            const themes = JSON.parse(localStorage.getItem('fd_custom_themes') || '{}');
            delete themes[name];
            localStorage.setItem('fd_custom_themes', JSON.stringify(themes));
            tcLoadSaved();
        }

        function tcLoadSaved() {
            const themes = JSON.parse(localStorage.getItem('fd_custom_themes') || '{}');
            const el = document.getElementById('tc_saved');
            const names = Object.keys(themes);
            if (names.length === 0) {
                el.innerHTML = '<span class="text-muted">No saved themes yet.</span>';
                return;
            }
            el.innerHTML = names.map(name => {
                const t = themes[name];
                return `<div style="display:flex;justify-content:space-between;align-items:center;padding:4px 0;border-bottom:1px solid var(--border)">
                    <div style="display:flex;align-items:center;gap:6px">
                        <span style="display:inline-flex;gap:2px">
                            ${['bg', 'text', 'accent', 'link', 'green'].map(f =>
                    `<span style="width:10px;height:10px;border-radius:2px;display:inline-block;background:${t[f]}"></span>`
                ).join('')}
                        </span>
                        <span style="cursor:pointer;color:var(--link)" onclick="tcLoadTheme('${name}')">${name}</span>
                    </div>
                    <div style="display:flex;gap:4px">
                        <button onclick="tcLoadTheme('${name}');tcApply()" class="btn" style="font-size:9px;padding:0 4px">▶</button>
                        <button onclick="tcDeleteTheme('${name}')" class="btn" style="font-size:9px;padding:0 4px;color:var(--accent)">✕</button>
                    </div>
                </div>`;
            }).join('');
        }

        function tcExport() {
            const v = {};
            fields.forEach(f => v[f] = document.getElementById('tc_' + f).value);
            const name = document.getElementById('tc_name').value.trim() || 'custom';
            const css = `[data-theme="${name}"] {\n` +
                fields.map(f => `    ${cssMap[f]}: ${v[f]};`).join('\n') +
                '\n}';
            navigator.clipboard.writeText(css).then(() => alert('CSS copied to clipboard!'));
        }

        function tcReset() {
            const defaults = { bg: '#0a0a0a', text: '#b0b0b0', heading: '#e0e0e0', accent: '#ff6b6b', link: '#6bb5ff', green: '#4ade80', border: '#333333', muted: '#666666' };
            fields.forEach(f => {
                document.getElementById('tc_' + f).value = defaults[f];
                document.getElementById('tc_' + f + '_hex').value = defaults[f];
            });
            document.getElementById('tc_name').value = '';
            tcRenderPreview();
        }

        function tcPreset(name) {
            const p = presets[name];
            if (!p) return;
            fields.forEach(f => {
                document.getElementById('tc_' + f).value = p[f];
                document.getElementById('tc_' + f + '_hex').value = p[f];
            });
            document.getElementById('tc_name').value = name;
            tcRenderPreview();
        }

        // Init
        tcRenderPreview();
        tcLoadSaved();
    </script>

</x-public-layout>