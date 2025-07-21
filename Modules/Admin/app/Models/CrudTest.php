<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\CrudTestFactory;

class CrudTest extends AbstractSoftDelModel
{
    use HasFactory;

    protected $table = 'crud_test';

}
