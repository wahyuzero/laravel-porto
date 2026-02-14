<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Profile::firstOrCreate(
            ['user_id' => auth()->id()],
            ['title' => '', 'bio' => '']
        );
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email_public' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:255',
            'status_text' => 'nullable|string|max:255',
            'currently_reading' => 'nullable|string|max:255',
            'currently_building' => 'nullable|string|max:255',
            'currently_listening' => 'nullable|string|max:255',
            'social_github' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_linkedin' => 'nullable|url|max:255',
            'social_website' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:1024',
            'resume' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        try {
            $profile = Profile::where('user_id', auth()->id())->firstOrFail();

            $profile->fill($validated);
            $profile->social_links = array_filter([
                'github' => $request->social_github,
                'twitter' => $request->social_twitter,
                'linkedin' => $request->social_linkedin,
                'website' => $request->social_website,
            ]);

            if ($request->hasFile('avatar')) {
                if ($profile->avatar_path) {
                    Storage::disk('public')->delete($profile->avatar_path);
                }
                $profile->avatar_path = $request->file('avatar')->store('avatars', 'public');
            }

            if ($request->hasFile('resume')) {
                if ($profile->resume_path) {
                    Storage::disk('public')->delete($profile->resume_path);
                }
                $profile->resume_path = $request->file('resume')->store('resumes', 'public');
            }

            $profile->save();

            auth()->user()->update(['display_name' => $request->input('display_name', auth()->user()->name)]);

            return back()->with('success', 'Profile updated.');
        } catch (\Exception $e) {
            Log::error('Profile update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}
