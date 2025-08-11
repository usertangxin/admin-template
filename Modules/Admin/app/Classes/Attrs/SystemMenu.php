<?php

namespace Modules\Admin\Classes\Attrs;

use ArrayAccess;
use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class SystemMenu implements ArrayAccess
{
    /**
     * 系统菜单
     *
     * @param  string      $name        菜单名称
     * @param  null|string $url         菜单URL
     * @param  null|string $type        菜单类型
     * @param  null|string $icon        菜单图标
     * @param  null|string $code        菜单编码，取路由名称为该值，他用户判断权限
     * @param  null|string $parent_code 父菜单编码
     * @param  bool        $is_hidden   是否隐藏
     * @param  string      $remark      备注
     * @param  array       $children    子菜单
     * @return void
     */
    public function __construct(
        public string $name,
        public ?string $url = null,
        public ?string $type = null,
        public ?string $icon = null,
        public ?string $code = null,
        public ?string $parent_code = null,
        public bool $is_hidden = false,
        public string $remark = '',
        public array $children = [],
        public bool $allow_all = false,
    ) {}

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->{$offset});
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->{$offset};
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->{$offset} = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->{$offset});
    }
}
