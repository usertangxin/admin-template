<?php

namespace Modules\Admin\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ModuleEventSubscriber
{
    public function onEnabled($event, $module)
    {
        //
        dump($module);
    }

    public function onDisabling($event,$module)
    {
        //
        dump($module);
    }

    public function onDeleting($event,$module)
    {
        //
        dump($module);
        throw new \Exception('删除模块失败');
    }
}
