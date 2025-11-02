---
title: 配置说明
---

# 配置说明

微信模块的所有配置都通过系统配置模块管理，配置组为 `wechat_config`。所有配置项都支持根据 `wechat_group` 条件显示，方便在不同微信应用类型之间切换配置。

## 配置切换

系统提供了配置切换功能，通过 `wechat_group` 配置项可以切换当前显示的配置类型：

| 配置值 | 对应类型 | 说明 |
|--------|---------|------|
| `wechat_mini` | 小程序 | 微信小程序配置 |
| `wechat_official` | 公众号 | 微信公众号配置 |
| `wechat_open_platform` | 开放平台 | 微信开放平台配置 |
| `wechat_work` | 企业微信 | 企业微信配置 |
| `wechat_open_work` | 企业微信开放平台 | 企业微信开放平台配置 |

## 小程序配置

### 配置项列表

| 配置键 | 说明 | 是否必填 |
|--------|------|---------|
| `wechat_mini_app_id` | 小程序 AppID | ✅ 必填 |
| `wechat_mini_secret` | 小程序 AppSecret | ✅ 必填 |
| `wechat_mini_token` | 消息推送 Token | 消息推送时必填 |
| `wechat_mini_aes_key` | 消息加解密密钥 | 消息加密时必填 |

### 配置说明

- **AppID** 和 **AppSecret**：在小程序管理后台的"开发"-"开发管理"-"开发设置"中获取
- **Token**：用于验证消息推送的合法性，可以自定义，需要与小程序后台配置一致
- **AES Key**：用于消息加解密，在消息加密模式下必填，可以在小程序后台自动生成

## 公众号配置

### 配置项列表

| 配置键 | 说明 | 是否必填 |
|--------|------|---------|
| `wechat_official_app_id` | 公众号 AppID | ✅ 必填 |
| `wechat_official_secret` | 公众号 AppSecret | ✅ 必填 |
| `wechat_official_token` | 消息推送 Token | 消息推送时必填 |
| `wechat_official_aes_key` | 消息加解密密钥 | 消息加密时必填 |
| `wechat_official_oauth_scopes` | OAuth 授权范围 | OAuth 授权时必填 |
| `wechat_official_redirect_url` | OAuth 回调地址 | OAuth 授权时必填 |

### OAuth 授权范围

支持两种授权范围（可多选）：
- **snsapi_base**：静默授权，不弹出授权页面，只能获取用户的 openid
- **snsapi_userinfo**：弹出授权页面，可以通过 openid 获取用户基本信息

### 配置说明

- **AppID** 和 **AppSecret**：在公众号管理后台的"开发"-"基本配置"中获取
- **Token**：用于验证消息推送的合法性，需要与公众号后台配置一致
- **AES Key**：用于消息加解密，在消息加密模式下必填
- **OAuth 回调地址**：需要在公众号后台"开发"-"接口权限"-"网页授权获取用户基本信息"中配置授权回调域名

## 开放平台配置

### 配置项列表

| 配置键 | 说明 | 是否必填 |
|--------|------|---------|
| `wechat_open_platform_app_id` | 开放平台 AppID | ✅ 必填 |
| `wechat_open_platform_secret` | 开放平台 AppSecret | ✅ 必填 |
| `wechat_open_platform_token` | 消息推送 Token | 消息推送时必填 |
| `wechat_open_platform_aes_key` | 消息加解密密钥 | 消息加密时必填 |

### 配置说明

- **AppID** 和 **AppSecret**：在微信开放平台管理中心获取
- **Token** 和 **AES Key**：在开放平台创建第三方平台时配置，需要与平台配置一致

## 企业微信配置

### 配置项列表

| 配置键 | 说明 | 是否必填 |
|--------|------|---------|
| `wechat_work_corp_id` | 企业 ID | ✅ 必填 |
| `wechat_work_secret` | 应用密钥 | ✅ 必填 |
| `wechat_work_token` | 消息推送 Token | 消息推送时必填 |
| `wechat_work_aes_key` | 消息加解密密钥 | 消息加密时必填 |
| `wechat_work_suite_id` | Suite ID | Suite 相关功能时必填 |
| `wechat_work_suite_secret` | Suite Secret | Suite 相关功能时必填 |

### 配置说明

- **Corp ID**：在企业微信管理后台的"我的企业"-"企业信息"中查看
- **应用密钥**：在企业微信管理后台的"应用管理"中创建应用后获取
- **Token** 和 **AES Key**：在应用配置的"接收消息"中设置
- **Suite ID** 和 **Suite Secret**：适用于第三方应用开发场景

## 企业微信开放平台配置

### 配置项列表

| 配置键 | 说明 | 是否必填 |
|--------|------|---------|
| `wechat_open_work_corp_id` | 企业 ID | ✅ 必填 |
| `wechat_open_work_provider_secret` | Provider Secret | ✅ 必填 |
| `wechat_open_work_token` | 消息推送 Token | 消息推送时必填 |
| `wechat_open_work_aes_key` | 消息加解密密钥 | 消息加密时必填 |

### 配置说明

- **Corp ID**：在服务商管理后台获取
- **Provider Secret**：在服务商管理后台的"开发配置"中获取
- **Token** 和 **AES Key**：在服务商管理后台配置

## 配置获取方式

在代码中，可以通过 `SystemConfigService` 获取配置：

```php
use Modules\Admin\Services\SystemConfigService;

$configService = app(SystemConfigService::class);

// 获取小程序 AppID
$appId = $configService->getConfigByKey('wechat_mini_app_id');

// 获取公众号 Secret
$secret = $configService->getConfigByKey('wechat_official_secret');
```

## 注意事项

::: warning
所有配置项都存储在数据库中，敏感信息（如 Secret、Token、AES Key）请妥善保管，不要泄露。
:::

::: danger
Token 和 AES Key 需要与对应微信平台后台的配置保持一致，否则消息推送和加解密功能将无法正常工作。
:::

::: tip
配置项支持条件显示，通过 `bind_p_config` 绑定到 `wechat_group`，只有当前选中的配置类型对应的配置项才会显示。
:::

::: warning
不同微信应用类型的配置是独立的，需要在后台分别配置。即使切换了 `wechat_group`，之前配置的值也会保留。
:::

::: tip
OAuth 回调地址需要在对应的微信平台后台配置授权回调域名，否则 OAuth 授权将失败。
:::

## 相关文档

- [EasyWeChat 6.x 官方文档](https://easywechat.com/6.x/)
- [微信小程序开发文档](https://developers.weixin.qq.com/miniprogram/dev/framework/)
- [微信公众号开发文档](https://developers.weixin.qq.com/doc/offiaccount/Getting_Started/Overview.html)
- [企业微信开发文档](https://developer.work.weixin.qq.com/document)

