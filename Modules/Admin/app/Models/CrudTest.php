<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Modules\Admin\Database\Factories\CrudTestFactory;

class CrudTest extends AbstractSoftDelModel
{
    use HasFactory;

    protected $table = 'crud_test';

    #[Scope]
    protected function fast_search(Builder $builder, $value)
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }
}
