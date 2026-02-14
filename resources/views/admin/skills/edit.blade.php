<x-admin-layout pageTitle="Edit Skill">
    <div class="admin-header">
        <h1>Edit: {{ $skill->name }}</h1>
    </div>
    <form action="{{ route('admin.skills.update', $skill) }}" method="POST" style="max-width:500px">@csrf @method('PUT')
        <div class="form-group"><label class="form-label">Name</label><input type="text" name="name" class="form-input"
                required value="{{ old('name', $skill->name) }}"></div>
        <div class="form-group"><label class="form-label">Category</label><input type="text" name="category"
                class="form-input" required value="{{ old('category', $skill->category) }}"></div>
        <div class="form-group"><label class="form-label">Level (1-5)</label><input type="number" name="level"
                class="form-input" min="1" max="5" value="{{ old('level', $skill->level) }}"></div>
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order"
                class="form-input" value="{{ old('sort_order', $skill->sort_order) }}"></div>
        <button type="submit" class="btn btn-primary">Update Skill</button>
    </form>
</x-admin-layout>