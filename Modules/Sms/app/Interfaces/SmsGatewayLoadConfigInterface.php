<?php

namespace Modules\Sms\Interfaces;

interface SmsGatewayLoadConfigInterface
{
    public function getGatewayName(): string;

    public function loadConfig(): array;

    public function isEnabled(): bool;
}
