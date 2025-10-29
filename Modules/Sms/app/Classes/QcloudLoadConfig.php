<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Services\SystemConfigService;
use Modules\Sms\Interfaces\SmsGatewayLoadConfigInterface;

class QcloudLoadConfig implements SmsGatewayLoadConfigInterface
{
    public function __construct(protected SystemConfigService $system_config_service) {}

    public function getGatewayName(): string
    {
        return 'qcloud';
    }

    public function isEnabled(): bool
    {
        return $this->system_config_service->getConfigByKey('sms_qcloud_status');
    }

    public function loadConfig(): array
    {
        return [
            'sdk_app_id' => $this->system_config_service->getConfigByKey('sms_qcloud_sdk_app_id'),
            'secret_id'  => $this->system_config_service->getConfigByKey('sms_qcloud_secret_id'),
            'secret_key' => $this->system_config_service->getConfigByKey('sms_qcloud_secret_key'),
            'sign_name'  => $this->system_config_service->getConfigByKey('sms_qcloud_sign_name'),
        ];
    }
}
