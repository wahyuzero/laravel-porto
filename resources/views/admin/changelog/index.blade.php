<x-admin-layout pageTitle="Changelog">
    <div class="admin-header">
        <h1>Changelog</h1><a href="{{ route('admin.changelog.create') }}" class="btn btn-primary">+ Add</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Version</th>
                <th>Title</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($changelogs as $c)
                <tr>
                    <td><span class="badge badge-blue">{{ $c->version }}</span></td>
                    <td>{{ $c->title }}</td>
                    <td style="font-size:12px;color:#94a3b8">{{ $c->released_at->format('Y-m-d') }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.changelog.edit', $c) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.changelog.destroy', $c) }}" method="POST"
                            onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin-layout>