<?php

namespace Modules\CrudGenerate\Classes;

class PageViewControlTextarea extends AbstractPageViewControl
{
    public function getSpecialParams(): array|string
    {
        return <<<'code'
            <a-form-item label="自适应高度">
                <a-radio-group v-model="params.auto_size" :options="[{label: '是', value: true}, {label: '否', value: false}, {label: '自定义行数', value: 'custom'},]" :default-value="false"></a-radio-group>
            </a-form-item>
            <template v-if="params.auto_size === 'custom'">
                <a-form-item label="自定义行数">
                    <input-range v-model="params.rows" placeholder="请输入行数" :min="1" />
                </a-form-item>
            </template>
            <a-form-item label="最大长度">
                <a-input-number v-model="params.max_length" placeholder="请输入最大长度" :min="1" />
            </a-form-item>
            <a-form-item label="是否显示字数统计">
                <dict-radio v-model="params.show_word_limit" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
            <a-form-item label="是否允许清空">
                <dict-radio v-model="params.allow_clear" code="yes_or_no" default-value="no"></dict-radio>
            </a-form-item>
        code;
    }

    public function getRequestRules(): null|array|string
    {
        $max_length = $this->innerGetSpecialParam('max_length', null);
        $a          = ['string'];
        if ($max_length !== null) {
            $a[] = 'max:' . $max_length;
        }

        return $a;
    }

    public function getQueryParams(): array|string
    {
        return <<<'code'
            <a-form-item label="是否模糊查询" field="query_like">
                <dict-radio v-model="params.query_like" code="yes_or_no" default-value="yes"></dict-radio>
            </a-form-item>
        code;
    }

    public function getQueryScopeFragment(): string
    {

        if ($this->innerGetQueryParam('query_like', 'yes') != 'yes') {
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
        $attrs           = '';
        $auto_size       = $this->innerGetSpecialParam('auto_size', false);
        $rows            = $this->innerGetSpecialParam('rows', null);
        $max_length      = $this->innerGetSpecialParam('max_length', null);
        $show_word_limit = $this->innerGetSpecialParam('show_word_limit', false);
        $allow_clear     = $this->innerGetSpecialParam('allow_clear', false);

        if ($auto_size === 'custom' && $rows !== null) {
            $attrs .= " :auto-size=\"{ minRows: {$rows[0]}, maxRows: {$rows[1]} }\"";
        } elseif ($auto_size === true) {
            $attrs .= ' :auto-size="true"';
        }

        if ($max_length !== null) {
            $attrs .= " :maxlength=\"{$max_length}\"";
        }
        if ($show_word_limit === 'yes') {
            $attrs .= ' :show-word-limit="true"';
        }
        if ($allow_clear === 'yes') {
            $attrs .= ' :allow-clear="true"';
        }

        return <<<code
            <a-form-item label="{$this->getComment()}" field="{$this->getFieldName()}">
                <a-textarea v-model="formData.{$this->getFieldName()}"$attrs></a-textarea>
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
