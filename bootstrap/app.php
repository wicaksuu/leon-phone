<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Shared\Exceptions\DomainException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // docs/05-coding-standards.md § 1 — API/webhook consumers always get
        // this shape, regardless of which DomainException subclass fired.
        // Filament/Livewire code paths should catch DomainException locally
        // via Modules\Shared\Traits\CatchesDomainExceptions instead of
        // relying on this global handler, so the form state isn't lost.
        $exceptions->render(function (DomainException $exception, Request $request) {
            if (! ($request->is('api/*') || $request->expectsJson())) {
                return null;
            }

            return new JsonResponse([
                'error' => [
                    'code' => $exception->code(),
                    'message' => $exception->getMessage(),
                ],
            ], $exception->status());
        });
    })->create();
