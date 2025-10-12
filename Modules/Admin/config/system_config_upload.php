<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    /*
    |--------------------------------------------------------------------------
    | 类型限制
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'name'  => [
            'zh_CN' => '类型限制',
            'en'    => 'Type Restriction',
        ],
        'input_type' => SystemConfigInputType::DIVIDER,
        'key'        => 'upload_allow_divider',
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_allow_file',
        'value' => 'jpg,jpeg,png,gif,svg,bmp,doc,docx,xls,xlsx,ppt,pptx,pdf,md,mp3,mp4,mov',
        'name'  => [
            'zh_CN' => '文件类型',
            'en'    => 'File Type',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_allow_image',
        'value' => 'jpg,jpeg,png,gif,svg,bmp',
        'name'  => [
            'zh_CN' => '图片类型',
            'en'    => 'Image Type',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_allow_video',
        'value' => 'mp4',
        'name'  => [
            'zh_CN' => '视频类型',
            'en'    => 'Video Type',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_allow_audio',
        'value' => 'mp3',
        'name'  => [
            'zh_CN' => '音频类型',
            'en'    => 'Audio Type',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_allow_document',
        'value' => 'txt,doc,docx,xls,xlsx,ppt,pptx,pdf,md,pem',
        'name'  => [
            'zh_CN' => '文稿类型',
            'en'    => 'Document Type',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 大小限制
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'name'  => [
            'zh_CN' => '大小限制',
            'en'    => 'Size Restriction',
        ],
        'input_type' => SystemConfigInputType::DIVIDER,
        'key'        => 'upload_size_divider',
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_size',
        'value' => '10485760',
        'name'  => [
            'zh_CN' => '上传文件大小',
            'en'    => 'Upload File Size',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '单位Byte,1MB=1024*1024Byte',
            'en'    => 'Unit Byte, 1MB=1024*1024Byte',
        ],
        'bind_p_config' => null,
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_size_image',
        'value' => '1048576',
        'name'  => [
            'zh_CN' => '上传图片大小',
            'en'    => 'Upload Image Size',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '单位Byte,1MB=1024*1024Byte',
            'en'    => 'Unit Byte, 1MB=1024*1024Byte',
        ],
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_size_video',
        'value' => '10485760',
        'name'  => [
            'zh_CN' => '上传视频大小',
            'en'    => 'Upload Video Size',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '单位Byte,1MB=1024*1024Byte',
            'en'    => 'Unit Byte, 1MB=1024*1024Byte',
        ],
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_size_audio',
        'value' => '10485760',
        'name'  => [
            'zh_CN' => '上传音频大小',
            'en'    => 'Upload Audio Size',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '单位Byte,1MB=1024*1024Byte',
            'en'    => 'Unit Byte, 1MB=1024*1024Byte',
        ],
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    [
        'group' => 'upload_config',
        'key'   => 'upload_size_document',
        'value' => '10485760',
        'name'  => [
            'zh_CN' => '上传文稿大小',
            'en'    => 'Upload Document Size',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '单位Byte,1MB=1024*1024Byte',
            'en'    => 'Unit Byte, 1MB=1024*1024Byte',
        ],
        'bind_p_config' => '',
        'input_attr'    => null,
    ],
    /*
    |--------------------------------------------------------------------------
    | 存储类型
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'name'  => [
            'zh_CN' => '存储类型',
            'en'    => 'Storage Type',
        ],
        'input_type' => SystemConfigInputType::DIVIDER,
        'key'        => 'upload_storage_divider',
    ],
    [
        'group' => 'upload_config',
        'key'   => 'storage_mode',
        'value' => 'public',
        'name'  => [
            'zh_CN' => '默认存储',
            'en'    => 'Default Storage',
        ],
        'input_type'    => SystemConfigInputType::RADIO,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [['label' => '本地私有', 'value' => 'private'], ['label' => '本地公开', 'value' => 'public']],
            ],
            'en' => [
                'options' => [['label' => 'Private', 'value' => 'private'], ['label' => 'Public', 'value' => 'public']],
            ],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 本地私有
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 'private_status',
        'value' => 'normal',
        'name'  => [
            'zh_CN' => '本地私有状态',
            'en'    => 'Private Storage Status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => '本地私有状态',
            'en'    => 'Private Storage Status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => '启用',
                        'remark' => '正常上传文件</br>此存储外部无法访问',
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
                        'remark' => 'Normal upload file</br>This storage is not accessible externally',
                    ],
                    'disabled' => [
                        'label'  => 'Disabled',
                        'remark' => 'Upload to this storage will be disabled</br>Existing uploaded files are not affected',
                    ],
                ],
            ],
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | 存储类型 - 本地公开
    |--------------------------------------------------------------------------
    */
    [
        'group' => 'upload_config',
        'key'   => 'public_status',
        'value' => 'normal',
        'name'  => [
            'zh_CN' => '本地存储状态',
            'en'    => 'Public Storage Status',
        ],
        'input_type' => SystemConfigInputType::DICT_RADIO,
        'remark'     => [
            'zh_CN' => '本地存储状态',
            'en'    => 'Public Storage Status',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => [
            'zh_CN' => [
                'code'  => 'data_status',
                'type'  => 'info',
                'merge' => [
                    'normal' => [
                        'label'  => '启用',
                        'remark' => '正常上传文件对外可访问</br><a class="arco-link" style="padding:0;line-height:1" href="javascript:request.post(route(`web.admin.SystemUploadFile.gen-symlink`))">点击生成软链</a>',
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
                        'remark' => 'Normal upload file is accessible externally</br><a class="arco-link" style="padding:0;line-height:1" href="javascript:request.post(route(`web.admin.SystemUploadFile.gen-symlink`))">Click to generate symlink</a>',
                    ],
                    'disabled' => [
                        'label'  => 'Disabled',
                        'remark' => 'Upload to this storage will be disabled</br>Existing uploaded files are not affected',
                    ],
                ],
            ],
        ],
    ],
    [
        'group'      => 'upload_config',
        'key'        => 'public_domain',
        'value'      => 'http://127.0.0.1:8000',
        'name'       => [
            'zh_CN' => '本地存储域名',
            'en'    => 'Public Storage Domain',
        ],
        'input_type' => SystemConfigInputType::INPUT,
        'remark'     => [
            'zh_CN' => '本地存储域名',
            'en'    => 'Public Storage Domain',
        ],
        'bind_p_config' => 'storage_mode',
        'input_attr'    => null,
    ],

];
