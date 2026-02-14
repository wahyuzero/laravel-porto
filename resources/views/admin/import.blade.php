<x-admin-layout pageTitle="Import Data">
    <div class="admin-header">
        <h1>📥 Import Data</h1>
        <span class="breadcrumb">admin / import</span>
    </div>

    @if(session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
    @endif

    <div style="background:#1e293b;border:1px solid #334155;border-radius:8px;padding:24px;max-width:500px">
        <form action="{{ route('admin.import.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom:16px">
                <label style="display:block;color:#94a3b8;font-size:13px;margin-bottom:6px">Import Type</label>
                <select name="type" class="retro-input"
                    style="width:100%;padding:8px;background:#0f172a;color:#e2e8f0;border:1px solid #334155;border-radius:4px">
                    <option value="blog">Blog Posts</option>
                    <option value="projects">Projects</option>
                </select>
            </div>
            <div style="margin-bottom:16px">
                <label style="display:block;color:#94a3b8;font-size:13px;margin-bottom:6px">File (JSON or CSV, max
                    5MB)</label>
                <input type="file" name="file" accept=".json,.csv,.txt" required style="color:#e2e8f0;font-size:13px">
            </div>
            <div
                style="margin-bottom:16px;padding:12px;background:#0f172a;border-radius:4px;font-size:11px;color:#64748b">
                <strong style="color:#94a3b8">JSON format:</strong> [{"title":"...","content":"..."}]<br>
                <strong style="color:#94a3b8">CSV format:</strong> title,content,excerpt (first row = headers)
            </div>
            <button type="submit" class="btn-primary"
                style="padding:8px 20px;background:#38bdf8;color:#0f172a;border:none;border-radius:4px;cursor:pointer;font-weight:600">
                Import
            </button>
        </form>
    </div>
</x-admin-layout>