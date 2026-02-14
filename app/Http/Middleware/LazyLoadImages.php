<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LazyLoadImages
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (method_exists($response, 'getContent') && str_contains($response->headers->get('content-type', ''), 'text/html')) {
            $content = $response->getContent();
            // Add loading="lazy" to img tags that don't already have it
            $content = preg_replace('/<img(?![^>]*loading=)([^>]*)>/i', '<img loading="lazy"$1>', $content);
            $response->setContent($content);
        }

        return $response;
    }
}
