<?php

namespace App\Helpers;

class HtmlSanitizer
{
    /**
     * Allowed HTML tags for blog content rendered from Markdown.
     * This prevents XSS while preserving all Markdown-generated HTML.
     */
    private const ALLOWED_TAGS = [
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'p',
        'br',
        'hr',
        'strong',
        'em',
        'b',
        'i',
        'u',
        's',
        'del',
        'ins',
        'mark',
        'sub',
        'sup',
        'a',
        'img',
        'ul',
        'ol',
        'li',
        'table',
        'thead',
        'tbody',
        'tr',
        'th',
        'td',
        'blockquote',
        'pre',
        'code',
        'div',
        'span',
        'details',
        'summary',
        'dl',
        'dt',
        'dd',
        'abbr',
        'cite',
        'dfn',
        'kbd',
        'samp',
        'var',
        'figure',
        'figcaption',
    ];

    /**
     * Sanitize HTML output from Markdown rendering.
     * Strips dangerous tags (script, iframe, form, etc.) while keeping safe ones.
     */
    public static function clean(string $html): string
    {
        // Remove script tags and their content
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Remove event handlers (onclick, onerror, onload, etc.)
        $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*\S+/i', '', $html);

        // Remove javascript: and data: URIs from href/src
        $html = preg_replace('/(?:href|src)\s*=\s*["\']?\s*javascript\s*:/i', 'href="', $html);
        $html = preg_replace('/(?:href|src)\s*=\s*["\']?\s*data\s*:\s*text\/html/i', 'href="', $html);

        // Strip to allowed tags only
        $allowedTagString = '<' . implode('><', self::ALLOWED_TAGS) . '>';
        $html = strip_tags($html, $allowedTagString);

        return $html;
    }
}
