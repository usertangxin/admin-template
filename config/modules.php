<?php

use Illuminate\Support\Str;
use Nwidart\Modules\Activators\FileActivator;
use Nwidart\Modules\Providers\ConsoleServiceProvider;

return [
    /*
     * |--------------------------------------------------------------------------
     * | 模块命名空间
     * |--------------------------------------------------------------------------
     * |
     * | 默认的模块命名空间。
     * |
     */
    'namespace' => 'Modules',

    /*
     * |--------------------------------------------------------------------------
     * | 模块存根
     * |--------------------------------------------------------------------------
     * |
     * | 默认的模块存根。
     * |
     */
    'stubs' => [
        'enabled' => false,
        'path'    => base_path('stubs/nwidart-stubs'),
        'files'   => [
            'routes/web'      => 'routes/web.php',
            'routes/api'      => 'routes/api.php',
            'views/index'     => 'resources/views/index.blade.php',
            'views/master'    => 'resources/views/components/layouts/master.blade.php',
            'scaffold/config' => 'config/config.php',
            'composer'        => 'composer.json',
            'assets/js/app'   => 'resources/assets/js/app.js',
            'assets/sass/app' => 'resources/assets/sass/app.scss',
            'vite'            => 'vite.config.js',
            'package'         => 'package.json',
        ],
        'replacements' => [
            /**
             * ❗❗❗请勿在配置文件中使用闭包，除非你 不缓存 配置文件❗❗❗
             * ❗❗❗在执行配置缓存时配置中不能包含任何闭包，任何地方修改的配置中含有闭包都不行，闭包不能被正常序列化❗❗❗
             * ❗❗❗任何含有闭包的配置都需要排除在缓存之外，问题在于序列化❗❗❗
             *
             * 为每个部分定义自定义替换项。
             * 您可以为动态值指定一个闭包。
             *
             * 示例:
             *
             * 'composer' => [
             *      'CUSTOM_KEY' => fn (\Nwidart\Modules\Generators\ModuleGenerator $generator) => $generator->getModule()->getLowerName() . '-module',
             *      'CUSTOM_KEY2' => fn () => 'custom text',
             *      'LOWER_NAME',
             *      'STUDLY_NAME',
             *      // ...
             * ],
             *
             * 注意: 键名应使用大写字母。
             */
            'routes/web' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'PLURAL_LOWER_NAME',
                'KEBAB_NAME',
                'MODULE_NAMESPACE',
                'CONTROLLER_NAMESPACE',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'routes/api' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'PLURAL_LOWER_NAME',
                'KEBAB_NAME',
                'MODULE_NAMESPACE',
                'CONTROLLER_NAMESPACE',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'vite' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'KEBAB_NAME',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'json' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'KEBAB_NAME',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'views/index' => [
                'LOWER_NAME',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'views/master' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'KEBAB_NAME',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'scaffold/config' => [
                'STUDLY_NAME',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
                'APP_FOLDER_NAME',
                // 'SNAKE_NAME' => fn (Nwidart\Modules\Generators\ModuleGenerator $generator) => Str::snake($generator->getName()),
            ],
        ],
        'gitkeep' => true,
    ],
    'paths' => [
        /*
         * |--------------------------------------------------------------------------
         * | 模块路径
         * |--------------------------------------------------------------------------
         * |
         * | 此路径用于保存生成的模块。
         * | 此路径也会自动添加到扫描文件夹列表中。
         * |
         */
        'modules' => base_path('Modules'),

        /*
         * |--------------------------------------------------------------------------
         * | 模块资源路径
         * |--------------------------------------------------------------------------
         * |
         * | 您可以在此处更新模块的资源路径。
         * |
         */
        'assets' => public_path('modules'),

        /*
         * |--------------------------------------------------------------------------
         * | 迁移文件路径
         * |--------------------------------------------------------------------------
         * |
         * | 当您运行 'module:publish-migration' 命令时，迁移文件将发布到哪里？
         * |
         */
        'migration' => base_path('database/migrations'),

        /*
         * |--------------------------------------------------------------------------
         * | 应用程序文件夹名称
         * |--------------------------------------------------------------------------
         * |
         * | app文件夹名称
         * | 例如可以将其更改为 'src' 或 'App'
         */
        'app_folder' => 'app/',

        /*
         * |--------------------------------------------------------------------------
         * | 生成器路径
         * |--------------------------------------------------------------------------
         * | 自定义文件夹生成的路径。
         * | 将 generate 键设置为 false 则不会生成该文件夹
         */
        'generator' => [
            // app/
            'actions'         => ['path' => 'app/Actions', 'generate' => false],
            'casts'           => ['path' => 'app/Casts', 'generate' => false],
            'channels'        => ['path' => 'app/Broadcasting', 'generate' => false],
            'class'           => ['path' => 'app/Classes', 'generate' => false],
            'command'         => ['path' => 'app/Console', 'generate' => false],
            'component-class' => ['path' => 'app/View/Components', 'generate' => false],
            'emails'          => ['path' => 'app/Emails', 'generate' => false],
            'event'           => ['path' => 'app/Events', 'generate' => false],
            'enums'           => ['path' => 'app/Enums', 'generate' => false],
            'exceptions'      => ['path' => 'app/Exceptions', 'generate' => false],
            'jobs'            => ['path' => 'app/Jobs', 'generate' => false],
            'helpers'         => ['path' => 'app/Helpers', 'generate' => false],
            'interfaces'      => ['path' => 'app/Interfaces', 'generate' => false],
            'listener'        => ['path' => 'app/Listeners', 'generate' => false],
            'model'           => ['path' => 'app/Models', 'generate' => false],
            'notifications'   => ['path' => 'app/Notifications', 'generate' => false],
            'observer'        => ['path' => 'app/Observers', 'generate' => false],
            'policies'        => ['path' => 'app/Policies', 'generate' => false],
            'provider'        => ['path' => 'app/Providers', 'generate' => true],
            'repository'      => ['path' => 'app/Repositories', 'generate' => false],
            'resource'        => ['path' => 'app/Transformers', 'generate' => false],
            'route-provider'  => ['path' => 'app/Providers', 'generate' => true],
            'rules'           => ['path' => 'app/Rules', 'generate' => false],
            'services'        => ['path' => 'app/Services', 'generate' => false],
            'scopes'          => ['path' => 'app/Models/Scopes', 'generate' => false],
            'traits'          => ['path' => 'app/Traits', 'generate' => false],
            // app/Http/
            'controller' => ['path' => 'app/Http/Controllers', 'generate' => true],
            'filter'     => ['path' => 'app/Http/Middleware', 'generate' => false],
            'request'    => ['path' => 'app/Http/Requests', 'generate' => false],
            // config/
            'config' => ['path' => 'config', 'generate' => true],
            // database/
            'factory'   => ['path' => 'database/factories', 'generate' => true],
            'migration' => ['path' => 'database/migrations', 'generate' => true],
            'seeder'    => ['path' => 'database/seeders', 'generate' => true],
            // lang/
            'lang' => ['path' => 'lang', 'generate' => false],
            // resource/
            'assets'         => ['path' => 'resources/assets', 'generate' => true],
            'component-view' => ['path' => 'resources/views/components', 'generate' => false],
            'views'          => ['path' => 'resources/views', 'generate' => true],
            // routes/
            'routes' => ['path' => 'routes', 'generate' => true],
            // tests/
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'test-unit'    => ['path' => 'tests/Unit', 'generate' => true],
        ],
    ],

    /*
     * |--------------------------------------------------------------------------
     * | 模块自动发现
     * |--------------------------------------------------------------------------
     * |
     * | 您可以在此处配置模块的自动发现功能
     * | 这有助于简化模块提供者的配置。
     * |
     */
    'auto-discover' => [
        /*
         * |--------------------------------------------------------------------------
         * | 迁移文件
         * |--------------------------------------------------------------------------
         * |
         * | 此选项用于自动注册迁移文件。
         * |
         */
        'migrations' => true,

        /*
         * |--------------------------------------------------------------------------
         * | 翻译文件
         * |--------------------------------------------------------------------------
         * |
         * | 此选项用于自动注册语言文件。
         * |
         */
        'translations' => false,
    ],

    /*
     * |--------------------------------------------------------------------------
     * | 包命令
     * |--------------------------------------------------------------------------
     * |
     * | 您可以在此处定义哪些命令将在您的应用程序中可见并使用。
     * | 您可以在合并部分添加自己的命令。
     * |
     */
    'commands' => ConsoleServiceProvider::defaultCommands()
        ->merge([
            // New commands go here
        ])
        ->toArray(),

    /*
     * |--------------------------------------------------------------------------
     * | 扫描路径
     * |--------------------------------------------------------------------------
     * |
     * | 您可以在此处定义要扫描的文件夹。默认情况下，将扫描 vendor 目录。
     * | 如果您将包托管在 packagist 网站上，这将很有用。
     * |
     */
    'scan' => [
        'enabled' => false,
        'paths'   => [
            base_path('vendor/*/*'),
        ],
    ],

    /*
     * |--------------------------------------------------------------------------
     * | Composer 文件模板
     * |--------------------------------------------------------------------------
     * |
     * | 这是由该包生成的 composer.json 文件的配置
     * |
     */
    'composer' => [
        'vendor' => env('MODULE_VENDOR', 'nwidart'),
        'author' => [
            'name'  => env('MODULE_AUTHOR_NAME', 'Nicolas Widart'),
            'email' => env('MODULE_AUTHOR_EMAIL', 'n.widart@gmail.com'),
        ],
        'composer-output' => false,
    ],

    /*
     * |--------------------------------------------------------------------------
     * | 选择 laravel-modules 将注册为自定义命名空间的内容。
     * | 将某个选项设置为 false 则需要您在自己的服务提供者类中注册该部分。
     * |--------------------------------------------------------------------------
     */
    'register' => [
        'translations' => true,
        /** 在启动或注册方法时加载文件 */
        'files' => 'register',
    ],

    /*
     * |--------------------------------------------------------------------------
     * | 激活器
     * |--------------------------------------------------------------------------
     * |
     * | 您可以在此处定义新类型的激活器，如文件、数据库等。唯一需要的参数是 'class'。
     * | 文件激活器将激活状态存储在 storage/installed_modules 中。
     */
    'activators' => [
        'file' => [
            'class'         => FileActivator::class,
            'statuses-file' => base_path('modules_statuses.json'),
        ],
    ],
    'activator' => 'file',
];
