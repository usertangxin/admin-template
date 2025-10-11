<?php

return [
    'wechat_group' => [
        'name'       => 'Current Configuration',
        'remark'     => '',
        'input_attr' => [
            'options' => [
                ['label' => 'Mini Program', 'value' => 'wechat_mini'],
                ['label' => 'Official Account', 'value' => 'wechat_official'],
                ['label' => 'Payment', 'value' => 'wechat_pay'],
            ],
        ],
    ],
    'wechat_mini_app_id' => [

        'name'  => 'app id',

        'remark'     => 'WeChat Mini Program app id',
        'input_attr' => null,
    ],
    'wechat_mini_secret' => [

        'name'  => 'secret',

        'remark'     => 'WeChat Mini Program secret',
        'input_attr' => null,
    ],
    'wechat_official_app_id' => [

        'name'  => 'app id',

        'remark'     => 'WeChat Official Account app id',
        'input_attr' => null,
    ],
    'wechat_official_secret' => [

        'name'  => 'secret',

        'remark'     => 'WeChat Official Account secret',
        'input_attr' => null,
    ],
    'wechat_pay_mch_id' => [

        'name'  => 'Merchant ID',

        'remark'     => '',
        'input_attr' => null,
    ],
    'wechat_pay_mch_secret_key' => [

        'name'  => 'Merchant Secret Key',

        'remark'     => '',
        'input_attr' => null,
    ],
    'wechat_pay_mch_secret_cert' => [

        'name'  => 'Merchant Private Key',

        'remark'     => 'Uploaded files are stored in the local private disk. You cannot directly preview the file. To preview, go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link for viewing.',
        'input_attr' => ['storage-mode' => 'private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => 'WeChat Pay private key, do not disclose'],
    ],
    'wechat_pay_mch_public_cert' => [

        'name'  => 'Merchant Public Key',

        'remark'     => 'Uploaded files are stored in the local private disk. You cannot directly preview the file. To preview, go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link for viewing.',
        'input_attr' => ['storage-mode' => 'private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => 'WeChat Pay public key, do not disclose'],
    ],
];
