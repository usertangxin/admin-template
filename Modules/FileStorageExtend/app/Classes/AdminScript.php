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

    protected $update_storage_mode_config_select_data = [
        ['label' => '阿里云OSS', 'value' => 'oss'],
        ['label' => '七牛云',    'value' => 'qiniu'],
        ['label' => '腾讯云COS', 'value' => 'cos'],
        ['label' => '亚马逊S3',  'value' => 's3'],
    ];

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

        foreach (config('admin.multi_language') as $lang) {
            $input_attr = $storageMode->getTranslation('input_attr', $lang);
            if (! $input_attr) {
                $input_attr = ['options' => []];
            }
            $update_storage_mode_config_select_data = collect($this->update_storage_mode_config_select_data)->map(function ($item) use ($lang) {
                $item['label'] = trans('file_storage_extend::storage_mode.storage_mode.' . $item['value'], [], $lang);

                return $item;
            })->toArray();
            $b                     = collect($input_attr['options'])->concat($update_storage_mode_config_select_data)->keyBy('value')->values()->all();
            $input_attr['options'] = $b;
            $storageMode->setTranslation('input_attr', $lang, $input_attr);
        }
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
