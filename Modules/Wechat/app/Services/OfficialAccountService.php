<?php

namespace Modules\Wechat\Services;

use EasyWeChat\OfficialAccount\Application;
use Modules\Admin\Services\SystemConfigService;

/**
 * @mixin Application
 */
class OfficialAccountService
{
    protected Application $app;

    public function __construct()
    {
        $app_id       = app(SystemConfigService::class)->getConfigByKey('wechat_official_app_id');
        $secret       = app(SystemConfigService::class)->getConfigByKey('wechat_official_secret');
        $token        = app(SystemConfigService::class)->getConfigByKey('wechat_official_token');
        $aes_key      = app(SystemConfigService::class)->getConfigByKey('wechat_official_aes_key');
        $oauth_scopes = app(SystemConfigService::class)->getConfigByKey('wechat_official_oauth_scopes');
        $redirect_url = app(SystemConfigService::class)->getConfigByKey('wechat_official_redirect_url');

        $config = [
            'app_id'  => $app_id,
            'secret'  => $secret,
            'token'   => $token,
            'aes_key' => $aes_key,
            'oauth'   => [
                'scopes'   => $oauth_scopes,
                'callback' => $redirect_url,
            ],
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
