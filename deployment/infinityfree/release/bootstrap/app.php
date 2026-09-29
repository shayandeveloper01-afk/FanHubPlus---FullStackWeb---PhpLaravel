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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'      => \App\Http\Middleware\EnsureIsAdmin::class,
            'notbanned'  => \App\Http\Middleware\EnsureNotBanned::class,
            'organizer'  => \App\Http\Middleware\IsOrganizer::class,
            'role'       => \App\Http\Middleware\EnsureRole::class,
        ]);
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureNotBanned::class);
        $middleware->appendToGroup('web', \App\Http\Middleware\TrackPageView::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
