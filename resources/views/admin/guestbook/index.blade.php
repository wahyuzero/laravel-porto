<x-admin-layout pageTitle="Guest Book Moderation">
    <div class="admin-header" style="display:flex;justify-content:space-between;align-items:center">
        <h1>Guest Book</h1>
        <button
            onclick="document.querySelectorAll('.ip-col').forEach(c=>c.style.display=c.style.display==='none'?'':'none')"
            class="btn btn-sm" style="font-size:11px">👁 Toggle IP</button>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nickname</th>
                <th>Message</th>
                <th class="ip-col" style="display:none">IP</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entries as $e)
                <tr>
                    <td>{{ $e->nickname }}</td>
                    <td style="max-width:300px">{{ Str::limit($e->message, 80) }}</td>
                    <td class="ip-col" style="display:none;font-size:10px;font-family:monospace">{{ $e->ip_address ?? '—' }}
                    </td>
                    <td style="font-size:12px;color:#94a3b8">{{ $e->created_at->diffForHumans() }}</td>
                    <td><span
                            class="badge {{ $e->is_approved ? 'badge-green' : 'badge-yellow' }}">{{ $e->is_approved ? 'approved' : 'pending' }}</span>
                    </td>
                    <td class="actions">
                        @unless($e->is_approved)
                            <form action="{{ route('admin.guestbook.approve', $e) }}" method="POST" style="display:inline">@csrf
                                @method('PATCH')<button class="btn btn-sm btn-primary">Approve</button></form>
                        @endunless
                        <form action="{{ route('admin.guestbook.destroy', $e) }}" method="POST"
                            onsubmit="return confirm('Delete?')" style="display:inline">@csrf @method('DELETE')<button
                                class="btn btn-sm btn-danger">Del</button></form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $entries->links() }}
</x-admin-layout>