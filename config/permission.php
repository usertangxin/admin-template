<?php

return [

    'models' => [

        /*
         * 使用此包中的 "HasPermissions" trait 时，我们需要知道应该使用哪个
         * Eloquent 模型来检索权限。当然，它通常只是 "Permission" 模型，但你可以使用任何你喜欢的模型。
         *
         * 你想用作权限模型的模型需要实现 `Spatie\Permission\Contracts\Permission` 契约。
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * 使用此包中的 "HasRoles" trait 时，我们需要知道应该使用哪个
         * Eloquent 模型来检索角色。当然，它通常只是 "Role" 模型，但你可以使用任何你喜欢的模型。
         *
         * 你想用作角色模型的模型需要实现 `Spatie\Permission\Contracts\Role` 契约。
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * 使用此包中的 "HasRoles" trait 时，我们需要知道应该使用哪个
         * 表来检索角色。我们已经选择了一个基本的默认值，但你可以轻松将其更改为任何你喜欢的表。
         */

        'roles' => 'roles',

        /*
         * 使用此包中的 "HasPermissions" trait 时，我们需要知道应该使用哪个
         * 表来检索权限。我们已经选择了一个基本的默认值，但你可以轻松将其更改为任何你喜欢的表。
         */

        'permissions' => 'permissions',

        /*
         * 使用此包中的 "HasPermissions" trait 时，我们需要知道应该使用哪个
         * 表来检索模型的权限。我们已经选择了一个基本的默认值，但你可以轻松将其更改为任何你喜欢的表。
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * 使用此包中的 "HasRoles" trait 时，我们需要知道应该使用哪个
         * 表来检索模型的角色。我们已经选择了一个基本的默认值，但你可以轻松将其更改为任何你喜欢的表。
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * 使用此包中的 "HasRoles" trait 时，我们需要知道应该使用哪个
         * 表来检索角色的权限。我们已经选择了一个基本的默认值，但你可以轻松将其更改为任何你喜欢的表。
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * 如果你想使用非默认名称来命名相关的关联表字段，请修改此处
         */
        'role_pivot_key' => null, // default 'role_id',
        'permission_pivot_key' => null, // default 'permission_id',

        /*
         * 如果你想使用 `model_id` 以外的名称来命名相关模型的主键，请修改此处。
         *
         * 例如，如果你的主键都是 UUID，修改此处会很有用。在这种情况下，可以将其命名为 `model_uuid`。
         */

        'model_morph_key' => 'model_id',

        /*
         * 如果你想使用团队功能，并且相关模型的外键不是 `team_id`，请修改此处。
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * 设置为 true 时，检查权限的方法将在 gate 上注册。
     * 如果你想实现自定义的权限检查逻辑，请将此设置为 false。
     */

    'register_permission_check_method' => true,

    /*
     * 设置为 true 时，将注册 Laravel\Octane\Events\OperationTerminated 事件监听器，
     * 这将在每次 TickTerminated、TaskTerminated 和 RequestTerminated 时刷新权限。
     * 注意：大多数情况下不需要这样做，但 Octane/Vapor 组合可能会从中受益。
     */
    'register_octane_reset_listener' => false,

    /*
     * 当角色或权限被分配/取消分配时，会触发以下事件：
     * \Spatie\Permission\Events\RoleAttached
     * \Spatie\Permission\Events\RoleDetached
     * \Spatie\Permission\Events\PermissionAttached
     * \Spatie\Permission\Events\PermissionDetached
     *
     * 若要启用，请设置为 true，然后创建监听器来监听这些事件。
     */
    'events_enabled' => false,

    /*
     * 团队功能。
     * 当设置为 true 时，该包会使用 'team_foreign_key' 实现团队功能。
     * 如果你希望在迁移时注册 'team_foreign_key'，必须在执行迁移前将此设置为 true。
     * 如果你已经执行过迁移，则必须创建一个新的迁移文件，将 'team_foreign_key' 添加到 'roles'、'model_has_roles' 和 'model_has_permissions' 表中
     * （查看该包最新版本的迁移文件）
     */

    'teams' => false,

    /*
     * 用于解析权限团队 ID 的类
     */
    'team_resolver' => \Spatie\Permission\DefaultTeamResolver::class,

    /*
     * Passport 客户端凭证授权
     * 当设置为 true 时，该包将使用 Passport 客户端来检查权限
     */

    'use_passport_client_credentials' => false,

    /*
     * 当设置为 true 时，所需的权限名称将被添加到异常消息中。
     * 在某些场景下，这可能会导致信息泄露，因此为了确保最佳安全性，默认设置为 false。
     */

    'display_permission_in_exception' => false,

    /*
     * 当设置为 true 时，所需的角色名称将被添加到异常消息中。
     * 在某些场景下，这可能会导致信息泄露，因此为了确保最佳安全性，默认设置为 false。
     */

    'display_role_in_exception' => false,

    /*
     * 默认情况下，通配符权限查找功能是禁用的。
     * 请查看文档以了解支持的语法。
     */

    'enable_wildcard_permission' => false,

    /*
     * 用于解释通配符权限的类。
     * 如果你需要修改分隔符，请重写该类并在此指定其名称。
     */
    // 'wildcard_permission' => Spatie\Permission\WildcardPermission::class,

    /* Cache-specific settings */

    'cache' => [

        /*
         * 默认情况下，所有权限会被缓存 24 小时以提高性能。
         * 当权限或角色更新时，缓存会自动刷新。
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * 用于存储所有权限的缓存键。
         */

        'key' => 'spatie.permission.cache',

        /*
         * 你可以选择指定一个特定的缓存驱动来缓存权限和角色，可使用 cache.php 配置文件中列出的任何 `store` 驱动。
         * 此处使用 'default' 表示使用 cache.php 中设置的 `default` 驱动。
         */

        'store' => 'default',
    ],
];
