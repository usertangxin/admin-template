<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Modules\Admin\Classes\Utils\FormToken;
use Modules\Admin\Models\SystemAdmin;
use Nwidart\Modules\Facades\Module;
use Tests\TestCase;

class AbstractAuthTestCase extends TestCase
{
    use RefreshDatabase;

    protected $autoAuth = true;

    protected function setUp(): void
    {
        parent::setUp();

        $mockFormToken = Mockery::mock(FormToken::class);
        $mockFormToken->shouldReceive('checkToken')->andReturn();
        $this->app->instance(FormToken::class, $mockFormToken);

        $all_enable_modules = Module::allEnabled();
        foreach ($all_enable_modules as $module) {
            $module->enable();
        }

        if ($this->autoAuth) {
            $this->auth();
        }
    }

    protected function auth($admin = null, $guard = 'admin')
    {
        $admin = $admin ?? SystemAdmin::where('is_root', true)->first();
        $admin->refresh();

        return $this->actingAs($admin, $guard);
    }
}
