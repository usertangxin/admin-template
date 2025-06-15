<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
abstract class AbstractCrudController extends Controller
{
    /**
     * @var Model
     */
    protected $model;
}
