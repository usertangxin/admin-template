---
title: 支持更多短信平台
---

# 支持更多短信平台

你可以向我们提交代码来添加更多默认受支持的短信平台

### Step 1: 添加加载配置类

创建一个加载配置类，实现 `Modules\Sms\Classes\SmsGatewayLoadConfigInterface` 接口。
你可以参考本模块的一些实现类。
```php
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

```

### Step 2: 添加配置

向系统配置 `sms_gateways` 中 `input_attr->options` 添加更多选项，你可以参考本模块的默认配置

::: danger
`input_attr` 是多语言的，你需要为每种语言添加选项
:::

向系统配置中添加关于本网关需要的配置项，你可以阅读 [EasySms](https://github.com/overtrue/easy-sms) 获取更多配置信息。<br>你可以参考本模块的默认配置

::: danger
需必须添加一项 `sms_{gatewayName}_sort_order`，这在顺序策略中是必须要的，用于控制本网关的优先级，你可以查阅 `Modules\Admin\Services\SystemConfigService\OrderStrategy` 代码了解更多信息<br>
或者你需要覆盖 `sms_strategy->input_attr->options` 选项或者覆盖容器中的 `Modules\Admin\Services\SystemConfigService\OrderStrategy` 的实例来实现自定义排序逻辑
:::

::: tip
切换控制配置显示你可能需要阅读 [Admin->配置](/Modules/Admin/config-register) 来了解
:::