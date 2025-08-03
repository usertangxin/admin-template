<?php

use Dedoc\Scramble\Http\Middleware\RestrictedDocsAccess;

return [
    /*
     * 你的 API 路径。默认情况下，所有以该路径开头的路由都将添加到文档中。
     * 如果你需要更改此行为，可以使用 `Scramble::routes()` 添加自定义路由解析器。
     */
    'api_path' => 'api',

    /*
     * 你的 API 域名。默认情况下，使用应用程序域名。这也是默认 API 路由匹配器的一部分，因此在实现自定义匹配器时，如果需要，请确保使用此配置。
     */
    'api_domain' => null,

    /*
     * 你的 OpenAPI 规范将导出的路径。
     */
    'export_path' => 'api.json',

    'info' => [
        /*
         * API 版本。
         */
        'version' => env('API_VERSION', '0.0.1'),

        /*
         * 渲染在 API 文档主页 (`/docs/api`) 上的描述。
         */
        'description' => '',
    ],

    /*
     * 自定义 Stoplight Elements 界面
     */
    'ui' => [
        /*
         * 定义文档网站的标题。当此配置为 `null` 时，使用应用程序名称。
         */
        'title' => 'Laravel后台管理模板',

        /*
         * 定义文档的主题。可用选项为 `light`（浅色）和 `dark`（深色）。
         */
        'theme' => 'dark',

        /*
         * 隐藏 `Try It`（试一下）功能。默认启用该功能。
         */
        'hide_try_it' => false,

        /*
         * 隐藏目录中的模式。默认启用该功能。
         */
        'hide_schemas' => false,

        /*
         * 图片的 URL，该图片将显示为标题旁边、目录上方的小方形徽标。
         */
        'logo' => '',

        /*
         * 用于获取 `Try It` 功能的凭证策略。选项有：omit（省略）、include（包含，默认值）和 same-origin（同源）
         */
        'try_it_credentials_policy' => 'include',

        /*
         * Elements 有三种布局：
         * - sidebar - （Elements 默认布局）三栏设计，带有可调整大小的侧边栏。
         * - responsive - 类似于 sidebar，不同之处在于在小屏幕尺寸下，侧边栏会折叠到一个可切换打开的抽屉中。
         * - stacked - 所有内容都在单列中，便于与已有侧边栏或其他栏的现有网站集成。
         */
        'layout' => 'responsive',
    ],

    /*
     * API 的服务器列表。默认情况下，当值为 `null` 时，
     * 服务器 URL 将根据 `scramble.api_path` 和 `scramble.api_domain` 配置变量生成。
     * 提供数组时，你需要手动指定本地服务器 URL（如果需要）。
     *
     * 非默认配置示例（最终 URL 使用 Laravel `url` 辅助函数生成）：
     *
     * ```php
     * 'servers' => [
     *     'Live' => 'api',
     *     'Prod' => 'https://scramble.dedoc.co/api',
     * ],
     * ```
     */
    'servers' => null,

    /**
     * 确定 Scramble 如何存储枚举用例的描述。
     * 可用选项：
     * - 'description' – 用例描述以表格格式存储为枚举模式的描述。
     * - 'extension' – 用例描述存储在 `x-enumDescriptions` 枚举模式扩展中。
     *
     *    @see https://redocly.com/docs-legacy/api-reference-docs/specification-extensions/x-enum-descriptions
     * - false - 忽略用例描述。
     */
    'enum_cases_description_strategy' => 'description',

    'middleware' => [
        'web',
        RestrictedDocsAccess::class,
    ],

    'extensions' => [],
];
