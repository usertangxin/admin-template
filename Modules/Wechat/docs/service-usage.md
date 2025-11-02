---
title: 服务使用
---

# 服务使用

微信模块提供了多个服务类，用于访问不同类型的微信应用。所有服务类都基于 EasyWeChat SDK，提供了完整的微信功能支持。

## 服务类概览

| 服务类 | 对应微信应用 | EasyWeChat 应用类 |
|--------|------------|-------------------|
| `MiniAppService` | 小程序 | `EasyWeChat\MiniApp\Application` |
| `OfficialAccountService` | 公众号 | `EasyWeChat\OfficialAccount\Application` |
| `OpenPlatformService` | 开放平台 | `EasyWeChat\OpenPlatform\Application` |
| `WorkWechatService` | 企业微信 | `EasyWeChat\Work\Application` |
| `OpenWorkWechatService` | 企业微信开放平台 | `EasyWeChat\OpenWork\Application` |

## 基础使用

### 获取服务实例

```php
use Modules\Wechat\Services\MiniAppService;
use Modules\Wechat\Services\OfficialAccountService;

// 通过容器获取
$miniService = app(MiniAppService::class);
$officialService = app(OfficialAccountService::class);
```

### 直接调用 EasyWeChat 方法

服务类实现了 `__call` 魔术方法，可以直接调用 EasyWeChat Application 的所有方法，无需先获取 Application 实例：

```php
$service = app(MiniAppService::class);

// 直接调用 getClient() 等方法
$response = $service->getClient()->get('/api/endpoint', ['param' => 'value']);

// 也可以调用 getConfig()、getOAuth() 等方法
$appId = $service->getConfig()->get('app_id');
```

### 获取 EasyWeChat Application 实例（可选）

如果需要获取 Application 实例，可以使用 `getApp()` 方法：

```php
$service = app(MiniAppService::class);
$app = $service->getApp(); // 通常不需要，直接使用 $service 即可
```

## 小程序使用示例

### 获取用户 OpenID 和 Session Key

```php
use Modules\Wechat\Services\MiniAppService;

$service = app(MiniAppService::class);

// 使用 EasyWeChat 6.x 的 API 调用方式（推荐）
$response = $service->getClient()->get('/sns/jscode2session', [
    'appid' => $service->getConfig()->get('app_id'),
    'secret' => $service->getConfig()->get('secret'),
    'js_code' => 'code_from_miniprogram',
    'grant_type' => 'authorization_code',
]);

$session = $response->toArray();
$openid = $session['openid'];
$sessionKey = $session['session_key'];
```

### 发送订阅消息

```php
use Modules\Wechat\Services\MiniAppService;

$service = app(MiniAppService::class);

$result = $service->getClient()->postJson('/cgi-bin/message/subscribe/send', [
    'touser' => 'openid',
    'template_id' => 'template_id',
    'page' => 'pages/index/index',
    'data' => [
        'thing1' => ['value' => '测试'],
        'time2' => ['value' => '2024-01-01 12:00:00'],
    ],
]);
```

### 获取小程序码

```php
use Modules\Wechat\Services\MiniAppService;

$service = app(MiniAppService::class);

// 获取小程序码
$response = $service->getClient()->postJson('/wxa/getwxacode', [
    'path' => 'pages/index/index',
    'width' => 430,
]);

// 保存二维码
file_put_contents('/path/to/save/qrcode.png', $response->getBody()->getContents());
```

## 公众号使用示例

### OAuth 授权

```php
use Modules\Wechat\Services\OfficialAccountService;

$service = app(OfficialAccountService::class);

// 获取 OAuth 实例并生成授权URL
$oauth = $service->getOAuth();
$redirectUrl = $oauth->scopes(['snsapi_userinfo'])->redirect('https://your-callback-url.com')->getTargetUrl();

// 或直接重定向
return $oauth->scopes(['snsapi_userinfo'])->redirect('https://your-callback-url.com');

// 在回调页面获取用户信息
$user = $oauth->user();
$openid = $user->getId();
$nickname = $user->getNickname();
$avatar = $user->getAvatar();
```

### 获取用户信息（API 调用）

```php
use Modules\Wechat\Services\OfficialAccountService;

$service = app(OfficialAccountService::class);

// 使用 EasyWeChat 6.x 的通用 API 调用方式
$response = $service->getClient()->get("/cgi-bin/user/info?openid={$openid}&lang=zh_CN");
$userInfo = $response->toArray();
```

### 发送模板消息

```php
use Modules\Wechat\Services\OfficialAccountService;

$service = app(OfficialAccountService::class);

$result = $service->getClient()->postJson('/cgi-bin/message/template/send', [
    'touser' => 'openid',
    'template_id' => 'template_id',
    'url' => 'https://your-website.com',
    'data' => [
        'first' => ['value' => '通知内容', 'color' => '#173177'],
        'keyword1' => ['value' => '关键词1'],
        'keyword2' => ['value' => '关键词2'],
        'remark' => ['value' => '备注'],
    ],
]);
```

