<?php

namespace Modules\Admin\Interfaces;

interface AdminScriptInterface
{
    public function enable();

    public function disable();

    public function delete();
}
