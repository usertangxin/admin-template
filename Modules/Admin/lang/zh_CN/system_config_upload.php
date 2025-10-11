<?php

return [
    'upload_allow_divider' => [
        'name'       => '类型限制',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_file' => [
        'name'       => '文件类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_image' => [
        'name'       => '图片类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_video' => [
        'name'       => '视频类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_audio' => [
        'name'       => '音频类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_document' => [
        'name'       => '文稿类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size_divider' => [
        'name'       => '大小限制',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size' => [
        'name'       => '上传文件大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_image' => [
        'name'       => '上传图片大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_video' => [
        'name'       => '上传视频大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_audio' => [
        'name'       => '上传音频大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_document' => [
        'name'       => '上传文稿大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_storage_divider' => [
        'name'  => '存储类型',

        'remark'     => '',
        'input_attr' => null,
    ],
    'storage_mode' => [
        'name'       => '默认存储',
        'remark'     => '',
        'input_attr' => [
            'options' => [['label' => '本地私有', 'value' => 'private'], ['label' => '本地公开', 'value' => 'public']],
        ],
    ],
    'private_status' => [
        'name'       => '本地私有状态',
        'remark'     => '本地私有状态',
        'input_attr' => [
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
    ],
    'public_status' => [
        'name'       => '本地存储状态',
        'remark'     => '本地存储状态',
        'input_attr' => [
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
    ],
    'public_domain' => [
        'name'       => '本地存储域名',
        'remark'     => '本地存储域名',
        'input_attr' => null,
    ],
];
