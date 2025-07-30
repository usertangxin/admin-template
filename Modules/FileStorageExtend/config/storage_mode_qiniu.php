<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 七牛云
    |--------------------------------------------------------------------------
    */
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_status',
        'value'              => 'disabled',
        'name'               => '七牛云状态',
        'input_type'         => SystemConfigInputType::DICT_RADIO,
        'config_select_data' => [
            ['label' => '启用', 'value' => 'normal'],
            ['label' => '停用', 'value' => 'disabled'],
        ],
        'remark'        => '七牛云状态',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://developer.qiniu.com/kodo" target="_blank">七牛云</a>',
                ],
                'disabled' => [
                    'label'  => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_accessKey',
        'value'              => '',
        'name'               => '七牛key',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '七牛云存储secretId',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_secretKey',
        'value'              => '',
        'name'               => '七牛secret',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '七牛云存储secretKey',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_bucket',
        'value'              => '',
        'name'               => '七牛bucket',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '七牛云存储bucket',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_dirname',
        'value'              => '',
        'name'               => '七牛dirname',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '七牛云存储dirname',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'qiniu_domain',
        'value'              => '',
        'name'               => '七牛domain',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '七牛云存储domain',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
];
