<?php

namespace Modules\Admin\Http\Middleware;

use App\Http\Middleware\HandleInertiaRequests as AppHandleInertiaRequests;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Modules\Admin\Http\Controllers\LoginController;
use Modules\Admin\Models\SystemAdmin;
use Modules\Admin\Services\AdminSupportService;
use Modules\Admin\Services\SystemConfigService;
use Modules\Admin\Services\SystemDictService;

class AdminSupport extends AppHandleInertiaRequests
{
    protected $rootView = 'admin::app';

    protected function inertiaShare()
    {
        Inertia::share('locale', app()->getLocale());
        Inertia::share('page-title', SystemConfigService::getInstance()->getConfigByKey('site_name'));
    }

    protected function inertiaProtectedShare()
    {
        $data = Cache::remember(config('admin.cache_name_map.system_config_dict_hash') . app()->getLocale(), 60 * 60 * 24, function () {
            return [
                'system_dict_hash'         => SystemDictService::getInstance()->getListHash(),
                'system_dict_group_hash'   => SystemDictService::getInstance()->getGroupsHash(),
                'system_config_hash'       => SystemConfigService::getInstance()->getListHash(),
                'system_config_group_hash' => SystemConfigService::getInstance()->getGroupsHash(),
            ];
        });
        Inertia::share('system_dict_hash', $data['system_dict_hash']);
        Inertia::share('system_dict_group_hash', $data['system_dict_group_hash']);
        Inertia::share('system_config_hash', $data['system_config_hash']);
        Inertia::share('system_config_group_hash', $data['system_config_group_hash']);
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        $locale = $request->cookie('locale');
        if ($locale && in_array($locale, config('admin.multi_language'))) {
            app()->setLocale($locale);
        }

        app(AdminSupportService::class)->setAdminBackground(true);

        $this->inertiaShare();

        if (\request()->route()->getController() instanceof LoginController) {
            return parent::handle($request, $next);
        }

        if (! Auth::check() || Auth::user()->status !== 'normal' || ! (Auth::user() instanceof SystemAdmin)) {
            return \redirect()->route('web.admin.logout');
        }

        $this->inertiaProtectedShare();

        /** @var \Modules\Admin\Model\SystemAdmin $user */
        $user = Auth::user();

        if (! $user->can($request->route()->getName())) {
            throw new \Illuminate\Auth\Access\AuthorizationException(__('admin::auth.no_permission'));
        }

        return parent::handle($request, $next);
    }
}
