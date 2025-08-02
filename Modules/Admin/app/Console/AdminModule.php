<?php

namespace Modules\Admin\Console;

use Artisan;
use Illuminate\Console\Command;
use Modules\Admin\Interfaces\AdminScriptInterface;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Traits\PathNamespace;

use function Laravel\Prompts\multiselect;

class AdminModule extends Command
{
    use PathNamespace;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'admin:module {action : 执行脚本方法名称} {module?* : 模块名称}';

    /**
     * The console command description.
     */
    protected $description = '执行模块脚本';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        Module::macro('getRequire', function ($module_name) {
            $module = Module::findOrFail($module_name);

            return $module->get('require', []);
        });
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modules       = $this->argument('module');
        $action        = $this->argument('action');
        $local_modules = Module::all();
        $all_modules   = [];
        if ($action == 'install') {
            $all_modules['all'] = '所有';
        }
        foreach ($local_modules as $key => $module) {
            $all_modules[$module->getName()] = $module->getName() . ($module->getDescription() ? ' - ' . $module->getDescription() : '');
        }
        if (empty($modules)) {
            $m       = ['install' => '安装', 'uninstall' => '卸载'];
            $modules = multiselect('请选择要执行 ' . ($m[$action] ?? $action) . ' 的模块', options: $all_modules);
        }
        if (in_array('all', $modules)) {
            $modules = array_keys($all_modules);
        }

        $error_message = [];
        $warn_message  = [];

        foreach ($modules as $module_name) {
            if ($module_name == 'all') {
                continue;
            }

            /** @var \Nwidart\Modules\Laravel\Module $model */
            $model = Module::find($module_name);

            if (empty($model)) {
                $error_message[] = $module_name . '模块不存在';

                continue;
            }

            $namespace     = $this->module_namespace($module_name);
            $install_class = $namespace . '\\Classes\\AdminScript';

            if (! class_exists($install_class)) {
                $warn_message[] = $module_name . '模块未存在AdminScript类,已跳过';

                continue;
            }

            if (! in_array(AdminScriptInterface::class, class_implements($install_class))) {
                $warn_message[] = $module_name . '模块AdminScript未实现 Modules\\Admin\\Classes\\Interfaces\\AdminScriptInterface 接口,已跳过';

                continue;
            }

            if (! method_exists($install_class, $action)) {
                $warn_message[] = $module_name . '模块未存在' . $action . '方法,已跳过';

                continue;
            }

            $model->register();
            $model->boot();
            if ($action == 'install') {
                Module::enable($module_name);
                Artisan::call('module:migrate', ['module' => $module_name], new \Symfony\Component\Console\Output\ConsoleOutput);
                app()->call($install_class . '@' . $action, ['command' => $this]);
                echo Artisan::output();
                $this->info($module_name . '模块安装成功');
            } elseif ($action == 'uninstall') {
                Module::disable($module_name);
                app()->call($install_class . '@' . $action);
                $this->info($module_name . '模块卸载成功');
            } else {
                app()->call($install_class . '@' . $action);
                $this->info($module_name . '模块' . $action . '成功');
            }
        }

        foreach ($warn_message as $message) {
            $this->warn($message);
        }

        foreach ($error_message as $message) {
            $this->error($message);
        }
    }
}
