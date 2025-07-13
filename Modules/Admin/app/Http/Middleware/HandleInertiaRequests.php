<?php

namespace Modules\Admin\Http\Middleware;

use App\Http\Middleware\HandleInertiaRequests as AppHandleInertiaRequests;

class HandleInertiaRequests extends AppHandleInertiaRequests
{
    protected $rootView = 'admin::app';
}
