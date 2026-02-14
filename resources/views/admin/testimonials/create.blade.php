<x-admin-layout pageTitle="Add Testimonial">
    <div class="admin-header">
        <h1>Add Testimonial</h1>
    </div>
    <form action="{{ route('admin.testimonials.store') }}" method="POST" style="max-width:600px">@csrf
        <div class="form-group"><label class="form-label">Name</label><input type="text" name="name" class="form-input"
                required value="{{ old('name') }}"></div>
        <div class="form-group"><label class="form-label">Role</label><input type="text" name="role" class="form-input"
                value="{{ old('role') }}"></div>
        <div class="form-group"><label class="form-label">Company</label><input type="text" name="company"
                class="form-input" value="{{ old('company') }}"></div>
        <div class="form-group"><label class="form-label">Content</label><textarea name="content" class="form-input"
                required>{{ old('content') }}</textarea></div>
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order"
                class="form-input" value="{{ old('sort_order', 0) }}"></div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</x-admin-layout>