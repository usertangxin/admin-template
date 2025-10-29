<?php

namespace Modules\Sms\Classes;

use Modules\Admin\Services\SystemConfigService;
use Overtrue\EasySms\Contracts\StrategyInterface;

class OrderStrategy implements StrategyInterface
{
    public function apply(array $gateways)
    {
        $configService  = app(SystemConfigService::class);
        $gatewayWeights = [];

        // 获取每个网关的排序权重
        foreach ($gateways as $gateway) {
            $gatewayWeights[$gateway] = (int) $configService->getConfigByKey('sms_' . $gateway . '_sort_order') ?? 1;
        }

        // 根据权重从大到小排序
        arsort($gatewayWeights);

        // 返回排序后的网关数组
        return array_keys($gatewayWeights);
    }
}
