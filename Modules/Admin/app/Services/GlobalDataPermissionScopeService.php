<?php

namespace Modules\Admin\Services;

use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;
use Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface;

class GlobalDataPermissionScopeService implements Arrayable
{
    /**
     * @var array<string, GlobalDataPermissionScopeInterface>
     */
    protected array $scopes = [];

    public function add(GlobalDataPermissionScopeInterface $class)
    {
        if (isset($this->scopes[$class->getScopeName()])) {
            throw new InvalidArgumentException($class->getScopeName() . ' 重复');
        }
        $this->scopes[$class->getScopeName()] = $class;
    }

    public function replace(GlobalDataPermissionScopeInterface $class)
    {
        $this->scopes[$class->getScopeName()] = $class;
    }

    public function has(string $scope_name)
    {
        return isset($this->scopes[$scope_name]);
    }

    public function get(string $scope_name)
    {
        return $this->scopes[$scope_name] ?? null;
    }

    public function toArray()
    {
        $a = [];
        foreach ($this->scopes as $item) {
            $a[$item->getScopeName()] = [
                'name'                        => $item->getScopeName(),
                'extend_data_scope_view_name' => $item->getExtendDataScopeViewName(),
            ];
        }
        return $a;
    }
}
