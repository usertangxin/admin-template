<?php

return [
    'storage_mode' => [
        'oss' => '阿里云OSS',
        'qiniu' => '七牛云',
        'cos' => '腾讯云COS',
        's3' => '亚马逊S3',
    ],
    // 亚马逊S3
    's3_status' => [
        'value' => 'disabled',
        'name' => 'S3状态',
        'remark' => 'S3状态',
        'input_attr' => [
            'code' => 'data_status',
            'type' => 'info',
            'merge' => [
                'normal' => [
                    'label' => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://www.amazonaws.cn/s3/" target="_blank">亚马逊S3</a>',
                ],
                'disabled' => [
                    'label' => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    's3_key' => [
        'value' => '',
        'name' => 'Key',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_secret' => [
        'value' => '',
        'name' => 'Secret',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_bucket' => [
        'value' => '',
        'name' => '存储桶',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_dirname' => [
        'value' => '',
        'name' => '目录名',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_domain' => [
        'value' => '',
        'name' => '域名',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_region' => [
        'value' => '',
        'name' => '区域',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_version' => [
        'value' => '',
        'name' => '版本',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_use_path_style_endpoint' => [
        'value' => '',
        'name' => '路径样式端点',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_endpoint' => [
        'value' => '',
        'name' => '端点',
        'remark' => '',
        'input_attr' => null,
    ],
    's3_acl' => [
        'value' => '',
        'name' => '访问控制',
        'remark' => '',
        'input_attr' => null,
    ],
    
    // 七牛云
    'qiniu_status' => [
        'value' => 'disabled',
        'name' => '七牛云状态',
        'remark' => '七牛云状态',
        'input_attr' => [
            'code' => 'data_status',
            'type' => 'info',
            'merge' => [
                'normal' => [
                    'label' => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://developer.qiniu.com/kodo" target="_blank">七牛云</a>',
                ],
                'disabled' => [
                    'label' => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    'qiniu_accessKey' => [
        'value' => '',
        'name' => '七牛Key',
        'remark' => '七牛云存储secretId',
        'input_attr' => null,
    ],
    'qiniu_secretKey' => [
        'value' => '',
        'name' => '七牛Secret',
        'remark' => '七牛云存储secretKey',
        'input_attr' => null,
    ],
    'qiniu_bucket' => [
        'value' => '',
        'name' => '七牛存储桶',
        'remark' => '七牛云存储bucket',
        'input_attr' => null,
    ],
    'qiniu_dirname' => [
        'value' => '',
        'name' => '七牛目录名',
        'remark' => '七牛云存储目录名',
        'input_attr' => null,
    ],
    'qiniu_domain' => [
        'value' => '',
        'name' => '七牛域名',
        'remark' => '七牛云存储域名',
        'input_attr' => null,
    ],
    
    // 阿里云OSS
    'oss_status' => [
        'value' => 'disabled',
        'name' => '阿里云状态',
        'remark' => '阿里云状态',
        'input_attr' => [
            'code' => 'data_status',
            'type' => 'info',
            'merge' => [
                'normal' => [
                    'label' => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://help.aliyun.com/zh/oss/" target="_blank">阿里云</a>',
                ],
                'disabled' => [
                    'label' => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    'oss_accessKeyId' => [
        'value' => '',
        'name' => '阿里ID',
        'remark' => '阿里云存储accessKeyId',
        'input_attr' => null,
    ],
    'oss_accessKeySecret' => [
        'value' => '',
        'name' => '阿里Secret',
        'remark' => '阿里云存储accessKeySecret',
        'input_attr' => null,
    ],
    'oss_bucket' => [
        'value' => '',
        'name' => '阿里存储桶',
        'remark' => '阿里云存储bucket',
        'input_attr' => null,
    ],
    'oss_dirname' => [
        'value' => '',
        'name' => '阿里目录名',
        'remark' => '阿里云存储目录名',
        'input_attr' => null,
    ],
    'oss_domain' => [
        'value' => '',
        'name' => '阿里域名',
        'remark' => '阿里云存储域名',
        'input_attr' => null,
    ],
    'oss_endpoint' => [
        'value' => '',
        'name' => '阿里端点',
        'remark' => '阿里云存储endpoint',
        'input_attr' => null,
    ],
    
    // 腾讯云COS
    'cos_status' => [
        'value' => 'disabled',
        'name' => '腾讯云状态',
        'remark' => '腾讯云状态',
        'input_attr' => [
            'code' => 'data_status',
            'type' => 'info',
            'merge' => [
                'normal' => [
                    'label' => '启用',
                    'remark' => '正常上传文件</br>更多信息请访问<a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://cloud.tencent.com/document/product/436" target="_blank">腾讯云</a>',
                ],
                'disabled' => [
                    'label' => '停用',
                    'remark' => '上传到此存储将不可用</br>已上传文件不受影响',
                ],
            ],
        ],
    ],
    'cos_secretId' => [
        'value' => '',
        'name' => '腾讯ID',
        'remark' => '腾讯云存储secretId',
        'input_attr' => null,
    ],
    'cos_secretKey' => [
        'value' => '',
        'name' => '腾讯Key',
        'remark' => '腾讯云secretKey',
        'input_attr' => null,
    ],
    'cos_bucket' => [
        'value' => '',
        'name' => '腾讯存储桶',
        'remark' => '腾讯云存储bucket',
        'input_attr' => null,
    ],
    'cos_dirname' => [
        'value' => '',
        'name' => '腾讯目录名',
        'remark' => '腾讯云存储目录名',
        'input_attr' => null,
    ],
    'cos_domain' => [
        'value' => '',
        'name' => '腾讯域名',
        'remark' => '腾讯云存储域名',
        'input_attr' => null,
    ],
    'cos_region' => [
        'value' => '',
        'name' => '腾讯区域',
        'remark' => '腾讯云存储region',
        'input_attr' => null,
    ],
];