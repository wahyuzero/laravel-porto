<x-admin-layout pageTitle="Edit Testimonial">
    <div class="admin-header">
        <h1>Edit Testimonial</h1>
    </div>
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" style="max-width:600px">@csrf
        @method('PUT')
        <div class="form-group"><label class="form-label">Name</label><input type="text" name="name" class="form-input"
                required value="{{ old('name', $testimonial->name) }}"></div>
        <div class="form-group"><label class="form-label">Role</label><input type="text" name="role" class="form-input"
                value="{{ old('role', $testimonial->role) }}"></div>
        <div class="form-group"><label class="form-label">Company</label><input type="text" name="company"
                class="form-input" value="{{ old('company', $testimonial->company) }}"></div>
        <div class="form-group"><label class="form-label">Content</label><textarea name="content" class="form-input"
                required>{{ old('content', $testimonial->content) }}</textarea></div>
        <div class="form-group"><label class="form-label">Sort Order</label><input type="number" name="sort_order"
                class="form-input" value="{{ old('sort_order', $testimonial->sort_order) }}"></div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-admin-layout>