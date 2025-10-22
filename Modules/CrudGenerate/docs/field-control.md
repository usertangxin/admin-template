---
title: 字段控件
---

# 字段控件

## 介绍
`FieldControl` 是用来控制数据库迁移文件生成内容的类，他需要实现 `Modules\CrudGenerate\Interfaces\FieldControl` 接口。

## 自定义 `FieldControl`

## Step 1: 实现 `FieldControl` 接口

你可以继承至 `AbstractFieldControl` 类，这个类实现了 `FieldControl` 一些基础的方法，他提供了一个很好的起点。
<br>更多实现请参阅 `AbstractFieldControl` 类 和 `FieldControl` 接口。

```php
<?php 

use Modules\CrudGenerate\Classes\AbstractFieldControl;

class FieldControlString extends AbstractFieldControl
{
    public function getSpecialParams(): array|string
    {
        // return [
        //     new SpecialParamLength,
        // ];
        return <<<'CODE'
            <a-form-item label="长度">
                <a-input-number v-model="params.length" mode="button" :precision="0" :step="1" :min="1" :max="255" placeholder="请输入长度"/>
            </a-form-item>
        CODE;
    }

    public function getMigrateCodeFragment(): string
    {
        $lengthStr = '';
        if ($length = $this->innerGetSpecialParam('length', null)) {
            $lengthStr = ', ' . $length;
        }

        return 'string(\'' . $this->field['field_name'] . '\'' . $lengthStr . ')';
    }
}
```

## Step 2: 注册 `FieldControl`
```php
<?php

use Modules\CrudGenerate\Services\FieldControlService;

class XXXServiceProvider extends ServiceProvider
{

    ...other code

    public function boot(FieldControlService $fieldControlService): void
    {
        $fieldControlService->add(new FieldControlString);
    }

    ...other code
}

```