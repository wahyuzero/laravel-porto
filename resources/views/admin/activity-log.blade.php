<x-admin-layout pageTitle="Activity Log">
    <div class="admin-header">
        <h1>Activity Log</h1>
        <span class="breadcrumb">admin / activity-log</span>
    </div>

    <div style="background:#1e293b;border-radius:8px;border:1px solid #334155;overflow:hidden">
        <table style="width:100%;border-collapse:collapse;font-size:13px">
            <thead>
                <tr style="border-bottom:1px solid #334155">
                    <th style="padding:10px 16px;text-align:left;color:#94a3b8;font-weight:500">Action</th>
                    <th style="padding:10px 16px;text-align:left;color:#94a3b8;font-weight:500">Description</th>
                    <th style="padding:10px 16px;text-align:left;color:#94a3b8;font-weight:500">User</th>
                    <th style="padding:10px 16px;text-align:left;color:#94a3b8;font-weight:500">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr style="border-bottom:1px solid #1e293b">
                        <td style="padding:8px 16px">
                            <span
                                class="badge {{ $log->action === 'create' ? 'badge-green' : ($log->action === 'delete' ? 'badge-red' : 'badge-yellow') }}">{{ $log->action }}</span>
                        </td>
                        <td style="padding:8px 16px;color:#e2e8f0">{{ $log->description }}</td>
                        <td style="padding:8px 16px;color:#94a3b8">{{ $log->user?->name ?? 'system' }}</td>
                        <td style="padding:8px 16px;color:#64748b;font-size:11px">{{ $log->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:24px;text-align:center;color:#64748b">No activity logs yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div style="margin-top:16px;display:flex;gap:8px;justify-content:center">
            {{ $logs->links() }}
        </div>
    @endif
</x-admin-layout>