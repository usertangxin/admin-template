<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 跨域资源共享 (CORS) 配置
    |--------------------------------------------------------------------------
    |
    | 在这里你可以配置跨域资源共享（即 "CORS"）的设置。
    | 这些设置决定了哪些跨域操作可以在网页浏览器中执行。你可以根据需要调整这些设置。
    |
    | 了解更多信息：https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
