<?php

namespace Modules\Admin\Models;

class SystemConfigGroup extends AbstractModel
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'code',
        'remark',
    ];
}
