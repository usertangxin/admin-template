<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Classes\Service\SystemConfigService;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Models\SystemConfig;

class SystemConfigController extends AbstractCrudController
{
    protected function getModel(): AbstractModel|AbstractSoftDelModel { 
        return new SystemConfig();
    }

    public function index()
    {
        $data = SystemConfigService::getList();
        $systemConfigGroup = SystemConfigService::getGroups();
        return $this->inertia([
            'config_list' => $data,
            'config_group_list' => $systemConfigGroup,
        ]);
    }
}
