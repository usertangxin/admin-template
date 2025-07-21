<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\CrudTest;

#[SystemMenu('CRUD测试', icon: 'fas bug', parent_code: 'system.dev')]
class CrudTestController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new CrudTest;
    }
}
