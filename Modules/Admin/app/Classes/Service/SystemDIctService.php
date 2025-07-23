<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Database\SQLiteDatabaseDoesNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\SystemDict;

/**
 * 系统字典服务
 * 请从容器中获取实例
 * @package Modules\Admin\Classes\Service
 */
class SystemDictService
{
    protected Collection $group;

    protected Collection $list;

    /**
     * @var SystemDict[]
     */
    protected $databaseConfig;

    public static function getInstance(): static
    {
        return app(static::class);
    }

    public function registerGroups(array $config_group)
    {
        $this->getGroups()->push(...$config_group);
    }

    public function getGroups(): Collection
    {
        $this->group ??= new Collection;

        return $this->group;
    }

    public function registerList(array $config_list)
    {
        $run_diff = true;
        if (\app()->runningInConsole()) {
            try {
                DB::connection()->getPdo();
                if (! Schema::hasTable(SystemDict::query()->getModel()->getTable())) {
                    $run_diff = false;
                }
            } catch (SQLiteDatabaseDoesNotExistException $e) {
                $run_diff = false;
            }

        }
        if ($run_diff) {
            $this->databaseConfig ??= SystemDict::all();
            $kv = [];
            foreach ($this->databaseConfig as $config) {
                $kv[$config->value] = $config;
            }
            foreach ($config_list as &$config) {
                if (isset($kv[$config['value'] ?? false])) {
                    $config = \array_merge($config, (array) $kv[$config['value']]);
                }
            }
        }
        $this->getList()->push(...$config_list);
    }

    public function getList(): Collection
    {
        $this->list ??= new Collection;

        return $this->list;
    }

    public function getValuesByCode($code)
    {
        return $this->getList()->where('code', $code)->pluck('value');
    }

    public function getListByCode($code)
    {
        return $this->getList()->where('code', $code);
    }

    public function getListHash()
    {
        return \sha1($this->getList()->toJson());
    }

    public function getGroupsHash()
    {
        return \sha1($this->getGroups()->toJson());
    }
}
