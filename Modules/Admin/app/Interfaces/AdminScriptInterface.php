<?php

namespace Modules\Admin\Interfaces;

use Nwidart\Modules\Module;

interface AdminScriptInterface
{
    public function enable(Module $module);

    public function disable(Module $module);

    public function delete(Module $module);
}
