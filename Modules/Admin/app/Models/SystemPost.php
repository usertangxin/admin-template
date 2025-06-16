<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\SystemPostFactory;

class SystemPost extends AbstractSoftDelModel
{
    protected $table = 'system_post';
}
