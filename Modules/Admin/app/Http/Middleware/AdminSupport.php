<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check() && Auth::user()->status !== 'normal' && $request->route()->getName() !== 'web.admin.logout') {
            return \redirect()->route('web.admin.logout');
        }

        return $next($request);
    }
}
