<?php

use App\Console\Commands\ProviderMakeCommand;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Context;
use Modules\Admin\Http\Middleware\AdminSupport;
use Modules\Admin\Services\ResponseService;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        ProviderMakeCommand::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        //
        $middleware->priority([
            AdminSupport::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            if (Context::get('__is_admin_background__')) {
                return \redirect()->route('web.admin.login.view');
            }

            return false;
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        $exceptions->render(function (Illuminate\Validation\ValidationException $exception, Request $request) {
            if (Context::get('__is_admin_background__')) {
                $messages = implode('', Arr::flatten($exception->errors()));

                return ResponseService::fail($messages, $exception->status, 'module.Admin.500', $exception->errors());
            }
        });

        $exceptions->render(function (NotFoundResourceException $exception, Request $request) {
            if (Context::get('__is_admin_background__')) {
                return ResponseService::fail($exception->getMessage(), 404, null, []);
            }
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (Context::get('__is_admin_background__')) {
                return \redirect()->route('web.admin.login.view');
            }
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (Context::get('__is_admin_background__')) {
                return ResponseService::fail($exception->getMessage(), 500, 'module.Admin.500', app()->isLocal() ? ['trace' => $exception->getTrace()] : []);
            }
        });
    })->create();
