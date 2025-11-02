<?php

namespace Modules\Wechat\Services;

use EasyWeChat\OpenPlatform\Application;
use Modules\Admin\Services\SystemConfigService;

/**
 * @mixin Application
 * @package Modules\Wechat\Services
 */
class OpenPlatformService
{
    protected Application $app;

    public function __construct()
    {
        $app_id = app(SystemConfigService::class)->getConfigByKey('wechat_open_platform_app_id');
        $secret = app(SystemConfigService::class)->getConfigByKey('wechat_open_platform_secret');
        $token = app(SystemConfigService::class)->getConfigByKey('wechat_open_platform_token');
        $aes_key = app(SystemConfigService::class)->getConfigByKey('wechat_open_platform_aes_key');

        $config = [
            'app_id' => $app_id,
            'secret' => $secret,
            'token' => $token,
            'aes_key' => $aes_key,
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
