<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Inertia\Response;
use Modules\Admin\Classes\Service\ResponseService;

abstract class AbstractController
{
    /**
     * 视图
     *
     * @param  array    $data 数据
     * @param  mixed    $view 视图
     * @return Response
     *
     * @throws BindingResolutionException
     */
    protected function inertia($data = [], $view = null)
    {
        return ResponseService::inertia($data, $view);
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
    protected function success($data = [], $message = '', $code = 0, $view = null)
    {
        return ResponseService::success($data, $message, $code, $view);
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
    protected function fail($message = 'fail', $code = 400, $view = null)
    {
        return ResponseService::fail($message, $code, $view);
    }
}
