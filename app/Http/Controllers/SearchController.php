<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', '');
        $posts = collect();
        $projects = collect();

        if (strlen($query) >= 2) {
            $term = '%' . $query . '%';

            if ($type !== 'projects') {
                $posts = BlogPost::published()
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('content_md', 'like', $term)
                            ->orWhere('excerpt', 'like', $term);
                    })
                    ->with('tags')
                    ->latest()
                    ->take(20)
                    ->get();
            }

            if ($type !== 'blog') {
                $projects = Project::visible()
                    ->where(function ($q) use ($term) {
                        $q->where('title', 'like', $term)
                            ->orWhere('description', 'like', $term)
                            ->orWhere('long_description', 'like', $term);
                    })
                    ->ordered()
                    ->take(20)
                    ->get();
            }
        }

        $suggestion = null;
        if (strlen($query) >= 2 && $posts->isEmpty() && $projects->isEmpty()) {
            $suggestion = self::suggest($query);
        }

        return view('search', compact('query', 'posts', 'projects', 'suggestion'));
    }

    /**
     * Generate a "did you mean" suggestion when no results are found.
     */
    public static function suggest(string $query): ?string
    {
        $titles = BlogPost::published()->pluck('title')->merge(
            Project::visible()->pluck('title')
        );

        $bestMatch = null;
        $bestScore = 0;

        foreach ($titles as $title) {
            similar_text(strtolower($query), strtolower($title), $percent);
            if ($percent > $bestScore && $percent > 40) {
                $bestScore = $percent;
                $bestMatch = $title;
            }
        }

        return $bestMatch;
    }

    public function autocomplete(Request $request)
    {
        $q = $request->get('q', '');
        if (strlen($q) < 2)
            return response()->json([]);

        $term = '%' . $q . '%';
        $results = BlogPost::published()->where('title', 'like', $term)->take(3)->pluck('title')
            ->merge(Project::visible()->where('title', 'like', $term)->take(2)->pluck('title'));

        return response()->json($results->values());
    }
}
