---
title: 配置注册
---

# 配置注册

> [!TIP]
> 配置注册是指在模块中注册配置项，这些配置项可以在后台的配置管理中进行管理。

> [!tip]
> 模块中的config文件可以导出到应用中，而不需要修改模块中的源代码

> [!WARNING]
> 你不应该总是让他执行，而是在需要时执行，例如模块被启用时

## 注册配置组

```php
<?php

use Modules\Admin\Classes\Utils\SystemConfigUtil;

SystemConfigUtil::autoResisterGroup([
    [
        'name' => [ // 如果你需要国际化
            'zh_CN' => '微信配置',
            'en'    => 'Wechat',
        ],
        // 'name' => '微信配置',
        'code'   => 'wechat_config', // code 无法国际化，他是唯一标识
        'remark' => [
            'zh_CN' => '公众号，小程序，微信支付等',
            'en'    => 'Official Account, Mini Program, Wechat Payment, etc.',
        ],
    ]
]);

```

## 注册配置项

```php
<?php

use Modules\Admin\Classes\Utils\SystemConfigUtil;
use Modules\Admin\Classes\Utils\SystemConfigInputType;
// group,key,value,input_type,bind_p_config 无法被国际化
SystemConfigUtil::autoResisterConfig([
    [
        'group' => 'wechat_config', // 配置组 code
        'key'   => 'wechat_group',
        'value' => 'wechat_mini',
        'name'  => [
            'zh_CN' => '当前配置',
            'en'    => 'Current Configuration',
        ],
        'input_type'    => SystemConfigInputType::TABS,
        'remark'        => '',
        'bind_p_config' => '',
        'input_attr'    => [
            'zh_CN' => [
                'options' => [
                    ['label' => '小程序', 'value' => 'wechat_mini'],
                    ['label' => '公众号', 'value' => 'wechat_official'],
                    ['label' => '支付', 'value' => 'wechat_pay'],
                ],
            ],
            'en' => [
                'options' => [
                    ['label' => 'Mini Program', 'value' => 'wechat_mini'],
                    ['label' => 'Official Account', 'value' => 'wechat_official'],
                    ['label' => 'Payment', 'value' => 'wechat_pay'],
                ],
            ],
        ],
    ],
    [
        // bind_p_config 绑定父配置项，父组件为一些切换组件时可以控制子组件的显示
        // 规则是：当前组件前缀为父组件的值，例如：wechat_mini_app_id
        // 当父组件值为wechat_mini时，当前组件才会显示
        'group' => 'wechat_config',
        'key'   => 'wechat_mini_app_id',
        'value' => '',
        'name'  => [
            'zh_CN' => 'app id',
            'en'    => 'App ID',
        ],
        'input_type' => SystemConfigInputType::INPUT,

        'remark' => [
            'zh_CN' => '微信小程序app id',
            'en'    => 'WeChat Mini Program App ID',
        ],
        'bind_p_config' => 'wechat_group',
        'input_attr'    => null,
    ],
]);

```