<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AbstractController
{
    public function view()
    {
        if (Auth::check()) {
            return redirect()->route('web.Admin.index');
        }

        return $this->inertia(view: 'login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'admin_name' => 'required',
            'password'   => 'required',
        ]);
        $remember = $request->input('remember', false);
        if (Auth::attempt($credentials, $remember)) {
            return $this->success(message: '登录成功');
        }

        return $this->fail('用户名或密码错误');
    }

    /**
     * 将用户从应用程序中注销。
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.Admin.login');
    }
}
