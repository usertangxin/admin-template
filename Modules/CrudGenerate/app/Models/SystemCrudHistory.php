<?php

namespace Modules\CrudGenerate\Models;

use Modules\Admin\Models\AbstractSoftDelModel;

// use Modules\CrudGenerate\Database\Factories\SystemCrudHistoryFactory;

class SystemCrudHistory extends AbstractSoftDelModel
{
    protected $table = 'system_crud_histories';
}
