<?php

return [
    /*
    |--------------------------------------------------------------------------
    | wxsys Application Settings
    |--------------------------------------------------------------------------
    | Centralized configuration for magic numbers and limits.
    */

    'reading_time' => [
        'wpm' => 200, // words per minute
    ],

    'search' => [
        'limit' => 20, // max results per model
        'min_length' => 2, // minimum query length
    ],

    'comments' => [
        'max_chars' => 2000,
    ],

    'guestbook' => [
        'max_chars' => 500,
    ],

    'upload' => [
        'max_size_kb' => 2048,
        'avatar_max_kb' => 1024,
        'allowed_mimes' => 'jpg,jpeg,png,webp,gif',
    ],

    'cache' => [
        'homepage_ttl' => 300, // 5 minutes
        'sitemap_ttl' => 3600, // 1 hour
    ],
];
