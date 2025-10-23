<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Rute utama web
        web: __DIR__.'/../routes/web.php',

        // Rute API publik & private
        api: __DIR__.'/../routes/api.php',

        // Command routes
        commands: __DIR__.'/../routes/console.php',

        // Route bawaan untuk health check
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        /**
         * Group 'api' di Laravel 11
         * Hanya HandleCors + SubstituteBindings (tanpa CSRF, tanpa auth)
         */
        $middleware->group('api', [
            HandleCors::class,
            SubstituteBindings::class,
        ]);

        /**
         * Group 'web' tetap default (pakai CSRF, session, dll)
         * Jadi route web masih aman untuk login/session.
         */
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
