<?php

namespace Modules\Admin\Services;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ResponseService
{
    protected function __construct() {}

    /**
     * 视图
     *
     * @param  array    $data 数据
     * @param  mixed    $view 视图
     * @return Response
     *
     * @throws BindingResolutionException
     */
    public static function inertia($data = [], $view = null)
    {
        if ($view === null) {
            $action    = \request()->route()->getActionMethod();
            $class     = \request()->route()->getControllerClass();
            $shortName = \class_basename($class);
            $prefix    = Str::of($shortName)->replace('Controller', '')->snake('_');
            $view      = $prefix . '/' . $action;
            if (str_starts_with($class, 'Modules')) {
                // 从类名中提取模块名称，格式为 Modules\ModuleName\Http\Controllers\...
                $moduleParts = explode('\\', $class);
                $moduleName  = $moduleParts[1]; // 第二个部分即为模块名称
                $view        = 'module.' . $moduleName . '.' . $view;
            } else {
                $view = 'app.' . $view;
            }
        }

        $data = static::analysisDataToResource($data);
        $data = (array) $data->toResponse(\request())->getData();

        return Inertia::render($view, $data);
    }

    /**
     * 成功
     *
     * @param  mixed                 $data    数据
     * @param  string                $message 消息
     * @param  int                   $code    状态码
     * @param  mixed                 $view    视图
     * @return JsonResponse|Response
     *
     * @throws BindingResolutionException
     */
    public static function success($data = [], $message = '', $code = 0, $view = null)
    {
        if (\request()->expectsJson()) {
            $data = static::analysisDataToResource($data);
            $data = (array) $data->toResponse(\request())->getData();

            return Response::json([
                'code'    => $code,
                'message' => $message,
                ...$data,
            ]);
        }

        Inertia::share('__flush_success__', $message);
        Inertia::share('__flush_code__', $code);

        return static::inertia($data, $view);
    }

    /**
     * 失败
     *
     * @param  string                $message 消息
     * @param  int                   $code    状态码
     * @param  mixed                 $view    视图
     * @return JsonResponse|Response
     *
     * @throws BindingResolutionException
     */
    public static function fail($message = 'fail', $code = 400, $view = null, $data = [])
    {
        if (\request()->expectsJson()) {
            return Response::json([
                'code'    => $code,
                'message' => $message,
                ...$data,
            ]);
        }

        Inertia::share('__flush_message__', $message);
        Inertia::share('__flush_code__', $code);

        return static::inertia($data, $view);
    }

    /**
     * 将数据转换为JsonResource
     *
     * @param  mixed        $data
     * @return JsonResource
     */
    protected static function analysisDataToResource($data)
    {
        if ($data instanceof Collection || $data instanceof AbstractPaginator) {
            $data = JsonResource::collection($data);
        } elseif (! ($data instanceof JsonResource)) {
            $data = new JsonResource($data);
        }

        return $data;
    }
}
