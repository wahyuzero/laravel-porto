<x-admin-layout pageTitle="Edit Post">
    <div class="admin-header">
        <h1>Edit: {{ $post->title }}</h1>
    </div>
    <form action="{{ route('admin.blog.update', $post) }}" method="POST" style="max-width:700px">@csrf @method('PUT')
        @include('admin.blog._form', ['post' => $post])
        <button type="submit" class="btn btn-primary">Update Post</button>
    </form>
</x-admin-layout>