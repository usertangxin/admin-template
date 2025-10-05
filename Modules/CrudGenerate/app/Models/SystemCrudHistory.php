<?php

namespace Modules\CrudGenerate\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\CrudGenerate\Casts\AsCrudFieldList;

// use Modules\CrudGenerate\Database\Factories\SystemCrudHistoryFactory;

class SystemCrudHistory extends AbstractSoftDelModel
{
    use HasUuids;

    protected $table = 'system_crud_histories';

    protected $fillable = [
        'table_name',
        'table_comment',
        'soft_delete',
        'primary_key',
        'parent_menu_code',
        'menu_name',
        'menu_icon',
        'gen_mode',
        'gen_class_name',
        'column_list',
        'module_name',
    ];

    protected $casts = [
        'column_list' => AsCrudFieldList::class,
        'file_list'   => 'array',
    ];
}
