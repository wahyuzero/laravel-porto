<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'site_name' => 'string',
            'site_tagline' => 'string',
            'site_description' => 'text',
            'footer_text' => 'string',
            'ascii_banner' => 'text',
        ];

        foreach ($fields as $key => $type) {
            if ($request->has($key)) {
                SiteSetting::set($key, $request->input($key), $type);
            }
        }

        return back()->with('success', 'Settings updated.');
    }
}
