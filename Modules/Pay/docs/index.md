---
title: Pay
---

# Pay

支付模块，提供完整的支付功能，支持支付宝和微信支付。

::: danger
该模块待测试，生产环境使用前请充分测试。
:::

## 依赖库

| PHP三方库 | 链接 |
| --- | --- |
| yansongda/laravel-pay | [yansongda/laravel-pay](https://packagist.org/packages/yansongda/laravel-pay) |

## 功能特性

### 支付方式
- **微信支付** - 支持公众号支付、小程序支付、APP支付等多种场景
- **支付宝支付** - 支持网页支付、手机网站支付、APP支付等多种场景

### 支付配置
- 支持多种运行模式（普通模式、服务商模式）
- 灵活的证书管理，支持本地私有存储
- 可配置的回调通知地址
- 支持多应用ID配置（公众号、小程序、APP等）

### 安全特性
- 使用官方推荐的加密方式
- 支持证书验证和签名验证
- 私有证书存储，确保安全性

## 快速开始

### 1. 配置支付参数

在后台管理系统的"配置管理"中，配置支付相关参数：

1. 选择支付方式（微信支付或支付宝支付）
2. 填写相应的商户信息和应用ID
3. 上传必要的证书文件
4. 设置回调通知地址

### 2. 使用支付服务

```php
use Modules\Pay\Services\PayService;

$payService = app(PayService::class);

// 获取微信支付实例
$wechatPay = $payService->wechat();

// 获取支付宝支付实例
$alipayPay = $payService->alipay();
```

### 3. 发起支付

```php
// 微信支付示例
$order = [
    'out_trade_no' => time(),
    'description' => '商品描述',
    'amount' => [
        'total' => 1,
        'currency' => 'CNY',
    ],
    'payer' => [
        'openid' => '用户openid',
    ],
];

$result = $wechatPay->mp($order);

// 支付宝支付示例
$order = [
    'out_trade_no' => time(),
    'total_amount' => 0.01,
    'subject' => '商品描述',
];

$result = $alipayPay->web($order);
```
