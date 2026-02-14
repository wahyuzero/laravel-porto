<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::visible()->ordered()->with('tags')->get();
        $techStacks = $projects->pluck('tech_stack')->flatten()->unique()->sort()->values();
        return view('projects.index', compact('projects', 'techStacks'));
    }

    public function show(string $slug)
    {
        $project = Project::where('slug', $slug)->visible()->with('tags')->firstOrFail();
        $relatedProjects = Project::visible()
            ->where('id', '!=', $project->id)
            ->get()
            ->filter(fn($p) => count(array_intersect($p->tech_stack, $project->tech_stack)) > 0)
            ->take(3);
        return view('projects.show', compact('project', 'relatedProjects'));
    }
}
