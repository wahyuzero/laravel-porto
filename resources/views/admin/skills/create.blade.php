<x-admin-layout pageTitle="Add Skill">
    <div class="admin-header">
        <h1>Add Skill</h1>
    </div>
    <form action="{{ route('admin.skills.store') }}" method="POST" style="max-width:500px">@csrf
        <div class="form-group"><label class="form-label">Name</label><input type="text" name="name" class="form-input"
                required value="{{ old('name') }}"></div>
        <div class="form-group"><label class="form-label">Category</label><input type="text" name="category"
                class="form-input" required value="{{ old('category') }}"
                placeholder="Languages, Frameworks, Tools, Databases"></div>
        <div class="form-group"><label class="form-label">Level (1-5)</label><input type="number" name="level"
                class="form-input" min="1" max="5" value="{{ old('level', 3) }}"></div>
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order"
                class="form-input" value="{{ old('sort_order', 0) }}"></div>
        <button type="submit" class="btn btn-primary">Add Skill</button>
    </form>
</x-admin-layout>