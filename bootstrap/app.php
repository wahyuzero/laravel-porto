<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies (Coolify/Traefik reverse proxy)
        $middleware->trustProxies(at: '*');
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\ForceHttps::class,
            \App\Http\Middleware\TrackPageView::class,
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\LazyLoadImages::class,
            \App\Http\Middleware\MinifyHtml::class,
            \App\Http\Middleware\CacheStaticAssets::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
