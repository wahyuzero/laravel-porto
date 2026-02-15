<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
{
    public function handle(Request $request, Closure $next)
    {
        // Disabled by default — reverse proxies (Coolify/Traefik) handle HTTPS
        // Set FORCE_HTTPS=true in .env only for direct (non-proxied) deployments
        if (!config('app.force_https', false)) {
            return $next($request);
        }

        if (!app()->environment('production')) {
            return $next($request);
        }

        $proto = $request->header('X-Forwarded-Proto');

        if ($proto && $proto !== 'https') {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        if (!$proto && !$request->isSecure()) {
            return redirect()->secure($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}


