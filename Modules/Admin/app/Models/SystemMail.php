<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SystemMail extends AbstractSoftDelModel
{
    use HasUuids;

    protected $table = 'system_mails';
}
