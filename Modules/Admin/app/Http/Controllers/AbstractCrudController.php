<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Inertia\Inertia;
use InvalidArgumentException;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Classes\Interfaces\TreeCollectionInterface;
use Modules\Admin\Classes\Service\SystemDictService;
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
     * 每页最大条数
     */
    protected function getMaxPerPage(): int
    {
        return 100;
    }

    /**
     * 视图前缀
     */
    protected function getViewPrefix(): string
    {
        $shortName = \class_basename($this);
        $prefix = Str::of($shortName)->replace('Controller', '')->snake('_');

        return $prefix;
    }

    /**
     * 状态字段和字典编码
     */
    protected function getStatusFieldAndDictCode(): array
    {
        return ['status', 'data_status'];
    }

    /**
     * 排序
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     */
    protected function orderBy(): array
    {
        return request('__order_by__', ['id' => 'desc']);
    }

    /**
     * 资源
     *
     * @return class-string<JsonResource>
     */
    protected function getResource(): ?string
    {
        return null;
    }

    /**
     * 树集合
     *
     * @return class-string<TreeCollectionInterface>
     */
    protected function getTreeCollection(): string
    {
        return TreeCollection::class;
    }

    protected function validate(): array
    {

        if (\request()->route()->getActionMethod() === 'changeStatus') {
            $systemDictService = app()->make(SystemDictService::class);
            $statusFieldAndDictCode = $this->getStatusFieldAndDictCode();
            $field = $statusFieldAndDictCode[0];
            $dictCode = $statusFieldAndDictCode[1];

            return \request()->validate([
                'id'   => 'required',
                $field => [
                    'required',
                    'in:' . \implode(',', $systemDictService->getValuesByCode($dictCode)->toArray()),
                ],
            ]);
        }

        $model_classname = get_class($this->getModel());
        $request_classname = Str::replace('\\Models\\', '\\Http\\Requests\\', $model_classname) . 'Request';
        /** @var \Illuminate\Foundation\Http\FormRequest */
        $request = \app()->make($request_classname);
        $data = $request->validated();

        return $data;
    }

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
        $where = [];
        foreach (request()->all() as $key => $value) {
            if (Str::contains($key, '__')) {
                continue;
            }
            if ($value === '') {
                continue;
            }
            $where[$key] = $value;
        }

        return $where;
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
        $model = $this->getModel();
        /** @var AbstractModel|AbstractSoftDelModel $query */
        $query = ModelUtil::bindSearch($model->newInstance(), $where);
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        if (! empty($visible = $this->getVisibleFields())) {
            $query = $query->setVisible($visible);
        }
        if (! empty($hidden = $this->getHiddenFields())) {
            $query = $query->setHidden($hidden);
        }
        foreach ($this->orderBy() as $key => $value) {
            $query = $query->orderBy($key, $value);
        }
        switch ($listType) {
            case 'tree':
                $data = ($this->getTreeCollection())::new($query->get())->toTree();
                break;
            case 'all':
                $data = $query->get();
                break;
            default:
                $data = $query->paginate(\min($this->getMaxPerPage(), \request('__per_page__', 10)), pageName: '__page__');
                break;
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = $resourceCollection::collection($data);
        }

        Inertia::share('__page_index__', true);

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
        $data = $this->getModel()->withTrashed()->find($id);
        if (! $data) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = new $resourceCollection($data);
        }

        Inertia::share('__page_read__', true);

        return $this->success($data, view: $this->getViewPrefix() . '/save');
    }

    /**
     * 创建
     *
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException
     */
    #[SystemMenu('创建')]
    public function create()
    {
        Inertia::share('__page_create__', true);

        if (\request()->method() == 'GET') {
            return $this->success(view: $this->getViewPrefix() . '/save');
        }

        $data = $this->validate();
        $result = $this->getModel()->create($data);
        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result, view: $this->getViewPrefix() . '/save');
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
        Inertia::share('__page_update__', true);

        $id = \request('id');
        if (\request()->method() == 'GET') {
            $data = $this->getModel()->find($id);
            if (! empty($resourceCollection = $this->getResource())) {
                $data = new $resourceCollection($data);
            }

            return $this->success($data, view: $this->getViewPrefix() . '/save');
        }

        $data = $this->validate();
        $model = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        $result = $model->update($data);
        if (! $result) {
            return $this->fail('更新失败', view: $this->getViewPrefix() . '/save');
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $model = new $resourceCollection($model);
        }

        return $this->success($model, message: '更新成功', view: $this->getViewPrefix() . '/save');
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
        $statusFieldAndDictCode = $this->getStatusFieldAndDictCode();
        $field = $statusFieldAndDictCode[0];
        $status = $this->validate()[$field];
        $model = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        $model->$field = $status;
        if (! $model->save()) {
            return $this->fail('切换状态失败');
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $model = new $resourceCollection($model);
        }

        Inertia::share('__page_change_status__', true);

        return $this->success($model, message: '切换状态成功');
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

        Inertia::share('__page_destroy__', true);

        $model = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail('数据不存在', 404, view: '404');
        }

        $result = $model->delete();
        if (! $result) {
            return $this->fail('删除失败');
        }

        return $this->success(message: '删除成功');
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
        foreach ($this->orderBy() as $key => $value) {
            $query = $query->orderBy($key, $value);
        }
        switch ($listType) {
            case 'tree':
                $data = ($this->getTreeCollection())::new($query->get())->toTree();
                break;
            case 'all':
                $data = $query->get();
                break;
            default:
                $data = $query->paginate(\min($this->getMaxPerPage(), \request('__per_page__', 10)), pageName: '__page__');
                break;
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = $resourceCollection::collection($data);
        }

        Inertia::share('__page_recycle__', true);

        return $this->success($data, view: $this->getViewPrefix() . '/index');
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

        Inertia::share('__page_recovery__', true);

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

        Inertia::share('__page_real_destroy__', true);

        return $this->success($this->getModel()->withTrashed()->whereIn('id', $ids)->forceDelete());
    }
}
