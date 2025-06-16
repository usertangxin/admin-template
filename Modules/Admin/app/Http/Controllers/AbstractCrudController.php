<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Models\AbstractModel;

abstract class AbstractCrudController
{

    abstract protected function getModel(): AbstractModel;

    /**
     * 显示字段 他会覆盖数据库中的$visible配置
     * @return array 
     */
    protected function getVisibleFields(): array
    {
        return [];
    }

    /**
     * 隐藏字段 他会覆盖数据库中的$hidden配置
     * @return array 
     */
    protected function getHiddenFields(): array
    {
        return [];
    }

    /**
     * 资源集合
     * @return string|null 
     */
    protected function getResourceCollection(): ?string
    {
        return null;
    }

    /**
     * 树集合
     * @return string 
     */
    protected function getTreeCollection(): string
    {
        return TreeCollection::class;
    }

    protected function validator($scene, $data) {}

    /**
     * 关联预加载
     * @return array 
     */
    protected function with(): array
    {
        return [];
    }

    /**
     * 搜索条件
     * @return array 
     */
    protected function searchWhere(): array
    {
        return [];
    }

    public function index()
    {
        $listType = \request('__list_type__', 'list');
        $where = $this->searchWhere();
        $query = $this->getModel()->search($where);
        if (!empty($with = $this->with())) {
            $query = $query->with($with);
        }
        if (!empty($visible = $this->getVisibleFields())) {
            $query = $query->setVisible($visible);
        }
        if (!empty($hidden = $this->getHiddenFields())) {
            $query = $query->setHidden($hidden);
        }
        switch ($listType) {
            case 'list':
                $data = $query->paginate();
                break;
            case 'tree':
                $data = (new ($this->getTreeCollection()))($query->get());
                break;
            case 'all':
                $data = $query->get();
                break;
            default:
                $data = $query->paginate();
                break;
        }
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $data = $data->toResourceCollection($resourceCollection);
        }
        return $data;
    }

    public function read($id)
    {
        $data = $this->getModel()->find($id);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $data = $data->toResourceCollection($resourceCollection);
        }
        return $data;
    }

    public function save()
    {
        $data = request()->all();
        $this->validator('save', $data);
        $result = get_class($this->getModel())::create($data);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $result = $result->toResourceCollection($resourceCollection);
        }
        return $result;
    }

    public function update($id)
    {
        $data = request()->all();
        $this->validator('update', $data);
        $result = get_class($this->getModel())::find($id)->update($data);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $result = $result->toResourceCollection($resourceCollection);
        }
        return $result;
    }
}
