<?php

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | 有状态的域名
    |--------------------------------------------------------------------------
    |
    | 来自以下域名 / 主机的请求将接收有状态的 API 认证 cookie。
    | 通常，这些域名应包括你通过前端单页应用 (SPA) 访问 API 的本地和生产环境域名。
    |
    */

    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort(),
        // Sanctum::currentRequestHost(),
    ))),

    /*
    |--------------------------------------------------------------------------
    | Sanctum 认证守卫
    |--------------------------------------------------------------------------
    |
    | 此数组包含 Sanctum 在尝试对请求进行认证时将检查的认证守卫。
    | 如果这些守卫都无法对请求进行认证，Sanctum 将使用传入请求中存在的持有者令牌进行认证。
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | 过期分钟数
    |--------------------------------------------------------------------------
    |
    | 此值控制已颁发的令牌在多少分钟后将被视为过期。
    | 这将覆盖令牌 "expires_at" 属性中设置的任何值，但第一方会话不受影响。
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | 令牌前缀
    |--------------------------------------------------------------------------
    |
    | Sanctum 可以为新令牌添加前缀，以便利用开源平台维护的众多安全扫描机制，
    | 这些机制会在开发者将令牌提交到代码仓库时通知他们。
    |
    | 请参阅：https://docs.github.com/en/code-security/secret-scanning/about-secret-scanning
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Sanctum 中间件
    |--------------------------------------------------------------------------
    |
    | 使用 Sanctum 对第一方单页应用 (SPA) 进行认证时，
    | 你可能需要自定义 Sanctum 在处理请求时使用的一些中间件。
    | 你可以根据需要更改下面列出的中间件。
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => Illuminate\Cookie\Middleware\EncryptCookies::class,
        'validate_csrf_token' => Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
    ],

];
