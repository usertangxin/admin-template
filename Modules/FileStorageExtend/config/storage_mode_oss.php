<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 阿里云
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 'oss_status',
        'value' => 'disabled',
        'name'  => [
            'zh_CN' => '阿里云状态',
            'en'    => 'Aliyun OSS Status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => '阿里云状态',
            'en'    => 'Aliyun OSS Status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
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
            'en' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => 'Enabled',
                        'remark' => 'Normal upload file</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://help.aliyun.com/zh/oss/" target="_blank">Aliyun</a>',
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
        'group' => 'upload_config',
        'key'   => 'oss_accessKeyId',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里Id',
            'en'    => 'Aliyun OSS accessKeyId',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '阿里云存储accessKeyId',
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'oss_accessKeySecret',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里Secret',
            'en'    => 'Aliyun OSS accessKeySecret',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '阿里云存储accessKeySecret',
            'en'    => 'Aliyun OSS accessKeySecret',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'oss_bucket',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里bucket',
            'en'    => 'Aliyun OSS bucket',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '阿里云存储bucket',
            'en'    => 'Aliyun OSS bucket',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'oss_dirname',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里dirname',
            'en'    => 'Aliyun OSS dirname',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '阿里云存储dirname',
            'en'    => 'Aliyun OSS dirname',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'oss_domain',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里domain',
            'en'    => 'Aliyun OSS domain',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '阿里云存储domain',
            'en'    => 'Aliyun OSS domain',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'oss_endpoint',
        'value' => '',
        'name'  => [
            'zh_CN' => '阿里endpoint',
            'en'    => 'Aliyun OSS endpoint',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '阿里云存储endpoint',
            'en'    => 'Aliyun OSS endpoint',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
];
