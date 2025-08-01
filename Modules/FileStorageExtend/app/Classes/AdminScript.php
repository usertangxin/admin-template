<?php

namespace Modules\FileStorageExtend\Classes;

use Illuminate\Support\Arr;
use Modules\Admin\Classes\Interfaces\AdminScriptInterface;
use Modules\Admin\Classes\Utils\SystemConfigUtil;
use Modules\Admin\Classes\Utils\SystemDictUtil;
use Modules\Admin\Models\SystemConfig;

class AdminScript implements AdminScriptInterface
{
    protected $configs = [];

    protected $update_storage_mode_config_select_data = [
        ['label' => '阿里云OSS', 'value' => 'oss'],
        ['label' => '七牛云',    'value' => 'qiniu'],
        ['label' => '腾讯云COS', 'value' => 'cos'],
        ['label' => '亚马逊S3',  'value' => 's3'],
    ];

    public function __construct()
    {
        $storage_mode_oss   = config('file_storage_extend.storage_mode_oss');
        $storage_mode_cos   = config('file_storage_extend.storage_mode_cos');
        $storage_mode_s3    = config('file_storage_extend.storage_mode_s3');
        $storage_mode_qiniu = config('file_storage_extend.storage_mode_qiniu');
        $this->configs      = array_merge($storage_mode_qiniu, $storage_mode_oss, $storage_mode_cos, $storage_mode_s3);
    }

    public function install()
    {
        SystemConfigUtil::autoResisterConfig($this->configs);
        $a = SystemConfig::where('key', 'storage_mode')->first();
        if ($a) {
            $data_config_select_data = $a->config_select_data;
            $data_config_select_data = array_merge($data_config_select_data, $this->update_storage_mode_config_select_data);
            $merged                  = Arr::keyBy($data_config_select_data, 'value');
            foreach ($this->update_storage_mode_config_select_data as $item) {
                $merged[$item['value']] = $item;
            }
            $merged                = array_values($merged);
            $a->config_select_data = $merged;
            $a->save();
        } else {
            echo '存储模式配置不存在';
        }

        SystemDictUtil::autoRegisterDicts(config('file_storage_extend.dict'));
    }

    public function uninstall()
    {
        SystemConfigUtil::autoUnregisterConfig($this->configs);
        $a = SystemConfig::where('key', 'storage_mode')->first();
        if ($a) {
            $data_config_select_data = $a->config_select_data;
            $excludeValues           = Arr::pluck($this->update_storage_mode_config_select_data, 'value');
            $filtered                = Arr::where($data_config_select_data, function ($item) use ($excludeValues) {
                return ! in_array($item['value'], $excludeValues);
            });
            $a->config_select_data = $filtered;
            $a->save();
        } else {
            echo '存储模式配置不存在';
        }
        SystemDictUtil::autoUnregisterDicts(config('file_storage_extend.dict'));
    }
}
