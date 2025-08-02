<?php

namespace Modules\Admin\Listeners;

use Illuminate\Support\Facades\Artisan;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Module;
use Nwidart\Modules\Traits\PathNamespace;

class ModuleEventSubscriber
{
    use PathNamespace;

    /**
     * @param  mixed    $event
     * @param  Module[] $modules
     * @return void
     */
    public function onEnabled($event, $modules)
    {
        //
        foreach ($modules as $module) {
            Artisan::call('module:migrate', ['module' => $module->getName()], new \Symfony\Component\Console\Output\ConsoleOutput);
            $admin_script_class = $this->getAdminScriptClass($module->getName());
            if ($admin_script_class) {
                app()->when($admin_script_class)->needs(Module::class)->give(fn () => $module);
                app()->call($admin_script_class . '@enable', ['module' => $module]);
                echo Artisan::output();
            }
        }
    }

    /**
     * @param  mixed    $event
     * @param  Module[] $modules
     * @return void
     */
    public function onDisabling($event, $modules)
    {
        //
        foreach ($modules as $module) {
            $admin_script_class = $this->getAdminScriptClass($module->getName());
            if ($admin_script_class) {
                app()->when($admin_script_class)->needs(Module::class)->give(fn () => $module);
                app()->call($admin_script_class . '@disable', ['module' => $module]);
                echo Artisan::output();
            }
        }
    }

    /**
     * @param  mixed    $event
     * @param  Module[] $modules
     * @return void
     */
    public function onDeleting($event, $modules)
    {
        //
        foreach ($modules as $module) {
            $admin_script_class = $this->getAdminScriptClass($module->getName());
            if ($admin_script_class) {
                app()->when($admin_script_class)->needs(Module::class)->give(fn () => $module);
                app()->call($admin_script_class . '@delete', ['module' => $module]);
                echo Artisan::output();
            }
        }
        throw new \Exception('删除模块失败');
    }

    protected function getAdminScriptClass($module_name)
    {
        $namespace     = $this->module_namespace($module_name);
        $install_class = $namespace . '\\Classes\\AdminScript';
        if (! class_exists($install_class)) {
            return null;
        }
        if (! in_array(AdminScriptInterface::class, class_implements($install_class))) {
            return null;
        }

        return $install_class;
    }
}
