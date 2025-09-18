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

    public function analysisFormCodeFragment(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content     = '';
        foreach ($column_list as $column) {
            $pageViewControl = $this->pageViewControls[$column['page_view_control']];
            $pageViewControl->make($column, $column_list, $crudHistory);
            $fragment = $pageViewControl->getFormCodeFragment();
            $content .= $fragment . PHP_EOL;
        }

        if (extension_loaded('tidy')) {
            $content = tidy_repair_string($content, [
                'indent'        => true,
                'indent-spaces' => 4,
                'wrap'          => 120,
            ]);
        }

        return $content;
    }
}
