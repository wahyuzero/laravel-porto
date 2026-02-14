<x-public-layout pageTitle="Search{{ $query ? ': ' . $query : '' }}"
    metaDescription="Search FrugalDev — blog posts, projects, and more.">

    <h1>$ grep -r "{{ $query }}" ./</h1>

    <form action="{{ route('search') }}" method="GET" class="mt-2" style="display:flex;gap:8px">
        <div style="flex:1;position:relative">
            <input type="text" name="q" value="{{ $query }}" class="retro-input" placeholder="search posts, projects..."
                autofocus id="searchInput" minlength="2" autocomplete="off">
            <div id="autocompleteDropdown"
                style="display:none;position:absolute;top:100%;left:0;right:0;background:var(--bg2);border:1px solid var(--border);z-index:11;font-size:11px;font-family:var(--mono)">
            </div>
            <div id="recentDropdown"
                style="display:none;position:absolute;top:100%;left:0;right:0;background:var(--bg2);border:1px solid var(--border);z-index:10;max-height:150px;overflow-y:auto">
            </div>
        </div>
        <select name="type" class="retro-input" style="width:auto;font-size:11px" aria-label="Filter by type">
            <option value="">all</option>
            <option value="blog" {{ request('type') === 'blog' ? 'selected' : '' }}>blog</option>
            <option value="projects" {{ request('type') === 'projects' ? 'selected' : '' }}>projects</option>
        </select>
        <button type="submit" class="btn">search</button>
    </form>

    @if($query)
        <div class="mono mt-2" style="font-size:12px">
            <div class="text-muted mb-1">
                found {{ $posts->count() + $projects->count() }} result(s) for "{{ $query }}"
                @if(isset($suggestion) && $suggestion && $posts->isEmpty() && $projects->isEmpty())
                    <div style="margin-top:6px">
                        💡 Did you mean: <a href="{{ route('search', ['q' => $suggestion]) }}"
                            style="color:var(--link)">{{ $suggestion }}</a>?
                    </div>
                @endif
            </div>

            @if($posts->count())
                <div class="mt-2">
                    <h2>./blog/</h2>
                    @foreach($posts as $post)
                        <div style="margin:6px 0;display:flex;flex-wrap:wrap;gap:8px;align-items:baseline">
                            <span class="text-muted" style="min-width:85px">{{ $post->published_at->format('Y-m-d') }}</span>
                            <a href="{{ route('blog.show', $post->slug) }}" style="flex:1;min-width:200px">{{ $post->title }}</a>
                            <span class="text-muted">{{ $post->file_size }}</span>
                            @foreach($post->tags as $tag)
                                <span class="tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif

            @if($projects->count())
                <div class="mt-2">
                    <h2>./projects/</h2>
                    @foreach($projects as $project)
                        <div style="margin:6px 0;display:flex;flex-wrap:wrap;gap:8px;align-items:baseline">
                            <span class="text-muted" style="min-width:50px">{{ $project->year }}</span>
                            <a href="{{ route('projects.show', $project->slug) }}"
                                style="flex:1;min-width:200px">{{ $project->title }}</a>
                            <span class="text-muted">{{ $project->status }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($posts->count() === 0 && $projects->count() === 0)
                <div class="mt-2">
                    <p class="text-accent mono" style="font-size:11px">grep: {{ $query }}: No such file or directory</p>
                    <div class="ascii-border mt-1" style="padding:12px">
                        <p class="text-muted" style="font-size:12px">Suggestions:</p>
                        <ul class="text-muted" style="font-size:11px;margin-top:4px;padding-left:16px">
                            <li>Check your spelling</li>
                            <li>Try broader keywords</li>
                            <li>Use fewer words</li>
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    @else
        <p class="text-muted mono mt-2" style="font-size:12px">Type at least 2 characters to search.</p>

        {{-- Bookmarked posts --}}
        <div id="bookmarkList" class="mt-2" style="display:none">
            <h2>$ cat bookmarks.txt</h2>
            <div id="bookmarkItems" class="mono" style="font-size:12px;margin-top:8px"></div>
        </div>
    @endif

    <script>
        // Recent searches
        (function () {
            const input = document.getElementById('searchInput');
            const dropdown = document.getElementById('recentDropdown');
            const key = 'fd_recent_searches';

            @if($query)
                // Save this search
                const recent = JSON.parse(localStorage.getItem(key) || '[]');
                const q = '{{ addslashes($query) }}';
                const idx = recent.indexOf(q);
                if (idx > -1) recent.splice(idx, 1);
                recent.unshift(q);
                localStorage.setItem(key, JSON.stringify(recent.slice(0, 8)));
            @endif

            input.addEventListener('focus', showRecent);
            input.addEventListener('input', function () {
                if (!this.value) showRecent();
                else dropdown.style.display = 'none';
            });

            // Autocomplete
            let acTimer;
            const acDrop = document.getElementById('autocompleteDropdown');
            input.addEventListener('input', function () {
                clearTimeout(acTimer);
                const v = this.value;
                if (v.length < 2) { acDrop.style.display = 'none'; return; }
                acTimer = setTimeout(() => {
                    fetch('/search/autocomplete?q=' + encodeURIComponent(v))
                        .then(r => r.json())
                        .then(items => {
                            if (!items.length) { acDrop.style.display = 'none'; return; }
                            acDrop.innerHTML = items.map(t =>
                                `<div style="padding:4px 8px;cursor:pointer;color:var(--link)" onmouseover="this.style.background='var(--bg3)'" onmouseout="this.style.background=''" onclick="document.getElementById('searchInput').value='${t.replace(/'/g, "\\'")}';document.querySelector('form').submit()">${t}</div>`
                            ).join('');
                            acDrop.style.display = '';
                        });
                }, 300);
            });

            document.addEventListener('click', (e) => {
                if (!e.target.closest('#searchInput') && !e.target.closest('#recentDropdown'))
                    dropdown.style.display = 'none';
            });

            function showRecent() {
                const recent = JSON.parse(localStorage.getItem(key) || '[]');
                if (!recent.length) { dropdown.style.display = 'none'; return; }
                dropdown.innerHTML = '<div style="padding:4px 8px;color:var(--muted);font-size:10px">recent searches</div>' +
                    recent.map(s => `<div style="padding:4px 8px;cursor:pointer;font-size:11px;font-family:var(--mono);color:var(--link)" onmouseover="this.style.background='var(--bg3)'" onmouseout="this.style.background=''" onclick="document.getElementById('searchInput').value='${s}';document.querySelector('form').submit()">${s}</div>`).join('');
                dropdown.style.display = '';
            }
        })();

        // Show bookmarks on search page (when no query)
        @if(!$query)
            (function () {
                const bookmarks = JSON.parse(localStorage.getItem('fd_bookmarks') || '{}');
                const slugs = Object.keys(bookmarks);
                if (!slugs.length) return;
                document.getElementById('bookmarkList').style.display = '';
                const items = slugs.map(s => {
                    const b = bookmarks[s];
                    return `<div style="margin:4px 0"><a href="/blog/${s}">${b.title || s}</a></div>`;
                }).join('');
                document.getElementById('bookmarkItems').innerHTML = items;
            })();
        @endif
    </script>

</x-public-layout>