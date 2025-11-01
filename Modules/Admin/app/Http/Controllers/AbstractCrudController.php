<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use InvalidArgumentException;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Events\CrudAfterCreate;
use Modules\Admin\Events\CrudAfterSave;
use Modules\Admin\Events\CrudAfterUpdate;
use Modules\Admin\Events\CrudBeforeCreate;
use Modules\Admin\Events\CrudBeforeUpdate;
use Modules\Admin\Services\SystemDictService;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Throwable;

abstract class AbstractCrudController extends AbstractReadController
{
    /**
     * 请求验证
     *
     * @throws BindingResolutionException
     */
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
     * 创建
     */
    #[SystemMenu('创建', name_lang: 'admin::system_menu.abstract_crud_controller.create')]
    public function create()
    {
        Inertia::share('__page_create__', true);

        if (request()->method() == 'GET') {
            return $this->success(view: $this->getViewPrefix() . '/save');
        }

        $data = $this->validate();
        DB::beginTransaction();
        try {

            $this->beforeCreate($data);
            CrudBeforeCreate::dispatch($data, $this);

            $result = $this->getModel()->create($data);

            $this->afterCreate($result);
            CrudAfterCreate::dispatch($result, $data, $this);

            $this->afterSave($result);
            CrudAfterSave::dispatch($result, $data, $this);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if (! empty($resourceCollection = $this->getResource())) {
            $result = new $resourceCollection($result);
        }

        return $this->success($result, message: __('admin::abstract_crud.create_success'), view: $this->getViewPrefix() . '/save');
    }

    /**
     * 创建前
     */
    protected function beforeCreate(array &$data): void {}

    /**
     * 保存后
     */
    protected function afterSave($model): void {}

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
    #[SystemMenu('编辑', name_lang: 'admin::system_menu.abstract_crud_controller.update')]
    public function update()
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

        $data  = $this->validate();
        $model = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $this->beforeUpdate($model, $data);
            CrudBeforeUpdate::dispatch($model, $data, $this);

            $result = $model->update($data);

            $this->afterUpdate($model);
            CrudAfterUpdate::dispatch($model, $data, $this);

            $this->afterSave($model);
            CrudAfterSave::dispatch($model, $data, $this);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        if (! $result) {
            return $this->fail(__('admin::abstract_crud.update_failed'), view: $this->getViewPrefix() . '/save');
        }
        if (! empty($resourceCollection = $this->getResource())) {
            $model = new $resourceCollection($model);
        }

        return $this->success($model, message: __('admin::abstract_crud.update_success'), view: $this->getViewPrefix() . '/save');
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
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('切换状态', name_lang: 'admin::system_menu.abstract_crud_controller.change_status')]
    public function changeStatus()
    {

        Inertia::share('__page_change_status__', true);

        $id                     = request('id');
        $statusFieldAndDictCode = $this->getStatusFieldAndDictCode();
        $field                  = $statusFieldAndDictCode[0];
        $status                 = $this->validate()[$field];
        $model                  = $this->getModel()->find($id);
        if (! $model) {
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
        }
        $model->$field = $status;
        if (! $model->save()) {
            return $this->fail(__('admin::abstract_crud.change_status_failed'));
        }

        return $this->success([], message: __('admin::abstract_crud.change_status_success'));
    }

    /**
     * 删除
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws Throwable
     */
    #[SystemMenu('删除', name_lang: 'admin::system_menu.abstract_crud_controller.destroy')]
    public function destroy()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_destroy__', true);

        $result = $this->getModel()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
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

        return $this->success(message: __('admin::abstract_crud.destroy_success'));
    }

    /**
     * 回收站
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException
     */
    #[SystemMenu('回收站', name_lang: 'admin::system_menu.abstract_crud_controller.recycle')]
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
    #[SystemMenu('恢复', name_lang: 'admin::system_menu.abstract_crud_controller.recovery')]
    public function recovery()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_recovery__', true);

        $result = $this->getModel()->onlyTrashed()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
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

        return $this->success([], message: __('admin::abstract_crud.recovery_success'));
    }

    /**
     * 永久删除
     *
     * @return Responsable|SymfonyResponse
     *
     * @throws BindingResolutionException|Throwable
     */
    #[SystemMenu('永久删除', name_lang: 'admin::system_menu.abstract_crud_controller.real_destroy')]
    public function realDestroy()
    {
        $ids = request('ids');
        if (! is_array($ids)) {
            $ids = explode(',', $ids);
        }

        Inertia::share('__page_real_destroy__', true);

        $result = $this->getModel()->withTrashed()->whereIn($this->getModel()->getKeyName(), $ids)->get();
        if (! $result || count($result) == 0) {
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
        }
        DB::beginTransaction();
        try {
            $result->each(function ($item) {
                $item->forceDelete();
            });
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return $this->fail(__('admin::abstract_crud.real_destroy_failed') . '：' . $e->getMessage());
        }

        return $this->success(message: __('admin::abstract_crud.destroy_success'));
    }
}
