<x-admin-layout pageTitle="Edit Project">
    <div class="admin-header">
        <h1>Edit: {{ $project->title }}</h1>
    </div>
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data"
        style="max-width:700px">
        @csrf @method('PUT')
        @include('admin.projects._form', ['project' => $project])
        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</x-admin-layout>