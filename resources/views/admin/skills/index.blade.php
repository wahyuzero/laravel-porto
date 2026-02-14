<x-admin-layout pageTitle="Skills">
    <div class="admin-header">
        <h1>Skills</h1><a href="{{ route('admin.skills.create') }}" class="btn btn-primary">+ Add Skill</a>
    </div>
    @foreach($skills as $category => $items)
        <h3 style="color:#94a3b8;font-size:13px;margin:16px 0 8px">{{ $category }}</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Bar</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $s)
                    <tr>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->level }}/5</td>
                        <td style="font-family:monospace;color:#6ee7b7">{{ $s->level_bar }}</td>
                        <td class="actions">
                            <a href="{{ route('admin.skills.edit', $s) }}" class="btn btn-sm btn-outline">Edit</a>
                            <form action="{{ route('admin.skills.destroy', $s) }}" method="POST"
                                onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                    class="btn btn-sm btn-danger">Del</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</x-admin-layout>