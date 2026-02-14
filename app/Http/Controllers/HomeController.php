<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Increment hit counter
        $counter = (int) SiteSetting::get('hit_counter', 0);
        SiteSetting::set('hit_counter', $counter + 1, 'integer');

        // Cache homepage data for 5 minutes
        $data = Cache::remember('homepage_data', 300, function () {
            return [
                'profile' => Profile::first(),
                'projects' => Project::visible()->featured()->ordered()->take(5)->get(),
                'posts' => BlogPost::published()->latest()->take(3)->get(),
                'skills' => Skill::visible()->ordered()->get()->groupBy('category'),
                'experiences' => Experience::visible()->ordered()->take(5)->get(),
                'testimonials' => Testimonial::visible()->ordered()->get(),
                'settings' => SiteSetting::all()->pluck('value', 'key'),
            ];
        });

        return view('home', $data);
    }
}
