<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\SystemUploadfileFactory;

class SystemUploadfile extends AbstractSoftDelModel
{
    protected $table = 'system_uploadfile';
}
