<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 腾讯云
    |--------------------------------------------------------------------------
    */
    [
        'group'              => 'upload_config',
        'key'                => 'cos_status',
        'value'              => 'disabled',
        'name'               => '腾讯云状态',
        'input_type'         => SystemConfigInputType::DICT_RADIO,
        'config_select_data' => [
            ['label' => '启用', 'value' => 'normal'],
            ['label' => '停用', 'value' => 'disabled'],
        ],
        'remark'        => '腾讯云状态',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://cloud.tencent.com/document/product/436" target="_blank">腾讯云</a>',
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
        'key'                => 'cos_secretId',
        'value'              => '',
        'name'               => '腾讯Id',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云存储secretId',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'cos_secretKey',
        'value'              => '',
        'name'               => '腾讯key',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云secretKey',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'cos_bucket',
        'value'              => '',
        'name'               => '腾讯bucket',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云存储bucket',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'cos_dirname',
        'value'              => '',
        'name'               => '腾讯dirname',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云存储dirname',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'cos_domain',
        'value'              => '',
        'name'               => '腾讯domain',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云存储domain',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
    [
        'group'              => 'upload_config',
        'key'                => 'cos_region',
        'value'              => '',
        'name'               => '腾讯region',
        'input_type'         => SystemConfigInputType::INPUT,
        'config_select_data' => null,
        'remark'             => '腾讯云存储region',
        'bind_p_config'      => 'storage_mode',
        'input_attr'         => null,
    ],
];
