<x-admin-layout pageTitle="Messages">
    <div class="admin-header">
        <h1>Contact Messages</h1>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th></th>
                <th>From</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $m)
                <tr style="{{ !$m->is_read ? 'font-weight:bold' : '' }}">
                    <td>{{ $m->is_read ? '📭' : '📬' }}</td>
                    <td>{{ $m->name }} <span style="color:#64748b">&lt;{{ $m->email }}&gt;</span></td>
                    <td>{{ $m->subject ?: '(no subject)' }}</td>
                    <td style="font-size:12px;color:#94a3b8">{{ $m->created_at->diffForHumans() }}</td>
                    <td class="actions">
                        <a href="{{ route('admin.messages.show', $m) }}" class="btn btn-sm btn-outline">Read</a>
                        <form action="{{ route('admin.messages.destroy', $m) }}" method="POST"
                            onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $messages->links() }}
</x-admin-layout>