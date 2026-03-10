<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register route middleware aliases here
        $middleware->alias([
            'check.permission' => \App\Http\Middleware\CheckPermission::class,
            'auth.jwt'         => \App\Http\Middleware\AdminJWT::class,
            'redirect.admin'   => \App\Http\Middleware\RedirectAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
