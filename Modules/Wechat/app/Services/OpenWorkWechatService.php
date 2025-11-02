<?php

namespace Modules\Wechat\Services;

use EasyWeChat\OpenWork\Application;
use Modules\Admin\Services\SystemConfigService;

/**
 * @mixin Application
 */
class OpenWorkWechatService
{
    protected Application $app;

    public function __construct()
    {
        $corp_id         = app(SystemConfigService::class)->getConfigByKey('wechat_open_work_corp_id');
        $provider_secret = app(SystemConfigService::class)->getConfigByKey('wechat_open_work_provider_secret');
        $token           = app(SystemConfigService::class)->getConfigByKey('wechat_open_work_token');
        $aes_key         = app(SystemConfigService::class)->getConfigByKey('wechat_open_work_aes_key');

        $config = [
            'corp_id'         => $corp_id,
            'provider_secret' => $provider_secret,
            'token'           => $token,
            'aes_key'         => $aes_key,
        ];

        $this->app = new Application($config);
    }

    public function getApp()
    {
        return $this->app;
    }

    public function __call($name, $arguments)
    {
        return $this->app->{$name}(...$arguments);
    }
}
