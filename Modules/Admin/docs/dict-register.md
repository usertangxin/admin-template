---
title: 字典注册
---

# 字典注册

> [!TIP]
> 字典注册是指在模块中注册字典项，这些字典项可以在后台的字典管理中进行管理。

> [!WARNING]
> 你不应该总是让他执行，而是在需要时执行，例如模块被启用时

## 注册字典组

```php
<?php

use Modules\Admin\Classes\Utils\SystemDictUtil;

SystemDictUtil::autoRegisterTypes([
    [
        'name' => [
            'zh_CN' => '存储模式',
            'en'    => 'Storage Mode',
        ],
        'code'   => 'storage_mode', // 不能被国际化，他是唯一标识
        'remark' => [
            'zh_CN' => '上传文件存储模式',
            'en'    => 'Uploaded File Storage Mode',
        ],
    ],
]);

```

## 注册字典项

```php
<?php

use Modules\Admin\Classes\Utils\SystemDictUtil;

SystemConfigUtil::autoResisterConfig([
    [
        'label' => [
            'zh_CN' => '本地私有',
            'en'    => 'Private',
        ],
        'value'  => 'private', // 不能被国际化
        'code'   => 'storage_mode', // 不能被国际化
        'remark' => '',
    ],
]);

```