<x-admin-layout>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
        <h2>Comments Moderation</h2>
        <span class="badge">{{ $comments->total() }} total</span>
    </div>

    @if(session('success'))
        <div class="flash-success">✓ {{ session('success') }}</div>
    @endif

    <form id="bulkForm" method="POST" action="{{ route('admin.comments.bulk') }}">
        @csrf
        <div style="display:flex;gap:8px;margin-bottom:12px;align-items:center">
            <label style="font-size:12px"><input type="checkbox" id="selectAll" style="margin-right:4px"> Select
                All</label>
            <select name="action" style="font-size:12px;padding:3px 6px">
                <option value="">-- Bulk Action --</option>
                <option value="approve">Approve</option>
                <option value="delete">Delete</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline"
                onclick="if(this.form.action.value==='delete')return confirm('Delete selected comments?');return this.form.action.value!==''">Apply</button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:30px"></th>
                    <th>Author</th>
                    <th>Post</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $comment->id }}" class="bulk-check"></td>
                        <td>
                            <strong>{{ $comment->author_name }}</strong><br>
                            <small style="color:#888">{{ $comment->author_email }}</small>
                        </td>
                        <td>
                            @if($comment->blogPost)
                                <a href="{{ route('blog.show', $comment->blogPost->slug) }}" target="_blank">
                                    {{ Str::limit($comment->blogPost->title, 30) }}
                                </a>
                            @else
                                <em style="color:#888">deleted post</em>
                            @endif
                        </td>
                        <td>{{ Str::limit($comment->content, 80) }}</td>
                        <td>
                            @if($comment->is_approved)
                                <span style="color:#22c55e">✓ approved</span>
                            @else
                                <span style="color:#f59e0b">⏳ pending</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('M d, H:i') }}</td>
                        <td style="white-space:nowrap">
                            @unless($comment->is_approved)
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST"
                                    style="display:inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-sm btn-success">Approve</button>
                                </form>
                            @endunless
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST"
                                style="display:inline" onsubmit="return confirm('Delete this comment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;color:#888">No comments yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>

    <div style="margin-top:16px">{{ $comments->links() }}</div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            document.querySelectorAll('.bulk-check').forEach(cb => cb.checked = this.checked);
        });
    </script>
</x-admin-layout>