---
title: 数据权限
---

# 数据权限

数据权限是指在系统中对不同用户进行数据访问控制的机制。它可以确保用户只能访问其被授权的数据，而不能访问其他用户的数据。
系统自带了以下数据权限：

- 所有数据权限 `GlobalDataPermissionScopeAll`
- 仅自己数据权限 `GlobalDataPermissionScopeSelf`

> [!warning]
> 需要使用数据权限的模型需要存在 `created_by` 和 `updated_by` 字段，并且字段类型为 `uuid`<br>
> 否则应设置 `public bool $ignoreGlobalDataPermission = true` 关闭全局数据权限

## 特定模型关闭
```php
<?php

...other code

public bool $ignoreGlobalDataPermission = true;

...other code

```

## 注册全局数据权限

全局数据权限被管理员选择

```php
<?php

use Modules\Admin\Services\GlobalDataPermissionScopeService;

class XXXXXXServiceProvider extends ServiceProvider
{
    ...other code

    public function boot(GlobalDataPermissionScopeService $globalDataPermissionScopeService): void
    {
        $globalDataPermissionScopeService->add(new XXX);
        // XXX 需要实现 Modules\Admin\Interfaces\GlobalDataPermissionScopeInterface
    }

    ...other code
}
```

## 针对模型设置数据权限
```php
<?php

use Modules\Admin\Models\Scopes\GlobalDataPermissionScope;

...other code

/**
 * 获取全局数据权限作用域，优先级高于设置的管理员全局数据权限
 */
public function getGlobalDataPermissionScope(): ?GlobalDataPermissionScopeInterface
{
    return null;
}

...other code

```