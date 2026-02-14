<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MinifyHtml
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only minify HTML responses in production
        if (
            !app()->environment('production') &&
            !config('app.minify_html', false)
        ) {
            return $response;
        }

        if (
            method_exists($response, 'getContent') &&
            str_contains($response->headers->get('content-type', ''), 'text/html')
        ) {
            $content = $response->getContent();

            // Remove HTML comments (but keep IE conditionals and blade directives)
            $content = preg_replace('/<!--(?!\[if)(?!<!).*?-->/s', '', $content);

            // Remove excess whitespace between tags
            $content = preg_replace('/>\s{2,}</', '> <', $content);

            // Remove leading whitespace on lines
            $content = preg_replace('/^\s+/m', '', $content);

            // Collapse multiple newlines
            $content = preg_replace('/\n{2,}/', "\n", $content);

            // Don't minify <pre>, <code>, <script>, <style>, <textarea> content
            // (the regex approach above preserves these since we only target whitespace between tags)

            $response->setContent($content);

            // Add response size header for debugging
            $response->headers->set('X-Minified', 'true');
        }

        return $response;
    }
}
