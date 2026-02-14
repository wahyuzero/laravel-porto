<x-admin-layout pageTitle="Data Export">
    <h2>Data Export</h2>
    <p style="color:#94a3b8;margin-bottom:24px">Download your data as CSV files.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px">
        <div class="card">
            <h3>📝 Blog Posts</h3>
            <p style="font-size:12px;color:#94a3b8;margin:8px 0">All posts with metadata</p>
            <a href="{{ route('admin.export.download', ['type' => 'blog']) }}" class="btn btn-sm btn-outline">↓ Download
                CSV</a>
        </div>
        <div class="card">
            <h3>🗂️ Projects</h3>
            <p style="font-size:12px;color:#94a3b8;margin:8px 0">All projects with tech stack</p>
            <a href="{{ route('admin.export.download', ['type' => 'projects']) }}" class="btn btn-sm btn-outline">↓
                Download CSV</a>
        </div>
        <div class="card">
            <h3>💬 Comments</h3>
            <p style="font-size:12px;color:#94a3b8;margin:8px 0">All comments with status</p>
            <a href="{{ route('admin.export.download', ['type' => 'comments']) }}" class="btn btn-sm btn-outline">↓
                Download CSV</a>
        </div>
        <div class="card">
            <h3>📬 Subscribers</h3>
            <p style="font-size:12px;color:#94a3b8;margin:8px 0">Newsletter subscribers</p>
            <a href="{{ route('admin.export.download', ['type' => 'subscribers']) }}" class="btn btn-sm btn-outline">↓
                Download CSV</a>
        </div>
        <div class="card">
            <h3>📈 Analytics</h3>
            <p style="font-size:12px;color:#94a3b8;margin:8px 0">Last 1000 page views</p>
            <a href="{{ route('admin.export.download', ['type' => 'analytics']) }}" class="btn btn-sm btn-outline">↓
                Download CSV</a>
        </div>
    </div>
</x-admin-layout>