<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Support\Collection;

class SystemConfigService
{
    protected static Collection $config_group;
    protected static Collection $config_list;
    protected function __construct() {
        
    }

    public static function registerGroups(array $config_group) {
        static::getGroups()->push(...$config_group);
    }

    public static function getGroups(): Collection {
        static::$config_group ??= new Collection();
        return static::$config_group;
    }

    public static function registerList(array $config_list) {
        static::getList()->push(...$config_list);
    }

    public static function getList(): Collection {
        static::$config_list ??= new Collection();
        return static::$config_list;
    }
}
