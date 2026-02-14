<x-admin-layout pageTitle="Projects">
    <div class="admin-header">
        <h1>Projects</h1>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-primary">+ New Project</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Tech</th>
                <th>Year</th>
                <th>Status</th>
                <th>Featured</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $p)
                <tr>
                    <td>{{ $p->title }}</td>
                    <td style="font-size:11px;color:#94a3b8">{{ implode(', ', $p->tech_stack) }}</td>
                    <td>{{ $p->year }}</td>
                    <td><span
                            class="badge {{ $p->status === 'completed' ? 'badge-green' : ($p->status === 'in_progress' ? 'badge-yellow' : 'badge-blue') }}">{{ $p->status }}</span>
                    </td>
                    <td>{{ $p->featured ? '⭐' : '' }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.projects.edit', $p) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $p) }}" method="POST"
                            onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin-layout>