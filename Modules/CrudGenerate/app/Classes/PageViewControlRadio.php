<?php

namespace Modules\CrudGenerate\Classes;

use Illuminate\Support\Str;

class PageViewControlRadio extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return [
            new SpecialParamKv(required: true),
        ];
    }

    public function getRequestRules(): null|array|string
    {
        return [
            'in:' . implode(',', array_column($this->innerGetSpecialParam('kv', []), 1)),
        ];
    }

    public function getQueryParams(): array|string
    {
        return [
            new SpecialParamYesOrNo('多选查询', 'mul_select'),
        ];
    }

    public function getQueryScopeFragment(): string
    {
        $mul_select = $this->innerGetQueryParam('mul_select', 'no');

        if ($mul_select == 'yes') {
            $name = $this->getFieldName();
            $name = Str::studly($name);

            return <<<code
                protected function scope{$name}(Builder \$query, \$value)
                {
                    if (\$value && is_array(\$value) && count(\$value) > 0) {
                        \$query->whereIn('{$this->getFieldName()}', \$value);
                    } else {
                        \$query->where('{$this->getFieldName()}', \$value);
                    }
                }
            code;
        }

        return '';
    }

    public function getFormCodeFragment(): string
    {
        $options = [];

        $kv = $this->innerGetSpecialParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <a-form-item label="{$this->getLabel()}" field="{$this->getFieldName()}">
                <a-radio-group v-model="formData.{$this->getFieldName()}" :options='$options'"></a-radio-group>
            </a-form-item>
        code;
    }

    public function getIndexQueryHtmlFragment(): string
    {
        $options = [];

        $kv = $this->innerGetSpecialParam('kv', []);
        foreach ($kv as $item) {
            $options[] = ['label' => $item[0], 'value' => $item[1]];
        }

        $options = json_encode($options, JSON_UNESCAPED_UNICODE);

        return <<<code
            <search-col>
                <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                     <a-select v-model="store.searchQuery.{$this->getFieldName()}" :options='$options'"></a-select>
                </a-form-item>
            </search-col>
        code;
    }
}
