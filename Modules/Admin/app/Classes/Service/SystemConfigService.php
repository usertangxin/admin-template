<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Support\Collection;
use Modules\Admin\Models\SystemConfig;

class SystemConfigService
{
    protected static Collection $config_group;
    protected static Collection $config_list;
    protected static \Illuminate\Database\Eloquent\Collection $databaseConfig;

    protected function __construct() {}

    public static function registerGroups(array $config_group)
    {
        static::getGroups()->push(...$config_group);
    }

    public static function getGroups(): Collection
    {
        static::$config_group ??= new Collection();
        return static::$config_group;
    }

    public static function registerList(array $config_list)
    {
        $run_diff = true;
        if (\app()->runningInConsole()) {
            // if (\app()->runningConsoleCommand('migrate', 'module:migrate','package')) {
            $run_diff = false;
            // }
        }
        if ($run_diff) {
            static::$databaseConfig ??= SystemConfig::all();
            $kv = [];
            foreach (static::$databaseConfig as $config) {
                $kv[$config->key] = $config['value'];
            }
            foreach ($config_list as &$config) {
                if (isset($kv[$config['key'] ?? false])) {
                    $config['value'] = $kv[$config['key']];
                }
            }
        }
        static::getList()->push(...$config_list);
    }

    public static function getList(): Collection
    {
        static::$config_list ??= new Collection();
        return static::$config_list;
    }
}
