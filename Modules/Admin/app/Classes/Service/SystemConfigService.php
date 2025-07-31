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
    protected ?Collection $config_group;

    protected ?Collection $config_list;

    protected array $register_group_queue = [];

    protected array $register_grouped_queue = [];

    protected array $register_list_queue = [];

    protected array $register_listed_queue = [];

    protected array $register_modify_config_queue = [];

    protected array $register_modify_config_end_queue = [];

    protected \Illuminate\Database\Eloquent\Collection $databaseConfig;

    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 注册配置组
     *
     * @return void
     */
    public function bootRegister()
    {
        $this->config_group ??= new Collection;

        foreach ($this->register_group_queue as $callback) {
            $arr = $callback();
            $this->config_group->push(...$arr);
        }

        foreach ($this->register_grouped_queue as $callback) {
            $arr = $callback();
            $this->config_group->push(...$arr);
        }

        $this->config_list ??= new Collection;
        foreach ($this->register_list_queue as $callback) {
            $arr = $callback();
            $this->config_list->push(...$arr);
        }

        foreach ($this->register_listed_queue as $callback) {
            $arr = $callback();
            $this->config_list->push(...$arr);
        }

        foreach ($this->register_modify_config_queue as $callback) {
            $callback($this->config_list, $this);
        }

        foreach ($this->register_modify_config_end_queue as $callback) {
            $callback($this->config_list, $this);
        }
    }

    public function registerGroupQueue(callable $callback)
    {
        $this->register_group_queue[] = $callback;

        return $this;
    }

    public function registerGrouped(callable $callback)
    {
        $this->register_grouped_queue[] = $callback;

        return $this;
    }

    /**
     * 获取配置组
     */
    public function getGroups(): Collection
    {
        return $this->config_group;
    }

    public function registerListQueue(callable $callback)
    {
        $this->register_list_queue[] = $callback;

        return $this;
    }

    public function registerListed(callable $callback)
    {
        $this->register_listed_queue[] = $callback;

        return $this;
    }

    public function registerModifyConfigQueue(callable $callback)
    {
        $this->register_modify_config_queue[] = $callback;

        return $this;
    }

    public function registerModifyConfigEnd(callable $callback)
    {
        $this->register_modify_config_end_queue[] = $callback;

        return $this;
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
        $run_diff = empty(request()['loaded_new_config']) ? true : false;

        request()['loaded_new_config'] = true;

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
