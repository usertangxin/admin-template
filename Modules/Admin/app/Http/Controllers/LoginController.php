<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends AbstractController
{
    public function view()
    {
        return $this->inertia(view: 'login');
    }

    public function authenticate(Request $request) {}
}
