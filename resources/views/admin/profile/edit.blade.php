<x-admin-layout pageTitle="Edit Profile">
    <div class="admin-header">
        <h1>Profile</h1>
        <span class="breadcrumb"><a href="{{ route('admin.dashboard') }}">admin</a> / profile</span>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
        style="max-width:700px">
        @csrf @method('PUT')

        <div class="form-group">
            <label class="form-label">Display Name</label>
            <input type="text" name="display_name" class="form-input"
                value="{{ old('display_name', auth()->user()->display_name ?? auth()->user()->name) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-input" value="{{ old('title', $profile->title) }}"
                placeholder="Full Stack Developer">
        </div>
        <div class="form-group">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-input" rows="5">{{ old('bio', $profile->bio) }}</textarea>
        </div>
        <div class="form-group">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-input" value="{{ old('location', $profile->location) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Public Email</label>
            <input type="email" name="email_public" class="form-input"
                value="{{ old('email_public', $profile->email_public) }}">
        </div>

        <h3 style="color:#94a3b8;font-size:14px;margin:20px 0 12px">Status / Now</h3>
        <div class="form-group">
            <label class="form-label">Status Text</label>
            <input type="text" name="status_text" class="form-input"
                value="{{ old('status_text', $profile->status_text) }}" placeholder="Available for hire">
        </div>
        <div class="form-group">
            <label class="form-label">Currently Building</label>
            <input type="text" name="currently_building" class="form-input"
                value="{{ old('currently_building', $profile->currently_building) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Currently Reading</label>
            <input type="text" name="currently_reading" class="form-input"
                value="{{ old('currently_reading', $profile->currently_reading) }}">
        </div>
        <div class="form-group">
            <label class="form-label">Currently Listening</label>
            <input type="text" name="currently_listening" class="form-input"
                value="{{ old('currently_listening', $profile->currently_listening) }}">
        </div>

        <h3 style="color:#94a3b8;font-size:14px;margin:20px 0 12px">Social Links</h3>
        <div class="form-group">
            <label class="form-label">GitHub URL</label>
            <input type="url" name="social_github" class="form-input"
                value="{{ old('social_github', $profile->social_links['github'] ?? '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Twitter URL</label>
            <input type="url" name="social_twitter" class="form-input"
                value="{{ old('social_twitter', $profile->social_links['twitter'] ?? '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">LinkedIn URL</label>
            <input type="url" name="social_linkedin" class="form-input"
                value="{{ old('social_linkedin', $profile->social_links['linkedin'] ?? '') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Website URL</label>
            <input type="url" name="social_website" class="form-input"
                value="{{ old('social_website', $profile->social_links['website'] ?? '') }}">
        </div>

        <h3 style="color:#94a3b8;font-size:14px;margin:20px 0 12px">Files</h3>
        <div class="form-group">
            <label class="form-label">Avatar</label>
            <input type="file" name="avatar" class="form-input" accept="image/*">
            @if($profile->avatar_path)
            <div class="form-hint">Current: {{ $profile->avatar_path }}</div>@endif
        </div>
        <div class="form-group">
            <label class="form-label">Resume (PDF)</label>
            <input type="file" name="resume" class="form-input" accept=".pdf">
            @if($profile->resume_path)
            <div class="form-hint">Current: {{ $profile->resume_path }}</div>@endif
        </div>

        <button type="submit" class="btn btn-primary">Save Profile</button>
    </form>
</x-admin-layout>