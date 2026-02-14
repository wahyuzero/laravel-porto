<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;

class TrackPageView
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only track successful GET requests to public pages
        if (
            $request->isMethod('GET') && $response->getStatusCode() === 200
            && !$request->is('admin/*', 'api/*', '_*', 'storage/*')
            && !$request->ajax()
        ) {
            try {
                PageView::create([
                    'url' => '/' . ltrim($request->path(), '/'),
                    'page_title' => null,
                    'referrer' => $request->header('referer'),
                    'ip_hash' => hash('sha256', $request->ip() . config('app.key')),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                    'viewed_date' => now()->toDateString(),
                ]);
            } catch (\Exception $e) {
                // Silently fail — analytics should never break the site
            }
        }

        return $response;
    }
}
