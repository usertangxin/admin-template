<?php

namespace Modules\FileStorageExtend\Classes;

use Illuminate\Contracts\Container\BindingResolutionException;
use Modules\Admin\Classes\Utils\SystemConfigUtil;
use Modules\Admin\Classes\Utils\SystemDictUtil;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Modules\Admin\Models\SystemConfig;
use Nwidart\Modules\Module;

class AdminScript implements AdminScriptInterface
{
    protected $configs = [];

    protected $dicts = [];

    /**
     * @return void
     *
     * @throws BindingResolutionException
     */
    public function __construct(Module $module)
    {
        $config_path        = $module->getPath() . '/config/';
        $storage_mode_oss   = include $config_path . 'storage_mode_oss.php';
        $storage_mode_cos   = include $config_path . 'storage_mode_cos.php';
        $storage_mode_s3    = include $config_path . 'storage_mode_s3.php';
        $storage_mode_qiniu = include $config_path . 'storage_mode_qiniu.php';
        $dict               = include $config_path . 'dict.php';
        $this->configs      = array_merge($storage_mode_qiniu, $storage_mode_oss, $storage_mode_cos, $storage_mode_s3);
        $this->dicts        = $dict;
    }

    public function enable(Module $module)
    {
        SystemConfigUtil::autoResisterConfig($this->configs, 'file_storage_extend::storage_mode.');
        SystemConfigUtil::autoEnableConfig($this->configs);

        $storageMode = SystemConfig::where('key', 'storage_mode')->first();

        $storage_mode_config_select_data = config('file_storage_extend.storage_mode_config_select_data');

        $currentInputAttr = $storageMode->getTranslations('input_attr');

        // 合并 input_attr
        // 为每种语言合并云存储选项
        foreach (config('admin.multi_language') as $lang) {
            if (isset($currentInputAttr[$lang]['options'])) {
                // 将云存储选项转换为所需格式并添加到现有选项中
                foreach ($storage_mode_config_select_data as $item) {
                    if (isset($item['label'][$lang])) {
                        $currentInputAttr[$lang]['options'][] = [
                            'label' => $item['label'][$lang] ?? $item['value']['zh_CN'],
                            'value' => $item['value']
                        ];
                    }
                }
            }
        }
        
        // 更新数据库中的input_attr
        $storageMode->setTranslations('input_attr', $currentInputAttr);

        $storageMode->save();

        SystemDictUtil::autoRegisterDicts($this->dicts);
        SystemDictUtil::autoEnableDicts($this->dicts);
    }

    public function disable(Module $module)
    {
        SystemConfigUtil::autoDisableConfig($this->configs);
        SystemDictUtil::autoDisableDicts($this->dicts);
    }

    public function delete(Module $module)
    {
        SystemConfigUtil::autoUnregisterConfig($this->configs);

        SystemDictUtil::autoUnregisterDicts($this->dicts);
    }
}
