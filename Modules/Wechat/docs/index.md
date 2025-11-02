---
title: Wechat
---

# Wechat

微信模块，提供完整的微信生态集成功能。支持小程序、公众号、开放平台、企业微信和企业微信开放平台等多种微信应用类型。

## 功能特性

### 小程序 (Mini Program)
- 小程序基础配置管理
- 支持 EasyWeChat MiniApp SDK 所有功能
- 消息推送和事件处理

### 公众号 (Official Account)
- 公众号基础配置管理
- OAuth 授权配置（支持 snsapi_userinfo 和 snsapi_base）
- 消息推送和事件处理
- 支持 EasyWeChat OfficialAccount SDK 所有功能

### 开放平台 (Open Platform)
- 开放平台基础配置管理
- 第三方平台开发支持
- 支持 EasyWeChat OpenPlatform SDK 所有功能

### 企业微信 (WeChat Work)
- 企业微信基础配置管理
- 企业应用开发支持
- Suite 套件配置
- 支持 EasyWeChat Work SDK 所有功能

### 企业微信开放平台 (Open Work)
- 企业微信开放平台基础配置管理
- 第三方企业应用开发支持
- 支持 EasyWeChat OpenWork SDK 所有功能

## 服务类说明

模块提供了以下服务类，每个服务类都是 EasyWeChat 对应应用的封装：

### MiniAppService
小程序服务，用于访问小程序相关功能。

```php
use Modules\Wechat\Services\MiniAppService;

$service = app(MiniAppService::class);
$app = $service->getApp(); // 获取 EasyWeChat Application 实例

// 或者直接调用 EasyWeChat 的方法
$service->code->getSessionKey('code');
```

### OfficialAccountService
公众号服务，用于访问公众号相关功能。

```php
use Modules\Wechat\Services\OfficialAccountService;

$service = app(OfficialAccountService::class);
$app = $service->getApp(); // 获取 EasyWeChat Application 实例

// 或者直接调用 EasyWeChat 的方法
$service->oauth->redirect('callback_url');
```

### OpenPlatformService
开放平台服务，用于访问开放平台相关功能。

```php
use Modules\Wechat\Services\OpenPlatformService;

$service = app(OpenPlatformService::class);
$app = $service->getApp(); // 获取 EasyWeChat Application 实例
```

### WorkWechatService
企业微信服务，用于访问企业微信相关功能。

```php
use Modules\Wechat\Services\WorkWechatService;

$service = app(WorkWechatService::class);
$app = $service->getApp(); // 获取 EasyWeChat Application 实例
```

### OpenWorkWechatService
企业微信开放平台服务，用于访问企业微信开放平台相关功能。

```php
use Modules\Wechat\Services\OpenWorkWechatService;

$service = app(OpenWorkWechatService::class);
$app = $service->getApp(); // 获取 EasyWeChat Application 实例
```

## 配置管理

所有微信配置都通过系统配置模块管理，配置组为 `wechat_config`。

### 配置切换

系统支持通过 `wechat_group` 配置项切换当前使用的微信应用类型：
- `wechat_mini` - 小程序
- `wechat_official` - 公众号
- `wechat_open_platform` - 开放平台
- `wechat_work` - 企业微信
- `wechat_open_work` - 企业微信开放平台

### 配置项说明

每个微信应用类型都包含以下基础配置：
- **app_id** / **corp_id** - 应用ID（企业微信使用corp_id）
- **secret** - 应用密钥
- **token** - 消息推送Token
- **aes_key** - 消息加解密密钥

公众号还额外支持：
- **oauth_scopes** - OAuth授权范围（多选：snsapi_userinfo, snsapi_base）
- **redirect_url** - OAuth回调地址

企业微信还额外支持：
- **suite_id** - Suite ID
- **suite_secret** - Suite Secret

企业微信开放平台额外支持：
- **provider_secret** - Provider Secret

所有配置项都会根据 `wechat_group` 的设置进行条件显示。

## 使用方法

### 获取服务实例

所有服务都通过 Laravel 服务容器自动注入配置：

```php
// 方式一：通过容器获取
$miniService = app(MiniAppService::class);
$officialService = app(OfficialAccountService::class);

// 方式二：通过依赖注入
public function __construct(MiniAppService $miniService)
{
    $this->miniService = $miniService;
}
```


## 依赖

模块依赖以下包：
- **overtrue/laravel-wechat** (~7.4.0) - EasyWeChat SDK for Laravel（基于 EasyWeChat 6.x）

::: tip
本模块使用 `overtrue/laravel-wechat` 作为底层 SDK，它是 EasyWeChat 的 Laravel 封装版本，提供了更好的 Laravel 集成体验。更多信息请参考 [EasyWeChat 6.x 官方文档](https://easywechat.com/6.x/)。
:::

## 注意事项

::: tip
所有服务类都使用 `@mixin` 注解，IDE 可以自动提示 EasyWeChat Application 的所有方法。
:::

::: warning
所有配置项都从系统配置模块读取，请确保在使用前已在后台配置好相应的微信应用参数。
:::

::: danger
Token 和 AES Key 等敏感信息请妥善保管，不要泄露。
:::

::: tip
配置项支持通过 `wechat_group` 切换不同应用类型，但每个类型的配置是独立的，需要在后台分别配置。
:::

