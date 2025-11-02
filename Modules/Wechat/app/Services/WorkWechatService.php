<?php

namespace Modules\Wechat\Services;

use EasyWeChat\Work\Application;
use Modules\Admin\Services\SystemConfigService;

/**
 * @mixin Application
 */
class WorkWechatService
{
    protected Application $app;

    public function __construct()
    {
        $corp_id      = app(SystemConfigService::class)->getConfigByKey('wechat_work_corp_id');
        $secret       = app(SystemConfigService::class)->getConfigByKey('wechat_work_secret');
        $token        = app(SystemConfigService::class)->getConfigByKey('wechat_work_token');
        $aes_key      = app(SystemConfigService::class)->getConfigByKey('wechat_work_aes_key');
        $suite_id     = app(SystemConfigService::class)->getConfigByKey('wechat_work_suite_id');
        $suite_secret = app(SystemConfigService::class)->getConfigByKey('wechat_work_suite_secret');

        $config = [
            'corp_id'      => $corp_id,
            'secret'       => $secret,
            'token'        => $token,
            'aes_key'      => $aes_key,
            'suite_id'     => $suite_id,
            'suite_secret' => $suite_secret,
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
