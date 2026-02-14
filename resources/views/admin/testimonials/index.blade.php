<x-admin-layout pageTitle="Testimonials">
    <div class="admin-header">
        <h1>Testimonials</h1><a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">+ Add</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Quote</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $t)
                <tr>
                    <td>{{ $t->name }}</td>
                    <td style="color:#94a3b8">{{ $t->role }} @ {{ $t->company }}</td>
                    <td style="max-width:300px">{{ Str::limit($t->content, 80) }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-sm btn-outline">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $t) }}" method="POST"
                            onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-admin-layout>