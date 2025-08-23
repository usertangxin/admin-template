<?php

namespace Modules\CrudGenerate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Models\AbstractSoftDelModel;

// use Modules\CrudGenerate\Database\Factories\SystemCrudHistoryFactory;

class SystemCrudHistory extends AbstractSoftDelModel
{
    protected $table = 'system_crud_histories';
}
