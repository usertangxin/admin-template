<?php

namespace Modules\Admin\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Admin\Database\Factories\CrudTestFactory;
use Tests\TestCase;

class CrudTest extends AbstractAuthTestCase
{
    public function test_index(): void
    {
        CrudTestFactory::new()->count(15)->create();
        $auth = $this->auth();
        $response = $auth->getJson('/web/admin/CrudTest/index');
        $response->assertJsonCount(10, 'data');
        $response = $auth->getJson('/web/admin/CrudTest/index?__page__=2');
        $response->assertJsonCount(5, 'data');
    }

    public function test_create(): void
    {
        //
    }

    public function test_update(): void
    {
        //
    }

    public function test_delete(): void
    {
        //
    }
}
