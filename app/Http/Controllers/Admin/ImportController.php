<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Project;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    public function index()
    {
        return view('admin.import');
    }

    public function process(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json,csv,txt|max:5120',
            'type' => 'required|in:blog,projects',
        ]);

        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        $content = file_get_contents($file->getRealPath());
        $imported = 0;

        try {
            if ($ext === 'json') {
                $items = json_decode($content, true);
                if (!$items)
                    throw new \Exception('Invalid JSON');
            } else {
                // CSV parse
                $lines = array_filter(explode("\n", $content));
                $headers = str_getcsv(array_shift($lines));
                $items = array_map(fn($line) => array_combine($headers, str_getcsv($line)), $lines);
            }

            foreach ($items as $item) {
                if ($request->type === 'blog') {
                    BlogPost::updateOrCreate(
                        ['slug' => Str::slug($item['title'] ?? '')],
                        [
                            'title' => $item['title'] ?? 'Untitled',
                            'slug' => Str::slug($item['title'] ?? 'untitled'),
                            'content_md' => $item['content'] ?? $item['content_md'] ?? '',
                            'content_html' => $item['content_html'] ?? '',
                            'excerpt' => $item['excerpt'] ?? Str::limit($item['content'] ?? '', 150),
                            'is_published' => $item['is_published'] ?? false,
                        ]
                    );
                    $imported++;
                } elseif ($request->type === 'projects') {
                    Project::updateOrCreate(
                        ['slug' => Str::slug($item['title'] ?? '')],
                        [
                            'title' => $item['title'] ?? 'Untitled',
                            'slug' => Str::slug($item['title'] ?? 'untitled'),
                            'description' => $item['description'] ?? '',
                            'long_description' => $item['long_description'] ?? '',
                            'status' => $item['status'] ?? 'active',
                        ]
                    );
                    $imported++;
                }
            }

            ActivityLog::log('import', "Imported {$imported} {$request->type} from {$ext} file");

            return back()->with('success', "Imported {$imported} {$request->type} successfully.");
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
