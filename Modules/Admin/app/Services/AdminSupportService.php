<?php

namespace Modules\Admin\Services;

use Illuminate\Support\Facades\Context;

class AdminSupportService
{
    const CONTEXT_KEY = '__is_admin_background__';

    public function isAdminBackground()
    {
        return Context::get(self::CONTEXT_KEY, false);
    }

    public function setAdminBackground(bool $isAdminBackground)
    {
        Context::add(self::CONTEXT_KEY, $isAdminBackground);
    }
}
