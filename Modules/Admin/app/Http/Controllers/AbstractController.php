<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Modules\Admin\Services\ResponseService;

abstract class AbstractController
{
    /**
     * 视图
     *
     * @param  mixed    $data 数据
     * @param  mixed    $view 视图
     * @return Response
     */
    protected function inertia($data = [], $view = null)
    {
        return ResponseService::inertia($data, $view);
    }

    /**
     * 成功
     *
     * @param  mixed    $data    数据
     * @param  string   $message 消息
     * @param  int      $code    状态码
     * @param  mixed    $view    视图
     * @return Response
     */
    protected function success($data = [], $message = '', $code = 0, $view = null)
    {
        return ResponseService::success($data, $message, $code, $view);
    }

    /**
     * 失败
     *
     * @param  string   $message 消息
     * @param  int      $code    状态码
     * @param  mixed    $view    视图
     * @return Response
     */
    protected function fail($message = 'fail', $code = 400, $view = null)
    {
        return ResponseService::fail($message, $code, $view);
    }
}
