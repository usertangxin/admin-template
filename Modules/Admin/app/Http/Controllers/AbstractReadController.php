<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Modules\Admin\Classes\DataBase\TreeCollection;
use Modules\Admin\Classes\Utils\ModelUtil;
use Modules\Admin\Interfaces\TreeCollectionInterface;
use Modules\Admin\Models\AbstractModel;
use Modules\Admin\Models\AbstractSoftDelModel;
use Modules\Admin\Services\ResponseService;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

abstract class AbstractReadController extends AbstractController
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
    #[SystemMenu('详情', name_lang: 'admin::system_menu.abstract_crud_controller.read')]
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
            return $this->fail(__('admin::abstract_crud.data_not_found'), 404, view: '404');
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
}