### 创建自定义菜单

```php
use Modules\Wechat\Services\OfficialAccountService;

$service = app(OfficialAccountService::class);

$buttons = [
    [
        'type' => 'click',
        'name' => '今日歌曲',
        'key' => 'V1001_TODAY_MUSIC',
    ],
    [
        'name' => '菜单',
        'sub_button' => [
            [
                'type' => 'view',
                'name' => '搜索',
                'url' => 'http://www.soso.com/',
            ],
        ],
    ],
];

$service->getClient()->postJson('/cgi-bin/menu/create', ['button' => $buttons]);
```

## 企业微信使用示例

### 发送应用消息

```php
use Modules\Wechat\Services\WorkWechatService;

$service = app(WorkWechatService::class);

$message = [
    'touser' => '@all',
    'msgtype' => 'text',
    'agentid' => 1000002,
    'text' => [
        'content' => '你的快递已到，请携带工卡前往邮件中心领取。\n出发前可查看<a href="http://work.weixin.qq.com">邮件中心视频实况</a>，聪明避开排队。',
    ],
];

$service->getClient()->postJson('/cgi-bin/message/send', $message);
```

### 获取部门列表

```php
use Modules\Wechat\Services\WorkWechatService;

$service = app(WorkWechatService::class);

$response = $service->getClient()->get('/cgi-bin/department/list');
$departments = $response->toArray();
```

### 获取用户信息

```php
use Modules\Wechat\Services\WorkWechatService;

$service = app(WorkWechatService::class);

$response = $service->getClient()->get("/cgi-bin/user/get?userid={$userid}");
$user = $response->toArray();
```

## 依赖注入

在控制器或服务类中，可以通过依赖注入使用服务：

```php
namespace App\Http\Controllers;

use Modules\Wechat\Services\MiniAppService;
use Modules\Wechat\Services\OfficialAccountService;

class WechatController extends Controller
{
    protected MiniAppService $miniService;
    protected OfficialAccountService $officialService;

    public function __construct(
        MiniAppService $miniService,
        OfficialAccountService $officialService
    ) {
        $this->miniService = $miniService;
        $this->officialService = $officialService;
    }

    public function getSessionKey()
    {
        $response = $this->miniService->getClient()->get('/sns/jscode2session', [
            'appid' => $this->miniService->getConfig()->get('app_id'),
            'secret' => $this->miniService->getConfig()->get('secret'),
            'js_code' => request('code'),
            'grant_type' => 'authorization_code',
        ]);
        
        return response()->json($response->toArray());
    }
}
```

## IDE 提示支持

所有服务类都使用了 `@mixin` 注解，IDE 可以自动识别 EasyWeChat Application 的所有方法，提供完整的代码提示和自动补全。

```php
$service = app(MiniAppService::class);

// IDE 会自动提示所有可用的方法和属性
$service->getClient()->  // 这里会提示所有 HTTP 客户端的方法
$service->getConfig()->  // 这里会提示配置相关的方法
$service->getOAuth()->   // 这里会提示 OAuth 相关的方法
```

## API 调用方式

在 EasyWeChat 6.x 中，主要通过 `getClient()` 方法调用微信 API。

### GET 请求

```php
$service = app(MiniAppService::class);

// 方式一：参数通过数组传递（推荐）
$response = $service->getClient()->get('/api/endpoint', ['param' => 'value']);

// 方式二：参数通过 URL 传递
$response = $service->getClient()->get('/api/endpoint?param=value');

// 获取响应数据
$data = $response->toArray();
```

### POST 请求

```php
$service = app(MiniAppService::class);

// POST JSON 数据
$response = $service->getClient()->postJson('/api/endpoint', ['data' => 'value']);

// POST 表单数据
$response = $service->getClient()->post('/api/endpoint', ['data' => 'value']);

// 获取响应数据
$data = $response->toArray();
```

### 获取配置

```php
$service = app(MiniAppService::class);

// 直接调用 getConfig() 方法
$appId = $service->getConfig()->get('app_id');
$secret = $service->getConfig()->get('secret');
```

更多 API 调用方式请参考 [EasyWeChat 6.x API 调用文档](https://easywechat.com/6.x/official-account/api.html)。

## 更多功能

由于所有服务都基于 EasyWeChat SDK，你可以使用 EasyWeChat 提供的所有功能。请参考：

- [EasyWeChat 6.x 官方文档](https://easywechat.com/6.x/)
- [EasyWeChat GitHub](https://github.com/w7corp/easywechat)

::: tip
所有服务类都从系统配置自动读取配置，无需手动设置。只需要在后台配置好相应的微信应用参数即可使用。
:::

::: warning
不同微信应用类型的配置是独立的，即使切换 `wechat_group`，也需要确保对应的配置项都已正确填写。
:::

