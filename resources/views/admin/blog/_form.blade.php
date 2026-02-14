@php $p = $post ?? null; @endphp
<div class="form-group"><label class="form-label">Title</label><input type="text" name="title" class="form-input"
                required value="{{ old('title', $p?->title) }}"></div>
<div class="form-group"><label class="form-label">Content (Markdown)</label><textarea name="content_md"
                class="form-input" rows="15" required
                style="font-family:monospace">{{ old('content_md', $p?->content_md) }}</textarea>
        <div class="form-hint">Write in Markdown. HTML will be generated automatically via league/commonmark.</div>
</div>
<div class="form-group"><label class="form-label">Excerpt</label><textarea name="excerpt" class="form-input"
                rows="2">{{ old('excerpt', $p?->excerpt) }}</textarea></div>
<div class="form-group"><label class="form-label">Tags (comma-separated)</label><input type="text" name="tags"
                class="form-input" value="{{ old('tags', $p?->tags->pluck('name')->implode(', ')) }}"></div>
<div class="form-group"><label class="form-label">Schedule Publish</label><input type="datetime-local"
                name="scheduled_at" class="form-input"
                value="{{ old('scheduled_at', $p?->scheduled_at?->format('Y-m-d\TH:i')) }}">
        <div class="form-hint">Leave empty to publish immediately when "Published" is checked. If set, the post will
                auto-publish at this time.</div>
</div>
<div class="form-group"><label class="form-check"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $p?->is_published) ? 'checked' : '' }}> Published</label></div>

@if($p)
        <div style="margin-top:12px">
                <a href="{{ route('admin.blog.show', $p) }}" class="btn btn-outline" target="_blank"
                        style="font-size:12px">Preview Draft →</a>
        </div>
@endif