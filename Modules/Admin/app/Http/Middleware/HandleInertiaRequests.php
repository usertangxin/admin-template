<?php

namespace Modules\Admin\Http\Middleware;

use App\Http\Middleware\HandleInertiaRequests as AppHandleInertiaRequests;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Admin\Services\SystemConfigService;

class HandleInertiaRequests extends AppHandleInertiaRequests
{
    protected $rootView = 'admin::app';

    public function handle(Request $request, Closure $next)
    {
        Inertia::share('page-title', SystemConfigService::getInstance()->getConfigByKey('site_name'));
        
        return parent::handle($request, $next);
    }

}
