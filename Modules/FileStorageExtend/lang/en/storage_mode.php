<?php

return [
    'storage_mode' => [
        'oss'   => 'Alibaba Cloud OSS',
        'qiniu' => 'Qiniu Cloud',
        'cos'   => 'Tencent Cloud COS',
        's3'    => 'Amazon S3',
    ],
    // Amazon S3
    's3_status' => [
        'value'      => 'disabled',
        'name'       => 'S3 Status',
        'remark'     => 'S3 Status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enable',
                    'remark' => 'Normal file upload</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://www.amazonaws.cn/s3/" target="_blank">Amazon S3</a>',
                ],
                'disabled' => [
                    'label'  => 'Disable',
                    'remark' => 'Upload to this storage will not be available</br>Uploaded files will not be affected',
                ],
            ],
        ],
    ],
    's3_key' => [
        'value'      => '',
        'name'       => 'Key',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_secret' => [
        'value'      => '',
        'name'       => 'Secret',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_bucket' => [
        'value'      => '',
        'name'       => 'Bucket',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_dirname' => [
        'value'      => '',
        'name'       => 'Directory Name',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_domain' => [
        'value'      => '',
        'name'       => 'Domain',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_region' => [
        'value'      => '',
        'name'       => 'Region',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_version' => [
        'value'      => '',
        'name'       => 'Version',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_use_path_style_endpoint' => [
        'value'      => '',
        'name'       => 'Path Style Endpoint',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_endpoint' => [
        'value'      => '',
        'name'       => 'Endpoint',
        'remark'     => '',
        'input_attr' => null,
    ],
    's3_acl' => [
        'value'      => '',
        'name'       => 'ACL',
        'remark'     => '',
        'input_attr' => null,
    ],

    // Qiniu
    'qiniu_status' => [
        'value'      => 'disabled',
        'name'       => 'Qiniu Status',
        'remark'     => 'Qiniu Status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enable',
                    'remark' => 'Normal file upload</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://developer.qiniu.com/kodo" target="_blank">Qiniu</a>',
                ],
                'disabled' => [
                    'label'  => 'Disable',
                    'remark' => 'Upload to this storage will not be available</br>Uploaded files will not be affected',
                ],
            ],
        ],
    ],
    'qiniu_accessKey' => [
        'value'      => '',
        'name'       => 'Qiniu Key',
        'remark'     => 'Qiniu storage secretId',
        'input_attr' => null,
    ],
    'qiniu_secretKey' => [
        'value'      => '',
        'name'       => 'Qiniu Secret',
        'remark'     => 'Qiniu storage secretKey',
        'input_attr' => null,
    ],
    'qiniu_bucket' => [
        'value'      => '',
        'name'       => 'Qiniu Bucket',
        'remark'     => 'Qiniu storage bucket',
        'input_attr' => null,
    ],
    'qiniu_dirname' => [
        'value'      => '',
        'name'       => 'Qiniu Directory Name',
        'remark'     => 'Qiniu storage directory name',
        'input_attr' => null,
    ],
    'qiniu_domain' => [
        'value'      => '',
        'name'       => 'Qiniu Domain',
        'remark'     => 'Qiniu storage domain',
        'input_attr' => null,
    ],

    // Alibaba Cloud OSS
    'oss_status' => [
        'value'      => 'disabled',
        'name'       => 'OSS Status',
        'remark'     => 'Alibaba Cloud Status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enable',
                    'remark' => 'Normal file upload</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://help.aliyun.com/zh/oss/" target="_blank">Alibaba Cloud</a>',
                ],
                'disabled' => [
                    'label'  => 'Disable',
                    'remark' => 'Upload to this storage will not be available</br>Uploaded files will not be affected',
                ],
            ],
        ],
    ],
    'oss_accessKeyId' => [
        'value'      => '',
        'name'       => 'Alibaba ID',
        'remark'     => 'Alibaba Cloud storage accessKeyId',
        'input_attr' => null,
    ],
    'oss_accessKeySecret' => [
        'value'      => '',
        'name'       => 'Alibaba Secret',
        'remark'     => 'Alibaba Cloud storage accessKeySecret',
        'input_attr' => null,
    ],
    'oss_bucket' => [
        'value'      => '',
        'name'       => 'Alibaba Bucket',
        'remark'     => 'Alibaba Cloud storage bucket',
        'input_attr' => null,
    ],
    'oss_dirname' => [
        'value'      => '',
        'name'       => 'Alibaba Directory Name',
        'remark'     => 'Alibaba Cloud storage directory name',
        'input_attr' => null,
    ],
    'oss_domain' => [
        'value'      => '',
        'name'       => 'Alibaba Domain',
        'remark'     => 'Alibaba Cloud storage domain',
        'input_attr' => null,
    ],
    'oss_endpoint' => [
        'value'      => '',
        'name'       => 'Alibaba Endpoint',
        'remark'     => 'Alibaba Cloud storage endpoint',
        'input_attr' => null,
    ],

    // Tencent Cloud COS
    'cos_status' => [
        'value'      => 'disabled',
        'name'       => 'COS Status',
        'remark'     => 'Tencent Cloud Status',
        'input_attr' => [
            'code'  => 'data_status',
            'type'  => 'info',
            'merge' => [
                'normal' => [
                    'label'  => 'Enable',
                    'remark' => 'Normal file upload</br>For more information, please visit <a class="arco-link arco-link-status-normal" style="padding: 0 2px;line-height:1;" href="https://cloud.tencent.com/document/product/436" target="_blank">Tencent Cloud</a>',
                ],
                'disabled' => [
                    'label'  => 'Disable',
                    'remark' => 'Upload to this storage will not be available</br>Uploaded files will not be affected',
                ],
            ],
        ],
    ],
    'cos_secretId' => [
        'value'      => '',
        'name'       => 'Tencent ID',
        'remark'     => 'Tencent Cloud storage secretId',
        'input_attr' => null,
    ],
    'cos_secretKey' => [
        'value'      => '',
        'name'       => 'Tencent Key',
        'remark'     => 'Tencent Cloud secretKey',
        'input_attr' => null,
    ],
    'cos_bucket' => [
        'value'      => '',
        'name'       => 'Tencent Bucket',
        'remark'     => 'Tencent Cloud storage bucket',
        'input_attr' => null,
    ],
    'cos_dirname' => [
        'value'      => '',
        'name'       => 'Tencent Directory Name',
        'remark'     => 'Tencent Cloud storage directory name',
        'input_attr' => null,
    ],
    'cos_domain' => [
        'value'      => '',
        'name'       => 'Tencent Domain',
        'remark'     => 'Tencent Cloud storage domain',
        'input_attr' => null,
    ],
    'cos_region' => [
        'value'      => '',
        'name'       => 'Tencent Region',
        'remark'     => 'Tencent Cloud storage region',
        'input_attr' => null,
    ],
];
