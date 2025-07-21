<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\CrudTest;

class CrudTestController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null
    {
        return new CrudTest;
    }
}
