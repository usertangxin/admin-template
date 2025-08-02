<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Admin\Services\SystemConfigService;
use Modules\Admin\Services\SystemDictService;

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
        Inertia::share('system_dict_hash', SystemDictService::getInstance()->getListHash());
        Inertia::share('system_dict_group_hash', SystemDictService::getInstance()->getGroupsHash());
        Inertia::share('system_config_hash', SystemConfigService::getInstance()->getListHash());
        Inertia::share('system_config_group_hash', SystemConfigService::getInstance()->getGroupsHash());

        return $next($request);
    }
}
