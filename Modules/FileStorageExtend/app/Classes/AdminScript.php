<?php

namespace Modules\FileStorageExtend\Classes;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Modules\Admin\Classes\Utils\SystemConfigUtil;
use Modules\Admin\Classes\Utils\SystemDictUtil;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Modules\Admin\Models\SystemConfig;
use Modules\Admin\Models\SystemDict;
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
        SystemConfigUtil::autoResisterConfig($this->configs);
        SystemConfigUtil::autoEnableConfig($this->configs);
        SystemConfigUtil::configSelectDataSave('storage_mode', $this->update_storage_mode_config_select_data);

        SystemDictUtil::autoRegisterDicts($this->dicts);
    }

    public function disable(Module $module)
    {
        $select_data = \collect($this->update_storage_mode_config_select_data)->map(function ($item) {
            $item['disabled'] = true;

            return $item;
        })->toArray();
        SystemConfigUtil::configSelectDataSave('storage_mode', $select_data);
        SystemConfigUtil::autoDisableConfig($this->configs);
        foreach ($this->dicts as $dict) {
            SystemDict::whereCode($dict['code'])->whereValue($dict['value'])->update(['status' => 'disabled']);
        }
    }

    public function delete(Module $module)
    {
        SystemConfigUtil::autoUnregisterConfig($this->configs);
        SystemConfigUtil::configSelectDataRemove('storage_mode', $this->update_storage_mode_config_select_data);
        SystemDictUtil::autoUnregisterDicts($this->dicts);
    }
}
