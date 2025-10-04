<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;
use InvalidArgumentException;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Classes\Utils\FormToken;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Interfaces\TreeCollectionInterface;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Services\ResponseService;
use Modules\Admin\Services\SystemDictService;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

use function request;

abstract class AbstractCrudController extends AbstractController
{
    /**
     * @return Model|AbstractSoftDelModel
     */
    abstract protected function getModel();

    /**
     * 显示字段
     */
    protected function getMakeVisibleFields(): array
    {
        return [];
    }

    /**
     * 隐藏字段
     */
    protected function getMakeHiddenFields(): array
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
        return ResponseService::getViewPrefix($this);
    }

    /**
     * 状态字段和字典编码 [字段,字典编码]
     */
    protected function getStatusFieldAndDictCode(): array
    {
        return ['status', 'data_status'];
    }

    /**
     * 排序
     *
     * @return mixed
     */
    protected function orderBy(): array
    {
        return request('__order_by__', [$this->getModel()->getKeyName() => 'desc']);
    }

    /**
     * 资源
     *
     * @return class-string<JsonResource>|null
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

        if (request()->route()->getActionMethod() === 'changeStatus') {
            $systemDictService      = SystemDictService::getInstance();
            $statusFieldAndDictCode = $this->getStatusFieldAndDictCode();
            $field                  = $statusFieldAndDictCode[0];
            $dictCode               = $statusFieldAndDictCode[1];

            return request()->validate([
                'id'   => 'required',
                $field => [
                    'required',
                    'in:' . \implode(',', $systemDictService->getValuesByCode($dictCode)->toArray()),
                ],
            ]);
        }

        // 相较于当前控制器的请求类
        $request_namespace = str_replace('Controllers', 'Requests', static::class);
        $request_namespace = str_replace(\class_basename(static::class), '', $request_namespace);
        $request_classname = $request_namespace . \class_basename($this->getModel()) . 'Request';
        /** @var FormRequest $request */
        $request = \app()->make($request_classname);

        return $request->validated();
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

            if ($value === '' || $value === null) {
                continue;
            }

            if (is_array($value)) {
                $ex_v = false;
                foreach ($value as $k => $v) {
                    if (! empty($v)) {
                        $ex_v = true;
                        break;
                    }
                }
                if (! $ex_v) {
                    continue;
                }
            }

            $where[$key] = $value;
        }

        return $where;
    }

    /**
     * 列表
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('列表')]
    public function index()
    {
        $listType = request('__list_type__', 'list');
        $where    = $this->searchWhere();
        $model    = $this->getModel();
        /** @var AbstractModel|AbstractSoftDelModel $query */
        $query = ModelUtil::bindSearch($model->newInstance(), $where);
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        foreach ($this->orderBy() as $key => $value) {
            $query = $query->orderBy($key, $value);
        }
        $data = match ($listType) {
            'tree', 'all' => $query->get(),
            default => $query->paginate(\min($this->getMaxPerPage(), request('__per_page__', 10)), pageName: '__page__'),
        };

        if (! empty($visible = $this->getMakeVisibleFields())) {
            $data->each(function ($item) use ($visible) {
                $item->makeVisible($visible);
            });
        }
        if (! empty($hidden = $this->getMakeHiddenFields())) {
            $data->each(function ($item) use ($hidden) {
                $item->makeHidden($hidden);
            });
        }

        if ($listType === 'tree') {
            $data = ($this->getTreeCollection())::new($data)->toTree();
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
     * @return Responsable|SymfonyResponse
     */
    #[SystemMenu('详情')]
    public function read()
    {

        Inertia::share('__page_read__', true);

        $id    = request('id');
        $model = $this->getModel();
        if (in_array(SoftDeletes::class, \class_uses_recursive($model))) {
            $query = $this->getModel()->withTrashed();
        } else {
            $query = $this->getModel()->query();
        }
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        $data = $query->find($id);
        if (! $data) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        if (! empty($visible = $this->getMakeVisibleFields())) {
            $data = $data->makeVisible($visible);
        }
        if (! empty($hidden = $this->getMakeHiddenFields())) {
            $data = $data->makeHidden($hidden);
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $data = new $resourceCollection($data);
        }

        return $this->success($data, view: $this->getViewPrefix() . '/save');
    }

    /**
     * 创建
     */
    #[SystemMenu('创建')]
    public function create(FormToken $formToken)
    {
        Inertia::share('__page_create__', true);

        if (request()->method() == 'GET') {
            return $this->success(view: $this->getViewPrefix() . '/save');
        }

        $formToken->checkToken();

        $data = $this->validate();
        DB::beginTransaction();
        try {
            $this->beforeCreate($data);
            $result = $this->getModel()->create($data);
            $this->afterCreate($result);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result, message: '创建成功', view: $this->getViewPrefix() . '/save');
    }

    /**
     * 创建前
     */
    protected function beforeCreate(array &$data): void {}

    /**
     * 创建后
     */
    protected function afterCreate($model): void {}

    /**
     * 编辑
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException
     * @throws InvalidArgumentException|Throwable
     */
    #[SystemMenu('编辑')]
    public function update(FormToken $formToken)
    {
        Inertia::share('__page_update__', true);

        $id = request('id');
        if (request()->method() == 'GET') {
            $data = $this->getModel()->find($id);
            if (! empty($resourceCollection = $this->getResource())) {
                $data = new $resourceCollection($data);
            }

            return $this->success($data, view: $this->getViewPrefix() . '/save');
        }

        $formToken->checkToken();

        $data  = $this->validate();
        $model = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $this->beforeUpdate($model, $data);
            $result = $model->update($data);
            $this->afterUpdate($model);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        if (! $result) {
            return $this->fail('更新失败', view: $this->getViewPrefix() . '/save');
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $model = new $resourceCollection($model);
        }

        return $this->success($model, message: '编辑成功', view: $this->getViewPrefix() . '/save');
    }

    /**
     * 更新前
     */
    protected function beforeUpdate($model, array &$data): void {}

    /**
     * 更新后
     */
    protected function afterUpdate($model): void {}

    /**
     * 切换状态
     *
     * @return Responsable|SymfonyResponse
     */
    #[SystemMenu('切换状态')]
    public function changeStatus()
    {

        Inertia::share('__page_change_status__', true);

        $id                     = request('id');
        $statusFieldAndDictCode = $this->getStatusFieldAndDictCode();
        $field                  = $statusFieldAndDictCode[0];
        $status                 = $this->validate()[$field];
        $model                  = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        $model->$field = $status;
        if (! $model->save()) {
            return $this->fail('切换状态失败');
        }

        return $this->success([], message: '切换状态成功');
    }

    /**
     * 删除
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws Throwable
     */
    #[SystemMenu('删除')]
    public function destroy()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_destroy__', true);

        $result = $this->getModel()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $result->each(function ($item) {
                $item->delete();
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        return $this->success(message: '删除成功');
    }

    /**
     * 回收站
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('回收站')]
    public function recycle()
    {
        $listType = request('__list_type__', 'list');
        $where    = $this->searchWhere();
        $query    = ModelUtil::bindSearch($this->getModel()->onlyTrashed(), $where);
        if (! empty($with = $this->with())) {
            $query = $query->with($with);
        }
        foreach ($this->orderBy() as $key => $value) {
            $query = $query->orderBy($key, $value);
        }
        $data = match ($listType) {
            'tree', 'all' => $query->get(),
            default => $query->paginate(\min($this->getMaxPerPage(), request('__per_page__', 10)), pageName: '__page__'),
        };

        if (! empty($visible = $this->getMakeVisibleFields())) {
            $data->each(function ($item) use ($visible) {
                $item->makeVisible($visible);
            });
        }
        if (! empty($hidden = $this->getMakeHiddenFields())) {
            $data->each(function ($item) use ($hidden) {
                $item->makeHidden($hidden);
            });
        }

        if ($listType === 'tree') {
            $data = ($this->getTreeCollection())::new($data)->toTree();
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
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException|Throwable
     */
    #[SystemMenu('恢复')]
    public function recovery()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_recovery__', true);

        $result = $this->getModel()->onlyTrashed()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $result->each(function ($item) {
                $item->restore();
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            throw $e;
        }

        return $this->success([], message: '恢复成功');
    }

    /**
     * 永久删除
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException|Throwable
     */
    #[SystemMenu('永久删除')]
    public function realDestroy()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_real_destroy__', true);

        $result = $this->getModel()->withTrashed()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail('数据不存在', 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $result->each(function ($item) {
                $item->forceDelete();
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->fail('永久删除失败：' . $e->getMessage());
        }

        return $this->success(message: '永久删除成功');
    }
}
