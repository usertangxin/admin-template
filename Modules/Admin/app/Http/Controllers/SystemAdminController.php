<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemAdmin;

#[SystemMenu('系统管理员', parent_code: 'system.permission', icon: 'fas fa-user-tie')]
class SystemAdminController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new SystemAdmin;
    }

    protected function searchWhere(): array
    {
        $where = [];
        if (! empty($fast_search = \request('fast_search'))) {
            $where['fast_search'] = $fast_search;
        }

        return $where;
    }
}
