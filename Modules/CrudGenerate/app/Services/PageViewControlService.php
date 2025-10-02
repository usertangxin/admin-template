<?php

namespace Modules\CrudGenerate\Services;

use Exception;
use JsonSerializable;
use Modules\CrudGenerate\Interfaces\PageViewControl;
use Modules\CrudGenerate\Models\SystemCrudHistory;

class PageViewControlService implements JsonSerializable
{
    /**
     * 页面控件列表
     *
     * @var array<PageViewControl>
     */
    protected $pageViewControls = [];

    public function jsonSerialize(): mixed
    {
        $arr = [];
        foreach ($this->pageViewControls as $pageViewControl) {
            $arr[$pageViewControl->getName()] = [
                'label'         => $pageViewControl->getLabel(),
                'name'          => $pageViewControl->getName(),
                'specialParams' => $pageViewControl->getSpecialParams(),
                'queryParams'   => $pageViewControl->getQueryParams(),
            ];
        }

        return $arr;
    }

    /**
     * 添加字段控件
     *
     * @param  class-string<PageViewControl> $pageViewControl
     * @return void
     *
     * @throws Exception
     */
    public function add($pageViewControl)
    {
        if (! is_a($pageViewControl, PageViewControl::class, true)) {
            throw new Exception('Page view control must be instance of PageViewControl');
        }
        $this->pageViewControls[$pageViewControl->getName()] = $pageViewControl;
    }

    /**
     * 合并页面控件
     *
     * @return void
     *
     * @throws Exception
     */
    public function merge(array $pageViewControls)
    {
        foreach ($pageViewControls as $pageViewControl) {
            if (! $pageViewControl instanceof PageViewControl) {
                throw new Exception('Page view control must be instance of PageViewControl');
            }
            if ($this->has($pageViewControl->getName())) {
                unset($this->pageViewControls[$pageViewControl->getName()]);
            }
            $this->add($pageViewControl);
        }
    }

    /**
     * 判断页面控件是否存在
     */
    public function has(string|PageViewControl $name): bool
    {
        return isset($this->pageViewControls[$name instanceof PageViewControl ? $name->getName() : $name]);
    }

    /**
     * 分析索引查询HTML片段
     * @param SystemCrudHistory $crudHistory 
     * @return string 
     */
    public function analysisIndexSearchHtmlFragment(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content     = '';
        foreach ($column_list as $column) {
            if ($column['gen_query'] == 'yes') {
                if (! $column['page_view_control']) {
                    continue;
                }
                $pageViewControl = $this->pageViewControls[$column['page_view_control']];
                $pageViewControl->make($column, $column_list, $crudHistory);
                $fragment = $pageViewControl->getIndexQueryHtmlFragment();
                if (! $fragment) {
                    continue;
                }

                $content .= $fragment . PHP_EOL;
            }
        }

        $lines         = explode("\n", $content);
        $indentedLines = array_map(function ($index, $line) {
            return '            ' . $line;
        }, array_keys($lines), $lines);
        $content = implode("\n", $indentedLines);

        return $content;
    }

    /**
     * 分析索引列片段
     *
     * @return string
     */
    public function analysisIndexColumnFragment(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content     = '';
        foreach ($column_list as $column) {
            if ($column['gen_index'] == 'yes') {
                if (! $column['page_view_control']) {
                    continue;
                }
                $pageViewControl = $this->pageViewControls[$column['page_view_control']];
                $pageViewControl->make($column, $column_list, $crudHistory);
                $arr = $pageViewControl->getIndexColumnFragment();
                if ($column['gen_sort'] == 'yes') {
                    $arr = array_merge(['sortable' => ['sortDirections' => ['ascend', 'descend'], 'sorter' => true]], $arr);
                }
                $arr = array_merge(['title' => $column['comment'], 'dataIndex' => $column['field_name']], $arr);
                $content .= '        ' . json_encode($arr, JSON_UNESCAPED_UNICODE) . ',' . PHP_EOL;
            }
        }

        return $content;
    }

    /**
     * 分析表单代码片段
     *
     * @return string|false
     */
    public function analysisFormCodeFragment(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content     = '';
        foreach ($column_list as $column) {
            if ($column['gen_form'] == 'yes') {
                if (! $column['page_view_control']) {
                    continue;
                }
                $pageViewControl = $this->pageViewControls[$column['page_view_control']];
                $pageViewControl->make($column, $column_list, $crudHistory);
                $fragment = $pageViewControl->getFormCodeHtmlFragment();
                $content .= $fragment . PHP_EOL;
            }
        }

        return $content;
    }

    public function analysisQueryScopeFragment(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content     = '';

        foreach ($column_list as $column) {
            if ($column['gen_query'] == 'yes') {
                if (! $column['page_view_control']) {
                    continue;
                }
                $pageViewControl = $this->pageViewControls[$column['page_view_control']];
                $pageViewControl->make($column, $column_list, $crudHistory);
                $fragment = $pageViewControl->getQueryScopeFragment();
                $content .= $fragment . PHP_EOL;
            }
        }

        return $content;
    }

    public function analysisCasts(SystemCrudHistory $crudHistory)
    {
        $casts       = '';
        $column_list = $crudHistory->column_list;
        foreach ($column_list as $column) {
            if (! $column['page_view_control']) {
                continue;
            }
            $pageViewControls = $this->pageViewControls[$column['page_view_control']];
            $pageViewControls->make($column, $column_list, $crudHistory);
            $cast = $pageViewControls->getModelCast();
            if ($cast) {
                $cast = '\'' . $cast . '\'';
                $casts .= <<<CODE
        '{$column['field_name']}' => $cast,
CODE;
            }
        }

        return $casts;
    }

    public function analysisRequestRules(SystemCrudHistory $crudHistory)
    {
        $rules = '';
        $column_list = $crudHistory->column_list;
        foreach ($column_list as $column) {
            if (! $column['page_view_control']) {
                continue;
            }
            if ($column['gen_form'] !== 'yes') {
                continue;
            }
            $pageViewControls = $this->pageViewControls[$column['page_view_control']];
            $pageViewControls->make($column, $column_list, $crudHistory);
            $rule = $pageViewControls->getRequestRules();
            if ($rule) {
                if (is_string($rule)) {
                    $rule = explode('|', $rule);
                }
                if ($column['nullable'] == 'yes') {
                    array_unshift($rule, 'nullable');
                } else {
                    array_unshift($rule, 'required');
                }
                $rule = implode('|', $rule);
                $rules .= <<<CODE
        '{$column['field_name']}' => '$rule',
    
CODE;
            }
        }

        return $rules;
    }
}
