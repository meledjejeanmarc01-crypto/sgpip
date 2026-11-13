<?php

use App\Http\Middleware\AccesModule;
use App\Http\Middleware\AccesProjet;
use App\Http\Middleware\RoleMiddleware;
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
            'role' => RoleMiddleware::class,
            'acces' => AccesModule::class,        // droits par module (config/acces.php)
            'projet.acces' => AccesProjet::class, // un gestionnaire ne modifie que ses projets (RG17)
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
