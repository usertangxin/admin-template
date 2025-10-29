<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Services\SystemConfigService;
use Modules\Sms\Interfaces\SmsGatewayLoadConfigInterface;

class AliyunLoadConfig implements SmsGatewayLoadConfigInterface
{
    public function __construct(protected SystemConfigService $system_config_service) {}

    public function getGatewayName(): string
    {
        return 'aliyun';
    }

    public function isEnabled(): bool
    {
        return $this->system_config_service->getConfigByKey('sms_aliyun_status');
    }

    public function loadConfig(): array
    {
        return [
            'access_key_id'     => $this->system_config_service->getConfigByKey('sms_aliyun_access_key_id'),
            'access_key_secret' => $this->system_config_service->getConfigByKey('sms_aliyun_access_key_secret'),
            'sign_name'         => $this->system_config_service->getConfigByKey('sms_aliyun_sign_name'),
        ];
    }
}
