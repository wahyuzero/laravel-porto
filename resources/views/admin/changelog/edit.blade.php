<x-admin-layout pageTitle="Edit Changelog">
    <div class="admin-header">
        <h1>Edit: {{ $changelog->version }}</h1>
    </div>
    <form action="{{ route('admin.changelog.update', $changelog) }}" method="POST" style="max-width:600px">@csrf
        @method('PUT')
        <div class="form-group"><label class="form-label">Version</label><input type="text" name="version"
                class="form-input" required value="{{ old('version', $changelog->version) }}"></div>
        <div class="form-group"><label class="form-label">Title</label><input type="text" name="title"
                class="form-input" required value="{{ old('title', $changelog->title) }}"></div>
        <div class="form-group"><label class="form-label">Content</label><textarea name="content" class="form-input"
                rows="6" required>{{ old('content', $changelog->content) }}</textarea></div>
        <div class="form-group"><label class="form-label">Release Date</label><input type="date" name="released_at"
                class="form-input" required value="{{ old('released_at', $changelog->released_at->format('Y-m-d')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-admin-layout>