<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemUploadfile;

#[SystemMenu('附件管理', icon:'fas file',parent_code: 'system.basic')]
class SystemUploadfileController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel|null {
        return new SystemUploadfile();
    }
}
