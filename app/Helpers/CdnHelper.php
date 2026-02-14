<?php

namespace App\Helpers;

class CdnHelper
{
    /**
     * Generate a CDN-prefixed URL for an asset.
     *
     * @param string $path The asset path (e.g., '/css/app.css')
     * @return string The full URL, CDN-prefixed if enabled
     */
    public static function asset(string $path): string
    {
        $path = '/' . ltrim($path, '/');

        if (config('cdn.enabled') && config('cdn.url')) {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $assetTypes = config('cdn.asset_types', []);

            if (in_array($ext, $assetTypes)) {
                return rtrim(config('cdn.url'), '/') . $path;
            }
        }

        return asset($path);
    }

    /**
     * Generate cache-busted asset URL.
     *
     * @param string $path The asset path
     * @return string URL with version query string
     */
    public static function versioned(string $path): string
    {
        $fullPath = public_path(ltrim($path, '/'));
        $version = file_exists($fullPath) ? filemtime($fullPath) : time();

        return self::asset($path) . '?v=' . $version;
    }
}
