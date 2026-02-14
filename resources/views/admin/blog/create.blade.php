<x-admin-layout pageTitle="New Post">
    <div class="admin-header">
        <h1>New Post</h1>
    </div>
    <form action="{{ route('admin.blog.store') }}" method="POST" style="max-width:700px">@csrf
        @include('admin.blog._form')
        <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</x-admin-layout>