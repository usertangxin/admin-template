<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 腾讯云
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 'cos_status',
        'value' => 'disabled',
        'name'  => [
            'zh_CN' => '腾讯云状态',
            'en'    => 'Tencent Cloud Status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => '腾讯云状态',
            'en'    => 'Tencent Cloud Status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
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
            'en' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => 'Enabled',
                        'remark' => 'Normal upload file</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://cloud.tencent.com/document/product/436" target="_blank">Tencent Cloud</a>',
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
        'key'   => 'cos_secretId',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯Id',
            'en'    => 'Tencent Cloud Id',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云存储secretId',
            'en'    => 'Tencent Cloud Storage secretId',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'cos_secretKey',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯key',
            'en'    => 'Tencent Cloud Storage secretKey',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云secretKey',
            'en'    => 'Tencent Cloud Storage secretKey',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'cos_bucket',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯bucket',
            'en'    => 'Tencent Cloud Storage bucket',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云存储bucket',
            'en'    => 'Tencent Cloud Storage bucket',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'cos_dirname',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯dirname',
            'en'    => 'Tencent Cloud Storage dirname',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云存储dirname',
            'en'    => 'Tencent Cloud Storage dirname',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'cos_domain',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯domain',
            'en'    => 'Tencent Cloud Storage domain',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云存储domain',
            'en'    => 'Tencent Cloud Storage domain',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'cos_region',
        'value' => '',
        'name'  => [
            'zh_CN' => '腾讯region',
            'en'    => 'Tencent Cloud Storage region',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '腾讯云存储region',
            'en'    => 'Tencent Cloud Storage region',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
];
