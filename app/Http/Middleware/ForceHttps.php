<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        if (!app()->environment('production')) {
            return $next($request);
        }

        // Only redirect if request came through a reverse proxy AND is HTTP
        // If no X-Forwarded-Proto header → internal request (healthcheck/direct) → skip
        $proto = $request->header('X-Forwarded-Proto');

        if ($proto && $proto !== 'https') {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}

