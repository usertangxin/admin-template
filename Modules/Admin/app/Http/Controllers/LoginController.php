<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\SystemMenuType;

class LoginController extends AbstractController
{
    #[SystemMenu('登录页', type: SystemMenuType::MENU, code: 'web.admin.login.view', parent_code: 'system_admin.login', allow_all: true)]
    public function view()
    {
        if (Auth::check()) {
            return redirect()->route('web.admin.index');
        }

        return $this->inertia(view: 'module.Admin.login');
    }

    #[SystemMenu('登录页', type: SystemMenuType::MENU, code: 'web.admin.login.authenticate', parent_code: 'system_admin.login', allow_all: true)]
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'admin_name' => 'required',
            'password'   => 'required',
        ]);
        $credentials['status'] = 'normal';
        $remember              = $request->input('remember', false);
        if (Auth::attempt($credentials, $remember)) {
            return $this->success(message: '登录成功');
        }

        return $this->fail('用户名或密码错误');
    }

    /**
     * 将用户从应用程序中注销。
     */
    #[SystemMenu('退出登录', type: SystemMenuType::MENU, code: 'web.admin.logout', parent_code: 'system_admin.login', allow_all: true)]
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('web.admin.login.view');
    }
}
