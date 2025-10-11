<?php

return [
    'wechat_group' => [
        'name'       => '当前配置',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => '小程序', 'value' => 'wechat_mini'],
                ['label' => '公众号', 'value' => 'wechat_official'],
                ['label' => '支付', 'value' => 'wechat_pay'],
            ],
        ],
    ],
    'wechat_mini_app_id' => [
        'name'       => 'app id',
        'remark'     => '微信小程序app id',
        'input_attr' => null,
    ],
    'wechat_mini_secret' => [
        'name'  => 'secret',

        'remark'     => '微信小程序secret',
        'input_attr' => null,
    ],
    'wechat_official_app_id' => [
        'name'  => 'app id',

        'remark'     => '微信公众号app id',
        'input_attr' => null,
    ],
    'wechat_official_secret' => [
        'name'  => 'secret',

        'remark'     => '微信公众号secret',
        'input_attr' => null,
    ],
    'wechat_pay_mch_id' => [
        'name'  => '商户号',

        'remark'     => '',
        'input_attr' => null,
    ],
    'wechat_pay_mch_secret_key' => [
        'name'  => '商户秘钥',

        'remark'     => '',
        'input_attr' => null,
    ],
    'wechat_pay_mch_secret_cert' => [
        'name'       => '商户私钥',
        'remark'     => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看',
        'input_attr' => ['storage-mode' => 'private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => '微信支付私钥，请勿泄露'],
    ],
    'wechat_pay_mch_public_cert' => [
        'name'       => '商户公钥',
        'remark'     => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看',
        'input_attr' => ['storage-mode' => 'private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => '微信支付公钥，请勿泄露'],
    ],
];
