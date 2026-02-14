<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;

class AboutController extends Controller
{
    public function index()
    {
        $data = Cache::remember('about_data', 300, function () {
            return [
                'profile' => Profile::first(),
                'skills' => Skill::visible()->ordered()->get()->groupBy('category'),
                'experiences' => Experience::visible()->ordered()->get(),
                'testimonials' => Testimonial::visible()->ordered()->get(),
            ];
        });

        return view('about', $data);
    }
}
