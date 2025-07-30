<?php

namespace Modules\Admin\Classes\Service;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\SQLiteDatabaseDoesNotExistException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Admin\Models\SystemDict;

/**
 * 系统字典服务
 * 请从容器中获取实例
 */
class SystemDictService
{
    protected Collection $group;

    protected Collection $list;

    /**
     * @var SystemDict[]
     */
    protected $databaseConfig;

    public function __construct()
    {
        if ($this->dictCached()) {
            $cache = require $this->getCacheFilePath();
            $this->getGroups()->push(...$cache['group']);
            $this->getList()->push(...$cache['list']);
        }
    }

    /**
     * 获取字典服务实例
     *
     * @throws BindingResolutionException
     */
    public static function getInstance(): static
    {
        return app(self::class);
    }

    /**
     * 获取缓存文件路径
     *
     * @return string
     *
     * @throws BindingResolutionException
     */
    public function getCacheFilePath()
    {
        return \config('cache.stores.file.path') . '/system_dicts.php';
    }

    /**
     * 检查字典是否缓存
     *
     * @throws BindingResolutionException
     */
    public function dictCached(): bool
    {
        return file_exists($this->getCacheFilePath());
    }

    /**
     * 注册字典组
     *
     * @return void
     */
    public function registerGroups(array $config_group)
    {
        $this->getGroups()->push(...$config_group);
    }

    /**
     * 获取字典组
     */
    public function getGroups(): Collection
    {
        $this->group ??= new Collection;

        return $this->group;
    }

    /**
     * 获取字典列表
     */
    public function getList(): Collection
    {
        $this->list ??= new Collection;

        return $this->list;
    }

    /**
     * 注册字典列表
     *
     * @return void
     */
    public function registerList(array $config_list)
    {
        // $run_diff = true;
        // if (\app()->runningInConsole()) {
        //     try {
        //         DB::connection()->getPdo();
        //         if (! Schema::hasTable(SystemDict::query()->getModel()->getTable())) {
        //             $run_diff = false;
        //         }
        //     } catch (SQLiteDatabaseDoesNotExistException $e) {
        //         $run_diff = false;
        //     }
        // }
        // if ($run_diff) {
        //     $this->databaseConfig ??= SystemDict::all();
        //     $kv = [];
        //     foreach ($this->databaseConfig as $config) {
        //         $kv[$config->value] = $config;
        //     }
        //     foreach ($config_list as &$config) {
        //         if (isset($kv[$config['value'] ?? false])) {
        //             $config = \array_merge($config, (array) $kv[$config['value']]);
        //         }
        //     }
        // }
        $this->getList()->push(...$config_list);
    }

    /**
     * 根据字典组编码获取字典值集合
     *
     * @param  mixed                         $code
     * @return Collection<string|int, mixed>
     */
    public function getValuesByCode($code)
    {
        return $this->getList()->where('code', $code)->pluck('value');
    }

    /**
     * 根据字典组编码获取字典集合
     *
     * @param  mixed      $code
     * @return Collection
     */
    public function getListByCode($code)
    {
        return $this->getList()->where('code', $code);
    }

    /**
     * 获取字典列表哈希值
     *
     * @return string
     */
    public function getListHash()
    {
        return \sha1($this->getList()->toJson());
    }

    /**
     * 获取字典组哈希值
     *
     * @return string
     */
    public function getGroupsHash()
    {
        return \sha1($this->getGroups()->toJson());
    }

    /**
     * 缓存字典
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function cacheDict()
    {
        $cache_file_path = $this->getCacheFilePath();
        $list            = $this->getList()->toArray();
        $group           = $this->getGroups()->toArray();
        $list_code       = var_export($list, true);
        $group_code      = var_export($group, true);
        $file_content    = <<<EOF
<?php

return [
    'list' => $list_code,
    'group' => $group_code,
];
EOF;
        file_put_contents($cache_file_path, $file_content);
    }

    /**
     * 清除字典缓存
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function clearCache()
    {
        if ($this->dictCached()) {
            unlink($this->getCacheFilePath());
        }
    }
}
