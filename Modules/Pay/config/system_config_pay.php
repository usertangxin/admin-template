<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;

return [
    [
        'group' => 'pay_config',
        'key'   => 'pay_group',
        'value' => 'wechat_pay',
        'name'  => [
            'zh_CN' => '当前配置',
            'en'    => 'Current Configuration',
        ],
        'input_type'    => SystemConfigInputType::TABS,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '微信支付', 'value' => 'wechat_pay'],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Wechat Payment', 'value' => 'wechat_pay'],
                ],
            ],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'wechat_pay_mch_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '商户号',
            'en'    => 'Merchant ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'wechat_pay_mch_secret_key',
        'value' => null,
        'name'  => [
            'zh_CN' => '商户秘钥',
            'en'    => 'Merchant Secret Key',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'wechat_pay_mch_secret_cert',
        'value' => '',
        'name'  => [
            'zh_CN' => '商户私钥',
            'en'    => 'Merchant Private Key',
        ],
        'input_type' => SystemConfigInputType::UPLOAD_FILE,

        'remark' => [
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => '微信支付私钥，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => 'WeChat Payment Private Key, Do Not Leak'],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'wechat_pay_mch_public_cert',
        'value' => '',
        'name'  => [
            'zh_CN' => '商户公钥',
            'en'    => 'Merchant Public Key',
        ],
        'input_type' => SystemConfigInputType::UPLOAD_FILE,

        'remark' => [
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => '微信支付公钥，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => 'WeChat Payment Public Key, Do Not Leak'],
        ],
    ],
];
