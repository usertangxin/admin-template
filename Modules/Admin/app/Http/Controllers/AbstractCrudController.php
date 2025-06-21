<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Inertia\Inertia;
use InvalidArgumentException;
use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;

abstract class AbstractCrudController extends AbstractController
{

    abstract protected function getModel(): AbstractModel|AbstractSoftDelModel|null;

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

    /**
     * 列表
     * @return mixed 
     * @throws BindingResolutionException 
     */
    public function index()
    {
        $listType = \request('__list_type__', 'list');
        $where = $this->searchWhere();
        $query = ModelUtil::bindSearch($this->getModel(), $where);
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
                $data = ($this->getTreeCollection())::new($query->get())->toArray();
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
        return $this->inertia($data);
    }

    /**
     * 读取详情
     * @param mixed $id 
     * @return mixed 
     */
    public function getRead($id)
    {
        $data = $this->getModel()->find($id);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $data = $data->toResourceCollection($resourceCollection);
        }
        return $this->success($data);
    }

    public function getSave()
    {
        return $this->inertia();
    }

    /**
     * 添加
     * @return mixed 
     * @throws BindingResolutionException 
     * @throws InvalidArgumentException 
     */
    public function postSave()
    {
        $data = request()->all();
        $this->validator('save', $data);
        $result = $this->getModel()->create($data);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $result = $result->toResourceCollection($resourceCollection);
        }
        return $this->success($result);
    }

    /**
     * 编辑
     * @param mixed $id 
     * @return mixed 
     * @throws BindingResolutionException 
     * @throws InvalidArgumentException 
     */
    public function update($id)
    {
        $data = request()->all();
        $this->validator('update', $data);
        $result = $this->getModel()->find($id)->update($data);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $result = $result->toResourceCollection($resourceCollection);
        }
        return $this->success($result);
    }

    /**
     * 切换状态
     * @param mixed $id 
     * @param mixed $status 
     * @return mixed 
     */
    public function changeStatus($id, $status) {
        $result = $this->getModel()->find($id)->update(['status' => $status]);
        if (!empty($resourceCollection = $this->getResourceCollection())) {
            $result = $result->toResourceCollection($resourceCollection);
        }
        return $this->success($result);
    }

    /**
     * 删除
     * @param mixed $id 
     * @return int 
     */
    public function destroy($id) {
        return $this->success($this->getModel()->destroy($id));
    }

    /**
     * 回收站
     * @return mixed 
     * @throws BindingResolutionException 
     */
    public function recycle()
    {
        $listType = \request('__list_type__', 'list');
        $where = $this->searchWhere();
        $query = ModelUtil::bindSearch($this->getModel()->onlyTrashed(), $where);
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
                $data = ($this->getTreeCollection())::new($query->get())->toArray();
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
        return $this->success($data);
    }

    /**
     * 恢复
     * @return void 
     * @throws BindingResolutionException 
     */
    public function recovery()
    {
        $ids = request('ids');
        return $this->success($this->getModel()->withTrashed()->whereIn('id', $ids)->restore());
    }

    /**
     * 永久删除
     * @return void 
     * @throws BindingResolutionException 
     */
    public function realDestroy()
    {
        $ids = request('ids');
        return $this->success($this->getModel()->withTrashed()->whereIn('id', $ids)->forceDelete());
    }
}
