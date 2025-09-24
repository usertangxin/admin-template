<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $data = Cache::remember('system_config_dict_hash', 60 * 60 * 24, function () {
            return [
                'system_dict_hash' => SystemDictService::getInstance()->getListHash(),
                'system_dict_group_hash' => SystemDictService::getInstance()->getGroupsHash(),
                'system_config_hash' => SystemConfigService::getInstance()->getListHash(),
                'system_config_group_hash' => SystemConfigService::getInstance()->getGroupsHash(),
            ];
        });
        Inertia::share('system_dict_hash', $data['system_dict_hash']);
        Inertia::share('system_dict_group_hash', $data['system_dict_group_hash']);
        Inertia::share('system_config_hash', $data['system_config_hash']);
        Inertia::share('system_config_group_hash', $data['system_config_group_hash']);

        return $next($request);
    }
}
