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
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);

        // Usuario ya logueado que entra a /login: enviarlo a su panel (evita bucle / ↔ /login)
        $middleware->redirectUsersTo(fn ($request) => $request->user()->isTecnico()
            ? route('tecnico.index')
            : route('contracts.index'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
