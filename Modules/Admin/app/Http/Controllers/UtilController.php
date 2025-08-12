<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\FormToken;
use Modules\Admin\Services\ResponseService;

#[SystemMenu('工具', is_hidden: true, code: 'web.admin.util')]
class UtilController extends AbstractController
{
    #[SystemMenu('获取表单token', allow_admin: true, is_hidden: true)]
    public function getFormToken(FormToken $formToken)
    {
        return $this->success(['token' => $formToken->getToken()]);
    }

    #[SystemMenu('清理系统缓存', allow_admin: true, is_hidden: true)]
    public function clearSystemCache()
    {
        Cache::clear();

        return ResponseService::success(message: '清理系统缓存成功');
    }
}
