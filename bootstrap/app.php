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
        $middleware->trustProxies(at: '*');

        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->alias([
            'volunteer.auth'     => \App\Http\Middleware\EnsureVolunteerIsApproved::class,
            'volunteer.password' => \App\Http\Middleware\EnsureVolunteerChangedPassword::class,
            'security.headers'   => \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Exclude payment gateway webhook endpoints from CSRF verification.
        // Cashfree and Razorpay are external services that POST without CSRF tokens.
        // ONLY these specific endpoints are excluded — global CSRF remains active.
        $middleware->validateCsrfTokens(except: [
            '/webhook/cashfree',
            '/webhook/razorpay',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
