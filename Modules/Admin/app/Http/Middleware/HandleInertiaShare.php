<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Admin\Classes\Service\SystemConfigService;
use Modules\Admin\Classes\Service\SystemDictService;

/**
 * 共享Inertia数据
 * 如果需要使用本模块提供的各种前端组件，则需要注册本中间件
 */
class HandleInertiaShare
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share('dict_list', SystemDictService::getList());
        Inertia::share('dict_group_list', SystemDictService::getGroups());
        Inertia::share('system_config_list', SystemConfigService::getList());
        Inertia::share('system_config_group_list', SystemConfigService::getGroups());

        return $next($request);
    }
}
