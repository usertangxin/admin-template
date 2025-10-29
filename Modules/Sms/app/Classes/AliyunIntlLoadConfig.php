<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Services\SystemConfigService;
use Modules\Sms\Interfaces\SmsGatewayLoadConfigInterface;

class AliyunIntlLoadConfig implements SmsGatewayLoadConfigInterface
{
    public function __construct(protected SystemConfigService $system_config_service) {}

    public function getGatewayName(): string
    {
        return 'aliyunintl';
    }

    public function isEnabled(): bool
    {
        return $this->system_config_service->getConfigByKey('sms_aliyunintl_status');
    }

    public function loadConfig(): array
    {
        return [
            'app_key'    => $this->system_config_service->getConfigByKey('sms_aliyunintl_app_key'),
            'app_secret' => $this->system_config_service->getConfigByKey('sms_aliyunintl_app_secret'),
            'sign_name'  => $this->system_config_service->getConfigByKey('sms_aliyunintl_sign_name'),
        ];
    }
}
