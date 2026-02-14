@php $e = $exp ?? null; @endphp
<div class="form-group"><label class="form-label">Type</label><select name="type" class="form-input">
        <option value="work" {{ old('type', $e?->type) === 'work' ? 'selected' : '' }}>Work</option>
        <option value="education" {{ old('type', $e?->type) === 'education' ? 'selected' : '' }}>Education</option>
    </select></div>
<div class="form-group"><label class="form-label">Title / Position</label><input type="text" name="title"
        class="form-input" required value="{{ old('title', $e?->title) }}"></div>
<div class="form-group"><label class="form-label">Organization</label><input type="text" name="organization"
        class="form-input" required value="{{ old('organization', $e?->organization) }}"></div>
<div class="form-group"><label class="form-label">Location</label><input type="text" name="location" class="form-input"
        value="{{ old('location', $e?->location) }}"></div>
<div class="form-group"><label class="form-label">Start Date</label><input type="date" name="start_date"
        class="form-input" required value="{{ old('start_date', $e?->start_date?->format('Y-m-d')) }}"></div>
<div class="form-group"><label class="form-label">End Date (empty = current)</label><input type="date" name="end_date"
        class="form-input" value="{{ old('end_date', $e?->end_date?->format('Y-m-d')) }}"></div>
<div class="form-group"><label class="form-label">Description</label><textarea name="description"
        class="form-input">{{ old('description', $e?->description) }}</textarea></div>