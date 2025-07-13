<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use InvalidArgumentException;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;

abstract class AbstractCrudController extends AbstractController
{
    abstract protected function getModel(): AbstractModel|AbstractSoftDelModel|null;

    /**
     * 显示字段 他会覆盖数据库中的$visible配置
     */
    protected function getVisibleFields(): array
    {
        return [];
    }

    /**
     * 隐藏字段 他会覆盖数据库中的$hidden配置
     */
    protected function getHiddenFields(): array
    {
        return [];
    }

    /**
     * 资源
     */
    protected function getResource(): ?string
    {
        return null;
    }

    /**
     * 树集合
     */
    protected function getTreeCollection(): string
    {
        return TreeCollection::class;
    }

    protected function validator($scene, $data) {}

    /**
     * 关联预加载
     */
    protected function with(): array
    {
        return [];
    }

    /**
     * 搜索条件
     */
    protected function searchWhere(): array
    {
        return [];
    }

    /**
     * 列表
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('列表')]
    public function index()
    {
        $listType = \request('__list_type__', 'list');
        $where = $this->searchWhere();
        /** @var AbstractModel|AbstractSoftDelModel $query */
        $query = ModelUtil::bindSearch($this->getModel(), $where);
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        if (! empty($visible = $this->getVisibleFields())) {
            $query = $query->setVisible($visible);
        }
        if (! empty($hidden = $this->getHiddenFields())) {
            $query = $query->setHidden($hidden);
        }
        switch ($listType) {
            case 'list':
                $data = $query->paginate(\request('per_page', 10));
                break;
            case 'tree':
                $data = ($this->getTreeCollection())::new($query->get())->toArray();
                break;
            case 'all':
                $data = $query->get();
                break;
            default:
                $data = $query->paginate(\request('per_page', 10));
                break;
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = new $resourceCollection($data);
        }

        return $this->success($data);
    }

    /**
     * 读取详情
     *
     * @return mixed
     */
    #[SystemMenu('详情')]
    public function read()
    {
        $id = \request('id');
        $data = $this->getModel()->find($id);
        if (! empty($resourceCollection = $this->getResource())) {
            $data = new $resourceCollection($data);
        }

        return $this->success($data);
    }

    /**
     * 添加
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    #[SystemMenu('添加')]
    public function save()
    {
        if (\request()->method() == 'GET') {
            return $this->inertia();
        }

        $data = request()->all();
        $this->validator('save', $data);
        $result = $this->getModel()->create($data);
        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result);
    }

    /**
     * 编辑
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    #[SystemMenu('编辑')]
    public function update()
    {
        $id = \request('id');
        if (\request()->method() == 'GET') {
            $data = $this->getModel()->find($id);
            if (! empty($resourceCollection = $this->getResource())) {
                $data = new $resourceCollection($data);
            }

            return $this->inertia($data);
        }

        $data = request()->all();
        $this->validator('update', $data);
        $result = $this->getModel()->find($id)->update($data);
        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result);
    }

    /**
     * 切换状态
     *
     * @return mixed
     */
    #[SystemMenu('切换状态')]
    public function changeStatus()
    {
        $id = \request('id');
        $status = \request('status');
        $result = $this->getModel()->find($id)->update(['status' => $status]);
        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result);
    }

    /**
     * 删除
     *
     * @return int
     */
    #[SystemMenu('删除')]
    public function destroy()
    {
        $id = \request('id');

        return $this->success($this->getModel()->destroy($id));
    }

    /**
     * 回收站
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('回收站')]
    public function recycle()
    {
        $listType = \request('__list_type__', 'list');
        $where = $this->searchWhere();
        $query = ModelUtil::bindSearch($this->getModel()->onlyTrashed(), $where);
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        if (! empty($visible = $this->getVisibleFields())) {
            $query = $query->setVisible($visible);
        }
        if (! empty($hidden = $this->getHiddenFields())) {
            $query = $query->setHidden($hidden);
        }
        switch ($listType) {
            case 'list':
                $data = $query->paginate(\request('per_page', 10));
                break;
            case 'tree':
                $data = ($this->getTreeCollection())::new($query->get())->toArray();
                break;
            case 'all':
                $data = $query->get();
                break;
            default:
                $data = $query->paginate(\request('per_page', 10));
                break;
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = new $resourceCollection($data);
        }

        return $this->success($data);
    }

    /**
     * 恢复
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('恢复')]
    public function recovery()
    {
        $ids = request('ids');

        return $this->success($this->getModel()->withTrashed()->whereIn('id', $ids)->restore());
    }

    /**
     * 永久删除
     *
     * @return void
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('永久删除')]
    public function realDestroy()
    {
        $ids = request('ids');

        return $this->success($this->getModel()->withTrashed()->whereIn('id', $ids)->forceDelete());
    }
}
