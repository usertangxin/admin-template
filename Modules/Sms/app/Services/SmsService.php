<?php

namespace Modules\Sms\Services;

use Modules\Admin\Services\SystemConfigService;
use Modules\Sms\Interfaces\SmsGatewayLoadConfigInterface;
use Overtrue\EasySms\EasySms;

/**
 * @mixin EasySms
 */
class SmsService
{
    protected EasySms $easySms;

    public function __construct()
    {
        $config = config('services.easy-sms');

        $sms_gateways_config = app(SystemConfigService::class)->getConfigByKey('sms_gateways');

        $gateways_configs = $config['gateways'] ?? [];
        $gateways         = $config['default']['gateways'] ?? [];

        collect($sms_gateways_config['input_attr']['options'])->each(function ($item) use (&$gateways_configs, &$gateways) {
            /** @var SmsGatewayLoadConfigInterface $class */
            $class = app($item['load_config']);
            if ($class->isEnabled()) {
                $gateways_configs[$class->getGatewayName()] = $class->loadConfig();
                $gateways[]                                 = $class->getGatewayName();
            }
        });

        $config['gateways'] = $gateways_configs;

        $config['default']['gateways'] = $gateways;
        $config['default']['strategy'] = app(SystemConfigService::class)->getConfigByKey('sms_strategy');

        $this->easySms = new EasySms($config);
    }

    public function __call($name, $arguments)
    {
        return $this->easySms->{$name}(...$arguments);
    }
}
