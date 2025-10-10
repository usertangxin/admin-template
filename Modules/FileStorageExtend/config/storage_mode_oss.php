<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 阿里云
    |--------------------------------------------------------------------------
    */
    [
        'group'         => 'upload_config',
        'key'           => 'oss_status',
        'value'         => 'disabled',
        'name'          => '阿里云状态',
        'input_type'    => SystemConfigInputType::DICT_RADIO,
        'remark'        => '阿里云状态',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://help.aliyun.com/zh/oss/" target="_blank">阿里云</a>',
                ],
                'disabled' => [
                    'label'  => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_accessKeyId',
        'value'      => '',
        'name'       => '阿里Id',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储accessKeyId',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_accessKeySecret',
        'value'      => '',
        'name'       => '阿里Secret',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储accessKeySecret',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_bucket',
        'value'      => '',
        'name'       => '阿里bucket',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储bucket',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_dirname',
        'value'      => '',
        'name'       => '阿里dirname',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储dirname',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_domain',
        'value'      => '',
        'name'       => '阿里domain',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储domain',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'oss_endpoint',
        'value'      => '',
        'name'       => '阿里endpoint',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储endpoint',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
];
