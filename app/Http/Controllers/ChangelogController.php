<?php

namespace App\Http\Controllers;

use App\Models\Changelog;

class ChangelogController extends Controller
{
    public function index()
    {
        $changelogs = Changelog::latest()->get();
        return view('changelog', compact('changelogs'));
    }
}
