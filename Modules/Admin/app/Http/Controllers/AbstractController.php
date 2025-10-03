<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Responsable;
use Modules\Admin\Services\ResponseService;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractController
{
    /**
     * 视图
     *
     * @param  mixed       $data 数据
     * @param  mixed       $view 视图
     * @return Responsable
     */
    protected function inertia(mixed $data = [], mixed $view = null)
    {
        return ResponseService::inertia($data, $view);
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
    protected function success(mixed $data = [], string $message = '', int $code = 0, mixed $view = null)
    {
        return ResponseService::success($data, $message, $code, $view);
    }

    /**
     * 失败
     *
     * @param  string                      $message 消息
     * @param  int                         $code    状态码
     * @param  mixed|null                  $view    视图
     * @return Responsable|SymfonyResponse
     */
    protected function fail(string $message = 'fail', int $code = 400, mixed $view = null)
    {
        return ResponseService::fail($message, $code, $view);
    }
}
