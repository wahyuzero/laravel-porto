<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CDN Configuration
    |--------------------------------------------------------------------------
    |
    | Configure a CDN URL to serve static assets from. When set, the
    | cdn_asset() helper will prefix asset URLs with this domain.
    | Leave null to serve assets from the same domain.
    |
    */

    'url' => env('CDN_URL', null),

    /*
    |--------------------------------------------------------------------------
    | CDN Enabled
    |--------------------------------------------------------------------------
    |
    | Whether CDN asset rewriting is enabled. Even if a CDN URL is set,
    | you can disable it with this flag.
    |
    */

    'enabled' => env('CDN_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Headers
    |--------------------------------------------------------------------------
    |
    | Cache-Control max-age in seconds for static assets served through
    | the application. Default: 30 days.
    |
    */

    'cache_max_age' => env('CDN_CACHE_MAX_AGE', 2592000), // 30 days

    /*
    |--------------------------------------------------------------------------
    | Asset Types
    |--------------------------------------------------------------------------
    |
    | File extensions that should be served through CDN.
    |
    */

    'asset_types' => ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico', 'woff', 'woff2', 'ttf', 'eot'],

];
