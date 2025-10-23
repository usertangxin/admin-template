<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 七牛云
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 'upload_qiniu_status',
        'value' => 'disabled',
        'name'  => [
            'zh_CN' => '七牛云状态',
            'en'    => 'Qiniu Cloud status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => '七牛云状态',
            'en'    => 'Qiniu Cloud status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
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
            'en' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => 'Enabled',
                        'remark' => 'Normal upload file</br>More information please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://developer.qiniu.com/kodo" target="_blank">Qiniu Cloud</a>',
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
        'key'   => 'upload_qiniu_accessKey',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛key',
            'en'    => 'Qiniu accessKey',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '七牛云存储secretId',
            'en'    => 'Qiniu Cloud secretId',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_qiniu_secretKey',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛secret',
            'en'    => 'Qiniu secretKey',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '七牛云存储secretKey',
            'en'    => 'Qiniu Cloud secretKey',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_qiniu_bucket',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛bucket',
            'en'    => 'Qiniu bucket',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '七牛云存储bucket',
            'en'    => 'Qiniu Cloud bucket',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_qiniu_dirname',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛dirname',
            'en'    => 'Qiniu dirname',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '七牛云存储dirname',
            'en'    => 'Qiniu Cloud dirname',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_qiniu_domain',
        'value' => '',
        'name'  => [
            'zh_CN' => '七牛domain',
            'en'    => 'Qiniu domain',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '七牛云存储domain',
            'en'    => 'Qiniu Cloud domain',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],
];
