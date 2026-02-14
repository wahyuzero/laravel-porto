<x-public-layout pageTitle="{{ $post->title }}"
    metaDescription="{{ $post->excerpt ?? Str::limit($post->content_md, 150) }}">

    {{-- JSON-LD Article Schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Article",
        "headline": "{{ $post->title }}",
        "datePublished": "{{ $post->published_at->toIso8601String() }}",
        "dateModified": "{{ $post->updated_at->toIso8601String() }}",
        "author": {
            "@@type": "Person",
            "name": "FrugalDev"
        },
        "description": "{{ $post->excerpt ?? Str::limit($post->content_md, 150) }}",
        "wordCount": {{ str_word_count($post->content_md) }},
        "url": "{{ route('blog.show', $post->slug) }}"
    }
    </script>

    {{-- Breadcrumb --}}
    <nav class="mono text-muted" style="font-size:12px" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">~</a> /
        <a href="{{ route('blog.index') }}">blog</a> /
        {{ $post->slug }}.md
    </nav>
    {{-- BreadcrumbList Schema --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "BreadcrumbList",
        "itemListElement": [
            { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ route('home') }}" },
            { "@@type": "ListItem", "position": 2, "name": "Blog", "item": "{{ route('blog.index') }}" },
            { "@@type": "ListItem", "position": 3, "name": "{{ $post->title }}" }
        ]
    }
    </script>

    <article class="ascii-border mt-2">
        <h1>{{ $post->title }}</h1>
        <div class="mono text-muted"
            style="font-size:11px;margin-bottom:16px;display:flex;justify-content:space-between;align-items:center">
            <span>
                {{ $post->published_at->format('Y-m-d H:i') }} |
                {{ ceil(str_word_count($post->content_md) / config('wxsys.reading_time.wpm', 200)) }} min read |
                {{ $post->file_size }} |
                👁 {{ $post->views_count }} views
            </span>
            <button id="bookmarkBtn" class="btn"
                style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)"
                onclick="toggleBookmark('{{ $post->slug }}', '{{ addslashes($post->title) }}')">[bookmark]</button>
            <button onclick="window.print()" class="btn"
                style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)"
                aria-label="Print article">[print]</button>
            <button onclick="adjustFont(1)" class="btn"
                style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)"
                aria-label="Increase font size">[A+]</button>
            <button onclick="adjustFont(-1)" class="btn"
                style="font-size:9px;padding:2px 8px;box-shadow:1px 1px 0px var(--heading)"
                aria-label="Decrease font size">[A-]</button>
        </div>

        @if($post->tags->count())
            <div style="margin-bottom:16px">
                @foreach($post->tags as $tag)
                    <a href="{{ route('blog.tag', $tag->name) }}" class="tag" style="text-decoration:none">{{ $tag->name }}</a>
                @endforeach
            </div>
        @endif

        <div class="blog-content" style="font-size:14px;line-height:1.8">
            {!! $post->content_html !!}
        </div>
    </article>

    {{-- Social Sharing --}}
    <div class="ascii-border mt-2" style="padding:8px 16px">
        <span class="mono text-muted" style="font-size:11px">$ share --to</span>
        @php
            $shareUrl = urlencode(route('blog.show', $post->slug));
            $shareTitle = urlencode($post->title);
        @endphp
        <div style="display:flex;gap:8px;margin-top:4px;flex-wrap:wrap">
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
                rel="noopener" class="btn" style="font-size:10px" aria-label="Share on Twitter">[twitter/X]</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener"
                class="btn" style="font-size:10px" aria-label="Share on LinkedIn">[linkedin]</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener"
                class="btn" style="font-size:10px" aria-label="Share on Facebook">[facebook]</a>
            <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                rel="noopener" class="btn" style="font-size:10px" aria-label="Share on WhatsApp">[whatsapp]</a>
            <button
                onclick="navigator.clipboard.writeText('{{ route('blog.show', $post->slug) }}');this.textContent='[copied!]';setTimeout(()=>this.textContent='[copy link]',2000)"
                class="btn" style="font-size:10px">[copy link]</button>
        </div>
    </div>

    {{-- Social Follow --}}
    <div class="ascii-border mt-2" style="padding:8px 16px">
        <span class="mono text-muted" style="font-size:11px">$ follow --author</span>
        @php $profile = \App\Models\Profile::first(); @endphp
        <div style="display:flex;gap:8px;margin-top:4px;flex-wrap:wrap">
            @if($profile?->social_links['github'] ?? null)
                <a href="{{ $profile->social_links['github'] }}" target="_blank" rel="noopener" class="btn"
                    style="font-size:10px">[github]</a>
            @endif
            @if($profile?->social_links['twitter'] ?? null)
                <a href="{{ $profile->social_links['twitter'] }}" target="_blank" rel="noopener" class="btn"
                    style="font-size:10px">[twitter]</a>
            @endif
            @if($profile?->social_links['linkedin'] ?? null)
                <a href="{{ $profile->social_links['linkedin'] }}" target="_blank" rel="noopener" class="btn"
                    style="font-size:10px">[linkedin]</a>
            @endif
            <a href="{{ route('feed') }}" class="btn" style="font-size:10px">[rss]</a>
        </div>
    </div>

    {{-- Next/Prev Navigation --}}
    <div class="mt-2 mono" style="font-size:12px;display:flex;justify-content:space-between;gap:16px">
        <div>
            @if($prevPost)
                <span class="text-muted">←</span> <a
                    href="{{ route('blog.show', $prevPost->slug) }}">{{ Str::limit($prevPost->title, 40) }}</a>
            @endif
        </div>
        <div style="text-align:right">
            @if($nextPost)
                <a href="{{ route('blog.show', $nextPost->slug) }}">{{ Str::limit($nextPost->title, 40) }}</a> <span
                    class="text-muted">→</span>
            @endif
        </div>
    </div>

    {{-- Related Posts --}}
    @if($relatedPosts->count())
        <div class="mt-2">
            <h2>$ ls related/</h2>
            <div class="mono" style="font-size:12px;margin-top:8px">
                @foreach($relatedPosts as $related)
                    <div style="margin-bottom:6px">
                        <span class="text-muted">{{ $related->published_at->format('Y-m-d') }}</span>
                        <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                        <span class="text-muted">{{ $related->file_size }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Comments Section --}}
    <div class="mt-2">
        <h2>$ cat comments.log</h2>
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap">
            <div class="mono text-muted" style="font-size:11px;margin:8px 0">
                {{ $comments->count() }} comment(s) | moderated
            </div>
            <select id="commentSort" onchange="sortComments(this.value)"
                style="font-size:10px;background:var(--bg2);color:var(--text);border:1px solid var(--border);padding:2px 6px;font-family:var(--mono)"
                aria-label="Sort comments">
                <option value="oldest">oldest first</option>
                <option value="newest">newest first</option>
            </select>
        </div>

        @if(session('success'))
            <div class="flash-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Comments Display --}}
        @forelse($comments as $comment)
            <div class="ascii-border" style="margin:8px 0;padding:10px 12px" id="comment-{{ $comment->id }}">
                <div style="display:flex;justify-content:space-between;align-items:baseline;flex-wrap:wrap;gap:4px">
                    <span class="text-heading mono" style="font-size:12px">{{ $comment->author_name }}</span>
                    <span class="text-muted mono" style="font-size:10px">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p style="margin:6px 0;font-size:13px;white-space:pre-line">{{ $comment->content }}</p>
                <div style="display:flex;gap:8px;align-items:center">
                    <button onclick="upvoteComment({{ $comment->id }})" id="vote-{{ $comment->id }}" class="mono text-link"
                        style="background:none;border:none;cursor:pointer;font-size:11px;color:var(--muted);padding:0">▲
                        <span class="vc">0</span></button>
                    <button onclick="document.getElementById('reply-{{ $comment->id }}').style.display='block'"
                        class="mono text-link"
                        style="background:none;border:none;cursor:pointer;font-size:11px;color:var(--link);padding:0">[reply]</button>
                </div>

                {{-- Reply Form --}}
                <div id="reply-{{ $comment->id }}" style="display:none;margin-top:8px">
                    <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                        @csrf
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:6px">
                            <input type="text" name="author_name" class="retro-input" placeholder="name" required>
                            <input type="email" name="author_email" class="retro-input" placeholder="email" required>
                        </div>
                        <textarea name="content" class="retro-input" rows="2" placeholder="your reply..." required
                            maxlength="2000"></textarea>
                        <div style="margin-top:4px;display:flex;gap:6px">
                            <button type="submit" class="btn" style="font-size:10px">submit reply</button>
                            <button type="button" onclick="this.closest('[id^=reply-]').style.display='none'"
                                class="mono text-muted"
                                style="background:none;border:none;cursor:pointer;font-size:11px">cancel</button>
                        </div>
                    </form>
                </div>

                {{-- Threaded Replies --}}
                @if($comment->replies->count())
                    <div style="margin-top:8px;padding-left:16px;border-left:2px solid var(--border)">
                        @foreach($comment->replies as $reply)
                            <div style="margin:6px 0" id="comment-{{ $reply->id }}">
                                <div style="display:flex;justify-content:space-between;flex-wrap:wrap;gap:4px">
                                    <span class="text-heading mono" style="font-size:11px">↳ {{ $reply->author_name }}</span>
                                    <span class="text-muted mono"
                                        style="font-size:10px">{{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                                <p style="margin:4px 0;font-size:12px;white-space:pre-line">{{ $reply->content }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted mono" style="font-size:12px;margin:8px 0">No comments yet. Be the first!</p>
        @endforelse

        {{-- New Comment Form --}}
        <div class="ascii-border mt-2" style="padding:12px">
            <h3 style="margin-bottom:8px">$ write comment</h3>
            <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:8px">
                    <div class="form-group" style="margin:0">
                        <label class="retro-label" for="comment_name">name *</label>
                        <input type="text" name="author_name" id="comment_name" class="retro-input" required
                            value="{{ old('author_name') }}" aria-label="Your name">
                    </div>
                    <div class="form-group" style="margin:0">
                        <label class="retro-label" for="comment_email">email * (not published)</label>
                        <input type="email" name="author_email" id="comment_email" class="retro-input" required
                            value="{{ old('author_email') }}" aria-label="Your email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="retro-label" for="comment_content">comment * (max 2000 chars)</label>
                    <textarea name="content" id="comment_content" class="retro-input" rows="4" required maxlength="2000"
                        aria-label="Your comment">{{ old('content') }}</textarea>
                    {{-- Markdown Toolbar --}}
                    <div style="display:flex;gap:4px;margin-bottom:4px;flex-wrap:wrap">
                        <button type="button" onclick="mdWrap('**','**')" class="btn"
                            style="font-size:10px;padding:1px 6px" title="Bold"><b>B</b></button>
                        <button type="button" onclick="mdWrap('*','*')" class="btn"
                            style="font-size:10px;padding:1px 6px" title="Italic"><i>I</i></button>
                        <button type="button" onclick="mdWrap('`','`')" class="btn"
                            style="font-size:10px;padding:1px 6px" title="Code">{'}'</button>
                        <button type="button" onclick="mdWrap('[','](url)')" class="btn"
                            style="font-size:10px;padding:1px 6px" title="Link">🔗</button>
                        <button type="button" onclick="mdInsert('> ')" class="btn"
                            style="font-size:10px;padding:1px 6px" title="Quote">❝</button>
                    </div>
                    <button type="button"
                        onclick="document.getElementById('emojiPicker').style.display=document.getElementById('emojiPicker').style.display==='none'?'flex':'none'"
                        class="mono text-link"
                        style="background:none;border:none;cursor:pointer;font-size:11px;color:var(--link);padding:2px 0">[😀
                        emoji]</button>
                    <div id="emojiPicker" style="display:none;flex-wrap:wrap;gap:4px;margin:4px 0;font-size:16px">
                        @foreach(['😀', '😂', '🤔', '👍', '❤️', '🎉', '🔥', '✨', '💡', '🙏', '👀', '🚀', '💬', '☕', '⚡', '🎯', '✅', '⭐'] as $e)
                            <span style="cursor:pointer;padding:2px"
                                onclick="(function(e){var t=document.getElementById('comment_content');t.value+=e;t.focus()})('{{ $e }}')">{{ $e }}</span>
                        @endforeach
                    </div>
                </div>
                @if($errors->any())
                    <div style="color:var(--accent);font-size:12px;margin-bottom:8px">
                        @foreach($errors->all() as $err)
                            <div>✗ {{ $err }}</div>
                        @endforeach
                    </div>
                @endif
                <button type="submit" class="btn">submit comment</button>
                <span class="text-muted mono" style="font-size:10px;margin-left:8px">moderated before publishing</span>
            </form>
        </div>
    </div>

    <style>
        .blog-content h1 {
            font-size: 16px;
            margin-top: 24px;
        }

        .blog-content h2 {
            font-size: 14px;
            margin-top: 20px;
        }

        .blog-content h3 {
            font-size: 13px;
            margin-top: 16px;
        }

        .blog-content p {
            margin: 8px 0;
        }

        .blog-content ul,
        .blog-content ol {
            margin: 8px 0;
            padding-left: 24px;
        }

        .blog-content li {
            margin: 4px 0;
        }

        .blog-content code {
            background: var(--bg2);
            padding: 1px 4px;
            font-family: var(--mono);
            font-size: 13px;
            color: var(--green);
        }

        .blog-content pre {
            background: var(--bg2);
            padding: 12px;
            margin: 12px 0;
            overflow-x: auto;
            border: 1px solid var(--border);
        }

        .blog-content pre code {
            padding: 0;
            background: transparent;
        }

        .blog-content blockquote {
            border-left: 3px solid var(--heading);
            padding-left: 12px;
            margin: 12px 0;
            color: var(--muted);
            font-style: italic;
        }

        .blog-content a {
            color: var(--link);
        }

        .blog-content img {
            max-width: 100%;
            border: 2px solid var(--border);
        }

        /* Copy Code Button */
        .code-wrapper {
            position: relative;
        }

        .copy-code-btn {
            position: absolute;
            top: 4px;
            right: 4px;
            background: var(--bg);
            border: 1px solid var(--border);
            color: var(--muted);
            font-family: var(--mono);
            font-size: 9px;
            padding: 2px 6px;
            cursor: pointer;
        }

        .copy-code-btn:hover {
            color: var(--heading);
            border-color: var(--heading);
        }

        /* TOC */
        .toc {
            font-size: 12px;
            margin: 12px 0;
            padding: 8px 12px;
        }

        .toc a {
            display: block;
            padding: 2px 0;
            color: var(--link);
            text-decoration: none;
        }

        .toc a:hover {
            text-decoration: underline;
        }

        .toc .toc-h3 {
            padding-left: 12px;
        }
    </style>

    <script>
        // Badge: reader
        (function () {
            const read = JSON.parse(localStorage.getItem('fd_read_posts') || '[]');
            const slug = '{{ $post->slug }}';
            if (!read.includes(slug)) { read.push(slug); localStorage.setItem('fd_read_posts', JSON.stringify(read)); }
            if (read.length >= 3) {
                const b = JSON.parse(localStorage.getItem('fd_badges') || '{}');
                if (!b.reader) { b.reader = Date.now(); localStorage.setItem('fd_badges', JSON.stringify(b)); }
            }
        })();

        // Copy code buttons
        document.querySelectorAll('.blog-content pre').forEach((pre) => {
            const wrapper = document.createElement('div');
            wrapper.className = 'code-wrapper';
            pre.parentNode.insertBefore(wrapper, pre);
            wrapper.appendChild(pre);
            const btn = document.createElement('button');
            btn.className = 'copy-code-btn';
            btn.textContent = 'copy';
            btn.onclick = () => {
                const code = pre.querySelector('code');
                navigator.clipboard.writeText(code ? code.textContent : pre.textContent);
                btn.textContent = 'copied!';
                setTimeout(() => btn.textContent = 'copy', 2000);
            };
            wrapper.appendChild(btn);
        });

        // Auto-generate TOC from headings
        (function () {
            const content = document.querySelector('.blog-content');
            const headings = content.querySelectorAll('h1, h2, h3');
            if (headings.length >= 3) {
                const toc = document.createElement('nav');
                toc.className = 'ascii-border toc';
                toc.innerHTML = '<span class="text-muted" style="font-size:10px">$ cat contents</' + 'span>';
                headings.forEach((h, i) => {
                    const id = 'heading-' + i;
                    h.id = id;
                    const a = document.createElement('a');
                    a.href = '#' + id;
                    a.textContent = h.textContent;
                    if (h.tagName === 'H3') a.className = 'toc-h3';
                    toc.appendChild(a);
                });
                content.insertBefore(toc, content.firstChild);
            }
        })();

        // Bookmark/Save post
        function toggleBookmark(slug, title) {
            const bookmarks = JSON.parse(localStorage.getItem('fd_bookmarks') || '{}');
            const btn = document.getElementById('bookmarkBtn');
            if (bookmarks[slug]) {
                delete bookmarks[slug];
                btn.textContent = '[bookmark]';
            } else {
                bookmarks[slug] = { title: title, date: Date.now() };
                btn.textContent = '[bookmarked ✓]';
            }
            localStorage.setItem('fd_bookmarks', JSON.stringify(bookmarks));
        }
        // Init bookmark state
        (function () {
            const bookmarks = JSON.parse(localStorage.getItem('fd_bookmarks') || '{}');
            const btn = document.getElementById('bookmarkBtn');
            if (btn && bookmarks['{{ $post->slug }}']) btn.textContent = '[bookmarked ✓]';
        })();

        // Font size adjuster
        let fontSize = 14;
        function adjustFont(delta) {
            fontSize = Math.max(10, Math.min(22, fontSize + delta));
            document.querySelector('.blog-content').style.fontSize = fontSize + 'px';
        }

        // Comment sorting
        function sortComments(order) {
            const container = document.querySelector('.mt-2');
            const comments = Array.from(container.querySelectorAll(':scope > .ascii-border'));
            if (order === 'newest') comments.reverse();
            comments.forEach(c => c.parentNode.appendChild(c));
        }

        // Auto-save draft comment
        (function () {
            const key = 'fd_draft_{{ $post->slug }}';
            const fields = ['comment_name', 'comment_email', 'comment_content'];
            fields.forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                const saved = localStorage.getItem(key + '_' + id);
                if (saved && !el.value) el.value = saved;
                el.addEventListener('input', () => localStorage.setItem(key + '_' + id, el.value));
            });
            document.querySelector('form[action*="comments"]')?.addEventListener('submit', () => {
                fields.forEach(id => localStorage.removeItem(key + '_' + id));
            });
        })();

        // Markdown toolbar helpers
        function mdWrap(before, after) {
            const t = document.getElementById('comment_content');
            if (!t) return;
            const s = t.selectionStart, e = t.selectionEnd;
            const sel = t.value.substring(s, e);
            t.value = t.value.substring(0, s) + before + sel + after + t.value.substring(e);
            t.focus();
            t.setSelectionRange(s + before.length, s + before.length + sel.length);
        }
        function mdInsert(prefix) {
            const t = document.getElementById('comment_content');
            if (!t) return;
            const s = t.selectionStart;
            t.value = t.value.substring(0, s) + prefix + t.value.substring(s);
            t.focus();
        }

        // @Mention highlighting — style @name in comments
        document.querySelectorAll('[id^="comment-"] p').forEach(p => {
            p.innerHTML = p.innerHTML.replace(/@(\w+)/g, '<span style="color:var(--green);font-weight:bold">@$1</span>');
        });

        // Comment upvote (client-side)
        function upvoteComment(id) {
            const voted = JSON.parse(localStorage.getItem('fd_comment_votes') || '{}');
            if (voted[id]) return;
            const data = JSON.parse(localStorage.getItem('fd_comment_counts') || '{}');
            data[id] = (data[id] || 0) + 1;
            voted[id] = true;
            localStorage.setItem('fd_comment_counts', JSON.stringify(data));
            localStorage.setItem('fd_comment_votes', JSON.stringify(voted));
            loadVotes();
        }
        function loadVotes() {
            const data = JSON.parse(localStorage.getItem('fd_comment_counts') || '{}');
            const voted = JSON.parse(localStorage.getItem('fd_comment_votes') || '{}');
            document.querySelectorAll('[id^="vote-"]').forEach(btn => {
                const id = btn.id.replace('vote-', '');
                const vc = btn.querySelector('.vc');
                if (vc) vc.textContent = data[id] || 0;
                if (voted[id]) btn.style.color = 'var(--green)';
            });
        }
        loadVotes();
    </script>

</x-public-layout>