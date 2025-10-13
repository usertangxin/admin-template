<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Inertia\Inertia;
use Modules\Admin\Http\Controllers\LoginController;
use Modules\Admin\Models\SystemAdmin;

class AdminSupport
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {

        $locale = $request->cookie('locale');
        if ($locale && in_array($locale, config('admin.multi_language'))) {
            app()->setLocale($locale);
        }

        Context::add('__is_admin_background__', true);

        Inertia::share('locale', app()->getLocale());

        if (\request()->route()->getController() instanceof LoginController) {
            return $next($request);
        }

        if (! Auth::check() || Auth::user()->status !== 'normal' || ! (Auth::user() instanceof SystemAdmin)) {
            return \redirect()->route('web.admin.logout');
        }

        /** @var \Modules\Admin\Model\SystemAdmin $user */
        $user = Auth::user();

        if (! $user->can($request->route()->getName())) {
            throw new \Illuminate\Auth\Access\AuthorizationException('您没有权限访问');
        }

        return $next($request);
    }
}
