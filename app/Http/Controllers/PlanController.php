<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\SiteSetting;

class PlanController extends Controller
{
    public function show()
    {
        $profile = Profile::first();
        $siteName = SiteSetting::get('site_name', 'FrugalDev');

        $plan = "Login: {$profile->user->name}\n";
        $plan .= "Title: {$profile->title}\n";
        $plan .= "Status: {$profile->status_text}\n";
        $plan .= "Building: {$profile->currently_building}\n";
        $plan .= "Reading: {$profile->currently_reading}\n";
        $plan .= "Listening: {$profile->currently_listening}\n";
        $plan .= "\n{$profile->bio}\n";

        return response($plan, 200)->header('Content-Type', 'text/plain');
    }
}
