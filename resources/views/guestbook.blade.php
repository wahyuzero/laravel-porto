<x-public-layout pageTitle="Guest Book" metaDescription="FrugalDev guest book — leave your mark.">

    <h1>$ cat guestbook.txt</h1>

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
            <div style="margin-bottom:12px;padding:8px;border:1px solid var(--border)">
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
                <div class="gb-reactions" data-id="{{ $entry->id }}" style="margin-top:4px;display:flex;gap:4px">
                    <button onclick="gbReact({{ $entry->id }},'👍')" class="btn" style="font-size:10px;padding:1px 6px">👍
                        <span class="rc">0</span></button>
                    <button onclick="gbReact({{ $entry->id }},'❤️')" class="btn" style="font-size:10px;padding:1px 6px">❤️
                        <span class="rc">0</span></button>
                    <button onclick="gbReact({{ $entry->id }},'😄')" class="btn" style="font-size:10px;padding:1px 6px">😄
                        <span class="rc">0</span></button>
                </div>
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

        // Guestbook reactions (client-side)
        function gbReact(id, emoji) {
            const key = 'gb_reactions';
            const data = JSON.parse(localStorage.getItem(key) || '{}');
            if (!data[id]) data[id] = {};
            const myKey = 'gb_my_' + id;
            const myReacted = localStorage.getItem(myKey);
            if (myReacted === emoji) return; // already reacted with same emoji
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
                    btn.querySelector('.rc').textContent = count;
                    btn.style.borderColor = (emoji === myEmoji) ? 'var(--green)' : '';
                });
            });
        }
        loadReactions();
    </script>

</x-public-layout>