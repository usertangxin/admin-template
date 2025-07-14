<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Modules\Admin\Classes\Service\SystemMenuRegisterService;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->redirectGuestsTo(function (Request $request) {
            $route_name = $request->route()->getName();
            if ($route_name == 'web.admin.index' || (SystemMenuRegisterService::getBy($route_name, 'code') ?? false)) {
                return route('web.admin.login');
            }

            return false;
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
