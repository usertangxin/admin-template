<?php

namespace Modules\CrudGenerate\Services;

use Exception;
use JsonSerializable;
use Modules\CrudGenerate\Interfaces\FieldControl;
use Modules\CrudGenerate\Interfaces\SpecialParam;
use Modules\CrudGenerate\Models\SystemCrudHistory;

class FieldControlService implements JsonSerializable
{
    /**
     * 字段控件列表
     *
     * @var array<FieldControl>
     */
    protected $fieldControls = [];

    public function jsonSerialize(): mixed
    {
        $arr = [];
        foreach ($this->fieldControls as $fieldControl) {
            $arr[$fieldControl->getName()] = [
                'label'         => $fieldControl->getLabel(),
                'name'          => $fieldControl->getName(),
                'specialParams' => $fieldControl->getSpecialParams(),
            ];
        }

        return $arr;
    }

    /**
     * 添加字段控件
     *
     * @param  class-string<FieldControl>  $fieldControl
     * @return void
     *
     * @throws Exception
     */
    public function add($fieldControl)
    {
        if (! is_a($fieldControl, FieldControl::class, true)) {
            throw new Exception('Field control must be instance of FieldControl');
        }
        $this->fieldControls[$fieldControl->getName()] = $fieldControl;
    }

    /**
     * 合并字段控件
     *
     * @return void
     *
     * @throws Exception
     */
    public function merge(array $fieldControls)
    {
        foreach ($fieldControls as $fieldControl) {
            if (! $fieldControl instanceof FieldControl) {
                throw new Exception('Field control must be instance of FieldControl');
            }
            if ($this->has($fieldControl->getName())) {
                unset($this->fieldControls[$fieldControl->getName()]);
            }
            $this->add($fieldControl);
        }
    }

    /**
     * 判断字段控件是否存在
     */
    public function has(string|FieldControl $name): bool
    {
        return isset($this->fieldControls[$name instanceof FieldControl ? $name->getName() : $name]);
    }

    public function analysisFieldContent(SystemCrudHistory $crudHistory)
    {
        $column_list = $crudHistory->column_list;
        $content = '';
        foreach ($column_list as $column) {
            $fieldControl = $this->fieldControls[$column['field_control']];
            $fieldControl->make($column, $column_list, $crudHistory);
            $fragment = $fieldControl->getMigrateCodeFragment();
            $fragment  = '$table->' . $fragment;
            if ($crudHistory['primary_key'] == $column['field_name']) {
                $fragment .= '->primary()';
            }
            if ($column['nullable']) {
                $fragment .= '->nullable()';
            }
            if ($column['default_value'] !== null) {
                $fragment .= '->default(' . $column['default_value'] . ')';
            }
            if ($column['comment']) {
                $fragment .= '->comment(\'' . $column['comment'] . '\')';
            }
            $content .= $fragment . ';' . PHP_EOL;
        }
        $content .= <<<CODE
\$table->dateTime('created_at')->nullable()->comment('创建时间');
\$table->dateTime('updated_at')->nullable()->comment('更新时间');

CODE;
        if ($crudHistory->soft_delete) {
            $content .= '$table->dateTime(\'deleted_at\')->nullable()->comment(\'删除时间\');' . PHP_EOL;
        }
        return $content;
    }
}
