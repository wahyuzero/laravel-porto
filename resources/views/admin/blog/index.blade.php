<x-admin-layout pageTitle="Blog Posts">
    <div class="admin-header">
        <h1>Blog Posts</h1><a href="{{ route('admin.blog.create') }}" class="btn btn-primary">+ New Post</a>
    </div>

    @if(session('success'))
        <div class="flash-success">✓ {{ session('success') }}</div>
    @endif

    <form id="bulkForm" method="POST" action="{{ route('admin.blog.bulk') }}">
        @csrf
        <div style="display:flex;gap:8px;margin-bottom:12px;align-items:center">
            <label style="font-size:12px"><input type="checkbox" id="selectAll" style="margin-right:4px"> Select
                All</label>
            <select name="action" style="font-size:12px;padding:3px 6px">
                <option value="">-- Bulk Action --</option>
                <option value="publish">Publish</option>
                <option value="unpublish">Unpublish</option>
                <option value="delete">Delete</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline"
                onclick="if(this.form.action.value==='delete')return confirm('Delete selected posts?');return this.form.action.value!==''">Apply</button>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:30px"></th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $p)
                    <tr>
                        <td><input type="checkbox" name="ids[]" value="{{ $p->id }}" class="bulk-check"></td>
                        <td>{{ $p->title }}</td>
                        <td><span
                                class="badge {{ $p->is_published ? 'badge-green' : 'badge-yellow' }}">{{ $p->is_published ? 'published' : 'draft' }}</span>
                        </td>
                        <td>{{ $p->views_count }}</td>
                        <td style="font-size:12px;color:#94a3b8">{{ $p->created_at->format('Y-m-d') }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.blog.edit', $p) }}" class="btn btn-sm btn-outline">Edit</a>
                            <form action="{{ route('admin.blog.destroy', $p) }}" method="POST"
                                onsubmit="return confirm('Delete this post?')">@csrf @method('DELETE')<button
                                    class="btn btn-sm btn-danger">Del</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            document.querySelectorAll('.bulk-check').forEach(cb => cb.checked = this.checked);
        });
    </script>
</x-admin-layout>