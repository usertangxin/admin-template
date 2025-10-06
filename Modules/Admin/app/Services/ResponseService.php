<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Nwidart\Modules\Module;
use Nwidart\Modules\Traits\PathNamespace;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class ResponseService
{
    use PathNamespace;

    protected function __construct() {}

    protected static function getDefaultNamespace(): string
    {
        return config('modules.paths.generator.controller.namespace')
            ?? ltrim(config('modules.paths.generator.controller.path'), config('modules.paths.app_folder', ''));
    }

    /**
     * Get class namespace.
     *
     * @return string
     */
    protected static function getClassNamespace(Module $module)
    {
        $my = new static;

        return $my->module_namespace($module->getStudlyName(), static::getDefaultNamespace());
    }

    /**
     * 获取控制器命名空间中间部分
     *
     * @return string
     */
    public static function getControllerTierStr($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        if (str_starts_with($class, config('modules.namespace'))) {
            $moduleParts = explode('\\', $class);
            $moduleName  = $moduleParts[1];

            $controllerBaseNamespace = static::getClassNamespace(module($moduleName, true));
        } else {
            $controllerBaseNamespace = 'App\\Http\\Controllers';
        }

        return Str::of($class)
            ->replaceFirst($controllerBaseNamespace . '\\', '')
            ->replaceLast(class_basename($class), '')
            ->replaceLast('\\', '')
            ->toString();
    }

    /**
     * 获取视图命名空间中间部分
     *
     * @return string
     */
    public static function getViewTierStr($class)
    {
        $controllerTierStr = static::getControllerTierStr($class);

        if ($controllerTierStr) {
            $controllerTierStr .= '\\';
        }

        $controllerTierStr .= Str::of(class_basename($class))->replace('Controller', '')->toString();

        $a = Str::of($controllerTierStr)->explode('\\')->map(fn ($item) => Str::snake($item))->toArray();

        return implode('.', $a);
    }

    /**
     * 获取中间部分视图路径
     *
     * @return string
     */
    public static function getViewTierPath($class)
    {
        return Str::of(static::getViewTierStr($class))->replace('.', '/')->toString();
    }

    /**
     * 基于完整控制器类名获取对应视图前缀
     *
     * @return string
     */
    public static function getViewPrefix($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        if (str_starts_with($class, config('modules.namespace'))) {
            $moduleParts = explode('\\', $class);
            $moduleName  = $moduleParts[1];

            $prefix = 'module.' . $moduleName . '.';
        } else {

            $prefix = 'app.';
        }

        $prefix = $prefix . static::getViewTierStr($class);

        return Str::of($prefix)->replace('_controller', '')->toString();
    }

    /**
     * 视图
     *
     * @param  mixed       $data 数据
     * @param  mixed|null  $view 视图
     * @return Responsable
     */
    public static function inertia(mixed $data = [], mixed $view = null)
    {
        if ($view === null) {
            $action = \request()->route()->getActionMethod();
            $action = Str::of($action)->replace(['get', 'post', 'put', 'delete'], '')->snake('-')->toString();
            $class  = \request()->route()->getControllerClass();
            $prefix = static::getViewPrefix($class);
            $view   = $prefix . '/' . $action;
        }

        $data = static::analysisDataToResource($data);
        $data = (array) $data->toResponse(\request())->getData();

        return Inertia::render($view, $data);
    }

    /**
     * 成功
     *
     * @param  mixed                       $data    数据
     * @param  string                      $message 消息
     * @param  int                         $code    状态码
     * @param  mixed|null                  $view    视图
     * @return Responsable|SymfonyResponse
     */
    public static function success(mixed $data = [], string $message = '', int $code = 0, mixed $view = null)
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
     * @param  string                      $message 消息
     * @param  int                         $code    状态码
     * @param  mixed|null                  $view    视图
     * @return SymfonyResponse|Responsable
     */
    public static function fail(string $message = 'fail', int $code = 400, mixed $view = null, mixed $data = [])
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
     * @return JsonResource
     */
    protected static function analysisDataToResource(mixed $data)
    {
        if ($data instanceof Collection || $data instanceof AbstractPaginator) {
            $data = JsonResource::collection($data);
        } elseif (! ($data instanceof JsonResource)) {
            $data = new JsonResource($data);
        }

        return $data;
    }
}
