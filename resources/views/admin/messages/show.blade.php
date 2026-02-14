<x-admin-layout pageTitle="Message">
    <div class="admin-header">
        <h1>Message from {{ $message->name }}</h1>
    </div>
    <div style="background:#1e293b;border:1px solid #334155;padding:16px;border-radius:6px;max-width:700px">
        <div style="font-size:13px;color:#94a3b8;margin-bottom:12px">
            <strong>From:</strong> {{ $message->name }} &lt;{{ $message->email }}&gt;<br>
            <strong>Subject:</strong> {{ $message->subject ?: '(none)' }}<br>
            <strong>Date:</strong> {{ $message->created_at->format('Y-m-d H:i') }}<br>
            <strong>IP:</strong> {{ $message->ip_address }}
        </div>
        <div style="white-space:pre-wrap;font-size:14px">{{ $message->message }}</div>
    </div>
    <div style="margin-top:16px">
        <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" class="btn btn-primary">Reply via
            Email</a>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-outline" style="margin-left:8px">Back</a>
    </div>
</x-admin-layout>