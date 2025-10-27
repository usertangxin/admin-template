<?php

use Modules\Admin\Classes\Utils\SystemConfigInputType;
use Yansongda\Pay\Pay;

return [
    [
        'group' => 'pay_config',
        'key'   => 'pay_group',
        'value' => 'pay_wechat',
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
                    ['label' => '微信支付', 'value' => 'pay_wechat'],
                    ['label' => '支付宝支付', 'value' => 'pay_alipay'],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Wechat Payment', 'value' => 'pay_wechat'],
                    ['label' => 'Alipay Payment', 'value' => 'pay_alipay'],
                ],
            ],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_mch_id',
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
        'key'   => 'pay_wechat_mch_secret_key',
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
        'key'   => 'pay_wechat_mch_secret_cert',
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
        'key'   => 'pay_wechat_mch_public_cert',
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
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_mp_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '公众号 APPID',
            'en'    => 'WeChat MP APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_mini_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '小程序 APPID',
            'en'    => 'WeChat Mini APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => 'APPID',
            'en'    => 'WeChat APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_mode',
        'value' => Pay::MODE_NORMAL,
        'name'  => [
            'zh_CN' => '运行模式',
            'en'    => 'Running Mode',
        ],
        'input_type' => SystemConfigInputType::RADIO,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '正常模式', 'value' => Pay::MODE_NORMAL . ''],
                    ['label' => '服务商模式', 'value' => Pay::MODE_SERVICE . ''],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Normal Mode', 'value' => Pay::MODE_NORMAL . ''],
                    ['label' => 'Service Mode', 'value' => Pay::MODE_SERVICE . ''],
                ],
            ],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_sub_mp_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '子公众号 APPID',
            'en'    => 'WeChat Sub MP APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_sub_mini_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '子小程序 APPID',
            'en'    => 'WeChat Sub Mini APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_sub_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '子应用 APPID',
            'en'    => 'WeChat Sub App APPID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_sub_mch_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '子商户 MCHID',
            'en'    => 'WeChat Sub Merchant MCHID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],


    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '应用ID',
            'en'    => 'Application ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_app_secret_cert',
        'value' => '',
        'name'  => [
            'zh_CN' => '应用私钥',
            'en'    => 'Application Private Key',
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
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_app_public_cert_path',
        'value' => '',
        'name'  => [
            'zh_CN' => '应用公钥证书',
            'en'    => 'Application Public Key Certificate',
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
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_public_cert_path',
        'value' => '',
        'name'  => [
            'zh_CN' => '公钥证书',
            'en'    => 'Public Key Certificate',
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
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_root_cert_path',
        'value' => '',
        'name'  => [
            'zh_CN' => '根证书',
            'en'    => 'Root Certificate',
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
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_mode',
        'value' => Pay::MODE_NORMAL,
        'name'  => [
            'zh_CN' => '运行模式',
            'en'    => 'Running Mode',
        ],
        'input_type' => SystemConfigInputType::RADIO,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '正常模式', 'value' => Pay::MODE_NORMAL . ''],
                    ['label' => '沙箱模式', 'value' => Pay::MODE_SANDBOX . ''],
                    ['label' => '服务商模式', 'value' => Pay::MODE_SERVICE . ''],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Normal Mode', 'value' => Pay::MODE_NORMAL . ''],
                    ['label' => 'Sandbox Mode', 'value' => Pay::MODE_SANDBOX . ''],
                    ['label' => 'Service Mode', 'value' => Pay::MODE_SERVICE . ''],
                ],
            ],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_service_provider_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '服务商ID',
            'en'    => 'Service Provider ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark'        => '',
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
];
