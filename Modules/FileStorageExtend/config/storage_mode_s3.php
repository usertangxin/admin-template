<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 亚马逊s3
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 's3_status',
        'value' => 'disabled',
        'name'  => [
            'zh_CN' => 's3状态',
            'en'    => 'S3 status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => 's3状态',
            'en'    => 'S3 status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => '启用',
                        'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://www.amazonaws.cn/s3/" target="_blank">亚马逊s3</a>',
                    ],
                    'disabled' => [
                        'label'  => '停用',
                        'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                    ],
                ],
            ],
            'en' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => 'Enabled',
                        'remark' => 'Normal upload file</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://www.amazonaws.cn/s3/" target="_blank">Amazon S3</a>',
                    ],
                    'disabled' => [
                        'label'  => 'Disabled',
                        'remark' => 'Upload to this storage will be disabled</br>Uploaded files will not be affected',
                    ],
                ],
            ],
        ],
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_key',
        'value'      => '',
        'name'       => 'key',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_secret',
        'value'      => '',
        'name'       => 'secret',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_bucket',
        'value'      => '',
        'name'       => 'bucket',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_dirname',
        'value'      => '',
        'name'       => 'dirname',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_domain',
        'value'      => '',
        'name'       => 'domain',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_region',
        'value'      => '',
        'name'       => 'region',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_version',
        'value'      => '',
        'name'       => 'version',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_use_path_style_endpoint',
        'value'      => '',
        'name'       => 'path_style_endpoint',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_endpoint',
        'value'      => '',
        'name'       => 'endpoint',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group'      => 'upload_config',
        'key'        => 's3_acl',
        'value'      => '',
        'name'       => 'acl',
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
];
