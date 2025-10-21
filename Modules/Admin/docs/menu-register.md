---
title: 菜单注册
---

# 菜单注册

>[!TIP]
> 在注册之后需要前往后台菜单管理中刷新菜单缓存，后台才会看得到

## 从控制器中

```php
<?php
// 控制器需要继承Modules\Admin\Http\Controllers\AbstractController
// 控制器需要添加SystemMenu注解
// 这会在后台创建一个目录

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Http\Controllers\AbstractController;

#[SystemMenu('测试')]
class TestController extends AbstractController {}
```

## 注册菜单功能
```php
<?php 

use Modules\Admin\Classes\Attrs\SystemMenu;

...其他控制器代码

#[SystemMenu('只能get请求')]
public function getTest() {}

#[SystemMenu('只能post请求')]
public function postTest() {}

#[SystemMenu('适用于所有请求')]
public function Test() {}

...其他控制器代码

```

## 手动注册目录
> [!WARNING]
> 你不应该总是让他执行，而是在需要时执行，例如模块被启用时

> [!WARNING]
> 手动注册的目录不会在刷新菜单缓存后生效，因为刷新缓存是解析被注册的路由

```php
<?php

use Modules\Admin\Classes\Utils\SystemMenuManager;

$a[] = new SystemMenu('开发', type: SystemMenuType::GROUP, icon: 'fas fa-code', code: 'system.dev');
$a[] = new SystemMenu('OpenApi', url: 'docs/api', type: SystemMenuType::MENU, icon: 'fas fa-code', code: 'scramble.docs.ui', parent_code: 'system.dev');
$a[] = new SystemMenu('Telescope', url: 'telescope', type: SystemMenuType::MENU, icon: 'fas fa-microscope', code: 'laravel.telescope.view', parent_code: 'system.dev');
$a[] = new SystemMenu('Font Awesome', url: 'https://fontawesome.com/search?ic=free', type: SystemMenuType::LINK, icon: 'fas fa-icons', code: 'fontawesome.com', parent_code: 'system.dev');
    
SystemMenuManager::autoRegister($a);

```

