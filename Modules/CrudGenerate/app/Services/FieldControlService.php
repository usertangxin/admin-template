<?php

namespace Modules\CrudGenerate\Services;

use Exception;
use JsonSerializable;
use Modules\CrudGenerate\Interfaces\FieldControl;
use Modules\CrudGenerate\Interfaces\SpecialParam;

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
}
