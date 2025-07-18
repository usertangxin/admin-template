<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Database\SQLiteDatabaseDoesNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\SystemDictData;

class SystemDictService
{
    protected static Collection $group;

    protected static Collection $list;

    /**
     * @var SystemDictData[]
     */
    protected static $databaseConfig;

    protected function __construct() {}

    public static function registerGroups(array $config_group)
    {
        static::getGroups()->push(...$config_group);
    }

    public static function getGroups(): Collection
    {
        static::$group ??= new Collection;

        return static::$group;
    }

    public static function registerList(array $config_list)
    {
        $run_diff = true;
        if (\app()->runningInConsole()) {
            try {
                DB::connection()->getPdo();
                if (! Schema::hasTable(SystemDictData::query()->getModel()->getTable())) {
                    $run_diff = false;
                }
            } catch (SQLiteDatabaseDoesNotExistException $e) {
                $run_diff = false;
            }

        }
        if ($run_diff) {
            static::$databaseConfig ??= SystemDictData::all();
            $kv = [];
            foreach (static::$databaseConfig as $config) {
                $kv[$config->value] = $config;
            }
            foreach ($config_list as &$config) {
                if (isset($kv[$config['value'] ?? false])) {
                    $config = \array_merge($config, (array) $kv[$config['value']]);
                }
            }
        }
        static::getList()->push(...$config_list);
    }

    public static function getList(): Collection
    {
        static::$list ??= new Collection;

        return static::$list;
    }

    public static function getListHash()
    {
        return \sha1(static::getList()->toJson());
    }

    public static function getGroupsHash()
    {
        return \sha1(static::getGroups()->toJson());
    }
}
