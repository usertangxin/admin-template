<?php

namespace Modules\CrudGenerate\Http\Middleware;

use App\Http\Middleware\HandleInertiaRequests as MiddlewareHandleInertiaRequests;

class HandleInertiaRequests extends MiddlewareHandleInertiaRequests
{
    protected $rootView = 'crud_generate::index';
}
