<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;

abstract class AbstractController
{
    protected function inertia($data = [], $view = null)
    {
        if ($view === null) {
            $controller = \request()->route()->getControllerClass();
            $action = \request()->route()->getActionMethod();
            $shortName = Arr::last(\explode('\\', $controller));
            $prefix = str_replace('Controller', '', $shortName);
            $prefix = Str::snake($prefix, '_');
            $view = $prefix . '/' . $action;
        }

        if ($data instanceof JsonResource) {
            $data = $data->toArray(\request());
        }

        return Inertia::render($view, $data);
    }

    protected function success($data = null, $message = '', $code = 0)
    {
        if (\request()->expectsJson()) {
            return response()->json([
                'code'    => $code,
                'message' => $message,
                'data'    => $data,
            ]);
        }
        
        Inertia::share('__flush_success__', $message);
        Inertia::share('__flush_code__', $code);

        return $this->inertia($data);
    }

    protected function fail($message = 'fail', $code = 400)
    {
        if (\request()->expectsJson()) {
            return response()->json([
                'code'    => $code,
                'message' => $message,
            ]);
        }

        Inertia::share('__flush_message__', $message);
        Inertia::share('__flush_code__', $code);

        return $this->inertia();
    }
}
