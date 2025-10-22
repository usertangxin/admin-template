---
title: 页面视图控件
---

# 页面视图控件

## 介绍
`PageViewControl` 是用来控制页面视图生成内容的类，他需要实现 `Modules\CrudGenerate\Interfaces\PageViewControl` 接口。

:::tip 为什么 `QueryScope`，`ModelCast`，`RequestRules` 这些非页面的代码控制不是在 `FieldControl` 而是在 `PageViewControl` 中。
<br>
因为这些代码可能随业务需求而变化，而不是数据表结构变化而变化，页面的代码会影响这些片段的实现方式<br><br>
例如前端有一个范围查询，那么 `QueryScope` 就需要做出对应调整来支持范围查询。
:::

## 自定义 `PageViewControl`

## Step 1: 实现 `PageViewControl` 接口

你可以继承至 `AbstractPageViewControl` 类，这个类实现了 `PageViewControl` 一些基础的方法，他提供了一个很好的起点。
<br>更多实现请参阅 `AbstractPageViewControl` 类 和 `PageViewControl` 接口。

```php
<?php

use Modules\CrudGenerate\Classes\AbstractPageViewControl;

class PageViewControlInput extends AbstractPageViewControl
{
    public function getQueryParams(): array|string
    {
        return <<<'code'
            <a-form-item label="是否模糊查询" field="query_like">
                <dict-radio v-model="params.query_like" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    public function getQueryScopeFragment(): string
    {

        if ($this->innerGetQueryParam('query_like', 'no') != 'yes') {
            return '';
        }

        $name = $this->getFieldName();

        return <<<code
            #[Scope]
            protected function {$name}(Builder \$query, \$value)
            {
                \$query->where('{$this->getFieldName()}', 'like', "%\$value%");
            }
        code;

    }

    public function getFormCodeHtmlFragment(): string
    {
        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-input v-model="formData.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
            </a-form-item>
        code;
    }

    public function getIndexQueryHtmlFragment(): string
    {
        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                    <a-input v-model="store.searchQuery.{$this->getFieldName()}" placeholder="请输入{$this->getComment()}"></a-input>
                </a-form-item>
            </search-col>
        code;
    }
}

```


## Step 2: 注册 `FieldControl`
```php
<?php

use Modules\CrudGenerate\Services\PageViewControlService;

class XXXServiceProvider extends ServiceProvider
{

    ...other code

    public function boot(PageViewControlService $pageViewControlService): void
    {
        $pageViewControlService->add(new PageViewControlInput);
    }

    ...other code
}

```