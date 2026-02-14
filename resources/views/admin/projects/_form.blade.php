@php $p = $project ?? null; @endphp
<div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input"
        required value="{{ old('title', $p?->title) }}"></div>
<div class="form-group"><label class="form-label">Description</label><textarea name="description" class="form-input"
        required>{{ old('description', $p?->description) }}</textarea></div>
<div class="form-group"><label class="form-label">Long Description</label><textarea name="long_description"
        class="form-input" rows="6">{{ old('long_description', $p?->long_description) }}</textarea></div>
<div class="form-group"><label class="form-label">Tech Stack (comma-separated)</label><input type="text"
        name="tech_stack" class="form-input" required
        value="{{ old('tech_stack', $p ? implode(', ', $p->tech_stack) : '') }}" placeholder="Laravel, PHP, SQLite">
</div>
<div class="form-group"><label class="form-label">URL</label><input type="url" name="url" class="form-input"
        value="{{ old('url', $p?->url) }}"></div>
<div class="form-group"><label class="form-label">Repository URL</label><input type="url" name="repo_url"
        class="form-input" value="{{ old('repo_url', $p?->repo_url) }}"></div>
<div class="form-group"><label class="form-label">Year</label><input type="number" name="year" class="form-input"
        value="{{ old('year', $p?->year ?? date('Y')) }}" min="2000" max="2030"></div>
<div class="form-group"><label class="form-label">Status</label><select name="status" class="form-input">
        <option value="completed" {{ old('status', $p?->status) === 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="in_progress" {{ old('status', $p?->status) === 'in_progress' ? 'selected' : '' }}>In Progress
        </option>
        <option value="archived" {{ old('status', $p?->status) === 'archived' ? 'selected' : '' }}>Archived</option>
    </select></div>
<div class="form-group"><label class="form-label">Tags (comma-separated)</label><input type="text" name="tags"
        class="form-input" value="{{ old('tags', $p?->tags->pluck('name')->implode(', ')) }}"></div>
<div class="form-group"><label class="form-check"><input type="checkbox" name="featured" value="1" {{ old('featured', $p?->featured) ? 'checked' : '' }}> Featured</label></div>
<div class="form-group"><label class="form-label">Screenshot</label><input type="file" name="screenshot"
        class="form-input" accept="image/*"></div>