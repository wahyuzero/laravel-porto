<x-admin-layout pageTitle="Edit Experience">
    <div class="admin-header">
        <h1>Edit: {{ $experience->title }}</h1>
    </div>
    <form action="{{ route('admin.experiences.update', $experience) }}" method="POST" style="max-width:600px">@csrf
        @method('PUT')
        @include('admin.experiences._form', ['exp' => $experience])
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</x-admin-layout>