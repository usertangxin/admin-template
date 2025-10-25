---
title: 路由注册
---

# 路由注册

::: danger
后台路由请至少注册一个 `Modules\Admin\Http\Middleware\AdminSupport` 中间件。并添加路由名称。<br>
:::

你可以使用 `Modules\Admin\Classes\Utils\RouteUtil::fastRoute` 方法来快速注册路由。
该方法将所有公共方法注册为路由。

::: tip
你可以在控制器类中添加 `IGNORE_METHODS` 常量来忽略某些方法。<br>
你可以在控制器类中添加 `IGNORE_ACTIONS` 常量来忽略某些动作。动作是是截取掉前缀后的方法名。例如 `getIndex` 动作就是 `index`, `postStoreInfo` 动作就是 `storeInfo`。也就是说 `getStoreInfo`, `postStoreInfo` 这两个方法的动作都是 `storeInfo`。
:::
