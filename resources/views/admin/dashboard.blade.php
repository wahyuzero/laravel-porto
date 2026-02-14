<x-admin-layout pageTitle="Dashboard">
    <div class="admin-header">
        <h1>Dashboard</h1>
        <span class="breadcrumb">admin / dashboard</span>
    </div>

    <div class="stat-grid">
        <div class="stat-card">
            <div class="label">Projects</div>
            <div class="value">{{ $stats['projects'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Published Posts</div>
            <div class="value">{{ $stats['blog_posts'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Drafts</div>
            <div class="value">{{ $stats['drafts'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Unread Messages</div>
            <div class="value" style="color:#fca5a5">{{ $stats['unread_messages'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Total Blog Views</div>
            <div class="value">{{ $stats['total_views'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Guest Book Pending</div>
            <div class="value">{{ $stats['guestbook_pending'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Hit Counter</div>
            <div class="value" style="color:#6ee7b7">{{ $stats['hit_counter'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Subscribers</div>
            <div class="value" style="color:#a78bfa">{{ $stats['subscribers'] }}</div>
        </div>
        <div class="stat-card">
            <div class="label">Comments</div>
            <div class="value">{{ $stats['comments'] }}</div>
        </div>
    </div>

    {{-- Page Views Chart --}}
    <div style="margin:24px 0;background:#1e293b;border-radius:8px;padding:20px;border:1px solid #334155">
        <h3 style="font-size:14px;color:#94a3b8;margin-bottom:16px">📊 Page Views (Last 7 Days)</h3>
        <div style="display:flex;align-items:flex-end;gap:8px;height:120px">
            @php
                $maxViews = max(array_column($chartData, 'views')) ?: 1;
            @endphp
            @foreach($chartData as $day)
                @php $pct = ($day['views'] / $maxViews) * 100; @endphp
                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px">
                    <span style="font-size:10px;color:#94a3b8">{{ $day['views'] }}</span>
                    <div
                        style="width:100%;background:#38bdf8;border-radius:4px 4px 0 0;min-height:4px;height:{{ max(4, $pct) }}%;transition:height 0.3s">
                    </div>
                    <span style="font-size:9px;color:#64748b">{{ $day['label'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
        <div>
            <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Recent Messages</h3>
            @forelse($recent_messages as $msg)
                <div style="padding:8px;border-bottom:1px solid #1e293b;font-size:13px">
                    <a href="{{ route('admin.messages.show', $msg) }}"
                        style="color:#38bdf8;text-decoration:none">{{ $msg->name }}</a>
                    <span style="color:#64748b">— {{ Str::limit($msg->message, 60) }}</span>
                    <div style="font-size:11px;color:#475569">{{ $msg->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p style="color:#64748b;font-size:13px">No messages yet.</p>
            @endforelse
        </div>
        <div>
            <h3 style="margin-bottom:12px;font-size:14px;color:#94a3b8">Recent Posts</h3>
            @forelse($recent_posts as $post)
                <div style="padding:8px;border-bottom:1px solid #1e293b;font-size:13px">
                    <a href="{{ route('admin.blog.edit', $post) }}"
                        style="color:#38bdf8;text-decoration:none">{{ $post->title }}</a>
                    <span
                        class="badge {{ $post->is_published ? 'badge-green' : 'badge-yellow' }}">{{ $post->is_published ? 'published' : 'draft' }}</span>
                    <div style="font-size:11px;color:#475569">{{ $post->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p style="color:#64748b;font-size:13px">No posts yet.</p>
            @endforelse
        </div>
    </div>
</x-admin-layout>