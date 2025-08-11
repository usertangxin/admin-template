<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Models\SystemMenu;

class AdminSupport
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $request->merge([
            '__is_admin_background__' => true,
        ]);

        $menu = SystemMenu::where('code', $request->route()->getName())->first();

        if($menu?->allow_all) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->status !== 'normal' && $request->route()->getName() !== 'web.admin.logout') {
            return \redirect()->route('web.admin.logout');
        }

        /** @var \Modules\Admin\Model\SystemAdmin $user */
        $user = Auth::user();

        if(!$user->can($request->route()->getName())) {
            throw new \Illuminate\Auth\Access\AuthorizationException('您没有权限访问');
        }

        return $next($request);
    }
}
