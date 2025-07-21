<?php

namespace Modules\Admin\Tests\Feature;

use Faker\Generator;
use Illuminate\Container\Container;
use Modules\Admin\Database\Factories\CrudTestFactory;

class CrudTest extends AbstractAuthTestCase
{
    public function test_index(): void
    {
        $faker = Container::getInstance()->make(Generator::class);
        CrudTestFactory::new()->count(15)->create();
        $auth = $this->auth();
        // 测试第二页
        $response = $auth->getJson('/web/admin/CrudTest/index?__page__=2&__per_page__=10');
        $response->assertJsonCount(5, 'data');
        // 测试每页条数
        $response = $auth->getJson('/web/admin/CrudTest/index?__page__=1&&__per_page__=12');
        $response->assertJsonCount(12, 'data');
        $response->assertJson([
            'meta' => [
                'current_page' => 1,
            ],
            'links' => [],
        ]);
        // 测试每页条数
        $response = $auth->getJson('/web/admin/CrudTest/index?__page__=2&__per_page__=12');
        $response->assertJsonCount(3, 'data');
        // 测试显示有所
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=all');
        $response->assertJsonCount(15, 'data');
        // 测试排序
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=all&__order_by__[id]=asc');
        $response->assertJsonPath('data.0.id', 1);
        // 测试倒序
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=all&__order_by__[id]=desc');
        $response->assertJsonPath('data.0.id', 15);

        CrudTestFactory::new()->count(20)->create(['name' => $faker->name() . 'asdf' . $faker->name()]);
        // 测试搜索范围
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=all&fast_search=asdf');
        $response->assertJsonCount(20, 'data');
        // 测试不存在的字段搜索
        $response = $auth->getJson('/web/admin/CrudTest/index?__page__=1&__per_page__=10&aaaaaa=asdf');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'data');

        CrudTestFactory::new()->count(3)->create(['name' => 'asdf']);
        CrudTestFactory::new()->count(3)->create(['name' => 'asdf1']);
        // 测试存在字段但不存在搜索范围的搜索
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=all&name=asdf');
        $response->assertJsonCount(3, 'data');

        CrudTestFactory::new()->count(2)->create(['name' => 'children ' . $faker->name(), 'parent_id' => 1]);
        // 测试树状结构
        $response = $auth->getJson('/web/admin/CrudTest/index?__list_type__=tree&__order_by__[id]=asc');
        $response->assertJsonCount(2, 'data.0.children');
    }

    public function test_create(): void
    {
        //
        $auth = $this->auth();
        $response = $auth->postJson('/web/admin/CrudTest/create', [
            'name' => 'asdf',
        ]);
        $response->assertStatus(200);
        $response = $auth->postJson('/web/admin/CrudTest/create', [
            'name' => 'asdf',
        ]);
        $response->assertStatus(422);
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
