<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Admin\Database\Factories\ModelFactory;

abstract class AbstractModel extends BaseModel
{
    use HasFactory;

    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * 搜索
     * 可以使用scope开头的方法来定义搜索条件
     * @param array $where
     * @return $this
     */
    public function search($where) {
        foreach ($where as $key => $value) {
            if ($this->hasNamedScope($key)) {
                $this->$key($value);
                continue;
            }
            $this->where($key, $value);
        }
        return $this;
    }
}
