<x-admin-layout pageTitle="Add Experience">
    <div class="admin-header">
        <h1>Add Experience</h1>
    </div>
    <form action="{{ route('admin.experiences.store') }}" method="POST" style="max-width:600px">@csrf
        @include('admin.experiences._form')
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</x-admin-layout>