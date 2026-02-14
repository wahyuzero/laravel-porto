<x-admin-layout pageTitle="Experience">
    <div class="admin-header">
        <h1>Experience</h1><a href="{{ route('admin.experiences.create') }}" class="btn btn-primary">+ Add</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Organization</th>
                <th>Type</th>
                <th>Period</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($experiences as $e)
                <tr>
                    <td>{{ $e->title }}</td>
                    <td>{{ $e->organization }}</td>
                    <td><span class="badge badge-blue">{{ $e->type }}</span></td>
                    <td style="font-size:12px;color:#94a3b8">{{ $e->duration }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.experiences.edit', $e) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.experiences.destroy', $e) }}" method="POST"
                            onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin-layout>