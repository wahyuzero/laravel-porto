<x-admin-layout pageTitle="Newsletter Email Preview">
    <div class="admin-header">
        <h1>📧 Email Preview</h1>
        <span class="breadcrumb">admin / newsletter / preview</span>
    </div>

    <div style="margin-bottom:16px">
        <form method="GET" style="display:flex;gap:8px;align-items:center">
            <select name="post_id" class="form-input" style="max-width:300px">
                <option value="">-- Select a post to preview --</option>
                @foreach($posts as $post)
                    <option value="{{ $post->id }}" {{ request('post_id') == $post->id ? 'selected' : '' }}>
                        {{ $post->title }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary" style="padding:6px 16px">Preview</button>
        </form>
    </div>

    @if($preview)
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            {{-- Desktop Preview --}}
            <div>
                <h3 style="color:#94a3b8;font-size:12px;margin-bottom:8px">📱 Desktop Preview</h3>
                <div
                    style="background:#ffffff;border:1px solid #334155;border-radius:8px;overflow:hidden;max-height:600px;overflow-y:auto">
                    <div style="background:#f8fafc;padding:16px 24px;border-bottom:1px solid #e2e8f0">
                        <div style="color:#0f172a;font-size:10px;font-family:monospace">
                            <div><strong>From:</strong> FrugalDev Newsletter &lt;newsletter@frugaldev.io&gt;</div>
                            <div><strong>Subject:</strong> {{ $preview->title }}</div>
                            <div><strong>Date:</strong> {{ now()->format('D, M d, Y H:i') }}</div>
                        </div>
                    </div>
                    <div style="padding:24px;color:#1e293b;font-size:14px;line-height:1.6">
                        <h1 style="color:#0f172a;font-size:20px;margin-bottom:12px">{{ $preview->title }}</h1>
                        @if($preview->excerpt)
                            <p style="color:#64748b;font-style:italic;margin-bottom:16px">{{ $preview->excerpt }}</p>
                        @endif
                        <div style="margin-bottom:16px">
                            {!! $preview->content_html ?: nl2br(e(Str::limit($preview->content_md, 500))) !!}</div>
                        <div style="margin-top:24px;padding-top:16px;border-top:1px solid #e2e8f0">
                            <a href="#"
                                style="display:inline-block;padding:10px 20px;background:#0f172a;color:#ffffff;text-decoration:none;border-radius:4px;font-size:13px">Read
                                Full Post →</a>
                        </div>
                        <div
                            style="margin-top:24px;padding-top:16px;border-top:1px solid #e2e8f0;color:#94a3b8;font-size:11px">
                            <p>You received this because you subscribed to FrugalDev Newsletter.</p>
                            <p><a href="#" style="color:#38bdf8">Unsubscribe</a></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Mobile Preview --}}
            <div>
                <h3 style="color:#94a3b8;font-size:12px;margin-bottom:8px">📱 Mobile Preview (320px)</h3>
                <div
                    style="background:#ffffff;border:1px solid #334155;border-radius:8px;overflow:hidden;max-width:320px;max-height:600px;overflow-y:auto">
                    <div style="background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e2e8f0">
                        <div style="color:#0f172a;font-size:9px;font-family:monospace">
                            <div><strong>Subject:</strong> {{ $preview->title }}</div>
                        </div>
                    </div>
                    <div style="padding:16px;color:#1e293b;font-size:13px;line-height:1.5">
                        <h1 style="color:#0f172a;font-size:16px;margin-bottom:8px">{{ $preview->title }}</h1>
                        @if($preview->excerpt)
                            <p style="color:#64748b;font-style:italic;font-size:12px;margin-bottom:12px">{{ $preview->excerpt }}
                            </p>
                        @endif
                        <div style="font-size:12px">
                            {!! Str::limit(strip_tags($preview->content_html ?: $preview->content_md), 300) !!}</div>
                        <div style="margin-top:16px">
                            <a href="#"
                                style="display:inline-block;padding:8px 16px;background:#0f172a;color:#ffffff;text-decoration:none;border-radius:4px;font-size:12px">Read
                                Full Post →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            style="margin-top:16px;padding:12px;background:#1e293b;border:1px solid #334155;border-radius:6px;font-size:12px;color:#94a3b8">
            💡 This is a preview of how the newsletter email would look when sent to subscribers.
            The actual email would include proper tracking links and unsubscribe URLs.
        </div>
    @else
        <div style="padding:40px;text-align:center;color:#64748b;font-size:14px">
            Select a blog post above to preview it as a newsletter email.
        </div>
    @endif
</x-admin-layout>