<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.projects.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'required|string',
            'url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'year' => 'nullable|integer|min:2000|max:2030',
            'status' => 'required|in:completed,in_progress,archived',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'tags' => 'nullable|string',
        ]);

        try {
            $validated['slug'] = Str::slug($validated['title']);
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
            $validated['featured'] = $request->boolean('featured');

            if ($request->hasFile('screenshot')) {
                $validated['screenshot_path'] = $request->file('screenshot')->store('projects', 'public');
            }

            $project = Project::create($validated);
            $this->syncTags($project, $request->input('tags', ''));

            return redirect()->route('admin.projects.index')->with('success', 'Project created.');
        } catch (\Exception $e) {
            Log::error('Project creation failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create project: ' . $e->getMessage());
        }
    }

    public function edit(Project $project)
    {
        $tags = Tag::orderBy('name')->get();
        return view('admin.projects.edit', compact('project', 'tags'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'long_description' => 'nullable|string',
            'tech_stack' => 'required|string',
            'url' => 'nullable|url|max:255',
            'repo_url' => 'nullable|url|max:255',
            'featured' => 'boolean',
            'year' => 'nullable|integer|min:2000|max:2030',
            'status' => 'required|in:completed,in_progress,archived',
            'screenshot' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'tags' => 'nullable|string',
        ]);

        try {
            $validated['slug'] = Str::slug($validated['title']);
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
            $validated['featured'] = $request->boolean('featured');

            if ($request->hasFile('screenshot')) {
                // Delete old screenshot
                if ($project->screenshot_path) {
                    Storage::disk('public')->delete($project->screenshot_path);
                }
                $validated['screenshot_path'] = $request->file('screenshot')->store('projects', 'public');
            }

            $project->update($validated);
            $this->syncTags($project, $request->input('tags', ''));

            return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
        } catch (\Exception $e) {
            Log::error('Project update failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update project: ' . $e->getMessage());
        }
    }

    public function destroy(Project $project)
    {
        try {
            if ($project->screenshot_path) {
                Storage::disk('public')->delete($project->screenshot_path);
            }
            $project->tags()->detach();
            $project->delete();
            return redirect()->route('admin.projects.index')->with('success', 'Project deleted.');
        } catch (\Exception $e) {
            Log::error('Project deletion failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to delete project.');
        }
    }

    private function syncTags(Project $project, string $tagsString): void
    {
        $tagNames = array_filter(array_map('trim', explode(',', $tagsString)));
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
            $tagIds[] = $tag->id;
        }
        $project->tags()->sync($tagIds);
    }
}
