<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Modules\Admin\Classes\Attrs\SystemMenu;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as ModulesModule;

class ModuleManagerController extends AbstractController
{
    #[SystemMenu('模块管理', icon: 'fas fa-kaaba')]
    public function index()
    {
        $modules = Module::all();
        $data    = (new Collection($modules))->map(function ($module) {
            /** @var ModulesModule $module */
            return [
                'name'        => $module->getName(),
                'description' => $module->getDescription(),
                'status'      => $module->isEnabled(),
            ];
        })->toArray();
        $data = array_values($data);

        return $this->success(data: $data);
    }

    #[SystemMenu('模块启用/禁用')]
    public function changeStatus(Request $request)
    {
        $module = Module::find($request->input('name'));
        $status = $request->input('status');
        if ($module) {
            if ($status) {
                $module->enable();
            } else {
                $module->disable();
            }
        }

        return $this->success(message: __('admin::module_manager.change_status_success'));
    }

    #[SystemMenu('模块删除')]
    public function destroy(Request $request)
    {
        $module = Module::find($request->input('name'));
        $module?->delete();

        return $this->success(message: __('admin::module_manager.destroy_success'));
    }
}
