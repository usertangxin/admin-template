<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Services\SystemConfigService;
use Modules\Sms\Interfaces\SmsGatewayLoadConfigInterface;

class QiniuLoadConfig implements SmsGatewayLoadConfigInterface
{
    public function __construct(protected SystemConfigService $system_config_service) {}

    public function getGatewayName(): string
    {
        return 'qiniu';
    }

    public function isEnabled(): bool
    {
        return $this->system_config_service->getConfigByKey('sms_qiniu_status');
    }

    public function loadConfig(): array
    {
        return [
            'secret_key' => $this->system_config_service->getConfigByKey('sms_qiniu_secret_key'),
            'access_key' => $this->system_config_service->getConfigByKey('sms_qiniu_access_key'),
        ];
    }
}
