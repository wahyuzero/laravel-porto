<x-admin-layout pageTitle="Add Changelog">
    <div class="admin-header">
        <h1>Add Changelog Entry</h1>
    </div>
    <form action="{{ route('admin.changelog.store') }}" method="POST" style="max-width:600px">@csrf
        <div class="form-group"><label class="form-label">Version</label><input type="text" name="version"
                class="form-input" required value="{{ old('version') }}" placeholder="1.0.0"></div>
        <div class="form-group"><label class="form-label">Title</label><input type="text" name="title"
                class="form-input" required value="{{ old('title') }}"></div>
        <div class="form-group"><label class="form-label">Content</label><textarea name="content" class="form-input"
                rows="6" required>{{ old('content') }}</textarea></div>
        <div class="form-group"><label class="form-label">Release Date</label><input type="date" name="released_at"
                class="form-input" required value="{{ old('released_at', date('Y-m-d')) }}"></div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</x-admin-layout>