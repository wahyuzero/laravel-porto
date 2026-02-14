<x-admin-layout pageTitle="New Project">
    <div class="admin-header">
        <h1>New Project</h1>
    </div>
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data"
        style="max-width:700px">
        @csrf
        @include('admin.projects._form')
        <button type="submit" class="btn btn-primary">Create Project</button>
    </form>
</x-admin-layout>