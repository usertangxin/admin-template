<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\SQLiteDatabaseDoesNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;
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

    public function __construct(protected $request_call) {}

    protected function request()
    {
        return call_user_func($this->request_call);
    }

    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 注册配置组
     *
     * @return void
     */
    public function registerGroups(array $config_group)
    {
        $this->config_group ??= new Collection;

        $this->config_group->push(...$config_group);
    }

    /**
     * 获取配置组
     */
    public function getGroups(): Collection
    {
        return $this->config_group;
    }

    /**
     * 注册配置列表
     *
     * @return void
     */
    public function registerList(array $config_list)
    {
        $this->config_list ??= new Collection;

        $this->config_list->push(...$config_list);

        $this->request()['loaded_new_config'] = null;
    }

    /**
     * 刷新配置列表
     */
    public function refresh(): Collection
    {
        return $this->getList(true);
    }

    /**
     * 获取配置列表
     *
     * @param bool $force
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    public function getList($force = false): Collection
    {
        $run_diff                             = empty($this->request()['loaded_new_config']) ? true : false;
        $this->request()['loaded_new_config'] = true;

        if ($force) {
            $run_diff = true;
        }

        if ($run_diff && \app()->runningInConsole()) {
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
            $this->databaseConfig = SystemConfig::all();
            $kv                   = [];
            foreach ($this->databaseConfig as $config) {
                $kv[$config->key] = $config['value'];
            }
            $this->config_list->transform(function ($item) use ($kv) {
                if (array_key_exists($item['key'] ?? false, $kv)) {
                    $item['value'] = $kv[$item['key']];
                }

                return $item;
            });
        }

        return $this->config_list;
    }

    /**
     * 获取配置值
     *
     * @return mixed
     */
    public function getValueByKey(string $key)
    {
        return $this->getList()->firstWhere('key', $key)['value'] ?? null;
    }

    /**
     * 获取配置
     *
     * @return mixed
     */
    public function getConfigByKey(string $key)
    {
        return $this->getList()->firstWhere('key', $key);
    }

    /**
     * 设置配置，不是数据库，用于混合现有配置
     *
     * @param  mixed $config
     * @return void
     */
    public function setConfigByKey(string $key, $config)
    {
        $this->getList()->transform(function ($item) use ($key, $config) {
            if (isset($item['key']) && $item['key'] == $key) {
                $item = $config;
            }

            return $item;
        });
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
