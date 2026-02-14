<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheStaticAssets
{
    /**
     * Add cache headers for static asset requests.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $path = $request->path();
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $assetTypes = config('cdn.asset_types', ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2']);

        if (in_array($ext, $assetTypes)) {
            $maxAge = config('cdn.cache_max_age', 2592000);
            $response->headers->set('Cache-Control', "public, max-age={$maxAge}, immutable");
            $response->headers->set('Vary', 'Accept-Encoding');
        }

        return $response;
    }
}
