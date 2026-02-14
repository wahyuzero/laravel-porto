<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Changelog;
use Illuminate\Http\Request;

class ChangelogController extends Controller
{
    public function index()
    {
        $changelogs = Changelog::latest()->get();
        return view('admin.changelog.index', compact('changelogs'));
    }

    public function create()
    {
        return view('admin.changelog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'released_at' => 'required|date',
        ]);

        Changelog::create($validated);
        return redirect()->route('admin.changelog.index')->with('success', 'Changelog added.');
    }

    public function edit(Changelog $changelog)
    {
        return view('admin.changelog.edit', compact('changelog'));
    }

    public function update(Request $request, Changelog $changelog)
    {
        $validated = $request->validate([
            'version' => 'required|string|max:20',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'released_at' => 'required|date',
        ]);

        $changelog->update($validated);
        return redirect()->route('admin.changelog.index')->with('success', 'Changelog updated.');
    }

    public function destroy(Changelog $changelog)
    {
        $changelog->delete();
        return redirect()->route('admin.changelog.index')->with('success', 'Changelog deleted.');
    }
}
