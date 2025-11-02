<?php

use Modules\Admin\Casts\AsInteger;
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
    /**
     * ===================================================
     * 微信支付配置
     * ===================================================
     */
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_mch_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '商户号',
            'en'    => 'Merchant ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「必填」商户号，服务商模式下为服务商商户号，可在 <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> 账户中心->商户信息 查看',
            'en'    => '「Required」Merchant ID for Service Providers, viewable in <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> Account Center->Merchant Information',
        ],
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

        'remark' => [
            'zh_CN' => '「必填」v3 商户秘钥，即 API v3 密钥(32字节，形如md5值)，可在 <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> 账户中心->API安全 中设置',
            'en'    => '「Required」v3 Merchant Secret Key, API v3 key (32 bytes, like md5 value), can be set in <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> Account Center->API Security',
        ],
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」商户私钥，即 API证书 PRIVATE KEY，可在 <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> 账户中心->API安全->申请API证书 里获得，文件名形如：apiclient_key.pem',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Merchant Private Key, API certificate PRIVATE KEY, can be obtained from <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> Account Center->API Security->Apply for API Certificate, filename like: apiclient_key.pem',
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」商户公钥证书路径，即 API证书 CERTIFICATE，可在 <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> 账户中心->API安全->申请API证书 里获得，文件名形如：apiclient_cert.pem',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Merchant Public Key Certificate Path, API certificate CERTIFICATE, can be obtained from <a class="arco-link arco-link-status-normal" href="https://pay.weixin.qq.com/" target="_blank">https://pay.weixin.qq.com/</a> Account Center->API Security->Apply for API Certificate, filename like: apiclient_cert.pem',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => '微信支付公钥，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.pem', 'remark' => 'WeChat Payment Public Key, Do Not Leak'],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_wechat_notify_url',
        'value' => '',
        'name'  => [
            'zh_CN' => '通知地址',
            'en'    => 'Notify URL',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「必填」微信回调url，不能有参数，如?号，空格等，否则会无法正确回调',
            'en'    => '「Required」WeChat callback URL, cannot have parameters like ?, spaces, etc., otherwise it will not be able to callback correctly',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
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

        'remark' => [
            'zh_CN' => '「选填」公众号 的 app_id，可在 <a class="arco-link arco-link-status-normal" href="https://mp.weixin.qq.com/" target="_blank">微信公众平台</a> 设置与开发->基本配置->开发者ID(AppID) 查看',
            'en'    => '「Optional」Official Account app_id, can be viewed in <a class="arco-link arco-link-status-normal" href="https://mp.weixin.qq.com/" target="_blank">WeChat Official Account Platform</a> Settings and Development->Basic Configuration->Developer ID(AppID)',
        ],
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

        'remark' => [
            'zh_CN' => '「选填」微信小程序的 app_id，在 <a class="arco-link arco-link-status-normal" href="https://developers.weixin.qq.com/sandbox" target="_blank">微信开放平台</a> 查看',
            'en'    => '「Optional」WeChat mini program app_id, view at <a class="arco-link arco-link-status-normal" href="https://developers.weixin.qq.com/sandbox" target="_blank">WeChat Open Platform</a>',
        ],
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

        'remark' => [
            'zh_CN' => '「选填」app 的 app_id',
            'en'    => '「Optional」App app_id',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'pay_config',
        'key'        => 'pay_wechat_mode',
        'value'      => Pay::MODE_NORMAL,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '运行模式',
            'en'    => 'Running Mode',
        ],
        'input_type' => SystemConfigInputType::RADIO,

        'remark' => [
            'zh_CN' => '「选填」默认为正常模式。可选为： MODE_NORMAL, MODE_SERVICE',
            'en'    => '「Optional」Default is Normal Mode. Options: MODE_NORMAL, MODE_SERVICE',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '正常模式', 'value' => Pay::MODE_NORMAL],
                    ['label' => '服务商模式', 'value' => Pay::MODE_SERVICE],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Normal Mode', 'value' => Pay::MODE_NORMAL],
                    ['label' => 'Service Mode', 'value' => Pay::MODE_SERVICE],
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

        'remark' => [
            'zh_CN' => '「选填」服务商模式下，子公众号 的 app_id',
            'en'    => '「Optional」In Service Provider mode, sub-official account app_id',
        ],
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

        'remark' => [
            'zh_CN' => '「选填」服务商模式下，子小程序 的 app_id',
            'en'    => '「Optional」In Service Provider mode, sub-mini program app_id',
        ],
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

        'remark' => [
            'zh_CN' => '「选填」服务商模式下，子 app 的 app_id',
            'en'    => '「Optional」In Service Provider mode, sub-app app_id',
        ],
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

        'remark' => [
            'zh_CN' => '「选填」服务商模式下，子商户号',
            'en'    => '「Optional」In Service Provider mode, sub-merchant ID',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],

    /**
     * ===================================================
     * 支付宝
     * ===================================================
     */
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => '应用ID',
            'en'    => 'Application ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「必填」支付宝分配的 app_id',
            'en'    => '「Required」App ID assigned by Alipay',
        ],
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」应用私钥 字符串或路径，在 <a class="arco-link arco-link-status-normal" href="https://open.alipay.com/develop/manage" target="_blank">https://open.alipay.com/develop/manage</a> 《应用详情->开发设置->接口加签方式》中设置',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Application private key, string or path, set in <a class="arco-link arco-link-status-normal" href="https://open.alipay.com/develop/manage" target="_blank">https://open.alipay.com/develop/manage</a> Application Details->Development Settings->Interface Signing Method',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => '支付宝应用私钥，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => 'Alipay Application Private Key, Do Not Leak'],
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」应用公钥证书 路径，设置应用私钥后，即可下载得到证书',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Application public key certificate path, can be downloaded after setting the application private key',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => '支付宝应用公钥，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => 'Alipay Application Public Key, Do Not Leak'],
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」支付宝公钥证书 路径，设置应用私钥后，即可下载得到证书',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Alipay public key certificate path, can be downloaded after setting the application private key',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => '支付宝根证书，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => 'Alipay Root Certificate, Do Not Leak'],
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
            'zh_CN' => '上传文件存储在本地私有磁盘，你无法直接预览该文件，如需预览可前往 <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">常规管理->附件管理</a> 生成临时链接查看。<br>「必填」支付宝根证书 路径，设置应用私钥后，即可下载得到证书',
            'en'    => 'Uploaded files are stored in the local private disk, you cannot directly preview the file, if you need to preview, please go to <a class="arco-link arco-link-status-normal" href="javascript:window.parent.openMenu(\'web.admin.SystemUploadFile.index\')">General Management->Attachment Management</a> to generate a temporary link to view.<br>「Required」Alipay root certificate path, can be downloaded after setting the application private key',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => '支付宝根证书，请勿泄露'],
            'en'    => ['storage-mode' => 'upload_private', 'upload-mode' => 'document', 'multiple' => false, 'limit' => 1, 'accept' => '.crt', 'remark' => 'Alipay Root Certificate, Do Not Leak'],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_return_url',
        'value' => '',
        'name'  => [
            'zh_CN' => '返回地址',
            'en'    => 'Return URL',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「选填」支付成功后的返回页面地址',
            'en'    => '「Optional」Return page URL after successful payment',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_notify_url',
        'value' => '',
        'name'  => [
            'zh_CN' => '通知地址',
            'en'    => 'Notify URL',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「选填」支付结果异步通知地址',
            'en'    => '「Optional」Asynchronous notification URL for payment results',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
    [
        'group'      => 'pay_config',
        'key'        => 'pay_alipay_mode',
        'value'      => Pay::MODE_NORMAL,
        'value_cast' => AsInteger::class,
        'name'       => [
            'zh_CN' => '运行模式',
            'en'    => 'Running Mode',
        ],
        'input_type' => SystemConfigInputType::RADIO,

        'remark' => [
            'zh_CN' => '「选填」默认为正常模式。可选为： MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE',
            'en'    => '「Optional」Default is Normal Mode. Options: MODE_NORMAL, MODE_SANDBOX, MODE_SERVICE',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '正常模式', 'value' => Pay::MODE_NORMAL],
                    ['label' => '沙箱模式', 'value' => Pay::MODE_SANDBOX],
                    ['label' => '服务商模式', 'value' => Pay::MODE_SERVICE],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Normal Mode', 'value' => Pay::MODE_NORMAL],
                    ['label' => 'Sandbox Mode', 'value' => Pay::MODE_SANDBOX],
                    ['label' => 'Service Mode', 'value' => Pay::MODE_SERVICE],
                ],
            ],
        ],
    ],
    [
        'group' => 'pay_config',
        'key'   => 'pay_alipay_app_auth_token',
        'value' => '',
        'name'  => [
            'zh_CN' => '应用授权令牌',
            'en'    => 'Application Authorization Token',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '「选填」第三方应用授权token',
            'en'    => '「Optional」Third-party application authorization token',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
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

        'remark' => [
            'zh_CN' => '「选填」服务商模式下的服务商 id，当 mode 为 Pay::MODE_SERVICE 时使用该参数',
            'en'    => '「Optional」Service provider ID in Service Provider mode, used when mode is Pay::MODE_SERVICE',
        ],
        'bind_p_config' => 'pay_group',
        'input_attr'    => null,
    ],
];
