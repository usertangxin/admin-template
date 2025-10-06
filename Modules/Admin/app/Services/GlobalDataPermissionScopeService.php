<?php

namespace Modules\Admin\Services;

use InvalidArgumentException;
use Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface;

class GlobalDataPermissionScopeService
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
}
