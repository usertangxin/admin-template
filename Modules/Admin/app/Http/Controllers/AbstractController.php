<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Arr;
use Inertia\Inertia;
use Str;

abstract class AbstractController
{

    public function inertia($data = [], $view = null)
    {
        if ($view === null) {
            $controller = \request()->route()->getControllerClass();
            $action = \request()->route()->getActionMethod();
            $shortName = Arr::last(\explode('\\', $controller));
            $prefix = str_replace('Controller', '', $shortName);
            $prefix = Str::snake($prefix, '_');
            $view = $prefix . '/' . $action;
        }
        return Inertia::render($view, $data);
    }

    public function success($data = null, $message = 'success', $code = 200)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function fail($message = 'fail', $code = 400)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
        ]);
    }
}
