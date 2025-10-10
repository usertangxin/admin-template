<?php

return [
    'upload_allow_divider' => [
        'value'      => '',
        'name'       => '类型限制',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_file' => [
        'value'      => 'jpg,jpeg,png,gif,svg,bmp,doc,docx,xls,xlsx,ppt,pptx,pdf,md,mp3,mp4,mov',
        'name'       => '文件类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_image' => [
        'value'      => 'jpg,jpeg,png,gif,svg,bmp',
        'name'       => '图片类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_video' => [
        'value'      => 'mp4',
        'name'       => '视频类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_audio' => [
        'value'      => 'mp3',
        'name'       => '音频类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_allow_document' => [
        'value'      => 'txt,doc,docx,xls,xlsx,ppt,pptx,pdf,md,pem',
        'name'       => '文稿类型',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size_divider' => [
        'value'      => '',
        'name'       => '大小限制',
        'remark'     => '',
        'input_attr' => null,
    ],
    'upload_size' => [
        'value'      => '10485760',
        'name'       => '上传文件大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_image' => [
        'value'      => '1048576',
        'name'       => '上传图片大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_video' => [
        'value'      => '10485760',
        'name'       => '上传视频大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_audio' => [
        'value'      => '10485760',
        'name'       => '上传音频大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_size_document' => [
        'value'      => '10485760',
        'name'       => '上传文稿大小',
        'remark'     => '单位Byte,1MB=1024*1024Byte',
        'input_attr' => null,
    ],
    'upload_storage_divider' => [
        'value' => '',
        'name'  => '存储类型',

        'remark'     => '',
        'input_attr' => null,
    ],
    'storage_mode' => [
        'value'      => 'public',
        'name'       => '默认存储',
        'remark'     => '',
        'input_attr' => [
            'options' => [['label' => '本地私有', 'value' => 'private'], ['label' => '本地公开', 'value' => 'public']],
        ],
    ],
    'private_status' => [
        'value'      => 'normal',
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
        'value'      => 'normal',
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
        'value'      => 'http://127.0.0.1:8000',
        'name'       => '本地存储域名',
        'remark'     => '本地存储域名',
        'input_attr' => null,
    ],
];
