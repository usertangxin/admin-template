<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

abstract class AbstractController
{
    /**
     * 视图
     *
     * @param array $data 数据
     * @param mixed $view 视图
     * @return Response 
     * @throws BindingResolutionException 
     */
    protected function inertia($data = [], $view = null)
    {
        if ($view === null) {
            $action = \request()->route()->getActionMethod();
            $shortName = \class_basename(\request()->route()->getControllerClass());
            $prefix = Str::of($shortName)->replace('Controller','')->snake('_');
            $view = $prefix . '/' . $action;
        }

        if ($data instanceof JsonResource) {
            $data = $data->toArray(\request());
        }

        return Inertia::render($view, $data);
    }

    /**
     * 成功
     *
     * @param mixed $data 数据
     * @param string $message 消息
     * @param int $code 状态码
     * @param mixed $view 视图
     * @return JsonResponse|Response 
     * @throws BindingResolutionException 
     */
    protected function success($data = null, $message = '', $code = 0, $view = null)
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

        return $this->inertia($data, $view);
    }

    /**
     * 失败
     *
     * @param string $message 消息
     * @param int $code 状态码
     * @param mixed $view 视图
     * @return JsonResponse|Response 
     * @throws BindingResolutionException 
     */
    protected function fail($message = 'fail', $code = 400, $view = null)
    {
        if (\request()->expectsJson()) {
            return response()->json([
                'code'    => $code,
                'message' => $message,
            ]);
        }

        Inertia::share('__flush_message__', $message);
        Inertia::share('__flush_code__', $code);

        return $this->inertia([], $view);
    }
}
