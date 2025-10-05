<?php

namespace Modules\Admin\Tests\Unit;

use Modules\Admin\Services\ResponseService;
use Tests\TestCase;

class ResponseServiceTest extends TestCase
{
    public function test_get_view_prefix(): void
    {
        $class  = 'Modules\\CrudGenerate\\Http\\Controllers\\TestAbc\\TestController';
        $result = ResponseService::getViewPrefix($class);
        $this->assertEquals('module.CrudGenerate.test_abc.test', $result);

        $class  = 'Modules\\CrudGenerate\\Http\\Controllers\\TestAbc';
        $result = ResponseService::getViewPrefix($class);
        $this->assertEquals('module.CrudGenerate.test_abc', $result);

        $class  = 'App\\Http\\Controllers\\Auth\\LoginController';
        $result = ResponseService::getViewPrefix($class);
        $this->assertEquals('app.auth.login', $result);
    }
}
