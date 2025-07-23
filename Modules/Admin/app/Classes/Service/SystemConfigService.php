<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Database\SQLiteDatabaseDoesNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\SystemConfig;

/**
 * 系统配置服务
 * 请从容器中获取实例
 */
class SystemConfigService
{
    protected Collection $config_group;

    protected Collection $config_list;

    protected \Illuminate\Database\Eloquent\Collection $databaseConfig;

    public static function getInstance(): static
    {
        return app(self::class);
    }

    public function registerGroups(array $config_group)
    {
        $this->getGroups()->push(...$config_group);
    }

    public function getGroups(): Collection
    {
        $this->config_group ??= new Collection;

        return $this->config_group;
    }

    public function registerList(array $config_list)
    {
        $run_diff = true;
        if (\app()->runningInConsole()) {
            try {
                DB::connection()->getPdo();
                if (! Schema::hasTable(SystemConfig::query()->getModel()->getTable())) {
                    $run_diff = false;
                }
            } catch (SQLiteDatabaseDoesNotExistException $e) {
                $run_diff = false;
            }
        }
        if ($run_diff) {
            $this->databaseConfig ??= SystemConfig::all();
            $kv = [];
            foreach ($this->databaseConfig as $config) {
                $kv[$config->key] = $config['value'];
            }
            foreach ($config_list as &$config) {
                if (isset($kv[$config['key'] ?? false])) {
                    $config['value'] = $kv[$config['key']];
                }
            }
        }
        $this->getList()->push(...$config_list);
    }

    public function getList(): Collection
    {
        $this->config_list ??= new Collection;

        return $this->config_list;
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
