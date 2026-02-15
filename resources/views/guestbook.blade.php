<x-public-layout pageTitle="Guest Book" metaDescription="FrugalDev guest book — leave your mark.">

    <h1>$ cat guestbook.txt</h1>

    {{-- Success message with edit link --}}
    @if(session('success'))
        <div class="ascii-border mt-1" style="padding:8px 12px;border-color:var(--green)">
            <span class="mono text-green" style="font-size:11px">✓ {{ session('success') }}</span>
            @if(session('edit_token'))
                <span class="mono" style="font-size:10px;display:block;margin-top:4px">
                    📝 Save this link to edit your message later:
                    <a href="{{ route('guestbook.edit', session('edit_token')) }}" style="color:var(--link)">
                        [edit link]
                    </a>
                </span>
                <script>
                    // Store edit token in localStorage for this entry
                    const tokens = JSON.parse(localStorage.getItem('gb_edit_tokens') || '{}');
                    tokens['{{ session("entry_id") }}'] = '{{ session("edit_token") }}';
                    localStorage.setItem('gb_edit_tokens', JSON.stringify(tokens));
                </script>
            @endif
        </div>
    @endif

    <div class="ascii-border mt-2">
        <h3 class="mono text-heading" style="font-size:12px">// sign the guest book</h3>
        <form action="{{ route('guestbook.store') }}" method="POST" class="mt-1">
            @csrf
            <div class="form-group">
                <label class="retro-label" for="gb_nickname">nickname:</label>
                <input type="text" name="nickname" id="gb_nickname" class="retro-input" required maxlength="50"
                    value="{{ old('nickname') }}" aria-label="Your nickname">
            </div>
            <div class="form-group">
                <label class="retro-label" for="gb_website">website (optional):</label>
                <input type="url" name="website" id="gb_website" class="retro-input" maxlength="255"
                    value="{{ old('website') }}" aria-label="Your website URL" placeholder="https://...">
            </div>
            <div class="form-group">
                <label class="retro-label" for="gb_message">message (max 500 chars):</label>
                <textarea name="message" id="gb_message" class="retro-input" rows="3" required maxlength="500"
                    aria-label="Your message">{{ old('message') }}</textarea>
            </div>
            <div class="form-group">
                <label class="retro-label" for="gb_ascii">ascii art (optional, max 500 chars):</label>
                <textarea name="ascii_art" id="gb_ascii" class="retro-input mono" rows="4" maxlength="500"
                    aria-label="ASCII art" placeholder="   /\_/\
   ( o.o )
    > ^ <">{{ old('ascii_art') }}</textarea>
            </div>
            @foreach ($errors->all() as $error)
                <p class="text-accent mono" style="font-size:11px">! {{ $error }}</p>
            @endforeach
            <button type="submit" class="btn">sign</button>
        </form>
    </div>

    <div class="ascii-hr">═══ ENTRIES ═══</div>

    <div class="mono" style="font-size:12px">
        @forelse($entries as $entry)
            {{-- Main entry --}}
            <div id="entry-{{ $entry->id }}" style="margin-bottom:12px;padding:8px;border:1px solid var(--border)">
                <span class="text-muted">[{{ $entry->created_at->format('Y-m-d H:i') }}]</span>
                <span class="text-heading">
                    @if($entry->website)
                        <a href="{{ $entry->website }}" target="_blank" rel="noopener nofollow"
                            style="color:var(--heading)">&lt;{{ $entry->nickname }}&gt;</a>
                    @else
                        &lt;{{ $entry->nickname }}&gt;
                    @endif
                </span>
                {{ $entry->message }}
                @if($entry->ascii_art)
                    <pre style="color:var(--green);font-size:10px;margin-top:4px">{{ $entry->ascii_art }}</pre>
                @endif

                {{-- Reactions --}}
                <div class="gb-reactions" data-id="{{ $entry->id }}"
                    style="margin-top:4px;display:flex;gap:4px;align-items:center">
                    <button onclick="gbReact({{ $entry->id }},'👍')" class="btn" style="font-size:10px;padding:1px 6px">👍
                        <span class="rc">0</span></button>
                    <button onclick="gbReact({{ $entry->id }},'❤️')" class="btn" style="font-size:10px;padding:1px 6px">❤️
                        <span class="rc">0</span></button>
                    <button onclick="gbReact({{ $entry->id }},'😄')" class="btn" style="font-size:10px;padding:1px 6px">😄
                        <span class="rc">0</span></button>
                    <button onclick="toggleReply({{ $entry->id }})" class="btn"
                        style="font-size:10px;padding:1px 6px;margin-left:4px">↩ reply</button>
                    <span class="gb-edit-btn" data-id="{{ $entry->id }}" style="display:none">
                        <a href="#" class="btn" style="font-size:10px;padding:1px 6px">✏ edit</a>
                    </span>
                </div>

                {{-- Reply form (hidden by default) --}}
                <div id="reply-form-{{ $entry->id }}"
                    style="display:none;margin-top:8px;padding:8px;border-left:2px solid var(--green)">
                    <form action="{{ route('guestbook.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $entry->id }}">
                        <div class="form-group">
                            <input type="text" name="nickname" class="retro-input" required maxlength="50"
                                placeholder="your nickname" style="font-size:11px;padding:4px 8px">
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="retro-input" rows="2" required maxlength="500"
                                placeholder="your reply..." style="font-size:11px;padding:4px 8px"></textarea>
                        </div>
                        <button type="submit" class="btn" style="font-size:10px;padding:2px 8px">send reply</button>
                        <button type="button" onclick="toggleReply({{ $entry->id }})" class="btn"
                            style="font-size:10px;padding:2px 8px">cancel</button>
                    </form>
                </div>

                {{-- Threaded replies --}}
                @if($entry->replies->count() > 0)
                    <div style="margin-top:8px;margin-left:16px;border-left:2px solid var(--border);padding-left:8px">
                        @foreach($entry->replies as $reply)
                            <div id="entry-{{ $reply->id }}" style="margin-bottom:6px;padding:4px 0">
                                <span class="text-muted"
                                    style="font-size:10px">[{{ $reply->created_at->format('Y-m-d H:i') }}]</span>
                                <span class="text-heading" style="font-size:11px">
                                    @if($reply->website)
                                        <a href="{{ $reply->website }}" target="_blank" rel="noopener nofollow"
                                            style="color:var(--heading)">&lt;{{ $reply->nickname }}&gt;</a>
                                    @else
                                        &lt;{{ $reply->nickname }}&gt;
                                    @endif
                                </span>
                                <span style="font-size:11px">{{ $reply->message }}</span>
                                <span class="gb-edit-btn" data-id="{{ $reply->id }}" style="display:none">
                                    <a href="#" class="btn" style="font-size:9px;padding:0 4px">✏</a>
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">No entries yet. Be the first!</p>
        @endforelse
    </div>

    @if($entries->hasPages())
        <div class="mt-2 mono" style="font-size:12px">
            {{ $entries->links('pagination::simple-default') }}
        </div>
    @endif

    <script>
        // Badge: writer
        document.querySelector('form')?.addEventListener('submit', function () {
            const b = JSON.parse(localStorage.getItem('fd_badges') || '{}');
            if (!b.writer) { b.writer = Date.now(); localStorage.setItem('fd_badges', JSON.stringify(b)); }
        });

        // Toggle reply form
        function toggleReply(id) {
            const form = document.getElementById('reply-form-' + id);
            if (form) form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // Show edit buttons for entries the user owns (via localStorage tokens)
        (function () {
            const tokens = JSON.parse(localStorage.getItem('gb_edit_tokens') || '{}');
            document.querySelectorAll('.gb-edit-btn').forEach(btn => {
                const id = btn.dataset.id;
                if (tokens[id]) {
                    btn.style.display = 'inline';
                    const link = btn.querySelector('a');
                    if (link) link.href = '/guestbook/edit/' + tokens[id];
                }
            });
        })();

        // Guestbook reactions (client-side)
        function gbReact(id, emoji) {
            const key = 'gb_reactions';
            const data = JSON.parse(localStorage.getItem(key) || '{}');
            if (!data[id]) data[id] = {};
            const myKey = 'gb_my_' + id;
            const myReacted = localStorage.getItem(myKey);
            if (myReacted === emoji) return;
            data[id][emoji] = (data[id][emoji] || 0) + 1;
            localStorage.setItem(key, JSON.stringify(data));
            localStorage.setItem(myKey, emoji);
            loadReactions();
        }
        function loadReactions() {
            const data = JSON.parse(localStorage.getItem('gb_reactions') || '{}');
            document.querySelectorAll('.gb-reactions').forEach(container => {
                const id = container.dataset.id;
                const counts = data[id] || {};
                const myEmoji = localStorage.getItem('gb_my_' + id);
                container.querySelectorAll('button').forEach(btn => {
                    const emoji = btn.textContent.trim().split(' ')[0];
                    const count = counts[emoji] || 0;
                    const rc = btn.querySelector('.rc');
                    if (rc) rc.textContent = count;
                    btn.style.borderColor = (emoji === myEmoji) ? 'var(--green)' : '';
                });
            });
        }
        loadReactions();
    </script>

</x-public-layout>