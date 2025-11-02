<?php

namespace Modules\Pay\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Admin\Services\SystemConfigService;
use Yansongda\Pay\Pay;

class PayService
{
    protected function getCertificateRelativePath($path): string
    {
        return Storage::disk('admin-private')->path($path);
    }

    public function wechat($config = [], $container = null)
    {
        $mch_id               = app(SystemConfigService::class)->getConfigByKey('wechat_pay_mch_id');
        $mch_secret_key       = app(SystemConfigService::class)->getConfigByKey('wechat_pay_mch_secret_key');
        $mch_secret_cert      = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('wechat_pay_mch_secret_cert'));
        $mch_public_cert_path = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('wechat_pay_mch_public_cert'));
        $mp_app_id            = app(SystemConfigService::class)->getConfigByKey('wechat_pay_mp_app_id');
        $mini_app_id          = app(SystemConfigService::class)->getConfigByKey('wechat_pay_mini_app_id');
        $app_id               = app(SystemConfigService::class)->getConfigByKey('wechat_pay_app_id');
        $sub_mp_app_id        = app(SystemConfigService::class)->getConfigByKey('wechat_pay_sub_mp_app_id');
        $sub_app_id           = app(SystemConfigService::class)->getConfigByKey('wechat_pay_sub_app_id');
        $sub_mini_app_id      = app(SystemConfigService::class)->getConfigByKey('wechat_pay_sub_mini_app_id');
        $sub_mch_id           = app(SystemConfigService::class)->getConfigByKey('wechat_pay_sub_mch_id');
        $mode                 = app(SystemConfigService::class)->getConfigByKey('wechat_pay_mode');
        $notify_url           = app(SystemConfigService::class)->getConfigByKey('wechat_pay_notify_url');

        return Pay::wechat(array_merge([
            'mch_id'               => $mch_id,
            'mch_secret_key'       => $mch_secret_key,
            'mch_secret_cert'      => $mch_secret_cert,
            'mch_public_cert_path' => $mch_public_cert_path,
            'notify_url'           => $notify_url,
            'mp_app_id'            => $mp_app_id,
            'mini_app_id'          => $mini_app_id,
            'app_id'               => $app_id,
            'sub_mp_app_id'        => $sub_mp_app_id,
            'sub_app_id'           => $sub_app_id,
            'sub_mini_app_id'      => $sub_mini_app_id,
            'sub_mch_id'           => $sub_mch_id,
            'mode'                 => $mode,
        ], $config), $container);
    }

    public function alipay($config = [], $container = null)
    {
        $app_id                  = app(SystemConfigService::class)->getConfigByKey('alipay_pay_app_id');
        $app_secret_cert         = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('alipay_pay_app_secret_cert'));
        $app_public_cert_path    = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('alipay_pay_app_public_cert'));
        $alipay_public_cert_path = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('alipay_pay_alipay_public_cert'));
        $alipay_root_cert_path   = $this->getCertificateRelativePath(app(SystemConfigService::class)->getConfigByKey('alipay_pay_alipay_root_cert'));
        $notify_url              = app(SystemConfigService::class)->getConfigByKey('alipay_pay_notify_url');
        $return_url              = app(SystemConfigService::class)->getConfigByKey('alipay_pay_return_url');
        $app_auth_token          = app(SystemConfigService::class)->getConfigByKey('alipay_pay_app_auth_token');
        $service_provider_id     = app(SystemConfigService::class)->getConfigByKey('alipay_pay_service_provider_id');
        $mode                    = app(SystemConfigService::class)->getConfigByKey('alipay_pay_mode');

        return Pay::alipay(array_merge([
            'app_id'                  => $app_id,
            'app_secret_cert'         => $app_secret_cert,
            'app_public_cert_path'    => $app_public_cert_path,
            'alipay_public_cert_path' => $alipay_public_cert_path,
            'alipay_root_cert_path'   => $alipay_root_cert_path,
            'notify_url'              => $notify_url,
            'return_url'              => $return_url,
            'app_auth_token'          => $app_auth_token,
            'service_provider_id'     => $service_provider_id,
            'mode'                    => $mode,
        ], $config), $container);
    }
}
